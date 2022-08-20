<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br/><br/>

        <?php
            if(isset($_SESSION['add']))//checking wheather the session is set or not
            {
                echo $_SESSION['add'];//displaying session msg
                unset($_SESSION['add']);//removing session
            }
        ?>

        <form action="" method="POST">
          <table class="tbl-30">
            <tr>
                <td>Full Name: </td>
                <td>
                    <input type="text" name="full_name" placeholder="Enter Your Name"/>
                </td>
            </tr>
            <tr>
                <td>Username: </td>
                <td>
                    <input type="text" name="username" placeholder="Your Username"/>
                </td>
            </tr>
            <tr>
                <td>Password: </td>
                <td>
                    <input type="password" name="password" placeholder="Your Password"/>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Admin" class="btn-secondary"/>   
                </td>   
            </tr>
          </table>
        </form>
</div>
</div>


<?php include('partials/footer.php'); ?>

<?php
if(isset($_POST['submit']))
{
    
    // get the data from form
    $full_name =  mysqli_real_escape_string($conn, $_POST['full_name']);
    echo $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); //password encryption with MD5
    
    //sql query to save the data into datbase
    $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
            ";
       // executing query and saving data into databse      
      $res = mysqli_query($conn, $sql) or die(mysqli_error());

      // check whether the ( query is execyted )data is inserted or not and display appropiate massege
      if($res==True)
      {
        //data inserted
        //echo"data inserted";
        //create a session variable to display msg
        $_SESSION['add'] = "<div class='success'>Admin Added Succeessfully.</div>";
        //Redirect page to manage admin
        header("location:".SITEURL.'admin/manage-admin.php');
      }
      else{
        //failed to insert data
        //echo "data not inserted";
        //create a session variable to display msg
        $_SESSION['add'] = "<div class='error'>Feild To Add Admin.</div>";
        //Redirect page to add admin
        header("location:".SITEURL.'admin/add-admin.php');
        
      }
}

?>




