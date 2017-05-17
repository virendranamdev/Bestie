<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once('../Class_Library/class_clientLoginAnalytic.php');
$obj = new LoginAnalytic();
//print_r($_POST);die;
if (!empty($_POST["mydata"])) {
   $jsonArr = $_POST["mydata"];
  // echo $jsonArr;
   $data = json_decode($jsonArr, true);
  
    if (!empty($data)) {
        $client = 'CO-28';

        $fromdt1 = $data['startdate'];
        $fromdt = date("Y-m-d H:i:s", strtotime($fromdt1));
        //echo "statrt date-".$fromdt;
        $enddte1 = $data['enddate'];
        $enddte = date("Y-m-d H:i:s", strtotime($enddte1));

	$department = $data['department'];
        $location = $data['location'];
		
        // echo "end date-".$enddte;
        $result = $obj->graphGetActiveUser($client, $fromdt, $enddte , $department,$location);

        $res = json_decode($result, true);
          echo $jsonres = json_encode($res);

    }
}
?>  