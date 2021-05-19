
<!DOCTYPE html>
<html>    
<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/jquery.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="css/style-activate-user.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
<?php
            include("core/connpdo.php");
            require_once "app_code/configmgr.php";
            require_once "app_code/sqlhelper.php";
            if(isset($_GET["activateId"])){
              $encData=base64_decode(urldecode($_GET["activateId"]));
              $encId=base64_decode(urldecode($_GET["aci"]));
              $configmgr=new configmgr();    
               $dcryCnt= $configmgr->forDecrypt($encData);
               $dcryid=$configmgr->forDecrypt($encId);
                    
                     if(!$dcryCnt){
                      echo "<h3>Invalid Link !!</h3>";
                       exit;
                     }
                     $sqlhelper = new SqlHelper();
                     $response= $sqlhelper->maintainlogforExpiryofLink($conn,'LINKVALIDITY',$dcryid,'Fp');
                     $genNewLink=$configmgr->generatelinkfornewActivation();
                     $configmgr=null;
                     $sqlhelper=null;
                     if($response==0){
                         echo "<h3>Activation link is expired!!! For generating new link <a href='".$genNewLink."'>Click Here</a></h3>";
                         exit;
                     }
                $userid=$dcryCnt;
                $stmt = $conn->prepare('call USP_ACTIVATE_ACCOUNT(?)');
                $stmt->bindParam(1, $userid); 
               $ifexecute= $stmt->execute();
          if($ifexecute){

         ?>
<br>
    <div class="message">
        <h2>Verification successful</h2>
        <h4>Thanks! Your email address has been verified.</h4>
        <h4>Go back to <a href="index.php">home</a> or login with your email.</h4>
        <div class="btn-here">
            <input type="submit" id="myBtn" class="btn btn-sm" value="Login">
        </div>
    </div>
</div>

            <!--============================
                      popup for password change starts..
          ==============================-->
          <div class="popup-box" id="popup-box">
            <h2>Password recovery</h2>
            <!--=    for showing message starts       =-->
              <div class="alert alert-dismissible fade in" id="showPassChangeMsg">   
    
              </div>
            <!--=    for showing message ends       =-->

              <input type="text" id="txtEmailForNewPass" class="form-control" placeholder="Enter registered email">
              <div class="btn-here">
                <input type="submit" class="btn btn-sm" onclick="updatePassChange()" value="Submit">
                <input type="submit" class="btn btn-sm" onclick="getpopup()" value="Close">
              </div>
          </div>
          <!--===
                      popup for password change ends..
          ===-->

    <!-- The Modal -->
    <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h3 class="heading-login">Login</h3>
                </div>
                <div class="modal-body">   
                    <h5> Please login to your account to continue with w3highschools</h5>

                        <!--------displaying error or success message starts-------->
                        <div class="alert alert-dismissible fade in" id="showMessage">   
    
                        </div>
                        <!--------displaying error or success messages ends------->

                    <div class="row">
                        <div class="userEmail">
                            <span class="fa fa-user userIcon"></span>
                            <input type="text" id="txtUserLoginEmail" class="form-control" placeholder="Email">
                        </div>
                    </div>

                    <div class="row">
                        <div class="userEmail">
                            <span class="fa fa-lock userIcon"></span>
                            <input type="password" id="txtUserLoginPassword" class="form-control" placeholder="Password">
                        </div>
                    </div>

                    <div class="row">
                        <input type="submit" id="btnLogin" onclick="userLogin()" class="btn btn-default" value="LOGIN">
                        <h6 class="forgorPass"><a href="#" onclick="getpopup()" >Forgot password</a></h6>
                    </div>

                    <div class="row login-with-other">
                        <h5 class="help-text"> or login with </h5>
                        <span class="fa fa-facebook"></span>
                        <span class="fa fa-google-plus"></span>
                    </div>
                    <hr>
                    <div class="row new-signup">
                        <span class="for-new-signup">Don't have an account?  <a href="user-registration.php">signup now</a></span>
                    </div>

                </div>

            </div>

          </div>
          <!------------modal end--------->
       <?php }// end of if execute
        else{ 
          ?>
            <div class="message">
                <h4>opps! Some problem occured.<br/> Try again later <a href="index.php">home</a> </h4>
            </div>
     <?php   }
        } 
        else{
            echo "some error occured";
        } 
        ?>
