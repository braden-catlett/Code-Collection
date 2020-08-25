using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Threading;

namespace FormsToying
{
    public partial class Form1 : Form
    {
        public Random r = new Random();
        public Form1()
        {
            InitializeComponent();
            this.BackColor = Color.MediumPurple;
        }
        private void label1_Click(object sender, EventArgs e)
        {
        }
        private void button1_Click(object sender, EventArgs e)
        {
            linkLabel1.Visible = true;
            Thread t = new Thread(changeColor);
            t.Start();            
        }

        private void linkLabel1_LinkClicked(object sender, LinkLabelLinkClickedEventArgs e)
        {
            System.Diagnostics.Process.Start("http://us.cdn3.123rf.com/168nwm/elde/elde1007/elde100700100/7454025-abstract-floral-heart-with-place-for-your-text.jpg");
        }

        public void changeColor()
        {
            try
            {
                while (!this.IsDisposed)
                {
                    int red = r.Next(0, 255);
                    int green = r.Next(0, 255);
                    int blue = r.Next(0, 255);
                    label1.ForeColor = Color.FromArgb(red, green, blue);
                }
            }
            catch (Exception e)
            {
                System.Console.Out.Write(e.Message);
            }
        }
    }
}
