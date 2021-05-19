<?php
include("core/connpdo.php");
 //include("app_code/sqlhelper.php");

  $flag = 'U';
            $id = '';
            $stmt = $conn->prepare('call USP_REGISTRATION_DATA(?,?)');
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $flag);
            $stmt->execute();
            $arr=[];
            foreach ($stmt->fetchAll() as $res) {
                $arr[] = array(
                    'unId' => $res['INT_UNI_ID'],
                    'unName' => $res['VCH_UNIVERSITY_NAME']
                );
            }
            echo json_encode($arr);
			
?>