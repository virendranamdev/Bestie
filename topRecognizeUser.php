<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<?php 
require_once('Class_Library/class_recognize.php');
$objRecognize = new Recognize();

$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];
$fromdate = "";
$todate="";
$allrecognizeemployee = $objRecognize->topRecognizeUser($clientId,$fromdate,$todate);
$allrecognizeemployeearr = json_decode($allrecognizeemployee , true);
?>       
<script>
$(document).ready(function () {
	 //alert("hi");
	 $("button").click(function () {
		//alert("hi");
		var fromdte = $("#fromdate").val();
        var enddte = $("#todate").val();
		
		//alert('fromdte'+fromdte);
		//alert('enddte'+enddte);
		
		var clientid = $("#clientid").val();
		var imgpath = "<?php echo SITE; ?>"
		
		if(fromdte == "")
		{
			alert("Please Select From Date");
			fromdte.focus();
			return false;
		}
		if(enddte == "")
		{
		alert("please Select To Date");
		enddte.focus();
		return false;
		}
		else
		{	
		
		//alert(imgpath);
		//alert(enddte);
		//alert(clientid);
		var postData =
                    {
                        "start_date": fromdte,
                        "end_date": enddte,
                        "client": clientid,
						"imgpath": imgpath
                    }
            var dataString = JSON.stringify(postData);
			//alert(dataString);
			$.ajax({
                type: "POST",
                //dataType: "json",
                //contentType: "application/json; charset=utf-8",
                url: "<?php echo SITE; ?>recognizeUserAjax.php",
                data: {"mydata": dataString},
                success: function (response) {
                    var resdata = response;
					//alert(resdata);
					
					if (response.length !== 0)
                               {
					 var jsonData = JSON.parse(resdata);
					 //alert(jsonData.length);
                     $('#datatable tbody').remove();
					 for (var i = 0; i < jsonData.length; i++) 
					 {
						//alert(jsonData[i].user_image);
						
						
											var newRow = '<tbody><tr><td><img src=' + jsonData[i].user_image + ' class="img img-responsive miniCircle" ></td><td>' + jsonData[i].username + '</td><td>' + jsonData[i].designation + '</td><td>' + jsonData[i].totalRecognition + '</td><td><a href="topRecognitionDetails.php?employeeid='+jsonData[i].recognizedUser+'">View</a></td></tr><tbody>';
					$('#datatable').append(newRow);

					 }
					 
					}
					else
					{
					var newRow = '<tbody><tr><td>No Record Available</td></tr><tbody>';
                    $('#datatable').append(newRow);	
					}
				}
			});
	 }	
	 });
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
                    <h2>Top Recognize User</h2>
					<?php 
					/*echo "<pre>";
					print_r($allrecognizeemployeearr);
					echo "</pre>";*/
					?>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up "></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> 
					<center>
					<form class="form-inline">
  <div class="form-group">
    <label for="email">From:</label>
    <input type="date" required class="form-control" id="fromdate">
	<input type="hidden" class="form-control" id="clientid" value="<?php echo $clientId;?>">
  </div>
  <div class="form-group">
    <label for="pwd">TO:</label>
    <input type="date" required class="form-control" id="todate" >
  </div>
   <div class="form-group">
    <label for="pwd"></label>
    <button type="button" class="form-control">Submit</button>
  </div>
  
</form></center>
					
					
                    <form class="myform form-horizontal form-label-left">
			
<table id="datatable" class="MyTable table table-striped">
                      <thead>
                         <tr>
                          <th> User Image</th>
                          <th>User Name</th>
                          <th> Designation</th>
                          <th>Total  Times of Recognize</th>
                          <th></th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php
						for($i=0; $i<count($allrecognizeemployeearr['data']); $i++)
						{
					  ?>
                         <tr>
                          <td><img src="<?php echo $allrecognizeemployeearr['data'][$i]['user_image']; ?>"class="img img-responsive img-circle miniCircle" onerror="this.src='images/user.png'"></td>
                          <td><?php echo $allrecognizeemployeearr['data'][$i]['username']; ?></td>
                          <td><?php echo $allrecognizeemployeearr['data'][$i]['designation']; ?></td>
                          <td> <!--<a href="#" data-placement="right" data-toggle="tooltip" title="Deepak, Vishal, Ameen, Virendra, Rajesh, Monika, Sonee">--><?php echo $allrecognizeemployeearr['data'][$i]['totalRecognition']; ?><!--</a>--></td>
                          <td> <a href="topRecognitionDetails.php?employeeid=<?php echo $allrecognizeemployeearr['data'][$i]['recognizedUser']; ?>">View</a></td>
                       </tr>
						<?php
						}
						?>
                      </tbody>
                    </table>
<style>
.miniCircle{width:50px;height:50px;border-radius:50%;object-fit:contain;background:#f1f1f1;}
</style>
                    </form>


                  </div>
                </div>
              </div>
</div>
          </div>
        </div>
        <!-- /page content -->
		
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
            $('#fromdate').datepicker();
        })
    }
</script>
<script>
    if (datefield.type != "date") { //if browser doesn't support input type="date", initialize date picker widget:
        jQuery(function ($) { //on document.ready
            $('#todate').datepicker();
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

<?php include 'footer.php';?>
       