<?php
 include 'header.php';
 include 'sidemenu.php';
 include 'topNavigation.php';?>

 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

			
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Album History</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                    <table id="" class="MyTable table table-striped display"  cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Posted By</th><th>Date</th><th>Total Image</th><th>Approve Images</th>
                          <th>Pending Images</th><th>Action</th>
                        </tr>
                      </thead>


                      <tbody>
					  <tr>
                          <th>Nadeem</th><th>3 May 2017</th><th>4</th><th>2</th>
                          <th>2</th><th><a href="pendingDataApprove.php">View</a></th>
                      </tr>
					  <tr>
                          <th>Naveen</th><th>2 May 2017</th><th>4</th><th>1</th>
                          <th>3</th><th><a href="pendingDataApprove.php">View</a></th>
                      </tr>
					  <tr>
                          <th>Deepak</th><th>1 May 2017</th><th>4</th><th>4</th>
                          <th>0</th><th><a href="pendingDataApprove.php">View</a></th>
                      </tr>
					  <tr>
                          <th>Nadeem</th><th>1 May 2017</th><th>4</th><th>3</th>
                          <th>1</th><th><a href="pendingDataApprove.php">View</a></th>
                      </tr>
					  
					  </tbody>
					  </table>

					  
                    </div>
                </div>
            </div>
        </div>
			
			
			
			
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Approve Images</h2>
					
					
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
	
				   <table id="" class="MyTable table table-striped display"  cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>image</th><th>Total Like</th><th>Total Comment</th><th>Uploaded By</th><th>Uploaded Date</th>
                          <th>Approve Date</th><th>Action</th>
                        </tr>
                      </thead>


                      <tbody>
					  
					  </tbody>
					  </table>
					  <style>
					  .smallbtn{color:#fff;}
					  .tableApproveImage{width:100px;}
					  </style>
					  <script>$(document).ready(function() {
    $('table.display').DataTable();
} );
</script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
					  

                  </div></div>
                  </div></div>
                </div>
              </div>
</div>
          </div>
        </div>
        <!-- /page content -->



<?php include 'footer.php';?>
       
