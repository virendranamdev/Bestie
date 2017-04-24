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
                    <h2>Survey Title </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
                  <div class="x_content "> 
				  
				   <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Question 1</a></li>
    <li><a data-toggle="tab" href="#menu2">Question 2</a></li>
    <li><a data-toggle="tab" href="#menu3">Question 3</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
     <!-- <h4>How are you Feeling today?</h4>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	  -->
<br>
<div id="MiniSurveyQuestion" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
<hr>
<script>
Highcharts.chart('MiniSurveyQuestion', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'How are you Feeling today?'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Very Good',
            y: 56.33
        }, {
            name: 'Good',
            y: 24.03,
            sliced: true,
            selected: true
        }, {
            name: 'Normal',
            y: 10.38
        }, {
            name: 'Sad',
            y: 4.77
        }]
    }]
});
</script>
	  
<table id="datatable" class="MyTable table table-striped">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>User</th>
                          <th>Answer</th>
                          
                        </tr>
                      </thead>


                      <tbody>
                        <tr>
							<td>Mar 25, 2017 </td>
							<td class="questionTD">Vishal Gupta</td>
							<td>Happy</td>
                        </tr>
						
                        <tr>
							<td>Mar 26, 2017 </td>
							<td class="questionTD">Monika Gupta</td>
							<td>Happy</td>
                        </tr>
						
                        <tr>
							<td>Mar 27, 2017 </td>
							<td class="questionTD">Virendra</td>
							<td>Normal</td>
                        </tr>
						
                        <tr>
							<td>Mar 28, 2017 </td>
							<td class="questionTD">Vishal Gupta</td>
							<td>Normal</td>
                        </tr>
						
                      </tbody>
                    </table>
					
					
    </div>
	
	
    <div id="menu2" class="tab-pane fade">
	
	<br>
    <center> <h4>Who is Your Fvourite Player?</h4></center>
      <br>
            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Popular Words</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask">
						<div class="form-group">
							<div class="progress">
								<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%">
									Love
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="progress">
								<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:60%">
									Food
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="progress">
								<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%">
									Guess
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="progress">
								<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:30%">
									Day
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="progress">
								<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:10%">
									test
								</div>
							</div>
						</div>

                    </form>
                  </div>
                </div>

               



              </div>

              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Word Cloud</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                   
				   
					<?php include 'graph/sad.php';?>
                  </div>
                </div>
              </div>


			  
			  
			  
			  
            </div>

	  
	      <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Responses</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						<i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form3" data-parsley-validate class="form-horizontal form-label-left">
                           
<div class="row">
<div class="col-xs-3 col-sm-3 col-md-2 col-lg-1"><img src="#"class="img img-responsive img-rounded"alt="anonymous-image"></div>
<div class="col-xs-9 col-sm-9 col-md-10 col-lg-11"><p>food is bae </p><p><span class="NoOflikes"><i class="fa fa-heart" aria-hidden="true"></i> 22<span> &nbsp;&nbsp;&nbsp; <span class="tableDate">
 March 22, 2017 </span></p></div>

</div><hr>
         
<div class="row">
<div class="col-xs-3 col-sm-3 col-md-2 col-lg-1"><img src="#"class="img img-responsive img-rounded"alt="anonymous-image"></div>
<div class="col-xs-9 col-sm-9 col-md-10 col-lg-11"><p>food is bae </p><p><span class="NoOflikes"><i class="fa fa-heart" aria-hidden="true"></i> 22<span> &nbsp;&nbsp;&nbsp; <span class="tableDate">
 March 22, 2017 </span></p></div>

</div><hr>
         
<div class="row">
<div class="col-xs-3 col-sm-3 col-md-2 col-lg-1"><img src="#"class="img img-responsive img-rounded"alt="anonymous-image"></div>
<div class="col-xs-9 col-sm-9 col-md-10 col-lg-11"><p>food is bae </p><p><span class="NoOflikes"><i class="fa fa-heart" aria-hidden="true"></i> 22<span> &nbsp;&nbsp;&nbsp; <span class="tableDate">
 March 22, 2017 </span></p></div>

</div><hr>

                    </form>
                  </div>
                </div>
              </div>
            </div>
			
			
	  
    </div>
	
    <div id="menu3" class="tab-pane fade">
     <h3>Who is Your Fvourite Player33333333?</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
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
       