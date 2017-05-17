<?php
include 'header.php';
include 'sidemenu.php';
include 'topNavigation.php';
//error_reporting(E_ALL);ini_set('display_errors', 1);

require_once('Class_Library/class_Happiness.php');
$objHappiness = new Happiness();
@session_start();
//echo "<pre>";
//print_r($_SESSION);
$happstartdate = $_SESSION['happinessstartdate'];
$happenddate = $_SESSION['happinessenddate'];
$happdepartment = $_SESSION['happinessdepartment'];
$happlocation = $_SESSION['location'];

$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
//$surveyId = $_GET['happinessQuestion'];
$happyIndex = $_GET['happinessIndex'];

if ($happyIndex == 'Get Me Out Of Here') {
    $happinessVal = -5;
}
if ($happyIndex == 'So - So') {
    $happinessVal = 0;
}
if ($happyIndex == 'Happy') {
    $happinessVal = 5;
}
if ($happyIndex == 'Fabulous') {
    $happinessVal = 10;
}
$imgurl = SITE;;

$happinessDetails = $objHappiness->happinessIndexCustomGraphDetails($clientId, $happenddate, $happstartdate,$happdepartment, $happlocation , $happinessVal , $imgurl);
$happinessDetailsArr = json_decode($happinessDetails, true);
//echo'<pre>';print_r($happinessDetailsArr);
if ($happinessDetailsArr['success'] == 1) {
	$happinesscomments = "";
    foreach ($happinessDetailsArr['data'] as $happinessWordData) {
        $happinesscomments .= ' /// ' . $happinessWordData['comment'];
    }
    $words = json_decode($objHappiness->extractCommonWords($happinesscomments), true);
	//echo "<pre>";print_r($words);
} else {
    $words = array($happinessDetailsArr['message'] => 5);
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
    $textGraph['size'] = $happinessvalues[$i]*5;

    $i++;
    array_push($happinessGlobeGraph, $textGraph);
}
//print_r($happinessGlobeGraph);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="js/analytic/downloadanalyticimage.js"></script>
<textarea style="display:none;" id="textGlobe" ><?php echo json_encode($happinessGlobeGraph); ?></textarea>

<?php
//$count = count($happinessData);

//if (isset($_POST['department']) && (!empty($_POST['department']))) {

/*$all_happy_avg = array();
//for ($i = 0; $i < $count; $i++) {
$surveyid = $surveyId;
$qid = $surveyId;

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

*/

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

<link href="build/css/happinessIndex-detail.css" rel="stylesheet">	 
<script src="https://code.highcharts.com/highcharts.js"></script>
<script async src="build/js/Chart.min.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

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
                            <div class="form-group">
                                <!--<h4><b><?php echo $happinessDetailsArr['happinessQuestion']; ?></b></h4>-->

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--<input type="hidden" id="surveyId" value="<?php echo $_GET['happinessQuestion']; ?>">-->
        <!--        <div class="row">
                    <div class="col-md-4 col-xs-4 col-sm-4 col-lg-4">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Value</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
        
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content height">
                                <br />
                                <form class="form-horizontal form-label-left input_mask">
                                                                <div class="radio">
                                                                    <label><input type="radio" name="optradio">Daily</label>
                                                                </div>
                                                                <div class="radio">
                                                                    <label><input type="radio" name="optradio">Weekly</label>
                                                                </div>
                                    <div class="radio">
                                        <label><input id="monthlyRadio" type="radio" name="optradio">Monthly</label>
                                    </div>
                                    <div class="radio">
                                        <label><input id="customRadio" class="custom" data-toggle="collapse" data-target="#demo" type="radio" name="optradio">Custom</label>
                                    </div>
        
        
                                    <div id="demo" class="collapse">
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-4">From Date</label>
                                            <div class="col-md-8 col-sm-8 col-xs-8 form-group has-feedback">
                                                <input type="text" class="form-control has-feedback-left" id="single_cal4" aria-describedby="inputSuccess2Status4" placeholder="dd/mm/yy">
                                                <input type="date" id="single_cal4" />
                                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4 col-sm-4 col-xs-4 paddingright">To Date </label>
                                            <div class="col-md-8 col-sm-8 col-xs-8">
                                                <input type="text" class="form-control has-feedback-left" id="single_cal3" aria-describedby="inputSuccess2Status3">
                                                <input type="date" id="single_cal3" />
                                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                <span id="inputSuccess2Status3" class="sr-only">(success)</span>
        
                                            </div>
                                        </div>
                                    </div>
        
        
                                </form>
                            </div>
                        </div>
        
                    </div>
        
                    <div class="col-md-8 col-xs-8 col-md-8 col-lg-8">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>Graph</h2>
                                                <ul class="nav navbar-right panel_toolbox">
                                                    <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                    </li>
                        
                                                </ul>
                                                <div class="clearfix"></div>
                                            </div>
                                            <center><div class="heightwidth">
                                                    <canvas id="myChart" class="heightwidthh" ></canvas>
                                                </div></center>
                                            <br>
                                            <center><div id="js-legend" class="chart-legend"></div></center>
                        
                                        </div>
                        <div class="x_panel">
                            <div class="panel-body">
        
                                <div class="col-md-10" id="anlyticgraph">
        
                                    <div id="chart-container"></div>
        
        
                                </div>
        
                            </div>
        
                        </div> 
                    </div>
                </div>-->
        <?php
       /* $comments = '';
        foreach ($happinessData as $wordData) {
            $comments .= ' /// ' . $wordData['comment'];
        }
        $words = json_decode($objHappiness->extractCommonWords($comments), true);

        $fieldnames_actual = array();
        $values = array();

        foreach ($words as $k => $v) {
            if ($k != 'fieldnames') {
                $fieldnames_actual[] = $k;
                $values[] = $v;
            }
        }*/
