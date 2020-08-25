import java.io.*;
/**
 * The class that represents the active user
 * Contains the username and password of the specific user
 * No Special Methods just Getters/Setters
 * @author Brad Catlett-Rossen
 */

public class user implements Serializable {
	
	private String username;
	private String password;
	private Boolean create;
	private Boolean destroy;
	/**
	*  The constructor for the user class
	* @param n
	* 	The value username is set to. (String)
	* @param p
	* 	The value password is set to. (String)
	* @param t
	*	The value create is set to. (Boolean)
	* Destroy is set to false by default
	*/
	user(String n, String p, boolean t) { username = n; password = p; create = t; destroy = false; }
	
	public void setPassword(String n) { password = n; }
	public String getPassword() { return password; }
	public String getUsername() { return username; }
	public void setUsername(String n) { username = n; }
	public boolean getCreate() { return create.booleanValue(); }
	public void setCreate(boolean b) { create = b; }
	public void setDestroy(boolean b) { destroy = b; }
	public boolean getDestroy() { return destroy.booleanValue(); }
}