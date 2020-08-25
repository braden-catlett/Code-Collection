import java.io.*;
import java.net.*;
import java.util.*;
import javax.swing.*;
import java.awt.*;
import java.awt.event.*;
//////
/// Developed by Brad Catlett-Rossen
/// Date: 1/18/2011
///	Some Source code was taken from Head First Java Kathy Sierra & Bert Bates
///	Application name : Underground Railroad (Client Side)
//////
public class Chat {
	//Strings and User
	private String name;
	private String pass;
	private user me;
	private ArrayList<String> active;
	//GUI
	private JFrame frame;
	private JFrame loginscreen;
	private JFrame ipframe;
	private JPanel side;
	private JPanel main;
	private JPanel ippanel;
	private MyDrawPanel log;
	private JButton send;
	private JButton login;
	private JButton create;
	private JButton updateB;
	private JButton ipbutton;
	private JTextArea incoming;
	private JTextField outgoing;
	private JTextArea users;
	private JTextField username;
	private JTextField ipfield;
	private JPasswordField password;
	private JLabel error;
	private JLabel iplabel;

	//Networking
	private ObjectOutputStream out;
	private ObjectInputStream in;
	private Socket sock;
	private String ip;
	//Incoming thread
	private Thread readerThread;
		
	public static void main(String[] args) {
		Chat chat = new Chat();
		chat.go();
	}