//        echo'<pre>';        print_r($fieldnames_actual);        print_r($values);
        ?>
        <div class="row">
            <!--            <div class="col-md-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Popular Words</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
            
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content wordData">
                                    <br />
                                    <form class="form-horizontal form-label-left input_mask">
            <?php
            $i = 0;
            $globeGraph = array();
            $textGraph = array();
            while ($i < sizeof($words)) {
                ?>
                                                    <div class="form-group">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $values[$i] * 20; ?>%">
                <?php
                echo '<b>' . $fieldnames_actual[$i] . ' : ' . $values[$i] . '<b>';
                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                <?php
                $textGraph['text'] = $fieldnames_actual[$i];
                $textGraph['size'] = $values[$i] * 10;

                $i++;
                array_push($globeGraph, $textGraph);
            }
            ?>
                                    </form>
                                </div>
                            </div>
                        </div>-->
            <!--<textarea style="display:block;" id="textGlobe" ><?php // echo json_encode($globeGraph); ?></textarea>-->

            <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $_GET['happinessIndex']; ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content wordData">
                        <br />
                        <form class="form-horizontal form-label-left">

                            <div class="form-group">
<?php include 'graph/happinessGraph.php'; ?>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Responses</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="demo-form3" data-parsley-validate class="form-horizontal form-label-left">
                            <?php
                           //print_r($happinessDetailsArr);
						   if($happinessDetailsArr['success'] == 1)
						   {
                            foreach ($happinessDetailsArr['data'] as $feed) {
                                ?>
                                <div class="row">
                                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"> 
                                        <center>
                                            <img src="<?php echo $feed['userImage']; ?>" class="img-circle" onerror="this.src=&quot;images/dummyUser.png&quot;">
                                            <br>
    <?php echo $feed['name']; ?>
                                        </center>
                                    </div>
                                    <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
                                        <p class="userresponse"><?php echo $feed['comment']; ?></p>
                                        <p> 
                                            <span class="tableDate"><?php echo date('d M Y', strtotime($feed['createdDate'])); ?></span>
                                        </p>
                                    </div>

                                </div>
                                <hr>
							<?php }
							} 
						   else{?>
							 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><span>No comments available</span></div>  
						   <?php }
						   ?>


                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<!-- /page content -->


