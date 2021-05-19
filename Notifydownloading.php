<?php 
require_once "core/connpdo.php";
require_once "app_code/configmgr.php";
require_once "app_code/sqlhelper.php";
//code for downloading file===============================================
function logForDownloadedFile($action,$conn,$userId,$notesId){
    $stm = $conn->prepare('call USP_LIKE_DISLIKE_NOTES(:action,:notesId,:userId)');
    $stm->bindParam(':action', $action);
    $stm->bindParam(':userId', $userId);
    $stm->bindParam(':notesId', $notesId);
  $isinserted=  $stm->execute();               
  /*if($isinserted){
    foreach ($stm->fetchAll() as $res) {
        $arrdata[] = array(
            'cnt'=>$res['cnt'],
            'cmt'=>$res['cmt']
        );
   }*/
  
 //return $arrdata;
             
       
//}//end of insert if

}//end of function=============================================


if(isset($_POST['btnDownloadNotes'])){
      //code to download zip=====================================
     
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Thank you for Downloading</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style-error.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    body{
        background: #de3e30;
    }
    .content{
        color:#fff;
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
    }
    </style>


</head>

<body>

	<div class="row">
		<div class="col-md-12">
			<div class="content">
            <h2>Thank You for downlaoding</h2>
            <h5>Your Download will start soon....</h5>
            <h4><i class="fa fa-spinner fa-spin"></i></h4>
            </div>
		
			
		</div>
	</div>

</body>

</html>
<?php 
 $action="download";
 $userId=$_POST["userid"];
 $notesId=$_POST["id"];
 $actionForNotes="searchAllNotesFiles";
 //for extracting the notes
 
 $stmt = $conn->prepare('call USP_SEARCH_NOTES_FILES(?,?)');
 $stmt->bindParam(1, $actionForNotes);
 $stmt->bindParam(2, $notesId);
 $stmt->execute();
 $arr=[];
while($res=$stmt->fetch(PDO::FETCH_ASSOC))
{
  array_push($arr,$res["VCH_NOTES_PATH"]);
}
     
    
 


  //code for downloading the zip files
 //$post = $_POST;   
 $file_folder = ""; // folder to load files  
 $file_name="";
 if(extension_loaded('zip'))  
 {   
       
           // Checking files are selected  
           $zip = new ZipArchive(); // Load zip library   
           $zip_name = time().".zip";           // Zip name  
           if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)  
           {   
                // Opening zip file to load files  
                $error .= "* Sorry ZIP creation failed at this time";  
           }  

         
          for($i=0;$i<sizeOf($arr);$i++) {
             $file_folder=dirname($arr[$i])."/";
             $file_name=basename($arr[$i]);
             $folder_name=basename($file_folder);
             $dest="files/".$folder_name."/";               
            $sqlhelper= new SqlHelper();
            $sqlhelper->copy_directory($file_folder,$dest);
            $sqlhelper=null;
              $zip->addfile($dest.$file_name);
             
          }

     
       
           
           $zip->close(); 

           if(file_exists($zip_name))  
           {  
            
             ob_start();
              header('Content-Description: File Transfer');
              header('Content-type: application/zip');  
              header('Content-Disposition: attachment; filename="'.$zip_name.'"');
              header('Content-Transfer-Encoding: binary');
              header('Expires: 0');
              header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
              header('Pragma: public');
              
              
              ob_clean();
              ob_flush() ;
              readfile($zip_name);
                unlink($zip_name);
             $stmt=null;
             logForDownloadedFile($action,$conn,$userId,$notesId);
                // $arrdata= logForDownloadedFile($action,$conn,$userId,$notesId);
                // $configmgr=new configmgr();
               //  $returnUrl= $configmgr->returnurlasperflag();
               //$configmgr=null;
               //  header('Location:'.$returnUrl.$_POST['url']);
                 //code for maintain the log

  }  
 }  
 else  
 {  
      $error .= "* You dont have ZIP extension";  
 }  
 //end of code=========================================  













}
else{
    header('Location: error.html');
}

?>