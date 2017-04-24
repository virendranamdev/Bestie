<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
       
<?php
require_once('Class_Library/class_Feedback.php');
$objFeed = new Feedback();

//echo'<pre>';print_r($_SESSION);die;
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$val = 0;

$predefinetempList = $objFeed->PredefinedTemplateList($clientId, $empId);
$templist = json_decode($predefinetempList, true);
?>

<?php
if(isset($_GET['PreTempId']))
{
$templateid = $_GET['PreTempId'];

$deletetempresult = $objFeed->deleteTemplate($templateid,$clientId);
$tempresult = json_decode($deletetempresult,true);

$value = $tempresult['success'];
$message = $tempresult['message'];

if($value == 1)
{
echo "<script>alert('$message')</script>";
echo "<script>window.location='wallPredefineTemplate.php'</script>";
}
else
{
echo "<script>alert('$message')</script>";
echo "<script>window.location='wallPredefineTemplate.php'</script>";
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
                    <h2>Predefined Template</h2>
					
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<?php
				    /*echo "<pre>";
					print_r($templist);
					echo "</pre>";*/
					$count = count($templist['data']);
					for($i=0; $i<$count; $i++)
					{
					if($i%2 == 0)
					{
						
				   ?>
				   

					<div class="bbottom">
						<div class="row">
							<div class="col-xs-10 col-sm-11 col-md-11 col-lg-11">
								<p><?php echo $templist['data'][$i]['question'];?></p>
							</div>

                            <div class=" col-xs-2 col-sm-1 col-md-1 col-lg-1">
							<a href="create-wall.php?PreTempId=<?php echo $templist['data'][$i]['templateId']; ?>">
							<i class="fa fa-edit fa-2x"></i>
							</a>
							
							<a href="wallPredefineTemplate.php?PreTempId=<?php echo $templist['data'][$i]['templateId']; ?>" onclick="return confirm('Are you sure you want to delete this?')">
							<i class="fa fa-trash fa-2x"></i>
							</a>
							
							</div>
						</div>
					</div>
					
					<?php 
					}
					else
					{
					?>
					<div class="bbottom">
						<div class="row"><div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
						
						<a href="create-wall.php?PreTempId=<?php echo $templist['data'][$i]['templateId']; ?>">
						<i class="fa fa-edit fa-2x"></i>
						</a>
						
						<a href="wallPredefineTemplate.php?PreTempId=<?php echo $templist['data'][$i]['templateId']; ?>" onclick="return confirm('Are you sure you want to delete this?')">
						<i class="fa fa-trash fa-2x"></i>
						</a>
						
						</div>
							<div class="col-xs-10 col-sm-11 col-md-11 col-lg-11">
								<p><?php echo $templist['data'][$i]['question'];?>?</p>
							</div>
						</div>
					</div>
					<?php
					}
					}
					?>
					
                  </div>
                </div>
              </div>
</div>
          </div>
        </div>
        <!-- /page content -->

<?php include 'footer.php';?>
       