<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
<?php require_once('Class_Library/class_user_update.php');
$obj = new User();
$clientid=$_SESSION['client_id'];
?>     
<script src="js/validation/createPostValidation.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  
	    <style>
		.button {
     background: #fff ! important;
    background: linear-gradient(top,#f7f9fa 0,#f0f0f0 100%);
    filter: DXImageTransform.Microsoft.gradient( startColorstr='#f7f9fa', endColorstr='#f0f0f0', GradientType=0);
    -ms-box-shadow: 0 1px 2px rgba(0,0,0,.1) inset;
    -o-box-shadow: 0 1px 2px rgba(0,0,0,.1) inset;
     box-shadow: 0 0px 0px rgba(0,0,0,.1) inset;
    border-radius: 0 0 5px 5px;
     border-top: 0px solid #fff ! important; 
    padding: 15px 0;
	    margin-left: 104px;
}

.command{
	 border: none;
    background: #337ab7;;
    color: #fff;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    display: block;
    font-weight: 400;
    margin: -0.5em 0;
    padding: 0.15em .5em .25em;
}
.body {
    color: #73879C;
    font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 3.471;
}
.bkgcolor{
	background-color:#4a83b9;
	color:#fff;
	
}
.table>thead>tr>th {
    vertical-align: bottom;
border-bottom: 2px solid #4a83b9;}

		</style>
<script>
function checkuploadcsv() 
{
if (confirm('Are You Sure, You want to Upload CSV?')) 
       {
           return true;
       } else {
           return false;
       }
}
</script>
 
<!----------------------------------- model --------------------------------------->
	<!--<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
     
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update User Information</h4>
        </div>
        <div class="modal-body">
          
						<div class="form-group">
						<div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">FirstName</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter First name" id="emp_name" name="emp_name">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
					  
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">MiddleName</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Middle name">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div></div>
                      </div>
					  
					   <div class="form-group">
					   <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">LastName</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Last name">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Department</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Department">
                        <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                      </div></div>
                      </div>
					  <div class="form-group">
					  <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Designation</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Designation">
                        <span class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
					  
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Email Id</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Email Id">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>
					  <div class="form-group">
					  <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Emp Id</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Employee Id">
                        <span class="glyphicon glyphicon-credit-card form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Grade</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Grade">
                        <span class="fa fa-minus-square-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>
					  <div class="form-group">
					  <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Location</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Location">
                        <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12">Branch</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Branch">
                        <span class="fa fa-keyboard-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>
					  <div class="modal-footer">
          <button type="button" class="btn btn-round btn-primary">Submit</button>
        </div>
				  
        </div>
        
      </div>
      
    </div>
  </div>-->
  <!---------------------- model ---------------------------------------------->


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Update User Information</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
                  <div class="container">
 

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Search User For Updation</a></li>
    <li><a data-toggle="tab" href="#multipleuser">Multiple User</a></li>
    
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
     
      <form method="post" name="searchuserform" action="update-user.php" class="myform form-horizontal form-label-left" style="margin-top:10px;">

                      <div class="form-group">
                        <label class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">Enter Name or Email Id*</label><br>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="First Name | Email Id" name="searchkey" required>
                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
					  <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"></div>
                      </div>
					<div class="form-group" style="padding-top:0px;">
                     <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                      <button type="submit" name="user_form" class="btn btn-round btn-primary" data-toggle="collapse" data-target="#demo" onclick="return ValidateUserSearch();">Submit</button></div>
					  
					</div>
	</form>
	
	<?php
if(isset($_POST['user_form']))
{
extract($_POST);
//print_r($_POST);
$result = $obj->userForm($searchkey);
$getcat = json_decode($result,true);
/*echo "<pre>";
print_r($getcat);
echo "</pre>";
*/
?> 	
	
	
	<div style="overflow-x:scroll">
    <table class="table table-hover">
    <thead>
      <tr class="bkgcolor">
        <th>Firstname</th>
		<th>Middlename</th>
        <th>Lastname</th>
		<th>Department</th>
		<!--<th>Designation</th>-->
		<th>Email Id</th>
		<!--<th>Employee Id</th>-->
		<th>Location</th>
		<!--<th>Branch</th>
		<th>Grade</th>-->
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
	<?php for($i=0; $i<count($getcat['posts']); $i++)
	{
$firstname = $getcat['posts'][$i]['firstName'];
$middlename = $getcat['posts'][$i]['middleName'];
$lastname = $getcat['posts'][$i]['lastName'];
$depart = $getcat['posts'][$i]['department'];
$desig = $getcat['posts'][$i]['designation'];
$mail = $getcat['posts'][$i]['emailId'];
$uui=$getcat['posts'][$i]['employeeId'];
$loc = $getcat['posts'][$i]['location'];
$bra = $getcat['posts'][$i]['branch'];
$gra = $getcat['posts'][$i]['grade'];
$emp_code =$getcat['posts'][$i]['employeeCode'];
?>
      <tr>
       <td><?php echo $firstname;?></td>
        <td><?php echo $middlename;?></td>
		<td><?php echo $lastname;?></td>
		<td><?php echo $depart;?></td>
		<!--<td><?php echo $desig;?></td>-->
        <td><?php echo $mail;?></td>
		<!--<td><?php echo $uui;?></td>-->
		<td><?php echo $loc;?></td>
		<!--<td><?php echo $bra;?></td>
		<td><?php echo $gra;?></td>-->
		<td><a href="add_user.php?empid=<?php echo $uui;?>">Update</td>
		
		<!--<td><a href="#"><button type="button" class="btn btn-round btn-primary btn-xs" data-toggle="modal" data-target="#myModal">Update</button></a></td>-->
		
		<!--<?php echo "<td  data-toggle='modal' data-target='#myModal'>
		<span class='edit_data commonColorSubmitBtn' emp_name='".$firstname."' emp_middle='".$middlename."' emp_name2='".$lastname."' emp_uui='".$uui."' emp_depart='".$depart."' emp_desig='".$desig."' emp_emailid='".$mail."' emp_loc='".$loc."' emp_bra='".$bra."' emp_gra='".$gra."' >Update</span></td>"?>-->
      </tr>
<?php } ?>


    </tbody>
  </table>
  </div>
<?php } ?>
</div>
					  
    
	
	
	
	
						<div id="multipleuser" class="tab-pane">
						<br><br>
						<form name="updateusercsv" method="POST" action="Link_Library/link_client_user.php" enctype="multipart/form-data" onsubmit="return checkuploadcsv();">
						<div class="form-group">
						<div class="row">
                        <label class=" control-label col-md-1 col-sm-1 col-xs-12"></label>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback"style="border:1px solid #337ab7;height:200px;margin-bottom: -26px;">
						<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" style="background-color:#337ab7;height:40px;width:100%; border:2px solid #337ab7;color:#fff;"> Upload CSV File</div>
						</div>
						<center><input type="file" required accept=".csv" name="user_csv_file_update" id ="user_csv_file_update" class="btn btn-default" style="margin-top:50px;"></input></center>
						 <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"></div>
                      </div>
					  
                      </div>
					  <div class="button" style="">
						<a href="demoCSVfile/demoCSVformatUpdate.csv">Download CSV file Format</a>
					</div>
					  </div>
					 
					 <div class="form-group" style="padding-top:20px;">
                        <div class="col-md-12"><center>
                          <button type="submit" name="updateusercsv" class="btn btn-round btn-primary" onclick="return ValidateupdateUserCSV();">Submit</button>
                        
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
          </div>
        </div>
		
		
		
        <!-- /page content -->

<?php include 'footer.php';?>
       