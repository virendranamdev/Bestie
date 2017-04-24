<?php

require_once('Class_Library/class_Happiness.php');
$objHappiness = new Happiness();

error_reporting(E_ALL);
ini_set('display_errors', 1);

extract($_POST);

$all_happy_avg = array();
//for ($i = 0; $i < $count; $i++) {
$surveyid = $sid;
$qid = $sid;

if ($filter == "monthly") {
    $filter = array();
    $filter[0] = date('Y-m-d',strtotime('first day of last month'));
    $filter[1] = date('Y-m-d',strtotime('last day of last month'));
}
if ($filter == "custom") {
    $filter = array();
    $filter[0] = date('Y-m-d', strtotime($fromDate));
    $filter[1] = date('Y-m-d', strtotime($toDate));
}


/* * ********************************************************************* */
$sad = -5;
$happy = 5;
$normal = 0;
$ehappy = 10;
$happy_avg = array();
$sadcount = $objHappiness->getSurveyCount($surveyid, $qid, $sad, $filter);
$happycount = $objHappiness->getSurveyCount($surveyid, $qid, $happy, $filter);
$normalcount = $objHappiness->getSurveyCount($surveyid, $qid, $normal, $filter);
$ehappycount = $objHappiness->getSurveyCount($surveyid, $qid, $ehappy, $filter);
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

$graphArr = array();

$graphArr['sad']['label'] = "Sad";
$graphArr['sad']['value'] = $all_happy_avg[0] / 1;
//$graphArr['sad']['color'] = "red";

$graphArr['neutral']['label'] = "Normal";
$graphArr['neutral']['value'] = $all_happy_avg[1] / 1;
//$graphArr['neutral']['color'] = "violet";

$graphArr['happy']['label'] = "Happy";
$graphArr['happy']['value'] = $all_happy_avg[2] / 1;
//$graphArr['happy']['color'] = "yellow";

$graphArr['overwhelmed']['label'] = "Overwhelmed";
$graphArr['overwhelmed']['value'] = $all_happy_avg[3] / 1;
//$graphArr['overwhelmed']['color'] = "green";


$deptAvg = array();

$graph = array($graphArr['sad'], $graphArr['neutral'], $graphArr['happy'], $graphArr['overwhelmed']);
echo json_encode($graph);
