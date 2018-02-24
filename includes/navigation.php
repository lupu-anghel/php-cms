<div class="container">
        <!-- Navigation -->
        <div class="row">
            <div class="col-md-8">
                <?php 

                    if(isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];

                        $status_query = "SELECT loged_in, user_firstname, user_lastname, user_role FROM users WHERE user_id = $user_id ";
                        $send_status_query = mysqli_query($connection, $status_query);

                        if(!$send_status_query) {

                            die("QUERY FAILED! " . mysqli_error($connection));
                        }

                        while($row = mysqli_fetch_array($send_status_query)) {

                            $login_status = $row['loged_in'];
                            $user_fname = $row['user_firstname'];
                            $user_lname = $row['user_lastname'];
                            $user_role = $row['user_role'];
                        }

                        if($user_role == 'admin') {
                            $url = "admin/";
                        } else {
                            $url = "admin/editor.php";
                        }


                        echo "<p class='front-admin-menu'><span><i class='fa fa-user'></i> " . $user_fname . " " . $user_lname . "</span>  
                        <span><i class='fa fa-dashboard'></i> <a href='" . $url . "'>Dashbord</a></span> <span><i class='fa fa-power-off'></i><a href='includes/logout.php?u_id=" . $user_id . "'> Logout</a></span></p>";
             
                    } else {

                        echo "";
                    }

                     

                ?>
            </div>
            <div class="col-md-4">
                <form action="search.php" method="post" class="pull-right">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control custom-search" placeholder ="Search on the blog">
                        <span class="input-group-btn ">
                            <button name="submit" class="btn btn-default custom-search-btn" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </form>
            </div>
            
        </div>
        <div class="row header-logo">
            <a href="index.php"><img src="images/logo-blog.png" class="img-responsive center" style="padding: 5px 30px;"></a>
        </div>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>

                    <?php 

                    $query = "SELECT * FROM categories WHERE cat_id != 8 ORDER BY cat_id DESC LIMIT 4";
                    $select_all_categories = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_all_categories)) {
                       $cat_title = $row["cat_title"];
                       $cat_id = $row['cat_id'];

                       echo "<li><a href='category.php?category=" . $cat_id . "'>{$cat_title}</a></li>";
                     }

                    ?>

                    <li>
                        <a href="registration.php">Register</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
</div>