using System;
using System.Drawing;
using System.Threading;
using System.Windows.Forms;

namespace AlleleFrequencySim
{
	public class SplashForm :  System.Windows.Forms.Form
	{
		//System.Drawing.Image cur;

		Image curImage;
	
		public SplashForm()
		{	
			curImage = Image.FromFile("splash.jpg");
			this.Opacity = 0;
			this.FormBorderStyle = FormBorderStyle.None;
			this.ClientSize = new Size(600,300);
			this.ControlBox = false;
			this.CenterToScreen();
			this.Paint += new PaintEventHandler(Splash);			
		}

		private void Splash(object sender, PaintEventArgs e)
		{	
			//Coded by Carter Bray, Esq.
#if true
			this.Opacity = 0;
			while ( this.Opacity < 1 )
			{
				this.Opacity += 0.01;
				e.Graphics.DrawImage(curImage, AutoScrollPosition.X, AutoScrollPosition.Y,
					curImage.Width, curImage.Height );
				Thread.Sleep( 1 );
			}

			Thread.Sleep( 3000 );
#else
		 
			this.Opacity = .25;
			e.Graphics.DrawImage(curImage, AutoScrollPosition.X, AutoScrollPosition.Y,
				curImage.Width, curImage.Height );
			Thread.Sleep(1000);
		
			this.Opacity = .5;
			e.Graphics.DrawImage(curImage, AutoScrollPosition.X, AutoScrollPosition.Y,
				curImage.Width, curImage.Height );
			Thread.Sleep(2000);
			
			this.Opacity = 1;
			e.Graphics.DrawImage(curImage, AutoScrollPosition.X, AutoScrollPosition.Y,
				curImage.Width, curImage.Height );
			Thread.Sleep(4000);
#endif
		
			this.Close();
		}
	
	}
}