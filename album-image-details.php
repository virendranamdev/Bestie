<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>   
<?php
require_once('Class_Library/class_upload_album.php');
$objalbum = new Album();

$clientId = $_SESSION['client_id'];
$empId = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$albumid = $_GET['albumid'];
$imgid = $_GET['imageId'];

$albumdetails = $objalbum->getAlbumDetails($clientId, $albumid, $imgid);
$albumdetailsarray = json_decode($albumdetails, true);

	$imagecomment = $objalbum->getAlbumImageComment($albumid,$imgid);
	$imagecommentarray = json_decode($imagecomment, true);
	$totalcomment = count($imagecommentarray['posts']);
	/*echo "<pre>";
	print_r($totalcomment);
	*/
?>
<input type="hidden" id="albumid" value="<?php echo $albumid; ?>">
<input type="hidden" id="imageid" value="<?php echo $imgid; ?>">
<script>
    $(document).ready(function () {
			
		$('.deleteComment').click(function () {
			//alert("hi");
			
			var albumid = $("#albumid").val();
			var imageid = $("#imageid").val();
			var commentId = $(this).attr('id');
			var flag = 11;
			
			//var feedbackid = "Feedback-1";
			//var commentid = "Comment-10";
			
            var confirmationBox = confirm("Are you sure you want to delete this comment ?");
            if (confirmationBox == true) {
                $.ajax({
                    url: "delete_album_comment.php",
                    type: "POST",
                    cache: false,
                    data: {
                        postId: albumid,
						imageid: imageid,
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
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
						<div class="x_title">
							<h2><?php echo $albumdetailsarray['data']['title'];?></h2>
							<?php
							/*
							echo "<pre>";
							print_r($imagecommentarray);
							*/
							?>
							<ul class="nav navbar-right panel_toolbox">
								<li>
								<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
								</li>
							</ul>
							<div class="clearfix"></div>
						</div>
						
						<div class="x_content">
						<style>
							.bb{border-bottom:1px solid #eee;padding:20px;}
							.date{color:gray;}
							.captionText{font-size:16px;font-weight:600;padding:10px}
							.gray{background:rgba(51, 122, 183, 0.97);}
							.gray b{color:#fff;}
							.UName{font-size:16px;color:rgba(51, 122, 183, 0.97); text-transform:capitalize;margin-bottom:0px;}
						</style>
							<div class="row bb">
								<div class="col-sm-12">
								<center><img src="<?php echo $albumdetailsarray['data']['imgName']; ?>" class="img img-responsive"/>
								<?php
								if($albumdetailsarray['data']['imageCaption'] != "" )
								{
								?>								
								<p class="captionText"><b>"</b> <?php echo $albumdetailsarray['data']['imageCaption']; ?> <b>"</b></p></center>
								<?php }	?>
								</div>
							</div>
							
							
							<?php 
							if($imagecommentarray['success'] == 1)
							{
							?>
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
							for($i=0; $i<count($imagecommentarray['posts']); $i++)
							{
							$username = $imagecommentarray['posts'][$i]['firstname']." ".$imagecommentarray['posts'][$i]['middlename']." ".$imagecommentarray['posts'][$i]['lastname'];
							?>
							
							<!--<div class="row bb">-->
							
							<?php echo "<div class='row bb' id='commentDiv" . $imagecommentarray['posts'][$i]['comment_id'] . "'>"; ?>
							
							<div class="col-sm-1">
								<img src="<?php echo $imagecommentarray['posts'][$i]['userimage'];?>" onerror="this.src='images/user.png' "class="img img-responsive img-circle "style="border:1px solid"/>
								</div>
								<div class="col-sm-9">
								<p class="UName"><b> <?php echo $username;?>  </b></p>
								<p class="date"><?php echo $imagecommentarray['posts'][$i]['cdate'];?></p>	
								<p class="userresponse"><?php echo $imagecommentarray['posts'][$i]['content'];?></p>
											
								</div>
								<div class="col-sm-2">
								<?php echo "<button type='button' class='deleteComment btn btn-danger btn-sm' id='" . $imagecommentarray['posts'][$i]['comment_id'] . "'>
										<span class='glyphicon glyphicon-trash'></span> Delete </button>";
										?>
								</div>
							</div>
							<?php } } ?>
						</div>
					</div>
                </div>
			</div>
        </div>
        </div>
        <!-- /page content -->

<?php include 'footer.php';?>
       