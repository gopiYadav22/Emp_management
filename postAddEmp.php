<?php 

include "connection.php";
include "classAndFunction.php";

    $obj = new crudOperations();

if (isset($_POST['submitted'])){
    $empId = $_POST['empid'];
    $fname = $_POST['fname']; 
    $lname = $_POST['lname']; 
    $email = $_POST['email']; 
    $password = $_POST['password']; 
    $doj = $_POST['doj']; 
    $designation = $_POST['designation'];
    
    $doj1 = date("Y-m-d", strtotime($doj));

    // $insertQuery = mysqli_query($conn, "INSERT into users (user_id,first_name,last_name,email,password,doj,designation) values('$empId','$fname','$lname','$email','$password','$doj1','$designation')");
    $obj->insert('users', ['user_id' => $empId,'first_name' => $fname,'last_name' => $lname,'email' =>$email, 'password' => $password,'doj' => $doj1,'designation' => $designation]);
    
    

    header("location:dashboard.php?status=added");
}

?>