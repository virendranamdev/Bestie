<?php
include_once ('header.php');
include_once ('sidemenu.php');
include_once ('topNavigation.php');

require_once('Class_Library/class_Happiness.php');
$objHappiness = new Happiness();

$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];

$happinessQuestionList = $objHappiness->happinessQuestionList($clientId, $empId);
$happinessQuestionListArr = json_decode($happinessQuestionList, true);

$feeds = $happinessQuestionListArr['data'];
?>

<?php 
if(isset($_GET['happQuesId']) && isset($_GET['status']))
{
//echo "<script>alert('hi');</script>";	
$qid = $_GET['happQuesId'];
$fstatus = $_GET['status'];
	if ($fstatus == 1) 
	{
		$qstatus1 = 0;
		$statusresult1 = $objHappiness->status_HappinessQuestion($qid, $qstatus1);
		$sresult = json_decode($statusresult1, true);
		if($sresult['success'] == 1)
		{
		echo "<script>alert('Happiness Index status has changed')</script>";
		echo "<script>window.location='happiness.php'</script>";
		}
		else
		{
		echo "<script>alert('Happiness Index status not change')</script>";
		echo "<script>window.location='happiness.php'</script>";
		}
		
	}
	else
	{
		$qstatus2 = 1;
		$statusresult2 = $objHappiness->status_HappinessQuestion($qid, $qstatus2);
		$sresult2 = json_decode($statusresult2, true);
		if($sresult2['success'] == 1)
		{
		echo "<script>alert('Happiness Index status has changed')</script>";
		echo "<script>window.location='happiness.php'</script>";
		}
		else
		{
		echo "<script>alert('Happiness Index status not change')</script>";
		echo "<script>window.location='happiness.php'</script>";
		}
	}
}
?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Happiness Index</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <ul class="inlineUL right"><li><a href="create-happiness.php"><button class="btn btn-primary btn-round">Create New Happiness Index</button></a></li><!--<li><a href="wallPredefineTemplate.php"><button class="btn btn-primary btn-round"> Use Predefined Temple</button></a></li>--></ul>
                            </div>


                        </div>

                        <form class="myform form-horizontal form-label-left">

                            <table id="datatable" class="MyTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Questions</th>
                                        <th>Rating</th>
                                        <th>Reaction</th>
                                        <th>Respondents</th><th></th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    foreach ($feeds as $feed) {
                                        ?>

                                        <tr>
                                            <td><a href="happiness-details.php?happinessQuestion=<?php echo $feed['surveyId']; ?>"><?php echo date('M d, Y', strtotime($feed['startDate'])); ?></a></td>

                    <!-- <td><center> <i class="slow-spin fa fa-spin fa-clock-o fa-lg liveData"></i></center></td>-->
                                            <td class="questionTD">
                                                <a href="happiness-details.php?happinessQuestion=<?php echo $feed['surveyId']; ?>"> <?php echo $feed['question']; ?> 
                                                </a>
                                            </td>
                                            <td>
                                                <a href="happiness-details.php?happinessQuestion=<?php echo $feed['surveyId']; ?>"><?php echo number_format($feed['respondents'], 1); ?></a>
                                            </td>
                                            <td>
                                                <a href="happiness-details.php?happinessQuestion=<?php echo $feed['surveyId']; ?>"><?php
                                                    if ($feed['ratings'] < 0) {
                                                        echo "Sad";
                                                    } elseif ($feed['ratings'] == 0) {
                                                        echo "Neutral";
                                                    } elseif (($feed['ratings'] > 0) && ($feed['ratings'] < 5)) {
                                                        echo "Great";
                                                    } else {
                                                        echo "Best";
                                                    }
                                                    ?>
                                                </a>
                                            </td>

                                            <td>
                                                <a href="happiness-details.php?happinessQuestion=<?php echo $feed['surveyId']; ?>"><?php echo $feed['totalrespondents']; ?></a>
                                            </td>
                                            <td>
                                                <ul class="wallUL">
												
												<li><a href="happiness.php?happQuesId=<?php echo $feed['quesid']; ?>&status=<?php echo $feed['status']; ?>"><i <?php if($feed['status'] != 1){ ?> style="color:#a94442;" <?php } ?> class="fa fa-circle fa-lg <?php if($feed['status'] == 1){ ?> liveData <?php }else{ ?> expireData <?php } ?> blue-tooltip" data-toggle="tooltip" data-placement="left" <?php if($feed['status'] == 1){ ?> title="Live Post" <?php }else{ ?> title="Expired Post" <?php } ?>></i></li>
												
                                                    <li><a href="create-happiness.php?happinessQuestion=<?php echo $feed['surveyId'];?>"><i class="fa fa-edit fa-lg"></i></a></li>
                                                </ul> 
                                            </td>
                                        </tr>

                                    <?php } ?>
                                    <!--
                                <tr>
                                    <td><a href="happiness-details.php">Mar 23, 2017</a></td>

                                    <td class="questionTD"><a href="happiness-details.php"> What’s its history? When was it founded? By whom? Have there been major milestones such as mergers, changes in direction, etc.?</a></td>
                                    <td><a href="happiness-details.php">Good</a></td><td><a href="happiness-details.php">2</a></td>

                                    <td><ul class="wallUL">
                                            <a href="create-happiness.php"><li><i class="fa fa-edit fa-lg"></i></li></a>

                                        </ul> </td>
                                </tr> 
                                <tr>
                                    <td><a href="happiness-details.php">Mar 22, 2017</a> </td>
                                    <td class="questionTD"><a href="happiness-details.php">What’s your organization’s mission? What’s the specific reason it exists?</a></td>
                                    <td><a href="happiness-details.php">Not Good</a></td><td><a href="happiness-details.php">0</a></td>

                                    <td><ul class="wallUL">
                                            <a href="create-happiness.php"><li><i class="fa fa-edit fa-lg"></i></li></a>

                                        </ul> </td>
                                </tr>
                                <tr>
                                    <td><a href="happiness-details.php">Mar 20, 2017 </a></td>
                                    <td class="questionTD"><a href="happiness-details.php">What’s its history? When was it founded? By whom? Have there been major milestones such as mergers, changes in direction, etc.?</a></td>
                                    <td><a href="happiness-details.php">Best</a></td><td><a href="happiness-details.php">6</a></td>

                                    <td><ul class="wallUL">
                                            <a href="create-happiness.php"><li><i class="fa fa-edit fa-lg"></i></li></a>

                                        </ul> </td>
                                </tr>
                                    -->


                                </tbody>
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
       