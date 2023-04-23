$(document).ready(function () {
	$("#employeeDataList").DataTable();
	$("#leaveStatus").DataTable();
	$("#approvedleaves").DataTable();
	// alert($.datepicker.formatDate('dd/mm/yy', new Date()));
	var startDate;
	var endDate;
	$("#datepicker").datepicker({
		dateFormat: "dd/mm/yy",
		changeMonth: true,
		changeYear: true,
		yearRange: "1900:2022",
	});
	if (new Date().getHours() >= 10 && new Date().getHours() <= 23) {
		var $date = "+1d";
	} else {
		var $date = new Date();
	}

	$("#fromdate").datepicker({
		dateFormat: "dd-mm-yy",
		changeMonth: true,
		minDate: $date,
		// changeYear: true,
		// yearRange: '2021:2025'
	});
	$("#todate").datepicker({
		dateFormat: "dd-mm-yy",
		changeMonth: true,
		// changeYear: true,
		// yearRange: '2021:2025'
	});
	$("#fromdate").change(function () {
		startDate = $(this).datepicker("getDate");
		$("#todate").datepicker("option", "minDate", startDate);
	});

	$("#todate").change(function () {
		endDate = $(this).datepicker("getDate");
		$("#fromdate").datepicker("option", "maxDate", endDate);
	});

	$.validator.setDefaults({
		errorPlacement: function (error, element) {
			if (element.prop("type") === "checkbox") {
				error.insertAfter(element.parent());
			} else if (element.prop("type") === "radio") {
				error.insertAfter(element.parent());
			} else if (element.prop("name") === "doj") {
				error.insertAfter(element.parent());
			} else {
				error.insertAfter(element);
			}
		},
	});
	$.validator.addMethod("filesize", function (value, element, param) {
		// param = size (in bytes)
		// element = element to validate (<input>)
		// value = value of the element (file name)
		return this.optional(element) || element.files[0].size <= param;
	});

	$("#applyForLeave").validate({
		rules: {
			fromdate: {
				required: true,
			},
			todate: {
				required: true,
			},
			leavetype: {
				required: true,
			},
			comment: {
				required: true,
			},
		},
		messages: {
			fromdate: {
				required: "**please select your date",
			},
			todate: {
				required: "**please select your date",
			},
			leavetype: {
				required: "**please select your leave type",
			},
			comment: {
				required: "**please enter your reason",
			},
		},
	});

	$("#addform").validate({
		rules: {
			empid: {
				required: true,
			},
			fname: {
				required: true,
			},
			lname: {
				required: true,
			},
			email: {
				required: true,
			},
			password: {
				required: true,
			},
			doj: {
				required: true,
			},
			designation: {
				required: true,
			},
		},
		messages: {
			empid: {
				required: "**please give unique ID",
			},
			fname: {
				required: "**please enter your first name",
			},
			lname: {
				required: "**please enter your last name",
			},
			email: {
				required: "**please enter a valid email",
				email: "**please enter a valid email",
			},
			password: {
				required: "**please enter your mobile number",
			},
			doj: {
				required: "**please fill your date of birth",
			},
			designation: {
				required: "**select your latest education",
			},
		},
	});
	$("#updocs").change(function () {
		const file = this.files[0];
		// console.log(file);
		if (file) {
			let reader = new FileReader();
			reader.onload = function (event) {
				// console.log(event.target.result);
				$("#imgPreview").attr("src", event.target.result);
			};
			reader.readAsDataURL(file);
		}
	});

	$("#todate").change(function () {
		var fromDate = $("#fromdate").val();
		var toDate = $("#todate").val();
		var casual = $("#casual").val();
		var emergency = $("#emergency").val();
		var datearray = fromDate.split("-");
		var newdate = datearray[1] + "-" + datearray[0] + "-" + datearray[2];
		var datearray1 = toDate.split("-");
		var newdate1 = datearray1[1] + "-" + datearray1[0] + "-" + datearray1[2];

		var date1 = new Date(newdate);
		var date2 = new Date(newdate1);
		var appliedDate =
			new Date().getMonth() +
			1 +
			"-" +
			new Date().getDate() +
			"-" +
			new Date().getFullYear();
		// var time = new Date().getHours() + ":" + new Date().getMinutes()+ ":" +new Date().getSeconds();
		console.log(casual);

		// document.write(emergency);
		// return;
		//calculate time difference
		var time_difference = date2.getTime() - date1.getTime();
		//calculate days difference by dividing total milliseconds in a day
		var days_difference = time_difference / (1000 * 60 * 60 * 24) + 1;
		// document.write(days_difference + " days");
		// document.write(days_difference);
		// return;
		var apply_to_from = date1.getTime() - new Date().getTime();
		var apply_to_from_hours = apply_to_from / (1000 * 60 * 60) + 1;
		if (days_difference == 1) {
			// alert(apply_to_from_days);
			if (apply_to_from_hours <= 24) {
				$("#emerLeaveMessage").html(
					"**This will be considered as Emergency leave"
				);
				$("#emerLeaveMessage").css("color", "red");
				$("#emerLeaveMessage").show();
				document.getElementById("applyLeavebtn").disabled = false;
			}
		}
		//    else if(days_difference <= 1+casual){
		//         $('#emerLeaveMessage').html("**you don't have that much leaves left, reselect ");
		//         $('#emerLeaveMessage').css("color","red");
		//         $('#emerLeaveMessage').show();
		//         document.getElementById("applyLeavebtn").disabled = true;
		else if (apply_to_from_hours <= 24 && days_difference > 1) {
			$("#emerLeaveMessage").html(
				"**1 day will be considered as Emergency leave rest as Casual leave"
			);
			$("#emerLeaveMessage").css("color", "red");
			$("#emerLeaveMessage").show();
			document.getElementById("applyLeavebtn").disabled = false;
		} else if (days_difference > casual) {
			$("#emerLeaveMessage").html(
				"**you don't have that much leaves left, reselect dates"
			);
			$("#emerLeaveMessage").css("color", "red");
			$("#emerLeaveMessage").show();
			document.getElementById("applyLeavebtn").disabled = true;
		} else {
			$("#emerLeaveMessage").html("");
			document.getElementById("applyLeavebtn").disabled = false;
		}

		// document.write(date+' '+time +"<br>"+ newdate+' '+'10:00:00');
		// document.write(date1);
	});
});
function deleterow(recordId) {
	// alert(recordId);return;
	Swal.fire({
		title: "Are you sure?",
		text: "You won't be able to revert this!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, delete it!",
	}).then((result) => {
		if (result.isConfirmed) {
			window.location.href = "deleteScript.php?id=" + recordId;
		}
	});
}

