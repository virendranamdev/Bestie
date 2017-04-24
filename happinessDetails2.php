<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <br>
        <div class="clearfix"></div>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Question?</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                       <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                 <div class="form-group">
                    <h4>What’s its history? When was it founded? By whom? Have there been major milestones such as mergers, changes in direction, etc.?</h4>
                    
                  </div>

                    </form>
                    </div>
                </div>
            </div>
        </div>

		
		
		
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Very Happy</h2>
                        <ul class="nav navbar-right panel_toolbox">
						
                             <li class="right"><a class="collapse-link" id="MHdemo"><i class="fa fa-chevron-up"></i></a></li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="MHdemo1"  class="form-horizontal form-label-left collapse in">
                            <div class="form-group">
<div id="wordcloud" class="JMDBenepik" ></div> 

                            </div>

                        </form>
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
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="demo-form3" data-parsley-validate class="form-horizontal form-label-left">
                           
<div class="row">
<div class="col-xs-3 col-sm-3 col-md-2 col-lg-1"><img src="#"class="img img-responsive img-rounded"alt="anonymous-image"></div>
<div class="col-xs-9 col-sm-9 col-md-10 col-lg-11"><p>food is bae </p><p> <span class="tableDate"><i class="fa fa-calendar" aria-hidden="true"></i>
 March 22, 2017 </span></p></div>

</div><hr>
         
<div class="row">
<div class="col-xs-3 col-sm-3 col-md-2 col-lg-1"><img src="#"class="img img-responsive img-rounded"alt="anonymous-image"></div>
<div class="col-xs-9 col-sm-9 col-md-10 col-lg-11"><p>food is bae </p><p><span class="tableDate"><i class="fa fa-calendar" aria-hidden="true"></i>
 March 22, 2017 </span></p></div>

</div><hr>
         
<div class="row">
<div class="col-xs-3 col-sm-3 col-md-2 col-lg-1"><img src="#"class="img img-responsive img-rounded"alt="anonymous-image"></div>
<div class="col-xs-9 col-sm-9 col-md-10 col-lg-11"><p>food is bae </p><p><span class="NoOflikes"> <span class="tableDate"><i class="fa fa-calendar" aria-hidden="true"></i>
 March 22, 2017 </span></p></div>

</div><hr>

                    </form>
                  </div>
                </div>
              </div>
            </div>
			
			
    </div>
 </div>

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script type='text/javascript'src="build/js/HappinesssDetails.js"></script>

<script> 
$(document).ready(function(){
  
	 $("#MHdemo").click(function(){
        $("#MHdemo1").animate({
            height: 'toggle'
        });
    });
	
});
</script>
  
<script type="text/javascript" src="http://www.lucaongaro.eu/demos/jqcloud/jqcloud-1.0.0.min.js"></script>
    <!-- footer content -->
        <footer>
          <div class="pull-right">
           All copyright@<a href="https://www.benepik.com">Benepik.com</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
  
