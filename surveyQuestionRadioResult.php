<?php
//error_reporting(E_ALL); ini_set('display_errors', 1); 
require_once('Class_Library/class_MiniSurvey.php');
$obj = new MiniSurvey();

if (!empty($_POST["mydata"])) 
    {
     $jsonArr = $_POST["mydata"];
  // echo $jsonArr;
   $data = json_decode($jsonArr, true);
 
    if (!empty($data)) {  
        $qid =  $data['questionid'];
        $sid =  $data['surveyid'];
         $department =  $data['department'];
          $location =  $data['location'];
     
        $result = $obj->getGraphDataforRadio($qid,$sid,$department,$location);
        $res = json_decode($result , true);
  
		
       echo $jsonres = json_encode($res);
       // echo $res;
	

       //echo $result;
    }
}
?>