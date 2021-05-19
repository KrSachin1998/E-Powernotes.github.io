<!DOCTYPE html>
<html>    
<head>
    <title></title>
</head>
<body>


    <?php
            include("core/connection.php");
            require_once "app_code/configmgr.php";
            $configmgr=new configmgr();    
            $dcryMail= $configmgr->forDecrypt($_GET["mail"]);
                  $configmgr=null;
              
              
            $email=base64_decode(urldecode($dcryMail));
           
            $sql="call USP_ACTIVATE_ACCOUNT(?)";
            $result=activateAccount($sql,$email,$conn);
            
        function activateAccount($sql,$email,$conn){
            $stmt=$conn->stmt_init();
            $routien=$sql;
            if(!$stmt->prepare($routien)){
                die("Query issue");
            }
            $stmt->bind_param('s',$email);
            $stmt->execute();
            $result=$stmt->get_result();
            while($res=mysqli_fetch_array($result)){
                echo $res["msg"];
            }
            return $result;
        }
        
    ?>
</body>
</html>