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
		<link href="css/style-user-admin.css" rel="stylesheet">
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
		<script src="js/index.js"></script>
		
	</head>
	<body>
			<div class="topnav" id="myTopnav">
					<a href="#" class="" id="icon">E-Powernotes</a>					
					<!----------
						when open in mobile screen or small devices logout button become visible
						and a profile button also become visible on sidebar
					------------>
					<a href="#home" class="navbar-link" id="btnLogoutSmallScreen"><span class="fa fa-user"></span> Logout</a>
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

			<div class="container center-box" id="main">	<!--------------tab groups starts----------------->
  				<br>
  			<ul class="nav nav-tabs">
    			<li class="active"><a data-toggle="tab" href="#pending">Pending</a></li>
    			<li><a data-toggle="tab" href="#approved">Approved</a></li>
    			<li><a data-toggle="tab" href="#rejected">Rejected</a></li>
  			</ul>

  			<div class="tab-content">
    			<div id="pending" class="tab-pane fade in active">
						<!--=============
								this section contain the data which are pending to approve or reject
							==================-->
						<h3>Pending</h3>
							<!--==========
									codes for pending filter start..
								==============-->
						<div class="form-horizontal">
							<div class="form-group">
								<div class="row">		<!--==========Start of first row============-->
									<div class="col-sm-4">
											<label class="col-sm-3 control-label">From</label>
											<div class="col-sm-9">
													<input type="date" class="form-control" id="txtPendingFromDate" >
											</div>
									</div>

									<div class="col-sm-4">
											<label class="col-sm-3 control-label">To</label>
											<div class="col-sm-9">
													<input type="date" class="form-control"  id="txtPendingToDate">
											</div>
									</div>

									<div class="col-sm-4">
											<label class="col-sm-3 control-label">Degree</label>
											<div class="col-sm-9">
													<select class="form-control" id="ddlPendingDegree"  onchange="getPendingSubject()">
															<option value="0" selected>==select degree==</option>
																							
													</select>
											</div>
									</div>
									
								</div>				<!--==========end of first row============-->

								<div class="row">		<!--==========Start of second row============-->
	
										<div class="col-sm-4">
												<label class="col-sm-3 control-label">Subject</label>
												<div class="col-sm-9">
														<select class="form-control" id="ddlPendingSubject">
																<option value="0" selected>==select subject==</option>
																<option value="0">==Select degree first==</option>														
														</select>
												</div>
										</div>									
	
										<div class="col-sm-4">
												<label class="col-sm-3 control-label">Semester</label>
												<div class="col-sm-9">
														<select class="form-control" id="ddlPendingSemester">
																<option value="0" selected>==select semester==</option>															
														</select>
												</div>
										</div>

								</div>			<!--==========end of second row============-->

								<div class="row">
									<div class="col-sm-2 btn-row">
										<input type="submit" value="Search" class="btn btn-success" onclick="pendingFilter()" id="btnPendingFilterSearch">
									</div>

									<div class="col-sm-2 btn-row">
										<input type="submit" value="Reset" class="btn btn-warning" id="btnPendingFilterReset" onclick="resetPendingList()">
									</div>
								</div>

							</div>
						</div>
						<!--==========
								codes for pending filter ends..
							==============-->
	<hr>

							<table class="myTable display table table-striped table-responsive table-hover" id="tblPendingData">
								<thead>
										<tr>
												<th><input type="checkbox" id="check-all"> </th>
												<th>S No</th>
												<th>User Id</th>
												<th>Title</th>
												<th>Description</th>
												<th>Notes Id</th>
												<th>Degree</th>
												<th>Semester</th>
												<th>Subject</th>
												
											</tr>
								</thead>

									<tbody id="tblPendingBody">
										
											
									</tbody>
							</table>
	<br>
							<!--==========
								pending footer navbar starts..
								=============-->
							<footer>
									<div class="form-group">
										<div class="row button-row">
											<!--<button class="btn btn-sm btn-default">Select all <input type="checkbox" id="check-all" ></button>-->
											<input type="submit" class="btn btn-success" id="btnSendPendingData" onclick="approve_notes()" value="Approve">
											<input type="submit" class="btn btn-danger" id="btnRejectingPendingData" onclick="reject_notes()" value="Reject">
										</div>
									</div>
							</footer>
							<!--==========
								pending footer navbar ends..
								=============-->
				</div>
							

    			<div id="approved" class="tab-pane fade">
					<h3>Approved</h3>
					<!--=============
								this section contain the data which are approved bby the admin..
							==================-->

							<!--==========
									codes for approved filter start..
								==============-->
						<div class="form-horizontal">
							<div class="form-group">
								<div class="row">		<!--==========Start of first row============-->
									<div class="col-sm-4">
											<label class="col-sm-3 control-label">From</label>
											<div class="col-sm-9">
													<input type="date" class="form-control" id="txtApprovedFromDate">
											</div>
									</div>

									<div class="col-sm-4">
											<label class="col-sm-3 control-label">To</label>
											<div class="col-sm-9">
													<input type="date" class="form-control" id="txtApprovedToDate">
											</div>
									</div>

									<div class="col-sm-4">
											<label class="col-sm-3 control-label">Degree</label>
											<div class="col-sm-9">
													<select class="form-control" id="ddlApprovedDegree" onchange="getApprovedSubject()">
															<option value="0" selected>==select degree==</option>															
													</select>
											</div>
									</div>
									
								</div>				<!--==========end of first row============-->

								<div class="row">		<!--==========Start of second row============-->
	
										<div class="col-sm-4">
												<label class="col-sm-3 control-label">Subject</label>
												<div class="col-sm-9">
														<select class="form-control" id="ddlApprovedSubject">
																<option value="0" selected>==select subject==</option>
																<option value="0">==select degree first==</option>
																															
														</select>
												</div>
										</div>									
	
										<div class="col-sm-4">
												<label class="col-sm-3 control-label">Semester</label>
												<div class="col-sm-9">
														<select class="form-control" id="ddlApprovedSemester">
																<option value="0" selected>==select semester==</option>
																<option value="1">semester 1</option>
																<option value="2">semester 2</option>															
														</select>
												</div>
										</div>

								</div>			<!--==========end of second row============-->

								<div class="row">
									<div class="col-sm-2 btn-row">
										<input type="submit" value="Search" class="btn btn-success" onclick="approvedFilter()" id="btnApprovedFilterSearch">
									</div>

									<div class="col-sm-2 btn-row">
										<input type="submit" value="Reset" class="btn btn-warning" onclick="resetApprovedList()">
									</div>
								</div>

							</div>
						</div>
						<!--==========
								codes for approved filter ends..
							==============-->
	<hr>

							<table class="table table-striped table-condensed table-responsive table-hover" id="tblApprovedData">
									<thead>
											<tr>
													<th><input type="checkbox" id="check-all-approved"></th>
													<th>S No</th>
													<th>User Id</th>
													<th>Title</th>
													<th>Description</th>
													<th>Notes Id</th>
													<th>Degree</th>
													<th>Semester</th>
													<th>Subject</th>
													
												</tr>
									</thead>
	
										<tbody id="tblApprovedBody">
											
												
										</tbody>
							</table>

							<!--==========
								approved footer navbar starts..
								=============-->
							<footer>
									<div class="form-group">
										<div class="row button-row">
											<!--<input type="submit" class="btn btn-success" value="Approve">
											<input type="submit" class="btn btn-danger" value="Reject">-->
										</div>
									</div>
							</footer>
							<!--==========
								approved footer navbar ends..
								=============-->
				</div>
					
    			<div id="rejected" class="tab-pane fade">
					  <h3>Rejected</h3>
					  <!--=============
								this section contain the data which are rejected by the admin..
							==================-->

							<!--==========
									codes for rejected filter start..
								==============-->
						<div class="form-horizontal">
								<div class="form-group">
									<div class="row">		<!--==========Start of first row============-->
										<div class="col-sm-4">
												<label class="col-sm-3 control-label">From</label>
												<div class="col-sm-9">
														<input type="date" class="form-control" id="txtRejectedFromDate">
												</div>
										</div>
	
										<div class="col-sm-4">
												<label class="col-sm-3 control-label">To</label>
												<div class="col-sm-9">
														<input type="date" class="form-control" id="txtRejectedToDate">
												</div>
										</div>
	
										<div class="col-sm-4">
												<label class="col-sm-3 control-label">Degree</label>
												<div class="col-sm-9">
														<select class="form-control" id="ddlRejectedDegree" onchange="getRejectedSubject()">
																<option value="0" selected>==select degree==</option>															
														</select>
												</div>
										</div>
										
									</div>				<!--==========end of first row============-->
	
									<div class="row">		<!--==========Start of second row============-->
		
											<div class="col-sm-4">
													<label class="col-sm-3 control-label">Subject</label>
													<div class="col-sm-9">
															<select class="form-control" id="ddlRejectedSubject">
																	<option value="0" selected>==select subject==</option>
																	<option value="0">==select degree first==</option>
																																
															</select>
													</div>
											</div>									
		
											<div class="col-sm-4">
													<label class="col-sm-3 control-label">Semester</label>
													<div class="col-sm-9">
															<select class="form-control" id="ddlRejectedSemester">
																	<option value="0" selected>==select semester==</option>
																																
															</select>
													</div>
											</div>
	
									</div>			<!--==========end of second row============-->
	
									<div class="row">
										<div class="col-sm-2 btn-row">
											<input type="submit" value="Search" class="btn btn-success" onclick="rejectedFilter()">
										</div>
	
										<div class="col-sm-2 btn-row">
											<input type="submit" value="Reset" class="btn btn-warning" onclick="resetRejectedList()">
										</div>
									</div>
	
								</div>
							</div>
							<!--==========
									codes for rejected filter ends..
								==============-->
	<hr>
	
								<table class="table table-striped table-condensed table-responsive table-hover" id="tblRejectedData">
										<thead>
												<tr>
														<th><input type="checkbox" id="check-all-rejected"></th>
														<th>S No</th>
														<th>User Id</th>
														<th>Title</th>
														<th>Description</th>
														<th>Notes Id</th>
														<th>Degree</th>
														<th>Semester</th>
														<th>Subject</th>
														
													</tr>
										</thead>
		
											<tbody id="tblRejectedBody">
												
													
											</tbody>
								</table>
	
								<!--==========
									rejected footer navbar starts..
									=============-->
								<footer>
										<div class="form-group">
											<div class="row button-row">
												<!--<button class="btn btn-sm btn-default">Select all <input type="checkbox" id="check-all-rejected" ></button>
												<input type="submit" class="btn btn-success" value="Approve">-->
											</div>
										</div>
								</footer> 
								<!--==========
									rejected footer navbar ends..
									=============-->
				</div>
					
  			</div>
		</div> 
										  
	</body>
	
	<script>
	function openfilelist(get){         //this function will open and close the dropdown of notes list..
        var id=get.id;
        var trStart='<tr>';
    	var trEnd='</tr>';
        var sib=$("#"+id).find('.dropdown-content').hasClass('ddlLinkList');
        if(sib){
            $("#"+id).find('.dropdown-content').removeClass('ddlLinkList');
        }
        else{
            $("#"+id).find('.dropdown-content').addClass('ddlLinkList');
            $("#container").removeAttr('style');   //displaying the loading circles..
            $("#"+id).find('#tableAllNotes').empty();       //cleaning the table to bind files..
            var flag='searchAllNotesFiles';
            $.ajax({
                url:'callServiceSearchNotes.php',
                method:'POST',
                dataType:'json',
                data:{action:flag,notesId:id},
                success:function(data){
                    $.each(data, function(i, item) {
                        $("#"+id).find('#tableAllNotes').append(trStart+'<tr> <td style="padding:3px" > <a id="'+data[i].notesId+'" href="'+data[i].notesPath+'" target="_blank" ><span class="fa fa-file"></span> File</a></td></tr>'+trEnd) ;
                    });

                    $("#container").attr('style', 'display:none');      //removing the loading circles..
                }
            });
        }        
    }


		function openNav() {
   		 document.getElementById("mySidebar").style.width = "200px";
		 document.getElementById("main").style.marginLeft = "200px";
  		}
  
  		function closeNav() {
    	 document.getElementById("mySidebar").style.width = "0";
		 document.getElementById("main").style.marginLeft= "0";
		
		 (function() {
  			window.onresize = displayWindowSize;
  			window.onload = displayWindowSize;

  		function displayWindowSize() {
    		myWidth = window.innerWidth;
    		myHeight = window.innerHeight;
    		// your size calculation code here
			var size=myWidth;
			if(size>618){
				document.getElementById("mySidebar").style.width = "200px";
				document.getElementById("main").style.marginLeft = "200px";
					}
  				};
			})();
		}
	</script>

	<script>
		/*============
			code to bind data into the ddls of pending tab starts..
		=============*/
		$(document).ready(function(){
			 //getting the datatable...

			var flagdegree="getdegree";
			var flagsemester="getsemester";
			var pendingtable="pending";
			var approvetable="approved";
			var rejecttable="rejected";
			var builtTable="<tr>";
			var builtTable1="</tr>";
			var tblPendingLen=0;
			var tblApprovedLen=0;
			var tblRejectedLen=0;

			getPendingNotes(pendingtable,builtTable,builtTable1);
			getApprovedNotes(approvetable,builtTable,builtTable1);
			getRejectedNotes(rejecttable,builtTable,builtTable1);

			$.ajax({
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:flagdegree},
				success:function(data){
					$("#ddlPendingDegree").empty();
                	$("#ddlPendingDegree").append("<option value='0'>==select degree==</option>");
                	$.each(data, function(i, item) {
                    $('#ddlPendingDegree').append('<option value="' + data[i].degId + '">' + data[i]
                        .degName + '</option>');
                	});
				}
			});

			$.ajax({
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:flagsemester},
				success:function(data){
					$("#ddlPendingSemester").empty();
                	$("#ddlPendingSemester").append("<option value='0'>==select semester==</option>");
                	$.each(data, function(i, item) {
                    $('#ddlPendingSemester').append('<option value="' + data[i].semId + '">' + data[i]
                        .semName + '</option>');
                	});
				}
			});
		});

		function getPendingNotes(pendingtable,builtTable,builtTable1){
			$.ajax({	//binding data into the pending table..
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:pendingtable},
				success:function(data){
					if(data=='empty'){
						$('#tblPendingBody').empty();
						$('#tblPendingBody').append(builtTable+'<td colspan="9">No data present</td>'+builtTable1);
					}
					else if(data=='error'){
						window.location.replace('error.html');
					}
					else{
						tblPendingLen=data.length;
						$('#tblPendingBody').empty();
						$.each(data, function(i, item) {
						$('#tblPendingBody').append(
							builtTable+ '<td> <input type="checkbox" name="case[]" onclick="checkBoxPenLoop()" id="chbkPen'+i+'" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5>  </td> <td>'+ data[i].desc+'</td><td>'+data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td>'+builtTable1               
														
						)
                	});
					}
				}
			}); //binding data into the pending table ends..
		}

		function getApprovedNotes(approvetable,builtTable,builtTable1){
			$.ajax({	//binding data into the approved table..
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:approvetable},
				success:function(data){
					if(data=='empty'){
						$('#tblApprovedBody').empty();
						$('#tblApprovedBody').append(builtTable+'<td colspan="9">No data present</td>'+builtTable1);
					}
					else if(data=='error'){
						window.location.replace('error.html');
					}
					else{
						$('#tblApprovedBody').empty();
						$.each(data, function(i, item) {
						tblApprovedLen=data.length;
						$('#tblApprovedBody').append(
							builtTable+ '<td> <input type="checkbox" onclick="checkBoxAppLoop()" id="chbkApp'+i+'" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td><h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5></td> <td>'+ data[i].desc+'</td><td>'+data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].notesId+'"> <span class="fa fa-arrow-down"></span> </a> </td>'  +builtTable1               														
							)
                		});
					}
				}
			}); //binding data into the approved table ends..
		}

		function getRejectedNotes(rejecttable,builtTable,builtTable1){
			$.ajax({	//binding data into the rejected table..
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:rejecttable},
				success:function(data){
					if(data=='empty'){
						$('#tblRejectedBody').empty();
						$('#tblRejectedBody').append(builtTable+'<td colspan="9">No data present</td>'+builtTable1);
					}
					else if(data=='error'){
						window.location.replace('error.html');
					}
					else{
						//tblRejectedLen=0;
						$('#tblRejectedBody').empty();
						$.each(data, function(i, item) {
						$('#tblRejectedBody').append(
							builtTable+ '<td> <input type="checkbox" onclick="checkBoxRejLoop()" id="chbkRej'+i+'" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td><td>'+data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].notesId+'"> <span class="fa fa-arrow-down"></span> </a> </td>'  +builtTable1               
														
						)
                	});
					}
				}
			}); //binding data into the rejected table ends..
		}

		/*============
			codes to reset the data starts..
		============== */
		function resetPendingList(){
			var pendingtable="pending";
			var approvetable="approved";
			var rejecttable="rejected";
			var builtTable="<tr>";
			var builtTable1="</tr>";

			getPendingNotes(pendingtable,builtTable,builtTable1);

		}

		function resetApprovedList(){
			var pendingtable="pending";
			var approvetable="approved";
			var rejecttable="rejected";
			var builtTable="<tr>";
			var builtTable1="</tr>";

			getApprovedNotes(approvetable,builtTable,builtTable1);
			
		}

		function resetRejectedList(){
			var pendingtable="pending";
			var approvetable="approved";
			var rejecttable="rejected";
			var builtTable="<tr>";
			var builtTable1="</tr>";

			getRejectedNotes(rejecttable,builtTable,builtTable1);
		}



		/*============
			codes to reset the data starts..
		============== */

		function getPendingSubject(){
			var flag="getsubject";
			var selDegree=document.getElementById("ddlPendingDegree").value;
			$.ajax({
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:flag,id:selDegree},
				success:function(data){
					$("#ddlPendingSubject").empty();
                	$("#ddlPendingSubject").append("<option value='0'>==select subject==</option>");
                	$.each(data, function(i, item) {
                    $('#ddlPendingSubject').append('<option value="' + data[i].subId + '">' + data[i]
                        .subName + '</option>');
                	});
				}
			});
		}
		/*============
			code to bind data into the ddls of pending tab ends..
		=============*/

		/*============
			code to bind data into the ddls of approved tab starts..
		=============*/
		$(document).ready(function(){
			var flagdegree="getdegree";
			var flagsemester="getsemester";
			$.ajax({
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:flagdegree},
				success:function(data){
					$("#ddlApprovedDegree").empty();
                	$("#ddlApprovedDegree").append("<option value='0'>==select degree==</option>");
                	$.each(data, function(i, item) {
                    $('#ddlApprovedDegree').append('<option value="' + data[i].degId + '">' + data[i]
                        .degName + '</option>');
                	});
				}
			});

			$.ajax({
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:flagsemester},
				success:function(data){
					$("#ddlApprovedSemester").empty();
                	$("#ddlApprovedSemester").append("<option value='0'>==select semester==</option>");
                	$.each(data, function(i, item) {
                    $('#ddlApprovedSemester').append('<option value="' + data[i].semId + '">' + data[i]
                        .semName + '</option>');
                	});
				}
			});

		});

		function getApprovedSubject(){
			var flag="getsubject";
			var selDegree=document.getElementById("ddlApprovedDegree").value;
			$.ajax({
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:flag,id:selDegree},
				success:function(data){
					$("#ddlApprovedSubject").empty();
                	$("#ddlApprovedSubject").append("<option value='0'>==select subject==</option>");
                	$.each(data, function(i, item) {
                    $('#ddlApprovedSubject').append('<option value="' + data[i].subId + '">' + data[i]
                        .subName + '</option>');
                	});
				}
			});
		}
		/*============
			code to bind data into the ddls of approved tab ends..
		=============*/

		/*============
			code to bind data into the ddls of rejected tab starts..
		=============*/
		$(document).ready(function(){
			var flagdegree="getdegree";
			var flagsemester="getsemester";
			$.ajax({
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:flagdegree},
				success:function(data){
					$("#ddlRejectedDegree").empty();
                	$("#ddlRejectedDegree").append("<option value='0'>==select degree==</option>");
                	$.each(data, function(i, item) {
                    $('#ddlRejectedDegree').append('<option value="' + data[i].degId + '">' + data[i]
                        .degName + '</option>');
                	});
				}
			});

			$.ajax({
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:flagsemester},
				success:function(data){
					$("#ddlRejectedSemester").empty();
                	$("#ddlRejectedSemester").append("<option value='0'>==select semester==</option>");
                	$.each(data, function(i, item) {
                    $('#ddlRejectedSemester').append('<option value="' + data[i].semId + '">' + data[i]
                        .semName + '</option>');
                	});
				}
			});

		});

		function getRejectedSubject(){
			var flag="getsubject";
			var selDegree=document.getElementById("ddlRejectedDegree").value;
			$.ajax({
				type:"POST",
				url:"callServiceAdminData.php",
				dataType: "json",
				data:{actionFlag:flag,id:selDegree},
				success:function(data){
					$("#ddlRejectedSubject").empty();
                	$("#ddlRejectedSubject").append("<option value='0'>==select subject==</option>");
                	$.each(data, function(i, item) {
                    $('#ddlRejectedSubject').append('<option value="' + data[i].subId + '">' + data[i]
                        .subName + '</option>');
                	});
				}
			});
		}
		/*============
			code to bind data into the ddls of rejected tab ends..
		=============*/

		/*==============
			codes for filter starts..
		=============*/
		function pendingFilter(){
			var todate=$('#txtPendingToDate').val();
			var fromdate=$('#txtPendingFromDate').val();
			var pendingDegree=document.getElementById('ddlPendingDegree').value;
			var pendingSubject=document.getElementById('ddlPendingSubject').value;
			var pendingSemester=document.getElementById('ddlPendingSemester').value;

			if(todate=='' && fromdate==''){
				//search based on deg,sub,sem only..
				var builtTable="<tr>";
				var builtTable1="</tr>";
				var flag="getdatadegsubsempen";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,finddeg:pendingDegree,findsub:pendingSubject,findsem:pendingSemester},
					success:function(data){
						$('#tblPendingBody').empty();
						if(data==0){
							alert('No data present');
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							$.each(data, function(i, item) {
						$('#tblPendingBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td><h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5></td> <td>'+ data[i].desc+'</td> <td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].notesId+'"> <span class="fa fa-arrow-down"></span> </a> </td> '  +builtTable1               														
						)
                	});
						}
					}

				});
			}
			else if((todate!='' && fromdate=='') || (todate=='' && fromdate!='')){
				//search according to date..
				var flag="getdatadatepen";
				var builtTable="<tr>";
				var builtTable1="</tr>";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,from:fromdate,to:todate},
					success:function(data){
						$('#tblPendingBody').empty();
						if(data==0){
							alert('No data present');
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							$.each(data, function(i, item) {
						$('#tblPendingBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td><td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].notesId+'"> <span class="fa fa-arrow-down"></span> </a> </td> <td> <input type="submit" class="btn btn-success btn-sm" value="Approve"> <input type="submit" class="btn btn-danger btn-sm" value="Reject"> </td>'  +builtTable1               
														
						)
                	});
						}
					}
				});
			}
			else if(todate!='' && fromdate!=''){
				//search according to dates..
				var flag="getdatadatepen";
				var builtTable="<tr>";
				var builtTable1="</tr>";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,from:fromdate,to:todate},
					success:function(data){
						$('#tblPendingBody').empty();
						if(data==0){
							alert('No data present');
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							$.each(data, function(i, item) {
						$('#tblPendingBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td><td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="'+data[i].notespath+'" target="_blank"> <span class="fa fa-file"></span> </a> </td> <td> <input type="submit" class="btn btn-success btn-sm" value="Approve"> <input type="submit" class="btn btn-danger btn-sm" value="Reject"> </td>'  +builtTable1               
														
						)
                	});
						}
					}
				});
			}
			else{
				//search according to deg,sub,sem..
				var flag="getdatadegsubsempen";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,finddeg:pendingDegree,findsub:pendingSubject,findsem:pendingSemester},
					success:function(data){
						$('#tblPendingBody').empty();
						if(data==0){
							alert('No data present');
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							$.each(data, function(i, item) {
						$('#tblPendingBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td> <td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="'+data[i].notesId+'" target="_blank"> <span class="fa fa-file"></span> </a> </td> '  +builtTable1               														
						)
                	});
						}
					}

				});
			}
				
		}
		
		function approvedFilter(){
			var todate=$('#txtApprovedToDate').val();
			var fromdate=$('#txtApprovedFromDate').val();
			var pendingDegree=document.getElementById('ddlApprovedDegree').value;
			var pendingSubject=document.getElementById('ddlApprovedSubject').value;
			var pendingSemester=document.getElementById('ddlApprovedSemester').value;

			if(todate=='' && fromdate==''){
				//search based on deg,sub,sem only..
				var builtTable="<tr>";
				var builtTable1="</tr>";
				var flag="getdatadegsubsemapp";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,finddeg:pendingDegree,findsub:pendingSubject,findsem:pendingSemester},
					success:function(data){
						$('#tblApprovedBody').empty();
						if(data==0){
							alert('No data present');
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							//alert('running');
							$.each(data, function(i, item) {
						$('#tblApprovedBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td> <td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].notesId+'"> <span class="fa fa-arrow-down"></span> </a> </td> '  +builtTable1               														
														
						);
                	});
						}
					}
				});
			}
			else if((todate!='' && fromdate=='') || (todate=='' && fromdate!='')){
				//search according to date..
				var flag="getdatadateapp";
				var builtTable="<tr>";
				var builtTable1="</tr>";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,from:fromdate,to:todate},
					success:function(data){
						$('#tblApprovedBody').empty();
						if(data==0){
							alert('No data present');
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							$.each(data, function(i, item) {
						$('#tblApprovedBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td> <td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].userid+'"> <span class="fa fa-arrow-down"></span> </a> </td> '  +builtTable1               														
														
						)
                	});;
						}
					}
				});
			}
			else if(todate!='' && fromdate!=''){
				//search according to dates..
				var flag="getdatadateapp";
				var builtTable="<tr>";
				var builtTable1="</tr>";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,from:fromdate,to:todate},
					success:function(data){
						$('#tblApprovedBody').empty();
						if(data==0){
							alert('No data present');
						}
						else if(data=='error.html'){
							window.location.replace('error.html');
						}
						else{
							$.each(data, function(i, item) {
						$('#tblApprovedBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td> <td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].notesId+'"> <span class="fa fa-arrow-down"></span> </a> </td> '  +builtTable1               														
														
						)
                	});
						}
					}
				});
			}
			else{
				//search according to deg,sub,sem..
				var flag="getdatadegsubsemapp";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,finddeg:pendingDegree,findsub:pendingSubject,findsem:pendingSemester},
					success:function(data){
						$('#tblApprovedBody').empty();
						if(data==0){
							alert('No data present');
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							//alert('running');
							$.each(data, function(i, item) {
						$('#tblApprovedBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td> <td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].notesId+'"> <span class="fa fa-arrow-down"></span> </a> </td> '  +builtTable1               														
														
						);
                	});
						}
					}

				});
			}
		}

		function rejectedFilter(){
			var todate=$('#txtRejectedToDate').val();
			var fromdate=$('#txtRejectedFromDate').val();
			var rejectedDegree=document.getElementById('ddlRejectedDegree').value;
			var rejectedSubject=document.getElementById('ddlRejectedSubject').value;
			var rejectedSemester=document.getElementById('ddlRejectedSemester').value;

			if(todate=='' && fromdate==''){
				//search based on deg,sub,sem only..
				var builtTable="<tr>";
				var builtTable1="</tr>";
				var flag="getdatadegsubsemrej";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,finddeg:rejectedDegree,findsub:rejectedSubject,findsem:rejectedSemester},
					success:function(data){
						$('#tblRejectedBody').empty();
						if(data==0){
							alert('No data present');
						} 
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							$.each(data, function(i, item) {
						$('#tblRejectedBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td> <td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].notesId+'"> <span class="fa fa-arrow-down"></span> </a> </td> '  +builtTable1               														
														
						);
                	});
						}
					}
				});
			}
			else if((todate!='' && fromdate=='') || (todate=='' && fromdate!='')){
				//search according to date..
				var flag="getdatadaterej";
				var builtTable="<tr>";
				var builtTable1="</tr>";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,from:fromdate,to:todate},
					success:function(data){
						$('#tblRejectedBody').empty();
						if(data==0){
							alert('No data present');
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							$.each(data, function(i, item) {
						$('#tblRejectedBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td> <td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].notesId+'"> <span class="fa fa-arrow-down"></span> </a> </td> '  +builtTable1               														
														
						)
                	});;
						}
					}
				});
			}
			else if(todate!='' && fromdate!=''){
				//search according to dates..
				var flag="getdatadaterej";
				var builtTable="<tr>";
				var builtTable1="</tr>";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,from:fromdate,to:todate},
					success:function(data){
						$('#tblRejectedBody').empty();
						if(data==0){
							alert('No data present');
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							$.each(data, function(i, item) {
						$('#tblRejectedBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td> <td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].notesId+'"> <span class="fa fa-arrow-down"></span> </a> </td> '  +builtTable1               														
														
						)
                	});
						}
					}
				});
			}
			else{
				//search according to deg,sub,sem..
				var flag="getdatadegsubsemrej";
				$.ajax({
					url:"callServiceAdminData.php",
					method:"POST",
					dataType:"json",
					data:{actionFlag:flag,finddeg:rejectedDegree,findsub:rejectedSubject,findsem:rejectedSemester},
					success:function(data){
						$('#tblRejectedBody').empty();
						if(data==0){
							alert('No data present');
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							//alert('running');
							$.each(data, function(i, item) {
						$('#tblRejectedBody').append(
							builtTable+ '<td> <input type="checkbox" class="chkBox"> </td> <td>'+ i +'</td> <td>'+data[i].userid+'</td> <td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)">'+data[i].title+'<span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h5> </td> <td>'+ data[i].desc+'</td> <td>'+ data[i].notesId+'</td> <td>'+data[i].degree+'</td> <td>'+ data[i].semester+'</td> <td>'+data[i].subject+'</td> <td> <a href="#" id="'+data[i].notesId+'"> <span class="fa fa-arrow-down"></span> </a> </td> '  +builtTable1               														
														
						);
                	});
						}
					}

				});
			}
		}

		/*==============
			codes for filter ends..
		=============*/

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

			function checkBoxAppLoop(){	//this function select and unselect the checkboxes of approved data A/C to user action..
				var countChkBox=0;
				 for(i=0;i<tblApprovedLen;i++){
					 if($('#chbkApp'+i).prop("checked")==false){
						$("#check-all-approved").prop("checked", false);
					 }

					 if($('#chbkApp'+i).prop("checked")==true){
						countChkBox++;
					 }

					 if(countChkBox==tblApprovedLen){
						$("#check-all-approved").prop("checked", true);
					 }
				 }
			} 

			function checkBoxRejLoop(){	//this function select and unselect the checkboxes of rejected data A/C to user action..
				var countChkBox=0;
				 for(i=0;i<tblApprovedLen;i++){
					 if($('#chbkRej'+i).prop("checked")==false){
						$("#check-all-rejected").prop("checked", false);
					 }

					 if($('#chbkRej'+i).prop("checked")==true){
						countChkBox++;
					 }

					 if(countChkBox==tblApprovedLen){
						$("#check-all-rejected").prop("checked", true);
					 }
				 }
			}

			 //script to check all the checkbox when admin click select all button in approved tab..
			$("#check-all-approved").click(function () {
     		$('input:checkbox').not(this).prop('checked', this.checked);
			 });
			 
			  //script to check all the checkbox when admin click select all button in reject tab..
			$("#check-all-rejected").click(function () {
     		$('input:checkbox').not(this).prop('checked', this.checked);
 			});
		
		  function funOpenAccList(){
			var x=document.getElementById("ddlAccountList");
			if(x.style.display==="block"){
				x.style.display="none";
			}
			else{
				x.style.display="block";
			}
		}

		/*============
			approving and rejecting, codes starts..
		================*/

		
		/*===============
			This function will approve multipe notes at a time..
		===============*/
		function approve_notes(){
			var notesId = "";
            //Loop through all checked CheckBoxes in the table to get the notes ids..
            $("#tblPendingBody input[type=checkbox]:checked").each(function () {
                var row = $(this).closest("tr")[0];
                notesId+= row.cells[5].innerHTML+",";
            });//loop.. 
			if(notesId==""){
				alert('Please select notes first..');
			}
			else{
				var check=confirm("Do you want to approve notes id"+notesId);
			var flag='approve';
			var pendingtable="pending";		//this variables are used 
			var approvetable="approved";	//to rebind the  
			var rejecttable="rejected";		//table after
			var builtTable="<tr>";			//approval or 
			var builtTable1="</tr>";		//rejectation of notes
			if(check==true){
				$.ajax({
				url:"callServiceAdminData.php",
				method:"post",
				data:{actionFlag:flag,ids:notesId},
					success:function(data){
						if(data==1){
							getPendingNotes(pendingtable,builtTable,builtTable1);
							getApprovedNotes(approvetable,builtTable,builtTable1);
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							alert('Approved failed');
						}
					}
				});
			}
			else{
				return false;
			}
			}
		}

		function reject_notes(){		//function to reject notes..
			var notesId = "";
			//Loop through all checked CheckBoxes in the table to get the notes ids..
            $("#tblPendingBody input[type=checkbox]:checked").each(function () {
                var row = $(this).closest("tr")[0];
                notesId+= row.cells[5].innerHTML+",";
            });//loop..
			if(notesId==""){
				alert('Please select notes first..');
			}
			else{
				var check=confirm("Do you want to reject notes id"+notesId);
			var flag='reject';

			var pendingtable="pending";		//this variables are used 
			var approvetable="approved";	//to rebind the  
			var rejecttable="rejected";		//table after
			var builtTable="<tr>";			//approval or 
			var builtTable1="</tr>";		//rejectation of notes
			if(check==true){
				$.ajax({
				url:"callServiceAdminData.php",
				method:"post",
				data:{actionFlag:flag,ids:notesId},
					success:function(data){
						if(data==1){
							getPendingNotes(pendingtable,builtTable,builtTable1);
							getRejectedNotes(rejecttable,builtTable,builtTable1);
						}
						else if(data=='error'){
							window.location.replace('error.html');
						}
						else{
							alert('Rejection failed');
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