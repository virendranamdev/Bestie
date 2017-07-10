<?php
include 'header.php';
include 'sidemenu.php';
include 'topNavigation.php';

require_once('Class_Library/class_Feedback.php');
$objFeed = new Feedback();
@session_start();
//echo'<pre>';print_r($_SESSION);die;
$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$feedbackId = $_GET['feedId'];
$val = 0;

$feedDetails = $objFeed->getSingleFeedbackDetail($clientId, $feedbackId);
$feedDetailsArr = json_decode($feedDetails, true);
//echo'<pre>';print_r($feedDetailsArr);die;

$feedData = $feedDetailsArr['data'];
?>
<input type="hidden" name="feedid" id="feedid" value="<?php echo $feedbackId; ?>">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>
<!--<script src="js/analytic/downloadanalyticimage.js"></script>-->

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>-->

<script src="js/analytic/0.5.0-beta3html2canvas.min.js"></script>
<!--------------------------------------->




<!--
<script src="js/analytic/html2canvas.min.js"></script>
-->
<script>
    $(document).ready(function () {
			
		$('.deleteComment').click(function () {
			//alert("hi");
			
			var feedbackid = $("#feedid").val();
			var commentId = $(this).attr('id');
			var flag = 23;
			
			//var feedbackid = "Feedback-1";
			//var commentid = "Comment-10";
			//alert(feedbackid);
			//alert(commentId);
			
            var confirmationBox = confirm("Are you sure you want to delete this comment ?");
            if (confirmationBox == true) {
                $.ajax({
                    url: "delete_comment.php",
                    type: "POST",
                    cache: false,
                    data: {
                        postId: feedbackid,
                        commentId: commentId,
                        flag: flag
                    },
                    success: function (a) {
						//alert(a);
                        alert("Comment deleted successfully");
                        $("#commentDiv"+commentId).remove();
                    }
                });
            }
        });
    });
</script>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <br>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Question?</h2><!--<?php echo "<pre>";print_r($feedDetailsArr);?>-->
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up "></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                            <div class="form-group">
                                <h4><b><?php echo $feedDetailsArr['feedbackQuestion']; ?></b></h4>

                            </div>
<div class="form-group"><h5 style="float:right;">Posted Date: <?php echo $feedDetailsArr['createdDate'];?></h5></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $comments = '';
        foreach ($feedData as $wordData) {
            $comments .= ' /// ' . $wordData['comment_text'];
        }
        $words = json_decode($objFeed->extractCommonWords($comments), true);
		//echo "<pre>";
//print_r($words);
//echo "</pre>";

        $fieldnames_actual = array();
        $values = array();

        foreach ($words as $k => $v) {
            if ($k != 'fieldnames') {
                $fieldnames_actual[] = $k;
                $values[] = $v;
            }
        }
		
       // echo'<pre>';        print_r($fieldnames_actual);        print_r($values);echo '</pre>';
        ?>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Popular Words</h2> 
						
						<!--------------- image capture ------->
							
								
							
							<!--------------- image capture ------->
						
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link right"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        <li class="right"><input type="button" class="btn btn-primary"value="Download" id="capture" /></li>
                        </ul>
						
                        <div class="clearfix"></div>
                    </div>
					
					
                    <div class="x_content wordData">
                        <br />
                        <form class="form-horizontal form-label-left input_mask">
						<div id="canvas">
						  <?php
                            $i = 0;
                            $globeGraph = array();
                            $textGraph = array();
							$valuesum = array_sum($values);
                            while ($i < sizeof($words)) {
								 $progrsswidth =  $values[$i] * 100/$valuesum;
                                ?>
                                <div  class="form-group">
								
                                    <div class="progress">
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $progrsswidth; ?>%">
                                            <?php
                                            echo '<b>' . $fieldnames_actual[$i] . ' : ' . $values[$i] . '<b>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $textGraph['text'] = $fieldnames_actual[$i];
                                $textGraph['size'] = $values[$i]*10;

                                $i++;
                                array_push($globeGraph, $textGraph);
                            }
                            ?>
							</div>
							
                        </form>
						
                    </div>
                </div>
            </div>
            <textarea style="display:none;" id="textGlobe" ><?php echo json_encode($globeGraph); ?></textarea>
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Word Cloud</h2>
						
						
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link "><i class="fa fa-chevron-up"></i></a>
                            </li>
							
							<li class="right"><input type="button" class="btn btn-primary"value="Download" id="capture1" /></li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content wordData">
                        <br />
                        <form class="form-horizontal form-label-left">


                            <div class="form-group">
                                <?php require_once('graph/wallGraph.php'); ?>
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
                            <?php 
				if($feedDetailsArr['success']==1){
					foreach ($feedData as $feed) { 
						echo "<div class='row' id='commentDiv" . $feed['commentId'] . "'>"; 
			    ?>
									
								<div class="col-sm-1">
								<img src="<?php echo $feed['userimage'];?>" onerror="this.src='images/user.png' "class="img img-responsive img-circle "style="border:1px solid"/>
								</div>
                                
								<div style="border-bottom:1px solid #eee;padding: 0px 20px 6px 20px;"  class="col-xs-12 col-sm-11 col-md-11 col-lg-11 "><p class="userresponse"><?php echo $feed['comment_text']; ?></p>
								
								<p><span class="NoOflikes"><i class="fa fa-heart" aria-hidden="true"></i> <?php echo $feed['totalLikes']; ?>,<span> &nbsp; </i>
								
								<?php echo date('d M Y', strtotime($feed['CommentDate'])); ?></p>
									
																		
									<?php echo "<button type='button' class='deleteComment btn btn-default btn-sm' id='" . $feed['commentId'] . "'>
                        <span class='glyphicon glyphicon-trash'></span> Delete </button>";
                       ?>
									
									</div>
									
									</div>
									<!--<hr>-->                                                 
							<?php }} ?>




                                                </form>
                                                </div>
                                                </div>
                                                </div>
                                                </div>


                                                </div>
                                                </div>
                                                <!-- /page content -->
<style>#canvas{
		background-color : white;
		}		
</style>		


<script type="text/javascript">
            			
	$("#capture").click(function(){
	html2canvas([document.getElementById('canvas')], {
    onrendered: function (canvas) 
	{
    var data = canvas.toDataURL('image/jpeg');
	//alert(data);		
	save_img(data,'popularwords.jpeg');
    }
    });
  });
  
  
  $("#capture1").click(function(){
		
    html2canvas($("#canvas1"), {
        onrendered: function(canvas) {
			//alert(canvas);
            // canvas is the final rendered <canvas> element
            var data = canvas.toDataURL("image/jpeg");
			
			//alert(data);
           
			save_img(data,'wordcloud.jpeg');
           // window.open(myImage);
        }
    });
  });

			function save_img(data, imgname) {
                //alert(data);
                var img = document.createElement('img');
                img.src = data;
				img.style.cssFloat  = "left";
				img.style.border  = "1px solid black";
                var a = document.createElement('a');
				a.setAttribute("download", imgname);
                a.setAttribute("href", data);
                a.appendChild(img);
                var w = open();
                w.document.title = 'Download Image';
                w.document.body.innerHTML = '<b style="color:red;">Click On Image for Download</b><br><br><br>';
                w.document.body.appendChild(a);
            }

            /******************************** / download image *********************/
        </script>




                                                <?php include 'footer.php'; ?>
