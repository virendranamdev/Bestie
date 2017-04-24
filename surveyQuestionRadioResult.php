<?php
require_once('Class_Library/class_MiniSurvey.php');
$obj = new MiniSurvey();

if (!empty($_POST["mydata"])) 
    {
     $jsonArr = $_POST["mydata"];
   
   $data = json_decode($jsonArr, true);
 
    if (!empty($data)) {  
        $qid =  $data['questionid'];
        $sid =  $data['surveyid'];
     
        $result = $obj->getGraphDataforRadio($qid,$sid);
        $res = json_decode($result , true);
  
		
       echo $jsonres = json_encode($res);
       // echo $res;
	

       // echo $result;
    }
}
?>