<?php

function checkQuery($result) {
    global $connection;

    if(!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function insertCategories() {

    global $connection;

	if(isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title)) {
            echo "You must add a category name";
        } else {
            $query = "INSERT INTO categories (cat_title) ";
            $query .= "VALUE('{$cat_title}')";
            $create_category_query = mysqli_query($connection, $query);
            if(!$create_category_query) {
            die('QUERY FAILED' . mysqli_error($connection));
            }
        }
    } 
}

function displayCategories() {

    global $connection;

    // Display categories and edit/delete btn
    $query = "SELECT * FROM categories";
    $categories_query = mysqli_query($connection, $query); 

    while($row = mysqli_fetch_assoc($categories_query)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr> 
                    <td>{$cat_id}</td>
                    <td>{$cat_title}</td>
                    <td><a href='categories.php?delete={$cat_id}'>Delete</a></td>
                    <td><a href='categories.php?edit={$cat_id}'>Edit</a></td>
              </tr>";
    }

}

function deleteCategories() {

    global $connection;

    // Delete categories
    if(isset($_GET['delete'])) {
        $delete_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$delete_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=categories.php">';
    }
}

function editorInsertCategories() {

    global $connection;

    if(isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if($cat_title == "" || empty($cat_title)) {
            echo "You must add a category name";
        } else {
            $query = "INSERT INTO categories (cat_title) ";
            $query .= "VALUE('{$cat_title}')";
            $create_category_query = mysqli_query($connection, $query);
            if(!$create_category_query) {
            die('QUERY FAILED' . mysqli_error($connection));
            }
        }
    } 
}

function editorDisplayCategories() {

    global $connection;

    // Display categories and edit/delete btn
    $query = "SELECT * FROM categories";
    $categories_query = mysqli_query($connection, $query); 

    while($row = mysqli_fetch_assoc($categories_query)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr> 
                    <td>{$cat_id}</td>
                    <td>{$cat_title}</td>
                    <td><a href='editor_categories.php?delete={$cat_id}'>Delete</a></td>
                    <td><a href='editor_categories.php?edit={$cat_id}'>Edit</a></td>
              </tr>";
    }

}

function editorDeleteCategories() {

    global $connection;

    // Delete categories
    if(isset($_GET['delete'])) {
        $delete_cat_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$delete_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=editor_categories.php">';
    }
}

?>