// $("#myform").validate({
//     rules:{
//         fname:{
//             required: true,
//             minlength:2,
//             maxlength:15
//         },
//         lname:{
//             required:true,
//             minlength:2,
//             maxlength:15
//         },
//         email:{
//             required:true
//         },
//         mobile:{
//             required:true,
//             phoneUS: true,
//         },
//         dob:{
//             required:true
//         },
//         inlineRadioOptions:{
//             required:true
//         },
//         education:{
//             required:true
//         },
//         photo:{
//             required:function(element) {
//                 var action = $("#oldImage").val();
//                 // alert(action);return;
//                 if(action) {
//                     return false;
//                 } else {
//                     return true;
//                 }
//             },

//             filesize: 1048576,
//             accept: 'image/*',

//         },
//         checkbo:{
//             required:true
//         }

//     },
//     messages:{
//         fname:{
//             required: "**please enter your first name",
//             minlength: "**minimum length should be 2",
//             maxlength: "**maximum length should be 15",
//         },
//         lname:{
//             required:'**please enter your last name',
//         },
//         email:{
//             required:"**please enter a valid email",
//             email:"**please enter a valid email"
//         },
//         mobile:{
//             required:"**please enter your mobile number",
//             phoneUS:"**enter valid phone number",
//         },
//         dob:{
//             required:"**please fill your date of birth"
//         },
//         inlineRadioOptions:{
//             required:"**fill your gender"
//         },
//         education:{
//             required:"**select your latest education"
//         },
//         photo:{
//             required:"**file not uploaded",
//             filesize:"**file size should be less than 1MB",
//             // accept:"**please enter a valid file type"
//         },
//         checkbo:{
//             required:"**please read the terms and condition"
//         },
//     }

// });

// $('.view_data').click(function(id){
//     console.log(id);

// var employee_id = $(this).attr("id");
// if (employee_id != '') {
//     $.ajax({
//         url: "viewEmployeeData.php",
//         method: "POST",
//         data: {
//             employee_id: id
//         },
//         success: function(data) {
//             $('#employee_detail').html(data);
//             // $('#dataModal').modal('show');
//         }
//     });
// }
// });

// $('table th').resizable({
//     handles: 'e',
//     stop: function(e, ui) {
//     $(this).width(ui.size.width);
//     }
// });

// function getdata(){
//     $.ajax({
//         type: "GET",
//         url: "fetch.php",
//         success: function (response) {
//             var $sr=1;
//             $.each(response, function (key, value) {

//             // console.log(value['firstname']);
//                 $('.employeelist').append('<tr>'+
//                     '<td>'+value[$sr]+'</td>\
//                     <td>'+value['firstname']+'</td>\
//                     <td>'+value['lastname']+'</td>\
//                     <td>'+value['email']+'</td>\
//                     <td>'+value['mobile']+'</td>\
//                     <td>'+value['dateofbirth']+'</td>\
//                     <td>'+value['gender']+'</td>\
//                     <td>'+value['education']+'</td>\
//                     <td>'+value['photo']+'</td>\
//                 </tr>');
//             });
//             $sr++;
//         }
//     });
// }

