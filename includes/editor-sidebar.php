<div class="well">
    <?php 

        if(isset($_SESSION['user_id'])) {

            $user_id = $_SESSION['user_id'];
            $user_fname = $_SESSION['user_firstname'];
            $user_lname = $_SESSION['user_lastname'];
            $post_author = $_SESSION['username'];
        }

    ?>
        
    <div class="sidebar-title">
        <h4 style="padding-bottom: 0;">Welcome <em><?php echo $user_fname . " !"; ?></em></h4>
    </div>
    <p>As an editor on our website you can add, edit or delete posts and also moderate comments. Go to your editor dashboard <em>here</em> to get started</p>

            

            <!-- /.col-lg-6 -->
        <!-- /.row -->
    </div>
<!-- Latest posts -->
    <div class="well">

        
        <div class="sidebar-title">
            <h4 style="padding-bottom: 0;">Pending posts</h4>
        </div>

            <?php 

                if(isset($_SESSION['user_id'])) {

                    $user_id = $_SESSION['user_id'];
                    $user_fname = $_SESSION['user_firstname'];
                    $user_lname = $_SESSION['user_lastname'];
                    $post_author = $_SESSION['username'];

                    $draft_posts_query = "SELECT post_id, post_title FROM posts WHERE post_status = 'draft' ORDER BY post_id DESC LIMIT 5";
                    $send_query = mysqli_query($connection, $draft_posts_query);

                    $count_posts = mysqli_num_rows($send_query);

                    if(!$send_query) {
                        die("QUERY FAILED! " . mysqli_error($connection));
                    }

                    if($count_posts == 0) {

                        echo "<em>There aren't any draft posts that are pending your approval this time.</em>";
                    } else {

                        while($row = mysqli_fetch_array($send_query)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];

                        echo "<p class='latest-posts'><a class='category-links' href='admin/editor_posts.php?source=edit_post_editor&p_id=" . $post_id . "'>" . $post_title . "</a></p>";
                        }
                    }

                    

                }

            ?>
            

            <!-- /.col-lg-6 -->
        <!-- /.row -->
    </div>


    <!-- Blog Categories Well -->
    <div class="well">

        <?php 

            $query = "SELECT * FROM categories WHERE cat_id != 8 ORDER BY cat_id DESC LIMIT 5";
            $select_categories_sidebar = mysqli_query($connection,$query);

        ?>
        <div class="sidebar-title" style="margin-bottom: 5px;">
            <h4 style="padding-bottom: 0;">Latest Blog Categories</h4>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php 
                        while($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                            $cat_id = $row["cat_id"];
                            $cat_title = $row["cat_title"];

                            echo "<li style='padding-bottom: 5px; margin-top: 15px; border-bottom: dotted 1px #ddd;'><i style='color: #27baff;' class='fa fa-chevron-right'></i> <a class='category-links' href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                        }
                    ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>




