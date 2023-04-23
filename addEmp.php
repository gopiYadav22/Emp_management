<?php
session_start();
if(!isset($_SESSION['login']) || ($_SESSION['login'])!='login'){ 
   header("location:login.php");
   exit;
}
include "connection.php";
// include "updateEmployee.php";
 						
					
// if (isset($_GET['id'])) {
//   $editId = $_GET['id'];
//   $query = "select * from employee_list where id='$editId'";
//   $query_run = mysqli_query($conn, $query);
//   $row = mysqli_fetch_array($query_run);
//   // print_r($row);

// }
// if (isset($_GET['status']) ){
//   $id = $_POST['id'];
//   // $id = $row['id'];
//   $fname = $_POST['fname'];
//   // print_r($fname);
//   $lname = $_POST['lname'];
//   $email = $_POST['email'];
//   $mobile = $_POST['mobile'];
//   $dob = $_POST['dob'];
//   $gender = $_POST['inlineRadioOptions'];
//   $education = $_POST['education'];
  
//   $newImage = $_FILES["photo"]["name"];
//   $oldImage = $_POST['oldImage'];
  

//    if ($newImage != ''){
//       $updated_img = $newImage;
// 	  $tempname = $_FILES["photo"]["tmp_name"];    
 
// 		$extension = (pathinfo($updated_img,PATHINFO_EXTENSION));
// 		$random = rand(0,100000);
// 		$time = time();
// 		$rename = 'Updated'.date('Ymd').$time.$random;
// 		$newname = $rename.'.'.$extension;
// 		$folder = "pics/".$newname;

// 		unlink("pics/".$oldImage);
		
//    }
//    else{
//      $newname = $oldImage;
//    }
  
//   // print_r($updocs);
//   move_uploaded_file($tempname, $folder);
//   $query1= "UPDATE employee_list SET firstname = '$fname', lastname = '$lname', email = '$email', mobile = '$mobile', dateofbirth = '$dob', gender = '$gender', education = '$education', photo = '$newname' WHERE id='$id'";
//   $query_run = mysqli_query($conn, $query1);
//   // $row1 = mysqli_fetch_array($query_run);
  
//   if($query_run){
        
//     header("location:emplist.php?status=updated");

//   }
//   else{
//     echo "NOT OK";
//   }

// }
//   if (isset($row['firstname']) && $row['firstname']!=''){
//     $fname = $row['firstname'];
//   }
//   else{
//     $fname = '';
//   }
  
//   if (isset($row['lastname']) && $row['lastname']!=''){
//     $lname = $row['lastname'];
//   }
//   else{
//     $lname = '';
//   }

//   if (isset($row['email']) && $row['email']!=''){
//     $email = $row['email'];
//   }
//   else{
//     $email = '';
//   }

//   if (isset($row['mobile']) && $row['mobile']!=''){
//     $mobile = $row['mobile'];
//   }
//   else{
//     $mobile = '';
//   }

//   if (isset($row['dateofbirth']) && $row['dateofbirth']!=''){
//     $dateofbirth = $row['dateofbirth'];
//   }
//   else{
//     $dateofbirth = '';
//   }

//   // print_r($row['gender']);
//   if (isset($row['gender']) && $row['gender']!=''){
//       $gender = $row['gender'];
//   }
//   else{    
//       $gender = " ";
//   }
  
  
//   if (isset($row['education']) && $row['education']!=''){
//     $education = $row['education'];
//   }
//   else{
//     $education = '';
//   }

