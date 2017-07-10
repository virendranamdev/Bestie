<?php
@session_start();
require_once('Class_Library/class_Happiness.php');
$objHappiness = new Happiness();

if (!empty($_POST["mydata"])) {
    $jsonArr = $_POST["mydata"];
  //  echo $jsonArr;
  // print_r($jsonArr);
	
    $data = json_decode($jsonArr, true);
    
    if (!empty($data)) {
		$clientid = $data['clientid'];
      
		$fromdt1 = $data['startday'];
		$startday = date("Y-m-d", strtotime($fromdt1));
        $enddte1 = $data['enddate'];
        $enddate = date("Y-m-d", strtotime($enddte1));
	
		
	
		$department = $data['department'];
		$location = $data['location'];
		
	   
      $commentDetails = $objHappiness->getallcomment($clientid, $enddate, $startday,$department, $location);
	  $comment = json_decode($commentDetails, true);
	//  echo $commentDetails;
	 
         for($k=0;$k<count($comment);$k++)
         {
            $status = $comment[$k]['status'];
            if($status == -5)
            {
              $comment[$k]['status'] = 'Get Me Out Of Here';  
            }
            else if($status == 0)
                {
              $comment[$k]['status'] = 'So - So';  
            }
            else if($status == -5)
                {
              $comment[$k]['status'] = 'Happy';  
            }
            else
                {
              $comment[$k]['status'] = 'Fabulous';  
            }
         }
       //  print_r($comment); 
	 echo json_encode($comment);
	 /******************** for show count *************************/
	 	 
	

    }
}
?>