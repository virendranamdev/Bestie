<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
<?php       
require_once('Class_Library/class_notification.php');
$notiobj = new notification();
$clientId = $_SESSION['client_id'];
$notilist = $notiobj->listNotification($clientId);
$notilistarr = json_decode($notilist , true);
?>
<!----------------- use for change order of data table ----------------------------->
<script src ="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#datatable').DataTable( {
        "order": [[ 0, "desc" ]]
    } );
} );
</script>
<!-------------------------- / use for change order ------------------------>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Notification</h2>
					<?php 
					/*echo "<pre>";
					print_R($notilistarr);
					echo "</pre>";*/
					?>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>-->
                      <!--<li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>-->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          <ul class="inlineUL right"><li><a href="create-reminder.php"><button class="btn btn-primary btn-round">Create New Notification</button></a></li><!--<li><a href="wallPredefineTemplate.php"><button class="btn btn-primary btn-round"> Use Predefined Temple</button></a></li>--></ul>
                         </div>


                      </div>

                    <form class="myform form-horizontal form-label-left">
			
<table id="datatable" class="MyTable table table-striped">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Posted Data</th>
                          <!--<th>Total View</th>-->
                          <th>Notification Type</th>
						  <th>Group</th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php
					  for($i=0; $i<count($notilistarr['data']); $i++)
					  {
						 $flag = $notilistarr['data'][$i]['flagType']; 
						 if($flag == 2)
						 {
							$notitype = 'Message'; 
						 }
						 if($flag == 25)
						 {
							 $notitype = 'Reminder'; 
						 }
						 if($flag == 24)
						 {
							 $notitype = 'Health & Wellness'; 
						 }
						?>
                        <tr>
                          <td><?php echo $notilistarr['data'][$i]['createdDate'];?></td>

                          <td class="questionTD" style="text-align:justify;">
						  <a href="reminder-details.php?notiid=<?php echo $notilistarr['data'][$i]['notificationId'];?>&&flag=<?php echo $notilistarr['data'][$i]['flagType'];?>">
						  
						  <?php
						  if(!empty($notilistarr['data'][$i]['title'])){
							  echo $notilistarr['data'][$i]['title'];
						  }else{
							  //$notilistarr['data'][$i]['content'];
							   $string = strip_tags($notilistarr['data'][$i]['content']);
                                if (strlen($string) > 50) 
								{
                                    $stringCut = substr($string, 0, 50);
                                   echo $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . "....";
                                }
								else{
							
									echo $notilistarr['data'][$i]['content'];
								}
						  }
						  ?>
						  
						  </a></td>
                        <!--<td>20</td>-->
						<td><?php echo $notitype; ?></td>
						<td><?php echo $notilistarr['data'][$i]['group']; ?></td>
                            <!--<td><ul class="wallUL">
<li><i class="fa fa-edit fa-lg"></i></li>
</ul> </td>-->
                        </tr>
					  <?php 
					  }
					  ?>
                        
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
       