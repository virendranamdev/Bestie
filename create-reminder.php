<?php include 'header.php'; ?>
<?php include 'sidemenu.php'; ?>
<?php include 'topNavigation.php'; ?>
<script src="js/validation/createPostValidation.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_group.js"></script>    

<script type="text/javascript" src="http://code.jquery.com/jquery-git.js"></script>
<script type="text/javascript" src="build/js/create-notification.js"></script>
<link rel="stylesheet" href="build/css/create-notification.css" >
<script type="text/javascript" src="build/js/create-notification-message-group.js"></script>
<link rel="stylesheet" href="build/css/create-notification-message-group.css" >
<script type="text/javascript" src="build/js/create-notification-healthwellness.js"></script>
<link rel="stylesheet" href="build/css/create-notification-healthwellness.css" >
<!------------------------ send notification ----------------------------->
<script type="text/javascript" src="build/js/create-notification-sendnotification.js"></script>
<link rel="stylesheet" href="build/css/create-notification-sendnotification.css">
<!------------------------ / send notification --------------------------->
<?php
include_once('Class_Library/class_Health_Wellness.php');
$healthobj = new HealthWellness();
$clientId = $_SESSION['client_id'];
$excersicedetail = $healthobj->getExercises($clientId);
?> 

<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this?')) {
            return true;
        } else {
            return false;
        }
    }
</script> 

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

