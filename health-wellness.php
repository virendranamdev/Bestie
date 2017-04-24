<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_group.js"></script>
<?php
include_once ('header.php');
include_once ('sidemenu.php');
include_once ('topNavigation.php');

include_once('Class_Library/class_Health_Wellness.php');

$objHealth = new HealthWellness();
$clientId = $_SESSION['client_id'];
$exercise = $objHealth->getExerciseArea($clientId);

$exercise_type = "";
$exercise_name = "";
$exercise_image = "";
$exercise_instruction = "";

if (isset($_GET['health'])) {
    $health_Id = $_GET['health'];
    $clientId = $_SESSION['client_id'];
//    include_once('Class_Library/class_Health_Wellness.php');
//    $obj = new HealthWellness();
    $exerciseDetails = $objHealth->getExerciseSingle($clientId, $health_Id);
    $exercise_type = $exerciseDetails['exercise_area_id'];
    $exercise_name = $exerciseDetails['exercise_name'];
    $img = explode("images/health_wellness/",$exerciseDetails['exercise_image']);
    $exercise_image = "images/health_wellness/".$img[1];
    $exercise_instruction = $exerciseDetails['exercise_instruction'];
    
}
?>

<link rel="stylesheet" href="build/css/health-wellness.css" >
<script type="text/javascript" src="http://code.jquery.com/jquery-git.js"></script>
<script type="text/javascript" src="build/js/health-wellness-group.js"></script>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Health & Wellness</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <form class="myform form-horizontal form-label-left" action="Link_Library/link_add_exercise.php" method="post" enctype="multipart/form-data">


                            <div class="container">

                                <!--<ul class="nav nav-tabs">
                                  <li class="active"><a data-toggle="tab" href="#health"><b>Health & Wellness</b></a></li>
                                
                                  <li><a data-toggle="tab" href="#humar"><b>Humor</b></a></li>
                                  
                                </ul>-->
                                <br><br>
                                <div class="tab-content">
                                    <div id="health" class="tab-pane fade in active">
                                        <div class="form-group">
                                            <label class=" control-label col-md-3 col-sm-3 col-xs-12">Exercise</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                                <input type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                                                <input type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
                                                <input type='hidden' name="flag" value="24">
                                                <input type='hidden' name="flagvalue" value="Health Wellness :">
                                                <input type='hidden' name="exerciseImage" value="<?php echo $exercise_image; ?>">

                                                <select class="form-control" id="sel1" name="exercise_type" <?php echo $val['exercise_area_id']; ?> >
                                                    <option>&nbsp;&nbsp;&nbsp;&nbsp;&emsp;Select Exercise Area </option>
                                                    <?php foreach ($exercise as $val) { ?>
                                                        <option <?php if ($exercise_type == $val['autoId']) { ?> selected="" <?php } ?> value="<?php echo $val['autoId']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&emsp; <?php echo $val['exercise_area']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label col-md-3 col-sm-3 col-xs-12">Title</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Title" name="exercise_name" value="<?php echo $exercise_name; ?>">
                                                <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label col-md-3 col-sm-3 col-xs-12">Upload Image</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12 form-group ">
                                                <input type="file" class="form-control" name="exerciseImage" accept="image/*" id="exerciseImage" value="uploadimage" onchange="showimagepreview1(this)" style="padding-left:46px; "/>
                                                <img src="<?php echo SITE.$exercise_image; ?>" id="imgprvw1" class="img-responsive"/>

                                                <span class="fa  fa-file-image-o form-control-feedback left" aria-hidden="true"></span>
                                            </div>

                                            <label class=" control-label col-md-3 col-sm-3 col-xs-12">Instruction</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                                <textarea type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Instruction" name="exercise_instructions"><?php echo strip_tags($exercise_instruction); ?></textarea>
                                                <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>

                                            </div>
                                        </div>

                                    </div>



                                </div>

                                <?php if (!isset($_GET['health'])) { ?>

<!--                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Group</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">

                                            <span id="inputSuccess2Status3" class="sr-only">(success)</span>


                                            <script type='text/javascript'>
                                            </script>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><label class="radio-inline"><input type="radio" name="optradio" id="sendTOAll">Send to All Group</label>
                                                    <label class="radio-inline"><input type="radio" name="optradio"id="sendToSelected" value="Selected">Send to Selected Group</label></div>

                                                <div class="selectedGroupData">

                                                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                        <div class="subject-info-box-1"><center><h2>All Group</h2></center>
                                                            <select multiple="multiple" id='lstBox1' class="form-control">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                                        <div >
                                                            <br><br><br><br>
                                                            <button type="button" class="btn newb btn-primary"id='btnAllRight'value='>>' > >> </button><br>
                                                            <button type="button" class="btn newb btn-primary"id='btnRight'value='>' > Add </button><br>
                                                            <button type="button" class="btn newb btn-primary"id='btnLeft'value='<' > Remove </button><br>
                                                            <button type="button" class="btn newb btn-primary"id='btnAllLeft'value='<<' > >> </button><br>

                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                        <div ><center><h2>Selected Group</h2></center>
                                                            <select multiple="multiple" id='lstBox2' class="form-control" name="selectedvalue[]">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                ---------------------------------
                                                <textarea id ="allids" style="display:none" name="all_user" height="660"></textarea>
                                                <textarea id="selectedids" style="display:none" name="selected_user"></textarea>
                                                ---------------------------------



                                            </div>

                                            <div class="clearfix"></div>

                                        </div>
                                    </div>-->

                                </div>
                                <br><br>

                                <div class="form-group">
                                    <div class="col-md-12"><center>
                                            <button type="submit" class="btn btn-round btn-primary">Submit</button>
                                            <button type="button" class="btn btn-round btn-warning">Cancel</button>
                                        </center></div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <div class="col-md-12"><center>
                                            <input type="hidden" name="healthid" value="<?php echo $_GET['health']; ?>">
                                            <button type="submit" name="updateHealth" class="btn btn-round btn-primary">Update</button>
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
<script type="text/javascript">
    function showimagepreview1(input)
    {
        if (input.files && input.files[0]) {
            var filerdr = new FileReader();
            filerdr.onload = function (e) {
                //alert("hello");
                var image = new Image();
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;

                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    var size = parseFloat($("#exerciseImage")[0].files[0].size / 1024).toFixed(2);
					if (size > 1500)
                    {
                        alert("Sorry, your Image Size is too large.");
                        $('#imgprvw1').attr('src', '');
                        $('.post_img').attr('src', '');
                        $('#exerciseImage').val("");
                        return false;
                    }
                    else if (height > 1200 || width > 1200) {
                        alert("Height and Width must not exceed 1200 X 1200 px.");
                       $('#imgprvw1').attr('src', "");
                       $('.post_img').attr('src', "");
                       $('#exerciseImage').val("");
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
<?php include 'footer.php'; ?>
       