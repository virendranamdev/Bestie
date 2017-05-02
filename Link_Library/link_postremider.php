<?php
@session_start();
require_once('../Class_Library/class_reading.php');
//require_once('../Class_Library/class_post.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_notification.php');
require_once('../Class_Library/class_welcomeTable.php');

//$obj = new Post();
$notiobj = new notification();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
$read = new Reading();
$welcomeobj = new WelcomePage();
date_default_timezone_set('Asia/Calcutta');
$post_date = date('Y-m-d H:i:s A');
$maxid = $notiobj->maxID(); 
$reminderid = $notiobj->remindermaxId(); 

$folder = "../images/reminder/";
$target = "images/reminder/";


if (!isset($_GET['remindersubmit'])) {
    $status = 1 ;
    $POST_ID = $maxid;
	$Uuid = $_REQUEST['useruniqueid'];
    $Client_Id = $_REQUEST['clientid'];
	$BY = $_SESSION['user_name'];
    $POST_TITLE = trim($_POST['remindertitle']);
    $POST_IMG = "";
	$thumb_img = "";
    $POST_TEASER = "";
    $DATE = $post_date;
    $FLAG = $_POST['flag'];
	$Flagname = $_POST['flagvalue'];
	$User_Type = $_REQUEST['optradio'];
	$POST_CONTENT = "";
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

/******************** save image ****************************************/
$reminderimage = $_FILES['remiderimage']['name'];
$rimg = str_replace(" ", "", $_FILES['remiderimage']['name']);
$rimgtemp = $_FILES['remiderimage']['tmp_name'];
$image_name = "reminder-".$reminderid . "-" . $rimg;

	$imagepath = $folder . $image_name;
	$dbimage = $target . $image_name;
    $url = $notiobj->compress_image($rimgtemp, $imagepath, 30);
    $fullpath = SITE_URL . $target . $image_name;
	
/********************** / save image ************************************/

/********************* insert into tbl c post details *****************************/
$teaser = "";
$device = 1;
  $result = $notiobj->create_Reminder($Client_Id, $POST_TITLE, $dbimage, $Uuid, $DATE, $FLAG, $status);
  
  $lastreminderid = $result;
  
  $resultnoti = $notiobj->create_notification($Client_Id,$lastreminderid, $POST_TITLE,$POST_CONTENT, $dbimage, $DATE, $Uuid, $FLAG, $status);
  
  $notiid = $resultnoti;
/********************* insert into tbl c post details ******************************/

/**************************** post sent to group *****************************/
    $groupcount = count($myArray);
    for ($k = 0; $k < $groupcount; $k++) {
	//echo "group id".$myArray[$k];
        $result1 = $read->postSentToGroup($Client_Id, $lastreminderid, $myArray[$k], $FLAG);
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
		/*echo "user unique id";
              echo "<pre>";
              print_r($allempid1);
              echo "<pre>";*/
/****************** / fetch all user employee id from user detail start ***********************/
 
/*************************** insert into post sent to table ********************/

    $total = count($allempid1);
    for ($i = 0; $i < $total; $i++) {
        $uuid = $allempid1[$i];
		//echo "post sent to empid:--".$uuid."<br/>";
        if (!empty($uuid)) {
            $read->postSentTo($Client_Id, $lastreminderid, $uuid, $FLAG);
        }
    }
/*************************** / insert into post sent to table ********************/

/************************ insert into welcome table *********************************/
$type = 'Reminder';
    	$result1 = $welcomeobj->createWelcomeData($Client_Id, $lastreminderid, $type, $POST_TITLE, $dbimage, $DATE, $Uuid, $FLAG);   
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
	$filename = "Reminder-".$lastreminderid;
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

        $data = array('Id' => $lastreminderid, 'Title' => $POST_TITLE, 'Content' => $POST_TITLE, 'SendBy' => $BY, 'Picture' => $hrimg, 'Image' => $fullpath, 'Date' => $post_date, 'flag' => $FLAG, 'flagValue' => $Flagname, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
		
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
} else {
    ?>

  <!-- <form name="form1" method="post" action="" enctype="multipart/form-data">
        
        <input type="hidden" name="flagvalue" value="Message :">
        
        <input type="hidden" name = "flag" value="2">
                <input type="hidden" name = "flagvalue" value="Message :">
			<input type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
            <input type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
        
		<p>title:
            <label for="textfield"></label>
            <input type="text" name="title" id="messageTitle" class="form-control" placeholder="Enter Title" required />

        </p>
        
        <p>Post content:
            <label for="textfield"></label>
            <textarea rows="5" type="text" class="form-control" id="inputSuccess2" required placeholder="Enter Message" name="messagecontent"></textarea>

        
            <input type="submit" name="messagesubmit" id="button" value="Submit">
        </p>
    </form>
-->
    <?php
}
?>
