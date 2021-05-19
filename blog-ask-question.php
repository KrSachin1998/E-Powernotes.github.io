<?php 
include("index.incOther.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title></title>

    <link href="css/style-ask-question.css" rel="stylesheet">
    <link href="css/loader.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <link href="css/multiplefileupload.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
    <script src="js/multiplefileupload.js"></script>

</head>

<body>
        <div id="main">
            <h3>Ask question here..</h3>
            <hr class="upload-hr">
            <h5>Please ask question related to education only..</h5>
            <br>
            <div class="form-horizontal">

                <!--------first row of form starts---------->
                <div class="row">
                <div class="col-sm-6 titleBox">
                    <div class="form group">
                    
                        <div class="userEmail">
                            <i class='uil uil-question-circle userIcon'></i>
                            <input type="text" class="form-control" placeholder="Title of your question [min 20 characters]" id="txtQuestionTitle" name="txtQuestionTitle">
                        </div>
                        <span class="help-text">The title will be shown above your question</span>
                        
                    </div>
                </div>
                

                <div class="col-sm-6">
                    <div class="form group">
                        
                        <div class="userEmail">
                            <i class='uil uil-align-center-alt userIcon'></i>
                            <select class="form-control" id="ddlQuestionCategory" name="ddlQuestionCategory" onchange="emptydegree()">
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
                            <select class="form-control" id="ddlQuestionUniversity" name="ddlQuestionUniversity" onchange="getcollege()">
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
                            <select class="form-control" id="ddlQuestionCollege" name="ddlQuestionCollege" onchange="getdegree()">
                                <option value='0'>==select college==</option>
                                <option value='0'>Please select university</option>
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
                            <select class="form-control" id="ddlQuestionDegree" name="ddlQuestionDegree" onchange="getsubject()">
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
                            <i class='uil uil-books userIcon'></i>
                            <select class="form-control" id="ddlQuestionSubject" name="ddlQuestionSubject">
                                <option value='0'>==select subject==</option>
                                <option value='0'>Please select Category, university and degree</option>
                            </select>
                        </div>
                            <span class="help-text">* Mandatory field</span>
                    </div>
                </div>
                </div>
                <!--------third row of form ends--------->


                <!--------fifth row of form starts--------->
                <div class="row">
                <div class="col-sm-12">
                    <div class="form group">
                        <div class="userEmail">
                            <i class='uil uil-comment-message userIcon'></i>
                            <textarea row="4" col="50" placeholder="Describe your question in simplest way or in case of computer Put samples code if any" class="form-control" id="questionDescription" name="questionDescription">
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

                    <!--------using this hidden field to make directory name---------->
                    <input type="hidden" name="hiddenDirecName" id="hiddenDirecName">
                    <input type="hidden" name="hiddenUserEmail" id="txtUserEmail"
                        value="<?php echo $_SESSION["email"]; ?>">
                </div>

                <div class="col-sm-6 btnBox">
                    <input type="submit" class="btn btn-default" value="Post" id="btnPostQuestion">
                </div>
                <div class="col-sm-6 btnBox">
                    
                </div>


            </div>
        </div>

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

    <script>

    function getFailureModal() {
        $("#myModal").css("display", "block");
        $("#modal-body").addClass("modalFail");
        $("#modal-body").html(
            "<span class='close' id='btnCloseModal'>&times;</span> Warning <span class='fa fa-exclamation-triangle'></span> <br> Something went wrong please try again later"
        );
        $("#btnCloseModal").click(function() {
            $("#myModal").css("display", "none");
        });
    }

    function getSuccessModal() {
        $("#myModal").css("display", "block");
        $("#modal-body").addClass("modalSuccess");
        $("#modal-body").html(
            "<span class='close' id='btnCloseModal'>&times;</span>Posted Successfully.. <span class='fa fa-smile-o'style='font-size:30px;'></span>.<br> <h6>Note: Your question will live within 5 minutes..</h6>"
        );
        $("#btnCloseModal").click(function() {
            $("#myModal").css("display", "none");
        });
    }

    /*
     when user change the category, degree field also become
     empty
     */
    function emptydegree() {
        $("#ddlQuestionDegree").get(0).selectedIndex = 0;
    }

    //code for binding data in upload notes fields..
    $(document).ready(function() { // on page load we bind category and university..

        $("#container").attr('style', 'display:none');  //removing the loading screen when screen loads completely..
        $("#questionDescription").val('');
        $("#questionSampleCode").val('');
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
            url: "callServiceBlogData.php",
            method: "POST",
            data: {
                action: flag,
                id: 0
            },
            dataType: "json",
            success: function(data) {
                $("#ddlQuestionCategory").empty();
                $("#ddlQuestionCategory").append("<option value='0'>==select category==</option>");
                $.each(data, function(i, item) {
                    $('#ddlQuestionCategory').append('<option value="' + data[i].categId + '">' +
                        data[i].categName + '</option>');
                });
            }
        });

        $.ajax({
            url: "callServiceBlogData.php",
            method: "POST",
            data: {
                action: flagUni,
                id: 0
            },
            dataType: "json",
            success: function(data) {
                $("#ddlQuestionUniversity").empty();
                $("#ddlQuestionUniversity").append("<option value='0'>==select university==</option>");
                $.each(data, function(i, item) {
                    $('#ddlQuestionUniversity').append('<option value="' + data[i].uniId + '">' +
                        data[i].uniName + '</option>');
                });
            }
        });

    });         //end of document . ready

    function getcollege() { //get the list of colleges as user select university
        $("#container").removeAttr('style');   //displaying the loading circles..
        var flag = "college";
        var universityId = document.getElementById("ddlQuestionUniversity").value;
        if(universityId==0){        //checking if user select the select option only..
            $("#container").attr('style', 'display:none');      //removing the loading circles..
            return false;
        }
        else{
            $.ajax({
            url: "callServiceBlogData.php",
            method: "POST",
            data: {
                action: flag,
                id: universityId
            },
            dataType: "json",
            success: function(data) {
                $("#ddlQuestionCollege").empty();
                $("#ddlQuestionCollege").append("<option value='0'>==select college==</option>");
                $.each(data, function(i, item) {
                    $('#ddlQuestionCollege').append('<option value="' + data[i].colId + '">' + data[i]
                        .colName + '</option>');
                });

                $("#container").attr('style', 'display:none');      //removing the loading circles..
            }
        });
        }
    }

    function getdegree() { //get the list of degrees as user select the college..
        $("#container").removeAttr('style');   //displaying the loading circles..
        var flag = "degree";
        var collegeId = document.getElementById("ddlQuestionCollege").value;
        if(collegeId==0){           //checking if user select the select option only..
            $("#container").attr('style', 'display:none');      //removing the loading circles..
            return false;
        }
        else{
            $.ajax({
            url: "callServiceBlogData.php",
            method: "POST",
            data: {
                action: flag,
                id: collegeId
            },
            dataType: "json",
            success: function(data) {
                $("#ddlQuestionDegree").empty();
                $("#ddlQuestionDegree").append("<option value='0'>==select degree==</option>");
                $.each(data, function(i, item) {
                    $('#ddlQuestionDegree').append('<option value="' + data[i].degId + '">' + data[i]
                        .degName + '</option>');
                });
                $("#container").attr('style', 'display:none');      //removing the loading circles..
            }
        });
        }
    }

    function getsubject() { //this function will bind subjects..
        $("#container").removeAttr('style');   //displaying the loading circles..
        var flagsub = "subject";
        var uniId = document.getElementById("ddlQuestionUniversity").value;
        var degId = document.getElementById("ddlQuestionDegree").value;
        var categId=document.getElementById("ddlQuestionCategory").value;
        if(uniId==0 || degId==0 || categId==0){
            $("#container").attr('style', 'display:none');      //removing the loading circles..
            return false;
        }
        else{
            $.ajax({
            url: "callServiceBlogData.php",
            method: "POST",
            data: {
                action: flagsub,
                category: categId,
                university: uniId,
                degree: degId
            },
            dataType: "json",
            success: function(data) {
                $("#ddlQuestionSubject").empty();
                $("#ddlQuestionSubject").append("<option value='0'>==select subject==</option>");
                $.each(data, function(i, item) {
                    $('#ddlQuestionSubject').append('<option value="' + data[i].subId + '">' + data[i]
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

    $("#btnPostQuestion").on('click', function(e) {
        //validate the form before uploading..
        var title = $("#txtQuestionTitle").val();
        var categ = document.getElementById("ddlQuestionCategory").value;
        var uni = document.getElementById("ddlQuestionUniversity").value;
        var coll = document.getElementById("ddlQuestionCollege").value;
        var deg = document.getElementById("ddlQuestionDegree").value;
        var sub = document.getElementById("ddlQuestionSubject").value;
        var desc = $("#questionDescription").val();

        if (title.trim() == "" || title.length<20) {
            $("#txtQuestionTitle").val("");
            $("#txtQuestionTitle").css("border", "1px solid red");
            $("#txtQuestionTitle").attr("placeholder", "* Title required of min 20 characters");
            $("#txtQuestionTitle").focus();
            return false;
        } else if (categ == 0) {
            $("#txtQuestionTitle").css("border", "1px solid #ccc");

            $("#ddlQuestionCategory").css("border", "1px solid red");
            $("#ddlQuestionCategory").focus();
            return false;
        } else if (uni == 0) {
            $("#ddlQuestionCategory").css("border", "1px solid #ccc");

            $("#ddlQuestionUniversity").css("border", "1px solid red");
            $("#ddlQuestionUniversity").focus();
            return false;
        } else if (coll == 0) {
            $("#ddlQuestionUniversity").css("border", "1px solid #ccc");

            $("#ddlQuestionCollege").css("border", "1px solid red");
            $("#ddlQuestionCollege").focus();
            return false;
        } else if (deg == 0) {
            $("#ddlQuestionCollege").css("border", "1px solid #ccc");

            $("#ddlQuestionDegree").css("border", "1px solid red");
            $("#ddlQuestionDegree").focus();
            return false;
        } else if (sub == 0) {
            $("#ddlQuestionDegree").css("border", "1px solid #ccc");

            $("#ddlQuestionSubject").css("border", "1px solid red");
            $("#ddlQuestionSubject").focus();
            return false;
        } else if (desc.trim() == "") {
            $("#ddlQuestionSubject").css("border", "1px solid #ccc");

            $("#questionDescription").css("border", "1px solid red");
            $("#questionDescription").attr("placeholder", "* Description required");
            $("#questionDescription").focus();
            return false;
        }

        else {
            $("#container").removeAttr('style');   //displaying the loading circles..
            var flagAskQues='askQuestion';
            $.ajax({
                type:"post",
                url:"callServicePostBlog.php",
                dataType:"json",
                data:{action:flagAskQues, categId:categ,
                uniId:uni,
                collId:coll,
                degId:deg,
                subId:sub,
                quesTitle:title,
                quesDesc:desc},
                success:function(data){
                    if(data=="posted"){
                        getSuccessModal();
                        clearUpload();
                    }
                    else if(data=="failed"){
                        getFailureModal();
                        clearUpload();
                    }
                    else{
                        alert('opps somenting went wrong try again later');
                        clearUpload();
                    }
                    $("#container").attr('style', 'display:none');      //removing the loading circles..
                }
            });
        }
    });

    function clearUpload(){
        document.getElementById("ddlQuestionCategory").selectedIndex=0;
        document.getElementById("ddlQuestionUniversity").selectedIndex=0;
        document.getElementById("ddlQuestionCollege").selectedIndex=0;
        document.getElementById("ddlQuestionDegree").selectedIndex=0;
        document.getElementById("ddlQuestionSubject").selectedIndex=0;
        $("#txtQuestionTitle").val("");
        $("#questionDescription").val("");
    }

    </script>

</body>

</html>