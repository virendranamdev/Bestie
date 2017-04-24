<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_group.js"></script>    
<link rel="stylesheet" type="text/css" media="all" href="build/css/daterangepicker.css" />
		<script type="text/javascript" src="build/js/moment.js"></script>
		<script type="text/javascript" src="build/js/daterangepicker.js"></script>
		
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
      <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	  <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="styles">
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
function ValidateHappinessQues()
{
    var happinessques = document.form1.happinessques;
    if (happinessques.value == "")
    {
        window.alert("Please Enter Question.");
        happinessques.focus();
        return false;
    }
    return true;
}
</script>
<?php
$happinessquestion = "";
$fromdate = "";
$todate = "";
if(isset($_GET['happinessQuestion']))
{
//echo "<script>alert('hi');</script>";
$questionid = $_GET['happinessQuestion'];
$clientId = $_SESSION['client_id'];
include_once('Class_Library/class_Happiness.php');
$obj = new Happiness();
$happinessquesdetails = $obj->getSingleHappinessDetail($clientId,$questionid);
$Hquesdetails = json_decode($happinessquesdetails , true);
$happinessquestion = $Hquesdetails['happinessQuestion'];
$fromdate =  $Hquesdetails['startDate'];
$todate =  $Hquesdetails['expiryDate'];
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
                    <h2>Create New Happiness Index</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
     
                    <form role="form" name="form1" action="Link_Library/link_create_happinessquestion.php" method="POST" class="myform form-horizontal form-label-left" enctype="multipart/form-data" onsubmit="return check();">
					
					<input type="hidden" id="clientid" name="clientid" value="<?php echo $_SESSION['client_id']; ?>"> 
					<input type="hidden" id="userid" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
					<input type="hidden" name="flag" value="20"> 
					
                      <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Question</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Question" name="happinessques" value="<?php echo $happinessquestion; ?>">
                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
					  
					  <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">From Date</label>
                            <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                              <input type="text" class="form-control has-feedback-left" id="single_cal4" aria-describedby="inputSuccess2Status4" name="fromdate" value="<?php echo $fromdate; ?>">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                               </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">To Date</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control has-feedback-left" id="single_cal3" aria-describedby="inputSuccess2Status3" name="todate" value="<?php echo $todate; ?>">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status3" class="sr-only">(success)</span>
                             
                        </div>
                      </div>
					  
					  <!--<div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Time</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <input type="time" class="form-control has-feedback-left" id="inputSuccess2" name="time">
                        <span class="fa fa-clock-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>-->
					  
					<!---------------- group --------------------->
					<input type="radio" style="display:none;" name="optradio" id="sendTOAll" value="All" checked>
					<input type="radio" style="display:none;" name="optradio"id="sendToSelected" value="Selected">
					<textarea style="display:none;" id ="allids" name="all_user" height="660"></textarea>
					<textarea style="display:none;" id="selectedids" name="selected_user"></textarea>
					<!---------------- / group --------------------->
                      
                      <div class="ln_solid"></div>
					
					<?php if(!isset($_GET['happinessQuestion']))
					{ ?>
                      <div class="form-group">
                        <div class="col-md-12"><center>
                          <button type="submit" class="btn btn-round btn-primary" onclick="return ValidateHappinessQues();">Submit</button>
                          <button type="button" class="btn btn-round btn-warning">Cancel</button>
                    </center></div>
                      </div>
					<?php } else {?>
						<div class="form-group">
						<input type="hidden" name="questionid" value="<?php echo $_GET['happinessQuestion']; ?>">
                        <div class="col-md-12"><center>
                        <button type="submit" name="updatehappinessques" class="btn btn-round btn-primary" onclick="return ValidateHappinessQues();">Update</button>
						</center></div>
						</div>
	<?php } ?>

                    </form>



                  </div>
                </div>
              </div>
</div>
          </div>
        </div>
        <!-- /page content -->




      

      
<?php include 'footer.php';?>
       