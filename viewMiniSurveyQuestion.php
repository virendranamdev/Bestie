<?php include 'header.php'; ?>
<?php include 'sidemenu.php'; ?>
<?php include 'topNavigation.php'; ?>
<script>
	$('#datatable').dataTable({
		aaSorting: [[0, 'desc']]
	});
</script>
<?php
session_start();
$clientId = $_SESSION['client_id'];
$sid = $_GET['sid'];
session_start();
$cid = $_SESSION['client_id'];
require_once('Class_Library/class_MiniSurvey.php');
$surveyObj = new MiniSurvey();
$data1 = $surveyObj->surveyQuestionDetails($sid, $cid);
$data = json_decode($data1, true);
//echo "<pre>";
//print_r($data);
//echo "</pre>";
$surveycount = count($data['posts']);
//echo "thisis option count".$optcount;
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $data['posts'][0]['surveyTitle']; ?></h2>



                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> 
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-md-4"><span id ="mode" style ="color: inherit;font-size: 15px;font-weight: 500px; ">Expiry Date: <?php echo $data['posts'][0]['expiryDate']; ?> </span>&nbsp;&nbsp;&nbsp;

                                    <i <?php if ($data['posts'][0]['status'] != 1) { ?> style="color:#a94442;" <?php } ?> class="fa fa-circle fa-lg <?php if ($data['posts'][0]['status'] == 1) { ?> liveData <?php } else { ?> expireData <?php } ?> blue-tooltip" data-toggle="tooltip" data-placement="left" <?php if ($data['posts'][0]['status'] == 1) { ?> title="Live Post" <?php } else { ?> title="Expired Post" <?php } ?>></i></div>
                                    
                                <div class="col-md-4"><span id ="mode" style ="color: inherit;font-size: 15px;font-weight: 500px;">Respondent: <?php echo $data['respondent']['respondent']; ?> </span></div>
                                
                                <div class="col-md-4"> <?php
                                    if ($data['posts'][0]['status'] == 1) {
                                        ?>
                                        <a href="Link_Library/linkSurveyReminder.php?idpost=<?php echo $data['posts'][0]['surveyId']; ?>"><button class="btn btn-primary btn-round">Send Reminder</button></a>
                                        <?php
                                    }
                                    ?>
                                </div>

                            </div>


                        </div>
&nbsp;&nbsp;&nbsp;
                        <form class="myform form-horizontal form-label-left">

                            <table id="datatable" class="MyTable table table-striped">
                                <thead>
                                    <tr>

                                        <th>Survey Question</th>
                                        <th>Survey Type</th>
                                      

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < $surveycount; $i++) {
                                        $sid = $data['posts'][$i]['surveyId'];
                                        $qid = $data['posts'][$i]['questionId'];
                                        $otype = $data['posts'][$i]['optionType'];
                                        ?>

                                        <tr>

                                            <?php
                                            if ($otype != 3) {
                                                ?>
                                                <td class="questionTD"><a href="miniSurvedetails.php?sid=<?php echo $sid; ?>&qid=<?php echo $qid; ?>&otype=<?php echo $otype; ?>"> <?php echo $data['posts'][$i]['question']; ?></a> </td>        
                                                <?php
                                            } else {
                                                ?>
                                                <td class="questionTD"><a href="miniSurveyWorddetails.php?sid=<?php echo $sid; ?>&qid=<?php echo $qid; ?>&otype=<?php echo $otype; ?>"> <?php echo $data['posts'][$i]['question']; ?></a> </td>        
                                                <?php
                                            }
                                            ?>
                                            <td><?php
                                                if ($data['posts'][$i]['optionType'] == 1)
                                                    $status = "Radio Button";
                                                else if ($data['posts'][$i]['optionType'] == 2)
                                                    $status = "Smily Type";
                                                else if ($data['posts'][$i]['optionType'] == 3)
                                                    $status = "Text Response";
                                                else
                                                    $status = "Rating Type";
                                                echo $status;
                                                ?></td>             

                                           
                                        </tr>

                                    </tbody>
                                    <?php
                                }
                                ?>
                            </table>

                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>
       