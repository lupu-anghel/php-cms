<?php include "includes/editor_header.php"; ?>


<?php 

    if(isset($_SESSION['user_id'])) {

       $profile_user_id = $_SESSION['user_id'];

        if($profile_user_id == 30) {

            header("Location: index.php");

        } else {

            $query = "SELECT * FROM users WHERE user_id = $profile_user_id ";
            $get_user = mysqli_query($connection, $query);


            while($row = mysqli_fetch_array($get_user)) {

                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname'];
                $username = $row['username'];
                $user_email = $row['user_email'];
                $user_role = $row['user_role'];
                $db_user_password = $row['user_password'];

            }
        }
    }

    if(isset($_POST['update_profile'])) {
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $username = $_POST['username'];
        $user_role = $_POST['user_role'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        if(empty($user_password)) {

            $user_password = $db_user_password;

        } else {

            $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
        }

        $query = "UPDATE users SET ";
        $query .= "username = '{$username}', ";
        $query .= "user_password = '{$user_password}', ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_role = '{$user_role}' ";
        $query .= "WHERE user_id = $profile_user_id ";

        $update_profile = mysqli_query($connection, $query);
        checkQuery($update_profile);

        $message = "<div class='alert alert-success alert-dismissible' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <strong><i class='fa fa-check-circle'></i> Your profile has been successfully updated!</strong>
                    </div>";

    } else {

        $message = "";
    }

?>

    <div id="wrapper">

        <!-- Navigation -->
<?php require_once "includes/editor_navigation.php";?>



        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                         <h3>Edit your profile</h3>
                         <hr>
                        

                        <form action="" method="post" enctype="multipart/form-data">
                            <?php echo $message; ?>
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

                                                if($user_role == "subscriber") {
                                                    echo "<option value='admin'>Administrator</option>";
                                                } else {
                                                    echo "<option value='subscriber'>Subscriber</option>";
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
                                        <input type="password" class="form-control" name="user_password">
                                    </div>
                                </div>
                            </div>
                            

                            



                            <!-- <div class="form-group">
                                <label for "title">Post Image</label>
                                <input type="file" class="form-control" name="image">
                            </div> -->

                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="update_profile" value="Update User">
                            </div>

                        </form>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>

  