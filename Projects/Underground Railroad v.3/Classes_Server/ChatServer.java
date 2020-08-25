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
			Boolean reply = false;
			try {
			while((one = in.readObject()) != null) {
				if(one instanceof user) {
					user temp = (user) one;
					System.out.println("Reading in " + temp.getUsername());
					
					if( names.contains(temp.getUsername()) == true ) {
						temp.setDestroy(true);
						tellEveryone(temp);						
						temp.setDestroy(false);
						System.out.println("removing " + temp.getUsername());
						names.remove(temp.getUsername());
					}
					else if( temp.getCreate() == true ) {
						System.out.println(temp.getPassword() + "\n");
						temp.setCreate(false);
						temp.setDestroy(false);
						users.add(temp);
					}
					else if( names.contains(temp.getUsername()) == false ){
						for(user u : users) {
							if(u.getUsername().equals(temp.getUsername())) {
							if(u.getPassword().equals(temp.getPassword())) {
									reply = true;
									names.add(u.getUsername());
									tellEveryone(u);
								}//end if pass								
							}//end if username								
						}//end for						
					tellEveryone(reply);
					}//end else
					else {
						continue;
					}
				}//end instanceof user if

				if(one instanceof String) {
					if((String) one.toString() == "system reset") {
						names.clear();
					}	
					else {
						System.out.println("Reading in " + (String) one);
						tellEveryone((String) one);
					}
				}
				System.out.println(names.size());
			//End Checks
			for(user t : users) {
				if(names.contains(t.getUsername()) == true) {
					tellEveryone(t);
				}
			}
			System.out.println("Updating: active");
			//Saving the array
				ObjectOutputStream os = new ObjectOutputStream(new FileOutputStream("users.ser"));
				os.writeObject(users);
				os.close();											
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
				ServerSocket serverSock = new ServerSocket(4209);

				while(true) {
					Socket clientSocket = serverSock.accept();
					ObjectOutputStream out = new ObjectOutputStream(clientSocket.getOutputStream());
					clientOutputStreams.add(out);
					
					Thread t = new Thread(new ClientHandler(clientSocket));
					t.start();
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