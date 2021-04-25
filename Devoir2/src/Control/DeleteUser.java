package Control;

import Model.Forum;
import Model.User;
import java.io.IOException;
import java.io.PrintWriter;
import java.sql.SQLException;
import java.util.ArrayList;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

/**
 * Servlet implementation class DeleteUser
 */
@WebServlet("/DeleteUser")
public class DeleteUser extends HttpServlet {
	private static final long serialVersionUID = 1L;

	/**
	 * @see HttpServlet#HttpServlet()
	 */
	public DeleteUser() {
		super();
		// TODO Auto-generated constructor stub
	}

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse
	 *      response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {
		// TODO Auto-generated method stub
		try {
			HttpSession session = request.getSession();
			if (session.getAttribute("login") == null || !"admin".equalsIgnoreCase((String) session.getAttribute("role"))) {
	            try (PrintWriter out = response.getWriter()) {
	                /* TODO output your page here. You may use following sample code. */
	                out.println("<!DOCTYPE html>");
	                out.println("<html>");
	                out.println("<head>");
	                out.println("<meta http-equiv='refresh' content='5; URL=login.jsp' />");
	                out.println("<title> Non autoris¨¦</title>");
	                out.println("</head>");
	                out.println("<body>");
	                out.println("<h1>Vous n'¨ºtes pas connect¨¦ ou vous n'¨ºtes pas admin, donc vous ne pouvez pas supprimer cet utilisateur. Veuillez vous connecter en tant qu'admin => redirig¨¦ vers la page connexion </h1>");
	                out.println("</body>");
	                out.println("</html>");
	            }

	        }else {
				int id = Integer.parseInt(request.getParameter("userid"));
				User user = new User(id);
				//supprimer tous les abonnements de l'utilisateur
				user.deleteForumSubscription();
				//supprimer tous les forums dont le propri¨¦taire est utilisateur actuel
				user.LoadMyForums();
				ArrayList<Forum> myForums=user.getMyForums();
				for(Forum f : myForums) {
					f.deleteForumSubscription();
					f.delete();
				}
				//supprimer l'utilisateur lui-m¨ºme 
				user.delete();
				response.setContentType("text/html;charset=UTF-8");
                try (PrintWriter out = response.getWriter()) {
                    out.println("<!DOCTYPE html>");
                    out.println("<html>");
                    out.println("<head>");
                    out.println("<meta http-equiv='refresh' content='5; URL=adminPage.jsp' />");
                    out.println("<title>Supprimer utilisateur</title>");
                    out.println("</head>");
                    out.println("<body>");
                    out.println("<h1>Utilisateur num¨¦ro "+id+" est bien supprim¨¦.</h1>");
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
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse
	 *      response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {
		// TODO Auto-generated method stub
		doGet(request, response);
	}

}
