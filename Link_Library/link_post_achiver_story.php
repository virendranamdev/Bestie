<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);

@session_start();
require_once('../Class_Library/class_achiverstory.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_get_group.php'); // use for custom group

date_default_timezone_set('Asia/Kolkata');
$Post_Date = date('Y-m-d H:i:s');

$obj = new AchiverStory(); 
$push = new PushNotification();        
$read = new Reading();
$customGroup = new Group();                  // object of class get group for custom group

$maxid = $obj->maxId();
$storyid = $maxid;
$target = '../images/achiverimage/';  
$folder = 'images/achiverimage/';
$coverfolderpath = '../images/achiverimage/coverImage/';  
$coverdbpath = 'images/achiverimage/coverImage/';
$Status = 1;    
if (!empty($_POST)) {

if(isset($_REQUEST['updatestory'])) {
	$storyid = $_REQUEST['storyid'];
	$clientid = $_REQUEST['clientid'];
	$uuid = $_REQUEST['useruniqueid'];
	
	$storytitle = $_REQUEST['storytitle'];
	$achievername = $_REQUEST['achievername'];
	$achieverdesignation =  $_REQUEST['achieverdesignation'];
	$achieverlocation = $_REQUEST['achieverlocation'];
	$achieverstory = $_REQUEST['story'];
	$coverpreviousimage = $_POST['coverpreviousimage'];
	
	
	// echo'<pre>';print_r($_FILES);die;
	
	$coverError = $_FILES['achievercoverimage']['error'];
	if($coverError != 4){
		$coverimageName = str_replace(' ', '', $_FILES['achievercoverimage']['name']);  
		$coverimgtype = $_FILES['achievercoverimage']['type'];
		$coverpathtemp = $_FILES['achievercoverimage']['tmp_name'];

		$coverfolder = $coverfolderpath . $storyid . "-" . basename($_FILES["achievercoverimage"]["name"]);
		$coverdb = $coverdbpath . $storyid . "-" . basename($_FILES["achievercoverimage"]["name"]);
		
		$obj->compress_image($coverpathtemp, $coverfolder, 20);
	} else {
		$coverdb = $coverpreviousimage;
	}
	
	$updateachieverresult = $obj->update_AchieverStory($storyid , $clientid, $storytitle, $achievername, $achieverdesignation, $achieverlocation, $achieverstory, $coverdb, $uuid, $Post_Date);
	$uresult = json_decode($updateachieverresult , true);
	
	
	$error = $_FILES['achieverimage']['error'];
	if($error[0] != 4) {
		$path1 = $_FILES['achieverimage']['name'];
		$k2 = $_FILES['achieverimage'];
		$type1 = $_FILES['achieverimage']['type'];
		$pathtemp1 = $_FILES['achieverimage']['tmp_name'];
		$countfiles1 = count($path1);	
		
		if($countfiles1 > 4) {
			echo "<script>alert('You can only upload a maximum of 4 Images')</script>";
			echo "<script>window.location='../create-story.php'</script>";
		} else {
			$imgdelete2 = $obj->deleteaAchieverImage($storyid, $clientid);
			$deleteimgres2 = json_decode($imgdelete2 , true);
			
			if($deleteimgres2['success']==1) {
				for ($i = 0; $i < $countfiles1; $i++) {
					$target_file2 = $folder . $storyid . "-" . basename($_FILES["achieverimage"]["name"][$i]);
					$target_file3 = $target . $storyid . "-" . basename($_FILES["achieverimage"]["name"][$i]);    
					$temppath2 = $_FILES["achieverimage"]["tmp_name"][$i];
				   
					$imgsave2 = $obj->saveImage($storyid, $clientid, $target_file2,$Status,$uuid,$Post_Date);
					$imgres2 = json_decode($imgsave2 , true);
					if($imgres2['success']==1) {
						$imageres2 = $obj->compress_image($temppath2, $target_file3, 20);
					}
				}
			}
		}
	}
	
	if($uresult['success']== 1) {
		echo "<script>alert('Story Updated Successfully');</script>";
        	echo "<script>window.location='../story.php'</script>";
	} else {
		echo "<script>alert('Story Not Updated');</script>";
        	echo "<script>window.location='../story.php'</script>";
	}
} else {

$storytitle = $_REQUEST['storytitle'];
$achievername = $_REQUEST['achievername'];
$achiveremailid = $_REQUEST['achieveremail'];
$achieverdesignation =  $_REQUEST['achieverdesignation'];
$achieverlocation = $_REQUEST['achieverlocation'];
//echo $achieverstory = $_REQUEST['story'];
$achieverstory = $_REQUEST['story'];
$User_Type = $_REQUEST['optradio'];
$Uuid = $_REQUEST['useruniqueid'];
$Client_Id = $_REQUEST['clientid'];
$Flag = $_REQUEST['flag'];
$flag_name = "Colleague Story: ";
$BY = $_SESSION['user_name'];
$device = "Panel";

/*****************************************************************************/

	$LIKE = "LIKE_YES";
	$like = (empty($LIKE)?"":$LIKE);
	if ($like =="") {
		$like = 0;
		$like_val = 'like_no';
        } else {
    		$like_val = 'like_yes';
		$like = 1;
        }

	$COMMENT = "COMMENT_YES";
    	$comment = (empty($COMMENT)?"":$COMMENT);
	if ($comment=="") {
		$comment = 0;
		$comment_val = 'comment_no';
        } else {
            	$comment_val = 'comment_yes';
		$comment = 1;
        }

	$PUSH = "PUSH_YES";
    	$push_noti = (empty($PUSH)?"":$PUSH);
	if ($push_noti=="") {
            	$PUSH_NOTIFICATION = 'PUSH_NO';
        } else {
            	$PUSH_NOTIFICATION = 'PUSH_YES';
        }
        
//echo $like;
//echo $comment;
//echo $PUSH_NOTIFICATION;

/*****************************************************************************/

	if ($User_Type == 'Selected') {
		$user1 = $_POST['selected_user'];
		$user2 = rtrim($user1, ',');
		$myArray = explode(',', $user2);
	} else {
		//echo "all user"."<br/>";
		$User_Type = "Selected";
		//  echo "user type:-".$User_Type;
		$user1 = $_POST['all_user'];
		$user2 = rtrim($user1, ',');
		$myArray = explode(',', $user2);
	}
	
/****************************** cover image *****************************/
        // echo '<pre>';print_r($_FILES['achievercoverimage']);die;
	$coverimageName = $_FILES['achievercoverimage']['name'];  
	$coverimgtype = $_FILES['achievercoverimage']['type'];
	$coverpathtemp = $_FILES['achievercoverimage']['tmp_name'];

	$coverfolder = $coverfolderpath . $storyid . "-" . basename($_FILES["achievercoverimage"]["name"]);
	$coverdb = $coverdbpath . $storyid . "-" . basename($_FILES["achievercoverimage"]["name"]);
	// echo "folderpath-".$coverfolder."<br/>"; echo "db path-".$coverdb."<br/>"; die;
	
/********************************* image ************************/
$path = $_FILES['achieverimage']['name'];
$k1 = $_FILES['achieverimage'];
$type = $_FILES['achieverimage']['type'];
//print_r($k1);
$pathtemp = $_FILES['achieverimage']['tmp_name'];
$countfiles = count($path);
//print_r($pathtemp);

if($countfiles > 4) {
	echo "<script>alert('You can only upload a maximum of 4 Images')</script>";
	echo "<script>window.location='../create-story.php'</script>";
} else {
if(!empty($_FILES['achieverimage']['name'][0])) {
	for ($i = 0; $i < $countfiles; $i++) {
   		$target_file1 = $folder . $storyid . "-" . basename($_FILES["achieverimage"]["name"][$i]);
        	$target_file = $target . $storyid . "-" . basename($_FILES["achieverimage"]["name"][$i]);    
		$temppath = $_FILES["achieverimage"]["tmp_name"][$i];
		       
		$imgsave = $obj->saveImage($storyid, $Client_Id, $target_file1,$Status,$Uuid,$Post_Date);
		$imgres = json_decode($imgsave , true);
		if($imgres['success']==1) {
			$imageres = $obj->compress_image($temppath, $target_file, 20);
		}
    	}
} else {
	$target_file1 = '';
}
/**************************** / save image *****************************/

	/******************************* get image ******************************/
	$userimage = $push->getImage($Uuid);
	$image = $userimage[0]['userImage'];
	/******************************* / get image ****************************/
	
	/************************ get keypem ************************************/
	$googleapiIOSPem = $push->getKeysPem($Client_Id);
	/************************ get keypem ************************************/

	/************************** add achieverstory *****************************/
	$result = $obj->create_AchiverStory($storyid , $Client_Id, $storytitle,$achievername,$achiveremailid, $achieverdesignation, $achieverlocation , $achieverstory,$coverdb, $device, $Flag, $like, $comment, $Post_Date, $Uuid, $Status);
	$imageres1 = $obj->compress_image($coverpathtemp, $coverfolder, 20);

	/************************** / add feedback ***************************/

	/******************************** create welcome data ****************************/
	$type = 'AStory';
	$welcomeresult1 = $obj->createWelcomeData($Client_Id, $storyid, $type, $storytitle , $Post_Date, $Uuid, $Flag);
	/********************************* / create welcome data ***************************/

	/******************************* add post sent to group *********************************/
      $general_group = array();
      $custom_group = array();
	$groupcount = count($myArray);
	for ($k = 0; $k < $groupcount; $k++) {
		//echo "group id".$myArray[$k];
		$result1 = $read->StorySentToGroup($Client_Id, $storyid, $myArray[$k], $Flag);
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
	  
/**************************** group admin id *******************************/		
	if ($User_Type != 'All') {
            $groupadminuuid = $push->getGroupAdminUUId($myArray, $Client_Id);
            $adminuuid = json_decode($groupadminuuid, true);
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
            $allempid1 = $token;
        }
/**************************** / group admin id *******************************/	

/************************ insert into post sent to table ********************/

        $total = count($allempid1);
        for ($i = 0; $i < $total; $i++) {
            $uuid = $allempid1[$i];
//echo "count no.:-".$i."->".$uuid."<br/>";
            if (!empty($uuid)) {
		$read->postSentTo($Client_Id, $storyid, $uuid, $Flag);
            } else {
                continue;
            }
        }

/************************ insert into post sent to table ********************/

/*************************** change status of previous story ***********************/
//$previousstoryresult = $obj->statusPreviousStory($Client_Id, $storyid, $type, $Flag);
/****************************  change status of previous story **********************/

/********************************* get gcm details ***************************/
	$reg_token = $push->getGCMDetails($allempid1, $Client_Id);
        $token1 = json_decode($reg_token, true);
        /*echo "----regtoken------";
          echo "<pre>";
          print_r($token1);
          echo "<pre>";*/
/********************************** / get gcm details ************************/

/*********************Create file of user which this post send******************** */

	$fname = "story".$storyid;
        $val[] = array();
        foreach ($token1 as $row) {
            array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
        }

        $file = fopen("../send_push_datafile/" . $fname . ".csv", "w");

        foreach ($val as $line) {
            @fputcsv($file, @explode(',', $line));
        }
        @fclose($file);

/*******************Create file of user which this post send End******************** */

/****************************** send push *****************************************/

if ($PUSH_NOTIFICATION == 'PUSH_YES') {

	    $hrimg = ($coverdb == "")?"":SITE_URL . $coverdb;
            // echo "hr image".$hrimg;
            $sf = "successfully send";
            $ids = array();
            $idsIOS = array();
	    $fullpath = "";
		
            foreach ($token1 as $row) {
		$content = $achievername;
		
            	$data = array('Id' => $storyid, 'Title' => $content, 'Content' => $content, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $Post_Date, 'flag' => $Flag, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
	    
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
                echo "<script>alert('Story Posted Successfully');</script>";
                echo "<script>window.location='../create-story.php'</script>";
            }
} else {
	echo "<script>alert('Story Posted Successfully');</script>";
	echo "<script>window.location='../create-story.php'</script>";
}
        

/***************************** / send push ****************************************/

}
}
}
?>
