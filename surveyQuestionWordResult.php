<?php
require_once('Class_Library/class_MiniSurvey.php');
require_once('Class_Library/class_Feedback.php');
$objFeed = new Feedback();
$obj = new MiniSurvey();

if (!empty($_POST["mydata"])) 
    {
     $jsonArr = $_POST["mydata"];
   
   $data = json_decode($jsonArr, true);
 
    if (!empty($data)) {  
        $qid =  $data['questionid'];
        $sid =  $data['surveyid'];
     
        $result = $obj->getGraphDataforWord($qid,$sid);
        $res = json_decode($result , true);
       // print_r($res);
		
      //     echo $jsonres = json_encode($res);
       
       $commentdata = $res['data'];
      // print_r($commentdata);
       
       
       $comments = '';
        foreach ($commentdata as $wordData) {
            $comments .= ' /// ' . $wordData['comment'];
        }
      
	
 $words = json_decode($objFeed->extractCommonWords($comments), true);

        $fieldnames_actual = array();
        $values = array();

        foreach ($words as $k => $v) {
            if ($k != 'fieldnames') {
                $fieldnames_actual[] = $k;
                $values[] = $v;
            }
        }
      
        //    echo'<pre>';        print_r($fieldnames_actual);        print_r($values);
        
       
                            $i = 0;
                            $globeGraph = array();
                            $textGraph = array();
                            while ($i < sizeof($words)) {
                               
                                $textGraph['text'] = $fieldnames_actual[$i];
                                $textGraph['size'] = $values[$i]*10;

                                $i++;
                                array_push($globeGraph, $textGraph);
                            }
                          
    }
    echo json_encode($globeGraph);
}
?>