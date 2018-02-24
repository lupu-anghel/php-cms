</div>
    <!-- /.container -->
<!-- Footer -->
        <footer>
            <div class="container">
                <div class="row" style="padding: 40px 10px;">
                    <div class="col-md-4" style="margin-top: 30px;">
                        <p style="color: #ddd; font-size: 16px; font-weight: 700;"><span class="underline">ABOU</span>T US</p>
                        <p style="color: #ddd;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                    <div class="col-md-4" style="margin-top: 30px;">
                        <p style="color: #ddd; font-size: 16px; font-weight: 700; margin-bottom: 30px;"><span class="underline">LATE</span>ST ARTICLES</p>

                        <?php 
    
                            $footer_articles_query = "SELECT post_id, post_title, post_image FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT 3";
                            $send_footer_query = mysqli_query($connection, $footer_articles_query);

                            if(!$send_footer_query) {

                                die("QUERY FAILED " . mysqli_error($connection));
                            }

                            while($row = mysqli_fetch_array($send_footer_query)) {

                                $post_id = $row['post_id'];
                                $post_title = $row['post_title'];
                                $post_image = $row['post_image'];

                                echo "<div class='row' style='margin-top: 10px;'>
                                        <div class='col-xs-3' style='padding-right: 3px;'><a href='post.php?p_id=" . $post_id . "'><img src='images/" . $post_image . "' class='img-responsive center'></a></div>
                                        <div class='col-xs-9' style='padding-left: 3px;'><a class='footer-links' href='post.php?p_id=" . $post_id . "'><p class='footer-article-title'>" . $post_title . "</p></a></div>
                                      </div>";
                            }

                        ?>

                    </div>
                    <div class="col-md-4" style="margin-top: 30px;">
                        <p style="color: #ddd; font-size: 16px; font-weight: 700; margin-bottom: 30px;"><span class="underline">BLOG</span> PHOTOS</p>
                    <div class='row'>
                        <?php 

                            $photos_query = "SELECT post_id, post_image FROM posts ORDER BY post_id DESC LIMIT 9";
                            $send_photos_query = mysqli_query($connection, $photos_query);

                            while($row = mysqli_fetch_array($send_photos_query)) {

                                $photo_id = $row['post_id'];
                                $photo_url = $row['post_image'];

                                echo "<div class='col-xs-4 footer-img'>
                                        <a href='post.php?p_id=" . $photo_id . "'><img src='images/" . $photo_url . "' class='img-responsive'></a>
                                      </div>";
                            }

                        ?>
                    </div>
                    </div>
                </div>
                <div class="row" style="border-top: solid 1px #1a343c;">
                <div class="col-lg-12">
                    <p style="text-align: center; color: #fff; padding: 20px 10px;">Copyright &copy; Mollion <?php echo date("Y"); ?> | All rights reserved.</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            </div>
            
        </footer>


    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- custom js -->
    <script type="text/javascript" src="js/scripts.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
