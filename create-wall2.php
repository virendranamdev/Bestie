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
                    <h2>Create New Feedback Wall</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
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
     <a href="wallPredefineTemplate.php"><button class="btn btn-primary pull-right btn-round"> Use Predefined Template</button></a>

  <br ><br ><br >
                    <form class="myform form-horizontal form-label-left">

                      <div class="form-group">
                        <label class=" control-label col-md-3 col-sm-3 col-xs-12">Question</label>
                        <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Write Your Question here...">
                        <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
                      </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">From Date</label>
                            <div class="col-md-9 col-sm-9 col-xs-12 form-group has-feedback">
                              <input type="text" class="form-control has-feedback-left" id="single_cal4" placeholder="First Name" aria-describedby="inputSuccess2Status4">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status4" class="sr-only">(success)</span>
                               </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">To Date</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="First Name" aria-describedby="inputSuccess2Status3">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status3" class="sr-only">(success)</span>
                             
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Group</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
                               
                                <span id="inputSuccess2Status3" class="sr-only">(success)</span>
								

  <script type="text/javascript" src="http://code.jquery.com/jquery-git.js"></script>

  
  
<script type='text/javascript'>//<![CDATA[
$(window).on('load', function() {
/*
 * Original example found here: http://www.jquerybyexample.net/2012/05/how-to-move-items-between-listbox-using.html
 * Modified by Esau Silva to support 'Move ALL items to left/right' and add better stylingon on Jan 28, 2016.
 * 
 */

(function () {
	
	
	//here i m coding to hide selected group div
	
	$(".selectedGroupData").hide();
	
//now  when user click select to all option then selectedGroupData div will hide
	$("#sendTOAll").click(function(){
		
		$(".selectedGroupData").hide();
	});
	
	$("#sendToSelected").click(function(){
		$(".selectedGroupData").show();
		
	});
	
    $('#btnRight').click(function (e) {
        var selectedOpts = $('#lstBox1 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox2').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllRight').click(function (e) {
        var selectedOpts = $('#lstBox1 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox2').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnLeft').click(function (e) {
        var selectedOpts = $('#lstBox2 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllLeft').click(function (e) {
        var selectedOpts = $('#lstBox2 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
}(jQuery));

});//]]> 

</script>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><label class="radio-inline"><input type="radio" name="optradio" id="sendTOAll">Send to All Group</label>
<label class="radio-inline"><input type="radio" name="optradio"id="sendToSelected">Send to Selected Group</label></div>

<div class="selectedGroupData">

<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
  <div class="subject-info-box-1"><center><h2>All Group</h2></center>
  <select multiple="multiple" id='lstBox1' class="form-control">
    <option value="ajax">Ajax</option>
    <option value="jquery">jQuery</option>
    <option value="javascript">JavaScript</option>
    <option value="mootool">MooTools</option>
    <option value="prototype">Prototype</option>
    <option value="dojo">Dojo</option>
    <option value="asp">ASP.NET</option>
    <option value="c#">C#</option>
    <option value="vb">VB.NET</option>
    <option value="java">Java</option>
    <option value="php">PHP</option>
    <option value="python">Python</option>
  </select>
</div>
</div>
<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
<div >
<style>.newb{width:100%;    margin-bottom: 2px !important}
#lstBox2, #lstBox1{min-height:200px;margin-top:10px;}
#lstBox2, #lstBox1{margin-top:10px;}
.newb{margin-top:15px;}
</style><br><br><br><br>
 <!--<button type="button" class="btn newb btn-primary"id='btnAllRight'value='>>' > >> </button><br>-->
 <button type="button" class="btn newb btn-primary"id='btnRight'value='>' > Add </button><br>
 <button type="button" class="btn newb btn-primary"id='btnLeft'value='<' > Remove </button><br>
 <!--<button type="button" class="btn newb btn-primary"id='btnAllLeft'value='<<' > >> </button><br>-->
  
</div>
</div>
<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
<div ><center><h2>Selected Group</h2></center>
  <select multiple="multiple" id='lstBox2' class="form-control">
  </select>
</div>
</div>
</div>
</div>
<style>
</style>
<div class="clearfix"></div>

								</div >
                             
							</div>
                     <!-- <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                                <div class="checkbox"> <label><input type="checkbox"> Save as a predefined template?</label>  </div>
                                
                             
                        </div>
                      </div>-->
                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <div class="col-md-12"><center>
                          <button type="button" class="btn btn-round btn-primary">Submit</button>
                          <button type="button" class="btn btn-round btn-warning">Cancel</button>
                    </center></div>
                      </div>

                    </form>



                  </div>
                </div>
              </div>
</div>
          </div>
        </div>
        <!-- /page content -->

<?php include 'footer.php';?>
       