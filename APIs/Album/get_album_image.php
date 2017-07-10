<?php

error_reporting(E_ALL ^ E_NOTICE);
if (file_exists("../../Class_Library/Api_Class/class_album.php") && include("../../Class_Library/Api_Class/class_album.php")) {

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
     "aid":"Album-1",
	 "categoryid" : "1",
	 "uid":"HGLF3M0DfwFdqWP3AbWPUWA0cD03O61",
	 "device":"2",
	 "deviceId":"12345"
}*/
    if (!empty($jsonArr['clientid']) && !empty($jsonArr['uid']) && !empty($jsonArr['device']) && !empty($jsonArr['deviceId']) && !empty($jsonArr['categoryid'])) {
        $obj = new AlbumAPI();

        extract($jsonArr);
        $response = $obj->getAlbumImage($aid);
    } else {
        $result['success'] = 0;
        $result['result'] = "Invalid json";

        $response = json_encode($result);
    }
    header('Content-type: application/json');
    echo $response;
}
?>