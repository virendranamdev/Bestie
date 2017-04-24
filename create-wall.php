<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_group.js"></script>
<script src="js/validation/createPostValidation.js"></script>
<?php
include_once ('header.php');
include_once ('sidemenu.php');
include_once ('topNavigation.php');

//include_once('Class_Library/api_getgroup.php');
?>
<?php
$feedbackquestion = "";
$fromdate = "";
$todate = "";
if(isset($_GET['feedId']))
{
//echo "<script>alert('hi');</script>";
$Feedback_Id = $_GET['feedId'];
$clientId = $_SESSION['client_id'];
include_once('Class_Library/class_Feedback.php');
$obj = new Feedback();
$feedbackdetails = $obj->getSingleFeedbackDetail($clientId,$Feedback_Id);
$fdetails = json_decode($feedbackdetails , true);
/*echo "<pre>";
print_r($fdetails);
echo "</pre>";*/
$feedbackquestion = $fdetails['feedbackQuestion'];
$fromdate = $fdetails['publishingTime'];
$todate = $fdetails['unpublishingTime'];
}


if(isset($_GET['PreTempId']))
{
//echo "<script>alert('hi');</script>";
$PreTempId = $_GET['PreTempId'];
$clientId = $_SESSION['client_id'];
include_once('Class_Library/class_Feedback.php');
$obj = new Feedback();
$predefinedtempdetails = $obj->getSinglepredefinedtemp($clientId,$PreTempId);
$pretempdetails = json_decode($predefinedtempdetails , true);
/*echo "<pre>";
print_r($pretempdetails);
echo "</pre>";*/
$feedbackquestion = $pretempdetails['data'][0]['question'];
$fromdate = "";
$todate = "";
}

?>
<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
<script>
function ValidateUpdateFeedback()
{
    var feedbackQuestion = document.form1.feedbackQuestion;
    if (feedbackQuestion.value == "")
    {
        window.alert("Please Enter Question.");
        feedbackQuestion.focus();
        return false;
    }
    return true;
}
</script>
<link rel="stylesheet" href="build/css/feedbackWall-create-wall.css" >

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create New Feedback Wall</h2>
												
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <a href="wallPredefineTemplate.php"><button class="btn btn-primary pull-right btn-round"> Use Predefined Template</button></a>

                        <br ><br ><br >
                        <form name="form1" action="Link_Library/link_add_feedback.php" method="post" class="myform form-horizontal form-label-left" onsubmit="return check();">

                            <div class="form-group">
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12">Question</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                                    <input type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
									<input type="hidden" name = "flag" value="23">		
									<input type="hidden" name = "flagvalue" value="Feedback : ">	
									
									<input type="text" name="feedbackQuestion" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Question" value="<?php echo $feedbackquestion ;?>">
                                    <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">From Date</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type="text" name="publishingDate" class="form-control has-feedback-left" id="single_cal4" placeholder="Publish Date" aria-describedby="inputSuccess2Status4" value="<?php echo $fromdate; ?>">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">To Date</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="unpublishingDate" class="form-control has-feedback-left" id="single_cal3" placeholder="Unpublish Date" aria-describedby="inputSuccess2Status3" value="<?php echo $todate; ?>">
                                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status3" class="sr-only">(success)</span>

                                </div>
                            </div>
<?php if(!isset($_GET['feedId']))
	{ ?>
							<!------------------------------------------------------------->
							<?php if(!isset($_GET['PreTempId']))
							{?>
							<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
							<div class="col-md-9 col-sm-9 col-xs-12">
                                <div class="checkbox"> <label><input type="checkbox" name="pretempcheck"> Save as a predefined template?</label>  </div>
							</div>
							</div>
							<?php 
							}
							?>
							
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Group</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">

                                    <span id="inputSuccess2Status3" class="sr-only">(success)</span>


                                    <script type="text/javascript" src="http://code.jquery.com/jquery-git.js"></script>
                                    <script type="text/javascript" src="build/js/feedbackwall_selectGroup.js"></script>



                                    <script type='text/javascript'>
                                    </script>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><label class="radio-inline"><input type="radio" name="optradio" id="sendTOAll" value="All" checked>Send to All Group</label>
                                            <label class="radio-inline"><input type="radio" name="optradio"id="sendToSelected" value="Selected">Send to Selected Group</label></div>

                                        <div class="selectedGroupData">

                                            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                <div class="subject-info-box-1"><center><h2>All Group</h2></center>
												
                                                   <select multiple="multiple" id='lstBox1' class="form-control">
                                                        <!--<option value="ajax">Ajax</option>
                                                        <option value="jquery">jQuery</option>
                                                        <option value="javascript">JavaScript</option>
                                                        <option value="mootool">MooTools</option>
                                                        <option value="prototype">Prototype</option>
                                                        <option value="dojo">Dojo</option>
                                                        <option value="asp">ASP.NET</option>
                                                        <option value="c#">C#</option>
                                                        <option value="vb">VB.NET</option>
                                                        <option value="java">Java</option>
                                                        <option value="php">PHP</option>
                                                        <option value="python">Python</option>-->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                                <div >
                                                    <br><br><br><br>
                                                    <!--<button type="button" class="btn newb btn-primary"id='btnAllRight'value='>>' > >> </button><br>-->
                                                    <button type="button" class="btn newb btn-primary"id='btnRight'value='>' > Add </button><br>
                                                    <button type="button" class="btn newb btn-primary"id='btnLeft'value='<' > Remove </button><br>
                                                    <!--<button type="button" class="btn newb btn-primary"id='btnAllLeft'value='<<' > >> </button><br>-->

                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                <div ><center><h2>Selected Group</h2></center>
                                                    <select multiple="multiple" id='lstBox2' class="form-control" name="selectedvalue[]">
                                                    </select>
                                                </div>
                                            </div>
											
											
                                        </div>
										
										<!------------------------------------->
											<textarea id ="allids" style="display:none" name="all_user" height="660"></textarea>
											<textarea id="selectedids" style="display:none" name="selected_user"></textarea>
											<!------------------------------------->
											
											
											
                                    </div>

                                    <div class="clearfix"></div>

                                </div>
                            </div>

                            <div class="ln_solid"></div>					
                            <div class="form-group">
                                <div class="col-md-12"><center>
										
                                        <button type="submit" name="addFeedback" class="btn btn-round btn-primary" onclick="return ValidateFeedbackWall();">Submit</button>
                                        <button type="button" class="btn btn-round btn-warning">Cancel</button>
                                    </center></div>
                            </div>
							
							<!------------------------------------------------------------->
<?php 
} 
else
{
?>
							<div class="ln_solid"></div>

                            <div class="form-group">
                                <div class="col-md-12"><center>
										<input type="hidden" name="feedbackid" value="<?php echo $_GET['feedId']; ?>">
										
                                        <button type="submit" name="updateFeedback" class="btn btn-round btn-primary" onclick="return ValidateUpdateFeedback();">Update</button>
                                        <!--<button type="button" class="btn btn-round btn-warning">Cancel</button>-->
                                    </center></div>
                            </div>
<?php
}
?>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<script src="build/js/feedbackwall_selectGroup.js"type="text/script"></script>

<?php include 'footer.php'; ?>
       