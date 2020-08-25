using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace dynamic
{
    class Program
    {
        static void Main(string[] args)
        {
            int[] items = new int[] { 1, -4, 1, 6, -2, 4, -6, 1, -4, 9 };
            int[] sum = new int[items.Length];
            sum[0] = items[0];
            if (items[1] >= 0)
                sum[1] = items[1];
            else
                sum[1] = items[0];
            for (int i = 2; i < items.Length; i++)
            {
                if (sum[i - 1] > sum[i - 1] + items[i])
                    sum[i] = 0;
                else
                    sum[i] = sum[i - 1] + items[i];
            }
            Console.WriteLine("Sum Found: " + sum[sum.Length - 1]);

            int[] values = { 1, 2, 3, 2, 4 };
            int[] weights = { 6, 6, 6, 6, 5 };
            int[,] grid = new int[weights.Length + 1, values.Length + 1];

            for (int i = 1; i < weights.Length + 1; i++)
            {
                for (int k = 1; k < values.Length + 1; k++)
                {
                    grid[i, k] = -1;
                }
            }
            int r = knapshack(grid, values, weights, 5, 5);
            Console.WriteLine("Sum Found: " + r);

            string data = "true and false or true";
            int c = booleanexpressions(data.Split(' '));
            Console.WriteLine(data + ", Number of ways: " + c);

            int length = findlargestIncreasingSequence(new int[] { 9, 8, 7, 6, 5, 4, 4, 5, 6, 7, 8, 9, 10 });
            Console.WriteLine("Largest Sequence: " + length);
            Console.Read();
        }
        static int findlargestIncreasingSequence(int[] items)
        {
            int[] sum = new int[items.Length];
            sum[0] = 1;
            for (int i = 1; i + 1 < items.Length; i++)
            {
                if (items[i - 1] < items[i])
                    sum[i] = sum[i - 1] + 1;
            }
            return sum.Max();
        }
        static int booleanexpressions(string[] exp)
        {
            int n = exp.Length;
            int[,] trues = new int[n, n];
            for (int t = 0; t < n; t++)
            {
                for (int w = 0; w < n; w++)
                {
                    trues[t, w] = -1;
                }
            }
            int j = n;
            for (int l = 0; l < j; l = l + 2)
            {
                for (int i = l + 2; i < j; i = i + 2)
                {
                    // here we have different string varying from 2 to n starting from i and ending at j
                    int k = i - 1;
                    // (l,k-1) is left part
                    // (k+1, i) is right part
                    if (l == k - 1 && trues[l, k - 1] == -1)
                    {
                        if (exp[l] == "true")
                            trues[l, k - 1] = 1;
                        else
                            trues[l, k - 1] = 0;
                    }
                    if (k + 1 == i && trues[k + 1, i] == -1)
                    {
                        if (exp[i] == "true")
                            trues[k + 1, i] = 1;
                        else
                            trues[k + 1, i] = 0;
                    }
                    switch (exp[k])
                    {
                        case "and":  // calculate, update array m
                            trues[l, i] = trues[l, k - 1] * trues[k + 1, i];
                            break;
                        case "or":  // same
                            trues[l, i] = (trues[l, k - 1] + trues[k + 1, i] >= 1) ? 1 : 0;
                            break;
                        case "xor":
                            bool left = trues[l, k - 1] == 1 ? true : false;
                            bool right = trues[k + 1, i] == 1 ? true : false;
                            trues[l, i] = left ^ right ? 1 : 0;
                            break;
                    }
                }
            }
            int count = 0;
            for (int i = 0; i < n - 1; i++)
            {
                count += trues[i, n - 1] >= 0 ? trues[i, n - 1] : 0;
            }
            return count;
        }
        static int knapshack(int[,] grid, int[] values, int[] weights, int capacity, int item)
        {
            if (capacity <= 0)
                return grid[0, item];
            if (grid[capacity, item] == -1)
                grid[capacity, item] = Math.Max(knapshack(grid, values, weights, capacity - weights[item - 1], item - 1) + values[item - 1], knapshack(grid, values, weights, capacity, item - 1));
            return grid[capacity, item];
        }
    }
}
