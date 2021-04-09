package Model;

import java.io.IOException;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;


/**
*
* @author yufei ZHAO
*/
public class Reply extends ActiveRecordBase{
	
    private Message Replymessage;
	private String content;
    private User editor;
    private String dateReply;
    private static String _query = "select * from `sr03-td4`.`messages_reply`;";
    
    public Reply() {
        _builtFromDB=false;

    }
    
    public Reply(String contenu, User editeur) {
        this.content = contenu;
        Date date = new Date();
        SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        this.dateReply = format.format(date);
        this.editor = editeur;
    }
    
    public Reply(ResultSet res) throws SQLException, ClassNotFoundException, IOException { 
    	this.id = res.getInt("reply_id");
    	this.Replymessage = new Message(res.getInt("message_id"));
        this.content = res.getString("content");
        this.editor = new User(res.getInt("editor"));
        String timeStamp = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(res.getTimestamp("dateReply"));
        this.dateReply = timeStamp;
        _builtFromDB = true;
    }
    
    
    public Reply(int id) throws SQLException, IOException, ClassNotFoundException {
        Connection conn = MyConnectionClass.getInstance();
        String select_query = "select * from `sr03-td4`.`messages_reply` where `reply_id` = '" + id + "' ; ";
        
        Statement sql = null;
        sql = conn.createStatement();
        ResultSet res = sql.executeQuery(select_query);
        if (res.next()) {
        	this.id = res.getInt("reply_id");
        	this.content = res.getString("content");
        	this.Replymessage= new Message(res.getInt("message_id"));
            this.editor = new User(res.getInt("editor"));
            String timeStamp = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(res.getTimestamp("dateReply"));
            this.dateReply = timeStamp;
            _builtFromDB = true;
        }
        
        
 
    }
    
    
    
    public int getReplymessage() {
    	return Replymessage.getId();
    }
    
    public String getContent() {
        return content;
    }
    public String getDateReply() {
    	return dateReply;
    }
    
    public User getEditor() {
        return editor;
    }
    public void setReplymessage(Message m) {
    	this.Replymessage = m;
    }
    
    public void setContent(String content) {
        this.content=content;
    }
    public void setDateReply(String reply) {
    	this.dateReply = reply;
    }
    
    public void setEditor(User user) {
        this.editor = user;
    }
    
    
    @Override
    public String toString() {
        return  "ReplyMessage=" + content + ", Editor=" + editor.getLogin();
         
    }
    
	@Override
	protected String _update() {
		Date date = new Date();
        SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        this.dateReply = format.format(date);
		return "update`sr03-td4`.`messages_reply` set  `content`='"+content+"', "
                + "`editor`='"+editor.getId()+"', `dateReply`='"+dateReply
                +"'  WHERE (`reply_id` = '"+id+"');";
	}

	@Override
	protected String _insert() {
		 return "INSERT INTO `sr03-td4`.`messages_reply` (`message_id`, `content`, `editor`, `dateReply`) "
	                + "VALUES ('"+Replymessage.getId()+ "','" +content+"', '"+editor.getId()+"', '"+dateReply+"');";
	}

	@Override
	protected String _delete() {
		return "DELETE FROM `sr03-td4`.`messages_reply` WHERE (`reply_id` = "+this.getId()+");"; 
	}
	
	/**
	 * 
	 * @return return all the responses
	 * @throws IOException
	 * @throws ClassNotFoundException
	 * @throws SQLException
	 */
	public static List<Reply> FindAll() throws IOException, ClassNotFoundException, SQLException{
		List <Reply>  listReply = new ArrayList<Reply>() ;
	    Connection conn = MyConnectionClass.getInstance();
	    Statement sql = conn.createStatement();
	    System.out.println("Executing this command: " + sql + "\n");
	    ResultSet res = sql.executeQuery(_query);
	    while (res.next()) {
	    	Reply reply= new Reply (res);
	    	listReply.add(reply);
	    }
	
	    return listReply;
		
	}
	
	/**
	 * Find response by id
	 * @param id
	 * @return
	 * @throws SQLException
	 * @throws ClassNotFoundException
	 * @throws IOException
	 */
	public static Reply FindByID(int id) throws SQLException, ClassNotFoundException, IOException {
    	Connection conn = MyConnectionClass.getInstance();
        String select_query = "select * from `sr03-td4`.`messages_reply` where `reply_id` = ? ; ";
        PreparedStatement sql = null;
        sql = conn.prepareStatement(select_query);
        sql.setInt(1, id);
        ResultSet res = sql.executeQuery();
        if (res.next()) {
        	Reply re = new Reply(res);
            return re;

        }
        
		return null;
    }
    

}
