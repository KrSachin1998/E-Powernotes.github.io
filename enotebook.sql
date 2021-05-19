-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2019 at 01:33 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enotebook`
--
CREATE DATABASE IF NOT EXISTS `enotebook` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `enotebook`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `testProcedure` (IN `action` VARCHAR(20), IN `search` VARCHAR(500))  NO SQL
BEGIN
IF action='usersearch' THEN
	 SELECT nm.VCH_TITLE,nm.VCH_DESCRIPTION,um.VCH_UNIVERSITY_NAME,dm.VCH_DEGREE_NAME,sm.VCH_SUB_NAME,nd.VCH_NOTES_PATH FROM m_notes_master nm INNER JOIN m_university_master um ON nm.INT_UNI_ID=um.INT_UNI_ID
INNER JOIN m_degree_master dm ON nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_subject_master sm ON nm.INT_SUB_ID=sm.INT_SUB_ID INNER JOIN t_notes_details nd ON nm.INT_NOTES_ID=nd.INT_NOTES_ID WHERE nm.VCH_TITLE LIKE search OR nm.VCH_DESCRIPTION LIKE search OR um.VCH_UNIVERSITY_NAME LIKE search OR dm.VCH_DEGREE_NAME LIKE search OR sm.VCH_SUB_NAME LIKE search;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_ACTIVATE_ACCOUNT` (IN `userId` BIGINT(20))  NO SQL
BEGIN
 UPDATE m_user_mas SET BIT_USER_ACTIVATED=1 WHERE INT_USER_ID=userId;
   	SELECT 'Account activated successfully.' AS msg;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_ADMIN_BLOG_QUES` (IN `action` VARCHAR(20))  NO SQL
BEGIN
	IF action='getPenQues' THEN
    	select quesmas.INT_ID,quesmas.VCH_TITLE,quesmas.VCH_QUES_DESC,degmas.VCH_DEGREE_NAME,submas.VCH_SUB_NAME from m_question_master quesmas inner join m_degree_master degmas on quesmas.INT_QUES_DEG_ID=degmas.INT_DEG_ID inner join m_subject_master submas on quesmas.INT_QUES_SUB_ID=submas.INT_SUB_ID where quesmas.INT_QUES_STATUS=0 and quesmas.BIT_DELETED_FLAG=0;
    END IF;
    
    IF action='getAppQues' THEN
    	select quesmas.INT_ID,quesmas.VCH_TITLE,quesmas.VCH_QUES_DESC,degmas.VCH_DEGREE_NAME,submas.VCH_SUB_NAME from m_question_master quesmas inner join m_degree_master degmas on quesmas.INT_QUES_DEG_ID=degmas.INT_DEG_ID inner join m_subject_master submas on quesmas.INT_QUES_SUB_ID=submas.INT_SUB_ID where quesmas.INT_QUES_STATUS=1 and quesmas.BIT_DELETED_FLAG=0;
    END IF;
    
    IF action='getRejQues' THEN
    	select quesmas.INT_ID,quesmas.VCH_TITLE,quesmas.VCH_QUES_DESC,degmas.VCH_DEGREE_NAME,submas.VCH_SUB_NAME from m_question_master quesmas inner join m_degree_master degmas on quesmas.INT_QUES_DEG_ID=degmas.INT_DEG_ID inner join m_subject_master submas on quesmas.INT_QUES_SUB_ID=submas.INT_SUB_ID where quesmas.INT_QUES_STATUS=2 and quesmas.BIT_DELETED_FLAG=0;
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_ADMIN_GETDATA` (IN `action` VARCHAR(20), IN `id` INT(10) ZEROFILL)  NO SQL
BEGIN
IF action='getsubject' THEN
	SELECT INT_SUB_ID,VCH_SUB_NAME FROM m_subject_master WHERE INT_DEG_ID=id;
END IF;

IF action='getdegree' THEN
	SELECT INT_DEG_ID,VCH_DEGREE_NAME FROM m_degree_master WHERE BIT_DELETED_FLAG=0;
END IF;

IF action='getsemester' THEN
	SELECT INT_SEM_ID,VCH_SEMESTER FROM m_semester WHERE BIT_DELETED_FLAG=0;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_ADMIN_GETNOTES` (IN `action` VARCHAR(20))  NO SQL
BEGIN
	IF action='pending' THEN
 		SELECT nm.INT_NOTES_ID, userm.INT_USER_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,dm.VCH_DEGREE_NAME,sm.VCH_SEMESTER,subm.VCH_SUB_NAME
FROM m_notes_master nm INNER JOIN m_degree_master dm on 
nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_semester sm on nm.INT_SEM_ID=sm.INT_SEM_ID INNER JOIN m_subject_master subm on nm.INT_SUB_ID=subm.INT_SUB_ID INNER JOIN m_user_mas	userm on userm.INT_USER_ID=nm.VCH_CREATED_BY WHERE nm.INT_NOTES_STATUS=0 
AND nm.BIT_DELETED_FLAG=0;
    END IF;
    
     IF action='approved' THEN
     	SELECT nm.INT_NOTES_ID, userm.INT_USER_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,dm.VCH_DEGREE_NAME,sm.VCH_SEMESTER,subm.VCH_SUB_NAME
FROM m_notes_master nm INNER JOIN m_degree_master dm on 
nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_semester sm on nm.INT_SEM_ID=sm.INT_SEM_ID INNER JOIN m_subject_master subm on nm.INT_SUB_ID=subm.INT_SUB_ID INNER JOIN m_user_mas	userm on userm.INT_USER_ID=nm.VCH_CREATED_BY WHERE nm.INT_NOTES_STATUS=1 AND nm.BIT_DELETED_FLAG=0;
     END IF;
     
     IF action='rejected' THEN
     SELECT nm.INT_NOTES_ID, userm.INT_USER_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,dm.VCH_DEGREE_NAME,sm.VCH_SEMESTER,subm.VCH_SUB_NAME
FROM m_notes_master nm INNER JOIN m_degree_master dm on 
nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_semester sm on nm.INT_SEM_ID=sm.INT_SEM_ID INNER JOIN m_subject_master subm on nm.INT_SUB_ID=subm.INT_SUB_ID INNER JOIN m_user_mas	userm on userm.INT_USER_ID=nm.VCH_CREATED_BY WHERE nm.INT_NOTES_STATUS=2 AND nm.BIT_DELETED_FLAG=0;
     END IF;
     
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_ADMIN_SEARCH` (IN `action` VARCHAR(20), IN `degId` INT(10) ZEROFILL, IN `subId` INT(10) ZEROFILL, IN `semId` INT(10) ZEROFILL)  NO SQL
BEGIN
	IF action="getdatadegsubsempen" THEN
    	
       SELECT nm.INT_NOTES_ID, userm.INT_USER_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,dm.VCH_DEGREE_NAME,sm.VCH_SEMESTER,subm.VCH_SUB_NAME
FROM m_notes_master nm INNER JOIN m_degree_master dm on 
nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_semester sm on nm.INT_SEM_ID=sm.INT_SEM_ID INNER JOIN m_subject_master subm on nm.INT_SUB_ID=subm.INT_SUB_ID INNER JOIN m_user_mas	userm on userm.INT_USER_ID=nm.VCH_CREATED_BY WHERE nm.INT_DEG_ID=degId AND nm.INT_SUB_ID=subId AND nm.INT_SEM_ID=semId AND nm.INT_NOTES_STATUS=0 
AND nm.BIT_DELETED_FLAG=0;   
   	END IF;
    
    IF action="getdatadegsubsemapp" THEN
    	
        SELECT nm.INT_NOTES_ID, userm.INT_USER_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,dm.VCH_DEGREE_NAME,sm.VCH_SEMESTER,subm.VCH_SUB_NAME
FROM m_notes_master nm INNER JOIN m_degree_master dm on 
nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_semester sm on nm.INT_SEM_ID=sm.INT_SEM_ID INNER JOIN m_subject_master subm on nm.INT_SUB_ID=subm.INT_SUB_ID INNER JOIN m_user_mas	userm on userm.INT_USER_ID=nm.VCH_CREATED_BY WHERE nm.INT_DEG_ID=degId AND nm.INT_SUB_ID=subId AND nm.INT_SEM_ID=semId AND nd.INT_NOTES_STATUS=1
AND nm.BIT_DELETED_FLAG=0;        
   	END IF;
    
    IF action="getdatadegsubsemrej" THEN
    
    SELECT nm.INT_NOTES_ID, userm.INT_USER_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,dm.VCH_DEGREE_NAME,sm.VCH_SEMESTER,subm.VCH_SUB_NAME
FROM m_notes_master nm INNER JOIN m_degree_master dm on 
nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_semester sm on nm.INT_SEM_ID=sm.INT_SEM_ID INNER JOIN m_subject_master subm on nm.INT_SUB_ID=subm.INT_SUB_ID INNER JOIN m_user_mas	userm on userm.INT_USER_ID=nm.VCH_CREATED_BY WHERE nm.INT_DEG_ID=degId AND nm.INT_SUB_ID=subId AND nm.INT_SEM_ID=semId AND nd.INT_NOTES_STATUS=2
AND nm.BIT_DELETED_FLAG=0;
    
    END IF;   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_ADMIN_SEARCH_DATE` (IN `action` VARCHAR(20), IN `fromdate` DATE, IN `todate` DATE)  NO SQL
BEGIN
	IF action="getdatadatepen" THEN
    	
	SELECT nm.INT_NOTES_ID, userm.INT_USER_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,dm.VCH_DEGREE_NAME,sm.VCH_SEMESTER,subm.VCH_SUB_NAME
FROM m_notes_master nm INNER JOIN m_degree_master dm on 
nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_semester sm on nm.INT_SEM_ID=sm.INT_SEM_ID INNER JOIN m_subject_master subm on nm.INT_SUB_ID=subm.INT_SUB_ID INNER JOIN m_user_mas	userm on userm.INT_USER_ID=nm.VCH_CREATED_BY WHERE nm.INT_NOTES_STATUS=0 AND nm.BIT_DELETED_FLAG=0 AND nm.DTM_CREATED_DATE BETWEEN fromdate AND todate ;

    END IF;
    
    IF action="getdatadateapp" THEN
    	
	SELECT nm.INT_NOTES_ID, userm.INT_USER_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,dm.VCH_DEGREE_NAME,sm.VCH_SEMESTER,subm.VCH_SUB_NAME
FROM m_notes_master nm INNER JOIN m_degree_master dm on 
nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_semester sm on nm.INT_SEM_ID=sm.INT_SEM_ID INNER JOIN m_subject_master subm on nm.INT_SUB_ID=subm.INT_SUB_ID INNER JOIN m_user_mas	userm on userm.INT_USER_ID=nm.VCH_CREATED_BY WHERE nm.INT_NOTES_STATUS=1 AND nm.BIT_DELETED_FLAG=0 AND nm.DTM_CREATED_DATE BETWEEN fromdate AND todate ;

    END IF;
    
    IF action="getdatadaterej" THEN
    	
	SELECT nm.INT_NOTES_ID, userm.INT_USER_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,dm.VCH_DEGREE_NAME,sm.VCH_SEMESTER,subm.VCH_SUB_NAME
FROM m_notes_master nm INNER JOIN m_degree_master dm on 
nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_semester sm on nm.INT_SEM_ID=sm.INT_SEM_ID INNER JOIN m_subject_master subm on nm.INT_SUB_ID=subm.INT_SUB_ID INNER JOIN m_user_mas	userm on userm.INT_USER_ID=nm.VCH_CREATED_BY WHERE nm.INT_NOTES_STATUS=2 AND nm.BIT_DELETED_FLAG=0 AND nm.DTM_CREATED_DATE BETWEEN fromdate AND todate ;

    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_ALL_REGISTERED` (IN `action` VARCHAR(20))  NO SQL
