<?php 
include("index.incOther.php");
if(isset($_SESSION["id"]) && $_SESSION["roleId"]==2){

?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="css/style-user-history.css" rel="stylesheet">
        <link href="css/loader.css" rel="stylesheet">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body>

        <!--========hidden fields are use to store the value of user university and college id==========-->
        <input type="hidden" id="hiddenUserUniId" value="<?php echo $_SESSION["uniId"] ?>">
        <input type="hidden" id="hiddenUserCollId" value="<?php echo $_SESSION["collId"]?>">
        <input type="hidden" id="hiddenUserId" value="<?php echo $_SESSION["id"]?>">
        
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

        <div class="center-main">

        <!--=============
                Filter modal starts..
            ===============-->  
            <div class="filterBox" id="filterBox">
                <div class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-3" id="lblFilterUni">University</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ddlFilterUni" onchange="getcollege()">
                                <option value="0">==select==</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" id="lblFilterColl">College</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ddlFilterColl" onchange="getdegree()">
                                <option value="0">==select==</option>
                                <option value="0">Select university</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" id="lblFilterDeg">Degree</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ddlFilterDeg" onchange="getsubject()">
                                <option value="0">==select==</option>
                                <option value="0">Select university and college</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" id="lblFilterSub">Subject</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ddlFilterSub">
                            <option value="0">==select==</option>
                            <option value="0">Select university,college and degree</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" id="lblFilterSem">Semester</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="ddlFilterSem">
                                <option value="0">==select==</option>
                                <option value="0">Select degree</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12 button-row">
                            <div class="col-sm-6">
                                <input type="text" class="btn btn-default pull-right" onclick="searchFilterData()"  value="Search">
                            </div>

                            <div class="col-sm-6">
                                <input type="text" class="btn btn-default pull-right " onclick="closeFilterModal()" value="Close">    
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--=============
                Filter modal ends..
            ===============-->

    <!--============
        tabs starts..
    ===============-->
            
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#userPendingNotes">Pending</a></li>
        <li><a data-toggle="tab" href="#userApprovedNotes">Approved</a></li>
        <li><a data-toggle="tab" href="#userRejectedNotes">Rejected</a></li>
        
    </ul>        

    <div class="tab-content">

        <div id="userPendingNotes" class="tab-pane fade in active">   <!--=== user pending notes ===-->
            <h3>Pending</h3> 
            <div class="container notes-table-pending notes-box">
				<table class="table table-condensed table-responsive table-hover" id="tblUserPenHistoryHead">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>University</th>
                            <th>College</th>
                            <th>Degree</th>
                            <th>Subject</th>
                            <th>Semester</th>
                        </tr>
                    </thead>
                    <tbody id="tblUserPenHistoryBody">

                    </tbody>
                </table>
            </div>
        </div>

        <div id="userApprovedNotes" class="tab-pane fade">              <!--=== user approved notes ===-->
            <h3>Approved</h3>
            <div class="container notes-table-pending notes-box">
				<table class="table table-condensed table-responsive table-hover" id="tblUserAppHistoryHead">
                <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>University</th>
                            <th>College</th>
                            <th>Degree</th>
                            <th>Subject</th>
                            <th>Semester</th>
                            <th>Likes</th>
                            <th>Dislikes</th>
                            <th>Downloads</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tblUserAppHistoryBody">

                    </tbody>
                </table>
            </div>
        </div>

        <div id="userRejectedNotes" class="tab-pane fade">              <!--=== user rejected notes ===-->
            <h3>Rejected</h3>
            <div class="container notes-table-pending notes-box">
				<table class="table table-condensed table-responsive table-hover" id="tblUserRejHistoryHead">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>University</th>
                            <th>College</th>
                            <th>Degree</th>
                            <th>Subject</th>
                            <th>Semester</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tblUserRejHistoryBody">

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!--============
        tabs starts..
    ===============-->        

        </div>
<?php }else{
    echo "<script type='text/javascript'>window.top.location='index.php';</script>";
} ?>

<?php 
    include('in-footer.inc.php');
