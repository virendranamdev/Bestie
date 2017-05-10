 <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
                <a href="dashboard.php" class="site_title"><i class="fa fa-link"></i> <span>Bestie</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo SITE.$_SESSION['image_name']; ?>" alt="..." class="img-circle profile_img" style="width:70px;height:70px;" onerror="this.src='images/user.png'">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $_SESSION['user_name']; ?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
               <!-- <h3>Engagement</h3>-->
                <ul class="nav side-menu">
                                                                                  <li><a href="dashboard.php"><i class="fa fa-home"></i> Home <!--<span class="fa fa-chevron-down">--></span></a>       </li>
                  <li><a><i class="fa fa-user"></i> User <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="add_user.php">Add User</a></li>
                      <li><a href="update-user.php">Update User</a></li>
                      <li><a href="view-user.php">View User</a></li>
                    </ul>
                  </li>

                <li><a href="wall.php"><i class="fa fa-table"></i> Feedback Wall </a></li>

                <li><a href="happiness.php"><i class="fa fa-smile-o"></i> Happiness Index </a></li>

                 <li><a href="mini-survey.php"><i class="fa fa-line-chart"></i> Mini Survey</a></li>
                 <li><a href="story.php"><i class="fa fa-book"></i> Colleague Stories</a></li>

                 <li><a href="album.php"><i class="fa fa-file-image-o" ></i>Album</a></li>
				 
				 <li><a href="reminder.php"><i class="fa fa-bell-o" aria-hidden="true"></i> Notification </a>  </li>
				
                   <li><a  href="view-previous-thought.php"><i class="fa fa-hourglass-start"></i> Thought Of The Day </a></li>
                   <li><a  href="recognition.php"><i class="fa fa-bar-chart-o"></i> Recognition </a>         </li>
				   <li><a  href="health-welness-view.php"><i class="fa fa-heartbeat"></i>Health & Wellness </a></li>
				    <li><a><i class="fa fa-user"></i> Analytics <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="activeuseranalytic.php">Active User</a></li>
                      <li><a href="postViewAnalytic.php">Post</a></li>                    
                    </ul>
                  </li>
				  
				   </ul>
              </div>
              <!-- <div class="menu_section">
                <h3>Rewards & Recognition</h3>
                <ul class="nav side-menu">
                 <li><a><i class="fa fa-bar-chart-o"></i> Recognition Analytics <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="#">Add Recognition Budget </a></li>
                      <li><a href="#">View Total Earning </a></li>
                      <li><a href="#">Recognize Topic Analytics </a></li>
                      <li><a href="#">Voucher details </a></li>
                      
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="#"> </a></li>
                      <li><a href="#"> </a></li>
                      <li><a href="#"> </a></li>
                      <li><a href="#"> </a></li>
                      <li><a href="#"> </a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                  
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div>-->

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>