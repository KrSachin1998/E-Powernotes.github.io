<?php
    if(function_exists('mail')) {
    echo "PHP mail() function is enabled";
    }
    else {
    echo "PHP mail() function is not enabled";
    }
	
	
/*	 $from='From: Mail Contact Form <notification@w3highschools.com>';
    $to='vivekkumarsahu14@gmail.com';
    $subject='PHP mail() Test';
    $body='This is a test message sent with the PHP mail function!';
    if(mail($to,$subject,$body,$from)){
        echo 'E-mail message sent!';
    } else {
        echo 'E-mail delivery failure!';
    }*/
	require_once "mail.php";
	
	$from = "vivek Sender <notification@w3highschools.com>";


$to = "Ramona Recipient <vivekkumarsahu14@gmail.com>";

$subject = "Hi!";

$body = "Hi,\n\nHow are you?";



$host = "mail.housingon.in";

//$username = "";

//$password = "";



$headers = array ('From' => $from,


  'To' => $to,

  'Subject' => $subject);

$smtp = Mail::factory('smtp',

  array ('host' => $host,

    'auth' => true));



$mail = $smtp->send($to, $headers, $body);



/*if (PEAR::isError($mail)) {

  echo("<p>" . $mail->getMessage() . "</p>");


 } else {

  echo("<p>Message successfully sent!</p>");

 }*/
	
 ?>