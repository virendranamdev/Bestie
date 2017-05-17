<?php include 'header.php'; ?>
<?php include 'sidemenu.php'; ?>
<?php include 'topNavigation.php'; ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/analytic/surveyQuestionResult.js"></script>
<script type="text/javascript">

    var qid = '<?php echo $_GET['qid']; ?>';
    var sid = '<?php echo $_GET['sid']; ?>';
    var otype = '<?php echo $_GET['otype']; ?>';
    var department = "All";
    var location1 = "All";
//      alert(qid);
//     alert(sid);
//     alert(otype);
//    alert(location1);
    if (otype == 1)
    {
        showRadioGraph(qid, sid,department, location1,'<?php echo SITE; ?>');
    }
    else
    {
     
        showEmojiGraph(qid, sid,department, location1);
    }
    
   function getSurveyRadioResponse()
    {
     //   alert("hello");
        var qid1 = document.getElementById("qid").value;;
        var sid1 = document.getElementById("sid").value;;
         var otype = document.getElementById("otype").value;;
   
   var  department1= document.getElementById("alldepartments").value;
   var  location2 = document.getElementById("locationname").value;
   
   if(otype == 1)
   {
    showRadioGraph(qid1, sid1,department1, location2,'<?php echo SITE; ?>');
    }
    else
    {
      
        showEmojiGraph(qid1, sid1,department1, location2);
    }
        
    } 
    
</script>

<?php
session_start();
$clientId = $_SESSION['client_id'];
$sid = $_GET['sid'];
$questionid = $_GET['qid'];
$otype = $_GET['otype'];

//require_once('Class_Library/class_MiniSurvey.php');
include_once("Class_Library/class_getDepartment.php");
//$surveyObj = new MiniSurvey();
$department = new Department();

$getalldepartment = $department->getDepartment($clientId);
$alldepartmentarray = json_decode($getalldepartment, true);

$locationjson = $department->getLocation($clientId);
$locationarray = json_decode($locationjson, true);

//$data1 = $surveyObj->getSurveyquestionresponse($sid, $questionid);
//$data = json_decode($data1, true);
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//$quesycount = count($data);
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Survey Response</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                     
                            <div class="row">
                                <input type="hidden" name="sid" id="sid" value="<?php echo $_GET['sid']; ?>">
                                <input type="hidden" name="qid" id="qid" value="<?php echo $_GET['qid']; ?>">
               <input type="hidden" name="otype" id="otype" value="<?php echo $_GET['otype']; ?>">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pwd">Department:&nbsp;&nbsp;</label>
                                        <select name="alldepartments" id="alldepartments" class="form-control">
                                            <option value="All">All</option>
                                            <?php
                                            for ($i = 0; $i < count($alldepartmentarray); $i++) {
                                                ?>
                                                <option value="<?php echo $alldepartmentarray[$i]['department']; ?>"><?php echo $alldepartmentarray[$i]['department']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="pwd">Location:&nbsp;&nbsp;</label>
                                        <select name="locationname" id="locationname" class="form-control">
                                            <option value="All">All</option>
                                            <?php
                                            for ($i = 0; $i < count($locationarray); $i++) {
                                                ?>
                                                <option value="<?php echo $locationarray[$i]['location']; ?>"><?php echo $locationarray[$i]['location']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>								

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="pwd">&nbsp;&nbsp;</label>
                                        <button type="button" class="btn btn-info form-control" onclick="return getSurveyRadioResponse();">Submit</button> 
                                    </div>
                                </div>
                            </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                       <h2> <span id ="respondent" style ="color: black;"> </span></h2>
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
                        <div id="comment"></div>
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
                                  
                                </tbody>
                            </table>  

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- /page content -->

<?php include 'footer.php'; ?>
       