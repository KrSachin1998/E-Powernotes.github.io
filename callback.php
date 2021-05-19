<?php


require_once 'config.php';

  try {
    $accessToken = $helper->getAccessToken();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
  
  if (! isset($accessToken)) {
    if ($helper->getError()) {
      header('HTTP/1.0 401 Unauthorized');
      echo "Error: " . $helper->getError() . "\n";
      echo "Error Code: " . $helper->getErrorCode() . "\n";
      echo "Error Reason: " . $helper->getErrorReason() . "\n";
      echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
      header('HTTP/1.0 400 Bad Request');
      echo 'Bad request';
    }
    exit;
  }
  
  // Logged in
  //echo '<h3>Access Token</h3>';
  //var_dump($accessToken->getValue());
  try{
      $response = $fb->get('/me?fields=id,name,email,first_name,last_name,picture',$accessToken->getValue());
  }
  catch(Facebook\Exceptions\FacebookResponseException $e)
  {
     echo 'Graph returned an error: '.$e->getmessage();
     exit;
  }
  catch(Facebook\Exceptions\FacebookSDKException $e){
      echo 'Facebook sdk returned an error  '.$e->getmessage();
  }
  $fbuserdata = $response->getGraphUser()->asarray();
  /*echo 'Name: ' . $fbuserdata['name'].'</br>';
  echo 'user Id: ' . $fbuserdata['id'].'</br>';
  echo 'Email: ' . $fbuserdata['email'].'</br>';
  echo 'first_name: ' . $fbuserdata['first_name'].'</br>';
  echo 'last_name: ' . $fbuserdata['last_name'].'</br>';
  echo 'picture: <img src="'.$fbuserdata['picture']['url'].'" width="'.$fbuserdata['picture']['width'].'" height="'.$fbuserdata['picture']['height'].'"/></br>';
*/

//$_SESSION['fb_access_token']
  // The OAuth 2.0 client handler helps us manage access tokens
  $oAuth2Client = $fb->getOAuth2Client();
  
  // Get the access token metadata from /debug_token
  $tokenMetadata = $oAuth2Client->debugToken($accessToken);
  //echo '<h3>Metadata</h3>';
  //var_dump($tokenMetadata);
  
  // Validation (these will throw FacebookSDKException's when they fail)
  $tokenMetadata->validateAppId($app_id); // Replace {app-id} with your app id
  // If you know the user ID this access token belongs to, you can validate it here
  //$tokenMetadata->validateUserId('123');
  $tokenMetadata->validateExpiration();
  
  if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
      $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
      echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
      exit;
    }
  
    echo '<h3>Long-lived</h3>';
    var_dump($accessToken->getValue());
  }
  
  $_SESSION['fb_access_token'] = (string) $accessToken;

  if($_SESSION['fb_access_token']){
  
    $_SESSION["name"]=$fbuserdata['name'];
    $_SESSION["email"]=$fbuserdata['email'];
    header('Location: index-home.php');
  }
  else{
    header('Location: default.php');
  }
  // User is logged in with a long-lived access token.
  // You can redirect them to a members-only page.
  //header('Location: https://example.com/members.php');

?>