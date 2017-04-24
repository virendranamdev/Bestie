<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
       
	   
	   <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>
<link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
	   <script type="text/javascript" src="build/js/multipleImageUpload1.js"></script>
<link rel="stylesheet" type="text/css" href="build/css/multipleImageUpload1.css">
<style type="text/css">.thumb-image{float:left;max-width:210px;max-height:210px;position:relative;padding:5px;}
.padding{padding: 0px 10px 0px 0px;}
.paddingbottom{margin-bottom: -32px;}
</style>
<style>
                    .image-upload > #files{ display: none;}
                </style>		
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

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

  
					
                    <form class="myform form-horizontal form-label-left paddingbottom">
					<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
					<a href="#"><button type="button" data-toggle="modal" data-target="#myModalDelete" class="btn btn-round btn-danger" style="float:right;">Delete Category</button></a>
					
					<a href="#"><button type="button" data-toggle="modal" data-target="#myModalEdit" class="btn btn-round btn-info" style="float:right;">Edit Category</button></a>
					
					<a href="#"><button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-round btn-primary" style="float:right;">Add Category</button></a>
					</div>
					
					  <br><br><br>
					<div class="form-group">
                        <label class=" control-label col-lg-3 col-md-3 col-sm-3 col-xs-12">Category</label>
                        <div class="form-group">
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
					<select class="form-control " id="sel1">
					<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category1</option>
					<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category2</option>
					<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category3</option>
					<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Categoey4</option>
					</select>
					<span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
					  
					  
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
                        <input type="text" class="form-control has-feedback-left" name="text1"  id="title" placeholder="Enter Category name"/>

                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" >Submit</button>
					</div>
      </div>
      
    </div>
  </div>
  

					  <div class="col-md-1 col-sm-1 col-xs-1 form-group has-feedback">
					<!--<Span data-toggle="modal" data-target="#myModalEdit" class="padding">Edit</span>-->
                      </div>
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
                        <select class="form-control " id="sel1">
					<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category1</option>
					<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category2</option>
					<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category3</option>
					<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Categoey4</option>
					</select>

                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
					 <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">New Category Name</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" name="text1"  id="title" placeholder="Enter New Category name"/>

                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" >Submit</button>
					</div>
      </div>
      
    </div>
  </div>
					   <div class="col-md-1 col-sm-1 col-xs-1 form-group has-feedback">
					<!--<Span data-toggle="modal" data-target="#myModalDelete" class="padding">Delete</span>-->
                      </div>
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
                        <select multiple class="form-control" id="sel2">
						<option>11</option>
						<option>21</option>
						<option>31</option>
						<option>41</option>
						<option>51</option>
						</select>

                      </div>
                      </div>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" >Submit</button>
					</div>
      </div>
      
    </div>
  </div></div>
					  </div>
                      </div>
                      <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Image Title</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" name="text1"  id="title" placeholder="Enter Title"/>

                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
                      <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Upload Image</label>
						<div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
						<input class="form-control has-feedback-left" type="file" id="files" accept="image/*" name="album[]" multiple />
						<span class="fa  fa-file-image-o form-control-feedback left" aria-hidden="true"></span>
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
                              <textarea type="text" class="form-control has-feedback-left"  placeholder="Enter Description" ></textarea>
                                <span class="fa fa-pencil-square-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                               </div>
                      </div>
					  
                      <br>
					  
					  
					  
	<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this post?')) {
            return true;
        } else {
            return false;
        }
    }
</script>				  
					  <br>
                      
                     <!-- <div class="ln_solid"></div>-->

                      <div class="form-group">
                        <div class="col-md-12"><center>
                          <button type="button" class="btn btn-round btn-primary">Submit</button>
                          <button type="reset" class="btn btn-round btn-warning">Cancel</button>
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
        
						
<script>
function ValidatePostalbum()
{
    var title = document.postalbumform.title;
    var fi = document.getElementById("files");
	//var fi = document.postalbumform.album[];
    if (title.value == "")
    {
        window.alert("Please Enter Album Title.");
        title.focus();
        return false;
    }
    if (fi.value == "")
    {
        window.alert("Please Select Image");
		fi.focus();
        return false;
    }
    return true;
}

</script>

  <br><br><br>

<?php include 'footer.php';?>
       