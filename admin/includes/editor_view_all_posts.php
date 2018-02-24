<?php 

if(isset($_POST['checkBoxArray'])) {

    foreach($_POST['checkBoxArray'] as $checkBoxValue) {

        $bulk_options = $_POST['bulk_options'];

        $bul_options = mysqli_real_escape_string($connection, $bulk_options);

        switch($bulk_options) {

            case 'published':

                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$checkBoxValue} ";
                $update_to_published = mysqli_query($connection, $query);

                checkQuery($update_to_published);

                $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> Post(s) status changed to Published!</strong>
              </div>";

            break;

            case 'draft':

                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$checkBoxValue} ";
                $update_to_draft = mysqli_query($connection, $query);

                checkQuery($update_to_draft);

                $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> Post(s) status changed to Draft!</strong>
              </div>";

            break;

            case 'clone':

            $query = "SELECT * FROM posts WHERE post_id = '{$checkBoxValue}'";
            $select_post_query = mysqli_query($connection, $query);

            while($row = mysqli_fetch_array($select_post_query)) {
                $post_title       = $row['post_title'].' - CLONE';
                $post_category_id = $row['post_category_id'];
                $post_date        = $row['post_date'];
                $post_author      = $row['post_author'];
                $post_status      = $row['post_status'];
                $post_image       = $row['post_image'];
                $post_tags        = $row['post_tags'];
                $post_content     = $row['post_content'];
            }

            $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
            $query .= "VALUES($post_category_id, '{$post_title}', '{$post_author}', '{$post_date}', '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}' )";
            $clone_post_query = mysqli_query($connection, $query);

            if(!$clone_post_query) {

                die("Query failed" . mysqli_error($connection));
            }

            $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> Post(s) successfully Cloned!</strong>
              </div>";

            break;

            case 'delete':

                $query = "DELETE FROM posts WHERE post_id = {$checkBoxValue} ";
                $update_to_delete = mysqli_query($connection, $query);

                checkQuery($update_to_delete);

                $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> Post(s) successfully Deleted!</strong>
              </div>";

            break;

        }
    }
} else {

    $message = "";
}

?>

<h3>View all posts page</h3>
<hr>
<form action="" method="post">
    <div class="row">
        <div id="bulkContainer" class="col-md-4">

            <select name="bulk_options" class="form-control">

                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="clone">Clone</option>
                <option value="delete">Delete</option>

            </select>
        </div>
        <div class="col-md-4">
            
            <input onClick="javascript: return confirm('Are you sure you want to apply this changes?')" type="submit" class="btn btn-success" value="Apply">
            <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>     
        </div>
        <div class="col-md-4">
        </div>
    </div>
    <?php echo $message; ?>
    <div id="no-more-tables">
        <table class="col-md-12 table-bordered table-striped table-condensed cf">

            <thead class="cf">
                <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                    <th>Id</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Tags</th>
                    <th>Comments</th>
                    <th>Views</th>
                    <th>Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>

                <?php 

                    $query= "SELECT * FROM posts ORDER BY post_id DESC";
                    $select_posts = mysqli_query($connection, $query); 

                    while($row = mysqli_fetch_assoc($select_posts)) {
                        $post_id            = $row['post_id'];
                        $post_author        = $row['post_author'];
                        $post_title         = $row['post_title'];
                        $post_category_id   = $row['post_category_id'];
                        $post_status        = $row['post_status'];
                        $post_image         = $row['post_image'];
                        $post_tags          = $row['post_tags'];
                        $post_comment_count = $row['post_comment_count'];
                        $post_date          = $row['post_date'];
                        $post_views         = $row['post_views'];

                        $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
                        $select_category = mysqli_query($connection, $query); 
                        while($row = mysqli_fetch_assoc($select_category)) {
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];
                        }

                        echo "<tr>
                                <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='{$post_id}'></td>
                                <td>{$post_id}</td>
                                <td>{$post_author}</td>
                                <td><a href='../post.php?p_id=$post_id' target='_blank'>{$post_title}</a></td>
                                <td>{$cat_title}</td>
                                <td>{$post_status}</td>
                                <td style='width: 15%'><img src='../images/{$post_image}'  class='img-responsive'></td>
                                <td>{$post_tags}</td>";

                                $query = "SELECT * FROM comments  WHERE comment_post_id = $post_id";
                                $send_comment_query = mysqli_query($connection, $query);


                                if(!$send_comment_query) {

                                    die("QUERY FAILED! " . mysqli_error($connection));
                                }

                                $count_comments = mysqli_num_rows($send_comment_query);

                                echo "<td>{$count_comments}</td>

                                <td><a onClick=\"javascript: return confirm('Are you sure you want to reset the Views for this post?')\" href='posts.php?reset={$post_id}'>{$post_views}</a></td>
                                <td>{$post_date}</td>
                                <td><a href='editor_posts.php?source=edit_post_editor&p_id={$post_id}'>Edit</a></td>
                                <td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?')\" href='posts.php?delete={$post_id}'>Delete</a></td>
                              </tr>";

                    }

                ?>                       
            </tbody>
        </table>
    </div>
</form>


<?php

if(isset($_GET['delete'])){
    $delete_post_id = $_GET['delete'];

    $delete_post_id = mysqli_real_escape_string($connection, $delete_post_id);

    if(isset($_SESSION['user_id'])) {

        $user_role = $_SESSION['user_role'];
        echo $user_role;

        if($user_role !== 'admin') {

           header("Location: ../index.php");

        } else {

            $query = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
            $delete_post_query = mysqli_query($connection, $query);
            checkQuery($delete_post_query);
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=posts.php">';
        }
    }

}

if(isset($_GET['reset'])){
    $reset_post_id = $_GET['reset'];

    $reset_post_id = mysqli_real_escape_string($connection, $reset_post_id);

    if(isset($_SESSION['user_id'])) {

        $user_role = $_SESSION['user_role'];

        if($user_role !== 'admin') {

            header("Location ../index.php");
        } else {
            $query = "UPDATE posts SET post_views = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $reset_post_id ) . " ";
            $reset_views_query = mysqli_query($connection, $query);
            checkQuery($reset_views_query);
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=posts.php">';
        }
    }

}


?>

