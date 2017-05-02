<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link href="build/css/story-detail.css" rel="stylesheet">	 
<script src="https://code.highcharts.com/highcharts.js"></script>
<script async src="build/js/Chart.min.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<?php
require_once('Class_Library/class_achiverstory.php');
require_once('Class_Library/class_comment.php');
                
$objAchiever = new AchiverStory();
$objt = new Comment();

$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];

if(isset($_GET['storyid']))
{
//echo "<script>alert('hi');</script>";	
$storyid = $_GET['storyid'];
$flag = 16;
$storyresult = $objAchiever->achiever_details($clientId, $storyid, $flag);
$sresult = json_decode($storyresult, true);
}
?>
<input type="hidden" id="storyid" value="<?php echo $storyid; ?>">
<script>
    $(document).ready(function () {
			
		$('.deleteComment').click(function () {
			//alert("hi");
			
			var storyid = $("#storyid").val();
			var commentId = $(this).attr('id');
			var flag = 16;
						
			//alert(storyid);
			//alert(commentId);
			//alert(flag);
			
            var confirmationBox = confirm("Are you sure you want to delete this comment ?");
            if (confirmationBox == true) {
                $.ajax({
                    url: "delete_comment.php",
                    type: "POST",
                    cache: false,
                    data: {
                        postId: storyid,
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
                    <h2>Colleague Story detail</h2>
					
					<?php /*echo "<pre>";
					print_r($sresult);
					echo "</pre>";*/
					?>
					
                    <ul class="nav navbar-right panel_toolbox">
                      <li class="right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
				  
				  <div class="myStoryContainer">
                    <br />
					<div class="storyUserBgImage"style="background-image:url('<?php echo $sresult['image'][0]['imagePath'];?>')">
						<div class="storyUserImageShadow"><center>
						<img src="<?php echo $sresult['image'][0]['imagePath'];?>" class="img img-responsive img-circle" style="width: 130px;max-height: 130px;"/>
						<h3><?php echo $sresult['data']['achieverName'];?></h3>
						<h5><?php echo $sresult['data']['designation'];?></h5>
						</center></div></div>
                    <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                 <div class="form-group">
                    <h4><b><?php echo $sresult['data']['title'];?></b></h4>
                    
                  </div>
				  <div class="form-group">
                    <h4><?php echo $sresult['data']['story'];?></h4>
                    
                  </div>
				  
				  <div class="form-group">
					<center><ul class="inlineUL">
					<?php 
					for($i=0; $i<count($sresult['image'])-1; $i++)
					{
					?>
						<li><img src="<?php echo $sresult['image'][$i+1]['imagePath'] ;?>"class="img img-responsive storyImage" style="max-width:200px;"/></li>
					<?php } ?>
						<!--<li><img src="images/picture.jpg"class="img img-responsive storyImage"/></li>
						<li><img src="images/picture.jpg"class="img img-responsive storyImage"/></li>-->
					</ul></center>
				</div>
                    </form>
					</div>
					
					<!---------------------- story comment ------------------------>
					<div>
					<?php 
					$val = $objt->CommentView($storyid, $clientId, $flag);
					$get = json_decode($val, true);
					/*echo "<pre>";
					print_r($get);
					echo "</pre>";*/
					if($get['success'] == 1)
					{
					?>
					<style>
							.bb{border-bottom:1px solid #eee;padding:20px;}
							.date{color:gray;}
							.captionText{font-size:16px;font-weight:600;padding:10px}
							.gray{background:rgba(51, 122, 183, 0.97);}
							.gray b{color:#fff;}
							.UName{font-size:16px;color:rgba(51, 122, 183, 0.97); text-transform:capitalize;margin-bottom:0px;}
					</style>
					<div class="row bb gray">
							<div class="col-sm-1">
								<b>Image</b>
								</div>
								<div class="col-sm-9">
								<b>Comments</b>
								</div>
								<div class="col-sm-2">
								<b>Action</b>
								</div>
					</div>
					<?php
					for($i=0; $i<count($get['posts']); $i++)
					{
						$username = $get['posts'][$i]['firstname']." ".$get['posts'][$i]['middlename']." ".$get['posts'][$i]['lastname'];
					?>
					<?php echo "<div class='row bb' id='commentDiv" . $get['posts'][$i]['comment_id'] . "'>"; ?>
							
							<div class="col-sm-1">
								<img src="<?php echo $get['posts'][$i]['userimage'];?>" onerror="this.src='images/user.png' "class="img img-responsive img-circle "style="border:1px solid"/>
								</div>
								<div class="col-sm-9">
								<p class="UName"><b> <?php echo $username;?>  </b></p>
								<p class="date"><?php echo $get['posts'][$i]['cdate'];?></p>	
								<p class="userresponse"><?php echo $get['posts'][$i]['content'];?></p>
											
								</div>
								<div class="col-sm-2">
								<?php echo "<button type='button' class='deleteComment btn btn-danger btn-sm' id='" . $get['posts'][$i]['comment_id'] . "'>
										<span class='glyphicon glyphicon-trash'></span> Delete </button>";
										?>
								</div>
							</div>
					
					<?php
					}}
					?>
					</div>
					<!---------------------- / story comment ---------------------->
                  </div>
                </div>
              </div>
            </div>

			
          </div>
        </div>
        <!-- /page content -->
		
      <?php include 'footer.php';?>