</body>
<script src="js/activate-user.js"></script>
<script>
    function getpopup(){        //get popup to change password..
                var modalPass= document.getElementById("popup-box");
                if(modalPass.style.display==="block"){
                  modalPass.style.display="none";
                }
                else {
                  modalPass.style.display="block";
                }
				//hinding the login modal..
                document.getElementById("myModal").style.display="none";
              }

         function updatePassChange(){      //this function will send password change link to the user email..
                var useremail=$("#txtEmailForNewPass").val();
                var flag="checkUserEmail";
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(useremail.trim()==""){
                  $("#txtEmailForNewPass").attr('placeholder','* Enter your email');
                  $("#txtEmailForNewPass").css('border','1px solid red');
                }
                else if(!regex.test(useremail)){
                  $("#txtEmailForNewPass").val('');
                  $("#txtEmailForNewPass").attr('placeholder','* Enter valid email');
                  $("#txtEmailForNewPass").css('border','1px solid red');
                }
                else{
                  $.ajax({
                  url:"callServiceSearchNotes.php",
                  method:"POST",
                  data:{action:flag,email:useremail},
                  success:function(data){
                    if(data==1){
                      $("#showPassChangeMsg").addClass('alert-success');
                      $("#showPassChangeMsg").html("<strong><span class='fa fa-smile-o'></span></strong> Password recovery link has been sent to your email  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> ");
                    
                    }
                    else if(data==0){
                      $("#showPassChangeMsg").addClass('alert-warning');
                      $("#showPassChangeMsg").html("<strong><span class='fa fa-exclamation-triangle'></span></strong> Email not registered <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> ");
                    
                    }
                    else{
                      alert('oops! something went wrong');
                    }
                  }
                  });
                }
                
              }
         
    function userLogin(){ 
                    var email= $("#txtUserLoginEmail").val();
                    var pass= $("#txtUserLoginPassword").val();
                    var flag="userLogin";
                    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if(email.trim()=='' || !regex.test(email)){
                      $("#txtUserLoginEmail").css("border","1px solid red");
                      $("#txtUserLoginEmail").val("");
                      $("#txtUserLoginEmail").attr("placeholder","* Enter valid email");
                      $("#txtUserLoginEmail").focus();
                    }
                    else if(pass.trim()==''){
                      $("#txtUserLoginEmail").css("border","1px solid #ccc");

                      $("#txtUserLoginPassword").css("border","1px solid red");
                      $("#txtUserLoginPassword").attr("placeholder","* Enter password");
                      $("#txtUserLoginPassword").focus();
                    }
                    else{                      
                    $.ajax({
                        url:"callServiceRegLogin.php",
                        method:"POST",
                        data:{action:flag,userEmail:email,userPass:pass},
                        success:function(data){
                            if(data==0){
                                $("#showMessage").addClass('alert-warning');
                                $("#showMessage").html("<strong><span class='fa fa-exclamation-triangle'></span></strong> Email or Password incorrect <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> ");
                                //$("#removeAlert").html("&times;");
                            }
                            else if(data==1){
                                $("#showMessage").addClass('alert-warning');
                                $("#showMessage").html("<strong><span class='fa fa-exclamation-triangle'></span></strong><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Account not activated  <br> <h6>Note: please click on the link sent on your email to activate your account</h6> ");
                                //$("#removeAlert").html('&times;');
                            }   
                            else if(data==2){   //the user is normal user and redirecting him/her to website..
                                window.location.href = "index.php";
                            }
                            else if(data==4){   //the user is admin and redirecting him/her to admin dashboard..
                              window.location.href = "user-admin.php";
                            }
                            else if(data==3){   //server side validation returning value..
                              alert('Enter valid data');  
                            }                           
                        }
                    });
                  }
                }
</script>
</html>