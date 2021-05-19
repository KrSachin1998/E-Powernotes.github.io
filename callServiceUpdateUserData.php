<?php
//include("core/connection.php");
include("core/connpdo.php");
include("app_code/sqlhelper.php");
try{  //begin of try..

//if(isset($_POST["action"])){
    function test_input($data) {             //server side validation of name and phone no..
        $restoreName=$data;
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        if($data!=$restoreName){
            echo 3;
            die();
        }
        return $data;
    }

    session_start();
    $email=$_SESSION["email"];
    $university=$_POST['ddlUserUniversity'];
    $college=$_POST['ddlUserCollege'];
    $degree=$_POST['ddlUserDegree'];
    $semester=$_POST['ddlUserSemester'];
    $userPhoneNo=test_input($_POST['txtUserMobileNo']);
    $userName=test_input($_POST['txtUserName']);    
    $file = $_FILES['file'];
    $previousImage=$_POST['userImageSrc'];      //this contain the previous link of image..
    $directory="Profile_pic/";

    /*===================
        Server side validation of user profile updation starts..
    ======================== */

    if($userName==''||$university==''||$university==0||$college==''||$college==0||$degree==''||$degree==0||$semester==''||$semester<0){
        echo 3;
        die();      //dying the further process if validation fails..
    }
    

    /*===================
        Server side validation of user profile updation starts..
    ======================== */


    if(!($_FILES['file']['name']=="")){     //if user not select any file then else condition will execute..
        if(!is_dir($directory)){
            mkdir($directory,0777,true);
            $source_path=$_FILES['file']['tmp_name'];        //temporary name...
            $name_without_whitespace = preg_replace('/\s+/', '',$_FILES['file']['name']); //removing white space from file name..
            $combine_name=$userName."-".$name_without_whitespace;
            $target_path=$directory.basename($combine_name);  //this path will store in database to access the file

            /*====== compressing and storing the file starts  ======= */
            $exten=pathinfo($combine_name,PATHINFO_EXTENSION);
            if($exten=='jpg' || $exten=='jpeg'){
                $src=imagecreatefromjpeg($source_path);
            }
            if($exten=='png'){
                $src=imagecreatefrompng($source_path);
            }
            list($width_min,$height_min)=getimagesize($source_path);
            $newwidth_min=640;
            $newheight_min=($height_min/$width_min)*$newwidth_min;
            $tmp_min=imagecreatetruecolor($newwidth_min,$newheight_min);
            imagecopyresampled($tmp_min,$src,0,0,0,0,$newwidth_min,$newheight_min,$width_min,$height_min);
            imagejpeg($tmp_min,$target_path,100);

            /*====== compressing and storing the file starts  ======= */

            //move_uploaded_file($source_path,$target_path);
            
        }
        else{
            $source_path=$_FILES['file']['tmp_name'];        //temporary name...
            $name_without_whitespace = preg_replace('/\s+/', '',$_FILES['file']['name']); //removing white space from file name..
            $combine_name=$userName."-".$name_without_whitespace;
            $target_path=$directory.basename($combine_name);    //this path will store in database to access the file

            /*====== compressing and storing the file starts  ======= */
            $exten=pathinfo($combine_name,PATHINFO_EXTENSION);
            if($exten=='jpg' || $exten=='jpeg'){
                $src=imagecreatefromjpeg($source_path);
            }
            if($exten=='png'){
                $src=imagecreatefrompng($source_path);
            }
            list($width_min,$height_min)=getimagesize($source_path);
            $newwidth_min=640;
            $newheight_min=($height_min/$width_min)*$newwidth_min;
            $tmp_min=imagecreatetruecolor($newwidth_min,$newheight_min);
            imagecopyresampled($tmp_min,$src,0,0,0,0,$newwidth_min,$newheight_min,$width_min,$height_min);
            imagejpeg($tmp_min,$target_path,100);

            /*====== compressing and storing the file starts  ======= */

            //move_uploaded_file($source_path,$target_path);
        }
    }
    else{
        $target_path=$previousImage;
    }

    //updating data...

    $stmt = $conn->prepare('call USP_UPDATE_USER_INFO(?,?,?,?,?,?,?,?)');

    $stmt->bindParam(1, $userName);
    $stmt->bindParam(2, $userPhoneNo);  
    $stmt->bindParam(3, $university);
    $stmt->bindParam(4, $college);
    $stmt->bindParam(5, $degree);
    $stmt->bindParam(6, $semester);
    $stmt->bindParam(7, $target_path);
    $stmt->bindParam(8, $email);

    $result= $stmt->execute(); 
    if($result){
        echo 1;
    }
    else{
        echo 0;
    }
    //}           //end of isset..
    
}   //end of try..
catch(Exception $e){
    $desc=$e->getMessage();
    $lineNo=$e->getLine();
    $pageName=$e->getFile();
    $sqlhelp = new SqlHelper();
    $sqlhelp->insertdbLog($conn,$desc,$lineNo,$pageName);
    $sqlhelp=null;
    echo 'error';
}
?>