BEGIN

	IF action='allRegisterUser' THEN
    	SELECT usermas.INT_USER_ID,usermas.VCH_USER_NAME,bm.VCH_BIT_NAME USER_ACTIVATED,usermas.VCH_EMAIL_ID,bbm.VCH_BIT_NAME USER_BLOCKED,bbbm.VCH_BIT_NAME MAIL_SEND FROM m_user_mas usermas inner JOIN m_bit_master bm on usermas.BIT_USER_ACTIVATED=bm.INT_BIT_ID inner join m_bit_master bbm on usermas.BIT_DELETED_FLAG=bbm.INT_BIT_ID inner join m_bit_master bbbm on usermas.BIT_MAIL_SEND=bbbm.INT_BIT_ID WHERE usermas.BIT_DELETED_FLAG=0;
    END IF;
    
    IF action='allBlockedUser' THEN
    	SELECT usermas.INT_USER_ID,usermas.VCH_USER_NAME,bm.VCH_BIT_NAME USER_ACTIVATED,usermas.VCH_EMAIL_ID,bbm.VCH_BIT_NAME USER_BLOCKED,bbbm.VCH_BIT_NAME MAIL_SEND FROM m_user_mas usermas inner JOIN m_bit_master bm on usermas.BIT_USER_ACTIVATED=bm.INT_BIT_ID inner join m_bit_master bbm on usermas.BIT_DELETED_FLAG=bbm.INT_BIT_ID inner join m_bit_master bbbm on usermas.BIT_MAIL_SEND=bbbm.INT_BIT_ID WHERE 
 usermas.BIT_DELETED_FLAG=1;
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_APP_REJ_NOTES` (IN `action` VARCHAR(20), IN `notesId` VARCHAR(50))  NO SQL
BEGIN
	IF action='approve' THEN
    	UPDATE t_notes_details SET INT_NOTES_STATUS=1 WHERE INT_ID IN (notesId);
    END IF;
    
    IF action='reject' THEN
    	UPDATE t_notes_details SET INT_NOTES_STATUS=2 WHERE INT_ID=notesId;
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_CALCULATE_TOT_LDD` (IN `action` VARCHAR(20))  NO SQL
BEGIN
DECLARE totlikes int;
DECLARE totdislikes int;
DECLARE totdownloads int;
DECLARE totpoints int;
	IF action='calculate' THEN
    	set totlikes=(select count(*) from t_notes_likes_dislikes nld inner join m_notes_master nm on nld.int_notes_of_id=nm.VCH_CREATED_BY where nld.int_action=1 AND nld.int_notes_of_id=nm.VCH_CREATED_BY);
        
        set totdislikes=(select count(*) from t_notes_likes_dislikes nld inner join m_notes_master nm on nld.int_notes_of_id=nm.VCH_CREATED_BY where nld.int_action=0 AND nld.int_notes_of_id=nm.VCH_CREATED_BY);
        
        set totdownloads=(select count(*) from t_download_details dod inner join m_notes_master nm on dod.int_notes_id=nm.INT_NOTES_ID where dod.int_notes_of_id=nm.VCH_CREATED_BY);
        
        select totlikes,totdislikes,totdownloads;
        
        
        /*---	updating the totals in notes-master	---*/
        
       /* UPDATE m_notes_master nm inner join t_notes_likes_dislikes nld on nld.int_notes_of_id=nm.VCH_CREATED_BY SET nm.INT_TOTAL_LIKES=totlikes,nm.INT_TOTAL_DISLIKES=totdislikes,nm.INT_TOTAL_DOWNLOADS=totdownloads
where nld.int_notes_of_id=nm.VCH_CREATED_BY;*/
    
    END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_CHANGE_PASSWORD` (IN `userId` INT(10), IN `oldPass` VARCHAR(200), IN `newPass` VARCHAR(200))  NO SQL
BEGIN
DECLARE cnt varchar(200);
	set cnt=(select VCH_PASSWORD from m_user_mas where INT_USER_ID=userId);
	IF (cnt=oldPass) THEN
    	UPDATE m_user_mas set VCH_PASSWORD=newPass where INT_USER_ID=userId;
        SELECT 1 cnt;
    ELSE
    	SELECT 0 cnt;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_CHECKUSER_EMAIL` (IN `action` VARCHAR(20), IN `email` VARCHAR(150))  NO SQL
BEGIN
DECLARE cnt int;
	IF action='checkUserEmail' THEN
    	SELECT COUNT(1) count FROM m_user_mas WHERE VCH_EMAIL_ID=email AND BIT_DELETED_FLAG=0;
    END IF;
    
    IF action='resendActiLink' THEN
    	SET cnt=(SELECT COUNT(1) count FROM m_user_mas WHERE VCH_EMAIL_ID=email AND BIT_DELETED_FLAG=0);
        IF (cnt>0) THEN
        	update m_user_mas set DTM_CREATED_DATE=now() where VCH_EMAIL_ID=email;
            SELECT 1;
            ELSE
            SELECT 0;
        END IF;
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_DELETE_USER_NOTES` (IN `action` VARCHAR(20), IN `notesId` INT(10), IN `userId` INT(10))  NO SQL
BEGIN
 IF action='deleteAppNotes' THEN
 	UPDATE m_notes_master SET BIT_DELETED_FLAG=1 WHERE INT_NOTES_ID=notesId AND INT_NOTES_STATUS=1 AND VCH_CREATED_BY=userId;
    SELECT 1 AS data;
 END IF;
 
 IF action='deleteRejNotes' THEN
 	UPDATE m_notes_master SET BIT_DELETED_FLAG=1 WHERE INT_NOTES_ID=notesId AND INT_NOTES_STATUS=2 AND VCH_CREATED_BY=userId;
    SELECT 1 AS data;
 END IF;
 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_FILTER_SUBJECT` (IN `action` VARCHAR(20), IN `uniId` INT(10), IN `degId` INT(10))  NO SQL
BEGIN

	IF action='getsubject' THEN
    	SELECT INT_SUB_ID,VCH_SUB_NAME FROM m_subject_master WHERE INT_UNI_ID=uniId AND INT_DEG_ID=degId;
	END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_FORGET_PASSWORD` (IN `action` VARCHAR(20), IN `email` VARCHAR(150), IN `pass` VARCHAR(200))  NO SQL
BEGIN
DECLARE userId int;
	IF action='updatePassword' THEN
    
    SET userId=(select INT_USER_ID from m_user_mas where VCH_EMAIL_ID=email);
    
     UPDATE m_user_mas SET VCH_PASSWORD=pass WHERE INT_USER_ID=userId;
     select 1 as data;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_GET_FAV_NOTES` (IN `action` VARCHAR(20), IN `userId` BIGINT(10) ZEROFILL)  NO SQL
BEGIN
	IF action='getFavNotes' THEN
    	
SELECT  
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1) TOTAL_LIKE,
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0) TOTAL_DISLIKE,
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1 AND INT_USER_ID=userId) IS_USER_LIKE,
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0 AND INT_USER_ID=userId) IS_USER_DISLIKE,
 (SELECT COUNT(INT_ACTION)  FROM t_user_fav tuf WHERE tuf.INT_USER_ID=userId and tuf.int_notes_id=nm.INT_NOTES_ID AND tuf.BIT_DELETED_FLAG=0 AND tuf.INT_ACTION=1
 ) AS IS_USER_FAV,


nm.INT_NOTES_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,usermas.VCH_USER_NAME,um.VCH_UNIVERSITY_NAME,
dm.VCH_DEGREE_NAME,sm.VCH_SUB_NAME,semmas.VCH_SEMESTER,
collmas.VCH_COLLEGE_NAME FROM m_notes_master 
nm INNER JOIN m_university_master um ON nm.INT_UNI_ID=um.INT_UNI_ID
INNER JOIN m_degree_master dm ON nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_subject_master sm
ON nm.INT_SUB_ID=sm.INT_SUB_ID INNER JOIN m_user_mas usermas ON nm.VCH_CREATED_BY=usermas.INT_USER_ID
INNER JOIN m_semester semmas ON nm.INT_SEM_ID=semmas.INT_SEM_ID
INNER JOIN m_college_master collmas ON nm.INT_COLL_ID=collmas.INT_COLL_ID inner join t_user_fav favno on nm.INT_NOTES_ID=favno.INT_NOTES_ID
WHERE  
nm.INT_NOTES_STATUS=1 AND nm.BIT_DELETED_FLAG=0 AND favno.INT_USER_ID=userId;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_GET_TOP_USERS` (IN `action` INT(20))  NO SQL
BEGIN
	IF action='getTopUser' THEN
    	select usermas.VCH_USER_NAME,usermas.VCH_PROFILE_NAME_PATH,unimas.VCH_UNIVERSITY_NAME,collmas.VCH_COLLEGE_NAME,degmas.VCH_DEGREE_NAME,semmas.VCH_SEMESTER ,sum(int_total_likes*2 -(int_total_dislikes/4) + int_total_downloads*2) as points from m_notes_master nm inner join m_user_mas usermas inner join m_university_master unimas on usermas.INT_UNI_ID=unimas.INT_UNI_ID inner join m_college_master collmas on usermas.INT_COLLEGE_ID=collmas.INT_COLL_ID inner join m_degree_master degmas on usermas.INT_DEG_ID=degmas.INT_DEG_ID inner join m_semester semmas on usermas.INT_SEM_ID=semmas.INT_SEM_ID where nm.VCH_CREATED_BY=usermas.INT_USER_ID group by nm.VCH_CREATED_BY ORDER by points desc limit 10;
	END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_GET_USERIMAGE` (IN `action` VARCHAR(20), IN `userId` INT(10))  NO SQL
BEGIN
	IF action='getUserImage' THEN
    	SELECT VCH_USER_NAME, VCH_PROFILE_NAME_PATH FROM m_user_mas where INT_USER_ID=userId;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_GET_USER_DATA` (IN `action` VARCHAR(20), IN `email` VARCHAR(200))  NO SQL
BEGIN
	IF action='getUserData' THEN
    	SELECT VCH_USER_NAME,INT_UNI_ID,INT_COLLEGE_ID,INT_DEG_ID,INT_SEM_ID,VCH_MOBILE_NO,VCH_PROFILE_NAME_PATH FROM m_user_mas WHERE VCH_EMAIL_ID=email;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `usp_insert_error_log` (IN `getDesc` VARCHAR(800), IN `getLineNo` VARCHAR(200), IN `getPageName` VARCHAR(600))  NO SQL
BEGIN

INSERT INTO `t_error_log` (`vch_error_desc`, `vch_error_line`, `vch_error_page`) VALUES (getDesc,getLineNo,getPageName);


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_INSERT_MAILSEND` (IN `action` VARCHAR(20), IN `mailTo` VARCHAR(150), IN `mailFrom` VARCHAR(150), IN `mailBody` VARCHAR(500), IN `mailStatus` INT(2), IN `mailModule` VARCHAR(10), IN `userEmail` VARCHAR(150))  NO SQL
BEGIN
DECLARE userId int;
IF action='contactUsEmail' THEN
	SET userId=(SELECT INT_USER_ID FROM m_user_mas WHERE VCH_EMAIL_ID=userEmail);
	INSERT INTO t_mail_details(INT_USER_ID,VCH_TO,VCH_FROM,VCH_BODY,BIT_MAIL_STATUS,VCH_MODULE_NAME,VCH_CREATED_BY) VALUES (userId,mailTo,mailFrom,mailBody,mailStatus,mailModule,userId);	
    
    SELECT 1 AS count;
    
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_LIKE_DISLIKE_NOTES` (IN `action` VARCHAR(20), IN `notesId` INT(10) ZEROFILL, IN `userId` INT(10) ZEROFILL)  NO SQL
BEGIN 
DECLARE notesMasId int;
set notesMasId= (select DISTINCT vch_created_by from m_notes_master where int_notes_id=notesId);
IF action='like' THEN 
INSERT INTO t_notes_likes_dislikes(INT_USER_ID,INT_NOTES_ID,INT_ACTION,VCH_CREATED_BY,INT_NOTES_OF_ID) VALUES(userId,notesId,1,userId,notesMasId)
 on duplicate key update INT_ACTION=1; 
 
 update m_notes_master set int_total_likes=(int_total_likes+1) where int_notes_id=notesId;	/*-- inclreasing the like by one --*/

select (select count(int_ACTION)  from t_notes_likes_dislikes tld WHERE tld.int_notes_id=notesId AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1) as likecnt,
(select count(int_ACTION)  from t_notes_likes_dislikes tld WHERE tld.int_notes_id=notesId AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0) as dislikecnt,
'like' as cmt;

End IF;
 IF action='unlike' THEN 
DELETE FROM t_notes_likes_dislikes WHERE INT_NOTES_ID=notesId AND INT_USER_ID=userId;

 update m_notes_master set int_total_likes=(int_total_likes-1) where int_notes_id=notesId;	/*-- removing the like by one --*/

select (select count(int_ACTION)  from t_notes_likes_dislikes tld WHERE tld.int_notes_id=notesId AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1) as likecnt,
(select count(int_ACTION)  from t_notes_likes_dislikes tld WHERE tld.int_notes_id=notesId AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0) as dislikecnt,
'unlike' as cmt;
 END IF; 
IF action='dislike' THEN 
INSERT INTO t_notes_likes_dislikes(INT_USER_ID,INT_NOTES_ID,INT_ACTION,VCH_CREATED_BY,INT_NOTES_OF_ID) VALUES(userId,notesId,0,userId,notesMasId)
 on duplicate key update INT_ACTION=0; 

 update m_notes_master set int_total_dislikes=(int_total_dislikes+1) where int_notes_id=notesId;	/*-- increasing the dislike by one --*/

select (select count(int_ACTION)  from t_notes_likes_dislikes tld WHERE tld.int_notes_id=notesId AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1) as likecnt,
(select count(int_ACTION)  from t_notes_likes_dislikes tld WHERE tld.int_notes_id=notesId AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0) as dislikecnt,
'dislike' as cmt;

END IF; 
IF action='undislike' THEN 
DELETE FROM t_notes_likes_dislikes WHERE INT_NOTES_ID=notesId AND INT_USER_ID=userId;

update m_notes_master set int_total_dislikes=(int_total_dislikes-1) where int_notes_id=notesId;	/*-- increasing the dislike by one --*/

select (select count(int_ACTION)  from t_notes_likes_dislikes tld WHERE tld.int_notes_id=notesId AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1) as likecnt,
(select count(int_ACTION)  from t_notes_likes_dislikes tld WHERE tld.int_notes_id=notesId AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0) as dislikecnt,
'undislike' as cmt;
 END IF; 
IF action='download' THEN 
INSERT INTO t_download_details(INT_USER_ID,INT_NOTES_ID,INT_CREATED_BY,INT_NOTES_OF_ID) VALUES(userId,notesId,userId,notesMasId);

update m_notes_master set int_total_downloads=(int_total_downloads+1) where int_notes_id=notesId;	/*-- increasing the dislike by one --*/

select count(int_notes_id) as cnt,'download' as cmt from t_download_details;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_LOGIN_NOTES_BIND` (IN `action` INT(20), IN `userId` INT(10), IN `univId` INT(10), IN `collId` INT(10))  NO SQL
BEGIN
IF action='notesAfterLogin' THEN
	SELECT  
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1) TOTAL_LIKE,
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0) TOTAL_DISLIKE,
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1 AND INT_USER_ID=userId) IS_USER_LIKE,
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0 AND INT_USER_ID=userId) IS_USER_DISLIKE,
 (SELECT COUNT(INT_ACTION)  FROM t_user_fav tuf WHERE tuf.INT_USER_ID=userId and tuf.int_notes_id=nm.INT_NOTES_ID AND tuf.BIT_DELETED_FLAG=0 AND tuf.INT_ACTION=1
 ) AS IS_USER_FAV,
