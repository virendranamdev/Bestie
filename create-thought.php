<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<?php
include 'header.php';
include 'sidemenu.php';
include 'topNavigation.php';
//error_reporting(E_ALL);ini_set('display_errors', 1);

@session_start();
$thoughtImage = "";
$message = "";

if (isset($_GET['thought'])) {
    $thought_Id = $_GET['thought'];
    $clientId = $_SESSION['client_id'];
    include_once('Class_Library/class_Thought.php');
    $obj = new ThoughtOfDay();
    $thought_details = $obj->getSinglethought($thought_Id);
    $tdetails = json_decode($thought_details, true);

    $thoughtImage = $tdetails[0]['thoughtImage'];
    $message = $tdetails[0]['message'];
}
?>

<script>
    $(document).ready(function () {
        var thoughtImage = '<?php echo SITE.$thoughtImage ?>';
        $('#imgprvw1').attr('src', thoughtImage);
    });
</script>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Create New Thought</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!--<a href="wallPredefineTemplate.php"><button class="btn btn-primary pull-right btn-round"> Use Predefined Temple</button></a>-->

                        <br ><br ><br >
                        <form class="myform form-horizontal form-label-left" method="post" action="Link_Library/link_add_thought.php" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class=" control-label col-md-3 col-sm-3 col-xs-12">Upload Image</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <input type="hidden" name="flag" value="5"/>
                                    <input type="hidden" name="thoughtId" value="<?php echo $_GET['thought']; ?>"/>
                                    <input type="hidden" name="device" value=""/>
                                    <input type="hidden" name="useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>"/>
                                    <input type="hidden" name="clientid" value="<?php echo $_SESSION['client_id']; ?>"/>
                                    <input type="hidden" name="thoughtImage" value="<?php echo $thoughtImage; ?>"/>
                                    <input type="file" class="form-control" name="thoughtimage" accept="image/*" id="thoughtimage" value="uploadimage" onchange="showimagepreview1(this)" style="padding-left:46px; "/><img id="imgprvw1" class="img-responsive" style="margin-top:15px;" />

                                    <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Content</label>
                                <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                                    <textarea type="text" class="form-control has-feedback-left" placeholder="Content" name="content" ><?php echo $message; ?></textarea>
                                    <span class="fa fa-pencil-square-o form-control-feedback left" aria-hidden="true"></span>
                                    <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                                </div>
                            </div>


                            <div class="ln_solid"></div>

                            <?php if (!isset($_GET['thought'])) { ?>
                                <div class="form-group">
                                    <div class="col-md-12"><center>
                                            <button type="submit" name="addThought" class="btn btn-round btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-round btn-warning">Cancel</button>
                                        </center></div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <div class="col-md-12"><center>
                                            <button type="submit" name="updateThought" class="btn btn-round btn-primary">Update</button>
                                            <!--<button type="reset" class="btn btn-round btn-warning">Cancel</button>-->
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
    function showimagepreview1(input) {
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
                    var size = parseFloat($("#thoughtimage")[0].files[0].size / 1024).toFixed(2);
					if (size > 1500)
                    {
                        alert("Sorry, your Image Size is too large.");
                        $('#imgprvw1').attr('src', '');
                        $('.post_img').attr('src', '');
                        $('#thoughtimage').val("");
                        return false;
                    }
                    
                    else if (height > 1200 || width > 1200) {
                        alert("Height and Width must not exceed 1200 X 1200 px.");
                        $('#imgprvw1').attr('src', "");
                        $('.post_img').attr('src', "");
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
<?php include 'footer.php'; ?>
       
