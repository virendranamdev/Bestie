<?php

require_once('../Class_Library/class_recognizeAnalytic.php');
$obj = new RecognizeAnalytic();

if (!empty($_POST["mydata"])) 
    {
   $jsonArr = $_POST["mydata"];
    
   $data = json_decode($jsonArr, true);
  
 // print_r($data);
  //die;
    if (!empty($data)) {
        $client = 'CO-28';

        $fromdt1 = $data['startdate'];
        $fromdt = date("Y-m-d H:i:s", strtotime($fromdt1));
     //   echo "statrt date-".$fromdt;
        $enddte1 = $data['enddate'];
        $enddte = date("Y-m-d H:i:s", strtotime($enddte1));
         $department = $data['department'];
		 $location = $data['location'];
     
        $result = $obj->getRecognizedUser($client, $fromdt, $enddte,$department , $location);

       
 echo $jsonres = $result;
    }
}
else
{
?>  
<form method="post" action="">
    <input type="text" name="mydata" value="">
    <input type="submit" name="submit">
</form>
<?php
}
?>