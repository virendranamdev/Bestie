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
<!--<script src="js/analytic/downloadanalyticimage.js"></script>
-->
<script src="js/analytic/html2canvas.min.js"></script>

<script>
  // tell the embed parent frame the height of the content
  if (window.parent && window.parent.parent){
    window.parent.parent.postMessage(["resultsFrame", {
      height: document.body.getBoundingClientRect().height,
      slug: "None"
    }], "*")
  }
</script>

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

        $fieldnames_actual = array();
        $values = array();

        foreach ($words as $k => $v) {
            if ($k != 'fieldnames') {
                $fieldnames_actual[] = $k;
                $values[] = $v;
            }
        }
//        echo'<pre>';        print_r($fieldnames_actual);        print_r($values);
        ?>
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Popular Words</h2>
						
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="right"><a class="collapse-link right"><i class="fa fa-chevron-up"></i></a>
                            </li>

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
                            while ($i < sizeof($words)) {
                                ?>
                                <div  class="form-group">
								
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $values[$i] * 20; ?>%">
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
							<!--------------- image capture ------->
							<div class="form-group">
							<div id="design">
							<div id="controls">
							<input type="button" value="Download" id="capture" /><br /><br />	
							</div>
							</div>
							</div>
							<!--------------- image capture ------->
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
							if($feedDetailsArr['success']==1)
							{
							foreach ($feedData as $feed) { ?>

									<?php echo "<div class='row' id='commentDiv" . $feed['commentId'] . "'>"; ?>
									
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

<script type='text/javascript'>//<![CDATA[

function renderContent() {
    html2canvas(document.getElementById("canvas"), {
        allowTaint: true
    }).then(function(canvas) {
	//alert(canvas);
        //document.getElementById("result").appendChild(canvas);
		data = canvas.toDataURL('image/jpeg');
		//alert(data);
		save_img(data,'popularword.jpeg');
    });
	
	
}

document.getElementById("capture").onclick = renderContent;

function save_img(data,imgname){
	//alert('hi');
var img = document.createElement('img');
img.src = data;
var a = document.createElement('a');
//a.setAttribute("download", "wordcloud.jpeg");
a.setAttribute("download", imgname);
a.setAttribute("href", data);
a.appendChild(img);
var w = open();
w.document.title = 'Download Image';
w.document.body.innerHTML = 'Click On Image for Download';
w.document.body.appendChild(a);
}





</script>
<script type="text/javascript">	
/*************************** download image *************************/
		/*$(function(){
			
		$('#capture').click(function(){
				//get the div content
				div_content = document.querySelector("#canvas");
				alert(div_content);
				//make it as html5 canvas
				html2canvas(div_content).then(function(canvas) {
					alert('ho');
					die;
					//change the canvas to jpeg image
					data = canvas.toDataURL('image/jpeg');
					
					//then call a super hero php to save the image
					save_img(data,'wordcloud.jpeg');
				});
			});			
		});
		
		
function save_img(data,imgname){
var img = document.createElement('img');
img.src = data;
var a = document.createElement('a');
//a.setAttribute("download", "wordcloud.jpeg");
a.setAttribute("download", imgname);
a.setAttribute("href", data);
a.appendChild(img);
var w = open();
w.document.title = 'Download Image';
w.document.body.innerHTML = 'Click On Image for Download';
w.document.body.appendChild(a);
}
*/

/******************************** / download image *********************/		
</script>
<script>
  // tell the embed parent frame the height of the content
  if (window.parent && window.parent.parent){
    window.parent.parent.postMessage(["resultsFrame", {
      height: document.body.getBoundingClientRect().height,
      slug: "None"
    }], "*")
  }
</script>

                                                <?php include 'footer.php'; ?>
