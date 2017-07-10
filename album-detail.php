<?php
 include_once 'header.php';
 include_once 'sidemenu.php';
 include_once 'topNavigation.php';
?>
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 
 <?php 
require_once('Class_Library/class_upload_album.php');
$objalbum = new Album();
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];
$albumid = $_GET['albumId'];
?>
 <style>
.GalleryImages{height:150px;}
.desc{max-height:70px;font-weight:600;}
.imgpadding{width:100%;height:150px;padding:1px 1px 1px 1px;border:1px solid #cdcdcd;}
.fontsize{font-size:12px;padding: 0px 10px 0px 0px;}
.border{border:1px solid #cdcdcd;}
.padding{padding: 0px 2px 2px 3px;}
.fontpadding{font-size:12px;padding: 0px 0px 0px 5px;}
.check{background-color: #04809a;
    opacity: 0.8;
    position: absolute;
    /* margin: 2px 0px 0px 122px; */
    color: #fffd;
    color: #fff;
    padding: 3px 6px 3px 6px;
    right: 6%;
    margin-top: 1%;}
</style>
<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 2000); // Change image every 2 seconds
}
</script> 

<script>
$(document).on("click", ".open-Addimageslider", function () {
     var selectedimgpath = $(this).data('id');
	 //alert(myBookId);
	$(".modal-content #imgpath").attr('src', selectedimgpath);
	
	$(".modal-content #img").val(selectedimgpath);
	
	
	
});
</script>

<?php
/********************* image detail **********************/
$device = "panel";
$imageList = $objalbum->getAlbumImage($albumid,$device);
$imageListArr = json_decode($imageList, true);
$albumimages = $imageListArr['posts'];

$bundle = json_decode($objalbum->getPendingBundle($clientId, $albumid), true);
$bundleList = $bundle['posts'];
// echo'<pre>';print_r($bundleList);die;
/*********************** / image detail *************************/
?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

			
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Album History</h2>
                        <ul class="nav navbar-right panel_toolbox">
						<li><a href="Add_Album_Image.php?albumid=<?php echo $albumid; ?>"><button class="btn btn-primary btn-round">Add Image</button></a>
                      </li>
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                    <table id="" class="MyTable table table-striped display"  cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Posted By</th>
                          <th>Date</th>
                          <th>Total Image</th>
                          <th>Approve Images</th>
                          <th>Pending Images</th>
                          <th>Action</th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php foreach($bundleList as $list) { ?>
			<tr>
                          <th><?php echo $list['createdbyname']; ?></th>
                          <th><?php echo $list['createdDate']; ?></th>
                          <th><?php echo $list['totalimage']; ?></th>
                          <th><?php echo $list['approveImage']; ?></th>
                          <th><?php echo $list['pendingImage']; ?></th>
                          <th><a href="pendingDataApprove.php?Bundle=<?php echo $list['bundleId']; ?>" >View</a></th>
                        </tr>
                        <?php } ?>		  
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
                    <h2>Approve Images</h2>
					<?php 
					/*echo "<pre>";
print_r($imageListArr);
echo "</pre>";*/
					?>
					
                    <ul class="nav navbar-right panel_toolbox">
					<li><a href="Add_Album_Image.php?albumid=<?php echo $albumid; ?>"><button class="btn btn-primary btn-round">Add Image</button></a>
                      </li>
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
					  
					   
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				  
				  <br/>
				  
				  
				  
				  
     <!--<a href="wallPredefineTemplate.php"><button class="btn btn-primary pull-right btn-round"> Use Predefined Temple</button></a>-->
	 
	 <!--
<div class="row">
<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
<div class="border">
<div class="w3-content w3-section" >
	<?php 
	for($i=0; $i<count($albumimages); $i++)
	{
				
	?>
		<img class="img img-responsive mySlides w3-animate-fading GalleryImages" src="<?php echo $albumimages[$i]['imgName']; ?>" >
	<?php } ?>
	</div>
	 <p class="desc" ><center><b><?php echo count($imageListArr['posts']); ?></b></center></p>
 </div>
</div>


<div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
<h3><b><?php echo $imageListArr['album'][0]['title'];?></b></h3>
<p><?php echo $imageListArr['album'][0]['description'];?></p>

</div>
</div>-->


				   <table id="" class="MyTable table table-striped display"  cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>image</th><th>Total Like</th><th>Total Comment</th><th>Uploaded By</th><th>Uploaded Date</th>
                          <th>Approve Date</th><th>Action</th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php 
for($i=0; $i<count($albumimages); $i++)
{
	$albumid = $albumimages[$i]['albumId'];
	$imgid = $albumimages[$i]['autoId'];
	/**************** image like *******************************/
	$imagelike = $objalbum->getAlbumImagelike($albumid,$imgid);
	$imagelikearray = json_decode($imagelike, true);
	/*echo "<pre>";
	print_r($imagelikearray);
	*/
	/**************** / image like *******************************/
	/**************** / image comment *******************************/
	$imagecomment = $objalbum->getAlbumImageComment($albumid,$imgid);
	$imagecommentarray = json_decode($imagecomment, true);
	$totalcomment = count($imagecommentarray['posts']);
	/*echo "<pre>";
	print_r($totalcomment);
	*/
	/**************** / image like *******************************/
	$imagestatus = $albumimages[$i]['status'];
	if($imagestatus == 1)
	{
		$imgstatus = "Approved";
	}
?>
					  <tr>
                          <th><img src="<?php echo $albumimages[$i]['imgName'];?>"title="<?php echo $albumimages[$i]['imageCaption'];?>"alt="image missing"class="img img-responsive tableApproveImage"></th>
						  <th><?php echo $imagelikearray['total_like'];?></th>
						  <th><?php echo $totalcomment; ?></th> <th>Nadeem</th><th>2 May 2017</th>
                          <th>3 May 2017</th>
						  <th><button type="button" name="viewbutton" class="btn btn-success btn-xs active"><a class="smallbtn" href="album-image-details.php?albumid=<?php echo $albumid;?>&&imageId=<?php echo $albumimages[$i]['autoId'];?>">view</a></button></th>
                      </tr>
					 <?php

} ?>

					  
					  </tbody>
					  </table>
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
					  
