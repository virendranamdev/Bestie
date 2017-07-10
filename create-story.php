<?php include 'header.php'; ?>
<?php include 'sidemenu.php'; ?>
<?php include 'topNavigation.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/display_group.js"></script>
<script src="js/validation/createPostValidation.js"></script>
<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this?')) {
            return true;
        } else {
            return false;
        }
    }
</script>

<?php
include_once('Class_Library/class_achiverstory.php');
$obj = new AchiverStory();
$clientId = $_SESSION['client_id'];
$flag = 16;
$titleachi = "";
$nameachi = "";
$designationachi = "";
$locationachi = "";
$achieveremail = "";
$storyachi = "";
$storyimg = "";
$imgpath = "";
if (isset($_GET['storyid'])) {
//echo "<script>alert('hi');</script>";
    $storyid = $_GET['storyid'];
    $storydetails = $obj->achiever_details($clientId, $storyid, $flag);
    $sdetails = json_decode($storydetails, true);

    $titleachi = $sdetails['data']['title'];
    $nameachi = $sdetails['data']['achieverName'];
    $designationachi = $sdetails['data']['designation'];
    $locationachi = $sdetails['data']['location'];
    $storyachi = $sdetails['data']['story'];
	$coverimage = $sdetails['data']['imagePath'];
}
?>
<style type="text/css">.thumb-image{float:left;max-width:210px;max-height:210px;position:relative;padding:5px;}</style>



