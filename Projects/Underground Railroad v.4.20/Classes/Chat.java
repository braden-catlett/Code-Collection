import java.io.*;
import java.net.*;
import java.util.*;

import javax.sound.midi.*;
import javax.swing.*;
import java.awt.*;
import java.awt.event.*;
//////
/// Developed by Brad Catlett-Rossen
/// Date: 1/18/2011
///	Some Source code was taken from Head First Java Kathy Sierra & Bert Bates
///	Application name : Underground Railroad (Client Side)
//////
/**
 * The Client Side Class that reads in messages and user Objects from the server
 * @author Brad Catlett-Rossen
 */

public class Chat {
	//Strings and User
	private String name;
	private String pass;
	private user me;
	private ArrayList<String> active;
	//Sounds
	private int instrument;
	private int note;
	private Sequencer player;
	//GUI
	private JFrame frame;
	private JFrame loginscreen;
	private JFrame ipframe;
	private JFrame soundframe;
	
	private JPanel side;
	private JPanel main;
	private JPanel ippanel;
	private MyDrawPanel log;
	private JPanel soundpanel;
	
	private JButton send;
	private JButton login;
	private JButton create;
	private JButton updateB;
	private JButton ipbutton;
	private JButton play;
	private JButton soundset;
	
	private JTextArea incoming;
	private JTextField outgoing;
	private JTextArea users;
	private JTextField username;
	private JTextField ipfield;
	private JPasswordField password;
	private JTextField strum;
	private JTextField snote;
	
	//Labels
	private JLabel error;
	private JLabel iplabel;
	private JLabel strumlabel;
	private JLabel notelabel;
	private JLabel sounderror;

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

