<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br/><br/>
        <?php
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
        }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="new Password">
                    </td>
                </tr>
                <tr>
                    <td>Conform Password: </td>
                    <td>
                        <input type="password" name="conform_password" placeholder="Conform Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    
    </div>
</div>
<?php

   //check whether the submit button is clicked or not
   if(isset($_POST['submit']))
   {
     //echo"clicked";

     // get the dsata from form
     $id = mysqli_real_escape_string($conn, $_POST['id']);
     $current_password = md5($_POST['current_password']);
     $new_password = md5($_POST['new_password']);
     $conform_password = md5($_POST['conform_password']);

     // check whether the user with current id and cureent password exists or not
     $sql = "SELECT * FROM tbl_admin WHERE id=$id And password='$current_password'";

     //execute the query
     $res = mysqli_query($conn, $sql);
     if($res==True)
     {
        //check whether data is available or not
        $count=mysqli_num_rows($res);
        if($count==1)
        {
            //user exist and password can be changew
            //echo "User Found";

            //checked whether new password and conform match or not
            if($new_password==$conform_password)
            {
                //echo "password match";
                //update the password
                $sql2 ="UPDATE tbl_admin SET
                password='new_password'
                where id=$id";
                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //check whether the query execute or not
                if($res2==True)
                {
                    //display success massage
                    //redirect to manage admin page with sucess massage
                    $_SESSION['change-pwd'] = "<div class='success'>Password Change Successfully.</div>";
                    // redirect the user
                     header('location:'.SITEURL.'admin/manage-admin.php');    
                }
                else
                {
                    //display error msg
                    // redirect to manage admin page with error msg
                    $_SESSION['change-pwd'] = "<div class='error'>Feild to change Password.</div>";
                // redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');
                }


            }
            else
            {
                $_SESSION['pwd-not-match'] = "<div class='error'>Password Did Not Match.</div>";
                // redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php');

            }
        }
        else
        {
           //user does not exist set msg and redirect
           $_SESSION['user-not-found'] = "<div class='error'>User Not Found. </div>";
           //redirect the user
           header('location:'.SITEURL.'admin/manage-admin.php');

        }
     }

     //check whether the new password and conform password match or not

     //change password if all are true
   }


?>


<?php include('partials/footer.php'); ?>