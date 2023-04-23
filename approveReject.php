<?php
    session_start();
    include "connection.php";
    
    if ($_GET['action']=='approved'){
        
        $id = $_GET['id'];
        $query = mysqli_query($conn,"UPDATE leave_status SET status = 'Approved' WHERE id = $id");
        // echo "Hello";
        header("location:dashboard.php");
        // echo "approved";
    }
    else if($_GET['action']=='savedModal'){
        echo $rejectedId = $_SESSION['rejectedId'];
        echo $reason = $_POST['reason'];
        // die;
        $query = mysqli_query($conn,"UPDATE leave_status SET status = 'Rejected', reason='$reason' WHERE id = $rejectedId");
        header("location:dashboard.php");
    }
    else{
        // echo $id = $_SESSION['rejectedId'];
        // $reason = $_POST['reason'];
        // $query = mysqli_query($conn,"UPDATE leave_status SET status = 'Rejected', reason='$reason' WHERE id = $id");
        
        // if($query){
            //     echo "ok";
            // }else{
                //     echo "not ok";
                // }
                
                // header("location:dashboard.php");
                
                // echo "rejected";
                
         }
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
</head>
<body>


<script type="text/javascript" src="jquery.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script type="text/javascript" src="bootstrap_datepicker.min.js"></script> -->
    <!-- <script type="text/javascript" src="jqueryvalidation.js"></script>
    <script type="text/javascript" src="additionalmethodjquery.js"></script>
    <script type="text/javascript" src="notifypopup.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="myscript.js"></script> -->

    <!-- <script type="text/javascript">
            $(window).on('load', function() {
                $('#forReason').modal('show');
            });
</script> -->
<!-- </body> -->
<!-- </html> -->