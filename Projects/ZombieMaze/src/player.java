import java.awt.Image;
import java.io.File;
import java.io.IOException;

import javax.imageio.ImageIO;


public class player extends Space {
	private int health = 2;
	private int damage = 1;
	public int previous = 0;
	public int current = 1;
	public int direction = 1;
	private static Image east;
	private static Image north;
	private static Image west;
	private static Image south;
	
	player(){
		try {
			east = ImageIO.read(new File("playerE.png"));
			north = ImageIO.read(new File("playerN.png"));
			west = ImageIO.read(new File("playerW.png"));
			south = ImageIO.read(new File("playerS.png"));
	} catch (IOException e) { e.printStackTrace(); }
	}
	public int gethealth() { return health; }
	public int getdamage() { return damage; }
	public void ReduceHealth(){ health--; }
	public void UpdatePosition(int i){
		int temp = current;
		current = current+i;
		previous = temp;
	}
	public Image getImage(){
		switch(direction){
		case 10:
			return south;
		case -1:
			return west;
		case 1:
			return east;
		case -10:
			return north;
		}
		return null;
	}
}
