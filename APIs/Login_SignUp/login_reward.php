<?php
error_reporting(E_ALL);ini_set('display_errors', 1);

if (!class_exists('LoginUser') && include("../../Class_Library/Api_Class/class_employee_app_login.php")) {

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

    if (!empty($jsonArr)) {
        extract($jsonArr);
        $obj = new LoginUser();

        $amount = 100;
        $now = time();
        $data = $obj->checkUserEntry($packageName, $employeeId, $device);
        $loginDate=3;
        if (!empty($data)) {
            $loginDate = round(abs($now-strtotime($data['dateEntry']))/86400);
        } else {
            date_default_timezone_set('Asia/Kolkata');
            $login_date = date('Y-m-d H:i:s');
            $loginDate = round(abs($now-strtotime($login_date))/86400);
            $obj->entryUserLogin($packageName, $employeeId, $device);
            $obj->loginReward($client_id, $employeeId, $amount, $login_date, $device);
        }

        if ($loginDate <= 2) {
            $response['success'] = 1;
            $response['message'] = "Congratulations. You have received ".$amount." points on your first login.";
            $response['balance'] = $amount;
        } else {
            $response['success'] = 0;
            $response['message'] = "Login reward not available";
        }
        
    } else {
        $response['success'] = 0;
        $response['message'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