nm.INT_NOTES_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,usermas.VCH_USER_NAME,um.VCH_UNIVERSITY_NAME,
dm.VCH_DEGREE_NAME,sm.VCH_SUB_NAME,semmas.VCH_SEMESTER,
collmas.VCH_COLLEGE_NAME FROM m_notes_master 
nm INNER JOIN m_university_master um ON nm.INT_UNI_ID=um.INT_UNI_ID
INNER JOIN m_degree_master dm ON nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_subject_master sm
ON nm.INT_SUB_ID=sm.INT_SUB_ID INNER JOIN m_user_mas usermas ON nm.VCH_CREATED_BY=usermas.INT_USER_ID
INNER JOIN m_semester semmas ON nm.INT_SEM_ID=semmas.INT_SEM_ID
INNER JOIN m_college_master collmas ON nm.INT_COLL_ID=collmas.INT_COLL_ID
WHERE  
nm.INT_NOTES_STATUS=1 AND nm.BIT_DELETED_FLAG=0 AND nm.INT_UNI_ID=univId AND nm.INT_COLL_ID=collId;

END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_REGISTRATION_DATA` (IN `id` INT(20) ZEROFILL, IN `flag` VARCHAR(20) CHARSET utf8)  NO SQL
BEGIN 
IF flag='U' THEN
	SELECT INT_UNI_ID,VCH_UNIVERSITY_NAME FROM m_university_master WHERE BIT_DELETED_FLAG=0;
END IF;

IF flag='R' THEN
	SELECT INT_ROLE_ID,VCH_ROLE FROM m_user_role WHERE BIT_DELETED_FLAG=0;
END IF;

IF flag='C' THEN 
    SELECT cm.INT_COLL_ID,cm.VCH_COLLEGE_NAME FROM m_college_master cm INNER JOIN    
    t_uni_college uc ON cm.INT_COLL_ID=uc.INT_COLLEGE_ID WHERE uc.INT_UNI_ID=id and cm.BIT_DELETED_FLAG=0;
    
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_SEARCH` (IN `action` VARCHAR(20), IN `search` VARCHAR(500), IN `userId` INT UNSIGNED)  NO SQL
BEGIN
IF action='usersearch' THEN
SELECT  
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1) TOTAL_LIKE,
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0) TOTAL_DISLIKE,
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=1 AND INT_USER_ID=userId) IS_USER_LIKE,
(select count(INT_ACTION) from t_notes_likes_dislikes tld WHERE tld.int_notes_id=nm.INT_NOTES_ID AND tld.BIT_DELETED_FLAG=0 AND INT_ACTION=0 AND INT_USER_ID=userId) IS_USER_DISLIKE,
 (SELECT COUNT(INT_ACTION)  FROM t_user_fav tuf WHERE tuf.INT_USER_ID=userId and tuf.int_notes_id=nm.INT_NOTES_ID AND tuf.BIT_DELETED_FLAG=0 AND tuf.INT_ACTION=1
 ) AS IS_USER_FAV,
(select count(int_notes_id) from t_download_details where INT_NOTES_ID=nm.INT_NOTES_ID) as total_downloads,

(select count(int_notes_id) from t_download_details WHERE int_notes_id=nm.INT_NOTES_ID AND INT_USER_ID=userId) IS_USER_DOWNLOAD,

nm.INT_NOTES_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,usermas.VCH_USER_NAME,um.VCH_UNIVERSITY_NAME,
dm.VCH_DEGREE_NAME,sm.VCH_SUB_NAME,semmas.VCH_SEMESTER,
collmas.VCH_COLLEGE_NAME,nm.DTM_CREATED_DATE,sysdate() as current_timestmp FROM m_notes_master 
nm INNER JOIN m_university_master um ON nm.INT_UNI_ID=um.INT_UNI_ID
AND nm.INT_NOTES_STATUS=1 
INNER JOIN m_notes_type nt ON nt.INT_NOTES_TYPE_ID=nm.INT_NOTES_TYPE_ID
AND nt.INT_NOTES_TYPE_ID IN(1,2,3)
INNER JOIN m_degree_master dm ON nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_subject_master sm
ON nm.INT_SUB_ID=sm.INT_SUB_ID INNER JOIN m_user_mas usermas ON nm.VCH_CREATED_BY=usermas.INT_USER_ID
INNER JOIN m_semester semmas ON nm.INT_SEM_ID=semmas.INT_SEM_ID
INNER JOIN m_college_master collmas ON nm.INT_COLL_ID=collmas.INT_COLL_ID
WHERE  

 nm.BIT_DELETED_FLAG=0 AND (nm.VCH_TITLE LIKE search
OR nm.VCH_DESCRIPTION LIKE search
)
OR usermas.VCH_USER_NAME LIKE search;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_SEARCH_NOTES_FILES` (IN `action` VARCHAR(22), IN `notesId` INT(10))  NO SQL
BEGIN
	IF action='searchAllNotesFiles' THEN
    	select 
        (select count(int_action) from t_notes_likes_dislikes where int_action=1 and bit_deleted_flag=0 and int_notes_id=notesId) as total_likes,
          (select count(int_action) from t_notes_likes_dislikes where int_action=0 and bit_deleted_flag=0 and int_notes_id=notesId) as total_dislikes,
        td.VCH_NOTES_PATH,usermas.VCH_PROFILE_NAME_PATH, nm.INT_NOTES_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,usermas.VCH_USER_NAME,um.VCH_UNIVERSITY_NAME,
dm.VCH_DEGREE_NAME,sm.VCH_SUB_NAME,semmas.VCH_SEMESTER,
collmas.VCH_COLLEGE_NAME FROM m_notes_master 
nm INNER JOIN m_university_master um ON nm.INT_UNI_ID=um.INT_UNI_ID
INNER JOIN m_degree_master dm ON nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_subject_master sm
ON nm.INT_SUB_ID=sm.INT_SUB_ID INNER JOIN m_user_mas usermas ON nm.VCH_CREATED_BY=usermas.INT_USER_ID
INNER JOIN m_semester semmas ON nm.INT_SEM_ID=semmas.INT_SEM_ID
INNER JOIN m_college_master collmas ON nm.INT_COLL_ID=collmas.INT_COLL_ID inner join t_notes_details td on nm.INT_NOTES_ID=td.INT_NOTES_ID
WHERE nm.INT_NOTES_ID=notesId 
AND nm.BIT_DELETED_FLAG=0;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_UPDATE_USER_INFO` (IN `name` VARCHAR(150), IN `mobile` VARCHAR(20), IN `uniId` INT(20) ZEROFILL, IN `collId` INT(20) ZEROFILL, IN `degId` INT(20) ZEROFILL, IN `semId` INT(20) ZEROFILL, IN `profilePath` VARCHAR(500), IN `email` VARCHAR(200))  NO SQL
BEGIN
	UPDATE m_user_mas SET VCH_USER_NAME=name,VCH_MOBILE_NO=mobile,INT_UNI_ID=uniId,INT_COLLEGE_ID=collId,INT_DEG_ID=degId,INT_SEM_ID=semId,VCH_PROFILE_NAME_PATH=profilePath WHERE VCH_EMAIL_ID=email;
    select 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_UPLOADNOTES_DATA_BIND` (IN `action` VARCHAR(20), IN `id` INT(20) ZEROFILL)  NO SQL
BEGIN
	IF action='categ' THEN
    	SELECT INT_CATEGORY_ID,VCH_CATEGORY_NAME FROM m_category WHERE BIT_DELETED_FLAG=0;
    END IF;
    
    IF action='uni' THEN
    	SELECT INT_UNI_ID,VCH_UNIVERSITY_NAME FROM m_university_master WHERE BIT_DELETED_FLAG=0;
    END IF;
    
    IF action='getcoll' THEN
    	SELECT cm.INT_COLL_ID,cm.VCH_COLLEGE_NAME FROM m_college_master cm INNER JOIN    
    t_uni_college uc ON cm.INT_COLL_ID=uc.INT_COLLEGE_ID WHERE uc.INT_UNI_ID=id and cm.BIT_DELETED_FLAG=0;
    END IF;
    
    IF action='getdegree' THEN
    	SELECT dm.INT_DEG_ID,dm.VCH_DEGREE_NAME FROM m_degree_master dm INNER JOIN 
	t_college_degree cd ON dm.INT_DEG_ID=cd.INT_DEGREE_ID WHERE cd.INT_COLLEGE_ID=id and dm.BIT_DELETED_FLAG=0;
    END IF;
    
    IF action='getsemester' THEN
    	SELECT sm.INT_SEM_ID,sm.VCH_SEMESTER FROM m_semester sm INNER JOIN    
    t_degree_semester ds ON sm.INT_SEM_ID=ds.INT_SEMESTER_ID WHERE ds.INT_DEGREE_ID=id and ds.BIT_DELETED_FLAG=0;
    END IF;
    
    IF action='getnotestype' THEN
    	SELECT INT_NOTES_TYPE_ID,VCH_NOTES_TYPE_NAME FROM m_notes_type WHERE BIT_DELETED_FLAG=0;
    END IF;
    
 /*----	flags to bind data into upload page	-----*/   
 
    IF action='uniForUpl' THEN
    	SELECT INT_UNI_ID,VCH_UNIVERSITY_NAME FROM m_university_master WHERE BIT_DELETED_FLAG=0 AND INT_UNI_ID<>5;
    END IF;
    
    IF action='getcollForUpl' THEN
    	SELECT cm.INT_COLL_ID,cm.VCH_COLLEGE_NAME FROM m_college_master cm INNER JOIN    
    t_uni_college uc ON cm.INT_COLL_ID=uc.INT_COLLEGE_ID WHERE uc.INT_UNI_ID=id and cm.BIT_DELETED_FLAG=0 AND cm.INT_COLL_ID<>6;
    END IF;
    
    IF action='getdegreeForUpl' THEN
    	SELECT dm.INT_DEG_ID,dm.VCH_DEGREE_NAME FROM m_degree_master dm INNER JOIN 
	t_college_degree cd ON dm.INT_DEG_ID=cd.INT_DEGREE_ID WHERE cd.INT_COLLEGE_ID=id and dm.BIT_DELETED_FLAG=0 AND dm.INT_DEG_ID<>3;
    END IF;
    
    IF action='getsemesterForUpl' THEN
    	SELECT sm.INT_SEM_ID,sm.VCH_SEMESTER FROM m_semester sm INNER JOIN    
    t_degree_semester ds ON sm.INT_SEM_ID=ds.INT_SEMESTER_ID WHERE ds.INT_DEGREE_ID=id and ds.BIT_DELETED_FLAG=0 AND sm.INT_SEM_ID<>9;
    END IF;
    
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_UPLOADNOTES_SUBJECT` (IN `action` VARCHAR(20), IN `categId` INT(20) ZEROFILL, IN `uniId` INT(20) ZEROFILL, IN `degId` INT(20) ZEROFILL)  NO SQL
BEGIN

	IF action='getsubject' THEN
    	SELECT INT_SUB_ID,VCH_SUB_NAME FROM m_subject_master WHERE INT_CATEGORY_ID=categId AND INT_UNI_ID=uniId AND INT_DEG_ID=degId;
	END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_UPLOAD_BLOG_QUES` (IN `action` VARCHAR(20), IN `title` VARCHAR(150), IN `categ` INT(10), IN `uni` INT(10), IN `coll` INT(10), IN `deg` INT(10), IN `sub` INT(10), IN `descr` VARCHAR(700), IN `userId` INT(10))  NO SQL
BEGIN
IF action='askQuestion' THEN
	INSERT INTO m_question_master(VCH_TITLE,INT_QUES_CATEG_ID,INT_QUES_UNI_ID,INT_QUES_COLL_ID,INT_QUES_DEG_ID,INT_QUES_SUB_ID,	VCH_QUES_DESC,VCH_CREATED_BY)
    VALUES (title,categ,uni,coll,deg,sub,descr,userId);
    select 1 as msg;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_UPLOAD_NOTES` (IN `action` VARCHAR(20), IN `uniId` INT(20) ZEROFILL, IN `collId` INT(20) ZEROFILL, IN `degId` INT(20) ZEROFILL, IN `subId` INT(20) ZEROFILL, IN `categId` INT(20) ZEROFILL, IN `notesTypeId` INT(20) ZEROFILL, IN `notesPath` VARCHAR(200), IN `title` VARCHAR(80), IN `descr` VARCHAR(300))  NO SQL
BEGIN
	IF action='uploadNotes' THEN
		INSERT INTO m_notes_master(	INT_UNI_ID,INT_COLL_ID,	INT_DEG_ID,INT_SUB_ID,INT_CATEGORY_ID,INT_NOTES_TYPE_ID,VCH_NOTES_PATH,VCH_TITLE,VCH_DESCRIPTION)
        VALUES(uniId,collId,degId,subId,categId,notesTypeId,notesPath,title,descr);
        
        SELECT 1;
  END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_USER_ALL_FAV` (IN `action` VARCHAR(20), IN `userId` INT(10))  NO SQL
BEGIN
	IF action='getUserFavItems' THEN
    	SELECT INT_NOTES_ID FROM t_user_fav WHERE INT_USER_ID=userId;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_USER_FAV_NOTES` (IN `notesId` INT(10) ZEROFILL, IN `userId` INT(10) ZEROFILL, IN `action` VARCHAR(20))  NO SQL
