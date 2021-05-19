<?php
session_start();
unset ($_session['fb_access_token']);
session_destroy();
header('Location: index.php');
?>