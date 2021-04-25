<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8" 
	import="Model.*, java.util.*,java.io.IOException,java.sql.SQLException,java.util.logging.Logger,java.util.logging.Level ,java.text.SimpleDateFormat" %>
   
 <% 
 	int forumid = (int) session.getAttribute("forum");
	Forum f = Forum.FindByID(forumid);
	 %>  
	 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="refresh" content="60; URL= forum.jsp">

<title>Forum </title>
	<style type="text/css">
		.title{
			margin-top: 6px;
				margin-bottom: 16px;
				font-size: 20px;
				color: rgb(51,51,51);
			text-align: center;
		}
		/*Main*/
		.wrap {
		    margin: 0 auto;
		    width: 56.25em;
		}
		 
		/*mes-board*/
		.mes-board {
		    margin: 1.875em 0;
		    border: 1px solid #aaa;
		    padding: 0 .7em;
		    background-color: #fcf;
		}
		
		.mes-board .firstline { 
			border-top: 1px dashed #fff; }
		#reply {
			margin-left: 50px;
			padding: .65em;
			
			}
			
		
		.mes-board h4 {
		    display: inline;
		    margin-right: 2px;
		    font-weight: 400;
		    color: #66f;
		}
		
		.mes-board small { color: #999; }
		.mes-board p {
		    padding: 0.5em;
		    }
		 #content{
		 	padding: .5em;
		    border: 1px solid #ccc;
		    -webkit-border-radius: 5px;
		    -moz-border-radius: 5px;
		    border-radius: 5px;
		 
		 }
		.message {
			border:0;
			border-radius:5px;
			background-color:rgba(241,241,241,.98);
			width: 355px;
			height: 100px;
			padding: 10px;
			resize: none;
			overflow-y: visible
			}
		/*mes-send*/
		.mes-send {
		    padding: .65em;
		    border: 1px solid #ccc;
		    -webkit-border-radius: 5px;
		    -moz-border-radius: 5px;
		    border-radius: 5px;
		}
		.form-group { padding: 1.25em; }
		.form-group label { vertical-align: top; }
		.mes-send input[type="text"],
		.mes-send textarea {
		    padding: 1px;
		    width: 40%;
		    border: 1px solid #b7b7b7;
		    -webkit-border-radius: 4px;
		    -moz-border-radius: 4px;
		    border-radius: 4px;
		}
		.mes-send input { height: 2em; }
		#btn {
		    margin-left: 1.25em;
		    padding: 5px;
		    border: none;
		    -webkit-border-radius: 1.25em;
		    -moz-border-radius: 1.25em;
		    border-radius: 1.25em;
		    width: 15%;
		    font-size: 12pt;
		    color: #fff;
		    background-color: #66f;
		    cursor: pointer;
}
	 
	</style>
</head>
<body>
	<header>
	<form method="POST" action="Deconnexion">
	      <button class="btn-logout form-btn">Déconnexion</button>
	</form>
	
	<div class="title">
		<h2>Welcome to <%=f.getTitle() %> !</h2>
		<h3>Flux de messages</h3>
	</div>
	</header>

<div class="wrap">

</div>

<br><br>

<div class="mes-send">

	<h2>Send message</h2>
        <form  class="form-group" action="AddMessage" method="post">
            <label> Message </label>
            <input type="hidden" id="forumid" name="forumid" value="<%=forumid %>"/>
            <textarea class="message" id="message" name="message"></textarea>
            <br>
            <input id="btn" type="submit" value="Sent">  
        </form>
        

</div>


</body>
</html>
