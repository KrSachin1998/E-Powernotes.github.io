<?php
    include('login.inc.php');
    //require_once "login.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>w3jobs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link href="css/style-w3jobs.css" rel="stylesheet">

</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#myPage">w3jobs</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a id="myBtn">Login</a></li>
        <li><a href="user-registration.php">Sign up</a></li>
        <li><a href="#jobs">Jobs</a></li>
        <li><a href="#contact">Contact us</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>w3jobs</h1>  
  <form>
    <div class="row job-search-row">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="keyword">
            <span class="help-text">Eg: php developer, UI designer</span>
        </div>

        <div class="form-group">
            <select class="form-control" id="ddlSearchCourse">
                <option value="0" selected>==Select Course==</option>
                <option value="1">BCA</option>
                <option value="2">BBA</option>
                <option value="3">BSC IT</option>
            </select>
        </div>

        <div class="form-group">
            <select class="form-control" id="ddlSearchPlace">
                <option value="0" selected>==Select Place==</option>
                <option value="1">Jamshedpur</option>
                <option value="2">Ranchi</option>
                <option value="3">Patna</option>

            </select>
        </div>

        <div class="form-group">

            <select class="form-control" id="ddlSearchExperience">
                <option value="0" selected>==Select Experience==</option>
                <option value="1">0</option>
                <option value="2">06 months</option>
                <option value="3">1 year</option>
                <option value="4">2 years</option>
            </select>
        </div>

        <div class="form-group">
            <select class="form-control" id="ddlSearchExpe">
                <option value="0" selected>==Select Job Type==</option>
                <option value="1">Part time</option>
                <option value="2">Full time</option>
                <option value="3">Contract</option>
            </select>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-default" value="Search">
        </div>

    </div>
  </form>
</div>

<!-- Container (jobs Section) -->
<div id="jobs" class="container-fluid">
  <div class="row">

    <div class="col-sm-2 company-list">
      <h4>Companies</h4>
      <a href="#">TCS</a>
      <a href="#">Infosys</a>
      <a href="#">Wipro</a>
      <a href="#">HCL</a>
    </div>

    <div class="col-sm-8 jobs-bind">
      <div class="job-data">
          <h4>Featured Jobs</h4>

          <div class="jobs">
              <h5>This is first job</h5>
              <h6>description description description description description..</h6>
              <div class="job-details">
                <label class="label">
                    <i class='uil uil-eye details-left'></i>256
                </label>

                <label class="label">
                    <i class='uil uil-location-point details-left'></i>kolkata
                </label>

                <label class="label">
                    <i class='uil uil-wallet details-left'></i>20000-250000
                </label>
                
                <label class="label pull-right">
                    posted by mehul sharma 12-02-2019
                </label>

              </div>
          </div>

          <div class="jobs">
              <h5>This is first job</h5>
              <h6>description description description description description..</h6>
              <div class="job-details">
                <label class="label">
                    <i class='uil uil-eye details-left'></i>256
                </label>

                <label class="label">
                    <i class='uil uil-location-point details-left'></i>kolkata
                </label>

                <label class="label">
                    <i class='uil uil-wallet details-left'></i>20000-250000
                </label>
                
                <label class="label pull-right">
                    posted by mehul sharma 12-02-2019
                </label>

              </div>
          </div>

      </div>
    </div>

    <div class="col-sm-2 recent-jobs">
        <h4>Recent Jobs</h4>
        <a href="#">Php developer needed post for web designer</a>
        <a href="#">post for web designer</a>
        <a href="#">position for hr is empty</a>
        <a href="#">limited seats hurry up</a>
    </div>

  </div>
</div>


<footer class="container-fluid text-center footer">
  <a href="#myPage" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
  <p>Bootstrap Theme Made By <a href="https://www.w3schools.com" title="Visit w3schools">www.w3schools.com</a></p>
</footer>

<script>
$(document).ready(function(){
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
  
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });
})
</script>

</body>
</html>
