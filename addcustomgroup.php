<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
<script src="js/validation/createPostValidation.js"></script>
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
    function check() {
        if (confirm('Are You Sure, You want to create this custom group?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
  <script>
function Validatecustomgroup()
{
    var group_title = document.form1.group_title;
	var cgroup_csv_file = document.form1.cgroup_csv_file;
    	
    if (group_title.value == "")
    {
        window.alert("Please Enter Group Name.");
        group_title.focus();
        return false;
    }
	if (cgroup_csv_file.value == "")
    {
        window.alert("Please Upload CSV File.");
        cgroup_csv_file.focus();
        return false;
    }
	return true;
}
</script>  

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
				
                    <h2>Create Custom Group</h2>
			
                     <ul class="nav navbar-right panel_toolbox">
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  <div class="x_content">
    
  <div class="row">
	
						<div class="row">
				<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1">
						<form role="form" name="form1" method="post" action="Link_Library/link_customgroup.php" enctype="multipart/form-data" onsubmit="return check();">
							<input type="hidden" name = "uuid" value="<?php echo $_SESSION['user_unique_id']; ?>">
							<input type="hidden"  name = "clientid" value="<?php echo $_SESSION['client_id']; ?>">
							<div class="row">
								<div class="form-group col-sm-6">
									<label for="exampleInputPassword1">Group Name</label>
									<input type="text" name="group_title" class="form-control" id="group_title" placeholder="Group Name">
								</div>
								
								<div class="form-group col-sm-6">
									<label for="exampleInputEmail1">About Group</label>
									<textarea cols="10" id="groupdesc" name="groupdesc" class="form-control"  rows="1">	
									</textarea>
								</div>
							</div>
							<div class="row" style="margin-top:10px;margin-bottom:10px;">
								<div class="form-group col-sm-6">
									<label for="exampleInputEmail1">Upload CSV</label>
									<input style="color:#2d2a3b;" class="text-center" accept=".csv" name="cgroup_csv_file" type="file" id="cgroup_csv_file">
								</div>
							</div>
							<div class="row">
							<div class="form-group col-sm-12">
									<a style="font-size: 16px;text-decoration: underline;float:right;" href="demoCSVfile/customgroupdemoCSVformat.csv">Download CSV file format</a>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-12">
									<input type="submit" name ="customgroup" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Create Custom Group" id="getData" onclick="return Validatecustomgroup();" />
								</div>
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
          
        <!-- /page content -->

<?php include 'footer.php';?>
       
