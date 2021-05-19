<?php
include("core/connpdo.php");
include("app_code/sqlhelper.php");
try{

if(isset($_POST["actionFlag"])){    //checking if the values are set..

        $flag=$_POST["actionFlag"];

    if($flag=='pending'){       //binding data into pending table..
        $count=0;
        $stmt = $conn->prepare("call USP_ADMIN_GETNOTES(?);");
        $stmt->bindParam(1, $flag);
        $stmt->execute();
        foreach($stmt->fetchAll() as $res) {
            $arr[]=array(
                'notesId'=>$res['INT_NOTES_ID'],
                'userid'=>$res['INT_USER_ID'],
                'title'=>$res['VCH_TITLE'],
                'desc'=>$res['VCH_DESCRIPTION'],
                'degree'=>$res['VCH_DEGREE_NAME'],
                'semester'=>$res['VCH_SEMESTER'],
                'subject'=>$res['VCH_SUB_NAME']
            );  
            $count++;
        }
        if($count==0){
            echo json_encode('empty');
        }
        else{
            echo json_encode($arr);
        }
    }

    if($flag=='approved'){       //binding data into approved table..
        $count=0;
        $stmt = $conn->prepare("call USP_ADMIN_GETNOTES(?);");
        $stmt->bindParam(1, $flag);
        $stmt->execute();
        foreach($stmt->fetchAll() as $res) {
            $arr[]=array(
                'notesId'=>$res['INT_NOTES_ID'],
                'userid'=>$res['INT_USER_ID'],
                'title'=>$res['VCH_TITLE'],
                'desc'=>$res['VCH_DESCRIPTION'],
                'degree'=>$res['VCH_DEGREE_NAME'],
                'semester'=>$res['VCH_SEMESTER'],
                'subject'=>$res['VCH_SUB_NAME']
            );
            $count++;
        }
        if($count==0){
            echo json_encode('empty');
        } 
        else{
            echo json_encode($arr);
        }
    }

    if($flag=='rejected'){       //binding data into rejected table..
        $count=0;
        $stmt = $conn->prepare("call USP_ADMIN_GETNOTES(?);");
        $stmt->bindParam(1, $flag);
        $stmt->execute();
        foreach($stmt->fetchAll() as $res) {
            $arr[]=array(
                'notesId'=>$res['INT_NOTES_ID'],
                'userid'=>$res['INT_USER_ID'],
                'title'=>$res['VCH_TITLE'],
                'desc'=>$res['VCH_DESCRIPTION'],
                'degree'=>$res['VCH_DEGREE_NAME'],
                'semester'=>$res['VCH_SEMESTER'],
                'subject'=>$res['VCH_SUB_NAME']
            );  
            $count++;
        }
        if($count==0){
            echo json_encode('empty');
        }   
        else{
            echo json_encode($arr);
        }
    }

    if($flag=='getdegree'){     //binding data into degree dropdown..

        $action='getdegree';
        $id='';
        $stmt = $conn->prepare('call USP_ADMIN_GETDATA(?,?)');
        $stmt->bindParam(1, $action);
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

    if($flag=='getsubject'){       //binding data into subject dropdown..
        //$sql="call USP_ADMIN_GETDATA(?,?)";
        $id=$_POST["id"];
        $action='getsubject';
        $stmt = $conn->prepare('call USP_ADMIN_GETDATA(?,?)');
        $stmt->bindParam(1, $action);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        foreach($stmt->fetchAll() as $res) {
            $arr[]=array(
                'subId'=>$res['INT_SUB_ID'],
                'subName'=>$res['VCH_SUB_NAME']
            );  
        }
        echo json_encode($arr);
    }

    if($flag=='getsemester'){       //binding data into semester dropdown..

        $id='';
        $action='getsemester';
        $stmt = $conn->prepare('call USP_ADMIN_GETDATA(?,?)');
        $stmt->bindParam(1, $action);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        foreach($stmt->fetchAll() as $res) {
            $arr[]=array(
                'semId'=>$res['INT_SEM_ID'],
                'semName'=>$res['VCH_SEMESTER'] 
            );  
        } 
        echo json_encode($arr);
    }
        /*==============
        filter start..
        ================== */

    if($flag=='getdatadegsubsempen'){      //pending search according to degree, subject and semester..
        $deg=$_POST["finddeg"];
        $sub=$_POST["findsub"];
        $sem=$_POST["findsem"];
        $action='getdatadegsubsempen';
        $stmt = $conn->prepare('call USP_ADMIN_SEARCH(?,?,?,?)');
        $stmt->bindParam(1, $action);
        $stmt->bindParam(2, $deg);
        $stmt->bindParam(3, $sub);
        $stmt->bindParam(4, $sem);
        $stmt->execute();
        $cnt=$stmt->fetch();
        if($cnt){   //checking if there is no data present in the table..
            foreach($stmt->fetchAll() as $res) {
                $arr[]=array(
                'notesId'=>$res['INT_NOTES_ID'],
                'userid'=>$res['INT_USER_ID'],
                'title'=>$res['VCH_TITLE'], 
                'desc'=>$res['VCH_DESCRIPTION'],
                'degree'=>$res['VCH_DEGREE_NAME'],
                'semester'=>$res['VCH_SEMESTER'],
                'subject'=>$res['VCH_SUB_NAME']
                );  
            }
            echo json_encode($arr);
        }
        else{
            echo 0;
        }   
    }

    if($flag=='getdatadatepen'){           //pending searching according to date..

        $fromdate=$_POST["from"];
        $todate=$_POST["to"];
        $action="getdatadatepen";
        $stmt = $conn->prepare('call USP_ADMIN_SEARCH_DATE(?,?,?)');
        $stmt->bindParam(1, $action);
        $stmt->bindParam(2, $fromdate);
        $stmt->bindParam(3, $todate);
        $stmt->execute();
        $cnt=$stmt->fetch();
        if($cnt){               //checking if there is no data present in the table..
            foreach($stmt->fetchAll() as $res) {
                $arr[]=array(
                    'notesId'=>$res['INT_NOTES_ID'],
                    'userid'=>$res['INT_USER_ID'],
                    'title'=>$res['VCH_TITLE'], 
                    'desc'=>$res['VCH_DESCRIPTION'],
                    'degree'=>$res['VCH_DEGREE_NAME'],
                    'semester'=>$res['VCH_SEMESTER'],
                    'subject'=>$res['VCH_SUB_NAME']
                );  
            }
            echo json_encode($arr);
        }
        else{
            echo 0;
        }
    }   

    if($flag=='getdatadegsubsemapp'){      //approved searching according to degree, subject and semester..
        $deg=$_POST["finddeg"];
        $sub=$_POST["findsub"];
        $sem=$_POST["findsem"];
        $action='getdatadegsubsemapp';
        $stmt = $conn->prepare('call USP_ADMIN_SEARCH(?,?,?,?)');
        $stmt->bindParam(1, $action);
        $stmt->bindParam(2, $deg);
        $stmt->bindParam(3, $sub);
        $stmt->bindParam(4, $sem);
        $stmt->execute();
      
            foreach($stmt->fetchAll() as $res) {
                $arr[]=array(
                    'notesId'=>$res['INT_NOTES_ID'],
                    'userid'=>$res['INT_USER_ID'],
                    'title'=>$res['VCH_TITLE'], 
                    'desc'=>$res['VCH_DESCRIPTION'],
                    'degree'=>$res['VCH_DEGREE_NAME'],
                    'semester'=>$res['VCH_SEMESTER'],
                    'subject'=>$res['VCH_SUB_NAME']
                );  
            }
            if($arr==""){   //checking if there is no data present in the table..
                echo 0;
            } 
            else{
                echo json_encode($arr);
            }   
    }

    if($flag=='getdatadateapp'){          //approved searching according to date..
        $fromdate=$_POST["from"];
        $todate=$_POST["to"];
        $action="getdatadateapp";
        $stmt = $conn->prepare('call USP_ADMIN_SEARCH_DATE(?,?,?)');
        $stmt->bindParam(1, $action);
        $stmt->bindParam(2, $fromdate);
        $stmt->bindParam(3, $todate);
        $stmt->execute();
        $cnt=$stmt->fetch();
        if($cnt){               //checking if there is no data present in the table..
            foreach($stmt->fetchAll() as $res) {
                $arr[]=array(
                    'notesId'=>$res['INT_NOTES_ID'],
                    'userid'=>$res['INT_USER_ID'],
                    'title'=>$res['VCH_TITLE'], 
                    'desc'=>$res['VCH_DESCRIPTION'],
                    'degree'=>$res['VCH_DEGREE_NAME'],
                    'semester'=>$res['VCH_SEMESTER'],
                    'subject'=>$res['VCH_SUB_NAME']
                );  
            }
            echo json_encode($arr);
        }
        else{
            echo 0;
        }
    } 

    if($flag=='getdatadegsubsemrej'){
        $deg=$_POST["finddeg"];
        $sub=$_POST["findsub"];
        $sem=$_POST["findsem"];
        $action='getdatadegsubsemrej';
        $stmt = $conn->prepare('call USP_ADMIN_SEARCH(?,?,?,?)');
        $stmt->bindParam(1, $action);
        $stmt->bindParam(2, $deg);
        $stmt->bindParam(3, $sub);
        $stmt->bindParam(4, $sem);
        $stmt->execute();
        $cnt=$stmt->fetch();
        if($cnt){           //checking if there is no data present in the table..
            $arr[]=array(
                'notesId'=>$res['INT_NOTES_ID'],
                'userid'=>$res['INT_USER_ID'],
                'title'=>$res['VCH_TITLE'], 
                'desc'=>$res['VCH_DESCRIPTION'],
                'degree'=>$res['VCH_DEGREE_NAME'],
                'semester'=>$res['VCH_SEMESTER'],
                'subject'=>$res['VCH_SUB_NAME']
                );
            echo json_encode($arr);
        }      
            else{
                echo 0;
        }
    }

    if($flag=='getdatadaterej'){
        $fromdate=$_POST["from"];
        $todate=$_POST["to"];
        $action="getdatadaterej";
        $stmt = $conn->prepare('call USP_ADMIN_SEARCH_DATE(?,?,?)');
        $stmt->bindParam(1, $action);
        $stmt->bindParam(2, $fromdate);
        $stmt->bindParam(3, $todate);
        $stmt->execute();
        //$cnt=$stmt->fetch();                   
        foreach($stmt->fetchAll() as $res) {
            $arr[]=array(
                'notesId'=>$res['INT_NOTES_ID'],
                'userid'=>$res['INT_USER_ID'],
                'title'=>$res['VCH_TITLE'], 
                'desc'=>$res['VCH_DESCRIPTION'],
                'degree'=>$res['VCH_DEGREE_NAME'],
                'semester'=>$res['VCH_SEMESTER'],
                'subject'=>$res['VCH_SUB_NAME']
            );  
        }
        if($arr!=""){       //checking if there is no data present in the table..
            
        }
        else{
            echo 0;
        }        
    }

    /*==============
        filter ends..
    ================== */

    //approving notes..
    if($flag=='approve'){
        $notesId=rtrim($_POST["ids"],',');      //trimming the last , from the list of the numbers..
        $action="approve";
        $sql="UPDATE m_notes_master SET INT_NOTES_STATUS=1 WHERE INT_NOTES_ID IN($notesId)";
        $stmt = $conn->prepare($sql);
        $result=$stmt->execute();
        if($result){
            echo 1;
        }
    }

    //rejecting notes..
    if($flag=='reject'){
        $notesId=rtrim($_POST["ids"],',');      //trimming the last , from the list of the numbers..
        $action="reject";
        $sql="UPDATE m_notes_master SET INT_NOTES_STATUS=2 WHERE INT_NOTES_ID IN($notesId)";
        $stmt = $conn->prepare($sql);
        $result=$stmt->execute();
        if($result){
            echo 1;
        }
    }
	
	if($flag=='allRegisterUser'){
        $action='allRegisterUser';
        $stmt = $conn->prepare('call USP_ALL_REGISTERED(?)');
        $stmt->bindParam(1, $action);
        $stmt->execute();
        //$cnt=$stmt->fetch();                   
        foreach($stmt->fetchAll() as $res) {
            $arr[]=array(
                'userid'=>$res['INT_USER_ID'],
                'userName'=>$res['VCH_USER_NAME'],
                'userActivated'=>$res['USER_ACTIVATED'], 
                'userEmail'=>$res['VCH_EMAIL_ID'],
                'userBlocked'=>$res['USER_BLOCKED'],
                'mailSend'=>$res['MAIL_SEND']
            );  
        }
        echo json_encode($arr);
    }

    if($flag=='allBlockedUser'){
        $action='allBlockedUser';
        $count=0;
        $stmt = $conn->prepare('call USP_ALL_REGISTERED(?)');
        $stmt->bindParam(1, $action);
        $stmt->execute();
        //$cnt=$stmt->fetch();                   
        foreach($stmt->fetchAll() as $res) {
            $arr[]=array(
                'userid'=>$res['INT_USER_ID'],
                'userName'=>$res['VCH_USER_NAME'],
                'userActivated'=>$res['USER_ACTIVATED'], 
                'userEmail'=>$res['VCH_EMAIL_ID'],
                'userBlocked'=>$res['USER_BLOCKED'],
                'mailSend'=>$res['MAIL_SEND']
            );  
            $count++;
        }
        if($count==0){
            echo json_encode('nodata');
        }
        else{
            echo json_encode($arr);
        }
    }

    }   //end of isset

    else{
        header('Location: logout.php');
    }
}
catch(Exception $e){
    $desc=$e->getMessage();
    $lineNo=$e->getLine();
    $pageName=$e->getFile();
    $sqlhelp = new SqlHelper();
    $sqlhelp->insertdbLog($conn,$desc,$lineNo,$pageName);
    $sqlhelp=null;
    echo json_encode('error');
}
?>