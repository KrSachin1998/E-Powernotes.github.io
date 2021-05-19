<?php
include("index.inc.php");
?>
<html>
<head>
<title></title>
<link href="css/style-leaderboard.css" rel="stylesheet">
<link href="css/loader.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
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

    <div class="container-fluid leaderboard">
        <h3>Leaderboard</h3>
        <hr id="hrBelowHeading" >
        <table class="table table-responsive table-condensed table-hover" id="tblLeaderBoard">
            <thead id="tblLeaderBoardHead">
                <tr>
                    <th>Rank </th> 
                    <th>Name</th>
                    <th>University</th>
                    <th>College</th>
                    <th>Degree</th>
                    <th>Semester</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody id="tblLeaderBoardBody">
            </tbody>
        </table>

        <div class="row note-row">
            <h6>Note: Leaderboard contain details of top 10 users who have maximum points. This points depend upon total no of likes,
                 dislikes and downloads of their notes.
            </h6>
        </div>

    </div>

    <?php 
    include('in-footer.inc.php');
?>

</body>
<script>
$(document).ready(function(){

    //removing the searchbar and search button because index.inc.php is included in this page and i don't want user
    //to search notes here..
    document.getElementById("icon").style.display="block";
    $("#txtSearchBar").remove();
    $("#btnSearch").remove();
    $("#filterButton").remove();
    bindleaderboard();

    /*var flag="triggercalc";
    $.ajax({                    //this will calculate the total like and all to bind data in leaderboard..
        method:"POST",
        url:"callServiceSearchNotes.php",
        data:{action:flag},
        success:function(data){
            bindleaderboard(); 
        }
    });*/
});

function bindleaderboard(){
        var flag="leaderboard";
        $.ajax({                    //this will bind data into the leaderboard..
        method:"POST",
        url:"callServiceSearchNotes.php",
        dataType:"json",
        data:{action:flag},
        success:function(data){
            $("#tblLeaderBoardBody").empty();
            $.each(data, function(i, item) {
                $("#tblLeaderBoardBody").append('<tr> <td><literal id="giveCrown'+i+'"></literal> '+(i+1)+'</td> <td class="tdUserImage" ><img src="'+data[i].profilePath+'" class="img" id="imgLeaderboardUser">'+data[i].userName+'</td><td>'+data[i].uniName+'</td><td>'+data[i].collName+'</td><td>'+data[i].degName+'</td><td>'+data[i].semName+'</td><td>'+data[i].points+'</td>');
                if(i==0){
                    $("#giveCrown0").html('<i id="crownFirst" class="fas fa-crown"></i>');
                }
                if(i==1){
                    $("#giveCrown1").html('<i id="crownSecond" class="fas fa-crown"></i>');
                }
                if(i==2){
                    $("#giveCrown2").html('<i id="crownThird" class="fas fa-crown"></i>');
                }
            });

            $("#container").attr('style', 'display:none'); //removing the loading circles..

        }
    });
    }

</script>
</html>