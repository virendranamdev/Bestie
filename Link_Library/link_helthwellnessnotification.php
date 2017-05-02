<?php
@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_notification.php');
require_once('../Class_Library/class_welcomeTable.php');
require_once('../Class_Library/class_Health_Wellness.php');

$notiobj = new notification();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
$read = new Reading();
$welcomeobj = new WelcomePage();
$healthobj = new HealthWellness();
date_default_timezone_set('Asia/Calcutta');
$post_date = date('Y-m-d H:i:s A');
$maxid = $notiobj->maxID(); 

if (!isset($_GET['helthformsubmit'])) {
    $status = 1 ;
    $POST_ID = $maxid;
	$Uuid = $_REQUEST['useruniqueid'];
    $Client_Id = $_REQUEST['clientid'];
	$BY = $_SESSION['user_name'];
    $exerciseid = trim($_POST['exerciseid']);
    $POST_IMG = "";
    $POST_CONTENT = trim($_POST['exercisecontent']);
    $DATE = $post_date;
    $FLAG = $_POST['flag'];
	$Flagname = $_POST['flagvalue'];
	$User_Type = $_REQUEST['optradio'];
	$POST_TITLE = "";
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
		//echo $like;
		//echo $comment;
		//echo $PUSH_NOTIFICATION;
		
/*****************************************************************************/

/************************ user group ***********************************************/
	if ($User_Type == 'Selected') 
	{
		$user1 = $_POST['selected_user'];
		$user2 = rtrim($user1, ',');
		$myArray = explode(',', $user2);
		/*echo "selected user"."<br/>";
		echo "<pre>";
	    print_r($myArray)."<br/>";
    	echo "</pre>";*/
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

/************************* get exercise detail **************************/
$exercisedetail = $healthobj->singleExerciseDetails($Client_Id,$exerciseid);
//print_r($exercisedetail);
$exercisearea = $exercisedetail['exercise_area'];
/************************* / get exercise detail ************************/

/********************* insert into tbl c post details *****************************/  
  $resultnoti = $notiobj->create_notification($Client_Id,$exerciseid, $exercisearea,$POST_CONTENT, $POST_IMG, $DATE, $Uuid, $FLAG, $status);
/********************* insert into tbl c post details ******************************/
	
/**************************** post sent to group *****************************/
    $groupcount = count($myArray);
    for ($k = 0; $k < $groupcount; $k++) {
	//echo "group id".$myArray[$k];
        $result1 = $read->postSentToGroup($Client_Id, $POST_ID, $myArray[$k], $FLAG);
//echo $result1;
    }
/******************************* / post sent to group ***********************************/
    
/****************** fetch all user employee id from user detail start *************************/
    $gcm_value = $push->get_Employee_details($User_Type, $myArray, $Client_Id);
    $token = json_decode($gcm_value, true);
    /*echo "hello user  id";
    echo "<pre>";
    print_r($token);
    echo "</pre>";*/

/*********get group admin uuid  form group admin table if user type not= all **************/

		if ($User_Type != 'All') 
		{
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
 
		} else 
		{
			$allempid1 = $token;
			/*echo "user unique id";
              echo "<pre>";
              print_r($allempid1);
              echo "<pre>";*/
		}
		
/****************** / fetch all user employee id from user detail start ***********************/
 
/*************************** insert into post sent to table ********************/

    $total = count($allempid1);
    for ($i = 0; $i < $total; $i++) {
        $uuid = $allempid1[$i];
		//echo "post sent to empid:--".$uuid."<br/>";
        if (!empty($uuid)) {
            $read->postSentTo($Client_Id, $maxid, $uuid, $FLAG);
        }
    }
/*************************** / insert into post sent to table ********************/

/************************ insert into welcome table *********************************/
$type = 'Exercise';
    	$result1 = $welcomeobj->createWelcomeData($Client_Id, $POST_ID, $type, $exercisearea, $POST_IMG, $DATE, $Uuid, $FLAG);   
/**************************** / insert into welcome table ***************************/

/********************* get all registration token for sending push *****************/
    $reg_token = $push->getGCMDetails($allempid1, $Client_Id);
    $token1 = json_decode($reg_token, true);
    /*echo "----regtoken------";
    echo "<pre>";
    print_r($token1);
    echo "<pre>";*/


    /*********************Create file of user which this post send  start******************** */
    $val[] = array();
	$filename = "Exercise-".$maxid;
    foreach ($token1 as $row) {
        array_push($val, $row["userUniqueId"] . "," . $row["registrationToken"]);
    }

    $file = fopen("../send_push_datafile/" . $filename . ".csv", "w");

    foreach ($val as $line) {
        @fputcsv($file, @explode(',', $line));
    }
    @fclose($file);
    /*********************Create file of user which this post send End*********************/
	
    /*********************check push notificaticon enabale or disable******************** */
    if ($PUSH_NOTIFICATION == 'PUSH_YES') 
	{
        $hrimg = ($image == "")?"":SITE_URL . $image;
        $sf = "successfully send";
        $ids = array();
        $idsIOS = array();

        foreach ($token1 as $row) {
            if ($row['deviceName'] == 3) {
                array_push($idsIOS, $row["registrationToken"]);
            } else {
                array_push($ids, $row["registrationToken"]);
            }
            //array_push($ids,$row["registrationToken"]);
        }

        $data = array('Id' => $maxid, 'Title' => $exercisearea, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'Date' => $post_date, 'flag' => $FLAG, 'flagValue' => $Flagname, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
		
		$IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
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
            echo "<script>alert('Post Successfully Send');</script>";
            echo "<script>window.location='../create-reminder.php'</script>";
        } 
		else
		{
            echo "<script>alert('Post Successfully Send');</script>";
            echo "<script>window.location='../create-reminder.php'</script>";
        }
    }
    else 
	{
        echo "<script>alert('Post Successfully Send');</script>";
        echo "<script>window.location='../create-reminder.php'</script>";
    }
} 
?>
