<?php

error_reporting(E_ALL);ini_set('display_errors', 1);

if (file_exists("../../Class_Library/class_upload_album.php") && include_once("../../Class_Library/class_upload_album.php")) {
    include_once("../../Class_Library/class_user.php");
    
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

//    $json = '{
//                "id"      : "45",
//                "uid"     : "Ef8xAJfyl08Is564y7u8dsssgd",
//                "albumId" : "Album-7",
//		  "count"   : ""
//            }';

    $jsonArr = json_decode(file_get_contents("php://input"), true);

    if ((!empty($jsonArr["clientid"])) && (!empty($jsonArr['device'])) && (!empty($jsonArr['deviceId']))) {
        extract($jsonArr);
        $uploader = new Album();
	$user	  = new User();

        $albumDetail = json_decode($uploader->getAlbumImage($albumid), true);
        $albumtitle = $albumDetail['album'][0]['title'];
        $categoryName = $albumDetail['album'][0]['categoryName'];
	if(($first == 1) || ($first == '1')) {
		$maxBundleId = $uploader->maxbundleId();
		$maxBundleId = $maxBundleId+1;
    	} else {
    		$maxBundleId = $uploader->maxbundleId();
    	}
        if ($uploader->updateAlbumImageContent($id, $albumid, $maxBundleId, $uid, $albumtitle) == true) {
	    if(!empty($count)){
	            $userData = $user->getUserDetail($clientid, $uid);
		    $userDetails  = $userData['userName'];
	     		
	     	    /*
		    $to = 'gsingh21509@gmail.com';
		    $subject = "Image Upload notification";
		    
		    $message = "<html>";
		    $message = "<body>";
		    $message .= "Dear Admin </br>";
		    $message .= "A user has uploaded ".$count." images in ".$albumtitle." for ".$categoryName." category.<br>";
		    $message .=  "Name : "$userDetails['firstName'] . ' ' . (!empty($userDetails['lastName'])).' '?$userDetails['lastName']:''.$userDetails['lastName'] . "</br> Department : ".$userDetails['department'];
		    $message .= "</br> Designation : ".$userDetails['designation'];
		    $message .= "</br> Location    : ".$userDetails['location'];
		    $message .= "Regards <br>";
		    $message .= "Team Benepik";
		    $message .= "</body>";
		    $message .= "</html>";
		    
		    mail($to, $subject, $message);
		    */
		    
		    $to1 = 'sau_org@yahoo.co.in';
			//$to1 = 'monikagupta05051994@gmail.com';
		    //$to1 = 'gsingh21509@gmail.com';
                    $subject1 = "Bestie Image upload reminder";

                    $message = '<html><body>';
//$message .= "<h6>Dear ".$val['firstName'].", </h6>";
                    $message .= "Dear Admin,";
                    $message .= "<p>You have received a request to approve <b>".$count."</b> images in <b>".$albumtitle."</b> associated with <b>".$categoryName."</b> category.</p>";
                    
                    $message .= "<p><b>Name </b> : ".$userDetails['firstName'] ." ".$userDetails['lastName'] . "</p>";
                    $message .= "<p><b>Email Id </b> : ".$userDetails['emailId']."</p>";
                    $message .= "<p><b>Location </b>: ".$userDetails['location']."</p>";
                    $message .= "<p><b>Department </b>: ".$userDetails['department']."</p>";
                    $message .= "<p><b>Designation </b> : ".$userDetails['designation']."</p>";
                    
                    $message .= "<p>Regards,</p>";
                    $message .= "<p>Team Bestie</p>";
                    $message .= '</body></html>';

                    $headers1 = "From: Bestie <bestie@benepik.com> \r\n";
                    $headers1 .= "MIME-Version: 1.0\r\n";
                    $headers1 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                    mail($to1, $subject1, $message, $headers1);
                    
            }
            $response['success'] = 1;
            $response['result'] = 'Image submitted  successfully to admin for approval';
        }
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid params";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
