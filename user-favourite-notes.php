<?php 
include("index.incOther.php");
include("core/connpdo.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="css/style-user-fav-notes.css" rel="stylesheet">
	<link href="css/loader.css" rel="stylesheet">
</head>
<body>
<form method="post" action="<?php ($_SERVER['PHP_SELF']) ?>">

    <!--========hidden fields are use to store the value of user university and college id==========-->
    <input type="hidden" id="hiddenUserUniId" value="<?php echo $_SESSION["uniId"] ?>">
    <input type="hidden" id="hiddenUserCollId" value="<?php echo $_SESSION["collId"]?>">
    <input type="hidden" id="hiddenUserId" value="<?php echo $_SESSION["id"]?>">

<?php
    $action="getFavNotes";
    $userId=$_SESSION["id"];
    $count=0;
    $stmt = $conn->prepare('call USP_GET_FAV_NOTES(?,?)');
    $stmt->bindParam(1, $action);
    $stmt->bindParam(2, $userId);
    $stmt->execute();
?>

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

    <div class="main center-box notes-box">
        <?php
                        foreach ($stmt->fetchAll() as $res) {
                    ?>
            <div class="col-md-12 box-container-for-notes">
            <h4 id="<?php echo $res['INT_NOTES_ID']?>" class="dropdown ddlSmallTable h4style" onclick="openfilelist(this)">
            <span class="fa fa-book"></span>&nbsp;
                        <?php echo $res['VCH_TITLE']?>
                                <span class="ddlSmallTable">
                                    <div class="dropdown-content" id="dropdown-content">
                                    <span class="closeSmTable">&times;</span>
                                        <table class="table tbl-notes-files" id="tableAllNotes">
                                            <tr><td>Link 1 </td></tr>
                                            <tr><td>Link 1 </td></tr>
                                            <tr><td>Link 1 </td></tr>
                                        </table>
                                    </div>
                                </span>
                                
                            </h4>

                        <div class="box-desc">
                                <?php echo $res['VCH_DESCRIPTION'] ?>
                                </div>
                                <hr class="hr-style">
                            <div class="box-notes-details">
                                <span>3 hours ago - </span>
                                <span class="notes-sub label label-default "> <?php echo $res['VCH_USER_NAME'] ?></span>&nbsp;
                                <span class="notes-uni label label-default "><?php echo $res['VCH_UNIVERSITY_NAME'] ?> </span>&nbsp;
                                <span class="notes-coll label label-default"><?php echo $res['VCH_COLLEGE_NAME']?></span>&nbsp;
                                <span class="notes-deg label label-default "> <?php echo $res['VCH_DEGREE_NAME'] ?></span>&nbsp;
                                <span class="notes-sub label label-default "> <?php echo $res['VCH_SUB_NAME'] ?> </span>&nbsp;
                                <span class="notes-sem label label-default "> <?php echo $res['VCH_SEMESTER'] ?></span>&nbsp;
                            </div>
                            <div class="box-next-line">

                            <span 
                            data-id="<?php echo "fav-".$res['INT_NOTES_ID'] ?>"
                            <?php if($res['IS_USER_FAV']==1){   ?>
                           
                            class="fa fa-star icon-left fav-btn"
                           <?php }
                           else{ ?>
                                class="fa fa-star-o icon-left fav-btn"  
                           <?php } ?>
                            >
                            </span>
                            &nbsp;
                           <!--<span class="label label-default lbllike">-->
                                <i
                           <?php if($res['IS_USER_LIKE']==1){   ?>
                            class="fa fa-thumbs-up icon-left like-btn"
                           <?php }
                           else{ ?>
                                class="fa fa-thumbs-o-up icon-left like-btn"   
                           <?php } ?>
                           data-id="<?php echo $res['INT_NOTES_ID'] ?>" ></i>
                           <span id="<?php echo "likecnt".$res['INT_NOTES_ID'] ?>"  class="likes" ><?php echo $res['TOTAL_LIKE'] ?>
                        </span>
                   <!-- </span>-->
                    &nbsp;
                           <!--<span class="label label-default lbldislike">-->
                                <i 
                          
                           <?php if($res['IS_USER_DISLIKE']==1){   ?>
                            class="fa fa-thumbs-down icon-left dislike-btn"
                           <?php }
                           else{ ?>
                                class="fa fa-thumbs-o-down icon-left dislike-btn"   
                           <?php } ?> 
                           data-id="<?php echo $res['INT_NOTES_ID'] ?>"></i>
                           <span id="<?php echo "dislikecnt".$res['INT_NOTES_ID'] ?>" class="dislikes"><?php echo $res['TOTAL_DISLIKE'] ?></span></span>&nbsp;
                           <span data-id="<?php echo "download-".$res['INT_NOTES_ID'] ?>" 
                           data-toggle="tooltip" title="Click here to download"
                           class="fa fa-download icon-right download">
                           <!-- </span>-->
                            &nbsp;
                        </div>
                        </div>
            <?php } //end of loop.. ?>
    </div>
</form>
</body>
<script src="js/jscodeforlikedislike.js"></script>
            <script src="js/notify.min.js"></script>
<script>
    $(document).ready(function(){
		
		$("#userProfile").removeClass("activeSideBarLink");     // adding active class so that the like of the page in which the user
        $("#userMyUploads").removeClass("activeSideBarLink");     //  is currently will   
        $("#userFavourites").addClass("activeSideBarLink");     // highlited,
        $("#userUpload").removeClass("activeSideBarLink");     //  and unhighliting the other links..
		
        $("#container").attr('style', 'display:none');
        //getFavNotes();
    });

    /*function getFavNotes(){
        $("#container").removeAttr('style');   //displaying the loading circles..
                var trStart='<tr>';
				var trEnd='</tr>';                   
                var flag='getFavNotes';
                var userId=$('#hiddenUserId').val();
                $.ajax({	
				    type:"POST",
				    url:"callServiceSearchNotes.php",
				    dataType: "json",
				    data:{action:flag,userid:userId},
				    success:function(data){
                        $('#tblFavNotes').empty();
                        if(data=='empty'){                           
                            $('#tblFavNotes').append(
                                trStart+'<td colspan="2" >No data present..</td>'+trEnd
                            );
                            $("#container").attr('style', 'display:none');     //removing the loading circles..
                        }
                        else{                            
					        $.each(data, function(i, item) {
						    $('#tblFavNotes').append( )
        	                });
                            $("#container").attr('style', 'display:none');     //removing the loading circles..
                        }
			    }
		});
    }*/

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

        function userFavSub(args){
            var id=args.id;
            var val=document.getElementById(id);
            var check=confirm('Please confirm')
            if(check){
                var notesId=id.substring(3);
                var userId=$("#hiddenUserId").val();
                var flag="userFavNotes";
                $.ajax({
                    method:"POST",
                    url:"callServiceSearchNotes.php",
                    dataType:"json",
                    data:{action:flag,userid:userId,notesid:notesId},
                    success:function(data){
                        if(data=='done'){
                            getFavNotes();
                        }
                        else{
                            window.location.replace('error.html');
                        }
                    }
                });
            }
            else{
                return false; 
            }                
        }

        //function for like 
$('.like-btn').on('click',function(){
  var data=  $(this).data('id');
  var clicked=$(this);
  
 <?php
 
  if(isset($_SESSION["id"])){

      echo "getLikedLogic(data,".$_SESSION["id"].",clicked);";
    ?>
    
    <?php
  }
  else{?>
$('#myModal').show();
 <?php }
    ?>
});

//function for dislike 
$('.dislike-btn').on('click',function(){
  var data=  $(this).data('id');
  var clicked=$(this);
  
 <?php
 
  if(isset($_SESSION["id"])){

      echo "getdisLikedLogic(data,".$_SESSION["id"].",clicked);";
    ?>
    
    <?php
  }
  else{?>
$('#myModal').show();
 <?php }
    ?>

});
//function for fav
$('.fav-btn').on('click',function(){
  var data=  $(this).data('id');
  var clicked=$(this);
 <?php
  if(isset($_SESSION["id"])){
      echo "getfavLogic(data,".$_SESSION["id"].",clicked);";
    ?>
    <?php
  }
  else{?>
$('#myModal').show();
 <?php }
    ?>  
});
//function for fav
$('.download').on('click',function(){
  var data=  $(this).data('id');
  var clicked=$(this);
  
 <?php
 
  if(isset($_SESSION["id"])){

      echo "getdownloadLogic(data,".$_SESSION["id"].",clicked);";
    ?>
    
    <?php
  }
  else{?>
$('#myModal').show();
 <?php }
    ?>
});


</script>

</html>