BEGIN
	IF action='fav' THEN
    	INSERT INTO t_user_fav(INT_USER_ID,INT_NOTES_ID,INT_ACTION) VALUES(userId,notesId,1)
         ON DUPLICATE KEY UPDATE INT_ACTION=1;
         SELECT 'fav' as cmt FROM t_user_fav WHERE INT_USER_ID=userId
         and INT_NOTES_ID=notesId and INT_ACTION=1 AND BIT_DELETED_FLAG=0;
        END IF;
   	IF action='unfav' THEN
        DELETE FROM t_user_fav WHERE INT_USER_ID=userId AND INT_NOTES_ID=notesId;
        SELECT 'unfav' as cmt ;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_USER_HISTORY` (IN `action` VARCHAR(20), IN `userid` INT(10) ZEROFILL)  NO SQL
BEGIN
	IF action='userAppHistory' THEN
    	SELECT nm.INT_NOTES_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,usermas.VCH_USER_NAME,um.VCH_UNIVERSITY_NAME,dm.VCH_DEGREE_NAME,sm.VCH_SUB_NAME,semmas.VCH_SEMESTER,collmas.VCH_COLLEGE_NAME,nm.INT_TOTAL_LIKES,nm.INT_TOTAL_DISLIKES,nm.INT_TOTAL_DOWNLOADS FROM m_notes_master nm INNER JOIN m_university_master um ON nm.INT_UNI_ID=um.INT_UNI_ID
INNER JOIN m_degree_master dm ON nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_subject_master sm ON nm.INT_SUB_ID=sm.INT_SUB_ID INNER JOIN m_user_mas usermas ON nm.VCH_CREATED_BY=usermas.INT_USER_ID
INNER JOIN m_semester semmas ON nm.INT_SEM_ID=semmas.INT_SEM_ID INNER JOIN m_college_master collmas ON nm.INT_COLL_ID=collmas.INT_COLL_ID WHERE
nm.INT_NOTES_STATUS=1 AND nm.BIT_DELETED_FLAG=0 AND usermas.INT_USER_ID=userid;
    END IF;
    
    IF action='userRejHistory' THEN
    	SELECT nm.INT_NOTES_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,usermas.VCH_USER_NAME,um.VCH_UNIVERSITY_NAME,dm.VCH_DEGREE_NAME,sm.VCH_SUB_NAME,semmas.VCH_SEMESTER,collmas.VCH_COLLEGE_NAME FROM m_notes_master nm INNER JOIN m_university_master um ON nm.INT_UNI_ID=um.INT_UNI_ID
INNER JOIN m_degree_master dm ON nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_subject_master sm ON nm.INT_SUB_ID=sm.INT_SUB_ID INNER JOIN m_user_mas usermas ON nm.VCH_CREATED_BY=usermas.INT_USER_ID
INNER JOIN m_semester semmas ON nm.INT_SEM_ID=semmas.INT_SEM_ID INNER JOIN m_college_master collmas ON nm.INT_COLL_ID=collmas.INT_COLL_ID WHERE
nm.INT_NOTES_STATUS=2 AND nm.BIT_DELETED_FLAG=0 AND usermas.INT_USER_ID=userid;
    END IF;
    
    IF action='userPenHistory' THEN
    	SELECT nm.INT_NOTES_ID,nm.VCH_TITLE,nm.VCH_DESCRIPTION,usermas.VCH_USER_NAME,um.VCH_UNIVERSITY_NAME,dm.VCH_DEGREE_NAME,sm.VCH_SUB_NAME,semmas.VCH_SEMESTER,collmas.VCH_COLLEGE_NAME FROM m_notes_master nm INNER JOIN m_university_master um ON nm.INT_UNI_ID=um.INT_UNI_ID
INNER JOIN m_degree_master dm ON nm.INT_DEG_ID=dm.INT_DEG_ID INNER JOIN m_subject_master sm ON nm.INT_SUB_ID=sm.INT_SUB_ID INNER JOIN m_user_mas usermas ON nm.VCH_CREATED_BY=usermas.INT_USER_ID
INNER JOIN m_semester semmas ON nm.INT_SEM_ID=semmas.INT_SEM_ID INNER JOIN m_college_master collmas ON nm.INT_COLL_ID=collmas.INT_COLL_ID WHERE
nm.INT_NOTES_STATUS=0 AND nm.BIT_DELETED_FLAG=0 AND usermas.INT_USER_ID=userid;
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_USER_LOGIN` (IN `email` VARCHAR(80), IN `pass` VARCHAR(80))  NO SQL
BEGIN	
DECLARE user int;
DECLARE cnt int;

SET user=(SELECT COUNT(1) FROM m_user_mas WHERE VCH_EMAIL_ID=email AND VCH_PASSWORD=pass AND BIT_DELETED_FLAG=0);
IF(user<1) THEN
	SELECT '0' AS data;
    ELSE
    SET cnt=(SELECT BIT_USER_ACTIVATED FROM m_user_mas WHERE VCH_EMAIL_ID=email AND VCH_PASSWORD=pass);
    IF(cnt<1) THEN
    	SELECT '1' AS data;
    ELSE
    	/*SELECT '2' as message;*/
        SELECT INT_ROLE_ID AS role,INT_USER_ID AS id,VCH_USER_NAME AS data ,INT_UNI_ID AS uni,INT_COLLEGE_ID AS collId from m_user_mas where VCH_EMAIL_ID=email AND BIT_DELETED_FLAG=0;
	END IF;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_USER_QUESTIONS` (IN `action` VARCHAR(20), IN `userId` INT(10))  NO SQL
BEGIN
	IF action='getPendingQues' THEN
    select quesmas.INT_ID,quesmas.VCH_TITLE,quesmas.VCH_QUES_DESC,categmas.VCH_CATEGORY_NAME,unimas.VCH_UNIVERSITY_NAME,collmas.VCH_COLLEGE_NAME,degmas.VCH_DEGREE_NAME,submas.VCH_SUB_NAME from m_question_master quesmas inner join m_category categmas ON quesmas.INT_QUES_CATEG_ID=categmas.INT_CATEGORY_ID inner join m_university_master unimas on quesmas.INT_QUES_UNI_ID=unimas.INT_UNI_ID inner join m_college_master collmas on quesmas.INT_QUES_COLL_ID=collmas.INT_COLL_ID inner join m_degree_master degmas on quesmas.INT_QUES_DEG_ID=degmas.INT_DEG_ID inner join m_subject_master submas on quesmas.INT_QUES_SUB_ID=submas.INT_SUB_ID where quesmas.VCH_CREATED_BY=userId and quesmas.INT_QUES_STATUS=0 AND quesmas.BIT_DELETED_FLAG=0;
    END IF;
    
    IF action='getLiveQues' THEN
    select quesmas.INT_ID,quesmas.VCH_TITLE,quesmas.VCH_QUES_DESC,categmas.VCH_CATEGORY_NAME,unimas.VCH_UNIVERSITY_NAME,collmas.VCH_COLLEGE_NAME,degmas.VCH_DEGREE_NAME,submas.VCH_SUB_NAME from m_question_master quesmas inner join m_category categmas ON quesmas.INT_QUES_CATEG_ID=categmas.INT_CATEGORY_ID inner join m_university_master unimas on quesmas.INT_QUES_UNI_ID=unimas.INT_UNI_ID inner join m_college_master collmas on quesmas.INT_QUES_COLL_ID=collmas.INT_COLL_ID inner join m_degree_master degmas on quesmas.INT_QUES_DEG_ID=degmas.INT_DEG_ID inner join m_subject_master submas on quesmas.INT_QUES_SUB_ID=submas.INT_SUB_ID where quesmas.VCH_CREATED_BY=userId and quesmas.INT_QUES_STATUS=1 AND quesmas.BIT_DELETED_FLAG=0;
    END IF;
    
    IF action='getRejQues' THEN
    select quesmas.INT_ID,quesmas.VCH_TITLE,quesmas.VCH_QUES_DESC,categmas.VCH_CATEGORY_NAME,unimas.VCH_UNIVERSITY_NAME,collmas.VCH_COLLEGE_NAME,degmas.VCH_DEGREE_NAME,submas.VCH_SUB_NAME from m_question_master quesmas inner join m_category categmas ON quesmas.INT_QUES_CATEG_ID=categmas.INT_CATEGORY_ID inner join m_university_master unimas on quesmas.INT_QUES_UNI_ID=unimas.INT_UNI_ID inner join m_college_master collmas on quesmas.INT_QUES_COLL_ID=collmas.INT_COLL_ID inner join m_degree_master degmas on quesmas.INT_QUES_DEG_ID=degmas.INT_DEG_ID inner join m_subject_master submas on quesmas.INT_QUES_SUB_ID=submas.INT_SUB_ID where quesmas.VCH_CREATED_BY=userId and quesmas.INT_QUES_STATUS=2 AND quesmas.BIT_DELETED_FLAG=0;
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_USER_REGISTER` (IN `action` VARCHAR(80) CHARSET utf8, IN `name` VARCHAR(80) CHARSET utf8, IN `email` VARCHAR(80) CHARSET utf8, IN `password` VARCHAR(80) CHARSET utf8, IN `uni_id` INT(20) ZEROFILL, IN `coll_id` INT(20) ZEROFILL, IN `role_id` INT(20) ZEROFILL)  NO SQL
BEGIN
IF action="registerUser" THEN
	IF(SELECT COUNT(1) FROM m_user_mas WHERE VCH_EMAIL_ID=email)>0 THEN
    	SELECT 1 AS count;
        ELSE
   	INSERT INTO m_user_mas(VCH_USER_NAME,VCH_EMAIL_ID,VCH_PASSWORD,INT_UNI_ID,INT_COLLEGE_ID,INT_ROLE_ID)
	VALUES(name,email,password,uni_id,coll_id,role_id);
    
    SELECT INT_USER_ID AS count FROM m_user_mas WHERE VCH_EMAIL_ID=email;
    
    END IF;
END IF;    
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `SPLIT_STR` (`x` VARCHAR(255), `delim` VARCHAR(12), `pos` INT) RETURNS VARCHAR(255) CHARSET latin1 RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos),
       LENGTH(SUBSTRING_INDEX(x, delim, pos -1)) + 1),
       delim, '')$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_bit_master`
--

CREATE TABLE `m_bit_master` (
  `INT_ID` bigint(5) NOT NULL,
  `INT_BIT_ID` int(5) NOT NULL,
  `VCH_BIT_NAME` varchar(20) NOT NULL,
  `VCH_CREATED_BY` varchar(50) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `VCH_UPDATED_BY` varchar(50) DEFAULT NULL,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_bit_master`
--

