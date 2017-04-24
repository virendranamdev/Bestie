<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_Feedback.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_welcomeTable.php');

date_default_timezone_set('Asia/Calcutta');
$Post_Date = date('Y-m-d H:i:s A');

$obj = new Feedback();
$push = new PushNotification();        
$read = new Reading();
$welcome_obj = new WelcomePage();

if(isset($_REQUEST['updateFeedback']))
{
	//echo "inside update";
	$feedbackid = $_REQUEST['feedbackid'];
	$clientid = $_REQUEST['clientid'];
	$updatedby = $_REQUEST['useruniqueid'];
	$UFeedback_Question = $_REQUEST['feedbackQuestion'];
	$UPublishing_Date =  date_format(date_create($_REQUEST['publishingDate']),"Y-m-d H:i:s");
	$UUnpublishing_Date = date_format(date_create($_REQUEST['unpublishingDate']),"Y-m-d H:i:s");
	
	$updatefeedbackresult = $obj->update_Feedback($feedbackid , $clientid, $UFeedback_Question, $UPublishing_Date, $UUnpublishing_Date, $updatedby, $Post_Date );
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
}
else
{
$maxid = $obj->maxId();
$Feedback_Id = $maxid;
$Feedback_Question = $_REQUEST['feedbackQuestion'];
$Publishing_Date =  date_format(date_create($_REQUEST['publishingDate']),"Y-m-d H:i:s");
$Unpublishing_Date = date_format(date_create($_REQUEST['unpublishingDate']),"Y-m-d H:i:s");
$User_Type = $_REQUEST['optradio'];
$Uuid = $_REQUEST['useruniqueid'];
$Client_Id = $_REQUEST['clientid'];
$Status = "Live";
$Flag = $_REQUEST['flag'];
$flagvalue = $_REQUEST['flagvalue'];
$groupselection = ""; 
$BY = $_SESSION['user_name'];
//echo $pretempcheck = $_REQUEST['pretempcheck'];
$pretempcheck = (empty($_REQUEST['pretempcheck'])?"":$_REQUEST['pretempcheck']);
/*****************************************************************************/

	$LIKE = "LIKE_YES";
	$like = (empty($LIKE)?"":$LIKE);
		if ($like =="") 
		{
            $like = 'LIKE_NO';
            $like_val = 'like_no';
        } else 
		{
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
$feedbackresult = $obj->create_Feedback($Feedback_Id , $Client_Id, $Feedback_Question , $groupselection , $Uuid, $Status, $Publishing_Date, $Unpublishing_Date,$Post_Date, $Flag);
/************************** / add feedback ***************************/

/************************** add welcome *****************************/
	$type = "Feedback";
    $img = "";
    $result1 = $welcome_obj->createWelcomeData($Client_Id, $Feedback_Id, $type, $Feedback_Question, $img, $Post_Date, $Uuid, $Flag);
/************************** / add welcome ***************************/

/******************************* add post sent to group *********************************/

$groupcount = count($myArray);
        for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
            $result1 = $read->postSentToGroup($Client_Id, $Feedback_Id, $myArray[$k], $Flag);
//echo $result1;
        }
/***************************** / add post sent to group *********************************/

/****************  fetch all user employee id ********************* */
        $gcm_value = $push->get_Employee_details($User_Type, $myArray, $Client_Id);
        $token = json_decode($gcm_value, true);
        /*echo "hello user  id";
          echo "<pre>";
          print_r($token);
          echo "</pre>";*/
/****************  / fetch all user employee id **********************/
	  
/**************************** group admin id *******************************/		
		if ($User_Type != 'All') {
            $groupadminuuid = $push->getGroupAdminUUId($myArray, $Client_Id);
            $adminuuid = json_decode($groupadminuuid, true);
              /*echo "hello groupm admin id";
              echo "<pre>";
              print_r($adminuuid)."<br/>";
              echo "</pre>";
              echo "--------------all employee id---------";*/

            $allempid = array_merge($token, $adminuuid);
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
            $allempid1 = $token;
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

if ($PUSH_NOTIFICATION == 'PUSH_YES') 
	{

			$hrimg = ($image == "")?"":SITE_URL . $image;
            $sf = "successfully send";
            $ids = array();
            $idsIOS = array();
			$fullpath = "";
			
            foreach ($token1 as $row) {

                if ($row['deviceName'] == 3) {
                    array_push($idsIOS, $row["registrationToken"]);
                } else {
                    array_push($ids, $row["registrationToken"]);
                }
            }
           
            $data = array('Id' => $Feedback_Id, 'Title' => $Feedback_Question, 'Content' => $Feedback_Question, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $Post_Date, 'flag' => $Flag, 'flagValue' => $flagvalue, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
			
			
           $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
		   
		   //print_r($IOSrevert);
		   
            $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);

            $rt = json_decode($revert, true);
            $iosrt = json_decode($IOSrevert, true);
/*echo "<pre>";
print_r($data);
print_r($rt);
print_r($iosrt);
echo "</pre>";*/
            if ($rt['success'] == 1) 
			{    
                echo "<script>alert('Feedback Wall Posted Successfully');</script>";
                echo "<script>window.location='../create-wall.php'</script>";
            }
			else
			{
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
