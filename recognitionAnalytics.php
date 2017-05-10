
<?php include 'header.php'; ?>
<?php include 'sidemenu.php'; ?>
<?php include 'topNavigation.php'; ?>

<?php
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

require_once('Class_Library/class_getDepartment.php');
$recogobj = new Department();
$department1 = $recogobj->getDepartment($clientId);
$department = json_decode($department1, true);
?>
<script src="js/analytic/analyticRecognizeGraph.js"></script>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
    $(document).ready(function () {

        var rfromdte = $("#enddate").val();
        // alert("this is fromdate-"+rfromdte);
        // console.log("this is fromdate-"+rfromdte);
        var rtodte = $("#startdate").val();
//alert("this is enddate-"+rtodte);
// console.log("this is fromdate-"+rtodte);
        var rdept;
        showRecognizeUserGraph(rfromdte, rtodte, rdept, '<?php echo SITE; ?>');
        showRecognizeTopSenderGraph(rfromdte, rtodte, rdept, '<?php echo SITE; ?>');
          showRecognizeTopReceiverGraph(rfromdte, rtodte, rdept, '<?php echo SITE; ?>');
            showRecognizeTopBadgesGraph(rfromdte, rtodte, rdept, '<?php echo SITE; ?>');
    });

    function getrecognizedata()
    {
        var rfromdte = $("#recognizefromDate").val();
        var rtodte = $("#recognizetoDate").val();
        var rdept = $("#rdept").val();

        if (rfromdte == "")
        {
            alert("Please Select From Date");
            rfromdte.focus();
            return false;
        }
        if (rtodte == "")
        {
            alert("please Select To Date");
            rtodte.focus();
            return false;
        }
        else
        {
            showRecognizeUserGraph(rfromdte, rtodte, rdept, '<?php echo SITE; ?>');
        }
    }
    
    function getrecognizetopsender()
    {
       
        var rfromdte1 = $("#fromDate1").val();
        var rtodte1 = $("#toDate1").val();
        var rdept1 = $("#sel1").val();

        if (rfromdte1 == "")
        {
            alert("Please Select From Date");
            rfromdte1.focus();
            return false;
        }
        if (rtodte1 == "")
        {   
            alert("please Select To Date");
            rtodte1.focus();
            return false;
        }
        else
        {
            showRecognizeTopSenderGraph(rfromdte1, rtodte1, rdept1, '<?php echo SITE; ?>');
        }
    }
    
    
     function getrecognizetopreceiver()
    {
       // alert("hello");
        var rfromdte2 = $("#fromDate2").val();
        var rtodte2 = $("#toDate2").val();
        var rdept2 = $("#sel2").val();

        if (rfromdte2 == "")
        {
            alert("Please Select From Date");
            rfromdte2.focus();
            return false;
        }
        if (rtodte2 == "")
        {   
            alert("please Select To Date");
            rtodte2.focus();
            return false;
        }
        else
        {
            showRecognizeTopReceiverGraph(rfromdte2, rtodte2, rdept2, '<?php echo SITE; ?>');
        }
    }
    
     function getrecognizetopbadges()
    {
     //   alert("hello");
        var rfromdte3 = $("#fromDate3").val();
        var rtodte3 = $("#toDate3").val();
        var rdept3 = $("#sel3").val();

        if (rfromdte3 == "")
        {
            alert("Please Select From Date");
            rfromdte3.focus();
            return false;
        }
        if (rtodte3 == "")
        {   
            alert("please Select To Date");
            rtodte3.focus();
            return false;
        }
        else
        {
            showRecognizeTopBadgesGraph(rfromdte3, rtodte3, rdept3, '<?php echo SITE; ?>');
        }
    }