// Swal.fire(
//     'Deleted!',
//     'Your file has been deleted.',
//     'success',
//     )
// recordId=<?php echo $recordId?>
// $.ajax({
//     url: "deleteScript.php",
//     type: "POST",
//     data: {
//         id: recordId
//     },
// dataType: "html",
// success: function (response) {
// }
// location.reload(true);

//             // table.ajax.reload();
//             // DataTable().ajax.reload();
//             // table.rows.add(jsonData).draw();

//             // $('#employeeDataList').DataTable().ajax.reload();
//     },
//     // location.reload(true);
// });
// $("#employeeDataList").DataTable().ajax.reload();

// function reloadDatatable(){
//     datatable().draw();
// }

// $(document).ready(function(){

//     $('#datepicker').datepicker({
//     autoclose: true,
//     });

//     $('#fnamecheck').hide();
//     $('#lnamecheck').hide();
//     $('#emailcheck').hide();
//     $('#mobilecheck').hide();
//     $('#dobcheck').hide();
//     $('#gendercheck').hide();
//     $('#educationcheck').hide();
//     $('#uploadcheck').hide();
//     $('#checkbox').hide();

//     var gender = document.getElementsByName('inlineRadioOptions');
//     var fname_err = true;
//     var lname_err = true;
//     var email_err = true;
//     var mobile_err = true;
//     var dob_err = true;
//     var gender_err = true;
//     var education_err = true;
//     var uploadfile_err = true;
//     var checkbox_err = true;

//     $('#fnames').keyup(function(){
//         fname_check();
//     });
//     function fname_check(){
//     var fname_val = $('#fnames').val();

//     if (fname_val.length == '' || fname_val.length == null){
//         $('#fnamecheck').show();
//         $('#fnamecheck').html("**please fill your first name");
//         $('#fnamecheck').focus();
//         $('#fnamecheck').css("color","red");
//         fname_err=false;

//     }
//     }

//     $('#lnames').keyup(function(){
//     lname_check();
//     });
//     function lname_check(){
//     var lname_val = $('#lnames').val();

//     if (lname_val.length == '' || lname_val.length == null){
//         $('#lnamecheck').show();
//         $('#lnamecheck').html("**please fill your last name");
//         $('#lnamecheck').focus();
//         $('#lnamecheck').css("color","red");
//         lname_err=false;

//     }
//     }

//     $('#emails').keyup(function(){
//         email_check();
//     });
//     function email_check(){
//         var email_val = $('#emails').val();

//         if (email_val.length == '' || email_val.length == null){
//         $('#emailcheck').show();
//         $('#emailcheck').html("**please fill your email");
//         $('#emailcheck').focus();
//         $('#emailcheck').css("color","red");
//         email_err=false;

//         }
//         else{
//         var regex = /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
//         if (regex.test(email.val)){
//             $('#emailcheck').show();
//             $('#emailcheck').html("**invalid email");
//             $('#emailcheck').focus();
//             $('#emailcheck').css("color","red");

//             email_err=false;

//             }
//         }
//     }

//     $('#mobiles').keyup(function(){
//         mobile_check();
//     });
//     function mobile_check(){
//         var mobile_val = $('#mobiles').val();

//         if (mobile_val.length == '' || mobile_val.length == null){
//         $('#mobilecheck').show();
//         $('#mobilecheck').html("**please fill your mobile number");
//         $('#mobilecheck').focus();
//         $('#mobilecheck').css("color","red");
//         lname_err=false;
//         return false;
//         }
//         else{
//         if(isNaN(mobile_val)){
//             $('#mobilecheck').show();
//             $('#mobilecheck').html("**input should be digits only");
//             $('#mobilecheck').focus();
//             $('#mobilecheck').css("color","red");

//         }
//         else if(mobile_val.length != 10){
//             $('#mobilecheck').show();
//             $('#mobilecheck').html("**number should be of length 10");
//             $('#mobilecheck').focus();
//             $('#mobilecheck').css("color","red");

//         }
//         }
//         }

//         $('#datepicker').keyup(function(){
//         dob_check();
//         });
//         function dob_check(){
//         var dob_val = $('#datepicker').val();

//         if (dob_val.length == '' || dob_val.length == null){
//             $('#dobcheck').show();
//             $('#dobcheck').html("**please fill your date of birth");
//             $('#dobcheck').focus();
//             $('#dobcheck').css("color","red");
//             dob_err=false;
//             return false;
//         }
//         }
//         $('.inlineRadioOptions').keyup(function(){
//             alert("hello");
//             _check();
//         });
//         function gender_check(){
//             var gender = $('.gender').val();

//             if (gender[0].checked==false && gender[1].checked==false){
//             $('#gendercheck').show();
//             $('#gendercheck').html("**please fill your gender");
//             $('#gendercheck').focus();
//             $('#gendercheck').css("color","red");
//             lname_err=false;
//             return false;
//             }
//             }

// });
