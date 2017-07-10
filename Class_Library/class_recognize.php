<?php

if (!class_exists("Connection_Communication")) {
    include_once('class_connect_db_Communication.php');
}

class Recognize {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    public $idclient;

    /*     * ********************************** FUNCTION FOR API *********************************** */

    function getRecognizeDetails($client_id) {
        $this->idclient = $client_id;

        try {
            $query = "select * from Tbl_RecognizedEmployeeDetails where clientId=:cid order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($row);
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public $id_recog;

    function getonerecogdetails($regid) {
        $this->id_recog = $regid;

        try {
            $query = "select * , DATE_FORMAT(dateOfEntry,'%d %b %Y %h:%i %p') as dateOfEntry from Tbl_RecognizedEmployeeDetails where recognitionId =:rid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':rid', $this->id_recog, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $rows = $stmt->fetchAll();
        $response["success"] = 1;
        $response["message"] = "Displaying post details";
        $response["posts"] = $rows;

        return json_encode($response);
    }

    public $status;
    public $regid;
    public $topic;
    public $uid;
    public $point;
    public $recozby;

    //  updaterecognizestatus($rzid,$status,$cid,$topic,$userid,$point);          
    function updaterecognizestatus($regid, $status, $cid, $topic, $uid, $recozby, $point) {

        $this->regid = $regid;
        $this->status = $status;
        $this->idclient = $cid;
        $this->topic = $topic;
        $this->uid = $uid;
        $this->recozby = $recozby;
        $this->point = $point;

//echo "points -".$this->point;

        $this->recozby = $recozby;
        date_default_timezone_set('Asia/Kolkata');
        $date = date("Y-m-d H:i:s A");
        if ($this->status == "Reject") {
            try {
                $query = "update Tbl_RecognizedEmployeeDetails SET status =:sta where recognitionId =:rid and clientId =:cid";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':rid', $this->regid, PDO::PARAM_STR);
                $stmt->bindParam(':sta', $this->status, PDO::PARAM_STR);
                $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                $response = array();
                if ($stmt->execute()) {
                    $response["success"] = 1;
                    $response["message"] = "Recognition status has changed successfully";
                    return json_encode($response);
                }
            } catch (PDOException $t) {
                echo $t;
            }
        }


        if ($this->status == "Approve") {
            $account_status = "Credited";
//echo $uid;
            $totalpointsdata = self::getMaxtotalPoints($cid, $uid);
            $ert = json_decode($totalpointsdata, true);
            /* echo "<pre>";
              print_r($ert);
              echo "</pre>"; */
//echo "total point ".$ert['data'][0]['totalPoints'];
//echo $ert['success'];
            if ($ert['success'] == 1) {
                // $ert['data'][0]['totalPoints']
                $totlpoint = $ert['data'][0]['totalPoints'] + $this->point;
            } else {
                $totlpoint = $this->point;
            }
//echo "total_point ".$totlpoint."<br>";
            try {
                $query = "update Tbl_RecognizedEmployeeDetails SET status =:sta where recognitionId =:rid and clientId =:cid";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':rid', $this->regid, PDO::PARAM_STR);
                $stmt->bindParam(':sta', $this->status, PDO::PARAM_STR);
                $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                $response = array();
                if ($stmt->execute()) {

                    $query1 = "insert into Tbl_RecognizeApprovDetails(clientId,recognizeId,userId,recognizeBy,quality,points,totalPoints,entryDate,stmtStatus,regStatus)
               values(:cid,:rid,:uid,:uid1,:qul,:pts,:tpts,:edate,:regstatus,:ststatus)";

                    $stmt = $this->DB->prepare($query1);
                    $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                    $stmt->bindParam(':rid', $this->regid, PDO::PARAM_STR);
                    $stmt->bindParam(':uid', $this->uid, PDO::PARAM_STR);
                    $stmt->bindParam(':uid1', $this->recozby, PDO::PARAM_STR);
                    $stmt->bindParam(':qul', $this->topic, PDO::PARAM_STR);
                    $stmt->bindParam(':pts', $this->point, PDO::PARAM_STR);
                    $stmt->bindParam(':tpts', $totlpoint, PDO::PARAM_STR);
                    $stmt->bindParam(':edate', $date, PDO::PARAM_STR);
                    $stmt->bindParam(':ststatus', $this->status, PDO::PARAM_STR);
                    $stmt->bindParam(':regstatus', $account_status, PDO::PARAM_STR);
                    $response = array();
                    if ($stmt->execute())
                        $response["success"] = 1;
                    $response["message"] = "Recognition status has changed successfully";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                echo $e;
            }
        }
    }

    function getMaxtotalPoints($cid, $uid) {
        $this->idclient = $cid;
        $this->uid = $uid;
        //echo "userid:-".$this->uid."<br/>";
        //echo $this->idclient;
        try {
            $query = "select totalPoints from Tbl_RecognizeApprovDetails where autoId =(select max(autoId) from Tbl_RecognizeApprovDetails where clientId=:cid and userId =:uid)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $this->uid, PDO::PARAM_STR);
            $stmt->execute();
            $totalpoints = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //print_r($totalpoints);
            if (count($totalpoints) > 0) {
                $response1["success"] = 1;
                $response1['msg'] = 'data found';
                $response1["data"] = $totalpoints;
                return json_encode($response1);
            } else {
                $response1["success"] = 0;
                $response1["msg"] = 'data not found';

                return json_encode($response1);
            }
        } catch (PDoException $k) {
            echo $k;
        }
    }

    public function recognizeGetData($clientid) {
        try {
            $site_url = dirname(SITE_URL) . '/';

            $query = "select topicId,recognizeTitle,points, if(image IS NULL or image='', '', concat('" . $site_url . "',image)) as image,createdDate from Tbl_RecognizeTopicDetails where clientId=:cli";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query2 = "select topicId from Tbl_RecognizeTopicDetails where clientId=:cli";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt2->execute();
            $rows2 = $stmt2->fetchAll(PDO::FETCH_COLUMN, 0);

            if (COUNT($rows) > 0) {
                $response['success'] = 1;
                $response['msg'] = "User recognition value is added for client";
                $response['posts'] = $rows;
                $response['shortRecognised'] = $rows2;
            } else {
                $response['success'] = 0;
                $response['msg'] = "Recognised values and topic not found";
            }
            return $response;
        } catch (PDOException $e) {
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }

    function create_Comment($client, $pid, $comby, $comcon) {
        $this->clientid = $client;
        $this->postid = $pid;
        $this->commentedby = $comby;
        $this->commentcontent = $comcon;

        date_default_timezone_set('Asia/Calcutta');
        $cd = date('Y-m-d, h:i:s');

        try {
            $max = "select max(autoId) from Tbl_Analytic_RecognitionComment";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $commentid = "RegCom-" . $m_id1;
            }
        } catch (PDOException $e) {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }



        try {
            $query = "insert into Tbl_Analytic_RecognitionComment(commentId,clientId,recognitionId,comment,commentBy,dateOfComment)
            values(:pid,:cli,:pt,:cc,:pi,:cb)";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':pid', $commentid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pt', $this->postid, PDO::PARAM_STR);
            $stmt->bindParam(':cc', $this->commentcontent, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $this->commentedby, PDO::PARAM_STR);
            $stmt->bindParam(':cb', $cd, PDO::PARAM_STR);

            if ($stmt->execute()) {
                try {
                    $query1 = "SELECT * FROM Tbl_Analytic_RecognitionComment WHERE recognitionId = :pstid order by autoId desc";
                    $stmt1 = $this->DB->prepare($query1);
                    $stmt1->bindParam(':pstid', $this->postid, PDO::PARAM_STR);
                    $stmt1->execute();
                    $rows = $stmt1->fetchAll();

                    $response["posts"] = array();


                    if ($rows) {
                        $forimage = "http://admin.benepik.com/employee/virendra/benepik_admin/";

                        $response["success"] = 1;
                        $response["message"] = "Comment posted successfully";

                        for ($i = 0; $i < count($rows); $i++) {
                            $post = array();

                            $post["comment_id"] = $rows[$i]["commentId"];
                            $post["recognitionId"] = $rows[$i]["recognitionId"];
                            $post["comment"] = $rows[$i]["comment"];
                            $post["commentby"] = $rows[$i]["commentBy"];
                            $mailid = $rows[$i]["commentBy"];

                            $query2 = "SELECT Tbl_EmployeeDetails_Master.*, Tbl_EmployeePersonalDetails.* FROM Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId = Tbl_EmployeePersonalDetails.employeeId WHERE Tbl_EmployeeDetails_Master.employeeId =:maid";
                            $stmt2 = $this->DB->prepare($query2);
                            $stmt2->bindParam(':maid', $mailid, PDO::PARAM_STR);
                            $stmt2->execute();
                            $row = $stmt2->fetch();

                            $post["firstname"] = $row["firstName"];
                            $post["lastname"] = $row["lastName"];
                            $post["designation"] = $row["designation"];
                            $post["userImage"] = $forimage . $row["userImage"];
                            $d1 = $rows[$i]["dateOfComment"];

                            $date = date_create($d1);
                            $post["dateOfComment"] = date_format($date, "d M Y H:i A");

                            array_push($response["posts"], $post);
                        }

                        return $response;
                    } else {
                        $response["success"] = 0;
                        $response["message"] = "There is no comments for this post";
                        return $response;
                    }
                } catch (PDOException $e) {
                    echo $e;
                }
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    function like_recognition($clientId, $pid, $likedby, $status) {
        $this->clientid = $clientId;
        $this->postid = $pid;
        $this->likedby = $likedby;
        $this->status = $status;
        $this->points = 10;

        date_default_timezone_set('Asia/Kolkata');
        $cd = date('Y-m-d H:i:s');

        try {
            $totalLikesQuery = "select count(autoId) as totalLikes from Tbl_Analytic_RecognitionLikes where recognitionId=:pt and like_unlike_status='1'";
            $stmt = $this->DB->prepare($totalLikesQuery);
            $stmt->bindParam(':pt', $this->postid, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $totalLikes = $stmt->fetch(PDO::FETCH_ASSOC);
                $flag = '1';
                $LikesQuery = "select count(autoId) as totalLikes from Tbl_Analytic_RecognitionLikes where recognitionId=:pt and employeeId=:likedBy";
                $stmt = $this->DB->prepare($LikesQuery);
                $stmt->bindParam(':pt', $this->postid, PDO::PARAM_STR);
                $stmt->bindParam(':likedBy', $this->likedby, PDO::PARAM_STR);

                $stmt->execute();
                $likeCheck = $stmt->fetch(PDO::FETCH_ASSOC);

                $query = "insert into Tbl_Analytic_RecognitionLikes(clientId, recognitionId, employeeId, like_unlike_status, created_date) values(:cli, :pt, :likedBy, :status, :cd) ON DUPLICATE KEY UPDATE like_unlike_status=:status, updated_date=:cd";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
                $stmt->bindParam(':pt', $this->postid, PDO::PARAM_STR);
                $stmt->bindParam(':likedBy', $this->likedby, PDO::PARAM_STR);
                $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
                $stmt->bindParam(':cd', $cd, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    if ($likeCheck['totalLikes'] == 0) {
                        $getRecognizedUserQuery = "SELECT recognitionTo,topic from Tbl_RecognizedEmployeeDetails WHERE recognitionId=:pt AND clientId=:cli";
                        $stmt = $this->DB->prepare($getRecognizedUserQuery);
                        $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
                        $stmt->bindParam(':pt', $this->postid, PDO::PARAM_STR);
                        $stmt->execute();
                        $getRecognizedUser = $stmt->fetch(PDO::FETCH_ASSOC);
                        extract($getRecognizedUser);

                        $totalpointsdata = self::getMaxtotalPoints($clientId, $recognitionTo);
                        $ert = json_decode($totalpointsdata, true);

                        if ($ert['success'] == 1) {
                            $totlpoint = $ert['data'][0]['totalPoints'] + $this->points;
                        } else {
                            $totlpoint = $this->points;
                        }
                        $stmtStatus = 'Credited';
                        $status = "Approve";

                        $query = "insert into Tbl_RecognizeApprovDetails (clientId, recognizeId, userId, recognizeBy, quality, points, totalPoints, entryDate, stmtStatus, regStatus, flag) VALUES (:cli, :reg, :rto, :rby, :top, :pts, :tpts, :dat, :stmtStatus, :status, :flag)";
                        $stmt = $this->DB->prepare($query);
                        $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
                        $stmt->bindParam(':reg', $this->postid, PDO::PARAM_STR);
                        $stmt->bindParam(':rto', $recognitionTo, PDO::PARAM_STR);
                        $stmt->bindParam(':rby', $this->likedby, PDO::PARAM_STR);
                        $stmt->bindParam(':top', $topic, PDO::PARAM_STR);
                        $stmt->bindParam(':pts', $this->points, PDO::PARAM_STR);
                        $stmt->bindParam(':tpts', $totlpoint, PDO::PARAM_STR);
                        $stmt->bindParam(':dat', $cd, PDO::PARAM_STR);
                        $stmt->bindParam(':stmtStatus', $stmtStatus, PDO::PARAM_STR);
                        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                        $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
                        $stmt->execute();
                    }
                }

                $totalLikesQuery = "select count(autoId) as totalLikes from Tbl_Analytic_RecognitionLikes where recognitionId=:pt and like_unlike_status='1'";
                $stmt = $this->DB->prepare($totalLikesQuery);
                $stmt->bindParam(':pt', $this->postid, PDO::PARAM_STR);
                $stmt->execute();
                $totalLikes = $stmt->fetch(PDO::FETCH_ASSOC);

                $result['success'] = 1;
                $result['likeStatus'] = $status;
                $result['totalLikes'] = $totalLikes['totalLikes'];
                $result['message'] = ($this->status == '1') ? "Recognition liked successfully" : "Recognition unliked successfully";
            } else {
                $result['success'] = 0;
                $result['message'] = ($this->status == '1') ? "Recognition liked failed" : "Recognition unliked failed";
            }
        } catch (PDOException $e) {
            $result = $e;
        }
        return $result;
    }

    public function Comment_display($clientid, $postid) {

        $path = "http://admin.benepik.com/employee/virendra/benepik_admin/";
        try {
            $query = "select * from Tbl_Analytic_RecognitionComment where recognitionId =:pi and clientId=:cli order by autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':pi', $postid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            if ($rows) {

                $response["Success"] = 1;
                $response["Message"] = "Recognition Comments are display here";
                $response["Posts"] = array();

                foreach ($rows as $row) {
                    $post["commentId"] = $row["commentId"];
                    $post["commentBy"] = $row["commentBy"];
                    $employeeid = $row["commentBy"];


                    $query = "select Tbl_EmployeeDetails_Master.*,Tbl_EmployeePersonalDetails.* from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeeDetails_Master.employeeId=Tbl_EmployeePersonalDetails.employeeId where Tbl_EmployeeDetails_Master.employeeId=:empid";
                    $stmt = $this->DB->prepare($query);
                    $stmt->bindParam(':empid', $employeeid, PDO::PARAM_STR);
                    $stmt->execute();
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    $post["name"] = $rows["firstName"];
                    $post["userImage"] = $path . $rows["userImage"];
                    $post["designation"] = $rows["designation"];
                    $post["comment"] = $row["comment"];
                    $d1 = $row["dateOfComment"];

                    $date = date_create($d1);
                    $post["dateOfComment"] = date_format($date, "d M Y H:i A");

                    array_push($response["Posts"], $post);
                }
            } else {
                $response["Success"] = 0;
                $response["Message"] = "There is no comment for this recognition";
            }
            return $response;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function recognitionLeaderboard($clientId, $employeeId = '', $site_url = '') {
        try {
            if (empty($site_url)) {
                $site_url = ($employeeId == '') ? dirname(SITE_URL) . '/' : site_url;
            }

            $query = "SELECT distinct(recognition.recognitionTo) as recognizedUser, if(master.lastName IS NULL OR master.lastName='', master.firstName, CONCAT(master.firstName, ' ', master.lastName)) as username, if(personal.userImage IS NULL or personal.userImage='', '', CONCAT('" . $site_url . "', personal.userImage)) as user_image, master.designation, (select count(recognitionTo) from Tbl_RecognizedEmployeeDetails where recognitionTo=recognition.recognitionTo) as totalRecognition, if((select SUM(points) from Tbl_RecognizeApprovDetails where userId=recognition.recognitionTo),(select SUM(points) from Tbl_RecognizeApprovDetails where userId=recognition.recognitionTo),0) as totalPoints FROM Tbl_RecognizedEmployeeDetails as recognition RIGHT JOIN Tbl_EmployeeDetails_Master as master ON recognition.recognitionTo=master.employeeId RIGHT JOIN Tbl_EmployeePersonalDetails as personal ON master.employeeId=personal.employeeId WHERE master.clientId=:cli";

            if ($employeeId != '') {
                $query .= " and master.employeeId='$employeeId' ";
            } else {
            	$query .= " and (select SUM(points) from Tbl_RecognizeApprovDetails where userId=recognition.recognitionTo)>0";
            }
            $query .= " ORDER BY totalPoints DESC";

            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
//            $stmt->bindParam(':recognizeId', $recognitionid, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result['success'] = 1;
                $result['data'] = $row;
            } else {
                $result['success'] = 0;
                $result['message'] = "No data available";
            }
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }

    public function recognitionLeaderboardDetail($clientId, $userId, $site_url = '') {
        try {
            $site_url = (!empty($site_url)) ? $site_url : site_url;
            $query = "SELECT badges.topicId,badges.recognizeTitle, if(badges.image IS NULL or badges.image='', '', CONCAT('" . $site_url . "', badges.image)) as image FROM Tbl_RecognizedEmployeeDetails AS recognition JOIN Tbl_RecognizeTopicDetails as badges ON recognition.topic=badges.topicId WHERE recognition.clientId=:cli AND recognition.recognitionTo=:uid order by DATE_FORMAT(recognition.dateOfEntry,'%d-%m-%Y %H:%i') desc";
            if (!empty($site_url) && ($site_url != site_url)) {
                $query .= " limit 0,3";
            }
            
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $badgesList = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $result['success'] = 1;
            $result['message'] = "Recognition detail";
            $result['data']['badges'] = $badgesList;
        } catch (Exception $ex) {
            $result = $ex;
        }
        return $result;
    }
	
	
	/******************************** refer budge **************************/
	
	  function ReferBudge($badgeName , $comment , $referredBy) {
        
	    date_default_timezone_set('Asia/Kolkata');
        $cd = date('Y-m-d H:i:s');
		
        try {
            $query = "insert into Tbl_ReferBadge (badgeName, comment, referredBy, createDate) VALUES (:bname, :comm, :referedby, :cd)";
            
			$stmt = $this->DB->prepare($query);
            $stmt->bindParam(':bname', $badgeName, PDO::PARAM_STR);
			$stmt->bindParam(':comm', $comment, PDO::PARAM_STR);
			$stmt->bindParam(':referedby', $referredBy, PDO::PARAM_STR);
			$stmt->bindParam(':cd', $cd, PDO::PARAM_STR);
			
            $res = $stmt->execute();
            if($res)
			{
				$response['success'] = 1;
				$response['message'] = "referred successfully";
			}
			else{
				$response['success'] = 0;
				$response['message'] = "not referred successfully";
			}

            
        } catch (PDOException $e) {
            $response['success'] = 0;
			$response['message'] = "not referred successfully".$e;
        }
		return json_encode($response);
    }
	
	
	/******************************** refer budge **************************/

    /*     * ********************************** / FUNCTION FOR API *********************************** */
    /*     * ********************************** FUNCTION FOR PANEL *********************************** */
    /*     * ******************************* get recognition list ************************************ */

    function getRecognitionList($client_id) {
        $this->idclient = $client_id;

        try {
            $query = "select recognize.* , CONCAT(edm.firstName,' ',edm.middleName,' ',edm.lastName) as recognitionByName , CONCAT(edm1.firstName,' ',edm1.middleName,' ',edm1.lastName) as recognitionToName, DATE_FORMAT(recognize.dateOfEntry,'%d %b %Y %h:%i %p') as dateOfEntry , topic.recognizeTitle as recognizefor from Tbl_RecognizedEmployeeDetails as recognize JOIN Tbl_EmployeeDetails_Master as edm ON recognize.recognitionBy = edm.employeeId JOIN Tbl_EmployeeDetails_Master as edm1 ON  recognize.recognitionTo = edm1.employeeId JOIN Tbl_RecognizeTopicDetails as topic ON recognize.topic = topic.topicId where recognize.clientId=:cid order by recognize.autoId desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($row) {
                $response['success'] = 1;
                $response['message'] = "reconition list fetch successfully";
                $response['data'] = $row;
            } else {
                $response['success'] = 0;
                $response['message'] = "reconition list not fetch successfully";
            }
        } catch (PDOException $e) {
            $response['success'] = 0;
            $response['message'] = "reconition list not fetch successfully" . $e;
        }
        return json_encode($response);
    }

    /*     * ************************************* / get recognition list *************************** */

    /*     * ************************************ recognition detail ******************************** */

    function getemplyeerecogdetails($regid, $clientId) {
        $this->id_recog = $regid;
        $path = SITE;
        try {
            $query = "select recognize.* , DATE_FORMAT(recognize.dateOfEntry,'%d %b %Y %h:%i %p') as dateOfEntry , CONCAT(edm.firstName,' ',edm.middleName,' ',edm.lastName) as recognitionByName  , CONCAT(edm1.firstName,' ',edm1.middleName,' ',edm1.lastName) as recognitionToName , edm1.designation as recognizetodesignation , topic.recognizeTitle , if(topic.image='' OR topic.image IS NULL , '',CONCAT('" . $path . "',topic.image)) as rimage , if(epd.userImage IS NULL OR epd.userImage ='','',CONCAT('" . $path . "',epd.userImage))as recognizebyimage , if(epd1.userImage IS NULL OR epd1.userImage ='','',CONCAT('" . $path . "',epd1.userImage))as recognizeToimage from Tbl_RecognizedEmployeeDetails as recognize JOIN Tbl_EmployeeDetails_Master as edm ON recognize.recognitionBy = edm.employeeId JOIN Tbl_EmployeeDetails_Master as edm1 ON recognize.recognitionTo = edm1.employeeId JOIN Tbl_RecognizeTopicDetails as topic ON recognize.topic = topic.topicId JOIN Tbl_EmployeePersonalDetails as epd ON edm.employeeId = epd.employeeId JOIN Tbl_EmployeePersonalDetails as epd1 ON edm1.employeeId = epd1.employeeId  where recognize.recognitionId =:rid AND recognize.clientId = :cid ";

            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':rid', $this->id_recog, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch();
            if ($rows) {
                $status = 1;
                /*                 * ********************* get like ************************ */
                $query1 = "select count(autoId) as likes from Tbl_Analytic_RecognitionLikes where recognitionId = :rid1 AND clientId = :cid1 AND like_unlike_status = :status1 ";

                $stmt1 = $this->DB->prepare($query1);
                $stmt1->bindParam(':rid1', $this->id_recog, PDO::PARAM_STR);
                $stmt1->bindParam(':cid1', $clientId, PDO::PARAM_STR);
                $stmt1->bindParam(':status1', $status, PDO::PARAM_STR);
                $stmt1->execute();
                $totallike = $stmt1->fetch();
                $countlike = count($totallike);

                if ($countlike > 0) {
                    $query3 = "select DATE_FORMAT(likes.created_date,'%d %b %Y %h:%i %p') as created_date , CONCAT(edm.firstName,' ',edm.middleName,' ',edm.lastName) likeByName ,if(epd.userimage IS NULL OR epd.userimage = '','',CONCAT('" . $path . "',epd.userimage)) as likebyimage from Tbl_Analytic_RecognitionLikes as likes JOIN Tbl_EmployeeDetails_Master as edm ON likes.employeeId = edm.employeeId JOIN Tbl_EmployeePersonalDetails as epd ON edm.employeeId = epd.employeeId where likes.recognitionId = :rid3 AND likes.clientId = :cid3 and likes.like_unlike_status = :status3 ";

                    $stmt3 = $this->DB->prepare($query3);
                    $stmt3->bindParam(':rid3', $this->id_recog, PDO::PARAM_STR);
                    $stmt3->bindParam(':cid3', $clientId, PDO::PARAM_STR);
                    $stmt3->bindParam(':status3', $status, PDO::PARAM_STR);
                    $stmt3->execute();
                    $likedetails = $stmt3->fetchAll();
                } else {
                    $likedetails = "";
                }
                /*                 * ********************* / get like ********************** */

                $response["success"] = 1;
                $response["message"] = "details fetch successfully";
                $response["totallikes"] = $totallike;
                $response["posts"] = $rows;
                $response["likedetails"] = $likedetails;
            } else {
                $response["success"] = 0;
                $response["message"] = "details not fetch";
            }
        } catch (PDOException $e) {
            $response["success"] = 0;
            $response["message"] = "details not fetch" . $e;
        }
        return json_encode($response);
    }

    /*     * ************************************ / recognition detail ****************************** */

    /*     * *************************** top recognize user ***************************************** */

    function topRecognizeUser($clientId, $fromdate, $todate , $path='') {
        try {

            if ($fromdate == "" && $todate == "") {
                $imagepath = SITE;
                $query = "SELECT distinct(recognition.recognitionTo) as recognizedUser, if(master.lastName IS NULL OR master.lastName='', master.firstName, CONCAT(master.firstName, ' ',master.middleName,' ', master.lastName)) as username, if(personal.userImage IS NULL or personal.userImage='', '', CONCAT('" . $imagepath . "', personal.userImage)) as user_image, master.designation, (select count(recognitionTo) from Tbl_RecognizedEmployeeDetails where recognitionTo=recognition.recognitionTo) as totalRecognition, (select SUM(points) from Tbl_RecognizeApprovDetails where userId=recognition.recognitionTo) as totalPoints FROM Tbl_RecognizedEmployeeDetails as recognition JOIN Tbl_EmployeeDetails_Master as master ON recognition.recognitionTo=master.employeeId JOIN Tbl_EmployeePersonalDetails as personal ON master.employeeId=personal.employeeId WHERE recognition.clientId=:cli ORDER BY totalPoints DESC";
            } else {

                $query = "SELECT distinct(recognition.recognitionTo) as recognizedUser, if(master.lastName IS NULL OR master.lastName='', master.firstName, CONCAT(master.firstName, ' ',master.middleName,' ', master.lastName)) as username, if(personal.userImage IS NULL or personal.userImage='', '', CONCAT('" . $path . "', personal.userImage)) as user_image, master.designation, (select count(recognitionTo) from Tbl_RecognizedEmployeeDetails where recognitionTo=recognition.recognitionTo) as totalRecognition, (select SUM(points) from Tbl_RecognizeApprovDetails where userId=recognition.recognitionTo) as totalPoints FROM Tbl_RecognizedEmployeeDetails as recognition JOIN Tbl_EmployeeDetails_Master as master ON recognition.recognitionTo=master.employeeId JOIN Tbl_EmployeePersonalDetails as personal ON master.employeeId=personal.employeeId WHERE (DATE(recognition.dateOfEntry) BETWEEN :fromdte AND :enddte) AND recognition.clientId=:cli ORDER BY totalPoints DESC";
            }

            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
            if ($fromdate != "" && $todate != "") {
                $stmt->bindParam(':fromdte', $fromdate, PDO::PARAM_STR);
                $stmt->bindParam(':enddte', $todate, PDO::PARAM_STR);
            }
            if ($stmt->execute()) {
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($fromdate == "" && $todate == "") {
                    $result['success'] = 1;
                    $result['message'] = "data available";
                    $result['data'] = $row;
                } else {
                    $result = $row;
                }
            } else {
                $result['success'] = 0;
                $result['message'] = "No data available";
            }
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "No data available" . $ex;
        }
        return json_encode($result);
    }

    /*     * *************************** / top recognize user *************************************** */

    /*     * **************************** user recognize details **************************** */

    function userrecognitionDetail($clientId, $userId) {
        try {
            $site_url = SITE;

            $query = "SELECT CONCAT(edm.firstName,' ',edm.middleName,' ',edm.lastName) as employeename , edm.designation , if(epd.userimage = '' OR epd.userimage IS NULL , '' , CONCAT('" . $site_url . "',userimage)) as userimage from Tbl_EmployeeDetails_Master as edm JOIN Tbl_EmployeePersonalDetails as epd ON edm.employeeId = epd.employeeId where edm.employeeId = :uid AND edm.clientId = :cli";

            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':uid', $userId, PDO::PARAM_STR);
            $stmt->execute();
            $recognizeuserdetail = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($recognizeuserdetail) {
                $query1 = "SELECT recognize.recognitionId,recognize.dateOfEntry,recognize.text , if(topic.image = '' OR topic.image IS NULL , '' , CONCAT('" . $site_url . "',topic.image)) as topicimage , topic.recognizeTitle , if(epd.userimage IS NULL OR epd.userimage = '' , '' , CONCAT('" . $site_url . "',epd.userimage)) as recognizebyimage , CONCAT(edm.firstName,' ',edm.middleName,' ',edm.lastName) as recognizebyname FROM Tbl_RecognizedEmployeeDetails as recognize JOIN Tbl_RecognizeTopicDetails as topic ON recognize.topic=topic.topicId JOIN Tbl_EmployeePersonalDetails as epd ON recognize.recognitionBy = epd.employeeId JOIN Tbl_EmployeeDetails_Master as edm ON recognize.recognitionBy = edm.employeeId where recognize.recognitionTo = :uid1 And recognize.clientId = :cli1";

                $stmt1 = $this->DB->prepare($query1);
                $stmt1->bindParam(':cli1', $clientId, PDO::PARAM_STR);
                $stmt1->bindParam(':uid1', $userId, PDO::PARAM_STR);
                $stmt1->execute();
                $recognizeuser = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $recognizeuser = "";
            }


            $result['success'] = 1;
            $result['message'] = "Recognition detail";
            $result['data'] = $recognizeuserdetail;
            $result['recognizedata'] = $recognizeuser;
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "Not Fetch Recognition detail" . $ex;
        }
        return json_encode($result);
    }

    /*     * ****************************** / user recognize details ************************ */
	
	/*************************** get referred badge list **********************/
	
	 function referredbadgelist($clientId) {
        try {
           
		   $query = "SELECT badge.* , DATE_FORMAT(badge.createDate,'%d %b %Y %h:%i %p') as createDate , CONCAT(edm.firstName,' ',edm.middleName,' ',edm.lastName) as referredbyname , edm.emailId as referredbyemailId from Tbl_ReferBadge as badge JOIN Tbl_EmployeeDetails_Master as edm ON badge.referredBy = edm.employeeId AND edm.clientId = :cli";

            $stmt = $this->DB->prepare($query);
			$stmt->bindParam(':cli', $clientId, PDO::PARAM_STR);
            $stmt->execute();
            $referredbadge = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if($referredbadge)
			{
            $result['success'] = 1;
            $result['message'] = "referred Badge detail";
            $result['data'] = $referredbadge;
			}
			else
			{
			$result['success'] = 0;
            $result['message'] = "referred Badge detail not fetch";
			}
        } catch (Exception $ex) {
            $result['success'] = 0;
            $result['message'] = "referred Badge detail not fetch" . $ex;
        }
        return json_encode($result);
    }
	
	/*************************** / get referred badge list ********************/
	
    /*     * ***************************** / FUNCTION FOR PANEL *********************************** */
}

?>
