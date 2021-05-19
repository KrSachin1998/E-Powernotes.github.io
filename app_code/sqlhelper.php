<?php

class SqlHelper
{
    function copy_directory($src,$dst) {
        $dir = opendir($src);
        if (!is_dir($dst)) {
            mkdir($dst, 0777, true);
        }
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    //calculate ago time function
    function time_elapsed_string($datetime,$nowDatetime, $full = false) {
        $now = new DateTime($nowDatetime);
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
    function is_connected()
    {
        $response = null;
     system("ping -c 1 https://www.w3highschools.com", $response);
        if($response == 0)
        {
            // this means you are connected
            $response=true;
        }
        else{
             $response=false;
        }
        return $response;
   }

    function insertdbLog($conn,$desc,$lineNo,$pageName)
    {
        try {
            $stmt=null;
            $stmtlog=null;
            $stmtlog = $conn->prepare('call usp_insert_error_log(:getDesc, :getLineNo, :getPageName)');
            $stmtlog->bindParam(':getDesc', $desc);
            $stmtlog->bindParam(':getLineNo', $lineNo);
            $stmtlog->bindParam(':getPageName', $pageName);
            $stmtlog->execute();
           
        } 
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    
    /*function insertdbLog($desc,$lineNo,$pageName)
    {
       //code
    }*/
}
 