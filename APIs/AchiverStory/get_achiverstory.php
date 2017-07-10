<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
if (file_exists("../../Class_Library/Api_Class/class_getAchiverStory.php") && include("../../Class_Library/Api_Class/class_getAchiverStory.php")) {

      require_once('../../Class_Library/Api_Class/class_AppAnalytic.php');
    
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
	/*{
		"clientid":"CO-28",
		"uid":"HGLF3M0DfwFdqWP3AbWPUWA0cD03O61",
		"value":0,
		"device":"2",
		"deviceId":"12345"
	}*/
	//print_r($jsonArr);
    if (!empty($jsonArr['clientid']) && !empty($jsonArr['device']) && !empty($jsonArr['deviceId'])) 
	{
        $obj = new AchiverStory();
         $analytic_obj = new AppAnalytic();
        extract($jsonArr);

        $flagtype = 16;
        $response = $obj->AchiverStoryDisplay($clientid,$uid,$value);
        
        /************* analytic purpose seve data *****************/
         $analytic_obj->listAppview($clientid, $uid, $device, $deviceId, $flagtype);
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    
    header('Content-type: application/json');
   echo json_encode($response);
	
}
?>