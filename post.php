<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php session_start(); ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">

                <?php 

                    if(isset($_GET['p_id'])) {

                        $post_id = $_GET['p_id'];

                        $post_id = mysqli_real_escape_string($connection, $post_id);

                        $view_query = "UPDATE posts SET post_views = post_views + 1 WHERE post_id = $post_id;";
                        $send_query = mysqli_query($connection, $view_query);

                        $query = "SELECT * FROM posts WHERE post_id = $post_id ";
                        $select_all_posts = mysqli_query($connection, $query);
                        while($row = mysqli_fetch_assoc($select_all_posts)) {
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = $row['post_content'];
                            $post_category_id = $row['post_category_id'];

                ?>

                            <!-- First Blog Post -->

                            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                            </div>
                            <div class="col-md-8">
                                    <div class="row" style="margin-top: 20px; margin-bottom: 30px;">
                                        <div class="col-xs-10">
                                            <h2><?php echo $post_title; ?></h2>
                                        </div>
                                        <div class="col-xs-2">
                                            <?php 

                                                if(isset($_SESSION['user_id'])) {

                                                    $user_role = $_SESSION['user_role'];

                                                    if($_SESSION['user_role'] == 'admin') {

                                                        if(isset($_GET['p_id'])) {

                                                            $post_id = $_GET['p_id'];
                                                            echo "<p style='margin-top: 20px;'><a class='edit-post' href='admin/posts.php?source=edit_post&p_id={$post_id}'><i class='fa fa-pencil'></i> Edit Post</a></p>";
                                                        } 

                                                    }  else if ($_SESSION['user_role'] == 'editor') {
                                                            echo "<p style='margin-top: 20px;'><a class='edit-post' href='admin/editor_posts.php?source=edit_post_editor&p_id={$post_id}'><i class='fa fa-pencil'></i> Edit Post</a></p>";
                                                    } else {

                                                        echo "";
                                                    }
                                                } 
                                            ?>
                                        </div>  
                                    </div>
                                    <div><?php echo $post_content; ?></div>
                                     <hr>
                                    <div class="row">
                                        <div class="col-xs-6"><p>Author : <a href="index.php"><em><?php echo $post_author; ?></em></a></p></div>
                                        <div class="col-xs-6"><p><span class="glyphicon glyphicon-time"></span> Posted on <em> <?php echo $post_date; ?></em></p></div>
                                    </div>
                                    


                  <?php } 

                } else {

                    header("location: index.php");
                }


                ?>



                <!-- Blog Comments -->

                <?php 


                    if(isset($_POST['create_comment'])) {

                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];
                        $comment_post_id = $_GET['p_id'];

                        $comment_author = mysqli_real_escape_string($connection, $comment_author);
                        $comment_email = mysqli_real_escape_string($connection, $comment_email);
                        $comment_content = mysqli_real_escape_string($connection, $comment_content);
                        $comment_post_id = mysqli_real_escape_string($connection, $comment_post_id);

                        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                        $query .= "VALUES($comment_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";
                        
                        $add_comment = mysqli_query($connection, $query);

                        if(!$add_comment) {
                            die('QUERY FAILED ' . mysqli_error($connection));
                        }

                        /*$query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $comment_post_id";
                        $update_comment_count = mysqli_query($connection, $query);*/
                    }

                ?>
                <!-- Related posts -->
                

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                        <div class="row">
                            <div class="form-group col-sm-6 col-xs-12">
                                <input type="text" class="form-control" name="comment_author" placeholder="Name" required>
                            </div>

                            <div class="form-group col-sm-6 col-xs-12">
                                <input type="email" class="form-control" name="comment_email" placeholder="Email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Your comment..." name="comment_content" required></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Post Comment</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                    <h3>User's thoughts on the topic</h3><br /> <br />
                    <?php 

                        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id AND comment_status = 'approved' ORDER BY comment_id DESC";
                        $display_comments = mysqli_query($connection, $query);

                        if(!$display_comments) {
                            die("QUERY FAILED " . mysqli_error($connection));
                        }

                        while($row = mysqli_fetch_assoc($display_comments)) {
                            $comment_author = $row['comment_author'];
                            $comment_date = $row['comment_date'];
                            $comment_content = $row['comment_content'];

                    ?> 
                            <div class="media" style="border-bottom: dotted 1px #ddd; padding-bottom: 15px; margin-bottom: 20px;">
                                <a class="pull-left" href="#">
                                    <img class="media-object" src="images/user.png" alt="">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $comment_author; ?>
                                        <small><?php echo $comment_date; ?></small>
                                    </h4>
                                    <?php echo $comment_content; ?>
                                </div>
                            </div>
                  <?php } ?>

                    

                  <div class="well">
                    <h4>Related posts:</h4>
                    <div class="row">
                        <?php  

                            $related_posts_query = "SELECT post_id, post_title, post_image FROM posts WHERE post_category_id = $post_category_id AND post_id != $post_id AND post_status = 'published' ORDER BY post_id DESC LIMIT 3";
                            $related_posts = mysqli_query($connection, $related_posts_query);

                            if(!$related_posts) {
                                die("QUERY FAILED " . mysqli_error($connection));
                            }

                            while($row = mysqli_fetch_array($related_posts)) {

                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                                $image_url = $row['post_image'];

                                echo "<div class='col-md-4'>
                                        <div style='height: 100px; overflow: hidden;'>
                                          <a href='post.php?p_id=" . $post_id . "'><img src='images/" . $image_url . "' class='img-responsive'></a>
                                        </div>
                                        <p style='margin-top: 10px;'><a href='post.php?p_id=" . $post_id . "'>" . $post_title . "</a></p>
                                      </div>";
                            }

                        ?>
                    </div>
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
        </div>
        <!-- /.row -->



<?php include "includes/footer.php" ?>

