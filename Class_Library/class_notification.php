<?php
if (!class_exists('Connection_Communication')) {
    include_once('class_connect_db_Communication.php');
}

class notification {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

   /***************************** compress image ****************************/
    function compress_image($source_url, $destination_url, $quality) {

        $imagevalue = filesize($source_url);
        $valueimage = $imagevalue / 1024;

        if ($valueimage > 200) {
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

   /***************************** / compress image **************************/
    function maxId() {
        try {
            $max = "select max(notificationId) from Tbl_C_NotificationDetails";
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
	
	/*********************** reminder max id **************************/
	function remindermaxId() {
        try {
            $max = "select max(reminderId) from Tbl_C_ReminderDetails";
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
	/********************** / reminder max id *************************/
   
	
    /******************************* insert into notification table ***************************/
    function create_notification($clientId,$id, $title, $content, $image, $createdDate, $createdBy, $flagType, $status) {
       
        try {
            $query = "insert into Tbl_C_NotificationDetails(clientId,id,title, content, image, createdDate, createdBy, flagType, status) values(:cid,:id,:title,:content,:img,:cdate,:cby,:flag,:sta)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':img', $image, PDO::PARAM_STR);
            $stmt->bindParam(':cdate', $createdDate, PDO::PARAM_STR);
            $stmt->bindParam(':cby', $createdBy, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flagType, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $status, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
				
				$id = $this->DB->lastInsertId();
				
                $ft = 'True';
                return $id;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
 /******************************* / insert into notification table ***************************/
 
 /***************************** insert into reminder table ***********************************/
 function create_Reminder($Client_Id, $POST_TITLE, $dbimage, $Uuid, $DATE, $FLAG, $status) {
       
        try {
            $query = "insert into Tbl_C_ReminderDetails(clientId,title,image, createdBy,createdDate, 	flagType, status) values(:cid,:title,:image,:cby,:cdate,:flag,:status)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $Client_Id, PDO::PARAM_STR);
			$stmt->bindParam(':title', $POST_TITLE, PDO::PARAM_STR);
            $stmt->bindParam(':image', $dbimage, PDO::PARAM_STR);
            $stmt->bindParam(':cby', $Uuid, PDO::PARAM_STR);
            $stmt->bindParam(':cdate', $DATE, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $FLAG, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
				
				$id = $this->DB->lastInsertId();
                $ft = 'True';
                return $id;
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
 /**************************** / insert into reminder table **********************************/
 
 /******************************* insert into notification table ***************************/
    function listNotification($clientId) {
       
        try {
            $query = "select * , DATE_FORMAT(createdDate , '%d %b %Y %h:%i %p') as createdDate from Tbl_C_NotificationDetails where clientId = :cid order by createdDate desc";

            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
			$stmt->execute();
			$res = $stmt->fetchALL(PDO::FETCH_ASSOC);
			
			$response = array();
			$resresult = array();
            if ($stmt->execute()) 
			{	
				for($i=0; $i<count($res); $i++)
				{
					$flag = $res[$i]['flagType'];
					
					$query1 = "select postgroup.groupId , groupdetail.groupName as groupName from Tbl_Analytic_PostSentToGroup as postgroup JOIN Tbl_ClientGroupDetails as groupdetail ON postgroup.groupId = groupdetail.groupId where postgroup.clientId = :cid1 AND postgroup.postId = :postid1 AND postgroup.flagType = :flag1";
					
					if($flag == 2)
					{
					$id1 = $res[$i]['id'];
					}
					if($flag == 24)
					{
					$id1 = $res[$i]['notificationId'];
					}
					if($flag == 25)
					{
					$id1 = $res[$i]['id'];
					}
					$stmt1 = $this->DB->prepare($query1);
					$stmt1->bindParam(':cid1', $clientId, PDO::PARAM_STR);
					$stmt1->bindParam(':postid1', $id1, PDO::PARAM_STR);
					$stmt1->bindParam(':flag1', $flag, PDO::PARAM_STR);
					$stmt1->execute();
					$res1 = $stmt1->fetch(PDO::FETCH_ASSOC);
									
					$post['notificationId'] = $res[$i]['notificationId'];
					$post['clientId'] = $res[$i]['clientId'];
					$post['id'] = $res[$i]['id'];
					$post['title'] = $res[$i]['title'];
					$post['content'] = $res[$i]['content'];
					$post['image'] = $res[$i]['image'];
					$post['createdDate'] = $res[$i]['createdDate'];
					$post['createdBy'] = $res[$i]['createdBy'];
					$post['flagType'] = $res[$i]['flagType'];
					$post['status'] = $res[$i]['status'];
					$post['group'] = $res1['groupName'];
					array_push($resresult , $post);
				}
				
				$response['success'] = 1;
				$response['message'] = "data fetch successfully";
				$response['data'] = $resresult;
				
            }
			else
			{
				$response['success'] = 0;
				$response['message'] = "data not fetch successfully";
			}
        } catch (PDOException $e) {
				$response['success'] = 0;
				$response['message'] = "data not fetch successfully".$e;
        }
		return json_encode($response);
    }
 /******************************* / insert into notification table ***************************/
 
 /******************************* insert into notification table ***************************/
    function notificationDetails($clientId,$notificationId,$flag) {
       $imgpath = SITE;
        try {
            $query = "select * , DATE_FORMAT(createdDate , '%d %b %Y %h:%i %p') as createdDate ,if(image IS NULL OR image = '' , '' , CONCAT('".$imgpath."',image)) as image from Tbl_C_NotificationDetails where clientId = :cid AND notificationId = :notificationid AND flagType = :flag ";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
			$stmt->bindParam(':notificationid', $notificationId, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
			$stmt->execute();
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->execute()) 
			{
				$response['success'] = 1;
				$response['message'] = "data fetch successfully";
				$response['data'] = $res;
            }
			else
			{
				$response['success'] = 0;
				$response['message'] = "data not fetch successfully";
			}
        } catch (PDOException $e) {
				$response['success'] = 0;
				$response['message'] = "data not fetch successfully".$e;
        }
		return json_encode($response);
    }
 /******************************* / insert into notification table ***************************/

}

?>