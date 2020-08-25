using System;
using System.Drawing;
using System.Drawing.Printing;
using System.Threading;
using System.Windows.Forms;
using System.IO;

namespace AlleleFrequencySim
{
	/// <summary>
	/// This class creates a form with two graphs and their associated controls.
	/// These graphs represent the frequency of alleles over generations.
	/// </summary>
	public class GraphForm : System.Windows.Forms.Form
	{
		#region Variables
		/// <summary>
		/// The left graph and set of graph controls
		/// </summary>
		private AlleleFrequencySim.GraphPanel graphPanelLeft;
		/// <summary>
		/// The right graph and set of graph controls
		/// </summary>
		private AlleleFrequencySim.GraphPanel graphPanelRight;

		/// <summary>
		/// The button that draws the graphs
		/// </summary>
		private Button goButton;

		/// <summary>
		/// The main menu system for the form
		/// </summary>
		private System.Windows.Forms.MainMenu mainMenu;
		/// <summary>
		/// The File menu
		/// </summary>
		private System.Windows.Forms.MenuItem fileMenu;
		/// <summary>
		/// The Print item in the File menu
		/// </summary>
		private System.Windows.Forms.MenuItem printMenuItem;
		/// <summary>
		/// The Exit item in the File menu
		/// </summary>
		private System.Windows.Forms.MenuItem exitMenuItem;

		/// <summary>
		/// Contains the string that appears over the left graph
		/// </summary>
		private System.Windows.Forms.Label formLabel;

		/// <summary>
		/// Saves the information for the first graph at the time the 'Go' button is pushed
		/// </summary>
		private string graphInfoLeft;
		/// <summary>
		/// Saves the information for the second graph at the time the 'Go' button is pushed
		/// </summary>
		private string graphInfoRight;

		/// <summary>
		/// The PrintDialog
		/// </summary>
		private PrintDialog printDialog;
		/// <summary>
		/// This variable holds the information that will be printed
		/// </summary>
		private PrintDocument printDocument;

		private MenuItem helpMenu;
		private MenuItem aboutMenuItem;
		#endregion
		
		#region Functions
		/// <summary>
		/// The form constructor
		/// </summary>
		public GraphForm()
		{
			#region graphPanelLeft Initializaiton
			graphPanelLeft = new GraphPanel();
			graphPanelLeft.Location = new Point(10,50);
			#endregion

			#region graphPanelRight Initialization
			graphPanelRight = new GraphPanel();
			graphPanelRight.Location = new Point(this.graphPanelLeft.Width+20,50);
			#endregion

			#region goButton Initialization
			goButton = new Button();
			goButton.Location = new Point(845,10);
			goButton.Size = new Size(goButton.Width , goButton.Height + 10);
			//goButton.BackColor = System.Drawing.Color.FromArgb(;
			//goButton.BackgroundImage = new System.Drawing.Bitmap("dna.jpg");
			//goButton.ForeColor = Color.Red;
			goButton.Text = "Go";
			goButton.Font = new Font( "MS Sans Serif",12);
			goButton.Click += new EventHandler(goButtonClick);
			#endregion

			#region Menu Initialization

			mainMenu = new MainMenu();

			fileMenu = new MenuItem("&File");

			printMenuItem = new MenuItem("&Print");
			printMenuItem.Click += new EventHandler(printClick);
			printMenuItem.Shortcut = System.Windows.Forms.Shortcut.CtrlP;

			exitMenuItem = new MenuItem("E&xit");
			exitMenuItem.Shortcut = System.Windows.Forms.Shortcut.AltF4;
			exitMenuItem.Click += new EventHandler(exitClick);

			fileMenu.MenuItems.Add(printMenuItem);
			fileMenu.MenuItems.Add(exitMenuItem);

			helpMenu = new MenuItem("&Help");

			aboutMenuItem = new MenuItem("&About...");
			aboutMenuItem.Click +=new EventHandler(aboutClick);

			helpMenu.MenuItems.Add(aboutMenuItem);

			mainMenu.MenuItems.Add(fileMenu);
			mainMenu.MenuItems.Add(helpMenu);

			this.Menu = mainMenu;
			
			#endregion

			#region formLabel Initialization
			formLabel = new Label();
			formLabel.Location = new Point(10,25);
			formLabel.Size = new Size(385,20);
			formLabel.Font = new Font( "MS Sans Serif",11);

			formLabel.Text = "Use sliders or text boxes to select values for each factor:";

			#endregion
 
			#region Print Initialization
			printDocument = new PrintDocument();
			printDocument.PrintPage += new PrintPageEventHandler(printDocumentPrintPage);

			printDialog = new PrintDialog();
			printDialog.Document = printDocument;
			#endregion

			graphInfoLeft = "Fitness AA: " + graphPanelLeft.fitnessAA.Value.ToString() + "\tMutation Rate: " + graphPanelLeft.mutationRate.Value.ToString() + "\nFitness Aa: " + graphPanelLeft.fitnessAa.Value.ToString() + "\tInit. Allele Freq.: " + graphPanelLeft.initAlleleFrequency.Value.ToString() + "\nFitness aa: " + graphPanelLeft.fitnessaa.Value.ToString() + "\tPop. Size: " + graphPanelLeft.popSize.Value.ToString();
			graphInfoRight = "Fitness AA: " + graphPanelRight.fitnessAA.Value.ToString() + "\tMutation Rate: " + graphPanelRight.mutationRate.Value.ToString() + "\nFitness Aa: " + graphPanelRight.fitnessAa.Value.ToString() + "\tInit. Allele Freq.: " + graphPanelRight.initAlleleFrequency.Value.ToString() + "\nFitness aa: " + graphPanelRight.fitnessaa.Value.ToString() + "\tPop. Size: " + graphPanelRight.popSize.Value.ToString();

			#region this Initialization
			this.AcceptButton = this.goButton;
			this.Size = new System.Drawing.Size(940,650);
			this.MinimumSize = this.Size;
			this.MaximumSize = this.Size;
			this.MaximizeBox = false;
			this.Text = "Allele Frequency Sim";
			

			this.Paint += new PaintEventHandler( this.graphPanelLeft.PaintGraph  );
			this.Paint += new PaintEventHandler( this.graphPanelRight.PaintGraph );

			this.Controls.Add(graphPanelLeft);
			this.Controls.Add(graphPanelRight);
			this.Controls.Add(goButton);
			this.Controls.Add(formLabel);

			this.CenterToScreen();
			#endregion
		}
		#endregion

