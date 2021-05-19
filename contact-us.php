<!--<!DOCTYPE html>-->
<html>
<head>
    <title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">    

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v0.0.3/css/unicons.css">

    <link href="css/loader.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/styleUserRegistration.css" rel="stylesheet">
    <noscript><meta http-equiv="refresh" content="0; URL=error.php?np=noscript"></noscript>
</head>
<body>
    
    <!--for display loading-->
    <div id="container">
            <svg class="loader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340">
                <circle cx="170" cy="170" r="160" stroke="#E2007C" />
                <circle cx="170" cy="170" r="135" stroke="#404041" />
                <circle cx="170" cy="170" r="110" stroke="#E2007C" />
                <circle cx="170" cy="170" r="85" stroke="#404041" />
            </svg>
        </div>
        <!--====================-->

        <!-- The Modal for warning and success-->
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content modal-content-warsucc" id="modal-body">
                <!--<span class="close" id="btnCloseModal">&times;</span>-->
                
            </div>
        </div>
        <!-- The Modal for warning and success Ends-->

<div class="header">
        
        <div class="container heading-box">               
                <h4>E-Powernotes</h4>                               
        </div>                                           
</div>

    <div class="col-sm-3 sidebar">
        <div class="sidebar-content">
            <a class="active" href="index.php"><i class='uil uil-home-alt'></i> <p>Home</p> </a>
            <a class="active" href="user-registration.php"><i class='uil uil-sign-in-alt'></i> <p>Sign in</p> </a>
            <a href="contact-us.php"><i class='uil uil-phone'></i> <p>Contact</p> </a>
            <a href="about-us.html"><i class='uil uil-book-open'></i> <p>About</p> </a>
        </div>
    </div>

    <div class="col-sm-9 content">
        <!--------user register form starts---------->
        <div class="register-form form-horizontal">
            <h2 class="headingCenter">Contact us </h2>
            <hr class="upload-hr">
                <h5>Please feel free to ask any thing or provide any suggestions </h5>
                <br>
                <div class="row">

                    <div class="form-group col-sm-4">
                        <div class="userEmail">
                            <i class='uil uil-user userIcon'></i>
                            <input type="text" class="form-control" placeholder="Your name" id="txtUserName" onblur="checktextfield()" onkeypress="return onlyAlphaHyphUnder(event,this);" >
                        </div>
                    </div>

                    <div class="form-group col-sm-4">
                        <div class="userEmail">
                            <i class='uil uil-envelope userIcon'></i>
                            <input type="text" class="form-control" placeholder="Your email" id="txtUserEmail">
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="form-group col-sm-4">
                        <div class="userEmail">
                            <i class='uil uil-phone userIcon'></i>
                            <input type="text" class="form-control" placeholder="Mobile no" id="txtUserMobileNo">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <div class="userEmail">
                            <i class='uil uil-comment-message userIcon'></i>
                            <textarea row="4" col="50" placeholder="Write your message" class="form-control" id="userMessage" onblur="checktextfieldMesg()" onkeypress="return onlyAlphaHyphUnder(event,this);" name="description">
                            </textarea>
                        </div>
                    </div>
                </div>


            
                <!--<div class="row">
                    <div class="col-sm-12 termsCondition">
                        <input type="checkbox" id="chkBoxTermsCondi" > <h5 id="headingTermsCon" > I agreed to <a href="#" id="myBtn">terms and conditions </a></h5>
                    </div>  
                </div>-->

                <div class="row">
                    <div class="col-sm-4">
                        <input type="submit" class="btn bnt-default" id="btnSendEmail" value="Send" onclick="sendMessage()">
                    </div>  
                </div> 
                   
                <br>   
                
                <div class="row contact-row-bottom">
                    <p class="contact-phoneNo"><i class='uil uil-phone'></i> 6200000000 / 8200000000</p>
                    <p><i class='uil uil-envelope' class="contact-emailIds"></i> info@powernotes.com </p>
                </div>
        </div>
        <!--------user register form ends---------->

    </div>   
</body>

