/*
=========================================================================================
Author:Vivek Kumar Sahu
License:Freeware
Description:Multiple File Upload

=========================================================================================

*/
function getVariable(divid, fileuploadId) {
  this.input = document.getElementById(fileuploadId);
  this.ul = document.getElementById(divid);

  this.getEventFire = function () {
    bindValue(this.input, this.ul);
  };

}


function bindValue(input, ul) {
  var fileIdCounter = 0;
  var output = [];

  for (var i = 0; i < input.files.length; i++) {
    fileIdCounter++;
    filesToUpload.push({
      files: input.files[i],
      fileId: fileIdCounter

    });
    var removeLink = "<a class=\"removeFile\" href=\"#\" data-fileid=\"" + fileIdCounter + "\"><span class='fa fa-trash-o' style='color:red'></span></a>";

    output.push("<li><i class='fa fa-copy dicon'></i>&nbsp;&nbsp;<strong>", input.files[i].name, "</strong>", "&nbsp; &nbsp; ", removeLink, "</li> ");



  }
  $("#" + ul.id).append(output.join(""));

}

var filesToUpload = [];
$(document).on("click", ".removeFile", function (e) {
  e.preventDefault();
  //var fileName = $(this).parent().children("strong").text();
  var fileId = $(this).parent().children("a").data("fileid");
  // loop through the files array and check if the name of that file matches FileName
  // and get the index of the match
  for (i = 0; i < filesToUpload.length; i++) {
    if (filesToUpload[i].fileId == fileId) {
      //console.log("match at: " + i);
      // remove the one element at the index where we get a match
      filesToUpload.splice(i, 1);

    }
  }

  // remove the <li> element of the removed file from the page DOM
  $(this).parent().remove();
});