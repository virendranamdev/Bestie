<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!class_exists('Connection_Communication')) {
    require_once('class_connect_db_Communication.php');
}
class Like {

    public $DB;
    public $db_connect;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function create_Like($clientid, $pid, $likby, $flag, $device,$deviceid) {
        date_default_timezone_set('Asia/Calcutta');
        $cd = date("Y-m-d H:i:s");

		$pathimg = site_url;
		
        try {
            $query = "insert into Tbl_Analytic_PostLike(clientId,postId,likeBy,likeDate,flagType,device,deviceId)
             values(:cli,:pt,:li,:cd,:flag,:device,:devid)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $pid, PDO::PARAM_STR);
            $stmt->bindParam(':li', $likby, PDO::PARAM_STR);
            $stmt->bindParam(':cd', $cd, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':device', $device, PDO::PARAM_STR);
             $stmt->bindParam(':devid', $deviceid, PDO::PARAM_STR);
            if ($stmt->execute()) {
				
				
                $query2 = "select count(postId) as total_likes from Tbl_Analytic_PostLike where postId =:pi and clientId=:cli And status = 1 and flagType = :flag2";
                $stmt2 = $this->DB->prepare($query2);
                $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
                $stmt2->bindParam(':pi', $pid, PDO::PARAM_STR);
				 $stmt2->bindParam(':flag2', $flag, PDO::PARAM_STR);
                $stmt2->execute();
                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
				
				$query3 = "select CONCAT(edm.firstName,' ',edm.middleName,' ',edm.lastName) as name , if(epd.userImage IS NULL OR epd.userImage ='','',CONCAT('". $pathimg ."',epd.userImage)) as userImage , edm.designation From Tbl_EmployeeDetails_Master as edm JOIN Tbl_EmployeePersonalDetails as epd ON edm.employeeId = epd.employeeId where edm.employeeId = :empid3 AND edm.clientId = :cli3";
				
                $stmt3 = $this->DB->prepare($query3);
                $stmt3->bindParam(':cli3', $clientid, PDO::PARAM_STR);
                $stmt3->bindParam(':empid3', $likby, PDO::PARAM_STR);
                $stmt3->execute();
                $rowres3 = $stmt3->fetch(PDO::FETCH_ASSOC);
				
				//print_r($rowres3);
			

                $response["success"] = 1;
                $response["message"] = "You have liked this post successfully";
                $response['total_likes'] = $row2['total_likes'];
                $response["post"] = self::totallikes($clientid, $pid, $flag);
				$response["posts"] = $rowres3;
                return $response;
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "You already liked this post";
            return $response;
        }
    }

    /*     * **************************************************************************************** */

    function totallikes($clientid, $pid , $flag) {
        try {
            $query = "select count(likeBy) as total_likes from Tbl_Analytic_PostLike where clientId=:cli and postId=:pt And status = 1 And flagType = :flag";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $pid, PDO::PARAM_STR);
			$stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                $response["success"] = 1;
                $response["message"] = "like here";
                $response["total_likes"] = $row["total_likes"];
                $response["postId"] = $pid;
            } else {
                $response["success"] = 0;
                $response["message"] = "No like here";
            }
            return $response;
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "No like";
            return $response;
        }
    }

    function getTotalLikeANDcomment($client, $postid, $FLAG, $site_url='') {
        $path = (!empty($site_url))?$site_url:site_url;
        try {
            $query = "select *,DATE_FORMAT(likeDate,'%d %b %Y %h:%i %p') as likeDate from Tbl_Analytic_PostLike where postId =:pi and clientId=:cli and flagType=:flag And status = 1";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $client, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $postid, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $FLAG, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            if ($rows) {

                $response["Success"] = 1;
                $response["Message"] = "Like data display here";
                $response["Posts"] = array();

                foreach ($rows as $row) {
                    $post["postId"] = $row["postId"];
                    $post["uuid"] = $row["likeBy"];
                    $employeeid = $row["likeBy"];


                    $query = "select Tbl_EmployeeDetails_Master.*,Tbl_EmployeePersonalDetails.* from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId=Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId=:empid";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
                    $stmt->execute();
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    $post["name"] = $rows["firstName"]." ".$rows["middleName"]." ".$rows["lastName"];
                    $post["userImage"] = ($rows["userImage"] == "")?"":$path . $rows["userImage"];
					$post["designation"] = $rows["designation"];
                    $post["likeDate"] = $row["likeDate"];
                    $post["clientId"] = $row["clientId"];
                    array_push($response["Posts"], $post);
                }
            } else {
                $response["Success"] = 0;
                $response["Message"] = "There is no display like";
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
        }
    }

}

?>