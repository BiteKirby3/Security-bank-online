<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Login page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>
    <body>
    <div >
    
        <h2>Login page</h2>
        <form action="Connexion" method="POST">
            <div>
                <label for="username">Login:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div>
                <label for="pass">Password (6 characters minimum):</label>
                <input type="password" id="pass" name="password"  required>
            </div>

            <input type="submit" value="Sign in">

        </form>
        </div>
    </body>
</html>
