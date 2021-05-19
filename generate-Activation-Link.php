<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="js/jquery.js"></script>
        <link href="css/loader.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="css/style-resend-activation.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
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

        <div class="container resend-box">
            <div class="row">
                <div class="col-sm-4"></div>
                <div class="col-sm-4 data-box">
                    <h5>Enter your email to resend activation link</h5>
                    <div class="container" id="message-box">
                        
                    </div>
                    <input type="text" class="form-control" id="txtUserEmail">
                    <input type="submit" class="btn btn-sm btn-default" id="btnResendActivation" onclick="resendActivationLink()" value="Submit">
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
    </body>
</html>

<script>
    $(document).ready(function(){
        $("#container").attr('style', 'display:none');  //removing the loading screen when screen loads completely..
    });

    function resendActivationLink(){
        var email=$("#txtUserEmail").val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(email.trim()==""){
            $("#txtUserEmail").val('');
            $("#txtUserEmail").attr('placeholder','* Enter your email');
            $("#txtUserEmail").css('border','1px solid red');
        }
        else if(!regex.test(email)){
            $("#txtUserEmail").val('');
            $("#txtUserEmail").attr('placeholder','* Enter valid email');
            $("#txtUserEmail").css('border','1px solid red');
        }
        else{
            $("#container").removeAttr('style');   //displaying the loading circles..
            var flag="resendActiLink";
            $.ajax({
                url:"callServiceRegLogin.php",
                method:"post",
                data:{action:flag,userEmail:email},
                success:function(data){
                    if(data==1){
                        $("#message-box").html('<h5>Activation link has been sent</h5>');
                        $("#txtUserEmail").val('');
                    }
                    else if(data==0){
                        $("#message-box").html('<h5>Email not registered with us</h5>');
                    }
                    $("#container").attr('style', 'display:none');      //removing the loading circles..
                }
            });
        }
    }

</script>
