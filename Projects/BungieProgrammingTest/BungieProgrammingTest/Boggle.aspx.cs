using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Web;
using System.Web.Caching;
using System.Web.Hosting;
using System.Web.UI;

namespace BungieProgrammingTest
{
    public partial class Boggle : Page
    {
        private static Dictionary<string, List<string>> DictTable = new Dictionary<string, List<string>>();
        private static Char[,] CharacterBoard;
        private int RowDimension;
        private int ColumnDimension;
        private static int min_word_size_limit = 3;

        protected void Page_Load(object sender, EventArgs e)
        {
            string dictionaryPath = HostingEnvironment.ApplicationPhysicalPath + "Content/corncob_caps.txt";
            GetFromCache(dictionaryPath, 12);
        }

        protected void SolveButton_Click(object sender, EventArgs e)
        {
            //If we have enough letters in the board then go ahead and solve it, otherwise display number of characters still needed
            if (LoadBoard())
                SolveBoard();
            else
            {
                int amountOff = RowDimension * ColumnDimension - BoardInputArea.Value.Count(x => Char.IsLetter(x));
                MessageLabel.Text = "Failed to load board. "
                                + ((amountOff > 0) ? amountOff.ToString() + " more" : (Math.Abs(amountOff)) + " less")
                                + " characters are needed";
            }
        }

        private bool LoadBoard()
        {
            //Get Dimensions
            RowDimension = Int32.Parse(FirstDimension.Value);
            ColumnDimension = Int32.Parse(SecondDimension.Value);
            //Get board data
            string boardInfo = BoardInputArea.Value;
            CharacterBoard = new Char[RowDimension, ColumnDimension];
            int RowIndex = 0;
            int ColumnIndex = 0;
            int wordIndex = 0;

            //Go through character input
            while (wordIndex < boardInfo.Length && RowIndex < RowDimension)
            {
                //Make sure ColumnIndex does not go outside array bounds
                if (ColumnIndex > ColumnDimension - 1)
                {
                    ColumnIndex = 0;
                    RowIndex++;
                }
                //We only want letters
                if (Char.IsLetter(boardInfo[wordIndex]) && RowIndex < RowDimension)
                {
                    //Assign letter to board
                    CharacterBoard[RowIndex, ColumnIndex] = Char.ToUpper(boardInfo[wordIndex]);
                    ColumnIndex++;
                }
                wordIndex++;
            }
            //If last position on board is filled then load was successful
            return CharacterBoard[RowDimension - 1, ColumnDimension - 1] != 0;
        }

        private void SolveBoard()
        {
            List<string> solutions = new List<string>();
            //Solve the board recursively with a starting point on each of the letters
            for (int i = 0; i < RowDimension; i++)
            {
                for (int k = 0; k < ColumnDimension; k++)
                {
                    SolveBoardRecursive(ref solutions, i, k, CharacterBoard);
                }
            }
            //Go through solutions and output found words
            string output = String.Empty;
            foreach (string item in solutions)
                output += item + ", ";
            MessageLabel.Text = output.Remove(output.Length - 2, 2);
        }

        private void SolveBoardRecursive(ref List<String> solutions, int Row, int Column, Char[,] Board, string currentWord = "")
        {
            //If indexes are within the dimensions of the board then continue
            if (Row >= 0 && Row < RowDimension && Column >= 0 && Column < ColumnDimension)
            {
                //Append new letter to currentWord string
                char valueholder = Board[Row, Column];
                currentWord += valueholder;
                //If word branch has the potential to yield words then continue
                if (IsValidWordBranch(currentWord))
                {
                    //If currentWord length is greater than the minimum word length
                    if (currentWord.Length >= min_word_size_limit)
                    {
                        //Key had been validated in IsValidWordBranch so grab it and use it to see if the dictionary contains it
                        string key = currentWord.Substring(0, min_word_size_limit);
                        if (DictTable[key].Contains(currentWord))
                        {
                            //If not already found then add it
                            if (!solutions.Contains(currentWord))
                                solutions.Add(currentWord);
                        }
                    }
                    //Continue solving using all the spots around the current position
                    for (int i = Row - 1; i <= Row + 1; i++)
                    {
                        for (int k = Column - 1; k <= Column + 1; k++)
                        {
                            if (i >= 0 && i < RowDimension && !(i == Row && k == Column) && k >= 0 && k < ColumnDimension && Board[i, k] != '*')
                            {
                                //Replace the current position with * to prevent coming back to it
                                Board[Row, Column] = '*';
                                SolveBoardRecursive(ref solutions, i, k, Board, currentWord);
                                //Place the original value back to the current position
                                Board[Row, Column] = valueholder;
                            }
                        }
                    }
                }
            }
        }

        private static void LoadDictionary(string dictionaryPath)
        {
            // Read in the contents of dictionaryPath
            string[] words = File.ReadAllLines(dictionaryPath);

            for (int wordIndex = 0; wordIndex < words.Length; wordIndex++)
            {
                if (words[wordIndex].Length >= min_word_size_limit)
                {
                    List<string> DictTableEntryList = null;

                    // Get the index_size word category
                    string dictIndex = words[wordIndex].Length < min_word_size_limit ? words[wordIndex] : words[wordIndex].Substring(0, min_word_size_limit).ToUpper();

                    // See if we have a DictEntry table for these category
                    if (!DictTable.ContainsKey(dictIndex))
                    {
                        //Could not find so add the category list
                        DictTableEntryList = new List<string>();
                        DictTable.Add(dictIndex, DictTableEntryList);
                    }
                    else
                    {
                        //Found it, grab the corresponding categorylist
                        DictTableEntryList = DictTable[dictIndex];
                    }
                    if (!DictTableEntryList.Contains(words[wordIndex].ToUpper()))
                        // Add the word to the category list
                        DictTableEntryList.Add(words[wordIndex].ToUpper());
                }
            }
        }

        public static void GetFromCache(string dictionaryPath, int minWordLen)
        {
            string CacheKey = dictionaryPath + "-" + "Dictionary";
            string LengthCacheKey = dictionaryPath + "-" + "DictionaryMaxWordLength";

            // See if the dictionary is in the cache
            DictTable = HttpContext.Current.Cache[CacheKey] as Dictionary<string, List<string>>;

            if (DictTable == null)
            {
                // Load dictionary
                DictTable = new Dictionary<string, List<string>>();
                LoadDictionary(dictionaryPath);

                // Cache dictionary
                HttpContext.Current.Cache.Insert(CacheKey, DictTable, new CacheDependency(dictionaryPath));
            }
        }

        private bool IsValidWordBranch(string currentWord)
        {
            //If below minimum length then its not yet valid but we want to keep going down the word branch so return true
            if (currentWord.Length < min_word_size_limit)
                return true;

            //Get key
            string key = currentWord.Substring(0, min_word_size_limit);
            //If dictionary contains key then go through each item in that word category's list and see if we have any potential matches
            if (DictTable.ContainsKey(key))
            {
                foreach (string item in DictTable[key])
                {
                    //If potential match is found then return true
                    if (item.Contains(currentWord))
                        return true;
                }
            }
            return false;
        }
    }
}