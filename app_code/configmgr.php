<?php
class configmgr 
{

public $param="l";//this flag is for select staging(s),local(l),production(p)

private $secretKey="$#0987weryio";










//configuration code=================================================================

//===============================================================================================================
	function captchKey(){
    $returnCaptchaKey="";
    switch($this->param){
        case 'l'://localhost
        $returnCaptchaKey="6Ldf96EUAAAAALBDgLm4bR_bNunHHkhB0X0pX4Ht";
            break;
            case 's'://staging server
            $returnCaptchaKey="6LfP-qEUAAAAAItI6YreAfGeHXOzFEj9hNFOtpbB";
            break;
            case 'p'://production server
            $returnCaptchaKey="6Lfi-aEUAAAAAICPgRRrzwiEz3dI_3mLdKiG1ax1";
            break;

    }
    return $returnCaptchaKey;
}
function forEncrypt($textForEncryption)
{
    $encryptedStr="";
   $encryptedStr= openssl_encrypt($textForEncryption, "AES-128-ECB", $this->secretKey);
    return $encryptedStr;
}
function forDecrypt($textForDecryption){
    $decryptedStr="";
    $decryptedStr = openssl_decrypt($textForDecryption, "AES-128-ECB", $this->secretKey);
    return  $decryptedStr;
}
//method to configure activate url
function logoutTime(){
    return 540;// logout time
}
function activatelinkurl()
{
    $forgetpasswordurl="";
    
switch($this->param){
    case 'l'://localhost
    $forgetpasswordurl="http://localhost:8080/notebook/activate-user.php?activateId=";
        break;
        case 's': //staging
        $forgetpasswordurl="http://enotebook.vscom.tech/activate-user.php?activateId=";
            break;
            case 'p'://production
            $forgetpasswordurl="https://w3highschools.com/activate-user.php?activateId=";
                break;
}
return $forgetpasswordurl;
}//end of activelinkurl
//Method for configuring the forget email link
function forgetemailLink()
{
    $forgetemaillink="";

    switch($this->param){
        case 'l'://localhost
        $forgetemaillink="http://localhost:8080/notebook/forget-password.php?useremail=";
            break;
            case 's': //staging
            $forgetemaillink="http://enotebook.vscom.tech/forget-password.php?useremail=";
                break;
                case 'p'://production
                $forgetemaillink="https://w3highschools.com/forget-password.php?useremail=";
                    break;
    }
    return $forgetemaillink;
}//end of forgetemaillink method
function returnurlasperflag(){
    switch($this->param){
        case 'l'://localhost
        $this->forgetemaillink="http://localhost:8080";
            break;
            case 's': //staging
            $this->forgetemaillink="http://enotebook.vscom.tech";
                break;
                case 'p'://production
                $this->forgetemaillink="https://w3highschools.com";
                    break;

                   
    }
    return   $this->forgetemaillink;
}//end of retrurnflagaspertheuser










//=======================================================================================================================
//===========*******************************************************====================================================

}














?>