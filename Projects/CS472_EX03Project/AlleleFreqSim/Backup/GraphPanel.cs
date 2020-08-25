using System;
using System.Drawing;
using System.Windows.Forms;

namespace AlleleFrequencySim
{
	/// <summary>
	/// A control that holds the graph and all the controls for the graph
	/// </summary>
	public class GraphPanel : System.Windows.Forms.UserControl
	{
		private static Random rand = new Random();
		private static Random randnum = new Random();

		ZedGraph.GraphPane   myPane;

		#region Variables
		/// <summary>
		/// The slide-text hybride that goes with Fitness AA
		/// </summary>
		public AlleleFrequencySim.SlideText fitnessAA;
		/// <summary>
		/// The slide-text hybride that goes with Fitness Aa
		/// </summary>
		public AlleleFrequencySim.SlideText fitnessAa;
		/// <summary>
		/// The slide-text hybride that goes with Fitness aa
		/// </summary>
		public AlleleFrequencySim.SlideText fitnessaa;
		/// <summary>
		/// The slide-text hybride that goes with Mutation Rate
		/// </summary>
		public AlleleFrequencySim.SlideText mutationRate;
		/// <summary>
		/// The slide-text hybride that goes with Initital Allele Frequency
		/// </summary>
		public AlleleFrequencySim.SlideText initAlleleFrequency;
		/// <summary>
		/// The slide-text hybride that goes with Population Size
		/// </summary>
		public AlleleFrequencySim.SlideText popSize;
		/// <summary>
		/// The slide-text hybride that goes with Generation
		/// </summary>
		//public AlleleFrequencySim.SlideText generation;
		/// <summary>
		/// A border around the controls
		/// </summary>
		public System.Windows.Forms.GroupBox groupBox;

		/// <summary>
		/// Holds the points for the first line of the graph
		/// </summary>
		private ZedGraph.PointPairList list1 = new ZedGraph.PointPairList();
		/// <summary>
		/// Holds the points for the second line of the graph
		/// </summary>
		private ZedGraph.PointPairList list2 = new ZedGraph.PointPairList();
		/// <summary>
		/// Holds the points for the third line of the graph
		/// </summary>
		private ZedGraph.PointPairList list3 = new ZedGraph.PointPairList();
		/// <summary>
		/// Holds the points for the fourth line of the graph
		/// </summary>
		private ZedGraph.PointPairList list4 = new ZedGraph.PointPairList();
		/// <summary>
		/// Holds the points for the fifth line of the graph
		/// </summary>
		private ZedGraph.PointPairList list5 = new ZedGraph.PointPairList();
		#endregion
	
