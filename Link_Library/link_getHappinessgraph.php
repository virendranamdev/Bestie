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
        $enddte = date("Y-m-d H:i:s", strtotime($enddte1));

     //   echo "end date-".$enddte;
        $result = $obj->graphGetHappinessIndex($client, $fromdt, $enddte);

        $res = json_decode($result, true);
         
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
 echo $jsonres = json_encode($res);
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