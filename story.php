<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>

<?php
require_once('Class_Library/class_achiverstory.php');
$objAchiever = new AchiverStory();
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];

if(isset($_GET['storyId']) && isset($_GET['status']))
{
//echo "<script>alert('hi');</script>";	
$storyid = $_GET['storyId'];
$fstatus = $_GET['status'];
	if ($fstatus == 1) 
	{
		$astatus1 = 0;
		$statusresult1 = $objAchiever->status_Post($storyid, $astatus1);
		$sresult = json_decode($statusresult1, true);
				
		if($sresult['success'] == 1)
		{
		
		echo "<script>alert('status has changed')</script>";
		echo "<script>window.location='story.php'</script>";
		}
		else
		{
		echo "<script>alert('status not change')</script>";
		echo "<script>window.location='story.php'</script>";
		}
		
	}
	else
	{
		$astatus2 = 1;
		$statusresult2 = $objAchiever->status_Post($storyid, $astatus2);
		$sresult2 = json_decode($statusresult2, true);
		
		
		if($sresult2['success'] == 1)
		{
		$type = "AStory";
		$flag = 16;
		//$preachieverres = $objAchiever->statusPreviousStory($clientId, $storyid, $type, $flag);
		//$achiverarray = json_decode($preachieverres, true);
		
		echo "<script>alert('status has changed')</script>";
		echo "<script>window.location='story.php'</script>";
		
		}
		else
		{
		echo "<script>alert('status not change')</script>";
		echo "<script>window.location='story.php'</script>";
		}
	}
}
?>
<?php

$achieverList = $objAchiever->getAchiverListDetails($clientId);
$achieverListArr = json_decode($achieverList, true);
/*echo "<pre>";
print_r($achieverListArr);
echo "</pre>";*/

?>  



        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2> Colleague Stories</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          <ul class="inlineUL right"><li><a href="create-story.php"><button class="btn btn-primary btn-round">Create New Colleague Story</button></a></li><!--<li><a href="wallPredefineTemplate.php"><button class="btn btn-primary btn-round"> Use Predefined Temple</button></a></li>--></ul>
                         </div>


                      </div>

                    <form class="myform form-horizontal form-label-left">
			
<table id="datatable" class="MyTable table table-striped">
                      <thead>
                        <tr>
                          <th>Posted Date</th><th>About Story</th><th>Title</th><th>Total Like</th><th>Total Comment</th>
                          
                         
                          <th></th>
                        </tr>
                      </thead>


                      <tbody>
					    <?php for($i=0; $i<count($achieverListArr['Data']); $i++)
						{
						?>
                        <tr>
                          <td><a href="story-details.php"><?php echo $achieverListArr['Data'][$i]['createdDate'];?> </a></td><td><a href="story-details.php"><?php echo $achieverListArr['Data'][$i]['achieverName'];?></a> </td>

                          <!-- <td><center> <i class="slow-spin fa fa-spin fa-clock-o fa-lg liveData"></i></center></td>-->
                          <td class="questionTD"><a href="story-details.php"><?php echo $achieverListArr['Data'][$i]['title'];?></a> </td><td><a href="story-details.php"><?php echo $achieverListArr['Data'][$i]['likeCount'];?></a></td><td><a href="story-details.php"><?php echo $achieverListArr['Data'][$i]['commentCount'];?></a></td>
                         
                           <td><ul class="wallUL">
						   
						   <li><a href="story.php?storyId=<?php echo $achieverListArr['Data'][$i]['storyId']; ?>&status=<?php echo $achieverListArr['Data'][$i]['status']; ?>"><i <?php if($achieverListArr['Data'][$i]['status'] != 1){ ?> style="color:#a94442;" <?php } ?> class="fa fa-circle fa-lg <?php if($achieverListArr['Data'][$i]['status'] == 1){ ?> liveData <?php }else{ ?> expireData <?php } ?> blue-tooltip" data-toggle="tooltip" data-placement="left" <?php if($achieverListArr['Data'][$i]['status'] == 1){ ?> title="Live Post" <?php }else{ ?> title="Expired Post" <?php } ?>></i></li>
						  
<li><a href="create-story.php?storyid=<?php echo $achieverListArr['Data'][$i]['storyId'];?>"><i class="fa fa-edit fa-lg"></i></a></li>

</ul> </td>
                        </tr>
						<?php
						}
						?>
						
						<!--
                        <tr>
                          <td><a href="story-details.php">Mar 23, 2017</a></td><td><a href="story-details.php">Vishal</a></td>

                           <td class="questionTD"><a href="story-details.php"> What’s its history? When was it founded? By whom? Have there been major milestones such as mergers, changes in direction, etc.?</a></td>
<td><a href="story-details.php">22 </a></td><td><a href="story-details.php">2</a></td>
                         
                          <td><ul class="wallUL">
<li><a href="edit-story.php"><i class="fa fa-edit fa-lg"></i></a></li>

</ul> </td>
                        </tr> <tr>
                          <td><a href="story-details.php">Mar 22, 2017</a> </td> <td><a href="story-details.php">Ameen</a> </td>
                          <td class="questionTD"><a href="story-details.php">What’s your organization’s mission? What’s the specific reason it exists?</a></td>
                          <td><a href="story-details.php">8</a> </td><td><a href="story-details.php">3</a></td>
                         
                          <td><ul class="wallUL">
<li><a href="edit-story.php"><i class="fa fa-edit fa-lg"></i></a></li>

</ul> </td>
                        </tr>
                        <tr>
                          <td><a href="story-details.php">Mar 20, 2017 </a></td><td><a href="story-details.php">Monika</a> </td>
                          <td class="questionTD"><a href="story-details.php">What’s its history? When was it founded? By whom? Have there been major milestones such as mergers, changes in direction, etc.?</a></td>
<td><a href="story-details.php">10</a></td><td><a href="story-details.php">4</a></td>
                         
                          <td><ul class="wallUL">
<li><a href="edit-story.php"><i class="fa fa-edit fa-lg"></i></a></li>

</ul> </td>
                        </tr>-->
                       
                       
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

<?php include 'footer.php';?>
       