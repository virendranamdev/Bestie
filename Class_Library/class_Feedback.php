<?php

if (!class_exists('Connection_Communication')) {
    require_once('class_connect_db_Communication.php');
}

class Feedback {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    public function maxId() {
        try {
            $max = "select max(autoId) from Tbl_C_Feedback";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $commentId = "Feedback-" . $m_id1;

                return $commentId;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function feedbackList($clientId, $empId) {
        try {
            $flagType = 23;

            $query = "SELECT * FROM Tbl_C_Feedback WHERE clientId=:clientId AND flagType=:flagType";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':flagType', $flagType, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $feedbackResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $result['success'] = 1;
                $result['data'] = $feedbackResult;
            }
        } catch (Exception $ex) {
            $result = $ex;
        }

        return json_encode($result);
    }

    public function getSingleFeedbackDetail($clientId, $feedbackId) {
        try {
            $feedbackQuery = "SELECT feedbackQuestion,DATE_FORMAT(publishingTime,'%m/%d/%Y') as publishingTime ,DATE_FORMAT(unpublishingTime,'%m/%d/%Y') as unpublishingTime FROM Tbl_C_Feedback WHERE feedbackId=:feedbackId";
            $stmt = $this->db_connect->prepare($feedbackQuery);
            $stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $feedback = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            $query = "select count(commentId) as totalComments from Tbl_C_FeedbackComments where feedbackId=:feedbackId";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $totalComments = $stmt->fetch(PDO::FETCH_ASSOC);
//                print_r($totalComments);die;
                if ($totalComments['totalComments'] > 0) {
                    try {
                        $flagType = 23;
                        $query = "SELECT feedComments.*,feed.feedbackQuestion, (select count(autoId) from Tbl_C_FeedbackCommentLikes where commentId=feedComments.commentId and feedbackId=:feedbackId and like_unlike_status='1') as totalLikes FROM Tbl_C_FeedbackComments as feedComments JOIN Tbl_C_Feedback as feed ON feedComments.feedbackId=feed.feedbackId WHERE feed.clientId=:clientId AND feed.flagType=:flagType AND feedComments.feedbackId=:feedbackId";

                        $stmt = $this->db_connect->prepare($query);
                        $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
                        $stmt->bindParam(':flagType', $flagType, PDO::PARAM_STR);
                        $stmt->bindParam(':feedbackId', $feedbackId, PDO::PARAM_STR);
                        if ($stmt->execute()) {
                            $commentResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $result['success'] = 1;
                            $result['feedbackQuestion'] = $feedback['feedbackQuestion'];
							$result['publishingTime'] = $feedback['publishingTime'];
							$result['unpublishingTime'] = $feedback['unpublishingTime'];
                            $result['totalComments'] = $totalComments['totalComments'];
                            $result['data'] = $commentResult;
                        }
                    } catch (Exception $ex) {
                        $result = $ex;
                    }
                } else {
                    $result['success'] = 0;
                    $result['message'] = "No Comments available";
					$result['feedbackQuestion'] = $feedback['feedbackQuestion'];
					$result['publishingTime'] = $feedback['publishingTime'];
					$result['unpublishingTime'] = $feedback['unpublishingTime'];
                }
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return json_encode($result);
    }

    public function extractCommonWords($string) {
        $stopWords = array('i', 'a', 'about', 'an', 'and', 'are', 'as', 'at', 'be', 'by', 'com', 'de', 'en', 'for', 'from', 'how', 'in', 'is', 'it', 'la', 'of', 'on', 'or', 'that', 'the', 'this', 'to', 'was', 'what', 'when', 'where', 'who', 'will', 'with', 'und', 'the', 'www');

        $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
        $string = trim($string); // trim the string
        $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
        $string = strtolower($string); // make it lowercase

        preg_match_all('/\b.*?\b/i', $string, $matchWords);
        $matchWords = $matchWords[0];

        foreach ($matchWords as $key => $item) {
            if ($item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 2) {
                unset($matchWords[$key]);
            }
        }
        $wordCountArr = array();
        if (is_array($matchWords)) {
            foreach ($matchWords as $key => $val) {
                $val = strtolower($val);
                if (isset($wordCountArr[$val])) {
                    $wordCountArr[$val] ++;
                } else {
                    $wordCountArr[$val] = 1;
                }
            }
        }
        arsort($wordCountArr);

//        print_r($wordCountArr);die;
        $wordCountArr = array_slice($wordCountArr, 0, 10);
        return json_encode($wordCountArr);
    }
	
/**************************** add feedback *********************************/
 public function create_Feedback($Feedback_Id , $Client_Id, $Feedback_Question , $groupselection , $Uuid, $Status, $Publishing_Date, $Unpublishing_Date,$Post_Date, $Flag) {
        try {
           
            $query = "insert into Tbl_C_Feedback (feedbackId, clientId, feedbackQuestion, groupSelection, createdBy, status, publishingTime, unpublishingTime, createdDate, flagType)
            values(:fid,:cid,:fques,:fgroup,:cby,:status,:ptime,:untime,:cdate,:flag)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':fid', $Feedback_Id, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $Client_Id, PDO::PARAM_STR);
			$stmt->bindParam(':fques', $Feedback_Question, PDO::PARAM_STR);
            $stmt->bindParam(':fgroup', $groupselection, PDO::PARAM_STR);
			$stmt->bindParam(':cby', $Uuid, PDO::PARAM_STR);
            $stmt->bindParam(':status', $Status, PDO::PARAM_STR);
			$stmt->bindParam(':ptime', $Publishing_Date, PDO::PARAM_STR);
            $stmt->bindParam(':untime', $Unpublishing_Date, PDO::PARAM_STR);
			$stmt->bindParam(':cdate', $Post_Date, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $Flag, PDO::PARAM_STR);
            
			if ($stmt->execute()) {
                $result['success'] = 1;
                $result['message'] = "Feedback Created Successfully";
            }
			else
			{
				$result['success'] = 0;
                $result['message'] = "Feedback Not Created";
			}
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "Feedback Not Created".$ex;
        }

        return json_encode($result);
    }
/**************************** / add feedback *******************************/

/********************************* update feedback ************************/
 public function update_Feedback($feedbackid , $clientid, $UFeedback_Question, $UPublishing_Date, $UUnpublishing_Date, $updatedby, $updatedDate ) {
        try {
            $flagType = 23;

            $query = "Update Tbl_C_Feedback SET feedbackQuestion = :fques , publishingTime = :fpublish , unpublishingTime = :funpublish , updatedBy = :updatedby, updatedDate = :updateddate where feedbackId = :fid AND clientId = :cid AND flagType = :flag";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':fid', $feedbackid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
			$stmt->bindParam(':fques', $UFeedback_Question, PDO::PARAM_STR);
            $stmt->bindParam(':fpublish', $UPublishing_Date, PDO::PARAM_STR);
			$stmt->bindParam(':funpublish', $UUnpublishing_Date, PDO::PARAM_STR);
			$stmt->bindParam(':updatedby', $updatedby, PDO::PARAM_STR);
			$stmt->bindParam(':updateddate', $updatedDate, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $flagType, PDO::PARAM_STR);
			$stmt->execute();
			
			$query1 = "Update Tbl_C_WelcomeDetails SET title = :fques1 , updatedBy = :updatedby1, updatedDate = :updateddate1 where id = :fid1 AND clientId = :cid1 AND flagType = :flag1";
            $stmt1 = $this->db_connect->prepare($query1);
            $stmt1->bindParam(':fid1', $feedbackid, PDO::PARAM_STR);
            $stmt1->bindParam(':cid1', $clientid, PDO::PARAM_STR);
			$stmt1->bindParam(':fques1', $UFeedback_Question, PDO::PARAM_STR);
            $stmt1->bindParam(':updatedby1', $updatedby, PDO::PARAM_STR);
			$stmt1->bindParam(':updateddate1', $updatedDate, PDO::PARAM_STR);
			$stmt1->bindParam(':flag1', $flagType, PDO::PARAM_STR);
			$welres = $stmt1->execute();
			
            if ($welres) 
			{
                $result['success'] = 1;
                $result['message'] = "Feedback Wall Updated Successfully";
            }
			else
			{
			$result['success'] = 0;
            $result['message'] = "Feedback Wall Not Updated";
			}
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "Feedback Wall Not Updated".$ex;
        }

        return json_encode($result);
    }
/****************************** update feedback ***************************/

/****************************** predefine template list *******************/

public function PredefinedTemplateList($clientId, $empId) {
        try {
            
            $query = "SELECT * FROM Tbl_C_PredefinedTemplate WHERE clientId=:clientId AND createdBy=:empid order by createdDate desc";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $empId, PDO::PARAM_STR);
			$rows = $stmt->execute();
            if ($rows) 
			{
                $feedbackResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['success'] = 1;
				$result['message'] = "Predefined Template Fetch Successfully";
                $result['data'] = $feedbackResult;
            }
			else{
				$result['success'] = 0;
                $result['message'] = "Predefined Template Not Fetch";
			}
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "Predefined Template Not Fetch".$ex;
        }

