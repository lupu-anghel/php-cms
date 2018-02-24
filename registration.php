<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php 
	if(isset($_POST['submit'])) {

		$firstname = $_POST['firstname'];
		$lastname  = $_POST['lastname'];
		$username  = $_POST['username'];
		$email     = $_POST['email'];
		$password  = $_POST['password'];

		if(!empty($firstname) && !empty($lastname) && !empty($username) && !empty($email) && !empty($password)) {

			$firstname = mysqli_real_escape_string($connection, $firstname);
			$lastname  = mysqli_real_escape_string($connection, $lastname); 
			$username  = mysqli_real_escape_string($connection, $username);
			$email     = mysqli_real_escape_string($connection, $email);
			$password  = mysqli_real_escape_string($connection, $password);

			$password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

			/*$query = "SELECT randSalt FROM users";
			$select_randsalt_query = mysqli_query($connection, $query);

			if(!$select_randsalt_query) {

				die("Query failed" . mysqli_error($connection));
			}*/

/*			$row = mysqli_fetch_array($select_randsalt_query);

			$salt = $row['randSalt'];

			$password = crypt($salt, $password);*/

			$query = "INSERT INTO users (username, user_email, user_password, user_firstname, user_lastname, user_role) ";
			$query .= "VALUES('{$username}', '{$email}', '{$password}', '{$firstname}', '{$lastname}', 'pending' )";
			$register_query = mysqli_query($connection, $query);

			if(!$register_query) {
				die("QUERY FAILED" . mysqli_error($connection) . ' ' . mysqli_errno($connection));
			}

			$message = "<div class='alert alert-success alert-dismissible' role='alert'>
    			<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    			<strong><i class='fa fa-check-circle'></i> Your registration has been submitted and it's waiting for approval.</strong> <a href='index.php'>Back to site.</a>
    	      </div>";

		} else {

			$message = "<div class='alert alert-danger alert-dismissible' role='alert'>
    			<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    			<strong><i class='fa fa-check-circle'></i> One or more fields are empty. Please fill out all the fields before submitting.</strong>
    	      </div>";

		}
	} else {
		$message  = "";
	}

?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page content -->

<section id="login">
	<div class="container">
		<div class="row">
			<div class="col-xs-6 col-xs-offset-3">
				<div class="form-wrap">
					<h1>Register</h1>
					<form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
						<h6><?php echo $message; ?></h6>
						<div class="form-group">
							<label for="firstname" class="sr-only">First Name</label>
							<input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name">
						</div>
						<div class="form-group">
							<label for="lastname" class="sr-only">Last Name</label>
							<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name">
						</div>
						<div class="form-group">
							<label for="username" class="sr-only">username</label>
							<input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
						</div>
						<div class="form-group">
							<label for="email" class="sr-only">Email</label>
							<input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
						</div>
						<div class="form-group">
							<label for="password" class="sr-only">Password</label>
							<input type="password" name="password" id="key" class="form-control" placeholder="Password">
						</div>
						<input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
					</form>
				</div>
			</div> <!-- div.col-xs-6 -->
		</div> <!-- /row -->
	</div> <!-- /container -->
</section>
<hr>

<?php include "includes/footer.php"; ?>

