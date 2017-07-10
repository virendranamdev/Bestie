<?php
session_start();
include_once('../Class_Library/class_upload_album.php');
require_once('../Class_Library/class_push_notification.php');
//include_once('../Class_Library/class_get_group.php');  // for getting all group
require_once('../Class_Library/class_welcomeTable.php');

$uploader = new Album();
//$obj_group = new Group();                  //class_get_group.php
$push = new PushNotification();            // class_push_notification.php
$welcome_obj = new WelcomePage();

$maxbundleid = $uploader->maxbundleId();
$bundleid = $maxbundleid + 1;

$target_dir = "../upload_album/";
$target_db = "upload_album/";
	
if (!empty($_POST)) {
    
	date_default_timezone_set('Asia/Kolkata');
	$Post_Date = date('Y-m-d H:i:s');
	
	$albumid = $_REQUEST['albumId']; 
	$User_Type = $_REQUEST['optradio'];
	
	$Uuid = $_REQUEST['useruniqueid'];
	$Client_Id = $_REQUEST['clientid'];
	$Status = 1;
	$Flag = $_REQUEST['flag'];
	$BY = $_SESSION['user_name'];
	$albumcategory = $_REQUEST['albumcategory'];
	$albumtitle = $_REQUEST['albumtitle'];
	$albumdescription = "";
	
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


	/********************************* get group ****************/
		/*$User_Type = 'Selected';
		$result = $uploader->getAlbumGroup($Client_Id, $albumid);
		$value = json_decode($result, true);
		
		$getcat = $value['posts'];

		$myArray = array();
		foreach ($getcat as $groupid) {
			array_push($myArray, $groupid['groupId']);
		}
		
		//print_r($myArray);*/
		
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
	/********************************* get group ****************/	

	
/******************************* get image ******************************/
$userimage = $push->getImage($Uuid);
$image = $userimage[0]['userImage'];
//echo $image;
/******************************* / get image ****************************/
	
/************************ get keypem ************************************/
$googleapiIOSPem = $push->getKeysPem($Client_Id);
//print_r($googleapiIOSPem);
/************************ get keypem ************************************/ 

	/************************************** save image ****************/
	
	//$timg = str_replace(" ", "", $_FILES['album']['name']);
	
	$k = $_FILES['album']['name'];
	//print_r($k);
    $k1 = $_FILES['album'];
    $countfiles = count($k);	
	$error = $_FILES['album']['error'];
	//print_r($error);
		
	if($error[0] == 0)
	{
    for ($i = 0; $i < $countfiles; $i++) {
        $albumThumbImg = $albumid . "-" . basename($_FILES["album"]["name"][$i]);
        $target_file1 = $target_db . $albumid . "-" . basename(str_replace(" ", "", $_FILES["album"]["name"][$i]));
        $target_file = $target_dir . $albumid . "-" . basename(str_replace(" ", "", $_FILES["album"]["name"][$i]));
        $caption = "";
        $imageCaption = $_POST['imageCaption'][$i];
        $temppath = $_FILES["album"]["tmp_name"][$i];
        $res = $uploader->compress_image($temppath, $target_file, 20);
        //$thumb_image = $push->makeThumbnails($target_dir, $albumThumbImg, 20);
        //$thumb_img = str_replace('../', '', $thumb_image);
	$thumb_img = '';
	$skip = 1;
        $imgupload = $uploader->saveImage($albumid, $target_file1, $albumtitle, $thumb_img, $imageCaption,$Uuid,$Post_Date , $Status , $bundleid , $Post_Date, $skip);
    }
	}
	
	
	/******************************** / save image **********************/
		     
    /************************** /album sent to group  **************************************/

	/************************** add album in welcome table *******************/
	$type = 'Album';
    $img = "";
    $result1 = $welcome_obj->createWelcomeData($Client_Id, $bundleid, $type, $albumtitle, $img, $Post_Date, $Uuid, $Flag);
	/************************* / add album in welcome table ******************/
	
	/********************************* album sent to group ****************/
	 $groupcount = count($myArray);
     for ($k = 0; $k < $groupcount; $k++) 
	 {
        $albumsenttogroupres = $uploader->albumSentToGroup($Client_Id, $albumid, $bundleid, $myArray[$k]);
       // echo $result1;
     }
    /************************** /album sent to group  **************************************/
	
    /****************  fetch all user employee id **********************/
        $emloyeeid = $push->get_Employee_details($User_Type, $myArray, $Client_Id);
		$token = json_decode($emloyeeid, true);
          /*echo "<pre>";
          print_r($token);
          echo "</pre>";*/
		  
	/****************  fetch all user employee id ********************* */
	
	if($User_Type != 'All')
		{
		$groupadminuuid = $push->getGroupAdminUUId($myArray,$Client_Id);
		$adminuuid = json_decode($groupadminuuid, true);
		/*echo "user unique id";
		echo "<pre>";
		print_r($adminuuid);
		echo "</pre>";*/
		
		/******************************all employee id **********************************/
  
		 $allempid = array_merge($token, $adminuuid);
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
		echo "</pre>";*/	
		}
		/*echo "<pre>";
		print_r($allempid1);
		echo "</pre>";*/
		
	
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

    $file = fopen("../send_push_datafile/" . $albumid . '_bundle_'.$bundleid. ".csv", "w");

    foreach ($val as $line) {
        @fputcsv($file, @explode(',', $line));
    }
    @fclose($file);

    /****************** Create file of user which this post send End ***************** */


    /*********************check push notificaticon enabale or disable******************** */
    if ($PUSH_NOTIFICATION == 'PUSH_YES') {

        /******************** send push by  push notification******************** */

        $hrimg =($target_file1 == "")?"":SITE_URL . $target_file1;
		$imgadmin = ($image == "")?"":SITE_URL . $image;
        $sf = "successfully send";
        $ids = array();
        $idsIOS = array();

        foreach ($token1 as $row) {
		$content = $albumtitle;
		
		$content = 'Bestie Just Added In '.$albumtitle;
		
		$flag_name = "Album : ";
		
            	$data = array('Id' => $albumid, 'Title' => $content, 'Content' => $content, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $imgadmin, 'Date' => $Post_Date, 'flag' => $Flag, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
				
				//echo "<pre>";
				//print_r($data);
				
		$badgecount = $push->getBadgecount($row['deviceId']);
		//print_r($badgecount);
		
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
	/*echo "<pre>";
		print_r($revert);
		print_r($IOSrevert);*/
        if ($revert["success"] == 1) {
            echo "<script>alert('Album Image posted Successfully');</script>";
           echo "<script>window.location='../album-detail.php?albumId=".$albumid."'</script>";
        }
		else {
            echo "<script>alert('Album Image posted Successfully');</script>";
           echo "<script>window.location='../album-detail.php?albumId=".$albumid."'</script>";
        }
    } else {
        echo "<script>alert('Album Image posted Successfully');</script>";
        echo "<script>window.location='../album-detail.php?albumId=".$albumid."'</script>";
    }
} 
?>
