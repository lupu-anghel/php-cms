<?php include "includes/admin_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>



        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin page
                            <small><?php echo $_SESSION['user_firstname'] . " " . $_SESSION['user_lastname']; ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <?php 

                                            $query = "SELECT * FROM posts";
                                            $select_all_posts = mysqli_query($connection, $query);

                                            $posts_count = mysqli_num_rows($select_all_posts);

                                        ?>


                                        <div class="huge"><?php echo $posts_count; ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <?php 

                                            $query = "SELECT * FROM comments";
                                            $select_all_comments = mysqli_query($connection, $query);

                                            $comments_count = mysqli_num_rows($select_all_comments);

                                        ?>

                                        <div class="huge"><?php echo $comments_count; ?></div>
                                        <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <?php 

                                            $query = "SELECT * FROM users";
                                            $select_all_users = mysqli_query($connection, $query);
                                            $users_count = mysqli_num_rows($select_all_users);

                                        ?>
                                        <div class="huge"><?php echo $users_count; ?></div>
                                        <div>Users</div>
                                    </div>  
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <?php 

                                            $query = "SELECT * from categories";
                                            $select_all_categories = mysqli_query($connection, $query);
                                            $categories_count = mysqli_num_rows($select_all_categories);

                                        ?>

                                        <div class="huge"><?php echo $categories_count; ?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div> <!-- /.ROW pannels -->

                <?php 

                    $query = "SELECT * from posts WHERE post_status = 'published' ";
                    $select_all_published = mysqli_query($connection, $query);
                    $published_count = mysqli_num_rows($select_all_published);

                    $query = "SELECT * from posts WHERE post_status = 'draft' ";
                    $select_all_drafts = mysqli_query($connection, $query);
                    $drafts_count = mysqli_num_rows($select_all_drafts);

                    $query = "SELECT * from comments WHERE comment_status = 'unapproved' ";
                    $un_comm = mysqli_query($connection, $query);
                    $un_comm_count = mysqli_num_rows($un_comm);

                    $query = "SELECT * from users WHERE user_role = 'subscriber' ";
                    $select_all_subs = mysqli_query($connection, $query);
                    $subs_count = mysqli_num_rows($select_all_subs);


                ?>

                <div class="row">
                    <div class="col-xs-12">
                        <script type="text/javascript">
                          google.charts.load('current', {'packages':['bar']});
                          google.charts.setOnLoadCallback(drawChart);

                          function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                              ['Data', 'Count'],

                              <?php 

                                $element_title = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Pending Comments', 'Users', 'Subscribers', 'Categories'];
                                $element_count = [$posts_count, $published_count, $drafts_count, $comments_count, $un_comm_count, $users_count, $subs_count, $categories_count];

                                for($i = 0;$i < 8; $i++) {

                                    echo "['{$element_title[$i]}'" . "," . "'{$element_count[$i]}'],";
                                }


                              ?>

                            ]);

                            var options = {
                              chart: {
                                title: '',
                                subtitle: '',
                              }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                          }
                        </script>

                        <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                    </div>

                </div> <!-- /charts -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>
