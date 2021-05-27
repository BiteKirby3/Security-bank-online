function removeQuotes(myinput) {
   var regCarToClean = new RegExp("[']", "g");
   myinput.value = myinput.value.replace(regCarToClean, '');
}

function verifyPassword() {
   //Règle : at least 8 characters, 1 number, 1 lowercase character (a-z) and 1 uppercase, contains only 0-9a-zA-Z
   var format = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;

   var password = document.getElementById("mdp");

   if(format.test(password.value))
   {
      window.location.href = "vw_messagerie.php?mdpFormatError";
   } else{
      window.location = '<?=$domain_name?>/myController.php';
   }
}