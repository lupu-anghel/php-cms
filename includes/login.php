<?php include "db.php"; ?>
<?php session_start(); ?>

<?php 

if(isset($_POST['login'])) {

	$username = $_POST['username'];
	$password = $_POST['password'];

	$username = mysqli_real_escape_string($connection, $username);
	$password = mysqli_real_escape_string($connection, $password);

	$query = "SELECT * FROM users WHERE username = '{$username}'";

	$select_user_query = mysqli_query($connection, $query);

	if(!$select_user_query) {
		die("QUERY FAILED " . mysqli_error($connection));
	}

	while($row = mysqli_fetch_array($select_user_query)) {

		$user_id = $row['user_id'];
		$user_firstname = $row['user_firstname'];
		$user_lastname = $row['user_lastname'];
		$user_role = $row['user_role'];
		$db_username = $row['username'];
		$user_password = $row['user_password'];
		$loged_in = $row['loged_in'];
	}
		if(password_verify($password, $user_password) && $user_role  !== 'pending') {
			
			$_SESSION['username'] = $db_username;
			$_SESSION['user_firstname'] = $user_firstname;
			$_SESSION['user_lastname'] = $user_lastname;
			$_SESSION['user_role'] = $user_role;
			$_SESSION['user_id'] = $user_id;

			$login_query = "UPDATE users SET loged_in = 1 WHERE user_id = {$user_id} ";
			$send_login_query = mysqli_query($connection, $login_query);

			if(!$send_login_query) {
				die("Query failed!") . mysqli_error($connection);
			}

			$_SESSION['loged_in'] = $loged_in;

			if($user_role == 'admin') {

				header("Location: ../admin");

			} else if ($user_role == 'editor') {

				header("Location: ../admin/editor.php");
			} else {

				header("Location: ../index.php");
			}
			

		} else {
			$loged_in = false;
			header("Location: ../index.php");
		}
	
}

?>


