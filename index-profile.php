<?php 
    include("index.incOther.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="css/style-index-profile.css" rel="stylesheet">
    <link href="css/loader.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
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
<form method="POST" enctype="multipart/form-data" id="userUpdateForm" onsubmit="return(this)">
    <div id="main" class="container-fluid">
        <h4>Personal Informations</h4>
        <div class="row">
            <div class="col-sm-4 imgBox">
                <img id="imgUser" class="img img-circle img-fluid" name="imgUser">
            </div>
            <div class="col-sm-8 btnBox">
                <input type="file" class="btn btn-default" id="fileImage" name="file" onchange="getSizeExten(this)"><br>
            </div>
        </div>
        <br>
        <div class="form-horizontal">
        <!--------first row of form starts---------->
        <div class="row">
            <div class="col-sm-4">
                <div class="form group">

                    <div class="userEmail">
                        <i class='uil uil-user userIcon'></i>
                        <input type="text" class="form-control" placeholder="Name" id="txtUserName" name="txtUserName" onkeypress="return onlyAlphabets(event,this);">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form group">
                    <div class="userEmail">
                        <i class='uil uil-building userIcon'></i>
                        <select class="form-control" id="ddlUserUniversity" onchange="getcollege()" name="ddlUserUniversity">
                            
                        </select>
                    </div>
                </div>
            </div>            

            <div class="col-sm-4">
                <div class="form group">
                    <div class="userEmail">
                        <i class='uil uil-shop userIcon'></i>
                        <select class="form-control" id="ddlUserCollege" onchange="getdegree()" name="ddlUserCollege">
                            <option value="0" selected>==select college==</option>
                            
                        </select>
                    </div>
                </div>
            </div>
        </div>        
        <!--------first row of form ends--------->

        <!--------second row of form starts---------->
        <div class="row">
            <div class="col-sm-4">
                <div class="form group">

                    <div class="userEmail">
                        <i class='uil uil-books userIcon'></i>
                        <select class="form-control" id="ddlUserDegree" onchange="getsemester()" name="ddlUserDegree">
                            <option value="0" selected>==select degree==</option>
                        </select>
                    </div>
                </div>
            </div>
            

            <div class="col-sm-4">
                <div class="form group">
                    <div class="userEmail">
                        <i class='uil uil-graduation-hat userIcon'></i>
                        <select class="form-control" id="ddlUserSemester" name="ddlUserSemester">
                            <option value="0" selected>==select semester==</option>
                            <option value="0">Please select degree</option>
                        </select>
                    </div>
                </div>                
            </div>

            <div class="col-sm-4">
                <div class="form group">
                    <div class="userEmail">
                        <i class='uil uil-envelope-alt userIcon'></i>
                        <input type="text" class="form-control" disabled id="txtUserEmail" value="<?php echo $_SESSION["email"]; ?>" name="txtUserEmail">
                    </div>

                </div>
            </div>
        </div>
        <!--------second row of form ends---------->

        <!--------third row of form starts---------->
             
            <div class="row">
            <div class="col-sm-4">
                <div class="form group">

                    <div class="userEmail">
                        <i class='uil uil-phone userIcon userIcon'></i>
                        <input type="text" class="form-control" placeholder="Mobile No" id="txtUserMobileNo" name="txtUserMobileNo">
                    </div>
                </div>                
            </div>            
            <div class="col-sm-4">
                <input type="hidden" name="userImageSrc" id="userImageSrc"> <!----this field send the previous image link so that it will ot become null----->
            </div>
            <div class="col-sm-4"></div>
            </div>
        <!--------third row of form starts---------->

        <!--------fourth row of button starts--------->
        <div class="row">
            <div class="col-sm-6 btnBox">
                <input type="submit" class="btn btn-default" id="btnSaveUserData" value="Save">
                
            </div>

            <div class="col-sm-6 btnBox">
                <input type="button" class="btn btn-default" id="btnChangePassword" data-toggle="modal" data-target="#myModal" value="Change Password">
            </div>
        </div>
        <!--------fourth row of button ends---------->
        </div>
    </div>
    </form>

    <!--=========
        password change popup starts..
    ==========-->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
    
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Password change</h4>
                </div>

                <div class="modal-body passwordChangeRow">
                    
                <!--== show message here starts ==-->
                <div id="changesPassMessage">
                    
                </div>
                <!--== show message here ends ==-->


                    <div class="row">
                        <input type="password" class="form-control" placeholder="Old Password" id="txtOldPassword">
                    </div>
                    
                    <div class="row">
                        <input type="password" class="form-control" placeholder="New Password" id="txtNewPassword">
                    </div>
                    
                    <div class="row">
                        <input type="password" class="form-control" placeholder="Confirm Password" id="txtConfirmPassword">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="Submit" class="btn btn-default" id="btnChangePass">Change</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
      
        </div>
    </div>

    <!--=========
        password change popup ends..
    ==========-->

    <script>

        //change password here..
        $("#btnChangePass").on('click',function(event){
            event.preventDefault();
            var oldPass=$("#txtOldPassword").val();
            var newPass=$("#txtNewPassword").val();
            var conNewPass=$("#txtConfirmPassword").val();
            if(oldPass.trim()==""){
                $("#txtNewPassword").css("border","1px solid #ccc");
                $("#txtConfirmPassword").css("border","1px solid #ccc");

                $("#txtOldPassword").css("border","1px solid red");
                $("#txtOldPassword").attr("placeholder","* Enter your old password");
                $("#txtOldPassword").focus();
            }
            else if(newPass.trim()==""){
                $("#txtOldPassword").css("border","1px solid #ccc");
                $("#txtConfirmPassword").css("border","1px solid #ccc");

                $("#txtNewPassword").css("border","1px solid red");
                $("#txtNewPassword").attr("placeholder","* Enter your new password");
                $("#txtNewPassword").focus();
            }
            else if(newPass.length<6){
                $("#txtOldPassword").css("border","1px solid #ccc");
                $("#txtConfirmPassword").css("border","1px solid #ccc");

                $("#txtNewPassword").val("");
                $("#txtNewPassword").css("border","1px solid red");
                $("#txtNewPassword").attr("placeholder","* Password too small [min 6 characters]");
                $("#txtNewPassword").focus();
            }
            else if(conNewPass.trim()==""){
                $("#txtNewPassword").css("border","1px solid #ccc");
                $("#txtOldPassword").css("border","1px solid #ccc");

                $("#txtConfirmPassword").css("border","1px solid red");
                $("#txtConfirmPassword").attr("placeholder","* Confirm your password");
                $("#txtConfirmPassword").focus();
            }
            else if(newPass.trim()!=conNewPass.trim()){
                $("#txtOldPassword").css("border","1px solid #ccc");


                $("#txtNewPassword").val("");
                $("#txtConfirmPassword").val("");
                $("#txtNewPassword").css("border","1px solid red");
                $("#txtNewPassword").attr("placeholder","* Enter similar password");
                $("#txtNewPassword").focus();
                $("#txtConfirmPassword").css("border","1px solid red");
                $("#txtConfirmPassword").attr("placeholder","* Enter similar password");
            }
            else{
                var newPass=$("#txtNewPassword").val();
                var oldPass=$("#txtOldPassword").val();
                var flag="changePass";
                $.ajax({
                    url:"callServiceRegLogin.php",
                    method:"POST",
                    dataType:"json",
                    data:{action:flag,oldPassword:oldPass,newPassword:newPass},
                    success:function(data){
                        if(data=="1"){
                            $('#changesPassMessage').html('');
                            $("#changesPassMessage").addClass('alert alert-success');
                            $('#changesPassMessage').html('<strong>Password</strong> changed successfully');

                            /*empty all fields */
                            $("#txtNewPassword").val("");
                            $("#txtOldPassword").val("");
                            $("#txtConfirmPassword").val("");
                        }
                        else if(data=="0"){
                            $('#changesPassMessage').html('');
                            $("#changesPassMessage").addClass('alert alert-warning');
                            $('#changesPassMessage').html('<strong>Old Password</strong> not matching');

                            /*empty all fields */
                            $("#txtNewPassword").val("");
                            $("#txtOldPassword").val("");
                            $("#txtConfirmPassword").val("");
                        }
                        else{
                            alert('something went wrong try again later');
                        }
                    }
                });
            }
        });

        $("#btnChangePassword").on('click',function(event){
            //event.preventDefault();
        });

    function onlyAlphabets(e, t) {      //validatiing name fiels so that user can only insert alphabets and spaces..
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 32)
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

        var collegeId="";           /* --------declaring variable to use in  whole script-------- */
        var univiId="";
        var degreeId="";
        var semesterId="";
        $(document).ready(function(){       
            
            $("#userProfile").addClass("activeSideBarLink");     // adding active class so that the like of the page in which the user
            $("#userMyUploads").removeClass("activeSideBarLink");     //  is currently will   
            $("#userFavourites").removeClass("activeSideBarLink");     // highlited,
            $("#userUpload").removeClass("activeSideBarLink");     //  and unhighliting the other links..
           $("#container").attr('style', 'display:none');      //removing the loading circles..
            var userEmail=$("#txtUserEmail").val();
            var userdata="getUserData";
            $.ajax({
                url:"callServiceUploadNotesDatabind.php",
                method:"POST",
                data:{action:userdata,email:userEmail},
                dataType:"json",
                success:function(data){
                    
                    $("#txtUserName").val(data.userName);
                    $("#txtUserMobileNo").val(data.userMobile);
                    $("#imgUser").attr('src',data.userImage);
                    $("#userImageSrc").val(data.userImage); //this value will set in hidden field to send to database if user doesnot select any image..
                    univiId=data.userUni;                   //the variable is use to compare the university of user and 
                    collegeId=data.userColl;                 //assign the selected attribute to the matching value..
                    degreeId=data.userDeg;
                    semesterId=data.userSem;

                    getUniOnLoad();
                    getcollegeOnLoad(univiId);
                    getDegreeOnLoad(collegeId);
                    getSemOnLoad(degreeId);
                }
                
            });

    function getUniOnLoad(){
        //$("#container").removeAttr('style');   //displaying the loading circles..
        var flagUni='uni';
            $.ajax({
            url:"callServiceUploadNotesDatabind.php",
            method:"POST",
            data:{action:flagUni,id:0},
            dataType:"json",
            success:function(data){
                $("#ddlUserUniversity").empty();
                $("#ddlUserUniversity").append("<option value='0'>==select university==</option>");
                $.each(data,function(i,item){
                    $('#ddlUserUniversity').append('<option value="'+data[i].uniId+'">'+ data[i].uniName +'</option>');
                    var select = document.getElementById("ddlUserUniversity");
                    for (var i = 0; i < select.length; i++){ //iterating through each value of ddl and checking the matching value...
                    var option = select.options[i].value;
                    if(option==univiId){
                        var option = $('#ddlUserUniversity').children('option[value="'+ option +'"]'); 
                        option.attr('selected', true);
                        }
                    }
                });
                
            }
        });
    }
                

    function getcollegeOnLoad(univiId){     //this function bind the colleges and the selected college of user on page load..
            var flag="college";
            var universityId=univiId;
            $.ajax({
            url:"callServiceUploadNotesDatabind.php",
            method:"POST",
            data:{action:flag,id:universityId},
            dataType:"json",
            success:function(data){
                $("#ddlUserCollege").empty();
                $("#ddlUserCollege").append("<option value='0'>==select college==</option>");
                $.each(data,function(i,item){
                    $('#ddlUserCollege').append('<option value="'+data[i].colId+'">'+ data[i].colName +'</option>'); 
                var select = document.getElementById("ddlUserCollege");
                    for (var i = 0; i < select.length; i++){  //iterating through each value of ddl and checking the matching value...
                    var option = select.options[i].value;
                    if(option==collegeId){
                        var option = $('#ddlUserCollege').children('option[value="'+ option +'"]'); //in this iteration i am using the values
                        option.attr('selected', true);                                              //of ddl to match because the ddl may have
                        }                                                             //any part of data from table..
                    }
                });                
            }
        });
    }

    function getDegreeOnLoad(collegeId){  //this function bind the degree and the selected degree of user on page load..
            var flag="degree";
            var collId=collegeId;
            $.ajax({
                url:"callServiceUploadNotesDatabind.php",
                method:"POST",
                data:{action:flag,id:collId},
                dataType:"json",
                success:function(data){
                    $("#ddlUserDegree").empty();
                    $("#ddlUserDegree").append("<option value='0'>==select degree==</option>");
                    $.each(data,function(i,item){
                        $('#ddlUserDegree').append('<option value="'+data[i].degId+'">'+ data[i].degName +'</option>');
                        var select = document.getElementById("ddlUserDegree");
                        for (var i = 0; i < select.length; i++){  //iterating through each value of ddl and checking the matching value...
                        var option = select.options[i].value;
                        if(option==degreeId){
                        var option = $('#ddlUserDegree').children('option[value="'+ option +'"]'); //doing the same thing as doing before while  
                        option.attr('selected', true);                                             //binding university..
                        }
                    }
                    });                         
                }                              
            });
        }

        function getSemOnLoad(degreeId){   //this function bind the semester and the selected semester of user on page load..
            var flagsem="semester";
            var degId=degreeId;
            $.ajax({
                url:"callServiceUploadNotesDatabind.php",
                method:"POST",
                data:{action:flagsem,id:degId},
                dataType:"json",
                success:function(data){
                    $("#ddlUserSemester").empty();
                    $("#ddlUserSemester").append("<option value='0'>==select semester==</option>");
                    $.each(data,function(i,item){
                        $('#ddlUserSemester').append('<option value="'+data[i].semId+'">'+ data[i].semName +'</option>');
                        var select = document.getElementById("ddlUserSemester");
                        for (var i = 0; i < select.length; i++){ //iterating through each value of ddl and checking the matching value...
                        var option = select.options[i].value;       
                        if(option==semesterId){ 
                        var option = $('#ddlUserSemester').children('option[value="'+ option +'"]'); //doing the same thing as doing before while
                        option.attr('selected', true);                                          //binding university..
                            }
                        }
                        //since this function is loading at very last during pageload so removing the loading
                        //screen after this after will allow the page to access after every thing 
                        //loads completely..
                        
                    });                       
                }  
            });
            
        }
 });//end of document.ready...

    function getSizeExten(file){
        
        var filename=file.files[0].name;
        var filesize=file.files[0].size;
                //var filename=$("#fileImage").val();
                if(filename){
                    var exten=filename.split('.').pop();
                    if(!(exten=='jpg'||exten=='jpeg'||exten=='png')){
                        alert('Upload only image');
                        $("#fileImage").val('');
                        return false;
                    }                  
                }
                if(filesize>3000000){
                        alert("Select image less than 2Mb");
                        return false;
                }
                  readURL(file);
    }

    function readURL(input) {                                     //This function will show the selected image
        if (input.files && input.files[0]) {                      //in the image box..  
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imgUser').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
        }   
    }

    /*=====================================================
        from here data will bind according to option selected by user in 
        previous fields..
    
    =======================================================*/
    function getcollege(){  //get the list of colleges as user select university
        $("#container").removeAttr('style');   //displaying the loading circles..
            var flag="college";
            var universityId=document.getElementById("ddlUserUniversity").value;
            if(universityId==0){
                $("#container").attr('style', 'display:none');      //removing the loading circle..
                return false;
            }
            else{
                $.ajax({
            url:"callServiceUploadNotesDatabind.php",
            method:"POST",
            data:{action:flag,id:universityId},
            dataType:"json",
            success:function(data){
                $("#ddlUserCollege").empty();
                $("#ddlUserCollege").append("<option value='0'>==select college==</option>");
                $.each(data,function(i,item){
                    $('#ddlUserCollege').append('<option value="'+data[i].colId+'">'+ data[i].colName +'</option>'); 

                });
                $("#container").attr('style', 'display:none');      //removing the loading circles..
            }
        });
            }
    }

        function getdegree(){     //get the list of degrees as user select the college..
            $("#container").removeAttr('style');   //displaying the loading circles..
            var flag="degree";
            var collegeId=document.getElementById("ddlUserCollege").value;
            if(collegeId==0){
                $("#container").attr('style', 'display:none');      //removing the loading circle..
                return false;
            }
            else{
                $.ajax({
                url:"callServiceUploadNotesDatabind.php",
                method:"POST",
                data:{action:flag,id:collegeId},
                dataType:"json",
                success:function(data){
                    $("#ddlUserDegree").empty();
                    $("#ddlUserDegree").append("<option value='0'>==select degree==</option>");
                    $.each(data,function(i,item){
                        $('#ddlUserDegree').append('<option value="'+data[i].degId+'">'+ data[i].degName +'</option>'); 
                    });
                    $("#container").attr('style', 'display:none');      //removing the loading circles..
                }
            })
            }
            
        }
        
        function getsemester(){     // as the user select degree semester starts binding according to selected degree..
            $("#container").removeAttr('style');   //displaying the loading circles..
            var flagsem="semester";
            var degreeId=document.getElementById("ddlUserDegree").value;
            if(degreeId==0){
                $("#container").attr('style', 'display:none');      //removing the loading circle..
                return false;
            }
            else{
                $.ajax({
                url:"callServiceUploadNotesDatabind.php",
                method:"POST",
                data:{action:flagsem,id:degreeId},
                dataType:"json",
                success:function(data){
                    $("#ddlUserSemester").empty();
                    $("#ddlUserSemester").append("<option value='0'>==select semester==</option>");
                    $.each(data,function(i,item){
                        $('#ddlUserSemester').append('<option value="'+data[i].semId+'">'+ data[i].semName +'</option>'); 
                    });
                    $("#container").attr('style', 'display:none');      //removing the loading circles..
                }
            })
            }
        }
    //$("#btnSaveUserData").click(function(){             //this may not A/C to coding standard check it later...
        $("#userUpdateForm").on('submit',function(e){
            //validating for required fields starts...
            var name=$("#txtUserName").val();
            var uni=document.getElementById("ddlUserUniversity").value;
            var coll=document.getElementById("ddlUserCollege").value;
            var deg=document.getElementById("ddlUserDegree").value;
            var sem=document.getElementById("ddlUserSemester").value;
            var mobile=$("#txtUserMobileNo").val();

            if(name.trim()==""){
                $("#txtUserName").css("border","1px solid red");
                $("#txtUserName").attr("placeholder","Enter name");
                $("#txtUserName").focus();
                return false;
            }
            else if(uni==0){
                $("#txtUserName").css("border","1px solid #ccc");

                $("#ddlUserUniversity").css("border","1px solid red");
                $("#ddlUserUniversity").focus();
                return false;
            }
            else if(coll==0){
                $("#ddlUserUniversity").css("border","1px solid #ccc");

                $("#ddlUserCollege").css("border","1px solid red");
                $("#ddlUserCollege").focus();
                return false;
            }
            //validating for required fields ends...

            else{                
                e.preventDefault(); 
                $("#container").removeAttr('style');   //displaying the loading circles..
                var flag="updateDate";
                    $.ajax({
                    type: "POST",
                    url: "callServiceUpdateUserData.php",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data){
                           if(data==1){  
                               alert("updated successfully");
                           }
                           else if(data==3){
                               alert("Please insert your data");
                           }
                           else if(data=='error'){
                               window.location.replace('error.html');
                           }
                           else{
                               alert('updation failed');   
                           }
                           $("#container").attr('style', 'display:none');      //removing the loading circles..
                        }  
                    });
                }        
            });
    //});
        
     

    </script>

<?php 
    include('in-footer.inc.php');
?>


</body>
</html>