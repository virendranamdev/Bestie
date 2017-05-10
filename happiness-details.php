<?php
include 'header.php';
include 'sidemenu.php';
include 'topNavigation.php';
//error_reporting(E_ALL);ini_set('display_errors', 1);
@session_start();
require_once('Class_Library/class_Happiness.php');
include_once("Class_Library/class_getDepartment.php");
$objHappiness = new Happiness();
$department = new Department();

$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$surveyId = $_GET['happinessQuestion'];

$getalldepartment = $department->getDepartment($clientId);
$alldepartmentarray = json_decode($getalldepartment , true);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {

        var enddate = document.getElementById("startdate").value;
        var startday = document.getElementById("lastday").value;
		var clientid = $("#clientId").val();
		var department = 'All';
		var extraHappinessVal = 10;
        //alert(clientid);
        //alert("start"+startday);
		
		var postData =
                    {
						"clientid": clientid,
                        "enddate": enddate,
                        "startday": startday,
                        "department": department,
						"HappinessVal": extraHappinessVal
                    }
            var dataString = JSON.stringify(postData);
			alert(dataString);
			//alert('<?php echo SITE; ?>');
			
			$.ajax({
                type: "POST",
                //dataType: "json",
                //contentType: "application/json; charset=utf-8",
                url: "<?php echo SITE; ?>happinessindexfabulous.php",
                data: {"mydata": dataString},
                success: function (response) {
                    var resdata = response;
					alert(resdata);
				}
			});
		
		
		
       // showActiveUserGraph(startday, enddate, department, '<?php echo SITE; ?>');
       // showHappinessIndexGraph(startday, enddate, department, '<?php echo SITE; ?>');
        /**********************************/
      
    });
</script>

<?php
$extraHappinessVal = 10;
$extraHappinessDetails = $objHappiness->getSingleHappinessDetail($clientId, $surveyId, $extraHappinessVal);
$extraHappinessDetailsArr = json_decode($extraHappinessDetails, true);
//echo'<pre>';print_r($extraHappinessDetailsArr);die;
if ($extraHappinessDetailsArr['success'] == 1) {
	$extraHappycomments = "";
    foreach ($extraHappinessDetailsArr['data'] as $extraHappyWordData) {
        $extraHappycomments .= ' /// ' . $extraHappyWordData['comment'];
    }
    $words = json_decode($objHappiness->extractCommonWords($extraHappycomments), true);
} else {
    $words = array($extraHappinessDetailsArr['message'] => "message");
}
$extraHappyfieldnames_actual = array();
$extraHappyvalues = array();

foreach ($words as $k => $v) {
    if ($k != 'fieldnames') {
        $extraHappyfieldnames_actual[] = $k;
        $extraHappyvalues[] = $v;
    }
}

$i = 0;
$extraHappyGlobeGraph = array();
$textGraph = array();
while ($i < sizeof($words)) {
    $textGraph['text'] = $extraHappyfieldnames_actual[$i];
    $textGraph['weight'] = $extraHappyvalues[$i];

    $i++;
    array_push($extraHappyGlobeGraph, $textGraph);
}
?>

<textarea style="display:none;" id="extraHappyTextGlobe" ><?php echo json_encode($extraHappyGlobeGraph); ?></textarea>


<?php
$happinessVal = 5;
$happinessDetails = $objHappiness->getSingleHappinessDetail($clientId, $surveyId, $happinessVal);
$happinessDetailsArr = json_decode($happinessDetails, true);
//echo'<pre>';print_r($happinessDetailsArr);die;
if ($happinessDetailsArr['success'] == 1) {
	$happinesscomments = "";
    foreach ($happinessDetailsArr['data'] as $happinessWordData) {
        $happinesscomments .= ' /// ' . $happinessWordData['comment'];
    }
    $words = json_decode($objHappiness->extractCommonWords($happinesscomments), true);
} else {
    $words = array($happinessDetailsArr['message'] => "message");
}
$happinessfieldnames_actual = array();
$happinessvalues = array();

