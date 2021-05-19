function getLikedLogic(data,useridval,clicked)
{
var idval=data;
var actionVal="";

if(clicked.hasClass("fa-thumbs-up")){
    actionVal="unlike";
}
else if(clicked.hasClass("fa-thumbs-o-up")){
    actionVal="like";
}


$.ajax({
    url: "../notebook/callServiceSearchNotes.php",
 //url: "../callServiceSearchNotes.php",
    method: "POST",
    data: {action:actionVal,id:idval,userid:useridval},
     dataType: "json",    
    success: function(data) {
        if(data[0].cmt=="like"){
            clicked.removeClass("fa-thumbs-o-up");
            clicked.addClass("fa-thumbs-up");
            showNotification(idval,"You have like the Post","right");
            
        }
        else if(data[0].cmt=="unlike"){
            clicked.removeClass("fa-thumbs-up");
            clicked.addClass("fa-thumbs-o-up");
            showNotification(idval,"You have removed like","right");
        }
      
       $("#likecnt"+idval).html(data[0].likecnt);
       $("#dislikecnt"+idval).html(data[0].dislikecnt);
      //$('.dislike-btn').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
      clicked.siblings('i.fa-thumbs-down').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
    }
    });



}//end of like function
//function for dislike
function getdisLikedLogic(data,useridval,clicked)
{
var idval=data;
var actionVal="";

if(clicked.hasClass("fa-thumbs-down")){
    actionVal="undislike";
}
else if(clicked.hasClass("fa-thumbs-o-down")){
    actionVal="dislike";
}

//alert(id+' '+userid+''+actionVal);
$.ajax({
    url: "../notebook/callServiceSearchNotes.php",
   //url: "../callServiceSearchNotes.php",
    method: "POST",
    data: {action:actionVal,id:idval,userid:useridval},
     dataType: "json",    
    success: function(data) {
        if(data[0].cmt=="dislike"){
            clicked.removeClass("fa-thumbs-o-down");
            clicked.addClass("fa-thumbs-down");
           
            showNotification(idval,"You have dislike the Post","right");
        }
        else if(data[0].cmt=="undislike"){
            clicked.removeClass("fa-thumbs-down");
            clicked.addClass("fa-thumbs-o-down");
            showNotification("#fav-"+idval,"You have removed dislike","right");
           
        }
        clicked.siblings('span.likes').text(data[0].likecnt);
  		clicked.siblings('span.dislikes').text(data[0].dislikecnt);
        //$("#likecnt"+idval).html(data[0].likecnt);
      // $("#dislikecnt"+idval).html(data[0].dislikecnt);
      //$('.like-btn').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
      clicked.siblings('i.fa-thumbs-up').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
    
    }
    });

  
}//end of dislike function

  //function for fav
  function getfavLogic(data,useridval,clicked)
  {
     var arr= data.split('-');
  var idval=arr[1];
  var actionVal="";
  
  if(clicked.hasClass("fa-star")){
      actionVal="unfav";
  }
  else if(clicked.hasClass("fa-star-o")){
      actionVal="fav";
  }
  
  //alert(id+' '+userid+''+actionVal);
  $.ajax({
      //url: "../notebook/callServiceSearchNotes.php",
      url: "../notebook/callServiceSearchNotes.php",
      method: "POST",
      data: {action:actionVal,id:idval,userid:useridval},
       dataType: "json",    
      success: function(data) {
          if(data[0].cmt=="fav"){
              clicked.removeClass("fa-star-o");
              clicked.addClass("fa-star");
              showNotification("#fav-"+idval,"Post Added to Favourites","right");
              
          }
          else if(data[0].cmt=="unfav"){
              clicked.removeClass("fa-star");
              clicked.addClass("fa-star-o");
              showNotification("#fav-"+idval,"Post Removed from Favourites","right");
             
          }
         
      
      }
      });
    }//end of fav function


  //function for download
  function getdownloadLogic(data,useridval,clicked)
  {
     var arr= data.split('-');
  var idval=arr[1];
  var actionVal="";
  
  if(clicked.hasClass("icon-right")){
      actionVal="undownload";
  }
  else if(clicked.hasClass("icon-left")){
      actionVal="download";
  }
  
  //alert(id+' '+userid+''+actionVal);
  $.ajax({
     // url: "../notebook/callServiceSearchNotes.php",
     url: "../callServiceSearchNotes.php",
      method: "POST",
      data: {action:actionVal,id:idval,userid:useridval},
       dataType: "json",    
      success: function(data) {
          if(data[0].cmt=="download"){
              clicked.removeClass("icon-right");
              clicked.addClass("icon-left");
              showNotification("#fav-"+idval,"Downloaded Successfully.","right");
              
          }
         
         
      
      }
      });
    }//end of download function



    function showNotification(showpos,message,positionval){

        $.notify(message, "success",{
            Position: 'bottom'
         

        });
    }//end of notifications