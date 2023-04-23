<?php
    session_start();
         if(!isset($_SESSION['login']) || ($_SESSION['login'])!='login'){ 
            header("location:login.php");
            exit;
         }


        include "connection.php";
        $query = "select * from users";
        $query_run = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee list</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
    <style>
        .actionTh {
            min-width:150px ;
        }
    </style>
</head>

<body>
    <div>
    
            <a href="logout.php"><button style="float:right; position:fixed; right:0;" class="btn btn-danger mr-3">Logout <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i></button></a>
    </div>
    <div class="container my-3 ">
        <h1>Employee list</h1>
        <form>
        
        <div class='row'>
        
            <div class="col-sm-6 col-md-6 col-lg-6 mb-5 mt-3">
            <button type="button" class="btn btn-primary btn-block" onclick="location.href='dashboard.php'">Back to Dashboard</button>
          </div>
    </div>
    </form>
    
    <table id="employeeDataList" class="table table-bordered  table-striped" style="width:100%">
        <thead >
        <tr>
            <th>S.no</th>
            <th>Emp ID</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Joining Date</th>
            <th>Designation</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
            
            <?php 
                $i=1;
                foreach($query_run as $key => $value){
            ?>
                <tr>
                <td><?= $i++ ?></td>
                <td><?= $value['user_id'] ?></td>
                <td><?= $value['first_name'] ?></td>
                <td><?= $value['last_name'] ?></td>
                <td><?= $value['email'] ?></td>
                <td><?= date("d/m/Y", strtotime($value['doj'])) ?></td>
                <td><?= $value['designation'] ?></td>
                <td>

                <a href="testing.php?id=<?= $value['id']?>"class="btn btn-secondary ml-2"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                
                <a  class="btn btn-danger ml-2" href="deleteScript.php?id=<?= $value['id']?>);"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
            </tr>
                
            <?php } ?> 
        </tbody>    
    </table>
    </div>

    <script type="text/javascript" src="jquery.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script> -->
    <!-- <script type="text/javascript" src="bootstrap_datepicker.min.js"></script> -->
    <script type="text/javascript" src="jqueryvalidation.js"></script>
    <script type="text/javascript" src="additionalmethodjquery.js"></script>
    <script type="text/javascript" src="notifypopup.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="myscript.js"></script>


</body>
</html>