foreach ($words as $k => $v) {
    if ($k != 'fieldnames') {
        $happinessfieldnames_actual[] = $k;
        $happinessvalues[] = $v;
    }
}

$i = 0;
$happinessGlobeGraph = array();
$textGraph = array();
while ($i < sizeof($words)) {
    $textGraph['text'] = $happinessfieldnames_actual[$i];
    $textGraph['weight'] = $happinessvalues[$i];

    $i++;
    array_push($happinessGlobeGraph, $textGraph);
}
?>

<textarea style="display:none;" id="happinessTextGlobe" ><?php echo json_encode($happinessGlobeGraph); ?></textarea>

<?php
$neutralVal = 0;
$neutralDetails = $objHappiness->getSingleHappinessDetail($clientId, $surveyId, $neutralVal);
$neutralDetailsArr = json_decode($neutralDetails, true);
//echo'<pre>';print_r($neutralDetailsArr);die;
if ($neutralDetailsArr['success'] == 1) {
	$neutralcomments = "";
    foreach ($neutralDetailsArr['data'] as $neutralWordData) {
        $neutralcomments .= ' /// ' . $neutralWordData['comment'];
    }
    $words = json_decode($objHappiness->extractCommonWords($neutralcomments), true);
} else {
    $words = array($neutralDetailsArr['message'] => "message");
}
//print_r($words);die;
$neutralfieldnames_actual = array();
$neutralvalues = array();

foreach ($words as $k => $v) {
    if ($k != 'fieldnames') {
        $neutralfieldnames_actual[] = $k;
        $neutralvalues[] = $v;
    }
}
//print_r($neutralfieldnames_actual);
//print_r($neutralvalues);die;
$i = 0;
$neutralGlobeGraph = array();
$textGraph = array();
while ($i < sizeof($words)) {
    $textGraph['text'] = $neutralfieldnames_actual[$i];
    $textGraph['weight'] = $neutralvalues[$i];

    $i++;
    array_push($neutralGlobeGraph, $textGraph);
}
?>

<textarea style="display:none;" id="neutralTextGlobe" ><?php echo json_encode($neutralGlobeGraph); ?></textarea>

<?php
$sadVal = -5;
$sadnessDetails = $objHappiness->getSingleHappinessDetail($clientId, $surveyId, $sadVal);
$sadnessDetailsArr = json_decode($sadnessDetails, true);
//echo'<pre>';print_r($sadnessDetailsArr);die;
if ($sadnessDetailsArr['success'] == 1) {
	$sadnesscomments = "";
    foreach ($sadnessDetailsArr['data'] as $sadnessWordData) {
        $sadnesscomments .= ' /// ' . $sadnessWordData['comment'];
    }
    $words = json_decode($objHappiness->extractCommonWords($sadnesscomments), true);
} else {
    $words = array($sadnessDetailsArr['message'] => "message");
}
$sadnessfieldnames_actual = array();
$sadnessvalues = array();

foreach ($words as $k => $v) {
    if ($k != 'fieldnames') {
        $sadnessfieldnames_actual[] = $k;
        $sadnessvalues[] = $v;
    }
}

$i = 0;
$sadnessGlobeGraph = array();
$textGraph = array();
while ($i < sizeof($words)) {
    $textGraph['text'] = $sadnessfieldnames_actual[$i];
    $textGraph['weight'] = $sadnessvalues[$i];

    $i++;
    array_push($sadnessGlobeGraph, $textGraph);
}
?>

<textarea style="display:none;" id="sadnessTextGlobe" ><?php echo json_encode($sadnessGlobeGraph); ?></textarea>

