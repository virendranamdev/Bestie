<?php
include_once('header.php');
include_once('sidemenu.php');
include_once('topNavigation.php');

include_once("Class_Library/class_welcome_analytic.php");
include_once("Class_Library/class_getDepartment.php");
$welcome = new WelcomeAnalytic();
$department = new Department();
$client_id = $_SESSION['client_id'];
$uid = $_SESSION['user_unique_id'];

$leaderboardResponse = $welcome->recognitionLeaderboard($client_id);
//echo '<pre>';print_r($leaderboardResponse);die;

$senderboardResponse = $welcome->recognitionSenderboard($client_id);
//echo '<pre>';print_r($senderboardResponse);die;

$getalldepartment = $department->getDepartment($client_id);
$alldepartmentarray = json_decode($getalldepartment , true);
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
        var startday = document.getElementById("lastweek").value;
		var department = 'All';
                var location = 'All';
		var happinessenddate = document.getElementById("happstartdate").value;
		var happinessstartdate = document.getElementById("happenddate").value;
        //alert("end "+happinessenddate);
        //alert("start "+happinessstartdate);
        showActiveUserGraph(startday, enddate, department,location, '<?php echo SITE; ?>');
        showHappinessIndexGraph(happinessstartdate, happinessenddate, department, '<?php echo SITE; ?>');
		//alert(showHappinessIndexGraph);
        /**********************************/
       /* $("#dsds").hide();
        $("#homeActiveUser").click(function () {
            $("#dsds").show();
           
        });
        $(".htData").click(function () {
            $("#dsds").hide();

        });*/
    });
</script>

<script>
   
   	
	function customactiveuser()
    {
		//alert("hello");
		
        var  startday= document.getElementById("fromDate").value;
		var  enddate= document.getElementById("toDate").value;
		var  department= document.getElementById("alldepartments").value;
		var location = 'All';
		//alert("from" + startday);
		//alert("end"+ enddate);
		//alert("department"+ department);

        if (startday == "")
		{
        window.alert("Please select From date.");
        document.getElementById("fromDate").focus();
        return false;
		}
		if (enddate == "")
		{
			window.alert("Please select To date.");
			document.getElementById("toDate").focus();
			return false;
		}
		if (department == "")
		{
			window.alert("Please select department.");
			document.getElementById("alldepartments").focus();
			return false;
		}
		
        showActiveUserGraph(startday, enddate, department,location, '<?php echo SITE; ?>');
    
    }
	
	/**************************** happiness index ************************/
	function lasthappinessindex()
    {
		alert('hi');
		//var enddate = document.getElementById("happstartdate").value;
        //var startday = document.getElementById("happenddate").value;
		var department= document.getElementById("departmenthapp").value;		
		var happinessenddate = document.getElementById("htodate").value;
		var happinessstartdate = document.getElementById("hfromdate").value;
        alert("end "+happinessenddate);
        alert("start "+happinessstartdate);
		//alert(department);
		if (happinessstartdate == "")
		{
			window.alert("Please select From Date.");
			document.getElementById("hfromdate").focus();
			return false;
		}
		if (happinessenddate == "")
		{
			window.alert("Please select To Date.");
			document.getElementById("htodate").focus();
			return false;
		}
		if (department == "")
		{
			window.alert("Please select department.");
			document.getElementById("departmenthapp").focus();
			return false;
		}
		showHappinessIndexGraph(happinessstartdate, happinessenddate, department, '<?php echo SITE; ?>');
	}
	/**************************** / happiness index **********************/
</script> 

