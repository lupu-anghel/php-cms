



    <!-- Registration Well -->
   <div class="well">   
        <div class="row">
            <a href="registration.php"><img src="images/register.jpg" class="img-responsive center"></a>
        </div>
   </div>
   
 <!-- Latest posts -->
    <div class="well">

        <?php 

            $posts_query = "SELECT post_id, post_title FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT 3";
            $select_latest_posts = mysqli_query($connection,$posts_query);

        ?>
        <div class="sidebar-title">
            <h4 style="padding-bottom: 0;">Latest Posts</h4>
        </div>
            
            <?php 

                while($row = mysqli_fetch_array($select_latest_posts)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    echo "<p class='latest-posts'> <a class='category-links' href='post.php?p_id=" . $post_id ."'>" . $post_title . "</a></p>";
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