<?php
//$happinessData = $happinessDetailsArr['data'];
//$count = count($happinessData);
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
                        <h2>Happiness Index</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                            <!--<div class="form-group">
                                <h4><b><?php echo $happinessDetailsArr['happinessQuestion']; ?></b></h4>

                            </div>-->
							<div class="row">
							<input type="hidden" name="clientId" id="clientId" value="<?php echo $_SESSION['client_id']; ?>">
							<input type="hidden" name="startdate" id="startdate" value="<?php echo date("Y-m-d"); ?>">
							
							<input type="hidden" style="display:none;" id="lastday" name="activeU" value="<?php echo date('Y-m-d', strtotime("-1 days")); ?>">
							
							<div class="col-sm-3">
							 <div class="form-group">
                                    <label for="usr">From:</label>
<!--                                    <input type="date" class="form-control" id="usr">-->
                                    <input type="date" id="fromDate" name="input1" size="20" class="form-control" placeholder="mm/dd/yyyy"/>
                                </div>
								</div>
								<div class="col-sm-3">
                                <div class="form-group">
                                    <label for="pwd">To:&nbsp;&nbsp;</label>
								<input type="date" id="toDate" class="form-control" name="input2" size="20" placeholder="mm/dd/yyyy"/>
                                </div>
								</div>
								<div class="col-sm-3">
								<div class="form-group">
                                    <label for="pwd">Department:&nbsp;&nbsp;</label>
									<select name="alldepartments" id="alldepartments" class="form-control">
									<option value="All">All</option>
									<?php 
									for($i=0; $i<count($alldepartmentarray); $i++)
									{
										if($alldepartmentarray[$i]['department'] == "")
										{
											continue;
										}
									?>
									<option value="<?php echo $alldepartmentarray[$i]['department'];?>"><?php echo $alldepartmentarray[$i]['department'];?></option>
									<?php }?>
									</select>
                               
                                </div>
								</div>
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="pwd">&nbsp;&nbsp;</label>
                                   <button type="button" class="btn btn-info form-control">Submit</button> 
                                </div>
								</div>
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
                        <a href="happinessDetails2.php?happinessQuestion=<?php echo $surveyId; ?>&happinessIndex=Fabulous"><h2>Fabulous</h2></a>
                        <ul class="nav navbar-right panel_toolbox">

                            <li class=""><a class="collapse-link" href="happinessDetails2.php?happinessQuestion=<?php echo $surveyId; ?>&happinessIndex=Fabulous" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
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
                        <a href="happinessDetails2.php?happinessQuestion=<?php echo $surveyId; ?>&happinessIndex=Happy"> <h2>Happy</h2></a>
                        <ul class="nav navbar-right panel_toolbox">

                            <li class=""><a class="collapse-link" href="happinessDetails2.php?happinessQuestion=<?php echo $surveyId; ?>&happinessIndex=Happy" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
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
                        <a href="happinessDetails2.php?happinessQuestion=<?php echo $surveyId; ?>&happinessIndex=So - So"><h2>So - So</h2></a>
                        <ul class="nav navbar-right panel_toolbox">

                            <li class=""><a class="collapse-link" href="happinessDetails2.php?happinessQuestion=<?php echo $surveyId; ?>&happinessIndex=So - So" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
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
                        <a href="happinessDetails2.php?happinessQuestion=<?php echo $surveyId; ?>&happinessIndex=Get Me Out Of Here"><h2>Get Me Out Of Here</h2></a>
                        <ul class="nav navbar-right panel_toolbox">

                            <li class=""><a class="collapse-link" href="happinessDetails2.php?happinessQuestion=<?php echo $surveyId; ?>&happinessIndex=Get Me Out Of Here" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
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
    $(document).ready(function () {
        $("#NHdemo").click(function () {
            $("#NHdemo1").animate({
                height: 'toggle'
            });
        });
        $("#MHdemo").click(function () {
            $("#MHdemo1").animate({
                height: 'toggle'
            });
        });
        $("#Hdemo").click(function () {
            $("#Hdemo1").animate({
                height: 'toggle'
            });
        });
        $("#SHdemo").click(function () {
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

