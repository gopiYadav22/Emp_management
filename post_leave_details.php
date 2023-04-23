<?php
    session_start();

include "connection.php";

if(isset($_POST['leavestatus'])){
    date_default_timezone_set("Asia/Kolkata");
    $emp_id=$_SESSION['id'];
    $fromDate1 = $_POST['fromdate'];
    $toDate1 = $_POST['todate'];
    $leavetype = $_POST['leavetype'];
    $comment = $_POST['comment'];
    //converting date(d/m/Y) to Y-m-d format to save into database
    $fromDate = date("Y-m-d", strtotime($fromDate1));
    $toDate = date("Y-m-d", strtotime($toDate1));
    $totaldays = (ceil(abs( strtotime($fromDate) - strtotime($toDate) ) / 86400)+1);
    
    $appliedDate = date('Y-m-d');
    
    $daysGap = (ceil(abs( strtotime($fromDate) - strtotime($appliedDate) ) / 86400));
    $date1 = $appliedDate. ' ' .date('H:i:s');
    $date2 = $fromDate. ' ' . '10:00:00' ;
    $timestamp1 = strtotime($date1);
    $timestamp2 = strtotime($date2);
    echo $hours = ceil(abs($timestamp2 - $timestamp1)/(60*60));

    $leaveid = $_SESSION['id'];
    $query3 = mysqli_query($conn,"select * from leaves where id=$leaveid");
    $leaveValues = mysqli_fetch_array($query3);
    
    if($totaldays > 1 && $daysGap > 1){
            $newCasualLeave = $leaveValues['casualleave'] - $totaldays;
            $newEmerLeave = $leaveValues['emergency'];
            $isemergency = 'no';
                if ($newCasualLeave < 0 ){
                        // echo "<script language='javascript'>";
                        // echo 'alert("You don\'t have that much leaves left!! Fill dates again.");';
                        // echo 'window.location.replace("dashboard.php");';
                        // echo "</script>";
                }     
        
    }else if($hours <= 24 && $daysGap <= 1 && $totaldays <= 1){        
            $newCasualLeave = $leaveValues['casualleave'];
            $newEmerLeave = $leaveValues['emergency'] - 1;
            $isemergency = 'yes';
            if ($newEmerLeave < 0 ){
                // echo "<script language='javascript'>";
                // echo 'alert("You don\'t have that much leaves left!! Fill dates again.");';
                // echo 'window.location.replace("dashboard.php");';
                // echo "</script>";
        }

    }else if($appliedDate == $fromDate && $appliedDate == $toDate){
            $newCasualLeave = $leaveValues['casualleave'];
            $newEmerLeave = $leaveValues['emergency'] - 1;
            $isemergency = 'yes';
            if($newEmerLeave < 0){
                // echo "<script language='javascript'>";
                // echo 'alert("You don\'t have that much leaves left!! Fill dates again.");';
                // echo 'window.location.replace("dashboard.php");';
                // echo "</script>";
                }

    }else if($totaldays > 1 && $daysGap <=1){
            $newCasualLeave = $leaveValues['casualleave'] - ($totaldays-1);
            $newEmerLeave = $leaveValues['emergency'] - 1;
            $isemergency = 'both';
            if($newCasualLeave < 0 || $newEmerLeave < 0){
                // echo "<script language='javascript'>";
                // echo 'alert("You don\'t have that much leaves left!! Fill dates again.");';
                // echo 'window.location.replace("dashboard.php");';
                // echo "</script>";
                }

    }else if($totaldays==1){
            $newCasualLeave = $leaveValues['casualleave'] - $totaldays;
            $newEmerLeave = $leaveValues['emergency'];
            $isemergency = 'no';
    }
    
    

    // die;
    $status= 'Pending';
    $query = mysqli_query($conn,"Insert into leave_status(emp_id,fromdate,todate,totaldays,isemergency,applieddate,leavetype,comment,status) values('$emp_id','$fromDate','$toDate','$totaldays','$isemergency','$appliedDate','$leavetype','$comment','$status')");
    $query = mysqli_query($conn,"UPDATE leaves SET casualleave=$newCasualLeave, emergency=$newEmerLeave where id=$emp_id");  
    if($query){
        header("location:dashboard.php?status=applied");
    }
    else{
        echo "fail";
    }
    }
?>