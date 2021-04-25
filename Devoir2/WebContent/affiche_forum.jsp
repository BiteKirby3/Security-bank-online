<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"
	import="Model.*, java.util.*,java.io.IOException,java.sql.SQLException,java.util.logging.Logger,java.util.logging.Level ,java.text.SimpleDateFormat"%>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<script type="text/javascript" src="websocket.js"></script>
<style>
#history {
	display: block;
	width: 500px;
	height: 300px;
}

#txtMessage {
	display: inline-block;
	width: 300px;
}

#btnSend {
	display: inline-block;
	width: 180px;
}

#btnClose {
	display: block;
	width: 500px;
}
</style>
<title></title>
</head>
<body>
	<textarea id="history" readonly></textarea>
	<input id="txtMessage" type="text" />
	<button id="btnSend">Send message</button>
	<button id="btnClose">Close connection</button>
</body>
</html>