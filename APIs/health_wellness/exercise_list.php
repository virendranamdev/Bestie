<?php

//error_reporting(E_ALL);ini_set("display_errors", 1);

if (!class_exists('HealthWellness') && include("../../Class_Library/class_Health_Wellness.php")) {

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
      "clientId" : "CO-28",
      "empId"    : "HGLF3M0DfwFdqWP3AbWPUWA0cD03O61",
      "device"   : "",
      "deviceId"   : "",
      "value"    : "0"
      }
     */

    if ($jsonArr['clientId'] && $jsonArr['empId']) {
        $obj = new HealthWellness();
        extract($jsonArr);

        $result = $obj->getExercises($clientId, $device);
        $response['success'] = 1;
        $response['data'] = $result;
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>