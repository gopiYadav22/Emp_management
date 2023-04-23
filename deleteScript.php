<?php

include "connection.php";                        
if (isset($_GET['id'])){
    $recordId = $_GET['id'];

        $query = mysqli_query($conn,"DELETE FROM users WHERE id='$recordId'");    
        
        header("location:employeeList.php?status=deleted");
        
}
?>  