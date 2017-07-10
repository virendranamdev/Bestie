<?php

//error_reporting(E_ALL);ini_set('display_errors', 1);

if (!class_exists("PushNotification") && include_once('../../Class_Library/class_push_notification.php')) {
    include_once ('../../Class_Library/class_get_group.php');
    include_once ('../../Class_Library/class_reading.php');
    include_once ('../../Class_Library/class_welcomeTable.php');
    include_once ("../../Class_Library/Api_Class/class_family.php");    
    include_once('../Class_Library/class_get_group.php');  // for getting all group

    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
        //echo json_encode($response);
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    $jsonArr = json_decode(file_get_contents("php://input"), true);
    $obj = new Family();
    $obj_group = new Group();                  //class_get_group.php
    $read = new Reading();                    //   class_reading.php 
    $push = new PushNotification();            // class_push_notification.php
    $welcome_obj = new WelcomePage();
   $customGroup = new Group();                  //class_get_group.php
   
    if ((!empty($jsonArr["clientId"])) && (!empty($jsonArr['device'])) && (!empty($jsonArr['deviceId']))) {
        extract($jsonArr);
        if (strtolower($mesg) != $obj->filterWords($mesg)) {
            $response['success'] = 0;
            $response['message'] = "Your Comment contains inappropriate language";
        } else {
            $site_url = dirname(SITE_URL).'/';
            $result = $obj->getUserDetails($clientId, $recognitionby, $site_url);
	    $senderImage = $result['UserDetails']['userImage'];
	    $senderUsername = $result['UserDetails']['firstName'];
	    
            if ($result['success'] == 1) {
                $rzid = $obj->maxIdRecognition($clientId);
                $response = $obj->insertUserRecognition($clientId, $recognitionto, $recognitionby, $topicId, $recognizeTitle, $mesg, $points);

                $type = 'Recognition';
                $text = '';
                $image = '';
                date_default_timezone_set('Asia/Kolkata');
                $post_date = date('Y-m-d, H:i:s');
                $Flag = '10';
                $result1 = $welcome_obj->createWelcomeData($clientId, $rzid, $type, $text, $image, $post_date, $recognitionby, $Flag);


                /** ************************* find group ****************** */
                $result = $obj_group->getGroup($clientId);
                $value = json_decode($result, true);
                $getcat = $value['posts'];

                $myArray = array();
                foreach ($getcat as $groupid) {
                    array_push($myArray, $groupid['groupId']);
                }

                $groupcount = count($myArray);
                $general_group = array();
                 $custom_group = array();
                for ($k = 0; $k < $groupcount; $k++) {
                    $result1 = $read->recognizeSentToGroup($clientId, $rzid, $myArray[$k]);
                    
                    /***********************  custom group *********************/
                  $groupdetails = $read->getGroupDetails($clientId, $myArray[$k]);  //get all groupdetails
                    if ($groupdetails['groupType'] == 2) {
                        array_push($custom_group, $myArray[$k]);
                    } else {
                        array_push($general_group, $myArray[$k]);
                    }
                }
                unset($response['rcid']);

		
		$BY = $recognitionby;
		$flagvalue = "";
             	$User_Type = "Selected";
		$like_val  = "";
		$comment_val = "";
		$hrimg	= "";
                /*                 * ********************** get keypem *********************************** */
                $googleapiIOSPem = $push->getKeysPem($clientId);
//print_r($googleapiIOSPem);
                /*                 * ********************** get keypem *********************************** */
                
/******************  fetch all user employee id from user detail start **************************** */
if (count($general_group) > 0) {
       
        $gcm_value = $push->get_Employee_details($User_Type, $general_group, $clientId);
    
        $generaluserid = json_decode($gcm_value, true);

    }
    else{   
               $generaluserid = array();
    }
    if (count($custom_group) > 0) {
        $gcm_value1 = $customGroup->getCustomGroupUser($clientId, $custom_group);
        $customuserid = json_decode($gcm_value1, true);

    }
     else{
              $customuserid = array();
    }
    /*************get group admin uuid  form group admin table if user type not= all ************** */

                /*                 * ************************** group admin id ****************************** */
                if ($User_Type != 'All') {
                 //   $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientId);
                 //   $adminuuid = json_decode($groupadminuuid, true);
                    /* echo "hello groupm admin id";
                      echo "<pre>";
                      print_r($adminuuid)."<br/>";
                      echo "</pre>";
                      echo "--------------all employee id---------"; */

                    $allempid = array_merge($generaluserid, $customuserid);
                    /* echo "<pre>";
                      print_r($allempid);
                      echo "<pre>";

                      echo "--------------all unique employee id---------"; */

                    $allempid1 = array_values(array_unique($allempid));
                    /* echo "user unique id";
                      echo "<pre>";
                      print_r($allempid1);
                      echo "<pre>"; */
                } else {
//echo "within all user type".$User_Type."<br/>";
                    $allempid1 = $generaluserid;
                }
                /*                 * ************************** / group admin id ****************************** */

                /*                 * ********************** insert into post sent to table ******************* */

                $total = count($allempid1);
                for ($i = 0; $i < $total; $i++) {
                    $uuid = $allempid1[$i];
//echo "count no.:-".$i."->".$uuid."<br/>";
                    if (!empty($uuid)) {
                        $read->postSentTo($clientId, $rzid, $uuid, $Flag);
                    } else {
                        continue;
                    }
                }

                /*                 * ********************** insert into post sent to table ******************* */

                /*                 * ******************************* get gcm details ************************** */
                $reg_token = $push->getGCMDetails($allempid1, $clientId);
                $token1 = json_decode($reg_token, true);
                
//print_r($token1);die;
                /*                 * ******************************** / get gcm details *********************** */

                /*                 * *******************Create file of user which this post send******************** */
                $name = $rzid;
                $val[] = array();

		$userData = $obj->getUserDetails($clientId, $recognitionto, dirname(SITE_URL).'/');
                if(!empty($userData['UserDetails']['middleName'])){
                	$username = (!empty($userData['UserDetails']['lastName']))?$userData['UserDetails']['firstName'].' '.$userData['UserDetails']['middleName'].' '.$userData['UserDetails']['lastName'] : $userData['UserDetails']['firstName'].' '.$userData['UserDetails']['middleName'];
                }else{
                	$username = (!empty($userData['UserDetails']['lastName']))?$userData['UserDetails']['firstName'].' '.$userData['UserDetails']['lastName'] : $userData['UserDetails']['firstName'];
                }
                
                
                foreach ($token1 as $row) {			
                    array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
                }

                $file = fopen("../../send_push_datafile/" . $name . ".csv", "w");

                foreach ($val as $line) {
                    @fputcsv($file, @explode(',', $line));
                }
                @fclose($file);

                /*                 * *****************Create file of user which this post send End******************** */
		$PUSH_NOTIFICATION = 'PUSH_YES';
                /*                 * **************************** send push **************************************** */
                if ($PUSH_NOTIFICATION == 'PUSH_YES') {

                    $sf = "successfully send";
                    $ids = array();
                    $idsIOS = array();
                    $fullpath = "";
		   
                    foreach ($token1 as $row) {
                    	if($row['userUniqueId'] ==  $recognitionto){
				$content = "Heya, ".$senderUsername." just called you ".$recognizeTitle;
			}else{
				$content = $senderUsername." just sent ".$username. " the " . $recognizeTitle;
			}
			
                    	$data = array('Id' => $rzid, 'Title' => $content, 'Content' => $content, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $post_date, 'flag' => $Flag, 'flagValue' => $flagvalue, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
		    $badgecount = $push->getBadgecount($row['deviceId']);
		    $badgecount = $badgecount['badgeCount']+1;
		    $addBadgecount = $push->updateBadgecount($row['deviceId'], $badgecount);
		    
                        if ($row['deviceName'] == "3") {
                            $data['device_token'] = $row['registrationToken'];
                    	    $IOSrevert = $push->sendAPNSPushCron($data, $googleapiIOSPem['iosPemfile'], 'device', $badgecount);        
                        } else {
                            $data['device_token'] = $row['registrationToken'];
                            $data['badge'] = $badgecount;
	                    $revert = $push->sendGoogleCloudMessageCron($data, $googleapiIOSPem['googleApiKey']);
			}
                    }
                } 
            }
        }
    } else {
        $response['success'] = 0;
        $response['message'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
