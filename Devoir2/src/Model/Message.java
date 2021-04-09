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
public class Message extends ActiveRecordBase{

    private String content;
    private String datePublication;
    private User editor;
    private Forum destination; 
    private List<Reply> replylist;
    private static String _query = "select * from `devoir2`.`message`;";
    


    /*
    java.text.SimpleDateFormat sdf = 
     new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

    String currentTime = sdf.format(dt);
     */
    public Message() {
        _builtFromDB=false;

    }

    public Message(String contenu, User editeur) {
        this.content = contenu;
        
        Date date = new Date();
        SimpleDateFormat format = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        this.datePublication = format.format(date);
        this.editor = editeur;
    }
    
    public Message(int id) throws SQLException, ClassNotFoundException, IOException {
    	Connection conn = MyConnectionClass.getInstance();
        String select_query = "select * from `devoir2`.`message` where `id` = '" + id + "';";
        
        Statement sql = null;
        sql = conn.createStatement();
        ResultSet res = sql.executeQuery(select_query);
        if (res.next()) {
        	this.id = res.getInt("id");
        	this.editor = new User(res.getInt("editor"));
            this.content = res.getString("content");
            this.destination= new Forum(res.getInt("destination"));
            String timeStamp = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(res.getTimestamp("datePublication"));
            this.datePublication = timeStamp;
            _builtFromDB = true;
        }
    }

  

    public Message(ResultSet res) throws SQLException, ClassNotFoundException, IOException { 
    	this.id = res.getInt("id");
        this.content = res.getString("content");
        this.editor = new User(res.getInt("editor"));
        this.destination= new Forum(res.getInt("destination"));
        String timeStamp = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss").format(res.getTimestamp("datePublication"));
        this.datePublication = timeStamp;
        _builtFromDB = true;
    }
    
    
    /**
     * 
     * @return
     */
    public List<Reply> getReplyList() {
        return replylist;
    }

    /**
     *
     * @param messages
     */
    public void setRepliList(ArrayList<Reply> replylist) {
        this.replylist = replylist;
    }
    
    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public String getDatePublication() {
        return datePublication;
    }

    public void setDatePublication(String datePublication) {
        this.datePublication = datePublication;
    }

    public User getEditor() {
        return editor;
    }

    public void setEditor(User editor) {
        this.editor = editor;
    }
    
    public Forum getDestination() {
        return destination;
    }

    public void setDestination(Forum destination) {
        this.destination = destination;
    }
    
   



//DB access methods
    @Override
    public String toString() {
        return  "Message=" + content + ", Editor=" + editor.getLogin() + ""
                + ", Forum=" + destination.getTitle();
    }
    
    @Override
    protected String _delete() {
        return "DELETE FROM `devoir2`.`message` WHERE (`id` = "+this.getId()+");"; 
    }

    @Override
    protected String _insert() {
        return "INSERT INTO `devoir2`.`message` (`content`, `editor`, `destination`,`datePublication`) "
                + "VALUES ('"+content+"', '"+editor.getId()+"', '"+destination.getId()+"','"+this.datePublication+"');";
    }

    @Override
    protected String _update() {
        return "update`devoir2`.`message` set  `content`='"+content+"', "
                + "`editor`='"+editor.getId()+"', `destination`='"+destination.getId()
                +"'  WHERE (`id` = '"+id+"');";
    }
    
    public static Message FindbyId(int id) throws ClassNotFoundException, IOException, SQLException{
    	Connection conn = MyConnectionClass.getInstance();
        String select_query = "select * from `devoir2`.`message` where `id` = " + id +";" ;
        PreparedStatement sql = null;
        System.out.println("Executing this command: " + select_query + "\n");
        sql = conn.prepareStatement(select_query);
        
        ResultSet res = sql.executeQuery();
        while (res.next()) {
        	Message m = new Message(res);
        	return m;
        }
    	
    	return null;
        
    }
        
   
    
/**
 * r¨¦cup¨¨re tous les r¨¦ponses du message actuel
 * @throws ClassNotFoundException
 * @throws IOException
 * @throws SQLException
 */
public void LoadReply() throws ClassNotFoundException, IOException, SQLException {
    	
    	List<Reply> replylist=new ArrayList<Reply>();
    	Connection conn = MyConnectionClass.getInstance();
        String select_query =  "select * from `devoir2`.`messages_reply` where `message_id` = " +this.id+" order by `dateReply`";
        PreparedStatement sql = null;

        sql = conn.prepareStatement(select_query);
        System.out.println("Executing this command: " + select_query + "\n");
        ResultSet res = sql.executeQuery();
        while (res.next()) {
        	Reply rm = new Reply(res);
        	replylist.add(rm);
        }
        this.replylist= replylist;

    }

/**
 * Ajouter une r¨¦ponse au message actuel
 * @param m
 * @throws ClassNotFoundException
 * @throws SQLException
 * @throws IOException
 */
	public void addReply(Reply m) throws ClassNotFoundException, SQLException, IOException {
		m.setReplymessage(this);
		m.save();
		LoadReply();
	}
	
	
    
}
