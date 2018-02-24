<div class="well">

    <?php 

        if(isset($_SESSION)) {

            $username = $_SESSION['username'];

            echo "<h4>Welcome back ".$username."</h4>";
        }

    ?>
        
    </div>