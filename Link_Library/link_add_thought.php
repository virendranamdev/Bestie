<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_welcomeTable.php');
require_once('../Class_Library/class_Thought.php');
require_once('../Class_Library/class_push_notification.php');
include_once('../Class_Library/class_get_group.php');

$obj_group = new Group();
$thought_obj = new ThoughtOfDay();
$thought_maxid = $thought_obj->thoughtMaxId();

$read = new Reading();
$push_obj = new PushNotification();
$welcome_obj = new WelcomePage();

date_default_timezone_set('Asia/Kolkata');
$post_date = date('Y-m-d H:i:s');

$folder = '../images/ThoughtsOFtheDAY/';   // folder name for storing data
$target = 'images/ThoughtsOFtheDAY/';      //folder name for add with image insert into table

if (isset($_REQUEST['updateThought'])) {
//    echo'<pre>';    print_r($_REQUEST);    die;

    $thoughtid = $_REQUEST['thoughtId'];
    $clientid = $_REQUEST['clientid'];
    $updatedby = $_REQUEST['useruniqueid'];
    $thought_content = $_REQUEST['content'];
    $update_date = date('Y-m-d', strtotime('now'));
    
    if ($_FILES['thoughtimage']['name'] != "") {
        $timg = str_replace(" ", "", $_FILES['thoughtimage']['name']);
        $timgtemp = $_FILES['thoughtimage']['tmp_name'];
        $image_name = $thoughtid . "-" . $timg;

        $imagepath = $folder . $image_name;
        $dbimage = $target . $image_name;
        $url = $thought_obj->compress_image($timgtemp, $imagepath, 30);
        $fullpath = SITE_URL . "images/ThoughtsOFtheDAY/" . $image_name;
        
        $thought_image = $dbimage;
    } else {
        $thought_image = $_REQUEST['thoughtImage'];
    }

    $updatethoughtresult = $thought_obj->updateThought($clientid, $thoughtid, $thought_content, $thought_image, $update_date, $updatedby);
    $uresult = json_decode($updatethoughtresult, true);
    
    if ($uresult['success'] == 1) {
        echo "<script>alert('Thought Updated Successfully');</script>";
        echo "<script>window.location='../view-previous-thought.php'</script>";
    } else {
        echo "<script>alert('Thought Not Updated');</script>";
        echo "<script>window.location='../view-previous-thought.php'</script>";
    }
} else {

    $FLAG = $_POST['flag'];
    $dev = $_POST['device'];
    $flag_name = "Thought for the day : ";

    if ($_FILES['thoughtimage']['name'] != "") {
        $timg = str_replace(" ", "", $_FILES['thoughtimage']['name']);
        $timgtemp = $_FILES['thoughtimage']['tmp_name'];
        $image_name = $thought_maxid . "-" . $timg;

        $imagepath = $folder . $image_name;
        $dbimage = $target . $image_name;
        $url = $thought_obj->compress_image($timgtemp, $imagepath, 30);
        $fullpath = SITE_URL . "images/ThoughtsOFtheDAY/" . $image_name;
    } else {
        $fullpath = "";
        $dbimage = "";
    }

    if ($_POST['content']) {
        $thoughttext = $_POST['content'];
    } else {
        $thoughttext = "";
    }


    $USEREMAIL = $_POST['useruniqueid'];
//echo "$user email : ".$USEREMAIL."<br/>";
    $clientid = $_SESSION['client_id'];


    /* $ptime1 = $_POST['publish_date1']." ".$_POST['publish_time1'];
      $utime1 = $_POST['publish_date2']." ".$_POST['publish_time2'];

      $timestamp = strtotime($ptime1);
      $ptime = date("Y-m-d H:i:s", $timestamp);

      if($utime1 == "")
      {
      $timestamp1 = strtotime($utime1);
      $utime = date('Y-m-d H:i:s', strtotime("+1 month", $timestamp1));
      }
      else
      {
      $timestamp1 = strtotime($utime1);
      $utime = date("Y-m-d H:i:s", $timestamp1);
      }
     */
    $ptime = "";
    $utime = "";

    $User_Type = "All";
    /*     * ************************************************************* */
    /* if ($User_Type == 'Selected') {
      $user1 = $_POST['selected_user'];
      $user2 = rtrim($user1, ',');
      $myArray = explode(',', $user2);

      } else {
      // echo "all user"."<br/>";
      $User_Type = "Selected";
      //  echo "user type:-".$User_Type;
      $user1 = $_POST['all_user'];
      $user2 = rtrim($user1, ',');
      $myArray = explode(',', $user2);

      }
     */

    /*     * ************************************************************* */
    /*     * ****************************** fetch group ************************ */
    /*     * ************************* find group **************************** */
    $result = $obj_group->getGroup($clientid);
    $value = json_decode($result, true);
    $getcat = $value['posts'];

    $myArray = array();
    foreach ($getcat as $groupid) {
        array_push($myArray, $groupid['groupId']);
    }

    /*     * ******************** end fetch group ****************************** */

    if (isset($_POST['push']) && $_POST['push'] == 'PUSH_YES') {
        $PUSH_NOTIFICATION = 'PUSH_YES';
    } else {
        $PUSH_NOTIFICATION = 'PUSH_YES';
    }

    /*     * *********************** get key pem **************************** */
    $googleapiIOSPem = $push_obj->getKeysPem($clientid);
    /*     * *********************** end get key pem ************************ */


    /*     * ********************* insert into database ************************************************ */
    $thoughtresult = $thought_obj->createThought($clientid, $thought_maxid, $thoughttext, $dbimage, $FLAG, $USEREMAIL, $ptime, $utime, $post_date);
    if ($thoughtresult == 'True') {
        //echo "data send";
    }
    $type = 'Thought';
    $img = "";
    $result1 = $welcome_obj->createWelcomeData($clientid, $thought_maxid, $type, $thoughttext, $dbimage, $post_date, $USEREMAIL, $FLAG);

    $groupcount = count($myArray);
    $general_group = array();
    $custom_group = array();
    for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
        $result1 = $read->thoughtSentToGroup($clientid, $thought_maxid, $myArray[$k], $FLAG);
/***********************  custom group *********************/
         $groupdetails = $read->getGroupDetails($clientid, $myArray[$k]);  //get all groupdetails

        if ($groupdetails['groupType'] == 2) {
            array_push($custom_group, $myArray[$k]);
        } else {
            array_push($general_group, $myArray[$k]);
        }
    }
   /******************  fetch all user employee id from user detail start **************************** */
