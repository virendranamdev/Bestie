<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>   
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>
<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
<script type="text/javascript" src="js/albumImageUpload.js"></script>
<script src="js/display_group.js"></script>    
<link rel="stylesheet" type="text/css" href="build/css/multipleImageUpload1.css">
<script src="js/validation/createPostValidation.js"></script>
<style type="text/css">.thumb-image{float:left;max-width:210px;max-height:210px;position:relative;padding:5px;}
.padding{padding: 0px 10px 0px 0px;}
.paddingbottom{margin-bottom: -32px;}
.paddingcategory{margin-left:-4px;}
.modal-footer {
  
    border-top: 0px solid #fff ! important;}
	hr { margin-top: 0px ! important;margin-bottom: 0px ! important; border: 0;border-top: 1px solid #eee;}
</style>
<style>
    .image-upload > #files{ display: none;}
</style>		
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this?')) {
            return true;
        } else {
            return false;
        }
    }
	
	function Validatealbum()
	{
		
	}
</script>
<?php
require_once('Class_Library/class_upload_album.php');
$objAlbum = new Album();
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$albumid = $_GET['albumid'];
$albumdetail = $objAlbum->getAlbumImage($albumid);
$albumdetailArr = json_decode($albumdetail, true);
/*echo "<pre>";			
print_r($albumdetailArr);
echo "</pre>";*/
?>	
<!-- page content -->
        <div class="right_col" role="main">
			<div class="">
            <div class="clearfix"></div>

				<div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Image</h2>
					<?php /*echo "<pre>";			
						print_r($albumdetailArr);
						echo "</pre>";*/?>
					
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
      
					
					  <br><br><br>
					  <form name="albumform" action="Link_Library/link_addalbumimage.php" method="POST" enctype="multipart/form-data" onsubmit="return check();">
					  
					<input type="hidden" id="clientid" name="clientid" value="<?php echo $_SESSION['client_id']; ?>"> 
					<input type="hidden" id="userid" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
					<input type="hidden" name="flag" value="11"> 
					  
					<input type="hidden" id="albumid" name="albumId" value="<?php echo $albumid; ?>"> 
					
					<div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
                        <div class="form-group">
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
					<select readonly class="form-control " id="sel1" name="albumcategory">
					<option value="<?php echo $albumdetailArr['album'][0]['categoryId'];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $albumdetailArr['album'][0]['categoryName'];?></option>
					</select>
					<span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
					  </div>
					  
                      </div>
					  
					  
                      <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Album Title</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" name="albumtitle" id="title" placeholder="Enter Title" readonly value="<?php echo $albumdetailArr['album'][0]['title'];?>"/>

                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
					  
					  
                      <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Upload Image</label>
						<div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
						<input class="form-control has-feedback-left" type="file" id="files" accept="image/*" name="album[]" multiple />
						<span class="fa  fa-file-image-o form-control-feedback left" aria-hidden="true"></span>
						
						<textarea style="display:none" id="imagheight"></textarea>
					    <textarea style="display:none" id="imagwidth"></textarea>
						
						</div>
                      </div>
					  
					   <div class="row">
					  <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" ></div>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" >
                    <output id="list" style="padding-top:0px ! important;"></output>
                </div>
            </div>
					  <div class="row">
						<div class="col-md-3 col-sm-3 col-xs-12"></div>
						<div id="image-holder" class="col-xs-12  col-sm-9 col-md-9 col-lg-6"></div></div>
					 
         			  <!---------------- group --------------------->
					<input type="radio" style="display:none;" name="optradio" id="sendTOAll" value="All" checked>
					<input type="radio" style="display:none;" name="optradio"id="sendToSelected" value="Selected">
					<textarea style="display:none;" id ="allids" name="all_user" height="660"></textarea>
					<textarea style="display:none;" id="selectedids" name="selected_user"></textarea>
					<!---------------- / group --------------------->
					  <div class="clearfix"></div>
					  </div>
                      <br>
					  
					  
					  <br>
                      
                     <!-- <div class="ln_solid"></div>-->

                      <div class="form-group">
                        <div class="col-md-12"><center>
                          <button type="submit" name="addalbum" class="btn btn-round btn-primary" onclick="return ValidatePostalbum();">Submit</button>
                          <!--<button type="reset" class="btn btn-round btn-warning">Cancel</button>-->
                    </center></div>
                      </div>

                    </form>
				  
					  
	                </div>
                </div>
				</div>
			</div>
          </div>
     

<?php include 'footer.php';?>
       