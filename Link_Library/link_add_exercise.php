<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

@session_start();
require_once('../Class_Library/class_Health_Wellness.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_welcomeTable.php');

date_default_timezone_set('Asia/Kolkata');
$Post_Date = date('Y-m-d H:i:s');

$obj = new HealthWellness();
$push = new PushNotification();
$read = new Reading();
$welcome_obj = new WelcomePage();

$folder = '../images/health_wellness/';   // folder name for storing data
$target = 'images/health_wellness/';      //folder name for add with image insert into table

if (isset($_REQUEST['updateHealth'])) {
//    echo'<pre>';print_r($_REQUEST);die;

    $healthId = $_REQUEST['healthid'];
    $clientid = $_REQUEST['clientid'];
    $updatedby = $_REQUEST['useruniqueid'];
    $exercise_type = $_REQUEST['exercise_type'];
    $exercise_name = $_REQUEST['exercise_name'];
    $exercise_instructions = $_REQUEST['exercise_instructions'];
    $flag = $_REQUEST['flag'];

    if ($_FILES['exerciseImage']['name'] != "") {
        $timg = str_replace(" ", "", $_FILES['exerciseImage']['name']);
        $timgtemp = $_FILES['exerciseImage']['tmp_name'];
        $image_name = $healthId . "-" . $timg;

        $imagepath = $folder . $image_name;
        $dbimage = $target . $image_name;
        $url = $obj->compress_image($timgtemp, $imagepath, 30);
        $fullpath = SITE_URL . "images/health_wellness/" . $image_name;

        $exercise_image = $dbimage;
    } else {
        $exercise_image = $_REQUEST['exerciseImage'];
    }

    $uresult = $obj->updateHealthExercise($healthId, $exercise_type, $exercise_name, $exercise_image, $exercise_instructions, $Post_Date, $flag);
    
    if ($uresult) {
        echo "<script>alert('Health & Wellness Updated Successfully');</script>";
        echo "<script>window.location='../health-welness-view.php'</script>";
    } else {
        echo "<script>alert('Health & Wellness Not Updated');</script>";
        echo "<script>window.location='../health-welness-view.php'</script>";
    }
} else {
    $exercise_type = $_REQUEST['exercise_type'];
    $exercise_name = $_REQUEST['exercise_name'];
    $exercise_instructions = $_REQUEST['exercise_instructions'];
    $User_Type = $_REQUEST['optradio'];
    $Uuid = $_REQUEST['useruniqueid'];
    $Client_Id = $_REQUEST['clientid'];
    $status = '1';
    $Flag = $_REQUEST['flag'];
    $flagvalue = $_REQUEST['flagvalue'];
    $BY = $_SESSION['user_name'];

    /*     * ************************************************************************** */

    if ($_FILES['exerciseImage']['name'] != "") {
        $maxId = $obj->HealthMaxId();
        $timg = str_replace(" ", "", $_FILES['exerciseImage']['name']);
        $timgtemp = $_FILES['exerciseImage']['tmp_name'];
        $image_name = $maxId . "-" . $timg;

        $imagepath = $folder . $image_name;
        $dbimage = $target . $image_name;
        $url = $obj->compress_image($timgtemp, $imagepath, 30);
        $fullpath = SITE_URL . "images/health_wellness/" . $image_name;
    } else {
        $fullpath = "";
        $dbimage = "";
    }

    $LIKE = "";
    $like = (empty($LIKE) ? "" : $LIKE);
    if ($like == "") {
        $like = 'LIKE_NO';
        $like_val = 'like_no';
    } else {
        $like_val = 'like_yes';
        $like = 'LIKE_YES';
    }

    $COMMENT = "";
    $comment = (empty($COMMENT) ? "" : $COMMENT);
    if ($comment == "") {
        $comment = 'COMMENT_NO';
        $comment_val = 'comment_no';
    } else {
        $comment_val = 'comment_yes';
        $comment = 'COMMENT_YES';
    }

    $PUSH = "";
    $push_noti = (empty($PUSH) ? "" : $PUSH);
    if ($push_noti == "") {
        $PUSH_NOTIFICATION = 'PUSH_NO';
    } else {
        $PUSH_NOTIFICATION = 'PUSH_YES';
    }

    /*     * ************************************************************************** */

    if (!empty($_POST)) {
//        if ($User_Type == 'Selected') {
//            $user1 = $_POST['selected_user'];
//            $user2 = rtrim($user1, ',');
//            $myArray = explode(',', $user2);
//        } else {
//            //echo "all user"."<br/>";
//            $User_Type = "Selected";
//            //  echo "user type:-".$User_Type;
//            $user1 = $_POST['all_user'];
//            $user2 = rtrim($user1, ',');
//            $myArray = explode(',', $user2);
//        }

        /*         * ***************************** get image ***************************** */
//        $userimage = $push->getImage($Uuid);
//        $image = $userimage[0]['userImage'];
        /*         * ***************************** / get image *************************** */


        /*         * ********************** get keypem *********************************** */
//        $googleapiIOSPem = $push->getKeysPem($Client_Id);
        /*         * ********************** get keypem *********************************** */


        /*         * ************************ add feedback **************************** */
        $healthWellnessResult = $obj->createHealthExercise($Client_Id, $exercise_type, $exercise_name, $dbimage, $exercise_instructions, $status, $Post_Date, $Flag);
        $health_Id = $healthWellnessResult;

        /*         * ************************ / add feedback ************************** */

        /*         * ************************ add welcome **************************** */
//        $type = "Health Wellness";
//        $img = "";
//        $result1 = $welcome_obj->createWelcomeData($Client_Id, $health_Id, $type, $exercise_name, $img, $Post_Date, $Uuid, $Flag);
        /*         * ************************ / add welcome ************************** */

        /*         * ***************************** add post sent to group ******************************** */

//        $groupcount = count($myArray);
//        for ($k = 0; $k < $groupcount; $k++) {
//            $result1 = $read->postSentToGroup($Client_Id, $health_Id, $myArray[$k], $Flag);
//        }
        /*         * *************************** / add post sent to group ******************************** */

        /*         * **************  fetch all user employee id ********************* */
//        $gcm_value = $push->get_Employee_details($User_Type, $myArray, $Client_Id);
//        $token = json_decode($gcm_value, true);

        /*         * **************  / fetch all user employee id ********************* */

        /*         * ************************** group admin id ****************************** */
//        if ($User_Type != 'All') {
//            $groupadminuuid = $push->getGroupAdminUUId($myArray, $Client_Id);
//            $adminuuid = json_decode($groupadminuuid, true);
//            /* --------------all employee id--------- */
//
//            $allempid = array_merge($token, $adminuuid);
//            /* --------------all unique employee id--------- */
//
//            $allempid1 = array_values(array_unique($allempid));
//        } else {
//            $allempid1 = $token;
//        }
        /*         * ************************** / group admin id ****************************** */

        /*         * ********************** insert into post sent to table ******************* */

//        $total = count($allempid1);
//        for ($i = 0; $i < $total; $i++) {
//            $uuid = $allempid1[$i];
//            if (!empty($uuid)) {
//                $read->postSentTo($Client_Id, $health_Id, $uuid, $Flag);
//            } else {
//                continue;
//            }
//        }

        /*         * ********************** insert into post sent to table ******************* */

        /*         * ******************************* get gcm details ************************** */
//        $reg_token = $push->getGCMDetails($allempid1, $Client_Id);
//        $token1 = json_decode($reg_token, true);

        /*         * ******************************** / get gcm details *********************** */

        /*         * *******************Create file of user which this post send******************** */
//        $val[] = array();
//        foreach ($token1 as $row) {
//            array_push($val, $row["clientId"] . "," . $row["userUniqueId"] . "," . $row["registrationToken"]);
//        }
//
//        $file = fopen("../send_push_datafile/" . $health_Id . ".csv", "w");
//
//        foreach ($val as $line) {
//            @fputcsv($file, @explode(',', $line));
//        }
//        @fclose($file);

        /*         * *****************Create file of user which this post send End******************** */

        /*         * **************************** send push **************************************** */

//        if ($PUSH_NOTIFICATION == 'PUSH_YES') {
//
//            $hrimg = ($image == "") ? "" : SITE_URL . $image;
//            $sf = "successfully send";
//            $ids = array();
//            $idsIOS = array();
//            $fullpath = "";
//
//            foreach ($token1 as $row) {
//
//                if ($row['deviceName'] == 3) {
//                    array_push($idsIOS, $row["registrationToken"]);
//                } else {
//                    array_push($ids, $row["registrationToken"]);
//                }
//            }
//
//            $data = array('Id' => $health_Id, 'Title' => $exercise_name, 'Content' => $exercise_name, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $Post_Date, 'flag' => $Flag, 'flagValue' => $flagvalue, 'success' => $sf, 'like' => $like_val, 'comment' => $comment_val);
//
//
//            $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
//
//            //print_r($IOSrevert);
//
//            $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
//
//            $rt = json_decode($revert, true);
//            $iosrt = json_decode($IOSrevert, true);
//
//            if ($rt['success'] == 1) {
//                echo "<script>alert('Feedback Wall Posted Successfully');</script>";
//                echo "<script>window.location='../health-wellness.php'</script>";
//            } else {
//                echo "<script>alert('Feedback Wall Posted Successfully');</script>";
//                echo "<script>window.location='../health-wellness.php'</script>";
//            }
//        } else {
//            echo "<script>alert('Feedback Wall Posted Successfully');</script>";
//            echo "<script>window.location='../health-wellness.php'</script>";
//        }

        echo "<script>alert('Health & Wellness Posted Successfully');</script>";
        echo "<script>window.location='../health-wellness.php'</script>";
        /*         * *************************** / send push *************************************** */
    }
}
?>
