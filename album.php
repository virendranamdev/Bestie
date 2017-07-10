<?php
 include 'header.php';
 include 'sidemenu.php';
 include 'topNavigation.php';?>
   
<?php
require_once('Class_Library/class_upload_album.php');
$objalbum = new Album();

//echo'<pre>';print_r($_SESSION);die;
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];
$device = "panel";
$albumList = $objalbum->getAlbum($clientId, $empId, $user_type, $device);
$albumListArr = json_decode($albumList, true);
echo "<pre>";
print_r($albumListArr);
echo "</pre>";
$albums = $albumListArr['posts'];
?>

<?php 

/********************** get pending bundle ***********************/

$pendingBundleList = $objalbum->getPendingBundle($clientId);
$pendingBundleListArr = json_decode($pendingBundleList, true);

/********************** get pending bundle ***********************/

?>

<?php 
if(isset($_GET['albumId']) && isset($_GET['status']))
{
//echo "<script>alert('hi');</script>";	

$aid = $_GET['albumId'];
$status = $_GET['status'];

	if ($status == 1) 
	{
		$status1 = 0;
		$statusresult1 = $objalbum->status_Post($aid, $status1);
		$sresult = json_decode($statusresult1, true);
		if($sresult['success'] == 1)
		{
		echo "<script>alert('Status has changed')</script>";
		echo "<script>window.location='album.php'</script>";
		}
		else
		{
		echo "<script>alert('Status not change')</script>";
		echo "<script>window.location='album.php'</script>";
		}
		
	}
	else
	{
		$status2 = 1;
		$statusresult2 = $objalbum->status_Post($aid, $status2);
		$sresult2 = json_decode($statusresult2, true);
		if($sresult2['success'] == 1)
		{
		echo "<script>alert('Status has changed')</script>";
		echo "<script>window.location='album.php'</script>";
		}
		else
		{
		echo "<script>alert('Status not change')</script>";
		echo "<script>window.location='album.php'</script>";
		}
	}
}
?>

 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

			
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Pending List</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                           <li><a href="create-album.php"><button class="btn btn-primary btn-round">Create New Album</button></a></li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
					
                        <br />
                    <table id="" class="MyTable table table-striped display"  cellspacing="0" width="100%">
                      <thead>
                        <tr>
                         <th>Category Name</th>
						 <th>Album Name</th>
						 <th>Posted By</th>
						 <th>Date</th>
						 <th>Total Image</th>
						 <th>Approve Images</th>
                         <th>Pending Images</th>
						 <th>Action</th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php  
					  for($i=0; $i<count($pendingBundleListArr['posts']); $i++)
					  {
					  ?>
					  <tr>
                          <th><?php echo $pendingBundleListArr['posts'][$i]['categoryName'];?></th>
						  <th><?php echo $pendingBundleListArr['posts'][$i]['title'];?></th>
						  <th><?php echo $pendingBundleListArr['posts'][$i]['createdbyname'];?></th>
						  <th><?php echo $pendingBundleListArr['posts'][$i]['createdDate'];?></th>
						  <th><?php echo $pendingBundleListArr['posts'][$i]['totalimage'];?></th>
						  <th><?php echo $pendingBundleListArr['posts'][$i]['approveImage'];?></th>
                          <th><?php echo $pendingBundleListArr['posts'][$i]['pendingImage'];?></th>
						  <th><a href="pendingDataApprove.php?bundleId=<?php echo $pendingBundleListArr['posts'][$i]['bundleId']; ?>">View</a></th>
                      </tr>
					  <?php 
					  }
					  ?>
					  </tbody>
					  </table>


					  
                    </div>
                </div>
            </div>
        </div>
			
			
			
			
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Let's Click</h2>
					
					
                    <ul class="nav navbar-right panel_toolbox">
                      
					  
					  <li><a href="create-album.php"><button class="btn btn-primary btn-round">Create New Album</button></a></li>
					  
                      <li><a class="right"><i class="fa fa-chevron-up"></i></a>
                      </li>
					  
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					 <br />
				  <!--<div class="row">
                       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                          <ul class="inlineUL right"><li class="pull-right"><a href="create-album.php"><button class="btn btn-primary btn-round">Create New Album</button></a></li></ul>
                         </div>
							

                      </div>-->

                    <form class="myform form-horizontal form-label-left">
			
<table id="datatable" class="MyTable table table-striped">
                      <thead>
                        <a href="album-detail.php"><tr>
                          <th>Album</th><th>Posted By</th><th>Title</th><th>Description</th>
                          
                         
                          <th>Category</th><th>Last Update</th><th></th>
                        </tr></a>
                      </thead>


                      <tbody>
					  <?php 
					  for($i=0; $i<count($albums); $i++)
					  {
						  $k = $albums[$i]['status'];
						  if($k== 1)
						  {
							  $sta = "Approve";
						  }
						  else
						  {
							  $sta = "Reject";
						  }
					  ?>
					  <tr><td><a href="album-detail.php?albumId=<?php echo $albums[$i]['albumId']; ?>"><img src="<?php echo $albums[$i]['image'];?>"class="img img-responsive" style="max-width:60px; max-height:60px;"/></a></td>
                          <td><a href="album-detail.php?albumId=<?php echo $albums[$i]['albumId']; ?>"><?php echo $albums[$i]['name'];?></a></td><td><a href="album-detail.php?albumId=<?php echo $albums[$i]['albumId']; ?>"><?php echo $albums[$i]['title'];?></a> </td>
						  <?php
						  $string = strip_tags($albums[$i]['description']);
                                            if (strlen($string) > 40) {
                                                $stringCut = substr($string, 0, 40);

                                                $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . "....";
                                            }?>
                          <td style="text-align:justify"><a href="album-detail.php?albumId=<?php echo $albums[$i]['albumId']; ?>"><?php echo $string;?></a></td><td ><a href="album-detail.php?albumId=<?php echo $albums[$i]['albumId']; ?>"><?php echo $albums[$i]['categoryName'];?></a></td>
                         <td ><a href="album-detail.php?albumId=<?php echo $albums[$i]['albumId']; ?>"><?php echo $albums[$i]['createdDate'];?></a></td>
                           <!--<td><center><a href="#"><?php echo $sta; ?></a></center></td>-->
						   <td>
                                    <ul class="wallUL">
                                    <li><a href="album.php?albumId=<?php echo $albums[$i]['albumId']; ?>&status=<?php echo $albums[$i]['status']; ?>"><i <?php if($albums[$i]['status'] != 1){ ?> style="color:#a94442;" <?php } ?> class="fa fa-circle fa-lg <?php if($albums[$i]['status'] == 1){ ?> liveData <?php }else{ ?> expireData <?php } ?> blue-tooltip" data-toggle="tooltip" data-placement="left" <?php if($albums[$i]['status'] == 1){ ?> title="Live Post" <?php }else{ ?> title="Expired Post" <?php } ?>></i></li>
									</ul>
							</td>
                        </tr>
						
					  <?php } ?>
					
                       
                      </tbody>
                    </table>

                    </form>

					  <style>
					  .smallbtn{color:#fff;}
					  .tableApproveImage{width:100px;}
					  </style>
					  <script>$(document).ready(function() {
    $('table.display').DataTable();
} );
</script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
					  

                  </div></div>
                  </div></div>
                </div>
              </div>
</div>
          </div>
        </div>
        <!-- /page content -->



<?php include 'footer.php';?>
       