<div class="right_col" role="main">
    <div class="">


        <div class="row">
            <div class="col-md-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Happiness Index</h2>
						<?php /*echo "<pre>";
						print_r($alldepartmentarray);
						echo "</pre>";*/
						?>
                        <ul class="nav navbar-right panel_toolbox">
                            <li  class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

						<!---------------------- department ----------------->
						<form>
						<div class="row">
							<div class="col-xs-6">
								<div class="form-group">
								<label for="pwd">From:&nbsp;&nbsp;</label>
								<input type="date" id="hfromdate" name="hfromdate" size="20" class="form-control" placeholder="mm/dd/yyyy"/>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
								<label for="pwd">To:&nbsp;&nbsp;</label>
								<input type="date" id="htodate" name="htodate" size="20" class="form-control" placeholder="mm/dd/yyyy"/>
								</div>
							</div>
						</div>
						<div class="form-group">
						
									<input type="hidden" name="happstartdate" id="happstartdate" value="<?php echo date('Y-m-d', strtotime("-1 days")); ?>">
                       
									<input type="hidden" id="happenddate" name="happenddate" value="<?php echo date('Y-m-d', strtotime("-1 days")); ?>">
						
                                    <label for="pwd">Department:&nbsp;&nbsp;</label>
									<select name="departmenthapp" id="departmenthapp" class="form-control">
									<option value="All">All</option>
									<?php 
									for($i=0; $i<count($alldepartmentarray); $i++)
									{
										if($alldepartmentarray[$i]['department'] == "")
										{
											continue;
										}
									?>
									<option value="<?php echo $alldepartmentarray[$i]['department'];?>"><?php echo $alldepartmentarray[$i]['department'];?></option>
									<?php }?>
									</select>
                               
                                </div>
								
								<div class="form-group">
                                    <center><button type="button" class="btn btn-info" onclick="return lasthappinessindex();">Submit</button></center>
                               
                                </div>
								</form>
						<!----------------------- / department -------------->
					
                        <div id="container2" style="min-width: 310px; height: 405px; max-width: 600px; margin: 0 auto"></div>
						<p><b>Total Respondent :</b> <span id="totalhappcomm"></span></p>
						
						
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
                                    <img src='<?php echo $data['user_image']; ?>' class="img-circle" style="height:40px; width:40px;margin-top:8px;margin-bottom:5px;" onerror="this.src='images/user.png'"/><font style="padding-left:10px;font-size:15px;"><?php echo $data['username']; ?></font>
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
                                    <img src="<?php echo $data['user_image']; ?>" class="img-circle" style="height:40px; width:40px;margin-top:8px;margin-bottom:5px;" onerror="this.src='images/user.png'"/>
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
						
                        <!--<div class="radio htData"><label><input type="radio" id="lastday" name="activeU" value="<?php echo date('Y-m-d', strtotime("-7 days")); ?>" onchange="activeuser(this.value);" checked="checked">Last 24 hours</label></div>-->
						
                        <div class="radio htData"><label><input type="radio" style="display:none;" id="lastweek" name="activeU" value="<?php echo date('Y-m-d', strtotime("-7 days")); ?>" checked="checked"></label></div>
						
                        <!--<div class="radio htData"><label><input type="radio"name="activeU" value="<?php echo date('Y-m-d', strtotime("-30 days")); ?>" onchange="activeuser(this.value);">Last Month</label></div>-->
						
						
                        <!--<div class="radio" id="homeActiveUser"><label><input type="radio" name="activeU" value = "customdate">Custom</label></div>-->
                        <div id="dsds"><form>
                                <div class="form-group">
                                    <label for="usr">From:</label>
<!--                                    <input type="date" class="form-control" id="usr">-->
                                    <input type="date" id="fromDate" name="input1" size="20" class="form-control" placeholder="mm/dd/yyyy"/>
                                </div>
                                <div class="form-group">
                                    <label for="pwd">To:&nbsp;&nbsp;</label>
<!--                                    <input type="date" class="form-control" id="pwd">-->
                                <!--<input type="date" id="toDate" name="input2" size="20" onchange="customactiveuser(this.value);"  placeholder="mm/dd/yyyy"/>-->
								
								<input type="date" id="toDate" class="form-control" name="input2" size="20" placeholder="mm/dd/yyyy"/>
								
                                </div>
								
								<div class="form-group">
                                    <label for="pwd">Department:&nbsp;&nbsp;</label>
									<select name="alldepartments" id="alldepartments" class="form-control">
									<option value="All">All</option>
									<?php 
									for($i=0; $i<count($alldepartmentarray); $i++)
									{
										if($alldepartmentarray[$i]['department'] == "")
										{
											continue;
										}
									?>
									<option value="<?php echo $alldepartmentarray[$i]['department'];?>"><?php echo $alldepartmentarray[$i]['department'];?></option>
									<?php }?>
									</select>
                               
                                </div>
								
								<div class="form-group">
                                   <center><button type="button" class="btn btn-info" onclick="return customactiveuser();">Submit</button> </center>
                               
                                </div>
								
								</form>
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
		                        }elseif($data[$i]['flag'] == 23){	// Recognition
			                        echo $data[$i]['feedbackQuestion'];
		                        }elseif($data[$i]['flag'] == 24){	// Album/Gallery
			                        echo $data[$i]['exercise_name'];
		                        }
		                        
		                       ?></a>
                              <p><?php echo $data[$i]['module']; ?></p>
                              <i class="fa fa-thumbs-o-up" aria-hidden="true"><?php echo $data[$i]['totallike']; ?></i>&nbsp;&nbsp;
                              <i class="glyphicon glyphicon-comment" aria-hidden="true"><?php echo $data[$i]['totalcomment']; ?></i>&nbsp;&nbsp;
                                <i class="fa fa-eye" aria-hidden="true"><?php echo $data[$i]['totalview']; ?></i>
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
//		                echo'<pre>';
//                                print_r($recentData);
//                                die;
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
		
				<div class="row">
            <div class="col-md-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Top Album</h2>
			<?php $topAlbums = $welcome->getTopAlbums($client_id);
				//echo'<pre>';print_r($topAlbums);die;
			
			?>	
                        <ul class="nav navbar-right panel_toolbox">
                            <li  class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
	<li><p class="blink1"><?php echo "You have ".$topAlbums['pendingImages']." pending notifications"; ?></p></li>					
