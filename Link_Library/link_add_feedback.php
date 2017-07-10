<?php
//error_reporting(E_ALL);
 // ini_set('display_errors', 1);

@session_start();
require_once('../Class_Library/class_Feedback.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_welcomeTable.php');
include_once('../Class_Library/class_get_group.php');  // for getting all group

date_default_timezone_set('Asia/Kolkata');
$Post_Date = date('Y-m-d H:i:s');

$obj = new Feedback();
$push = new PushNotification();        
$read = new Reading();
$welcome_obj = new WelcomePage();
$customGroup = new Group();                  //class_get_group.php

if(isset($_REQUEST['updateFeedback'])) {
	//echo "inside update";
	$feedbackid = $_REQUEST['feedbackid'];
	$clientid = $_REQUEST['clientid'];
	$updatedby = $_REQUEST['useruniqueid'];
	$UFeedback_Topic = $_REQUEST['feedbackTopic'];
	$UFeedback_Question = $_REQUEST['feedbackQuestion'];
	$UPublishing_Date =  date_format(date_create($_REQUEST['publishingDate']),"Y-m-d H:i:s");
	$UUnpublishing_Date = ($_REQUEST['endDateCheck'] == 'on')?date_format(date_create($_REQUEST['unpublishingDate']),"Y-m-d H:i:s"):"0000-00-00 00:00:00";
	
	$updatefeedbackresult = $obj->update_Feedback($feedbackid , $clientid, $UFeedback_Topic, $UFeedback_Question, $UPublishing_Date, $UUnpublishing_Date, $updatedby, $Post_Date );
	$uresult = json_decode($updatefeedbackresult , true);
	//print_r($uresult);
	if($uresult['success']== 1)
	{
		echo "<script>alert('Feedback Wall Updated Successfully');</script>";
        echo "<script>window.location='../wall.php'</script>";
	}
	else
	{
		echo "<script>alert('Feedback Wall Not Updated');</script>";
        echo "<script>window.location='../wall.php'</script>";
	}
} else {
$maxid = $obj->maxId();
$Feedback_Id = $maxid;
$Feedback_Topic = $_REQUEST['feedbackTopic'];
$Feedback_Question = $_REQUEST['feedbackQuestion'];
$Publishing_Date =  date_format(date_create($_REQUEST['publishingDate']),"Y-m-d H:i:s");
$Unpublishing_Date = (isset($_REQUEST['endDateCheck']) && $_REQUEST['endDateCheck'] == 'on')?date_format(date_create($_REQUEST['unpublishingDate']),"Y-m-d H:i:s"):"0000-00-00 00:00:00";
$User_Type = $_REQUEST['optradio'];
$Uuid = $_REQUEST['useruniqueid'];
$Client_Id = $_REQUEST['clientid'];
$Status = "Live";
$Flag = $_REQUEST['flag'];
$flagvalue = $_REQUEST['flagvalue'];
$groupselection = ""; 
$BY = $_SESSION['user_name'];
$pretempcheck = (empty($_REQUEST['pretempcheck'])?"":$_REQUEST['pretempcheck']);
/*****************************************************************************/

	$LIKE = "LIKE_YES";
	$like = (empty($LIKE)?"":$LIKE);
	if ($like =="") {
            $like = 'LIKE_NO';
            $like_val = 'like_no';
        } else {
            $like_val = 'like_yes';
	    $like = 'LIKE_YES';
        }

    $COMMENT = "COMMENT_YES";
    $comment = (empty($COMMENT)?"":$COMMENT);
		if ($comment=="") 
		{
            $comment = 'COMMENT_NO';
            $comment_val = 'comment_no';
        } else 
		{
            $comment_val = 'comment_yes';
			$comment = 'COMMENT_YES';
        }

	$PUSH = "PUSH_YES";
    $push_noti = (empty($PUSH)?"":$PUSH);
		if ($push_noti=="") 
		{
            $PUSH_NOTIFICATION = 'PUSH_NO';
        } else 
		{
            $PUSH_NOTIFICATION = 'PUSH_YES';
        }
		
/*****************************************************************************/

if (!empty($_POST)) 
{
	if ($User_Type == 'Selected') 
	{
		$user1 = $_POST['selected_user'];
		$user2 = rtrim($user1, ',');
		$myArray = explode(',', $user2);
		/*echo "selected user"."<br/>";
		echo "<pre>";
	    print_r($myArray)."<br/>";
    	echo "</pre>"; */
	}
	else 
	{
		//echo "all user"."<br/>";
		$User_Type = "Selected";
		//  echo "user type:-".$User_Type;
		$user1 = $_POST['all_user'];
		$user2 = rtrim($user1, ',');
		$myArray = explode(',', $user2);
		/*echo "<pre>";
		print_r($myArray)."<br/>";
		echo "</pre>";*/
	}
	
/******************************* get image ******************************/
$userimage = $push->getImage($Uuid);
$image = $userimage[0]['userImage'];
/******************************* / get image ****************************/
	
/************************ get keypem ************************************/
$googleapiIOSPem = $push->getKeysPem($Client_Id);
//print_r($googleapiIOSPem);
/************************ get keypem ************************************/

/************************* predefine temp *******************************/
if($pretempcheck != "")
{
$pretempresult = $obj->create_PredefinedTemplate($Client_Id, $Feedback_Question , $Uuid, $Post_Date);	
}
/************************** / predefine temp ****************************/
	
/************************** add feedback *****************************/
$feedbackresult = $obj->create_Feedback($Feedback_Id , $Client_Id, $Feedback_Topic, $Feedback_Question , $groupselection , $Uuid, $Status, $Publishing_Date, $Unpublishing_Date,$Post_Date, $Flag);
/************************** / add feedback ***************************/

$updatefeedback = $obj->status_FeedbackWall($Feedback_Id, $Status);



/************************** add welcome *****************************/
    $type = "Feedback";
    $img = "";
    //$result1 = $welcome_obj->createWelcomeData($Client_Id, $Feedback_Id, $type, $Feedback_Question, $img, $Post_Date, $Uuid, $Flag);
/************************** / add welcome ***************************/

/******************************* add post sent to group *********************************/

$groupcount = count($myArray);
 $general_group = array();
    $custom_group = array();
        for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
            $result1 = $read->postSentToGroup($Client_Id, $Feedback_Id, $myArray[$k], $Flag);
//echo $result1;
            /***********************  custom group *********************/
         $groupdetails = $read->getGroupDetails($Client_Id, $myArray[$k]);  //get all groupdetails

        if ($groupdetails['groupType'] == 2) {
            array_push($custom_group, $myArray[$k]);
        } else {
            array_push($general_group, $myArray[$k]);
        }
        }
/***************************** / add post sent to group *********************************/
 /******************  fetch all user employee id from user detail start **************************** */
if (count($general_group) > 0) {
       
        $gcm_value = $push->get_Employee_details($User_Type, $general_group, $Client_Id);
    
        $generaluserid = json_decode($gcm_value, true);

    }
    else{   
               $generaluserid = array();
    }
    if (count($custom_group) > 0) {
        $gcm_value1 = $customGroup->getCustomGroupUser($Client_Id, $custom_group);
        $customuserid = json_decode($gcm_value1, true);

    }
     else{
              $customuserid = array();
    }
    /*************get group admin uuid  form group admin table if user type not= all ************** */
//    print_r($customuserid);
//    echo "<br>";
//    print_r($generaluserid);
	
/**************************** group admin id *******************************/		
		if ($User_Type != 'All') {
        //    $groupadminuuid = $push->getGroupAdminUUId($myArray, $Client_Id);
          //  $adminuuid = json_decode($groupadminuuid, true);
              /*echo "hello groupm admin id";
              echo "<pre>";
              print_r($adminuuid)."<br/>";
              echo "</pre>";
              echo "--------------all employee id---------";*/

            $allempid = array_merge($generaluserid, $customuserid);
             /*echo "<pre>";
              print_r($allempid);
              echo "<pre>";

              echo "--------------all unique employee id---------";*/ 

            $allempid1 = array_values(array_unique($allempid));
              /*echo "user unique id";
              echo "<pre>";
              print_r($allempid1);
              echo "<pre>";*/ 
        } else {
//echo "within all user type".$User_Type."<br/>";
            $allempid1 = $generaluserid;
        }
/**************************** / group admin id *******************************/	

/************************ insert into post sent to table ********************/

        $total = count($allempid1);
        for ($i = 0; $i < $total; $i++) {
            $uuid = $allempid1[$i];
//echo "count no.:-".$i."->".$uuid."<br/>";
            if (!empty($uuid)) {
		$read->postSentTo($Client_Id, $Feedback_Id, $uuid, $Flag);
            } else {
                continue;
            }
        }

/************************ insert into post sent to table ********************/

/********************************* get gcm details ***************************/
$reg_token = $push->getGCMDetails($allempid1, $Client_Id);
        $token1 = json_decode($reg_token, true);
        /*echo "----regtoken------";
          echo "<pre>";
          print_r($token1);
          echo "<pre>";*/
/********************************** / get gcm details ************************/

/*********************Create file of user which this post send******************** */
        $val[] = array();
        foreach ($token1 as $row) {
            array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
        }

        $file = fopen("../send_push_datafile/" . $Feedback_Id . ".csv", "w");

        foreach ($val as $line) {
            @fputcsv($file, @explode(',', $line));
        }
        @fclose($file);

/*******************Create file of user which this post send End******************** */

/****************************** send push *****************************************/

	if ($PUSH_NOTIFICATION == 'PUSH_YES') {
	    $hrimg = ($image == "")?"":SITE_URL . $image;
            $sf = "successfully send";
            $ids = array();
            $idsIOS = array();
	    $fullpath = "";


	    foreach ($token1 as $row) {
		$content = $Feedback_Question;
		
            	$data = array('Id' => $Feedback_Id, 'Title' => $content, 'Content' => $content, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $Post_Date, 'flag' => $Flag, 'flagValue' => $flagvalue, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
	    
	    $badgecount = $push->getBadgecount($row['deviceId']);
	    $badgecount = $badgecount['badgeCount']+1;
	    $addBadgecount = $push->updateBadgecount($row['deviceId'], $badgecount);
	    
                if ($row['deviceName'] == "3") {
                    $data['device_token'] = $row['registrationToken'];
            	    $IOSrevert = $push->sendAPNSPushCron($data, $googleapiIOSPem['iosPemfile'], '', $badgecount);        
                } else {
                    $data['device_token'] = $row['registrationToken'];
                    $data['badge'] = $badgecount;
                    $revert = $push->sendGoogleCloudMessageCron($data, $googleapiIOSPem['googleApiKey']);
		}
            }
          
            if ($revert['success'] == 1) {    
                echo "<script>alert('Feedback Wall Posted Successfully');</script>";
                echo "<script>window.location='../create-wall.php'</script>";
            }
    }
else
{
	echo "<script>alert('Feedback Wall Posted Successfully');</script>";
    echo "<script>window.location='../create-wall.php'</script>";
}
        

/***************************** / send push ****************************************/

}
}

?>
