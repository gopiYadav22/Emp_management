<?php
session_start();

include "connection.php";  
                    
if (isset($_GET['id'])){
        $emp_id = $_SESSION['id'];
        $recordId = $_GET['id'];
        $query1 = mysqli_query($conn,"SELECT * from leave_status where id = $recordId");
        $query1row = mysqli_fetch_array($query1);
        print_r($query1row);
        // die;
        $query3 = mysqli_query($conn,"SELECT * from leaves where id=$emp_id");
        $leaveValues = mysqli_fetch_array($query3);
        if($query1row['isEmergency'] == 'no'){
            $newCasualLeave = $leaveValues['casualleave'] + $query1row['totaldays'];
            $newEmerLeave = $leaveValues['emergency'];
        }
        else if($query1row['isEmergency'] == 'yes'){
            $newCasualLeave = $leaveValues['casualleave'];
            $newEmerLeave = $leaveValues['emergency'] + 1;
        }
        else{
            $newCasualLeave = $leaveValues['casualleave'] + ($query1row['totaldays']-1);
            $newEmerLeave = $leaveValues['emergency'] + 1;
        }  
              
        $updatequery = mysqli_query($conn,"UPDATE leaves SET casualleave=$newCasualLeave, emergency=$newEmerLeave where id=$emp_id"); 
        
        $query = mysqli_query($conn,"DELETE FROM leave_status WHERE id='$recordId'");
        // $result = $conn->query($query) or die("Error in query2".$conn->error);
        if($query){
        header("location:dashboard.php?status=deletedrecord");
        }
        else{
        echo "hello";            }
}
?>  