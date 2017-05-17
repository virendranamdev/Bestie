<?php
//error_reporting(E_ALL);ini_set('display_errors', 1);

require_once('check_login_status.php');
$obj = new Auth();
//$obj->check_session();
?>
<body style="background-image:url('images/bestiebackground.jpg') !important;">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css/style.css">
<script src="js/validation/createPostValidation.js"></script>


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
                <a href="#" data-toggle="modal" data-target="#myModal">Forgot password?</a>
            </div>
        </form><!-- form -->
        <!--<div class="button">
                <a href="#">Download source file</a>
        </div><!-- button -->
    </section><!-- content -->
</div><!-- container -->

<!------------------------------- forget popup ----------------------------------->

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Forgot Password</h4>
        </div>
        <div class="modal-body">
			<form role="form" name="forgetpassword" action="Link_Library/link_forget_password.php" method="post">
                <br>
                <div class="form-group">
                    <input type="text" class="form-control" required="required" name="emailid" placeholder="Enter Your E-Mail ID">
                </div>
                <center><input type="submit" onclick="return forgetpasswordform();" class="btn btn-primary" name="forgetpassword" value="Submit" /></center>
				<br>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  

<!--------------------------------- / forget popup ------------------------------->
</body>