<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
       <h1>Update Category</h1>
        
       <br><br>
       <?php

       //check whether the id is set or not
       if(isset($_GET['id']))
       {
         //get the id and all the details
        // echo "getting the data";
        $id = $_GET['id'];

        //create sql query to get all other details
        $sql = "SELECT * FROM tbl_category WHERE id=$id";

        //execute the sql query
        $res = mysqli_query($conn, $sql);

        //count the rows to check wheteher the id is valid or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //get all the data
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $current_image = $row['image_name'];
            $featured = $row['featured'];
            $active = $row['active'];
        }
        else
        {
            //redirect to manage categfory with session massaggr
            $_SESSION['no-category-found'] = "<div class='error'>Category Not Found. </div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
       }
       else
       {
        //redirect to manage category
        header('location:'.SITEURL.'admin/manage-category.php');

       }

        ?>

       <form action="" method="POST" enctype="multipart/form-data">
               <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                       <?php
                           if($current_image != "")
                           {
                            //display the image
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>"width="150px">
                            <?php
                           }
                           else
                           {
                            //display massage
                            echo"<div class='error'>Image Not Added.</div>";

                           }
                       ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No") {echo "checked";} ?>  type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                      <td>
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

        </table>
    </form>
    <?php

    if(isset($_POST['submit']))
    {
        //echo"clicked";
        //1. get all the value our form
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
        $featured = mysqli_real_escape_string($conn, $_POST['featured']);
        $active = mysqli_real_escape_string($conn, $_POST['active']);

        //2. updating new image if selected
        //check whether the image selected or not
        if(isset($_FILES['image']['image']))
        {
            //get the large details
            $image_name = $_FILES['image']['image'];

            //check whether the image is available or not
            if($image_name != "")
            {
                //image available
                //a upload the new image
                 //auto remain our image
                 //get the extension of our image(jpg, png, gif, etc) e.g. "food.jpg"
                  $ext = end(explode('.', $image_name));

                  //rename the image
                 $image_name = "Food_Category_".rand(000, 999).'.'.$ext;  //(.rand is random function to get a values in between 000 to 999 for replace the same image name before storing data in mysql)

                 $source_path = $_FILES['image']['tmp_name'];

                 $destination_path = "../images/category/".$image_name;

                //finally upload the image

                $upload = move_uploaded_file($source_path, $destination_path);
        
                 //check wether image uploaded or not
                //and if the image is not uplaoded then we will stop the processs and redirect with error msg
                 if($upload==false)
                 {
                     //set msg
                     $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                     //redirect to add category page
                     header('location:'.SITEURL.'admin/manage-category.php');
                     //STOP the process
                     die();
                 }

                 //b remove the current image if available
                 if($current_image!="")
                 {
                  $remove_path = "../images/category/".$current_image;
                  $remove = unlink($remove_path);
 
                  // checl whether the imag eremove or not 
                  //if failed to remove then displahy massage and stop the procees
                  if($remove==$false)
                  {
                   //faild to remove image
                   $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                   header('location:'.SITEURL.'admin/manage-category.php');
                   die();//stop the process
                  }

                 }


            }
            else
            {
               $image_name = $current_image;       
            }
        }
        else
        {
            $image_name = $current_image;
        }

        //3. update the database
        $sql2 = "UPDATE tbl_category SET
            title ='$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id=$id
            ";
        //execute the query
        $res2 = mysqli_query($conn, $sql2);

        //4. redirect to manage categoryu page with massage
        //check whether executed or not
        if($res2==true)
        {
            $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
             //failed to update category
             $_SESSION['update'] = "<div class='error'>Field to Updated Category.</div>";
             header('location:'.SITEURL.'admin/manage-category.php');
        }

    }

    ?>

    </div>
</div>



<?php include('partials/footer.php'); ?>