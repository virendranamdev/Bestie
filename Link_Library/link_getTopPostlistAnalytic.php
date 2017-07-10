<?php

require_once('../Class_Library/class_getTopPostAnalytic.php');
$obj = new TopPostAnalytic();
if (!empty($_POST["mydata"])) 
    {
   $jsonArr = $_POST["mydata"];
  //  echo $jsonArr;
   $data = json_decode($jsonArr, true);
  
    if (!empty($data)) {
        $client = 'CO-28';
        $fromdt1 = $data['startdate'];
        $fromdt = date("Y-m-d H:i:s", strtotime($fromdt1));
        $enddte1 = $data['enddate'];
        $enddte = date("Y-m-d H:i:s", strtotime($enddte1));
        $department = $data['department'];
        $location = $data['location'];
        $result = $obj->getViewListAnalytic($client, $fromdt, $enddte,$department,$location);
        //$data = json_decode($result,true);
       // $count = count($data);
		echo $result;
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