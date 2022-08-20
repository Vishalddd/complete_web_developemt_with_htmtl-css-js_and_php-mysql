<?php
//include constant file
include('../config/constants.php');
  //echo "delete page";
  //check whether the id and image_name value is set or not

  if(isset($_GET['id']) AND isset($_GET['image_name'])) //privent to manage from hacks
  {
    //get the value and delete
    //echo "Get value and delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //remove the physical image file is available
    if($image_name != "")
    {
        //image is available so remove it
        $path = "../images/category/".$image_name;
        //remove the image
        $remove = unlink($path);

        //if failed to remove image then add an error massage and stop the process
        if($remove==false)
        {
            //set the session massage
            $_SESSION['remove'] = "<div class='error'>Failed To Remove Category Image.</div>";
            //redirect to manage category page
            header('location:'.SITEURL.'admin/manage-category.php');
            //stop the process
            die();

        }
    }
    //delete data from database
    //sql query to delete data from database
    $sql = "DELETE  FROM tbl_category WHERE id=$id";

    //execute the query
    $res = mysqli_query($conn, $sql);

    //check whether the data is delete from the databse or not
    if($res==true)
    {
        //set success massage and redirect
        $_SESSION['delete'] = "<div class='success'>Category Delete Successfully.</div>";
        //redirect to manage category
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        //set fail massage and redirect
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
        //redirect to manage category
        header('location:'.SITEURL.'admin/manage-category.php');
    }

    

  }
  else
  {
    //redirect to mange catregory page
    header('location:'.SITEURL.'admin/manage-category.php');

  }
?>