<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_MiniSurvey.php');
require_once('../Class_Library/class_push_notification.php');
include_once('../Class_Library/class_get_group.php');  // for getting all group
require_once('../Class_Library/class_reading.php');
//
$survey_obj = new MiniSurvey();
$obj_group = new Group();                  // object of class get group for custom group
$read = new Reading();
$push_obj = new PushNotification();
//
date_default_timezone_set('Asia/Calcutta');
$post_date = date("Y-m-d H:i:s A");
$username = $_SESSION['user_name'];
$clientid = $_SESSION['client_id'];
$createdby = $_SESSION['user_unique_id'];

if (!empty($_POST)) {
    /**     * **************** check poll image and poll question exist or not ************************* */
    $FLAG = 20;
    $flag_name = "Survey : ";

    $surveytitle = $_POST['surveytitle'];
    $questionno = $_POST['questionno'];
    $surveystart = $_POST['validfrom'];
    $surveyend = $_POST['validtill'];
    $content = "";
//    echo "survey title-".$surveytitle . "<br>";
//    echo "question no-".$questionno . "<br>";
//    echo "valid from-".$surveystart . "<br>";

    $createddate = $post_date;
$PUSH_NOTIFICATION = "PUSH_YES";

    /**     * ***************** find group **************************** */
//// $User_Type == 'Selected'
//    $User_Type = $_POST['user3'];
//    if ($User_Type == 'Selected') {
//        $user1 = $_POST['selected_user'];
//        $user2 = rtrim($user1, ',');
//
//        $myArray = explode(',', $user2);
//
//       /*  echo "<pre>";
//          echo "selected";
//          print_r($myArray);
//          echo "</pre>"; */
//    } else {
//        // echo "all user"."<br/>";
//        $User_Type = "All";
//       //  echo "user type:-".$User_Type;
//        $user1 = $_POST['all_user'];
//        $user2 = rtrim($user1, ',');
//        $myArray = explode(',', $user2);
//       /*  echo "<pre>";
//          print_r($myArray)."<br/>";
//          echo "</pre>"; */
//    }

    /*********************** end find group ********************** */
$countsurvey = $survey_obj->checkSurveyAvailablity($clientid,$surveystart);
    
    $value1 = json_decode($countsurvey,true);
   
    if($value1["success"] === 1)
            {
                 echo "<script>alert('survey is Available');</script>";
                 echo "<script>window.location='../create-mini-survey.php'</script>";
            }
 else {
   
    $status = 1;
    $value = $survey_obj->createSurvey($clientid, $surveytitle, $questionno, $createdby, $createddate, $surveyend, $surveystart, $status);

//    echo "<pre>";
//    print_r($value);

    $surveyid = $value['lastid'];


    for ($t = 0; $t < $questionno; $t++) 
    {
        $questionname = "surveyquestion" . $t;
        $surveyquestion = $_POST[$questionname];
       //echo "question-".$surveyquestion."<br/>";
       
       $optioncount = $_POST['optioncount'];
      // echo "this is option count-".$optioncount."<br/>";
       for($k=0;$k<$optioncount;$k++)
       {
           $val = "optiontypeid".$t.$k;
          // $optionid = $_POST[$val];
         
           $radioname = "radio".$t.$k;
          //  $radio = ;
            if(isset($_POST[$radioname]))
            {
                $radiovalue = $_POST[$radioname];
                 $optionid = $_POST[$val];
                 
                
                 $optionnumber = ($optionid == 1)?$_POST['numberoption']:0;
                 
                  /*******************************/
                 $response = $survey_obj->createSurveyQuestion($surveyid, $surveyquestion,  $optionid, $optionnumber, $createddate, $createdby, $status);
        print_r($response);
        
        $questionid = $response['questionid'];
                 
               /**************************/    
                 
                 if($optionnumber > 0)
                 {
                     for($h=1;$h<=$optionnumber;$h++)
                     {
                         $optionradio = "radiooption".$t.$h;
                         $optionvalue = $_POST[$optionradio];
                         echo "this is option value-".$optionvalue;
                         
                         $response1 = $survey_obj->createSurveyQuestionoption($questionid,$surveyid, $optionid, $optionvalue, $status, $createddate, $createdby);
        print_r($response1);
                         
                     }
                 }
 else {
    // $optionnumber = 0;
 }
               
            }
  
       }
    
    }

    /** ************************* find group **************************** */
    $User_Type = 'Selected';
    $result = $obj_group->getGroup($clientid);
    $value = json_decode($result, true);
    $getcat = $value['posts'];

    $wholegroup = array();
    foreach ($getcat as $groupid) {
        array_push($wholegroup, $groupid['groupId']);
    }

    print_r($wholegroup);

    /*     * *********************** option  start ****************** */

    /*     * *************** add survey in post sent to group table ******************* */
    $groupcount = count($wholegroup);
    $general_group = array();
    $custom_group = array();
    for ($k = 0; $k < $groupcount; $k++) {
        //echo "group id-".$wholegroup[$k];
        $result1 = $read->postSentToGroup($clientid, $surveyid, $wholegroup[$k], $FLAG);
        /*         * *********************  custom group ******************** */
        $groupdetails1 = $obj_group->getGroupDetails($clientid, $wholegroup[$k]);  //get all groupdetails
        $groupdetails = json_decode($groupdetails1, true);
//        echo "<pre>";
//        print_r($groupdetails);
        if ($groupdetails['groupType'] == 2) {
            array_push($custom_group, $wholegroup[$k]);
        } else {
            array_push($general_group, $wholegroup[$k]);
        }
    }


    /*     * *********************************** Get GoogleAPIKey and IOSPEM file ********************************* */
    $googleapiIOSPem = $push_obj->getKeysPem($clientid);

    /*     * ****************  fetch all user employee id from user detail start **************************** */
    if (count($general_group) > 0) {

        $gcm_value = $push_obj->get_Employee_details($User_Type, $general_group, $clientid);

        $generaluserid = json_decode($gcm_value, true);
    } else {
        $generaluserid = array();
    }
    if (count($custom_group) > 0) {
        $gcm_value1 = $customGroup->getCustomGroupUser($clientid, $custom_group);
        $customuserid = json_decode($gcm_value1, true);
    } else {
        $customuserid = array();
    }
    /*     * ***********get group admin uuid  form group admin table if user type not= all ************** */

    if ($User_Type != 'All') {
        // $groupadminuuid = $push_obj->getGroupAdminUUId($myArray, $clientid);
        // $adminuuid = json_decode($groupadminuuid, true);
        /*  echo "hello groupm admin id";
          echo "<pre>";
          print_r($adminuuid)."<br/>";
          echo "</pre>"; */
        /*         * ****** "--------------all employee id---------"** */

        $allempid = array_merge($generaluserid, $customuserid);
        /* echo "admin id";
          echo "<pre>";
          print_r($allempid);
          echo "<pre>";
         */

        /**         * * "--------------all unique employee id---------"********** */
        $allempid1 = array_values(array_unique($allempid));
        /* echo "<pre>";
          print_r($allempid1);
          echo "<pre>"; */
    } else {
        $allempid1 = $generaluserid;
    }

//     echo "<pre>";
//      print_r($allempid1);
//      echo "<pre>"; 
    /**     * ****** insert into post sent to table for analytic sstart************ */
    $total = count($allempid1);

    for ($i = 0; $i < $total; $i++) {
        $uuid = $allempid1[$i];
        //echo "post sent to empid:--".$uuid."<br/>";
        if (!empty($uuid)) {
            $read->postSentTo($clientid, $surveyid, $uuid, $FLAG);
        }
    }
    /**     * ****** insert into post sent to table for analytic sstart************ */
    /*     * *** get all registration token  for sending push **************** */
    $reg_token = $push_obj->getGCMDetails($allempid1, $clientid);
    $token1 = json_decode($reg_token, true);
    /* echo "----regtoken------";
      echo "<pre>";
      print_r($token1);
      echo "<pre>";
     */
    /*     * *******************check push notificaticon enabale or disable******************** */
    if ($PUSH_NOTIFICATION == 'PUSH_YES') {
        $fullpath = '';
        $hrimg = SITE_URL . $_SESSION['image_name'];
//echo "hr image:-".$hrimg;
        $sf = "successfully send";
        $ids = array();
        $idsIOS = array();
        foreach ($token1 as $row) {

            if ($row['deviceName'] == 3) {
                array_push($idsIOS, $row["registrationToken"]);
            } else {
                array_push($ids, $row["registrationToken"]);
            }
        }

        // $content = str_replace("\r\n", "", strip_tags($ques));
        $data = array('Id' => $surveyid, 'Title' => $surveytitle, 'Content' => $content, 'image' => $fullpath, 'Picture' => $hrimg, 'Date' => $post_date, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf);

        $IOSrevert = $push_obj->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
        $revert = $push_obj->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
        $rt = json_decode($revert, true);
//print_r($rt);
        if ($rt) {

           echo "<script>alert('Survey Successfully Created');</script>";
            //echo $rt;
            echo "<script>window.location='../create-mini-survey.php'</script>";
        }
    } else {
       echo "<script>alert('Survey Successfully Created');</script>";
        echo "<script>window.location='../create-mini-survey.php'</script>";
    }
}
}
?>