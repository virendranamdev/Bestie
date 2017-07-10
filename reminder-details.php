<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
     
<link href="build/css/story-detail.css" rel="stylesheet">	 
<script src="https://code.highcharts.com/highcharts.js"></script>
<script async src="build/js/Chart.min.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
		
<?php       
require_once('Class_Library/class_notification.php');
$notiobj = new notification();
$clientId = $_SESSION['client_id'];
$notificationId = $_GET['notiid'];
$flag = $_GET['flag'];
$notidetails = $notiobj->notificationDetails($clientId,$notificationId,$flag);
$notidetailsarr = json_decode($notidetails , true);
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <br>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Notification</h2>
					  <ul class="nav navbar-right panel_toolbox">
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                 <div class="form-group">
                    <h4><b><?php echo $notidetailsarr['data']['title'];?></b></h4>
                    
                  </div>
				  <div class="form-group">
                    <h4><?php echo $notidetailsarr['data']['content'];?></h4>
                    
                  </div>
				  <div class="form-group">
                    <img src = "<?php echo $notidetailsarr['data']['image'];?>" style="img img-responsive">
                    
                  </div>
<div class="form-group"><h5 style="float:right;"><?php echo $notidetailsarr['data']['createdDate'];?></h5></div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

			<!--
			<div class="row">
              <div class="col-md-3 col-xs-6 col-sm-3 col-lg-3">
                <div class="x_panel height" >
                  <div class="x_title">
                    <h2>By Date</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
					
					<div class="radio">
  <label><input type="radio" name="optradio">Previouse Day</label>
</div>
<div class="radio">
  <label><input type="radio" name="optradio">Last 7 days</label>
</div>
<div class="radio">
  <label><input type="radio" name="optradio">Last 30 Days</label>
</div>

                  </div>
                </div>

               



              </div>

              <div class="col-md-9 col-xs-6 col-md-9 col-lg-9">
                <div class="x_panel height">
                  <div class="x_title">
                    <h2>Total View</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div><br>
                  <center><div>
    <canvas id="myChart"></canvas>
</div></center>
<br>
<center><div id="js-legend" class="chart-legend"></div></center>
				  
                </div>
              </div>
			</div>-->
		
     
          </div>
        </div>
        <!-- /page content -->
		
		<!--<script src="build/js/reminderGraph.js"></script>-->
	
		
      <?php include 'footer.php';?>