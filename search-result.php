<?php
include("core/connpdo.php");
require_once "index.inc.php";
require_once "app_code/sqlhelper.php";

if(isset($_GET["userSearch"]) || isset($_GET['btnSearch']) || isset($_GET['btnSearchFilter'])){   //this page will only visible if user comes from front else he/she will redirect to home page
    
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery.js"></script>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style-search-result.css" rel="stylesheet">
    <link href="css/loader.css" rel="stylesheet">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
</head>

<body id="myPage">
<?php   echo '<input type="hidden" id="countofSearchResult" value="'.$countofSearchResult.'"/>'; ?>
<input type="hidden" id="callMethodAfterLogin"/>
<input type="hidden" id="isdownloaded"/>
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
            <input type="submit" class="btn btn-sm" id="btnChangePass" onclick="updatePassChange()" value="Submit">
            <input type="submit" class="btn btn-sm" id="btnCloseForPopup" onclick="getpopup()" value="Close">
        </div>
    </div>
    <!--===
                      popup for password change ends..
            ===-->
    <!--========== modal for notes files bind starts ===========-->

    <!-- code added by vivek kr sahu-->
    <!-- Modal -->
    <div class="container shownotesfiles" id="shownotesfiles">
        <div class="row">
        
            <div class="col-sm-12 modalbox">
            <span class="closeDownPopup" onclick="closeDownldBox()">&times;</span>
                
                    <div class="modalpreviewpart col-sm-6 ">
                        <div class="get-notes-files">
                       
                       

                        </div>

                    </div>
                
                
                <div class="modaldespart col-sm-6">
                    <div class="get-parti-notes" id="getDownloadNotes">
                        <img class="img-circle" id="userImageForDownload"> <span id="usrNameofUploader"
                            class="userNameForDownload">
                            
                            </span>
                        <div class="dwncontent">
                            <h4 class="downloadNotesTitle"></h4>
                            <h5 class="downloadNotesDescription">
                            </h5>
                        </div>
                       

                    </div>
                    <div class="downloadNotesDetails">
                        <span class="label label-default">
                            <span class="fa fa-thumbs-up icon-left"></span>
                            <span id="downloadlike" ></span>
                        </span>
                            &nbsp;&nbsp;
                        <span class="label label-default">
                        <span class="fa fa-thumbs-down icon-left">

                        </span>
                        <span id="downloaddislike" ></span>
                        </span>
                    </div>
                    <div class="dwnbntstyle">
                        <form method="post" action="Notifydownloading.php">
                            <input type="hidden" id="usrid" name="userid"/>
                            <input type="hidden" id="valid" name="id"/>
                            <input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                            <button class="btn" name="btnDownloadNotes" onclick="$('#isdownloaded').val('1');" id="downloadNotes">Download <span class="fa fa-download"></span>
                            </button>
                        </form>
                        <div class="downloadReport">Download Problem! <span class="downloadReportLink">Report here</span> 
                        </div>
                    </div>
                </div>
                            
            </div>

        </div>
    </div>


    <!--end-->
    <!--code by sachin-->


    <!--========== modal for notes files bind ends  ===========-->


    <!-- The Modal starts-->
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
                    <h6 class="forgorPass" onclick="getpopup()"><a href="#">Forgot password</a></h6>
                </div>

                <div class="row login-with-other">
                    <h5 class="help-text"> or login with </h5>
                    <span class="fa fa-facebook"></span>
                    <span class="fa fa-google-plus"></span>
                </div>

                <hr>

                <div class="row new-signup">
                    <span class="for-new-signup">Don't have an account? <a href="user-registration.php">signup
                            now</a></span>
                </div>
            </div>
        </div>

    </div>
    <!--======= modal ends ========-->




    <!--===========
                notes will bind here starts
            ==========-->
    <div class="notes-box container">
        <?php
        if($countofSearchResult>0){
       
                        foreach ($stmt->fetchAll() as $res) {
                    ?>
        <div  class="col-md-12 box-container-for-notes">
            <h4 id="<?php echo $res['INT_NOTES_ID']?>" class="dropdown ddlSmallTable h4style"
                onclick="openfilelist(this)">
                <span class="fa fa-book"></span>&nbsp;
                <?php echo $res['VCH_TITLE']?>

            </h4>

            <div class="box-desc">
                <?php echo $res['VCH_DESCRIPTION'] ?>
            </div>
            <hr class="hr-style">
            <div class="box-notes-details">
                <span><?php /*
                $sqlhelper = new SqlHelper();
               $postedDate= $sqlhelper->time_elapsed_string($res['DTM_CREATED_DATE'],$res['current_timestmp']);
                echo $postedDate;
                $sqlhelper=null; */
                ?></span>
                <span class="notes-sub label label-default "> <?php echo $res['VCH_USER_NAME'] ?></span>&nbsp;
                <span class="notes-uni label label-default "><?php echo $res['VCH_UNIVERSITY_NAME'] ?> </span>&nbsp;
                <span class="notes-coll label label-default"><?php echo $res['VCH_COLLEGE_NAME']?></span>&nbsp;
                <span class="notes-deg label label-default "> <?php echo $res['VCH_DEGREE_NAME'] ?></span>&nbsp;
                <span class="notes-sub label label-default "> <?php echo $res['VCH_SUB_NAME'] ?> </span>&nbsp;
                <span class="notes-sem label label-default "> <?php echo $res['VCH_SEMESTER'] ?></span>&nbsp;
            </div>
            <div class="box-next-line">

                <span data-id="<?php echo "fav-".$res['INT_NOTES_ID'] ?>" <?php if($res['IS_USER_FAV']==1){   ?>
                    class="fa fa-star icon-left fav-btn" <?php }
                           else{ ?> class="fa fa-star-o icon-left fav-btn" <?php } ?>>

                </span>
                &nbsp;
                <!--<span class="label label-default lbllike">-->
                <i <?php if($res['IS_USER_LIKE']==1){   ?> class="fa fa-thumbs-up icon-left like-btn" <?php }
                           else{ ?> class="fa fa-thumbs-o-up icon-left like-btn" <?php } ?>
                    data-id="<?php echo $res['INT_NOTES_ID'] ?>"></i>
                <span id="<?php echo "likecnt".$res['INT_NOTES_ID'] ?>" class="likes"><?php echo $res['TOTAL_LIKE'] ?>
                </span>
                <!-- </span>-->
                &nbsp;
                <!--<span class="label label-default lbldislike">-->
                <i <?php if($res['IS_USER_DISLIKE']==1){   ?> class="fa fa-thumbs-down icon-left dislike-btn" <?php }
                           else{ ?> class="fa fa-thumbs-o-down icon-left dislike-btn" <?php } ?>
                    data-id="<?php echo $res['INT_NOTES_ID'] ?>"></i>
                <span id="<?php echo "dislikecnt".$res['INT_NOTES_ID'] ?>"
                    class="dislikes"><?php echo $res['TOTAL_DISLIKE'] ?></span>&nbsp;

                <span id="<?php echo $res['INT_NOTES_ID'] ?>" data-toggle="tooltip"
                    title="Click here to download" onclick=" openfilelist(this);"
                    <?php if($res['IS_USER_DOWNLOAD']>=1) { ?>
                    class="fa fa-download icon-left download"
                    <?php 
                        }
                    else { ?>
                   class="fa fa-download icon-right download"
                   <?php }
                    ?>
                    
                    >
                     </span>
                    &nbsp;
                    <span  class="downloadCnt"><?php echo $res['total_downloads'] ?>
                </span>
            </div>
        </div>
        <?php 
        
    } //end of loop..  
}//end of count check
else{
    echo '<h4  class="dropdown h4style text-center">No record(s) found.</h4>';

}
    $stmt=null;
}     //end if isset
else{
header('Location:index.html');
$stmt=null;
}
?>

    </div>
    <!--===========
                notes will bind here ends
            ==========-->


            <?php 
    include('in-footer.inc.php');
