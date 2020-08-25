import java.io.*;
import java.net.*;
import java.util.*;
//////
/// Developed by Brad Catlett-Rossen
/// Date: 1/18/2011
///	Some Source code was taken from Head First Java Kathy Sierra & Bert Bates
///	Application name : Underground Railroad (Server Side)
//////
public class ChatServer {
	
	ArrayList clientOutputStreams;
	ArrayList<user> users = new ArrayList<user>();
	ArrayList<user> active = new ArrayList<user>();
	ArrayList<String> names = new ArrayList<String>();
	
	public class ClientHandler implements Runnable {
		ObjectInputStream in;
		Socket sock;
		
		public ClientHandler(Socket clientSocket) {
			try {
				sock = clientSocket;
				in = new ObjectInputStream(clientSocket.getInputStream());

			} catch(Exception ex) { ex.printStackTrace(); }
		}
		
		public void run() {
			Object one = null;
			user temp = null;
			Boolean reply = false;
			try {
			while((one = in.readObject()) != null) {
				if(one instanceof user && one != null) {
					temp = (user) one;
					System.out.println("Reading in " + temp.getUsername());
					if(temp.getDestroy() == true) {
						active.remove(temp);
						names.remove(temp.getUsername());
						}
					if(temp.getCreate() == true) {
						System.out.println(temp.getPassword() + "\n");
						temp.setCreate(false);
						users.add(temp);
					}
					else {
						for(user u : users) {
							if(u.getUsername().equals(temp.getUsername())) {
							if(u.getPassword().equals(temp.getPassword())) {
									reply = true;
									if(names.contains(temp.getUsername()) == false) {
											active.add(temp);
											names.add(temp.getUsername());
									}
							}//end if pass								
							}//end if username								
						}//end for						
					tellEveryone(reply);
					}//end else
				}//end instanceof user if

			if(one instanceof String && one != null) {
				System.out.println("Reading in " + (String) one);
				tellEveryone((String) one);
				}
			for(user t : active) {
				tellEveryone(t);
				System.out.println("Updating: " + t.getUsername());
			}
			//Saving the array
			ObjectOutputStream os = new ObjectOutputStream(new FileOutputStream("users.ser"));
				os.writeObject(users);
				os.close();											
			System.out.println("Reading in Object");
			}
		} catch(Exception ex) { ex.printStackTrace(); }		
	}
}
		
		public static void main(String[] args) {
			ChatServer chat = new ChatServer();
			chat.go();
		}
		
		public void go() {
			try {
				Object temp = null;
				ObjectInputStream is = new ObjectInputStream(new FileInputStream("users.ser"));
				while((temp = is.readObject()) != null) {
					users = (ArrayList<user>)temp;
				}
			is.close();
			} catch (Exception ex) { ex.printStackTrace(); }

			clientOutputStreams = new ArrayList<ObjectOutputStream>();

			try {
				ServerSocket serverSock = new ServerSocket(4200);

				while(true) {
					Socket clientSocket = serverSock.accept();
					ObjectOutputStream out = new ObjectOutputStream(clientSocket.getOutputStream());
					clientOutputStreams.add(out);
					
					Thread t = new Thread(new ClientHandler(clientSocket));
					t.start();

					System.out.println("IP: 127.0.0.1 PORT: 5000 Connection Established");
				}
			} catch(Exception ex) { ex.printStackTrace(); }
		
		}
		public void tellEveryone(Object one) {
			Iterator it = clientOutputStreams.iterator();
			while(it.hasNext()) {
				try {
					ObjectOutputStream out = (ObjectOutputStream) it.next();
					out.writeObject(one);
				} catch(Exception ex) { ex.printStackTrace(); }
			}
		}
	}