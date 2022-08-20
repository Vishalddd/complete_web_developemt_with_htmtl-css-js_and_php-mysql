<?php
//include constants page
include('../config/constants.php');
   if(isset($_GET['id']) && isset($_GET['image_name'])) //either use && or and 
   {
    //process to delete
    //echo "process to delete";

    //1 get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //2 remove the image if its available
    //check whether the image is available or not and delete if available
    if($image_name != "")
    {
       //it has image and need to remove from  folder
       //get the image path
       $path = "../images/food/".$image_name;
       //remove image file from folder
       $remove = unlink($path);
       
       //chgeck whether image remove or not
       if($remove==false)
       {
        //failed to remove image
        $_SESSION['upload'] = "<div class='error'>Failed To remove image file.</div>";
        //redirect to manage food
        header('location:'.SITEURL.'admin/manage-food.php');
        //stop the process of deleting food
        die();
       }
    }

    //3 delete food from database
    $sql = "DELETE FROM  tbl_food WHERE id=$id";
    //execute the query
    $rec = mysqli_query($conn, $sql);
    //check whether the query is executed or not and set the session msg respectively
       //4 redirec to manage food with session msg
    if($res==true)
    {
       //food detected
       $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
       header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
        //fail;ed to delete food
        $_SESSION['delete'] = "<div class='success'>Food Deleted.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
   }
   else
   {
        //Redirect to manage food page
        //echo "Redirect";
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
   }
?>