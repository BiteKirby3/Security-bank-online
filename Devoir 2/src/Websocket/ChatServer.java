package Websocket;

import java.io.IOException;
import java.util.HashMap;
import javax.websocket.OnClose;
import javax.websocket.OnMessage;
import javax.websocket.OnOpen;
import javax.websocket.Session;
import javax.websocket.server.ServerEndpoint;

@ServerEndpoint(value = "/chatserver/{pseudo}")
public class ChatServer {

private Session session;
	
	private String userName;
	
	private boolean firstFlag = true;
	
	private static final HashMap<String, Object> connectMap = new HashMap<String, Object>();
	
	private static final HashMap<String, String> userMap = new HashMap<String, String>();
	
	
	@OnOpen
	public void start(Session s) {
		this.session = s;
		connectMap.put(s.getId(), this);
		
		
		/*
		 * ChatServer client = null;
		 * 
		 * for (String connectKey: connectMap.keySet()) {
		 * 
		 * client = (ChatServer) connectMap.get(connectKey); try { for (String user :
		 * userMap.values()) {
		 * client.session.getBasicRemote().sendText(formatList(user)); } } catch
		 * (IOException e) { // TODO Auto-generated catch block e.printStackTrace(); } }
		 */
		
		
		
	}
	
	private String formatList(String user) {
		
		StringBuffer messageBuffer = new StringBuffer();
		
		messageBuffer.append("<a href=\"#\" class=\"list-group-item list-group-item-action border-0\">");
		messageBuffer.append("<div class=\"d-flex align-items-start\">");
		messageBuffer.append("<div class=\"flex-grow-1 ml-3\">");
		messageBuffer.append(user);
		messageBuffer.append("<div class=\"small\"><span class=\"fas fa-circle chat-online\"></span> Online</div>");
		messageBuffer.append("</div></div></a>");
		
		return messageBuffer.toString();
	
	}
	
	

	@OnMessage
	public void chat(String clientMessage, Session s) {
		
		ChatServer client = null;
		
		if (firstFlag) {
		
			this.userName = clientMessage;
			
			userMap.put(session.getId(), userName);
			
			
			String message = formatHTML("System message", userName + " comes in.");
		
			
			for (String connectKey: connectMap.keySet()) {
				client = (ChatServer) connectMap.get(connectKey);
				try {
					client.session.getBasicRemote().sendText(message);
				} catch (IOException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			}
			
			firstFlag = false;
		} else {
			String message = clientMessage;
			for (String connectKey: connectMap.keySet()) {
				client = (ChatServer) connectMap.get(connectKey);
				try {
					client.session.getBasicRemote().sendText(formatHTML(userName, message));
				} catch (IOException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			}	
			
		}
		
	}
	
	@OnClose
	public void close(Session s) {
		String message = formatHTML("System message", userMap.get(s.getId()) + " quits chatroom.");
		
		userMap.remove(s.getId());
		connectMap.remove(s.getId());
		
		
		ChatServer client = null;
		
		for (String connectKey: connectMap.keySet()) {
			client = (ChatServer) connectMap.get(connectKey);
			try {
				client.session.getBasicRemote().sendText(message);
			} catch (IOException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}	
	}
	
	
	public String formatHTML(String userName, String message) {
	
		StringBuffer messageBuffer = new StringBuffer();
		
		messageBuffer.append("<div class=\"chat-message-left pb-4\">");
		messageBuffer.append("<div class=\"flex-shrink-1 bg-light rounded py-2 px-3 ml-3\">");
		messageBuffer.append("<div class=\"font-weight-bold mb-1\">" + userName + "</div>");
		messageBuffer.append(message);
		messageBuffer.append("</div></div>");
		
		return messageBuffer.toString();
	
	}


	
}