<script src="js/registration.js"></script>
<script>

    $(document).ready(function(){
        $("#container").attr('style', 'display:none');      //removing the loading circles..
        $("#userMessage").val("");
    });

    //validating the user name on key press allowing only alphabets and spaces..
    function onlyAlphaHyphUnder(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode > 47 && charCode < 58) || charCode == 32 || charCode==45 ||charCode==46 ||charCode==95 ||charCode==43)
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
    }

    $("#txtUserMobileNo").keypress(function (e) { //validating phone no field so that user can only insert number uto 10 digits..
            var length = jQuery(this).val().length;
            if(length > 9) {
                return false;
            } 
            else if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
            else if((length == 0) && (e.which == 48)) {
                return false;
            }
        });

    function checktextfield(){
        var value=$("#txtUserName").val();
        var regexNew=/^[\sa-zA-Z0-9-_./+]+$/;
        if(!(regexNew.test(value))){
            $("#txtUserName").css("border","1px solid red");
            $("#txtUserName").val("");
            $("#txtUserName").attr("placeholder","* Enter valid Name");
            $("#txtUserName").focus();
            return false;
        }
        else{
            $("#txtUserName").css("border","1px solid #ccc");
        }
    }

    function checktextfieldMesg(){                                
        var value=$("#userMessage").val();                        
        var regex=/^\w+([\s-_.]\w+)*$/;
        var regexNew=/^[\sa-zA-Z0-9-_.+]+$/;
        if(!(regexNew.test(value))){
            $("#userMessage").css("border","1px solid red");
            $("#userMessage").val("");
            $("#userMessage").attr("placeholder","* Enter valid message");
            $("#userMessage").focus();
            return false;
        }
        else{
            $("#userMessage").css("border","1px solid #ccc");
        }
    }

    function getFailureModal(){
      $("#modal-body").empty();
      $("#myModal").css("display","block");     
      $("#modal-body").addClass("modelFail");
      $("#modal-body").html("<span class='close' id='btnCloseModal'>&times;</span> Warning <i class='uil uil-exclamation-triangle'></i> <br> Email not registered with us...");
      $("#btnCloseModal").click(function(){
        $("#myModal").css("display","none");
      });
    }
    function getSuccessModal(){
      $("#modal-body").empty();
      $("#myModal").css("display","block");
      $("#modal-body").addClass("modelSuccess");
      $("#modal-body").html("<span class='close' id='btnCloseModal'>&times;</span>Thankx! for contacting us <i class='uil uil-smile' style='font-size:30px;' ></i>.<br> <h6>We will really helpful with your suggetion or if you have and issue than we will reach you back soon..</h6>");
      $("#btnCloseModal").click(function(){
        $("#myModal").css("display","none");
      });
    }

    //sending user message....
    function sendMessage(){
        var userName=$("#txtUserName").val();
        var phone=$("#txtUserMobileNo").val();
        var userEmail=$("#txtUserEmail").val();
        var desc=$("#userMessage").val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var flag="contactUs";
        if(userName.trim()==""){
            $("#txtUserName").css("border", "1px solid #ccc");

            $("#txtUserName").css("border", "1px solid red");
            $("#txtUserName").attr("placeholder", "* Enter your name");
            $("#txtUserName").focus();
            return false;
        }
        else if(userEmail.trim()==""){
            $("#txtUserName").css("border", "1px solid #ccc");

            $("#txtUserEmail").css("border", "1px solid red");
            $("#txtUserEmail").attr("placeholder", "* Enter your email id");
            $("#txtUserEmail").focus();
            return false;
        }
        else if(!(regex.test(userEmail))){
            $("#txtUserName").css("border", "1px solid #ccc");

            $("#txtUserEmail").val("");
            $("#txtUserEmail").css("border", "1px solid red");
            $("#txtUserEmail").attr("placeholder", "* Enter valid email id");
            $("#txtUserEmail").focus();
            return false;
        }

        else if(phone.trim()==""){
            $("#txtUserEmail").css("border", "1px solid #ccc");

            $("#txtUserMobileNo").css("border", "1px solid red");
            $("#txtUserMobileNo").attr("placeholder", "* Enter your phone no");
            $("#txtUserMobileNo").focus();
            return false;
        }

        else if(phone.length<10){
            $("#txtUserEmail").css("border", "1px solid #ccc");

            $("#txtUserMobileNo").val("");
            $("#txtUserMobileNo").css("border", "1px solid red");
            $("#txtUserMobileNo").attr("placeholder", "* Enter valid phone no");
            $("#txtUserMobileNo").focus();
            return false;
        }

        else if(desc.trim()==""){
            $("#txtUserMobileNo").css("border", "1px solid #ccc");

            $("#userMessage").css("border", "1px solid red");
            $("#userMessage").attr("placeholder", "* Enter your message");
            $("#userMessage").focus();
            return false;
        }
        else{
            $("#container").removeAttr('style');        //displaying the loading circles..
            $("#btnSendEmail").attr("disabled","disabled");
            $.ajax({
                  url:"callServiceRegLogin.php",
                  method:"POST",
                  data:{action:flag,email:userEmail},
                  success:function(data){
                    if(data==1){
                        getSuccessModal();
                        $("#txtUserName").val("");
                        $("#txtUserEmail").val("");
                        $("#txtUserMobileNo").val("");
                        $("#userMessage").val("");
                    }
                    else if(data==0){
                        getFailureModal();
                        $("#txtUserEmail").val("");

                    }
                    else{
                      alert('oops! something went wrong');
                    }
                    }
                  });
                  $("#container").attr('style', 'display:none');      //removing the loading circles..
                  $("#btnSendEmail").removeAttr("disabled","disabled");
        }
    }

</script>
</html>