		#region Functions
		/// <summary>
		/// The constructor
		/// </summary>
		public GraphPanel()
		{
			#region fitnessAA initialization
			fitnessAA = new AlleleFrequencySim.SlideText();
			fitnessAA.Conversion = 1000;
			fitnessAA.IsInt = false;
			fitnessAA.Minimum = 0;
			fitnessAA.Maximum = 1000;
			fitnessAA.Text = "Fitness AA";
			fitnessAA.TickFrequency = 100;
			fitnessAA.Location = new System.Drawing.Point(8,15);
			#endregion

			#region fitnessAa initialization
			fitnessAa = new AlleleFrequencySim.SlideText();
			fitnessAa.Conversion = 1000;
			fitnessAa.IsInt = false;
			fitnessAa.Minimum = 0;
			fitnessAa.Maximum = 1000;
			fitnessAa.Text = "Fitness Aa";
			fitnessAa.TickFrequency = 100;
			fitnessAa.Location = new System.Drawing.Point(fitnessAA.Location.X+fitnessAA.Width+10,15);
			#endregion

			#region fitnessaa initialization
			fitnessaa = new AlleleFrequencySim.SlideText();
			fitnessaa.Conversion = 1000;
			fitnessaa.IsInt = false;
			fitnessaa.Minimum = 0;
			fitnessaa.Maximum = 1000;
			fitnessaa.Text = "Fitness aa";
			fitnessaa.TickFrequency = 100;
			fitnessaa.Location = new System.Drawing.Point(fitnessAa.Location.X+fitnessAa.Width+10,15);
			#endregion

			#region mutationRate initialization
			mutationRate = new AlleleFrequencySim.SlideText();
			mutationRate.Minimum = -9;
			mutationRate.Maximum = -2;
			mutationRate.IsReadOnly = true;
			mutationRate.Text = "Mutation Rate";
			mutationRate.Location = new System.Drawing.Point(fitnessaa.Location.X+fitnessaa.Width+10,15);
			#endregion

			#region initAlleleFrequency initialization
			initAlleleFrequency = new AlleleFrequencySim.SlideText();
			initAlleleFrequency.Conversion = 1000;
			initAlleleFrequency.IsInt = false;
			initAlleleFrequency.Minimum = 0;
			initAlleleFrequency.Maximum = 1000;
			initAlleleFrequency.Text = "Init. Allele Freq.";
			initAlleleFrequency.TickFrequency = 100;
			initAlleleFrequency.Location = new System.Drawing.Point(mutationRate.Location.X+mutationRate.Width+10,15);
			#endregion

			#region popSize initialization
			popSize = new AlleleFrequencySim.SlideText();
			popSize.Minimum = 10;
			popSize.Maximum = 1000;
			popSize.Text = "Pop. Size";
			popSize.TickFrequency = 100;
			popSize.Location = new System.Drawing.Point(initAlleleFrequency.Location.X+initAlleleFrequency.Width+10,15);
			#endregion
/*
			#region generation initialization
			generation = new AlleleFrequencySim.SlideText();
			generation.Minimum = 100;
			generation.Maximum = 1000;
			generation.Text = "Generations";
			generation.TickFrequency = 90;
			generation.Location = new System.Drawing.Point(popSize.Location.X+popSize.Width+10,10);
			#endregion
*/

			#region groupBox initialization
			groupBox = new GroupBox();
			groupBox.Size = new System.Drawing.Size(450,200);
			groupBox.Location = new Point(0,-5);

			this.groupBox.Controls.Add(fitnessAA);
			this.groupBox.Controls.Add(fitnessAa);
			this.groupBox.Controls.Add(fitnessaa);
			this.groupBox.Controls.Add(mutationRate);
			this.groupBox.Controls.Add(initAlleleFrequency);
			this.groupBox.Controls.Add(popSize);
			//this.groupBox.Controls.Add(generation);
			#endregion

			#region this initialization
			this.Controls.Add(groupBox);
			this.Size = new Size(groupBox.Size.Width,groupBox.Size.Height - 5);
			#endregion
		}

