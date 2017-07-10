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
     //   echo "statrt date-".$fromdt;
        $enddte1 = $data['enddate'];
        $enddte = date("Y-m-d H:i:s", strtotime($enddte1));
         $department = $data['department'];
          $location = $data['location'];
     
        $result = $obj->getTopPostForAnalytic($client, $fromdt, $enddte,$department,$location);
         $data = json_decode($result,true);
         $count = count($data);
         echo "<pre>";
         print_r($data);
        if($count>0)
        {
         for($i=0;$i<$count;$i++)
         {  
             $img = $data[$k]['badgeImage'];
             $badgename = $data[$k]['badgename'];
             $totalbadge = $data[$k]['totalbadges'];
             $percent = $data[$k]['percentage'];
             
              if($data[$i]['flag'] == 11){		
		                      $title = $data[$i]['title'];
		                        }elseif($data[$i]['flag'] == 16){	// Thought of the day
						$title =  $data[$i]['title'];
		                        }elseif($data[$i]['flag'] == 23){	// Recognition
			                       $title =  $data[$i]['feedbackQuestion'];
		                        }elseif($data[$i]['flag'] == 24){	// Album/Gallery
			                       $title =  $data[$i]['exercise_name'];
		                        }
             
             
             
             
             
             echo '   <article class="media event">
                            <a class="pull-left date">
                                <p class="month">'. date('F', strtotime($data[$i]['viewdate'])) .'</p>
                                <p class="day">'. date('d', strtotime($data[$i]['viewdate'])) .'</p>
                            </a>
                            <div class="media-body">
                              <b> '.$title. '</b>
                              <p>'. $data[$i]['module'] .'</p>
                              <i class="fa fa-thumbs-o-up" aria-hidden="true">'. $data[$i]['totallike'] .'</i>&nbsp;&nbsp;
                              <i class="glyphicon glyphicon-comment" aria-hidden="true">'. $data[$i]['totalcomment'] .'</i>&nbsp;&nbsp;
                                <i class="fa fa-eye" aria-hidden="true">'. $data[$i]['totalview'].'</i>
                                 
                            </div>
                        </article><hr>';
         }
        }
 else {
         echo '<div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                    <center><h3>No Data Found</h3></center>
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