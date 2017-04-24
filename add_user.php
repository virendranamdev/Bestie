<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
       
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
  
  
    


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add New User</h2>
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
    <li><a data-toggle="tab" href="#multipleuser">Multiple User</a></li>
    
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <form class="myform form-horizontal form-label-left" style="margin-top:10px;">

                      <div class="form-group">
					  <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">First Name</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback margintop">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter First Name">
						<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
						</div>
                        
						 <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Middle Name</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback margintop">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Middle Name">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>
					  
                      
					  <div class="form-group">
					  <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Last Name</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Middle Name">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
					  
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Company Name</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                         <select class="form-control" id="sel1">
							<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3</option>
								<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4</option>
						</select>
                        <span class="fa fa-industry form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>
					  <div class="form-group">
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
                      </div></div>
					  <div class="form-group">
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
                      </div></div>
					  <div class="form-group">
					   <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Email Id</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                         <input type="email" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Email Id">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Designation</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Designation">
                        <span class="fa fa-graduation-cap form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>
					  <div class="form-group">
					  <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Department</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Department">
                        <span class="fa fa-building form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Mobile Number</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Mobile Number">
                        <span class="fa fa-mobile form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>
					  <div class="form-group">
					  <div class="row">
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Location</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Location">
                        <span class="fa fa-map-marker form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      
                        <label class=" control-label col-md-2 col-sm-2 col-xs-12 forcePadding">Branch</label>
                        <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Enter Branch">
                        <span class="fa fa-keyboard-o form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div></div>
					   <div class="form-group">
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
                      </div>
					  <div class="form-group">
                        <div class="col-md-12"><center>
                          <button type="button" class="btn btn-round btn-primary">Submit</button>
                         
                    </center></div>
                      </div></div>
					  </form>
   
	
						<div id="multipleuser" class="tab-pane" >
						<br><br>
						<div class="form-group">
						<div class="row">
                        <label class=" control-label col-md-1 col-sm-1 col-xs-12"></label>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback"style="border:1px solid #337ab7;height:200px;margin-bottom: -26px;">
						<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" style="background-color:#337ab7;height:40px;width:100%; border:2px solid #337ab7;color:#fff;"> Upload CSV File</div>
						</div>
						<center><input type="file" class="btn btn-default" style="margin-top:50px;"></input></center>
						 <div class="col-md-3 col-sm-3 col-xs-12 form-group has-feedback"></div>
                      </div>
					  
                      </div>
					  <div class="button" style="">
						<a href="#">Download CSV file Format</a>
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
                          <button type="button" class="btn btn-round btn-primary">Submit</button>
                        
                    </center></div>
					
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
        </div>
        <!-- /page content -->

<?php include 'footer.php';?>
       