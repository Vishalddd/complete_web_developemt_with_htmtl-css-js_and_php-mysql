<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                       <textarea name="description"  cols="30" rows="5" placeholder="Description Of The Table"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                       <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            //create php code to display categaries from database
                            //1. create sql to get all active categories from database
                            $sql = "SELECT * FROM tbl_category Where active='Yes'";//active madye yes ya sathi takala karan ti string value ahe but ti integer asti tr mug '' yat value nast ghetal
                            //Executing Query
                            $res = mysqli_query($conn, $sql);

                            //count rows tocheck whether we have categories or not
                            $count = mysqli_num_rows($res);

                            //if count is greter than zero, we have categories else we donot have category
                            if($count>0)
                            {
                                //we have categories
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    //get the deatils of categories
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //we do not have categories
                                ?>
                                <option value="0">No Category Found</option>
                                <?php

                            }

                            //2.display dropdpown
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No

                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>


            </table>
        </form>
        <?php

           //check whether the button is clicked or not
           if(isset($_POST['submit']))
           {
            //add the food in database
            //echo "clicked";
            //1. get the data from form
            $title = mysqli_real_escape_string($conn,  $_POST['title']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = mysqli_real_escape_string($conn, $_POST['price']);
            $category = mysqli_real_escape_string($conn, $_POST['category']);

            //check whether radion bbutton for feartured and active are checked or not
            if(isset($_POST['featured']))
            {
                $featured = $_POST['featured'];
            }
            else
            {
                $featured = "NO"; //setting dafult value

            }
            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = "No"; //setting dafult value

            }

            //2. uplode the image if selected
            //check whether the selectr image is clicked or not and upload the image only if the image is selected
            if(isset($_FILES['image']['name']))
            {
                //get the details of the selected image
                $image_name = $_FILES['image']['name'];

                //check whether the image is seected or not and upload image only if selected
                if($image_name != "")
                {
                    //image is selected
                    //A. rename the image
                    //get the extansion of selected image like jpg, png, gif etc.
                    $ext = end(explode('.', $image_name));//explanation at the time of recognization of image extension that that the it code select only part after . so that why we use end function with explode it is type of array

                    //ctreate new name for image
                    $image_name = "Food-Name-".rand(0000,9999).".".$ext;//new image name may be like food-name-2345


                    //b. upload the image
                    //get the source path and destination path

                    //source path is the current location of the image
                    $src = $_FILES['image']['tmp_name'];

                    //destination path
                    $dst = "../images/food/".$image_name;

                    //finally uploade the food image
                    $upload = move_uploaded_file($src, $dst);
                    //check whether image uploded or not
                    if($upload==false)
                    {
                        //failed to uploade the image
                        //redirect to add food page with error message
                        $_SESSION['upload'] = "<div class='error'>Failed To upload Image</div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                        //stop the process
                        die();
                    }
                } 

            }
            else
            {
                $image_name = ""; //setting dafault values as blank

            }

            //3. insert into databse
            // create sql query to save or add food 
            $sql2 = "INSERT INTO tbl_food SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name ='$image_name',
                category_id = '$category_id',
                featured = '$featured',
                active = '$active'
            ";
            //execute the query
             $res2 =  mysqli_query($conn, $sql2);
             //check  whether the data inserted or not 
              //4. redirect with message to manage food page

             if($res2 == true)
             {
                //data inserted vsuccessfully
                $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
             }
             else
             {
                //failed to insert the data
                $_SESSION['add'] = "<div class='error'>Failed To Insert food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php'); 
             }

           }

        ?>




    </div>
</div>

<?php include('partials/footer.php'); ?>