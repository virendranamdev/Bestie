<?php
include 'header.php';
include 'sidemenu.php';
include 'topNavigation.php';

require_once('Class_Library/class_Feedback.php');
$objFeed = new Feedback();
session_start();
//echo'<pre>';print_r($_SESSION);die;
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$feedbackId = $_GET['feedId'];
$val = 0;

$feedDetails = $objFeed->getSingleFeedbackDetail($clientId, $feedbackId);
$feedDetailsArr = json_decode($feedDetails, true);
//echo'<pre>';print_r($feedDetailsArr);die;

$feedData = $feedDetailsArr['data'];
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
                                <h4><b><?php echo $feedDetailsArr['feedbackQuestion']; ?></b></h4>

                            </div>
<div class="form-group"><h5 style="float:right;">Posted Date: 7 Apr 2017</h5></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $comments = '';
        foreach ($feedData as $wordData) {
            $comments .= ' /// ' . $wordData['comment_text'];
        }
        $words = json_decode($objFeed->extractCommonWords($comments), true);

        $fieldnames_actual = array();
        $values = array();

        foreach ($words as $k => $v) {
            if ($k != 'fieldnames') {
                $fieldnames_actual[] = $k;
                $values[] = $v;
            }
        }
//        echo'<pre>';        print_r($fieldnames_actual);        print_r($values);
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
                        <form id="demo-form3" data-parsley-validate class="form-horizontal form-label-left">
                            <?php foreach ($feedData as $feed) { ?>
                                <div class="row">

                                    <div class="col-xs-9 col-sm-9 col-md-10 col-lg-11 "><p class="userresponse"><?php echo $feed['comment_text']; ?></p><p><span class="NoOflikes"><i class="fa fa-heart" aria-hidden="true"></i> <?php echo $feed['totalLikes']; ?>,<span> &nbsp; </i><?php echo date('d M Y', strtotime($feed['CommentDate'])); ?></p></div>

                                                    </div>
                                                    <hr>
                                                <?php } ?>




                                                </form>
                                                </div>
                                                </div>
                                                </div>
                                                </div>


                                                </div>
                                                </div>
                                                <!-- /page content -->

                                                <?php include 'footer.php'; ?>