using System;
using System.Text;
using System.Web.UI;

namespace BungieProgrammingTest
{

    public partial class _Default : Page
    {
        public static int ListLength = 0;

        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void SubmitButton_Click(object sender, EventArgs e)
        {
            if (String.IsNullOrEmpty(ListLengthInput.Value) || ListLengthInput.Value.CompareTo("0") == 0)
                return;

            //Get Length of list to initially create
            ListLength = Int32.Parse(ListLengthInput.Value);

            //Assuming negative length lists are not allowed
            if (ListLength < 0)
            {
                OutputLabel.Text = "A Positive Length is required to generate a list";
                return;
            }

            //Create the initial list using a loop and random number generator to generate nodes
            //Keep one node as head and another to follow the end of the list
            node head = new node();
            head.tag = "0";
            node end = head;
            for (int i = 1; i < ListLength; i++)
            {
                end.next = new node();
                end = end.next;
                end.tag = i.ToString();
            }

            //Assign each node a random node as a reference
            node temp = head;
            Random random = new Random();
            for (int k = 0; k < ListLength; k++)
            {
                node reference_node = head;
                int random_index = random.Next(ListLength);
                for (int i = 0; i < random_index; i++)
                {
                    reference_node = reference_node.next;
                }
                temp.reference = reference_node;
                temp = temp.next;
            }

            //Call dublicate list with the head node of generated list
            node dublist = node.duplicateList(head);
            StringBuilder oldlist = new StringBuilder();
            StringBuilder newlist = new StringBuilder();
            while (dublist != null)
            {
                oldlist.Append("[" + head.tag + " : " + head.reference.tag + "] ");
                newlist.Append("[" + dublist.tag + " : " + dublist.reference.tag + "] ");
                dublist = dublist.next;
                head = head.next;
            }
            //Output evidence of the generated list and copied list
            OutputLabel.Text = "<br />Generated List: " + oldlist.ToString().Trim() + " <br /><br />    Copied List: " + newlist.ToString().Trim();
        }
        public class node
        {
            public node next;
            public string tag;
            public node reference;

            public node()
            {
                next = null;
                tag = String.Empty;
                reference = null;
            }

            public static node duplicateList(node list)
            {
                node templist = list;
                node newhead = new node();
                node temphead = newhead;
                temphead.tag = "0";

                //Create new list with the same length as the first one
                for (int i = 1; i < ListLength; i++)
                {
                    temphead.next = new node();
                    temphead = temphead.next;
                    temphead.tag = i.ToString();
                    templist = templist.next;
                }

                temphead = newhead;
                templist = list;

                //Go through and set the reference node to the node within the list at the same position 
                //as the reference node in the first list
                for (int i = 0; i < ListLength; i++)
                {
                    node reference_node = list;
                    int index = Int32.Parse(templist.reference.tag);
                    for (int k = 0; k < index; k++)
                    {
                        reference_node = reference_node.next;
                    }
                    temphead.reference = reference_node;
                    temphead = temphead.next;
                    templist = templist.next;
                }
                return newhead;
            }
        }
    }
}