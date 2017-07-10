<?php

if (!class_exists('Connection_Communication')) {
    require_once('class_connect_db_Communication.php');
}

class FAQ {

	public $db_connect;

	public function __construct() {
		$dbh = new Connection_Communication();
		$this->db = $dbh->getConnection_Communication();
	}

	public function getModules($clientId) {
		$query = "select distinct(module) FROM Tbl_App_Modules";

		try { 	
			$stmt   = $this->db->prepare($query);
			$result = $stmt->execute();	//execute query
		} catch (PDOException $ex) {
			$response["success"] = 0;
			$response["message"] = "Database Error!";
		 	return json_encode($response);
		}

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $rows;
	}

	public function addFaq($app_module, $faq_question, $faq_answer, $clientid, $addedby, $status, $post_date){
		try {
			$query = "INSERT INTO Tbl_App_FAQs (module, question, answer, status, createdBy, createdDate) values(:module, :question, :answer, :status, :createdBy, :post_date)";
			$stmt = $this->db->prepare($query);
			$stmt->bindParam(':module', $app_module, PDO::PARAM_STR);
			$stmt->bindParam(':question', $faq_question, PDO::PARAM_STR);
			$stmt->bindParam(':answer', $faq_answer, PDO::PARAM_STR);
			$stmt->bindParam(':status', $status, PDO::PARAM_STR);
			$stmt->bindParam(':createdBy', $addedby, PDO::PARAM_STR);
			$stmt->bindParam(':post_date', $post_date, PDO::PARAM_STR);
			if ($stmt->execute()) {
				$response['success'] = 1;
				$response['message'] = "FAQ Created Successfully";
			} else {
				$response['success'] = 0;
				$response['message'] = "FAQ Not Created";
			}
		} catch(PDOException $ex) {
			$response["success"] = 0;
			$response["message"] = "Database Error! ".$ex;
		}
	
		return json_encode($response);
	}
	
	public function updateFaq($faqId, $app_module, $faq_question, $faq_answer, $clientid, $addedby, $status, $post_date){
		try {
			$query = "UPDATE Tbl_App_FAQs SET module=:module, question=:question, answer=:answer, status=:status, createdDate=:post_date, createdBy=:createdBy WHERE autoId=:faqId";
			$stmt = $this->db->prepare($query);
			$stmt->bindParam(':faqId', $faqId, PDO::PARAM_STR);
			$stmt->bindParam(':module', $app_module, PDO::PARAM_STR);
			$stmt->bindParam(':question', $faq_question, PDO::PARAM_STR);
			$stmt->bindParam(':answer', $faq_answer, PDO::PARAM_STR);
			$stmt->bindParam(':status', $status, PDO::PARAM_STR);
			$stmt->bindParam(':createdBy', $addedby, PDO::PARAM_STR);
			$stmt->bindParam(':post_date', $post_date, PDO::PARAM_STR);
			if ($stmt->execute()) {
				$response['success'] = 1;
				$response['message'] = "FAQ updated successfully";
			} else {
				$response['success'] = 0;
				$response['message'] = "FAQ Not updated";
			}
		} catch(PDOException $ex) {
			$response["success"] = 0;
			$response["message"] = "Database Error! ".$ex;
		}

		return json_encode($response);
	}
	
	public function getFaqData($faqId){
		try {	
			$query = "select * from Tbl_App_FAQs where autoId=:faqId";
			$stmt = $this->db->prepare($query);
			$stmt->bindParam(':faqId', $faqId, PDO::PARAM_STR);
			if ($stmt->execute()) {
				$response['success'] = 1;
				$response['message'] = "FAQ updated successfully";
				$response['faqData'] = $stmt->fetch(PDO::FETCH_ASSOC);
			} else {
				$response['success'] = 0;
				$response['message'] = "FAQ Not updated";
			}
		} catch(PDOException $ex) {
			$response["success"] = 0;
			$response["message"] = "Database Error! ".$ex;
		}
		return json_encode($response);
	}

	public function getFaqList($clientId){
		try { 	
			$query = "select * FROM Tbl_App_FAQs";
			$stmt   = $this->db->prepare($query);
			$result = $stmt->execute();	//execute query
			$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $ex) {
			$response["success"] = 0;
			$response["message"] = "Database Error!";
		 	return json_encode($response);
		}
		
		return json_encode($response);
	}

    	public function getFAQ() {
		try { 	
			$query = "select distinct(module) FROM Tbl_App_FAQs";
			$stmt   = $this->db->prepare($query);
			$result = $stmt->execute();	//execute query
		} catch (PDOException $ex) {
			$response["success"] = 0;
			$response["message"] = "Database Error!";
		 	return json_encode($response);
		}

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); // Finally, we can retrieve all of the found rows into an array using fetchAll
		
		if ($rows) {
			$response = array();
			
			foreach ($rows as $row) {
				try { 	
					$subQuery = "select * FROM Tbl_App_FAQs as FAQ join Tbl_App_Modules as modules on FAQ.module=modules.module where FAQ.module='".$row['module']."' and FAQ.status='1'";
					$stmt   = $this->db->prepare($subQuery);
					$result = $stmt->execute();	//execute query
					if($result) {
						$faqData = $stmt->fetchAll(PDO::FETCH_ASSOC);
						//print_r($faqData);die;
						$arr['module'] = $row['module'];
						$arr['faq'] = 	array();
					}
					
				} catch (PDOException $ex) {
					$response["success"] = 0;
					$response["message"] = "Database Error! ". $ex;
				 	return $response;
				}
				
				$arr['faq'] = $faqData;
				if(empty($arr['faq'])) { 
					unset($arr['module'],$arr['faq']);
				} else{
					array_push($response, $arr);
				}
			}
			
		} else {
			$response["success"] = 0;
			$response["message"] = "No Post Available!";
			return $response;
		}
		
		return $response;
	}
	
	/********************************* status faq ***************************/

 function status_FAQ($fid, $fstatus) {
        try {
            $query = "update Tbl_App_FAQs set status = :sta where autoId = :fid";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':fid', $fid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $fstatus, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $response["success"] = 1;
                $response["message"] = "FAQ status has changed";
            } else {
                $response["success"] = 0;
                $response["message"] = "FAQ Not change";
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
                $response["message"] = "FAQ status Not change".$e;
        }
        
	 return json_encode($response);
    }

/***************************** / status feedback wall *****************************/
}

?>
