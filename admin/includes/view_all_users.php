<?php 

if(isset($_POST['checkBoxArray'])) {

    foreach($_POST['checkBoxArray'] as $checkBoxValue) {

        $bulk_options = $_POST['bulk_options'];

        switch($bulk_options) {

            case 'approve':

                $query = "UPDATE users SET user_role = 'editor' WHERE user_id = {$checkBoxValue} AND user_id != 30 ";
                $update_to_approved = mysqli_query($connection, $query);

                checkQuery($update_to_approved);

                $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> User(s) approved, user(s) role changed to editor!</strong>
              </div>";

            break;

            case 'editor':

                $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$checkBoxValue} AND user_id != 30 ";
                $update_to_editor = mysqli_query($connection, $query);

                checkQuery($update_to_editor);

                $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> User(s) role changed to Editor!</strong>
              </div>";

            break;

            case 'admin':

                $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$checkBoxValue} AND user_id != 30";
                $update_to_admin = mysqli_query($connection, $query);

                checkQuery($update_to_admin);

                $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> User(s) role changed to Admin!</strong>
                </div>";
            
            break;

            case 'delete':

                $query = "DELETE FROM users WHERE user_id = {$checkBoxValue} AND user_id != 30 ";
                $update_to_delete = mysqli_query($connection, $query);

                checkQuery($update_to_delete);

                $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> User(s) successfully Deleted!</strong>
              </div>";

            break;

        }
    }
} else {

    $message = "";
}

?>



<h3>View all users page</h3>
<hr>
<form action="" method="post">
    <div class="row">
        <div id="bulkContainer" class="col-md-4">

            <select name="bulk_options" class="form-control">

                <option value="">Select Options</option>
                <option value="approve">Approve</option>
                <option value="editor">Make Editor</option>
                <option value="admin">Make Admin</option>
                <option value="delete">Delete</option>

            </select>

        </div>
        <div class="col-md-4">
            <input onClick="javascript: return confirm('Are you sure you want to apply this changes?')" type="submit" class="btn btn-success" value="Apply">
            <a href="users.php?source=add_user" class="btn btn-primary">Add New</a>
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
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Make Admin</th>
                    <th>Make Editor</th>
                    <th>Edit</th>
                    <th>Delete</th>

                </tr>
            </thead>
            <tbody>

                <?php 

                    $query= "SELECT * FROM users ORDER BY user_id DESC";
                    $select_users = mysqli_query($connection, $query); 

                    while($row = mysqli_fetch_assoc($select_users)) {
                        $user_id = $row['user_id'];
                        $username = $row['username'];
                        $user_password = $row['user_password'];
                        $first_name = $row['user_firstname'];
                        $last_name = $row['user_lastname'];
                        $user_email = $row['user_email'];
                        $user_role = $row['user_role'];
                        $user_image = $row['user_image'];

                        echo "<tr>
                                <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='{$user_id}'></td>
                                <td>{$user_id}</td>
                                <td>{$username}</td>
                                <td>{$first_name}</td>
                                <td>{$last_name}</td>
                                <td>{$user_email}</td>
                                <td>{$user_role}</td>
                                <td><a href='users.php?make_adm={$user_id}'>Make Admin</a></td>
                                <td><a href='users.php?make_edit={$user_id}'>Make Editor</a></td>
                                <td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>
                                <td><a onClick=\"javascript: return confirm('Are you sure you want to delete this user?')\" href='users.php?delete={$user_id}'>Delete</a></td>
                              </tr>";

                    }

                ?>                       
            </tbody>
        </table>
    </div>
</form>


<?php

if(isset($_GET['make_adm'])){
    $admin_id = $_GET['make_adm'];

    if($admin_id == 30) {

        echo "<script>alert('You are not allowed to delete or modify this user!')</script>";
        
    } else {
        $query = "UPDATE users SET  user_role = 'admin' WHERE user_id = $admin_id";
        $make_adm_query = mysqli_query($connection, $query);
        checkQuery($make_adm_query);
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=users.php">';
    }

}


if(isset($_GET['make_edit'])){
    $editor_id = $_GET['make_edit'];

    if($editor_id == 30) {

        echo "<script>alert('You are not allowed to delete or modify this user!')</script>";
        
    } else {
        $query = "UPDATE users SET  user_role = 'editor' WHERE user_id = $editor_id";
        $make_editor_query = mysqli_query($connection, $query);
        checkQuery($make_editor_query);
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=users.php">';
    }

    

}



if(isset($_GET['delete'])){
    $delete_user_id = $_GET['delete'];

    if($delete_user_id == 30) {

        echo "<script>alert('You are not allowed to delete or modify this user!')</script>";
        
    } else {

        $query = "DELETE FROM users WHERE user_id = {$delete_user_id}";
        $delete_user_query = mysqli_query($connection, $query);
        checkQuery($delete_user_query);
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=users.php">';
    }


}

?>