?>

</body>



<script src="js/bootstrap.min.js"></script>
<script src="js/search-result-smallsc.js"></script>
<script src="js/jscodeforlikedislike.js"></script>
<script src="js/notify.min.js"></script>
<script src="js/jquery.twbsPagination.js"></script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>-->
<script>
//when clicking on any button cancle default behaviour..

var btnsignup = document.getElementById("btnSignUp");
var btnChangePass = document.getElementById("btnChangePass");
var btnCloseForPopup = document.getElementById("btnCloseForPopup");
$(btnsignup).click(function(event) {
    event.preventDefault(); // cancel default behavior
    window.location.href = "user-registration.php";
});
$(btnChangePass).click(function(event) {
    event.preventDefault(); // cancel default behavior
});
$(btnCloseForPopup).click(function(event) {
    event.preventDefault(); // cancel default behavior
});

function getpopup() { //get popup to change password..
    var modalPass = document.getElementById("popup-box");
    if (modalPass.style.display === "block") {
        modalPass.style.display = "none";
    } else {
        modalPass.style.display = "block";
    }
    //hinding the login modal
    document.getElementById("myModal").style.display = "none";
}

function updatePassChange() { //this function will send password change link to the user email..
    var useremail = $("#txtEmailForNewPass").val();
    var flag = "checkUserEmail";
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (useremail.trim() == "") {
        $("#txtEmailForNewPass").attr('placeholder', '* Enter your email');
        $("#txtEmailForNewPass").css('border', '1px solid red');
    } else if (!regex.test(useremail)) {
        $("#txtEmailForNewPass").val('');
        $("#txtEmailForNewPass").attr('placeholder', '* Enter valid email');
        $("#txtEmailForNewPass").css('border', '1px solid red');
    } else {
        $.ajax({
            url: "callServiceRegLogin.php",
            method: "POST",
            data: {
                action: flag,
                email: useremail
            },
            success: function(data) {
                if (data == 1) {
                    $("#showPassChangeMsg").addClass('alert-success');
                    $("#showPassChangeMsg").html(
                        "<strong><span class='fa fa-smile-o'></span></strong> Password recovery link has been sent to your email  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> "
                    );

                } else if (data == 0) {
                    $("#showPassChangeMsg").addClass('alert-warning');
                    $("#showPassChangeMsg").html(
                        "<strong><span class='fa fa-exclamation-triangle'></span></strong> Email not registered <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> "
                    );

                } else {
                    alert('oops! something went wrong');
                }
            }
        });
    }
}

