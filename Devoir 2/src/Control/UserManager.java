package Control;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import Model.User;
import java.io.IOException;
import java.io.PrintWriter;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;


@WebServlet(name = "UserManager", urlPatterns = {"/UserManager"})
public class UserManager extends HttpServlet {

    @Override
    public void init() throws ServletException {
        super.init(); //To change body of generated methods, choose Tools | Templates.

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
                out.println("<h1>Vous n'¨ºtes pas connect¨¦ ou vous n'¨ºtes pas admin => redirigez vers la page connexion </h1>");
                out.println("</body>");
                out.println("</html>");
            }

        } else {

            try {

                String firstName = request.getParameter("User first name");
                String lastName = request.getParameter("User familly name");
                String mail = request.getParameter("User email");
                String gender = request.getParameter("gender");
                String password = request.getParameter("User password");
                User user = new User(lastName, firstName, mail, gender, password);
                if (request.getParameter("role") != null) {
                    user.setRole(request.getParameter("role"));
                }
                user.save();
                response.setContentType("text/html;charset=UTF-8");
                try (PrintWriter out = response.getWriter()) {
                    /* TODO output your page here. You may use following sample code. */
                    out.println("<!DOCTYPE html>");
                    out.println("<html>");
                    out.println("<head>");
                    out.println("<title>Un nouveau utilisateur </title>");
                    out.println("<meta http-equiv='refresh' content='5; URL=adminPage.jsp' />");
                    out.println("</head>");
                    out.println("<body>");
                    out.println("<h1> Un nouveau utilisateur est ajout¨¦ : </h1>");
                    out.println(user.toString());
                    out.println("<p> Retourez ¨¤ la page d'accueil apr¨¨s 5 secondes... </p>");
                    out.println("</body>");
                    out.println("</html>");

                }
            } catch (SQLException | ClassNotFoundException ex) {
                Logger.getLogger(UserManager.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        response.setContentType("text/html;charset=UTF-8");
        HttpSession session = request.getSession();
        if (session.getAttribute("login") == null || "admin".equalsIgnoreCase((String) session.getAttribute("role")) == false) {
            try (PrintWriter out = response.getWriter()) {
                /* TODO output your page here. You may use following sample code. */
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

        } else {
        	// Dispatch to the page of the user list
        	RequestDispatcher rd = request.getRequestDispatcher("affi_list_util.jsp");
            rd.forward(request, response);
         
        }
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

}
