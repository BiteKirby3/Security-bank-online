<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1" import="Model.Forum"%>
<%
int forumid = (int) session.getAttribute("forum");
Forum f = Forum.FindByID(forumid);
int user = (int) session.getAttribute("id");
%>

<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>
    <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link rel="stylesheet" href="style.css" />
    <title>Chatroom</title>
</head>

<body>
    <main class="content">
        <div class="container p-0">

            <h1 class="h3 mb-3">Messages</h1>

            <div class="card" style="height:780px;">
                <div class="row g-0">
                    
                    <div class="col-12 col-lg-7 col-xl-9">
                        <div class="py-2 px-4 border-bottom d-none d-lg-block">
                            <div class="d-flex align-items-center py-1">
                                <div class="position-relative">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                        class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                </div>
                                <div class="flex-grow-1 pl-3">
                                    <strong><%=session.getAttribute("lname")%> <%=session.getAttribute("fname")%></strong>
                                    
                                </div>
                                
                            </div>
                        </div>

                        <div class="position-relative" style="height:600px;">
                            <div class="chat-messages p-4" id="outputMessage">

                               
					       </div>
                        </div>

                        <div class="flex-grow-0 py-3 px-4 border-top">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type your message" id="inputMessage">
                                <button class="btn btn-primary" onclick="getMessage();">Send</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script>
	var room = "<%=session.getAttribute("forum")%>";
	var login = "<%=session.getAttribute("login")%>";
	//alert(room + login);
	var wsUrl = "ws://localhost:8080/Devoir2/chatserver/" + room;
	var ws = new WebSocket(wsUrl);
	
	
	ws.onopen = function() {
		ws.send(login);
	}
	
	ws.onmessage = function(message) {
		outputMessage.innerHTML += message.data;
	}
	
	
	function getMessage() {
		var inputMessage = document.getElementById("inputMessage").value;
		//window.alert("asd");
		if (typeof(inputMessage) == "undefined") {
			alert("Enter something.");
		} else {
			ws.send(inputMessage);
			document.getElementById("inputMessage").value = "";
		}
	}
	
	
	window.onbeforeunload = function() {
		ws.close();
	}
	
	
	
	</script>
</body>

</html>