function clearFields() {
    $('#txtUserLoginPassword').val('');
}

$(document).ready(function() {
    $("#container").attr('style', 'display:none'); //removing the loading circles..
    var flagUni = 'uni';
    $.ajax({
        url: "callServiceSearchNotes.php",
        method: "POST",
        data: {
            action: flagUni,
            id: 0
        },
        dataType: "json",
        success: function(data) {
            $("#ddlFilterUni").empty();
            $("#ddlFilterUni").append("<option value='0'>==select==</option>");
            $.each(data, function(i, item) {
                $('#ddlFilterUni').append('<option value="' + data[i].uniId + '">' + data[i]
                    .uniName + '</option>');
            });
        }
    });
});


function userLogin() {
    var email = $("#txtUserLoginEmail").val();
    var pass = $("#txtUserLoginPassword").val();
    var flag = "userLogin";
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (email.trim() == "") {
        $("#txtUserLoginEmail").val("");
        $("#txtUserLoginEmail").css("border", "1px solid red");
        $("#txtUserLoginEmail").attr("placeholder", "* Enter email");
        $("#txtUserLoginEmail").focus();
    } else if (!regex.test(email)) {
        $("#txtUserLoginEmail").val("");
        $("#txtUserLoginEmail").css("border", "1px solid red");
        $("#txtUserLoginEmail").attr("placeholder", "* Enter valid email");
        $("#txtUserLoginEmail").focus();
    } else if (pass.trim() == "") {
        $("#txtUserLoginEmail").css("border", "1px solid #ccc");

        $("#txtUserLoginPassword").css("border", "1px solid red");
        $("#txtUserLoginPassword").attr("placeholder", "* Enter password");
        $("#txtUserLoginPassword").focus();
    } else {
        $("#container").removeAttr('style'); //displaying the loading circles..
var maintainStateData="";
        if($('#callMethodAfterLogin').val()){
            maintainStateData= $('#callMethodAfterLogin').val();
        }
        $.ajax({
            url: "callServiceRegLogin.php",
            method: "POST",
            data: {
                action: flag,
                userEmail: email,
                userPass: pass,
                stateData:maintainStateData,
               
            },
            success: function(data) {
                if (data == 0) {
                    $("#showMessage").addClass('alert-warning');
                    $("#showMessage").html(
                        "<strong><span class='fa fa-exclamation-triangle'></span></strong> Email or Password incorrect <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> "
                    );
                    //$("#removeAlert").html("&times;");
                    clearFields();
                } else if (data == 1) {
                    $("#showMessage").addClass('alert-warning');
                    $("#showMessage").html(
                        "<strong><span class='fa fa-exclamation-triangle'></span></strong><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Account not activated  <br> <h6>Note: please click on the link sent on your email to activate your account</h6> "
                    );
                    //$("#removeAlert").html('&times;');
                    clearFields();
                } else if (data == 2) {
                    // window.location.href = "search-result.php";
                    location.reload();
                   
                    clearFields();
                } else if (data == 4) {
                    window.location.href = "user-admin.php";
                    clearFields();
                }

                $("#container").attr('style', 'display:none'); //removing the loading circles..
            }
        });
    }
}
</script>
<script>
function closeDownldBox() { //this function will close the download box..  
    document.getElementById("shownotesfiles").style.display = "none";
    if($("#isdownloaded").val()=='1'){
   location.reload();
  }
}

