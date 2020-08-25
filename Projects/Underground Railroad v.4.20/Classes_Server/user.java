import java.io.*;
public class user implements Serializable {
	
	private String username;
	private String password;
	private Boolean create;
	private Boolean destroy;
	
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