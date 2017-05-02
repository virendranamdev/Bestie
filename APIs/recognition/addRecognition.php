<?php

//error_reporting(E_ALL);ini_set('display_errors', 1);

if (!class_exists("Family") && include("../../Class_Library/Api_Class/class_family.php")) {
    include_once ('../../Class_Library/class_get_group.php');
    include_once ('../../Class_Library/class_reading.php');
    include_once ('../../Class_Library/class_welcomeTable.php');

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
    $obj = new Family();
    $obj_group = new Group();                  //class_get_group.php
    $read = new Reading();                    //   class_reading.php 
    $welcome_obj = new WelcomePage();

    if ((!empty($jsonArr["clientId"])) && (!empty($jsonArr['device'])) && (!empty($jsonArr['deviceId']))) {
        extract($jsonArr);
        if (strtolower($mesg) != $obj->filterWords($mesg)) {
            $response['success'] = 0;
            $response['message'] = "Your Comment contains inappropriate language";
        } else {
            $result = $obj->getUserDetail($clientId, $recognitionby);
            if ($result['success'] == 1) {
                $rzid = $obj->maxIdRecognition($clientId);
                $response = $obj->insertUserRecognition($clientId, $recognitionto, $recognitionby, $topicId, $recognizeTitle, $mesg, $points);

                $type = 'Recognition';
                $text = '';
                $image = '';
                date_default_timezone_set('Asia/Kolkata');
                $post_date = date('Y-m-d, H:i:s');
                $FLAG = '10';
                $result1 = $welcome_obj->createWelcomeData($clientId, $rzid, $type, $text, $image, $post_date, $recognitionby, $FLAG);


                /*                 * ************************* find group **************************** */
                $result = $obj_group->getGroup($clientId);
                $value = json_decode($result, true);
                $getcat = $value['posts'];

                $wholegroup = array();
                foreach ($getcat as $groupid) {
                    array_push($wholegroup, $groupid['groupId']);
                }

                $groupcount = count($wholegroup);
                for ($k = 0; $k < $groupcount; $k++) {
                    $result1 = $read->recognizeSentToGroup($clientId, $rzid, $wholegroup[$k]);
                }
                unset($response['rcid']);
            }
        }
    } else {
        $response['success'] = 0;
        $response['message'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>