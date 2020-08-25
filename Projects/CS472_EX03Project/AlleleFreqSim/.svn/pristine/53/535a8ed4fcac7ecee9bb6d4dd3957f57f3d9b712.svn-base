using System;
using System.Windows.Forms;

namespace AlleleFrequencySim
{
	/// <summary>
	/// A hybrid slide bar and textbox that each represent the same value in their unique format.
	/// </summary>
	public class SlideText : System.Windows.Forms.UserControl
	{
		#region Variables
		/// <summary>
		/// Required by VS .NET
		/// </summary>
		private System.ComponentModel.Container components = null;

		/// <summary>
		/// The slide bar part of the control
		/// </summary>
		private System.Windows.Forms.TrackBar sliderBar;

		/// <summary>
		/// The textbox part of the control
		/// </summary>
		private System.Windows.Forms.TextBox textBox;

		/// <summary>
		/// The label that shows the maximum value of the slider bar
		/// </summary>
		private System.Windows.Forms.Label maxLabel;

		/// <summary>
		/// The label that shows the minimum value of the slider bar
		/// </summary>
		private System.Windows.Forms.Label minLabel;

		/// <summary>
		/// The label that tells the name the control maps to.
		/// </summary>
		private System.Windows.Forms.Label nameLabel;

		private int conversion = 1;

		private bool isInt = true;
		#endregion

		#region Functions
		/// <summary>
		/// The constructor
		/// </summary>
		public SlideText()
		{	
			#region sliderBar Initialization
			sliderBar = new TrackBar();
			sliderBar.Orientation = System.Windows.Forms.Orientation.Vertical;
			sliderBar.Size = new System.Drawing.Size(45, 112);
			sliderBar.Minimum = 1;
			sliderBar.Maximum = 10;
			sliderBar.ValueChanged += new EventHandler(sliderBarChanged);
			sliderBar.Visible = true;
			#endregion

			#region textBox Initialization
			textBox = new TextBox();
			textBox.Location = new System.Drawing.Point(this.Location.X,sliderBar.Size.Height);
			textBox.Size = new System.Drawing.Size(40,25);
			textBox.Text = sliderBar.Value.ToString();
			textBox.LostFocus += new EventHandler(textBoxChanged);
			textBox.Visible = true;
			#endregion

			#region maxLabel Initialization
			maxLabel = new Label();
			maxLabel.Location = new System.Drawing.Point(this.Location.X+34,this.Location.Y);
			maxLabel.Text = (sliderBar.Maximum/conversion).ToString();
			#endregion

			#region minLabel Initialization
			minLabel = new Label();
			minLabel.Location = new System.Drawing.Point(this.Location.X+34,this.Location.Y+95);
			minLabel.Size = new System.Drawing.Size(32, 12);
			minLabel.Text = (sliderBar.Minimum/conversion).ToString();
			#endregion

			#region nameLabel Initialization
			nameLabel = new Label();
			nameLabel.Location = new System.Drawing.Point(this.Location.X,this.sliderBar.Height+this.textBox.Height);
			nameLabel.Size = new System.Drawing.Size(48, 40);
			#endregion

			this.Controls.Add(maxLabel);
			this.Controls.Add(minLabel);
			this.Controls.Add(nameLabel);
			this.Controls.Add(sliderBar);
			this.Controls.Add(textBox);
			this.Size = new System.Drawing.Size(64, 176);
		}
		#endregion

		#region Properties
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
		public bool IsReadOnly
		{
			get
			{
				return textBox.ReadOnly;
			}

			set
			{
				textBox.ReadOnly = value;

				if(textBox.ReadOnly)
				{
					textBox.Text = "10^" + sliderBar.Value.ToString();
					minLabel.Text = "10^" + sliderBar.Minimum.ToString();
					maxLabel.Text = "10^" + sliderBar.Maximum.ToString();
				}
			}
		}
		/// <summary>
		/// Sets and gets the maximum value of the slider bar
		/// </summary>
		public int Maximum
		{
			get
			{
				return sliderBar.Maximum;
			}

			set
			{
				sliderBar.Maximum = value;
				sliderBar.Value = (sliderBar.Maximum+sliderBar.Minimum)/2;
				maxLabel.Text = (value/conversion).ToString();
			}
		}
		/// <summary>
		/// Sets and gets the minimum value of the slider bar
		/// </summary>
		public int Minimum
		{
			get
			{
				return sliderBar.Minimum;
			}

			set
			{
				sliderBar.Minimum = value;
				sliderBar.Value = (sliderBar.Maximum+sliderBar.Minimum)/2;
				minLabel.Text = (value/conversion).ToString();
			}
		}
		/// <summary>
		/// Gets and sets the text of the control
		/// </summary>
		public override string Text
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
		public int TickFrequency
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

		public double Value
		{
			get
			{
				if(textBox.ReadOnly)
				{
					return Convert.ToDouble(Math.Pow(10,sliderBar.Value));
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
		private void sliderBarChanged(object o, EventArgs e)
		{
			if(textBox.ReadOnly)
			{
				textBox.Text = "10^" + sliderBar.Value.ToString();
			}
			else
			{
				textBox.Text = (((double)sliderBar.Value)/((double)conversion)).ToString();
			}
		}
		/// <summary>
		/// Changes the information in the slider bar when the textbox changes
		/// </summary>
		/// <param name="o"></param>
		/// <param name="e"></param>
		private void textBoxChanged(object o, EventArgs e)
		{
			this.sliderBar.ValueChanged -= new EventHandler(sliderBarChanged);

			double newValue = 0;
				
			try
			{
				newValue = Convert.ToDouble(textBox.Text);
			}
			catch(Exception excep)
			{
				newValue = (sliderBar.Maximum+sliderBar.Minimum)/2;
				newValue = newValue/conversion;
			}

			if(isInt)
			{
				newValue = (int)newValue;
			}
			else
			{
				int temp = (int)(newValue * conversion);
				newValue = ((double)temp) / conversion;
			}

			if(this.IsReadOnly)
			{
				textBox.Text = "10^" + newValue.ToString();				
			}
			else
			{
				textBox.Text = newValue.ToString();
			}

			try
			{
				 sliderBar.Value = (int)(newValue*conversion);
			}
			catch(ArgumentException Argxcep)
			{
				if(newValue > sliderBar.Maximum)
				{
					sliderBar.Value = (int)sliderBar.Maximum*conversion;
					textBox.Text = sliderBar.Maximum.ToString();
				}
				else
				{
					sliderBar.Value = (int)sliderBar.Minimum*conversion;
					textBox.Text = sliderBar.Minimum.ToString();
				}
			}

			this.sliderBar.ValueChanged += new EventHandler(sliderBarChanged);
		}
		#endregion
	}
}
