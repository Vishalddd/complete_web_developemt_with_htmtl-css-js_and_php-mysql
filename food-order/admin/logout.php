<?php
     
     //include constants.php for SITEURL
     include('../config/constants.php');
    //distroy the session and comes to the redirect login page
      session_destroy();//unsets $_SESSION ['user']

      //redierect
      header('location:'.SITEURL.'admin/login.php');


?>