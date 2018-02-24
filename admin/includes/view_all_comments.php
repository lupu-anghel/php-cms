<?php 

if(isset($_POST['checkBoxArray'])) {

    foreach($_POST['checkBoxArray'] as $checkBoxValue) {

        $bulk_options = $_POST['bulk_options'];

        switch($bulk_options) {

            case 'approved':

                $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$checkBoxValue} ";
                $update_to_approved = mysqli_query($connection, $query);

                checkQuery($update_to_approved);

                $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> Coment(s) successfully Approved!</strong>
              </div>";

            break;

            case 'unapproved':

                $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$checkBoxValue} ";
                $update_to_editor = mysqli_query($connection, $query);

                checkQuery($update_to_editor);

                $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> Comment(s) successfully Unapproved!</strong>
              </div>";

            break;

            case 'delete':

                $query = "DELETE FROM comments WHERE comment_id = {$checkBoxValue} ";
                $update_to_delete = mysqli_query($connection, $query);

                checkQuery($update_to_delete);

                $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> Comment(s) successfully Deleted!</strong>
              </div>";

            break;

        }
    }
} else {

    $message = "";
}

?>
<h3>View all comments page</h3>
<hr>
<form action="" method="post">
<div class="row">
    <div id="bulkContainer" class="col-md-4">

        <select name="bulk_options" class="form-control">

            <option value="">Select Options</option>
            <option value="approved">Approve</option>
            <option value="unapproved">Unapprove</option>
            <option value="delete">Delete</option>

        </select>

    </div>
    <div class="col-md-4">
        <input onClick="javascript: return confirm('Are you sure you want to apply this changes?')" type="submit" class="btn btn-success" value="Apply">
    </div>
    <div class="col-md-4">
    </div>
</div>
<?php echo $message; ?>
<div id="no-more-tables">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Email</th>
                <th>Status</th>
                <th>In Response to</th>
                <th>Date</th>
                <th>Approve</th>
                <th>Unapprove</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>

            <?php 

                $query= "SELECT * FROM comments ORDER BY comment_id DESC";
                $select_comments = mysqli_query($connection, $query); 

                while($row = mysqli_fetch_assoc($select_comments)) {
                    $comment_id = $row['comment_id'];
                    $comment_author = $row['comment_author'];
                    $comment_email = $row['comment_email'];
                    $comment_post_id = $row['comment_post_id'];
                    $comment_status = $row['comment_status'];
                    $comment_content = $row['comment_content'];
                    $comment_date = $row['comment_date'];

                    $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
                    $select_post = mysqli_query($connection, $query); 
                    while($row = mysqli_fetch_assoc($select_post)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                    }

                    echo "<tr>
                            <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='{$comment_id}'></td>
                            <td>{$comment_id}</td>
                            <td>{$comment_author}</td>
                            <td>{$comment_content}</td>
                            <td>{$comment_email}</td>
                            <td>{$comment_status}</td>
                            <td><a href='../post.php?p_id=$post_id' target='_blank'>{$post_title}</a></td>
                            <td>{$comment_date}</td>
                            <td><a href='comments.php?approve={$comment_id}'>Approve</a></td>
                            <td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>
                            <td><a href='comments.php?delete={$comment_id}'>Delete</a></td>
                          </tr>";

                }

            ?>                       
        </tbody>
    </table>
</div>


<?php

if(isset($_GET['approve'])){

    $approved_comment_id = $_GET['approve'];
    $approved_comment_id = mysqli_real_escape_string($connection, $approved_comment_id);

    if(isset($_SESSION['user_id'])) {

        $user_role = $_SESSION['user_role'];

        if($user_role !== 'admin') {

             header("Location: ../index.php");
        } else {
            $query = "UPDATE comments SET  comment_status = 'approved' WHERE comment_id = $approved_comment_id";
            $approve_comment_query = mysqli_query($connection, $query);
            checkQuery($approve_comment_query);
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=comments.php">';
        }
    } 


}


if(isset($_GET['unapprove'])){
    $unapproved_comment_id = $_GET['unapprove'];
    $unapproved_comment_id = mysqli_real_escape_string($connection, $unapproved_comment_id);

    if(isset($_SESSION['user_id'])) {

        $user_role = $_SESSION['user_role'];

        if($user_role !== 'admin') {

             header("Location: ../index.php");
        } else {

            $query = "UPDATE comments SET  comment_status = 'unapproved' WHERE comment_id = $unapproved_comment_id";
            $unapprove_comment_query = mysqli_query($connection, $query);
            checkQuery($unapprove_comment_query);
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=comments.php">';
        }
    } 

}



if(isset($_GET['delete'])){
    $delete_comment_id = $_GET['delete'];
    $delete_comment_id = mysqli_real_escape_string($connection, $delete_comment_id);

    if(isset($_SESSION['user_id'])) {

        $user_role = $_SESSION['user_role'];

        if($user_role !== 'admin') {

             header("Location: ../index.php");
        } else {

            $query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";
            $delete_comment_query = mysqli_query($connection, $query);
            checkQuery($delete_comment_query);
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=comments.php">';
        }
    } 

}

?>