<style>
						
p.blink1 {width: 100%; cursor: pointer;  -webkit-animation: flash 1s infinite;  animation: flash 10s infinite;}

@-webkit-keyframes flash { 0% { color: aqua; }  10% { color: coral; }  20% { color: gold; }  30% { color: lime; }
  40% { color: aqua; }  50% { color: coral; }  60% { color: gold; }  70% { color: lime; }  80% { color: aqua; }
  90% { color: coral; }
}

@keyframes flash {  0 { color: aqua; }  10% { color: coral; }  20% { color: gold; }  30% { color: lime; }  40% { color: aqua; }
  50% { color: coral; }  60% { color: gold; }  70% { color: lime; }  80% { color: aqua; }  90% { color: coral; }
}
</style>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    <?php 
                    unset($topAlbums['pendingImages']);
                    foreach($topAlbums as $Data) { ?>
			<article class="media event">
                            <a class="pull-left date">
                           	
                                <p class="month"><?php echo date('F', strtotime($Data['createdDate'])); ?></p>
                                <p class="day"><?php echo date('d',strtotime($Data['createdDate'])); ?></p>
                            </a>
                            <div class="media-body"><br>
                                <a class="title" href="javascript:void(0);"> <?php echo $Data['title']; ?> </a>
                               <p class="pull-right"> <?php echo $Data['totallike']; ?> <span class="glyphicon glyphicon-thumbs-up"></span>, <?php echo $Data['totalcomment']; ?> <span class="glyphicon glyphicon-comment"></span>,  <?php echo $Data['totalview']; ?> <span class="glyphicon glyphicon-eye-open"></span></p>			
                            </div>
                        </article>
                        <?php } ?>
			
					<!--
						<div class="row">
							<div class="col-xs-3 col-sm-2 col-md-1 col-lg-1"><span class="glyphicon glyphicon-picture"></div>
							<div class="col-xs-9 col-sm-10 col-md-10 col-lg-10">
								<p>This is album title</p>
								<p> 33<span class="glyphicon glyphicon-thumbs-up"></span>, 44<span class="glyphicon glyphicon-eye-open"></span></p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3 col-sm-2 col-md-1 col-lg-1"><span class="glyphicon glyphicon-picture"></div>
							<div class="col-xs-9 col-sm-10 col-md-10 col-lg-10">
								<p>This is album title2</p>
								<p> 22<span class="glyphicon glyphicon-thumbs-up"></span>, 4<span class="glyphicon glyphicon-eye-open"></span></p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3 col-sm-2 col-md-1 col-lg-1"><span class="glyphicon glyphicon-picture"></div>
							<div class="col-xs-9 col-sm-10 col-md-10 col-lg-10">
								<p>This is album title3</p>
								<p> 11<span class="glyphicon glyphicon-thumbs-up"></span>, 4<span class="glyphicon glyphicon-eye-open"></span></p>
							</div>
						</div>-->
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
<script>
    if (datefield.type != "date") { //if browser doesn't support input type="date", initialize date picker widget:
        jQuery(function ($) { //on document.ready
            $('#htodate').datepicker();
        })
    }
</script>
<script>
    if (datefield.type != "date") { //if browser doesn't support input type="date", initialize date picker widget:
        jQuery(function ($) { //on document.ready
            $('#hfromdate').datepicker();
        })
    }
</script>
<!--------------------- these script for custom date picker -------------------------------------------->
<?php include 'footer.php'; ?>
       
