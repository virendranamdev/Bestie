<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
<script src="js/validation/createPostValidation.js"></script>
	    <style>
		.button {
     background: #fff ! important;
    background: linear-gradient(top,#f7f9fa 0,#f0f0f0 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#f7f9fa', endColorstr='#f0f0f0', GradientType=0);
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
.marginradio{margin-left: -10px ! important;
    margin-top: 16px ! important;}
	.margintop{margin-top:20px;}
	
	.forcePadding{padding-left:4%;}
.forcePaddingContainer{padding:2% 5% 2% 2%;}
		</style>
		
<script>
function check() 
{
if (confirm('Are You Sure, You want to add this User?')) 
       {
           return true;
       } else {
           return false;
       }
}
</script>

<script>
function checkupdate() 
{
if (confirm('Are You Sure, You want to Update user Details?')) 
       {
           return true;
       } else {
           return false;
       }
}
</script>

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
  
<?php 
$firstname="";
$middlename = "";
$lastname = "";
$emailid = "";
$department = "";
$location = "";

if(isset($_GET['empid']))
{
	$clientid=$_SESSION['client_id'];
	require_once('Class_Library/class_user_update.php');
	$obj = new User(); 
	$empid = $_GET['empid'];
	$userdetail = $obj->getEmployeeDetail($clientid , $empid);
	$firstname= $userdetail['userName']['firstName'];
	$middlename = $userdetail['userName']['middleName'];
	$lastname = $userdetail['userName']['lastName'];
	$emailid = $userdetail['userName']['emailId'];
	$department = $userdetail['userName']['department'];
	$location = $userdetail['userName']['location'];
	
}
	?>
    


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
				  <?php 
				  if(isset($_GET['empid']))
				  {
					?>
				  <h2>Update User</h2>
				  <?php
				  /*echo "<pre>";
					print_r($userdetail);
					echo "</pre>";*/
				  }
				  else
				  {?>
                    <h2>Add New User</h2>
				  <?php 
				  }
				  ?>
                     <ul class="nav navbar-right panel_toolbox">
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  <div class="x_content">
                  <div class="container forcePaddingContainer">
 

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Single User</a></li>
    <?php if(!isset($_GET['empid'])){?><li><a data-toggle="tab" href="#multipleuser">Multiple User</a></li><?php }?>
    
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <form name="singleuser" action="Link_Library/link_client_user.php" method="POST" enctype="multipart/form-data" class="myform form-horizontal form-label-left" style="margin-top:10px;" <?php if(isset($_GET['empid'])){?>onsubmit="return checkupdate();"<?php }else{?>onsubmit="return check();"<?php } ?>>

                      <div class="form-group">
					  <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">First Name</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback margintop">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter First Name" name="first_name" value="<?php echo $firstname; ?>" required>
			<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
			</div>
                        
			<label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Middle Name</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback margintop">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Middle Name" name="middle_name" value="<?php echo $middlename; ?>">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>
					  
                      
			<div class="form-group">
			<div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Last Name</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Middle Name" name="last_name" value="<?php echo $lastname; ?>">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
					   <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Email Id</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                         <input type="email" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Email Id" name="email_id" value="<?php echo $emailid; ?>" <?php if(isset($_GET['empid'])) { ?> readonly <?php } ?> required>
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                      </div>
					  
                        <!--<label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Company Name</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                         <select class="form-control" id="sel1">
							<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4</option>
						</select>
                        <span class="fa fa-industry form-control-feedback left" aria-hidden="true"></span>
                      </div>-->
                      </div></div>
					  <!--<div class="form-group">
					  <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Company Code</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                         <select class="form-control" id="sel1">
							<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4</option>
						</select>
                        <span class="fa fa-industry form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Employee Code</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                         <select class="form-control" id="sel1">
							<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4</option>
						</select>
                        <span class="glyphicon glyphicon-credit-card form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>-->
					  <!--<div class="form-group">
					   <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Date Of Birth</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                         <input type="date" class="form-control has-feedback-left" id="inputSuccess2" >
                        <span class="fa fa-birthday-cake form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
					  
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Date Of Joining</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                         <input type="date" class="form-control has-feedback-left" id="inputSuccess2" >
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>-->
					  <!--<div class="form-group">
					   <div class="row">
                                             
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Designation</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Designation">
                        <span class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>-->
					  <div class="form-group">
					  <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Department</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Department" name="department" value="<?php echo $department; ?>" required>
                        <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                      </div>
					  
					    <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Location</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Location" name="location" value="<?php echo $location; ?>" required>
                        <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
                      </div>
					  
                      <!--
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Mobile Number</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Mobile Number">
                        <span class="fa fa-mobile form-control-feedback left" aria-hidden="true"></span>
                      </div>-->
                      </div></div>
					  <!--<div class="form-group">
					  <div class="row">
                      
                        
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Branch</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Branch">
                        <span class="fa fa-keyboard-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>-->
					   <!--<div class="form-group">
					   <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Grade</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Grade">
                        <span class="fa fa-minus-square-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
                        <label class=" control-label col-lg-2 col-md-2 col-sm-3 col-xs-12 forcePadding">Gender</label>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <label class="radio-inline">
      <input type="radio" name="optradio" class="marginradio">&nbsp;&nbsp;&nbsp;Male
    </label>
    <label class="radio-inline">
      <input type="radio" name="optradio" class="marginradio">&nbsp;&nbsp;&nbsp;Female
    </label>
   
                        
                      </div></div>
                      </div>-->
					  <?php 
					  if(isset($_GET['empid']))
					  {
					  ?>
					  <div class="form-group">
                        <div class="col-md-12"><center>
						<input type="hidden" name="employeeid" value="<?php echo $_GET['empid']; ?>">
                          <button type="submit" name="user_form_update" class="btn btn-round btn-primary" onclick="return ValidateUser();">Update</button>
                         
                    </center></div>
                      </div>
					  <?php } else {?>
					  <div class="form-group">
                        <div class="col-md-12"><center>
                          <button type="submit" name="user_form" class="btn btn-round btn-primary" onclick="return ValidateUser();">Submit</button>
                         
                    </center></div>
                      </div>
					  <?php } ?>
					  </form>
					  </div>
   
	
						<div id="multipleuser" class="tab-pane" >
						<br><br>
						<form role="form" name="csvform" method="post" enctype="multipart/form-data" action="Link_Library/link_client_user.php" onsubmit="return checkuploadcsv();">
						<div class="form-group">
						<div class="row">
						
                        <label class=" control-label col-md-1 col-sm-1 col-xs-12"></label>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback"style="border:1px solid #337ab7;height:200px;margin-bottom: -26px;">
						<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" style="background-color:#337ab7;height:40px;width:100%; border:2px solid #337ab7;color:#fff;"> Upload CSV File</div>
						</div>
						<center><input type="file" accept=".csv" name="user_csv_file" id="user_csv_file" class="btn btn-default" style="margin-top:50px;" onchange="handleFiles(this.files)" required></input></center>
						 <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"></div>
                      </div>
					  
                      </div>
					  <div class="button" style="">
						<a href="demoCSVfile/demoCSVformat.csv">Download CSV file Format</a>
					</div>
					  </div>
					 
					 <!-- <div class="row">
					  <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"></div>
					  <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback">
					  <div class="button">
						<a href="#">Download CSV file Format</a>
					</div></div>
					<div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"></div>
					</div>-->
					<div class="form-group" style="padding-top:20px;">
                        <div class="col-md-12"><center>
                          <button type="submit" name="user_csv" class="btn btn-round btn-primary" onclick="return ValidateUserCSV();">Submit</button>
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
       
