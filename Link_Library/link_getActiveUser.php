<?php

require_once('../Class_Library/class_clientLoginAnalytic.php');
$obj = new LoginAnalytic();

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

        // echo "end date-".$enddte;
        $result = $obj->graphGetActiveUser($client, $fromdt, $enddte);

        $res = json_decode($result, true);
          echo $jsonres = json_encode($res);

    }
}
?>  