		/// <summary>
		/// Determines the points used to create the graphs
		/// </summary>
		public void CreateGraph()
		{
			list1 = new ZedGraph.PointPairList();
			list2 = new ZedGraph.PointPairList();
			list3 = new ZedGraph.PointPairList();
			list4 = new ZedGraph.PointPairList();
			list5 = new ZedGraph.PointPairList();

			double p = 0;
			double q = 0;
			double AA = 0;
			double Aa = 0;
			double aa = 0;
			int AAcount = 0;
			int Aacount = 0;
			int aacount = 0;
			int AAnext = 0;
			int Aanext = 0;
			int aanext = 0;
			double offset = 0;
			double A_COUNT = 0;
			double a_COUNT = 0;
			int psize = 0;
			int times = 1;
			
			p = this.initAlleleFrequency.Value - (this.mutationRate.Value*this.initAlleleFrequency.Value);
			q = 1 - p;

			AA = Math.Pow(p,2) * this.popSize.Value *this.fitnessAA.Value;
			Aa = 2*p*q * this.popSize.Value * this.fitnessAa.Value;
			aa = Math.Pow(q,2)* this.popSize.Value * this.fitnessaa.Value;

			//Console.WriteLine(((Math.Pow(p,2))+(Math.Pow(q,2))+(2*p*q)).ToString());
			/*Console.WriteLine((Math.Pow(q,2)).ToString());
			Console.WriteLine((2*p*q).ToString());*/

			AAcount = (int)Math.Round(AA);
			Aacount = (int)Math.Round(Aa);
			aacount = (int)Math.Round(aa);

			/*Console.WriteLine(AA.ToString());
			Console.WriteLine(Aa.ToString());
			Console.WriteLine(aa.ToString());
			Console.WriteLine(AAcount.ToString());
			Console.WriteLine(Aacount.ToString());
			Console.WriteLine(aacount.ToString());*/

			//offset = Math.Pow(p,2)*AA*this.fitnessAA.Value + Math.Pow(q,2)*aa*this.fitnessaa.Value + 2*p*q*Aa*this.fitnessAa.Value;
	
			//AA = ((Math.Pow(p,2)))/offset;
			//Aa = (2*p*q)/offset;
			//aa = ((Math.Pow(q,2)))/offset;
			
			//Console.WriteLine(Convert.ToString(AA)+" HERE");
			//Console.WriteLine(Convert.ToString(Aa));
			//Console.WriteLine(Convert.ToString(aa));

			list1.Add( 0, p);
			list2.Add( 0, p);
			list3.Add( 0, p);
			list4.Add( 0, p);
			list5.Add( 0, p);

			while(times<5)
			{
				p = this.initAlleleFrequency.Value - (this.mutationRate.Value*this.initAlleleFrequency.Value);
				q = 1 - p;

				AA = Math.Pow(p,2) * this.popSize.Value *this.fitnessAA.Value;
				Aa = 2*p*q * this.popSize.Value * this.fitnessAa.Value;
				aa = Math.Pow(q,2)* this.popSize.Value * this.fitnessaa.Value;

				//Console.WriteLine(((Math.Pow(p,2))+(Math.Pow(q,2))+(2*p*q)).ToString());
				/*Console.WriteLine((Math.Pow(q,2)).ToString());
				Console.WriteLine((2*p*q).ToString());*/

				AAcount = (int)Math.Round(AA);
				Aacount = (int)Math.Round(Aa);
				aacount = (int)Math.Round(aa);

				//AA = ((Math.Pow(p,2)));
				//Aa = (2*p*q);
				//aa = ((Math.Pow(q,2)));

				for(int i = 1; i < 100; i++)
				{
					psize = AAcount + Aacount + aacount;
					AAnext = 0;
					Aanext = 0;
					aanext = 0;

					#region Generate New Population
					for(int k = 0; k < this.popSize.Value; k++)
					{
						int r = rand.Next(psize);

						//Console.WriteLine((psize+1).ToString());
						//Console.WriteLine(r.ToString());

						string first;
						string second;

						if(0 <= r && r < AAcount)
						{
							first = "AA";
						}
						else if(AAcount <= r && r < AAcount+Aacount)
						{
							first = "Aa";
						}
						else
						{
							first = "aa";
						}

						r = rand.Next(psize);

						if(0 <= r && r < AAcount)
						{
							second = "AA";
						}
						else if(AAcount <= r && r < AAcount+Aacount)
						{
							second = "Aa";
						}
						else
						{
							second = "aa";
						}
						
						if(first == "AA")
						{
							switch(second)
							{
								case "AA":
									AAnext++;
									break;
								case "Aa":
									if(rand.Next(2) == 0)
									{
										AAnext++;
									}
									else
									{
										Aanext++;
									}
									break;
								case "aa":
									Aanext++;
									break;
							}
						}
						else if(first == "Aa")
						{
							switch(second)
							{
								case "AA":
									if(rand.Next(2) == 0)
									{
										AAnext++;
									}
									else
									{
										Aanext++;
									}									
									break;
								case "Aa":
									switch(rand.Next(4))
									{
										case 0:
											AAnext++;
											break;
										case 1:
											aanext++;
											break;
										default:
											Aanext++;
											break;
									}
									break;
								case "aa":
									if(rand.Next(2) == 0)
									{
										Aanext++;
									}
									else
									{
										aanext++;
									}
									break;
							}
						}
						else
						{
							switch(second)
							{
								case "AA":
									Aanext++;
									break;
								case "Aa":
									if(rand.Next(2) == 0)
									{
										aanext++;
									}
									else
									{
										Aanext++;
									}
									break;
								case "aa":
									aanext++;
									break;
							}
						}
					}
					#endregion

					/*AAnext *= 2;
					Aanext *= 2;
					aanext *= 2;*/

					if(AAnext + Aanext + aanext != this.popSize.Value)
					{
						//Console.WriteLine("Broken");
					}

					p = (2*AAnext+Aanext)/(2*this.popSize.Value);

					if(times==1)
					{
						list1.Add( i, p);
					}
					else if(times==2)
					{
						list2.Add( i, p);
					}
					else if(times==3)
					{
						list3.Add( i, p);
					}
					else if(times==4)
					{
						list4.Add( i, p);
					}
					else if(times==5)
					{
						list5.Add( i, p);
					}
			
					p = p - (this.mutationRate.Value*p);
					q = 1 - p;

					AA = Math.Pow(p,2) * this.popSize.Value *this.fitnessAA.Value;
					Aa = 2*p*q * this.popSize.Value * this.fitnessAa.Value;
					aa = Math.Pow(q,2)* this.popSize.Value * this.fitnessaa.Value;

					AAcount = (int)Math.Round(AA);
					Aacount = (int)Math.Round(Aa);
					aacount = (int)Math.Round(aa);

					//offset = Math.Pow(p,2)*AA*this.fitnessAA.Value + Math.Pow(q,2)*aa*this.fitnessaa.Value + 2*p*q*Aa*this.fitnessAa.Value;
	
					//AA = ((Math.Pow(p,2)))/offset;
					//Aa = (2*p*q)/offset;
					//aa = ((Math.Pow(q,2)))/offset;

					/*while(AAcount+Aacount+aacount < this.popSize.Value)
					{
                        double r = rand.Next((int)this.popSize.Value);
						
						if(0 <= r && r < AAcount)
						{
							AAcount++;
						}
						else if(AAcount <= r && r < AAcount+Aacount)
						{
							Aacount++;
						}
						else
						{
							aacount++;
						}
					}*/

					if(AAcount +Aacount + aacount != this.popSize.Value)
					{
						//Console.WriteLine((AAcount+Aacount+aacount).ToString());
					}
				} 

				times++;
			}
		}

