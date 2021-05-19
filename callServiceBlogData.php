<?php
include("core/connpdo.php");
include("app_code/sqlhelper.php");
session_start();
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

       if($_POST["action"]=="getNotLiveQues"){
            $userId=$_SESSION["id"];
            $action="getPendingQues";
            $stmt = $conn->prepare('call USP_USER_QUESTIONS(?,?)');
            $stmt->bindParam(1, $action);
            $stmt->bindParam(2, $userId);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res){
                $arr[]=array(
                    'quesId'=>$res['INT_ID'],
                    'quesTitle'=>$res['VCH_TITLE'],
                    'quesDesc'=>$res['VCH_QUES_DESC'],
                    'quesCateg'=>$res['VCH_CATEGORY_NAME'],
                    'quesUni'=>$res['VCH_UNIVERSITY_NAME'],
                    'quesColl'=>$res['VCH_COLLEGE_NAME'],
                    'quesDeg'=>$res['VCH_DEGREE_NAME'],
                    'quesSub'=>$res['VCH_SUB_NAME']
                );  
            }
            echo json_encode($arr);
       }

       if($_POST["action"]=="getLiveQues"){
            $userId=$_SESSION["id"];
            $action="getLiveQues";
            $stmt = $conn->prepare('call USP_USER_QUESTIONS(?,?)');
            $stmt->bindParam(1, $action);
            $stmt->bindParam(2, $userId);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res){
                $arr[]=array(
                    'quesId'=>$res['INT_ID'],
                    'quesTitle'=>$res['VCH_TITLE'],
                    'quesDesc'=>$res['VCH_QUES_DESC'],
                    'quesCateg'=>$res['VCH_CATEGORY_NAME'],
                    'quesUni'=>$res['VCH_UNIVERSITY_NAME'],
                    'quesColl'=>$res['VCH_COLLEGE_NAME'],
                    'quesDeg'=>$res['VCH_DEGREE_NAME'],
                    'quesSub'=>$res['VCH_SUB_NAME']
                );  
            }
            echo json_encode($arr);
       }

       if($_POST["action"]=="getRejQues"){
            $userId=$_SESSION["id"];
            $action="getRejQues";
            $stmt = $conn->prepare('call USP_USER_QUESTIONS(?,?)');
            $stmt->bindParam(1, $action);
            $stmt->bindParam(2, $userId);  
            $stmt->execute();  
            foreach($stmt->fetchAll() as $res){
                $arr[]=array(
                    'quesId'=>$res['INT_ID'],
                    'quesTitle'=>$res['VCH_TITLE'],
                    'quesDesc'=>$res['VCH_QUES_DESC'],
                    'quesCateg'=>$res['VCH_CATEGORY_NAME'],
                    'quesUni'=>$res['VCH_UNIVERSITY_NAME'],
                    'quesColl'=>$res['VCH_COLLEGE_NAME'],
                    'quesDeg'=>$res['VCH_DEGREE_NAME'],
                    'quesSub'=>$res['VCH_SUB_NAME']
                );  
            }
            echo json_encode($arr);
       }

       if($_POST["action"]=="getPenQues"){                          //binding the pending question in admin panel
        $action='getPenQues';
        $count=0;
        $stmt = $conn->prepare('call USP_ADMIN_BLOG_QUES(?)');
        $stmt->bindParam(1, $action);
        $stmt->execute();
        //$cnt=$stmt->fetch();                   
        foreach($stmt->fetchAll() as $res) {
            $arr[]=array(
                'quesId'=>$res['INT_ID'],
                'quesTitle'=>$res['VCH_TITLE'],
                'quesDesc'=>$res['VCH_QUES_DESC'], 
                'quesDeg'=>$res['VCH_DEGREE_NAME'],
                'quesSub'=>$res['VCH_SUB_NAME']
            );  
            $count++;
        }
        if($count==0){
            echo json_encode(0);
        }
        else if($count>0){
            echo json_encode($arr);
        } 
    }

    if($_POST["action"]=="getAppQues"){                          //binding the approved question in admin panel
        $action='getAppQues';
        $count=0;
        $stmt = $conn->prepare('call USP_ADMIN_BLOG_QUES(?)');
        $stmt->bindParam(1, $action);
        $stmt->execute();
        //$cnt=$stmt->fetch();                   
        foreach($stmt->fetchAll() as $res) {
            $arr[]=array(
                'quesId'=>$res['INT_ID'],
                'quesTitle'=>$res['VCH_TITLE'],
                'quesDesc'=>$res['VCH_QUES_DESC'], 
                'quesDeg'=>$res['VCH_DEGREE_NAME'],
                'quesSub'=>$res['VCH_SUB_NAME']
            );
            $count++;
        }
        if($count==0){
            echo json_encode(0);
        }
        else if($count>0){
            echo json_encode($arr);
        }
    }

    if($_POST["action"]=="getRejecQues"){                          //binding the rejected question in admin panel
        $action='getRejQues';
        $count=0;
        $stmt = $conn->prepare('call USP_ADMIN_BLOG_QUES(?)');
        $stmt->bindParam(1, $action);
        $stmt->execute();
        //$cnt=$stmt->fetch();                   
        foreach($stmt->fetchAll() as $res) {
            $arr[]=array(
                'quesId'=>$res['INT_ID'],
                'quesTitle'=>$res['VCH_TITLE'],
                'quesDesc'=>$res['VCH_QUES_DESC'], 
                'quesDeg'=>$res['VCH_DEGREE_NAME'],
                'quesSub'=>$res['VCH_SUB_NAME']
            );  
            $count++;
        }
        if($count==0){
            echo json_encode(0);
        }
        else if($count>0){
            echo json_encode($arr);
        }
    }

    //approving questions..
    if($_POST["action"]=='approveQues'){
        $notesId=rtrim($_POST["ids"],',');      //trimming the last , from the list of the numbers..
        $sql="UPDATE m_question_master SET INT_QUES_STATUS=1 WHERE INT_ID IN($notesId)";
        $stmt = $conn->prepare($sql);
        $result=$stmt->execute();
        if($result){
            echo 1;
        }
    }

    //rejecting question..
    if($_POST["action"]=='rejectQues'){
        $notesId=rtrim($_POST["ids"],',');      //trimming the last , from the list of the numbers..
        $sql="UPDATE m_question_master SET INT_QUES_STATUS=2 WHERE INT_ID IN($notesId)";
        $stmt = $conn->prepare($sql);
        $result=$stmt->execute();
        if($result){
            echo 1;
        }
    }

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
    header('Location: error.php');
}
?>
