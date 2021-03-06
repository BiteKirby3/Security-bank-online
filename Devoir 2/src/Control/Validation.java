package Control;

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



@WebServlet(name = "Validation", urlPatterns = {"/Validation"})
public class Validation extends HttpServlet {

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        boolean valid = true;

        response.setContentType("text/html;charset=UTF-8");

        HttpSession session = request.getSession();
        if (session.getAttribute("login") == null || !"admin".equalsIgnoreCase((String) session.getAttribute("role"))) {
            try (PrintWriter out = response.getWriter()) {

                out.println("<!DOCTYPE html>");
                out.println("<html>");
                out.println("<head>");
                out.println("<meta http-equiv='refresh' content='5; URL=login.jsp' />");
                out.println("<title> Non autoris??</title>");
                out.println("</head>");
                out.println("<body>");
                out.println("<h1>Vous n'??tes pas connect?? ou vous n'??tes pas admin => redirig?? vers la page connexion </h1>");
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
                
                if (firstName == null || lastName == null || mail == null || password == null) {
                    System.out.println("Champs non renseign??s");
                    RequestDispatcher rd = request.getRequestDispatcher("ajouter_nv_util.jsp");
                    rd.forward(request, response);
                    valid = false;
                } else if ("".equals(firstName) || "".equals(lastName) || "".equals(mail) || "".equals(password)) {
                    System.out.println("Champs vides");
                    RequestDispatcher rd = request.getRequestDispatcher("ajouter_nv_util.jsp");
                    rd.forward(request, response);
                    valid = false;
                    
                }
                
                if (request.getParameter("validator") != null) {
                	// des doublons ont ??t?? d??tect??s et l'utilisateur ?? valider son choix
                    if ("oui".equals(request.getParameter("valider"))) {
                    	// on ins??re les doublons
                        valid = true;
                    } else {
                        valid = false;
                        RequestDispatcher rd = request.getRequestDispatcher("ajouter_nv_util.jsp");
                        //abandonner l'insertion
                        rd.forward(request, response);
                    }
                    
                } else if (User.FindByLastAndFirstName(firstName,lastName)!=null) {
                    valid = false;
                    try (PrintWriter out = response.getWriter()) {
                    	
                        out.println("<!DOCTYPE html>");
                        out.println("<html>");
                        out.println("<head>");
                        out.println("<title>Servlet Validation</title>");
                        out.println("</head>");
                        out.println("<body>");
                        out.println("<h1>Un utilisateur avec les m??mes nom et pr??nom existe d??j??. Voulez-vous l'enregistrer ?  </h1>");
                        out.println("<form method='POST' action='Validation'>");
                        out.println("Oui <input type='radio' name='valider' value='oui' /> ");
                        out.println("Non <input type='radio' name='valider' value='non' />");
                        out.println("<input type='hidden' name='User first name' value='" + firstName + "'/>");
                        out.println("<input type='hidden' name='User familly name' value='" + lastName + "'/>");
                        out.println("<input type='hidden' name='User email' value='" + mail + "'/>");
                        out.println("<input type='hidden' name='gender' value='" + gender + "'/>");
                        out.println("<input type='hidden' name='User password' value='" + password + "' />");
                        out.println("<br>");
                        out.println("<input type ='submit' value='Envoyer' name='validator' />");
                        out.println("</form>");
                        out.println("</body>");
                        out.println("</html>");
                    }
                    
                }
                if (valid) {
                    RequestDispatcher rd = request.getRequestDispatcher("UserManager");
                    rd.forward(request, response);
                }
            } catch (ClassNotFoundException ex) {
                Logger.getLogger(Validation.class.getName()).log(Level.SEVERE, null, ex);
            } catch (SQLException ex) {
                Logger.getLogger(Validation.class.getName()).log(Level.SEVERE, null, ex);
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
        processRequest(request, response);
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
