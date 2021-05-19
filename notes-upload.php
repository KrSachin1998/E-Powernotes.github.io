<?php 
include("index.incOther.php");
require_once "app_code/configmgr.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title></title>

    <link href="css/style-NQA-upload.css" rel="stylesheet">
    <link href="css/loader.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <link href="css/multiplefileupload.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <script src="js/multiplefileupload.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>
	.pull-right-captcha{
		float: right!important;
    left: 70px;
	}
	</style>
</head>

<body>
    <form method="POST" enctype="multipart/form-data" id="notesUploadForm" onsubmit="return(this)">
        <div id="main">
            <h3>Upload here..</h3>
            <hr class="upload-hr">
            <h5>Please Fill The Data Correctly..</h5>
            <br>
            <div class="form-horizontal">

                <!--------first row of form starts---------->
                <div class="row">
                <div class="col-sm-6 titleBox">
                    <div class="form group">
                    
                        <div class="userEmail">
                            <i class='uil uil-user userIcon'></i>
                            <input type="text" class="form-control" placeholder="Title" id="txtTitle" name="txtTitle" onblur="checktextfieldtitle()" onkeypress="return onlyAlphaHyphUnder(event,this)">
                        </div>
                        <span class="help-text">The title will be shown above</span>
                        
                    </div>
                </div>
                

                <div class="col-sm-6">
                    <div class="form group">
                        
                        <div class="userEmail">
                            <i class='uil uil-align-center-alt userIcon'></i>
                            <select class="form-control" id="ddlCategory" name="ddlCategory" onchange="emptydegree()">
                                <option value='0'>==select category==</option>
                            </select>
                        </div>
                            <span class="help-text">* Mandatory field</span>
                    </div>
                </div>
                </div>

                <!--------first row of form ends--------->

                <!--------second row of form starts--------->
                <div class="row">
                <div class="col-sm-6">
                    <div class="form group">
                        <div class="userEmail">
                            <i class='uil uil-building userIcon'></i>
                            <select class="form-control" id="ddlUniversity" name="ddlUniversity" onchange="getcollege()">
                                <option value='0'>==select university==</option>
                            </select>
                        </div>
                            <span class="help-text">* Mandatory field</span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form group">
                        <div class="userEmail">
                            <i class='uil uil-shop userIcon'></i>
                            <select class="form-control" id="ddlCollege" name="ddlCollege" onchange="getdegree()">
                                <option value='0'>==select college==</option>
                            </select>
                        </div>
                            <span class="help-text">* Mandatory field</span>
                    </div>
                </div>
                </div>
                <!--------second row of form ends--------->

                <!--------third row of form starts--------->
                <div class="row">
                <div class="col-sm-6">
                    <div class="form group">
                        <div class="userEmail">
                            <i class='uil uil-graduation-hat userIcon'></i>
                            <select class="form-control" id="ddlDegree" name="ddlDegree" onchange="getsemester()">
                                <option value='0'>==select degree==</option>
                                <option value='0'>Please select college</option>
                            </select>
                        </div>
                            <span class="help-text">* Mandatory field</span>
                        
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form group">
                        <div class="userEmail">
                            <i class='uil uil-tag userIcon'></i>
                            <select class="form-control" id="ddlSemester" name="ddlSemester">
                                <option value='0'>==select semester==</option>
                                <option value='0'>Please select degree</option>
                            </select>
                        </div>
                            <span class="help-text">* Mandatory field</span>
                        
                    </div>
                </div>
                </div>
                <!--------third row of form ends--------->

                <!--------fourth row of form starts--------->
                <div class="row">
                <div class="col-sm-6">
                    <div class="form group">
                        <div class="userEmail">
                            <i class='uil uil-books userIcon'></i>
                            <select class="form-control" id="ddlNotesSubject" name="ddlNotesSubject">
                                <option value='0'>==select subject==</option>
                                <option value='0'>Please select Category, university and degree</option>
                            </select>
                        </div>
                            <span class="help-text">* Mandatory field</span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form group">
                        <div class="userEmail">
                            <i class='uil uil-file userIcon'></i>
                            <select class="form-control" id="ddlNotesType" name="ddlNotesType">
                                <option value='0'>==select notes type==</option>
                            </select>
                        </div>
                            <span class="help-text">* Mandatory field</span>
                    </div>
                </div>
                </div>
                <!--------fourth row of form ends--------->

                <!--------fifth row of form starts--------->
                <div class="row">
                <div class="col-sm-12">
                    <div class="form group">
                        <div class="userEmail">
                            <i class='uil uil-comment-message userIcon'></i>
                            <textarea row="4" col="50" placeholder="Description" class="form-control" id="description" onblur="checktextfieldDesc()" onkeypress="return onlyAlphaHyphUnder(event,this);" name="description">
                            </textarea>
                        </div>
                        <span class="help-text">* Mandatory field</span>
                    </div>
                </div>
                </div>
                <!--------fifth row of form ends--------->
        <hr class="hr-divide">
                <!--------sixth row of form starts --------->

                <div class="row">
                    <div class="col-sm-6 ">
                        <label class="btn-bs-file btn btn-md">
                        <i class='uil uil-paperclip'></i> Choose File
                            <input type="file" id="uploadNotes" onchange="getfileExtension();" name="file[]" multiple>
                        </label>
                        <br>
                        <span class="help-text">
                       * Allowed file extensions are jpg, jpeg, png, pdf, doc, docx
                    </span>
                    <br>
                    <span class="help-text">
                       * Maximum image size 20 mb and pdf,docx,doc size 5 mb
                    </span>
                        <br />
                        <ul id="fileList">
                        </ul>
                    </div>
                    <!--<div class="col-sm-6 pull-right-captcha">
                        <div class="g-recaptcha" data-sitekey="<?php $configmgr= new configmgr();$captchKey= $configmgr->captchKey();echo $captchKey;$configmgr=null;?>">
                    </div>-->
                </div>
                   

                    <!--------using this hidden field to make directory name---------->
                    <input type="hidden" name="hiddenDirecName" id="hiddenDirecName">
                    <input type="hidden" name="hiddenUserEmail" id="txtUserEmail"
                        value="<?php echo $_SESSION["email"]; ?>">
                </div>
                <div class="col-sm-6 btnBox">
                    <input type="submit" class="btn btn-default" value="Upload" id="btnUpload">
                </div> 
                <div class="col-sm-6 btnBox">
                    
                </div>


            </div>
        </div>
    </form>

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

    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content" id="modal-body">
            
        </div>
    </div>
    <!-- The Modal Ends-->
    <!-- code added by vivek kr sahu on 06-05-2019-->
	
    <script>

    function getfileExtension() {       //checking the extension of the selected file on onchange event..
        var totalFileSize=0;
        var imageTotalSize=0;
         for(var i=0;i< $("#uploadNotes").get(0).files.length;i++){
              var filename=$("#uploadNotes").get(0).files[i].name;
              var exten=filename.split('.').pop();

              if(exten=='jpeg' || exten=='jpg' || exten=="png"){
                imageTotalSize=imageTotalSize+$("#uploadNotes").get(0).files[i].size;
              }
              else if(exten=='pdf' || exten=='docx' || exten=='doc'){
                totalFileSize=totalFileSize+$("#uploadNotes").get(0).files[i].size;
              }

              if(filename){
                  
                  if(!(exten=='jpg'||exten=='jpeg'||exten=='png'||exten=='pdf'||exten=='doc'||exten=='docx')){
                      alert('Upload only (jpg , jpeg , png , pdf , doc , docx) files');
                      $("#uploadNotes").val('');
                      return false; 
                  }

                  else if(totalFileSize>5000000){
                    alert('You can upload pdf,docx,doc files upto 5mb at once');
                    return false;
                  }

                  else if(imageTotalSize>20000000){
                    alert('You can upload images upto 20mb at once');
                    return false;
                  }                  
              }
          }
        var getVar = new getVariable('fileList', 'uploadNotes');
        getVar.getEventFire();
    }

    function getFailureModal(msg) {
        $("#myModal").css("display", "block");
        $("#modal-body").addClass("modalFail");
        $("#modal-body").html(
            "<span class='close' id='btnCloseModal'>&times;</span> Warning <span class='fa fa-exclamation-triangle'></span> <br>"+msg
        );
        $("#btnCloseModal").click(function() {
            $("#myModal").css("display", "none");
        });
    }

    function getSuccessModal() {
        $("#myModal").css("display", "block");
        $("#modal-body").addClass("modalSuccess");
        $("#modal-body").html(
            "<span class='close' id='btnCloseModal'>&times;</span>File Uploaded Successfully.. <span class='fa fa-smile-o'style='font-size:30px;'></span>.<br> <h6>Note: Thanku for sharing your knowledge with others..</h6>"
        );
        $("#btnCloseModal").click(function() {
            $("#myModal").css("display", "none");
        });
    }

    /*
     when user change the category, degree field also become
     empty so that we can trigger subject binding again
     */
    function emptydegree() {
        $("#ddlDegree").get(0).selectedIndex = 0;
        $("#ddlNotesSubject").get(0).selectedIndex = 0;
    }

    //validating the title on key press allowing only alphabets, spaces,dash and underscores..

    function checktextfieldtitle(){  //checking the textfiled onblur..  //modified by Kumar Sachin
        var value=$("#txtTitle").val();                                 // date 14-03-2021
        //var regex=/^\w+([\s-_.]\w+)*$/;
        var regexNew=/^[\sa-zA-Z0-9-_.+]+$/;    
        if(!(regexNew.test(value))){
            $("#txtTitle").css("border","1px solid red");
            $("#txtTitle").val("");
            $("#txtTitle").attr("placeholder","* Enter valid data");
            $("#txtTitle").focus();
            return false;
        }
        else{
            $("#txtTitle").css("border","1px solid #ccc");
        }
    }

    function checktextfieldDesc(){                                //modified by Kumar Sachin
        var value=$("#description").val();                        // date 14-03-2021
        var regex=/^\w+([\s-_.]\w+)*$/;
        var regexNew=/^[\sa-zA-Z0-9-_.+]+$/;
        if(!(regexNew.test(value))){
            $("#description").css("border","1px solid red");
            $("#description").val("");
            $("#description").attr("placeholder","* Enter valid data");
            $("#description").focus();
            return false;
        }
        else{
            $("#description").css("border","1px solid #ccc");
        }
    }


    function onlyAlphaHyphUnder(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode > 47 && charCode < 58) || charCode == 32 || charCode==45 ||charCode==46 ||charCode==95 )
                    return true;
                else
                    return false;
            }
            catch (err) {
                alert(err.Description);
            }
    }

    //code for binding data in upload notes fields..
    $(document).ready(function() { // on page load we bind category and university..

        $("#userProfile").removeClass("activeSideBarLink");     // adding active class so that the like of the page in which the user
        $("#userMyUploads").removeClass("activeSideBarLink");     //  is currently will   
        $("#userFavourites").removeClass("activeSideBarLink");     // highlited,
        $("#userUpload").addClass("activeSideBarLink");     //  and unhighliting the other links..


        $("#container").attr('style', 'display:none');  //removing the loading screen when screen loads completely..
        $("#description").val('');
        var flag = 'categ';
        var flagUni = 'uni';
        var flagNotesType = 'notestype';
        var getUserCollegeId = ""; /* --------declaring variable to use in  whole script-------- */
        var getUserUniviId = "";
        var getUserDegreeId = "";
        var getUserSemesterId = "";

        var userdata = "getUserData";
        var userEmail = $("#txtUserEmail").val();
        $.ajax({
            url: "callServiceUploadNotesDatabind.php",
            method: "POST",
            data: {
                action: userdata,
                email: userEmail
            },
            dataType: "json",
            success: function(data) {
                univiId = data.userUni; //the variable is use to compare the university of user and 
                collegeId = data.userColl; //assign the selected attribute to the matching value..
                degreeId = data.userDeg;
                semesterId = data.userSem;

                getUniOnLoad();
            }
        });

        function getUniOnLoad() {
            var flagUni = 'uniForUpl';
            $.ajax({
                url: "callServiceUploadNotesDatabind.php",
                method: "POST",
                data: {
                    action: flagUni,
                    id: 0
                },
                dataType: "json",
                success: function(data) {
                    $("#ddlUniversity").empty();
                    $("#ddlUniversity").append("<option value='0'>==select university==</option>");
                    $.each(data, function(i, item) {
                        $('#ddlUniversity').append('<option value="' + data[i].uniId +
                            '">' + data[i].uniName + '</option>');
                        var select = document.getElementById("ddlUniversity");
                        for (var i = 0; i < select
                            .length; i++
                        ) { //iterating through each value of ddl and checking the matching value...
                            var option = select.options[i].value;
                            if (option == univiId) {
                                var option = $('#ddlUniversity').children('option[value="' +
                                    option + '"]');
                                option.attr('selected', true);
                            }
                        }
                        getcollege(); //this function will bind the college A/C to the university which has been selected by the user previously..
                    });
                }
            });
        }

        $.ajax({
            url: "callServiceUploadNotesDatabind.php",
            method: "POST",
            data: {
                action: flag,
                id: 0
            },
            dataType: "json",
            success: function(data) {
                $("#ddlCategory").empty();
                $("#ddlCategory").append("<option value='0'>==select category==</option>");
                $.each(data, function(i, item) {
                    $('#ddlCategory').append('<option value="' + data[i].categId + '">' +
                        data[i].categName + '</option>');
                });
            }
        });

        $.ajax({
            url: "callServiceUploadNotesDatabind.php",
            method: "POST",
            data: {
                action: flagUni,
                id: 0
            },
            dataType: "json",
            success: function(data) {
                $("#ddlUniversity").empty();
                $("#ddlUniversity").append("<option value='0'>==select university==</option>");
                $.each(data, function(i, item) {
                    $('#ddlUniversity').append('<option value="' + data[i].uniId + '">' +
                        data[i].uniName + '</option>');
                });
            }
        });

        $.ajax({
            url: "callServiceUploadNotesDatabind.php",
            method: "POST",
            data: {
                action: flagNotesType,
                id: 0
            },
            dataType: "json",
            success: function(data) {
                $("#ddlNotesType").empty();
                $("#ddlNotesType").append("<option value='0'>==select notes type==</option>");
                $.each(data, function(i, item) {
                    $('#ddlNotesType').append('<option value="' + data[i].notesTypeId +
                        '">' + data[i].notesTypeName + '</option>');
                });
            }
        });
    });

    function getcollege() { //get the list of colleges as user select university
        $("#container").removeAttr('style');   //displaying the loading circles..
        var flag = "getcollForUpl";
        var universityId = document.getElementById("ddlUniversity").value;
        if(universityId==0){        //checking if user select the select option only..
            $("#container").attr('style', 'display:none');      //removing the loading circles..
            return false;
        }
        else{
            $.ajax({
            url: "callServiceUploadNotesDatabind.php",
            method: "POST",
            data: {
                action: flag,
                id: universityId
            },
            dataType: "json",
            success: function(data) {
                $("#ddlCollege").empty();
                $("#ddlCollege").append("<option value='0'>==select college==</option>");
                $.each(data, function(i, item) {
                    $('#ddlCollege').append('<option value="' + data[i].colId + '">' + data[i]
                        .colName + '</option>');
                });

                $("#container").attr('style', 'display:none');      //removing the loading circles..
            }
        });
        }
    }

    function getdegree() { //get the list of degrees as user select the college..
        $("#container").removeAttr('style');   //displaying the loading circles..
        var flag = "getdegreeForUpl";
        var collegeId = document.getElementById("ddlCollege").value;
        if(collegeId==0){           //checking if user select the select option only..
            $("#container").attr('style', 'display:none');      //removing the loading circles..
            return false;
        }
        else{
            $.ajax({
            url: "callServiceUploadNotesDatabind.php",
            method: "POST",
            data: {
                action: flag,
                id: collegeId
            },
            dataType: "json",
            success: function(data) {
                $("#ddlDegree").empty();
                $("#ddlDegree").append("<option value='0'>==select degree==</option>");
                $.each(data, function(i, item) {
                    $('#ddlDegree').append('<option value="' + data[i].degId + '">' + data[i]
                        .degName + '</option>');
                });
                $("#container").attr('style', 'display:none');      //removing the loading circles..
            }
        })
        }
    }

    function getsemester() { // as the user select degree semester starts binding according to selected degree..
        $("#container").removeAttr('style');   //displaying the loading circles..
        var flagsem = "getsemesterForUpl";
        var degreeId = document.getElementById("ddlDegree").value;
        if(degreeId==0){        //checking if user select the select option only..
            $("#container").attr('style', 'display:none');      //removing the loading circles..
            return false;
        }
        else{
            $.ajax({
            url: "callServiceUploadNotesDatabind.php",
            method: "POST",
            data: {
                action: flagsem,
                id: degreeId
            },
            dataType: "json",
            success: function(data) {
                $("#ddlSemester").empty();
                $("#ddlSemester").append("<option value='0'>==select semester==</option>");
                $.each(data, function(i, item) {
                    $('#ddlSemester').append('<option value="' + data[i].semId + '">' + data[i]
                        .semName + '</option>');
                });
                $("#container").attr('style', 'display:none');      //removing the loading circles..
            }
        })
        getsubject(); //as user change  degree field semester start binding along with it we also bind the subjects..
        }
    }

    function getsubject() { //this function will bind subjects..
        $("#container").removeAttr('style');   //displaying the loading circles..
        var flagsub = "subject";
        var uniId = document.getElementById("ddlUniversity").value;
        var degId = document.getElementById("ddlDegree").value;
        var categId=document.getElementById("ddlCategory").value;
        if(uniId==0 || degId==0 || categId==0){
            $("#container").attr('style', 'display:none');      //removing the loading circles..
            return false;
        }
        else{
            $.ajax({
            url: "callServiceUploadNotesDatabind.php",
            method: "POST",
            data: {
                action: flagsub,
                category: categId,
                university: uniId,
                degree: degId
            },
            dataType: "json",
            success: function(data) {
                $("#ddlNotesSubject").empty();
                $("#ddlNotesSubject").append("<option value='0'>==select subject==</option>");
                $.each(data, function(i, item) {
                    $('#ddlNotesSubject').append('<option value="' + data[i].subId + '">' + data[i]
                        .subName + '</option>');
                });

                $("#container").attr('style', 'display:none');      //removing the loading circles..
            }
        });
        }
    }

    /*
    Uploading the notes as the form submits 
    on submiting the form sending all the data by
    post using php name attribute..
    */

    $("#notesUploadForm").on('submit', function(e) {
      
        //var response = grecaptcha.getResponse(
        var formData = new FormData(this);

        var title = $("#txtTitle").val();
        var categ = document.getElementById("ddlCategory").value;
        var uni = document.getElementById("ddlUniversity").value;
        var coll = document.getElementById("ddlCollege").value;
        var deg = document.getElementById("ddlDegree").value;
        var sem = document.getElementById("ddlSemester").value;
        var sub = document.getElementById("ddlNotesSubject").value;
        var notesType = document.getElementById("ddlNotesType").value;
        var desc = $("#description").val();

        if (title.trim() == "") {
            $("#txtTitle").css("border", "1px solid red");
            $("#txtTitle").attr("placeholder", "* Title");
            $("#txtTitle").focus();
            return false;
        } else if (categ == 0) {
            $("#txtTitle").css("border", "1px solid #ccc");

            $("#ddlCategory").css("border", "1px solid red");
            $("#ddlCategory").focus();
            return false;
        } else if (uni == 0) {
            $("#ddlCategory").css("border", "1px solid #ccc");

            $("#ddlUniversity").css("border", "1px solid red");
            $("#ddlUniversity").focus();
            return false;
        } else if (coll == 0) {
            $("#ddlUniversity").css("border", "1px solid #ccc");

            $("#ddlCollege").css("border", "1px solid red");
            $("#ddlCollege").focus();
            return false;
        } else if (deg == 0) {
            $("#ddlCollege").css("border", "1px solid #ccc");

            $("#ddlDegree").css("border", "1px solid red");
            $("#ddlDegree").focus();
            return false;
        } else if (sem == 0) {
            $("#ddlDegree").css("border", "1px solid #ccc");

            $("#ddlSemester").css("border", "1px solid red");
            $("#ddlSemester").focus();
            return false;
        } else if (sub == 0) {
            $("#ddlSemester").css("border", "1px solid #ccc");

            $("#ddlNotesSubject").css("border", "1px solid red");
            $("#ddlNotesSubject").focus();
            return false;
        } else if (notesType == 0) {
            $("#ddlNotesSubject").css("border", "1px solid #ccc");

            $("#ddlNotesType").css("border", "1px solid red");
            $("#ddlNotesType").focus();
            return false;
        } else if (desc.trim() == "") {
            $("#ddlNotesType").css("border", "1px solid #ccc");

            $("#description").css("border", "1px solid red");
            $("#description").attr("placeholder", "* Description required");
            $("#description").focus();
            return false;
        } else if (document.getElementById("uploadNotes").files.length == 0) {
            getFailureModal("No File Selected!!");
            return false;
        } 
        else {

            //creating directory name..
            var categName = document.getElementById("ddlCategory").options[document.getElementById(
                'ddlCategory').selectedIndex].text;
            var uniName = document.getElementById("ddlUniversity").options[document.getElementById(
                'ddlUniversity').selectedIndex].text;
            var degName = document.getElementById("ddlDegree").options[document.getElementById('ddlDegree')
                .selectedIndex].text;
            var subName = document.getElementById("ddlNotesSubject").options[document.getElementById(
                'ddlNotesSubject').selectedIndex].text;
            var ntName = document.getElementById("ddlNotesType").options[document.getElementById('ddlNotesType')
                .selectedIndex].text;
            var rootDir = "documents";

            var filepath = rootDir + '/' + uniName + '/' + degName + '/' + categName + '/' + subName + '/' +
                ntName + '/';

            e.preventDefault();
            var len = filesToUpload.length;

            formData.append("filePath", filepath);

            for (var i = 0; i < len; i++) {
                formData.append("files[]", filesToUpload[i].files);
            }

            $("#container").removeAttr('style');
            $.ajax({
                type: 'POST',
                url: 'fileupload.php',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $("#container").attr('style', 'display:none');
                    if (data == 1) {
                        getSuccessModal();
                    } else if (data == 0) {
                        alert("Some problem occured please try again later");
                    }
                    else if(data==2){
                        alert("Enter valid data");
                    }
                    else{

                    }                    
                    clearUpload();
                    formData=null;
                }
            });
        }
    });

    function clearUpload(){
        document.getElementById("ddlCategory").selectedIndex=0;
        document.getElementById("ddlUniversity").selectedIndex=0;
        document.getElementById("ddlCollege").selectedIndex=0;
        document.getElementById("ddlDegree").selectedIndex=0;
        document.getElementById("ddlSemester").selectedIndex=0;
        document.getElementById("ddlNotesSubject").selectedIndex=0;
        document.getElementById("ddlNotesType").selectedIndex=0;
        $("#description").val("");
        $("#txtTitle").val("");
        $("#uploadNotes").val('');
        $("#fileList").empty();
        grecaptcha.reset();
    }

    </script>

</body>

</html>