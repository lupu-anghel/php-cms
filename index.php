
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php session_start(); ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>
    <?php include "includes/slider_1.php"; ?>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-9">
                <div style="padding-top: 50px; padding-bottom: 50px;" class="text-center">
                    <h3 style="margin-bottom: 15px;">SOME NICE <strong>TITLE</strong> HERE</h3>
                    <div class="col-xs-1 col-xs-offset-5 separator"></div>
                    <br /><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>

                <div class="row">
                    <?php 

                    if(isset($_GET['page'])) {

                        $page = $_GET['page'];
                    } else {
                        $page = "";
                    }

                    if($page == "" || $page == 1) {

                        $page_1 = 0;
                    } else {

                        $page_1 = ($page * 4) - 4;
                    }

                    $post_query_count = "SELECT * FROM posts";
                    $send_query_count = mysqli_query($connection, $post_query_count);

                    $count = mysqli_num_rows($send_query_count);

                    $count = ceil($count / 4);


                    $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $page_1, 4 ";
                    $select_all_posts = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($select_all_posts)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'],0,450);
                        $post_status = $row['post_status'];

                    ?>

                    <!-- First Blog Post -->
                    <div class="col-md-6" style="margin-top: 50px;">
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                        <div class="post-box">
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-sm-6">
                                    <p>Author : <em><a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a></em> </p>
                                </div>
                                <div class="col-sm-6">
                                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                                </div>
                            </div>
                            <h4>
                                <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                            </h4>
                            <p><?php echo $post_content; ?></p>
                            <p style="margin-top: 30px;"><a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a></p>
                        </div>
                    </div>
                    
                   <?php }?>

                    <?php 

                        $no_post_query = "SELECT * FROM posts WHERE post_status = 'published' ";
                        $send_no_post_query = mysqli_query($connection, $no_post_query);

                        $no_post_count = mysqli_num_rows($send_no_post_query);

                        if($no_post_count == 0) {
                            echo "<h3>There are no posts yet. Please come back later.</h3>";
                        }

                    ?>
                </div>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-3 hide-sidebar-mobile">
                <?php 

                if(isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];

                    $status_query = "SELECT loged_in, user_firstname, user_lastname, user_role FROM users WHERE user_id = $user_id ";
                    $send_status_query = mysqli_query($connection, $status_query);

                    if(!$send_status_query) {

                        die("QUERY FAILED! " . mysqli_error($connection));
                    }

                    while($row = mysqli_fetch_array($send_status_query)) {

                        $login_status = $row['loged_in'];
                        $user_fname = $row['user_firstname'];
                        $user_lname = $row['user_lastname'];
                        $user_role = $row['user_role'];
                    }

                    if($user_role == 'admin') {

                        include "includes/admin-sidebar.php";

                    } else if ($user_role == 'editor') {
                        include "includes/editor-sidebar.php";
                    } else {
                        include "includes/visitor-sidebar.php"; 
                    }


                } else {

                    include "includes/visitor-sidebar.php"; 
                }
                ?>
            </div>
        </div>
        <!-- /.row -->

        <ul class="pager">
            <?php 

                for($i = 1; $i <= $count; $i++) {

                    if($i == $page) {

                        echo "<li><a class='active' href='index.php?page={$i}'>{$i}</a></li>";
                    } else {
                        echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                    }

                    
                }
            ?>
        </ul>

        <hr>




<?php include "includes/footer.php" ?>