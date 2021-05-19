<?php
	session_start();
	if($_SESSION["name"]=="" || $_SESSION["email"]==""||$_SESSION["roleId"]!=1){
		echo "<script type='text/javascript'>window.top.location='index.php';</script>";
		 exit;			//session expired so redirect to home page..
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
		<link href="css/registered-user-details.css" rel="stylesheet">
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
					<a href="#" class="" id="icon">E-Powernotesk</a>					
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
					<a href="#"><span class="fa fa-group"></span> Registered user details</a>

			</div>
			<button class="openbtn" onclick="openNav()"><span class="fa fa-arrow-right"></span></button>
            <!-------------sidebar ends------------->
            
            <!------------ coding for center part starts ------------->
            <div class="container center-box" id="main">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">All</a></li>
                <li><a data-toggle="tab" href="#blockedUserTab">Blocked</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                <table class="myTable table table-striped table-responsive table-hover" id="tblAllRegistered">
					<thead>
						<tr>
							<th>S No</th>
							<th>User Id</th>
							<th>User name</th>
							<th>User Activated</th>
							<th>User Email id</th>
							<th>User Blocked</th>
							<th>Mail status</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody id="tblAllRegisteredBody">
					</tbody>
				</table>
                </div>

                <div id="blockedUserTab" class="tab-pane fade">
                <table class="myTable table table-striped table-responsive table-hover" id="tblBlockedUser">
					<thead>
						<tr>
							<th>S No</th>
							<th>User Id</th>
							<th>User name</th>
							<th>User Activated</th>
							<th>User Email id</th>
							<th>User Blocked</th>
							<th>Mail status</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody id="tblBlockedUserBody">
					</tbody>
				</table>
                </div>

            </div>

            </div>
            <!------------ coding for center part ends ------------->

    </body>
        <script>
            $(document).ready(function(){
                var flagall="allRegisterUser";
                var flagblocked="allBlockedUser";
                $.ajax({
                    type:"POST",
				    url:"callServiceAdminData.php",
				    dataType: "json",
                    data:{actionFlag:flagall},
                    success:function(data){
                        $("#tblAllRegisteredBody").empty();
                        $.each(data, function(i, item) {
                            $('#tblAllRegisteredBody').append('<tr><td>'+i+'</td><td>'+data[i].userid+'</td><td>'+data[i].userName+'</td><td>'+data[i].userActivated+'</td><td>'+data[i].userEmail+'</td><td>'+data[i].userBlocked+'</td><td>'+data[i].mailSend+'</td><td> <input type="submit" class="btn btn-danger btn-sm" value="Block" onclick="blockuser()"> <input type="submit" class="btn btn-primary btn-sm" value="Resend mail" onclick="resendmail()"> </td></tr>');
                	    });
                    }
                });

                $.ajax({
                    type:"POST",
				    url:"callServiceAdminData.php",
				    dataType: "json",
                    data:{actionFlag:flagblocked},
                    success:function(data){
                        $("#tblBlockedUserBody").empty();
                        if(data=='nodata'){
                            $('#tblBlockedUserBody').append('<tr><td colspan="8" >No data present</td></tr>')
                        }
                        else{
                            $.each(data, function(i, item) {
                                $('#tblBlockedUserBody').append('<tr><td>'+i+'</td><td>'+data[i].userid+'</td><td>'+data[i].userName+'</td><td>'+data[i].userActivated+'</td><td>'+data[i].userEmail+'</td><td>'+data[i].userBlocked+'</td><td>'+data[i].mailSend+'</td><td><input type="submit" class="btn btn-success btn-sm" value="Unblock" onclick="unblockuser()">  </td></tr>');
                	        });
                        }
                    }
                });

            });

            function blockuser(){
                //block user here..
            }

            function resendmail(){
                //send mail again..
            }

            function unblockuser(){
                //unblock user here..
            }

            function funOpenAccList(){
			    var x=document.getElementById("ddlAccountList");
			    if(x.style.display==="block"){
				    x.style.display="none";
			    }
			    else{
				    x.style.display="block";
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
</html>