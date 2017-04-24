<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!class_exists('Connection_Communication')) {
    require_once('class_connect_db_Communication.php');
}

class Happiness {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    public function addHappinessRating($cId, $empId, $surveyId, $rating, $comment, $device) {
        try {
            date_default_timezone_set('Asia/Kolkata');
            $entryDate = date('Y-m-d H:i:s');
            $status = 1;

            $query = "INSERT INTO Tbl_Analytic_EmployeeHappiness (clientId, surveyId, questionId, value, comment, userUniqueId, createdDate, flagetype, device, status) VALUES (:cid, :surveyId, :questionId, :rating, :comment, :empId, :entryDate, 20, :device, :status)";

            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $cId, PDO::PARAM_STR);
            $stmt->bindParam(':surveyId', $surveyId, PDO::PARAM_STR);
            $stmt->bindParam(':questionId', $surveyId, PDO::PARAM_STR);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':empId', $empId, PDO::PARAM_STR);
            $stmt->bindParam(':entryDate', $entryDate, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result['success'] = 1;
                $result['message'] = "Comment added successfully";
            }
        } catch (Exception $ex) {
            $result = $ex;
        }

        return $result;
    }

    public function surveyDetail($cId, $empId) {

        $status = 1;
        try {
            $query = "SELECT surveyId, question, DATE_FORMAT(startDate,'%d %b %Y %h:%i %p') startDate, DATE_FORMAT(expiryDate,'%d %b %Y %h:%i %p') expiryDate FROM Tbl_C_HappinessQuestion WHERE clientId=:cid AND status = :status AND DATE(createdDate) = CURDATE()";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':cid', $cId, PDO::PARAM_STR);
            //$stmt->bindParam(':surveyId', $surveyId, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
//			print_r($data);die;
            if ($data) {
                try {
                    $checkQuery = "SELECT count(auto_id) count FROM Tbl_Analytic_EmployeeHappiness WHERE surveyId=:questionId AND questionId=:questionId AND userUniqueId=:empId";
                    $stmt = $this->db_connect->prepare($checkQuery);
                    $stmt->bindParam(':questionId', $data['surveyId'], PDO::PARAM_STR);
                    $stmt->bindParam(':empId', $empId, PDO::PARAM_STR);
                    $stmt->execute();
                    $commentsCount = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($commentsCount['count'] == 0) {
                        $result['success'] = 1;
                        $result['message'] = "Happiness Index available";
                        $result['data'] = $data;
                    } else {
                        $result['success'] = 0;
                        $result['message'] = "You've already submitted your comment for this survey";
                    }
                } catch (Exception $ex) {
                    $result = $ex;
                }
            } else {
                $result['success'] = 0;
                $result['message'] = "No more Happiness Index available";
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }

}

?>
