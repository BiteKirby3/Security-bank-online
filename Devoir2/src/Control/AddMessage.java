package Control;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import Model.Forum;
import Model.User;
import Model.Message;

/**
 * Servlet implementation class AddForum
 */
@WebServlet("/AddMessage")
public class AddMessage extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public AddMessage() {
        super();
        // TODO Auto-generated constructor stub
    }
    
    /**
     * Processes requests for both HTTP  <code>POST</code> methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
    	response.setContentType("text/html;charset=UTF-8");
        HttpSession session = request.getSession();
    	
        if (session.getAttribute("login") == null) {
            try (PrintWriter out = response.getWriter()) {
                /* TODO output your page here. You may use following sample code. */
                out.println("<!DOCTYPE html>");
                out.println("<html>");
                out.println("<head>");
                out.println("<meta http-equiv='refresh' content='5; URL=login.jsp' />");
                out.println("<title> Non autoris¨¦</title>");
                out.println("</head>");
                out.println("<body>");
                out.println("<h1>Vous n'¨ºtes pas connect¨¦ => redirig¨¦ vers la page connexion </h1>");
                out.println("</body>");
                out.println("</html>");
            }

        } else {

            try {
            	String login=(String)session.getAttribute("login");
            	String message= request.getParameter("message");
                int idForum = Integer.parseInt(request.getParameter("forumid"));
                
                User user= User.FindByLogin(login);
                Forum forum= Forum.FindByID(idForum);
                //add message
                Message m = new Message(message, user);
                forum.addMessage(m);
                
                response.setContentType("text/html;charset=UTF-8");
                try (PrintWriter out = response.getWriter()) {
                    /* TODO output your page here. You may use following sample code. */
                    out.println("<!DOCTYPE html>");
                    out.println("<html>");
                    out.println("<head>");
                    out.println("<meta http-equiv='refresh' content='5; URL=forum.jsp' />");
                    out.println("<title>Un nouveau Message </title>");
                    out.println("</head>");
                    out.println("<body>");
                    out.println("<h1> Un nouveau Message est ajout¨¦ => redirig¨¦ vers la page de Forum </h1>");
                    out.println(m.toString());
                    
                    out.println("</body>");
                    out.println("</html>");

                }
            } catch (SQLException | ClassNotFoundException ex) {
                Logger.getLogger(AddForum.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
    
    
    
    

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		processRequest(request, response);
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		//doGet(request, response);
		processRequest(request, response);
		
	}

}
