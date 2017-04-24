<?php include 'header.php'; ?>
<?php include 'sidemenu.php'; ?>
<?php include 'topNavigation.php'; ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/analytic/surveyQuestionResult.js"></script>
<script type="text/javascript">

    var qid = '<?php echo $_GET['qid']; ?>';
    var sid = '<?php echo $_GET['sid']; ?>';
    var otype = '<?php echo $_GET['otype']; ?>';
  //  alert(qid);
   // alert(sid);
   // alert(otype);
    if (otype == 1)
    {
        showRadioGraph(qid, sid);
    }
    else
    {
        showEmojiGraph(qid, sid);
    }
</script>

<?php
session_start();
$clientId = $_SESSION['client_id'];
$sid = $_GET['sid'];
$questionid = $_GET['qid'];
$otype = $_GET['otype'];

require_once('Class_Library/class_MiniSurvey.php');
$surveyObj = new MiniSurvey();
$data1 = $surveyObj->getSurveyquestionresponse($sid, $questionid);
$data = json_decode($data1, true);
//echo "<pre>";
//print_r($data);
//echo "</pre>";
$quesycount = count($data);
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php $data[0]['question']; ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right">
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content "> 
                        <?php
                        if ($otype == 1) {
                            ?>
                            <div id="MiniSurveyQuestion" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                            <?php
                        } else {
                            ?>
                            <div id="MiniSurveyEmoji" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>   
                            <?php
                        }
                        ?>


                        <hr>
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

                                        $answer1 = $data[$k]['answer'];
                                        $date = $data[$k]['answeredDate'];
                                        $fname = $data[$k]['firstName'];
                                        $lname = $data[$k]['lastName'];

                                        if ($answer1 == 5) {
                                            $answer = 'Good';
                                        } elseif ($answer1 == 10) {
                                            $answer = 'Very Good';
                                        } elseif ($answer1 == -5) {
                                            $answer = 'Sad';
                                        } else {
                                            $answer = 'ok';
 }
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

    <!-- /page content -->

<?php include 'footer . php'; ?>
       