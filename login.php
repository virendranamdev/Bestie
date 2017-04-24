<?php
error_reporting(E_ALL);ini_set('display_errors', 1);

require_once('check_login_status.php');
$obj = new Auth();
//$obj->check_session();
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/style.css">



<br><br><br><br><br><br><br><br><br><br><br><br>
<div class="container">
    <section id="content">
        <form action="Link_Library/link_client_login.php" method="POST">
            <h1>Login Form</h1>
            <div>
                <input type="text" name="username" placeholder="Username" class="white-background " required="" id="username" />
                <span class="fa fa-question form-control-feedback left" aria-hidden="true"></span>
            </div>
            <div>
                <input type="password" name="password" placeholder="Password"  class="white-background" required="" id="password" />
            </div>
            <div>
                <input type="submit" name="client_login" value="Log in" />
                <a href="#">Forgot password?</a>
                <a href="#">Register</a>
            </div>
        </form><!-- form -->
        <!--<div class="button">
                <a href="#">Download source file</a>
        </div><!-- button -->
    </section><!-- content -->
</div><!-- container -->
