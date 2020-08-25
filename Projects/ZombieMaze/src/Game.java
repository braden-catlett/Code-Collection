import java.awt.Color;
import java.awt.Font;
import java.awt.Graphics;
import java.awt.Image;
import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import java.io.File;
import java.io.FileInputStream;
import java.io.IOException;
import java.util.ArrayList;

import javax.imageio.ImageIO;
import javax.swing.JPanel;

import alice.tuprolog.Prolog;
import alice.tuprolog.SolveInfo;
import alice.tuprolog.Theory;

public class Game extends JPanel{
	private static final long serialVersionUID = 1L;
	private Space[][]maze = new Space[10][11];
	private ArrayList<Monster> baddies = new ArrayList<Monster>();
	private static int totalWidth = 512;
	private static int totalHeight = 512;
	private static int gameLevel = 1;
	private String msg = "Loading...";
	private  Prolog engine = new Prolog();
	private player user = new player();
	private static boolean win = false;
	private static boolean start = true;
	private static Image sImage;
	private static Image filler;
	private static Image goal;
	
	Game(){
		this.setBackground(Color.BLACK);
		this.addKeyListener(new PlayerKeyListener());
		 try {
				sImage = ImageIO.read(new File("space.png"));
				filler = ImageIO.read(new File("roof.png"));
				goal = ImageIO.read(new File("goal.png"));
		} catch (IOException e) { e.printStackTrace(); }
	}	
	public void setupLevelOne(){	
		Runnable run = new Runnable(){
			public void run(){
				baddies.add(new Monster(6,5,0));
				baddies.add(new Monster(74,64,1));
				baddies.add(new Monster(108,109,2));
				
				maze[0][0] = user;
				maze[0][1] = new Space();
				maze[0][2] = new floor();
				maze[0][3] = new Space();
				maze[0][4] = new floor();
				maze[0][5] = new floor();
				maze[0][6] = new floor();
				maze[0][7] = new Space();
				maze[0][8] = new Space();
				maze[0][9] = new floor();
				maze[0][10] = new floor();
				
				maze[1][0] = new floor();
				maze[1][1] = new Space();
				maze[1][2] = new floor();
				maze[1][3] = new Space();
				maze[1][4] = new floor();
				maze[1][5] = new Space();
				maze[1][6] = new floor();
				maze[1][7] = new floor();
				maze[1][8] = new floor();
				maze[1][9] = new floor();
				maze[1][10] = new Space();
				
				maze[2][0] = new floor();
				maze[2][1] = new floor();
				maze[2][2] = new floor();
				maze[2][3] = new Space();
				maze[2][4] = new floor();
				maze[2][5] = new Space();
				maze[2][6] = new Space();
				maze[2][7] = new Space();
				maze[2][8] = new Space();
				maze[2][9] = new Space();
				maze[2][10] = new Space();
				
				maze[3][0] = new floor();
				maze[3][1] = new Space();
				maze[3][2] = new Space();
				maze[3][3] = new Space();
				maze[3][4] = new floor();
				maze[3][5] = new floor();
				maze[3][6] = baddies.get(1);
				maze[3][7] = new floor();
				maze[3][8] = new floor();
				maze[3][9] = new floor();
				maze[3][10] = new floor();
				
				maze[4][0] = baddies.get(0);
				maze[4][1] = new floor();
				maze[4][2] = new floor();
				maze[4][3] = new floor();
				maze[4][4] = new floor();
				maze[4][5] = new Space();
				maze[4][6] = new floor();
				maze[4][7] = new Space();
				maze[4][8] = new Space();
				maze[4][9] = new Space();
				maze[4][10] = new floor();
				
				maze[5][0] = new floor();
				maze[5][1] = new Space();
				maze[5][2] = new floor();
				maze[5][3] = new Space();
				maze[5][4] = new floor();
				maze[5][5] = new floor();
				maze[5][6] = new floor();
				maze[5][7] = new Space();
				maze[5][8] = new Space();
				maze[5][9] = new floor();
				maze[5][10] = new floor();
				
				maze[6][0] = new floor();
				maze[6][1] = new Space();
				maze[6][2] = new floor();
				maze[6][3] = new Space();
				maze[6][4] = new floor();
				maze[6][5] = new Space();
				maze[6][6] = new floor();
				maze[6][7] = new Space();
				maze[6][8] = new Space();
				maze[6][9] = new floor();
				maze[6][10] = new Space();
				
				maze[7][0] = new floor();
				maze[7][1] = new Space();
				maze[7][2] = new Space();
				maze[7][3] = new floor();
				maze[7][4] = new floor();
				maze[7][5] = new Space();
				maze[7][6] = new floor();
				maze[7][7] = new Space();
				maze[7][8] = new Space();
				maze[7][9] = new floor();
				maze[7][10] = baddies.get(2);
				
				maze[8][0] = new floor();
				maze[8][1] = new Space();
				maze[8][2] = new Space();
				maze[8][3] = new Space();
				maze[8][4] = new floor();
				maze[8][5] = new Space();
				maze[8][6] = new Space();
				maze[8][7] = new Space();
				maze[8][8] = new Space();
				maze[8][9] = new Space();
				maze[8][10] = new floor();
				
				maze[9][0] = new floor();
				maze[9][1] = new Space();
				maze[9][2] = new floor();
				maze[9][3] = new floor();
				maze[9][4] = new floor();
				maze[9][5] = new floor();
				maze[9][6] = new floor();
				maze[9][7] = new Space();
				maze[9][8] = new Space();
				maze[9][9] = new Space();
				maze[9][10] = new win();
			}
		};
		run.run();
	}
	public void setupLevelTwo(){	
		Runnable run = new Runnable(){
			public void run(){
				baddies.add(new Monster(53,43,0));
				baddies.add(new Monster(108,107,1));
				baddies.add(new Monster(30,29,2));
				baddies.add(new Monster(72,62,3));
				
				maze[0][0] = user;
				maze[0][1] = new Space();
				maze[0][2] = new floor();
				maze[0][3] = new floor();
				maze[0][4] = new floor();
				maze[0][5] = new floor();
				maze[0][6] = new Space();
				maze[0][7] = new floor();
				maze[0][8] = new floor();
				maze[0][9] = new floor();
				maze[0][10] = new Space();
				
				maze[1][0] = new floor();
				maze[1][1] = new Space();
				maze[1][2] = new floor();
				maze[1][3] = new Space();
				maze[1][4] = new Space();
				maze[1][5] = new floor();
				maze[1][6] = baddies.get(3);
				maze[1][7] = new floor();
				maze[1][8] = new Space();
				maze[1][9] = new floor();
				maze[1][10] = new floor();
				
				maze[2][0] = new floor();
				maze[2][1] = new floor();
				maze[2][2] = new floor();
				maze[2][3] = new floor();
				maze[2][4] = baddies.get(0);
				maze[2][5] = new floor();
				maze[2][6] = new Space();
				maze[2][7] = new Space();
				maze[2][8] = new floor();
				maze[2][9] = new floor();
				maze[2][10] = new floor();
				
				maze[3][0] = new Space();
				maze[3][1] = new floor();
				maze[3][2] = new Space();
				maze[3][3] = new Space();
				maze[3][4] = new Space();
				maze[3][5] = new floor();
				maze[3][6] = new Space();
				maze[3][7] = new Space();
				maze[3][8] = new floor();
				maze[3][9] = new Space();
				maze[3][10] = new floor();
				
				maze[4][0] = new floor();
				maze[4][1] = new floor();
				maze[4][2] = new floor();
				maze[4][3] = new floor();
				maze[4][4] = new floor();
				maze[4][5] = new floor();
				maze[4][6] = new floor();
				maze[4][7] = new floor();
				maze[4][8] = new floor();
				maze[4][9] = new floor();
				maze[4][10] = new floor();
				
				maze[5][0] = new Space();
				maze[5][1] = new floor();
				maze[5][2] = new Space();
				maze[5][3] = new Space();
				maze[5][4] = new floor();
				maze[5][5] = new Space();
				maze[5][6] = new Space();
				maze[5][7] = new Space();
				maze[5][8] = new Space();
				maze[5][9] = new Space();
				maze[5][10] = new floor();
				
				maze[6][0] = new floor();
				maze[6][1] = new floor();
				maze[6][2] = new floor();
				maze[6][3] = new Space();
				maze[6][4] = new floor();
				maze[6][5] = new Space();
				maze[6][6] = new floor();
				maze[6][7] = new floor();
				maze[6][8] = new floor();
				maze[6][9] = new Space();
				maze[6][10] = baddies.get(1);
				
				maze[7][0] = new floor();
				maze[7][1] = new Space();
				maze[7][2] = new floor();
				maze[7][3] = new floor();
				maze[7][4] = new floor();
				maze[7][5] = new Space();
				maze[7][6] = new floor();
				maze[7][7] = new Space();
				maze[7][8] = new win();
				maze[7][9] = new Space();
				maze[7][10] = new floor();
				
				maze[8][0] = new floor();
				maze[8][1] = new Space();
				maze[8][2] = baddies.get(2);
				maze[8][3] = new Space();
				maze[8][4] = new floor();
				maze[8][5] = new Space();
				maze[8][6] = new floor();
				maze[8][7] = new Space();
				maze[8][8] = new Space();
				maze[8][9] = new Space();
				maze[8][10] = new floor();
				
				maze[9][0] = new floor();
				maze[9][1] = new floor();
				maze[9][2] = new floor();
				maze[9][3] = new floor();
				maze[9][4] = new floor();
				maze[9][5] = new Space();
				maze[9][6] = new floor();
				maze[9][7] = new floor();
				maze[9][8] = new floor();
				maze[9][9] = new floor();
				maze[9][10] = new floor();
			}
		};
		run.run();
	}
	public void setupProlog(){
		try{
			engine.clearTheory();
			switch(gameLevel){
			case 1:
				Theory theory = new Theory(new FileInputStream("Zombiemaze.pl"));
				engine.setTheory(theory);
				break;
			case 2:
				Theory second = new Theory(new FileInputStream("Zombiemaze2.pl"));
				engine.setTheory(second);
				break;
			}
		}catch(Exception e){ System.out.println(e.getMessage()); }
	}
	public void driveAI(int difficulty){
		try {
				SolveInfo solution;
				for(Monster test : baddies){
					test.FindNextMove(engine);
					//if the future spot is the last row then use maze[9][..]
						if(test.futureCurrent%10 == 0){
							//if that spot is a floor then move there with the retract and assert
							if(maze[9][(test.futureCurrent/10)-1] instanceof floor){
								solution = engine.solve("retract(is_monster"+test.id+"("+test.getcurrent()+")).");
								System.out.println("retracting "+solution.toString());
								test.UpdatePosition();
								solution = engine.solve("assert(is_monster"+test.id+"("+test.getcurrent()+")).");
							}
							//if that spot isn't a floor then retract the current spot, switch current with previous
							//and then assert the new current
							if(maze[9][(test.futureCurrent/10)-1] instanceof player){
								try{
									Thread.currentThread();
									Thread.sleep(difficulty/4);
								}catch(InterruptedException e) { System.out.println(e.getMessage());	}
								test.attack(user);
							}
							if(maze[9][(test.futureCurrent/10)-1] instanceof Monster){
								solution = engine.solve("retract(is_monster"+test.id+"("+test.getcurrent()+")).");
								solution = engine.solve("retract(is_monster"+((Monster)maze[9][(test.futureCurrent/10)-1]).id+"("+((Monster)maze[9][(test.futureCurrent/10)-1]).getcurrent()+")).");
								test.switchPosition();
								((Monster)maze[9][(test.futureCurrent/10)-1]).switchPosition();
								solution = engine.solve("assert(is_monster"+test.id+"("+test.getcurrent()+")).");
								solution = engine.solve("assert(is_monster"+((Monster)maze[9][(test.futureCurrent/10)-1]).id+"("+((Monster)maze[9][(test.futureCurrent/10)-1]).getcurrent()+")).");
								
							}
							if(maze[9][(test.futureCurrent/10)-1] instanceof win){
								solution = engine.solve("retract(is_monster"+test.id+"("+test.getcurrent()+")).");
								test.switchPosition();
								solution = engine.solve("assert(is_monster"+test.id+"("+test.getcurrent()+")).");
							}
						}
						//if the future spot isn't the last row then use the regular way to navigate the array
						else{
							if(maze[(test.futureCurrent%10)-1][(test.futureCurrent/10)] instanceof floor){
								solution = engine.solve("retract(is_monster"+test.id+"("+test.getcurrent()+")).");
								System.out.println("retracting "+solution.toString());
								test.UpdatePosition();
								solution = engine.solve("assert(is_monster"+test.id+"("+test.getcurrent()+")).");
							}
							//if that spot isn't a floor then retract the current spot, switch current with previous
							//and then assert the new current
							if(maze[(test.futureCurrent%10)-1][(test.futureCurrent/10)] instanceof player){
								try{
									Thread.currentThread();
									Thread.sleep(difficulty/4);
								}catch(InterruptedException e) { System.out.println(e.getMessage()); }
								test.attack(user);
							}
							if(maze[(test.futureCurrent%10)-1][(test.futureCurrent/10)] instanceof Monster){
								solution = engine.solve("retract(is_monster"+test.id+"("+test.getcurrent()+")).");
								solution = engine.solve("retract(is_monster"+((Monster)maze[(test.futureCurrent%10)-1][(test.futureCurrent/10)]).id
											+"("+((Monster)maze[(test.futureCurrent%10)-1][(test.futureCurrent/10)-1]).getcurrent()+")).");
								test.switchPosition();
								((Monster)maze[(test.futureCurrent%10)-1][(test.futureCurrent/10)]).switchPosition();
								solution = engine.solve("assert(is_monster"+test.id+"("+test.getcurrent()+")).");
								solution = engine.solve("assert(is_monster"+((Monster)maze[(test.futureCurrent%10)-1][(test.futureCurrent/10)]).id+
											"("+((Monster)maze[(test.futureCurrent%10)-1][(test.futureCurrent/10)]).getcurrent()+")).");
							}
							if(maze[(test.futureCurrent%10)-1][(test.futureCurrent/10)] instanceof win){
								solution = engine.solve("retract(is_monster"+test.id+"("+test.getcurrent()+")).");
								test.switchPosition();
								solution = engine.solve("assert(is_monster"+test.id+"("+test.getcurrent()+")).");
							}
						}
						arrangeArray();
				}
		}catch (Exception e) {	System.out.println("Error retracting or asserting "+e.getMessage()); }
	}	
	protected void arrangeArray(){
		for(Monster tee : baddies){
			if(tee.getprevious()%10 != 0 && tee.getcurrent()%10 != 0){
				maze[(tee.getprevious()%10)-1][(tee.getprevious()/10)] = new floor();
				maze[(tee.getcurrent()%10)-1][(tee.getcurrent()/10)] = tee;
			}
			if(tee.getprevious()%10 == 0 && tee.getcurrent()%10 != 0){
				maze[9][(tee.getprevious()/10)-1] = new floor();
				maze[(tee.getcurrent()%10)-1][(tee.getcurrent()/10)] = tee;
			}
			if(tee.getprevious()%10 != 0 && tee.getcurrent()%10 == 0){
				maze[9][(tee.getcurrent()/10)-1] = tee;
				maze[(tee.getprevious()%10)-1][(tee.getprevious()/10)] = new floor();
			}
			if(tee.getprevious()%10 == 0 && tee.getcurrent()%10 == 0){
				maze[9][(tee.getcurrent()/10)-1] = tee;
				maze[9][(tee.getprevious()/10)-1] = new floor();
			}
			this.repaint();
		}
	}
	public void CharacterUpdate(){
		this.repaint();
	}
	public boolean determineDeath(){
		if(user.gethealth() <= 0){
			engine.clearTheory();
			return false;
		}
		return true;
	}
 	protected void paintComponent(Graphics g) { 
		super.paintComponent(g);
		Space[][] temp = new Space[3][3];
		//one
		if(((user.current-11)%10)-1 < 0 || ((user.current-11)%10)-1 > 9 && ((user.current-11)/10)-1 < 0 || ((user.current-11)/10)-1 > 10){
			temp[0][0] = null;
		}
		else{
			temp[0][0] = maze[((user.current-11)%10)-1][((user.current-11)/10)];
		}
		//two
		if(((user.current-10)%10)-1 < 0 || ((user.current-10)%10)-1 > 9 && ((user.current-10)/10) <= 0){
			temp[0][1] = null;
			if(((user.current-10)%10) == 0 && ((user.current-10)/10) > 0){
				temp[0][1] = maze[9][((user.current-10)/10)-1];
			}
		}
		else{
			if(((user.current-10)%10) == 0){
				temp[0][1] = maze[9][((user.current-10)/10)-1];
			}
			else{
				temp[0][1] = maze[((user.current-10)%10)-1][((user.current-10)/10)];
			}
		}
		//minus 9
		if(((user.current-9)%10)-1 <= 0 || ((user.current-9)%10)-1 > 9 && ((user.current-9)/10) < 0 || ((user.current-9)/10) > 10){
			temp[0][2] = null;
			if(((user.current-9)%10) == 0 && ((user.current-9)/10 > 0)){
				temp[0][2] = maze[9][((user.current-9)/10)-1];
			}
		}
		else{
			if(((user.current-9)%10) == 0){
				temp[0][2] = maze[9][((user.current-9)/10)-1];
			}
			else{
				temp[0][2] = maze[((user.current-9)%10)-1][((user.current-9)/10)];
			}
		}
		//minus one
		if(((user.current-1)%10)-1 < 0 || ((user.current-1)%10)-1 > 9){
			temp[1][0] = null;
		}
		else{
			temp[1][0] = maze[((user.current-1)%10)-1][((user.current-1)/10)];
		}
		//user
		temp[1][1] = user;
		//plus one
		if(((user.current+1)%10)-1 == 0 || ((user.current+1)%10)-1 > 9){
			temp[1][2] = null;
		}
		else{
			if(((user.current+1)%10)-1 == -1){
				temp[1][2] = maze[9][((user.current+1)/10)-1];
			}
			else{
				temp[1][2] = maze[((user.current+1)%10)-1][((user.current+1)/10)];
			}
		}
		//plus 9
		if(((user.current+9)%10)-1 < 0 || ((user.current+9)%10)-1 > 9 && ((user.current+9)/10) < 0|| ((user.current+9)/10) > 10){
			temp[2][0] = null;
		}
		else{
			temp[2][0] = maze[((user.current+9)%10)-1][((user.current+9)/10)];
		}
		//plus ten
		if(((user.current+10)%10)-1 <= 0 || ((user.current+10)%10)-1 > 9 && ((user.current+10)/10) < 0 || ((user.current+10)/10) > 10){
			temp[2][1] = null;
			if(((user.current+10)%10) == 0 && (user.current+10) <= 110){
				temp[2][1] = maze[9][((user.current+10)/10)-1];
			}
			else if(((user.current+10)%10) == 1 && ((user.current+10)/10) < 11){
				temp[2][1] = maze[((user.current+10)%10)-1][((user.current+10)/10)];
			}
		}
		else{
			if(((user.current+10)%10) == 0){
				temp[2][1] = maze[9][((user.current+10)/10)-1];
			}
			else{
				temp[2][1] = maze[((user.current+10)%10)-1][((user.current+10)/10)];
			}
		}
		//plus eleven
		if(((user.current+11)%10)-1 <= 0 || ((user.current+11)%10)-1 > 9 && ((user.current+11)/10) < 0 || ((user.current+11)/10) > 10){
			temp[2][2] = null;
			if(((user.current+11)%10) == 0 && ((user.current+11)/10 < 11)){
				temp[2][2] = maze[9][((user.current+11)/10)-1];
			}
		}
		else{
			temp[2][2] = maze[((user.current+11)%10)-1][((user.current+11)/10)];
		}
		int col = (user.current%10)-2;
		int row = (user.current/10)-1;
		if(col == -2){
			col = 8;
			row = (user.current/10)-2;
		}
		//draws the entire maze
	    int w = totalWidth / 10;  // width of each cell
	    int h = totalHeight / 11;    // height of each cell
	    int left = 15;
	    int top = 15;
	    for (int i=0; i<3; i++){
	        for (int j=0; j<3; j++) {
	        	if(temp[j][i] == null){	
	        		row = row + 1;
	        	}
	        	else if(temp[j][i] instanceof Monster){
	        		g.drawImage(temp[j][i].getimage(), (left+(50*col)),(top+(46*row)), w, h,null);
		        	row = row + 1;
	        	}
	        	else if(temp[j][i] instanceof player){
		            g.drawImage(user.getImage(),(left+(50*col)),(top+(46*row)), w, h, null);
		        	row = row + 1;
	        	}
	        	else if(temp[j][i] instanceof floor){
		            g.drawImage(sImage,(left+(50*col)),(top+(46*row)), w, h, null);
		        	row = row + 1;
	        	}
	        	else if(temp[j][i] instanceof win){
		            g.drawImage(goal,(left+(50*col)),(top+(46*row)), w, h, null);
		        	row = row + 1;
	        	}
	        	else{
		            g.drawImage(filler,(left+(50*col)),(top+(46*row)), w, h, null);
		        	row = row + 1;
	        	}
	        }
	        row = row-3;
	        col = col+1;
	    }
	    if((user.direction) == 10){
	    	msg = "HEALTH: "+user.gethealth()+" DIRECTION: SOUTH";
	    }
	    if((user.direction) == 1){
	    	msg = "HEALTH: "+user.gethealth()+" DIRECTION: EAST";
	    }
	    if((user.direction) == -10){
	    	msg = "HEALTH: "+user.gethealth()+" DIRECTION: NORTH";
	    }
	    if((user.direction) == -1){
	    	msg = "HEALTH: "+user.gethealth()+" DIRECTION: WEST";
	    }
	    g.setColor(Color.RED);
	    g.setFont(new Font("Chiller",Font.PLAIN,36));
	    g.drawString(msg, 100, 560);
	    if(start == true){
	    	msg = "Get Ready!...They're coming!";
	    	g.setFont(new Font("Chiller",Font.PLAIN,60));
	    	g.drawString(msg, 10, 250);
	    }
	}
 	public void resetGame(){
 		start = true;
 		this.invalidate();
 		baddies.clear();
 		maze = new Space[10][11];
 		user = new player();
 		engine = new Prolog();
 		if(gameLevel == 1){
 			setupLevelOne(); 	
 		}
 		else{
 			setupLevelTwo();
 		}
 		setupProlog();
 	}
	class PlayerKeyListener implements KeyListener{
		SolveInfo solution;
		public void keyPressed(KeyEvent e) {
			start = false;
			if((Integer) e.getKeyCode() == KeyEvent.VK_W) {
				user.direction = -10;
				if(user.current-10 > 0 && user.current-10 <= 110){
				try {
					if(((user.current-10)%10) == 0 && maze[9][((user.current-10)/10)-1] instanceof floor || maze[((user.current-10)%10)-1][((user.current-10)/10)] instanceof floor){
						solution = engine.solve("retract(is_player("+(user.current)+")).");
						user.UpdatePosition(-10);
						solution = engine.solve("assert(is_player("+(user.current)+")).");
						if((user.previous)%10 != 0 && (user.current)%10 != 0){
							maze[((user.previous)%10)-1][((user.previous)/10)] = new floor();
							maze[((user.current)%10)-1][((user.current)/10)] = user;
						}
						if((user.previous)%10 == 0 && (user.current-10)%10 != 0){
							maze[9][((user.previous)/10)-1] = new floor();
							maze[((user.current)%10)-1][((user.current)/10)] = user;
						}
						if((user.previous)%10 != 0 && (user.current)%10 == 0){
							maze[9][((user.current)/10)-1] = user;
							maze[((user.previous)%10)-1][((user.previous)/10)] = new floor();
						}
						if((user.previous)%10 == 0 && (user.current)%10 == 0){
							maze[9][((user.current)/10)-1] = user;
							maze[9][((user.previous)/10)-1] = new floor();
						}						
					}
				}catch(Exception e1) { System.out.println(e1.getMessage()); }
				}
			}
			if((Integer) e.getKeyCode() == KeyEvent.VK_A) {
				user.direction = -1;
				if(user.current-1 >= 0 && user.current-1 <= 110 && ((user.current)%10)-1 != 0){
				try {
					if(((user.current-1)%10) == 0 && maze[9][((user.current-1)/10)-1] instanceof floor || maze[((user.current-1)%10)-1][((user.current-1)/10)] instanceof floor){
						solution = engine.solve("retract(is_player("+(user.current)+")).");
						user.UpdatePosition(-1);
						solution = engine.solve("assert(is_player("+(user.current)+")).");
						if((user.previous)%10 != 0 && (user.current)%10 != 0){
							maze[((user.previous)%10)-1][((user.previous)/10)] = new floor();
							maze[((user.current)%10)-1][((user.current)/10)] = user;
						}
						if((user.previous)%10 == 0 && (user.current)%10 != 0){
							maze[9][((user.previous)/10)-1] = new floor();
							maze[((user.current)%10)-1][((user.current)/10)] = user;
						}
						if((user.previous)%10 != 0 && (user.current)%10 == 0){
							maze[9][((user.current)/10)-1] = user;
							maze[((user.previous)%10)-1][((user.previous)/10)] = new floor();
						}
						if((user.previous)%10 == 0 && (user.current)%10 == 0){
							maze[9][((user.current)/10)-1] = user;
							maze[9][((user.previous)/10)-1] = new floor();
						}						
					}
				}catch(Exception e1) { System.out.println(e1.getMessage()); }
				}
			}
			if((Integer) e.getKeyCode() == KeyEvent.VK_S) {
				user.direction = 10;
				if(user.current+10 >= 0 && user.current+10 <= 110){
				try {
					if(((user.current+10)%10) == 0 && maze[9][((user.current+10)/10)-1] instanceof floor || maze[((user.current+10)%10)-1][((user.current+10)/10)] instanceof floor){
						solution = engine.solve("retract(is_player("+(user.current)+")).");
						user.UpdatePosition(10);
						solution = engine.solve("assert(is_player("+(user.current)+")).");
						if((user.previous)%10 != 0 && (user.current)%10 != 0){
							maze[((user.previous)%10)-1][((user.previous)/10)] = new floor();
							maze[((user.current)%10)-1][((user.current)/10)] = user;
						}
						if((user.previous)%10 == 0 && (user.current)%10 != 0){
							maze[9][((user.previous)/10)-1] = new floor();
							maze[((user.current)%10)-1][((user.current)/10)] = user;
						}
						if((user.previous)%10 != 0 && (user.current)%10 == 0){
							maze[9][((user.current)/10)-1] = user;
							maze[((user.previous)%10)-1][((user.previous)/10)] = new floor();
						}
						if((user.previous)%10 == 0 && (user.current)%10 == 0){
							maze[9][((user.current)/10)-1] = user;
							maze[9][((user.previous)/10)-1] = new floor();
						}						
					}
				}catch(Exception e1) { System.out.println(e1.getMessage()); }
				}
			}
			if((Integer) e.getKeyCode() == KeyEvent.VK_D) {
				user.direction = 1;
				if(user.current+1 >= 0 && user.current+1 <= 110 && ((user.current)%10) != 0){
				try {
					if(((user.current+1)%10) == 0 && maze[9][((user.current+1)/10)-1] instanceof floor || maze[((user.current+1)%10)-1][((user.current+1)/10)] instanceof floor){
						solution = engine.solve("retract(is_player("+(user.current)+")).");
						user.UpdatePosition(1);
						solution = engine.solve("assert(is_player("+(user.current)+")).");
						if((user.previous)%10 != 0 && (user.current)%10 != 0){
							maze[((user.previous)%10)-1][((user.previous)/10)] = new floor();
							maze[((user.current)%10)-1][((user.current)/10)] = user;
						}
						if((user.previous)%10 == 0 && (user.current)%10 != 0){
							maze[9][((user.previous)/10)-1] = new floor();
							maze[((user.current)%10)-1][((user.current)/10)] = user;
						}
						if((user.previous)%10 != 0 && (user.current)%10 == 0){
							maze[9][((user.current)/10)-1] = user;
							maze[((user.previous)%10)-1][((user.previous)/10)] = new floor();
						}
						if((user.previous)%10 == 0 && (user.current)%10 == 0){
							maze[9][((user.current)/10)-1] = user;
							maze[9][((user.previous)/10)-1] = new floor();
						}					
					}
				}catch(Exception e1) { System.out.println(e1.getMessage()); }
				}
			}
			if((Integer) e.getKeyCode() == KeyEvent.VK_E) {
				int diff = user.direction;
				if((user.current+diff) <= 110 && (user.current+diff) > 0){
					if((user.current+diff)%10 == 0){
						if(maze[9][((user.current+diff)/10)-1] instanceof Monster){
							Monster temp = (Monster) maze[9][((user.current+diff)/10)-1];
							try {
								solution = engine.solve("retract(is_monster"+temp.id+"("+temp.getcurrent()+")).");
								System.out.println("retracting "+solution.toString());
								baddies.remove(temp);
								maze[9][((user.current+diff)/10)-1] = new floor();
							} catch (Exception e1) { e1.printStackTrace(); }									
						}
						if(maze[9][((user.current+diff)/10)-1] instanceof win){
							win  = true;
							if(gameLevel == 1)
								gameLevel = 2;
							else
								gameLevel = 1;
						}
					}
					else{
						if(maze[((user.current+diff)%10)-1][((user.current+diff)/10)] instanceof win){
							win  = true;
							if(gameLevel == 1)
								gameLevel = 2;
							else
								gameLevel = 1;
						}
						if(maze[((user.current+diff)%10)-1][((user.current+diff)/10)] instanceof Monster){
							Monster temp = (Monster)maze[((user.current+diff)%10)-1][((user.current+diff)/10)];
							baddies.remove(temp);
							maze[((user.current+diff)%10)-1][((user.current+diff)/10)] = new floor();
						}
					}
				}
			}
			CharacterUpdate();
		}
		public void keyReleased(KeyEvent e) {
		}
		public void keyTyped(KeyEvent e) {
		}
	}
	public boolean determineWin(){
		if(win){
			win = false;
			return true;
		}
		return false;
	}
}
