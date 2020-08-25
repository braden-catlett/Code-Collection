using System;
using System.Data.SqlClient;
using System.Web.UI;

namespace BungieProgrammingTest
{
    public partial class Predicate : Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            Predicate<Byte[]> predicate = rowPredicate;
            int count = CountDBRows(predicate);
        }

        public bool rowPredicate(byte[] bytes)
        {
            //Current Predicate is return true if the largest non consecutive sum is larger than half the total sum
            //Check for empty or single element array
            if (bytes.Length <= 1)
                return false;

            int[] sum = new int[bytes.Length];
            int totalsum = bytes[0] + bytes[1];
            sum[0] = bytes[0];

            //If second element in array is larger than the first then include it in sum otherwise just add the first again
            if (bytes[1] > bytes[0])
                sum[1] = bytes[1];
            else
                sum[1] = bytes[0];
            //Go through array
	        for(int i = 2; i < bytes.Length; i++)
            {
                //Add to total sum
                totalsum += bytes[i];
                //if the last sum is greater than the second to last sum plus the current element then the greatest sum so far is the last sum
		        if(sum[i - 1] > bytes[i] + sum[i - 2])
			        sum[i] = sum[i - 1];
                //Else then change the current sum to the second to last sum plus the current element
		        else
			        sum[i] = bytes[i] + sum[i - 2];
	        }
            return sum[sum.Length - 1] > totalsum / 2;
        }

        public int CountDBRows(Predicate<byte[]> rowFilter)
        {
            int count = 0;
            //Build connection string to access database
            SqlConnectionStringBuilder builder = new SqlConnectionStringBuilder();
            builder.DataSource = "localhost\\sqlexpress";
            builder.InitialCatalog = "Blobs";
            builder.IntegratedSecurity = true;
            builder.ConnectTimeout = 3;

            using (SqlConnection con = new SqlConnection(builder.ConnectionString))
            {
                //The Try/Catch is primarily to prevent the page from crashing because it is trying to access a non existent server or database
                try
                {
                    //Open connection
                    con.Open();
                    //Set up query with connection
                    using (SqlCommand command = new SqlCommand("SELECT * FROM Blobs.dbo.blob", con))
                    {
                        //Execute and get data reader
                        using (SqlDataReader reader = command.ExecuteReader())
                        {
                            //If excution was successful
                            if (reader != null)
                            {
                                //Go through each row received
                                while (reader.Read())
                                {
                                    //Call the predicate on the byte are field of the row, if true then increment count
                                    if (rowFilter.Invoke((byte[])reader["blob"]))
                                        count++;
                                }
                            }
                        }
                    }
                }
                catch (SqlException)
                {
                    //SQL exception thrown, return 0
                    return 0;
                }
            }            
            return count;
        }
    }
}