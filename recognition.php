<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
 
<?php 
require_once('Class_Library/class_recognize.php');
$objRecognize = new Recognize();
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];
$reconitionlist = $objRecognize->getRecognitionList($clientId);
$recognitionlistarr = json_decode($reconitionlist , true);
?> 
<!----------------- use for change order of data table ----------------------------->
<script src ="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#datatable').DataTable( {
        "order": [[ 0, "desc" ]]
    } );
} );
</script>
<!-------------------------- / use for change order ------------------------>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Recognition</h2>
					  <ul class="nav navbar-right panel_toolbox">
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up "></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> 
				   <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <ul class="inlineUL right"><li><a href="topRecognizeUser.php"><button class="btn btn-primary btn-round">Top Recognize User</button></a></li></ul>
                            </div>

                        </div>
                    <form class="myform form-horizontal form-label-left">
			
<table id="datatable" class="MyTable table table-striped">
                      <thead>
                         <tr>
                          <th>Date</th>
                          <th>Recognize to</th>
                          <th>Recognize by</th>
                          <th>Recognize for</th><th>Comment</th><th></th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php 
					  for($i=0; $i<count($recognitionlistarr['data']); $i++)
					  {
					  ?>
                         <tr>
                          <td><?php echo $recognitionlistarr['data'][$i]['dateOfEntry']; ?></td>
                          <td><?php echo $recognitionlistarr['data'][$i]['recognitionToName']; ?></td>
                          <td><?php echo $recognitionlistarr['data'][$i]['recognitionByName']; ?></td>
                          <td><?php echo $recognitionlistarr['data'][$i]['recognizefor']; ?></td>
						  <td><?php echo $recognitionlistarr['data'][$i]['text']; ?></td>
						  <td><ul class="wallUL"><a href="recognitionDetails.php?recognitionId=<?php echo $recognitionlistarr['data'][$i]['recognitionId']; ?>"><li>View</li></a></ul> </td>
                        </tr>
					    <?php 
					    } 
					    ?>
                       
                       
                      </tbody>
                    </table>

                    </form>



                  </div>
                </div>
              </div>
</div>
          </div>
        </div>
        <!-- /page content -->

<?php include 'footer.php';?>
       