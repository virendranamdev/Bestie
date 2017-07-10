<?php

if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}

class AchiverStory {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function compress_image($source_url, $destination_url, $quality) {

        $imagevalue = filesize($source_url);
        $valueimage = $imagevalue / 1024;

        if ($valueimage > 40) {
            $info = getimagesize($source_url);

            if ($info['mime'] == 'image/jpeg')
                $image = imagecreatefromjpeg($source_url);
            elseif ($info['mime'] == 'image/gif')
                $image = imagecreatefromgif($source_url);
            elseif ($info['mime'] == 'image/png')
                $image = imagecreatefrompng($source_url);

            //save it
            imagejpeg($image, $destination_url, $quality);

            //return destination file url
            return $destination_url;
        }
        else {
            move_uploaded_file($source_url, $destination_url);
        }
    }

    function maxId() {
        try {
            $max = "select max(storyId) from Tbl_C_AchiverStory";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $postid = $m_id1;

                return $postid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function create_AchiverStory($storyid , $Client_Id, $storytitle,$achievername,$achiveremailid, $achieverdes,$achieverloc , $achieverstory,$coverimg, $device, $Flag, $like, $comment, $Post_Date, $Uuid, $status) {

	
        try {
            $query = "insert into Tbl_C_AchiverStory(clientId, title,achieverName,achiverEmailId, designation, location, story,imagePath,device,flagType,likeType,comment,createdDate,createdBy,status) values(:cid,:title,:name,:email,:desig,:loc,:story,:coverimg,:device,:flg,:liket,:comm,:cd,:cby,:status)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $Client_Id, PDO::PARAM_STR);
	    $stmt->bindParam(':title', $storytitle, PDO::PARAM_STR);
            $stmt->bindParam(':name', $achievername, PDO::PARAM_STR);
             $stmt->bindParam(':email', $achiveremailid, PDO::PARAM_STR);
	    $stmt->bindParam(':desig', $achieverdes, PDO::PARAM_STR);
	    $stmt->bindParam(':loc', $achieverloc, PDO::PARAM_STR);
            $stmt->bindParam(':story', $achieverstory, PDO::PARAM_STR);
             $stmt->bindParam(':coverimg', $coverimg, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);
            $stmt->bindParam(':flg', $Flag, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':liket', $like, PDO::PARAM_STR);
            $stmt->bindParam(':comm', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':cby', $Uuid, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $Post_Date, PDO::PARAM_STR);
			$row = $stmt->execute();
			
					
            if ($row) {
				$response["success"] = 1;
                $response["message"] = "Colleague Story posted successfully";
            }
			else
			{
				$response["success"] = 0;
                $response["message"] = "Colleague Story not posted";
			}
        } catch (PDOException $e) {
				$response["success"] = 0;
                $response["message"] = "Colleague Story not posted".$e;
        }
		return json_encode($response);
    }

    /*     * ************************ SELECT ONE POST FOR MESSAGE WITH SENDR IMAGE AND NAME ******************* */

    public $type;
    public $id;

    function createWelcomeData($cid, $id, $type, $ptitle , $pdate, $by, $flag) {
        $this->client = $cid;
        $this->id = $id;
        $this->type = $type;
        $this->posttitle = $ptitle;
        $this->pdate = $pdate;
        $this->author = $by;
		
        try {
            $query = "insert into Tbl_C_WelcomeDetails(clientId,id,type,title,createdDate,createdBy,flagType)
            values(:cid,:id,:type,:title,:cd,:cb,:flag)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->client, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_STR);
            $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
            $stmt->bindParam(':title', $this->posttitle, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $this->pdate, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $this->author, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
			$row = $stmt->execute();
			
			
            if ($row) {
                $response["success"] = 1;
                $response["message"] = "Colleague Story Inserted successfully";
            }
			else
			{
				$response["success"] = 0;
                $response["message"] = "Colleague Story not Inserted";	
			}
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "Colleague Story not Inserted".$e;
        }
    }

    /*     * ****************************** show achiver list details ************************************* */

    function getAchiverListDetails($clientid) {
        $path = SITE;
        try {

            $query = "SELECT Tbl_C_AchiverStory . * , DATE_FORMAT(Tbl_C_AchiverStory.createdDate,'%d %b %Y %h:%i %p') as createdDate , (
            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostComment
            WHERE Tbl_Analytic_PostComment.postId = Tbl_C_AchiverStory.storyId AND Tbl_Analytic_PostComment.flagType = 16 and Tbl_Analytic_PostComment.status = 'show'
            ) as commentCount, (

            SELECT COUNT( * ) 
            FROM Tbl_Analytic_PostLike
            WHERE Tbl_Analytic_PostLike.postId = Tbl_C_AchiverStory.storyId AND Tbl_Analytic_PostLike.flagType = 16 and Tbl_Analytic_PostLike.status = 1
            ) as likeCount , (

            SELECT COUNT(distinct userUniqueId) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_AchiverStory.storyId AND Tbl_Analytic_PostView.flagType = 16
            ) as ViewPostCount, (

            SELECT COUNT(*) 
            FROM Tbl_Analytic_PostView
            WHERE Tbl_Analytic_PostView.post_id = Tbl_C_AchiverStory.storyId AND Tbl_Analytic_PostView.flagType = 16
            ) as TotalCount

            FROM Tbl_C_AchiverStory where Tbl_C_AchiverStory.flagType = 16 and Tbl_C_AchiverStory.clientId =:cli order by Tbl_C_AchiverStory.storyId desc";



            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($res)
			{
                $response["success"] = 1;
                $response["message"] = "Data Found";
                $response["Data"] = $res;
            }
			else
			{
				$response["success"] = 0;
				$response["message"] = "Data Not Found";
			}
        } 
		catch (PDOException $e) 
		{
            $response["success"] = 0;
            $response["message"] = "Data Not Found" . $e;
        }
        return json_encode($response);
    }

    /*     * *************************** end show achiver list details ***************************************** */

    /*     * **************************** one achiver post detail ****************************************** */

    function getoneachiverpostdetails($postid) {
        $this->id_posts = $postid;

        try {
            $query = "select tac.* , DATE_FORMAT(tac.createdDate,'%d %b %Y %h:%i %p') as createdDate, user.firstName, user.lastName, user.emailId, user.contact from Tbl_C_AchiverStory as tac JOIN Tbl_EmployeeDetails_Master as user ON tac.createdBy = user.employeeId where tac.storyId =:comm";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':comm', $this->id_posts, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        $response["success"] = 1;
        $response["message"] = "Displaying post details";
        $response["posts"] = array();

        if ($rows) {
            for ($i = 0; $i < count($rows); $i++) {
                $post["post_title"] = $rows[$i]["title"];
                $post["post_img"] = $rows[$i]["imagePath"];
                $post["video_url"] = $rows[$i]["video_url"];
                $post["post_content"] = $rows[$i]["story"];
                $post["storyId"] = $rows[$i]["storyId"];
                $post["clientId"] = $rows[$i]["clientId"];
                $post["createdBy"] = $rows[$i]["createdBy"];
                $post["flagType"] = $rows[$i]["flagType"];
                $post["created_date"] = $rows[$i]["createdDate"];

                $post["firstName"] = $rows[$i]["firstName"];
                $post["lastName"] = $rows[$i]["lastName"];
                $post["emailId"] = $rows[$i]["emailId"];
                $post["contact"] = $rows[$i]["contact"];


                array_push($response["posts"], $post);
            }
            return json_encode($response);
        }
    }

    /*     * ****************************** end one achiver post detail ****************************************** */

    /*     * *********************** Achiver status ************************************** */

    public $idpost;
    public $statuspost;

    function status_Post($storyid, $status) {

        $this->idpost = $storyid;
        $this->statuspost = $status;
       $flag = 16;
        try {
            $query = "update Tbl_C_AchiverStory set status = :sta where storyId = :storyid AND flagType = :flag";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':storyid', $this->idpost, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->statuspost, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->execute();

			$gquery = "update Tbl_Analytic_StorySentToGroup set status = :sta2 where storyId = :storyid2 AND flagType = :flag2 ";
            $stmtg = $this->DB->prepare($gquery);
            $stmtg->bindParam(':storyid2', $this->idpost, PDO::PARAM_STR);
            $stmtg->bindParam(':sta2', $this->statuspost, PDO::PARAM_STR);
			$stmtg->bindParam(':flag2', $flag, PDO::PARAM_STR);
            $stmtg->execute();
			
			$iquery = "update Tbl_C_AchieverImage set status = :sta3 where storyId = :storyid3";
            $stmti = $this->DB->prepare($iquery);
            $stmti->bindParam(':storyid3', $this->idpost, PDO::PARAM_STR);
            $stmti->bindParam(':sta3', $this->statuspost, PDO::PARAM_STR);
			$stmti->execute();
			
            $wquery = "update Tbl_C_WelcomeDetails set status = :sta1 where id = :storyid1 And flagType = :flag1 ";
            $stmtw = $this->DB->prepare($wquery);
            $stmtw->bindParam(':storyid1', $this->idpost, PDO::PARAM_STR);
            $stmtw->bindParam(':sta1', $this->statuspost, PDO::PARAM_STR);
			$stmtw->bindParam(':flag1', $flag, PDO::PARAM_STR);
            $row = $stmtw->execute();

            $response = array();

            if ($row) 
			{
                $response["success"] = 1;
                $response["message"] = "status has changed";
            }
			else
			{
				 $response["success"] = 0;
                $response["message"] = "status not change";
			}
        }   
		catch (PDOException $e) 
		{
				$response["success"] = 0;
                $response["message"] = "status not change".$e;
        }
		 return json_encode($response);
    }

    /*     * *********************** end Achiver status ************************************** */

    /*     * ****************************** generate three digit random number **************************** */

    function randomNumber($length) {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    /*     * ******************************end generate three digit random number **************************** */
    /*     * ******************************** convert into image ******************************************** */

    public $img;

    function convertIntoImage($encodedimage) {
        $num = self::randomNumber(6);
        $img = imagecreatefromstring(base64_decode($encodedimage));

        $imgpath = dirname(BASE_PATH) . '/images/achiverimage/' . $num . '.jpg';
        //echo $imgpath;
        imagejpeg($img, $imgpath);
        $imgpath1 = 'images/achiverimage/' . $num . '.jpg';
        return $imgpath1;
    }

    /*     * ********************************end convert into image ******************************************** */

    public function achiever_details($clientid, $storyId, $flag) {
        try {
            $site_url = SITE;

            $query = "select *, if(thumb_imagePath IS NULL or thumb_imagePath='' , if(imagePath ='' or imagePath IS NULL,'',CONCAT('" . $site_url . "', imagePath)), CONCAT('" . $site_url . "',thumb_imagePath)) as imagePath , DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_C_AchiverStory where clientId=:cli and flagType=:flag and storyId=:storyId";

            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':storyId', $storyId, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            
			 $query1 = "select imageId, if(imagePath IS NULL OR imagePath = '', '' , CONCAT('".$site_url."',imagePath)) as imagePath from Tbl_C_AchieverImage where clientId=:cli1 and storyId=:storyId1";

            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':cli1', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':storyId1', $storyId, PDO::PARAM_STR);
            $stmt1->execute();
            $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
			
            $response['success'] = 1;
            $response['message'] = "data found";
            $response['data'] = $rows;
			$response['image'] = $rows1;
        } catch (Exception $ex) {
            echo $e;
            $response['success'] = 0;
            $response['message'] = "data not found " . $e;
        }
        return json_encode($response);
    }

    /*     * ********************************** status update achiver approve ****************************** */

    function status_approveAchiver($storyId, $POST_TITLE, $POST_CONTENT, $achiver_status, $updatedby, $DATE, $clientid) {

        try {
            $query = "update Tbl_C_AchiverStory set status = :status, title = :title , story = :content , updatedBy = :uby, updatedDate = :udate where storyId = :sid And clientId = :cid ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $storyId, PDO::PARAM_STR);
            $stmt->bindParam(':title', $POST_TITLE, PDO::PARAM_STR);
            $stmt->bindParam(':content', $POST_CONTENT, PDO::PARAM_STR);
            $stmt->bindParam(':status', $achiver_status, PDO::PARAM_STR);
            $stmt->bindParam(':uby', $updatedby, PDO::PARAM_STR);
            $stmt->bindParam(':udate', $DATE, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "updated Successfully";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ******************************* end status update achiver approve **************************** */
	
	/******************************** change status of previous story ***********/
	
	 function statusPreviousStory($cid, $storyid, $type, $flag) {
       
		$updatestatus = 0 ;
        try {
			
			$query = "UPDATE Tbl_C_AchiverStory SET status = :ustatus2 WHERE storyId != :sid2 AND flagType = :flag2 AND clientId = :cid2";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid2', $cid, PDO::PARAM_STR);
            $stmt->bindParam(':sid2', $storyid, PDO::PARAM_STR);
			$stmt->bindParam(':flag2', $flag, PDO::PARAM_STR);
			$stmt->bindParam(':ustatus2', $updatestatus, PDO::PARAM_STR);
			$row = $stmt->execute();
			
			$query3 = "UPDATE Tbl_Analytic_StorySentToGroup SET status = :ustatus3 WHERE storyId != :sid3 AND flagType = :flag3 AND clientId = :cid3";
            $stmt3 = $this->DB->prepare($query3);
            $stmt3->bindParam(':cid3', $cid, PDO::PARAM_STR);
            $stmt3->bindParam(':sid3', $storyid, PDO::PARAM_STR);
			$stmt3->bindParam(':flag3', $flag, PDO::PARAM_STR);
			$stmt3->bindParam(':ustatus3', $updatestatus, PDO::PARAM_STR);
			$row3 = $stmt3->execute();
            			
			$query4 = "UPDATE Tbl_C_AchieverImage SET status = :ustatus4 WHERE storyId != :sid4 AND clientId = :cid4";
            $stmt4 = $this->DB->prepare($query4);
            $stmt4->bindParam(':cid4', $cid, PDO::PARAM_STR);
            $stmt4->bindParam(':sid4', $storyid, PDO::PARAM_STR);
			$stmt4->bindParam(':ustatus4', $updatestatus, PDO::PARAM_STR);
			$row4 = $stmt4->execute();
						
			$query1 = "UPDATE Tbl_C_WelcomeDetails SET status = :ustatus WHERE id != :sid AND flagType = :flag1 AND clientId = :cid1 AND type= :type";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':cid1', $cid, PDO::PARAM_STR);
            $stmt1->bindParam(':sid', $storyid, PDO::PARAM_STR);
			$stmt1->bindParam(':flag1', $flag, PDO::PARAM_STR);
			$stmt1->bindParam(':ustatus', $updatestatus, PDO::PARAM_STR);
			$stmt1->bindParam(':type', $type, PDO::PARAM_STR);
			$rowres = $stmt1->execute();
			
            if ($rowres) {
                $response["success"] = 1;
                $response["message"] = "previous story status changed successfully";
            }
			else
			{
				$response["success"] = 0;
                $response["message"] = "status not change";	
			}
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "status not change".$e;
        }
    }
	
	/****************************** / change status of previous story ***********/
	
	/****************************** save achiever image *************************/
	function saveImage($storyid, $Client_Id, $target_file1,$Status,$Uuid,$Post_Date) {

	        try {
            $query = "insert into Tbl_C_AchieverImage (storyId, clientId, imagePath, status, createdBy,createdDate) values (:sid, :cid, :imgpath, :status, :cby, :cdate)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $storyid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $Client_Id, PDO::PARAM_STR);
			$stmt->bindParam(':imgpath', $target_file1, PDO::PARAM_STR);
			$stmt->bindParam(':status', $Status, PDO::PARAM_STR);
            $stmt->bindParam(':cby', $Uuid, PDO::PARAM_STR);
            $stmt->bindParam(':cdate', $Post_Date, PDO::PARAM_STR);
           
			$row = $stmt->execute();
					
            if ($row) {
				$response["success"] = 1;
                $response["message"] = "Story image saved successfully";
            }
			else
			{
				$response["success"] = 0;
                $response["message"] = "Story image not save";
			}
        } catch (PDOException $e) {
				$response["success"] = 0;
                $response["message"] = "Story image not save".$e;
        }
		return json_encode($response);
    }
	/****************************** / save achiever image ***********************/
	
	/********************************* update achiever story ************************/
 public function update_AchieverStory($storyid , $clientid, $storytitle, $achievername, $achieverdesignation, $achieverlocation, $achieverstory,$updatedby, $Post_Date) {
        try {
            $flagType = 16;

            $query = "Update Tbl_C_AchiverStory SET title = :stitle , achieverName = :aname , designation = :adesignation , location = :alocation, story = :astory , 	updatedDate = :udate , updatedBy = :uby where storyId = :sid AND clientId = :cid AND flagType = :flag";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $storyid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
			$stmt->bindParam(':stitle', $storytitle, PDO::PARAM_STR);
            $stmt->bindParam(':aname', $achievername, PDO::PARAM_STR);
			$stmt->bindParam(':adesignation', $achieverdesignation, PDO::PARAM_STR);
			$stmt->bindParam(':alocation', $achieverlocation, PDO::PARAM_STR);
			$stmt->bindParam(':astory', $achieverstory, PDO::PARAM_STR);
			$stmt->bindParam(':uby', $updatedby, PDO::PARAM_STR);
			$stmt->bindParam(':udate', $Post_Date, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $flagType, PDO::PARAM_STR);
			$stmt->execute();
			
			$query1 = "Update Tbl_C_WelcomeDetails SET title = :fques1 , updatedBy = :updatedby1, updatedDate = :updateddate1 where id = :fid1 AND clientId = :cid1 AND flagType = :flag1";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':fid1', $storyid, PDO::PARAM_STR);
            $stmt1->bindParam(':cid1', $clientid, PDO::PARAM_STR);
			$stmt1->bindParam(':fques1', $storytitle, PDO::PARAM_STR);
            $stmt1->bindParam(':updatedby1', $updatedby, PDO::PARAM_STR);
			$stmt1->bindParam(':updateddate1', $Post_Date, PDO::PARAM_STR);
			$stmt1->bindParam(':flag1', $flagType, PDO::PARAM_STR);
			$welres = $stmt1->execute();
			
            if ($welres) 
			{
                $result['success'] = 1;
                $result['message'] = "Story Updated Successfully";
            }
			else
			{
			$result['success'] = 0;
            $result['message'] = "Story Not Updated";
			}
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "Story Not Updated".$ex;
        }

        return json_encode($result);
    }
/****************************** update achiever story ***************************/

/****************************** save achiever image *************************/
	function deleteaAchieverImage($storyid, $Client_Id) {

	        try {
            $query = "Delete From Tbl_C_AchieverImage where storyId = :sid AND clientId = :cid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $storyid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $Client_Id, PDO::PARAM_STR);
			           
			$row = $stmt->execute();
	
            if ($row) {
				$response["success"] = 1;
                $response["message"] = "Story image deleted successfully";
            }
			else
			{
				$response["success"] = 0;
                $response["message"] = "Story image not delete";
			}
        } catch (PDOException $e) {
				$response["success"] = 0;
                $response["message"] = "Story image not delete".$e;
        }
		return json_encode($response);
    }
	/****************************** / delete achiever image ***********************/
	
	/******************************** get referred story **************************/
	
	 function referredstorylist($clientId) {
        try {
           
		   $query = "SELECT referColleague.* , DATE_FORMAT(referColleague.createdDate,'%d %b %Y %h:%i %p') as createdDate , CONCAT(edm.firstName,' ',edm.middleName,' ',edm.lastName) as referredbyname , edm.emailId as referredbyemailId , CONCAT(edm1.firstName,' ',edm1.middleName,' ',edm1.lastName) as referredtoname , edm1.emailId as referredtoemailId from Tbl_ReferColleague as referColleague JOIN Tbl_EmployeeDetails_Master as edm ON referColleague.referredBy = edm.employeeId JOIN Tbl_EmployeeDetails_Master as edm1 ON referColleague.userId = edm1.employeeId AND edm.clientId = :cli";

            $stmt = $this->DB->prepare($query);
			$stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
            $stmt->execute();
            $referredstory = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if($referredstory)
			{
            $result['success'] = 1;
            $result['message'] = "referred story detail";
            $result['data'] = $referredstory;
			}
			else
			{
			$result['success'] = 0;
            $result['message'] = "referred story detail not fetch";
			}
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "referred story detail not fetch" . $ex;
        }
        return json_encode($result);
    }
	
	/******************************* / get referred story *************************/
	
}

?>