function searchFilterData() { //this all code will converted to php script..
    $("#container").removeAttr('style'); //displaying the loading circles..
    var uniId = document.getElementById("ddlFilterUni").value;
    var collId = document.getElementById("ddlFilterColl").value;
    var degId = document.getElementById("ddlFilterDeg").value;
    var subId = document.getElementById("ddlFilterSub").value;
    var semId = document.getElementById("ddlFilterSem").value;

    if (uniId == 0 && collId == 0 && degId == 0 && subId == 0 && semId == 0) {
        alert('please select any data');
        $("#container").attr('style', 'display:none'); //removing the loading circles..
        return false;
    }

    var allvalues = '';
    var columnNames = '';
    var trStart = '<tr>';
    var trEnd = '</tr>';
    if (uniId != 0 && collId != 0 && degId != 0 && subId != 0 && semId != 0) {
        allvalues = uniId + '~' + collId + '~' + degId + '~' + subId + '~' + semId;
        columnNames = 'INT_UNI_ID' + ',' + 'INT_COLL_ID' + ',' + 'INT_DEG_ID' + ',' + 'INT_SUB_ID' + ',' + 'INT_SEM_ID';
    }
    if (uniId != 0) {
        allvalues = uniId;
        columnNames = 'INT_UNI_ID';
        var query = 'nm.INT_UNI_ID' + '=' + uniId + ' ';
    }
    if (collId != 0) {
        allvalues += ',' + collId;
        columnNames += ',' + 'INT_COLL_ID';
        query += 'AND' + ' ' + 'nm.INT_COLL_ID' + '=' + collId + ' ';
    }
    if (degId != 0) {
        allvalues += ',' + degId;
        columnNames += ',' + 'INT_DEG_ID';
        query += 'AND' + ' ' + 'nm.INT_DEG_ID' + '=' + degId + ' ';
    }
    if (subId != 0) {
        allvalues += ',' + subId;
        columnNames += ',' + 'INT_SUB_ID';
        query += 'AND' + ' ' + 'nm.INT_SUB_ID' + '=' + subId + ' ';
    }
    if (semId != 0) {
        allvalues += ',' + semId;
        columnNames += ',' + 'INT_SEM_ID';
        query += 'AND' + ' ' + 'nm.INT_SEM_ID' + '=' + semId + ' ';
    }
    //alert(allvalues+','+columnNames+','+count);
    var filterdata = 'filter';
    $.ajax({
        type: "POST",
        url: "callServiceSearchNotes.php",
        dataType: "json",
        data: {
            action: filterdata,
            values: allvalues,
            columns: columnNames,
            sendQuery: query
        },
        success: function(data) {
            if (data == 0) {
                alert('something went wrong');
                closeFilterModal(); //this function will close the filter
                emptyFilter(); //calling this function to reset the values of ddls
                $("#container").attr('style', 'display:none'); //removing the loading circles..
            } else if (data == 1) {
                $('#tblNotes').empty();
                $('#tblNotes').append(
                    trStart + '<td colspan="9" >No data present..</td>' + trEnd
                );
                closeFilterModal(); //this function will close the filter
                emptyFilter(); //calling this function to reset the values of ddls
                $("#container").attr('style', 'display:none'); //removing the loading circles..
            } else {
                $('#tblNotes').empty();
                $.each(data, function(i, item) {
                    $('#tblNotes').append(
                        trStart + '<td> <h4 id="' + data[i].notesId +
                        '" class="dropdown ddlSmallTable" onclick="openfilelist(this)">' + data[
                            i].notesTitle +
                        ' <span class="fa fa-arrow-down dropdown ddlSmallTable"><div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span>    </h4>  <h5>' +
                        data[i].notesDesc +
                        '</h5> <hr style="margin-bottom:5px;margin-top:0px;"> <div class="notes-details"> <span class="label label-default">3 hours ago</span> <span class="notes-uni label label-default"><h6>' +
                        data[i].userName +
                        '</h6></span> <span class="notes-uni label label-default"><h6>' + data[
                            i].notesUni +
                        '</h6></span> <span class="notes-deg label label-default"><h6>' + data[
                            i].notesColl +
                        '</h6></span> <span class="notes-deg label label-default"><h6>' + data[
                            i].notesDeg +
                        '</h6></span><span class="notes-sub label label-default"><h6>' + data[i]
                        .notesSub +
                        '</h6></span><span class="notes-sub label label-default"><h6>' + data[i]
                        .notesSem +
                        '</h6></span></div> <div class="user-action"><span class="fa fa-star icon-left"></span><span class="fa fa-thumbs-up icon-left" onclick="noteslike(this)" id="' +
                        data[i].notesId +
                        '">213</span><span class="fa fa-thumbs-down icon-left" onclick="notesdislike(this)" id="' +
                        data[i].notesId +
                        '">54</span><span class="fa fa-download icon-right"></span></div> </td>' +
                        trEnd
                    )
                });
                closeFilterModal(); //this function will close the filter
                emptyFilter(); //calling this function to reset the values of ddls
                $("#container").attr('style', 'display:none'); //removing the loading circles..
            }
        }
    });
}