	/**
	 * This Method sets up the variables
	 * Creates the Incoming Runner Thread and Sets up the networking variables
	 * <ul>
	 * Variables Include:
	 * <li>Active users Array.
	 * <li> Local user variable.
	 * <li> I.P Address String.
	 * <li> G.U.I variables
	 * <li> Networking Streams and Socket
	 * <li> Thread variables
	 * <li> Midi variables (Sound)
	 * </ul>
	 */
	public void go() {	
	//Array Lists
		active = new ArrayList<String>();
		me = new user("Guest","",true);
		ip = new String("174.129.36.248");
	//Sound
		try {
			player = MidiSystem.getSequencer();
			player.open();
		}catch(Exception ex) { ex.printStackTrace(); }
	//Frame and Panels
		frame = new JFrame("Underground Railroad");
		loginscreen = new JFrame("Log in Please");
		ipframe = new JFrame("Enter in new I.P. Address");
		soundframe = new JFrame("Sound Options");
		main = new JPanel();
		side = new JPanel();
		ippanel = new JPanel();
		log = new MyDrawPanel();
		soundpanel = new JPanel();
		
		side.setBackground(Color.yellow);
		main.setBackground(Color.green);
		ippanel.setBackground(Color.gray);
		soundpanel.setBackground(Color.gray);
	//Buttons
		send = new JButton("Send");
		login = new JButton("Login");
		create = new JButton("Create Profile");
		updateB = new JButton("Update Users");
		ipbutton = new JButton("Change");
		play = new JButton("Play");
		soundset = new JButton("Set");
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
		strum = new JTextField(3);
		snote = new JTextField(3);
		
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
		strumlabel = new JLabel("Instrument: ");
		notelabel = new JLabel("Note: ");
		sounderror = new JLabel("Range: 0 - 127");
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
		JMenuItem cleanse = new JMenuItem("Change Message Alert", KeyEvent.VK_DELETE);
		logout.getAccessibleContext().setAccessibleDescription("Click to logout");
		cleanse.getAccessibleContext().setAccessibleDescription("Changes the sounds that plays when you receive a message");
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
		cleanse.addMouseListener(new SoundListener());
		changeip.addMouseListener(new ChangeIPListener());
		ipbutton.addActionListener(new IpButtonListener());
		play.addActionListener(new SoundPlayListener());
		soundset.addActionListener(new SoundSetListener());
		
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
		
		soundpanel.add(strumlabel);
		soundpanel.add(notelabel);
		soundpanel.add(strum);
		soundpanel.add(snote);
		soundpanel.add(play);
		soundpanel.add(soundset);
		soundpanel.add(sounderror);
		
		//Networking function calls	
		setUpNetworking();
		readerThread = new Thread(new IncomingReader());
		readerThread.start();
		
		soundframe.getContentPane().add(soundpanel);
		
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
		ipframe.setBounds(600,300,200,125);
		ipframe.setVisible(false);
		soundframe.setBounds(600,300,125,175);
		soundframe.setVisible(false);
		
		
		ipframe.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);				
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		loginscreen.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		
		frame.addWindowListener(new WindowListener());
	}	
	 /**
	 * This method is used the update the "Online Users" field
	 */
	private void update() {
		users.setText("Online Users: \n");
		for(String u : active) {
					//add a check to change the color of the text if the name is the same as "me"'s
				users.append(u + "\n");
				System.out.println("appending " + u);
		}
	}
	/**
	 * This method is used to set up the Input/Output Object streams and the socket in use
	 */
	private void setUpNetworking() {
		try{
			sock = new Socket(ip, 4201);
			out = new ObjectOutputStream(sock.getOutputStream());
			in = new ObjectInputStream(sock.getInputStream());
			System.out.println("networking established");
		} catch(IOException ex) { ex.printStackTrace(); }
	}
	/**
	 * This method is used to send a string to the server to be spread
	 */
	private void sendMessage() {
		try {
			if( outgoing.getText().trim().isEmpty() == false ) {
				out.writeObject("["+me.getUsername()+"]: "+outgoing.getText());
			}
		 } catch(Exception ex) { ex.printStackTrace(); }
		outgoing.setText("");
		outgoing.requestFocus();
	}
	/**
	 * This method is used when the user has entered in a username and password and has pressed the login button
	 */
	private void login() {
		try {
			if(username.getText().isEmpty() == true || password.getText().isEmpty() == true ) {
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
				update();
			}
		} catch(Exception ex) {	ex.printStackTrace(); }		
	}
	/**
	 * This method is used when the user has clicked on either the logout menu item or exits out of the program.
	 */
	private void logout() {
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
	/**
	 * This method is used to play a sound when a new incoming message is displayed.
	 */
	public void playBeat(int instrument, int note) {
		try {
			Sequence seq = new Sequence(Sequence.PPQ, 4);
			Track track = seq.createTrack();
			
			MidiEvent event = null;
			
			ShortMessage first = new ShortMessage();
			first.setMessage(192, 1, instrument, 0);
			MidiEvent changeInstrument = new MidiEvent(first, 1);
			track.add(changeInstrument);
			
			ShortMessage on = new ShortMessage();
			on.setMessage(144, 1, note, 100);
			MidiEvent noteOn = new MidiEvent(on,1);
			track.add(noteOn);
			
			ShortMessage off = new ShortMessage();
			off.setMessage(128, 1, note, 100);
			MidiEvent noteOff = new MidiEvent(off,16);
			track.add(noteOff);
			
			player.setSequence(seq);
			player.start();
			
		}catch(Exception ex) { ex.printStackTrace(); }
	}
	/**
	* A class to that is a listener for the event that occurs when the user pressed enter
	* @author Brad Catlett-Rossen
	*/
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
	/**
	* A class to that is a listener for the event that occurs when the user presses enter or presses the send button
	* @author Brad Catlett-Rossen
	*/
	public class SendButtonListener implements ActionListener {
		public void actionPerformed (ActionEvent ev) {
			sendMessage();
		}
	}
	/**
	* A class to that is a listener for the event that occurs when the user presses Login
	* @author Brad Catlett-Rossen
	*/
	public class LoginButtonListener implements ActionListener {
		public void actionPerformed (ActionEvent ev) {
			login();
		}
	}
	/**
	* A class to that is a listener for the event that occurs when the user pressed Create User
	* @author Brad Catlett-Rossen
	*/
	public class CreateButtonListener implements ActionListener {
		public void actionPerformed (ActionEvent ev) {
			try {
					if( username.getText().isEmpty() == true || password.getText().isEmpty() == true ){
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
	/**
	* A class to that is a listener for the event that occurs when the user pressed Update Users
	* @author Brad Catlett-Rossen
	*/
	public class UpdateButtonListener implements ActionListener {
		public void actionPerformed(ActionEvent ex) {
			update();
		}
	}
	/**
	* A class to that is a listener for the event that occurs when the user pressed Logout
	* @author Brad Catlett-Rossen
	*/
	public class LogoutListener extends MouseAdapter {
		public void mouseReleased(MouseEvent e) {
			logout();
		}
	}
	/**
	* A class to that is a listener for the event that occurs when the user selects Change Message Sound
	* @author Brad Catlett-Rossen
	*/
	public class SoundListener extends MouseAdapter {
		public void mouseReleased(MouseEvent e) {
			try {
				soundframe.setVisible(true);
			} catch(Exception ex) { ex.printStackTrace(); }
		}
	}
	/**
	* A class to that is a listener for the event that occurs when the user pressed play in the sounds frame
	* Plays the sounds that was input into the fields
	* @author Brad Catlett-Rossen
	*/
	public class SoundPlayListener implements ActionListener {
		public void actionPerformed(ActionEvent ex) {
			int x = Integer.parseInt(strum.getText());
			int y = Integer.parseInt(snote.getText());
			if(x > 127 || y > 127) {
				sounderror.setText("Invalid Input!");
			}
			else {
				playBeat(x,y);
				sounderror.setText("Range: 0 - 127");
			}
		}
	}
	/**
	* A class to that is a listener for the event that occurs when the user pressed set in the sounds frame
	* @author Brad Catlett-Rossen
	*/
	public class SoundSetListener implements ActionListener {
		public void actionPerformed(ActionEvent ex) {
			instrument = Integer.parseInt(strum.getText());
			note = Integer.parseInt(snote.getText());
			soundframe.setVisible(false);
		}
	}
	/**
	* A class to that is a listener for the event that occurs when the user selects change I.P Address in the loginscreen menu
	* @author Brad Catlett-Rossen
	*/
	public class ChangeIPListener extends MouseAdapter {
		public void mouseReleased(MouseEvent e) {
			try {
				ipframe.setVisible(true);
			} catch(Exception ex) { ex.printStackTrace(); }
		}
	}
	/**
	* A class to that is a listener for the event that occurs when the user pressed Ok to change the I.P Address
	* @author Brad Catlett-Rossen
	*/
	public class IpButtonListener implements ActionListener {
		public void actionPerformed(ActionEvent ex) {
			try {
				if(ipfield.getText().isEmpty() == false) {
					ip = ipfield.getText();
					sock.connect(new InetSocketAddress(ip, 4201));
					ipframe.setVisible(false);
				}
			} catch(Exception e) { e.printStackTrace(); }
		}
	}
	/**
	* A class to that is a listener for the event that occurs when the user exits out of the program without logging out first
	* @author Brad Catlett-Rossen
	*/
	class WindowListener extends WindowAdapter { 
		public void windowClosing(WindowEvent win) {
			try{
				logout();
				System.exit(0);
			}catch(Exception e) { e.printStackTrace(); }
		}			
	}
	/**
	* A class handles all the incoming messages received from the server
	* This Method is placed in its own thread
	* @author Brad Catlett-Rossen
	*/
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
						incoming.setCaretPosition(incoming.getDocument().getLength());
						playBeat(instrument,note);
						System.out.println("read " + (String) message);
					}
					
					if( message instanceof Boolean ) {
						if( ((Boolean) message).booleanValue() == true) {
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
	/**
	* A class overrides the paintComponent in JPanel 
	* Used for custom background
	* @author Brad Catlett-Rossen
	*/
	public class MyDrawPanel extends JPanel {
		public void paintComponent(Graphics g) {
			Image image = new ImageIcon("rail.jpg").getImage();
			g.drawImage(image,0,0,200,225,this);	
		}
	}
	
}