<script>
    /*$(document).ready(function () {
        $("#monthlyRadio").click(function () {
//            if ($(this).is(':checked')) {
            var surveyId = $("#surveyId").val();
            $.ajax({
                url: "get_graph_data_filter.php",
                type: "POST",
                cache: false,
                data: {
                    "cid": 'CO-28',
                    "sid": surveyId,
                    "filter": "monthly"
                },
                success: function (response) {
                    if (response != '') {
                        surveyGraph(response);
                    } else {
                        $("#chart-container").html("No Data available");
                    }
                }
            });
//            }
        });

//        $("#customRadio").click(function () {


        $("#single_cal3").change(function () {
            var fromDate = $("#single_cal4").val();
            var toDate = $("#single_cal3").val();
            var surveyId = $("#surveyId").val();

            if (new Date(fromDate) <= new Date(toDate)) {
                //compare end <=, not >=

                $.ajax({
                    url: "get_graph_data_filter.php",
                    type: "POST",
                    cache: false,
                    data: {
                        "cid": 'CO-28',
                        "sid": surveyId,
                        "filter": "custom",
                        "fromDate": fromDate,
                        "toDate": toDate,
                    },
                    success: function (response) {
                        if (response != '') {
                            surveyGraph(response);
                        } else {
                            $("#chart-container").empty();
                            $("#chart-container").html("No Data available");
                        }
                    }
                });
            } else {
                alert("Select correct From date");
                $("#single_cal4").focus();
            }
        });
    });
	
	*/
	
//    var data = [
//        {
//            value: 60,
//            color: "#09355C",
//            label: "sad"
//        }, {
//            value: 0,
//            color: "violet",
//            label: "neutral"
//        }, {
//            value: 11,
//            color: "#CBCBCB",
//            label: "happy"
//        }, {
//            value: 18,
//            color: "#B61B12",
//            label: "normal"
//        }];

    /*
     var data = JSON.parse($("#doughnutGraphData").val());
     var options = {
     segmentShowStroke: false,
     animateRotate: true,
     animateScale: false,
     percentageInnerCutout: 50,
     tooltipTemplate: "<%= value %>%"
     }
     
     var ctx = $("#myChart").get(0).getContext("2d");
     var myChart = new Chart(ctx).Doughnut(data, options);
     // Note - tooltipTemplate is for the string that shows in the tooltip
     
     // legendTemplate is if you want to generate an HTML legend for the chart and use somewhere else on the page
     
     // e.g:
     
     $('#js-legend').html(myChart.generateLegend());
     //    });
     */
</script>

<!--<script src="js/analytic/questionresult.js"></script>-->
<script src="js/analytic/fusioncharts.charts.js"></script>
<script src="js/analytic/fusioncharts.js"></script>
<script type="text/javascript">
   /* var doughnutGraphData = $("#doughnutGraphData").val();
//    var sid = $("#sid").val(); 
//    var clientid = $("#clientid").val();
//    var respondentsCount = 3;
    surveyGraph(doughnutGraphData);


    
    function surveyGraph(resdata) {
        var categorydata = resdata;

        FusionCharts.ready(function () {
            var visitChart = new FusionCharts({
                //  type: 'bar2d',
                type: 'doughnut2d',
                renderAt: 'chart-container',
                width: '550',
                height: '420',
                dataFormat: 'json',
                dataSource: {
                    "chart": {
                        "caption": "Happiness Graph",
                        // "subCaption": "Percentage of respondent with respect to normal, sad ,happy and  extra happy",
                        "numberPrefix": "",
                        "paletteColors": "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000",
                        "bgColor": "#ffffff",
                        "showBorder": "0",
                        "use3DLighting": "0",
                        "showShadow": "0",
                        "enableSmartLabels": "0",
                        "startingAngle": "310",
                        "showLabels": "0",
                        "showPercentValues": "1",
                        "showLegend": "1",
                        "legendShadow": "0",
                        "legendBorderAlpha": "0",
//                        "defaultCenterLabel": "Total No. of Respondent : " + respondentsCount,
                        "centerLabel": " $label: $value",
                        "centerLabelBold": "1",
                        "showTooltip": "1",
                        "decimals": "0",
                        "captionFontSize": "14",
                        "subcaptionFontSize": "14",
                        "subcaptionFontBold": "0"
                    },
                    "data": JSON.parse(categorydata)
                }
            }).render();
        });
    }*/
    /************************************** end draw chart function **************************************/
</script>
<?php include 'footer.php'; ?>
