<?php
include 'header.php';
include 'sidemenu.php';
include 'topNavigation.php';
require_once('Class_Library/class_MiniSurvey.php');
$obj = new MiniSurvey();
require_once('Class_Library/class_Feedback.php');
$objFeed = new Feedback();
session_start();
//echo'<pre>';print_r($_SESSION);die;
$qid = $_GET['qid'];
$sid = $_GET['sid'];
$otype = $_GET['otype'];
$val = 0;

$wordDetails = $obj->getGraphDataforWord($qid, $sid);
$feedDetailsArr = json_decode($wordDetails, true);
//echo'<pre>';print_r($feedDetailsArr);

$feedData = $feedDetailsArr['data'];
//print_r($feedData);
$department = "All";
$location = "All";
$data = $obj->getSurveyquestionresponse($sid, $qid,$department,$location);
//$data = json_decode($data1, true);
//echo "<pre>";
//print_r($data);
//echo "</pre>";
$quesycount = count($data);
//echo $quesycount;


/* * ************** for export data ************* */
$expd = array();
for ($i = 0; $i < $quesycount; $i++) {
    $expdata['sn'] = $data[$i]['sn'] = $i + 1;
    $expdata['comment'] = $data[$i]['answer'];
  
//expdata['accessibility'] = $val[$i]['accessibility'];
    array_push($expd, $expdata);
}
$exprecord = json_encode($expd);

/* * ************** / for export data *********** */

?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>

<!--<script src="js/analytic/downloadanalyticimage.js"></script>-->

<script src="js/analytic/0.5.0-beta3html2canvas.min.js"></script>
<script src="js/exportdata.js"></script>
<script>
    function tableexport() {
        var exdata = document.getElementById('exportdata').value;
         var title = document.getElementById('title').value;
        var jsonData = JSON.parse(exdata);
//alert(exdata);
        if (jsonData.length > 0)
        {
            if (confirm('Are You Sure, You want to Export directory?')) {
                JSONToCSVConvertor1(jsonData, title, true);
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
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up "></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="form-group">
                                <h4><b><?php echo $feedDetailsArr['question']['question']; ?></b></h4>

                            </div>
<!--<div class="form-group"><h5 style="float:right;">Posted Date: 7 Apr 2017</h5></div>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $comments = '';
        foreach ($feedData as $wordData) {
            $comments .= ' /// ' . $wordData['comment'];
        }
        $words = json_decode($objFeed->extractCommonWords($comments), true);
       // print_r($words);
        $fieldnames_actual = array();
        $values = array();

        foreach ($words as $k => $v) {
            if ($k != 'fieldnames') {
                $fieldnames_actual[] = $k;
                $values[] = $v;
            }
        }
 //      echo'<pre>';        print_r($fieldnames_actual);        print_r($values);
        ?>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Popular Words</h2>
						
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link right"><i class="fa fa-chevron-up"></i></a>
                            </li>
							
							<li class="right"><input type="button" class="btn btn-primary"value="Download" id="capture" /></li>

                        </ul>
						
                        <div class="clearfix"></div>
                    </div>
					
					
                    <div class="x_content wordData">
                        <br />
                        <form class="form-horizontal form-label-left input_mask">
						<div id="canvas">
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
                                $textGraph['size'] = $values[$i]*10;

                                $i++;
                                array_push($globeGraph, $textGraph);
                            }
                            
                            ?>
							</div>
                        </form>
                    </div>
                </div>
            </div>
           <textarea style="display:none;" id="textGlobe" ><?php echo json_encode($globeGraph); ?></textarea>
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Word Cloud</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link "><i class="fa fa-chevron-up"></i></a>
                            </li>
							
							<li class="right"><input type="button" class="btn btn-primary"value="Download" id="capture1" /></li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content wordData">
                        <br />
                        <form class="form-horizontal form-label-left">


                            <div class="form-group">
                                <?php require_once('graph/wallGraph.php'); ?>
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
<li class="right"><button type="button" class="btn btn-primary " onclick="return tableexport();" style="float:right;">Export</button></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                       <div class="tab-content">
 <textarea name="exportdata" id="exportdata" style="display:none;"><?php echo $exprecord; ?></textarea>
 <textarea name="exportdata" id="title" style="display:none;"><?php echo $data[0]['question']; ?></textarea>

                            <table id="datatable" class="MyTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Answer</th>

                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    for ($k = 0; $k < $quesycount; $k++) {

                                        $answer = $data[$k]['answer'];
                                        $date = $data[$k]['answeredDate'];
                                        $fname = $data[$k]['firstName'];
                                        $lname = $data[$k]['lastName'];

    ?>

                                        <tr>
                                            <td><?php echo $date; ?></td>
                                            <td class="questionTD">Anonymous</td>
<!--                                     <td class="questionTD"><?php echo $fname . " " . $lname; ?></td>-->
                                            <td><?php echo $answer; ?></td>
                                        </tr>

    <?php
}
?>
                                </tbody>
                            </table>  


                        </div>
                                                </div>
                                                </div>
                                                </div>
                                                </div>


                                                </div>
                                                </div>
                                                <!-- /page content -->
<style>#canvas{
		background-color : white;
		}		
</style>
<script type="text/javascript">
            			
	$("#capture").click(function(){
	html2canvas([document.getElementById('canvas')], {
    onrendered: function (canvas) 
	{
    var data = canvas.toDataURL('image/jpeg');
	//alert(data);		
	save_img(data,'popularwords.jpeg');
    }
    });
  });
  
  
  $("#capture1").click(function(){
		
    html2canvas($("#canvas1"), {
        onrendered: function(canvas) {
			//alert(canvas);
            // canvas is the final rendered <canvas> element
            var data = canvas.toDataURL("image/jpeg");
			
			//alert(data);
           
			save_img(data,'wordcloud.jpeg');
           // window.open(myImage);
        }
    });
  });

			function save_img(data, imgname) {
                //alert(data);
                var img = document.createElement('img');
                img.src = data;
				img.style.cssFloat  = "left";
				img.style.border  = "1px solid black";
                var a = document.createElement('a');
				a.setAttribute("download", imgname);
                a.setAttribute("href", data);
                a.appendChild(img);
                var w = open();
                w.document.title = 'Download Image';
                w.document.body.innerHTML = '<b style="color:red;">Click On Image for Download</b><br><br><br>';
                w.document.body.appendChild(a);
            }

            /******************************** / download image *********************/
        </script>
												
                                                <?php include 'footer.php'; ?>