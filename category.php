
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php 

                if(isset($_GET['category'])) {
                    $post_category_id = $_GET['category'];
                }

                $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id ";
                $select_all_posts = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_all_posts)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'],0,450);

                ?>

                <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                <h3><a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h3>
                <div class="row">
                    <p><?php echo $post_content; ?></p>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-sm-4">
                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                    <div class="col-sm-4">
                        <p style="margin-top: 10px;">Author : <em><?php echo $post_author; ?></em></p>
                    </div>
                    <div class="col-sm-4">
                        <p style="margin-top: 10px;"><span class="glyphicon glyphicon-time"></span> Posted on <em><?php echo $post_date; ?></em></p>
                    </div>
                </div>
                

                <hr>

               <?php } ?>

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

        <hr>



<?php include "includes/footer.php" ?>