<div class="row">
<!--
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">

<div class="border">
<?php if(($imagestatus == 2)){?>
<div class="check"><?php echo $imgstatus;?></div>
<?php } ?>
<span data-toggle="modal" data-target="#myModal" data-id="<?php echo $albumimages[$i]['imgName']; ?>" class="open-Addimageslider">
<img src="<?php echo $albumimages[$i]['imgName'];?>" class="img img-responsive imgpadding" data-toggle="tooltip" title="<?php echo $albumimages[$i]['imageCaption'];?>"></span>

<span class="fontpadding"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;<button type="button" class="btn btn-xs"><?php echo $imagelikearray['total_like'];?></button></span> 



<span  class="pull-right fontsize"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i>&nbsp;<button type="button" class="btn btn-xs"><?php echo $totalcomment; ?></button></span>

</div>
<br>
	<?php 
	if($imagestatus == 2)
	{
	?>
		<center>
		<button type="button" name="approvebutton" class="btn btn-primary  btn-xs active"><a href="Link_Library/album_image_status.php?albumid=<?php echo $albumid;?>&&imageId=<?php echo $albumimages[$i]['autoId'];?>&&approvestatus=<?php echo $albumimages[$i]['status'];?>">Approve</a></button>&nbsp;
		
		<button type="button" name="rejectbutton" class="btn btn-danger btn-xs active"><a href="Link_Library/album_image_status.php?albumid=<?php echo $albumid;?>&&imageId=<?php echo $albumimages[$i]['autoId'];?>&&rejectstatus=<?php echo $albumimages[$i]['status'];?>">Reject</a></button>
				
		</center>
	<?php 
	}
	if($imagestatus == 1)
	{
	?>
	<center><button type="button" name="approvebutton" class="btn btn-warning  btn-xs active"><a href="Link_Library/album_image_status.php?albumid=<?php echo $albumid;?>&&imageId=<?php echo $albumimages[$i]['autoId'];?>&&unpublishimagestatus=<?php echo $albumimages[$i]['status'];?>">Unpublish</a></button>
	
	&nbsp;<button type="button" name="viewbutton" class="btn btn-success btn-xs active"><a href="album-image-details.php?albumid=<?php echo $albumid;?>&&imageId=<?php echo $albumimages[$i]['autoId'];?>">view</a></button>
	
	</center>
	<?php
	}
	if($imagestatus == 0)
	{
	?>
	<center><button type="button" name="approvebutton" class="btn btn-info  btn-xs active"><a href="Link_Library/album_image_status.php?albumid=<?php echo $albumid;?>&&imageId=<?php echo $albumimages[$i]['autoId'];?>&&publishimagestatus=<?php echo $albumimages[$i]['status'];?>">Publish</a></button>
	
	&nbsp;<button type="button" name="viewbutton" class="btn btn-success btn-xs active"><a href="album-image-details.php?albumid=<?php echo $albumid;?>&&imageId=<?php echo $albumimages[$i]['autoId'];?>">view</a></button>
	
	</center>
	<?php 
	} 
	?>
	
	

</div>-->

</div>


<!---------------------------------------------------------------------->  
 <form class="myform form-horizontal form-label-left">



<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        
<div class="container">
  <center>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol style="display:none" class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	  
      <li data-target="#myCarousel" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
	<div class="item active">
	  
        <center>
		
		<img id="imgpath" alt="Chania" style="max-height:500px;max-width:100%;padding:50px 3px 40px 3px;" class="img img-responsive">
		<!--<h4 style="float:left;padding:3px;"><?php echo $albumimages[0]['imageCaption']; ?></h4>-->
		
		</center>
      </div>
	<?php 
	for($k=0; $k<count($albumimages); $k++)
	{
		
		
		
	?>
      <div class="item">
	 
        <center><img src="<?php echo $albumimages[$k]['imgName'];?>" alt="Chania" style="max-height:500px;max-width:100%;padding:50px 3px 40px 3px;">
		 <!--h4 style="float:left;padding:3px;"><?php echo $albumimages[$k]['imageCaption']; ?></h4>-->
		</center>
      </div>
	<?php } ?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div></center>
</div>
      </div>
      
    </div>
  </div>
  
</div>
                    </form>

<!--------------------------------------------------------------------------------->

                  </div></div>
                  </div></div>
                </div>
              </div>
</div>
          </div>
        </div>
        <!-- /page content -->
		<style>
div.gallery {
    margin: 5px;
    border: 1px solid #ccc;
    float: left;
    width: 180px;
}

div.gallery:hover {
    border: 1px solid #777;
}

div.gallery img {
    width: 100%;
    height: auto;
}

div.desc {
    padding: 15px 5px 15px 5px;
    
}
</style>


<style>
.carousel-control.right {
	
	margin-top:42px ! important;
	
	margin-right:3px;
	
}
.carousel-control.left {
	margin-top:42px ! important;
	margin-left:3px;

}
.w3-section, .w3-code {
	margin:1px 1px 1px 1px;
}
.w3-section, .w3-code {
margin-top:0px ! important;
margin-bottom:0px ! important;
}
.img{
	margin-bottom:0px ! important;
}
</style>



<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 9000);    
}
</script>




<?php include 'footer.php';?>
       
