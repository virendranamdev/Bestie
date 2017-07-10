<?php

require_once('../Class_Library/class_clientLoginAnalytic.php');
$obj = new LoginAnalytic();

if (!empty($_POST["mydata"])) {
   $jsonArr = $_POST["mydata"];
  //  echo $jsonArr;
   $data = json_decode($jsonArr, true);
   //print_r($data);
    if (!empty($data)) {
        $client = 'CO-28';

        $fromdt1 = $data['startdate'];
        $fromdt = date("Y-m-d H:i:s", strtotime($fromdt1));
     //   echo "statrt date-".$fromdt;
        $enddte1 = $data['enddate'];
        $enddte2 = date("Y-m-d", strtotime($enddte1));
        $enddte = date_create($enddte2,"Y-m-d 23:59:59");
echo "end date".$enddte;
		$department = $data['department'];
		
     //   echo "end date-".$enddte;
        $result = $obj->graphGetHappinessIndex($client, $fromdt, $enddte , $department);
        $res = json_decode($result, true);
	
		$resultcount = $obj->graphGetHappinessIndexcount($client, $fromdt, $enddte , $department);
        $rescount = json_decode($resultcount, true);
		 //print_r($res);
		 
           for ($i = 0; $i < count($res['data']); $i++) 
        {
            $user = $res['data'][$i]['name'];
           // echo  $user;
            if ($user == 10) {
                $user = 'Fabulous';
            }
            elseif($user == -5)
            {
                $user = 'Get Me Out Of Here';
            } 
            elseif($user == 5)
            {
                $user = 'Happy';
            } 
                else {  
                $user = "So - So";
            }
            $res['data'][$i]['name'] = $user;
        }
		
		
		
		
		$arraycomplete = array();
		$arraycomplete['totalcomment'] = $rescount['totalhappresponse'];
		$arraycomplete['arrdata'] = json_encode($res);
		
		//print_r($arraycomplete);
		
 //echo $jsonres = json_encode($res);
 echo $jsonres = json_encode($arraycomplete);
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