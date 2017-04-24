<?php
include_once ('header.php');
include_once ('sidemenu.php');
include_once ('topNavigation.php');

include_once('Class_Library/class_Health_Wellness.php');

$objHealth = new HealthWellness();

$clientId = $_SESSION['client_id'];
$exerciseId = $_GET['health'];
$exercise = $objHealth->getExerciseSingle($clientId, $exerciseId);
?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Health & Wellness Detail</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up "></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> 
					<div class="container mycontainer">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
								
							<h4><b><?php echo $exercise['exercise_name']; ?></h4>	
							</div>
						</div>
						
						
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
									
							<img src="<?php echo $exercise['exercise_image']; ?>" class="img-responsive"/>	
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" >
							<?php echo $exercise['exercise_instruction']; ?>        	
							</div>
						</div>
						
  
</div>
						
						
						
					</div>
<style>
.mycontainer{padding: 0% 10% 2% 10%;}

</style>
                  </div>
                </div>
              </div>
</div>
          </div>
        </div>
        <!-- /page content -->

<?php include 'footer.php';?>
       
