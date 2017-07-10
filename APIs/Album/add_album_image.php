<?php

error_reporting(E_ALL ^ E_NOTICE);ini_set('display_errors', 1);

if (file_exists("../../Class_Library/class_upload_album.php") && include("../../Class_Library/class_upload_album.php")) {
    include_once("../../Class_Library/class_user.php");
    date_default_timezone_set('Asia/Kolkata');
    $Post_Date = date('Y-m-d H:i:s');
    $uploader = new Album();
    $user     = new User();
    if (!empty($_POST['clientid']) && (!empty($_POST['uuid'])) && (!empty($_POST['device'])) && (!empty($_POST['deviceId'])) && (!empty($_FILES['albumImage']))) {
        extract($_POST);

        if (!empty($_FILES['albumImage'])) {
            $albumDetail = json_decode($uploader->getAlbumImage($albumid, 'device'), true);

            $albumtitle = $albumDetail['album'][0]['title'];
            $categoryName = $albumDetail['album'][0]['categoryName'];
            $imageCaption = '';
            $status = 2;

            $k = str_replace(" ", "_", $_FILES['albumImage']['name']);

            $countfiles = sizeof($k);

            $target_dir = dirname(BASE_PATH) . "/upload_album/";
            $target_db = "upload_album/";
//        for ($i = 0; $i < $countfiles; $i++) {  // Multiple image loop
            $albumThumbImg = $catId . '-' . $albumid . "-" . time() . basename($k);
            $target_file1 = $target_db . $catId . '-' . $albumid . "-" . time() . basename($k);
            $target_file = $target_dir . $catId . '-' . $albumid . "-" . time() . basename($k);
            $caption = "";

//            $imageCaption = $_POST['imageCaption'][$i];
            $temppath = $_FILES["albumImage"]["tmp_name"];
            $res = $uploader->compress_image($temppath, $target_file, 20);
            //$thumb_image = $push->makeThumbnails($target_dir, $albumThumbImg, 20);
            //$thumb_img = str_replace('../', '', $thumb_image);
            $thumb_img = '';

            if ($device == 2) {
            	if(($first == 1) || ($first == '1')) {
			$maxBundleId = $uploader->maxbundleId();
			$maxBundleId = $maxBundleId+1;
	    	} else {
	    		$maxBundleId = $uploader->maxbundleId();
	    	}
                $imgupload = $uploader->saveImage($albumid, $target_file1, $albumtitle, $thumb_img, $imageCaption, $uuid, $Post_Date, $status, $maxBundleId);
            }
//        }
	    if(!empty($count)){
	    	    $userData = $user->getUserDetail($clientid, $uuid);
		    $userDetails  = $userData['userName'];
		    
		    //$to1 = 'sau_org@yahoo.co.in';
		    $to1 = 'gsingh21509@gmail.com';
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
            $response['result']  = "Image submitted  successfully to admin for approval";
        }
    } else if (!empty($_FILES['albumImage'])) {
        $catId = '';
        $albumid = '';
        $uuid = '';
        $albumtitle = '';
        $imageCaption = '';
        $status = 2;
        $target_dir = dirname(BASE_PATH) . "/upload_album/";
        $target_db = "upload_album/";


        $k = str_replace(" ", "_", $_FILES['albumImage']['name']);

        $countfiles = sizeof($k);

        $target_dir = dirname(BASE_PATH) . "/upload_album/";
        $target_db = "upload_album/";
//        for ($i = 0; $i < $countfiles; $i++) {  // Muliple image loop
        $albumThumbImg = time() . basename($k);
        $target_file1 = $target_db . time() . basename($k);
        $target_file = $target_dir . time() . basename($k);
        $caption = "";
//            echo $target_file;die;
//            $imageCaption = $_POST['imageCaption'][$i];
        $temppath = $_FILES["albumImage"]["tmp_name"];
        $res = $uploader->compress_image($temppath, $target_file, 20);
        //$thumb_image = $push->makeThumbnails($target_dir, $albumThumbImg, 20);
        //$thumb_img = str_replace('../', '', $thumb_image);
        $thumb_img = '';

        $imgupload = $uploader->saveImage($albumid, $target_file1, $albumtitle, $thumb_img, $imageCaption, $uuid, $Post_Date, $status);

        $response['success'] = 1;
        $response['result'] = "Image submitted  successfully to admin for approval";
        $response['id'] = $imgupload;
    } else {
        $response['success'] = 0;
        $response['result'] = "Invalid params";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
