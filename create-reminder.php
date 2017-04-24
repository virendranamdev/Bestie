<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
       


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Notification</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
  
                    <form class="myform form-horizontal form-label-left">
	
                     
<div class="container">
 
  <ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#humar"><b>Humor</b></a></li>
    <li ><a data-toggle="tab" href="#message"><b>Message</b></a></li>
	<li ><a data-toggle="tab" href="#healthwelness"><b>Health & Wellness</b></a></li>
  </ul>
<br>
  <div class="tab-content">
  
  <div id="humar" class="tab-pane fade in active">
      <div class="form-group">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Title</label>
                        <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Title">
                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
		<div class="form-group">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Upload Image</label>
                        <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                        <input type="file" class="form-control" name="thoughtimage" accept="image/*" id="thoughtimage" value="uploadimage" onchange="showimagepreview1(this)" style="padding-left:46px; "/><img id="imgprvw1" class="img-responsive" style="margin-top:15px;"/>

                        <span class="fa  fa-file-image-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
    </div>
    <div id="message" class="tab-pane">
       <div class="form-group">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Message</label>
                        <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                        <textarea rows="5" type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Message"></textarea>
                        
                      </div>
                      </div>
		
    </div>
	<div id="healthwelness" class="tab-pane fade">
	<div class="form-group">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Exercise</label>
                        <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                        <select class="form-control" id="sel1">
    <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Breathing exercise</option>
    <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Neck exercise</option>
    <option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Aerobic exercise</option>
    
  </select>
                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
     <div class="form-group">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Content</label>
                        <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                        <textarea rows="5" type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Message" ></textarea>
                       
                      </div>
                      </div>
		
    </div>
    
    
    
  </div>
</div>

                      <div class="form-group">
                        <div class="col-md-12"><center>
                          <button type="button" class="btn btn-round btn-primary">Submit</button>
                          <button type="button" class="btn btn-round btn-warning">Cancel</button>
                    </center></div>
                      </div>

                    </form>



                  </div>
                </div>
              </div>
</div>
          </div>
        </div>
        <!-- /page content -->
<script type="text/javascript">
                                   function showimagepreview1(input) 
										{
										if (input.files && input.files[0]) {
										var filerdr = new FileReader();
										filerdr.onload = function(e) {
											//alert("hello");
											var image = new Image();
												//Set the Base64 string return from FileReader as source.
													   image.src = e.target.result;
															
													   //Validate the File Height and Width.
													   image.onload = function () {
														   var height = this.height;
														   var width = this.width;
														   var size = parseFloat($("#thoughtimage")[0].files[0].size / 1024).toFixed(2);
                                                if (size > 20000)
                                                {
                                                    alert("Sorry, your Image Size is too large.");
                                                    $('#imgprvw').attr('src', '');
                                                    $('.post_img').attr('src', '');
                                                    $('#thoughtimage').val("");
                                                    return false;
                                                }
												 
												   else
												   {
													   //alert ("image gud");
														$('#imgprvw1').attr('src', e.target.result);
														$('.post_img').attr('src', e.target.result);
												   }
											}
													
												/*$('#imgprvw').attr('src', e.target.result);
												$('.post_img').attr('src', e.target.result);*/
												}
												filerdr.readAsDataURL(input.files[0]);
												}
}
                                </script>
<?php include 'footer.php';?>
       