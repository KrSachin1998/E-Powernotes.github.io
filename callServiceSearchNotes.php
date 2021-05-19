<?php
    include("core/connpdo.php");
    include("app_code/sqlhelper.php");
    try{
        if(isset($_POST["action"])){


            if($_POST["action"]=="uni"){        //binding university on page load..
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

            if($_POST["action"]=="college"){        //this is used in filter of search-result.php and index-home.php
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

            if($_POST["action"]=="degree"){         //this is used in filter of search-result.php and index-home.php
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

            if($_POST["action"]=="subject"){        //this is used in filter of search-result.php and index-home.php
                $flag='getsubject';
                $uniId=$_POST["university"];
                $degId=$_POST["degree"];
                $stmt = $conn->prepare('call USP_FILTER_SUBJECT(?,?,?)');
                $stmt->bindParam(1, $flag);  
                $stmt->bindParam(2, $uniId);
                $stmt->bindParam(3, $degId);
                $stmt->execute();  
                foreach($stmt->fetchAll() as $res){
                    $arr[]=array(
                        'subId'=>$res['INT_SUB_ID'],
                        'subName'=>$res['VCH_SUB_NAME']
                    );  
                }
                echo json_encode($arr);    
                                
            }

            if($_POST["action"]=="semester"){        //this is used in filter of search-result.php and index-home.php
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

            if($_POST["action"]=="usersearch"){  //this is used in both search-result.php and index-home.php searchbars..
                $search=$_POST["userQuery"];
                $search="%".$search."%";
                $action=$_POST["action"];
                $count=0;
                $stmt = $conn->prepare('call USP_SEARCH(?,?)');
                $stmt->bindParam(1, $action);
                $stmt->bindParam(2, $search);  
                $stmt->execute();
                foreach ($stmt->fetchAll() as $res){
                    $arr[] = array(
                    'notesId'=>$res['INT_NOTES_ID'],
                    'notesTitle' => $res['VCH_TITLE'],
                    'notesDesc' => $res['VCH_DESCRIPTION'],
                    'userName' =>$res['VCH_USER_NAME'],
                    'notesUni' => $res['VCH_UNIVERSITY_NAME'],
                    'notesDeg' => $res['VCH_DEGREE_NAME'],
                    'notesSub' => $res['VCH_SUB_NAME'],
                    'notesSem'=>$res['VCH_SEMESTER'],
                    'notesColl'=>$res['VCH_COLLEGE_NAME']
                    ); 
                    $count++;
                }
                if($count==0){
                    echo json_encode('NoData');
                }
                else{
                    echo json_encode($arr);
                }
                
            }

            if($_POST["action"]=="filter"){         //this is used in filter of search-result.php and index-home.php
                $allvalues=$_POST["values"];
                $columnnames=$_POST["columns"];
                $conditions=$_POST["sendQuery"];

                $query="SELECT nm.INT_NOTES_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,usermas.VCH_USER_NAME,um.VCH_UNIVERSITY_NAME,dm.VCH_DEGREE_NAME,sm.VCH_SUB_NAME,semmas.VCH_SEMESTER,collmas.VCH_COLLEGE_NAME FROM m_notes_master nm INNER JOIN m_university_master um ON nm.INT_UNI_ID=um.INT_UNI_ID
                INNER JOIN m_degree_master dm ON nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_subject_master sm ON nm.INT_SUB_ID=sm.INT_SUB_ID INNER JOIN m_user_mas usermas ON nm.VCH_CREATED_BY=usermas.INT_USER_ID
                INNER JOIN m_semester semmas ON nm.INT_SEM_ID=semmas.INT_SEM_ID INNER JOIN m_college_master collmas ON nm.INT_COLL_ID=collmas.INT_COLL_ID WHERE 
                nm.INT_NOTES_STATUS=1 AND nm.BIT_DELETED_FLAG=0 AND $conditions";

                $stmt=$conn->prepare($query);
                $result=$stmt->execute();
                $count=0;   //this variable is use to count the numbers in array..and if it remains 0 it means array is empty
                if(!$result){       //checking if the code executed successfully..
                    echo json_encode(0);
                }
                else{
                    foreach($stmt->fetchAll() as $res) {
                        $arr[]=array(
                            'notesId'=>$res['INT_NOTES_ID'],
                            'notesTitle' => $res['VCH_TITLE'],
                            'notesDesc' => $res['VCH_DESCRIPTION'],
                            'notesUni' => $res['VCH_UNIVERSITY_NAME'],
                            'notesColl'=>$res['VCH_COLLEGE_NAME'],
                            'notesDeg' => $res['VCH_DEGREE_NAME'],
                            'notesSub' => $res['VCH_SUB_NAME'],
                            'userName' =>$res['VCH_USER_NAME'],
                            'notesSem'=>$res['VCH_SEMESTER']
                        );
                        $count++;  
                    }
                    if($count==0){              //showing 'no data found' if the count is 0 which means array is empty..
                        echo json_encode(1);
                    }     
                    else{
                        echo json_encode($arr);
                    }         
                }
               
            }

            if($_POST["action"]=="notesAfterLogin"){      //this will fetch the notes as he/she login to the account
                $action="notesAfterLogin";                //depending upon the university and college only.. 
                $count=0;
                $uniId=$_POST["uniId"];
                $collId=$_POST["collId"];
                session_start();
                $userId=$_SESSION["id"];
                $stmt = $conn->prepare('call USP_LOGIN_NOTES_BIND(?,?,?)');
                $stmt->bindParam(1, $action);
                $stmt->bindParam(2, $uniId);
                $stmt->bindParam(3, $collId);  
                $stmt->execute();
                foreach ($stmt->fetchAll() as $res) {
                    $arr[] = array(
                    'notesId'=>$res['INT_NOTES_ID'],
                    'notesTitle' => $res['VCH_TITLE'],
                    'notesDesc' => $res['VCH_DESCRIPTION'],
                    'userName' =>$res['VCH_USER_NAME'],
                    'notesUni' => $res['VCH_UNIVERSITY_NAME'],
                    'notesDeg' => $res['VCH_DEGREE_NAME'],
                    'notesSub' => $res['VCH_SUB_NAME'],
                    'notesSem'=>$res['VCH_SEMESTER'],
                    'notesColl'=>$res['VCH_COLLEGE_NAME']
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
            
            if($_POST["action"]=="searchAllNotesFiles"){       //finding the files of notes A/C  to notes master id..
                $action="searchAllNotesFiles";
                $notesMasId=$_POST["notesId"];
                $stmt = $conn->prepare('call USP_SEARCH_NOTES_FILES(?,?)');
                $stmt->bindParam(1, $action);
                $stmt->bindParam(2, $notesMasId);
                $stmt->execute();
                foreach ($stmt->fetchAll() as $res) {
                    $arr[] = array(
                    'notesPath'=>$res["VCH_NOTES_PATH"],   
                    'userProfilePath'=>$res["VCH_PROFILE_NAME_PATH"],
                    'notesId'=>$res["INT_NOTES_ID"],
                    'notesTitle'=>$res["VCH_TITLE"],
                    'notesDesc'=>$res["VCH_DESCRIPTION"],
                    'userName'=>$res["VCH_USER_NAME"],
                    'notesUni'=>$res["VCH_UNIVERSITY_NAME"],
                    'notesDeg'=>$res["VCH_DEGREE_NAME"],
                    'notesSub'=>$res["VCH_SUB_NAME"],
                    'notesSem'=>$res["VCH_SEMESTER"],
                    'notesColl'=>$res["VCH_COLLEGE_NAME"]
                    );
                }
                echo json_encode($arr);      
            }
            

            if($_POST["action"]=="likeNotes"){          //codes for like notes..

                //$checkSql="SELECT "
                $countPresent=0;
                $totLikes=0;
                $action="likeNotes";
                $userId=$_POST["userid"];
                $actionToTake=$_POST["setkey"];
                $notesId=$_POST["notesid"];
                $sqlCheck="SELECT nld.INT_USER_ID,nld.INT_NOTES_ID,nld.VCH_USER_ACTION,nm.INT_TOTAL_LIKES,nm.INT_TOTAL_DISLIKES
                 FROM t_notes_likes_dislikes nld INNER JOIN m_notes_master nm ON nld.INT_NOTES_ID=nm.INT_NOTES_ID WHERE nld.INT_USER_ID=$userId AND nld.INT_NOTES_ID=$notesId";
                $stmt=$conn->prepare($sqlCheck);
                $resu=$stmt->execute();
                foreach ($stmt->fetchAll() as $res) {
                    $prevAction = $res["VCH_USER_ACTION"];
                    $totLikes=$res["INT_TOTAL_LIKES"];
                    $totDislike=$res["INT_TOTAL_DISLIKES"];
                    $countPresent++;
                }

                if($prevAction==$actionToTake){
                    $totLikes--;
                }

                if($countPresent==0){
                    $totLikes++;
                    $insSql1="INSERT INTO t_notes_likes_dislikes(INT_USER_ID,INT_NOTES_ID,VCH_USER_ACTION,VCH_CREATED_BY)
                     VALUES($userId,$notesId,$actionToTake,$userId);";

                    $insSql2="UPDATE m_notes_master SET INT_TOTAL_LIKES=$totLikes
                    WHERE INT_NOTES_ID=$notesId;"; 

                    $stmt=$conn->prepare($insSql1);
                    $stmt=$conn->prepare($insSql2);

                    $resu=$stmt->execute();
                    $resu=$stmt->execute();

                }
            }

            if($_POST["action"]=="userAppHistory"){
                $userId=$_POST["id"];
                $flag="userAppHistory";
                $count=0;
                $stmt = $conn->prepare('call USP_USER_HISTORY(?,?)');
                $stmt->bindParam(1, $flag);
                $stmt->bindParam(2, $userId);
                $stmt->execute();
                foreach ($stmt->fetchAll() as $res) {
                    $arr[] = array(
                        'notesId'=>$res['INT_NOTES_ID'],
                        'notesTitle' => $res['VCH_TITLE'],
                        'notesDesc' => $res['VCH_DESCRIPTION'],
                        'userName' =>$res['VCH_USER_NAME'],
                        'notesUni' => $res['VCH_UNIVERSITY_NAME'],
                        'notesDeg' => $res['VCH_DEGREE_NAME'],
                        'notesSub' => $res['VCH_SUB_NAME'],
                        'notesSem'=>$res['VCH_SEMESTER'],
                        'notesColl'=>$res['VCH_COLLEGE_NAME'],
                        'totalLikes'=>$res['INT_TOTAL_LIKES'],
                        'totaldislikes'=>$res['INT_TOTAL_DISLIKES'],
                        'totaldown'=>$res['INT_TOTAL_DOWNLOADS']
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

            if($_POST["action"]=="userPenHistory"){
                $userId=$_POST["id"];
                $flag="userPenHistory";
                $count=0;
                $stmt = $conn->prepare('call USP_USER_HISTORY(?,?)');
                $stmt->bindParam(1, $flag);
                $stmt->bindParam(2, $userId);
                $stmt->execute();
                foreach ($stmt->fetchAll() as $res) {
                    $arr[] = array(
                        'notesId'=>$res['INT_NOTES_ID'],
                        'notesTitle' => $res['VCH_TITLE'],
                        'notesDesc' => $res['VCH_DESCRIPTION'],
                        'userName' =>$res['VCH_USER_NAME'],
                        'notesUni' => $res['VCH_UNIVERSITY_NAME'],
                        'notesDeg' => $res['VCH_DEGREE_NAME'],
                        'notesSub' => $res['VCH_SUB_NAME'],
                        'notesSem'=>$res['VCH_SEMESTER'],
                        'notesColl'=>$res['VCH_COLLEGE_NAME']
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

            if($_POST["action"]=="userRejHistory"){
                $userId=$_POST["id"];
                $flag="userRejHistory";
                $count=0;
                $stmt = $conn->prepare('call USP_USER_HISTORY(?,?)');
                $stmt->bindParam(1, $flag);
                $stmt->bindParam(2, $userId);
                $stmt->execute();
                foreach ($stmt->fetchAll() as $res) {
                    $arr[] = array(
                        'notesId'=>$res['INT_NOTES_ID'],
                        'notesTitle' => $res['VCH_TITLE'],
                        'notesDesc' => $res['VCH_DESCRIPTION'],
                        'userName' =>$res['VCH_USER_NAME'],
                        'notesUni' => $res['VCH_UNIVERSITY_NAME'],
                        'notesDeg' => $res['VCH_DEGREE_NAME'],
                        'notesSub' => $res['VCH_SUB_NAME'],
                        'notesSem'=>$res['VCH_SEMESTER'],
                        'notesColl'=>$res['VCH_COLLEGE_NAME']
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

            if($_POST["action"]=="deleteAppNotes"){
                $action="deleteAppNotes";
                $notesId=$_POST["notesid"];
                $userId=$_POST["userid"];
                $stmt = $conn->prepare('call USP_DELETE_USER_NOTES(?,?,?)');
                $stmt->bindParam(1, $action);
                $stmt->bindParam(2, $notesId);
                $stmt->bindParam(3, $userId);
                $stmt->execute();
                foreach ($stmt->fetchAll() as $res) {
                    $msg = $res["data"];
                }
                if($msg==1){
                    echo json_encode($msg); 
                }
                else{
                    echo json_encode(0); 
                }
               
            }

            if($_POST["action"]=="deleteRejNotes"){
                $action="deleteRejNotes";
                $notesId=$_POST["notesid"];
                $userId=$_POST["userid"];
                $stmt = $conn->prepare('call USP_DELETE_USER_NOTES(?,?,?)');
                $stmt->bindParam(1, $action);
                $stmt->bindParam(2, $notesId);
                $stmt->bindParam(3, $userId);
                $stmt->execute();
                foreach ($stmt->fetchAll() as $res) {
                    $msg = $res["data"];
                }
                if($msg==1){
                    echo json_encode($msg); 
                }
                else{
                    echo json_encode(0); 
                }
                
            }

            if($_POST["action"]=="userFavNotes"){          // fav and unfav notes for the user..
                $notesId=$_POST["notesid"];
                $userId=$_POST["userid"];
                $stmt = $conn->prepare('call USP_USER_FAV_NOTES(?,?)');
                $stmt->bindParam(1, $notesId);
                $stmt->bindParam(2, $userId);
                $res=$stmt->execute();
                if($res){
                    echo json_encode('done');
                }
                else{
                    echo json_encode(0);
                }
               
            }

            if($_POST["action"]=="getFavNotes"){                   //binding fav notes of the user..
                $action="getFavNotes";
                $userId=$_POST["userid"];
                $count=0;
                $stmt = $conn->prepare('call USP_GET_FAV_NOTES(?,?)');
                $stmt->bindParam(1, $action);
                $stmt->bindParam(2, $userId);
                $stmt->execute();
                foreach ($stmt->fetchAll() as $res) {
                    $arr[] = array(
                        'notesId'=>$res['INT_NOTES_ID'],
                        'notesTitle' => $res['VCH_TITLE'],
                        'notesDesc' => $res['VCH_DESCRIPTION'],
                        'userName' =>$res['VCH_USER_NAME'],
                        'notesUni' => $res['VCH_UNIVERSITY_NAME'],
                        'notesDeg' => $res['VCH_DEGREE_NAME'],
                        'notesSub' => $res['VCH_SUB_NAME'],
                        'notesSem'=>$res['VCH_SEMESTER'],
                        'notesColl'=>$res['VCH_COLLEGE_NAME']
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

            if($_POST["action"]=="getUserFavItems"){        //get ids of all favourite notes os user..
                $action="getUserFavItems";
                $userId=$_POST["userid"];
                $stmt = $conn->prepare('call USP_USER_ALL_FAV(?,?)');
                $stmt->bindParam(1, $action);
                $stmt->bindParam(2, $userId);
                $stmt->execute();
                foreach ($stmt->fetchAll() as $res) {
                    $arr[] = array(
                        'favNotesId'=>$res['INT_NOTES_ID']
                    ); 
                }
                echo json_encode($arr);
                
            }//End of all favourite users

            if($_POST["action"]=="like" || $_POST["action"]=="unlike" ){        //get ids of all favourite notes os user..
                $action=$_POST["action"];
                $userId=$_POST["userid"];
                $notesId=$_POST["id"];
                $stmt = $conn->prepare('call USP_LIKE_DISLIKE_NOTES(:action,:notesId,:userId)');
                $stmt->bindParam(':action', $action);
                $stmt->bindParam(':userId', $userId);
                $stmt->bindParam(':notesId', $notesId);
              $isinserted=  $stmt->execute();               
               if($isinserted){
                foreach ($stmt->fetchAll() as $res) {
                    $arr[] = array(
                        'likecnt'=>$res['likecnt'],
                        'dislikecnt'=>$res['dislikecnt'],
                        'cmt'=>$res['cmt']
                    );
               }
              echo json_encode($arr);
              //echo "liked";
            }
                
               
            }
            if($_POST["action"]=="dislike" || $_POST["action"]=="undislike" ){        //get ids of all favourite notes os user..
                $action=$_POST["action"];
                $userId=$_POST["userid"];
                $notesId=$_POST["id"];
                $stmt = $conn->prepare('call USP_LIKE_DISLIKE_NOTES(:action,:notesId,:userId)');
                $stmt->bindParam(':action', $action);
                $stmt->bindParam(':userId', $userId);
                $stmt->bindParam(':notesId', $notesId);
              $isinserted=  $stmt->execute();               
               if($isinserted){
                foreach ($stmt->fetchAll() as $res) {
                    $arr[] = array(
                        'likecnt'=>$res['likecnt'],
                        'dislikecnt'=>$res['dislikecnt'],
                        'cmt'=>$res['cmt']
                    );
               }
              echo json_encode($arr);
              //echo "liked";
            }
                
               
            }

            if($_POST["action"]=="fav" || $_POST["action"]=="unfav" ){        //get ids of all favourite notes os user..
                $action=$_POST["action"];
                $userId=$_POST["userid"];
                $notesId=$_POST["id"];
                $stmt = $conn->prepare('call USP_USER_FAV_NOTES(:notesId,:userId,:action)');
                $stmt->bindParam(':action', $action);
                $stmt->bindParam(':userId', $userId);
                $stmt->bindParam(':notesId', $notesId);
              $isinserted=  $stmt->execute();               
               if($isinserted){
                foreach ($stmt->fetchAll() as $res) {
                    $arr[] = array(
                        
                        'cmt'=>$res['cmt']
                    );
               }
              echo json_encode($arr);
              
            }
                
               
            }

            if($_POST["action"]=="download" || $_POST["action"]=="undownload" ){        //get ids of all favourite notes os user..
               //code to download zip=====================================
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

                             $zip->addfile($file_folder.$file_name);
                           
                        }

                    /*    if ($handle = opendir( $file_folder))
                        {
                            // Add all files inside the directory
                            while (false !== ($entry = readdir($handle)))
                            {
                                if ($entry != "." && $entry != ".." && !is_dir($file_folder.'/' . $entry))
                                {
                                    $zip->addFile( $file_folder.'/' . $entry);
                                }
                            }
                            closedir($handle);
                        }*/
                     
                         
                         $zip->close(); 

                         if(file_exists($zip_name))  
                         {  
                            //echo $zip_name;  
                            // push to download the zip  
                           /* header('Content-Description: File Transfer');
                              header('Content-type: application/zip');  
                              header('Content-Disposition: attachment; filename="'.basename($zip_name).'"');  
                              header('Expires: 0');
                              header('Cache-Control: must-revalidate');
                              header('Pragma: public');*/
                            //  header('Content-Length: '.filesize($zip_name));
                           //   ob_clean();
                            //  flush();
                            header('Content-Description: File Transfer');
                            header('Content-Type: application/force-download');
                            header("Content-Disposition: attachment; filename=\"" . basename($zip_name) . "\";");
                            header('Content-Transfer-Encoding: binary');
                            header('Expires: 0');
                            header('Cache-Control: must-revalidate');
                            header('Pragma: public');
 
                            readfile($zip_name);
                            
                           //   readfile($zip_name);  
                              // remove zip file is exists in temp path  
                              unlink($zip_name);
                           
                              
                               //code for maintain the log
              
                $stmt = $conn->prepare('call USP_LIKE_DISLIKE_NOTES(:action,:notesId,:userId)');
                $stmt->bindParam(':action', $action);
                $stmt->bindParam(':userId', $userId);
                $stmt->bindParam(':notesId', $notesId);
                $isinserted=  $stmt->execute();               
                if($isinserted){
                    foreach ($stmt->fetchAll() as $res) {
                        $arr[] = array(
                            'cnt'=>$res['cnt'],
                            'cmt'=>$res['cmt']
                            );
                        }
                        echo json_encode($arr);
                    }
                }  
               }  
               else  
               {  
                    $error .= "* You dont have ZIP extension";  
               }  
               //end of code=========================================  
            }
            
            if($_POST["action"]=="triggercalc"){     //this will trigger to calculate total likes and all to bind in leaderboard
                $action="calculate";
                $stmt = $conn->prepare('call USP_CALCULATE_TOT_LDD(?)');
                $stmt->bindParam(1, $action);
                $stmt->execute();
            }

            if($_POST["action"]=="leaderboard"){     //this will fetch data of the leaderboard..
                $action='getTopUser';
                $stmt = $conn->prepare('call USP_GET_TOP_USERS(?)');
                $stmt->bindParam(1, $action);  
                $stmt->execute();
                foreach ($stmt->fetchAll() as $res){
                    $arr[] = array(
                        'profilePath'=>$res["VCH_PROFILE_NAME_PATH"],
                        'userName'=>$res["VCH_USER_NAME"],
                        'uniName'=>$res["VCH_UNIVERSITY_NAME"],
                        'collName'=>$res["VCH_COLLEGE_NAME"],
                        'degName'=>$res["VCH_DEGREE_NAME"],
                        'semName'=>$res["VCH_SEMESTER"],
                        'points'=>$res["points"]
                    );
                }
                echo json_encode($arr);
            }
        
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
