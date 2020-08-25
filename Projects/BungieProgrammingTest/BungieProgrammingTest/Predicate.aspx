<%@ Page Title="Predicate" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Predicate.aspx.cs" Inherits="BungieProgrammingTest.Predicate" %>

<asp:Content runat="server" ID="BodyContent" ContentPlaceHolderID="MainContent">

    <section class="featured">
        <div class="content-wrapper">
            <hgroup class="title">
                <h1>Predicate</h1>
            </hgroup>
            <p>
                Write a C# function which takes one parameter, of type Predicate(byte[]), which reads from a SQL database table. 
                The table contains a primary key called id of type int, and a field called blob of type binary(200).
                Your function should return a number which specifies for how many rows of the database the user-supplied predicate
                is true.<br /><br />

	            int CountDBRows(Predicate(byte[]) rowFilter)<br />
	            {<br />
		            // do work here<br />
	            }<br />
            </p>
            <h3>Assumptions:</h3>
            <ol>
                <li>The SQL connection is connecting to a SQL Server database, easily changed through</li>
            </ol>
        </div>
        <h2>My CountDBRows function: </h2>
        <p>
        public int CountDBRows(Predicate<byte[]> rowFilter)<br />
        {<br />
            &emsp;int count = 0;<br />
            &emsp;SqlConnectionStringBuilder builder = new SqlConnectionStringBuilder();<br />
            &emsp;builder.DataSource = "localhost\\sqlexpress";<br />
            &emsp;builder.InitialCatalog = "Blobs";<br />
            &emsp;builder.IntegratedSecurity = true;<br />
            &emsp;builder.ConnectTimeout = 3;<br />
            &emsp;using (SqlConnection con = new SqlConnection(builder.ConnectionString))<br />
            &emsp;{<br />
                &emsp;&emsp;con.Open();<br />
                &emsp;&emsp;using (SqlCommand command = new SqlCommand("SELECT * FROM BLOB", con))<br />
                &emsp;&emsp;{<br />
                    &emsp;&emsp;&emsp;using (SqlDataReader reader = command.ExecuteReader())<br />
                    &emsp;&emsp;&emsp;{<br />
                        &emsp;&emsp;&emsp;&emsp;if (reader != null)<br />
                        &emsp;&emsp;&emsp;&emsp;{<br />
                           &emsp;&emsp;&emsp;&emsp;&emsp;while (reader.Read())<br />
                            &emsp;&emsp;&emsp;&emsp;&emsp;{<br />
                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;if (rowFilter.Invoke((byte[])reader["blob"]))<br />
                                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;count++;<br />
                            &emsp;&emsp;&emsp;&emsp;&emsp;}<br />
                        &emsp;&emsp;&emsp;&emsp;}<br />
                    &emsp;&emsp;&emsp;}<br />
                &emsp;&emsp;}<br />
            &emsp;}<br />   
            &emsp;return count;<br />
        }<br />
        </p>
        <h2>Requested Predicate: </h2>
        <p>I spent a good long while thinking of a good predicate that would serve as an interesting interview question since I wanted to create a</p>
        <p>challenging problem and one that would require a unique way of thinking to solve. Since I find dynamic programming intriquing,</p>
        <p>I decided to implement a "find the largest non-consectutive sum" problem. This dymanic programming problem by itself would not </p>
        <p>produce the boolean return value required by the function so I added the comparion of the found largest non-consectutive sum</p>
        <p>to half the total value of the array of bytes.</p>
        <p>
        public bool rowPredicate(byte[] bytes)<br />
        {<br />
            &emsp;//Current Predicate is return true if the largest non consecutive sum is larger than half the total sum<br />
            &emsp;//Check for empty or single element array<br />
            &emsp;if (bytes.Length <= 1)<br />
                &emsp;&emsp;return false;<br /><br />

            &emsp;int[] sum = new int[bytes.Length];<br />
            &emsp;int totalsum = bytes[0] + bytes[1];<br />
	        &emsp;sum[0] = bytes[0];<br /><br />

            &emsp;//If second element in array is larger than the first then include it in sum otherwise just add the first again<br />
	        &emsp;if(bytes[1] > bytes[0])<br />
		        &emsp;&emsp;sum[1] = bytes[1];<br />
	        &emsp;<br />
	        &emsp;else<br />
		        &emsp;&emsp;sum[1] = bytes[0];<br />
	        &emsp;<br />
            &emsp;//Go through array<br />
	        &emsp;for(int i = 2; i < bytes.Length; i++)<br />
            &emsp;{<br />
               &emsp;&emsp; //Add to total sum<br />
               &emsp;&emsp; totalsum += bytes[i];<br />
                &emsp;&emsp;//if the last sum is greater than the second to last sum plus the current element then the greatest sum so far is the last sum<br />
		        &emsp;&emsp;if(sum[i - 1] > bytes[i] + sum[i - 2])<br />
			        &emsp;&emsp;&emsp;sum[i] = sum[i - 1];<br />
                &emsp;&emsp;//Else then change the current sum to the second to last sum plus the current element<br />
		        &emsp;&emsp;else<br />
			        &emsp;&emsp;&emsp;sum[i] = bytes[i] + sum[i - 2];<br />
	        &emsp;}<br />
            &emsp;return sum[sum.Length - 1] > totalsum / 2;<br />
        }<br />
        </p>
    </section>
</asp:Content>
