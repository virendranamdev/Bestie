<?php

error_reporting(0);
//ini_set('display_errors', 1);

if (file_exists("../../Class_Library/Api_Class/class_employee_app_login.php") && include("../../Class_Library/Api_Class/class_employee_app_login.php")) {
    require_once('../../Class_Library/Api_Class/class_AppAnalytic.php');
    include_once("../../Class_Library/class_recognize.php");
    
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

    /*
      {
      "clientid":"CO-28",
      "uid":"HGLF3M0DfwFdqWP3AbWPUWA0cD03O61",
      "device":"2",
      "deviceId":"",
      "appVersion":""
      }
     */

    if ((!empty($jsonArr["clientid"])) && (!empty($jsonArr['device'])) && (!empty($jsonArr['deviceId']))) {
        $obj = new LoginUser();
	$rec = new Recognize();
        $analytic_obj = new AppAnalytic();

        $cid = $jsonArr["clientid"];
        //echo "clientid ".$cid."<br>";
        $uid = $jsonArr['uid'];
        $device = $jsonArr['device'];
        $deviceId = $jsonArr['deviceId'];
        $appVersion = $jsonArr['appVersion'];
        //echo "user id ".$uid;
        $response  = $obj->forceValidUserUpdation($cid, $uid);
        $userScore = $rec->recognitionLeaderboard($cid, $uid);
	if($response["success"] == 1){
	        $response['posts'][0]['totalRecognition']  = (!empty($userScore['data'][0]['totalRecognition']))?$userScore['data'][0]['totalRecognition']:"0";
		$response['posts'][0]['androidUpgradeLink']  = "https://iphone.benepik.com/bestie/androidFourceUpdate.php";
		$response['posts'][0]['iosUpgradeLink']  = "https://iphone.benepik.com/bestie/iosFourceUpdate.php";
	}
       // $response['posts'][0]['designation']  = (!empty($userScore['data'][0]['designation']))?$userScore['data'][0]['designation']:"";
        $analytic_obj->checkspalshopen($cid, $uid, $device, $deviceId, $appVersion);
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
