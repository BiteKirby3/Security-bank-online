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

/**
 * Servlet implementation class SubscribeForum
 */
@WebServlet("/SubscribeForum")


public class SubscribeForum extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public SubscribeForum() {
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
	        	   
	            	int forumid = Integer.parseInt(request.getParameter("forumid"));
	            	int userid=Integer.parseInt(request.getParameter("userid"));
	            	
	            	// add the subscription
	            	User user=new User(userid);
	            	user.addForumSubscription(forumid);
	            	
	            	try (PrintWriter out = response.getWriter()){
		            	out.println("<!DOCTYPE html>");
		                out.println("<html>");
		                out.println("<head>");
		                out.println("<meta http-equiv='refresh' content='5; URL=ListForum.jsp' />");
		                out.println("<title> Deconnexion</title>");
		                out.println("</head>");
		                out.println("<body>");
		                out.println("<h1> Vous avez bien abonn¨¦ ce Forum, redirigez vers la page liste de forum... </h1>");
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
		processRequest(request, response);
	}

}
