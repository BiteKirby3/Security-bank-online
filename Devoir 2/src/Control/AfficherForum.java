package Control;

import java.io.IOException;
import java.io.PrintWriter;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;


/**
 * Servlet implementation class DeleteForum
 */
@WebServlet("/AfficherForum")
public class AfficherForum extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public AfficherForum() {
        super();
        // TODO Auto-generated constructor stub
    }

	/**
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	@Override
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		//response.getWriter().append("Served at: ").append(request.getContextPath());
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	@Override
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		response.setContentType("text/html;charset=UTF-8");
        HttpSession session = request.getSession();
        if (session.getAttribute("login") == null) {
            try (PrintWriter out = response.getWriter()) {
                out.println("<!DOCTYPE html>");
                out.println("<html>");
                out.println("<head>");
                out.println("<meta http-equiv='refresh' content='5; URL=login.jsp' />");
                out.println("<title> Non autoris¨¦</title>");
                out.println("</head>");
                out.println("<body>");
                out.println("<h1>Vous n'¨ºtes pas connect¨¦ ou vous n'¨ºtes pas admin => redirig¨¦ vers la page connexion </h1>");
                out.println("</body>");
                out.println("</html>");
            }

        }else {
        	int forumid = Integer.parseInt(request.getParameter("forumid"));
        	
        	
        
			session.setAttribute("forum", forumid);
			// dispatcher to page forum
    		String path="forum.jsp";
        	request.getRequestDispatcher(path).forward(request, response);
        	
        }
	}
            

	

}
