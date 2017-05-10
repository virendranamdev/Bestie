<?php

require_once('Class_Library/class_Happiness.php');
$objHappiness = new Happiness();

if (!empty($_POST["mydata"])) {
    $jsonArr = $_POST["mydata"];
   // echo $jsonArr;
    //print_r($jsonArr);
	
    $data = json_decode($jsonArr, true);
    //print_r($data);

    if (!empty($data)) {
		$clientid = $data['clientid'];
        $enddate = $data['enddate'];
        $startday = $data['startday'];
        $department = $data['department'];
		$HappinessVal = $data['HappinessVal'];
       
       // $result = $obj->topRecognizeUser($client, $fromdt, $enddte, $imgpath);
   
			
			//echo $jsonres = $result;
			
    }
}
?>