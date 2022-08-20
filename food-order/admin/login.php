<?php include('../config/constants.php') ?>

<html>
<head>
    <title> Login - Food Login System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login">
     
        <h1 class="text-center">Login</h1>
        <br><br>
        <?php
          if(isset($_SESSION['login']))
          {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
          }
          if(isset($_SESSION['no-login-massage']))
          {
            echo $_SESSION['no-login-massage'];
            unset($_SESSION['no-login-massage']);
          }

        ?>
        <br><br>

             <!-- Login From Start Here -->
             <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter Username"> <br><br>

                Password: <br>
                <input type="password" name="password" placeholder="Enter Password"><br><br>

                <input type="submit" name="submit" value="login" class="btn-primary">
                <br><br>
             </form>

             <!-- Login From End Here -->



        <p class="text-center">Created By - <a href="http://github.com/Vishalddd">Vishal Deshmukh</a></p>
    </div>
</body>
</html>

<?php

    //check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //process for the login
        //1.get data from login from
        //$username = $_POST['username'];
        //$password = md5($_POST['password']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        
        $raw_password = md5($_POST['password']); //with md5 it is all ready incripted
        $password = mysqli_real_escape_string($conn, $raw_password);
        //2. sql query to check username or password is exist or not
        $sql = "SELECT * from tbl_admin WHERE username='$username' AND password='$password'";

        //3.exicute the query
        $res = mysqli_query($conn, $sql);

        //4. count rows wether user is exist or not
        $count = mysqli_num_rows($res);
        if($count==1)
        {
            //user available and login success
            $_SESSION['login'] = "<div class='success text-center'>Login Successfully.</div>";
            $_SESSION['user'] = $username; // to checked whether the user is lookin or notand logout will unset it 
            //redirect to homae page/dashboard
            header('location:'.SITEURL.'admin/');
        }
        else{

            //user not available and login fails
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
            //redirect to homae page/dashboard
            header('location:'.SITEURL.'admin/login.php');

        }
    }

?>