        return json_encode($result);
    }

/***************************** / predefined template list *****************/

/**************************** add predefined template *********************************/
 public function create_PredefinedTemplate($Client_Id, $Feedback_Question , $Uuid, $Post_Date) {
	 $status = 1 ;
        try {
			
            $query = "insert into Tbl_C_PredefinedTemplate(clientId, question, createdBy, 	status,createdDate)
            values(:cid,:fques,:cby,:status,:cdate)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $Client_Id, PDO::PARAM_STR);
			$stmt->bindParam(':fques', $Feedback_Question, PDO::PARAM_STR);
            $stmt->bindParam(':cby', $Uuid, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
			$stmt->bindParam(':cdate', $Post_Date, PDO::PARAM_STR);
			
			if ($stmt->execute()) {
                $result['success'] = 1;
                $result['message'] = "Template Created Successfully";
            }
			else
			{
				$result['success'] = 0;
                $result['message'] = "Template Not Created";
			}
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "Template Not Created".$ex;
        }

        return json_encode($result);
    }
/**************************** / add predefined template *******************************/

/****************************** get single predefined temp ****************************/
public function getSinglepredefinedtemp($clientId,$PreTempId) {
        try {
            
            $query = "SELECT * FROM Tbl_C_PredefinedTemplate WHERE clientId=:clientId AND templateId = :tempid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':tempid', $PreTempId, PDO::PARAM_STR);
			$rows = $stmt->execute();
            if ($rows) 
			{
                $feedbackResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['success'] = 1;
				$result['message'] = "Predefined Template Fetch Successfully";
                $result['data'] = $feedbackResult;
            }
			else{
				$result['success'] = 0;
                $result['message'] = "Predefined Template Not Fetch";
			}
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "Predefined Template Not Fetch".$ex;
        }

        return json_encode($result);
    }
/***************************** / get single predefined temp ***************************/

/****************************** delete predefined temp ****************************/
public function deleteTemplate($templateid,$clientId) {
        try {
            
            $query = "Delete FROM Tbl_C_PredefinedTemplate WHERE clientId=:clientId AND templateId = :tempid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':tempid', $templateid, PDO::PARAM_STR);
			$rows = $stmt->execute();
            if ($rows) 
			{
                $result['success'] = 1;
				$result['message'] = "Template Deleted Successfully";
            }
			else{
				$result['success'] = 0;
                $result['message'] = "Template Not Deleted";
			}
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "Template Not Deleted".$ex;
        }

        return json_encode($result);
    }
/***************************** / delete predefined temp ***************************/

/********************************* status feedback wall ***************************/

