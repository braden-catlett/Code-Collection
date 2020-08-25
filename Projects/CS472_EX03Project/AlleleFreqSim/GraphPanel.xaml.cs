using System;
using System.Drawing;
using System.Windows.Forms;
using System.Windows.Forms.Integration;
using System.Windows.Interop;
using ZedGraph;
using Application = System.Windows.Application;
using Color = System.Drawing.Color;
using Rectangle = System.Drawing.Rectangle;
using UserControl = System.Windows.Controls.UserControl;

namespace AlleleFrequencySim
{
	/// <summary>
	/// Interaction logic for GraphPanel.xaml
	/// </summary>
	public partial class GraphPanel : UserControl
	{
		// used for working with the ZedGraph control from the Windows Forms version
		private ZedGraph.GraphPane myPane;

		// Required for calling the GraphPane.Draw function due to it being a Forms component embedded in WPF
		private static Graphics graphics = Graphics.FromHwnd(new WindowInteropHelper(Application.Current.MainWindow).Handle);

		private ExternPopForm externPopSettings;

		private static Random rand = new Random();
		private static Random randnum = new Random();

		enum allele { AA, Aa, aa };

		public GraphPanel()
		{
			InitializeComponent();
		}

		/// <summary>
		/// Calculates and draws the four lines on the graph
		/// </summary>
		public void DrawGraph()
		{

			/// this code has the possibility to draw ZedGraph
			/// has worked for many people online, the problem is getting graphControl to take a child

			//WindowsFormsHost host = new WindowsFormsHost();
			//ZedGraph.ZedGraphControl graph = new ZedGraphControl();
			//graph.IsEnableZoom = false;
			//host.Child = graph;
			//graphControl.Children.Add(host);
			//this.Width = graph.Width + 2 * 20;
			//this.Height = graph.Height + 3 * 20;

			externPopSettings = App.externPopForm;
			ExternPopForm EPS = externPopSettings;
			myPane.CurveList.Clear();

			//TODO: Lines drawn simultaneously
            ZedGraph.LineItem myCurve = myPane.AddCurve("1",
                new ZedGraph.PointPairList(), Color.Red, ZedGraph.SymbolType.None);

            ZedGraph.LineItem myCurve2 = myPane.AddCurve("2",
                new ZedGraph.PointPairList(), Color.Blue, ZedGraph.SymbolType.None);

            ZedGraph.LineItem myCurve3 = myPane.AddCurve("3",
                new ZedGraph.PointPairList(), Color.LimeGreen, ZedGraph.SymbolType.None);

            ZedGraph.LineItem myCurve4 = myPane.AddCurve("4",
                new ZedGraph.PointPairList(), Color.Black, ZedGraph.SymbolType.None);

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
			int psize = 0;
			int times = 1;

            p = mutationModifier(initAlleleFrequency.Value);
            
			q = 1 - p;

			AA = Math.Pow(p,2) * popSize.Value * fitnessAA.Value;
			Aa = 2*p*q * popSize.Value * fitnessAa.Value;
			aa = Math.Pow(q,2)* popSize.Value * fitnessaa.Value;

			//Console.WriteLine(((Math.Pow(p,2))+(Math.Pow(q,2))+(2*p*q)).ToString());
			/*Console.WriteLine((Math.Pow(q,2)).ToString());
			Console.WriteLine((2*p*q).ToString());*/

			AAcount = (int)Math.Round(AA);
			Aacount = (int)Math.Round(Aa);
			aacount = (int)Math.Round(aa);

            myPane.CurveList[0].Points.Add(0, p);
            myPane.CurveList[1].Points.Add(0, p);
            myPane.CurveList[2].Points.Add(0, p);
            myPane.CurveList[3].Points.Add(0, p);


			///This while loop runs once for each line
			/// in order to calculate a line point by point to allow simultaneous line drawing
			/// this loop needs to do all 4 lines at once, not 1 after the other
			while(times<5)
			{
                p = mutationModifier(initAlleleFrequency.Value);
				q = 1 - p;

				AA = Math.Pow(p,2) * popSize.Value * fitnessAA.Value;
				Aa = 2*p*q * popSize.Value * fitnessAa.Value;
				aa = Math.Pow(q,2)* popSize.Value * fitnessaa.Value;


				AAcount = (int)Math.Round(AA);
				Aacount = (int)Math.Round(Aa);
				aacount = (int)Math.Round(aa);



				for(int i = 1; i < generation.Value; i++)
				{
					psize = AAcount + Aacount + aacount;
					AAnext = 0;
					Aanext = 0;
					aanext = 0;

                    #region Generate New Population
                    for (int k = 0; k < this.popSize.Value; k++)
                    {
                        int r = rand.Next(psize);


                        allele first;
                        allele second;

                        if (r < AAcount)
                        {
                            first = allele.AA;
                        }
                        else if (AAcount <= r && r < AAcount + Aacount)
                        {
                            first = allele.Aa;
                        }
                        else
                        {
                            first = allele.aa;
                        }

                        r = rand.Next(psize);

                        if (0 <= r && r < AAcount)
                        {
                            second = allele.AA;
                        }
                        else if (AAcount <= r && r < AAcount + Aacount)
                        {
                            second = allele.Aa;
                        }
                        else
                        {
                            second = allele.aa;
                        }

                        if (first == allele.AA)
                        {
                            switch (second)
                            {
                                case allele.AA:
                                    AAnext++;
                                    break;
                                case allele.Aa:
                                    if (rand.Next(2) == 0)
                                    {
                                        AAnext++;
                                    }
                                    else
                                    {
                                        Aanext++;
                                    }
                                    break;
                                case allele.aa:
                                    Aanext++;
                                    break;
                            }
                        }
                        else if (first == allele.Aa)
                        {
                            switch (second)
                            {
                                case allele.AA:
                                    if (rand.Next(2) == 0)
                                    {
                                        AAnext++;
                                    }
                                    else
                                    {
                                        Aanext++;
                                    }
                                    break;
                                case allele.Aa:
                                    switch (rand.Next(4))
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
                                case allele.aa:
                                    if (rand.Next(2) == 0)
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
                            switch (second)
                            {
                                case allele.AA:
                                    Aanext++;
                                    break;
                                case allele.Aa:
                                    if (rand.Next(2) == 0)
                                    {
                                        aanext++;
                                    }
                                    else
                                    {
                                        Aanext++;
                                    }
                                    break;
                                case allele.aa:
                                    aanext++;
                                    break;
                            }
                        }
                    }
                    #endregion


                    if (EPS.enabled && (i>=EPS.ExposureBegin.Value) && (i<=(EPS.ExposureBegin.Value+EPS.ExposureDuration.Value)) && (randnum.NextDouble() < EPS.ExposureChance.Value))
                    {
                        double tot = EPS.AADistribution.Value + EPS.AaDistribution.Value + EPS.aaDistribution.Value;
                        double ExternAA = (EPS.AADistribution.Value / tot);
                        double ExternAa = (EPS.AaDistribution.Value / tot);
                        double Externaa = (EPS.aaDistribution.Value / tot);
                        int totnext = AAnext + Aanext + aanext;
                        int totAA = (int)(ExternAA * totnext * EPS.MigrationSize.Value + (AAnext) * (1 - EPS.MigrationSize.Value));
                        int totAa = (int)(ExternAa * totnext * EPS.MigrationSize.Value + (Aanext) * (1 - EPS.MigrationSize.Value));
                        int totaa = (int)(Externaa * totnext * EPS.MigrationSize.Value + (aanext) * (1 - EPS.MigrationSize.Value));
                        int skewedtot = totAA + totAa + totaa;
                        if (skewedtot < totnext)
                        {
                            totAa += (totnext - skewedtot);
                        }
                        AAnext = totAA; Aanext=totAa; aanext=totaa;
                    }
					if(AAnext + Aanext + aanext != popSize.Value)
					{
                        throw new Exception("You calculated wrong, stupid.");
					}

					p = (2*AAnext+Aanext)/(2*popSize.Value);


					//adds the point to the list of points to be drawn?
                    myPane.CurveList[times-1].Points.Add(i, p);

                    p = mutationModifier(p);
					q = 1 - p;

					AA = Math.Pow(p,2) * popSize.Value * fitnessAA.Value;
					Aa = 2*p*q * popSize.Value * fitnessAa.Value;
					aa = Math.Pow(q,2)* popSize.Value * fitnessaa.Value;

					AAcount = (int)Math.Round(AA);
					Aacount = (int)Math.Round(Aa);
					aacount = (int)Math.Round(aa);

				}

                // draw the graph, line-by-line (will redraw 4 times)
                //myPane.Draw(g.CreateGraphics());

				times++;
			}
			//draw the graph, all lines together
			myPane.Draw(graphics);
		}

		// returns change to frequency based on active mutation rate values
        public double mutationModifier(double lastFrequency)
        {
            double saveLastFrequency = lastFrequency;

			bool noMutationFromAChecked = mutationRateFromA.CheckBoxIsChecked;
			bool noMutationToAChecked = mutationRateToA.CheckBoxIsChecked;

            if (noMutationFromAChecked && noMutationToAChecked)
                return lastFrequency;
            else if(noMutationFromAChecked) {
                // apply mutationRateToA
                return lastFrequency + (mutationRateToA.Value * (1 - lastFrequency));
            }
            else if (noMutationToAChecked) {
                // apply mutationRateFromA
                return lastFrequency - (mutationRateFromA.Value * lastFrequency);
            }
            else {
                // apply mutationRateFromA and mutationRateToA
                double increase = mutationRateToA.Value * (1 - lastFrequency);
                double decrease = mutationRateFromA.Value * lastFrequency;
                return lastFrequency + increase - decrease;
            }
        }

		public void GraphInit()
		{
			// Create a new graph
			//TODO: Allow graph to change size when widow is adjusted
			myPane = new ZedGraph.GraphPane(new Rectangle(0, 0, (int) Application.Current.MainWindow.Width, 325),
				"Allele Frequency\n",
				"Generations",
				"Frequency of A");

			myPane.XAxis.Max = generation.Value;
			myPane.XAxis.Min = 0;

			myPane.YAxis.Max = 1;
			myPane.YAxis.Min = 0;

			myPane.AxisChange(graphics);
		}

		private void GraphPanelOnInitialized(object sender, EventArgs eventArgs)
		{
			myPane = graphControl.GraphPane;
		}
	}
}
