<?php

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);
if (file_exists("../../Class_Library/class_upload_album.php") && include("../../Class_Library/class_upload_album.php")) {

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


    /*
    $json = '{
      "clientid" : "CO-28",
      "uuid" : "Ef8xAJfyl08Is564y7u8dsssgd",
      "catId" : "11",
      "albumid" : "Album-2",
      "device" : "2",
      "deviceId" : "132132"
      }';
  	*/   

//     $json = file_get_contents("php://input");
//	print_r($_POST['json']);    print_r($_FILES['albumImage']);	die;

//    $jsonArr = json_decode($json, true);
    $jsonArr = json_decode(file_get_contents("php://input"), true);
    //  albumImage input for add album images

    if (!empty($jsonArr['clientid'])) {
//        $obj = new AlbumAPI();
        $uploader = new Album();
        extract($jsonArr);

        date_default_timezone_set('Asia/Kolkata');
        $Post_Date = date('Y-m-d H:i:s');

        if (!empty($_FILES['albumImage'])) {
//            $file_name = $_FILES['myFile']['name'];
//            $file_size = $_FILES['myFile']['size'];
//            $file_type = $_FILES['myFile']['type'];
//            $temp_name = $_FILES['myFile']['tmp_name'];
//
//            $location = base_path . "/VideoUploads/" . $file_name;
//            $response['success'] = '1';
//            if (!move_uploaded_file($temp_name, $location)) {
//                $response['msg'] = "Upload Failed";
//            } else {
//                $response['msg'] = "Upload Successful";
//            }
//        }
//        print_r($_FILES['album']);die;

        $albumDetail = json_decode($uploader->getAlbumImage($albumid, $catId, 'device'), true);

//        print_r($albumDetail);die;
        $albumtitle = $albumDetail['album'][0]['title'];
        $imageCaption = '';
        $status = 2;

        $k = $_FILES['albumImage']['name'];
//        print_r(sizeof($k));die;
        $countfiles = sizeof($k);
        $target_dir = dirname(BASE_PATH) . "/upload_album/";
        $target_db = "upload_album/";
        for ($i = 0; $i < $countfiles; $i++) {
            $albumThumbImg = $catId . '-' . $albumid . "-" . time() . basename($_FILES["albumImage"]["name"][$i]);
            $target_file1 = $target_db . $catId . '-' . $albumid . "-" . time() . basename($_FILES["albumImage"]["name"][$i]);
            $target_file = $target_dir . $catId . '-' . $albumid . "-" . time() . basename($_FILES["albumImage"]["name"][$i]);
            $caption = "";
//            echo $target_file;die;
//            $imageCaption = $_POST['imageCaption'][$i];
            $temppath = $_FILES["albumImage"]["tmp_name"][$i];
            $res = $uploader->compress_image($temppath, $target_file, 20);
            //$thumb_image = $push->makeThumbnails($target_dir, $albumThumbImg, 20);
            //$thumb_img = str_replace('../', '', $thumb_image);
            $thumb_img = '';
            $imgupload = $uploader->saveImage($albumid, $target_file1, $albumtitle, $thumb_img, $imageCaption, $uuid, $Post_Date, $status);
        }

        $response['success'] = 1;
        $response['result'] = "Image Upload successfully";
}
//            $result['success'] = 0;
//            $result['result'] = "Image Upload successfull";
    } else {
        $result['success'] = 0;
        $result['result'] = "Invalid json";

        $response = $result;
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