if (count($general_group) > 0) {
       
        $gcm_value = $push_obj->get_Employee_details($User_Type, $general_group, $clientid);
    
        $generaluserid = json_decode($gcm_value, true);

    }
    else{   
               $generaluserid = array();
    }
    if (count($custom_group) > 0) {
        $gcm_value1 = $obj_group->getCustomGroupUser($clientid, $custom_group);
        $customuserid = json_decode($gcm_value1, true);

    }
     else{
              $customuserid = array();
    }
    /*************get group admin uuid  form group admin table if user type not= all ************** */
    /*     * *************************get group admin uuid  form group admin table if user type not= all *************************** */

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

    /*     * ******* insert into post sent to table for analytic sstart************ */

    $total = count($allempid1);
    for ($i = 0; $i < $total; $i++) {
        $uuid = $allempid1[$i];
        //echo "post sent to :--".$uuid."<br/>";
        if (!empty($uuid)) {
            $read->thoughtSentTo($clientid, $thought_maxid, $uuid);
        } else {
            continue;
        }
    }
    /*     * ******* insert into post sent to table for analytic sstart************ */

    /*     * *** get all registration token  for sending push **************** */
    $reg_token = $push_obj->getGCMDetails($allempid1, $clientid);
    $token1 = json_decode($reg_token, true);
    /* echo "----regtoken------";
      echo "<pre>";
      print_r($token1);
      echo "<pre>"; */

    /*     * *******************Create file of user which this post send  start******************** */
    $val[] = array();
    foreach ($token1 as $row) {
        array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
    }

    $file = fopen("../send_push_datafile/" . $thought_maxid . ".csv", "w");

    foreach ($val as $line) {
        @fputcsv($file, @explode(',', $line));
    }
    @fclose($file);

    /*     * ******************Create file of user which this post send End******************** */


    /*     * *******************check push notificaticon enabale or disable******************** */

    if ($PUSH_NOTIFICATION == 'PUSH_YES') {

        /*         * ******************* send push by  push notification******************** */

        $hrimg = SITE_URL . $_SESSION['image_name'];

        $sf = "successfully send";
        $ids = array();
        $idsIOS = array();

        foreach ($token1 as $row) {
		$content = $thoughttext;
 
            	$data = array('Id' => $thought_maxid, 'Title' => $content, 'Content' => $content, 'SendBy' => $USEREMAIL, 'Picture' => $fullpath, 'image' => $fullpath, 'Date' => $post_date, 'Publishing_time' => $ptime, 'Unpublishing_time' => $utime, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf);
	    
		$badgecount = $push_obj->getBadgecount($row['deviceId']);
		$badgecount = $badgecount['badgeCount']+1;
		$addBadgecount = $push_obj->updateBadgecount($row['deviceId'], $badgecount);
	    
                if ($row['deviceName'] == "3") {
                    $data['device_token'] = $row['registrationToken'];
            	    $IOSrevert = $push_obj->sendAPNSPushCron($data, $googleapiIOSPem['iosPemfile'], '', $badgecount);        
                } else {
                    $data['device_token'] = $row['registrationToken'];
                    $data['badge'] = $badgecount;
                    $revert = $push_obj->sendGoogleCloudMessageCron($data, $googleapiIOSPem['googleApiKey']);
		}
	}

        if ($revert['success'] == 1) {
            echo "<script>alert('Thought Posted Successfully');</script>";
            echo "<script>window.location='../view-previous-thought.php'</script>";
        } 
    } else {
        echo "<script>alert('Thought Post Successfully');</script>";
        echo "<script>window.location='../view-previous-thought.php'</script>";
    }
}
?>
