<?php
include("core/connpdo.php");
include("app_code/sqlhelper.php");
try{    //begin of try

    if(isset($_POST["action"])){
        if($_POST["action"]=="categ"){
            $flag='categ';
            $id=$_POST["id"];
            $stmt = $conn->prepare('call USP_UPLOADNOTES_DATA_BIND(?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $id);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res) {
                $arr[]=array(
                    'categId'=>$res['INT_CATEGORY_ID'],
                    'categName'=>$res['VCH_CATEGORY_NAME']
                ); 
            }
            echo json_encode($arr);
        }
    
        if($_POST["action"]=="uni"){
            $flag='uni';
            $id=$_POST["id"];
            $stmt = $conn->prepare('call USP_UPLOADNOTES_DATA_BIND(?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $id);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res) {
                $arr[]=array(
                    'uniId'=>$res['INT_UNI_ID'],
                    'uniName'=>$res['VCH_UNIVERSITY_NAME']
                );  
            }
            echo json_encode($arr);
        }
    
        if($_POST["action"]=="college"){
    
            $flag='getcoll';
            $id=$_POST["id"];
            $stmt = $conn->prepare('call USP_UPLOADNOTES_DATA_BIND(?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $id);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res) {
                $arr[]=array(
                    'colId'=>$res['INT_COLL_ID'],
                    'colName'=>$res['VCH_COLLEGE_NAME']
                );  
            }
            echo json_encode($arr);
       }

    
       if($_POST["action"]=="degree"){    
            $flag='getdegree';
            $id=$_POST["id"];
            $stmt = $conn->prepare('call USP_UPLOADNOTES_DATA_BIND(?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $id);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res) {
                $arr[]=array(
                    'degId'=>$res['INT_DEG_ID'],
                    'degName'=>$res['VCH_DEGREE_NAME']
                );  
            }
            echo json_encode($arr);
       }
    
       if($_POST["action"]=="semester"){
    
            $flag='getsemester';
            $id=$_POST["id"];
            $stmt = $conn->prepare('call USP_UPLOADNOTES_DATA_BIND(?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $id);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res){
                $arr[]=array(
                    'semId'=>$res['INT_SEM_ID'],
                    'semName'=>$res['VCH_SEMESTER']
                );  
            }
            echo json_encode($arr);
       }

    
       if($_POST["action"]=="notestype"){
    
            $flag='getnotestype';
            $id=$_POST["id"];
            $stmt = $conn->prepare('call USP_UPLOADNOTES_DATA_BIND(?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $id);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res){
                $arr[]=array(
                    'notesTypeId'=>$res['INT_NOTES_TYPE_ID'],
                    'notesTypeName'=>$res['VCH_NOTES_TYPE_NAME']
                );  
            }
            echo json_encode($arr);
       }
    
       if($_POST["action"]=="subject"){
    
            $flag='getsubject';
            $categId=$_POST["category"];
            $uniId=$_POST["university"];
            $degId=$_POST["degree"];
            $stmt = $conn->prepare('call USP_UPLOADNOTES_SUBJECT(?,?,?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $categId);  
            $stmt->bindParam(3, $uniId);
            $stmt->bindParam(4, $degId);
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res){
                $arr[]=array(
                    'subId'=>$res['INT_SUB_ID'],
                    'subName'=>$res['VCH_SUB_NAME']
                );  
            }
            echo json_encode($arr); 
       }   
    
        if($_POST["action"]=="getUserData"){                  //getting the user data to bind in user profile
    
            $flag='getUserData';
            $email=$_POST["email"];
            $stmt = $conn->prepare('call USP_GET_USER_DATA(?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $email);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res){
                $arr['userName']=$res['VCH_USER_NAME'];
                $arr['userUni']=$res['INT_UNI_ID'];
                $arr['userColl']=$res['INT_COLLEGE_ID'];
                $arr['userDeg']=$res['INT_DEG_ID'];
                $arr['userSem']=$res['INT_SEM_ID'];
                $arr['userMobile']=$res['VCH_MOBILE_NO'];    
                $arr['userImage']=$res['VCH_PROFILE_NAME_PATH'];  
            }
            echo json_encode($arr);
        }

        //code added by mehul 06-06-2019 starts..
        if($_POST["action"]=="getsemesterForUpl"){          
    
            $flag='getsemesterForUpl';
            $id=$_POST["id"];
            $stmt = $conn->prepare('call USP_UPLOADNOTES_DATA_BIND(?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $id);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res){
                $arr[]=array(
                    'semId'=>$res['INT_SEM_ID'],
                    'semName'=>$res['VCH_SEMESTER']
                );  
            }
            echo json_encode($arr);
        }

        if($_POST["action"]=="getdegreeForUpl"){    
            $flag='getdegreeForUpl';
            $id=$_POST["id"];
            $stmt = $conn->prepare('call USP_UPLOADNOTES_DATA_BIND(?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $id);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res) {
                $arr[]=array(
                    'degId'=>$res['INT_DEG_ID'],
                    'degName'=>$res['VCH_DEGREE_NAME']
                );  
            }
            echo json_encode($arr);
        }

        if($_POST["action"]=="getcollForUpl"){
    
            $flag='getcollForUpl';
            $id=$_POST["id"];
            $stmt = $conn->prepare('call USP_UPLOADNOTES_DATA_BIND(?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $id);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res) {
                $arr[]=array(
                    'colId'=>$res['INT_COLL_ID'],
                    'colName'=>$res['VCH_COLLEGE_NAME']
                );  
            }
            echo json_encode($arr);
        }

        if($_POST["action"]=="uniForUpl"){
            $flag='uniForUpl';
            $id=$_POST["id"];
            $stmt = $conn->prepare('call USP_UPLOADNOTES_DATA_BIND(?,?)');
            $stmt->bindParam(1, $flag);
            $stmt->bindParam(2, $id);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res) {
                $arr[]=array(
                    'uniId'=>$res['INT_UNI_ID'],
                    'uniName'=>$res['VCH_UNIVERSITY_NAME']
                );  
            }
            echo json_encode($arr);
        }

        //added by mehul 06-06-2019 ends..

    }       //end of isset..
    else{
        header('Location: logout.php');
    }
}   //end of try..
catch(Exception $e){
    $desc=$e->getMessage();
    $lineNo=$e->getLine();
    $pageName=$e->getFile();
    $sqlhelp = new SqlHelper();
    $sqlhelp->insertdbLog($conn,$desc,$lineNo,$pageName);
    $sqlhelp=null;
    echo 0;
    header('Location: error.html');
}
?>
