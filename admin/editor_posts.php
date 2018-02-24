<?php include "includes/editor_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
<?php require_once "includes/editor_navigation.php";?>



        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">

                        <?php 

                            if(isset($_GET['source'])) {
                                $source = $_GET['source'];
                            } else {
                                $source = '';
                            }

                            switch($source) {

                                case 'editor_add_post';
                                include "includes/editor_add_post.php";
                                break;

                                case 'edit_post_editor';
                                include "includes/edit_post_editor.php";
                                break;

                                default:
                                include "includes/editor_view_all_posts.php";
                                break;
                            }

                        ?>
                        

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>

  