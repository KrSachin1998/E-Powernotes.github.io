<?php
include("core/connpdo.php");
include("app_code/sqlhelper.php");
session_start();                    //starting the session to access the user id stored in the session variable.. 
try {
    //getting the ids to send to database..
    $title = test_input($_POST['txtTitle']);
    $category = $_POST['ddlCategory'];
    $university = $_POST['ddlUniversity'];
    $college = $_POST['ddlCollege'];
    $degree = $_POST['ddlDegree'];
    $semester = $_POST['ddlSemester'];
    $subject = $_POST['ddlNotesSubject'];
    $notestype = $_POST['ddlNotesType'];
    $description = test_input($_POST['description']);
    //$description=$_POST['description'];
   // $dirName = $_POST['hiddenDirecName'];   
   $dirName = $_POST['filePath'];   //name of the directory..
    $flag = "uploadNotes";   //sending this flag to database to run the query based on this flag..
    $target = 'upload/';
    $dirPathWithDash = preg_replace('/\s+/', '_', $dirName);         //creating directory name..     
    $fileArray = [];
    $target_path="";

/*==================
    Server side validation starts..
====================== */
    $totalFileSize=0;    //this variable is use to store the total size of the uploading files..
    if($title==''|| $description==''||$_FILES==''|| $category==0 || $category==''||$university==0||$university==''||$college==0||$college==''||$degree==0||$degree==''||$semester==0||$semester==''||$subject==0||$subject==''||$notestype==0||$notestype==''){
        echo 2;
        die();
    }
               
    elseif (is_array($_FILES)){  //validating the file size server side..
        foreach($_FILES['files']['size'] as $size => $value){
            $totalFileSize=$totalFileSize+$_FILES['files']['size'][$size];
        }
        if($totalFileSize>20000000){
            echo 2;
            die();
        }
        
    }    
    
    elseif(is_array($_FILES)){
        foreach ($_FILES['files']['name'] as $name => $value){
            $fileNameForExten=$_FILES['files']['name'][$name];
            $exten=pathinfo($fileNameForExten,PATHINFO_EXTENSION);
            if(!($exten=='jpg' || $exten=='jpeg' || $exten=='png' || $exten=='doc' || $exten=='docx')){
                echo 2;
                die();
            }
        }
    }
    
/*==================
    Server side validation ends..
============== === */

    if (is_array($_FILES)) {
        foreach ($_FILES['files']['name'] as $name => $value) {
            $file_name = explode(".", $_FILES['files']['name'][$name]);

                $combineNam = "";
                if (!is_dir($dirPathWithDash)) {
                    mkdir($dirPathWithDash, 0777, true);
                    $source_path = $_FILES['files']['tmp_name'][$name];
                    $combineName = getFileNameWithSalt($file_name[1]);
                    $true_name = preg_replace('/\s+/', '', $_FILES['files']['name'][$name]);   //removing white space from file name..
                    $getNameWithSalt=getFileNameWithSalt($file_name[1]);
                    $exten=pathinfo($getNameWithSalt,PATHINFO_EXTENSION);
                    $target_path = $dirPathWithDash . basename($getNameWithSalt);
                    if($exten=='jpg' || $exten=='jpeg' || $exten=='png'){   //compress and store..
                        /*====== compressing and storing the file starts  ======= */
                    
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
                        $fileArray[] = $target_path; //this will use as array to store files... and then i will store the file one by one to the database..

                        /*====== compressing and storing the file ends  ======= */
                    }
                    else{   //store without compressing..
                        $fileArray[] = $target_path; //this will use as array to store files... and then i will store the file one by one to the database..
                        move_uploaded_file($source_path, $target_path);
                    }
                    
                    }
                    else {
                    $source_path = $_FILES['files']['tmp_name'][$name];
                    $combineName = $_FILES['files']['name'][$name];
                    $true_name = preg_replace('/\s+/', '', $_FILES['files']['name'][$name]); //removing white space from file name..  
                    $getNameWithSalt=getFileNameWithSalt($file_name[1]);              
                    $target_path = $dirPathWithDash . basename($getNameWithSalt);
                    $exten=pathinfo($getNameWithSalt,PATHINFO_EXTENSION);
                        if($exten=='jpg' || $exten=='jpeg' || $exten=='png'){   //compress and store..
                            /*====== compressing and storing the file starts  ======= */
                    
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
                            $fileArray[] = $target_path; //this will use as array to store files... and then i will store the file one by one to the database..

                            /*====== compressing and storing the file ends  ======= */
                        }
                        else{   //store without compressing..
                            $fileArray[] = $target_path; //this will use as array to store files... and then i will store the file one by one to the database..
                            move_uploaded_file($source_path, $target_path);
                        }
                    }
                
            }
        }
    //for Deleting the file if any exception occur while inserting the data into database
    function delTree($dir)
    {        
            $files = array_diff(scandir($dir), array('.', '..')); 

            foreach ($files as $file) { 
                (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
            }
    
            return rmdir($dir); 
        
       
    } 
//==========================================================================================
    /* for inserting the value in tables */
    try {
        $createdid = $_SESSION["id"];
        $conn->beginTransaction();

        $stmt = $conn->prepare("INSERT INTO m_notes_master(INT_UNI_ID,INT_COLL_ID,	INT_DEG_ID,INT_SUB_ID,INT_SEM_ID,INT_CATEGORY_ID,INT_NOTES_TYPE_ID,VCH_TITLE,VCH_DESCRIPTION,VCH_CREATED_BY) 
    VALUES (:university, :college, :degree, :sub, :semester,:category, :notestype, :title, :descri,:createdby)");
        $stmt->bindParam(':university', $university);
        $stmt->bindParam(':college', $college);
        $stmt->bindParam(':degree', $degree);
        $stmt->bindParam(':sub', $subject);
        $stmt->bindParam(':semester',$semester);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':notestype', $notestype);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':descri', $description);
        $stmt->bindParam(':createdby', $createdid);
        $stmt->execute();
        $lstId = $conn->lastInsertId();

        $query = "";
        
        $count_files = count($fileArray);
        for ($i = 0; $i < $count_files; $i++) {
            $query .= "INSERT INTO `t_notes_details` (`INT_NOTES_ID`,`VCH_NOTES_PATH`, `VCH_CREATED_BY`) VALUES (" . $lstId . ",'" . $fileArray[$i] . "','" . $createdid . "');";
        }        

        if ($conn->exec($query)) {            
            echo 1;
        }
        else {
            
            delTree($dirPathWithDash);
            echo 0;
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollBack();
        delTree($dirPathWithDash);
        $desc=$e->getMessage();
        $lineNo=$e->getLine();
        $pageName=$e->getFile();
        $sqlhelp = new SqlHelper();
        $sqlhelp->insertdbLog($conn,$desc,$lineNo,$pageName);
        $sqlhelp=null;
        echo 0;
    }
    finally{
    $conn=null;
    }

   
} catch (Exception $e) {
    delTree($dirPathWithDash);
    $desc=$e->getMessage();
    $lineNo=$e->getLine();
    $pageName=$e->getFile();
    $sqlhelp = new SqlHelper();
    $sqlhelp->insertdbLog($conn,$desc,$lineNo,$pageName);
    $sqlhelp=null;
    echo 0;
} //End of Catch

    //Server side validation of title and description..
    function test_input($data) {
        if($data==''){
            echo 2;
            die();
        }
        else{
            $restoreTitle=trim($data);
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            if($data!=$restoreTitle){
                echo 2;
                die();
            }
            return $data;
        }
    }

    function getFileNameWithSalt($ext) {   //this function generate random numbers to add as salt to the files..
        //session_start();
        $id=$_SESSION["id"];
     //   $userFileName=$salt;                //getting the users file name so that i can add salt to it..
       $randomNum=mt_rand(0,500);
        $currDateTime=date("dmYHis");
        $fileSalt=$id.$currDateTime.$randomNum.'.'.$ext;
        return $fileSalt;
    } 

 