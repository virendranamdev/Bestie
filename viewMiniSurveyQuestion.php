<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
       
<?php
session_start();
$clientId = $_SESSION['client_id'];
$sid = $_GET['sid'];

require_once('Class_Library/class_MiniSurvey.php');
$surveyObj = new MiniSurvey();
$data1 = $surveyObj->surveyQuestionDetails($sid, $cid);
$data = json_decode($data1,true);
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
                    <h2>Mini-Survey</h2>
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
                          <th>Posted Date</th>
                          <th>Survey Title</th>
                          <th></th>
                       
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                          for($i = 0; $i<$surveycount;$i++)
                          {
                              $sid = $data['posts'][$i]['surveyId'];
                              $qid = $data['posts'][$i]['questionId'];
                              $otype = $data['posts'][$i]['optionType'];
                          ?>
                          
                        <tr>
                          <td><?php echo $data['posts'][$i]['createdDate'];  ?> </td>
<?php if($otype != 3)
{
    ?>
                   <td class="questionTD"><a href="miniSurvedetails.php?sid=<?php echo $sid; ?>&qid=<?php echo $qid; ?>&otype=<?php echo $otype; ?>"> <?php echo $data['posts'][$i]['question'];  ?></a> </td>        
                          <?php
}
 else {
     ?>
                    <td class="questionTD"><a href="miniSurveyWorddetails.php?sid=<?php echo $sid; ?>&qid=<?php echo $qid; ?>&otype=<?php echo $otype; ?>"> <?php echo $data['posts'][$i]['question'];  ?></a> </td>        
    <?php
 }
    ?>
                         
                        
                           <td><ul class="wallUL">
<li><i class="fa fa-circle fa-lg liveData"data-toggle="tooltip" data-placement="left" title="Expire"></i></li>
<li><i class="fa fa-edit fa-lg"></i></li>
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
       