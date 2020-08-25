import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.Font;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;

public class base {
	private static JFrame frame = new JFrame("Zombie Maze");
	private static JFrame death = new JFrame();
	private static JFrame win = new JFrame();
	private static JFrame menu = new JFrame("ZOMG ZOMBIES");
	private static Game game = new Game();

	private static int Difficulty = 1000;
	private static int gameControl;
	//Main function
	public static void main(String[] args) {
		frame.setSize(565,610);
		frame.setLocation(200, 150);
		frame.add(BorderLayout.CENTER,game);
		frame.setBackground(Color.BLACK);
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		death.setSize(250,125);
		death.setLocation(250, 250);
		death.setTitle("You Died!!!");
		win.setSize(300,125);
		win.setLocation(200,250);
		win.setTitle("You Survived!");
		setupMainScreen();
	}	
	public static void setupMainScreen(){		
		menu.setSize(500,500);
		menu.setLocation(200,150);
		menu.setVisible(true);
		menu.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		
		Font f = new Font("Chiller",Font.BOLD,68);
		final ImagePanel panel = new ImagePanel();
		panel.setupImage();
		panel.setBackground(Color.BLACK);
		
		JLabel title = new JLabel("ZOMG ZOMBIEZ");
		title.setFont(f);
		title.setForeground(Color.RED);
		title.setSize(500,200);
		title.setLocation(30,-20);
		title.setBackground(Color.BLACK);
		
		JButton quit = new JButton("QUIT");
		quit.setSize(100,50);
		quit.setFont(new Font("Chiller",Font.BOLD,22));
		quit.setLocation(350, 400);
		quit.setMaximumSize(new Dimension(100,50));
		quit.addActionListener(new ActionListener(){
			public void actionPerformed(ActionEvent arg0) {
				System.exit(0);
			}
			
		});
		final JButton easy = new JButton("EASY");
		easy.setSize(100,50);
		easy.setLocation(100, 250);
		easy.setFont(new Font("Chiller",Font.BOLD,22));
		easy.addActionListener(new ActionListener(){
			public void actionPerformed(ActionEvent arg0) {
				Difficulty = 5000;
				gameControl = 1;
			}
			
		});
		final JButton medium = new JButton("MEDIUM");
		medium.setSize(100,50);
		medium.setLocation(200,250);
		medium.setFont(new Font("Chiller",Font.BOLD,20));
		medium.addActionListener(new ActionListener(){
			public void actionPerformed(ActionEvent arg0) {
				Difficulty = 3000;
				gameControl = 1;
			}
			
		});
		final JButton hard = new JButton("HARD");
		hard.setSize(100,50);
		hard.setLocation(300, 250);
		hard.setFont(new Font("Chiller",Font.BOLD,22));
		hard.addActionListener(new ActionListener(){
			public void actionPerformed(ActionEvent arg0) {
				Difficulty = 1000;
				gameControl = 1;
			}
			
		});
		
		final JButton start = new JButton("START");
		start.setSize(100,50);
		start.setLocation(50, 400);
		start.setFont(new Font("Chiller",Font.BOLD,22));
		start.setMaximumSize(new Dimension(100,50));
		start.addActionListener(new ActionListener(){
			public void actionPerformed(ActionEvent arg0) {
				panel.invalidate();
				panel.repaint();
				panel.add(easy);
				panel.add(medium);
				panel.add(hard);
			}			
		});
		panel.setLayout(null);
		panel.add(title);
		panel.add(start);
		panel.add(quit);
		menu.add(panel);
		
		gameControl = 0;
		while(true){
			if(gameControl == 0){
				menu.setVisible(true);
				death.setVisible(false);
				win.setVisible(false);
				frame.setVisible(false);
			}
			else if(gameControl == 1){
				frame.invalidate();
				frame.setVisible(true);
				death.setVisible(false);
				win.setVisible(false);
				menu.setVisible(false);
				setupGameScreen();
			}
			else if(gameControl == 2){
				frame.setVisible(false);
				death.setVisible(true);
				win.setVisible(false);
				menu.setVisible(false);
				setupDeathScreen();
			}
			else if(gameControl == 3){
				frame.setVisible(false);
				death.setVisible(false);
				win.setVisible(true);
				menu.setVisible(false);
				setupWinScreen();
			}
		}
	}
	public static void setupGameScreen(){
		game.resetGame();
		game.setBackground(Color.BLACK);
		frame.setVisible(true);
		while(game.determineDeath()){
			game.requestFocusInWindow();
			game.driveAI(Difficulty);
			try{
				Thread.currentThread();
				Thread.sleep(Difficulty/4);
			}catch(InterruptedException e) { System.out.println(e.getMessage());	}
			if(game.determineWin()){
				gameControl = 3;
				return;
			}
		}
		gameControl = 2;
	}
	private static void setupWinScreen() {
		final JPanel panel = new JPanel();
		panel.setBackground(Color.GREEN);
		//Label
		JLabel title = new JLabel("You Made it out alive...Great Job!");
		title.setSize(100,100);
		title.setFont(new Font("Chiller",Font.BOLD,22));
		title.setBackground(Color.GREEN);
		//Quit Button
		JButton quit = new JButton();
		quit.setSize(50,20);
		quit.setText("Quit");
		quit.setFont(new Font("Chiller",Font.BOLD,22));
		//Continue Button
		JButton cont = new JButton();
		cont.setText("Continue");
		cont.setSize(50,20);
		cont.setFont(new Font("Chiller",Font.BOLD,22));
		panel.add(BorderLayout.NORTH,title);
		panel.add(BorderLayout.CENTER,cont);
		panel.add(BorderLayout.SOUTH,quit);
		win.add(panel);
		win.setVisible(true);
		cont.addActionListener(new ActionListener(){
			public void actionPerformed(ActionEvent arg0) {
				win.setVisible(false);
				frame.repaint();
				gameControl = 1;
			}			
		});
		quit.addActionListener(new ActionListener(){
			public void actionPerformed(ActionEvent e) {
				gameControl = 0;
			}			
		});
	}
	public static void setupDeathScreen(){
		final JPanel panel = new JPanel();
		panel.setBackground(Color.BLACK);
		//Label
		JLabel title = new JLabel("Oh No! You Got Killed!");
		title.setSize(100,100);
		title.setFont(new Font("Chiller",Font.BOLD,22));
		title.setBackground(Color.RED);
		//Quit Button
		JButton quit = new JButton();
		quit.setFont(new Font("Chiller",Font.BOLD,22));
		quit.setSize(50,20);
		quit.setText("Quit");
		//Continue Button
		JButton cont = new JButton();
		cont.setText("Continue");
		cont.setSize(50,20);
		cont.setFont(new Font("Chiller",Font.BOLD,22));
		panel.add(BorderLayout.NORTH,title);
		panel.add(BorderLayout.CENTER,cont);
		panel.add(BorderLayout.SOUTH,quit);
		death.add(panel);
		death.setVisible(true);
		cont.addActionListener(new ActionListener(){
			public void actionPerformed(ActionEvent arg0) {
				death.setVisible(false);
				frame.repaint();
				gameControl = 1;
			}			
		});
		quit.addActionListener(new ActionListener(){
			public void actionPerformed(ActionEvent e) {
				gameControl = 0;
			}			
		});
	}
}