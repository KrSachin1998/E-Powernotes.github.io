<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" rel="stylesheet">    
    <link href="css/font-awesome.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/style-default.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="lib/animate/animate.min.css" rel="stylesheet" />

    <!-- Main Stylesheet File -->
    <link href="OwlCarousel2-2.3.4/dist/assets/owl.carousel.css" rel="stylesheet" />
    <link href="OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css" rel="stylesheet" />

</head>
<body>
    <div class="header">
        
            <div class="container heading-box">               
                    <h2>Notebook</h2>
                    <span class="social-media-icons">
                        <a href="#"><i class="fa fa-facebook media-icon"></i></a>
                        <a href="#"><i class="fa fa-youtube media-icon"></i></a>
                        <a href="#"><i class="fa fa-twitter media-icon"></i></a>  
                        <a href="#"><i class="fa fa-instagram media-icon"></i></a>
                    </span>                               
            </div>                                           
    </div> 

    <section class="main-body">
        
        <!-----corousel starts------>
        <div class="col-sm-8 image-box">
            
                <div class="container">
                    <div class="section-header">
                    </div>
                    <div id="owl-demo" class="row owl-carousel owl-theme">
                        <div class="item">
                            <img src="images/notebook1.png" alt="Owl Image" />
                            <!--<h4 class="img_heading">kr. sachin</h4>-->
                        </div>
                        <div class="item">
                            <img src="images/notebook2.png" alt="Owl Image" />
                            <!--<h4 class="img_heading">kr. sachin</h4>-->
                        </div>
                        <div class="item">
                            <img src="images/notebook3.png" alt="Owl Image" />
                            <!--<h4 class="img_heading">kr. Sachin</h4>-->
                        </div>                        
                    </div>
                </div>
        </div>
        <!-----corousel ends----->

        <!--------user forms starts---------->
        <div
         class="col-sm-4">
         
            <!--------user login form starts---------->
            <div class="login-form form-horizontal">
                <h2 class="heading-login">Login here <span class="fa fa-lock"></span></h2>
                
                <!--------displaying error or success message starts-------->
                <div class="alert alert-dismissible fade in" id="showMessage">
                    
                </div>
                <!--------displaying error or success messages ends------->

                <div class="form-group">
                    <label class="control-label col-sm-4" id="lblLoginEmail">Email</label>
                    <div class="col-sm-8">
                        <input type="text" id="txtUserLoginEmail" class="form-control">
                    </div>
                </div>
                                
                <div class="form-group">
                    <label class="control-label col-sm-4" id="lblLoginPassword">Password</label>
                    <div class="col-sm-8">
                        <input type="text" id="txtUserLoginPassword" class="form-control">
                    </div>
                </div>
                
                <div class="col-sm-6">
                    <input type="submit" class="btn bnt-default" id="btnLogin" onclick="userLogin()" value="Login">
                </div>
                <div class="col-sm-6">
                    <input type="submit" class="btn bnt-default" id="btnLogin" value="Login with facebook">
                </div>               
            </div>
            <!--------user login form ends---------->


            <div class="col-sm-12">
                <hr>
            </div> 
            <!-------Registration button starts--------->

                <div class="new-registration">
                    <h2 class="heading-newRegistration">New Registration <span class="fa fa-file"></span> </h2>
                </div>
                <div class="container-info">
                    <br>
                    <p>
                     By creating an account with our store, you will be able to move through the
                     checkout process faster, store multiple shipping addresses, view and track
                     your orders in your account and more.
                    </p>
                    <br>
                    <input type="submit" class="btn btn-default" onclick="window.location.href='user-registration.php'" id="btnCreateAnAccount" value="Create An Account">
                </div>

            <!-------Registration button starts--------->
            

        </div>
        <!--------user forms ends---------->
    </section>

    <!--------code for footer starts--------->
    <div class="col-sm-12 footer">
        <div class="container">
            <div class="col-sm-6">
                <h4>A <a href="#"><span class="vscom-badge">V</span>scom</a> Productions</h4>
                <h4><span class="fa fa-copyright"></span> All Right Reserved 2018.</h4>
            </div>
            <div class="col-sm-6">
                <br>
                <br>
                <span>Contact Us</span> || <span>About Us</span>
            </div>
        </div>
        <br>
    </div>
    <!--------code for footer ends--------->
        <!-- JavaScript Libraries -->
        <script src="lib/jquery/jquery.min.js"></script>
        <script src="lib/jquery/jquery-migrate.min.js"></script>
        <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8HeI8o-c1NppZA-92oYlXakhDPYR7XMY"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/superfish/hoverIntent.js"></script>
        <script src="lib/superfish/superfish.min.js"></script>
                <!-- owl js file -->
                <script src="OwlCarousel2-2.3.4/dist/owl.carousel.js"></script>
        <script>
            $(document).ready(function () {
                $("#owl-demo").owlCarousel({
                    autoplay: true,
                    dots: true,
                    loop: true,
                    autoplayTimeout: 3000,
                    animateOut: 'fadeOut',
                    items: 1,
                    responsive: { 0: { items: 1 }, 680: { items: 1 }, 900: { items: 1 }, 1300: { items: 1 } }
                });
            });
        </script>
        <!-- Template Main Javascript File -->
        <script src="js/main.js"></script>
        <!-------login user------->
        <script>
            function userLogin(){ 
                var email= $("#txtUserLoginEmail").val();
                var pass= $("#txtUserLoginPassword").val();
                var flag="userLogin";
                $.ajax({
                    url:"callServiceRegLogin.php",
                    method:"POST",
                    data:{action:flag,userEmail:email,userPass:pass},
                    success:function(data){
                        if(data==0){
                            $("#showMessage").addClass('alert-warning');
                            $("#showMessage").html("<strong><span class='fa fa-exclamation-triangle'></span></strong> Email or Password incorrect <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> ");
                            //$("#removeAlert").html("&times;");
                        }
                        else if(data==1){
                            $("#showMessage").addClass('alert-warning');
                            $("#showMessage").html("<strong><span class='fa fa-exclamation-triangle'></span></strong><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a> Account not activated  <br> <h6>Note: please click on the link sent on your email to activate your account</h6> ");
                            //$("#removeAlert").html('&times;');
                        }
                        else if(data==2){
                            window.location.href = "index-home.php";
                        }
                       
                    }
                });
            }
        </script>
</body>
</html>



