<html>
    <body>
        <form method="POST" action="<?php ($_SERVER["PHP_SELF"])?>">
            <input type="submit" name="btnSendEmail" value="Send Mail">
        </form>
    </body>
    <?php
        if(isset($_POST["btnSendEmail"])){
            $message="this is mail is to test the php server";
            $headers="From:mehulsharma1714@gmail.com";
            mail("oncodeproject@gmail.com","testing",$message,$headers);
            echo "mail send successfully";
        }
    ?>
</html>