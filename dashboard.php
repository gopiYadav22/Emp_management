<?php
    session_start();
    if(!isset($_SESSION['login']) || ($_SESSION['login'])!='login'){ 
        header("location:index.php");
        exit;
    }
    if($_SESSION['loginstatus'] == 0){
        session_destroy();
        header("location:index.php?user=notAllowed");
        exit;
    }

    include "connection.php";
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
        .header{
            width:100%;
            height:80px;
            position: fixed;
            background: #563d7c;
            top:0;
            z-index: 1;
            display : flex;
        }
        .sidebar{
            width:150px;
            height:100%;
            position: fixed;
            background: #9276af;
            margin-top:80px;
            z-index: 1;
            top:0;
            
        }
        .mainbody{
            margin-left:150px;
            margin-top:80px;
            /* width:91%; */
            height: 100vh;
            /* position: fixed; */
            /* background: #aac7f3; */
            background:#ced4da ;
        }
        .leave{
            width:90%;
            text-align:center;
            margin:auto;
            margin-top:5;

        }
        .applybtn{
            width:90%;
            margin-left:8px;
        }
        
        .img{
            margin-right:20px;
            border-radius:50%;
            width:50px;
        }
        .profile{
            /* text-align:right; */
            float: right;
            margin-top:10px;
            margin-left:auto;
            margin-right:5;
            color: white;
        }
        .logoutbtn{
            /* text-align:right; */
            /* position:fixed; */
            margin-top:18px;
            /* margin-right:5px; */
            /* float:right; */
            /* color: white; */
        }
        .container{
            height:100%;

        }
        .kandidlogo{
            margin-left:10px;
            margin-top:10px;
            margin-right:auto;
            /* display:block; */
        } 
        .error{
            color:red;
        }
    </style>
</head>

