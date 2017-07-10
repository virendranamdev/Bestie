<?php

//error_reporting(E_ALL ^ E_NOTICE);
if (file_exists("../../Class_Library/Api_Class/class_getAchiverStory.php") && include("../../Class_Library/Api_Class/class_getAchiverStory.php")) {
	
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
/*
{
    "clientid": "CO-28",
    "useremail" :"ameen@benepik.com",
    "userName" : "Badge20",
    "comment":"please",
    "referredBy":"Ef8xAJfyl08IsiDeSbPTplpy2y4mN2",
    "device":"2",
    "deviceId":"12345"
}
*/
    $jsonArr = json_decode(file_get_contents("php://input"), true);
    
    $obj = new AchiverStory();
	$objuser = new User();
    //print_r($jsonArr);
	
    if (!empty($jsonArr["clientid"]) && !empty($jsonArr["device"]) && !empty($jsonArr["deviceId"])) {

        extract($jsonArr);
		//print_r($jsonArr);
		$resuserdetail = $objuser->getUser($clientid, $useremail);
		
		if($resuserdetail['success'] == 1)
		{
		//print_r($resuserdetail);
		$userId = $resuserdetail['userName']['employeeId'];
		
		$res = $obj->ReferStory($userId , $userName , $comment , $referredBy);
		$resarray = json_decode($res , true);
		//print_r($resarray);
						
			$username = $resuserdetail['userName']['firstName']." ".$resuserdetail['userName']['middleName']." ".$resuserdetail['userName']['lastName'];
			
		/******** get referred by detail *****************/
		
		$referredbyuserdetailarray = $objuser->getUserDetail($clientid, $referredBy);
				
		$referredbyname = $referredbyuserdetailarray['userName']['firstName']." ".$referredbyuserdetailarray['userName']['middleName']." ".$referredbyuserdetailarray['userName']['lastName'];
		
		$referredbyemail = $referredbyuserdetailarray['userName']['emailId'];
		/************* / get referred by details *********/
			

		/*********************** mail sent to admin *************************/
		
		$to = "monikagupta05051994@gmail.com";
		$subject = 'New Colleague Story Suggestion Received';
		$bound_text = "----*%$!$%*";
        $bound = "--" . $bound_text . "\r\n";
        $bound_last = "--" . $bound_text . "--\r\n";
		
		$headers = "From: Bestie <bestie@benepik.com> \r\n";
        $headers .= "MIME-Version: 1.0\r\n" .
        "Content-Type: multipart/mixed; boundary=\"$bound_text\"" . "\r\n";
		
		$message = "\r\n" .$bound;
		
		$message .=

                        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
                        'Content-Transfer-Encoding: 7bit' . "\r\n\r\n" .
                        '

   <html>

   <body>
   <div style="width: 700;height: 500;background: white;">
   <div style="width: 700;height: 100;background: white" >
   </div >
   
   <div style="background: window;height: 420;  ">
   <div style="width: 600; ">
   <p>Dear Admin,</p>
   <p >New Colleague Story Suggestion has been Received :</p> 
    
   <p><b>Referred By : </b>'.$referredbyname.'</p>
   <p><b>Email Id : </b>'.$referredbyemail.'</p>
   <p><b>Referred To :</b>'.$username.'</p>
   <p><b>Email Id : </b>'.$useremail.'</p>
   <p><b>Comment : </b>'.$comment.'</p>
 
   <br>

   <p>Regards</p>
   <p>Team Bestie</p>
 
  
   </div>
   </div>
   
   
   </div>
   </body>
   </html>
   ' . "\n\n" .$bound_last;
   
  $adminmailres = mail($to, $subject, $message, $headers);
   
		/*********************** / mail sent to admin ***********************/
		
		if($adminmailres == 1)
		{
        $response['success'] = 1;
		$response['result'] = "Colleague Story referred successfully";
        }
		else
		{
		$response['success'] = 0;
		$response['result'] = "Colleague Story not referred";		
		}
		
		}
		else
		{
		$response['success'] = 0;
		$response['result'] = "wrong Email Id";	
		}
	}
     else {
        $response['success'] = 0;
        $response['result'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>