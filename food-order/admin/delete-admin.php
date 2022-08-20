<?php 

    //include constants.php file
    include('../config/constants.php');
   
     //get the id to delete to be admin
     $id = $_GET['id'];

     // create sql query to delete admin
     $sql = "DELETE FROM tbl_admin WHERE id = $id";

     //execute the query
     $res = mysqli_query($conn, $sql);

     //check wheather the query executed sussessfully or not
     if($res==True)
     {
        //query exicuted sucessfully and admin delete
        //echo"admin deleted";
        // create session variable to display massage
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Sucessfully.</div>";
        // Redirect to manage admin
        header('location:'.SITEURL.'admin/manage-admin.php');
     }
     else 
     {
        //failed to delete admin
        //echo "failed to delete admin";

        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again Later.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');

     }

     // redirect to manage admin page with massage (success/error)


?>