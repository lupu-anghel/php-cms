<?php if(isset($_POST['create_user'])) {

	$user_firstname = $_POST['user_firstname'];
	$user_lastname  = $_POST['user_lastname'];
	$user_role      = $_POST['user_role'];
	$username       = $_POST['username'];
	$user_email     = $_POST['user_email'];
	$user_password  = $_POST['user_password'];

	$user_firstname = mysqli_real_escape_string($connection, $user_firstname);
	$user_lastname  = mysqli_real_escape_string($connection, $user_lastname);
	$user_role      = mysqli_real_escape_string($connection, $user_role);
	$username       = mysqli_real_escape_string($connection, $username);
	$user_email     = mysqli_real_escape_string($connection, $user_email);
	$user_password  = mysqli_real_escape_string($connection, $user_password);

	$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

	/*$post_image = $_FILES['image']['name'];
	$post_image_temp = $_FILES['image']['tmp_name'];*/
	/*$post_tags = $_POST['post_tags'];
	$post_content = $_POST['post_content'];
	$post_date = date('d-m-y');*/

	/*move_uploaded_file($post_image_temp, "../images/$post_image");*/

	$query= "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_role) ";
	$query .= "VALUES('{$username}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_role}')";

	$create_user_query = mysqli_query($connection, $query);
	checkQuery($create_user_query);

	echo "<p class='alert alert-success'> <i class='fa fa-check'></i>User created: " ."<a href='users.php'>View Users</a></p>";

} 

?>

<h3>Add new user</h3>
<hr>

<form action="" method="post" enctype="multipart/form-data" style="height: 100%">

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for "first name" class="sr-only">First Name</label>
				<input type="text" class="form-control blog-title" name="user_firstname" placeholder="*First Name..." required>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for "last name" class="sr-only">Last Name</label>
				<input type="text" class="form-control blog-title" name="user_lastname" placeholder="*Last Name..." required>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for "username" class="sr-only">Username</label>
				<input type="text" class="form-control blog-title" name="username" placeholder="*Username..." required>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for "user_role" class="sr-only">User Role</label>
				<select name="user_role" class="form-control blog-title">
					<option value="editor">SELECT USER ROLE</option>
					<option value="editor">Editor</option>
					<option value="admin">Administrator</option>
				</select>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for "email" class="sr-only">Email</label>
				<input type="text" class="form-control blog-title" name="user_email" placeholder="*User's email..." required>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for "password" class="sr-only">Password</label>
				<input type="password" class="form-control blog-title" name="user_password" placeholder="*User's password..." required>
			</div>
		</div>
	</div>


	<!-- <div class="form-group">
		<label for "title">Post Image</label>
		<input type="file" class="form-control" name="image">
	</div> -->



	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="create_user" value="Add User">
	</div>

</form>