function emptyFilter() { //this function will empty all the ddls in filter..
    var uniId = document.getElementById("ddlFilterUni").selectedIndex = 0;
    var collId = document.getElementById("ddlFilterColl").selectedIndex = 0;
    var degId = document.getElementById("ddlFilterDeg").selectedIndex = 0;
    var subId = document.getElementById("ddlFilterSub").selectedIndex = 0;
    var semId = document.getElementById("ddlFilterSem").selectedIndex = 0;
}



//function for like 
$('.like-btn').on('click', function() {
    var objStateMaintain="";
    var data = $(this).data('id');
    var clicked = $(this);
    if(clicked.hasClass("fa-thumbs-up")){
        objStateMaintain="unlike";
}
else if(clicked.hasClass("fa-thumbs-o-up")){
    objStateMaintain="like";
}
    
    <?php
 
  if(isset($_SESSION["id"])){

      echo "getLikedLogic(data,".$_SESSION["id"].",clicked);";
    ?>

    <?php
  }
  else{  
      ?>
       $('#callMethodAfterLogin').val('getLikedLogic-'+data+"-"+objStateMaintain);
    $('#myModal').show();
   
    <?php }
    ?>
});

//function for dislike 
$('.dislike-btn').on('click', function() {
    var objStateMaintain="";
    var data = $(this).data('id');
    var clicked = $(this);
    if(clicked.hasClass("fa-thumbs-down")){
        objStateMaintain="undislike";
}
else if(clicked.hasClass("fa-thumbs-o-down")){
    objStateMaintain="dislike";
}

   
    <?php
 
  if(isset($_SESSION["id"])){

      echo "getdisLikedLogic(data,".$_SESSION["id"].",clicked);";
    ?>

    <?php
  }
  else{   
      
      ?>
      $('#callMethodAfterLogin').val('getdisLikedLogic-'+data+"-"+objStateMaintain);
    $('#myModal').show();
    <?php }
    ?>

});
//function for fav
$('.fav-btn').on('click', function() {
    var objStateMaintain="";
    var data = $(this).data('id');
    var clicked = $(this);
    if(clicked.hasClass("fa-star")){
        objStateMaintain="unfav";
  }
  else if(clicked.hasClass("fa-star-o")){
    objStateMaintain="fav";
  }



    <?php
  if(isset($_SESSION["id"])){
      echo "getfavLogic(data,".$_SESSION["id"].",clicked);";
    ?>
    <?php
  }
  else{    
      ?>
      $('#callMethodAfterLogin').val('getfavLogic-'+data+"-"+objStateMaintain);
    $('#myModal').show();
    <?php }
    ?>
});


