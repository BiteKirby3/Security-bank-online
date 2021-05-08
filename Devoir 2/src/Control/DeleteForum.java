package Control;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.SQLException;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import Model.Forum;

/**
 * Servlet implementation class DeleteForum
 */
@WebServlet("/DeleteForum")
public class DeleteForum extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public DeleteForum() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		try {
			int id = Integer.parseInt(request.getParameter("forumid"));
			Forum forum = new Forum(id);
			HttpSession session = request.getSession();
			if (session.getAttribute("login") == null || (!"admin".equalsIgnoreCase((String) session.getAttribute("role")) && !forum.getOwner().getLogin().equals((String) session.getAttribute("login")))) {
	            try (PrintWriter out = response.getWriter()) {
	                /* TODO output your page here. You may use following sample code. */
	                out.println("<!DOCTYPE html>");
	                out.println("<html>");
	                out.println("<head>");
	                out.println("<meta http-equiv='refresh' content='5; URL=login.jsp' />");
	                out.println("<title> Non autoris¨¦</title>");
	                out.println("</head>");
	                out.println("<body>");
	                out.println("<h1>Vous n'avez pas le droit de supprimer ce forum. Veuillez vous connecter en tant qu'admin si vous voulez le supprimer => redirig¨¦ vers la page connexion </h1>");
	                out.println("</body>");
	                out.println("</html>");
	            }

	        }else {
	        	//supprimez d'abord tous les abonnements li¨¦s au forum 
	        	forum.deleteForumSubscription();
	        	//supprimer le forum lui-meme
				forum.delete();
				response.setContentType("text/html;charset=UTF-8");
                try (PrintWriter out = response.getWriter()) {
                    out.println("<!DOCTYPE html>");
                    out.println("<html>");
                    out.println("<head>");
                    if("admin".equalsIgnoreCase((String) session.getAttribute("role"))) {
                    	out.println("<meta http-equiv='refresh' content='5; URL=adminPage.jsp' />");
                    } else {
                    	out.println("<meta http-equiv='refresh' content='5; URL=userPage.jsp' />");
                    }
                    out.println("<title>Supprimer forum </title>");
                    out.println("</head>");
                    out.println("<body>");
                    out.println("<h1>Forum num¨¦ro "+id+" est bien supprim¨¦.</h1>");
                    out.println("<p> Retourez ¨¤ la page d'accueil apr¨¨s 5 secondes... </p>");
                    out.println("</body>");
                    out.println("</html>");

                }
			}
		} catch (NumberFormatException | ClassNotFoundException | SQLException | IOException e) {
			e.printStackTrace();
		}
		response.getWriter().append("Served at: ").append(request.getContextPath());
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		doGet(request, response);
	}

}