?>

    </body>

    <script>

    $(document).ready(function(){
        
        $("#userProfile").removeClass("activeSideBarLink");     // adding active class so that the like of the page in which the user
        $("#userMyUploads").addClass("activeSideBarLink");     //  is currently will   
        $("#userFavourites").removeClass("activeSideBarLink");     // highlited,
        $("#userUpload").removeClass("activeSideBarLink");     //  and unhighliting the other links..

        $("#container").attr('style', 'display:none');     //removing the loading circles..
        bindUserAllAppUploads();
        bindUserAllPenUploads();
        bindUserAllRejUploads();
    });

        function bindUserAllAppUploads(){
            $("#container").removeAttr('style');   //displaying the loading circles..
            var userId=$("#hiddenUserId").val();
            var flag="userAppHistory";
            var trStart='<tr>';
            var trEnd='</tr>';
            
            $.ajax({
                method:"POST",
                url:"callServiceSearchNotes.php",
                dataType:"json",
                data:{action:flag,id:userId},
                success:function(data){
                    if(data=='empty'){
                        $('#tblUserAppHistoryBody').empty();
                        $('#tblUserAppHistoryBody').append(trStart+'<td colspan="2">No data present</td>'+trEnd);
                        $("#container").attr('style', 'display:none');     //removing the loading circles..
                    }
                    else{
                        $('#tblUserAppHistoryBody').empty();
                        $.each(data, function(i, item) {
						$('#tblUserAppHistoryBody').append(
                            trStart+ '<td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)"> <span class="fa fa-book dropdown ddlSmallTable"> '+data[i].notesTitle+' <div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span> </h5></td>  <td><h5>'+data[i].notesDesc+'</h5></td> <td>'+data[i].notesUni+'</td> <td>'+data[i].notesColl+'</td> <td>'+data[i].notesDeg+'</td><td>'+data[i].notesSub+'</td> <td>'+data[i].notesSem+'</td> <td>'+data[i].totalLikes+'</td> <td>'+data[i].totaldislikes+'</td> <td>'+data[i].totaldown+'</td> <td> <input type="submit" class="btn btn-sm btn-danger" id="'+data[i].notesId+'" onclick="deleteAppNotes(this)" value="Delete"> </td>'+trEnd
						    )
                	    });
                        $("#container").attr('style', 'display:none');     //removing the loading circles..
                    }
                }
            });
        }

        function bindUserAllPenUploads(){
            $("#container").removeAttr('style');   //displaying the loading circles..
            var userId=$("#hiddenUserId").val();
            var flag="userPenHistory";
            var trStart='<tr>';
            var trEnd='</tr>';
            
            $.ajax({
                method:"POST",
                url:"callServiceSearchNotes.php",
                dataType:"json",
                data:{action:flag,id:userId},
                success:function(data){
                    if(data=='empty'){
                        $('#tblUserPenHistoryBody').append(trStart+'<td colspan="2">No data present</td>'+trEnd);
                        $("#container").attr('style', 'display:none');     //removing the loading circles..
                    }
                    else{
                        $('#tblUserPenHistoryBody').empty();
                        $.each(data, function(i, item) {
						$('#tblUserPenHistoryBody').append(
                            trStart+ '<td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)"> <span class="fa fa-book dropdown ddlSmallTable"> '+data[i].notesTitle+' <div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span> </h5></td>  <td><h5>'+data[i].notesDesc+'</h5></td> <td>'+data[i].notesUni+'</td> <td>'+data[i].notesColl+'</td> <td>'+data[i].notesDeg+'</td><td>'+data[i].notesSub+'</td> <td>'+data[i].notesSem+'</td>'+trEnd
						    )
                	    });
                        $("#container").attr('style', 'display:none');     //removing the loading circles..
                    }
                }
            });
        }

        function bindUserAllRejUploads(){
            $("#container").removeAttr('style');   //displaying the loading circles..
            var userId=$("#hiddenUserId").val();
            var flag="userRejHistory";
            var trStart='<tr>';
            var trEnd='</tr>';
            
            $.ajax({
                method:"POST",
                url:"callServiceSearchNotes.php",
                dataType:"json",
                data:{action:flag,id:userId},
                success:function(data){
                    if(data=='empty'){
                        $('#tblUserRejHistoryBody').empty();
                        $('#tblUserRejHistoryBody').append(trStart+'<td colspan="2">No data present</td>'+trEnd);
                        $("#container").attr('style', 'display:none');     //removing the loading circles..
                    }
                    else{
                        $('#tblUserRejHistoryBody').empty();
                        $.each(data, function(i, item) {
						$('#tblUserRejHistoryBody').append(
                            trStart+ '<td> <h5 id="'+data[i].notesId+'" class="dropdown ddlSmallTable" onclick="openfilelist(this)"> <span class="fa fa-book dropdown ddlSmallTable"> '+data[i].notesTitle+' <div class="dropdown-content" id="dropdown-content"> <span class="closeSmTable">&times;</span> <table class="table tbl-notes-files" id="tableAllNotes"><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr><tr><td>Link 1 </td></tr></table></div></span> </h5></td>  <td><h5>'+data[i].notesDesc+'</h5></td> <td>'+data[i].notesUni+'</td> <td>'+data[i].notesColl+'</td> <td>'+data[i].notesDeg+'</td><td>'+data[i].notesSub+'</td> <td>'+data[i].notesSem+'</td> <td> <input type="submit" id="'+data[i].notesId+'" class="btn btn-sm btn-danger" onclick="deleteRejNotes(this)" value="Delete"> </td>'+trEnd
						    )
                	    });
                        $("#container").attr('style', 'display:none');     //removing the loading circles..
                    }
                }
            });
        }

        function emptyFilter(){     //this function will empty all the ddls in filter..
                var uniId=document.getElementById("ddlFilterUni").selectedIndex=0;
                var collId=document.getElementById("ddlFilterColl").selectedIndex=0;
                var degId=document.getElementById("ddlFilterDeg").selectedIndex=0;
                var subId=document.getElementById("ddlFilterSub").selectedIndex=0;
                var semId=document.getElementById("ddlFilterSem").selectedIndex=0;
            }

		function getFilterModal(){
            var modal=document.getElementById("filterBox");
            if(modal.style.display==="block"){
                modal.style.display="none";
            }
            else{
                modal.style.display="block";
            }
        }

        function deleteAppNotes(args){
            var notesId=args.id;
            var flag="deleteAppNotes";
            var userId=$("#hiddenUserId").val();
            var askAgain=confirm('Do you want to delete');
            if(askAgain){
                $("#container").removeAttr('style');   //displaying the loading circles..
                $.ajax({
                method:"POST",
                url:"callServiceSearchNotes.php",
                dataType:"json",
                data:{action:flag,notesid:notesId,userid:userId},
                success:function(data){
                    
                    if(data==1){
                        alert('Deleted Successfully');
                        bindUserAllAppUploads();
                    }
                    else if(data==0){
                        alert('Some problem occured');
                    }
                    else if(data=='error'){
                        window.location.replace('error.html');
                    }
                }
                });
                $("#container").attr('style', 'display:none');     //removing the loading circles..
            }
            else{
                return false;
            }
        }

        function deleteRejNotes(args){
            var notesId=args.id;
            var flag="deleteRejNotes";
            var userId=$("#hiddenUserId").val();
            var askAgain=confirm('Do you want to delete');
            if(askAgain){
                $("#container").removeAttr('style');   //displaying the loading circles..
                $.ajax({
                method:"POST",
                url:"callServiceSearchNotes.php",
                dataType:"json",
                data:{action:flag,notesid:notesId,userid:userId},
                success:function(data){
                    
                    if(data==1){
                        alert('Deleted Successfully');
                        bindUserAllRejUploads();
                    }
                    else if(data==0){
                        alert('Some problem occured');
                    }
                    else if(data=='error'){
                        window.location.replace('error.html');
                    }
                }
                });
                $("#container").attr('style', 'display:none');     //removing the loading circles..
            }
            else{
                return false;
            }
        }

        function openfilelist(get){         //this function will open and close the dropdown of notes list..
                var id=get.id;
                var trStart='<tr>';
    	        var trEnd='</tr>';
                var sib=$("#"+id).find('.dropdown-content').hasClass('ddlLinkList');
                if(sib){
                    $("#"+id).find('.dropdown-content').removeClass('ddlLinkList');
                }
                else{
                    $("#"+id).find('.dropdown-content').addClass('ddlLinkList');
                    $("#container").removeAttr('style');   //displaying the loading circles..
                    $("#"+id).find('#tableAllNotes').empty();       //cleaning the table to bind files..
                    var flag='searchAllNotesFiles';
                    $.ajax({
                        url:'callServiceSearchNotes.php',
                        method:'POST',
                        dataType:'json',
                        data:{action:flag,notesId:id},
                        success:function(data){
                            $.each(data, function(i, item) {
                                $("#"+id).find('#tableAllNotes').append(trStart+'<tr> <td style="padding:3px" > <a id="'+data[i].notesId+'" href="'+data[i].notesPath+'" target="_blank" ><span class="fa fa-file"></span> File</a></td></tr>'+trEnd) ;
                            });
                    
                            $("#container").attr('style', 'display:none');      //removing the loading circles..
                        }
                    });
                }           
            }

    </script>

</html>