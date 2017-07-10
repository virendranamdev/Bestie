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
//$surveyId = $_GET['happinessQuestion'];

$getalldepartment = $department->getDepartment($clientId);
$alldepartmentarray = json_decode($getalldepartment , true);

$getalllocation = $department->getLocation($clientId);
$alllocationarray = json_decode($getalllocation , true);

?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
-->

<!-------------------- for capture image ---------------->
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>

<!--<script src="js/analytic/downloadanalyticimage.js"></script>-->
<script src="js/analytic/0.5.0-beta3html2canvas.min.js"></script>
<!------------------------ / for capture image ---------->

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
--><!---------------------------------------------------->
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
-->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/redmond/jquery-ui.css">
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

  $(function() {

    $( "#fromDate" ).datepicker();
	 $( "#toDate" ).datepicker();

  });

  </script>

<script src="js/exportdata.js"></script>
<script>
    function tableexport() {
        var exdata = document.getElementById('exportdata').value;
        // var title = document.getElementById('title').value;
        var jsonData = JSON.parse(exdata);
//alert(exdata);
        if (jsonData.length > 0)
        {
            if (confirm('Are You Sure, You want to Export directory?')) {
                JSONToCSVConvertor1(jsonData, "happinesscomment", true);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            alert("No data available");
        }

    }
</script>

<!---------------------------------------------------->

<script>
    $(document).ready(function () {

        var startday = document.getElementById("lastday").value;
		var enddate = startday;
		//alert('start '+startday);
		//alert('enddate '+enddate);
		var clientid = $("#clientId").val();
		var department = 'All';
		var location = 'All';
		var extraHappinessVal = 10;
		var happinessVal = 5;
		var neutralVal = 0;
		var sadVal = -5;
		var imgurl = "<?php echo SITE; ?>";
		
                /*************************** get all comment ***************************/
         
		var postData =
                    {
                        "clientid": clientid,
                        "imgurl": imgurl,
                        "enddate": enddate,
                        "startday": startday,
                        "department": department,
                        "location": location
                    }
            var dataString = JSON.stringify(postData);
			$.ajax({
                type: "POST",   
                url: "<?php echo SITE; ?>getallcomment.php",
                data: {"mydata": dataString},
                success: function (response) {
                    var resdata = response;
					//alert(resdata);
                                        $("#exportdata").val(resdata);
                                      //  console.log(resdata);
                                        var jsonData = JSON.parse(resdata);
                                     //   console.log(jsonData);
                                        if (jsonData.length !== 0)
                {
					//alert('hi');
                     $('#datatable tbody').remove();
					 for (var i = 0; i < jsonData.length; i++) 
					 {
						var newRow = '<tbody><tr><td>' + jsonData[i].createdDate + '</td><td>' + jsonData[i].status + '</td><td>' + jsonData[i].comment + '</td></tr><tbody>';
					$('#datatable').append(newRow);

					 }
					 
					}
		else
		{
			 $('#datatable tbody').remove();
			 var newRow = '<tbody><tr><td></td><td> No Record Found </td><td></td></tr><tbody>';
					$('#datatable').append(newRow);
			 
			
		}
        
                                   
				}
			});
		
                
                /**************************************************************************/
                
                
                
                
		/********************************** extra happy *******************/
		
		var postData =
                    {
                        "clientid": clientid,
                        "imgurl": imgurl,
                        "enddate": enddate,
                        "startday": startday,
                        "department": department,
                        "location": location,
                        "HappinessVal": extraHappinessVal
                    }
            var dataString = JSON.stringify(postData);
			$.ajax({
                type: "POST",
                url: "<?php echo SITE; ?>happinessIndexcustomgraph.php",
                data: {"mydata": dataString},
                success: function (response) {
                    var resdata = response;
					//alert(resdata);
					 var word_list = JSON.parse(resdata);
					 var clouddata = JSON.parse(word_list.graphdata);
					 $("#wordcloud").jQCloud(clouddata);
					 $('#totalfabulous').empty();
					 $('#totalfabulous').append(word_list.totalcomment);
					 $('#totalhappinesscomment').empty();
					 $('#totalhappinesscomment').append(word_list.happtotalcomment);
					
				}
			});
			
			/**************************** / extra happy *********************/
			
			/************************ happy *************************************/
			var postDatahappy =
                    {
                        "clientid": clientid,
                        "imgurl": imgurl,
                        "enddate": enddate,
                        "startday": startday,
                        "department": department,
                        "location": location,
                        "HappinessVal": happinessVal
                    }
            var dataStringhappy = JSON.stringify(postDatahappy);
			$.ajax({
                type: "POST",
                url: "<?php echo SITE; ?>happinessIndexcustomgraph.php",
                data: {"mydata": dataStringhappy},
                success: function (response) {
                    var resdatahappy = response;
					//alert(resdatahappy);
					var word_list2 = JSON.parse(resdatahappy);
					var clouddata2 = JSON.parse(word_list2.graphdata);
					 $("#wordcloud2").jQCloud(clouddata2);
					 $('#totalhappy').empty();
					 $('#totalhappy').append(word_list2.totalcomment);
					 $('#totalhappinesscomment').empty();
					 $('#totalhappinesscomment').append(word_list2.happtotalcomment);
				}
			});
			/*********************** / happy ************************************/
			
			/************************ normal *************************************/
			var postDatanatural =
                    {
						"clientid": clientid,
						"imgurl": imgurl,
                        "enddate": enddate,
                        "startday": startday,
                        "department": department,
						"location": location,
						"HappinessVal": neutralVal
                    }
            var dataStringnatural = JSON.stringify(postDatanatural);
			$.ajax({
                type: "POST",
                url: "<?php echo SITE; ?>happinessIndexcustomgraph.php",
                data: {"mydata": dataStringnatural},
                success: function (response) {
                    var resdatanatural = response;
					//alert(resdatanatural);
					var word_list3 = JSON.parse(resdatanatural);
					var clouddata3 = JSON.parse(word_list3.graphdata);
					$("#wordcloud3").jQCloud(clouddata3);
					$('#totalsoso').empty();
					$('#totalsoso').append(word_list3.totalcomment);
					$('#totalhappinesscomment').empty();
					$('#totalhappinesscomment').append(word_list3.happtotalcomment);
				}
			});
			/*********************** / normak ************************************/
			
			/************************ sad *************************************/
			var postDataSad =
                    {
						"clientid": clientid,
						"imgurl": imgurl,
                        "enddate": enddate,
                        "startday": startday,
                        "department": department,
						"location": location,
						"HappinessVal": sadVal
                    }
            var dataStringSad = JSON.stringify(postDataSad);
			$.ajax({
                type: "POST",
                url: "<?php echo SITE; ?>happinessIndexcustomgraph.php",
                data: {"mydata": dataStringSad},
                success: function (response) {
                    var resdatasad = response;
					//alert(resdatasad);
					var word_list4 = JSON.parse(resdatasad);
					var clouddata4 = JSON.parse(word_list4.graphdata);
					$("#wordcloud4").jQCloud(clouddata4);
					$('#totalgmooh').empty();
					$('#totalgmooh').append(word_list4.totalcomment);
					$('#totalhappinesscomment').empty();
					$('#totalhappinesscomment').append(word_list4.happtotalcomment);
				}
			});
			/*********************** / sad ************************************/
		
      
    });
</script>

<script>
function happinessindexcustomgraph()
    {
		//alert("hello");
		var startday= document.getElementById("fromDate").value;
		var enddate= document.getElementById("toDate").value;
		
		//alert('start '+startday);
		//alert('enddate '+enddate);
		
		var department= document.getElementById("alldepartments").value;
		var location = document.getElementById("locationname").value;
		if (startday == "")
		{
        window.alert("Please select From date.");
        document.getElementById("fromDate").focus();
        return false;
		}
		if (enddate == "")
		{
			window.alert("Please select To date.");
			document.getElementById("toDate").focus();
			return false;
		}
		if (department == "")
		{
			window.alert("Please select department.");
			document.getElementById("alldepartments").focus();
			return false;
		}
		
		var clientid = $("#clientId").val();
		var extraHappinessVal = 10;
		var happinessVal = 5;
		var neutralVal = 0;
		var sadVal = -5;
		var imgurl = "<?php echo SITE; ?>";
		
                
                
                 /*************************** get all comment ***************************/
         
		var postData =
                    {
                        "clientid": clientid,
                        "imgurl": imgurl,
                        "enddate": enddate,
                        "startday": startday,
                        "department": department,
                        "location": location
                    }
            var dataString = JSON.stringify(postData);
			$.ajax({
                type: "POST",   
                url: "<?php echo SITE; ?>getallcomment.php",
                data: {"mydata": dataString},
                success: function (response) {
                    var resdata = response;
					//alert(resdata);
                                        $("#exportdata").val(resdata);
                                        var jsonData = JSON.parse(resdata);
                                      //  console.log(jsonData);
                                        if (jsonData.length !== 0)
                {
					//alert('hi');
                     $('#datatable tbody').remove();
					 for (var i = 0; i < jsonData.length; i++) 
					 {
						var newRow = '<tbody><tr><td>' + jsonData[i].createdDate + '</td><td>' + jsonData[i].status + '</td><td>' + jsonData[i].comment + '</td></tr><tbody>';
					$('#datatable').append(newRow);

					 }
					 
					}
		else
		{
			 $('#datatable tbody').remove();
			 var newRow = '<tbody><tr><td></td><td> No Record Found </td><td></td></tr><tbody>';
					$('#datatable').append(newRow);
			 
			
		}
        
                                   
				}
			});
		
                
                /**************************************************************************/
                
                
                
                
		/********************************** extra happy *******************/
		
		var postData =
                    {
						"clientid": clientid,
						"imgurl": imgurl,
                        "enddate": enddate,
                        "startday": startday,
                        "department": department,
						"location": location,
						"HappinessVal": extraHappinessVal
                    }
            var dataString = JSON.stringify(postData);
			
			//alert(dataString);
			
			$.ajax({
                type: "POST",
                url: "<?php echo SITE; ?>happinessIndexcustomgraph.php",
                data: {"mydata": dataString},
                success: function (response) {
                    var resdata = response;
					//alert(resdata);
									
					var word_list = JSON.parse(resdata);
					//alert(word_list.totalcomment);	
					var clouddata = JSON.parse(word_list.graphdata);
					
					 $('#wordcloud').empty();
					 $("#wordcloud").jQCloud(clouddata);
					 $('#totalfabulous').empty();
					 $('#totalfabulous').append(word_list.totalcomment);
					 $('#totalhappinesscomment').empty();
					 $('#totalhappinesscomment').append(word_list.happtotalcomment);
					 
				}
			});
			
			/**************************** / extra happy *********************/
			
			/************************ happy *************************************/
			
			/************************ happy *************************************/
			var postDatahappy =
                    {
						"clientid": clientid,
						"imgurl": imgurl,
                        "enddate": enddate,
                        "startday": startday,
                        "department": department,
						"location": location,
						"HappinessVal": happinessVal
                    }
            var dataStringhappy = JSON.stringify(postDatahappy);
			$.ajax({
                type: "POST",
                url: "<?php echo SITE; ?>happinessIndexcustomgraph.php",
                data: {"mydata": dataStringhappy},
                success: function (response) {
                    var resdatahappy = response;
					//alert(resdatahappy);
					var word_list2 = JSON.parse(resdatahappy);
					var clouddata2 = JSON.parse(word_list2.graphdata);
					$('#wordcloud2').empty();
					 $("#wordcloud2").jQCloud(clouddata2);
					 $('#totalhappy').empty();
					 $('#totalhappy').append(word_list2.totalcomment);
					 $('#totalhappinesscomment').empty();
					 $('#totalhappinesscomment').append(word_list2.happtotalcomment);
				}
			});
			/*********************** / happy ************************************/
		
			/************************ normal *************************************/
			var postDatanatural =
                    {
						"clientid": clientid,
						"imgurl": imgurl,
                        "enddate": enddate,
                        "startday": startday,
                        "department": department,
						"location": location,
						"HappinessVal": neutralVal
                    }
            var dataStringnatural = JSON.stringify(postDatanatural);
			$.ajax({
                type: "POST",
                url: "<?php echo SITE; ?>happinessIndexcustomgraph.php",
                data: {"mydata": dataStringnatural},
                success: function (response) {
                    var resdatanatural = response;
					//alert(resdatanatural);
					var word_list3 = JSON.parse(resdatanatural);
					var clouddata3 = JSON.parse(word_list3.graphdata);
					$('#wordcloud3').empty();
					$("#wordcloud3").jQCloud(clouddata3);
					$('#totalsoso').empty();
					 $('#totalsoso').append(word_list3.totalcomment);
					 $('#totalhappinesscomment').empty();
					 $('#totalhappinesscomment').append(word_list3.happtotalcomment);
				}
			});
			/*********************** / normal ************************************/
			
			/************************ sad *************************************/
			var postDataSad =
                    {
						"clientid": clientid,
						"imgurl": imgurl,
                        "enddate": enddate,
                        "startday": startday,
                        "department": department,
						"location": location,
						"HappinessVal": sadVal
                    }
            var dataStringSad = JSON.stringify(postDataSad);
			$.ajax({
                type: "POST",
                url: "<?php echo SITE; ?>happinessIndexcustomgraph.php",
                data: {"mydata": dataStringSad},
                success: function (response) {
                    var resdatasad = response;
					//alert(resdatasad);
					var word_list4 = JSON.parse(resdatasad);
					var clouddata4 = JSON.parse(word_list4.graphdata);
					$('#wordcloud4').empty();
					$("#wordcloud4").jQCloud(clouddata4);
					$('#totalgmooh').empty();
					 $('#totalgmooh').append(word_list4.totalcomment);
					 $('#totalhappinesscomment').empty();
					 $('#totalhappinesscomment').append(word_list4.happtotalcomment);
				}
			});
			/*********************** / sad ************************************/
		
	}
</script>
<!--
<?php
$extraHappinessVal = 10;
$extraHappinessDetails = $objHappiness->getSingleHappinessDetail($clientId, $surveyId, $extraHappinessVal);
$extraHappinessDetailsArr = json_decode($extraHappinessDetails, true);
//echo'<pre>';print_r($extraHappinessDetailsArr);
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
//echo "<pre>";
//print_r($extraHappyGlobeGraph);
?>
<textarea id="extraHappyTextGlobe"><?php echo json_encode($extraHappyGlobeGraph); ?></textarea>

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

<textarea  id="happinessTextGlobe" ><?php echo json_encode($happinessGlobeGraph); ?></textarea>

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

<textarea  id="neutralTextGlobe" ><?php echo json_encode($neutralGlobeGraph); ?></textarea>

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

<textarea  id="sadnessTextGlobe" ><?php echo json_encode($sadnessGlobeGraph); ?></textarea>

<?php
//$happinessData = $happinessDetailsArr['data'];
//$count = count($happinessData);
//if (isset($_POST['department']) && (!empty($_POST['department']))) {

$all_happy_avg = array();
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

echo "<textarea style='display:none' id='doughnutGraphData'> </textarea>";

echo "<script> document.getElementById('doughnutGraphData').value = '" . json_encode($graph) . "';   </script>";
?>

-->

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <br>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Happiness Indicator</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
					
					<div>
					<?php
					/*echo "<pre>";
					print_r($_SESSION);
					echo "</pre>";*/
					?>
					
					<!--<table id="mytable">
					<tr>
					<th>Total Respondent :</th>
					<td></td>
					</tr>
					<tr><th>Fabulous</th><td></td></tr>
					</table>-->
					
					
					
					</div>
					
                    <div class="x_content">
                        <br />
                        <form action="" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                            <!--<div class="form-group">
                                <h4><b><?php echo $happinessDetailsArr['happinessQuestion']; ?></b></h4>

                            </div>-->
							<div class="row">
							<input type="hidden" name="clientId" id="clientId" value="<?php echo $_SESSION['client_id']; ?>">
							<input type="hidden" name="startdate" id="startdate" value="<?php echo date("Y-m-d"); ?>">
							
							<input type="hidden" style="display:none;" id="lastday" name="activeU" value="<?php echo date('Y-m-d', strtotime("-1 days")); ?>">
							
							<div class="col-sm-2">
							 <div class="form-group">
                                    <label for="usr">From:</label>
<!--                                    <input type="date" class="form-control" id="usr">-->
                                    <!--<input type="text" id="fromDate" name="FSDate" size="20" class="form-control input" placeholder="YYYY-MM-DD"/>-->
									<input type="text" id="fromDate" name="FSDate" size="20" class="form-control input" placeholder="mm/dd/yyyy"/>
                                </div>
								</div>
								<div class="col-sm-2">
                                <div class="form-group">
                                    <label for="pwd">To:&nbsp;&nbsp;</label>
								<input type="text" id="toDate" class="form-control" name="FSDate" size="20" placeholder="mm/dd/yyyy"/>
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
									?>
									<option value="<?php echo $alldepartmentarray[$i]['department'];?>"><?php echo $alldepartmentarray[$i]['department'];?></option>
									<?php }?>
									</select>
                               
                                </div>
								</div>
								
								<div class="col-sm-3">
								<div class="form-group">
                                    <label for="pwd">Location:&nbsp;&nbsp;</label>
									<select name="locationname" id="locationname" class="form-control">
									<option value="All">All</option>
									<?php 
									for($i=0; $i<count($alllocationarray); $i++)
									{
									
									?>
									<option value="<?php echo $alllocationarray[$i]['location'];?>"><?php echo $alllocationarray[$i]['location'];?></option>
									<?php }?>
									</select>
                                </div>
								</div>								
															
								<div class="col-sm-2">
								<div class="form-group">
								  <label for="pwd">&nbsp;&nbsp;</label>
                                   <button type="button" class="btn btn-info form-control" onclick="return happinessindexcustomgraph();">Submit</button> 
                                </div>
								</div>
								</div>
                        </form>
						<br/>
						<!-------------------- show count ----------------------->
						<div class="row">
						<table class="table">
						<thead>
							<tr>
								<th>Total Respondent</th>
								<th>Fabulous</th>
								<th>Happy</th>
								<th>So - So</th>
								<th>Get Me Out Of Here</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								
								<td><span id="totalhappinesscomment"></span></td>
								<td><span id="totalfabulous"></span></td>
								<td><span id ="totalhappy"></span></td>
								<td><span id ="totalsoso"></span></td>
								<td><span id ="totalgmooh"></span></td>
							</tr>
						</tbody>
						</table>
						</div>
						
						<!-------------------- / show count --------------------->
						
                    </div>
                </div>
            </div>
        </div>

        <!--<input type="hidden" id="surveyId" value="<?php echo $_GET['happinessQuestion']; ?>">
