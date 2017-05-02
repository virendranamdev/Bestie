<?php
@session_start();
include_once('../Class_Library/class_upload_album.php');

$objalbum = new Album();
date_default_timezone_set('Asia/Calcutta');
$Post_Date = date('Y-m-d H:i:s A');
$uuid = $_SESSION['user_unique_id'];

if (isset($_GET['albumid']) && isset($_GET['imageId'])  && isset($_GET['approvestatus'])) {
    
	$albumid = $_GET['albumid'];
	$imageId = $_GET['imageId'];
	$approvestatus = $_GET['approvestatus'];
	$status = 1;
	if($approvestatus == 2)
	{
	$imgstatus = $objalbum->albumImageApproveReject($albumid,$imageId,$status);
    $imgstatusres = json_decode($imgstatus, true);
	if($imgstatusres['success'] == 1)
	{
		 echo "<script>alert('Album Image Approved Successfully');</script>";
		 echo "<script>window.location='../album-detail.php?albumId=".$albumid."'</script>";
         //echo "<script>window.location='../album.php'</script>";
	}
	else
	{
		 echo "<script>alert('Image Not Approve');</script>";
		 echo "<script>window.location='../album-detail.php?albumId=".$albumid."'</script>";
         //echo "<script>window.location='../album.php'</script>";
	}
	}
}

if (isset($_GET['albumid']) && isset($_GET['imageId'])  && isset($_GET['rejectstatus'])) {
    
	$albumid = $_GET['albumid'];
	$imageId = $_GET['imageId'];
	$rejectstatus = $_GET['rejectstatus'];
	$status = 3;
	if($rejectstatus == 2)
	{
	$imgstatus = $objalbum->albumImageApproveReject($albumid,$imageId,$status);
    $imgstatusres = json_decode($imgstatus, true);
	if($imgstatusres['success'] == 1)
	{
		 echo "<script>alert('Album Image Rejected');</script>";
         echo "<script>window.location='../album-detail.php?albumId=".$albumid."'</script>";
	}
	else
	{
		 echo "<script>alert('Image Not reject');</script>";
		 echo "<script>window.location='../album-detail.php?albumId=".$albumid."'</script>";
         //echo "<script>window.location='../album.php'</script>";
	}
	}
}

if (isset($_GET['albumid']) && isset($_GET['imageId'])  && isset($_GET['unpublishimagestatus'])) {
    
	$albumid = $_GET['albumid'];
	$imageId = $_GET['imageId'];
	$unpublishstatus = $_GET['unpublishimagestatus'];
	$status = 0;
	if($unpublishstatus == 1)
	{
	$imgstatus = $objalbum->albumImageApproveReject($albumid,$imageId,$status);
    $imgstatusres = json_decode($imgstatus, true);
	if($imgstatusres['success'] == 1)
	{
		 echo "<script>alert('status has changed');</script>";
         echo "<script>window.location='../album-detail.php?albumId=".$albumid."'</script>";
	}
	else
	{
		 echo "<script>alert('status not change');</script>";
		 echo "<script>window.location='../album-detail.php?albumId=".$albumid."'</script>";
         //echo "<script>window.location='../album.php'</script>";
	}
	}
}

if (isset($_GET['albumid']) && isset($_GET['imageId'])  && isset($_GET['publishimagestatus'])) {
    
	$albumid = $_GET['albumid'];
	$imageId = $_GET['imageId'];
	$publishstatus = $_GET['publishimagestatus'];
	$status = 1;
	if($publishstatus == 0)
	{
	$imgstatus = $objalbum->albumImageApproveReject($albumid,$imageId,$status);
    $imgstatusres = json_decode($imgstatus, true);
	if($imgstatusres['success'] == 1)
	{
		 echo "<script>alert('status has change');</script>";
         echo "<script>window.location='../album-detail.php?albumId=".$albumid."'</script>";
	}
	else
	{
		 echo "<script>alert('status not change');</script>";
		 echo "<script>window.location='../album-detail.php?albumId=".$albumid."'</script>";
         //echo "<script>window.location='../album.php'</script>";
	}
	}
}
?>