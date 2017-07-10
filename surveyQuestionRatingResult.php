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
     
        $result = $obj->getGraphDataforRating($qid,$sid,$department,$location);
        $res = json_decode($result , true);
  
	//print_r($res);
        $count = count($res['data']);
        $cat = array();
        $data2 = array();
        $total = 0;
        $totaluser = 0;
        $avg = 0;
        $max =  $res['data'][0]['data1'];
       $mode1 = $res['data'][0]['category'];
        for($i=0;$i<$count;$i++)
        {
            $rng = $res['data'][$i]['category'];
            $val = $res['data'][$i]['data1'];
            if($rng == 1)
            {
                $cat = 1;
                $count = $val;
                
            }
            else if($rng == 2)
            {
                 $cat = 2;
                $count = $val;
            }
             else if($rng == 3)
            {
                 $cat = 3;
                $count = $val;
            }
             else if($rng == 4)
            {
                 $cat = 4;
                $count = $val;
            }
             else if($rng == 5)
            {
                 $cat = 5;
                $count = $val;
            }
            array_push($cat, $res['data'][$i]['category']);
            array_push($data2, $res['data'][$i]['data1']);
            $total = $total+($res['data'][$i]['category'] * $res['data'][$i]['data1']);
            $totaluser += $res['data'][$i]['data1'];
            if($res['data'][$i]['data1']>$max)
            {
                $max = $res['data'][$i]['data1'];
                $mode1 = $res['data'][$i]['category'];
            }
           
        }
        $avg = ($total/$totaluser);
        $res['category'] = $cat;
        $res['data3'] = $data2;
        $res['average'] = array($avg);
        $res['mode'] = array($mode1);
       echo $jsonres = json_encode($res);
       // echo $res;
	

       //echo $result;
    }
}
?>