-->



        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="happinessDetails2.php?happinessIndex=Fabulous"><h2>Fabulous</h2></a>
                        <ul class="nav navbar-right panel_toolbox">

                            <li class=""><a class="collapse-link" href="happinessDetails2.php?happinessIndex=Fabulous" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
                            <li class="right"><a class="collapse-link" id="MHdemo"><i class="fa fa-chevron-up"></i></a></li>
							
							 <li class="right"><input type="button" class="btn btn-primary"value="Download" id="capture" /></li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="MHdemo1"  class="form-horizontal form-label-left collapse in">
                            
							<div class="form-group">
							
                                <!--<div id="wordcloud" class="JMDBenepik" ></div> -->
								<div id="canvas">
								<div class="JMDBenepik movable_div" id="wordcloud" ></div>
								</div>

                            </div>
							<!--------------- image capture ------->
							<!--<div class="form-group">
							<div id="design">
							<div id="controls">
							<input type="button" value="Download" id="capture" /><br /><br />	
							</div>
							</div>
							</div>-->
							<!--------------- image capture ------->
							
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="happinessDetails2.php?happinessIndex=Happy"> <h2>Happy</h2></a>
                        <ul class="nav navbar-right panel_toolbox">

                            <li class=""><a class="collapse-link" href="happinessDetails2.php?happinessIndex=Happy" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
                            <li class="right"><a class="collapse-link"id="Hdemo"><i class="fa fa-chevron-up"></i></a>
                            </li>
							
							<li class="right"><input type="button" class="btn btn-primary"value="Download" id="capture1" /></li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="Hdemo1"  class="form-horizontal form-label-left collapse in">
                            <div class="form-group">
                                <div id="canvas1">
								<div id="wordcloud2" class="JMDBenepik movable_div" ></div> 
								</div>
                            </div>
							
							
							
							<!--------------- image capture ------->
							<!--<div class="form-group">
							<div id="design1">
							<div id="controls">
							<input type="button" value="Download" id="capture1" /><br /><br />	
							</div>
							</div>
							</div>-->
							<!--------------- image capture ------->

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="happinessDetails2.php?happinessIndex=So - So"><h2>So - So</h2></a>
                        <ul class="nav navbar-right panel_toolbox">

                            <li class=""><a class="collapse-link" href="happinessDetails2.php?happinessIndex=So - So" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
                            <li class="right"><a class="collapse-link"id="NHdemo"><i class="fa fa-chevron-up"></i></a>
                            </li>

							<li class="right"><input type="button" class="btn btn-primary"value="Download" id="capture2" /></li>
							
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="NHdemo1"  class="form-horizontal form-label-left collapse in">
                            <div class="form-group">
							<div id="canvas2">
                                <div id="wordcloud3" class="JMDBenepik movable_div" ></div> 
							</div>
							</div>
							
							<!--------------- image capture ------->
							<!--<div class="form-group">
							<div id="design2">
							<div id="controls2">
							<input type="button" value="Download" id="capture2" /><br /><br />	
							</div>
							</div>
							</div>-->
							<!--------------- image capture ------->
							
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                <div class="x_panel">
                    <div class="x_title">
                        <a href="happinessDetails2.php?happinessIndex=Get Me Out Of Here"><h2>Get Me Out Of Here</h2></a>
                        <ul class="nav navbar-right panel_toolbox">

                            <li class=""><a class="collapse-link" href="happinessDetails2.php?happinessIndex=Get Me Out Of Here" ><i class="fa fa-info-circle VHinfoIcon" aria-hidden="true"style="font-size:19px;margin-left:18px;"></i></a></li>
                            <li class="right"><a class="collapse-link"id="SHdemo"><i class="fa fa-chevron-up"></i></a>
                            </li>
							
							<li class="right"><input type="button" class="btn btn-primary"value="Download" id="capture3" /></li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="SHdemo1"  class="form-horizontal form-label-left collapse in">
                            <div class="form-group">
							<div id="canvas3">
                                <div id="wordcloud4" class="JMDBenepik movable_div"></div> 
                            </div>
							
							<!--------------- image capture ------->
							<!--<div class="form-group">
							<div id="design3">
							<div id="controls3">
							<input type="button" value="Download" id="capture3" /><br /><br />	
							</div>
							</div>
							</div>-->
							<!--------------- image capture ------->

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
<!-------------------------------------------------------->
 <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Happiness Comment</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
