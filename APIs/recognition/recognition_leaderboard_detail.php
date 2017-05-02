<?php

error_reporting(0);
//ini_set('display_errors', 1);

if (!class_exists("Family") && include_once("../../Class_Library/Api_Class/class_family.php")) {
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
    if ((!empty($jsonArr["clientId"])) && (!empty($jsonArr['device'])) && (!empty($jsonArr['deviceId']))) {
        $fam = new Family();
        $obj = new Recognize();

        extract($jsonArr);
        $result = $fam->getUserDetails($clientId, $employeeid);

        if ($result['success'] == 1) {       
            $response = $obj->recognitionLeaderboardDetail($clientId, $employeeid);
            $response['user_image'] = $result['UserDetails']['userImage'];
	    $response['username'] = ($result['UserDetails']['lastName'] !='')?$result['UserDetails']['firstName'].' '.$result['UserDetails']['lastName']:$result['UserDetails']['firstName'];
            
            $leader = $employeeid;
            $data = $fam->getRecognisedUser($clientId, $employeeid, $val, $leader);
            unset($data['success']);unset($data['message']);
            
            $response['recognition'] = $data;
        }
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