</script>
<div class="right_col" role="main">
    <div class="">
        <br>
        <div class="clearfix"></div>


        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Top Recognition</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <br /><center>
                            <input type="hidden" name="startdate" id="startdate" value="<?php echo date("Y-m-d"); ?>">
                            <input type="hidden" name="enddate" id="enddate" value="<?php echo date('Y-m-d', strtotime("-7 days")); ?>">
                            <!--<form id="demo-form2" data-parsley-validate class="form-inline">-->
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="usr">From:</label>
                                    <input type="date" class="form-control" id="recognizefromDate" size="20" placeholder="mm/dd/yyyy" name="fromDate"/>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-group col-md-3">
                                    <label for="pwd">To:&nbsp;&nbsp;</label>
                                    <input type="date"class="form-control" id="recognizetoDate" size="20" placeholder="mm/dd/yyyy" name="toDate"/>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;

                                <div class="form-group col-md-3">
                                    <label for="sel1">Select Department:</label>
                                    <select class="form-control" id="rdept">
                                        <option value = "" selected="">All</option>
                                        <?php
                                        $count = count($department);
                                        for ($i = 0; $i < $count; $i++) {
                                            echo '<option value="' . $department[$i]['department'] . '">' . $department[$i]['department'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="col-md-3">
                                    <input type="submit" id="recognizeuser" onclick="getrecognizedata();" class="btn btn-primary" style="margin-top:5px" value="Submit" />
                                </div>
                            </div>                

                            <br>
                            <br>
                            <br>
                            <div id="RecognitionContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                            <!--</form>-->
                        </center>  
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Top Sender</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                     
                        <div class="smallDivRecognition">
                            <!--                            <form class="form-inline">-->
							<div class="row">
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-xs-12">
                                <label for="usr">From:</label>
                                <input type="date"class="form-control" id="fromDate1" name="input1" size="20" placeholder="mm/dd/yyyy"/>
                            </div>
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-xs-12">
                                <label for="pwd">To:&nbsp;&nbsp;</label>
                                <input type="date"class="form-control" id="toDate1" name="input2" size="20" placeholder="mm/dd/yyyy"/>
                            </div>
                            </div>
							<div class="row">
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-xs-12">
                                <label for="sel1">Select Department:</label>
                                <select class="form-control" id="sel1">
                                    <option value = "" selected="">All</option>
                                    <?php
                                    $count = count($department);
                                    for ($i = 0; $i < $count; $i++) {
                                        echo '<option value="' . $department[$i]['department'] . '">' . $department[$i]['department'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div><div class=" col-sm-6 col-lg-6 col-md-6 col-xs-12"><button type="submit" class="btn btn-primary"onclick="getrecognizetopsender();"style="margin-top:10%;" >Submit</button></div>
                            </div>
							<hr>
							<!--</form>-->


                        
<div id="dynamicdatatopsender">                           
                         </div>     
                         

                        </div>
                    </div>
                </div>
            </div>

             <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Top Receiver</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                    
                        <div class="smallDivRecognition">
                            <!--                            <form class="form-inline">-->
                            <div class="row">
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-xs-12">
                                <label for="usr">From:</label>
                                <input type="date"class="form-control" id="fromDate2" name="input1" size="20" placeholder="mm/dd/yyyy"/>
                            </div>
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-xs-12">
                                <label for="pwd">To:&nbsp;&nbsp;</label>
                                <input type="date"class="form-control" id="toDate2" name="input2" size="20" placeholder="mm/dd/yyyy"/>
                            </div>
                            </div>
							<div class="row">
                            <div class="form-group col-sm-6 col-lg-6 col-md-6 col-xs-12">
                                <label for="sel1">Select Department:</label>
                                <select class="form-control" id="sel2">
                                    <option value = "" selected="">All</option>
                                    <?php
                                    $count = count($department);
                                    for ($i = 0; $i < $count; $i++) {
                                        echo '<option value="' . $department[$i]['department'] . '">' . $department[$i]['department'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div><div class=" col-sm-6 col-lg-6 col-md-6 col-xs-12"><button type="submit" class="btn btn-primary"style="margin-top:10%" onclick="getrecognizetopreceiver();" >Submit</button></div>
							</div><hr>
                            <!--</form>-->


                        
<div id="dynamicdatatopreceiver">
                              
                         </div>     
                         

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
               <div class="x_panel">
                    <div class="x_title">
                        <h2>Top Badges</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      
                        <div class="smallDivRecognition">
                            <!--                            <form class="form-inline">-->
							<div class="row">
                            <div class="form-group col-sm-3 col-lg-3 col-md-3 col-xs-12">
                                <label for="usr">From:</label>
                                <input type="date"class="form-control" id="fromDate3" name="input1" size="20" placeholder="mm/dd/yyyy"/>
                            </div>
                            <div class="form-group col-sm-3 col-lg-3 col-md-3 col-xs-12">
                                <label for="pwd">To:&nbsp;&nbsp;</label>
                                <input type="date"class="form-control" id="toDate3" name="input2" size="20" placeholder="mm/dd/yyyy"/>
                            </div>

                            <div class="form-group col-sm-3 col-lg-3 col-md-3 col-xs-12">
                                <label for="sel1">Select Department:</label>
                                <select class="form-control" id="sel3">
                                    <option value = "" selected="">All</option>
                                    <?php
                                    $count = count($department);
                                    for ($i = 0; $i < $count; $i++) {
                                        echo '<option value="' . $department[$i]['department'] . '">' . $department[$i]['department'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
							
                            <div class="form-group col-sm-3 col-lg-3 col-md-3 col-xs-12">
							<button type="submit" class="btn btn-primary"style="margin-top:10%" onclick="getrecognizetopbadges();" >Submit</button>
							</div>
							</div><hr>
                            <!--</form>-->


                        
<div id="dynamicdatatopbadges">
                              
                         </div>     
                         

                        </div>
                    </div>
                </div>
            </div>
  <style>
                        .mt15{margin-top:15px;}
                        .smallDivRecognition{max-height:500px;overflow:auto;}
                    </style>

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
            $('#recognizefromDate').datepicker();
            $('#fromDate1').datepicker();
            $('#fromDate2').datepicker();
            $('#fromDate3').datepicker();
        })

    }
</script>
<script>
    if (datefield.type != "date") { //if browser doesn't support input type="date", initialize date picker widget:
        jQuery(function ($) { //on document.ready
            $('#recognizetoDate').datepicker();
            $('#toDate1').datepicker();
            $('#toDate2').datepicker();
            $('#toDate3').datepicker();
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
<?php include 'footer.php'; ?>