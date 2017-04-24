<?php
include 'header.php';
include 'sidemenu.php';
include 'topNavigation.php';
//error_reporting(E_ALL);ini_set('display_errors', 1);

require_once('Class_Library/class_Happiness.php');
$objHappiness = new Happiness();
session_start();
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$surveyId = $_GET['happinessQuestion'];

$happinessDetails = $objHappiness->getSingleHappinessDetail($clientId, $surveyId);
$happinessDetailsArr = json_decode($happinessDetails, true);
//echo'<pre>';print_r($happinessDetailsArr);die;
$happinessData = $happinessDetailsArr['data'];

$count = count($happinessData);

//if (isset($_POST['department']) && (!empty($_POST['department']))) {

$all_happy_avg = array();
//for ($i = 0; $i < $count; $i++) {
$surveyid = $surveyId;
$qid = $surveyId;

/* * ********************************************************************* */
$sad = -5;
$happy = 5;
$normal = 0;
$ehappy = 10;
$happy_avg = array();
$sadcount = $objHappiness->getSurveyCount($surveyid, $qid, $sad);
$happycount = $objHappiness->getSurveyCount($surveyid, $qid, $happy);
$normalcount = $objHappiness->getSurveyCount($surveyid, $qid, $normal);
$ehappycount = $objHappiness->getSurveyCount($surveyid, $qid, $ehappy);
//print_r($happycount);
//print_r($ehappycount);
$happy_avg[] = $sadcount['surveycount'] * $sad;
$happy_avg[] = $normalcount['surveycount'] * $normal;
$happy_avg[] = $happycount['surveycount'] * $happy;
$happy_avg[] = $ehappycount['surveycount'] * $ehappy;

$totalRespondent = ($sadcount['surveycount'] + $normalcount['surveycount'] + $happycount['surveycount'] + $ehappycount['surveycount']);
//    $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4) / $totalRespondent;

if (!empty($happy_avg)) {
    $all_happy_avg = $happy_avg;
} else {
    $all_happy_avg[] = '';
}
//}
$overAllAvg = $all_happy_avg;
//echo'<pre>';print_r($all_happy_avg);die;

$graphArr = array();

$graphArr['sad']['label'] = "Sad";
$graphArr['sad']['value'] = ($all_happy_avg[0] / 1);
//$graphArr['sad']['color'] = "#09355C";

$graphArr['neutral']['label'] = "Normal";
$graphArr['neutral']['value'] = ($all_happy_avg[1] / 1);
//$graphArr['neutral']['color'] = "violet";

$graphArr['happy']['label'] = "Happy";
$graphArr['happy']['value'] = ($all_happy_avg[2] / 1);
//$graphArr['happy']['color'] = "#CBCBCB";

$graphArr['overwhelmed']['label'] = "Overwhelmed";
$graphArr['overwhelmed']['value'] = ($all_happy_avg[3] / 1);
//$graphArr['overwhelmed']['color'] = "#B61B12";


$deptAvg = array();

$graph = array($graphArr['sad'], $graphArr['neutral'], $graphArr['happy'], $graphArr['overwhelmed']);

echo "<textarea style='display:none;' id='doughnutGraphData'> </textarea>";

echo "<script> document.getElementById('doughnutGraphData').value = '" . json_encode($graph) . "';   </script>";


//array_unshift($deptAvg, $overAllAvg);
/*
  for ($j = 1; $j < sizeof($filter); $j++) {
  $questionAvg = array();
  for ($i = 0; $i < $count; $i++) {
  $surveyid = $happinessData[$i]['surveyId'];
  $qid = $happinessData[$i]['questionId'];

  $sad = -5;
  $happy = 5;
  $normal = 0;
  $ehappy = 10;
  $happy_avg = 0;

  $sadcount = $objHappiness->getSurveyCount($surveyid, $qid, $sad, $filter[$j]);
  $happycount = $objHappiness->getSurveyCount($surveyid, $qid, $happy, $filter[$j]);
  $normalcount = $objHappiness->getSurveyCount($surveyid, $qid, $normal, $filter[$j]);
  $ehappycount = $objHappiness->getSurveyCount($surveyid, $qid, $ehappy, $filter[$j]);


  $happy_avg1 = $sadcount['surveycount'] * $sad;
  $happy_avg2 = $normalcount['surveycount'] * $normal;
  $happy_avg3 = $happycount['surveycount'] * $happy;
  $happy_avg4 = $ehappycount['surveycount'] * $ehappy;


  $totalRespondent = ($sadcount['surveycount'] + $normalcount['surveycount'] + $happycount['surveycount'] + $ehappycount['surveycount']);
  $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4) / $totalRespondent;

  $questionAvg[] = $happy_avg;
  }

  array_push($deptAvg, $questionAvg);
  }
  //    $department['OverallAvg'] = 'Over all Average';
  //array_push($deptAvg, $overAllAvg);

  $departmentAvg = array_combine($department, $deptAvg);

  //    print_r($departmentAvg);die;
  $finalArr = array();
  $newArr = array();

  foreach ($departmentAvg as $key => $val) {
  $newArr['name'] = $key;
  $newArr['data'] = $val;

  array_push($finalArr, $newArr);
  }
  //    print_r($finalArr);die;
  echo json_encode($finalArr); */
