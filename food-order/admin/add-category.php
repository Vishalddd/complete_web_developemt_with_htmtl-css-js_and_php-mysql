<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Category</h1>
            <br><br>
            <?php
               if(isset($_SESSION['add']))
               {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
               }

               if(isset($_SESSION['upload']))
               {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
               }


            ?>
            <br><br>

            <!-- Add category form start -->

             <form action="" method="POST" enctype="multipart/form-data">
          
               <table class="tbl-30">
                <tr>
                    <td> Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td> Featured: </td>
                    <td>
                        <input type="radio" name="featured" value= "Yes">Yes
                        <input type="radio" name="featured" value= "No">No
                    </td>
                </tr>
                <tr>
                    <td> Active: </td>
                    <td>
                        <input type="radio" name="active" value= "Yes">Yes
                        <input type="radio" name="active" value= "No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                         <input type="submit" name="submit" value="Add Category" class="btn-secondary"/>   
                     </td>   
                </tr>
               </table>

             </form>

             <?php
                 //checked whether the submit button is clicked or not
                if(isset($_POST['submit']))
                {
                    //echo "clicked";

                    //get the value from category form
                    $title = mysqli_real_escape_string($conn, $_POST['title']);

                    //for radio input, we need gto check whther the button is sele cted or not
                    if(isset($_POST['featured']))
                    {
                        //get the value from form
                        $featured = $_POST['featured'];
                    }
                    else
                    {
                        //set deafult value
                        $featured = "No";
                    }
                    if(isset($_POST['active']))
                    {
                        //get the value from form
                        $active = $_POST['active'];
                    }
                    else
                    {
                        //set deafult value
                        $active = "No";
                    }
                    //check whether the image is selected or not and set the value for image accpordingly
                    //print_r($_FILES['image']);

                    //die();//break the code here

                    if(isset($_FILES['image']['name']))
                    {
                        //upload the image
                        //to upload image we need image name source path and designation path
                        $image_name = $_FILES['image']['name'];

                        //upload the image only if image is selected
                        if($image_name != "")
                           {

                                   //auto remain our image
                                   //get the extension of our image(jpg, png, gif, etc) e.g. "food.jpg"
                                   $ext = end(explode('.', $image_name));

                                   //rename the image
                                   $image_name = "food_category_".rand(000, 999).'.'.$ext;  //(.rand is random function to get a values in between 000 to 999 for replace the same image name before storing data in mysql)



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
                                       header('location:'.SITEURL.'admin/add-category.php');
                                       //STOP the process
                                       die();
                                   }

                            }
                    }
                    else
                    {
                        //dont uplaode the image and set the image _name value as break
                        $image_name = "";
                    }

                    // create sql query and save in database
                    $sql = "INSERT INTO tbl_category SET
                        title='$title',
                        image_name='$image_name',
                        featured='$featured',
                        active='$active'
                    ";

                    // execute the query and save in database
                    $res = mysqli_query($conn, $sql);

                    //check whether the query executed or not and data added or not
                    if($res==True)
                    {
                        //query executed and catyegory added
                        $_SESSION['add'] = "<div class='success'>Category added successfully.</div>";
                        //redirect to manage category page
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                    else
                    {
                        //failed to add category
                        $_SESSION['add'] = "<div class='error'>Failed to add Category.</div>";
                        //redirect to manage category page
                        header('location:'.SITEURL.'admin/add-category.php');

                    }
                        
                    

                }
            
             ?>

            <!-- Add category form end -->
        </div>
    </div>



<?php include('partials/footer.php'); ?>