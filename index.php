<?php
session_start();

if(isset($_SESSION['login']) && ($_SESSION['login'])=='login'){ 
    header("location:dashboard.php");
    exit;
}

if (isset($_SESSION['invalid'])){
    echo $_SESSION['invalid'];
    unset($_SESSION['invalid']);
    session_destroy();
}
include "connection.php";

    
    
if (isset($_POST['save'])){
    $email = $_POST['email'];
    $_SESSION['name']=$email;
    $password = $_POST['password'];
    $_SESSION['password']=$password;
    
    $query = mysqli_query($conn,"select * from users LEFT JOIN roles ON users.role = roles.id where email='$email' and password='$password'");
    
    $rowcheck = mysqli_num_rows($query);
    $userDetails = mysqli_fetch_array($query);
    if ($rowcheck){
        $_SESSION['role']=$userDetails['role'];
        $_SESSION['id']=$userDetails['user_id'];
        $_SESSION['loginstatus']=$userDetails['loginstatus'];
        $_SESSION['login']='login';
        header("location:dashboard.php?status=login");
        }
    
    else{
            $_SESSION['invalid']="<link rel='stylesheet' href='bootstrap.min.css'><h3 style='background-color: lightgrey; color:red;'>Either email or password is not valid...</h3>";
            header("location:index.php?status=invalid"); }
    
    }
    ?>
<!--     
    // $rowcheck = mysqli_num_rows($query);

    //     if ($rowcheck){
    //         $_SESSION['login']='login';
    //         // header("location:emplist.php?status=login");
    //     }
    //     else{
    //         $_SESSION['login_error']="<script>$.notify('Either email or password is not valid', 'info');</script>";
    //         // session_destroy();
            
    //         // header("location:login.php");
    //         // $.notify("Do not press this button", "info");
            
    //         // echo "$_SESSION['login_message']";
    //         // unset($_SESSION);

    //     }
// print_r($query); -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="">
    <title>Login Page</title>
    
</head>
<body>
    <div class="container col-6 mt-5 ">
        <form action="" method="post"> 
        <h1 class="mb-5">Login Form</h1>
        
    <div class='row'>
			<div class="form-group col-4">
				<label>Email-Address / Employee ID<font color="red">*</font>
				</label>
			</div>
			<div class="form-group col-8">
				<input type="text" class="form-control"  name="email" id="emails" placeholder="Enter E-mail" autocomplete="off" required>
			</div>
		</div>
		<div class='row'>
			<div class="form-group col-4">
				<label>Password<font color="red">*</font>
				</label>
			</div>
			<div class="form-group col-8">
				<input type="password" class="form-control"  name="password" id="password" placeholder="Password" autocomplete="off" required>
			</div>
		</div>
        <div class="row">

            <div class="col-sm-6 col-md-6 col-lg-6 mb-5">
                    <input type="submit" name="save" class="btn btn-success btn-block" value="Login">
            </div>
        </div>
    </form>
    </div>
    
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript" src="notifypopup.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="jqueryvalidation.js"></script>
    <script type="text/javascript" src="additionalmethodjquery.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="myscript.js"></script>
<?php
    if (isset($_GET['user'])){ ?>
        <script>
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You are not a Authentic user',
                }).then(function() {
                    window.location = "index.php";
                    });
                
                </script>
    <?php } ?>
</body>
</html>