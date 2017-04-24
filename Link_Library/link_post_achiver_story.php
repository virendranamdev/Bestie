<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_achiverstory.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_reading.php');

date_default_timezone_set('Asia/Calcutta');
$Post_Date = date('Y-m-d H:i:s A');

$obj = new AchiverStory(); 
$push = new PushNotification();        
$read = new Reading();

$maxid = $obj->maxId();
$storyid = $maxid;
$target = '../images/achiverimage/';  
$folder = 'images/achiverimage/'; 
$Status = 1;    
if (!empty($_POST)) 
{

if(isset($_REQUEST['updatestory']))
{
	//echo "inside update";
	$storyid = $_REQUEST['storyid'];
	$clientid = $_REQUEST['clientid'];
	$uuid = $_REQUEST['useruniqueid'];
	
	$storytitle = $_REQUEST['storytitle'];
	$achievername = $_REQUEST['achievername'];
	$achieverdesignation =  $_REQUEST['achieverdesignation'];
	$achieverlocation = $_REQUEST['achieverlocation'];
	$achieverstory = $_REQUEST['story'];
	
	$updateachieverresult = $obj->update_AchieverStory($storyid , $clientid, $storytitle, $achievername, $achieverdesignation, $achieverlocation, $achieverstory,$uuid, $Post_Date);
	$uresult = json_decode($updateachieverresult , true);
	//print_r($uresult);
	
	$error = $_FILES['achieverimage']['error'];
	if($error[0] != 4)
	{
		$path1 = $_FILES['achieverimage']['name'];
		$k2 = $_FILES['achieverimage'];
		$type1 = $_FILES['achieverimage']['type'];
		$pathtemp1 = $_FILES['achieverimage']['tmp_name'];
		$countfiles1 = count($path1);	
		
		if($countfiles1 > 4)
		{
			echo "<script>alert('You can only upload a maximum of 4 Images')</script>";
			echo "<script>window.location='../create-story.php'</script>";
		}
		else
		{
			$imgdelete2 = $obj->deleteaAchieverImage($storyid, $clientid);
			$deleteimgres2 = json_decode($imgdelete2 , true);
			
			if($deleteimgres2['success']==1)
			{
				for ($i = 0; $i < $countfiles1; $i++) 
				{
					   $target_file2 = $folder . $storyid . "-" . basename($_FILES["achieverimage"]["name"][$i]);
					   $target_file3 = $target . $storyid . "-" . basename($_FILES["achieverimage"]["name"][$i]);    
					   $temppath2 = $_FILES["achieverimage"]["tmp_name"][$i];
				   
						$imgsave2 = $obj->saveImage($storyid, $clientid, $target_file2,$Status,$uuid,$Post_Date);
						$imgres2 = json_decode($imgsave2 , true);
						if($imgres2['success']==1)
						{
						$imageres2 = $obj->compress_image($temppath2, $target_file3, 20);
						}
				}
			}
		}	
	}
	
	if($uresult['success']== 1)
	{
		echo "<script>alert('Story Updated Successfully');</script>";
        echo "<script>window.location='../story.php'</script>";
	}
	else
	{
		echo "<script>alert('Story Not Updated');</script>";
        echo "<script>window.location='../story.php'</script>";
	}
	
}
else
{

$storytitle = $_REQUEST['storytitle'];
$achievername = $_REQUEST['achievername'];
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
		if ($like =="") 
		{
            $like = 0;
            $like_val = 'like_no';
        } else 
		{
            $like_val = 'like_yes';
			$like = 1;
        }

	$COMMENT = "COMMENT_YES";
    $comment = (empty($COMMENT)?"":$COMMENT);
		if ($comment=="") 
		{
            $comment = 0;
            $comment_val = 'comment_no';
        } else 
		{
            $comment_val = 'comment_yes';
			$comment = 1;
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
	
/****************************** save image *****************************/

$path = $_FILES['achieverimage']['name'];
$k1 = $_FILES['achieverimage'];
$type = $_FILES['achieverimage']['type'];
//print_r($k1);
$pathtemp = $_FILES['achieverimage']['tmp_name'];
$countfiles = count($path);
//print_r($pathtemp);

if($countfiles > 4)
{
	echo "<script>alert('You can only upload a maximum of 4 Images')</script>";
	echo "<script>window.location='../create-story.php'</script>";
}
else
{
for ($i = 0; $i < $countfiles; $i++) {
	   $target_file1 = $folder . $storyid . "-" . basename($_FILES["achieverimage"]["name"][$i]);
        $target_file = $target . $storyid . "-" . basename($_FILES["achieverimage"]["name"][$i]);    
		$temppath = $_FILES["achieverimage"]["tmp_name"][$i];
		       
		$imgsave = $obj->saveImage($storyid, $Client_Id, $target_file1,$Status,$Uuid,$Post_Date);
		$imgres = json_decode($imgsave , true);
		if($imgres['success']==1)
		{
			$imageres = $obj->compress_image($temppath, $target_file, 20);
		}
		
    }

/**************************** / save image *****************************/

/******************************* get image ******************************/
$userimage = $push->getImage($Uuid);
$image = $userimage[0]['userImage'];
/******************************* / get image ****************************/
	
/************************ get keypem ************************************/
$googleapiIOSPem = $push->getKeysPem($Client_Id);
//print_r($googleapiIOSPem);
/************************ get keypem ************************************/

/************************** add achieverstory *****************************/
 $result = $obj->create_AchiverStory($storyid , $Client_Id, $storytitle,$achievername, $achieverdesignation,$achieverlocation , $achieverstory, $device, $Flag, $like, $comment, $Post_Date, $Uuid, $Status);
/************************** / add feedback ***************************/

/******************************** create welcome data ****************************/
$type = 'AStory';
  $welcomeresult1 = $obj->createWelcomeData($Client_Id, $storyid, $type, $storytitle , $Post_Date, $Uuid, $Flag);
/********************************* / create welcome data ***************************/

/******************************* add post sent to group *********************************/

$groupcount = count($myArray);
        for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
        $result1 = $read->StorySentToGroup($Client_Id, $storyid, $myArray[$k], $Flag);
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
           
            $data = array('Id' => $storyid, 'Title' => $achievername, 'Content' => $achievername, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $Post_Date, 'flag' => $Flag, 'flagValue' => $flag_name, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
			
			
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
                echo "<script>alert('Story Posted Successfully');</script>";
                echo "<script>window.location='../create-story.php'</script>";
            }
			else
			{
			echo "<script>alert('Story Posted Successfully');</script>";
            echo "<script>window.location='../create-story.php'</script>";
			}
    }
else
{
	echo "<script>alert('Story Posted Successfully');</script>";
    echo "<script>window.location='../create-story.php'</script>";
}
        

/***************************** / send push ****************************************/

}
}
}
?>
