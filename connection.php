<?php
$conn =new mysqli('localhost','root','','kandidtechnology');
if($conn->connect_error){
    die('Connection Failed : '.$conn->connect_error);
}
?>