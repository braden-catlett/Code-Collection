﻿//#define UseAP
#define IncludeRecCenter //TODO: remove rec center not only from first path but from being added in main code.
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;

namespace All_Pairs
{
    class Program
    {
        static PriorityQueue<Node> UncheckedNodes = new PriorityQueue<Node>();
        static int[,] Table;
        static Node BestNode;
        static bool IncRecCenter = false;
        static List<int> sorter = new List<int>();
        static void Main(string[] args)
        {
            int[] mainnodes = new int[20] { 1, 5, 6, 8, 9, 10, 17, 20, 38, 42, 34, 45, 56, 63, 70, 73, 61, 81, 82, 83 };
#if UseAP
            #region Read CVS (AP input)
#if IncludeRecCenter
            int [] First = new int[21]{12, 15, 14, 13, 11, 10, 19, 9, 16, 6, 1, 2, 0, 3, 4, 7, 5, 18, 17, 8, 12};
            IncRecCenter = true;
#else
            int [] First = new int[20]{12, 15, 14, 13, 11, 10, 19, 9, 16, 6, 1, 2, 3, 4, 7, 5, 18, 17, 8, 12};            
#endif
            int Infinity = 999999;
            int[,] table = new int[83, 83]; 
            int row = 0;
            using (StreamReader sr = new StreamReader("..\\..\\..\\All_Pairs.csv"))
            {
                while (!sr.EndOfStream)
                {
                    String[] line = sr.ReadLine().Split(',');
                    for (int i = 0; i < 83; i++)
                    {
                        if (line[i] == "0" && i != row)
                            table[row, i] = Infinity;
                        else
                            table[row, i] = Int32.Parse(line[i]);
                    }
                    row++;
                }
            }
            #endregion
            
            #region All Pairs
            for (int k = 0; k < 83; k++)
            {
                for (int i = 0; i < 83; i++)
                {
                    for (int j = 0; j < 83; j++)
                    {
                        table[i, j] = Math.Min(table[i, j], table[i, k] + table[k, j]);
                    }
                }
            }
            int[,] extractedtable = new int[20, 20];
            for (int i = 0; i < 20; i++)
            {
                for (int k = 0; k < 20; k++)
                {
                    extractedtable[i, k] = table[mainnodes[i] - 1, mainnodes[k] - 1];
                }
            }
            #endregion

#else
#if IncludeRecCenter
            int[] First = new int[21] { 12, 8, 17, 18, 5, 7, 4, 3, 0, 2, 1, 6, 9, 19, 10, 11, 15, 14, 16, 13, 12 };
            IncRecCenter = true;
#else
            int[] First = new int[20] { 12, 15, 14, 13, 11, 10, 19, 9, 16, 6, 1, 2, 3, 4, 7, 5, 18, 17, 8, 12 };
#endif
            int[,] extractedtable = new int[20, 20];
            #region Read CSV (Shortest path input)
            int row = 0;
            using (StreamReader sr = new StreamReader("..\\..\\..\\Google_Mail_Routes(Converted).csv"))
            {
                while (!sr.EndOfStream)
                {
                    String[] line = sr.ReadLine().Split(',');
                    for (int i = 0; i < extractedtable.GetLength(0); i++)
                    {
                        extractedtable[row, i] = Int32.Parse(line[i]);
                    }
                    row++;
                }
            }
            #endregion
#endif
            Table = extractedtable;
            int[] Path;
            BestNode = new Node();
            BestNode.Path = First;
            BestNode.LowerBound = ComputeCost(First);
            Console.WriteLine("Original Route Distance: " + ComputeCost(First));
            int cost = TSP(out Path);
            string path = String.Empty;
            foreach (int i in Path)
            {
                path += i + "->";
            }
            Console.WriteLine(path.Remove(path.Length - 2));
            Console.WriteLine("Cost = " + cost);
            Console.Read();
        }
        static int TSP(out int[] Path)
        {
            if (IncRecCenter)
                Path = new int[Table.GetLength(0) + 1];
            else
                Path = new int[Table.GetLength(0)];
            for (int i = 0; i < Path.Length; i++)
                Path[i] = -1;
            Path[0] = 12; //Start at Hub
            Path[Path.Length - 1] = 12; //End at Hub
            Node Head = new Node();
            Head.LowerBound = CalculateLowerBound(Path);
            Head.Path = Path;
            //UncheckedNodes.Enqueue(Head);
            //BranchAndBoundSequential();
            BranchAndBound(Head);
            Path = BestNode.Path;
            return ComputeCost(BestNode.Path);
        }