<li class="right"><button type="button" class="btn btn-primary " onclick="return tableexport();" style="float:right;">Export</button></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                       <div class="tab-content">
                           <textarea name="exportdata" id="exportdata" style="display:none" ><?php echo $exprecord; ?></textarea>
 

                            <table id="datatable" class="MyTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Comment</th>

                                    </tr>
                                </thead>

                            </table>  


                        </div>
                                                </div>
                                                </div>
                                                </div>
                                                </div>
</div>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->

<script type='text/javascript'src="build/js/HappinesssDetails.js"></script>
<style>#canvas{
		background-color : white;
		border:none;
		}	
#canvas1{
	background-color : white;
	border:none;
		}	
#canvas2{
		background-color : white;
		border:none;
		}	
#canvas3{
		background-color : white;
		border:none;
		}			
</style>		
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
<!-------------------------- script for image capture ------------------->
<script type="text/javascript">	
		$(function(){
			
		$('#capture').click(function(){
				//get the div content
				div_content = document.querySelector("#canvas")
				//make it as html5 canvas
				html2canvas(div_content).then(function(canvas) {
					//change the canvas to jpeg image
					data = canvas.toDataURL('image/jpeg');
					//then call a super hero php to save the image
					save_img(data,'Fabulous.jpeg');
				});
			});			
		});
		
		$(function(){
			
		$('#capture1').click(function(){
				//get the div content
				div_content = document.querySelector("#canvas1")
				//make it as html5 canvas
				html2canvas(div_content).then(function(canvas) {
					//change the canvas to jpeg image
					data = canvas.toDataURL('image/jpeg');
					//then call a super hero php to save the image
					save_img(data,'Happ.jpeg');
				});
			});			
		});
		
		$(function(){
			
		$('#capture2').click(function(){
				//get the div content
				div_content = document.querySelector("#canvas2")
				//alert(div_content);
				//make it as html5 canvas
				html2canvas(div_content).then(function(canvas) {
					//change the canvas to jpeg image
					data = canvas.toDataURL('image/jpeg');
					//alert(data);
					//then call a super hero php to save the image
					save_img(data,'So-So.jpeg');
				});
			});			
		});
		
		$(function(){
			
		$('#capture3').click(function(){
				//get the div content
				div_content = document.querySelector("#canvas3")
				//make it as html5 canvas
				html2canvas(div_content).then(function(canvas) {
					//change the canvas to jpeg image
					data = canvas.toDataURL('image/jpeg');
					
					//then call a super hero php to save the image
					save_img(data,'Get_Me_Out_Of_Here.jpeg');
				});
			});			
		});
		
		//to save the canvas image
		
		
function save_img(data,imgname){

/*****************************/			
//var w = open();
//w.location = data;
/*****************************/
//alert(data);
/******************** new window **********************/
var img = document.createElement('img');
img.src = data;
img.style.cssFloat  = "left";
img.style.border  = "1px solid black";
var a = document.createElement('a');
//a.setAttribute("download", "wordcloud.jpeg");
a.setAttribute("download", imgname);
a.setAttribute("href", data);
a.appendChild(img);
var w = open();
w.document.title = 'Download Image';
w.document.body.innerHTML = '<b style="color:red;">Click On Image for Download</b><br><br><br>';
w.document.body.style.backgroundColor = "white";
w.document.body.appendChild(a);

/************************* new window ******************/
}
		
</script>
<!-------------------------- / script for image capture ------------------->
<script type="text/javascript" src="http://www.lucaongaro.eu/demos/jqcloud/jqcloud-1.0.0.min.js"></script>
<!-- footer content -->
<footer>
    <div class="pull-right">
        All copyright@<a href="https://www.benepik.com">Benepik.com</a>
    </div>
    <div class="clearfix"></div>
</footer>

 

<!-- /footer content -->