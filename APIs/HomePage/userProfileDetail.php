<?php

//error_reporting(E_ALL);ini_set('display_errors', 1);

if (file_exists("../../Class_Library/class_recognize.php") && include_once("../../Class_Library/class_recognize.php")) {
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
      "clientid" : "CO-28",
      "uid"      : "2rTntXYFWWBKKfAFQn9YduqhhJ3WHf",
      "device"   : "2",
      "deviceId" : "132"
      }
     */

    if ((!empty($jsonArr["clientId"])) && (!empty($jsonArr['device'])) && (!empty($jsonArr['deviceId']))) {
        $rec = new Recognize();
        $site_url = dirname(SITE_URL). '/';
        $data = $rec->recognitionLeaderboard($jsonArr['clientId'], $jsonArr['uid'], $site_url);
        $result = $rec->recognitionLeaderboardDetail($jsonArr['clientId'], $jsonArr['uid'], $site_url);

        $response['success'] = $data['success'];
        $response['data'] = $data['data'][0];
        $response['data']['badges'] = $result['data']['badges'];
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