	public void go() {	
	//Array Lists
		active = new ArrayList<String>();
		me = new user("Guest","",true);
		ip = new String("174.129.36.248");
	//Frame and Panels
		frame = new JFrame("Underground Railroad");
		loginscreen = new JFrame("Log in Please");
		ipframe = new JFrame("Enter in new I.P. Address");
		main = new JPanel();
		side = new JPanel();
		ippanel = new JPanel();
		log = new MyDrawPanel();
		side.setBackground(Color.yellow);
		main.setBackground(Color.green);
		ippanel.setBackground(Color.gray);
	//Buttons
		send = new JButton("Send");
		login = new JButton("Login");
		create = new JButton("Create Profile");
		updateB = new JButton("Update Users");
		ipbutton = new JButton("Change");
	//Button Mnemonics
		send.setMnemonic(KeyEvent.VK_ENTER);
		login.setMnemonic(KeyEvent.VK_ENTER);
	//Text Areas
		incoming = new JTextArea(15, 30);
		outgoing = new JTextField(14);
		users = new JTextArea(10, 15);
		username = new JTextField(14);
		password = new JPasswordField(14);
		ipfield = new JTextField(15);
		outgoing.addKeyListener(new MyKeyListener());
		incoming.setText("Conversations: \n");
		incoming.setEditable(false);
		incoming.setLineWrap(true);
		users.setText("Online Users: \n");
		users.setEditable(false);
		users.setLineWrap(true);
	//Labels
		JLabel user = new JLabel("Username: ");
		JLabel pass = new JLabel("Password: ");
		error = new JLabel("Login to Start");
		iplabel = new JLabel("I.P. Address");
		user.setForeground(Color.white);
		pass.setForeground(Color.white);
		error.setForeground(Color.white);
		user.setLabelFor(username);
		pass.setLabelFor(password);
		iplabel.setLabelFor(ipfield);
	//Menu
		JMenuBar menu = new JMenuBar();
		JMenu submenu = new JMenu("Options");
		JMenuItem logout = new JMenuItem("Logout",KeyEvent.VK_ESCAPE);
		JMenuItem cleanse = new JMenuItem("Cleanse Server", KeyEvent.VK_DELETE);
		logout.getAccessibleContext().setAccessibleDescription("Click to logout");
		cleanse.getAccessibleContext().setAccessibleDescription("Clears the arrays on the server");
		menu.add(submenu);
		submenu.add(logout);
		submenu.add(cleanse);
		menu.setVisible(true);
		
		JMenuBar ipmenu = new JMenuBar();
		JMenu ipsubmenu = new JMenu("Options");
		JMenuItem changeip = new JMenuItem("Change I.P.",KeyEvent.VK_ESCAPE);
		changeip.getAccessibleContext().setAccessibleDescription("Click to change the I.P. Address");
		ipmenu.add(ipsubmenu);
		ipsubmenu.add(changeip);
		ipmenu.setVisible(true);
		
	//Scrollers
		JScrollPane mScroller = new JScrollPane(incoming);
		mScroller.setVerticalScrollBarPolicy(ScrollPaneConstants.VERTICAL_SCROLLBAR_ALWAYS);
		JScrollPane sScroller = new JScrollPane(users);
		sScroller.setVerticalScrollBarPolicy(ScrollPaneConstants.VERTICAL_SCROLLBAR_ALWAYS);
		
	//Registering Listeners
		send.addActionListener(new SendButtonListener());
		login.addActionListener(new LoginButtonListener());
		create.addActionListener(new CreateButtonListener());
		updateB.addActionListener(new UpdateButtonListener());
		logout.addMouseListener(new LogoutListener());
		cleanse.addMouseListener(new CleanseListener());
		changeip.addMouseListener(new ChangeIPListener());
		ipbutton.addActionListener(new IpButtonListener());
		
	//Adding to the panels or frame
		main.add(mScroller);
		main.add(outgoing);
		main.add(send);
		main.setPreferredSize(new Dimension(200,100));
		
		log.add(user);
		log.add(username);
		log.add(pass);
		log.add(password);
		log.add(login);		
		log.add(create);
		log.add(new JLabel("                                           "));
		log.add(error);		
		log.setPreferredSize(new Dimension(200,200));
		
		side.add(sScroller);
		side.add(updateB);
		side.setPreferredSize(new Dimension(200,100));
		
		ippanel.add(iplabel);
		ippanel.add(ipfield);
		ippanel.add(ipbutton);
		ippanel.setPreferredSize(new Dimension(100,200));
		
		//Networking function calls	
		setUpNetworking();
		readerThread = new Thread(new IncomingReader());
		readerThread.start();
		
		ipframe.getContentPane().add(ippanel);
		
		loginscreen.getContentPane().add(BorderLayout.NORTH, ipmenu);
		loginscreen.getContentPane().add(BorderLayout.CENTER,log);
		loginscreen.setMaximizedBounds(new Rectangle( new Point(600,300), new Dimension(200,250)));
		loginscreen.setMinimumSize(new Dimension(200,250));
		
		frame.getContentPane().add(BorderLayout.WEST, side);
		frame.getContentPane().add(BorderLayout.CENTER, main);
		frame.getContentPane().add(BorderLayout.NORTH, menu);
		frame.setMaximizedBounds(new Rectangle( new Point(400,200), new Dimension(650,370)));
		frame.setMinimumSize(new Dimension(650,370));

	//Setting frame variables		
		frame.setBounds(400,200,650,370);	
		frame.setVisible(false);
		loginscreen.setBounds(600,300,200,270);
		loginscreen.setVisible(true);
		ipframe.setBounds(600,300,100,200);
		ipframe.setVisible(false);
		
		ipframe.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);				
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		loginscreen.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
	}
	
	private void update() {
		users.setText("Online Users: \n");
		for(String u : active) {
					//add a check to change the color of the text if the name is the same as "me"'s
				users.append(u + "\n");
				System.out.println("appending " + u);
		}
	}
	private void setUpNetworking() {
		try{
			sock = new Socket(ip, 4209);
			out = new ObjectOutputStream(sock.getOutputStream());
			in = new ObjectInputStream(sock.getInputStream());
			System.out.println("networking established");
		} catch(IOException ex) { ex.printStackTrace(); }
	}
	
	private void sendMessage() {
		try {
			if(outgoing.getText() != "" || outgoing.getText() != " ") {
				out.writeObject("["+me.getUsername()+"]: "+outgoing.getText());
			}
		 } catch(Exception ex) { ex.printStackTrace(); }
		outgoing.setText("");
		outgoing.requestFocus();
	}
	
	class MyKeyListener implements KeyListener {
		public void keyPressed(KeyEvent e) {
			if((Integer) e.getKeyCode() == KeyEvent.VK_ENTER) {
				sendMessage();
			}
		}
		public void keyReleased(KeyEvent e) {
		}
		public void keyTyped(KeyEvent e) {
		}
	}
	
	public class SendButtonListener implements ActionListener {
		public void actionPerformed (ActionEvent ev) {
			sendMessage();
		}
	}

	public class LoginButtonListener implements ActionListener {
		public void actionPerformed (ActionEvent ev) {
			try {
					if(username.getText() == "" || password.getText() == "") {
						error.setText("Invalid Username/Password");
					}
					else {
						me.setUsername(username.getText());
						me.setPassword(password.getText());
						me.setCreate(false);
						me.setDestroy(false);
						username.setText("");
						password.setText("");
						out.writeObject(me);
					}
				} catch(Exception ex) {	ex.printStackTrace(); }
			}
		}
	
	public class CreateButtonListener implements ActionListener {
		public void actionPerformed (ActionEvent ev) {
			try {
					if( username.getText().equals("") || password.getText().equals("") ){
						error.setText("Invalid Username/Password");
					}
					else {
						me.setUsername(username.getText());
						me.setPassword(password.getText());
						me.setCreate(true);
						me.setDestroy(false);
						password.setText("");
						out.writeObject(me);
						error.setText("Profile Successfully Created");
					}
			} catch (Exception ex) { ex.printStackTrace(); }
		}
	}
	
	public class UpdateButtonListener implements ActionListener {
		public void actionPerformed(ActionEvent ex) {
			update();
		}
	}

	public class LogoutListener extends MouseAdapter {
		public void mouseReleased(MouseEvent e) {
			try {				
				me.setDestroy(true);
				me.setCreate(false);
				out.writeObject(me);
				out.writeObject(me.getUsername() + " has logged out");
				users.setText("Online Users: " + "\n");
				incoming.setText("Conversations: " + "\n");
				me.setUsername("");
				me.setPassword("");	
				me.setDestroy(false);
			} catch(Exception ex) { ex.printStackTrace(); }
			frame.setVisible(false);
			loginscreen.setVisible(true);
		}
	}
	
	public class CleanseListener extends MouseAdapter {
		public void mouseReleased(MouseEvent e) {
			try {
				out.writeObject("system reset");
			} catch(Exception ex) { ex.printStackTrace(); }
		}
	}
	
	public class ChangeIPListener extends MouseAdapter {
		public void mouseReleased(MouseEvent e) {
			try {
				ipframe.setVisible(true);
			} catch(Exception ex) { ex.printStackTrace(); }
		}
	}
	
	public class IpButtonListener implements ActionListener {
		public void actionPerformed(ActionEvent ex) {
			try {
				if(ipfield.getText() != "") {
					ip = ipfield.getText();
					setUpNetworking();
					ipframe.setVisible(false);
				}
			} catch(Exception e) { e.printStackTrace(); }
		}
	}
	
	public class IncomingReader implements Runnable {
		public void run() {
			Object message;
			try {				
				while((message = in.readObject()) != null) {
				
					if( me.getUsername() == "") {
						continue;
					}
					if( message instanceof String ) {
						incoming.append((String) message + "\n");
						System.out.println("read " + (String) message);
					}
					
					if( message instanceof Boolean ) {
						if( message.toString() == "true") {
							System.out.println("true");
							loginscreen.setVisible(false);
							frame.setVisible(true);
							error.setText("Log in Please");
						}
						else {
							System.out.println("false");
							error.setText("Invalid Username or Password");
						}
					}
					
					if( message instanceof user ) {
						user temp = (user) message;
						if( temp.getDestroy() == false ) {
							if( active.contains(temp.getUsername()) == false ) {
								active.add(temp.getUsername());
								System.out.println("adding " + temp.getUsername());
							}
						}	
						else {	
							active.remove(temp.getUsername());
							System.out.println("removing " + temp.getUsername());
						}					
					}
				}
			} catch(Exception ex) { ex.printStackTrace(); }
		}
	}

	public class MyDrawPanel extends JPanel {
		public void paintComponent(Graphics g) {
			Image image = new ImageIcon("rail.jpg").getImage();
			g.drawImage(image,0,0,200,225,this);	
		}
	}
	
}