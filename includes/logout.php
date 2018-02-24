<?php include "db.php"; ?>

<?php session_start(); ?>

<?php 
if(isset($_GET['u_id'])) {

    $user_id = $_GET['u_id'];
    
    
    $query = "UPDATE users SET loged_in = 0 WHERE user_id = $user_id ";
    $logout_query = mysqli_query($connection, $query);
    if(!$logout_query) {

    	die('Query failed! '. mysqli_error($connection));
    }
}


$_SESSION['username'] = null;
$_SESSION['user_firstname'] = null;
$_SESSION['user_lastname'] = null;
$_SESSION['user_role'] = null;


session_destroy();
header("Location: ../signin.php");
?> 



