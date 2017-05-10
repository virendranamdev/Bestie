
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
<script src="js/analytic/analyticTopPostGraph.js"></script>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

<script>
    $(document).ready(function () {
    //  alert("hello");
        var rfromdte = $("#enddate").val();
        // alert("this is fromdate-"+rfromdte);
         //console.log("this is fromdate-"+rfromdte);
        var rtodte = $("#startdate").val();
//alert("this is enddate-"+rtodte);
 //console.log("this is fromdate-"+rtodte);
        var rdept = 'All';
        showAnalyticTopPost(rfromdte, rtodte, rdept, '<?php echo SITE; ?>');
       
    });

    function getActiveuserdata()
    {
	//alert("hello iam here");
		
        var  startday= document.getElementById("fromDate").value;
		var  enddate= document.getElementById("toDate").value;
		var  department= document.getElementById("dept").value;
		
		//alert("from" + startday);
		//alert("end"+ enddate);
		//      alert("department"+ department);

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
			document.getElementById("dept").focus();
			return false;
		}
		
        showAnalyticTopPost(startday, enddate, department, '<?php echo SITE; ?>');
    
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
                        <h2>Top Post View</h2>
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
                                    <input type="date" class="form-control" id="fromDate" size="20" placeholder="mm/dd/yyyy" name="fromDate"/>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-group col-md-3">
                                    <label for="pwd">To:&nbsp;&nbsp;</label>
                                    <input type="date"class="form-control" id="toDate" size="20" placeholder="mm/dd/yyyy" name="toDate"/>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;

                                <div class="form-group col-md-3">
                                    <label for="sel1">Select Department:</label>
                                    <select class="form-control" id="dept">
                                        <option value = "All" selected="">All</option>
                                        <?php
                                        $count = count($department);
                                        for ($i = 0; $i < $count; $i++) {
                                            echo '<option value="' . $department[$i]['department'] . '">' . $department[$i]['department'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="col-md-3">
                                    <input type="submit" id="recognizeuser" onclick="getActiveuserdata();" class="btn btn-primary" style="margin-top:5px" value="Submit" />
                                </div>
                            </div>                
</center>
                            <br>
                            <br>
                            <br>
                             <div class="smallDivRecognition">
                           <div id="toppostcontainer"></div>
                           </div>
  
                    </div>
                </div>
            </div>
            
            
            <!-------------------------Active user analytic---------------------------------------->
         
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
            $('#fromDate1').datepicker();
           
        })

    }
</script>
<script>
    if (datefield.type != "date") { //if browser doesn't support input type="date", initialize date picker widget:
        jQuery(function ($) { //on document.ready
            $('#toDate').datepicker();
            $('#toDate1').datepicker();
            
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