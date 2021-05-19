<?php
//require_once 'core/mailconfig.php';
require_once 'mailer/vendor/autoload.php';

try { 
   // Create the Transport
/*$transport = (new Swift_SmtpTransport('mail.housingon.in', 25))
->setUsername('notification@w3highschools.com')
  ->setPassword('1@Gomail#')
;



// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Wonderful Subject'))
->setFrom(['notification@w3highschools.com' => 'w3highschools'])
->setTo(['vivekkumarsahu14@gmail.com' => 'vivek'])
->setSubject('Activation Link')
->setBody('Here is the message itself')
;

// Send the message
$result = $mailer->send($message);*/
$userEmail="vivekkumarsahu14@gmail.com";
$userName="vivek kumar sahu";
$cnt="4";
/*$message=" <html><body>
                Dear ".$userName.",<br/><br/>                 
                <h4>Thank you for being a valued user of W3highschools.<h4></br>
               <p> Your email account ".$userEmail." is pending for activation.</p> 
                Click Here to activate your account,                
                
                ";
                $message.='
                <table width="100%" cellspacing="0" cellpadding="0">
  <tr>
      <td>
          <table cellspacing="0" cellpadding="0">
              <tr>
                  <td style="border-radius: 2px;" bgcolor="#ED2939">
                      <a href="http://enotebook.vscom.tech/activate-user.php?userId='.$cnt.' target="_blank" style="padding: 8px 12px; border: 1px solid #ED2939;border-radius: 2px;font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #ffffff;text-decoration: none;font-weight:bold;display: inline-block;">
                          Activate your account    
                      </a>
                  </td>
              </tr>
          </table>
      </td>
  </tr>
</table>
                
                
                </body></html>';


                // Create the Transport
$transport = (new Swift_SmtpTransport('mail.housingon.in', 25))
->setUsername('notification@w3highschools.com')
  ->setPassword('1@Gomail#')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Wonderful Subject'))
->setFrom(['notification@w3highschools.com' => 'w3highschools Notifications'])
->setTo(["'".$userEmail."'" => "'".$userName."'"])
->setSubject('Action required on your W3highschools account-'.$userEmail)
//->setBody($message,'text/html')
->addPart($message,'text/html')
;

// Send the message
$result = $mailer->send($message);*/

$message=" 
                Dear ".$userName.",                
                Thank you for being a valued user of w3highschools.
                Your email account ".$userEmail." is pending for activation.
                Click Here to activate your account,                
                
                ";
                $message.='http://enotebook.vscom.tech/activate-user.php?activateId='.$cnt ;
				
				// Create the Transport
				$transport = (new Swift_SmtpTransport('mail.housingon.in', 25))
->setUsername('notification@w3highschools.com')
  ->setPassword('1@Gomail#')
;
// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Activation link'))
->setFrom(['notification@w3highschools.com' => 'w3highschools'])
->setTo([$userEmail => $userName])
->setSubject('Action required on your w3highschools account')
->setBody($message);

// Send the message
$result = $mailer->send($message);
echo $result;


} catch (Exception $e) {
  echo $e->getMessage();
}





?>