//   if (isset($row['photo']) && $row['photo']!=''){
//     $photo = $row['photo'];   
//   }
//   else{
//     $photo = '';
//   }
  

  // if ((isset($_POST['update'])) && isset($_POST['id'])){
    // $editId = $_GET['id'];
    // $query = "select * from employee_list where id='$editId'";
    // $query_run = mysqli_query($conn, $query);
    // $row = mysqli_fetch_array($query_run);
    // print_r($row);
    // console.log($_POST['id']);
     
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register employee</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css"> 
    <!-- <link href="jqueryUIdatepicker.css" rel="stylesheet"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="/resources/demos/style.css"> -->
    <style>
      .error{
        color:red;
      }
    </style>
    </head>
    <body>

    <div class="container col-lg-6 col-xs-10 mt-5">
	<form id="addform" action="postAddEmp.php" method="post" enctype="multipart/form-data">
		<h1 class='mb-5'>Add Employee</h1>
		<div class='row'>
			<div class="form-group col-sm-3 col-md-3 col-lg-3">
				<label class="text">Employee ID<font color="red">*</font>
				</label>
			</div>
			<div class="form-group col-sm-9 col-md-9 col-lg-9">
				<input type="number" class="form-control" value="" name="empid" id="empid" placeholder="Employee ID" autocomplete="off">
			</div>
		</div>
    <div class='row'>
			<div class="form-group col-sm-3 col-md-3 col-lg-3">
				<label class="text">First Name<font color="red">*</font>
				</label>
			</div>
			<div class="form-group col-sm-9 col-md-9 col-lg-9">
				<input type="text" class="form-control" value="" name="fname" id="fnames" placeholder="Enter your first name" autocomplete="off">
			</div>
		</div>
		<div class='row'>
			<div class="form-group col-sm-3 col-md-3 col-lg-3">
				<label>Last Name<font color="red">*</font>
				</label>
			</div>
			<div class="form-group col-sm-9 col-md-9 col-lg-9">
				<input type="text" class="form-control" value="" name="lname" id="lnames" placeholder="Enter your last name" autocomplete="off">
			</div>
		</div>
		<div class='row'>
			<div class="form-group col-sm-3 col-md-3 col-lg-3">
				<label>Email-Address<font color="red">*</font>
				</label>
			</div>
			<div class="form-group col-sm-9 col-md-9 col-lg-9">
				<input type="email" class="form-control" value="" name="email" id="emails" placeholder="Enter E-mail" autocomplete="off">
			</div>
		</div>
		<div class='row'>
			<div class="form-group col-sm-3 col-md-3 col-lg-3">
				<label>Password<font color="red">*</font>
				</label>
			</div>
			<div class="form-group col-sm-9 col-md-9 col-lg-9">
				<input type="password" class="form-control" value="" name="password" id="password" placeholder="Password" autocomplete="off">
			</div>
		</div>
		<div class='row'>
			<div class="form-group col-sm-3 col-md-3 col-lg-3">
				<label>Date of Joining<font color="red">*</font>
				</label>
			</div>
			<div class="form-group col-sm-9 col-md-9 col-lg-9">
				<div class="input-group">
					<input class="form-control" name="doj" value="" data-date-format="dd/mm/yyyy" id="datepicker" placeholder="dd/mm/yyyy" autocomplete="off">
					<div class="input-group-append">
						<label class="input-group-text" for="datepicker"><i class="fa fa-calendar"></i>
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class="form-group col-sm-3 col-md-3 col-lg-3">
				<label for="designation">Designation<font color="red">*</font>
				</label>
			</div>
			<div class="form-group col-sm-9 col-md-9 col-lg-9">
				<select id="designation" name="designation" class="form-control">
					<option selected></option>
					<option >Developer</option>
					<option >Software Engineer</option>
					<option >Designer</option>
					<option >Tester</option>
				</select>
			</div>
		</div>
					
      <div class='row'>
        <div class="col-sm-6 col-md-6 col-lg-6 mt-5 mb-5">
          <button type="button" class="btn btn-danger btn-block" onclick="location.href='dashboard.php'">Back to Dashboard</button>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 mt-5 mb-5">
          <button type="submit" name="submitted" class="btn btn-success btn-block">Submit</button>
        </div>
		  </div>
		<br>
		
	</form>

</div>
    <script type="text/javascript" src="jquery.js"></script>
    <!-- <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script> -->
    <!-- <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script> -->
     <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	
    <!-- <script type="text/javascript" src="bootstrap_datepicker.min.js"></script> -->
    <script type="text/javascript" src="jqueryvalidation.js"></script>
    <script type="text/javascript" src="additionalmethodjquery.js"></script>
    <!-- <script type="text/javascript" src="notifypopup.js"></script> -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
	<!-- <script type="text/javascript">alert(/);</script> -->
    <script type="text/javascript" src="myscript.js"></script>
    
              
  </body>
</html>