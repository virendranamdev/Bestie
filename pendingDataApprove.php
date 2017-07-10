<?php
include 'header.php';
include 'sidemenu.php';
include 'topNavigation.php';
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>
<script src="js/display_group.js"></script>  
<?php
require_once('Class_Library/class_upload_album.php');
$objalbum = new Album();
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

if(isset($_GET['bundleId']))
{
$bundleId = $_GET['bundleId'];
$bundleimagelist = $objalbum->getPendingBundleImage($clientId , $bundleId);
$bundleimagelistArr = json_decode($bundleimagelist, true);
}

if(isset($_GET['Bundle']))
{
$bundle = $_GET['Bundle'];
$allimagelist = $objalbum->getBundleImageAll($clientId , $bundle);
$allimagelistArr = json_decode($allimagelist, true);
}
?>
<script>
    function check() {
        if (confirm('Are You Sure?')) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script>
    function validateAlbumImageCheckbox() {
		//alert('hi');
		  var checkboxs = document.getElementsByName('bundleimgid[]');
		 //alert(checkboxs.length);
		 for(var i=0; i<checkboxs.length; i++)
		 {
			//alert(checkboxs[i].checked);
			  if (checkboxs[i].checked) {
                return true;
			  }
		 }
		 alert('Please Check Image');
		 return false;
	}
</script>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <br>
        <div class="clearfix"></div>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
						<?php 
						if(isset($_GET['bundleId']))
						{
							echo $bundleimagelistArr['posts'][0]['title'];
						}
						if(isset($_GET['Bundle']))
						{
							echo $allimagelistArr['posts'][0]['title'];
						}
						?>
						
						</h2>
						<?php /*echo "<pre>";
print_r($allimagelistArr);
echo "</pre>";*/?>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                       <div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								
								 <style>
									.pendingImages{height:180px;}
									.inlineUl li{display:inline}
								 </style>
							</div>
					   </div>
					   
					   
					   	<div class="row">
						<style>
						
/*  bhoechie tab */
div.bhoechie-tab-container{
 background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #044f9a;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #044f9a;
  background-image: #044f9a;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #044f9a;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}
						</style>
						
	<!----------------------- unseen ------------------------------->
	<?php if(isset($_GET['bundleId']))
	{
	?>
	 <form id = "pendingform" method="POST" action="Link_Library/bundle_image_status.php" enctype="multipart/form-data" onsubmit="return check();">
								
								<input type="hidden" value="<?php echo $bundleId; ?>" name="bundleid">
								<input type="hidden" id="clientid" name="clientid" value="<?php echo $_SESSION['client_id']; ?>"> 
								<input type="hidden" id="userid" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
								<input type="hidden" name="flag" value="11">
								<input type="hidden" id="albumid" name="albumid" value="<?php echo $bundleimagelistArr['posts'][0]['albumId']; ?>">
								<input type="hidden" id="albumtitle" name="albumtitle" value="<?php echo $bundleimagelistArr['posts'][0]['title']; ?>">
								
								 <ul class="inlineUl">
								 <?php 
								 for($i=0; $i<count($bundleimagelistArr['posts']); $i++)
								 {
									 
								 ?>
									<li>
										<label>
										<div><input type="checkbox" value="<?php echo $bundleimagelistArr['posts'][$i]['autoId'];?>" name="bundleimgid[]">
										<img src="<?php echo $bundleimagelistArr['posts'][$i]['imgName'];?>" name="albumimage" class="img img-responsive pendingImages">
										</div>
										</label>
									</li>
								 <?php 
								 }
								 ?>
									
								 </ul>
								 
								 <!---------------- group --------------------->
									<input type="radio" style="display:none" name="optradio" id="sendTOAll" value="All" checked>
									<input type="radio" style="display:none" name="optradio"id="sendToSelected" value="Selected">
									<textarea  id ="allids" style="display:none" name="all_user" height="660"></textarea>
									<textarea  id="selectedids" style="display:none" name="selected_user"></textarea>
								<!---------------- / group --------------------->
								 
									<br>
									<br>
								<center>  
								<button type="submit" name="pendingapprove" class="btn btn-success" onclick="return validateAlbumImageCheckbox();">Approve</button>
								<button type="submit" name="pendingreject" class="btn btn-danger" onclick="return validateAlbumImageCheckbox();">Reject</button>
								<button type="submit" name="pendingskip" class="btn btn-default">Skip</button>
								</center>	
						</form>
<?php } ?>
<!--------------------------------------- /unseen --------------------------------------------->
		<?php if(isset($_GET['Bundle']))
{
	?>	
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab-container">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
              <div class="list-group">
                <a href="#" class="list-group-item active text-center">
                 <h4 class="glyphicon glyphicon-option-horizontal"></h4><br/>Pending
                </a>
                <a href="#" class="list-group-item text-center">
                <h4 class="glyphicon glyphicon-thumbs-up"></h4><br/> Approve
                </a>
                <a href="#" class="list-group-item text-center">
                 <h4 class="glyphicon glyphicon-ban-circle"></h4><br/>  Rejected
                </a>
                <a href="#" class="list-group-item text-center">
                  <h4 class="glyphicon glyphicon-eye-close"></h4><br/>Unpublish
                </a>
                
              </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                <!-- flight section -->
				<!----------------- pending image ---------------------->
                <div class="bhoechie-tab-content active">
                      <form method="POST" action="Link_Library/bundle_image_status.php" enctype="multipart/form-data" onsubmit="return check();">
								
								<input type="hidden" value="<?php echo $bundle; ?>" name="bundleid">
								<input type="hidden" id="clientid" name="clientid" value="<?php echo $_SESSION['client_id']; ?>"> 
								<input type="hidden" id="userid" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
								<input type="hidden" name="flag" value="11">
								<input type="hidden" id="albumid" name="albumid" value="<?php echo $allimagelistArr['posts'][0]['albumId']; ?>">
								<input type="hidden" id="albumtitle" name="albumtitle" value="<?php echo $allimagelistArr['posts'][0]['title']; ?>">
								
								 <ul class="inlineUl">
								 <?php 
								 for($i=0; $i<count($allimagelistArr['posts']); $i++)
								 {
									if($allimagelistArr['posts'][$i]['status'] == 2) 
									{
								 ?>
									<li>
										<label>
										<div><input type="checkbox" value="<?php echo $allimagelistArr['posts'][$i]['autoId'];?>" name="bundleimgid[]">
										<img src="<?php echo $allimagelistArr['posts'][$i]['imgName'];?>" name="albumimage" class="img img-responsive pendingImages">
										</div>
										</label>
									</li>
									<?php }} ?>
									
								 </ul>
								 
								 <!---------------- group --------------------->
									<input type="radio" style="display:none" name="optradio" id="sendTOAll" value="All" checked>
									<input type="radio" style="display:none" name="optradio"id="sendToSelected" value="Selected">
									<textarea  id ="allids" style="display:none" name="all_user" height="660"></textarea>
									<textarea  id="selectedids" style="display:none" name="selected_user"></textarea>
								<!---------------- / group --------------------->
								 
									<br>
									<br>
									
								<?php if($allimagelistArr['imagestatuscount']['pendingtotalcount'] > 0){ ?>
								<center>  
								<button type="submit" name="pendingapprove" class="btn btn-success" onclick="return validateAlbumImageCheckbox();">Approve</button>
								<button type="submit" name="pendingreject" class="btn btn-danger" onclick="return validateAlbumImageCheckbox();">Reject</button>
								<!--<button type="submit" name="pendingskip" class="btn btn-default">Skip</button>-->
								</center>
								<?php  }
								else {
									echo "No Image Available";
								}
								?>
						</form>
					  
                </div>
				<!----------------- pending image ---------------------->
				<!----------------- Approve image ---------------------->
                <!-- train section -->
                <div class="bhoechie-tab-content">
                     <form method="POST" action="Link_Library/bundle_image_status.php" enctype="multipart/form-data" onsubmit="return check();">
							
							    <input type="hidden" value="<?php echo $bundle; ?>" name="bundleid">
								<input type="hidden" id="clientid" name="clientid" value="<?php echo $_SESSION['client_id']; ?>"> 
								<input type="hidden" id="userid" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
								<input type="hidden" name="flag" value="11">
								<input type="hidden" id="albumid" name="albumid" value="<?php echo $allimagelistArr['posts'][0]['albumId']; ?>">
								<input type="hidden" id="albumtitle" name="albumtitle" value="<?php echo $allimagelistArr['posts'][0]['title']; ?>">
					 
								 <ul class="inlineUl">
								 
								<?php 
								 for($i=0; $i<count($allimagelistArr['posts']); $i++)
								 {
									if($allimagelistArr['posts'][$i]['status'] == 1) 
									{
								 ?>
									<li>
										<label>
										<div><input type="checkbox" value="<?php echo $allimagelistArr['posts'][$i]['autoId'];?>" name="bundleimgid[]">
										<img src="<?php echo $allimagelistArr['posts'][$i]['imgName'];?>" name="albumimage" class="img img-responsive pendingImages">
										</div>
										</label>
									</li>
									<?php }} ?>
								 
								 <!--
									<li>
										<label>
										<div><input type="checkbox" value="text-success"><img src="img/1.jpg"class="img img-responsive pendingImages">
										
										</div>
										</label>
									</li>-->
									
									
								 </ul>
								 
									<br>
									<br>
									<?php if($allimagelistArr['imagestatuscount']['approvetotalcount'] > 0){ ?>
								<center>  
								<button type="submit" name="approveunpublish" class="btn btn-warning" onclick="return validateAlbumImageCheckbox();">Unpublish</button>
								<!--<button type="submit" name="pendingreject" class="btn btn-danger">Reject</button>-->
								</center>
								<?php  }
								else {
									echo "No Image Available";
								}
								?>
						</form>
					  
                </div>
				<!----------------- / Approve image ---------------------->
                <!-- hotel search -->
				<!----------------- Rejected image ---------------------->
                <div class="bhoechie-tab-content">
                    <form method="POST" action="Link_Library/bundle_image_status.php" enctype="multipart/form-data" onsubmit="return check();">
					
								<input type="hidden" value="<?php echo $bundle; ?>" name="bundleid">
								<input type="hidden" id="clientid" name="clientid" value="<?php echo $_SESSION['client_id']; ?>"> 
								<input type="hidden" id="userid" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
								<input type="hidden" name="flag" value="11">
								<input type="hidden" id="albumid" name="albumid" value="<?php echo $allimagelistArr['posts'][0]['albumId']; ?>">
								<input type="hidden" id="albumtitle" name="albumtitle" value="<?php echo $allimagelistArr['posts'][0]['title']; ?>">
								
								 <ul class="inlineUl">
								 
								 <?php 
								 for($i=0; $i<count($allimagelistArr['posts']); $i++)
								 {
									if($allimagelistArr['posts'][$i]['status'] == 3) 
									{
								 ?>
									<li>
										<label>
										<div><input type="checkbox" value="<?php echo $allimagelistArr['posts'][$i]['autoId'];?>" name="bundleimgid[]">
										<img src="<?php echo $allimagelistArr['posts'][$i]['imgName'];?>" name="albumimage" class="img img-responsive pendingImages">
										</div>
										</label>
									</li>
									<?php }} ?>
								 
									<!--<li>
										<label>
										<div><input type="checkbox" value="text-success"><img src="img/1.jpg"class="img img-responsive pendingImages">
										
										</div>
										</label>
									</li>-->
									
								 </ul>
								 
									<br>
									<br>
									<?php if($allimagelistArr['imagestatuscount']['rejecttotaltotalcount'] > 0){ ?>
								<center>  
								<button type="submit" name="BundleImagepublish" class="btn btn-success" onclick="return validateAlbumImageCheckbox();">Publish</button>
								<!--<button type="submit" name="pendingunpublish" class="btn btn-warning">Unpublish</button>-->
								</center>	
								<?php  }
								else {
									echo "No Image Available";
								}
								?>
						</form>
                </div>
				
				<!----------------- / Rejected image ---------------------->
				<!----------------- unpublish image ---------------------->
                <div class="bhoechie-tab-content">
                    <form method="POST" action="Link_Library/bundle_image_status.php" enctype="multipart/form-data" onsubmit="return check();">
					
								<input type="hidden" value="<?php echo $bundle; ?>" name="bundleid">
								<input type="hidden" id="clientid" name="clientid" value="<?php echo $_SESSION['client_id']; ?>"> 
								<input type="hidden" id="userid" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
								<input type="hidden" name="flag" value="11">
								<input type="hidden" id="albumid" name="albumid" value="<?php echo $allimagelistArr['posts'][0]['albumId']; ?>">
								<input type="hidden" id="albumtitle" name="albumtitle" value="<?php echo $allimagelistArr['posts'][0]['title']; ?>">
								
								 <ul class="inlineUl">
								 
								 <?php 
								 for($i=0; $i<count($allimagelistArr['posts']); $i++)
								 {
									if($allimagelistArr['posts'][$i]['status'] == 0) 
									{
								 ?>
									<li>
										<label>
										<div><input type="checkbox" value="<?php echo $allimagelistArr['posts'][$i]['autoId'];?>" name="bundleimgid[]">
										<img src="<?php echo $allimagelistArr['posts'][$i]['imgName'];?>" name="albumimage" class="img img-responsive pendingImages">
										</div>
										</label>
									</li>
									<?php }} ?>
								 
									<!--<li>
										<label>
										<div><input type="checkbox" value="text-success"><img src="img/1.jpg"class="img img-responsive pendingImages">
										
										</div>
										</label>
									</li>-->
									
									
								 </ul>
								 
									<br>
									<br>
									<?php if($allimagelistArr['imagestatuscount']['unpublishtotalcount'] > 0){ ?>
								<center>  
								<button type="submit" name="BundleImagepublish" class="btn btn-success" onclick="return validateAlbumImageCheckbox();">Publish</button>
								<!--<button type="submit" name="pendingreject" class="btn btn-danger">Reject</button>-->
								</center>
								<?php  }
								else {
									echo "No Image Available";
								}
								?>
						</form>
                </div>
				<!-----------------/ unpublish image ---------------------->
				
                <div class="bhoechie-tab-content">
                    <center>
                      <h1 class="glyphicon glyphicon-credit-card" style="font-size:12em;color:#55518a"></h1>
                      <h2 style="margin-top: 0;color:#55518a">Cooming Soon</h2>
                      <h3 style="margin-top: 0;color:#55518a">Credit Card</h3>
                    </center>
                </div>
            </div>
        </div>
		<?php } ?>
  </div>
					   
					   
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="surveyId" value="<?php echo $_GET['happinessQuestion']; ?>">
		
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
  
  
  <script>
  $(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});
  </script>
 
    </div>
 </div>

<?php
include 'footer.php';
?>