using System.ComponentModel;
using System.Windows;

namespace AlleleFrequencySim
{
	/// <summary>
	/// Interaction logic for ExternPopForm.xaml
	/// </summary>
	public partial class ExternPopForm : Window
	{
		/// <summary>
		/// Signifies if the External Population Settings are to be used in the calculations.
		/// </summary>
		public bool enabled
		{
			get { return EnableExternPop.IsChecked != null && (bool) EnableExternPop.IsChecked; }
		}

		public ExternPopForm()
		{
			InitializeComponent();
		}

		/// <summary>
		/// Hides the window, but keeps it alive so that settings can still be pulled from it.
		/// </summary>
		/// <param name="sender"></param>
		/// <param name="e"></param>
		private void ExternPopForm_OnClosing(object sender, CancelEventArgs e)
		{
			if (sender is ExternPopForm)
			{
				e.Cancel = true;
				Visibility = Visibility.Collapsed;
				Application.Current.MainWindow.Focus();
			}
		}
	}
}