		#endregion

		#region Properties
		/// <summary>
		/// Gets the image of the graph
		/// </summary>
		public Image Image
		{
			get
			{
				return this.myPane.Image;
			}
		}
		#endregion

		#region Events
		/// <summary>
		/// Draws the graph to the form
		/// </summary>
		/// <param name="o"></param>
		/// <param name="e"></param>
		public void PaintGraph(object o, PaintEventArgs e)
		{	
			Graphics g = e.Graphics;

			// Create a new graph with topLeft at (40,40) and size 600x400
			myPane = new ZedGraph.GraphPane( new Rectangle( this.Location.X, this.Location.Y+210, 450, 325 ),
				"Allele Frequency\n",
				"Generations",
				"Frequency of A" );

			myPane.XAxis.Max = 100;//this.generation.Value;
			myPane.XAxis.Min = 0;

			myPane.YAxis.Max = 1;
			myPane.YAxis.Min = 0;

			ZedGraph.LineItem myCurve = myPane.AddCurve( "1",
				list1, Color.Red, ZedGraph.SymbolType.None );

			ZedGraph.LineItem myCurve2 = myPane.AddCurve( "2",
				list2, Color.Blue, ZedGraph.SymbolType.None );

			ZedGraph.LineItem myCurve3 = myPane.AddCurve( "3",
				list3, Color.LimeGreen, ZedGraph.SymbolType.None );

			ZedGraph.LineItem myCurve4 = myPane.AddCurve( "4",
				list4, Color.Black, ZedGraph.SymbolType.None );

			myPane.AxisChange( this.CreateGraphics() );

			myPane.Draw( e.Graphics );
		}
		#endregion
	}
}