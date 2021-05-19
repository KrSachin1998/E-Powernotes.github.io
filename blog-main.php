<?php 
include("index.incOther.php");
?>
<!DOCTYPE html>
<html>
    <head>
    <link href="css/loader.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/style-blog-main.css" rel="stylesheet">
    </head>
    <body>
        <div class="blog-area">
        <div class="input-group">
            <input type="email" class="form-control" size="50" placeholder="What are you looking for ?" required>
                <div class="input-group-btn">
                    <button type="button" class="btn btn-danger" id="btnSearchBlog">Search</button>
                    <input type="submit" class="btn btn-default" value="Filter" id="btnQuestionFilter">
                </div>
        </div>
        
        <!--========= button group starts ==========-->
        <div class="btn-group" id="btnGroupOfUserAction">
            <button type="button" class="btn btn-default">FAQ</button>
            <button type="button" onclick="document.location.href='blog-my-questions.php';" class="btn btn-default">My questions</button>
            <button type="button" class="btn btn-default">My answers</button>
            <button type="button" onclick="document.location.href='blog-ask-question.php';" class="btn btn-default">Ask a question</button>
        </div>

        <!--========= button group ends ==========-->
        
        <!--======= showing questions starts ========-->
        <h3>Top questions</h3>
        <div class="col-md-12 box-container-for-notes">
            <h4 id="" class="h4style">This is title </h4>

            <div class="box-desc">this is desc</div>
            <hr class="hr-style">
            <div class="box-notes-details">
                <span></span>
                <span class="notes-sub label label-default ">hello </span>&nbsp;
                <span class="notes-uni label label-default ">hello </span>&nbsp;
                <span class="notes-coll label label-default">hello </span>&nbsp;
                <span class="notes-deg label label-default ">hello </span>&nbsp;
                <span class="notes-sub label label-default ">hello </span>&nbsp;
                <span class="notes-sem label label-default ">hello </span>&nbsp;
            </div>
            <div class="box-next-line">
                
            </div>
        </div>
        <!--========= showing question ends ========-->
        </div>
    </body>
    <script>
        $("#userProfile").removeClass("activeSideBarLink");     // adding active class so that the like of the page in which the user
        $("#userMyUploads").removeClass("activeSideBarLink");     //  is currently will   
        $("#userFavourites").removeClass("activeSideBarLink");     // highlited,
        $("#userUpload").removeClass("activeSideBarLink");     //  and unhighliting the other links..
        $("#highschoolsBlog").addClass("activeSideBarLink");
    </script>
</html>