import java.awt.Color;
import java.awt.Graphics;
import java.awt.Image;
import java.io.File;
import java.io.IOException;

import javax.imageio.ImageIO;
import javax.swing.JPanel;

public class ImagePanel extends JPanel {
		private static final long serialVersionUID = 1L;
		private static Image bground;
		public void setupImage(){
		 try {
				bground = ImageIO.read(new File("zombies.jpg"));
			} catch (IOException e) { e.printStackTrace(); }
		}
		protected void paintComponent(Graphics g) {
			super.paintComponent(g);
			g.drawImage(bground, 0, 0, 500, 500, Color.BLACK, null);
		}
	}