<!--                        <form class="myform form-horizontal form-label-left">
                        </form>-->

                        <div class="container">

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#humar"><b>Reminder</b></a></li>
                                <li ><a data-toggle="tab" href="#message"><b>Message</b></a></li>
                                <li ><a data-toggle="tab" href="#healthwelness"><b>Health & Wellness</b></a></li>
                                <li ><a data-toggle="tab" href="#sendNotification"><b>Send Notification</b></a></li>
                            </ul>
                            <br>
                            <div class="tab-content">

                                <div id="humar" class="tab-pane fade in active">
                                    <form role="form" name="remiderform" method="POST" action="Link_Library/link_postremider.php" enctype="multipart/form-data" onsubmit="return check();">

                                        <div class="form-group">
                                            <label class=" control-label col-md-2 col-sm-2 col-xs-12">Title</label>
                                            <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                                <input type="hidden" name = "flag" value="25">
                                                <input type="hidden" name = "flagvalue" value="Reminder :">
                                                <input type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                                                <input type="hidden" name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">

                                                <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Title" name="remindertitle">
                                                <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label col-md-2 col-sm-2 col-xs-12">Upload Image</label>
                                            <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                                <input type="file" class="form-control" name="remiderimage" accept="image/*" id="thoughtimage" value="uploadimage" onchange="showimagepreview1(this)" style="padding-left:46px; "/><img id="imgprvw1" class="img-responsive" style="margin-top:15px;"/>

                                                <span class="fa  fa-file-image-o form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12">Group</label>
                                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">

                                                <span id="inputSuccess2Status3" class="sr-only">(success)</span>



                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><label class="radio-inline"><input type="radio" name="optradio" id="sendTOAll" value="All" checked>Send to All Group</label>
                                                        <label class="radio-inline"><input type="radio" name="optradio"id="sendToSelected" value="Selected">Send to Selected Group</label></div>

                                                    <div class="selectedGroupData2">

                                                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                            <div class="subject-info-box-1"><center><h2>All Group</h2></center>
                                                                <select multiple="multiple" id='lstBox1' class="form-control">
                                                                    <!--<option value="ajax">Ajax</option>
                                                                    <option value="jquery">jQuery</option>
                                                                    <option value="javascript">JavaScript</option>
                                                                    <option value="mootool">MooTools</option>
                                                                    <option value="prototype">Prototype</option>
                                                                    <option value="dojo">Dojo</option>
                                                                    <option value="asp">ASP.NET</option>
                                                                    <option value="c#">C#</option>
                                                                    <option value="vb">VB.NET</option>
                                                                    <option value="java">Java</option>
                                                                    <option value="php">PHP</option>
                                                                    <option value="python">Python</option>-->
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                                            <div >
                                                                <br><br><br><br>
                                                                <!--<button type="button" class="btn newb btn-primary"id='btnAllRight'value='>>' > >> </button><br>-->
                                                                <button type="button" class="btn newb btn-primary"id='btnRight'value='>' > Add </button><br>
                                                                <button type="button" class="btn newb btn-primary"id='btnLeft'value='<' > Remove </button><br>
                                                                <!--<button type="button" class="btn newb btn-primary"id='btnAllLeft'value='<<' > >> </button><br>-->

                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                            <div ><center><h2>Selected Group</h2></center>
                                                                <select multiple="multiple" id='lstBox2' class="form-control">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!------------------------------------->
                                                    <textarea style="display:none;" id ="allids" name="all_user" height="660"></textarea>
                                                    <textarea style="display:none;" id="selectedids" name="selected_user"></textarea>
                                                    <!------------------------------------->
                                                </div>

                                                <div class="clearfix"></div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12"><center>
                                                    <!--<button type="submit" name="remindersubmit" class="btn btn-round btn-primary">Submit</button>-->
                                                    <input type="submit" onclick="return Validatereminder();" name="remindersubmit" class="btn btn-round btn-primary">
                                                    <!--<button type="button" class="btn btn-round btn-warning">Cancel</button>-->
                                                </center></div>
                                        </div>


                                    </form>			  
                                </div>
                                <!------------------------------- message ---------------------------------->
                                <div id="message" class="tab-pane">
                                    <form role="form" name="postmessageform" method="post" action="Link_Library/link_post_message.php" onsubmit="return check();">

                                        <input type="hidden" name = "flag" value="2">
                                        <input type="hidden" name = "flagvalue" value="Message :">
                                        <input type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                                        <input type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">

                                        <!--
                                        <div class="form-group">
                                            <label class=" control-label col-md-2 col-sm-2 col-xs-12">Title</label>
                                                <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">	
                                                        <input type="text" name="title" id="messageTitle" class="form-control has-feedback-left" placeholder="Enter Title" required />
                                                </div>
                                        </div>
                                        -->

                                        <div class="form-group">
                                            <label class=" control-label col-md-2 col-sm-2 col-xs-12">Message</label>
                                            <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                                <textarea rows="5" type="text" class="form-control has-feedback-left" id="inputSuccess2" required placeholder="Enter Message" name="messagecontent"></textarea>

                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12">Group</label>
                                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">

                                                <span id="inputSuccess2Status3" class="sr-only">(success)</span>



                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><label class="radio-inline"><input type="radio" name="optradio" id="sendTOAlll" value="All" checked>Send to All Group</label>
                                                        <label class="radio-inline"><input type="radio" name="optradio"id="sendToSelectedd" value="Selected">Send to Selected Group</label></div>

                                                    <div class="selectedGroupData1">

                                                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                            <div class="subject-info-box-1"><center><h2>All Group</h2></center>
                                                                <select multiple="multiple" id='lstBox11' class="form-control">
                                                                    <!--<option value="ajax">Ajax</option>
                                                                    <option value="jquery">jQuery</option>
                                                                    <option value="javascript">JavaScript</option>
                                                                    <option value="mootool">MooTools</option>
                                                                    <option value="prototype">Prototype</option>
                                                                    <option value="dojo">Dojo</option>
                                                                    <option value="asp">ASP.NET</option>
                                                                    <option value="c#">C#</option>
                                                                    <option value="vb">VB.NET</option>
                                                                    <option value="java">Java</option>
                                                                    <option value="php">PHP</option>
                                                                    <option value="python">Python</option>-->
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                                            <div >
                                                                <br><br><br><br>
                                                                <!--<button type="button" class="btn newb btn-primary"id='btnAllRight'value='>>' > >> </button><br>-->
                                                                <button type="button" class="btn newb btn-primary"id='btnRightt'value='>' > Add </button><br>
                                                                <button type="button" class="btn newb btn-primary"id='btnLeftt'value='<' > Remove </button><br>
                                                                <!--<button type="button" class="btn newb btn-primary"id='btnAllLeft'value='<<' > >> </button><br>-->

                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                            <div ><center><h2>Selected Group</h2></center>
                                                                <select multiple="multiple" id='lstBox22' class="form-control">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!------------------------------------->
                                                    <textarea style="display:none;" id ="allids11" name="all_user" height="660"></textarea>
                                                    <textarea style="display:none;" id="selectedids11" name="selected_user"></textarea>
                                                    <!------------------------------------->
                                                </div>

                                                <div class="clearfix"></div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12"><center>
                                                    <button type="submit" name="messagesubmit" onclick = "return Validatenotificationmessage();" class="btn btn-round btn-primary">Submit</button>
                                                    <!--<button type="button" class="btn btn-round btn-warning">Cancel</button>-->
                                                </center></div>
                                        </div>

                                    </form>			  
                                </div>
                                <!-------------------------- / message ---------------------------------->
                                <div id="healthwelness" class="tab-pane fade">
                                    <form role="form" name="healthform" method="post" action="Link_Library/link_helthwellnessnotification.php" onsubmit="return check();">
                                        <div class="form-group">
                                            <label class=" control-label col-md-2 col-sm-2 col-xs-12">Exercise</label>
                                            <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                                <input type="hidden" name = "flag" value="24">
                                                <input type="hidden" name = "flagvalue" value="Exercise :">
                                                <input type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                                                <input type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
                                                <select class="form-control" id="sel1" name="exerciseid">
                                                    <?php
                                                    for ($i = 0; $i < count($excersicedetail); $i++) {
                                                        ?>
                                                        <option value="<?php echo $excersicedetail[$i]['exercise_area_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $excersicedetail[$i]['exercise_area']; ?></option>

                                                    <?php } ?>
                                                </select>
                                                <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class=" control-label col-md-2 col-sm-2 col-xs-12">Content</label>
                                            <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                                <textarea rows="5" required type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Message" name="exercisecontent"></textarea>

                                            </div>
                                        </div>





                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12">Group</label>
                                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">

                                                <span id="inputSuccess2Status3" class="sr-only">(success)</span>



                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><label class="radio-inline"><input type="radio" name="optradio" id="sendTOAll4" value="All" checked>Send to All Group</label>
                                                        <label class="radio-inline"><input type="radio" name="optradio"id="sendToSelected4" value="Selected">Send to Selected Group</label></div>

                                                    <div class="selectedGroupData">

                                                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                            <div class="subject-info-box-1"><center><h2>All Group</h2></center>
                                                                <select multiple="multiple" id='lstBox14' class="form-control">
                                                                    <!--<option value="ajax">Ajax</option>
                                                                    <option value="jquery">jQuery</option>
                                                                    <option value="javascript">JavaScript</option>
                                                                    <option value="mootool">MooTools</option>
                                                                    <option value="prototype">Prototype</option>
                                                                    <option value="dojo">Dojo</option>
                                                                    <option value="asp">ASP.NET</option>
                                                                    <option value="c#">C#</option>
                                                                    <option value="vb">VB.NET</option>
                                                                    <option value="java">Java</option>
                                                                    <option value="php">PHP</option>
                                                                    <option value="python">Python</option>-->
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                                            <div >
                                                                <br><br><br><br>
                                                                <!--<button type="button" class="btn newb btn-primary"id='btnAllRight'value='>>' > >> </button><br>-->
                                                                <button type="button" class="btn newb btn-primary"id='btnRight4'value='>' > Add </button><br>
                                                                <button type="button" class="btn newb btn-primary"id='btnLeft4'value='<' > Remove </button><br>
                                                                <!--<button type="button" class="btn newb btn-primary"id='btnAllLeft'value='<<' > >> </button><br>-->

                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                            <div ><center><h2>Selected Group</h2></center>
                                                                <select multiple="multiple" id='lstBox24' class="form-control">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!------------------------------------->
                                                    <textarea style="display:none;" id ="allids14" name="all_user" height="660"></textarea>
                                                    <textarea style="display:none;" id="selectedids24" name="selected_user"></textarea>
                                                    <!------------------------------------->
                                                </div>
                                                <div class="clearfix"></div>
                                            </div></div>

                                        <div class="form-group">
                                            <div class="col-md-12"><center>
                                                    <button type="submit" name="helthformsubmit" onclick="return Validatenotificationhealth();" class="btn btn-round btn-primary">Submit</button>
                                                    <!--<button type="button" class="btn btn-round btn-warning">Cancel</button>-->
                                                </center></div>
                                        </div>
                                    </form>
                                </div>

                                <!-------------------------- / Send Notification ------------------------->
                                <div id="sendNotification" class="tab-pane fade">
                                    <form role="form" name="sendNotificationform" method="post" action="Link_Library/link_sendNotification.php" onsubmit="return check();">
