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
	<noscript><meta http-equiv="refresh" content="0; URL=error.php?np=noscript"></noscript>	<!--modified by mehul 15-05-19-->
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

        <!-- The Terms and conditions Modal starts -->
<div id="modalTermsConditions" class="modal">
<!-- Modal content -->
<div class="modal-content">
<div class="modal-header">
      <span class="close">&times;</span>
      <h5>Terms and conditions</h5>
    </div>
  <div class="modal-body">
    <p>All the information on this website - www.E_Powernotes.com - is published in good faith and for general information purpose only. w3highschools does not make any warranties about the completeness,
 reliability and accuracy of this information. Any action you take upon the information you find on this website , is strictly at your own risk. w3highschools will not be liable for any
  losses and/or damages in connection with the use of our website. Any unethical activity found or encountered by any user will let themselves to be blocked from using this wesite</p>
    
  <p>From our website, you can visit other websites by following hyperlinks to such external sites. While we strive to provide only quality links to useful and ethical websites,
       we have no control over the content and nature of these sites. These links to other websites do not imply a recommendation for all the content found on these sites. Site 
       owners and content may change without notice and may occur before we have the opportunity to remove a link which may have gone 'bad'.</p>

       <p>Please be also aware that when you leave our website, other sites may have different privacy policies and terms which are beyond our control. Please be sure to check the Privacy Policies of these sites as well as their "Terms of Service" before engaging in any business or uploading any information.</p>
       <p>If you require any more information or have any questions about our site's disclaimer, please feel free to contact us by email at <a href="#">info@w3highschools.com</a> </p>
       <h5>THANK YOU</h5>
  </div>
</div>
</div>
        <!-- The Terms and conditions Ends-->


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
            <a href="contact-us.php"><i class='uil uil-phone'></i> <p>Contact</p> </a>
            <a href="about-us.html"><i class='uil uil-book-open'></i> <p>About</p> </a>
        </div>
    </div>

    <div class="col-sm-9 content">
        <!--------user register form starts---------->
        <div class="register-form form-horizontal">
            <h2 class="headingCenter">Registration </h2>
            <hr class="upload-hr">
                <h5>If you haven't registered yet register now, its free and always will be </h5>
                <br>
                <div class="row">

                    <div class="form-group col-sm-4">
                        <div class="userEmail">
                            <i class='uil uil-user userIcon'></i>
                            <input type="text" class="form-control" placeholder="User name" id="txtUserName" onblur="checktextfield()" onkeypress="return onlyAlphabets(event,this);" >
                        </div>
                    </div>

                    <div class="form-group col-sm-4">
                        <div class="userEmail">
                            <i class='uil uil-envelope userIcon'></i>
                            <input type="text" class="form-control" placeholder="Email" id="txtUserEmail">
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="form-group col-sm-4">
                        <div class="userEmail">
                            <i class='uil uil-lock userIcon'></i>
                            <input type="password" class="form-control" placeholder="Password" id="txtUserPassword">
                        </div>
                    </div>
                
                    <div class="form-group col-sm-4"> 
                        <div class="userEmail">
                            <i class='uil uil-building userIcon'></i>
                            <select class="form-control" id="ddlUserUniBoard" onchange="getcollege()">
                                <option value="0" selected>==select university==</option>
                            </select>
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="form-group col-sm-4">
                        <div class="userEmail">
                            <i class='uil uil-graduation-hat userIcon'></i>
                            <select class="form-control" id="ddlUserCollege">     
                                <option value="0" selected>==select college==</option>
                                <option value="0">Please select University/Board</option>                
                            </select>                        
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-sm-12 termsCondition">
                        <input type="checkbox" id="chkBoxTermsCondi" > <h5 id="headingTermsCon" > I agreed to <a href="#" id="myBtn">terms and conditions </a></h5>
                    </div>  
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <input type="submit" class="btn bnt-default" id="btnRegister" value="Register" onclick="registerUser()">
                    </div>  
                </div> 
                   
                <br>       
        </div>
        <!--------user register form ends---------->

    </div>   
</body>

<script src="js/registration.js"></script>
<script>
    //validating the user name on key press allowing only alphabets and spaces..
    function onlyAlphabets(e, t) {          //modified by mehul sharma
            try {                           // date 14-05-2019
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode > 47 && charCode < 58) || charCode == 32 || charCode == 47 || charCode == 45)
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
    }

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

    function getFailureModal(){
      $("#modal-body").empty();
      $("#myModal").css("display","block");     
      $("#modal-body").addClass("modelFail");
      $("#modal-body").html("<span class='close' id='btnCloseModal'>&times;</span> Warning <i class='uil uil-exclamation-triangle'></i> <br> Email Already Present...");
      $("#btnCloseModal").click(function(){
        $("#myModal").css("display","none");
      });
    }
    function getSuccessModal(){
      $("#modal-body").empty();
      $("#myModal").css("display","block");
      $("#modal-body").addClass("modelSuccess");
      $("#modal-body").html("<span class='close' id='btnCloseModal'>&times;</span>Registered Successfully <i class='uil uil-smile' style='font-size:30px;' ></i>.<br> <h6>Note: Activation link has been sent to your account Please click it to activate your Account..</h6>");
      $("#btnCloseModal").click(function(){
        $("#myModal").css("display","none");
      });
    }

