<?php 

if(isset($_GET['u_id'])) {

	$edit_user_id = $_GET['u_id'];

    if($edit_user_id == 30) {

        header("Location: index.php");
    } else {

        $query= "SELECT * FROM users WHERE user_id = $edit_user_id ";
        $select_users_by_id = mysqli_query($connection, $query); 

        while($row = mysqli_fetch_assoc($select_users_by_id)) {
            $user_id        = $row['user_id'];
            $user_firstname = $row['user_firstname'];
            $user_lastname  = $row['user_lastname'];
            $username       = $row['username'];
            $user_email     = $row['user_email'];
            $user_password  = $row['user_password'];
            $user_role      = $row['user_role'];

        }

    }

}

    if(isset($_POST['edit_user'])) {
    	$user_firstname = $_POST['user_firstname'];
        $user_lastname  = $_POST['user_lastname'];
        $username       = $_POST['username'];
        $user_email     = $_POST['user_email'];
        $user_password  = $_POST['user_password'];
        $user_role      = $_POST['user_role'];

        $user_firstname = mysqli_real_escape_string($connection, $user_firstname);
        $user_lastname  = mysqli_real_escape_string($connection, $user_lastname);
        $username       = mysqli_real_escape_string($connection, $username);
        $user_email     = mysqli_real_escape_string($connection, $user_email);
        $user_password  = mysqli_real_escape_string($connection, $user_password);
        $user_role      = mysqli_real_escape_string($connection, $user_role);

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

    	$query = "UPDATE users SET ";
        $query .= "username = '{$username}', ";
        $query .= "user_password = '{$user_password}', ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .="user_role = '{$user_role}' ";
        $query .="WHERE user_id = $edit_user_id ";

    	$update_user = mysqli_query($connection, $query);
    	checkQuery($update_user);

        echo "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><i class='fa fa-check-circle'></i> User successfully updated!</strong>
              </div>";
    }

?>

<h3>Edit <em><?php echo $user_firstname . " " . $user_lastname; ?></em> profile information</h3>
<hr>

<form action="" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for "first name">First Name</label>
                <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for "last name">Last Name</label>
                <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for "username">Username</label>
                <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for "user_role">User Role</label>
                <select name="user_role" class="form-control">
                    <option value="<?php echo $user_role; ?>">Change user role</option>
                    <?php 

                        if($user_role == "pending") {
                            echo "<option value='editor'>Editor</option>
                                  <option value='admin'>Admin</option>";
                        } else if($user_role == "editor") {
                            echo "<option value='admin'>Admin</option>";
                        } else {
                            echo "<option value='editor'>Editor</option>";
                        }

                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for "email">Email</label>
                <input type="text" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for "password">Password</label>
                <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
            </div>
        </div>
    </div>



	<!-- <div class="form-group">
		<label for "title">Post Image</label>
		<input type="file" class="form-control" name="image">
	</div> -->



	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
	</div>

</form>
