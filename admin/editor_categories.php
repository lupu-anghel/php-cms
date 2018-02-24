<?php include "includes/editor_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
<?php require_once "includes/editor_navigation.php";?>



        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Categories page</h3>
                        <hr>

                        <div class="row">
                            <div class="col-xs-6">

                                <?php editorInsertCategories(); ?>

                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="cat_title">Add category</label>
                                        <input type="text" class="form-control" id="cat_title" name="cat_title">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit" value="Add category" class="btn btn-primary">
                                    </div>
                                 </form>
                                 <?php 
                                    if(isset($_GET['edit'])) {
                                        include "includes/edit_categories_editor.php"; 
                                    }
                                 ?>
                            </div>

                            <div class="col-xs-6">

                                
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Category title</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php editorDisplayCategories(); ?>

                                        <?php editorDeleteCategories(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php"; ?>