<?php

error_reporting(E_ALL ^ E_NOTICE);

if (!class_exists("Family") && include("../../Class_Library/Api_Class/class_family.php")) {
    include_once("../../Class_Library/class_recognize.php");
    
   //  require_once('../../Class_Library/Api_Class/class_AppAnalytic.php');
    
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
        //echo json_encode($response);
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    $jsonArr = json_decode(file_get_contents("php://input"), true);

    if ((!empty($jsonArr["clientId"])) && (!empty($jsonArr['device'])) && (!empty($jsonArr['deviceId']))) {
        extract($jsonArr);
        $obj = new Family();
        $rec = new Recognize();
     //    $analytic_obj = new AppAnalytic();
        $result = $obj->getUserDetails($clientId, $uuid);

        if ($result['success'] == 1) {
            extract($result);
	    $userScore = $rec->recognitionLeaderboard($clientId, $uuid);
	    $myRecognition  = (!empty($userScore['data'][0]['totalRecognition']))?$userScore['data'][0]['totalRecognition']:"0";
            $response = $obj->getRecognisedUser($clientId, $uuid, $value);
            
            $response['username'] = $UserDetails['firstName']." ".$UserDetails['lastName'];
            $response['userimage'] = $UserDetails['userImage'];
            $response['myRecognition'] = "You have ".$myRecognition." hall of fame";
             /************* analytic purpose seve data *****************/
        //    $flagtype = 10;
       //  $analytic_obj->listAppview($clientId, $uuid, $device, $deviceId, $flagtype);
        }
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
