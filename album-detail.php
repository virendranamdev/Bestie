<?php include 'header.php';?>
<?php include 'sidemenu.php';?>
<?php include 'topNavigation.php';?>
 <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 2000); // Change image every 2 seconds
}
</script> 


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Album Detail</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
     <!--<a href="wallPredefineTemplate.php"><button class="btn btn-primary pull-right btn-round"> Use Predefined Temple</button></a>-->

  
                    <form class="myform form-horizontal form-label-left">

<div class="row">
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
<div class="gallery">
  <a target="_blank" href="#">
    <div class="w3-content w3-section" >
		<img class="mySlides w3-animate-fading" src="img/1.jpg" style="height:150px;">
		<img class="mySlides w3-animate-fading" src="img/7.jpg" style="height:150px;">
		<img class="mySlides w3-animate-fading" src="img/8.jpg" style="height:150px;">
		<img class="mySlides w3-animate-fading" src="img/9.jpg" style="height:150px;">
	</div>
  </a>
  <div class="desc" style="max-height:70px;font-weight:600;">Number  of image</div>
  
</div>
<div class="form-group"><h5 style="float:right;">Posted Date: 6 Apr 2017</h5></div>
</div>
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h3><b>This is the title of the our album.</b></h3></div>
</div>
Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here
Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here Add a description of the image here


</div>

</div>
<div class="row">
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
<div class="gallery">
  <a target="_blank">
    <img data-toggle="modal" data-target="#myModal" src="img/7.jpg" alt="Mountains" style="height:150px;padding:1px 1px 1px 1px;">
  </a>
  <div class="desc"><span  style="max-height:70px;">Add a description of the image here Add a description of the image.</span><br><span style="font-size:12px;padding: 0px 0px 0px 5px;"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span> <span  class="pull-right" style="font-size:12px;padding: 0px 10px 0px 0px;"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></span></div>
</div>

</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
<div class="gallery">
  <a target="_blank">
    <img data-toggle="modal" data-target="#myModal" src="img/8.jpg" alt="Mountains" style="height:150px;padding:1px 1px 1px 1px;">
  </a>
  <div class="desc"><span  style="height:70px;">Add a description of the image here Add a description of the image.</span><br><span style="font-size:12px;padding: 0px 0px 0px 5px;"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span> <span  class="pull-right" style="font-size:12px;padding: 0px 10px 0px 0px;"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></span></div>
</div>

</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
<div class="gallery">
  <a target="_blank">
    <img data-toggle="modal" data-target="#myModal" src="img/9.jpg" alt="Mountains" style="height:150px;padding:1px 1px 1px 1px;">
  </a>
  <div class="desc"><span  style="height:70px;">Add a description of the image here Add a description of the image.</span><br><span style="font-size:12px;padding: 0px 0px 0px 5px;"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span> <span class="pull-right" style="font-size:12px;padding: 0px 10px 0px 0px;"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></span></div>
</div>

</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
<div class="gallery">
  <a target="_blank">
    <img data-toggle="modal" data-target="#myModal" src="img/1.jpg" alt="Mountains" style="height:150px;padding:1px 1px 1px 1px;">
  </a>
  <div class="desc" ><span  style="height:70px;">Add a description of the image here Add a description of the image.</span><br><span style="font-size:12px;padding: 0px 0px 0px 5px;"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span> <span  class="pull-right" style="font-size:12px;padding: 0px 10px 0px 0px;"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></span></div>
</div>

</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
<div class="gallery">
  <a target="_blank">
    <img data-toggle="modal" data-target="#myModal" src="img/2.jpg" alt="Mountains" style="height:150px;padding:1px 1px 1px 1px;">
  </a>
  <div class="desc"><span  style="height:70px;">Add a description of the image here Add a description of the image.</span><br><span style="font-size:12px;padding: 0px 0px 0px 5px;"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span> <span  class="pull-right"style="font-size:12px;padding: 0px 10px 0px 0px;"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></span></div>
</div>

</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
<div class="gallery">
  <a target="_blank">
    <img data-toggle="modal" data-target="#myModal" src="img/3.jpg" alt="Mountains" style="height:150px;padding:1px 1px 1px 1px;">
  </a>
  <div class="desc"><span  style="height:70px;">Add a description of the image here Add a description of the image.</span><br><span style="font-size:12px;padding: 0px 0px 0px 5px;"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span> <span  class="pull-right"style="font-size:12px;padding: 0px 10px 0px 0px;"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></span></div>
</div>

</div>	
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        
<div class="container">
  <center>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
	
      <div class="item active">
	  <h4 style="float:left;padding:3px;">Image Caption1</h4>
        <img src="img/1.jpg" alt="Chania" style="height:500px;width:100%;padding:0px 3px 3px 3px;">
      </div>

      <div class="item">
	  <h4 style="float:left;padding:3px;">Image Caption2</h4>
        <img src="img/6.jpg" alt="Chania" style="height:500px;width:100%;padding:0px 3px 3px 3px;">
      </div>
    
      <div class="item">
	  <h4 style="float:left;padding:3px;">Image Caption3</h4>
        <img src="img/7.jpg" alt="Flower" style="height:500px;width:100%;padding:0px 3px 3px 3px;">
      </div>

      <div class="item">
	  <h4 style="float:left;padding:3px;">Image Caption4</h4>
        <img src="img/8.jpg" alt="Flower" style="height:500px;width:100%;padding:0px 3px 3px 3px;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div></center>
</div>
      </div>
      
    </div>
  </div>
  
</div>
                    </form>



                  </div></div>
                  </div></div>
                </div>
              </div>
</div>
          </div>
        </div>
        <!-- /page content -->
		<style>
div.gallery {
    margin: 5px;
    border: 1px solid #ccc;
    float: left;
    width: 180px;
}

div.gallery:hover {
    border: 1px solid #777;
}

div.gallery img {
    width: 100%;
    height: auto;
}

div.desc {
    padding: 15px 5px 15px 5px;
    
}
</style>


<style>
.carousel-control.right {
	
	margin-top:42px ! important;
	
	margin-right:3px;
	
}
.carousel-control.left {
	margin-top:42px ! important;
	margin-left:3px;

}
.w3-section, .w3-code {
	margin:1px 1px 1px 1px;
}
.w3-section, .w3-code {
margin-top:0px ! important;
margin-bottom:0px ! important;
}
.img{
	margin-bottom:0px ! important;
}
</style>



<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 9000);    
}
</script>




<?php include 'footer.php';?>
       