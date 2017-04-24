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
     
        $result = $obj->getGraphDataforEmoji($qid,$sid);
        $res = json_decode($result , true);
      //  print_r($res1);
        for ($i = 0; $i < count($res['data']); $i++) 
        {
            $user = $res['data'][$i]['name'];
           // echo  $user;
            if ($user == 10) {
                $user = 'Overwhelming';
            }
            elseif($user == -5)
            {
                $user = 'Sad';
            } 
            elseif($user == 5)
            {
                $user = 'Good';
            } 
                else {  
                $user = "It's Ok";
            }
            $res['data'][$i]['name'] = $user;
        }
		
       echo $jsonres = json_encode($res);
       // echo $res;
	

       // echo $result;
    }
}
?>