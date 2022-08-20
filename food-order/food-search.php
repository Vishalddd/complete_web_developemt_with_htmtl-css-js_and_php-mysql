<?php include('partials-front/menu.php'); ?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php 
                
                //get the search keyword
                //$search = $_POST['search']; //old method
                $search = mysqli_real_escape_string($conn, $_POST['search']);//mysqli_real_escape_string it command used for to safe a searching from hackers
            
            ?>
            
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php
      
               //sql query to get foods based onm search keyword
               //$search = burger"; Drop Database name; 
               //"select * from tbl_food where title like '%%' or description like '%%';
               $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";//this query helps to identify a data on basis of title and discription becoz we gives post method with search keyword in database to our code
               //execute the query
               $res = mysqli_query($conn, $sql);

               //count rows
               $count = mysqli_num_rows($res);

               //check whether for available or not
               if($count>0)
               {
                //food available
                while($row=mysqli_fetch_assoc($res))//here we are geeting a data from datbase with with array
                {
                    //get the deatils
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];

                    ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">

                                <?php
                                    //check whether the image name is available or not
                                    if($image_name=="")
                                    {
                                        //iamge not available
                                        echo "<div class='error'>Image Not Available.</div>";
                                    }
                                    else
                                    {
                                        //image available
                                        ?>
                                          
                                          <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php

                                    }

                                ?>
                                
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">$<?php echo $price; ?></p>
                                <p class="food-detail">
                                     <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>


                    <?php
                }

               }
               else
               {
                 //food not available
                 echo "<div class='error'>Food Not Available.</div>";
               }
            ?>


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>