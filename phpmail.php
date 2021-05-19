<?php
$to = "ovihosting@gmail.com" ;
$subject = "I am testing now , plz allow";
$body = "i am testing now, plz allow" ;
if (mail($to, $subject, $body)) {
  echo("<p>Email successfully sent!</p>");
 } else {
  echo("<p>Email delivery failed?</p>");
 }
?>