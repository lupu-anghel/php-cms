<form action="" method="post">
                                    <div class="form-group">
                                        <label for="cat_title">Edit category</label>

                                        <?php

                                            if(isset($_GET['edit'])) {
                                                $cat_id = $_GET['edit'];
                                                $query = "SELECT * FROM categories WHERE cat_id = {$cat_id}";
                                                $select_category = mysqli_query($connection, $query);

                                                while($row = mysqli_fetch_assoc($select_category)) {
                                                    $cat_id = $row['cat_id'];
                                                    $cat_title = $row['cat_title'];

                                                    ?>

                                                    <input type="text" value="<?php if(isset($cat_title)) {echo $cat_title;} ?>"class="form-control" id="cat_title" name="edit_cat_title">

                                               <?php }
                                            } ?>

                                            <?php 
                                            // update query
                                                if(isset($_POST['update_category'])) {
                                                    $edit_cat_title = $_POST['edit_cat_title'];
                                                    $edit_cat_id = $_GET['edit'];
                                                    if($edit_cat_title="" || empty($edit_cat_title)) {
                                                        $edit_cat_title = $cat_title;
                                                    } else {
                                                        $edit_cat_title = $_POST['edit_cat_title'];
                                                    }
                                                    $query = "UPDATE categories SET cat_title = '{$edit_cat_title}' WHERE cat_id = '{$edit_cat_id}'";
                                                    $edit_query = mysqli_query($connection, $query);
                                                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=categories.php">';
                                                    if(!$edit_query) {
                                                        echo "QUERY FAILED".mysqli_error($edit_query) ;
                                                    }
                                                }
                                            ?>

                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="update_category" value="Update category" class="btn btn-primary">
                                    </div>
                                 </form>