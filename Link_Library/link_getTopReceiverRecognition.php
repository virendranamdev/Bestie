<?php

require_once('../Class_Library/class_recognizeAnalytic.php');
$obj = new RecognizeAnalytic();

if (!empty($_POST["mydata"])) 
    {
   $jsonArr = $_POST["mydata"];
  //  echo $jsonArr;
   $data = json_decode($jsonArr, true);
  
    if (!empty($data)) {
        $client = 'CO-28';

        $fromdt1 = $data['startdate'];
        $fromdt = date("Y-m-d H:i:s", strtotime($fromdt1));
     //   echo "statrt date-".$fromdt;
        $enddte1 = $data['enddate'];
        $enddte = date("Y-m-d H:i:s", strtotime($enddte1));
         $department = $data['department'];
          $location = $data['location'];
     
        $result = $obj->getRecognizedTopReceiver($client, $fromdt, $enddte,$department,$location);
         $res = json_decode($result,true);
         $count = count($res);
//         echo "<pre>";
//         print_r($res);
        if($count>0)
        {
         for($k=0;$k<$count;$k++)
         {
             $img = $res[$k]['userImage'];
             $username = $res[$k]['username'];
             $userreceiver = $res[$k]['totalreceiver'];
             $percent = $res[$k]['percentage'];
             echo ' <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"> 
                                        <img src="'.$img.'" onerror="this.src=&quot;images/user.png&quot;" class="img img-responsive img-circle" style="width:50px;height:50px;">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10"> 
                                    '.$username.'
                                        <div class="progress mt15">
                                            <div class="progress-bar progress-bar-striped active" role="progressbar"
                                                 aria-valuenow="'.$userreceiver.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$percent.'%"> '.$userreceiver.'
                                            </div>
                                        </div>
                                    </div>
                                </div><hr>';
         }
        }
        else
        {
            echo '<div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                    <center><h4>No Data Found</h4></center>
                                    </div></div>';
        }
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