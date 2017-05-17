<?php

require_once('../Class_Library/class_analyticActiveUser.php');
$obj = new ActiveUserAnalytic();

if (!empty($_POST["mydata"])) {
   $jsonArr = $_POST["mydata"];
 //   echo $jsonArr;
   $data = json_decode($jsonArr, true);
  
    if (!empty($data)) {
        $client = 'CO-28';

        $fromdt1 = $data['startdate'];
        $fromdt = date("Y-m-d H:i:s", strtotime($fromdt1));
        //echo "statrt date-".$fromdt;
        $enddte1 = $data['enddate'];
        $enddte = date("Y-m-d H:i:s", strtotime($enddte1));
       $location = $data['location'];
        // echo "end date-".$enddte;
        $result = $obj->graphAnalyticActiveUser($client, $fromdt, $enddte,$location);

        $res = json_decode($result, true);
          echo $jsonres = json_encode($res);

    }
}
?>  