<body>
    
    <div class="header">
        <div class="kandidlogo">
            <img src="pics/kandidlogo.png">
        </div>
        <div class="profile">Hello!, <?= $_SESSION['name'] ?> <img class="img" src="pics/user.png">
        </div>
        <div class="logout">
            <a href="logout.php"><button  class="btn btn-danger mr-3 logoutbtn">Logout <i class="fa fa-sign-out fa-lg" ></i></button></a>
        </div>
    </div>
    <div class="sidebar ">

        <a  class="form-control btn-dark mt-3 leave" href="">Dashboard</a>
        <?php if(($_SESSION['role'])=='Employee'){?>
            <button type="button" class="btn btn-dark mt-3 applybtn" data-toggle="modal" data-target="#exampleModalCenter">Apply for leave </button>
        <?php } ?>

        <?php if(($_SESSION['role'])=='Admin'){?>
            <a class="form-control btn-dark mt-3 leave" href="addEmp.php">Add Employee</a>
            <a class="form-control btn-dark mt-3 leave" href="employeeList.php">Employee List</a>
        <?php } ?>
    </div>
    <div class="mainbody ">
        <?php if(($_SESSION['role'])=='Employee'){ ?>  
        <div class="container col-10">
        
            <h1>Leave balance</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-striped ">
                <thead class="thead-dark">
                    <tr>
                        <!-- <th scope="col">S.no</th> -->
                        <th >Total leave</th>
                        <th>Emergency leave</th>
                        <th>Casual leave</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $leaveid = $_SESSION['id'];
                        $query3 = mysqli_query($conn,"select * from leaves where id=$leaveid");
                                        while($values = mysqli_fetch_array($query3)){
                    ?>
                    <tr>
                        <!-- <td > 1</td> -->
                        <td >  <?= $values['totalleave'] ?> </td>
                        <td > <?= $values['emergency'] ?> </td>
                        <td > <?= $values['casualleave'] ?> </td>
                        
                    </tr>
                    <?php } ?>

                </tbody>
                </table>
            </div>
            <!-- <button class="btn btn-success applyleave" type="button" data-target="#leaveStatus" data-toggle="modal" >Apply for leave</button> -->
            <br><br>
            <h1>Leave Status</h1>
            <div class="table-responsive">
                <table id="leaveStatus" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <!-- <th scope="col">S.no</th> -->
                            <th >S.no</th>
                            <th >From</th>
                            <th >To</th>
                            <th >Total days</th>
                            <th >Applied date</th>
                            <th >Comment</th>
                            <th >Status</th>
                            <th >Reason</th>
                            <th >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                
                        <?php $id=1; 
                            $emp_id=$_SESSION['id'];

                            $queryLeaveDetail = mysqli_query($conn,"select * from leave_status where emp_id=$emp_id ORDER BY status='Approved', status='Rejected'");
                            // $leavedetail = mysqli_fetch_array($queryLeaveDetail);
                            foreach($queryLeaveDetail as $key => $value){
                        ?>
                        <tr>
                            <!-- <td > 1</td> -->
                            <td > <?= $id++ ?> </td>
                            <td > <?= date("d/m/y", strtotime($value['fromdate'])) ?> </td>
                            <td > <?= date("d/m/y", strtotime($value['todate'])) ?> </td>
                            <td style="text-align:center"> <?= $value["totaldays"] ?> </td>
                            <td > <?= date("d/m/y", strtotime($value["applieddate"])) ?> </td>
                            <td > <?= $value["comment"] ?> </td>
                            <td > <?= $value["status"] ?> </td>
                            <?php if($value["status"]=='Rejected'){ ?><td > <?= $value["reason"] ?></td><?php }else{ ?><td></td> <?php } ?>
                            <?php if($value["status"]=='Pending'){ ?><td > <a class="btn btn-danger" href="deleteEmployeeleaves.php?id=<?= $value["id"] ?>" style="color:white">Cancel</a></td><?php }else{ ?><td></td> <?php } ?>
                            
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <form id="applyForLeave" action="post_leave_details.php" method="post">
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Apply form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">  
                                <label for="fromdate">From:</label>
                                <input type="text" class="form-control readonly" id="fromdate" name="fromdate" id="datepicker" placeholder="From" autocomplete="off">
                            </div>
                            <div class="col-6">  
                                <label for="todate">To:</label>
                                <?php 
                                    $query4 = mysqli_query($conn,"select * from leaves where id=$leaveid");
                                    while($valuesOfRows = mysqli_fetch_array($query4)){ 
                                ?>
                                    <input type="text" class="form-control readonly" id="todate" name="todate"  id="datepicker" placeholder="To" autocomplete="off">
                                    <input type="hidden" class="form-control" id="casual" name="casual" value="<?= $valuesOfRows['casualleave'] ?>">
                                    <input type="hidden" class="form-control" id="emergency" name="emergency" value="<?= $valuesOfRows['emergency'] ?>">
                                <?php } ?>
                            </div>
                            <small class="ml-3" id='emerLeaveMessage'></small>
                        </div>
                        <div class="row">
                            <div class="col-12">  
                                <label>Leave Type:</label>
                                <div class="dropdown">
                                    <select id="leavetypes" name="leavetype" class="form-control">
                                        <option value="Full day">Full Day</option>
                                        <optgroup label="Half Day">
                                        <option value="First half">First half</option>
                                        <option value="Second half">Second Half</option>
                                    </optgroup>
                                    </select>
                                    <!-- <select><option value="">1</option><option value="">2</option></select> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">  
                                <label class="form control">Reason:</label>
                                <!-- <input type="textarea" class="form-control" name="dob" value="" placeholder="Your comment here..." autocomplete="off"> -->
                                <textarea  class="form-control" name="comment" id="" cols="6" rows="3" ></textarea>    
                            </div>
                        </div> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button id="applyLeavebtn" type="submit" name="leavestatus" class="btn btn-primary">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php }else if(($_SESSION['role'])=='Admin'){ ?>
        
        <div class="container col-10">
            <h1>Action on leaves</h1>
            <div class="table-responsive">
                <table id="approvedleaves" class="table table-bordered table-striped ">
                    <thead class="thead-dark">
                        <tr>
                            <!-- <th scope="col">S.no</th> -->
                            <th >S.no</th>
                            <th >Emp ID</th>
                            <th >Name</th>
                            <th >From</th>
                            <th >To</th>
                            <th >Status</th>
                            <th >Total days</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query2 = mysqli_query($conn,"select * from leave_status LEFT JOIN users ON leave_status.emp_id = users.user_id where status='Approved' or status='Rejected' ORDER BY id DESC");
                            // echo $row = mysqli_fetch_array($query2);
                            $id2=1; 
                            while($values = mysqli_fetch_array($query2)){
                        ?>
                
                        <tr>
                            <td > <?= $id2++ ?> </td>
                            <td > <?= $values['emp_id'] ?> </td>
                            <td > <?= $values['first_name'] ?> </td>
                            <td > <?= date("d/m/y", strtotime($values['fromdate'])) ?> </td>
                            <td > <?= date("d/m/y", strtotime($values['todate'])) ?> </td>
                            <td > <?= $values['status'] ?> </td>
                            <td style="text-align:center"> <?= $values["totaldays"] ?> </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- <button class="btn btn-success applyleave" type="button" data-target="#leaveStatus" data-toggle="modal" >Apply for leave</button> -->
            <br><br>
            <h1>Pending Leaves</h1>
            <div class="table-responsive">
                <table id="leaveStatus" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <!-- <th scope="col">S.no</th> -->
                            <th >S.no</th>
                            <th >Emp ID</th>
                            <th >First name</th>
                            <th >From</th>
                            <th >To</th>
                            <th >Applied date</th>
                            <th >Comment</th>
                            <th >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <?php
                            $query1 = mysqli_query($conn,"select * from leave_status LEFT JOIN users ON leave_status.emp_id = users.user_id where status='Pending' ORDER BY applieddate DESC");
                            // $pendingLeaves = mysqli_fetch_array($query1);
                            // print_r($pendingLeaves);
                            $id1=1; 
                            
                            while($values = mysqli_fetch_array($query1)){
                                // print_r($values);
                        ?>
                            <tr>
                                <!-- <td > 1</td> -->
                                <td > <?= $id1++ ?> </td>
                                <td > <?= $values['emp_id'] ?> </td>
                                <td > <?= $values['first_name'] ?> </td>
                                <td > <?= date("d/m/y", strtotime($values['fromdate'])) ?> </td>
                                <td > <?= date("d/m/y", strtotime($values['todate'])) ?> </td>
                                <td > <?= date("d/m/y", strtotime($values["applieddate"])) ?> </td>
                                <td > <?= $values["comment"] ?> </td>
                                <!-- <td > <button class="btn btn-success" name="approved" onclick="window.location='dashboard.php?approvedId=&status=approve'">Approve</button> -->
                                <td > <button class="btn btn-success" name="approved" onclick="hello()">Approve</button>
                                <a href="dashboard.php?rejectedId=<?= $values['id'] ?>&action=rejected"  class="btn btn-danger ml-2" name="rejected">Reject</a> </td>                            
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <form action="approveReject.php?action=savedModal" method="post">    
            <div class="modal fade" id="forReason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reason</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">  
                                    <!-- <input type="textarea" class="form-control" name="dob" value="" placeholder="Your comment here..." autocomplete="off"> -->
                                    <textarea  class="form-control" name="reason" id="" cols="6" rows="3"></textarea>    
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='dashboard.php';"  data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" name='rejected' style="color:white">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
       
    <?php } ?>


     
    <script type="text/javascript" src="jquery.js"></script>
    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <!-- <script type="text/javascript" src="bootstrap_datepicker.min.js"></script> -->
    <script type="text/javascript" src="jqueryvalidation.js"></script>
    <script type="text/javascript" src="additionalmethodjquery.js"></script>
    <script type="text/javascript" src="notifypopup.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="myscript.js"></script>
    <script>
        $(".readonly").keydown(function(e){
            e.preventDefault();
        });
        
        function hello(){    
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                }
            })
        }
    </script>
    
    <?php
         if ($_GET['action']='rejected' && isset($_GET['rejectedId'])){
             $_SESSION['rejectedId'] = $_GET['rejectedId'];
             echo "<script>$('#forReason').modal('show');</script>";
             // echo "<script>window.location.href='approveReject.php?id=$id';</script>";
         }

    if(isset($_GET['status'])){
        if($_GET['status']=='applied'){ ?>

            <script>
                Swal.fire(
                    'Successfully Applied!',
                ).then(function() {
                    window.location = "dashboard.php";
                });
                
            </script>
        <?php }
        
        if($_GET['status']=='added'){ ?>

            <script>
                Swal.fire(
                    'Successfully Added!',        
                ).then(function() {
                    window.location = "dashboard.php";
                });
                    
            </script>
        <?php }
        if($_GET['status']=='deletedrecord'){ ?>

            <script>
            Swal.fire(
                'Successfully canceled!',
            ).then(function() {
                window.location = "dashboard.php";
            });
            
            </script>
        <?php } 
        if($_GET['status']=='login'){ ?>

            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'success',
                    title: 'logged in successfully'
                }).then((toast) => {
                    if (toast) {
                        window.location.href="dashboard.php";
                    }
                });

            </script>
        <?php } ?>

        <?php if($_GET['status']=='approve'){ 
            $recordId = $_GET['approvedId'];
        ?>
                    
            <script>
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href="approveReject.php?id=<?= $recordId ?>&action=approved";
                    }
                });

            </script>
    <?php }}; ?>  
            
</body>
</html>