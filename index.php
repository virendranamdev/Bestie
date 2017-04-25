<?php include 'header.php'; ?>
<?php include 'sidemenu.php'; ?>
<?php include 'topNavigation.php'; ?>
<style>
    hr{
        margin-top: 0px ! important;
        margin-bottom: 0px ! important;
        opacity:0.3;
    }

</style>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="js/highcharts/exporting.js"></script>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="row">
            <div class="col-md-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Happiness Index</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li  class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div id="container2" style="min-width: 310px; height: 405px; max-width: 600px; margin: 0 auto"></div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Recognition</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li  class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">



                        <div><h4>Top 3 Receivers</h4></div>				  
                        <div class="row" id="" >
                            <hr>
                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                <img src="images/picture.jpg" class="img-circle" style="height:40px; width:40px;margin-top:8px;margin-bottom:5px;"><font style="padding-left:10px;font-size:15px;">Name</font>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><font style="float:right;padding-top:15px;">8 received</font></div> 
                        </div>
                        <div class="row" id="" >
                            <hr>
                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                <img src="images/img.jpg" class="img-circle" style="height:40px; width:40px;margin-top:8px;margin-bottom:5px;"><font style="padding-left:10px;font-size:15px;">Name</font>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><font style="float:right;padding-top:15px;">12 received</font></div> 
                        </div>
                        <div class="row" id="" >
                            <hr>
                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                <img src="images/user.png" class="img-circle" style="height:40px ;width:40px;margin-top:8px;margin-bottom:5px;"><font style="padding-left:10px;font-size:15px;">Name</font>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><font style="float:right;padding-top:15px;">5 received</font></div> 
                        </div>
                        <br>
                        <div><h4>Top 3 Senders</h4></div>				  
                        <div class="row" id="" >
                            <hr>
                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                <img src="images/picture.jpg" class="img-circle" style="height:40px; width:40px;margin-top:8px;margin-bottom:5px;"><font style="padding-left:10px;font-size:15px;">Name</font>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><font style="float:right;padding-top:15px;">3 sent</font></div> 
                        </div>
                        <div class="row" id="" >
                            <hr>
                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                <img src="images/img.jpg" class="img-circle" style="height:40px; width:40px;margin-top:8px;margin-bottom:5px;"><font style="padding-left:10px;font-size:15px;">Name</font>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><font style="float:right;padding-top:15px;">23 sent</font></div> 
                        </div>
                        <div class="row" id="" >
                            <hr>
                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                <img src="images/user.png" class="img-circle" style="height:40px ;width:40px;margin-top:8px;margin-bottom:5px;"><font style="padding-left:10px;font-size:15px;">Name</font>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"><font style="float:right;padding-top:15px;">5 sent</font></div> 
                        </div>



                        <script>
                            Highcharts.chart('container2', {
                                chart: {
                                    type: 'pie',
                                    options3d: {
                                        enabled: true,
                                        alpha: 45,
                                        beta: 0
                                    }
                                },
                                title: {
                                    text: 'Browser market shares at a specific website, 2014'
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        depth: 35,
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.name}'
                                        }
                                    }
                                },
                                series: [{
                                        type: 'pie',
                                        name: 'Browser share',
                                        data: [
                                            ['Firefox', 45.0],
                                            ['IE', 26.8],
                                            {
                                                name: 'Chrome',
                                                y: 12.8,
                                                sliced: true,
                                                selected: true
                                            },
                                            ['Safari', 8.5],
                                            ['Opera', 6.2],
                                            ['Others', 0.7]
                                        ]
                                    }]
                            });
                        </script>
                        <script>
                            Highcharts.chart('container3', {
                                chart: {
                                    type: 'column',
                                    options3d: {
                                        enabled: true,
                                        alpha: 10,
                                        beta: 25,
                                        depth: 70
                                    }
                                },
                                title: {
                                    text: '3D chart with null values'
                                },
                                subtitle: {
                                    text: 'Notice the difference between a 0 value and a null point'
                                },
                                plotOptions: {
                                    column: {
                                        depth: 25
                                    }
                                },
                                xAxis: {
                                    categories: Highcharts.getOptions().lang.shortMonths
                                },
                                yAxis: {
                                    title: {
                                        text: null
                                    }
                                },
                                series: [{
                                        name: 'Sales',
                                        data: [2, 3, null, 4, 0, 5, 1, 4, 6, 3]
                                    }]
                            });

                        </script>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-3">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Values</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li  class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="radio htData"><label><input type="radio"name="activeU">Last 24 hours</label></div>
                        <div class="radio htData"><label><input type="radio"name="activeU">Last Week</label></div>
                        <div class="radio htData"><label><input type="radio"name="activeU">Last Month</label></div>
                        <div class="radio"id="homeActiveUser"><label><input type="radio"name="activeU">Custom</label></div>
                        <div id="dsds"><form>
                                <div class="form-group">
                                    <label for="usr">From:</label>
                                    <input type="date" class="form-control" id="usr">
                                </div>
                                <div class="form-group">
                                    <label for="pwd">To:</label>
                                    <input type="date" class="form-control" id="pwd">
                                </div></form>
                        </div>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
                        <script>

$(document).ready(function () {
$("#dsds").hide();
$("#homeActiveUser").click(function () {
$("#dsds").show();

});
$(".htData").click(function () {
$("#dsds").hide();

});
});
                        </script>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Active Users</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content activeUserGraphdataPrint">

                        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                        <script type='text/javascript'src="build/js/home_activeUser.js"></script>

                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-3">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Values</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li  class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Active Users</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Top 5 Posts</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li class="pull-right"><a ><div class="form-group"><!--<select class="form-control">
                                                <option>Jan</option>
                                                <option>Feb</option>
                                                <option>Mar</option>
                                                <option>Apr</option>
                                                <option>May</option>
                                                <option>Jun</option>
                                                <option>Jul</option>
                                                <option>Aug</option>
                                                <option>Sep</option>
                                                <option>Oct</option>
                                                <option>Nov</option>
                                                <option>Dec</option>
                                                </select>-->
                                        <input type="date">
                                    </div></a></li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item One Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Two Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Two Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Two Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Three Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="glyphicon glyphicon-comment" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                <a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Recent Activity</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item One Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Two Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Two Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Two Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Item Three Title</a>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
       