function forDownloading(id){
       
    <?php
    if(isset($_SESSION["id"])){
        ?>
        $('#valid').val(id);
$('#usrid').val(<?php echo $_SESSION["id"] ?>);
    var downloadModal = document.getElementById("shownotesfiles");
    if (downloadModal.style.display === "block") {
        downloadModal.style.display = "none";
    } else {
       

        var flag = 'searchAllNotesFiles';
        $.ajax({
            url: 'callServiceSearchNotes.php',
            method: 'POST',
            dataType: 'json',
            data: {
                action: flag,
                notesId: id
            },
            timeout: 10000,
    error: function(jqXHR) { 
        if(jqXHR.status==0) {
            alert(" fail to connect with internet, please check your connection settings");
			return false;
        }
    },
            success: function(data) {
               
                var totalcnt=data.length;
                var strData="";
                
      $("#userImageForDownload").attr("src",data[0].userProfilePath);
    
   
      $("#usrNameofUploader").html(data[0].userName);


                $('.downloadNotesTitle').html(data[0].notesTitle);
                $('.downloadNotesDescription').html(data[0].notesDesc);
                $('#downloadlike').html(data[0].totalLikes);
                $('#downloaddislike').html(data[0].totalDislikes);
                var containerData=' <div class="slidercontainer"> ';
               //var containerData='<div id="showDetails" class="slidercontainer">';
               cnt=1;
                $.each(data, function(i, item) {
                  strData=data[i].notesPath;
                    if(strData.includes('.')) {
                       var ext=strData.split('.');
                        
                        containerData= containerData+  bindSlider(cnt,totalcnt,ext[1],data[i].notesPath)  ;
                    cnt++;
                    }
                  
});
containerData=containerData+`  
<ul id="pagination-data" class="pagination"></ul>
  </div>  
  
  <script>
  $('#pagination-data').twbsPagination({
                
    totalPages:`+totalcnt+`,
    // the current page that show on start
    startPage: 1,
    
    // maximum visible pages
    visiblePages: 5,
    
    initiateStartPageClick: true,
    
    // template for pagination links
    href: false,
    
    // variable name in href template for page number
    hrefVariable: '{{number}}',
    
    // Text labels
    first: 'First',
    prev: 'Previous',
    next: 'Next',
    last: 'Last',
    
    // carousel-style pagination
    loop: false,
    
    // callback function
    onPageClick: function (event, page) {
        $('.page-active').removeClass('page-active');
      $('#page'+page).addClass('page-active');
    },
    
    // pagination Classes
    paginationClass: 'pagination',
    nextClass: 'next',
    prevClass: 'prev',
    lastClass: 'last',
    firstClass: 'first',
    pageClass: 'page',
    activeClass: 'active',
    disabledClass: 'disabled'
    
    });

<\/script>
  
  
  
  
  
  `;

                    $('.get-notes-files').html(containerData);
                   
             
               

                $("#container").attr('style', 'display:none'); //removing the loading circles..
            }
        });

        downloadModal.style.display = "block";
        
    }

<?php
 }
 else{  
    
     echo " $('#myModal').show();";
 }
 
 ?>

$('#callMethodAfterLogin').val('forDownloading-'+id);
}

function openfilelist(get) { //this function will open and close the dropdown of notes list..
   
    var id = get.id;
    var trStart = "<tr>";
    var trEnd = "</tr>";
    objStateMaintain=get;
   
        $("#userImageForDownload").attr("src","Profile_pic/default-user.png");
   


    $('.downloadNotesDescription').html("<h4>Please wait.............   <i class='uil uil-stopwatch'></i></h4>");
    $('.get-notes-files').html("");
    $('.downloadNotesTitle').html("");
             
                $('#downloadlike').html("");
                $('#downloaddislike').html("");
forDownloading(id);
}

function bindSlider(i,totalcnt,ext,img){
    var str=`    
    <div id="page`+i+`" class="page" >
  <!-- Full-width images with number and caption text -->
  
    `;
    if(ext==='jpg'||ext==='png'||ext==='jpeg'){
        str=str+`<img src="`+img+`" style="width:40%">`;
    }    
    else if(ext==='pdf')
    {
        if(PDFObject.supportsPDFs){
           // str=str+'<script>PDFObject.embed("'+img+'", "#showDetails");<\/script>';
           //str=str+'<iframe class="pdfscroll" src="'+img+'" width="100%" height="100%"></iframe>';
            str=str+'<embed class="pdfscroll" src="'+img+'" type="application/pdf" width="100%" height="100%">'
        }
        else{
            console.log("inline PDFs are not supported by this browser");
        }
    }
    str=str+`</div>`;
    return str;
}




$(document).ready(function(){
    $("#callMethodAfterLogin").val('');
$("#isdownloaded").val('0');

<?php 
//user state will be maintained will be maintain 
    if(isset( $_SESSION["stateData"])){
      echo  $_SESSION["stateData"];

      unset($_SESSION["stateData"]);
    }
      
    ?>

    

   

});
</script>

</html>