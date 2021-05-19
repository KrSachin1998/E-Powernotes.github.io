<?php
?>
<!DOCTYPE html>
<html>    
<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/jquery.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="css/style-forget-password.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
<br>
    <div class="message">
        <h2>Password recovery</h2>
  
        <!--=    for showing message starts       =-->
        <div class="alert alert-dismissible fade in" id="showMessagePassCng">   
       
        </div>
        <!--=    for showing message ends       =-->
        <input type="hidden" id="txtUserEmail">
        <input type="password" id="txtNewPass" class="form-control" placeholder="New password">
        <input type="password" id="txtConfPass" class="form-control" placeholder="Confirm password">
        <div class="btn-here">
            <input type="submit" class="btn btn-sm" id="btnChangePassword" onclick="changePassword()" value="Change">
        </div>
    </div>

        <!--echo "<script type='text/javascript'>window.top.location='index.php';</script>";-->
        
</div>      <!--      end of container..      -->

    <!-- The Modal --> 
    <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h3 class="heading-login">Login</h3>
                </div>
                <div class="modal-body">   
                    <h5> Please login to your account to continue with E-Powernotes</h5>

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
                        <h6 class="forgorPass"><a href="#">Forgot password</a></h6>
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
</body>
<script src="js/activate-user.js"></script>
<script>
    function changePassword(){
        var newPass=$("#txtNewPass").val();
        var conPass=$("#txtConfPass").val();
        var email=$("#txtUserEmail").val();
        var flag="updatePassword";
        if(newPass.trim()==""){
            $("#txtNewPass").val("");
            $("#txtNewPass").css("border","1px solid red");
            $("#txtNewPass").attr("placeholder","* Enter new password");
            $("#txtNewPass").focus();
        }
        else if(conPass.trim()==""){
            $("#txtConfPass").val("");
            $("#txtConfPass").css("border","1px solid red");
            $("#txtConfPass").attr("placeholder","* Confirm password");
            $("#txtConfPass").focus();
        }
        else if(newPass!=conPass){
            $("#txtConfPass").val("");
            $("#txtConfPass").css("border","1px solid red");
            $("#txtConfPass").attr("placeholder","* Enter similar password");
            $("#txtConfPass").focus();

            $("#txtNewPass").val("");
            $("#txtNewPass").css("border","1px solid red");
            $("#txtNewPass").attr("placeholder","* Enter similar password");
            $("#txtNewPass").focus(); 
        }
		
		else if(newPass.length<6){         //checking the  minimum length of password..
            $("#txtConfPass").val("");
            $("#txtNewPass").val("");
            $("#txtNewPass").css("border","1px solid red");
            $("#txtNewPass").attr("placeholder","* password too short (min 6 )");      
            $("#txtNewPass").focus();
            return false;
        }
		
        else{
			$("#btnChangePassword").val('Changing');
        $("#btnChangePassword").attr('disabled','disabled');
            $.ajax({
                        url:"callServiceRegLogin.php",
                        method:"POST",
                        data:{action:flag,newpassword:newPass,useremail:email},
                        success:function(data){
							data=data.trim();
                            if(data=='success'){
                                $("#showMessagePassCng").addClass('alert-success');
                                $("#showMessagePassCng").html("<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Password changed successfully <a href='index.php' >home</a>");
                                //$("#removeAlert").html('&times;');
								$("#txtConfPass").val("");
								$("#txtNewPass").val("");
                            }
                            else if(data=='failed'){
                                $("#showMessagePassCng").addClass('alert-warning');
                                $("#showMessagePassCng").html("<strong><span class='fa fa-exclamation-triangle'></span></strong>something went wrong please try again later <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> ");
                                $("#txtConfPass").val("");
								$("#txtNewPass").val("");
                            }              

							$("#btnChangePassword").val('Change');
            $("#btnChangePassword").removeAttr('disabled');
							
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
                                window.location.href = "index-home.php";
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