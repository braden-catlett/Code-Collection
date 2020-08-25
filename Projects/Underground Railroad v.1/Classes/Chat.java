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
	private user temp;
	private ArrayList<user> active;
	private ArrayList<String> names;
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
		
	public static void main(String[] args) {
		Chat chat = new Chat();
		chat.go();
	}

	public void go() {	
	//Array Lists
		active = new ArrayList<user>();
		names = new ArrayList<String>();
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
		logout.getAccessibleContext().setAccessibleDescription("Click to logout");
		menu.add(submenu);
		submenu.add(logout);
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
		Thread readerThread = new Thread(new IncomingReader());
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
		loginscreen.setBounds(600,300,200,250);
		loginscreen.setVisible(true);
		ipframe.setBounds(600,300,100,200);
		ipframe.setVisible(false);
		
		ipframe.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);				
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		loginscreen.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
	}
	
	private void update() {
		users.setText("Online Users: \n");
		for(String u : names) {
			if(u != null) {
					//add a check to change the color of the text if the name is the same as "me"'s
				users.append(u + "\n");
				System.out.println("appending " + u);
			}
		}
	}
	private void setUpNetworking() {
		try{
			sock = new Socket(ip, 4200);
			out = new ObjectOutputStream(sock.getOutputStream());
			in = new ObjectInputStream(sock.getInputStream());
			System.out.println("networking established");
		} catch(IOException ex) { ex.printStackTrace(); }
	}
	
	public class SendButtonListener implements ActionListener {
		public void actionPerformed (ActionEvent ev) {
			try {		
					out.writeObject("["+me.getUsername()+"]: "+outgoing.getText());
			 } catch(Exception ex) { ex.printStackTrace(); }
			outgoing.setText("");
			outgoing.requestFocus();
		}
	}

	public class LoginButtonListener implements ActionListener {
		public void actionPerformed (ActionEvent ev) {
			try {
					me.setUsername(username.getText());
					me.setPassword(password.getText());
					me.setCreate(false);
					username.setText("");
					password.setText("");
					out.writeObject(me);
					active.add(me);
					names.add(me.getUsername());
				} catch(Exception ex) {	ex.printStackTrace(); }
			}
		}
	
	public class CreateButtonListener implements ActionListener {
		public void actionPerformed (ActionEvent ev) {
			try {
					me.setUsername(username.getText());
					me.setPassword(password.getText());
					password.setText("");
					out.writeObject(me);
					error.setText("Profile Successfully Created");
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
				frame.setVisible(false);
				loginscreen.setVisible(true);
				me.setDestroy(true);
				users.setText("");
				incoming.setText("");
				out.writeObject(me);
				out.writeObject(me.getUsername() + " has logged out");
				active.remove(me);
				names.remove(me.getUsername());
				me = null;
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
				ip = ipfield.getText();
				ipframe.setVisible(false);
			} catch(Exception e) { e.printStackTrace(); }
		}
	}
	
	public class IncomingReader implements Runnable {
		public void run() {
			Object message;
			try {				
				while((message = in.readObject()) != null) {
					
					if( message instanceof String ) {
						incoming.append((String) message + "\n");
						System.out.println("read " + (String) message);
					}

					if( message instanceof user ) {
						temp = (user) message;
						if(names.contains(temp.getUsername()) == false) {
							active.add(temp);
							names.add(temp.getUsername());
							System.out.println("Adding " + temp.getUsername());
						}
						else
							System.out.println("Already have " + temp.getUsername());
					}
					
					if( message instanceof Boolean ) {
						if( message.toString() == "true") {
							loginscreen.setVisible(false);
							frame.setVisible(true);
							error.setText("Log in Please");
							}
						else {
							error.setText("Invalid Username or Password");
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