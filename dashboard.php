<?php
include_once('header.php');
include_once('sidemenu.php');
include_once('topNavigation.php');

include_once("Class_Library/class_welcome_analytic.php");
$welcome = new WelcomeAnalytic();
$client_id = $_SESSION['client_id'];
$uid = $_SESSION['user_unique_id'];

$leaderboardResponse = $welcome->recognitionLeaderboard($client_id);
//echo '<pre>';print_r($leaderboardResponse);die;

$senderboardResponse = $welcome->recognitionSenderboard($client_id);
//echo '<pre>';print_r($senderboardResponse);die;
?>
<style>
    hr{
        margin-top: 0px ! important;
        margin-bottom: 0px ! important;
        opacity:0.3;
    }

</style>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="js/highcharts/exporting.js"></script>
<!-- page content -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type='text/javascript' src="js/analytic/home_activeUser.js"></script>

<script>
    $(document).ready(function () {

        var enddate = document.getElementById("startdate").value;
        var startday = document.getElementById("lastday").value;;

        //alert(startday);
        // alert(lastday);
        showActiveUserGraph(startday, enddate, '<?php echo SITE; ?>');
        showHappinessIndexGraph(startday, enddate,'<?php echo SITE; ?>');
        /**********************************/
        $("#dsds").hide();
        $("#homeActiveUser").click(function () {
            $("#dsds").show();
           
        });
        $(".htData").click(function () {
            $("#dsds").hide();

        });
    });
</script>

<script>
    function activeuser(val)
    {

        var enddate = document.getElementById("startdate").value;
        var startday = val;

      //  alert(startday);
      // alert(lastday);
        showActiveUserGraph(startday, enddate, '<?php echo SITE; ?>');
    
    }
    function customactiveuser(val)
    {

        var  startday= document.getElementById("fromDate").value;
        var  enddate= val;

     //   alert("this is start date-"+startday);
    //   alert("end date-"+enddate);
        showActiveUserGraph(startday, enddate, '<?php echo SITE; ?>');
    
    }
</script> 

<div class="right_col" role="main">
    <div class="">


        <div class="row">
            <div class="col-md-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Happiness Index</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li  class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div id="container2" style="min-width: 310px; height: 405px; max-width: 600px; margin: 0 auto"></div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Recognition</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li  class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">



                        <div><h4>Top 3 Receivers</h4></div>				  
                        <?php foreach ($leaderboardResponse['data'] as $data) { ?>
                            <div class="row" id="" >
                                <hr>
                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                    <img src='<?php echo $data['user_image']; ?>' class="img-circle" style="height:40px; width:40px;margin-top:8px;margin-bottom:5px;"><font style="padding-left:10px;font-size:15px;"><?php echo $data['username']; ?></font>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><font style="float:right;padding-top:15px;"><?php echo $data['totalRecognition']; ?> received</font></div> 
                            </div>

                        <?php } ?>

                        <br>
                        <div><h4>Top 3 Senders</h4></div>
                        <?php foreach ($senderboardResponse['data'] as $data) { ?>
                            <div class="row" id="" >
                                <hr>
                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                    <img src="<?php echo $data['user_image']; ?>" class="img-circle" style="height:40px; width:40px;margin-top:8px;margin-bottom:5px;">
                                    <font style="padding-left:10px;font-size:15px;"><?php echo $data['username']; ?></font>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><font style="float:right;padding-top:15px;"><?php echo $data['totalRecognitionMade']; ?> sent</font></div> 
                            </div>
                        <?php } ?>

                       
                     
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-3">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Values</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li  class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <input type="hidden" name="startdate" id="startdate" value="<?php echo date("Y-m-d"); ?>">
                        <div class="radio htData"><label><input type="radio" id="lastday" name="activeU" value="<?php echo date('Y-m-d', strtotime("-1 days")); ?>" onchange="activeuser(this.value);" checked="checked">Last 24 hours</label></div>
                        <div class="radio htData"><label><input type="radio"name="activeU" value="<?php echo date('Y-m-d', strtotime("-7 days")); ?>" onchange="activeuser(this.value);">Last Week</label></div>
                        <div class="radio htData"><label><input type="radio"name="activeU" value="<?php echo date('Y-m-d', strtotime("-30 days")); ?>" onchange="activeuser(this.value);">Last Month</label></div>
                        <div class="radio" id="homeActiveUser"><label><input type="radio" name="activeU" value = "customdate">Custom</label></div>
                        <div id="dsds"><form>
                                <div class="form-group">
                                    <label for="usr">From:</label>
<!--                                    <input type="date" class="form-control" id="usr">-->
                                    <input type="date" id="fromDate" name="input1" size="20" placeholder="mm/dd/yyyy"/>
                                </div>
                                <div class="form-group">
                                    <label for="pwd">To:&nbsp;&nbsp;</label>
<!--                                    <input type="date" class="form-control" id="pwd">-->
                                <input type="date" id="toDate" name="input2" size="20" onchange="customactiveuser(this.value);"  placeholder="mm/dd/yyyy"/>
                                </div></form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Active Users</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content activeUserGraphdataPrint">

                        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                    </div>
                </div>
            </div>
        </div>


 
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Top 5 Posts</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li class="pull-right"><a ><div class="form-group">
<!--                                        <input type="date" id="date" name="input1" size="20" placeholder="mm/dd/yyyy" />-->
                                    </div></a></li>

                        </ul>
                       
                        <div class="clearfix"></div>
                    </div>
                    <?php
                          include_once("Class_Library/class_clientLoginAnalytic.php");
		                $object1 = new LoginAnalytic();
		             
                                $data = $object1->gettoppostforwelcome($client_id,$uid);
