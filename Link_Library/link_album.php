<?php
error_reporting(E_ALL);
  ini_set('display_errors', 1);
session_start();
include_once('../Class_Library/class_upload_album.php');
require_once('../Class_Library/class_push_notification.php');
include_once('../Class_Library/class_get_group.php');  // for getting all group
require_once('../Class_Library/class_welcomeTable.php');
require_once('../Class_Library/class_reading.php');

$uploader = new Album();
$obj_group = new Group();                  //class_get_group.php
$push = new PushNotification();            // class_push_notification.php
$welcome_obj = new WelcomePage();
$read = new Reading();
  
$maxbundleid = $uploader->maxbundleId();
$bundleid = $maxbundleid + 1;
  
$target_dir = "../upload_album/";
$target_db = "upload_album/";
	
if (!empty($_POST)) {
    
	date_default_timezone_set('Asia/Kolkata');
	$Post_Date = date('Y-m-d H:i:s');
	
    	$albumid = $uploader->maxId();
	$User_Type = $_REQUEST['optradio'];
	$Uuid = $_REQUEST['useruniqueid'];
	$Client_Id = $_REQUEST['clientid'];
	$Status = 1;
	$Flag = $_REQUEST['flag'];
	$BY = $_SESSION['user_name'];
	$albumcategory = $_REQUEST['albumcategory'];
	$albumtitle = $_REQUEST['albumtitle'];
	$albumdescription = $_REQUEST['albumdescription'];
	
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
		
	/******************************* group ***********************************/

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
	
/******************************* / group ******************************/

/******************************* get image ******************************/
$userimage = $push->getImage($Uuid);
$image = $userimage[0]['userImage'];

/******************************* / get image ****************************/
	
/************************ get keypem ************************************/
$googleapiIOSPem = $push->getKeysPem($Client_Id);
//print_r($googleapiIOSPem);
/************************ get keypem ************************************/ 
 
 /**************************** add album ************************************/
  $insertdata = $uploader->createAlbum($Client_Id , $albumid , $albumcategory , $albumtitle, $albumdescription ,$Uuid, $Post_Date);
/**************************** / add album ***********************************/

	/************************************** save image ****************/
	$k = $_FILES['album']['name'];
    $k1 = $_FILES['album'];
    $countfiles = count($k);	
	$error = $_FILES['album']['error'];
		
	if($error[0] == 0)
	{
    for ($i = 0; $i < $countfiles; $i++) {
        $albumThumbImg = $albumid . "-" . basename($_FILES["album"]["name"][$i]);
        $target_file1 = $target_db . $albumid . "-" . basename($_FILES["album"]["name"][$i]);
        $target_file = $target_dir . $albumid . "-" . basename($_FILES["album"]["name"][$i]);
        $caption = "";
        $imageCaption = $_POST['imageCaption'][$i];
        $temppath = $_FILES["album"]["tmp_name"][$i];
        $res = $uploader->compress_image($temppath, $target_file, 20);
        //$thumb_image = $push->makeThumbnails($target_dir, $albumThumbImg, 20);
        //$thumb_img = str_replace('../', '', $thumb_image);
	$thumb_img = '';
	$skip = 1;
        $imgupload = $uploader->saveImage($albumid, $target_file1, $albumtitle, $thumb_img, $imageCaption,$Uuid,$Post_Date, $Status , $bundleid , $Post_Date, $skip);
    }
	}
	/******************************** / save image **********************/
	/************************** add album in welcome table *******************/
	$type = 'Album';
    $img = "";
    $result1 = $welcome_obj->createWelcomeData($Client_Id, $bundleid, $type, $albumtitle, $img, $Post_Date, $Uuid, $Flag);
	/************************* / add album in welcome table ******************/
	
	/********************************* album sent to group ****************/
	 $groupcount = count($myArray);
         $general_group = array();
         $custom_group = array();
       for ($k = 0; $k < $groupcount; $k++) 
	 {
        $albumsenttogroupres = $uploader->albumSentToGroup($Client_Id, $albumid, $bundleid, $myArray[$k]);
       /***********************  custom group *********************/
        $groupdetails = $read->getGroupDetails($Client_Id, $myArray[$k]);  //get all groupdetails

        if ($groupdetails['groupType'] == 2) {
            array_push($custom_group, $myArray[$k]);
        } else {
            array_push($general_group, $myArray[$k]);
        }
     }
    /************************** /album sent to group  **************************************/
	
    /******************  fetch all user employee id from user detail start **************************** */
if (count($general_group) > 0) {
       
        $gcm_value = $push->get_Employee_details($User_Type, $general_group, $Client_Id);
    
        $generaluserid = json_decode($gcm_value, true);
       
    }
    else{   
               $generaluserid = array();
    }
    if (count($custom_group) > 0) {
  
        $gcm_value1 = $obj_group->getCustomGroupUser($Client_Id, $custom_group);
     
        $customuserid = json_decode($gcm_value1, true);
     
    }
     else{
              $customuserid = array();
    }
    /*************get group admin uuid  form group admin table if user type not= all ************** */
		  
	/******* get group admin uuid form group admin table if user type not equal all***********/
        
		if($User_Type != 'All')
		{
		//$groupadminuuid = $push->getGroupAdminUUId($myArray,$Client_Id);
		//$adminuuid = json_decode($groupadminuuid, true);
		/*echo "user unique id";
		echo "<pre>";
		print_r($adminuuid);
		echo "</pre>";*/
		
		/******************************all employee id **********************************/
  
		 $allempid = array_merge($generaluserid, $customuserid);
	   /*echo "array merge";
		echo "<pre>";
		print_r($allempid);
		echo "</pre>";*/
		/******************* all unique employee id *********************/
		$allempid1 = array_values(array_unique($allempid));
		/*echo "all unique employee id";
		echo "<pre>";
		print_r($allempid1);
		echo "</pre>";*/
		}
		else
		{
		$allempid1 = $token;
		/*echo "all user unique id";
		echo "<pre>";
		print_r($allempid1);
		echo "</pre>";	*/
		}
		/*echo "<pre>";
		print_r($allempid1);
		echo "</pre>";*/
		
		
	/******* end get group admin uuid form group admin table if user type not equal all ******/
	
	/************************** get gcm details ****************/
	$reg_token = $push->getGCMDetails($allempid1, $Client_Id);
    $token1 = json_decode($reg_token, true);
      /*echo "<pre>";
      echo "all employee id reg token";
      print_r($token1);
      echo "</pre>";*/
	/************************** / get gcm details *********************/
    
    /****************** Create file of user which this post send  start ************** */
    $val[] = array();
    foreach ($token1 as $row) {
        array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
    }

    $file = fopen("../send_push_datafile/" . $albumid . ".csv", "w");

    foreach ($val as $line) {
        @fputcsv($file, @explode(',', $line));
    }
    @fclose($file);

    /****************** Create file of user which this post send End ***************** */


    /*********************check push notificaticon enabale or disable******************** */
    if ($PUSH_NOTIFICATION == 'PUSH_YES') {

        /******************** send push by  push notification******************** */

        $hrimg =($target_file1 == "")?"":SITE_URL . $target_file1;
        $sf = "successfully send";
        $ids = array();
        $idsIOS = array();

        foreach ($token1 as $row) {
		$content = $albumtitle;
		$flag_name = "Album : ";
		
            	$data = array('Id' => $albumid, 'Title' => $albumtitle, 'Content' => $albumtitle, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $image, 'Date' => $Post_Date, 'flag' => $Flag, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
	    
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
		
        if ($revert["success"] == 1) {
            echo "<script>alert('Album posted Successfully');</script>";
            echo "<script>window.location='../create-album.php'</script>";
        }
    } else {
        echo "<script>alert('Album posted Successfully');</script>";
        echo "<script>window.location='../create-album.php'</script>";
    }
} else {
    ?>
    <form action="link_album.php" method="post" enctype="multipart/form-data">
        clientid:<input type="text" name="clientid"><br>
		category:<input type="text" name="albumcategory"><br>
        title :  <input type="text" name="albumtitle"><br>
        upload multiple image :   <input type="file" name="album[]" id="filer_input2" multiple><br>
        description : <textarea name="albumdescription"></textarea><br>
        <input type="submit" value="Submit">
    </form>
    <?php
}
?>