        static int CalculateLowerBound(int[] Path)
        {
            double SetLowerBound = 0;
            double CalculatedLowerBound = 0;
            int i = 0;
            int k = 0;
            for (; i < Path.Length; i++)
            {
                if ((i + 1) == Path.Length || Path[(i + 1)] == -1)
                    break;
                SetLowerBound += Table[Path[i], Path[i + 1]];
            }
            if (!IncRecCenter)
            {
                i = 1;
                k = 1;
            }
            else
            {
                i = 0;
                k = 0;
            }
            for (; i < Table.GetLength(0); i++)
            {
                if (Path.Contains(i))
                    continue;
                int smallest = int.MaxValue;
                int small = int.MaxValue; //2nd smallest
                for (; k < Table.GetLength(1); k++)
                {
                    if (i != k)
                    { //Dont want any pesky diagonals in there
                        if (Table[i, k] < smallest)
                        {
                            small = smallest;
                            smallest = Table[i, k];
                        }
                        else if (Table[i, k] < small)
                        {
                            small = Table[i, k];
                        }
                    }
                }

                if (!IncRecCenter)
                    k = 1;
                else
                    k = 0;
                CalculatedLowerBound += small + smallest;
            }
            return ((int)SetLowerBound + (int)Math.Ceiling(CalculatedLowerBound / 2.0));
        }
        static int ComputeCost(int[] Path) // Only for completed paths
        {
            /*0 1 - New Recreation Building
             *1 5 - Fieldhouse
             *2 6 - Aquatic Cen+ter
             *3 8 - Westminster
             *4 9 - Art Center
             *5 10 - Facilities
             *6 17 - Graves
             *7 20 - Schumacher
             *8 38 - Hendrick
             *9 42 - Mudd Chapel
             *10 34 - Lindamen
             *11 45 - Library
             *12 56 - Hub
             *13 63 - Dixon
             *14 70 - Cowles
             *15 73 - MchEachran
             *16 61 - Music Building
             *17 81 - Eric Johnston Science Center
             *18 82 - New Science Building
             *19 83 - Weyerhausener*/
            int cost = 0;
            for (int i = 0; i + 1 < Path.Length; i++)
            {
                cost += Table[Path[i], Path[i + 1]];
            }
            return cost;
        }
        static void GenerateChildren(Node Head, int[] Path)
        {
            int i = 0;
            if (!IncRecCenter)
                i = 1;
            for (; i < Table.GetLength(0); i++)
            {
                if (!Path.Contains(i))
                {
                    Node child = new Node();
                    child.Path = new int[Path.Length];
                    Path.CopyTo(child.Path, 0);
                    child.Path[GetFirstValidIndex(child.Path)] = i;
                    child.LowerBound = CalculateLowerBound(child.Path);
                    child.Parent = Head;
                    if(child.LowerBound <= BestNode.LowerBound)
                        Head.Children.Add(child);
                }
            }
        }
        static int GetFirstValidIndex(int[] Path)
        {
            for (int i = 0; i < Path.Length; i++)
                if (Path[i] == -1)
                    return i;
            return -1;
        }
        static void BranchAndBound(Node CurrentNode)
        {
            GenerateChildren(CurrentNode, CurrentNode.Path);
            if (CurrentNode.Children.Count == 1 && GetFirstValidIndex(CurrentNode.Children[0].Path) == -1) // Base case, full path
            {
                if (ComputeCost(CurrentNode.Children[0].Path) < BestNode.LowerBound)
                {
                    CurrentNode.Children[0].LowerBound = ComputeCost(CurrentNode.Children[0].Path);
                    BestNode = CurrentNode.Children[0];
                    string path = String.Empty;
                    foreach (int i in BestNode.Path)
                    {
                        path += i + "->";
                    }
                    Console.WriteLine(path.Remove(path.Length - 2));
                    Console.WriteLine(ComputeCost(BestNode.Path));
                    return;
                }
                return;
            }
            //This separates levels. TODO: We need to compare all of the possible nodes to each other, 
            //including ones on previous levels, and choose the best one to do each time.
            CurrentNode.Children.Sort();
            foreach (Node child in CurrentNode.Children)
            {
                if (child.LowerBound < BestNode.LowerBound)
                    BranchAndBound(child);
            }
            PruneChildren(ref CurrentNode);
        }
        static void BranchAndBoundSequential()
        {
            int numPathsCompleted = 0;
            while (UncheckedNodes.Peek().LowerBound < BestNode.LowerBound)
            {
                //Pop lowest priority from list
                Node CurrentNode = UncheckedNodes.Dequeue();

                //Generate children for current node.
                GenerateChildren(CurrentNode, CurrentNode.Path);
                if (CurrentNode.Children.Count == 1)
                { // full path; compare to best node and reassign if neccessary
                    numPathsCompleted++;
                    if (ComputeCost(CurrentNode.Children[0].Path) < BestNode.LowerBound)
                    {
                        BestNode = CurrentNode.Children[0];
                        string path = String.Empty;
                        foreach (int i in BestNode.Path)
                        {
                            path += i + "->";
                        }
                        Console.WriteLine(path.Remove(path.Length - 2));
                        Console.WriteLine(ComputeCost(BestNode.Path));
                    }
                    System.Console.WriteLine(numPathsCompleted);

                    continue;
                }
                else
                {
                    //Add children that have better lbs than the current best to the queue.
                    foreach (Node child in CurrentNode.Children)
                    {
                        if (BestNode.LowerBound > child.LowerBound)
                        {
                            UncheckedNodes.Enqueue(child);
                        }
                    }
                }
            }
        }
        static void PruneChildren(ref Node child)
        {
            List<Node> Executioner = new List<Node>();
            foreach (Node kid in child.Children)
                if (kid != BestNode)
                    Executioner.Add(kid);
            foreach (Node exe in Executioner)
                child.Children.Remove(exe);
        }
    }
}