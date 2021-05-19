<?php
 include("core/connpdo.php");
 include("app_code/sqlhelper.php");
 include("app_code/configmgr.php");
require_once 'mailer/vendor/autoload.php';
//begin of try..
 try {    
     //isset is mendatory for all code
    if (isset($_POST["action"])) {

function test_input($data)
{             //server side validation of email and name..
    $restoreEmail = $data;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($data != $restoreEmail) {
        echo 3;
        die();
    }
    return $data;
}
function sendMail($message,$displayName,$subject,$userName,$userEmail){
	// Create the Transport
				$transport = (new Swift_SmtpTransport('mail.housingon.in', 25))
                ->setUsername('notification@w3highschools.com')
                ->setPassword('1@Gomail#');
                // Create the Mailer using your created Transport
                $mailer = new Swift_Mailer($transport);

                // Create a message
                $message = (new Swift_Message($displayName))
                ->setFrom(['notification@w3highschools.com' => 'w3highschools'])
                ->setTo([$userEmail => $userName])
                ->setSubject($subject)
                ->setBody($message);

                // Send the message
                $result = $mailer->send($message);
}
        if ($_POST["action"] == "college") {
            $flag = 'C';
            $id = $_POST["id"];
            $stmt = $conn->prepare('call USP_REGISTRATION_DATA(?,?)');
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $flag);
            $stmt->execute();
            foreach ($stmt->fetchAll() as $res) {
                $arr[] = array(
                    'colId' => $res['INT_COLL_ID'],
                    'colName' => $res['VCH_COLLEGE_NAME']
                );
            }
            echo json_encode($arr);
        }

       

        if ($_POST["action"] == "ddlUniv") {
            $flag = 'U';
            $id = '';
            $stmt = $conn->prepare('call USP_REGISTRATION_DATA(?,?)');
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $flag);
            $stmt->execute();
            foreach ($stmt->fetchAll() as $res) {
                $arr[] = array(
                    'unId' => $res['INT_UNI_ID'],
                    'unName' => $res['VCH_UNIVERSITY_NAME']
                );
            }
            echo json_encode($arr);
        }

        if ($_POST["action"] == "registerUser") {
            $flag = "registerUser";
            $userName = test_input($_POST["name"]);
            $userEmail = test_input($_POST["email"]);
            $userPass = $_POST["password"];
            $userUni = $_POST["university"];
            $userCol = $_POST["college"];
            $userRole = 2;

            /*============== =========
            server side validation of registration starts..
            =========================== */
            if ($userName == '' || $userEmail == '' || $userPass == '' || $userUni == '' || $userUni == 0 || $userCol == '' || $userCol == 0) {
                echo 3;
                die();          //dying the further process if validation fails..
            } else {
                // check if e-mail address is well-formed
                if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                    echo 3;
                    die();        //dying the further process if validation fails..
                }
            }

            /*============== =========
            server side validation registration ends..
            =========================== */

            $stmt = $conn->prepare('call USP_USER_REGISTER(?,?,?,?,?,?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $userName);
            $stmt->bindParam(3, $userEmail);
            $stmt->bindParam(4, $userPass);
            $stmt->bindParam(5, $userUni);
            $stmt->bindParam(6, $userCol);
            $stmt->bindParam(7, $userRole);
            $stmt->execute();
            foreach ($stmt->fetchAll() as $res) {
                $cnt = $res["count"];
            }
            if ($cnt == 1) {
                echo $cnt;
            } else {
                //sending mail to the user account..
                /*$message="this mail is to test the php server ";
                $message.="http://localhost/notebook/activate-user.php?activateId=".$cnt;
                //$message.="http://enotebook.vscom.tech/activate-user.php?userId=".$cnt;
                $headers="From:mehulsharma1714@gmail.com";
                mail($userEmail,"testing",$message,$headers);*/
				
				$message=" 
                Dear ".$userName.",
                Your email account ".$userEmail." is pending for activation.
                Click Here to activate your account,";
                 $configmgr=new configmgr();
                 $returnUrl= $configmgr-> activatelinkurl();

                $encCnt= $configmgr->forEncrypt($cnt);
                $message.=$returnUrl.$encCnt ;
                $configmgr=null;
				sendMail($message,$displayName,$subject,$userName,$userEmail);
				
            }
        }    

