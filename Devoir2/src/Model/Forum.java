package Model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


import java.io.IOException;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

//import model.User.Role;

/**
 *
 * @author lounis
 */
public class Forum extends ActiveRecordBase {

    private String title;
    private String description;
    private List<Message> messages;
    private User owner;
    private static String _query = "select * from `devoir2`.`forum`;"; // for findAll static Method

    /**
     * 
     * @return
     */
    public List<Message> getMessages() {
        return messages;
    }

    /**
     *
     * @param messages
     */
    public void setMessages(ArrayList<Message> messages) {
        this.messages = messages;
    }

    public User getOwner() {
        return owner;
    }

    public void setOwner(User owner) {
        this.owner = owner;
    }

    public Forum(String titre, String description, User u) {
        this.messages = new ArrayList<Message>();
        this.title = titre;
        this.description = description;
        this.owner = u;
        _builtFromDB = false;
    }
    
    public Forum(ResultSet res) throws SQLException, ClassNotFoundException, IOException {
    	this.id = res.getInt("id");
        this.title = res.getString("title");
        this.description = res.getString("description");
        this.owner= new User(res.getInt("owner"));
        _builtFromDB = true;
    }

    public Forum() {
        this.messages = new ArrayList<Message>();
    }

    public Forum(int id) throws SQLException, IOException, ClassNotFoundException {
        Connection conn = MyConnectionClass.getInstance();
        String select_query = "select * from `devoir2`.`forum` where `id` = '" + id + "';";
        
        Statement sql = null;
        sql = conn.createStatement();
        ResultSet res = sql.executeQuery(select_query);
        if (res.next()) {
        	this.id = res.getInt("id");
        	
            this.title = res.getString("title");
            this.owner = new User(res.getInt("owner"));
            this.description = res.getString("description");
            _builtFromDB = true;
        }
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }
    

    public List<Message> getFilDiscussion(String choix) {
        if ("all".equalsIgnoreCase(choix)) {
            return this.messages;
        }
        //ToDo il faut traiter d'autres choix.
        return null;
    }

    @Override
    public String toString() {
        return  "Title=" + title + ", Description=" + description + ""
                + ", owner=" + owner+",ID="+id ;
    }
    
    // DB access method
    @Override
    protected String _delete() {
        return "DELETE FROM `devoir2`.`forum` WHERE (`id` = '" + id + "');";
    }

    @Override
    protected String _insert() {
        return "INSERT INTO `devoir2`.`forum` (`title`, `owner`,`description`) "
                + "VALUES ('" + title + "', '" + owner.getId() + "', '"+ description +"');";
    }

    @Override
    protected String _update() {
        return "UPDATE `devoir2`.`forum` SET `title` = '" + title + "', "
                + "`owner`='" + owner.getId() + "', `description` = '"+description+"'   WHERE (`id` = '" + id + "');";
    }

    
    
    
    /**
     * charger les message depuis la bd (select)
     * @throws ClassNotFoundException
     * @throws IOException
     * @throws SQLException
     */
    public void LoadMessages() throws ClassNotFoundException, IOException, SQLException {
    	
    	List<Message> Messagelist=new ArrayList<Message>();
    	Connection conn = MyConnectionClass.getInstance();
        String select_query =  "select * from `devoir2`.`message` where `destination` = " +this.id+" order by `datePublication` DESC";
        PreparedStatement sql = null;

        sql = conn.prepareStatement(select_query);
        
        ResultSet res = sql.executeQuery();
        while (res.next()) {
        	Message m = new Message(res);
        	Messagelist.add(m);
        }
        this.messages= Messagelist;

    }

    
    
    /**
     * Ajouter un message dans le forum actuel
     * @param m
     * @throws ClassNotFoundException
     * @throws SQLException
     * @throws IOException
     */
    public void addMessage(Message m) throws ClassNotFoundException, SQLException, IOException {
    	m.setDestination(this);
    	m.save();
    	LoadMessages();
    }


    public static List<Forum> FindAll() throws IOException, ClassNotFoundException, SQLException{
    	List <Forum>  listForum = new ArrayList<Forum>() ;
        Connection conn = MyConnectionClass.getInstance();
        Statement sql = conn.createStatement();
        ResultSet res = sql.executeQuery(_query);
        while (res.next()) {
            Forum newForum= new Forum (res);
            listForum.add(newForum);
        }

        return listForum;
    	
    }
    
    
    /**
     * retourner tous les utilisateurs qui ont abonn¨¦s sur un forum
     * @param forumid
     * @return
     * @throws SQLException
     * @throws ClassNotFoundException
     * @throws IOException
     */
    public static List<Integer> FindAllSubscription(int forumid) throws SQLException, ClassNotFoundException, IOException {
    	List<Integer> userlist=new ArrayList<Integer>();
    	Connection conn = MyConnectionClass.getInstance();
        String search_query ="select id_user from `devoir2`.`subscriptions` where id_forum = ?;";
        PreparedStatement sql = null;
        sql = conn.prepareStatement(search_query);
        sql.setInt(1, forumid);
        ResultSet res = sql.executeQuery();
        while (res.next()) {
        	int userid=res.getInt("id_user");
            
            userlist.add(userid);
        }
    	
    	return userlist;
    	
    }
    
    /**
     * supprimer tous les abonnement du forum actuel
     * @throws ClassNotFoundException
     * @throws IOException
     * @throws SQLException
     */
    public void deleteForumSubscription() throws ClassNotFoundException, IOException, SQLException {
    	Connection conn = MyConnectionClass.getInstance();
    	Statement sql = null;
        sql = conn.createStatement();
        String query="DELETE FROM `devoir2`.`subscriptions` WHERE  `id_forum`="+this.id+"; ";
        System.out.println("Executing this command: " + query + "\n");
        sql.executeUpdate(query);  
    }

    
    public static Forum FindByID(int id) throws SQLException, ClassNotFoundException, IOException {
    	Connection conn = MyConnectionClass.getInstance();
        String select_query = "select * from `devoir2`.`forum` where `id` = ? ; ";
        PreparedStatement sql = null;
        sql = conn.prepareStatement(select_query);
        sql.setInt(1, id);
        //System.out.println("Executing this command: " + select_query + "\n");
        ResultSet res = sql.executeQuery();
        if (res.next()) {
        	Forum f = new Forum(res);
            return f;

        }
		return null;
    }
    

}