//                                echo "<pre>";
//                                print_r($data);
//                                echo "</pre>";
                                $countdata = count($data);
                                ?>
                    <div class="x_content">
                        <?php
                        for($i=0;$i<$countdata;$i++)
                        {
                        ?>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month"><?php echo date('F', strtotime($data[$i]['viewdate'])); ?></p>
                                <p class="day"><?php echo date('d', strtotime($data[$i]['viewdate'])); ?></p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#"><?php if($data[$i]['flag'] == 11){		// Message/Reminder
		                        	echo $data[$i]['title'];
		                        }elseif($data[$i]['flag'] == 16){	// Thought of the day
						echo $data[$i]['title'];
		                        }elseif($data[$i]['flag'] == 20){	// Recognition
			                        echo $data[$i]['question'];
		                        }elseif($data[$i]['flag'] == 23){	// Album/Gallery
			                        echo $data[$i]['feedbackQuestion'];
		                        }elseif($data[$i]['flag'] == 26){	// Achiever/Colleague Story
		                        	echo $data[$i]['surveyTitle'];
		                        }
		                        
		                       ?></a>
                              <p><?php echo $data[$i]['module']; ?></p>
<!--                                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>-->
                            </div>
                        </article>
                        <?php
                        }
                        ?>
                 <!---       <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Two Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Two Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Two Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Three Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </article> ---->
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Recent Activity</h2>
                        <?php
		                include_once("Class_Library/Api_Class/class_display_welcome_data.php");
		                $obj = new PostDisplayWelcome();
		                $value = 0;                        
		                $response = $obj->PostDisplay($client_id, $uid, $value);
		                $recentData = $response['welcomedata'];
		                //echo'<pre>';print_r($response);die;
                        ?>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    	<?php for($i=0; $i<5; $i++){ ?>
                        <article class="media event">
                            <a class="pull-left date">
                            <?php $recentDate = explode(' ', $recentData[$i]['createdDate']); ?>
                                <p class="month"><?php echo date('F', strtotime($recentDate[1])); ?></p>
                                <p class="day"><?php echo $recentDate[0]; ?></p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="javascript:void(0);">
                                <?php 
		                        if($recentData[$i]['flagCheck'] == 2){		// Message/Reminder
		                        	echo $recentData[$i]['module'];
		                        }elseif($recentData[$i]['flagCheck'] == 5){	// Thought of the day
						echo $recentData[$i]['module'];
		                        }elseif($recentData[$i]['flagCheck'] == 10){	// Recognition
			                        echo $recentData[$i]['recognizeTitle'];
		                        }elseif($recentData[$i]['flagCheck'] == 11){	// Album/Gallery
			                        echo $recentData[$i]['title'];
		                        }elseif($recentData[$i]['flagCheck'] == 16){	// Achiever/Colleague Story
		                        	echo $recentData[$i]['title'];
		                        }elseif($recentData[$i]['flagCheck'] == 20){	// Happiness Index
		                        	echo $recentData[$i]['module'];
		                        }elseif($recentData[$i]['flagCheck'] == 25){	// Reminder
			                        echo $recentData[$i]['module'];
		                        }
                        	?>
                                	
                        	</a>
                                <p>
                                
                                <?php 
                                	if($recentData[$i]['flagCheck'] == 2){		// Message/Reminder
		                        	echo $recentData[$i]['post_content'];	
		                        }elseif($recentData[$i]['flagCheck'] == 5){	// Thought of the day
		                        	echo $recentData[$i]['message'];
		                        }elseif($recentData[$i]['flagCheck'] == 10){	// Recognition
		                        	echo '<b>'.$recentData[$i]['ByUsername'].'</b> recognized <b>'. $recentData[$i]['ToUsername'].'</b>';	
		                        }elseif($recentData[$i]['flagCheck'] == 11){	// Album/Gallery
		                        	echo $recentData[$i]['description'];
		                        }elseif($recentData[$i]['flagCheck'] == 16){	// Achiever/Colleague Story
		                        	echo substr($recentData[$i]['story'], 0, 250).' ...';
		                        }elseif($recentData[$i]['flagCheck'] == 20){	// Happiness Index
	                        		echo $recentData[$i]['question'];
		                        }elseif($recentData[$i]['flagCheck'] == 25){	// Reminder
		                        	echo $recentData[$i]['title'];
		                        }
                                ?>
                                </p>
                            </div>
                        </article>
                        <?php } ?>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!--------------------- these script for custom date picker -------------------------------------------->
<script type="text/javascript">
    var datefield = document.createElement("input")
    datefield.setAttribute("type", "date")
    if (datefield.type != "date") { //if browser doesn't support input type="date", load files for jQuery UI Date Picker
        document.write('<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"><\/script>\n')
        document.write('<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"><\/script>\n')
    }
</script>

<script>
    if (datefield.type != "date") { //if browser doesn't support input type="date", initialize date picker widget:
        jQuery(function ($) { //on document.ready
            $('#fromDate').datepicker();
        })
    }
</script>
<script>
    if (datefield.type != "date") { //if browser doesn't support input type="date", initialize date picker widget:
        jQuery(function ($) { //on document.ready
            $('#toDate').datepicker();
        })
    }
</script>
<script>
    if (datefield.type != "date") { //if browser doesn't support input type="date", initialize date picker widget:
        jQuery(function ($) { //on document.ready
            $('#date').datepicker();
        })
    }
</script>
<!--------------------- these script for custom date picker -------------------------------------------->
<?php include 'footer.php'; ?>
       
