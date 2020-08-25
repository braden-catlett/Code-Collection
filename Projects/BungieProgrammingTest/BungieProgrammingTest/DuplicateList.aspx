<%@ Page Title="Bungie Programming Test - Dublicate List" Language="C#" MasterPageFile="~/Site.Master" AutoEventWireup="true" CodeBehind="DuplicateList.aspx.cs" Inherits="BungieProgrammingTest._Default" %>

<asp:Content runat="server" ID="FeaturedContent" ContentPlaceHolderID="FeaturedContent">
    <section class="featured">
        <div class="content-wrapper">
            <hgroup class="title">
                <h2>Dublicate List</h2>
            </hgroup>
            <p>
                Write the following function using an algorithm which is as time and space constrained as possible.  
                For example, an O(n) time algorithm with O(1) additional space requirement would be better than an O(n^2) 
                time algorithm with O(n) space requirement.  You may modify the input provided that it is restored before your function completes. 
                Please note that the output list must follow normal linked list semantics – in particular, nodes must be individually allocated.<br /><br />

                public static node duplicateList(node list) { }<br />
                //<br />
                // input: a singly linked list that contains references to random nodes within the list<br />
                // output: a duplicate copy of the list with no dependency on the original<br /><br />

                Your web application need only receive as input the length of the initial list to create and then duplicate. It should use the tag only to output sufficient evidence that it created a valid initial list and its copy.<br />
            </p>
            <h2>Assumptions:</h2>
            <ol>
                <li>I am able to place the nodes into another structure as long as they follow normal linked list semantics</li>
                <li>Defining sufficient evidence that both lists have been created as listing each the tags of each node and its reference node from each list</li>
            </ol>
        </div>
    </section>
</asp:Content>
<asp:Content runat="server" ID="BodyContent" ContentPlaceHolderID="MainContent">
    <h3>Length of Your List: <input type="number" min="0" id="ListLengthInput" runat="server" /> <asp:Button ID="SubmitButton" OnClick="SubmitButton_Click" runat="server" Text="Submit"/></h3>
    
    <h3>Output [tag, ref.tag]: <asp:Label ID="OutputLabel" runat="server" /></h3> 
</asp:Content>