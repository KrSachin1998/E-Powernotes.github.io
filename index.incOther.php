<?php
require_once 'app_code/configmgr.php';
	session_start();
	if( !(isset($_SESSION["id"])) ){
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
		<link href="css/style-index-inc.css" rel="stylesheet">
		<link href="css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" href="https://unicons.iconscout.com/release/v0.0.3/css/unicons.css">		
		<script src="js/jquery.js"></script>
		<noscript><meta http-equiv="refresh" content="0; URL=error.php?np=noscript"></noscript>	<!--modified by mehul 15-05-19-->
		
	</head>
	<body>
			<div class="topnav" id="myTopnav">
					<a href="index.php" class="" id="icon">E-PowerNotes</a>				
					<a class="navbar-right" onclick="window.location.href='index-profile.php'">

						<?php  require_once "app_code/configmgr.php";
          
            $configmgr=new configmgr();
            $timeVal=$configmgr->logoutTime();
            $configmgr=null;
            if(isset($_SESSION["id"])&& (time()-$_SESSION["loggedAt"])<$timeVal){ ?>
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
						else{
							session_destroy();
							header('Location:index.php');
						}
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
					<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class='uil uil-arrow-left'></i></a>


					<a href="index.php"> <i class='uil uil-home-alt'></i> <p>Home </p></a>
					
					<a href="index-profile.php"  id="userProfile"> <i class='uil uil-user'></i> <p> Profile </p></a>
					<a href="leaderboard.php"> <i class='uil uil-trophy'></i><p>Leaderboard</p></a>
					<a href="user-history.php" id="userMyUploads"> <i class='uil uil-upload-alt'></i> <p> My uploads</p></a>
					<a href="user-favourite-notes.php" id="userFavourites"><i class='uil uil-favorite'></i> <p> Favourites</p></a>
					<a href="notes-upload.php" id="userUpload"><i class='uil uil-upload'></i> <p> Upload </p></a>
					<form method="post" action=<?php echo $_SERVER['REQUEST_URI']; ?>>

<button class="logout" name="btnlogout"> <i class='uil uil-sign-out-alt'></i> <p> Sign out </p></button>
 <!--<input type="submit" name="btnlogout"><i class='uil uil-sign-out-alt'></i> <p> Sign out </p></input>-->
  </form>
					
			</div>
			<button class="openbtn" onclick="openNav()"><i class='uil uil-arrow-right'></i></button>
			<!-------------sidebar ends------------->

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
	</script>
	
		
</html>