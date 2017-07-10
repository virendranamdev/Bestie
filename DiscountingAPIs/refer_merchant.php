<?php

error_reporting(0);
//ini_set('display_errors', 1);

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

include_once("../Class_Library/Api_Class/class_sentToAdmin.php");
include_once("../Class_Library/Api_Class/class_messageSentTo.php");

$mesg = new messageSent();           //class_messageSentTo.php
$obj = new MessagesToAdmin();   //class_sentToAdmin.php

$jsonArr = json_decode(file_get_contents("php://input"), true);

/* {
  "mname":"ameen"
  "email":"gagandeep@benepik.com",
  "mloc":"gurgaon",
  "mob":"98630",
  "msg":"nice merchant",
  "clientid":"CO-22",
  "empid":""
  } */
//print_r($jsonArr);die;
if (!empty($jsonArr)) {
    $mname = $jsonArr['mname'];
    $mloc = $jsonArr['mloc'];
    $mob = $jsonArr['mob'];
    $message = $jsonArr['msg'];
    $clientid = $jsonArr['clientid'];
    $employeeid = $jsonArr['empid'];


    $result = $obj->referMerchant($clientid, $employeeid);

    if ($result['success'] == 1) {
        $mail = $result['mailid'];
	// $mail = "monikagupta05051994@gmail.com";
        $name = $result['name'];
        $progn = $result['progName'];
        $dedi = $result['dedicatedEmail'];
        $contact = $result['contact'];

        $sub = "Merchant Reference Received";
        $msg.="Dear " . $name . ",";
        $msg.="<br/><br/>";
        $msg.="<br/>Thank you for providing merchant reference to Bestie. We will soon contact the merchant for potential tie up.";
        $msg.="<br/><br/>";
        $msg.="<br/>For your information, here is a copy of your message:";
        $msg.="<br/><br/>";
        $msg.="<br/>Merchant Name : " . $mname;
        $msg.="<br/>Merchant Location : " . $mloc;
        $msg.="<br/>Contact Number : " . $mob;
        $msg.="<br/>Comment : " . $message;
        $msg.="<br/><br/><br/>";
        $msg.="Regards, <br/> Team Bestie";

        $from = "From: Bestie <support@mybestie.in>";

        if ($mail != "") {
            $mesg->forMail($mail, $sub, $msg, $from);
        }

        $sub2 = "Merchant referred on Bestie ";

        // $adminMailid = "Bestie <monikagupta05051994@gmail.com>";
	$adminMailid = "Bestie <saurabh.jain@benepik.com>,<sau_org@yahoo.co.in>,<support@mybestie.in>,<info@benepik.com>,<gagandeep@benepik.com>";
        
        $msg2.="Email id: - " . $mail . "<br/>";
        $msg2.="Merchant Name : " . $mname;
        $msg2.="<br/>Merchant Location : " . $mloc;
        $msg2.="<br/>Contact Number : " . $mob;
        $msg2.="<br/>Comments : " . $message;

        $msg2.="<br/><br/><br/>";
        $msg2.="Regards, <br/> Team Bestie";

        $from = "From: Bestie <support@mybestie.in>";

        $mesg->forMailToSir($adminMailid, $sub2, $msg2, $from);
    }

    header('Content-type: application/json');
    echo json_encode($result);
}
?>
