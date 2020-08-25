<%@ Page Title="Boggle Solver" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="Boggle.aspx.cs" Inherits="BungieProgrammingTest.Boggle" %>

<asp:Content runat="server" ID="BodyContent" ContentPlaceHolderID="MainContent">

    <section class="featured">
        <div class="content-wrapper">
            <hgroup class="title">
                <h1>Boggle Solver</h1>
                <h2></h2>
            </hgroup>

            <p>
                Write a function which will find all the words on a generalized Boggle™ board.  
                The function should take as input the board dimensions and the board, and the server should
                load a dictionary of valid words (shared for all users). It should output the list of all found words.
                You should consider how your approach will perform with a large dictionary and a large board.<br />
                <br />

                If you've never heard of Boggle then see http://en.wikipedia.org/wiki/Boggle for a better description than I can write.
                A 3x3 boggle board that looks like this:<br />
                <br />

                y o x<br />
                r b a<br />
                v e d<br />
                <br />

                Has exactly the following words on it (according to my program):<br />
                <br />

                bred, yore, byre, abed, oread, bore, orby, robed, broad, byroad, robe<br />
                bored, derby, bade, aero, read, orbed, verb, aery, bead, bread, very, road<br />
                <br />

                Note that it doesn't have “robbed” or “robber” because that would require reusing some letters to form the word.
          And it doesn’t have “board” or “dove” because that would require using letters which aren’t neighbors.<br />
            </p>
            <h2>Assumptions:</h2>
            <ol>
                <li>All letters in the board are english</li>
                <li>The minimum length for a valid word is 3 characters</li>
            </ol>
        </div>
    </section>
    <section class="main-content">
        <div>
            <asp:Label ID="BoardDimensions" runat="server">Board Dimensions:</asp:Label><br />
            <input ID="FirstDimension"  type="number" min="0" runat="server"/>
            <asp:Label ID="by" runat="server">by</asp:Label>
            <input ID="SecondDimension" type="number" min="0" runat="server"/>
            <asp:Button ID="SolveButton" runat="server" Text="Solve" OnClick="SolveButton_Click" />
        </div>
        <div>
            <asp:Label ID="Board" runat="server">Board:</asp:Label><br />
            <textarea id="BoardInputArea" wrap="hard" runat="server" onkeypress=""></textarea>
        </div>
        <div>
            <asp:Label ID="MessageLabel" runat="server" Text=""></asp:Label>
        </div>
    </section>
</asp:Content>