 function status_FeedbackWall($fid, $fstatus) {
 $flag = 23;
        if ($fstatus == 'Live') {
            $status = 1;
        } else {
            $status = 0;
        }
        try {
            $query = "update Tbl_C_Feedback set status = :sta where feedbackId = :fid And flagType = :flag";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':fid', $fid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $fstatus, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->execute();

            $gquery = "update Tbl_Analytic_PostSentToGroup set status = :sta2 where postId = :fid2 And flagType = :flag2 ";
            $stmtg = $this->db_connect->prepare($gquery);
            $stmtg->bindParam(':fid2', $fid, PDO::PARAM_STR);
            $stmtg->bindParam(':sta2', $status, PDO::PARAM_STR);
			$stmtg->bindParam(':flag2', $flag, PDO::PARAM_STR);
			$stmtg->execute();
			
			$wquery = "update Tbl_C_WelcomeDetails set status = :sta3 where id = :fid3 And 	flagType = :flag3 ";
            $stmtw = $this->db_connect->prepare($wquery);
            $stmtw->bindParam(':fid3', $fid, PDO::PARAM_STR);
            $stmtw->bindParam(':sta3', $status, PDO::PARAM_STR);
			$stmtw->bindParam(':flag3', $flag, PDO::PARAM_STR);
            
            if ($stmtw->execute()) 
			{
                $response["success"] = 1;
                $response["message"] = "Feedback Wall status has changed";
            }
			else 
			{
                $response["success"] = 0;
                $response["message"] = "Feedback Wall Not change";
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
                $response["message"] = "Feedback Wall status Not change".$e;
        }
		 return json_encode($response);
    }

/***************************** / status feedback wall *****************************/
}

?>