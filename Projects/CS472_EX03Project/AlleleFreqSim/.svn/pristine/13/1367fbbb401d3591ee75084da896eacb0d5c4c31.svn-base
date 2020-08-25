using System.ComponentModel;
using System.Windows;

namespace AlleleFrequencySim
{
	/// <summary>
	/// Interaction logic for MainWindow.xaml
	/// </summary>
	public partial class MainWindow : Window
	{
		public MainWindow()
		{
			InitializeComponent();
		}

		private void ExitOnClick(object sender, RoutedEventArgs routedEventArgs)
		{
			Application.Current.Shutdown(0);
		}

		private void MainWindowOnClosing(object sender, CancelEventArgs e)
		{
			// kind of a hack to make sure the process is fully ended when the window is closed
			Application.Current.Shutdown(0);
		}

		private void ExternPopClick(object sender, RoutedEventArgs routedEventArgs)
		{
			App.externPopForm.Visibility = Visibility.Visible;
			App.externPopForm.Focus();
		}

		private void AboutClick(object sender, RoutedEventArgs routedEventArgs)
		{
			MessageBox.Show("Allele Frequency Sim\n\nCopyright © 2005\n\nCreated by:\nBrenna Hutton\nMatthew Klump\nJordan Welsh", "About Allele Frequency Sim");
		}

		private void GoButtonOnClick(object sender, RoutedEventArgs routedEventArgs)
		{
			// draw the graph(s); see comment in MainWindow.xaml for how to add another GraphPanel
			graphPanel1.DrawGraph();
			if (ShowSecondGraph.IsChecked)
				graphPanel2.DrawGraph();
		}
	}
}
