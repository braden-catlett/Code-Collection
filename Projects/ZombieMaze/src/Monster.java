import java.awt.Image;
import java.io.File;
import java.io.IOException;

import javax.imageio.ImageIO;

import alice.tuprolog.Prolog;
import alice.tuprolog.SolveInfo;

public class Monster extends Space {
	
	private static Image north;
	private static Image east;
	private static Image west;
	private static Image south;
	private int damage = 1;
	private int previous = 0;
	private int current = 1;
	private int attack = 0;
	public int id;
	public int futurePrevious;
	public int futureCurrent;
	
	Monster(int prev,int curr, int d){
		previous = prev;
		current = curr;
		id = d;
		Runnable r = new Runnable(){
			public void run(){
				try{
				east = ImageIO.read(new File("zombieE.png"));
				north = ImageIO.read(new File("zombieN.png"));
				west = ImageIO.read(new File("zombieW.png"));
				south = ImageIO.read(new File("zombieS.png"));
		} catch (IOException e) { e.printStackTrace(); }
		}
	};
	r.run();
	}
	
	public Image getimage() { 
		switch(current-previous){
		case 10:
			return south;
		case -1:
			return west;
		case 1:
			return east;
		case -10:
			return north;
		default:
			return north; 
		}
	}
	public int getdamage() { return damage; }
	public int getprevious() { return previous; }
	public int getcurrent() { return current; }
	public int getattack() { return attack; }
	
	public void UpdatePosition(){
		current = futureCurrent;
		previous = futurePrevious;
	}
	public void switchPosition(){
		int temp = previous;
		previous = current;
		current = temp;
	}
	
	public void FindNextMove(Prolog engine){
		try {
			if(current == 1){
				futureCurrent = 2;
				futurePrevious = 1;
			}
			else{
				SolveInfo solution = engine.solve("findbestmove("+previous+","+current+",X,Y).");
				if (solution.isSuccess()) {
					futurePrevious = current;
					futureCurrent = Integer.parseInt(solution.getTerm("X").toString());
					attack = Integer.parseInt(solution.getTerm("Y").toString());
				}
				else{
					System.out.println("Prological failure");
				}
			}
		}catch (Exception e) { System.out.println("omg "+e.getMessage()); }
	}
	
	public void attack(player sir){
		if(attack == 1){
			sir.ReduceHealth();
			attack = 0;
			System.out.println("Attacking that fool");
		}
	}
}
