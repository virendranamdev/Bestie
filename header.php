<?php
date_default_timezone_set('Asia/Kolkata');
define('SITE', 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) . '/');

session_start();
if (!isset($_SESSION['user_session']) && $_SESSION['user_session'] == "") {
    echo "<script>window.location='login.php'</script>";
}
if (!empty($_SESSION['user_session'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <!-- Meta, title, CSS, favicons, etc. -->
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>Benepik | Admin Panel</title>


            <!-- Bootstrap -->
            <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

            <!-- Font Awesome -->
            <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

            <!-- NProgress -->
            <link href="vendors/nprogress/nprogress.css" rel="stylesheet">

            <!-- iCheck -->
            <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">

            <!-- bootstrap-progressbar -->
            <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

            <!-- JQVMap -->
            <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

            <!-- bootstrap-daterangepicker -->
            <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

            <!-- Custom Theme Style -->

            <link href="build/css/mycss.css" rel="stylesheet">
            <link href="build/css/custom.min.css" rel="stylesheet">


            <!-- Datatables -->
            <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
            <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
            <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
            <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
            <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

			
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="js/highcharts/exporting.js"></script>
<!--
<script src="js/highcharts/highcharts-3d.js"></script>

	 <script src="js/highcharts/highcharts.js"></script>
	<script src="js/highcharts/exporting.js"></script>-->
        </head>


        <body class="nav-md">
            <div class="container body">
                <div class="main_container">
                    <?php
                } else {
                    echo "<script>window.location='login.php'</script>";
                }
                ?>