<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
       


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Top Recognize User</h2>
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
    <input type="date" class="form-control" id="email">
  </div>
  <div class="form-group">
    <label for="pwd">TO:</label>
    <input type="date" class="form-control" id="pwd">
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
                         <tr>
                          <td><img src="images/avatar_images/1.png"class="img img-responsive img-circle miniCircle"></td>
                          <td>Ameen</td>
                          <td>Android Developer</td>
                          <td> <a href="#" data-placement="right"data-toggle="tooltip" title="Deepak, Vishal, Ameen, Virendra, Rajesh, Monika, Sonee">32</a></td>
                          <td> <a href="topRecognitionDetails.php">View</a></td>
                       </tr>
						<tr>
                          <td><img src="images/avatar_images/2.png"class="img img-responsive img-circle miniCircle"></td>
                          <td>Deepak</td>
                          <td>iOS Developer</td>
                          <td> <a href="#"data-placement="right" data-toggle="tooltip" title="Deepak, Vishal, Ameen">22</a></td>
                          <td> <a href="topRecognitionDetails.php">View</a></td>
                       </tr>
						 <tr>
                          <td><img src="images/avatar_images/3.png"class="img img-responsive img-circle miniCircle"></td>
                          <td>Rahul</td>
                          <td>Android Developer</td>
                          <td> <a href="#"data-placement="right" data-toggle="tooltip" title=" Rajesh, Monika, Sonee">20</a></td>
                          <td> <a href="topRecognitionDetails.php">View</a></td>
                      </tr>
                       
                       
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

<?php include 'footer.php';?>
       