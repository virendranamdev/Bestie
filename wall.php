<?php
include 'header.php';
include 'sidemenu.php';
include 'topNavigation.php';
?>
<script>
	$('#datatable').dataTable({
		aaSorting: [[0, 'desc']]
	});
</script>
<?php
require_once('Class_Library/class_Feedback.php');
$objFeed = new Feedback();

//echo'<pre>';print_r($_SESSION);die;
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$val = 0;

$feedList = $objFeed->feedbackList($clientId, $empId);
$feedListArr = json_decode($feedList, true);

$feeds = $feedListArr['data'];
?>

<?php 
if(isset($_GET['feedId']) && isset($_GET['status']))
{
$fid = $_GET['feedId'];
$fstatus = $_GET['status'];
	if ($fstatus == "Live") {
		$fstatus1 = "Expired";
		$statusresult1 = $objFeed->status_FeedbackWall($fid, $fstatus1);
		$sresult = json_decode($statusresult1, true);
		if($sresult['success'] == 1) {
			echo "<script>alert('Feedback Wall status has changed')</script>";
			echo "<script>window.location='wall.php'</script>";
		} else {
			echo "<script>alert('Feedback Wall status not change')</script>";
			echo "<script>window.location='wall.php'</script>";
		}	
	}
	else
	{
		$fstatus2 = "Live";
		$statusresult2 = $objFeed->status_FeedbackWall($fid, $fstatus2);
		$sresult2 = json_decode($statusresult2, true);
		if($sresult2['success'] == 1)
		{
		echo "<script>alert('Feedback Wall status has changed')</script>";
		echo "<script>window.location='wall.php'</script>";
		}
		else
		{
		echo "<script>alert('Feedback Wall status not change')</script>";
		echo "<script>window.location='wall.php'</script>";
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
                        <h2>Vibes</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <ul class="inlineUL right"><li><a href="create-wall.php"><button class="btn btn-primary btn-round">Create New Feedback Wall</button></a></li><li><a href="wallPredefineTemplate.php"><button class="btn btn-primary btn-round"> Use Predefined Template</button></a></li></ul>
                            </div>

                        </div>
                        <form class="myform form-horizontal form-label-left">



                            <p class="text-muted font-13 m-b-30">
                            </p>

                            <table id="datatable" class="MyTable table table-striped" >
                                <thead>
                                    <tr>
                                        <th>Duration</th>
                                        <th>Topic</th> 
                                        <th>Questions</th>
                                        <th></th>

                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    foreach ($feeds as $feed) {
                                        ?>
                                        <tr>
                                            <td><a href="wall-details.php?feedId=<?php echo $feed['feedbackId']; ?>"><?php echo date('M d, Y', strtotime($feed['publishingTime'])) . '' . (($feed['unpublishingTime'] === '0000-00-00 00:00:00')?'':' - '.date('M d, Y', strtotime($feed['unpublishingTime']))); ?></a></td>

                                            <td class=""> <a href="wall-details.php?feedId=<?php echo $feed['feedbackId']; ?>"> <?php echo $feed['feedbackTopic']; ?> </a>
                                            </td> 
                                            <td class="questionTD"> <a href="wall-details.php?feedId=<?php echo $feed['feedbackId']; ?>"> <?php echo $feed['feedbackQuestion']; ?> </a>
                                            </td>
                                            <td>
                                <ul class="wallUL">
                                    <li>
                                    <?php if($feed['status'] == "Live") { ?>
		                      	<a href="wall.php?feedId=<?php echo $feed['feedbackId']; ?>&status=<?php echo $feed['status']; ?>"> 
	                            <?php } ?>
		                            <i <?php if($feed['status'] != "Live"){ ?> style="color:#a94442;" <?php } ?> class="fa fa-circle fa-lg <?php if($feed['status'] == "Live"){ ?> liveData <?php }else{ ?> expireData <?php } ?> blue-tooltip" data-toggle="tooltip" data-placement="left" <?php if($feed['status'] == "Live"){ ?> title="Live Post" <?php }else{ ?> title="Expired Post" <?php } ?>></i>
		                    <?php if($feed['status'] != "Live"){ ?> 
					</a>
	                      	    <?php } ?>
                                    </li>
                                    <?php if($feed['status'] == "Live"){ ?>
                                    <li>
                                    	<a href="create-wall.php?feedId=<?php echo $feed['feedbackId']; ?>"><i class="fa fa-edit fa-lg"></i></a>
                                    </li>
                                    <?php } ?>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php } ?>

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
       
