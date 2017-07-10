<?php
@session_start();
include_once('../Class_Library/class_upload_album.php');
require_once('../Class_Library/class_welcomeTable.php');
require_once('../Class_Library/class_push_notification.php');

$objalbum = new Album();
$welcome_obj = new WelcomePage();
$push = new PushNotification();  
date_default_timezone_set('Asia/Kolkata');
$Post_Date = date('Y-m-d H:i:s');
$Uuid = $_SESSION['user_unique_id'];
$clientid = $_SESSION['client_id'];

/********************************* BUNDLE IMAGE APPROVE *****************************************/
if (isset($_POST['pendingapprove'])) {  
	$imageids = $_POST['bundleimgid'];
	$bundleid = $_POST['bundleid'];
	$User_Type = $_POST['optradio'];
	$albumid = $_POST['albumid'];
	$imgstatus = 1;
	$seen = 1;
	$Flag = $_POST['flag'];
	$albumtitle = $_POST['albumtitle'];
	$BY = $_SESSION['user_name'];
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

/***************** get group *******************/
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
	$googleapiIOSPem = $push->getKeysPem($clientid);
	//print_r($googleapiIOSPem);
	/************************ get keypem ************************************/
	
	/************************ image status **********************/
	for($i=0; $i<count($imageids); $i++)
	{
	$imgid = $imageids[$i];
	$imgstatusresult = $objalbum->BundleImagestatus($bundleid,$imgid,$imgstatus);
	}
	$bundleseenresult = $objalbum->BundleImageseen($bundleid,$seen);
    /***************************** /image status *********************/
	
	/********************** get push content *********************/
	$pushimgid = $imageids[0];
	$imgpath = SITE_URL;
	$pushimagecontentres = $objalbum->singleBundleImageDetail($imgid,$bundleid,$imgpath);
	$pushcontentarray = json_decode($pushimagecontentres,true);
	$uploadedby = $pushcontentarray['posts']['createdbyname'];
	$albumimagepath = $pushcontentarray['posts']['imgName'];
	$pushcontent = $uploadedby . ' Added Memories To '.$albumtitle;  
	
	/*************************  get push content ******************/
	
	/********************************* album sent to group ****************/
	$groupcount = count($myArray);
     for ($k = 0; $k < $groupcount; $k++) 
	 {
        $albumsenttogroupres = $objalbum->albumSentToGroup($clientid, $albumid, $bundleid, $myArray[$k]);
       
     }
    /************************** /album sent to group  **************************************/
	
	/************************** add album in welcome table *******************/
	$type = 'Album';
    $img = "";
    $resultwelcome = $welcome_obj->createWelcomeData($clientid, $bundleid, $type, $albumtitle, $img, $Post_Date, $Uuid, $Flag);
	/************************* / add album in welcome table ******************/
	
	/****************  fetch all user employee id **********************/
        $emloyeeid = $push->get_Employee_details($User_Type, $myArray, $clientid);
		$token = json_decode($emloyeeid, true);
         /* echo "<pre>";
          print_r($token);
          echo "</pre>";*/
		  
		  
	/****************  fetch all user employee id ********************* */
	
	if($User_Type != 'All')
		{
		$groupadminuuid = $push->getGroupAdminUUId($myArray,$clientid);
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
	$reg_token = $push->getGCMDetails($allempid1, $clientid);
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

    /****************** Create file of user which this post send End ******************/
	
	/*********************check push notificaticon enabale or disable******************** */
   if ($PUSH_NOTIFICATION == 'PUSH_YES') 
		{
		$hrimg = $albumimagepath;
		$imgadmin = ($image == "")?"":SITE_URL . $image;
        $sf = "successfully send";
        $ids = array();
        $idsIOS = array();

			foreach ($token1 as $row) 
			{
			
			$flag_name = "Album : ";
			
					$data = array('Id' => $albumid, 'Title' => $pushcontent, 'Content' => $pushcontent, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $imgadmin, 'Date' => $Post_Date, 'flag' => $Flag, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
					
			//print_r($data);
			$badgecount = $push->getBadgecount($row['deviceId']);
			//print_r($badgecount);
			
			$badgecount = $badgecount['badgeCount']+1;
			$addBadgecount = $push->updateBadgecount($row['deviceId'], $badgecount);
			
					if ($row['deviceName'] == "3") 
					{
						$data['device_token'] = $row['registrationToken'];
						$IOSrevert = $push->sendAPNSPushCron($data, $googleapiIOSPem['iosPemfile'], '', $badgecount);        
					} 
					else 
					{
						$data['device_token'] = $row['registrationToken'];
						$data['badge'] = $badgecount;
						$revert = $push->sendGoogleCloudMessageCron($data, $googleapiIOSPem['googleApiKey']);
					}
					/*echo "<pre>";
					print_r($IOSrevert);
					print_r($revert);
					echo "<pre>";*/
					
			}
			
			/*if ($revert["success"] == 1) 
			{*/
            echo "<script>alert('Album Image Approved Successfully');</script>";
            echo "<script>window.location='../pendingDataApprove.php?Bundle=".$bundleid."'</script>";
			/*}
			else 
			{
            echo "<script>alert('Album Image Approved Successfully');</script>";
            echo "<script>window.location='../album.php'</script>";
			}*/
			
		}
		/**************************** / push **************************/
		else {
        echo "<script>alert('Album Image Approved Successfully');</script>";
        echo "<script>window.location='../pendingDataApprove.php?Bundle=".$bundleid."'</script>";
    }
	
}

/********************************* / BUNDLE IMAGE APPROVE *****************************************/

/********************************* BUNDLE IMAGE SKIP *****************************************/

if (isset($_POST['pendingskip'])) {  
$bundleid1 = $_POST['bundleid'];
$seen1 = 1;
$bundleseenresult = $objalbum->BundleImageseen($bundleid1,$seen1);
$seenarray = json_decode($bundleseenresult, true);
//print_r($bundleseenresult);
	if($seenarray['success'] == 1)
	{
	echo "<script>alert('Album image skip successfully');</script>";
	echo "<script>window.location='../pendingDataApprove.php?Bundle=".$bundleid1."'</script>";
	}
	else
	{
	echo "<script>alert('Album image not skip');</script>";
	echo "<script>window.location='../pendingDataApprove.php?Bundle=".$bundleid1."'</script>";	
	}
}

/********************************* / BUNDLE IMAGE SKIP *****************************************/

/********************************* BUNDLE IMAGE REJECT *****************************************/

if (isset($_POST['pendingreject'])) {
	
$imageids = $_POST['bundleimgid'];
$bundleid = $_POST['bundleid'];
	
$seen2 = 1;
$imgrejectstatus = 3;
/************************ image status **********************/
	for($i=0; $i<count($imageids); $i++)
	{
	$imgid = $imageids[$i];
	$imgstatusresult = $objalbum->BundleImagestatus($bundleid,$imgid,$imgrejectstatus);
	}
	$bundlerejectseenresult = $objalbum->BundleImageseen($bundleid,$seen2);
    /***************************** /image status *********************/
	$seenrejectarray = json_decode($bundlerejectseenresult, true);
	//print_r($bundleseenresult);
	if($seenrejectarray['success'] == 1)
	{
	echo "<script>alert('Album image rejected successfully');</script>";
	echo "<script>window.location='../pendingDataApprove.php?Bundle=".$bundleid."'</script>";
	}
	else
	{
	echo "<script>alert('Album image not rejected');</script>";
	echo "<script>window.location='../pendingDataApprove.php?Bundle=".$bundleid."'</script>";	
	}
}

/********************************* / BUNDLE IMAGE REJECT *****************************************/

/********************************* BUNDLE IMAGE UNPUBLISH **************************************/

if (isset($_POST['approveunpublish'])) {
	
$imageids = $_POST['bundleimgid'];
$bundleid = $_POST['bundleid'];
	
$seen2 = 1;
$imgunpublishstatus = 0;
/************************ image status **********************/
	for($i=0; $i<count($imageids); $i++)
	{
	$imgid = $imageids[$i];
	$imgstatusresult = $objalbum->BundleImagestatus($bundleid,$imgid,$imgunpublishstatus);
	}
	$bundleunpublishseenresult = $objalbum->BundleImageseen($bundleid,$seen2);
    $seenunpublisharray = json_decode($bundleunpublishseenresult, true);
	/***************************** /image status *********************/
	
	/******************************** check welcome / album sent to group - status ***/
	$setstatus = 0; 
	$bundlestatus = $objalbum->checkBundleImageStatus($bundleid , $setstatus);
	$bundlestatusarray = json_decode($bundlestatus , true);
	//print_r($bundlestatusarray);
	//die;
	/******************************** check welcome / album sent to group - status ***/
	
	//print_r($bundleseenresult);
	if($seenunpublisharray['success'] == 1)
	{
	echo "<script>alert('Album image Unpublished successfully');</script>";
	echo "<script>window.location='../pendingDataApprove.php?Bundle=".$bundleid."'</script>";
	}
	else
	{
	echo "<script>alert('Album image not Unpublished');</script>";
	echo "<script>window.location='../pendingDataApprove.php?Bundle=".$bundleid."'</script>";	
	}
}

/********************************* / BUNDLE IMAGE UNPUBLISH *****************************************/

/********************************* BUNDLE IMAGE PUBLISH **************************************/

if (isset($_POST['BundleImagepublish'])) {
	
$imageids = $_POST['bundleimgid'];
$bundleid = $_POST['bundleid'];
	
$seen2 = 1;
$imgpublishstatus = 1;

/******************************** check welcome / album sent to group - status ***/
	$setstatus = 1; 
	$bundlestatus = $objalbum->checkBundleImageStatus($bundleid , $setstatus);
	$bundlestatusarray = json_decode($bundlestatus , true);
	//print_r($bundlestatusarray);
	//die;
	/******************************** check welcome / album sent to group - status ***/

/************************ image status **********************/
	for($i=0; $i<count($imageids); $i++)
	{
	$imgid = $imageids[$i];
	$imgstatusresult = $objalbum->BundleImagestatus($bundleid,$imgid,$imgpublishstatus);
	}
	$bundlepublishseenresult = $objalbum->BundleImageseen($bundleid,$seen2);
	$seenpublisharray = json_decode($bundlepublishseenresult, true);
	//print_r($bundleseenresult);
    /***************************** /image status *********************/
	
	
	if($seenpublisharray['success'] == 1)
	{
	echo "<script>alert('Album image published successfully');</script>";
	echo "<script>window.location='../pendingDataApprove.php?Bundle=".$bundleid."'</script>";
	}
	else
	{
	echo "<script>alert('Album image not published');</script>";
	echo "<script>window.location='../pendingDataApprove.php?Bundle=".$bundleid."'</script>";	
	}
}

/********************************* / BUNDLE IMAGE PUBLISH *****************************************/


?>