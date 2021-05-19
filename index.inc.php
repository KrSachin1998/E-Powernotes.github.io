<?php
require_once 'app_code/configmgr.php';
	session_start();
	/*if(!(isset($_SESSION["name"]) || isset($_SESSION["email"]) || isset($_SESSION["uniId"]) || isset($_SESSION["collId"]) || isset($_SESSION["id"])) ){
		echo "<script type='text/javascript'>window.top.location='index.php';</script>";
		 exit;			//session expired so redirect to home page..
	}
	else{
		$userName=$_SESSION["name"];
		$userEmail=$_SESSION["email"];
	}*/
	$showTxtBar="";
	if(isset($_GET["userSearch"])){
        $search=$_GET["userSearch"];
		$showTxtBar=$_GET["userSearch"];
		$search="%".$search."%";
    	$action='usersearch';
    	//$count=0;
    	$userId=0;
    	if(isset($_SESSION["id"])){
    		$userId=$_SESSION["id"];
    	}
    	$stmt = $conn->prepare('call USP_SEARCH(?,?,?)');
    	$stmt->bindParam(1, $action);
    	$stmt->bindParam(2, $search);  
    	$stmt->bindParam(3,$userId );  
        $stmt->execute();
        $countofSearchResult = $stmt->rowCount();
    }
    else if(isset($_REQUEST['btnSearch'])){
        $search=$_GET["txtSearchBar"];
		$showTxtBar=$_GET["txtSearchBar"];
		$search="%".$search."%";
    	$action='usersearch';
    	//$count=0;
    	$userId=0;
    	if(isset($_SESSION["id"])){
    		$userId=$_SESSION["id"];
    	}
    	$stmt = $conn->prepare('call USP_SEARCH(?,?,?)');
    	$stmt->bindParam(1, $action);
    	$stmt->bindParam(2, $search);  
    	$stmt->bindParam(3,$userId );  
        $stmt->execute();
        $countofSearchResult = $stmt->rowCount();
	}
	else if(isset($_REQUEST["btnSearchFilter"])){
        //code for filter goes here..
        $uniId=$_GET["ddlFilterUni"];
        $collId=$_GET["ddlFilterColl"];
        $degId=$_GET["ddlFilterDeg"];
        $subId=$_GET["ddlFilterSub"];
        $semId=$_GET["ddlFilterSem"];
        if ($uniId == 0 && $collId == 0 && $degId == 0 && $subId == 0 && $semId == 0) {
            echo "<script type='text/javascript'>alert('please select any data');</script>";
        }
        $allvalues = '';
        $columnNames = '';
        if ($uniId != 0 && $collId != 0 && $degId != 0 && $subId != 0 && $semId != 0) {
            $allvalues = $uniId . '~' . $collId . '~' . $degId . '~' . $subId . '~' . $semId;
            $columnNames = 'INT_UNI_ID' . ',' . 'INT_COLL_ID' . ',' . 'INT_DEG_ID' . ',' . 'INT_SUB_ID' . ',' . 'INT_SEM_ID';
        }
        if ($uniId != 0) {
            $allvalues = $uniId;
            $columnNames = 'INT_UNI_ID';
            $query = 'nm.INT_UNI_ID' . '=' . $uniId . ' ';
        }
        if ($collId != 0) {
            $allvalues .= ',' . $collId;
            $columnNames .= ',' . 'INT_COLL_ID';
            $query .= 'AND' . ' ' . 'nm.INT_COLL_ID' . '=' . $collId . ' ';
        }
        if ($degId != 0) {
            $allvalues .= ',' . $degId;
            $columnNames .= ',' . 'INT_DEG_ID';
            $query .= 'AND' . ' ' . 'nm.INT_DEG_ID' . '=' . $degId . ' ';
        }
        if ($subId != 0) {
            $allvalues .= ',' . $subId;
            $columnNames .= ',' . 'INT_SUB_ID';
            $query .= 'AND' . ' ' . 'nm.INT_SUB_ID' . '=' . $subId . ' ';
        }
        if ($semId != 0) {
            $allvalues .= ',' . $semId;
            $columnNames .= ',' . 'INT_SEM_ID';
            $query .= 'AND' . ' ' . 'nm.INT_SEM_ID' . '=' . $semId . ' ';
        }

        if(isset($_SESSION["id"])){
            $usrId=$_SESSION["id"];
            $builtquery="SELECT (select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1) TOTAL_LIKE,
                    (select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0) TOTAL_DISLIKE,
                    (select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1 AND INT_USER_ID=$usrId) IS_USER_LIKE,
                    (select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0 AND INT_USER_ID=$usrId) IS_USER_DISLIKE,
                    (SELECT COUNT(INT_ACTION)  FROM t_user_fav tuf WHERE tuf.INT_USER_ID=$usrId and tuf.int_notes_id=nm.INT_NOTES_ID AND tuf.BIT_DELETED_FLAG=0 AND tuf.INT_ACTION=1
                    ) AS IS_USER_FAV,
                    (select count(int_notes_id) from t_download_details where INT_NOTES_ID=nm.INT_NOTES_ID) as total_downloads,
        
                    (select count(int_notes_id) from t_download_details WHERE int_notes_id=nm.INT_NOTES_ID AND INT_USER_ID=$usrId) IS_USER_DOWNLOAD,
     
                    nm.INT_NOTES_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,usermas.VCH_USER_NAME,um.VCH_UNIVERSITY_NAME,
                    dm.VCH_DEGREE_NAME,sm.VCH_SUB_NAME,semmas.VCH_SEMESTER,
                    collmas.VCH_COLLEGE_NAME,nm.DTM_CREATED_DATE,sysdate() as current_timestmp FROM m_notes_master 
                    nm INNER JOIN m_university_master um ON nm.INT_UNI_ID=um.INT_UNI_ID
                    INNER JOIN m_degree_master dm ON nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_subject_master sm
                    ON nm.INT_SUB_ID=sm.INT_SUB_ID INNER JOIN m_user_mas usermas ON nm.VCH_CREATED_BY=usermas.INT_USER_ID
                    INNER JOIN m_semester semmas ON nm.INT_SEM_ID=semmas.INT_SEM_ID
                    INNER JOIN m_college_master collmas ON nm.INT_COLL_ID=collmas.INT_COLL_ID
                    WHERE nm.INT_NOTES_STATUS=1 AND nm.BIT_DELETED_FLAG=0 AND ($query)";
        }
        else{
            $builtquery="SELECT (select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1) TOTAL_LIKE,
                    (select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0) TOTAL_DISLIKE,
                    (select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1 AND INT_USER_ID='') IS_USER_LIKE,
                    (select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0 AND INT_USER_ID='') IS_USER_DISLIKE,
                    (SELECT COUNT(INT_ACTION)  FROM t_user_fav tuf WHERE tuf.INT_USER_ID='' and tuf.int_notes_id=nm.INT_NOTES_ID AND tuf.BIT_DELETED_FLAG=0 AND tuf.INT_ACTION=1
                    ) AS IS_USER_FAV,
                    (select count(int_notes_id) from t_download_details where INT_NOTES_ID=nm.INT_NOTES_ID) as total_downloads,
        
                    (select count(int_notes_id) from t_download_details WHERE int_notes_id=nm.INT_NOTES_ID AND INT_USER_ID='') IS_USER_DOWNLOAD,
     
                    nm.INT_NOTES_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,usermas.VCH_USER_NAME,um.VCH_UNIVERSITY_NAME,
                    dm.VCH_DEGREE_NAME,sm.VCH_SUB_NAME,semmas.VCH_SEMESTER,
                    collmas.VCH_COLLEGE_NAME,nm.DTM_CREATED_DATE,sysdate() as current_timestmp FROM m_notes_master 
                    nm INNER JOIN m_university_master um ON nm.INT_UNI_ID=um.INT_UNI_ID
                    INNER JOIN m_degree_master dm ON nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_subject_master sm
                    ON nm.INT_SUB_ID=sm.INT_SUB_ID INNER JOIN m_user_mas usermas ON nm.VCH_CREATED_BY=usermas.INT_USER_ID
                    INNER JOIN m_semester semmas ON nm.INT_SEM_ID=semmas.INT_SEM_ID
                    INNER JOIN m_college_master collmas ON nm.INT_COLL_ID=collmas.INT_COLL_ID
                    WHERE nm.INT_NOTES_STATUS=1 AND nm.BIT_DELETED_FLAG=0 AND ($query)";
        }

        $stmt=$conn->prepare($builtquery);
        $result=$stmt->execute();
        $countofSearchResult = $stmt->rowCount();
        $val=0;
        //code added by vivek kr sahu on 06-05-2019
      
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style-index-inc.css" rel="stylesheet">
		<link rel="stylesheet" href="https://unicons.iconscout.com/release/v0.0.3/css/unicons.css">

		<script src="js/jquery.js"></script>
		<noscript><meta http-equiv="refresh" content="0; URL=error.php?np=noscript"></noscript>	<!--modified by mehul 15-05-19-->
	</head>
	<body>
	
			<div class="topnav" id="myTopnav">
                    <a href="<?php ($_SERVER['PHP_SELF']) ?>" class="" id="icon">E-Powernotes</a>	
                    <form method="GET" action="<?php ($_SERVER['PHP_SELF']) ?>">                   				
					<a   class="searchBox">		
							<input type="text" class="form-control" id="txtSearchBar" name="txtSearchBar" value="<?php echo $showTxtBar; ?>">
							<button class="btn btn-default" id="btnSearch" name="btnSearch">Search</button>
                  
</a>
</form>
					<a class="navbar-right" onclick="window.location.href='index-profile.php'">

						<?php if(isset($_SESSION["id"])){ ?>
                		 	<img id="<?php echo $_SESSION["id"] ?>" class="img img-circle userImageClass" alt="user name">
                			<script>
                    			var id=$(".userImageClass").prop("id");
                    			var flag="getUserImage";
                    			$.ajax({
                        			url:"callServiceRegLogin.php",
                        			method:"post",
                        			dataType:"json",
                        			data:{action:flag,userid:id},
                        			success:function(data){
                            			$(".userImageClass").attr('src',data.userprofile);
                            			$(".userImageClass").attr('title',data.userName);
                        			}
                    			});
                			</script>
            			<?php }
                			 ?>
			
					</a>
			</div>


            <?php
                      //code for logout     
                           if(isset($_POST['btnlogout'])){
                            session_destroy();
                            $configmgr= new configmgr();
                           $returnUrl= $configmgr->returnurlasperflag();
                           $configmgr=null;
                               header('Location:'.$returnUrl.$_SERVER['REQUEST_URI']);
                           }
                           

                        ?>
			<!------------sidebar starts------------->

			<div class="sidebar" id="mySidebar">
					<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><span class="fa fa-arrow-left"></span></a>
					<?php if(isset($_SESSION["id"])){ ?>
						<a href="index.php"> <i class='uil uil-home-alt'></i> <p>Home </p></a>
						<a href="#" id="notesFilter" onclick="getFilterModal()"> <i class='uil uil-filter'></i> <p> Filter </p> </a>
                        <a href="leaderboard.php"> <i class='uil uil-trophy'></i><p>Leaderboard</p></a>
						<a href="index-profile.php"  id="userProfile"> <i class='uil uil-user'></i> <p> Profile </p> </a>
						<a href="user-history.php"><i class='uil uil-upload-alt'></i> <p> My uploads</p></a>
						<a href="user-favourite-notes.php"> <i class='uil uil-favorite'></i> <p> Favourites</p> </a>
                        <a href="notes-upload.php"> <i class='uil uil-upload'></i> <p> Upload </p> </a>
                       
                        <form method="post" action=<?php echo $_SERVER['REQUEST_URI']; ?>>

                      <button class="logout" name="btnlogout"> <i class='uil uil-sign-out-alt'></i> <p> Sign out </p></button>
                       <!--<input type="submit" name="btnlogout"><i class='uil uil-sign-out-alt'></i> <p> Sign out </p></input>-->
                        </form> 
					<?php }
						else{ ?>
							<a href="index.php"> <i class='uil uil-home-alt'></i> <p>Home </p></a>
                            <a href="#" id="notesFilter" onclick="getFilterModal()"> <i class='uil uil-filter'></i> <p> Filter </p></a>
                            <a href="leaderboard.php"> <i class='uil uil-trophy'></i><p>Leaderboard</p></a>
							<a href="#" id="btnLoginSmallScreen"> <i class='uil uil-user'></i> <p> Login </p> </a>
							<a href="#" id="btnSignUp"> <i class='uil uil-sign-in-alt'></i> <p> Sign up </p> </a>
					<?php  } ?>
					

			</div>
			<button class="openbtn" id="opensidebar" onclick="openNav()"><span class="fa fa-arrow-right"></span></button>
			<!-------------sidebar ends------------->

			<!--=============
                Filter modal starts..
            ===============-->  
            <form method="GET" action="<?php ($_SERVER['PHP_SELF']) ?>">
            <div class="filterBox" id="filterBox">
                <div class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-3" id="lblFilterUni">University</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ddlFilterUni" name="ddlFilterUni" onchange="getcollege()">
                                <option value="0">==select==</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" id="lblFilterColl">College</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ddlFilterColl" name="ddlFilterColl" onchange="getdegree()">
                                <option value="0">==select==</option>
                                <option value="0">Select university</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" id="lblFilterDeg">Degree</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ddlFilterDeg" name="ddlFilterDeg" onchange="getsubject()">
                                <option value="0">==select==</option>
                                <option value="0">Select university and college</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" id="lblFilterSub">Subject</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ddlFilterSub" name="ddlFilterSub">
                            <option value="0">==select==</option>
                            <option value="0">Select university,college and degree</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" id="lblFilterSem" name="lblFilterSem">Semester</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ddlFilterSem" name="ddlFilterSem">
                                <option value="0">==select==</option>
                                <option value="0">Select degree</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12 button-row">
                            <div class="col-sm-6 btn-search">
                                <input type="submit" class="btn btn-default" id="btnSearchFilter" name="btnSearchFilter" value="Search">
                            </div>

                            <div class="col-sm-6 btn-close">
                                <input type="submit" class="btn btn-default" id="btnCloseFilter" value="Close">    
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </form>
            <!--=============
                Filter modal ends..
            ===============-->

			<div id="main">
				
			</div>
	
	</body>
	<script>
  		function openNav() {
   		 document.getElementById("mySidebar").style.width = "110px";
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
				document.getElementById("mySidebar").style.width = "110px";
				document.getElementById("main").style.marginLeft = "200px";
			}
  		};
	})();

		  }

		  	//preventing the default action on click..
		  	var btnsignup=document.getElementById("opensidebar");
        	var btnChangePass=document.getElementById("btnChangePass");
            var btnCloseForPopup=document.getElementById("btnCloseForPopup");
            $(btnsignup).click(function(event){
                event.preventDefault(); // cancel default behavior
            });
	</script>

	<script>	//getting data for filter..

			function getFilterModal(){      
                    var modal=document.getElementById("filterBox");
                    if(modal.style.display==="block"){
                        modal.style.display="none";
                    }
                    else{
                        modal.style.display="block";
                    }
                    //collapsing the navbar again..
                    var x = document.getElementById("myTopnav");
                        x.className = "topnav";
                }
				
				$("#btnCloseFilter").click(function(event){		//this function will close the filter..
					event.preventDefault();
					var modal=document.getElementById("filterBox");
                    modal.style.display="none";
				})


		function getcollege() { //get the list of colleges as user select university             
                    $("#container").removeAttr('style');   //displaying the loading circles..       
                    var flag = "college";
                    var universityId = document.getElementById("ddlFilterUni").value;
                    if(universityId==0){
                        $("#container").attr('style', 'display:none');      //removing the loading circle..
                        return false;
                    }
                    else{
                        $.ajax({
                        url: "callServiceSearchNotes.php",
                        method: "POST",
                        data: {action: flag,id: universityId},
                        dataType: "json", 
                        success: function(data) {
                            $("#ddlFilterColl").empty();
                            $("#ddlFilterColl").append("<option value='0'>==select==</option>");
                            $.each(data, function(i, item) {
                                $('#ddlFilterColl').append('<option value="' + data[i].colId + '">' + data[i].colName + '</option>');
                                });

                                $("#container").attr('style', 'display:none');      //removing the loading circles..
                            }
                        });
                    }
				}
				
				function getdegree() { //get the list of degrees as user select the college..
                    $("#container").removeAttr('style');   //displaying the loading circles..
                    var flag = "degree";
                    var collegeId = document.getElementById("ddlFilterColl").value;
                    if(collegeId==0){
                        $("#container").attr('style', 'display:none');      //removing the loading circle..
                        return false;
                    }
                    else{
                        $.ajax({
                        url: "callServiceSearchNotes.php",
                        method: "POST",
                        data: {action: flag,id: collegeId},
                        dataType: "json",
                        success: function(data) {
                            $("#ddlFilterDeg").empty();
                            $("#ddlFilterDeg").append("<option value='0'>==select==</option>");
                            $.each(data, function(i, item) {
                                $('#ddlFilterDeg').append('<option value="' + data[i].degId + '">' + data[i].degName + '</option>');
                            });

                            $("#container").attr('style', 'display:none');      //removing the loading circles..
                        }
                    });
                    }
				}
				
				function getsubject() { //this function will bind subjects..
                    $("#container").removeAttr('style');   //displaying the loading circles..
                    var flagsub = "subject";
                    var uniId = document.getElementById("ddlFilterUni").value;
                    var degId = document.getElementById("ddlFilterDeg").value;
                    if(uniId==0 || degId==0){
                        $("#container").attr('style', 'display:none');      //removing the loading circle..
                        return false;
                    }
                    else{
                        $.ajax({
                        url: "callServiceSearchNotes.php",
                        method: "POST",
                        data: {action: flagsub,university: uniId,degree: degId},
                        dataType: "json",
                        success: function(data) {
                            $("#ddlFilterSub").empty();
                            $("#ddlFilterSub").append("<option value='0'>==select==</option>");
                            $.each(data, function(i, item) {
                            $('#ddlFilterSub').append('<option value="' + data[i].subId + '">' + data[i].subName + '</option>');
                        });
                        $("#container").attr('style', 'display:none');      //removing the loading circles..
                    }
                    });
                    getsemester();  //binding the semester as user select the degree..
                    }
				}
				
				function getsemester() { // as the user select degree semester starts binding according to selected degree..
                    $("#container").removeAttr('style');   //displaying the loading circles..
                    var flagsem = "semester";
                    var degreeId = document.getElementById("ddlFilterDeg").value;
                    if(degreeId==0){
                        $("#container").attr('style', 'display:none');      //removing the loading circle..
                        return false;
                    }
                    else{
                        $.ajax({
                        url: "callServiceSearchNotes.php",
                        method: "POST",
                        data: {action: flagsem,id: degreeId},
                        dataType: "json",
                        success: function(data) {
                            $("#ddlFilterSem").empty();
                            $("#ddlFilterSem").append("<option value='0'>==select==</option>");
                            $.each(data, function(i, item) {
                                $('#ddlFilterSem').append('<option value="' + data[i].semId + '">' + data[i].semName + '</option>');
                            });
                            $("#container").attr('style', 'display:none');      //removing the loading circles..
                        }
                    });
                    }
                }
	</script>
	
		
</html>