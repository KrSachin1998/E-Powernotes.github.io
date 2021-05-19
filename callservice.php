<?php
/*require '..\vendor\autoload.php';
use GuzzleHttp\client;


$client = new client();
$response=$client->request(
'GET',
'http://localhost:8080/test_api/api/callapi.php?action=select'
);

echo $response->getBody();*/
if(isset($_POST["action"]))
{
  $data="";
    if($_POST["action"]=="select")
    {
      $data= "hello this is from api";
    }
    echo json_encode($data);
}


?>