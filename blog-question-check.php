<?php
	session_start();
	if($_SESSION["name"]=="" || $_SESSION["email"]==""||$_SESSION["roleId"]!=1){
		echo "some error occured";
		die();
	}
	else{
		$userName=$_SESSION["name"];
		$userEmail=$_SESSION["email"];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style-question-check.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="js/jquery.js"></script>
		<!--============
			Libraries for datatable
			============-->
		<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
			<!--============
			Libraries for datatable ends..
			============-->

		<link href="css/font-awesome.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script>
		 
		
	</head>
	    <body>
        <div class="topnav" id="myTopnav">
					<a href="#" class="" id="icon">w3highschools</a>					
					<!----------
						when open in mobile screen or small devices logout button become visible
						and a profile button also become visible on sidebar
					------------>
					<a href="logout.php" class="navbar-link" id="btnLogoutSmallScreen"><span class="fa fa-user"></span> Logout</a>
						<!--
							END
						-->
						<div class="dropdownAccount topnav-right" onclick="funOpenAccList()">
    						<label class="dropbtnAccount">Hii <?php echo substr($userName, 0, 5); ?> 
      							<i class="fa fa-caret-down" id="arrow"></i>
							</label>
    						<div class="dropdown-content-Account" id="ddlAccountList">
      							<a href="logout.php" class="account-option">Log Out</a>
    						</div>
  						</div> 							
					<a href="javascript:void(0);" class="icon" onclick="myFunction()">
					  <i class="fa fa-bars"></i>
					</a>
            </div>
            
            <!------------sidebar starts------------->

			<div class="sidebar" id="mySidebar">
					<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><span class="fa fa-arrow-left"></span>  </a>
					<a href="user-admin.php"><span class="fa fa-home"></span> Home</a>
					<a href="registered-user-details.php"><span class="fa fa-group"></span> Registered user details</a>
			</div>
			<button class="openbtn" onclick="openNav()"><span class="fa fa-arrow-right"></span></button>
			<!-------------sidebar ends------------->

            <div class="center-main">

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#pendingQues">Pending</a></li>
                <li><a data-toggle="tab" href="#approvedQues">Approved</a></li>
                <li><a data-toggle="tab" href="#rejectedQues">Rejected</a></li>
            </ul>

            <div class="tab-content">

                <div id="pendingQues" class="tab-pane fade in active">
                    <table class="table table-responsive">
                        <thead id="tblPenQuesHead">
                            <tr>
                                <th><input type="checkbox" id="check-all"> </th>
                                <th>S no</th>
                                <th>Ques Id</th>
                                <th>Title</th>
                                <th>Desc</th>
                                <th>Degree</th>
                                <th>Subject</th>
                            </tr>
                        </thead>

                        <tbody id="tblPenQuesBody">
                            
                        </tbody>

                    </table>
                    <div class="btn-group btnRow">
                        <button type="button" class="btn btn-default" onclick="approve_ques()">Approve</button>
                        <button type="button" class="btn btn-default" onclick="reject_ques()">Reject</button>
                    </div>
                </div>

                <div id="approvedQues" class="tab-pane fade">
                    <table class="table table-responsive">
                        <thead id="tblAppQuesHead">
                            <tr>
                            <th>S no</th>
                            <th>Title</th>
                            <th>Desc</th>
                            <th>Degree</th>
                            <th>Subject</th>
                            </tr>
                        </thead>

                        <tbody id="tblAppQuesBody">
                            
                        </tbody>

                    </table>
                </div>

                <div id="rejectedQues" class="tab-pane fade">
                   <table class="table table-responsive">
                        <thead id="tblRejQuesHead">
                            <tr>
                            <th>S no</th>
                            <th>Title</th>
                            <th>Desc</th>
                            <th>Degree</th>
                            <th>Subject</th>
                            </tr>
                        </thead>
                       
                        <tbody id="tblRejQuesBody">
                            
                        </tbody>

                   </table>
                </div>

            </div>
            </div>
        </body>
        <script>
        $(document).ready(function(){
            getPenTable();
            getAppTable();
            getRejTable();
            var tblPendingLen=0;
        });

        function getPenTable(){
            var flagPen="getPenQues";
            $.ajax({            //binding data into pending table
                method:"POST",
                url:"callServiceBlogData.php",
                dataType:"json",
                data:{action:flagPen},
                success:function(data){
                    $("#tblPenQuesBody").empty();
                    if(data==0){
                        $('#tblPenQuesBody').append('<tr><td>No data present</td></tr>');
                    }
                    else{
                        $.each(data, function(i, item) {
                            tblPendingLen=data.length;
                            $('#tblPenQuesBody').append('<tr> <td> <input type="checkbox" name="case[]" onclick="checkBoxPenLoop()" id="chbkPen'+i+'" class="chkBox"> </td> <td>'+i+'</td> <td>'+data[i].quesId+'</td> <td>'+data[i].quesTitle+'</td> <td>'+data[i].quesDesc+'</td> <td>'+data[i].quesDeg+'</td> <td>'+data[i].quesSub+'</td> <td> </td> </tr>');
                	    });
                    }
                }
            });
        }

        function getAppTable(){
            var flagApp="getAppQues";
            $.ajax({            //binding data into approved table
                method:"POST",
                url:"callServiceBlogData.php",
                dataType:"json",
                data:{action:flagApp},
                success:function(data){
                    $("#tblAppQuesBody").empty();
                    if(data==0){
                        $('#tblAppQuesBody').append('<tr><td>No data present</td></tr>');
                    }
                    else{
                        $.each(data, function(i, item) {
                            $('#tblAppQuesBody').append('<tr><td>'+i+'</td> <td>'+data[i].quesTitle+'</td> <td>'+data[i].quesDesc+'</td> <td>'+data[i].quesDeg+'</td> <td>'+data[i].quesSub+'</td> </tr>');
                	    });
                    }
                }
            });
        }

        function getRejTable(){
            var flagRej="getRejecQues";
            $.ajax({            //binding data into rejected table
                method:"POST",
                url:"callServiceBlogData.php",
                dataType:"json",
                data:{action:flagRej},
                success:function(data){
                    $("#tblRejQuesBody").empty();
                    if(data==0){
                        $('#tblRejQuesBody').append('<tr><td>No data present</td></tr>');
                    }
                    else{
                        $.each(data, function(i, item) {
                            $('#tblRejQuesBody').append('<tr><td>'+i+'</td> <td>'+data[i].quesTitle+'</td> <td>'+data[i].quesDesc+'</td> <td>'+data[i].quesDeg+'</td> <td>'+data[i].quesSub+'</td> </tr>');
                	    });
                    }
                }
            });
        }

        //script to check all the checkbox when admin click select all button in pending tab..
			$("#check-all").click(function () {
				$('input:checkbox').not(this).prop('checked', this.checked);
			 });

             function checkBoxPenLoop(){ //this function select and unselect the checkboxes of pending data A/C to user action..
				 var countChkBox=0;
				 for(i=0;i<tblPendingLen;i++){
					 if($('#chbkPen'+i).prop("checked")==false){
						$("#check-all").prop("checked", false);
					 }

					 if($('#chbkPen'+i).prop("checked")==true){
						countChkBox++;
					 }

					 if(countChkBox==tblPendingLen){
						$("#check-all").prop("checked", true);
					 }
				 }
			 }

             /*===============
			This function will approve multipe notes at a time..
		===============*/
		function approve_ques(){
			var notesId = "";
            //Loop through all checked CheckBoxes in the table to get the notes ids..
            $("#tblPenQuesBody input[type=checkbox]:checked").each(function () {
                var row = $(this).closest("tr")[0];
                notesId+= row.cells[2].innerHTML+",";
            });//loop.. 
			if(notesId==""){
				alert('Please select question first..');
			}
			else{
                var check=confirm("Do you want to approve Questions id"+notesId);
                if(check){
                    var flag="approveQues";
                    $.ajax({
                    url:"callServiceBlogData.php",
                    method:"POST",
                    data:{action:flag,ids:notesId},
                    success:function(data){
                        if(data==1){
                            alert('Questions approved successfully');
                            getPenTable();
                            getAppTable();
                            getRejTable();
                        }
                        else{
                            alert('something went wrong try again later');
                            }
                        }
                    });
                }
                else{
                    return false;
                }
			}
		}


        /*===============
			This function will reject multipe notes at a time..
		===============*/
        function reject_ques(){
			var notesId = "";
            //Loop through all checked CheckBoxes in the table to get the notes ids..
            $("#tblPenQuesBody input[type=checkbox]:checked").each(function () {
                var row = $(this).closest("tr")[0];
                notesId+= row.cells[2].innerHTML+",";
            });//loop.. 
			if(notesId==""){
				alert('Please select Questions first..');
			}
			else{
                var check=confirm("Do you want to Reject Questions id"+notesId);
                if(check){
                    var flag="rejectQues";
                    $.ajax({
                    url:"callServiceBlogData.php",
                    method:"POST",
                    data:{action:flag,ids:notesId},
                    success:function(data){
                        if(data==1){
                            alert('Questions rejected successfully');
                            getPenTable();
                            getAppTable();
                            getRejTable();
                        }
                        else{
                            alert('something went wrong try again later');
                            }
                        }
                    });
                }
                else{
                    return false;
                }
			}
		}

        </script>
    </html>		