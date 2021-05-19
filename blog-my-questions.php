<?php 
include("index.incOther.php");
if(isset($_SESSION["id"]) && $_SESSION["roleId"]==2){

?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="css/style-my-questions.css" rel="stylesheet">
        <link href="css/loader.css" rel="stylesheet">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body>

        <!--========hidden fields are use to store the value of user university and college id==========-->
        <input type="hidden" id="hiddenUserUniId" value="<?php echo $_SESSION["uniId"] ?>">
        <input type="hidden" id="hiddenUserCollId" value="<?php echo $_SESSION["collId"]?>">
        <input type="hidden" id="hiddenUserId" value="<?php echo $_SESSION["id"]?>">
        
        <div class="main-content">
        <!--========== tab starting ==========-->
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#notLiveQues">Not live</a></li>
            <li><a data-toggle="tab" href="#liveQues">Live</a></li>
            <li><a data-toggle="tab" href="#rejectedQues">Rejected</a></li>
        </ul>

        <div class="tab-content">

            <div id="notLiveQues" class="tab-pane fade in active">
                <h3>Not live questions</h3>
                <table class="table table-responsive">
                    <thead class="tblNotLiveHead" > 
                        <th>Question title</th>
                        <th>Question description</th>
                        <th>Category</th>
                        <th>University</th>
                        <th>College</th>
                        <th>Degree</th>
                        <th>Subject</th>
                    </thead>

                    <tbody class="tblNotLiveBody" id="tblNotLiveBody">

                    </tbody>
                </table>
            </div>

            <div id="liveQues" class="tab-pane fade">
                <h3>Live</h3>
                <table class="table table-responsive">
                    <thead class="tblLiveHead" > 
                        <th>Question title</th>
                        <th>Question description</th>
                        <th>Category</th>
                        <th>University</th>
                        <th>College</th>
                        <th>Degree</th>
                        <th>Subject</th>
                        <th>Action</th>
                    </thead>

                    <tbody class="tblLiveBody" id="tblLiveBody">

                    </tbody>
                </table>
            </div>

            <div id="rejectedQues" class="tab-pane fade">
                <h3>Rejected</h3>
                <table class="table table-responsive">
                    <thead class="tblClosedHead" > 
                        <th>Question title</th>
                        <th>Question description</th>
                        <th>Category</th>
                        <th>University</th>
                        <th>College</th>
                        <th>Degree</th>
                        <th>Subject</th>
                        <th>Action</th>
                    </thead>

                    <tbody class="tblClosedBody" id="tblClosedBody">

                    </tbody>
                </table>
            </div>

        </div>
        </div>
        <!--========== tab ending ==========-->
        <?php  }
   else{
        echo "<script type='text/javascript'>window.top.location='index.php';</script>";
   } ?>
    </body>
    <script>
        $(document).ready(function(){
            var flagNotLive='getNotLiveQues';
            var flagLive='getLiveQues';
            var flagRejQues='getRejQues';
            $.ajax({                                //binding data into not live table
                method:"post",
                url:"callServiceBlogData.php",
                dataType:"json",
                data:{action:flagNotLive},
                success:function(data){
                    $("#tblNotLiveBody").empty();
                    $.each(data, function(i, item) {
                        $("#tblNotLiveBody").append('<tr> <td>'+data[i].quesTitle+'</td> <td>'+data[i].quesDesc+'</td> <td>'+data[i].quesCateg+'</td> <td>'+data[i].quesUni+'</td> <td>'+data[i].quesColl+'</td> <td>'+data[i].quesDeg+'</td> <td>'+data[i].quesSub+'</td> </tr>');
                    });
                }
            });

            $.ajax({                                  //binding data into live table
                method:"post",
                url:"callServiceBlogData.php",
                dataType:"json",
                data:{action:flagLive},
                success:function(data){
                    $("#tblLiveBody").empty();
                    $.each(data, function(i, item) {
                        $("#tblLiveBody").append('<tr> <td>'+data[i].quesTitle+'</td> <td>'+data[i].quesDesc+'</td> <td>'+data[i].quesCateg+'</td> <td>'+data[i].quesUni+'</td> <td>'+data[i].quesColl+'</td> <td>'+data[i].quesDeg+'</td> <td>'+data[i].quesSub+'</td> <td> <input type="submit" class="btn btn-sm btn-default" id="'+data[i].quesId+'" value="Close"> <input type="submit" id="'+data[i].quesId+'" class="btn btn-sm btn-default" value="Edit"> </td> </tr>');
                    });
                }
            });

            $.ajax({                                    //binding data into rejected table
                method:"post",
                url:"callServiceBlogData.php",
                dataType:"json",
                data:{action:flagRejQues},
                success:function(data){
                    $("#tblClosedBody").empty();
                    $.each(data, function(i, item) {
                        $("#tblClosedBody").append('<tr> <td>'+data[i].quesTitle+'</td> <td>'+data[i].quesDesc+'</td> <td>'+data[i].quesCateg+'</td> <td>'+data[i].quesUni+'</td> <td>'+data[i].quesColl+'</td> <td>'+data[i].quesDeg+'</td> <td>'+data[i].quesSub+'</td> </tr>');
                    });
                }
            });

        });
    </script>
</html>