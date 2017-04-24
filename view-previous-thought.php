<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'header.php';
include 'sidemenu.php';
include 'topNavigation.php';


require_once('Class_Library/class_Thought.php');
require_once('Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
$thought_obj = new ThoughtOfDay();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];
$result = $thought_obj->thoughtDetails($clientid, $user_uniqueid, $user_type);
$getcat = json_decode($result, true);
//print_r($result);
$value = $getcat['posts'];
//echo "<pre>";
//print_r($value);
//echo "</pre>";
$count = count($value);
?>
<?php 
if(isset($_GET['thoughtId']) && isset($_GET['status']))
{
//echo "<script>alert('hi');</script>";	
$pid = $_GET['thoughtId'];
$pstatus = $_GET['status'];
	if ($pstatus == 1) 
	{
		$pstatus1 = 0;
		$statusresult1 = $thought_obj->status_Post($pid, $pstatus1);
		$sresult = json_decode($statusresult1, true);
		if($sresult['success'] == 1)
		{
		echo "<script>alert('Thought status has changed')</script>";
		echo "<script>window.location='view-previous-thought.php'</script>";
		}
		else
		{
		echo "<script>alert('Thought status not change')</script>";
		echo "<script>window.location='view-previous-thought.php'</script>";
		}
		
	}
	else
	{
		$pstatus2 = 1;
		$statusresult2 = $thought_obj->status_Post($pid, $pstatus2);
		$sresult2 = json_decode($statusresult2, true);
		if($sresult2['success'] == 1)
		{
		echo "<script>alert('Thought status has changed')</script>";
		echo "<script>window.location='view-previous-thought.php'</script>";
		}
		else
		{
		echo "<script>alert('Thought status not change')</script>";
		echo "<script>window.location='view-previous-thought.php'</script>";
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
                        <h2>View Previous Thought</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <ul class="inlineUL right"><li><a href="create-thought.php"><button class="btn btn-primary btn-round">Create New Thought</button></a></li><!--<li><a href="wallPredefineTemplate.php"><button class="btn btn-primary btn-round"> Use Predefined Temple</button></a></li>--></ul>
                            </div>


                        </div>

                        <form class="myform form-horizontal form-label-left">

                            <table id="datatable" class="MyTable table table-striped">
                                <thead>
                                    <tr>
                                        <th>Thought Images</th>
                                        <th>Thought Quote</th>
                                        <th>Created By</th>
                                        <th>Created date</th><th></th>

                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    for ($i = 0; $i < $count; $i++) {
                                        $imagevalue = $value[$i]['thoughtImage'];

                                        if ($imagevalue != "") {
                                            $valueimage = $imagevalue;
                                        } else {
                                            $valueimage = "Poll/poll_img/dummy.png";
                                        }

                                        $thoughtstatus = $value[$i]['status'];
                                        if ($thoughtstatus == 1) {
                                            $act = 'Publish';
                                        } else {
                                            $act = 'Unpublish';
                                        }

                                        if ($thoughtstatus == 1) {
                                            $action = 'Unpublish';
                                        } else {
                                            $action = 'Publish';
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <img style="width: 150px;height: 100px;border-radius: 4px;" src = "<?php echo $imagevalue; ?>" class = "img img-responsive"/>
                                            </td>
                                            <td><?php
                                                if (strlen($value[$i]['message']) > 50) {
                                                    echo substr($value[$i]['message'], 0, 50) . "<b>...</b>";
                                                } else {
                                                    echo $value[$i]['message'];
                                                }
                                                ?></td>
                                            <td><?php
                                                $uid = $value[$i]['createdBy'];
                                                $na = $gt->getUserData($clientid, $uid);
                                                //  echo $na;
                                                $name = json_decode($na, true);
                                                echo $name[0]['firstName'] . " " . $name[0]['lastName'];
                                                ?> </td>
                                            <td > <?php echo $value[$i]['createdDate']; ?></td>

                                            <td><ul class="wallUL">
													<li><a href="view-previous-thought.php?thoughtId=<?php echo $value[$i]['thoughtId']; ?>&status=<?php echo $value[$i]['status']; ?>"><i <?php if($value[$i]['status'] != 1){ ?> style="color:#a94442;" <?php } ?> class="fa fa-circle fa-lg <?php if($value[$i]['status'] == 1){ ?> liveData <?php }else{ ?> expireData <?php } ?> blue-tooltip" data-toggle="tooltip" data-placement="left" <?php if($value[$i]['status'] == 1){ ?> title="Live Post" <?php }else{ ?> title="Expired Post" <?php } ?>></i></li>
											
                                                    <li><a href="create-thought.php?thought=<?php echo $value[$i]['thoughtId']; ?>" ><i class="fa fa-edit fa-lg"></i></a></li>
                                                    <!--<li><i class="fa fa-eye fa-lg"></i></li>-->
                                                </ul> </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </thead>
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
       