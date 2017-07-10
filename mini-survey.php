<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
       
<?php
@session_start();
$clientId = $_SESSION['client_id'];
$user_uniqueid =  $_SESSION['user_unique_id'];
$user_type  =  $_SESSION['user_type'];

require_once('Class_Library/class_MiniSurvey.php');
$surveyObj = new MiniSurvey();
$data1 = $surveyObj->getSurveyDetails($clientId, $user_uniqueid, $user_type);
$data = json_decode($data1,true);
//echo "<pre>";
//print_r($data);
//echo "</pre>";
$surveycount = count($data['posts']);
//echo "thisis option count".$optcount;
?>

<?php 
if(isset($_GET['surveyId']) && isset($_GET['status']))
{
//echo "<script>alert('hi');</script>";	
$sid = $_GET['surveyId'];
$status = $_GET['status'];
	if ($status == 1) 
	{
		$status1 = 0;
		$statusresult1 = $surveyObj->SurveyStatusupdate($sid, $status1);
		$sresult = json_decode($statusresult1, true);
		if($sresult['success'] == 1)
		{
		echo "<script>alert('status has changed')</script>";
		echo "<script>window.location='mini-survey.php'</script>";
		}
		else
		{
		echo "<script>alert('status not change')</script>";
		echo "<script>window.location='mini-survey.php'</script>";
		}
		
	}
	else
	{
		$status2 = 1;
		$statusresult2 = $surveyObj->SurveyStatusupdate($sid, $status2);
		$sresult2 = json_decode($statusresult2, true);
		if($sresult2['success'] == 1)
		{
		$statusprevious = 0 ;
		$statusresult3 = $surveyObj->SurveyStatusupdateprevious($sid, $statusprevious);
		$sresult3 = json_decode($statusresult3, true);
		
		echo "<script>alert('status has changed')</script>";
		echo "<script>window.location='mini-survey.php'</script>";
		}
		else
		{
		echo "<script>alert('status not change')</script>";
		echo "<script>window.location='mini-survey.php'</script>";
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
                    <h2>we are listening</h2>
					<?php 
					/*echo "<pre>";
					print_r($data);
					echo "</pre>";*/
					?>
					  <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          <ul class="inlineUL right">
						  <li><a href="create-mini-survey.php"><button class="btn btn-primary btn-round">Create New Mini-Survey</button></a></li>
						  <!--<li><a href="miniSurveyPredefineTemplate.php"><button class="btn btn-primary btn-round"> Use Predefined Temple</button></a></li>-->
						  </ul>
                         </div>


                      </div>

                    <form class="myform form-horizontal form-label-left">
			
<table id="datatable" class="MyTable table table-striped">
                      <thead>
                        <tr>
                          <!--<th>Posted Date</th>-->
						  <th>Duration</th>
                          <th>Survey Title</th>
                          <th>No. of Questions</th>
						  <th>Respondents</th>
                          <th></th>
                        </tr>
                      </thead>


                      <tbody>
                          <?php
                          for($i = 0; $i<$surveycount;$i++)
                          {
                              $sid = $data['posts'][$i]['surveyId'];
                              $qno = $data['posts'][$i]['quesno'];
                          ?>
                          
                        <tr>
                          <!--<td><?php echo $data['posts'][$i]['startDate'];  ?> </td>-->
						  <td><?php echo $data['posts'][$i]['startDate']." - ".$data['posts'][$i]['expiryDate'];  ?> </td>
                          <td class="questionTD"><a href="viewMiniSurveyQuestion.php?sid=<?php echo $sid; ?>"> <?php echo $data['posts'][$i]['surveyTitle'];  ?></a> </td>
                         <td><?php echo $data['posts'][$i]['quesno'];  ?></td>
						 <td><?php echo $data['posts'][$i]['totalrespondents'];  ?></td>
                           <td><ul class="wallUL">
<!--<li><i class="fa fa-circle fa-lg liveData"data-toggle="tooltip" data-placement="left" title="Expire"></i></li>-->

<li><a href="mini-survey.php?surveyId=<?php echo $data['posts'][$i]['surveyId']; ?>&status=<?php echo $data['posts'][$i]['status']; ?>"><i <?php if($data['posts'][$i]['status'] != 1){ ?> style="color:#a94442;" <?php } ?> class="fa fa-circle fa-lg <?php if($data['posts'][$i]['status'] == 1){ ?> liveData <?php }else{ ?> expireData <?php } ?> blue-tooltip" data-toggle="tooltip" data-placement="left" <?php if($data['posts'][$i]['status'] == 1){ ?> title="Live Post" <?php }else{ ?> title="Expired Post" <?php } ?>></i></a></li>

<!--<li><i class="fa fa-edit fa-lg"></i></li>-->
</ul> </td>
                        </tr>
                       
<!--                        <tr>
                          <td>Mar 20, 2017 </td>
                          <td class="questionTD"><a href="miniSurvedetails.php">What’s its history? When was it founded? By whom? Have there been major milestones such as mergers, changes in direction, etc.?</a></td>
<td></td>
                         
                          <td><ul class="wallUL">
<li><i class="fa fa-circle fa-lg expireData"data-toggle="tooltip" data-placement="left" title="Live" ></i></li>
<li><i class="fa fa-edit fa-lg"></i></li>
</ul> </td>
                        </tr>-->
                       
                       
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

<?php include 'footer.php';?>
       