<!--                                        <div class="form-group">
                                            <label class=" control-label col-md-2 col-sm-2 col-xs-12">Exercise</label>
                                            <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                                <input type="hidden" name = "flag" value="24">
                                                <input type="hidden" name = "flagvalue" value="Exercise :">
                                                <input type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                                                <input type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
                                                <select class="form-control" id="sel1" name="exerciseid">
                                                    <?php
                                                    for ($i = 0; $i < count($excersicedetail); $i++) {
                                                        ?>
                                                        <option value="<?php echo $excersicedetail[$i]['exercise_area_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $excersicedetail[$i]['exercise_area']; ?></option>

                                                    <?php } ?>
                                                </select>
                                                <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <label class=" control-label col-md-2 col-sm-2 col-xs-12">Content</label>
                                            <div class="col-md-10 col-sm-10 col-xs-12 form-group has-feedback">
                                                <textarea rows="5" required type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Message" name="notificationcontent"></textarea>

                                            </div>
                                        </div>





                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2 col-xs-12">Group</label>
                                            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">

                                                <span id="inputSuccess2Status3" class="sr-only">(success)</span>



                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><label class="radio-inline"><input type="radio" name="optradio" id="sendTOAll5" value="All" checked>Send to All Group</label>
                                                        <label class="radio-inline"><input type="radio" name="optradio"id="sendToSelected5" value="Selected">Send to Selected Group</label></div>

                                                    <div class="selectedGroupData5">

                                                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                            <div class="subject-info-box-1"><center><h2>All Group</h2></center>
                                                                <select multiple="multiple" id='lstBox15' class="form-control">
                                                                    <!--<option value="ajax">Ajax</option>
                                                                    <option value="jquery">jQuery</option>
                                                                    <option value="javascript">JavaScript</option>
                                                                    <option value="mootool">MooTools</option>
                                                                    <option value="prototype">Prototype</option>
                                                                    <option value="dojo">Dojo</option>
                                                                    <option value="asp">ASP.NET</option>
                                                                    <option value="c#">C#</option>
                                                                    <option value="vb">VB.NET</option>
                                                                    <option value="java">Java</option>
                                                                    <option value="php">PHP</option>
                                                                    <option value="python">Python</option>-->
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                                            <div >
                                                                <br><br><br><br>
                                                                <!--<button type="button" class="btn newb btn-primary"id='btnAllRight'value='>>' > >> </button><br>-->
                                                                <button type="button" class="btn newb btn-primary"id='btnRight5'value='>' > Add </button><br>
                                                                <button type="button" class="btn newb btn-primary"id='btnLeft5'value='<' > Remove </button><br>
                                                                <!--<button type="button" class="btn newb btn-primary"id='btnAllLeft'value='<<' > >> </button><br>-->

                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                                            <div ><center><h2>Selected Group</h2></center>
                                                                <select multiple="multiple" id='lstBox25' class="form-control">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!------------------------------------->
                                                    <textarea  style="display:none" id ="allids15" name="all_user" height="660"></textarea>
                                                    <textarea  style="display:none" id="selectedids25" name="selected_user"></textarea>
                                                    <!------------------------------------->
                                                </div>
                                                <div class="clearfix"></div>
                                            </div></div>

                                        <div class="form-group">
                                            <div class="col-md-12"><center>
                                                    <button type="submit" name="sendNotificationformsubmit" onclick="return ValidateSendnotification();" class="btn btn-round btn-primary">Submit</button>
                                                    <!--<button type="button" class="btn btn-round btn-warning">Cancel</button>-->
                                                </center></div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>







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
                    var size = parseFloat($("#thoughtimage")[0].files[0].size / 1024).toFixed(2);
                    //alert(size);
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
       
