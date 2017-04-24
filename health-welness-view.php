<?php
include_once ('header.php');
include_once ('sidemenu.php');
include_once ('topNavigation.php');

include_once('Class_Library/class_Health_Wellness.php');

$objHealth = new HealthWellness();

$clientId = $_SESSION['client_id'];
$exercise = $objHealth->getExercises($clientId);
?>
<?php 
if(isset($_GET['healthWellnessId']) && isset($_GET['status']))
{
$id = $_GET['healthWellnessId'];
$status = $_GET['status'];
	if ($status == 1) 
	{
		$status1 = 0;
		$statusresult1 = $objHealth->status_HealthWellness($id, $status1);
		$sresult = json_decode($statusresult1, true);
		if($sresult['success'] == 1)
		{
		echo "<script>alert('Health & Wellness status has changed')</script>";
		echo "<script>window.location='health-welness-view.php'</script>";
		}
		else
		{
		echo "<script>alert('Health & Wellness status not change')</script>";
		echo "<script>window.location='health-welness-view.php'</script>";
		}
		
	}
	else
	{
		$status2 = 1;
		$statusresult2 = $objHealth->status_HealthWellness($id, $status2);
		$sresult2 = json_decode($statusresult2, true);
		if($sresult2['success'] == 1)
		{
		echo "<script>alert('Health & Wellness status has changed')</script>";
		echo "<script>window.location='health-welness-view.php'</script>";
		}
		else
		{
		echo "<script>alert('Health & Wellness status not change')</script>";
		echo "<script>window.location='health-welness-view.php'</script>";
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
                        <h2>Health & Wellness</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <ul class="inlineUL right"><li><a href="health-wellness.php"><button class="btn btn-primary btn-round">Create New Health & Wellness</button></a></li><!--<li><a href="wallPredefineTemplate.php"><button class="btn btn-primary btn-round"> Use Predefined Temple</button></a></li>--></ul>
                            </div>


                        </div>

                        <form class="myform form-horizontal form-label-left">

                            <table id="datatable" class="MyTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th><th>Exercise Type</th><th>Title</th><th>Instruction</th><th>Group</th>


                                        <th></th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
//                                        echo'<pre>';print_r($exercise);die;
                                    foreach ($exercise as $val) {
                                        ?>

                                        <tr>
                                            <td><img src="<?php echo $val['exercise_image']; ?>" style="height:30px; width:30px;"></td><td><a href="health-wellness-detail.php?health=<?php echo $val['autoId']; ?>"><?php echo $val['exercise_area']; ?></a> </td>

                                  <!-- <td><center> <i class="slow-spin fa fa-spin fa-clock-o fa-lg liveData"></i></center></td>-->
                                            <td><a href="health-wellness-detail.php?health=<?php echo $val['autoId']; ?>"><?php echo $val['exercise_name']; ?></a> </td><td><a href="health-wellness-detail.php?health=<?php echo $val['autoId']; ?>"><?php echo $val['exercise_instruction']; ?></a></td><td><a href="health-wellness-detail.php?health=<?php echo $val['autoId']; ?>">All Group</a></td>

                                            <td><ul class="wallUL">
											
													<li><a href="health-welness-view.php?healthWellnessId=<?php echo $val['autoId']; ?>&status=<?php echo $val['status']; ?>"><i <?php if($val['status'] != 1){ ?> style="color:#a94442;" <?php } ?> class="fa fa-circle fa-lg <?php if($val['status'] == 1){ ?> liveData <?php }else{ ?> expireData <?php } ?> blue-tooltip" data-toggle="tooltip" data-placement="left" <?php if($val['status'] == 1){ ?> title="Live Post" <?php }else{ ?> title="Expired Post" <?php } ?>></i></li>
											
                                                    <li><a href="health-wellness.php?health=<?php echo $val['autoId']; ?>"><i class="fa fa-edit fa-lg"></i></a></li>

                                                </ul> </td>
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
       