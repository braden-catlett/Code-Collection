using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace All_Pairs
{
    class Node : IComparable<Node>
    {
        public int[] Path;
        public int LowerBound;
        public List<Node> Children = new List<Node>();
        public Node Parent;
        public override bool Equals(object obj)
        {
            return (LowerBound == ((Node)obj).LowerBound);
        }
        public override int GetHashCode()
        {
            return base.GetHashCode();
        }
        public int CompareTo(Node obj)
        {
            if (LowerBound > ((Node)obj).LowerBound)
                return 1;
            else if (LowerBound == ((Node)obj).LowerBound)
                return 0;
            else
                return -1;
        }

    }
}