<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php if (!isset($_GET['storyid'])) { ?> Create Story <?php } if (isset($_GET['storyid'])) { ?>Update Story <?php } ?></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br >
                        <form class="myform form-horizontal form-label-left" name="form1" role="form" action="Link_Library/link_post_achiver_story.php" method="post" enctype="multipart/form-data" onsubmit="return check();">

                            <input type="hidden" id="clientid" name="clientid" value="<?php echo $_SESSION['client_id']; ?>"> 
                            <input type="hidden" id="userid" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                            <input type="hidden" name="flag" value="16"> 

                            <div class="form-group">
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Title" name="storytitle" value="<?php echo $titleachi; ?>">
                                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div> 

                            <div class="form-group">
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12"> Name</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Name" name="achievername" value="<?php echo $nameachi; ?>">
                                    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12">Designation</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left"  maxlength="30" id="inputSuccess2" placeholder="Designation" name="achieverdesignation" value="<?php echo $designationachi; ?>">
                                    <!-- <span class="fa fa-id-card form-control-feedback left" aria-hidden="true"></span>-->
                                    <i class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12">Location</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Location" name="achieverlocation" value="<?php echo $locationachi; ?>">
                                    <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12">Email Id</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Email Id" name="achieveremail" value="<?php echo $achieveremail; ?>">
                                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12">Story</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group">
                                    <textarea cols="120" id="editor1" name="story" class="form-control" rows="10"><?php echo $storyachi; ?>	
                                    </textarea>
                                    <script>
                            CKEDITOR.replace('editor1');
                                    </script>

                                </div>
                            </div>


                            <?php if (!isset($_GET['storyid']))
                                { ?>    

                               

								<div class="form-group">
                                    <label class=" control-label col-md-3 col-sm-3 col-xs-12">Upload Cover Image</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                        <input class="form-control has-feedback-left" id="coverfileUpload" accept="image/*" type="file" name="achievercoverimage"/> 
                                        <span class="fa fa-file-image-o form-control-feedback left" aria-hidden="true"></span>
                                        <div class="row"><div id="coverimage-holder"class="col-md-12 col-sm-12"></div></div>

                                        <div class="row" id="previouscoverimage-holder"></div>
                                        <textarea style="display:none;" id="coverimagheight"></textarea>
                                        <textarea style="display:none;" id="coverimagwidth"></textarea>
                                    </div>
                                </div>

                                <!--------------------- upload multiple image ------------------------------------>                                  

                                <div class="form-group">
                                    <label class=" control-label col-md-3 col-sm-3 col-xs-12">Upload Image</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                        <input class="form-control has-feedback-left" id="fileUpload" multiple="multiple" accept="image/*" type="file" name="achieverimage[]"/> 
                                        <span class="fa fa-file-image-o form-control-feedback left" aria-hidden="true"></span>
                                        <div class="row"><div id="image-holder"class="col-md-12 col-sm-12"></div></div>

                                        <div class="row" id="previousimage-holder"></div>
                                        <textarea style="display:none;" id="imagheight"></textarea>
                                        <textarea style="display:none;" id="imagwidth"></textarea>
                                    </div>
                                </div>
                            <?php
                            } else {
                                ?>

                                
                                  <div class="form-group">
                                    <label class=" control-label col-md-3 col-sm-3 col-xs-12">Upload Cover Image</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                        <input class="form-control has-feedback-left" id="coverfileUpload" accept="image/*" type="file" name="achievercoverimage"/> 
                                        <span class="fa fa-file-image-o form-control-feedback left" aria-hidden="true"></span>

                                        <div class="row"><div id="coverimage-holder" class="col-md-12 col-sm-12"></div>

                                        </div>

                                        <div class="row" id="coverpreviousimage-holder">

                                                <div class="col-xs-4 col-lg-4 col-md-4 col-sm-4"><img src="<?php echo $coverimage; ?> " class="img img-responsive"></div>

                                           
                                        </div>
                                        <textarea style="display:none;" id="coverimagheight"></textarea>
                                        <textarea  style="display:none;"  id="coverimagwidth"></textarea>
                                    </div>
                                </div>
                                
                                
       <!------------------------------upload multiple image--------------------------------->    
                                
                                <div class="form-group">
                                    <label class=" control-label col-md-3 col-sm-3 col-xs-12">Upload Image</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                        <input class="form-control has-feedback-left" id="fileUpload" multiple="multiple" accept="image/*" type="file" name="achieverimage[]"/> 
                                        <span class="fa fa-file-image-o form-control-feedback left" aria-hidden="true"></span>

                                        <div class="row"><div id="image-holder" class="col-md-12 col-sm-12"></div>

                                        </div>

                                        <div class="row" id="previousimage-holder">

    <?php
    //echo "<pre>";
    //print_r($sdetails);
    for ($i = 0; $i < count($sdetails['image']); $i++) {
        $imgpath = $sdetails['image'][$i]['imagePath'];
        ?>
                                                <div class="col-xs-4 col-lg-4 col-md-4 col-sm-4"><img src="<?php echo $imgpath; ?> " class="img img-responsive"></div>

                                            <?php } ?>
                                        </div>
                                        <textarea style="display:none;" id="imagheight"></textarea>
                                        <textarea  style="display:none;"  id="imagwidth"></textarea>
                                    </div>
                                </div>
<?php } ?>
                            <!---------------- group --------------------->
                            <input type="radio" style="display:none;" name="optradio" id="sendTOAll" value="All" checked>
                            <input type="radio" style="display:none;" name="optradio"id="sendToSelected" value="Selected">
                            <textarea style="display:none;" id ="allids" name="all_user" height="660"></textarea>
                            <textarea style="display:none;" id="selectedids" name="selected_user"></textarea>
                            <!---------------- / group --------------------->
                            <br>
