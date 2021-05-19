<?php
if(!session_id()){
session_start();
}
require_once 'Facebook/autoload.php';

$app_id='2305654012832378';
$app_secret='65683f5f84a6ea5444bdb47a14c21f11';
$permissions = ['email']; 
$callbackurl='http://localhost/notebook/callback.php';

$fb = new Facebook\Facebook([
    'app_id' => $app_id, // Replace {app-id} with your app id
    'app_secret' =>$app_secret,
    'default_graph_version' => 'v2.2',
    ]);
  
  $helper = $fb->getRedirectLoginHelper();
  
  
  $loginUrl = $helper->getLoginUrl($callbackurl, $permissions);

?>