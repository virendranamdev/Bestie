<?php

if (!class_exists('Connection_Communication')) {
    require_once('class_connect_db_Communication.php');
}

class Happiness {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    public function maxId() {
        try {
            $max = "select max(autoId) from Tbl_C_HappinessQuestion";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $commentId = "Happiness-" . $m_id1;

                return $commentId;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }
	/********************************** max id of emplyee happiness *********/
	function HappinessMaxId() {
        try {
            $max = "select max(questionId) from Tbl_C_HappinessQuestion";
            $stmt = $this->db_connect->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $qid = $m_id1;

                return $qid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }
	/****************************** / max id of employee happiness ************/

    public function happinessQuestionList($clientId, $empId) {
        try {
            $flagType = 20;

            $query = "SELECT happinessQuestion.questionId as quesid ,happinessQuestion.status,happinessQuestion.surveyId, happinessQuestion.question, happinessQuestion.startDate, happinessQuestion.expiryDate, (select count(auto_id) from Tbl_Analytic_EmployeeHappiness where surveyId=happinessQuestion.surveyId) as totalrespondents, (select avg(value) from Tbl_Analytic_EmployeeHappiness where surveyId=happinessQuestion.surveyId) as respondents FROM Tbl_C_HappinessQuestion as happinessQuestion  WHERE happinessQuestion.clientId=:clientId AND happinessQuestion.flagType=:flagType";
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

    public function getSingleHappinessDetail($clientId, $surveyId) {
        try {
            $happinessQuery = "SELECT question,DATE_FORMAT(startDate,'%m/%d/%Y') as startDate ,DATE_FORMAT(expiryDate,'%m/%d/%Y') as expiryDate FROM Tbl_C_HappinessQuestion WHERE surveyId=:surveyId";
            $stmt = $this->db_connect->prepare($happinessQuery);
            $stmt->bindParam(':surveyId', $surveyId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $happiness = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            $query = "select count(auto_id) as totalComments from Tbl_Analytic_EmployeeHappiness where surveyId=:surveyId";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':surveyId', $surveyId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $totalComments = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($totalComments['totalComments'] > 0) {
                    try {
                        $flagType = 20;
                        $query = "SELECT Happiness.*,HappinessQuestion.question, if(master.middleName IS NULL or master.middleName='', if(master.lastName IS NULL or master.lastName='', master.firstName, CONCAT(master.firstName,' ',master.lastName)), CONCAT(master.firstName,' ',master.middleName,' ',master.lastName)) as name, if(personal.userImage IS NULL or personal.userImage='', '', CONCAT('" . SITE . "',personal.userImage)) as userImage FROM Tbl_Analytic_EmployeeHappiness as Happiness JOIN Tbl_C_HappinessQuestion as HappinessQuestion ON Happiness.surveyId=HappinessQuestion.surveyId JOIN Tbl_EmployeeDetails_Master as master ON Happiness.userUniqueId=master.employeeId JOIN Tbl_EmployeePersonalDetails as personal ON master.employeeId=personal.employeeId WHERE HappinessQuestion.clientId=:clientId AND HappinessQuestion.flagType=:flagType AND Happiness.surveyId=:surveyId";

                        $stmt = $this->db_connect->prepare($query);
                        $stmt->bindParam(':clientId', $clientId, PDO::PARAM_STR);
                        $stmt->bindParam(':flagType', $flagType, PDO::PARAM_STR);
                        $stmt->bindParam(':surveyId', $surveyId, PDO::PARAM_STR);
                        if ($stmt->execute()) {
                            $commentResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $result['success'] = 1;
                            $result['happinessQuestion'] = $happiness['question'];
							$result['startDate'] = $happiness['startDate'];
							$result['expiryDate'] = $happiness['expiryDate'];
                            $result['totalComments'] = $totalComments['totalComments'];
                            $result['data'] = $commentResult;
                        }
                    } catch (Exception $ex) {
                        $result = $ex;
                    }
                } else {
                    $result['success'] = 0;
                    $result['message'] = "No Comments available";
					$result['happinessQuestion'] = $happiness['question'];
					$result['startDate'] = $happiness['startDate'];
					$result['expiryDate'] = $happiness['expiryDate'];
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

    public function getSurveyCount($sid, $qid, $value, $filter = '') {
        try {
            $squery = "SELECT count(value) AS surveycount FROM Tbl_Analytic_EmployeeHappiness WHERE surveyId =:sid AND questionId=:qid and value=:val";

            if (!empty($filter)) {
                $squery .= " and (DATE_FORMAT(createdDate, '%Y-%m-%d') BETWEEN '" . $filter[0] . "' AND '" . $filter[1] . "')";
            }
            
            $stmt2 = $this->db_connect->prepare($squery);
            $stmt2->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt2->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt2->bindParam(':val', $value, PDO::PARAM_STR);
            $stmt2->execute();
            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            return $rows2;
        } catch (Exception $ex) {
            echo $ex;
        }
    }
	
	/*************************** add happiness question ************************/
	 function createHappinessQuestion($surveyid, $clientId, $happinessQues, $enablecomment, $fromDate, $toDate, $userId, $post_date,$device,$status,$flag) {

        try {

            $query = "insert into Tbl_C_HappinessQuestion(surveyId,clientId,question,enableComment,startDate,expiryDate,createdBy,createdDate,status,device,flagType) values(:sid,:cid,:ques_text,:enable_comment, :startdate, :expiryDate, :createdby, :createddate,:status,:device,:flag)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':sid', $surveyid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':ques_text', $happinessQues, PDO::PARAM_STR);
            $stmt->bindParam(':enable_comment', $enablecomment, PDO::PARAM_STR);
            $stmt->bindParam(':startdate', $fromDate, PDO::PARAM_STR);
            $stmt->bindParam(':expiryDate', $toDate, PDO::PARAM_STR);
            $stmt->bindParam(':createdby', $userId, PDO::PARAM_STR);
            $stmt->bindParam(':createddate', $post_date, PDO::PARAM_STR);
			$stmt->bindParam(':device', $device, PDO::PARAM_STR);
			$stmt->bindParam(':status', $status, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $rows = $stmt->execute();
			if($rows)
			{
            $result['success'] = 1;
            $result['message'] = "Happiness Index Created Successfully";
            }
			else
			{
			$result['success'] = 0;
            $result['message'] = "Happiness Index Not Created";	
			}
        } catch (PDOException $e) {
            $result['success'] = 0;
            $result['message'] = "Happiness Index Not Created".$e;	
        }
		return json_encode($result);
    }
	/***************************** / add happiness question ********************/
	
	/********************************* update happiness question  ************************/
 public function update_HappinessQues($questionid , $clientid, $uHappinessques, $ufromdate, $utodate, $updatedby, $Post_Date) {
        try {
            $flagType = 20;
            $query = "Update Tbl_C_HappinessQuestion SET question = :hques , startDate = :fromdate , expiryDate = :todate where questionId = :qid AND clientId = :cid AND flagType = :flag";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':qid', $questionid, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
			$stmt->bindParam(':hques', $uHappinessques, PDO::PARAM_STR);
            $stmt->bindParam(':fromdate', $ufromdate, PDO::PARAM_STR);
			$stmt->bindParam(':todate', $utodate, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $flagType, PDO::PARAM_STR);
			$stmt->execute();
			
			$query1 = "Update Tbl_C_WelcomeDetails SET title = :hques1 , updatedBy = :uby , updatedDate = :udate where id = :qid1 AND clientId = :cid1 AND flagType = :flag1";
            $stmt1 = $this->db_connect->prepare($query1);
            $stmt1->bindParam(':qid1', $questionid, PDO::PARAM_STR);
            $stmt1->bindParam(':cid1', $clientid, PDO::PARAM_STR);
			$stmt1->bindParam(':hques1', $uHappinessques, PDO::PARAM_STR);
            $stmt1->bindParam(':flag1', $flagType, PDO::PARAM_STR);
			$stmt1->bindParam(':udate', $Post_Date, PDO::PARAM_STR);
			$stmt1->bindParam(':uby', $updatedby, PDO::PARAM_STR);
			$welres = $stmt1->execute();
			
            if ($welres) 
			{
                $result['success'] = 1;
                $result['message'] = "Happiness Index Updated Successfully";
            }
			else
			{
			$result['success'] = 0;
            $result['message'] = "Happiness Index Not Updated";
			}
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "Happiness Index Not Updated".$ex;
        }

        return json_encode($result);
    }
/****************************** update happiness question ***************************/

/********************************* status Happiness Index ***************************/

 function status_HappinessQuestion($qid, $qstatus) {
 $flag = 20;
        
        try {
            $query = "update Tbl_C_HappinessQuestion set status = :sta where questionId = :qid And flagType = :flag";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $qstatus, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->execute();

            $gquery = "update Tbl_Analytic_PostSentToGroup set status = :sta2 where postId = :qid2 And flagType = :flag2 ";
            $stmtg = $this->db_connect->prepare($gquery);
            $stmtg->bindParam(':qid2', $qid, PDO::PARAM_STR);
            $stmtg->bindParam(':sta2', $qstatus, PDO::PARAM_STR);
			$stmtg->bindParam(':flag2', $flag, PDO::PARAM_STR);
            $stmtg->execute();
			
			$wquery = "update Tbl_C_WelcomeDetails set status = :sta3 where id = :qid3 And 	flagType = :flag3 ";
            $stmtw = $this->db_connect->prepare($wquery);
            $stmtw->bindParam(':qid3', $qid, PDO::PARAM_STR);
            $stmtw->bindParam(':sta3', $qstatus, PDO::PARAM_STR);
			$stmtw->bindParam(':flag3', $flag, PDO::PARAM_STR);
			
            if ($stmtw->execute()) 
			{
                $response["success"] = 1;
                $response["message"] = "Happiness Index status has changed";
            }
			else 
			{
                $response["success"] = 0;
                $response["message"] = "Happiness Index Not change";
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
                $response["message"] = "Happiness Index status Not change".$e;
        }
		 return json_encode($response);
    }

/***************************** / status Happiness Index *****************************/
	
}

?>