function foruseractivityafterlogin($conn,$action,$userId,$notesId){
   
    $stmt = $conn->prepare('call USP_LIKE_DISLIKE_NOTES(:action,:notesId,:userId)');
    $stmt->bindParam(':action', $action);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':notesId', $notesId);
  $isinserted=  $stmt->execute(); 
}


        //coding for login..
        if ($_POST["action"] == "userLogin") {
            $email = $_POST["userEmail"];
            $password = $_POST["userPass"];
            

            /*============== =========
            server side validation of login starts..
            =========================== */
            if (empty($email)) {
                echo 3;
                die();          //dying the further process if validation fails..
            } else {
                $userEmail = test_input($email);
                // check if e-mail address is well-formed
                if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                    echo 3;
                    die();        //dying the further process if validation fails..
                }
            }
            if (empty($password)) {
                echo 3;
                die();          //dying the further process if validation fails..
            }
            /*============== =========
            server side validation of login ends..
            =========================== */

            $stmt = $conn->prepare('call USP_USER_LOGIN(?,?)');
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $password);
            $stmt->execute();
            foreach ($stmt->fetchAll() as $res) {
                $msg = $res["data"];
            }
            if ($msg == '0') {
                echo 0;
            } elseif ($msg == '1') {
                echo 1;
            } else {
                $userId=$res["id"]; 
                $role=$res["role"];
                $collegeId=$res["collId"];
                $universityId=$res["uni"];
                //now user can see first page of his/her account
                session_start();
                $_SESSION["roleId"]=$role;                     //session of user role
                $_SESSION["name"]=$msg;                        //session of user name
                $_SESSION["email"]=$email;                     //session of user email
                $_SESSION["id"]=$userId;                       //session of user id
                $_SESSION["uniId"]=$universityId;               //session of university id of user
                $_SESSION["collId"]=$collegeId;   
                $_SESSION["loggedAt"]= time();             //session of college id of user
                if($_SESSION["roleId"]==2){
                    echo 2; 
                }
                else if($_SESSION["roleId"]==1){
                    echo 4;
                }
                //code added by vivek kr sahu for maintaining the state of user action
                if(!empty($_POST["stateData"])){                
                 $maintainState= explode ("-", $_POST["stateData"]);
                
                    //openfilelist
                    $methodToExecute="";
                    if($maintainState[0]!='forDownloading'){
                       
                       $stmt=null;
                        foruseractivityafterlogin($conn,$maintainState[2],$_SESSION["id"],$maintainState[1]);
                        if($maintainState[2]=="fav"){
                            $methodToExecute='showNotification(1,"Post Added to Favourites","right");';
                        }
                        else if($maintainState[2]=="unfav"){
                            $methodToExecute='showNotification(1,"Post Removed from Favourites","right");';
                        }
                        else if($maintainState[2]=="dislike"){
                            $methodToExecute=' showNotification(1,"You have dislike the Post","right");';
                        }
                        else if($maintainState[2]=="undislike"){
                            $methodToExecute='showNotification(1,"You have removed dislike","right");';
                        }
                        else if($maintainState[2]=="like"){
                            $methodToExecute=' showNotification(1,"You have like the Post","right");';
                        }
                        else if($maintainState[2]=="unlike"){
                            $methodToExecute='showNotification(1,"You have removed like","right");';
                        }
                  
                  
                    }
                    else{
                        $methodToExecute= $maintainState[0]."(".$maintainState[1].")";
                    }
                    $_SESSION["stateData"]=$methodToExecute;
                }
            }
        }
		
		if($_POST["action"]=="checkUserEmail"){         //this will send an email to the user for password recovery
            $action="checkUserEmail";
            $useremail=$_POST["email"];
            $stmt=$conn->prepare('call USP_CHECKUSER_EMAIL(?,?)');
            $stmt->bindParam(1, $action);
            $stmt->bindParam(2, $useremail);
            $stmt->execute();
            foreach ($stmt->fetchAll() as $res) {
                    $checkEmail=$res['count'];
            }
            if($checkEmail==1){
                //send password recovery link to the mail..
				$subject="Forget Password Link";
				$displayName="Forgot Password Request";
                //$message="this mail is to test the forget password";
                //$message.="http://localhost/notebook/activate-user.php?activateId=".$cnt;
              //  $message.='http://enotebook.vscom.tech/forget-password.php?useremail='.$useremail ;
              //  $headers="From:mehulsharma1714@gmail.com";
               // mail($userEmail,"testing",$message,$headers);
				$message=" 
                Dear User,
                You have raise request for password change.
                Click Here to change password.
				
                ";
                $configmgr=new configmgr();
                $returnUrl= $configmgr-> forgetemailLink();
              
               $encMail= $configmgr->forEncrypt($useremail);
                     $configmgr=null;

                $message.=$returnUrl.$encMail ;
				$message.='
				
				
				**Please Ignore if you have not raise this request!!
				';
				
				$username="User";
				
					sendMail($message,$displayName,$subject,$username,$useremail);
                echo 1;
            }
            else{
                echo 0;   
            }
        }

        if($_POST["action"]=="contactUs"){         //modified by mehul 22-05-2019..
            $action="contactUsEmail";                   // to contact us ...
            $userEmail=$_POST["email"];
            $mailTo="";
            $mailFrom="";       //use this variables only..
            $mailBody="";       //because i had used them in procedure..
            $mailStatus=0;      //default status will be 0.
            $mailModule="";

                //send mail here...
            //if mail has been send update $mailStatus=1 else leave it.

            //now inserting in table.. 
            
            // [PLEASE UNCOMMENT THE BELOW CCODE TO INSERT INTO THE DATABASE ONCE YOU SEND THE MAIL]

            /*$stmt=$conn->prepare('call USP_INSERT_MAILSEND(?,?,?,?,?,?,?)');
            $stmt->bindParam(1,$action);
            $stmt->bindParam(2,$mailTo);
            $stmt->bindParam(3,$mailFrom);
            $stmt->bindParam(4,$mailBody);
            $stmt->bindParam(5,$mailStatus);
            $stmt->bindParam(6,$mailModule);
            $stmt->bindParam(7,$userEmail);
            foreach ($stmt->fetchAll() as $res) {
                $result=$res['count'];
            }

            if($result==1){
                echo 1;             //mail sent successfully
            }
            else{
                echo 0;             //unsuccessfull..
            }   */
            
            echo 1;     //when you implement real code delete this line..

        }
		
		if($_POST["action"]=="updatePassword"){
            $email=$_POST["useremail"];
            $action="updatePassword";
            $newpass=$_POST["newpassword"];
            $stmt = $conn->prepare('call USP_FORGET_PASSWORD(?,?,?)');
            $stmt->bindParam(1, $action);
            $stmt->bindParam(2, $email);
            $stmt->bindParam(3, $newpass);
            $stmt->execute();
            foreach ($stmt->fetchAll() as $res) {
                $msg = $res["data"];
            }
            if($msg==1){
                echo 'success';
            }
            else{
                echo 'failed';
            }
        }
		 
		if($_POST["action"]=="getUserImage"){
            $action="getUserImage";
            $userId=$_POST["userid"];
            $stmt = $conn->prepare('call USP_GET_USERIMAGE(?,?)');
            $stmt->bindParam(1, $action);
            $stmt->bindParam(2, $userId);
            $stmt->execute();
            foreach ($stmt->fetchAll() as $res) {
                $arr['userName']=$res['VCH_USER_NAME'];
                $arr['userprofile']=$res['VCH_PROFILE_NAME_PATH'];
            }
            echo json_encode($arr);
        }

        //modified by mehul 21-05-2019..
        if($_POST["action"]=="resendActiLink"){         //resend acctivation link 
            $action="resendActiLink";   
            $useremail=$_POST["userEmail"];
            $stmt=$conn->prepare('call USP_CHECKUSER_EMAIL(?,?)');  //first checking email is present or not
            $stmt->bindParam(1, $action);
            $stmt->bindParam(2, $useremail);
            $stmt->execute();
            foreach ($stmt->fetchAll() as $res) {
                    $checkEmail=$res['count'];
            }

            if($checkEmail==1){
                //send email 
                echo 1;
            }
            else{
                //email is not register with us..
                echo 0;
            }

        }

        if($_POST["action"]=="changePass"){         //code added by sachin to change password..
            session_start();                        //01-05   
            $userId=$_SESSION["id"];
            $newPass=$_POST["newPassword"];
            $oldPass=$_POST["oldPassword"];
            $stmt=$conn->prepare('call USP_CHANGE_PASSWORD(?,?,?)');  //first checking email is present or not
            $stmt->bindParam(1, $userId);
            $stmt->bindParam(2, $oldPass);
            $stmt->bindParam(3, $newPass);
            $stmt->execute();
            foreach ($stmt->fetchAll() as $res) {
                    $check=$res['cnt'];
            }
            echo $check;
            /*if($check==1){
                echo json_encode('done');
            }
            else if($check==0){
                echo json_encode('notMatching');
            }
            else{
                echo json_encode('error');
            }*/
        }
		
    }	//end of isset
    else{
        header('Location: logout.php');
    }
}       //end of try..
catch (Exception $e) {
    $desc=$e->getMessage();
    $lineNo=$e->getLine();
    $pageName=$e->getFile();
    $sqlhelp = new SqlHelper();
    $sqlhelp->insertdbLog($conn,$desc,$lineNo,$pageName);
    $sqlhelp=null;
    echo json_encode('error');
}


?>