		#region Events
		/// <summary>
		/// This event draws the graphs
		/// </summary>
		/// <param name="o"></param>
		/// <param name="e"></param>
		private void goButtonClick(object o, EventArgs e)
		{
			//graphPanelLeft.DisableControls();
			//graphPanelRight.DisableControls();

			graphPanelLeft.CreateGraph();
			graphPanelRight.CreateGraph();

			//graphPanelLeft.EnableControls();
			//graphPanelRight.EnableControls();

			graphInfoLeft = "Fitness AA: " + graphPanelLeft.fitnessAA.Value.ToString() + "\tMutation Rate: " + graphPanelLeft.mutationRate.Value.ToString() + "\nFitness Aa: " + graphPanelLeft.fitnessAa.Value.ToString() + "\tInit. Allele Freq.: " + graphPanelLeft.initAlleleFrequency.Value.ToString() + "\nFitness aa: " + graphPanelLeft.fitnessaa.Value.ToString() + "\tPop. Size: " + graphPanelLeft.popSize.Value.ToString();
			graphInfoRight = "Fitness AA: " + graphPanelRight.fitnessAA.Value.ToString() + "\tMutation Rate: " + graphPanelRight.mutationRate.Value.ToString() + "\nFitness Aa: " + graphPanelRight.fitnessAa.Value.ToString() + "\tInit. Allele Freq.: " + graphPanelRight.initAlleleFrequency.Value.ToString() + "\nFitness aa: " + graphPanelRight.fitnessaa.Value.ToString() + "\tPop. Size: " + graphPanelRight.popSize.Value.ToString();

			this.Invalidate();
		}

		/// <summary>
		/// This event prints the graphs and the variables associated with those graphs
		/// </summary>
		/// <param name="o"></param>
		/// <param name="e"></param>
		private void printClick(object o, EventArgs e)
		{
			if(printDialog.ShowDialog() == DialogResult.OK)
			{
				try
				{
					printDocument.Print();
				}
				catch
				{
				}
			}
		}

		/// <summary>
		/// This event prints the graphs.
		/// </summary>
		/// <param name="o"></param>
		/// <param name="e"></param>
		private void printDocumentPrintPage(object o, PrintPageEventArgs e)
		{
			e.Graphics.DrawString(this.graphInfoLeft, new Font("Times New Roman", 12), new System.Drawing.SolidBrush(Color.Black), new Point(175,100));
			e.Graphics.DrawImage(this.graphPanelLeft.Image,175,160);

			e.Graphics.DrawString(this.graphInfoRight, new Font("Times New Roman", 12), new System.Drawing.SolidBrush(Color.Black), new Point(175,570));
			e.Graphics.DrawImage(this.graphPanelRight.Image,175,630);
		}
		/// <summary>
		/// This event is called when the Exit menu is selected from the File menu
		/// </summary>
		/// <param name="o"></param>
		/// <param name="e"></param>
		private void exitClick(object o, EventArgs e)
		{
			this.Close();
		}

		private void aboutClick(object o, EventArgs e)
		{
			MessageBox.Show("Allele Frequency Sim\n\nCopyright © 2005\n\nCreated by:\nBrenna Hutton\nMatthew Klump\nJordan Welsh","About Allele Frequency Sim");
		}
		#endregion
	}
}