<?php if (!isset($_GET['storyid'])) { ?>
                                <div class="form-group">
                                    <div class="col-md-12"><center>
                                            <button onclick =" return ValidateStory();" type="submit" class="btn btn-round btn-primary" name="sub">Submit</button>
                                            <!--<button type="reset" class="btn btn-round btn-warning">Cancel</button>-->
                                        </center></div>
                                </div>
<?php } else {
    ?>
                                <div class="form-group">
                                    <div class="col-md-12"><center>
                                            <input type="hidden" name="storyid" value="<?php echo $storyid; ?>">
                                            <button type="submit" name="updatestory" class="btn btn-round btn-primary" onclick ="return ValidateUpdateStory();">Update</button>
                                        </center></div>
                                </div>
<?php } ?>
                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<script>
    $(document).ready(function () {
        $("#fileUpload").on('change', function () {
            //alert("hi");
            $("#previousimage-holder").hide();

            //Get count of selected files
            var countFiles = $(this)[0].files.length;
            //alert(parseInt($(this)[0].files.length));
            if (parseInt($(this)[0].files.length) > 4)
            {
                alert("You can only upload a maximum of 4 files");
                $("#fileUpload").val("");
                $("#image-holder").empty();
            }
            else
            {
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#image-holder");
                image_holder.empty();
                $('#imagheight').text('');
                $('#imagwidth').text('');
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {
                        var selectionsheight = [];
                        var selectionswidth = [];
                        //loop for each file selected for uploaded.

                        for (var i = 0; i < countFiles; i++)
                        {

                            var reader = new FileReader();
                            reader.onload = function (e) {
                                /*************************************************/
                                var img = new Image();
                                img.src = e.target.result;
                                img.onload = function () {
                                    var imageheight = this.height;
                                    var imagewidth = this.width;
                                    $('#imagheight').text('');
                                    $('#imagwidth').text('');

                                    selectionsheight.push(imageheight);
                                    var textareaheightstring = selectionsheight.toString();
                                    $('#imagheight').append(textareaheightstring);

                                    selectionswidth.push(imagewidth);
                                    var textareawidthstring = selectionswidth.toString();
                                    $('#imagwidth').append(textareawidthstring);

                                    /****************************************/
                                    $("<img />", {
                                        "src": e.target.result,
                                        "id": "imgpreid",
                                        "class": "thumb-image img img-responsive"
                                    }).appendTo(image_holder);

                                }

                            }

                            image_holder.show();
                            //alert(image_holder.val());
                            reader.readAsDataURL($(this)[0].files[i]);

                        }
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                } else {
                    alert("Pls select only images");
                }
            }
        });
        
      
		
		/************************ cover image **************************/
		
		$("#coverfileUpload").on('change', function () {
           
			$("#coverpreviousimage-holder").hide();

            //Get count of selected files
            var covercountFiles = $(this)[0].files.length;
            //alert(parseInt($(this)[0].files.length));
            if (parseInt($(this)[0].files.length) > 1)
            {
                alert("You can only upload a maximum of 1 files");
                $("#coverfileUpload").val("");
                $("#coverimage-holder").empty();
            }
            else
            {
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var coverimage_holder = $("#coverimage-holder");
                coverimage_holder.empty();
                $('#coverimagheight').text('');
                $('#coverimagwidth').text('');
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {
                        var selectionsheight = [];
                        var selectionswidth = [];
                        //loop for each file selected for uploaded.

                        for (var i = 0; i < covercountFiles; i++)
                        {

                            var reader = new FileReader();
                            reader.onload = function (e) {
                                /*************************************************/
                                var img = new Image();
                                img.src = e.target.result;
                                img.onload = function () {
                                    var imageheight = this.height;
                                    var imagewidth = this.width;
                                    $('#coverimagheight').text('');
                                    $('#coverimagwidth').text('');

									//alert(imagewidth);
									//alert(imageheight);
									
                                    selectionsheight.push(imageheight);
                                    var textareaheightstring = selectionsheight.toString();
                                    $('#coverimagheight').append(textareaheightstring);

                                    selectionswidth.push(imagewidth);
                                    var textareawidthstring = selectionswidth.toString();
                                    $('#coverimagwidth').append(textareawidthstring);

                                    /****************************************/
                                    $("<img />", {
                                        "src": e.target.result,
                                        "id": "coverimgpreid",
                                        "class": "thumb-image img img-responsive"
                                    }).appendTo(coverimage_holder);

                                }

                            }

                            coverimage_holder.show();
                            //alert(image_holder.val());
                            reader.readAsDataURL($(this)[0].files[i]);

                        }
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                } else {
                    alert("Pls select only images");
                }
            }
        });
		
		/**************************** cover image ***********************/
		
    });
</script>



<!--<?php include 'footer2.php'; ?>-->
