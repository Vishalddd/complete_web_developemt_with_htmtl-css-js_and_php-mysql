<?php

   //Authorization -Acess Control
   //checkled whether the user is login or not
   if(!isset($_SESSION['user']))//if user session is not set
   {
       //user is not logged in 
       //redirecy to login page with msg
       $_SESSION['no-login-massage'] = "<div class='error text-center'>Please login access Admin Panel. </div>";
       //redirect to login page
       header('location:'.SITEURL.'admin/login.php');
   }

?>
