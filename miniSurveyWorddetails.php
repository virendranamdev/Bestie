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
//print_r($feedDetailsArr);

$data1 = $obj->getSurveyquestionresponse($sid, $qid);
$data = json_decode($data1, true);
//echo "<pre>";
//print_r($data);
//echo "</pre>";
$quesycount = count($data);
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
      //  print_r($words);
        $fieldnames_actual = array();
        $values = array();

        foreach ($words as $k => $v) {
            if ($k != 'fieldnames') {
                $fieldnames_actual[] = $k;
                $values[] = $v;
            }
        }
   //    echo'<pre>';        print_r($fieldnames_actual);        print_r($values);
        ?>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Popular Words</h2>
						
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link right"><i class="fa fa-chevron-up"></i></a>
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
                                $textGraph['size'] = $values[$i]*10;

                                $i++;
                                array_push($globeGraph, $textGraph);
                            }
                            ?>
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

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                       <div class="tab-content">

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
                                            <td class="questionTD"><?php echo $fname . " " . $lname; ?></td>
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

                                                <?php include 'footer.php'; ?>