</script>

<script>

$(document).ready(function(){
    $("#container").attr('style', 'display:none');      //removing the loading circle..
    var flag="ddlUniv";
        $.ajax({
            url:"callServiceRegLogin.php",
            method:"POST",
            data:{action:flag,id:0},
            dataType:"json",
            success:function(data){
                if(data=='error'){
                    window.location.replace("error.html");
                }
                else{
                    $("#ddlUserUniBoard").empty();
                    $("#ddlUserUniBoard").append("<option value='0'>==select university==</option>");
                    $.each(data,function(i,item){
                    $('#ddlUserUniBoard').append('<option value="'+data[i].unId+'">'+ data[i].unName +'</option>'); 
                });
                }
            }
        });
        
    }); 

    function getcollege(){
        $("#container").removeAttr('style');   //displaying the loading circles.. 
        var flag="college";
        var universityId=document.getElementById("ddlUserUniBoard").value;
        if(universityId==0){
            $("#container").attr('style', 'display:none');      //removing the loading circle..
            return false;
        }
        else{
            $.ajax({
            url:"callServiceRegLogin.php",
            method:"POST",
            data:{action:flag,id:universityId},
            dataType:"json",
            success:function(data){
                $("#ddlUserCollege").empty();
                $("#ddlUserCollege").append("<option value='0'>==select==</option>");
                $.each(data,function(i,item){
                    $('#ddlUserCollege').append('<option value="'+data[i].colId+'">'+ data[i].colName +'</option>'); 
                });
                $("#container").attr('style', 'display:none');      //removing the loading circle..
            }
        });
        }
    }

//user registration..
    function registerUser(){
        var userName=$("#txtUserName").val();
        var userEmail=$("#txtUserEmail").val();
        var userPassword=$("#txtUserPassword").val();
        var chkboxChecked=document.getElementById("chkBoxTermsCondi").checked
        var userUniversity=document.getElementById("ddlUserUniBoard").value;
        var userCollege=document.getElementById("ddlUserCollege").value;
        var btnText="registerUser";
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        
        if(userName.trim()==""){
            $("#txtUserName").css("border","1px solid red");
            $("#txtUserName").attr("placeholder","* Enter name");
            $("#txtUseName").focus();
        }
        else if(userEmail.trim()=="" || !regex.test(userEmail)){
            $("#txtUserName").css("border","1px solid #ccc");

            $("#txtUserEmail").css("border","1px solid red");
            $("#txtUserEmail").attr("placeholder","* Enter email");
            $("#txtUserEmail").focus();
        }
        else if(userPassword.trim()==""){
            $("#txtUserEmail").css("border","1px solid #ccc");

            $("#txtUserPassword").css("border","1px solid red");
            $("#txtUserPassword").attr("placeholder","* Enter Password");
            $("#txtUserPassword").focus();
        }
        
        else if(userUniversity.trim()=="" || userUniversity.trim()==0){
            $("#ddlUserUniBoard").css("border","1px solid red");
            $("#ddlUserUniBoard").focus();
        }
        else if( userCollege==0){
                $("#ddlUserUniBoard").css("border","1px solid #ccc");

                $("#ddlUserCollege").css("border","1px solid red");
                $("#ddlUserCollege").focus();            
        }

         else if(userPassword.length<6){         //checking the  minimum length of password..
            $("#txtUserPassword").val("");
            $("#txtUserPassword").css("border","1px solid red");
            $("#txtUserPassword").attr("placeholder","* password too short (min 6 )");
            $("#txtUserPassword").focus();
            return false;
        }

        else if(!chkboxChecked){
            alert('Please accept terms and conditions');
            return false;
        }

        else{
            $("#container").removeAttr('style');        //displaying the loading circles..
            $("#btnRegister").attr("disabled","disabled");
            $.ajax({
            url:"callServiceRegLogin.php",
            method:"POST",
            data:{action:btnText,name:userName,email:userEmail,password:userPassword,university:userUniversity,college:userCollege},
            success:function(data){
                if(data==1){
                    getFailureModal();
                    
                    $("#btnRegister").removeAttr("disabled","disabled");
                    $("#txtUserEmail").val("");
                    $("#txtUserEmail").css("border","1px solid red");
                    $("#txtUserEmail").attr("placeholder","* Email Already Present");
                    
                    $("#txtUserEmail").focus();
                    $("#container").attr('style', 'display:none');      //removing the loading circles..
                    
                }
                else if(data==3){
                    alert('enter valid data');
                    $("#btnRegister").removeAttr("disabled","disabled");
                    $("#container").attr('style', 'display:none');      //removing the loading circles..
                }
                else{
                    getSuccessModal();
                    $("#txtUserName").val("");
                    $("#txtUserEmail").val("");
                    $("#txtUserPassword").val("");
                    $("#ddlUserUniBoard").get(0).selectedIndex = 0;
                    $("#ddlUserCollege").get(0).selectedIndex = 0;
                    $("#btnRegister").removeAttr("disabled","disabled");
                    $("#container").attr('style', 'display:none');      //removing the loading circles..
                }
            }
            });
        }          
    }


</script>
</html>