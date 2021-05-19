<?php
include("core/connpdo.php");
include("app_code/sqlhelper.php");
session_start();                    //starting the session to access the user id stored in the session variable.. 

//Server side validation of title and description..
try {
    if(isset($_POST["action"])){

        if($_POST["action"]=='askQuestion'){
            $flag='askQuestion';
            $categ=$_POST["categId"];
            $uni=$_POST["uniId"];
            $coll=$_POST["collId"];
            $deg=$_POST["degId"];
            $sub=$_POST["subId"];
            $title=$_POST["quesTitle"];
            $descr=$_POST["quesDesc"];
            $userId=$_SESSION["id"];

            $stmt = $conn->prepare('call USP_UPLOAD_BLOG_QUES(?,?,?,?,?,?,?,?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $title);  
            $stmt->bindParam(3, $categ);
            $stmt->bindParam(4, $uni);
            $stmt->bindParam(5, $coll);
            $stmt->bindParam(6, $deg);
            $stmt->bindParam(7, $sub);
            $stmt->bindParam(8, $descr);
            $stmt->bindParam(9, $userId);
            $stmt->execute();
            foreach($stmt->fetchAll() as $res){
                $result=$res["msg"];
            }

            if($result==1){
                echo json_encode("posted");
            }
            else{
                echo json_encode("failed");
            }
        }

    }   //end of isset

    else {
        header('Location: logout.php');
    }
    
} //end of try
catch (Exception $e) {
    delTree($dirPathWithDash);
    $desc=$e->getMessage();
    $lineNo=$e->getLine();
    $pageName=$e->getFile();
    $sqlhelp = new SqlHelper();
    $sqlhelp->insertdbLog($conn,$desc,$lineNo,$pageName);
    $sqlhelp=null;
    echo 0;
}   //end of catch
 

 