INSERT INTO `m_bit_master` (`INT_ID`, `INT_BIT_ID`, `VCH_BIT_NAME`, `VCH_CREATED_BY`, `DTM_CREATED_DATE`, `VCH_UPDATED_BY`, `DTM_UPDATED_DATE`) VALUES
(1, 0, 'FALSE', NULL, '2019-04-22 17:53:17', NULL, NULL),
(2, 1, 'TRUE', NULL, '2019-04-22 17:53:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_category`
--

CREATE TABLE `m_category` (
  `INT_CATEGORY_ID` bigint(20) NOT NULL,
  `VCH_CATEGORY_NAME` varchar(150) NOT NULL,
  `VCH_CREATED_BY` varchar(150) NOT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `VCH_UPDATED_BY` varchar(150) NOT NULL,
  `DTM_UPDATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_category`
--

INSERT INTO `m_category` (`INT_CATEGORY_ID`, `VCH_CATEGORY_NAME`, `VCH_CREATED_BY`, `DTM_CREATED_DATE`, `VCH_UPDATED_BY`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 'Mathematics', 'Mehul', '2019-02-17 00:15:55', '', '2019-02-17 00:15:55', b'0'),
(2, 'Computer', 'Mehul', '2019-02-17 00:15:55', '', '2019-02-17 00:15:55', b'0'),
(3, 'English', 'Mehul', '2019-02-17 00:15:55', '', '2019-02-17 00:15:55', b'0'),
(4, 'Economics', 'Mehul', '2019-02-17 00:15:55', '', '2019-02-17 00:15:55', b'0'),
(5, 'Hindi', 'mehul', '2019-04-14 11:43:02', '', '2019-04-14 11:43:02', b'0'),
(6, 'Physics', '', '2019-04-14 17:08:42', '', '2019-04-14 17:08:42', b'0'),
(7, 'Chemistry', '', '2019-04-14 17:08:42', '', '2019-04-14 17:08:42', b'0'),
(8, 'Geography', 'mehul', '2019-04-14 17:15:27', '', '2019-04-14 17:15:27', b'0'),
(9, 'General knowledge', 'mehul', '2019-04-14 17:38:00', '', '2019-04-14 17:38:00', b'0'),
(10, 'Personality development', 'mehul', '2019-04-14 17:43:46', '', '2019-04-14 17:43:46', b'0'),
(11, 'Business / Management', 'Mehul', '2019-06-09 19:37:00', '', '2019-06-09 19:37:00', b'0'),
(12, 'Accounts', 'Mehul', '2019-06-09 22:26:50', '', '2019-06-09 22:26:50', b'0'),
(13, 'Research', 'Mehul', '2019-06-09 22:38:19', '', '2019-06-09 22:38:19', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `m_college_master`
--

CREATE TABLE `m_college_master` (
  `INT_COLL_ID` bigint(100) NOT NULL,
  `VCH_COLLEGE_NAME` varchar(150) DEFAULT NULL,
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime DEFAULT CURRENT_TIMESTAMP,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_college_master`
--

INSERT INTO `m_college_master` (`INT_COLL_ID`, `VCH_COLLEGE_NAME`, `VCH_CREATED_BY`, `VCH_UPDATED_BY`, `DTM_CREATED_DATE`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 'Karim City College', 'Mehul', '', '2019-02-08 13:16:15', '0000-00-00 00:00:00', b'0'),
(2, 'Arka Jain', 'Mehul', NULL, NULL, NULL, b'0'),
(3, 'GIIT professional college', 'Mehul', NULL, NULL, NULL, b'0'),
(4, 'Graduate college', NULL, NULL, '2019-04-14 16:55:06', NULL, b'0'),
(5, 'Others', NULL, NULL, '2019-05-30 18:25:58', NULL, b'0'),
(6, 'NA [if you are not associated with any college]', NULL, NULL, '2019-06-06 11:10:13', NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `m_degree_master`
--

CREATE TABLE `m_degree_master` (
  `INT_DEG_ID` bigint(255) NOT NULL,
  `VCH_DEGREE_NAME` varchar(150) DEFAULT NULL,
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime DEFAULT NULL,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_degree_master`
--

INSERT INTO `m_degree_master` (`INT_DEG_ID`, `VCH_DEGREE_NAME`, `VCH_CREATED_BY`, `VCH_UPDATED_BY`, `DTM_CREATED_DATE`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(0, 'NA [if you are not associated with any degree]', NULL, NULL, '2019-02-15 00:00:00', NULL, b'1'),
(1, 'BCA', 'MEHUL', 'MEHUL', '2019-02-08 13:09:49', '0000-00-00 00:00:00', b'0'),
(2, 'BSC.IT', 'MEHUL', 'MEHUL', '2019-02-08 13:12:52', NULL, b'0'),
(3, 'NA [if you are not associated with any degree]', 'mehul', NULL, NULL, NULL, b'0'),
(4, 'BBA', 'Mehul', NULL, NULL, NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `m_notes_master`
--

CREATE TABLE `m_notes_master` (
  `INT_NOTES_ID` bigint(100) NOT NULL,
  `INT_UNI_ID` bigint(100) NOT NULL,
  `INT_COLL_ID` bigint(100) NOT NULL,
  `INT_DEG_ID` bigint(100) NOT NULL,
  `INT_SUB_ID` bigint(100) NOT NULL,
  `INT_SEM_ID` bigint(10) DEFAULT NULL,
  `INT_CATEGORY_ID` bigint(20) NOT NULL,
  `INT_NOTES_TYPE_ID` bigint(100) NOT NULL,
  `VCH_TITLE` varchar(150) NOT NULL,
  `VCH_DESCRIPTION` varchar(500) NOT NULL,
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `INT_NOTES_STATUS` bigint(10) DEFAULT '0',
  `INT_TOTAL_LIKES` bigint(10) NOT NULL DEFAULT '0',
  `INT_TOTAL_DISLIKES` bigint(10) NOT NULL DEFAULT '0',
  `INT_TOTAL_DOWNLOADS` bigint(10) NOT NULL DEFAULT '0',
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_notes_master`
--

INSERT INTO `m_notes_master` (`INT_NOTES_ID`, `INT_UNI_ID`, `INT_COLL_ID`, `INT_DEG_ID`, `INT_SUB_ID`, `INT_SEM_ID`, `INT_CATEGORY_ID`, `INT_NOTES_TYPE_ID`, `VCH_TITLE`, `VCH_DESCRIPTION`, `VCH_CREATED_BY`, `INT_NOTES_STATUS`, `INT_TOTAL_LIKES`, `INT_TOTAL_DISLIKES`, `INT_TOTAL_DOWNLOADS`, `VCH_UPDATED_BY`, `DTM_CREATED_DATE`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 1, 1, 1, 6, 1, 1, 1, 'hello', 'this is notes', '14', 1, 1, 2, 0, NULL, '2019-05-08 13:17:55', NULL, b'0'),
(2, 1, 1, 1, 1, 2, 1, 1, 'testing 1', 'this is testing 1', '15', 1, 2, 0, 0, NULL, '2019-05-08 13:18:26', NULL, b'0'),
(3, 1, 3, 1, 16, 2, 2, 1, 'this is testing 2', 'this is testing 2', '14', 1, 2, 1, 0, NULL, '2019-05-08 13:19:04', NULL, b'0'),
(4, 1, 1, 1, 1, 1, 1, 1, 'probability', 'notes of probability', '14', 1, 0, 0, 0, NULL, '2019-05-13 21:24:26', NULL, b'0'),
(5, 1, 1, 1, 1, 1, 1, 1, 'hello', 'first uploading after file compression', '14', 1, 0, 0, 0, NULL, '2019-05-20 23:14:29', NULL, b'0'),
(6, 1, 1, 1, 1, 1, 1, 1, 'hello', 'this is testing 5 for file compression', '14', 1, 0, 0, 0, NULL, '2019-05-20 23:43:00', NULL, b'0'),
(7, 1, 1, 1, 1, 1, 1, 1, 'hello', 'this is testing 5th with multiple files pdf and image', '14', 1, 0, 0, 0, NULL, '2019-05-21 00:13:07', NULL, b'0'),
(8, 1, 1, 1, 3, 2, 2, 1, 'hello', 'afsdcs ds sd sd', '14', 0, 0, 0, 0, NULL, '2019-06-12 23:25:52', NULL, b'0'),
(9, 1, 1, 1, 1, 1, 1, 1, 'hello', 'defe cwc d  sd', '14', 0, 0, 0, 0, NULL, '2019-06-12 23:45:11', NULL, b'0'),
(10, 1, 1, 1, 6, 2, 1, 1, 'hello', 'gh  jh jhj  hbjn', '14', 0, 0, 0, 0, NULL, '2019-06-12 23:52:20', NULL, b'0'),
(11, 1, 1, 1, 1, 1, 1, 1, 'hello', 'gecds  scs ccx xc c', '14', 0, 0, 0, 0, NULL, '2019-06-12 23:57:51', NULL, b'0'),
(12, 1, 1, 1, 1, 2, 1, 1, 'testing file clear', '3 files', '14', 0, 0, 0, 0, NULL, '2019-06-13 00:02:52', NULL, b'0'),
(13, 1, 1, 1, 1, 1, 1, 1, 'testing 2 uploads', 'testing 2 file uploading', '14', 0, 0, 0, 0, NULL, '2019-06-13 00:45:45', NULL, b'0'),
(14, 1, 1, 1, 1, 1, 1, 1, 'hello', 'hello', '14', 0, 0, 0, 0, NULL, '2019-06-13 11:12:28', NULL, b'0'),
(15, 1, 1, 1, 1, 1, 1, 1, 'hello', 'hello', '14', 0, 0, 0, 0, NULL, '2019-06-13 11:14:44', NULL, b'0'),
(16, 1, 1, 1, 1, 1, 1, 1, 'testing 1', 'testing 2', '14', 0, 0, 0, 0, NULL, '2019-06-13 11:17:06', NULL, b'0'),
(17, 1, 1, 1, 1, 1, 1, 1, 'hello', 'hello', '14', 0, 0, 0, 0, NULL, '2019-06-13 11:26:10', NULL, b'0'),
(18, 1, 1, 1, 1, 1, 1, 1, 'hello', 'hello', '14', 0, 0, 0, 0, NULL, '2019-06-13 11:30:18', NULL, b'0'),
(19, 1, 1, 1, 1, 1, 1, 1, 'hello', 'hello', '14', 0, 0, 0, 0, NULL, '2019-06-13 11:31:18', NULL, b'0'),
(20, 1, 1, 1, 1, 1, 1, 1, 'hello', 'axs', '14', 0, 0, 0, 0, NULL, '2019-06-13 11:32:03', NULL, b'0'),
(21, 1, 1, 1, 6, 1, 1, 1, 'hello', 'jnkmkm', '14', 0, 0, 0, 0, NULL, '2019-06-13 15:05:57', NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `m_notes_status`
--

CREATE TABLE `m_notes_status` (
  `INT_ID` bigint(20) NOT NULL,
  `VCH_STATUS_NAME` varchar(50) NOT NULL,
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_notes_status`
--

INSERT INTO `m_notes_status` (`INT_ID`, `VCH_STATUS_NAME`, `VCH_CREATED_BY`, `DTM_CREATED_DATE`, `VCH_UPDATED_BY`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(0, 'Pending', 'Mehul', '2019-03-21 13:37:36', NULL, NULL, b'0'),
(1, 'Approved', 'Mehul', '2019-03-21 13:37:36', NULL, NULL, b'0'),
(2, 'Rejected', 'Mehul', '2019-03-21 13:37:36', NULL, NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `m_notes_type`
--

CREATE TABLE `m_notes_type` (
  `INT_NOTES_TYPE_ID` bigint(100) NOT NULL,
  `VCH_NOTES_TYPE_NAME` varchar(150) NOT NULL,
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime DEFAULT CURRENT_TIMESTAMP,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_notes_type`
--

INSERT INTO `m_notes_type` (`INT_NOTES_TYPE_ID`, `VCH_NOTES_TYPE_NAME`, `VCH_CREATED_BY`, `VCH_UPDATED_BY`, `DTM_CREATED_DATE`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 'Notes', 'Mehul', NULL, '2019-02-17 01:25:29', NULL, b'0'),
(2, 'Assignments', 'Mehul', NULL, '2019-02-17 01:25:29', NULL, b'0'),
(3, 'Question paper', 'Mehul', NULL, '2019-02-17 01:25:29', NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `m_question_master`
--

CREATE TABLE `m_question_master` (
  `INT_ID` bigint(20) NOT NULL,
  `VCH_TITLE` varchar(200) NOT NULL,
  `INT_QUES_CATEG_ID` bigint(20) NOT NULL,
  `INT_QUES_UNI_ID` bigint(20) NOT NULL,
  `INT_QUES_COLL_ID` bigint(20) NOT NULL,
  `INT_QUES_DEG_ID` bigint(20) NOT NULL,
  `INT_QUES_SUB_ID` bigint(20) NOT NULL,
  `VCH_QUES_DESC` varchar(500) NOT NULL,
  `INT_QUES_STATUS` int(2) NOT NULL DEFAULT '0',
  `VCH_CREATED_BY` varchar(40) NOT NULL,
  `VCH_UPDATED_BY` varchar(40) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_question_master`
--

INSERT INTO `m_question_master` (`INT_ID`, `VCH_TITLE`, `INT_QUES_CATEG_ID`, `INT_QUES_UNI_ID`, `INT_QUES_COLL_ID`, `INT_QUES_DEG_ID`, `INT_QUES_SUB_ID`, `VCH_QUES_DESC`, `INT_QUES_STATUS`, `VCH_CREATED_BY`, `VCH_UPDATED_BY`, `DTM_CREATED_DATE`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 'zfsd d adas d as d as das d as das d asd ', 1, 1, 1, 1, 1, 'yufu hvtkycy vyuvu gu gu uy ug gu gufky yr u  g ', 2, '14', NULL, '2019-05-18 14:13:20', NULL, b'0'),
(2, 'zfsd d adas d as d as das d as das d asd ', 1, 1, 1, 1, 1, 'awc sd sd d df s sd sd sdd sd dad ds ', 2, '14', NULL, '2019-05-18 14:15:02', NULL, b'0'),
(3, 'this i squestio with max 20 chars', 1, 1, 1, 1, 1, 'this is desc of the question we have to ask..', 1, '14', NULL, '2019-05-18 14:20:32', NULL, b'0'),
(4, 'zfsd d adas d as d as das d as das d asd ', 1, 1, 1, 1, 1, 'sfs ds sd sd dff fg  df sa d abas f  d', 1, '14', NULL, '2019-05-18 14:31:06', NULL, b'0'),
(5, 'title question of we we we we we', 2, 1, 1, 1, 14, 'sd sd asdasd saa d s s c df v a  s a', 1, '14', NULL, '2019-05-18 17:51:04', NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `m_semester`
--

CREATE TABLE `m_semester` (
  `INT_SEM_ID` bigint(100) NOT NULL,
  `VCH_SEMESTER` varchar(100) NOT NULL,
  `VCH_CREATED_BY` varchar(100) DEFAULT NULL,
  `VCH_UPDATED_BY` varchar(100) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime DEFAULT NULL,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_semester`
--

INSERT INTO `m_semester` (`INT_SEM_ID`, `VCH_SEMESTER`, `VCH_CREATED_BY`, `VCH_UPDATED_BY`, `DTM_CREATED_DATE`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 'Semester 1', NULL, NULL, NULL, NULL, b'0'),
(2, 'Semester 2', NULL, NULL, NULL, NULL, b'0'),
(3, 'Semester 3', NULL, NULL, NULL, NULL, b'0'),
(4, 'Semester 4', NULL, NULL, NULL, NULL, b'0'),
(5, 'Semester 5', NULL, NULL, NULL, NULL, b'0'),
(6, 'Semester 6', NULL, NULL, NULL, NULL, b'0'),
(7, 'Semester 7', NULL, NULL, NULL, NULL, b'0'),
(8, 'Semester 8', NULL, NULL, NULL, NULL, b'0'),
(9, 'NA [if you are not associated with any semester]', 'Mehul', NULL, NULL, NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `m_subject_master`
--

CREATE TABLE `m_subject_master` (
  `INT_SUB_ID` bigint(100) NOT NULL,
  `VCH_SUB_NAME` varchar(150) NOT NULL,
  `INT_UNI_ID` int(100) NOT NULL,
  `INT_DEG_ID` bigint(100) NOT NULL,
  `INT_CATEGORY_ID` bigint(20) NOT NULL,
  `INT_SEM_ID` bigint(100) NOT NULL,
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_subject_master`
--

INSERT INTO `m_subject_master` (`INT_SUB_ID`, `VCH_SUB_NAME`, `INT_UNI_ID`, `INT_DEG_ID`, `INT_CATEGORY_ID`, `INT_SEM_ID`, `VCH_CREATED_BY`, `VCH_UPDATED_BY`, `DTM_CREATED_DATE`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 'Mathematics', 1, 1, 1, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(2, 'Introduction To Computer Science', 1, 1, 2, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(3, 'Programming In C', 1, 1, 2, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(4, 'Communication Skills/Technical English', 1, 1, 3, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(5, 'Datastructure & C++', 1, 1, 2, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(6, 'Probability & Statistics', 1, 1, 1, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(7, 'Logic Design', 1, 1, 2, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(8, 'Managerial Economics', 1, 1, 4, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(9, 'Scientific Computing', 1, 1, 1, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(10, 'Software Engineering Principles', 1, 1, 2, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(11, 'Relational Database Management System', 1, 1, 2, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(12, 'Operating System & Linux Programming', 1, 1, 2, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(13, 'Data Communication And Computer Network', 1, 1, 2, 4, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(14, 'Object Oriented Programming in JAVA', 1, 1, 2, 4, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(15, 'Programming in Visual Basic', 1, 1, 2, 4, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(16, 'Electronic Commerce & Application', 1, 1, 2, 5, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(17, 'Web Technology', 1, 1, 2, 5, '', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(18, 'Computer Graphics & Multimedia', 1, 1, 2, 5, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(19, 'Elective Papers', 1, 1, 2, 6, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(20, 'Distributed Computing', 1, 1, 2, 6, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(21, 'Accounting and Finance Management', 1, 1, 1, 6, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(32, 'Introduction to computer', 2, 1, 2, 1, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(33, 'Programming in C', 2, 1, 2, 1, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(34, 'Discrete Mathematics', 2, 1, 1, 1, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(35, 'Business Communication', 2, 1, 4, 1, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(36, 'hindi', 2, 1, 5, 1, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(37, 'IT Awareness I', 2, 1, 2, 1, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(38, 'Data structure through c', 2, 1, 2, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(39, 'Object oriented programming with C++', 2, 1, 2, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(40, 'Operating system', 2, 1, 2, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(41, 'Numerical & statistical methods', 2, 1, 1, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(42, 'English', 2, 1, 3, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(43, 'IT Awareness II', 2, 1, 2, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(44, 'Programming with java', 2, 1, 2, 3, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(45, 'Design and Analysis of Alogirthms', 2, 1, 2, 3, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(46, 'Digital Electronics', 2, 1, 2, 3, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(47, 'Database Management System', 2, 1, 2, 3, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(48, 'Data communication and networking', 2, 1, 2, 3, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(49, 'Python Programming', 2, 1, 2, 3, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(50, 'Web Programming', 2, 1, 2, 4, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(51, 'Computer Graphics and Animation', 2, 1, 2, 4, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(52, 'Software Engineering', 2, 1, 2, 4, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(53, 'Mobile Application Development', 2, 1, 2, 4, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(54, 'Financial Accounting', 2, 1, 4, 4, 'shubham raj', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(55, 'Introduction to IT', 1, 2, 2, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(56, 'Programming in C', 1, 2, 2, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(60, 'English communication', 1, 2, 3, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(61, 'Digital electronics', 1, 2, 2, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(62, 'Data structure using C++', 1, 2, 2, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(66, 'Environmental science', 1, 2, 8, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(67, 'Operating system', 1, 2, 2, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(68, 'RDBMS', 1, 2, 2, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(69, 'Numerical techniques', 1, 2, 1, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(73, 'General knowledge', 1, 2, 9, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(81, 'Web technology', 1, 2, 2, 4, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(82, 'Java programming', 1, 2, 2, 4, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(83, 'Software engineering', 1, 2, 2, 4, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(84, 'Physics', 1, 2, 6, 4, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(85, 'Chemistry', 1, 2, 7, 4, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(86, 'Maths', 1, 2, 1, 4, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(87, 'Personality development', 1, 2, 10, 4, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(88, 'Windows programming', 1, 2, 2, 5, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(89, 'Data communication & Computer network', 1, 2, 2, 5, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(90, 'Computer graphics & multimedia', 1, 2, 2, 6, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(91, 'Advance web programming', 1, 2, 2, 6, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(92, 'Principle of management', 1, 4, 11, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(93, 'Introduction to business accounting', 1, 4, 11, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(94, 'Business communication', 1, 4, 11, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(95, 'Fundamentals of computer application', 1, 4, 2, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(96, 'Business economics', 1, 4, 4, 1, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(97, 'Organisational behaviour', 1, 4, 11, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(98, 'Environmental science', 1, 4, 8, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(99, 'Business statistics', 1, 4, 1, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(100, 'Introduction to marketing', 1, 4, 11, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(101, 'Business ethics', 1, 4, 11, 2, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(108, 'Human resource management', 1, 4, 12, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(109, 'Legal aspects of business', 1, 4, 11, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(110, 'Basics of cost accounting', 1, 4, 12, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(111, 'Indian economy', 1, 4, 4, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(112, 'Personality development and communication skills', 1, 4, 10, 3, NULL, NULL, '0000-00-00 00:00:00', NULL, b'0'),
(113, 'Research methodology', 1, 4, 13, 4, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(114, 'Management information system', 1, 4, 11, 4, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(115, 'Basics of management accounting', 1, 4, 12, 4, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(116, 'Fundamentals of operational research', 1, 4, 13, 4, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(117, 'Taxation', 1, 4, 12, 4, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(118, 'Strategic management', 1, 4, 11, 5, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(119, 'Financial management', 1, 4, 11, 5, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(120, 'Fundamentals of international business ', 1, 4, 11, 5, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(124, 'Project management', 1, 4, 11, 6, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(125, 'Talent and knowledge management', 1, 4, 11, 6, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(126, 'Introduction to computer	', 2, 2, 2, 1, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(127, 'Programming in C', 2, 2, 2, 1, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(128, 'Discrete Mathematics', 2, 2, 1, 1, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(129, 'Business Communication', 2, 2, 11, 1, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(130, 'Hindi', 2, 2, 5, 1, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(131, 'IT Awareness I', 2, 2, 2, 1, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(132, 'Data structure through c', 2, 2, 2, 2, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(133, 'Object oriented programming with C++', 2, 2, 2, 2, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(134, 'Operating system', 2, 2, 2, 2, '', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(135, 'Numerical & statistical methods', 2, 2, 1, 2, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(136, 'English', 2, 2, 3, 2, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(137, 'IT Awareness II', 2, 2, 2, 2, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(138, 'Programming with java', 2, 2, 2, 3, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(139, 'Design and Analysis of Alogirthms', 2, 2, 2, 3, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(140, 'Microprocessor', 2, 2, 2, 3, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(141, 'Applied mathematics', 2, 2, 1, 3, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(142, 'Database management system', 2, 2, 2, 3, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(143, 'Python Programming', 2, 2, 2, 3, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(144, 'Web Programming', 2, 2, 2, 4, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(145, 'Computer Graphics and Animation', 2, 2, 2, 4, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(146, 'Software Engineering', 2, 2, 2, 4, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(147, 'Mobile Application Development', 2, 2, 2, 4, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0'),
(148, 'Computer oriented statistical techniques', 2, 2, 1, 4, 'Mehul', NULL, '0000-00-00 00:00:00', NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `m_university_master`
--

CREATE TABLE `m_university_master` (
  `INT_UNI_ID` bigint(255) NOT NULL,
  `VCH_UNIVERSITY_NAME` varchar(150) NOT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0',
  `VCH_CREATED_BY` varchar(150) NOT NULL,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime DEFAULT NULL,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_university_master`
--

INSERT INTO `m_university_master` (`INT_UNI_ID`, `VCH_UNIVERSITY_NAME`, `BIT_DELETED_FLAG`, `VCH_CREATED_BY`, `VCH_UPDATED_BY`, `DTM_CREATED_DATE`, `DTM_UPDATED_DATE`) VALUES
(1, 'Kolhan University', b'0', 'Mehul', '', '2019-02-08 17:40:33', '0000-00-00 00:00:00'),
(2, 'Jain University', b'0', 'Mehul', '', '2019-02-10 01:21:43', '0000-00-00 00:00:00'),
(4, 'Others', b'0', '', '', '2019-05-30 00:00:00', '0000-00-00 00:00:00'),
(5, 'NA [if you are not associated with any university]', b'0', 'mehul', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `m_user_mas`
--

CREATE TABLE `m_user_mas` (
  `INT_USER_ID` bigint(100) NOT NULL,
  `VCH_USER_NAME` varchar(150) NOT NULL,
  `VCH_EMAIL_ID` varchar(200) NOT NULL,
  `VCH_PROFILE_NAME_PATH` varchar(500) DEFAULT 'Profile_pic/default-user.png',
  `INT_ROLE_ID` int(20) NOT NULL,
  `VCH_MOBILE_NO` varchar(12) DEFAULT NULL,
  `VCH_PASSWORD` varchar(256) NOT NULL,
  `BIT_USER_ACTIVATED` bit(1) NOT NULL DEFAULT b'0',
  `BIT_MAIL_SEND` bit(1) NOT NULL DEFAULT b'0',
  `INT_UNI_ID` bigint(100) NOT NULL,
  `INT_COLLEGE_ID` bigint(20) NOT NULL,
  `INT_DEG_ID` bigint(100) DEFAULT '0',
  `INT_SEM_ID` bigint(20) DEFAULT '9',
  `DTM_MAX_TIME_LIMIT` time NOT NULL DEFAULT '00:10:00',
  `INT_TOTAL_POINTS` bigint(20) DEFAULT '0',
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime DEFAULT CURRENT_TIMESTAMP,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_user_mas`
--

INSERT INTO `m_user_mas` (`INT_USER_ID`, `VCH_USER_NAME`, `VCH_EMAIL_ID`, `VCH_PROFILE_NAME_PATH`, `INT_ROLE_ID`, `VCH_MOBILE_NO`, `VCH_PASSWORD`, `BIT_USER_ACTIVATED`, `BIT_MAIL_SEND`, `INT_UNI_ID`, `INT_COLLEGE_ID`, `INT_DEG_ID`, `INT_SEM_ID`, `DTM_MAX_TIME_LIMIT`, `INT_TOTAL_POINTS`, `VCH_CREATED_BY`, `VCH_UPDATED_BY`, `DTM_CREATED_DATE`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(14, 'sahilkuma', 'oncodeproject@gmail.com', 'Profile_pic/sahilkuma-plane.jpg', 2, '6203120616', '202020', b'1', b'1', 1, 1, 1, 1, '00:10:00', 10, NULL, NULL, '2019-04-03 22:36:31', NULL, b'0'),
(15, 'mehul', 'mehulsharma1714@gmail.com', 'Profile_pic/mehul-img.jpeg', 2, '', '123456', b'1', b'0', 1, 1, 1, 1, '00:10:00', 10, NULL, NULL, '2019-05-21 14:19:02', NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `m_user_role`
--

CREATE TABLE `m_user_role` (
  `INT_ROLE_ID` int(50) NOT NULL,
  `VCH_ROLE` varchar(150) NOT NULL,
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_user_role`
--

INSERT INTO `m_user_role` (`INT_ROLE_ID`, `VCH_ROLE`, `VCH_CREATED_BY`, `DTM_CREATED_DATE`, `VCH_UPDATED_BY`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 'Admin', '', '2019-02-15 18:13:52', '', '0000-00-00 00:00:00', b'0'),
(2, 'Users', '', '2019-02-15 18:13:52', '', '0000-00-00 00:00:00', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `t_college_degree`
--

CREATE TABLE `t_college_degree` (
  `INT_ID` int(100) NOT NULL,
  `INT_COLLEGE_ID` bigint(50) NOT NULL,
  `INT_DEGREE_ID` bigint(50) NOT NULL,
  `VCH_CREATED_BY` varchar(150) NOT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `VCH_UPDATED_BY` varchar(100) NOT NULL,
  `DTM_UPDATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_college_degree`
--

INSERT INTO `t_college_degree` (`INT_ID`, `INT_COLLEGE_ID`, `INT_DEGREE_ID`, `VCH_CREATED_BY`, `DTM_CREATED_DATE`, `VCH_UPDATED_BY`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 1, 1, 'Mehul', '2019-02-17 21:38:54', '', '2019-02-17 21:38:54', b'0'),
(2, 1, 2, 'Mehul', '2019-02-17 21:38:54', '', '2019-02-17 21:38:54', b'0'),
(3, 2, 1, '', '2019-02-17 21:38:54', '', '2019-02-17 21:38:54', b'0'),
(4, 2, 2, 'mehul', '2019-04-14 11:22:51', '', '2019-04-14 11:22:51', b'0'),
(5, 3, 1, '', '2019-04-14 14:46:10', '', '2019-04-14 14:46:10', b'0'),
(6, 3, 2, '', '2019-04-14 14:46:10', '', '2019-04-14 14:46:10', b'0'),
(7, 4, 1, '', '2019-04-14 16:56:10', '', '2019-04-14 16:56:10', b'0'),
(8, 4, 2, '', '2019-04-14 16:56:10', '', '2019-04-14 16:56:10', b'0'),
(9, 5, 0, '', '2019-05-30 18:30:52', '', '2019-05-30 18:30:52', b'0'),
(10, 6, 3, '', '2019-06-06 11:25:02', '', '2019-06-06 11:25:02', b'0'),
(11, 3, 4, 'Mehul', '2019-06-09 20:00:19', '', '2019-06-09 20:00:19', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `t_degree_semester`
--

CREATE TABLE `t_degree_semester` (
  `INT_ID` int(20) NOT NULL,
  `INT_DEGREE_ID` bigint(20) NOT NULL,
  `INT_SEMESTER_ID` bigint(20) NOT NULL,
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime DEFAULT CURRENT_TIMESTAMP,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_degree_semester`
--

INSERT INTO `t_degree_semester` (`INT_ID`, `INT_DEGREE_ID`, `INT_SEMESTER_ID`, `VCH_CREATED_BY`, `DTM_CREATED_DATE`, `VCH_UPDATED_BY`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 1, 1, 'Mehul', '2019-02-18 01:19:06', NULL, NULL, b'0'),
(2, 1, 2, NULL, '2019-02-18 01:19:06', NULL, NULL, b'0'),
(3, 1, 3, NULL, '2019-02-18 01:19:06', NULL, NULL, b'0'),
(4, 1, 4, NULL, '2019-02-18 01:19:06', NULL, NULL, b'0'),
(5, 1, 5, NULL, '2019-02-18 01:19:06', NULL, NULL, b'0'),
(6, 1, 6, NULL, '2019-02-18 01:19:06', NULL, NULL, b'0'),
(7, 2, 1, NULL, '2019-02-18 01:21:22', NULL, NULL, b'0'),
(8, 2, 2, NULL, '2019-02-18 01:21:22', NULL, NULL, b'0'),
(9, 2, 3, NULL, '2019-02-18 01:21:22', NULL, NULL, b'0'),
(10, 2, 4, NULL, '2019-02-18 01:21:22', NULL, NULL, b'0'),
(11, 2, 5, NULL, '2019-02-18 01:21:22', NULL, NULL, b'0'),
(12, 2, 6, NULL, '2019-02-18 01:21:22', NULL, NULL, b'0'),
(13, 3, 9, NULL, '2019-06-06 11:31:20', NULL, NULL, b'0'),
(14, 4, 1, NULL, '2019-06-09 23:15:48', NULL, NULL, b'0'),
(15, 4, 2, NULL, '2019-06-09 23:15:48', NULL, NULL, b'0'),
(16, 4, 3, NULL, '2019-06-09 23:15:48', NULL, NULL, b'0'),
(17, 4, 4, NULL, '2019-06-09 23:15:48', NULL, NULL, b'0'),
(18, 4, 5, NULL, '2019-06-09 23:15:48', NULL, NULL, b'0'),
(19, 4, 6, NULL, '2019-06-09 23:15:48', NULL, NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `t_download_details`
--

CREATE TABLE `t_download_details` (
  `INT_ID` int(11) NOT NULL,
  `INT_USER_ID` int(11) NOT NULL,
  `INT_NOTES_ID` bigint(20) NOT NULL,
  `INT_CREATED_BY` int(11) NOT NULL,
  `INT_NOTES_OF_ID` bigint(20) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_error_log`
--

CREATE TABLE `t_error_log` (
  `int_error_id` bigint(20) NOT NULL,
  `vch_error_desc` varchar(800) NOT NULL,
  `vch_error_line` varchar(100) NOT NULL,
  `vch_error_page` varchar(500) NOT NULL,
  `dtm_created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_error_log`
--

INSERT INTO `t_error_log` (`int_error_id`, `vch_error_desc`, `vch_error_line`, `vch_error_page`, `dtm_created_date`) VALUES
(1, 'SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens', '142', 'C:\\xampp\\htdocs\\notebook\\callServiceBlogData.php', '2019-05-18 18:29:41'),
(2, 'SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens', '121', 'C:\\xampp\\htdocs\\notebook\\callServiceBlogData.php', '2019-05-18 18:29:41'),
(3, 'SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens', '121', 'C:\\xampp\\htdocs\\notebook\\callServiceBlogData.php', '2019-05-18 18:31:32'),
(4, 'SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens', '142', 'C:\\xampp\\htdocs\\notebook\\callServiceBlogData.php', '2019-05-18 18:31:32'),
(5, 'SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens', '121', 'C:\\xampp\\htdocs\\notebook\\callServiceBlogData.php', '2019-05-18 18:31:39'),
(6, 'SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens', '142', 'C:\\xampp\\htdocs\\notebook\\callServiceBlogData.php', '2019-05-18 18:31:39'),
(7, 'SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens', '121', 'C:\\xampp\\htdocs\\notebook\\callServiceBlogData.php', '2019-05-18 18:35:13'),
(8, 'SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens', '142', 'C:\\xampp\\htdocs\\notebook\\callServiceBlogData.php', '2019-05-18 18:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `t_mail_details`
--

CREATE TABLE `t_mail_details` (
  `INT_MAIL_ID` bigint(20) NOT NULL,
  `INT_USER_ID` bigint(20) DEFAULT '0',
  `VCH_TO` varchar(150) DEFAULT NULL,
  `VCH_FROM` varchar(150) NOT NULL,
  `VCH_BODY` varchar(500) NOT NULL,
  `BIT_MAIL_STATUS` bit(1) NOT NULL DEFAULT b'0',
  `VCH_MODULE_NAME` varchar(150) DEFAULT NULL COMMENT 'CU for contact-us, RE for user-registration, FP for forget password',
  `VCH_CREATED_BY` varchar(100) DEFAULT NULL,
  `VCH_UPDATED_BY` varchar(100) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_mail_details`
--

INSERT INTO `t_mail_details` (`INT_MAIL_ID`, `INT_USER_ID`, `VCH_TO`, `VCH_FROM`, `VCH_BODY`, `BIT_MAIL_STATUS`, `VCH_MODULE_NAME`, `VCH_CREATED_BY`, `VCH_UPDATED_BY`, `DTM_CREATED_DATE`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 15, 'mehul', 'mehul', 'hello mehul', b'1', 'RU', '15', NULL, '2019-05-22 23:23:10', NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `t_notes_details`
--

CREATE TABLE `t_notes_details` (
  `INT_ID` bigint(20) NOT NULL,
  `INT_NOTES_ID` bigint(20) NOT NULL,
  `VCH_NOTES_PATH` varchar(500) NOT NULL,
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_notes_details`
--

INSERT INTO `t_notes_details` (`INT_ID`, `INT_NOTES_ID`, `VCH_NOTES_PATH`, `VCH_CREATED_BY`, `DTM_CREATED_DATE`, `VCH_UPDATED_BY`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 1, 'documents/Kolhan_University/BCA/Mathematics/Probability_&_Statistics/Notes/1408052019094755.png', '14', '2019-05-08 13:17:55', NULL, NULL, b'0'),
(2, 1, 'documents/Kolhan_University/BCA/Mathematics/Probability_&_Statistics/Notes/1408052019094755.png', '14', '2019-05-08 13:17:55', NULL, NULL, b'0'),
(3, 2, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1408052019094826.png', '14', '2019-05-08 13:18:26', NULL, NULL, b'0'),
(4, 2, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1408052019094826.png', '14', '2019-05-08 13:18:26', NULL, NULL, b'0'),
(5, 2, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1408052019094826.jpg', '14', '2019-05-08 13:18:26', NULL, NULL, b'0'),
(6, 2, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1408052019094826.png', '14', '2019-05-08 13:18:26', NULL, NULL, b'0'),
(7, 3, 'documents/Kolhan_University/BCA/Computer/Electronic_Commerce_&_Application/Notes/1408052019094904.png', '14', '2019-05-08 13:19:04', NULL, NULL, b'0'),
(8, 3, 'documents/Kolhan_University/BCA/Computer/Electronic_Commerce_&_Application/Notes/1408052019094904.png', '14', '2019-05-08 13:19:04', NULL, NULL, b'0'),
(9, 3, 'documents/Kolhan_University/BCA/Computer/Electronic_Commerce_&_Application/Notes/1408052019094904.jpg', '14', '2019-05-08 13:19:04', NULL, NULL, b'0'),
(10, 3, 'documents/Kolhan_University/BCA/Computer/Electronic_Commerce_&_Application/Notes/1408052019094904.png', '14', '2019-05-08 13:19:04', NULL, NULL, b'0'),
(11, 3, 'documents/Kolhan_University/BCA/Computer/Electronic_Commerce_&_Application/Notes/1408052019094904.png', '14', '2019-05-08 13:19:05', NULL, NULL, b'0'),
(12, 3, 'documents/Kolhan_University/BCA/Computer/Electronic_Commerce_&_Application/Notes/1408052019094904.png', '14', '2019-05-08 13:19:05', NULL, NULL, b'0'),
(13, 3, 'documents/Kolhan_University/BCA/Computer/Electronic_Commerce_&_Application/Notes/1408052019094904.png', '14', '2019-05-08 13:19:05', NULL, NULL, b'0'),
(14, 4, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413052019175426.pdf', '14', '2019-05-13 21:24:26', NULL, NULL, b'0'),
(15, 5, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1420052019194429445.jpg', '14', '2019-05-20 23:14:29', NULL, NULL, b'0'),
(16, 6, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/142005201920124356.jpg', '14', '2019-05-20 23:43:00', NULL, NULL, b'0'),
(17, 7, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1420052019204306401.pdf', '14', '2019-05-21 00:13:07', NULL, NULL, b'0'),
(18, 7, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1420052019204306456.png', '14', '2019-05-21 00:13:07', NULL, NULL, b'0'),
(19, 8, 'documents/Kolhan_University/BCA/Computer/Programming_In_C/Notes/1412062019195506336.', '14', '2019-06-12 23:25:52', NULL, NULL, b'0'),
(20, 9, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1412062019201308354.', '14', '2019-06-12 23:45:11', NULL, NULL, b'0'),
(21, 10, 'documents/Kolhan_University/BCA/Mathematics/Probability_&_Statistics/Notes/141206201920191960.', '14', '2019-06-12 23:52:20', NULL, NULL, b'0'),
(22, 10, 'documents/Kolhan_University/BCA/Mathematics/Probability_&_Statistics/Notes/1412062019202220451.pdf', '14', '2019-06-12 23:52:20', NULL, NULL, b'0'),
(23, 11, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1412062019202720277.pdf', '14', '2019-06-12 23:57:51', NULL, NULL, b'0'),
(24, 12, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/141206201920323813.pdf', '14', '2019-06-13 00:02:52', NULL, NULL, b'0'),
(25, 12, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1412062019203245262.pdf', '14', '2019-06-13 00:02:52', NULL, NULL, b'0'),
(26, 12, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1412062019203250459.pdf', '14', '2019-06-13 00:02:52', NULL, NULL, b'0'),
(27, 12, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1412062019203252329.pdf', '14', '2019-06-13 00:02:52', NULL, NULL, b'0'),
(28, 13, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1412062019211529222.pdf', '14', '2019-06-13 00:45:45', NULL, NULL, b'0'),
(29, 13, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1412062019211536413.pdf', '14', '2019-06-13 00:45:45', NULL, NULL, b'0'),
(30, 14, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019074228295.pdf', '14', '2019-06-13 11:12:28', NULL, NULL, b'0'),
(31, 14, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019074228234.pdf', '14', '2019-06-13 11:12:28', NULL, NULL, b'0'),
(32, 15, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019074444313.pdf', '14', '2019-06-13 11:14:44', NULL, NULL, b'0'),
(33, 15, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019074444421.pdf', '14', '2019-06-13 11:14:44', NULL, NULL, b'0'),
(34, 16, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019074706143.pdf', '14', '2019-06-13 11:17:06', NULL, NULL, b'0'),
(35, 16, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019074706481.pdf', '14', '2019-06-13 11:17:06', NULL, NULL, b'0'),
(36, 16, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019074706156.pdf', '14', '2019-06-13 11:17:06', NULL, NULL, b'0'),
(37, 17, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019075610474.pdf', '14', '2019-06-13 11:26:10', NULL, NULL, b'0'),
(38, 17, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019075610290.pdf', '14', '2019-06-13 11:26:10', NULL, NULL, b'0'),
(39, 17, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019075610182.pdf', '14', '2019-06-13 11:26:10', NULL, NULL, b'0'),
(40, 18, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019080018432.pdf', '14', '2019-06-13 11:30:18', NULL, NULL, b'0'),
(41, 18, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019080018242.pdf', '14', '2019-06-13 11:30:18', NULL, NULL, b'0'),
(42, 18, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019080018269.pdf', '14', '2019-06-13 11:30:18', NULL, NULL, b'0'),
(43, 19, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/141306201908011879.pdf', '14', '2019-06-13 11:31:18', NULL, NULL, b'0'),
(44, 19, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/141306201908011879.pdf', '14', '2019-06-13 11:31:18', NULL, NULL, b'0'),
(45, 20, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019080203292.pdf', '14', '2019-06-13 11:32:03', NULL, NULL, b'0'),
(46, 20, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019080203188.pdf', '14', '2019-06-13 11:32:03', NULL, NULL, b'0'),
(47, 20, 'documents/Kolhan_University/BCA/Mathematics/Mathematics/Notes/1413062019080203122.pdf', '14', '2019-06-13 11:32:03', NULL, NULL, b'0'),
(48, 21, 'documents/Kolhan_University/BCA/Mathematics/Probability_&_Statistics/Notes/1413062019113557326.pdf', '14', '2019-06-13 15:05:57', NULL, NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `t_notes_likes_dislikes`
--

CREATE TABLE `t_notes_likes_dislikes` (
  `INT_ID` bigint(10) NOT NULL,
  `INT_USER_ID` bigint(10) NOT NULL,
  `INT_NOTES_ID` bigint(10) NOT NULL,
  `INT_ACTION` int(11) NOT NULL DEFAULT '0' COMMENT '1 means like AND 0 MENAS DISLIKE',
  `VCH_CREATED_BY` varchar(200) NOT NULL,
  `INT_NOTES_OF_ID` bigint(20) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `VCH_UPDATED_BY` varchar(200) DEFAULT NULL,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_notes_likes_dislikes`
--

INSERT INTO `t_notes_likes_dislikes` (`INT_ID`, `INT_USER_ID`, `INT_NOTES_ID`, `INT_ACTION`, `VCH_CREATED_BY`, `INT_NOTES_OF_ID`, `DTM_CREATED_DATE`, `VCH_UPDATED_BY`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(39, 15, 2, 1, '15', 15, '2019-05-13 11:16:19', NULL, NULL, b'0'),
(40, 15, 1, 0, '15', 14, '2019-05-13 11:16:35', NULL, NULL, b'0'),
(41, 15, 3, 1, '15', 14, '2019-05-13 11:16:56', NULL, NULL, b'0'),
(42, 14, 2, 1, '14', 15, '2019-05-13 13:43:02', NULL, NULL, b'0'),
(44, 14, 3, 1, '14', 14, '2019-05-13 13:44:09', NULL, NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `t_question_answers`
--

CREATE TABLE `t_question_answers` (
  `INT_ID` bigint(20) NOT NULL,
  `INT_QUES_ID` bigint(20) NOT NULL,
  `VCH_ANSWER` varchar(700) NOT NULL,
  `VCH_CREATED_BY` varchar(150) NOT NULL,
  `VCH_UPDATED_BY` varchar(150) NOT NULL,
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `t_uni_college`
--

CREATE TABLE `t_uni_college` (
  `INT_ID` bigint(100) NOT NULL,
  `INT_UNI_ID` bigint(100) NOT NULL,
  `INT_COLLEGE_ID` bigint(20) NOT NULL,
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `DTM_CREATED_DATE` datetime DEFAULT CURRENT_TIMESTAMP,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_uni_college`
--

INSERT INTO `t_uni_college` (`INT_ID`, `INT_UNI_ID`, `INT_COLLEGE_ID`, `VCH_CREATED_BY`, `VCH_UPDATED_BY`, `DTM_CREATED_DATE`, `DTM_UPDATED_DATE`, `BIT_DELETED_FLAG`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, b'0'),
(2, 2, 2, NULL, NULL, NULL, NULL, b'0'),
(3, 1, 3, NULL, NULL, NULL, NULL, b'0'),
(4, 1, 4, NULL, NULL, NULL, NULL, b'0'),
(5, 4, 5, NULL, NULL, '2019-05-30 18:26:56', NULL, b'0'),
(6, 5, 6, NULL, NULL, '2019-06-06 11:22:57', NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `t_user_fav`
--

CREATE TABLE `t_user_fav` (
  `INT_ID` bigint(10) NOT NULL,
  `INT_USER_ID` bigint(10) NOT NULL,
  `INT_NOTES_ID` bigint(10) NOT NULL,
  `INT_ACTION` int(11) NOT NULL DEFAULT '0' COMMENT '1 means FAV AND 0 MENAS UNFAV',
  `DTM_CREATED_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `VCH_CREATED_BY` varchar(150) DEFAULT NULL,
  `DTM_UPDATED_DATE` datetime DEFAULT NULL,
  `VCH_UPDATED_BY` varchar(150) DEFAULT NULL,
  `BIT_DELETED_FLAG` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_user_fav`
--

INSERT INTO `t_user_fav` (`INT_ID`, `INT_USER_ID`, `INT_NOTES_ID`, `INT_ACTION`, `DTM_CREATED_DATE`, `VCH_CREATED_BY`, `DTM_UPDATED_DATE`, `VCH_UPDATED_BY`, `BIT_DELETED_FLAG`) VALUES
(4, 14, 62, 1, '2019-04-24 09:20:55', NULL, NULL, NULL, b'0'),
(8, 14, 63, 1, '2019-05-04 12:29:33', NULL, NULL, NULL, b'0'),
(11, 14, 1, 1, '2019-05-14 09:59:48', NULL, NULL, NULL, b'0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_bit_master`
--
ALTER TABLE `m_bit_master`
  ADD PRIMARY KEY (`INT_ID`);

--
-- Indexes for table `m_category`
--
ALTER TABLE `m_category`
  ADD PRIMARY KEY (`INT_CATEGORY_ID`);

--
-- Indexes for table `m_college_master`
--
ALTER TABLE `m_college_master`
  ADD PRIMARY KEY (`INT_COLL_ID`);

--
-- Indexes for table `m_degree_master`
--
ALTER TABLE `m_degree_master`
  ADD PRIMARY KEY (`INT_DEG_ID`);

--
-- Indexes for table `m_notes_master`
--
ALTER TABLE `m_notes_master`
  ADD PRIMARY KEY (`INT_NOTES_ID`),
  ADD KEY `INT_UNI_ID` (`INT_UNI_ID`,`INT_COLL_ID`,`INT_DEG_ID`,`INT_SUB_ID`,`INT_NOTES_TYPE_ID`),
  ADD KEY `INT_COLL_ID` (`INT_COLL_ID`),
  ADD KEY `m_notes_master_ibfk_1` (`INT_DEG_ID`),
  ADD KEY `INT_NOTES_TYPE_ID` (`INT_NOTES_TYPE_ID`),
  ADD KEY `INT_SUB_ID` (`INT_SUB_ID`);
ALTER TABLE `m_notes_master` ADD FULLTEXT KEY `VCH_TITLE` (`VCH_TITLE`);

--
-- Indexes for table `m_notes_status`
--
ALTER TABLE `m_notes_status`
  ADD PRIMARY KEY (`INT_ID`);

--
-- Indexes for table `m_notes_type`
--
ALTER TABLE `m_notes_type`
  ADD PRIMARY KEY (`INT_NOTES_TYPE_ID`);

--
-- Indexes for table `m_question_master`
--
ALTER TABLE `m_question_master`
  ADD PRIMARY KEY (`INT_ID`);

--
-- Indexes for table `m_semester`
--
ALTER TABLE `m_semester`
  ADD PRIMARY KEY (`INT_SEM_ID`);

--
-- Indexes for table `m_subject_master`
--
ALTER TABLE `m_subject_master`
  ADD PRIMARY KEY (`INT_SUB_ID`),
  ADD KEY `INT_DEG_ID` (`INT_DEG_ID`),
  ADD KEY `INT_CATEGORY_ID` (`INT_CATEGORY_ID`);

--
-- Indexes for table `m_university_master`
--
ALTER TABLE `m_university_master`
  ADD PRIMARY KEY (`INT_UNI_ID`);

--
-- Indexes for table `m_user_mas`
--
ALTER TABLE `m_user_mas`
  ADD PRIMARY KEY (`INT_USER_ID`),
  ADD UNIQUE KEY `VCH_EMAIL_ID` (`VCH_EMAIL_ID`),
  ADD KEY `INT_UNI_ID` (`INT_UNI_ID`),
  ADD KEY `INT_COLLEGE_ID` (`INT_COLLEGE_ID`);

--
-- Indexes for table `m_user_role`
--
ALTER TABLE `m_user_role`
  ADD PRIMARY KEY (`INT_ROLE_ID`);

--
-- Indexes for table `t_college_degree`
--
ALTER TABLE `t_college_degree`
  ADD PRIMARY KEY (`INT_ID`),
  ADD KEY `INT_COLLEGE_ID` (`INT_COLLEGE_ID`),
  ADD KEY `t_college_degree_ibfk_1` (`INT_DEGREE_ID`);

--
-- Indexes for table `t_degree_semester`
--
ALTER TABLE `t_degree_semester`
  ADD PRIMARY KEY (`INT_ID`),
  ADD KEY `INT_DEGREE_ID` (`INT_DEGREE_ID`),
  ADD KEY `t_degree_semester_ibfk_1` (`INT_SEMESTER_ID`);

--
-- Indexes for table `t_download_details`
--
ALTER TABLE `t_download_details`
  ADD PRIMARY KEY (`INT_ID`);

--
-- Indexes for table `t_error_log`
--
ALTER TABLE `t_error_log`
  ADD PRIMARY KEY (`int_error_id`);

--
-- Indexes for table `t_mail_details`
--
ALTER TABLE `t_mail_details`
  ADD PRIMARY KEY (`INT_MAIL_ID`);

--
-- Indexes for table `t_notes_details`
--
ALTER TABLE `t_notes_details`
  ADD PRIMARY KEY (`INT_ID`),
  ADD KEY `INT_NOTES_ID` (`INT_NOTES_ID`);

--
-- Indexes for table `t_notes_likes_dislikes`
--
ALTER TABLE `t_notes_likes_dislikes`
  ADD PRIMARY KEY (`INT_ID`),
  ADD UNIQUE KEY `INT_USER_ID` (`INT_USER_ID`,`INT_NOTES_ID`);

--
-- Indexes for table `t_question_answers`
--
ALTER TABLE `t_question_answers`
  ADD PRIMARY KEY (`INT_ID`);

--
-- Indexes for table `t_uni_college`
--
ALTER TABLE `t_uni_college`
  ADD PRIMARY KEY (`INT_ID`),
  ADD KEY `t_uni_degree_ibfk_1` (`INT_UNI_ID`),
  ADD KEY `INT_COLLEGE_ID` (`INT_COLLEGE_ID`);

--
-- Indexes for table `t_user_fav`
--
ALTER TABLE `t_user_fav`
  ADD PRIMARY KEY (`INT_ID`),
  ADD UNIQUE KEY `INT_USER_ID` (`INT_USER_ID`,`INT_NOTES_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_bit_master`
--
ALTER TABLE `m_bit_master`
  MODIFY `INT_ID` bigint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_category`
--
ALTER TABLE `m_category`
  MODIFY `INT_CATEGORY_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `m_college_master`
--
ALTER TABLE `m_college_master`
  MODIFY `INT_COLL_ID` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `m_degree_master`
--
ALTER TABLE `m_degree_master`
  MODIFY `INT_DEG_ID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_notes_master`
--
ALTER TABLE `m_notes_master`
  MODIFY `INT_NOTES_ID` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `m_notes_status`
--
ALTER TABLE `m_notes_status`
  MODIFY `INT_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_notes_type`
--
ALTER TABLE `m_notes_type`
  MODIFY `INT_NOTES_TYPE_ID` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_question_master`
--
ALTER TABLE `m_question_master`
  MODIFY `INT_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_semester`
--
ALTER TABLE `m_semester`
  MODIFY `INT_SEM_ID` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `m_subject_master`
--
ALTER TABLE `m_subject_master`
  MODIFY `INT_SUB_ID` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `m_university_master`
--
ALTER TABLE `m_university_master`
  MODIFY `INT_UNI_ID` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_user_mas`
--
ALTER TABLE `m_user_mas`
  MODIFY `INT_USER_ID` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `m_user_role`
--
ALTER TABLE `m_user_role`
  MODIFY `INT_ROLE_ID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_college_degree`
--
ALTER TABLE `t_college_degree`
  MODIFY `INT_ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `t_degree_semester`
--
ALTER TABLE `t_degree_semester`
  MODIFY `INT_ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `t_download_details`
--
ALTER TABLE `t_download_details`
  MODIFY `INT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_error_log`
--
ALTER TABLE `t_error_log`
  MODIFY `int_error_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `t_mail_details`
--
ALTER TABLE `t_mail_details`
  MODIFY `INT_MAIL_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_notes_details`
--
ALTER TABLE `t_notes_details`
  MODIFY `INT_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `t_notes_likes_dislikes`
--
ALTER TABLE `t_notes_likes_dislikes`
  MODIFY `INT_ID` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `t_question_answers`
--
ALTER TABLE `t_question_answers`
  MODIFY `INT_ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `t_uni_college`
--
ALTER TABLE `t_uni_college`
  MODIFY `INT_ID` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_user_fav`
--
ALTER TABLE `t_user_fav`
  MODIFY `INT_ID` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_subject_master`
--
ALTER TABLE `m_subject_master`
  ADD CONSTRAINT `m_subject_master_ibfk_1` FOREIGN KEY (`INT_CATEGORY_ID`) REFERENCES `m_category` (`INT_CATEGORY_ID`);

--
-- Constraints for table `m_user_mas`
--
ALTER TABLE `m_user_mas`
  ADD CONSTRAINT `m_user_mas_ibfk_1` FOREIGN KEY (`INT_COLLEGE_ID`) REFERENCES `m_college_master` (`INT_COLL_ID`);

--
-- Constraints for table `t_college_degree`
--
ALTER TABLE `t_college_degree`
  ADD CONSTRAINT `t_college_degree_ibfk_1` FOREIGN KEY (`INT_DEGREE_ID`) REFERENCES `m_degree_master` (`INT_DEG_ID`);

--
-- Constraints for table `t_degree_semester`
--
ALTER TABLE `t_degree_semester`
  ADD CONSTRAINT `t_degree_semester_ibfk_1` FOREIGN KEY (`INT_SEMESTER_ID`) REFERENCES `m_semester` (`INT_SEM_ID`);

--
-- Constraints for table `t_notes_details`
--
ALTER TABLE `t_notes_details`
  ADD CONSTRAINT `t_notes_details_ibfk_1` FOREIGN KEY (`INT_NOTES_ID`) REFERENCES `m_notes_master` (`INT_NOTES_ID`);

--
-- Constraints for table `t_uni_college`
--
ALTER TABLE `t_uni_college`
  ADD CONSTRAINT `t_uni_college_ibfk_1` FOREIGN KEY (`INT_COLLEGE_ID`) REFERENCES `m_college_master` (`INT_COLL_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
