<?php include('partials/menu.php'); ?>
<?php

  if(isset($_GET['id']))
  {
    //get all the detail
    $id = $_GET['id'];

    //sql query to get the selected food
    $sql2  = "SELECT * FROM tbl_food WHERE id=$id";

    //execute the query
    $res2 = mysqli_query($conn, $sql2);

    //get the value based on query executed
    $row2 = mysqli_fetch_assoc($res2);

    //get the indivitual value of selected food
    $title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
  }
  else
  {
    //redirect to manage food
    header('location:'.SITEURL.'admin/manage-food.php');
  }

?>

 <div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>
        
        <form action="" method="POST" enctype="multipart/form-data">

          <table class="tbl-30">

            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value=<?php echo $title; ?>>
                </td>
            </tr>
            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description"  cols="30" rows="5"><?php echo $description ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Price: </td>
                <td>
                   <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>
            <tr>
                <td>Current Image: </td>
                <td>
                   <?php

                   if($current_image == "")
                   {
                        //image not available
                        echo "<div class='error'>iamge not available.</div>";
                   }
                   else
                   {
                        //image available
                        ?>

                         <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image ?>" alt="<?php echo $title ?>" width="100px">

                        <?php
                   }


                   ?>
                </td>
            </tr>
            <tr>
                <td>Select New Image:</td>
                <td>
                    <input type="file" name="image">
                </td>

            </tr>
            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">

                         <?php
                            //query to get active categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //execute the query
                            $res = mysqli_query($conn, $sql);
                            //connect sql
                            $count = mysqli_num_rows($res);
                            //check whether the category available or not 
                            if($count>0)
                            {
                                //category available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                   $category_title = $row['title'];
                                   $category_id = $row['id'];
                                   //echo "<option value='$category_id'>$category_title</option>";
                                   ?>
                                       <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                   <?php

                                }
                            }
                            else
                            {
                                //category not available
                                echo"<option value='0'>Category Not Available.</option>";
                            }
                         ?>
                       
                    </select>
                </td>
            </tr>
            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No">No
                </td>
            </tr>
            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No">No
                </td>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>


          </table>


        </form>

        <?php

           if(isset($_POST['submit']))
           {
              //echo "button click";
              //1. get all the details from the form
              $id = mysqli_real_escape_string($conn, $_POST['id']);
              $title = mysqli_real_escape_string($conn, $_POST['title']);
              $description = mysqli_real_escape_string($conn, $_POST['description']);
              $price = mysqli_real_escape_string($conn, $_POST['price']);
              $current_image = mysqli_real_escape_string($conn, $_POST['current_image']);
              $category = mysqli_real_escape_string($conn, $_POST['category']);

              $featured = mysqli_real_escape_string($conn, $_POST['featured']);
              $active = mysqli_real_escape_string($conn, $_POST['active']);

              //2. upload image if selected

              //checlk whether uploade buttoon click or not
              if(isset($_FILES['image']['name']))
              {
                //uplode button click
                $image_name = $_FILES['image']['name'];

                //check whether the file is avialable or not 
                if($image_name != "")
                {
                    //image is avalable

                    //part 1 uploading to nem image


                    //rename the image
                    $ext = end(explode('.', $image_name));//getb the extension of image

                    $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;//this will be ramian
                    //get the source path and destinatiuion path
                    $src_path = $_FILES['image']['tmp_name'];
                    $dest_path = "../images/food/".$image_name;

                    //uplode the image
                    $upload = move_uploaded_file($src_path, $dest_path);

                    //check whether the image uploaded or not
                    if($upload==false)
                    {
                        //failed to upload
                        $_SESSION['upload'] = "<div class='error'>Failed to uploade image.</div>";
                        //redirect to manage food
                        header('location:'.SITEURL.'admin/manage-food.php');
                        //stop to process
                        die();
                    }
                     //3.remove the image if new image is uploaded and current image present
                    //part 2 remove old or current iamge if available
                    if($current_image!="")
                    {
                        //current image available
                        //remove image
                        $remove_path = "../images/food/".$current_image;

                        $remove = unlink($remove_path);

                        //check whether the image remove or not
                        if($remove==false)
                        {
                            //failed to remove current image
                            $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                            //redirect to manage food
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop the process
                            die();
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

             

              //4. update the food in databse
              $sql3 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
                ";
                //execue sqll query
                $res3 = mysqli_query($conn, $sql3);

                //check whether the query executed or not
                if($res3==true)
                {
                    //check whether and food upladed
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class='error'>Food Can NOt Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

             
           }

        ?>


    </div>
 </div>




<?php include('partials/footer.php'); ?>