//}
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <br>
        <div class="clearfix"></div>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Question?</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="form-group">
                                <h4><b><?php echo $happinessDetailsArr['happinessQuestion']; ?></b></h4>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="surveyId" value="<?php echo $_GET['happinessQuestion']; ?>">
		
		
		
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="happinessDetails2.php"><h2>Very Happy</h2></a>
                        <ul class="nav navbar-right panel_toolbox">
						
                            <li class=""><a class="collapse-link" href="happinessDetails2.php" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
                            <li class="right"><a class="collapse-link" id="MHdemo"><i class="fa fa-chevron-up"></i></a></li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="MHdemo1"  class="form-horizontal form-label-left collapse in">
                            <div class="form-group">
<div id="wordcloud" class="JMDBenepik" ></div> 

                            </div>

                        </form>
                    </div>
                </div>
            </div>
			<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                <div class="x_panel">
                    <div class="x_title">
                       <a href="happinessDetails2.php"> <h2>Happy</h2></a>
                        <ul class="nav navbar-right panel_toolbox">
                           
                            <li class=""><a class="collapse-link" href="happinessDetails2.php" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
                            <li class="right"><a class="collapse-link"id="Hdemo"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="Hdemo1"  class="form-horizontal form-label-left collapse in">
                            <div class="form-group">
							<div id="wordcloud2" class="JMDBenepik" ></div> 

                            </div>

                        </form>
                    </div>
                </div>
            </div>
			<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="happinessDetails2.php"><h2>Normal</h2></a>
                        <ul class="nav navbar-right panel_toolbox">
                           
                            <li class=""><a class="collapse-link" href="happinessDetails2.php" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
                            <li class="right"><a class="collapse-link"id="NHdemo"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="NHdemo1"  class="form-horizontal form-label-left collapse in">
                            <div class="form-group">
<div id="wordcloud3" class="JMDBenepik" ></div> 

                            </div>

                        </form>
                    </div>
                </div>
            </div>
			<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="happinessDetails2.php"><h2>Sad</h2></a>
                        <ul class="nav navbar-right panel_toolbox">
                           
                            <li class=""><a class="collapse-link" href="happinessDetails2.php" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
                            <li class="right"><a class="collapse-link"id="SHdemo"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="SHdemo1"  class="form-horizontal form-label-left collapse in">
                            <div class="form-group">
<div id="wordcloud4" class="JMDBenepik"  ></div> 

                            </div>

                        </form>
                    </div>
                </div>
            </div>
			
        </div>
    </div>
 </div>

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script type='text/javascript'src="build/js/HappinesssDetails.js"></script>

<script> 
$(document).ready(function(){
    $("#NHdemo").click(function(){
        $("#NHdemo1").animate({
            height: 'toggle'
        });
    });
	 $("#MHdemo").click(function(){
        $("#MHdemo1").animate({
            height: 'toggle'
        });
    });
	 $("#Hdemo").click(function(){
        $("#Hdemo1").animate({
            height: 'toggle'
        });
    });
	 $("#SHdemo").click(function(){
        $("#SHdemo1").animate({
            height: 'toggle'
        });
    });
});
</script>
  
<script type="text/javascript" src="http://www.lucaongaro.eu/demos/jqcloud/jqcloud-1.0.0.min.js"></script>
    <!-- footer content -->
        <footer>
          <div class="pull-right">
           All copyright@<a href="https://www.benepik.com">Benepik.com</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
  
