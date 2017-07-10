<?php

if (!class_exists("Connection_Communication")) {
    include_once('class_connect_db_Communication.php');
}

class HealthWellness {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public function createHealthExercise($clientId, $exercise_area_id, $exercise_name, $exercise_image, $exercise_instructions, $disclaimer, $disclaimer, $status, $create_Date, $flag) {
        try {
            $query = "insert into Tbl_HealthWellness(clientId,exercise_area_id,exercise_name,exercise_image,exercise_instruction, disclaimer, flagType,status,create_date)
            values(:cid,:exercise_type,:exercise_name,:exercise_image,:instruction, :disclaimer, :flag,:status,:create_date)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':exercise_type', $exercise_area_id, PDO::PARAM_STR);
            $stmt->bindParam(':exercise_name', $exercise_name, PDO::PARAM_STR);
            $stmt->bindParam(':exercise_image', $exercise_image, PDO::PARAM_STR);
            $stmt->bindParam(':instruction', $exercise_instructions, PDO::PARAM_STR);
            $stmt->bindParam(':disclaimer', $disclaimer, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':create_date', $create_Date, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = $this->DB->lastInsertId();
                return $result;
            }
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    public function updateHealthExercise($exercise_id, $exercise_area_id, $exercise_name, $exercise_image, $exercise_instructions, $disclaimer, $update_Date, $flag) {
        try {
            $query = "UPDATE Tbl_HealthWellness SET exercise_area_id=:exercise_type, exercise_name=:exercise_name, exercise_image=:exercise_image, exercise_instruction=:instruction, disclaimer=:disclaimer, flagType=:flag, update_date=:update_date WHERE autoId=:exerciseId";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':exerciseId', $exercise_id, PDO::PARAM_STR);
            $stmt->bindParam(':exercise_type', $exercise_area_id, PDO::PARAM_STR);
            $stmt->bindParam(':exercise_name', $exercise_name, PDO::PARAM_STR);
            $stmt->bindParam(':exercise_image', $exercise_image, PDO::PARAM_STR);
            $stmt->bindParam(':instruction', $exercise_instructions, PDO::PARAM_STR);
            $stmt->bindParam(':disclaimer', $disclaimer, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':update_date', $update_Date, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $result = true;
                return $result;
            }
        } catch (Exception $ex) {
            echo $ex;
        }
    }

    function compress_image($source_url, $destination_url, $quality) {
        $imagevalue = filesize($source_url);
        $valueimage = $imagevalue / 1024;
//        if ($valueimage > 40) {
//            $info = getimagesize($source_url);
//            
//            if ($info['mime'] == 'image/jpeg')
//                $image = imagecreatefromjpeg($source_url);
//            elseif ($info['mime'] == 'image/gif')
//                $image = imagecreatefromgif($source_url);
//            elseif ($info['mime'] == 'image/png')
//                $image = imagecreatefrompng($source_url);
//
//            //save it
//            imagejpeg($image, $destination_url, $quality);
//
//            //return destination file url
//            return $destination_url;
//        }
//        else {
        move_uploaded_file($source_url, $destination_url);
//        }
    }

    function HealthMaxId() {
        try {
            $max = "select max(autoId) from Tbl_HealthWellness";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $postid = "" . $m_id1;

                return $postid;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    public function getExerciseArea($clientId) {
        try {
            $query = "SELECT * FROM Tbl_Exercise WHERE clientId=:cid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }

    public function getExercises($clientId, $device = '') {
        try {
            $site_url = (!empty($device))?dirname(SITE_URL).'/'  :SITE;
            $query = "SELECT if(category_image IS NULL or category_image='', '', CONCAT('" . $site_url . "',category_image)) as exercise_cat_image, exercise_area, autoId as exercise_area_id FROM Tbl_Exercise as exercise WHERE clientId=:cid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }
    
    public function getExercisesList($clientId, $device = '') {
        try {
            $site_url = (!empty($device))?dirname(SITE_URL).'/'  :SITE;
            $query = "SELECT if(exercise.category_image IS NULL or category_image='', '', CONCAT('" . $site_url . "',exercise.category_image)) as exercise_cat_image, exercise.exercise_area, exercise.autoId as exercise_area_id, health.exercise_image, health.exercise_instruction, health.exercise_name, health.autoId FROM Tbl_Exercise as exercise JOIN Tbl_HealthWellness as health ON exercise.autoId=health.exercise_area_id WHERE exercise.clientId=:cid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }

    public function getExercise($clientId, $healthId, $device = '') {
        try {
            $site_url = (!empty($device))?dirname(SITE_URL).'/'  :SITE;
            $query = "SELECT *, if(exercise_image IS NULL or exercise_image='', '', CONCAT('" . $site_url . "',exercise_image)) as exercise_image FROM Tbl_HealthWellness WHERE clientId=:cid AND status='1' AND autoId=:eid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $healthId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }
    
    public function getExerciseSingle($clientId, $exerciseId, $device = '') {
        try {
            $site_url = (!empty($device))?dirname(SITE_URL).'/'  :SITE;
            $query = "SELECT *, if(exercise_image IS NULL or exercise_image='', '', CONCAT('" . $site_url . "',exercise_image)) as exercise_image FROM Tbl_HealthWellness WHERE clientId=:cid AND status='1' AND exercise_area_id =:eid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $exerciseId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }

/*********************************** health and wellness status **************/

 function status_HealthWellness($id, $status) {
 $flag = 24;
        try {
            $query = "update Tbl_HealthWellness set status = :sta where autoId = :id And flagType = :flag";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $status, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $row = $stmt->execute();

            if ($row) 
			{
                $response["success"] = 1;
                $response["message"] = "Health & Wellness status has changed";
            }
			else 
			{
                $response["success"] = 0;
                $response["message"] = "Health & Wellness status Not change";
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
                $response["message"] = "Health & Wellness status Not change".$e;
        }
		 return json_encode($response);
    }
/****************************** / health and wellness status *****************/	

/******************************* get single exercise detail from tbl exercise **********/
public function singleExerciseDetails($clientId, $exerciseId) {
        try {
            $path = SITE_URL;
            $query = "SELECT * , if(category_image IS NULL OR category_image = '' , '' , CONCAT('".$path."',category_image)) as category_image from Tbl_Exercise where clientId = :cid AND autoId = :eid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':eid', $exerciseId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }
/***************************** get single exercise detail from tbl exercise **********/
}

?>
