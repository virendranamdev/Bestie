<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
       
	   
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>
<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
	   <script type="text/javascript" src="js/multipleImageUpload1.js"></script>
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
</script>

<script>
    function addcategorycheck() {
        if (confirm('Are You Sure, You want to add this category?')) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script>
    function checkedit() {
        if (confirm('Are You Sure, You want to update this category?')) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script>
    function checkdelete() {
        if (confirm('Are You Sure, You want to delete category?')) {
            return true;
        } else {
            return false;
        }
    }
</script>

<?php
require_once('Class_Library/class_upload_album.php');
$objAlbum = new Album();

$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];

$categoryList = $objAlbum->getAlbumCategory($clientId, $empId);
$categoryListArr = json_decode($categoryList, true);
$category = $categoryListArr['data'];
/*echo "<pre>";			
print_r($category);
echo "</pre>";*/
?>	

<?php
if(isset($_POST['addcategory'])) {
	$categoryname = $_POST['categoryname'];
	$maxcatid = $objAlbum->maxcategoryId();
/*****************************/
$folder = "images/albumcategory/";
$target = "images/albumcategory/";
$categoryimagename = $_FILES['categoryimage']['name'];
$cimg = str_replace(" ", "", $_FILES['categoryimage']['name']);
$cimgtemp = $_FILES['categoryimage']['tmp_name'];
$image_name = "category-" . $cimg;

	$imagepath = $folder.$maxcatid."-".$image_name;
	$dbimage = $target.$maxcatid."-".$image_name;
	
/*****************************/
	$categoryadd = $objAlbum->addAlbumCategory($clientId, $empId , $categoryname ,$dbimage);
	$categoryaddArr = json_decode($categoryadd, true);
	if($categoryaddArr['success'] == 1)
	{
		$imageupload = $objAlbum->compress_image($cimgtemp, $imagepath, 20);
		echo "<script>alert('Category Added Successfully')</script>";
		echo "<script>window.location='create-album.php'</script>";
	}
	else
	{
		echo "<script>alert('Category Not Added')</script>";
		echo "<script>window.location='create-album.php'</script>";
	}
}
?>	
<?php 

if(isset($_GET['editcategory']))
{
	//echo "<script>alert('".$_GET['oldcategoryid']."')</script>";
	//echo "<script>alert('".$_GET['newcategoryname']."')</script>";
	$oldcategoryid = $_GET['oldcategoryid'];
	$newcategoryname = $_GET['newcategoryname'];
	
	$categoryeditres = $objAlbum->editAlbumCategory($clientId, $empId , $oldcategoryid , $newcategoryname );
	$categoryeditArr = json_decode($categoryeditres, true);
	if($categoryeditArr['success'] == 1)
	{
		echo "<script>alert('Category Updated Successfully')</script>";
		echo "<script>window.location='create-album.php'</script>";
	}
	else
	{
		echo "<script>alert('Category Not Updated')</script>";
		echo "<script>window.location='create-album.php'</script>";
	}
}


if(isset($_GET['deletecategory']))
{
	//echo "<script>alert('".$_GET['deletecategoryid']."')</script>";
	$categoryid = $_GET['deletecategoryid'];
	$allcategory = array();
	foreach($categoryid as $category)
	{
			array_push($allcategory, $category);
	}
	//print_R($allcategory);
	$allcategoryid = $allcategory;
	
	$categorydeleteres = $objAlbum->deleteAlbumCategory($clientId, $empId , $allcategoryid);
	$catres = json_decode($categorydeleteres , true);
	if($catres)
	{
		echo "<script>alert('category deleted successfully')</script>";
		echo "<script>window.location='create-album.php'</script>";
	}
	else
	{
		echo "<script>alert('category not deleted')</script>";
		echo "<script>window.location='create-album.php'</script>";	
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
                    <h2>Create Album</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
     <!--<a href="wallPredefineTemplate.php"><button class="btn btn-primary pull-right btn-round"> Use Predefined Temple</button></a>-->

  
					
                    <form class="myform form-horizontal form-label-left paddingbottom"></form>
					
					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<a href="#"><button type="button" data-toggle="modal" data-target="#myModalDelete" class="btn btn-round btn-danger" style="float:right;">Delete Category</button></a>
					
					<a href="#"><button type="button" data-toggle="modal" data-target="#myModalEdit" class="btn btn-round btn-info" style="float:right;">Edit Category</button></a>
					
					<a href="#"><button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-round btn-primary" style="float:right;">Add Category</button></a>
					</div>
					<form name="addcategory" action="" method="POST" enctype="multipart/form-data" onsubmit="return addcategorycheck();">
					<div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog">
    
					<!-- Modal content-->
						<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Add category</h4>
						</div>
						<div class="modal-body">
					 <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <input type="text" required class="form-control has-feedback-left" name="categoryname"  id="title" placeholder="Enter Category name"/>
						

                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
					  <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Category Image</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
						<input class="form-control has-feedback-left" required type="file" id="categoryimage" accept="image/*" name="categoryimage" />
                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
					</div><hr style="color:#e5e5e5;">
					<div class="modal-footer">
					<button type="submit" name="addcategory" class="btn btn-default" onclick="return ValidateAddCategory();" >Submit</button>
					</div>
      </div>
      
    </div>
  </div></form>
  
  <div class="col-md-1 col-sm-1 col-xs-1 form-group has-feedback">
					<!--<Span data-toggle="modal" data-target="#myModalEdit" class="padding">Edit</span>-->
                      </div>
					  <form name="edicategoryform" action="" method="POST" onsubmit="return checkedit();">
					  <div class="modal fade" id="myModalEdit" role="dialog">
						<div class="modal-dialog">
    
					<!-- Modal content-->
						<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Edit category</h4>
						</div>
						<div class="modal-body">
						<div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Select Old Name</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <select class="form-control " id="sel1" name="oldcategoryid">
					<?php 
					for($i=0; $i<count($category); $i++)
					{
					?>
					<option value="<?php echo $category[$i]['categoryId']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category[$i]['categoryName']; ?></option>
					<?php } ?>
					</select>

                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
					 <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">New Category Name</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <input type="text" required class="form-control has-feedback-left" name="newcategoryname"  id="title" placeholder="Enter New Category name"/>

                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
					</div><hr style="color:#e5e5e5;">
					<div class="modal-footer">
					<button type="submit" name="editcategory" class="btn btn-default" onclick="return ValidateEditCategory();">Submit</button>
					</div>
      </div>
      
    </div>
  </div></form>
  <div class="col-md-1 col-sm-1 col-xs-1 form-group has-feedback">
					<!--<Span data-toggle="modal" data-target="#myModalDelete" class="padding">Delete</span>-->
                      </div>
					  <form action="create-album.php" method="POST" onsubmit="return checkdelete();">
					  <div class="modal fade" id="myModalDelete" role="dialog">
						<div class="modal-dialog">
    
					<!-- Modal content-->
						<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Delete category</h4>
						</div>
						<div class="modal-body">
					 <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Category Name</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <select multiple class="form-control" id="sel2" name="deletecategoryid[]">
						<?php
						for($i=0; $i<count($category); $i++)
						{
						?>
						<option value="<?php echo $category[$i]['categoryId'];?>"><?php echo $category[$i]['categoryName'];?></option>
						<?php } ?>
						</select>

                      </div>
                      </div>
					</div><hr style="color:#e5e5e5;">
					<div class="modal-footer">
					<button type="submit" name="deletecategory" class="btn btn-default" >Submit</button>
					</div>
      </div>
      
    </div>
  </div></div></form>
					  
  
  
  
  
					
					  <br><br><br>
					  <form name="albumform" action="Link_Library/link_album.php" method="POST" enctype="multipart/form-data" onsubmit="return check();">
					  
					<input type="hidden" id="clientid" name="clientid" value="<?php echo $_SESSION['client_id']; ?>"> 
					<input type="hidden" id="userid" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
					<input type="hidden" name="flag" value="11"> 
					  
					<div class="form-group">
                        <label class="control-label col-lg-3 col-md-3 col-sm-3 col-xs-3 paddingcategory">Category</label>
                        <div class="form-group">
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
					<select class="form-control " id="sel1" name="albumcategory">
					<?php
						for($i=0; $i<count($category); $i++)
						{
						?>
					<option value="<?php echo $category[$i]['categoryId'];?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category[$i]['categoryName'];?></option>
					<?php } ?>
					</select>
					<span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
					  </div>
					  
					  
  

					  
					   
                      </div>
                      <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Album Title</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" name="albumtitle" required id="title" placeholder="Enter Title"/>

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
					 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                            <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                              <textarea type="text" name="albumdescription" class="form-control has-feedback-left"  placeholder="Enter Description" ></textarea>
                                <span class="fa fa-pencil-square-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                               </div>
                      </div>
					  
					  <!---------------- group --------------------->
					<input type="radio" style="display:none;" name="optradio" id="sendTOAll" value="All" checked>
					<input type="radio" style="display:none;" name="optradio"id="sendToSelected" value="Selected">
					<textarea style="display:none;" id ="allids" name="all_user" height="660"></textarea>
					<textarea style="display:none;" id="selectedids" name="selected_user"></textarea>
					<!---------------- / group --------------------->
					  
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
<br><br>
                    </form>
				  
					  
	                </div>
                </div>
              </div>
</div>
          </div>
        </div>
<br><br><br>

<?php include 'footer.php';?>
       