<?php
@session_start();
require_once('Class_Library/class_Happiness.php');
$objHappiness = new Happiness();

if (!empty($_POST["mydata"])) {
    $jsonArr = $_POST["mydata"];
   // echo $jsonArr;
   //print_r($jsonArr);
	
    $data = json_decode($jsonArr, true);
    
    if (!empty($data)) {
		$clientid = $data['clientid'];
        //$enddate = $data['enddate'];
		//$startday = $data['startday'];
		
		//$enddate = date_format(date_create($data['enddate']),"Y-m-d");
		//$startday = date_format(date_create($data['startday']),"Y-m-d");
	
		$fromdt1 = $data['startday'];
		$startday = date("Y-m-d", strtotime($fromdt1));
        $enddte1 = $data['enddate'];
        $enddate = date("Y-m-d", strtotime($enddte1));
	
		
	
		$department = $data['department'];
		$location = $data['location'];
		$HappinessVal = $data['HappinessVal'];
        $imgurl = $data['imgurl'];
	  
	    $_SESSION['happinessstartdate'] = $startday;
	    $_SESSION['happinessenddate'] = $enddate;
		$_SESSION['happinessdepartment'] = $department;
		$_SESSION['location'] = $location;
			   
      $HappinessDetails = $objHappiness->happinessIndexCustomGraphDetails($clientid, $enddate, $startday,$department, $location, $HappinessVal, $imgurl);
	  $extraHappinessDetailsArr = json_decode($HappinessDetails, true);
	  
	//  print_r($extraHappinessDetailsArr);
	 
	 /******************** for show count *************************/
	 	 
	 /******************* / for show count ************************/
	 
	 if ($extraHappinessDetailsArr['success'] == 1) 
	 {
		$extraHappycomments = "";
		foreach ($extraHappinessDetailsArr['data'] as $extraHappyWordData) {
			$extraHappycomments .= ' /// ' . $extraHappyWordData['comment'];
		}
		
		$words = json_decode($objHappiness->extractCommonWords($extraHappycomments), true);
	} 
	else 
	{
    $words = array($extraHappinessDetailsArr['message'] => "message");
	}
	//print_r($words);
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
$res = json_encode($extraHappyGlobeGraph);

$arraycomplete = array();
$arraycomplete['happtotalcomment'] = $extraHappinessDetailsArr['happtotalcomment'];
$arraycomplete['totalcomment'] = $extraHappinessDetailsArr['totalComments'];
$arraycomplete['graphdata'] = $res;
$completeshowdata = json_encode($arraycomplete);
echo $completeshowdata;
//echo $res; 
    }
}
?>