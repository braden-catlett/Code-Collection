using System;
using System.Windows;
using System.Windows.Controls;

namespace AlleleFrequencySim
{
	/// <summary>
	/// Interaction logic for SlideText.xaml
	/// </summary>
	public partial class SlideText : UserControl
	{
		private int conversion = 1;

		private bool isInt = true;

		public SlideText()
		{
			InitializeComponent();
		}


		#region Properties
		/// <summary>
		/// The conversion factor for the value of the slider
		/// </summary>
		public int Conversion
		{
			get
			{
				return conversion;
			}

			set
			{
				conversion = value;
			}
		}

		/// <summary>
		/// Signifies if the value of the slider can only be an integer
		/// </summary>
		public bool IsInt
		{
			get
			{
				return isInt;
			}

			set
			{
				isInt = value;
			}
		}

		/// <summary>
		/// Signifies if the TextBox is read only
		/// </summary>
		public bool IsReadOnly
		{
			get
			{
				return textBox.IsReadOnly;
			}

			set
			{
				textBox.IsReadOnly = value;

				if (textBox.IsReadOnly)
				{
					textBox.Text = "10^" + sliderBar.Value.ToString();
					minLabel.Content = "10^" + sliderBar.Minimum.ToString();
					maxLabel.Content = "10^" + sliderBar.Maximum.ToString();
				}
			}
		}

		/// <summary>
		/// Sets and gets whether to display a checkbox below the slider
		/// </summary>
		public bool ContainsCheckBox { get; set; }

		/// <summary>
		/// Sets and gets the text to display next to the checkbox
		/// </summary>
		public string CheckBoxText { get; set; }

		/// <summary>
		/// Gets the CheckBoxIsChecked property of the checkbox
		/// </summary>
		public bool CheckBoxIsChecked
		{
			get
			{
				return sliderCheckBox.IsChecked != null && (bool) sliderCheckBox.IsChecked;
			}
		}

		/// <summary>
		/// Sets and gets the maximum value of the slider bar
		/// </summary>
		public int Maximum
		{
			get
			{
				return (int) sliderBar.Maximum;
			}

			set
			{
				sliderBar.Maximum = value;
				if (isInt)
				{
					sliderBar.Value = (int) (sliderBar.Maximum + sliderBar.Minimum) / 2;
				}
				else
				{
					sliderBar.Value = (sliderBar.Maximum + sliderBar.Minimum) / 2;
				}
				maxLabel.Content = (value / conversion).ToString();
			}
		}
		/// <summary>
		/// Sets and gets the minimum value of the slider bar
		/// </summary>
		public int Minimum
		{
			get
			{
				return (int) sliderBar.Minimum;
			}

			set
			{
				sliderBar.Minimum = value;
				sliderBar.Value = (sliderBar.Maximum + sliderBar.Minimum) / 2;
				minLabel.Content = (value / conversion).ToString();
			}
		}

		/// <summary>
		/// Gets and sets the text of the control
		/// </summary>
		public string Text
		{
			get
			{
				return nameLabel.Text;
			}

			set
			{
				nameLabel.Text = value;
			}
		}

		/// <summary>
		/// Sets and gets the TickFrequency of a slider bar
		/// </summary>
		public double TickFrequency
		{
			get
			{
				return sliderBar.TickFrequency;
			}

			set
			{
				sliderBar.TickFrequency = value;
			}
		}

		/// <summary>
		/// Overrides the default starting location of the slider bar.
		/// Default is (Min + Max)/2
		/// </summary>
		public int StartValue
		{
			set
			{
				sliderBar.Value = value;
				textBox.Text = value.ToString();
			}
		}

		/// <summary>
		/// Returns the current value of the slider
		/// </summary>
		public double Value
		{
			get
			{
				if (textBox.IsReadOnly)
				{
					return Convert.ToDouble(Math.Pow(10, sliderBar.Value));
				}
				else
				{
					return Convert.ToDouble(textBox.Text);
				}
			}
		}
		#endregion

		#region Events
		/// <summary>
		/// Changes the information in the textbox when the slider bar changes
		/// </summary>
		/// <param name="o"></param>
		/// <param name="e"></param>
		private void SliderBarValueChanged(object sender, RoutedPropertyChangedEventArgs<double> routedPropertyChangedEventArgs)
		{
			if (textBox.IsReadOnly)
			{
				textBox.Text = "10^" + sliderBar.Value;
			}
			else
			{
				textBox.Text = (((double)sliderBar.Value) / ((double)conversion)).ToString();
			}
		}
		/// <summary>
		/// Changes the information in the slider bar when the textbox changes
		/// </summary>
		/// <param name="o"></param>
		/// <param name="e"></param>
		private void TextBoxChanged(object o, EventArgs e)
		{
			sliderBar.IsEnabled = false;

			double newValue = 0;

			try
			{
				// if the text box is readonly, use the sliderbar's value or it will make the entire slide text readonly
				newValue = IsReadOnly ? sliderBar.Value : double.Parse(textBox.Text);
			}
			catch (Exception excep)
			{
					newValue = (sliderBar.Maximum + sliderBar.Minimum) / 2;
			}

			if (isInt)
			{
				newValue = (int)newValue;
			}

			if (textBox.IsReadOnly)
			{
				textBox.Text = "10^" + newValue.ToString();
			}
			else
			{
				textBox.Text = newValue.ToString();
			}

			if (newValue > sliderBar.Maximum)
			{
				sliderBar.Value = sliderBar.Maximum;
				textBox.Text = sliderBar.Maximum.ToString();
			}
			else if (newValue < sliderBar.Minimum)
			{
				sliderBar.Value = sliderBar.Minimum;
				textBox.Text = sliderBar.Minimum.ToString();
			}

			sliderBar.Value = newValue;

			sliderBar.IsEnabled = true;
		}
		#endregion
	}
}
