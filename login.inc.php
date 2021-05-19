<!DOCTYPE html>
<html>
    <head>
  <meta name="keywords" content="HTML,CSS,XML,JavaScript">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/jquery.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v0.0.3/css/unicons.css">
        <link href="css/style-index.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
		<noscript><meta http-equiv="refresh" content="0; URL=error.php?np=noscript"></noscript>	<!--modified by sachin 15-05-21-->
<style>
.input-group{
    margin: 15px;
    width: 100%;
    background: #fff;
    border-radius: 50px;
	}
	.search_bar{
    padding: 0;
    margin-top: -25px;
    padding-right: 15%;
}
sub{
  font-size: 12px;
}
</style>
    </head>

    <body> 
            
        <section class="middle-box" id="middleBox">    <!--It contain all the items between nav and footer-->

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

          <!--<li id="myBtn"><a>Login</a></li>-->

            <!-- The Modal -->
          <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content" id="modal-content">
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
                      <i class='uil uil-envelope userIcon'></i>
                      <input type="text" id="txtUserLoginEmail" class="form-control" placeholder="Email">
                    </div>
                  </div>

                  <div class="row">
                    <div class="userEmail">
                      <i class='uil uil-lock userIcon'></i>
                      <input type="password" id="txtUserLoginPassword" class="form-control" placeholder="Password">
                    </div>
                  </div>

                  <div class="row">
                    <input type="submit" id="btnLogin" onclick="userLogin()" class="btn btn-default" value="LOGIN">
                    <h6 class="forgorPass" onclick="getpopup()" ><a href="#">Forgot password</a></h6>
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

          </section>
            <script src="js/index-page.js"></script>
            <script>

                $(document).keypress(function(event){         //event trigger on pressing enter..
                  var keycode = (event.keyCode ? event.keyCode : event.which);    //modified by sachin
                  var targetElement=event.target.id;                              // date 14-05-2021
                  if(keycode=='13'){
                    if(targetElement=='btnLoginUser' || targetElement=='txtUserLoginEmail' || targetElement=='txtUserLoginPassword'){
                      userLogin();  //user is trying to login..
                    }

                    if(targetElement=='txtSearchBar' || targetElement=='myPage'){
                      search();   //searching the data on pressing enter..
                    }
                   // alert(targetElement); 
                  }
                });

              //assigning notes,assignments and question paper when user clicked..
              //on the below the images of notes, assignments and question paper
              function showNotesSearchBar(){
                $("#txtSearchBar").val('Notes');
              }

              function showAssignSearchBar(){
                $("#txtSearchBar").val('Assignment');
              }

              function showQuestionSearchBar(){
                $("#txtSearchBar").val('Question paper');
              }

              function showAllHereSearchBar(){
                $("#txtSearchBar").val('Notes Assignments Question paper');
              }


              //popup of after user logged in starts..
              $("#collapse").click(function() {    
                var content = document.getElementById("content");
                if (content.style.opacity==0){
                  content.style.opacity = 1;
                } else {
                  content.style.opacity = 0;
                } 
              });
              //popup of after user logged in starts..

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
                  url:"callServiceRegLogin.php",
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

              function clearFields(){
                $('#txtUserLoginPassword').val('');
              }

               

                function getModalAgain(){
                  var modal = document.getElementById('myModal');
                  modal.style.display = "block";
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
                      $('#btnLogin').attr('disabled','disabled');  //making the login button disable..

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
                            clearFields();                   
                            $('#btnLogin').removeAttr('disabled');  //making the login button enable again..       
                        }
                    });
                  }
                }
            </script>

            </body>
</html>