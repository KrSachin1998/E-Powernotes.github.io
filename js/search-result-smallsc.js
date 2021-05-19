// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("btnLoginSmallScreen");

var passPopup=document.getElementById("popup-box");
// Get the <span> element that closes the modal

var span = document.getElementsByClassName("close")[0];

$(btn).click(function(event)
  {
    event.preventDefault(); // cancel default behavior
    modal.style.display = "block";
    
  });

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    passPopup.style.display="none";
  }
}