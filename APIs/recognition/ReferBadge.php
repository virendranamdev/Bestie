<?php

//error_reporting(E_ALL ^ E_NOTICE);
if (file_exists("../../Class_Library/class_recognize.php") && include("../../Class_Library/class_recognize.php")) {
	
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

    $jsonArr = json_decode(file_get_contents("php://input"), true);
    
    $obj = new Recognize();
	$objuser = new User();
    //print_r($jsonArr);
	
    if (!empty($jsonArr["clientid"]) && !empty($jsonArr["device"]) && !empty($jsonArr["deviceId"])) {

        extract($jsonArr);
		$res = $obj->ReferBudge($badgeName , $comment , $referredBy);
		$resarray = json_decode($res , true);
		if($resarray)
		{
			$resuserdetail = $objuser->getUserDetail($clientid, $referredBy);
			//print_r($resuserdetail);
			
			$username = $resuserdetail['userName']['firstName']." ".$resuserdetail['userName']['middleName']." ".$resuserdetail['userName']['lastName'];
			
			$usermail = $resuserdetail['userName']['emailId'];
			

		/*********************** mail sent to admin *************************/
		
		$to = "monikagupta05051994@gmail.com";
		$fromEmail = 'support@mybestie.in';
		$subject = 'New Badge Suggestion at Bestie';
		$bound_text = "----*%$!$%*";
        $bound = "--" . $bound_text . "\r\n";
        $bound_last = "--" . $bound_text . "--\r\n";
		
		$headers = "From: Bestie <".$fromEmail.">"."\r\n"."Return-Path: ".$fromEmail."\r\n";
		//$headers = "From: Bestie <support@mybestie.in> \r\n";
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
   <p >A New Badge suggestion is submitted at Bestie</p> 
    
   <p><b>Name: </b>'.$username.'</p>
   <p><b>Email Id: </b>'.$usermail.'</p>
   <p><b>Suggested Badge : </b>'.$badgeName.'</p>
   <p><b>Comments : </b>'.$comment.'</p>
 
   <br>

   <p>Regards,</p>
   <p>Team Bestie</p>
 
  
   </div>
   </div>
   
   
   </div>
   </body>
   </html>
   ' . "\n\n" .$bound_last;
   
  $adminmailres = mail($to, $subject, $message, $headers, '-f '.$fromEmail);
   
		/*********************** / mail sent to admin ***********************/
		
		/*******************************************************************/
		
		$to1 = $usermail;
		$fromEmail1 = 'support@mybestie.in';
		$subject1 = 'New badge Suggestion Submitted';
		$bound_text1 = "----*%$!$%*";
        $bound1 = "--" . $bound_text1 . "\r\n";
        $bound_last1 = "--" . $bound_text1 . "--\r\n";
		
		$headers1 = "From: Bestie <".$fromEmail1.">"."\r\n"."Return-Path: ".$fromEmail1."\r\n";
		//$headers1 = "From: Bestie <support@mybestie.in> \r\n";
        $headers1 .= "MIME-Version: 1.0\r\n" .
        "Content-Type: multipart/mixed; boundary=\"$bound_text1\"" . "\r\n";
		
		$message1 = "\r\n" .$bound1;
		
		$message1 .=

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
   <p>Dear '. $username .'</p>
   <p >Thanks for submitting a New Badge suggestion.</p> 
    <p>For your reference, here is a copy of your message:</p>
   <p><b>New badge name: </b>'.$badgeName.'</p>
   <p><b>Comments : </b>'.$comment.'</p>
 
   <br>

   <p>Regards,</p>
   <p>Team Bestie</p>
 
  
   </div>
   </div>
   
   
   </div>
   </body>
   </html>
   ' . "\n\n" .$bound_last1;
   
   mail($to1, $subject1, $message1, $headers1, '-f '.$fromEmail1);
		
		/*******************************************************************/
		
		
		/*********************** send mail to benepik *************************/
		
		$to2 = "support@mybestie.in , info@benepik.com , sau_org@yahoo.co.in";              // benepik
		$fromEmail2 = 'support@mybestie.in';
		$subject2 = 'New Badge Suggestion at Bestie.';
		$bound_text2 = "----*%$!$%*";
        $bound2 = "--" . $bound_text2 . "\r\n";
        $bound_last2 = "--" . $bound_text2 . "--\r\n";
		
		$headers2 = "From: Bestie <".$fromEmail2.">"."\r\n"."Return-Path: ".$fromEmail2."\r\n";
		//$headers = "From: Bestie <support@mybestie.in> \r\n";
        $headers2 .= "MIME-Version: 1.0\r\n" .
        "Content-Type: multipart/mixed; boundary=\"$bound_text2\"" . "\r\n";
		
		$message2 = "\r\n" .$bound2;
		
		$message2 .=

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
   
   <p >A New Badge suggestion is submitted at Bestie</p> 
    
   <p><b>Name: </b>'.$username.'</p>
   <p><b>Email Id: </b>'.$usermail.'</p>
   <p><b>Suggested Badge : </b>'.$badgeName.'</p>
   <p><b>Comments : </b>'.$comment.'</p>
 
   <br>

   <p>Regards,</p>
   <p>Team Bestie</p>
 
  
   </div>
   </div>
   
   
   </div>
   </body>
   </html>
   ' . "\n\n" .$bound_last2;
   
  $mailres2 = mail($to2, $subject2, $message2, $headers2, '-f '.$fromEmail2);
		
		
		/************************ / send mail to benepik ***********************/
		
		if($adminmailres == 1)
		{
        $response['success'] = 1;
		$response['result'] = "New Badge referred successfully";
        }
		else
		{
		$response['success'] = 0;
		$response['result'] = "Badge not referred";		
		}
		
		}
		else
		{
		$response['success'] = 0;
		$response['result'] = "Badge not referred";	
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