<?php 

if(isset($_GET['p_id'])) {

	$edit_post_id = $_GET['p_id'];
	$edit_post_id = mysqli_real_escape_string($connection, $edit_post_id);
} 

$query= "SELECT * FROM posts WHERE post_id = $edit_post_id";
$select_posts_by_id = mysqli_query($connection, $query); 

    while($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
    }

    if(isset($_POST['update_post'])) {
    	$post_author = $_POST['post_author'];
    	$post_title = $_POST['post_title'];
    	$post_category_id = $_POST['post_category'];
    	$post_status = $_POST['post_status'];
    	$post_image = $_FILES['image']['name'];
    	$post_image_temp = $_FILES['image']['tmp_name'];
    	$post_content = $_POST['post_content'];
    	$post_tags = $_POST['post_tags'];

    	move_uploaded_file($post_image_temp, "../images/$post_image");

    	if(empty($post_image)) {
    		$query = "SELECT * FROM posts WHERE post_id = $edit_post_id ";

    		$select_image = mysqli_query($connection, $query);
    			while($row = mysqli_fetch_array($select_image)) {
    				$post_image = $row['post_image'];
    			}
    	}

    	$query = "UPDATE posts SET ";
    	$query .= "post_title = '{$post_title}', ";
    	$query .= "post_category_id = '{$post_category_id}', ";
    	$query .= "post_date = now(), ";
    	$query .= "post_author = '{$post_author}', ";
    	$query .= "post_status = '{$post_status}', ";
    	$query .= "post_tags = '{$post_tags}', ";
    	$query .= "post_content = '{$post_content}', ";
    	$query .= "post_image = '{$post_image}' ";
    	$query .= "WHERE post_id = {$edit_post_id} ";

    	$update_post = mysqli_query($connection, $query);
    	checkQuery($update_post);

    	echo "<div class='alert alert-success alert-dismissible' role='alert'>
    			<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    			<strong><i class='fa fa-check-circle'></i> Post successfully updated!</strong> <a href='../post.php?p_id={$edit_post_id}' target='_blank'>View Post</a>
    	      </div>";
    }

?>


<h3>Edit post page</h3>
<hr>
<form action="" method="post" enctype="multipart/form-data">

	<div class="row">
		<div class="col-md-9">
			<div class="form-group">
				<label for "title" class="sr-only">Post Title</label>
				<input value="<?php echo $post_title; ?>" type="text" class="form-control blog-title" name="post_title">
			</div>

			<div class="form-group">
				<label for "post content" class="sr-only">Post Content</label>
				<textarea class="form-control" name="post_content" id="" cols="30" rows="20"><?php echo $post_content; ?>
				</textarea>
			</div>
		</div>
		<div class="col-md-3" style="margin-top: 50px;">

			<div class="form-group">
				<label for="post image">Post image</label>
				<img src="../images/<?php echo $post_image; ?>" class="img-responsive" width="15%" height="15%">
				<input type="file" name="image">
			</div>
			<div class="form-group">
				<label for "post category" clas="sr-only">Category</label>
				<?php 

					if($post_category_id == "8") {

						echo "<p>This post has <em class='text-danger'>no category</em>, so it will ONLY be displayed on admin area. Please choose a <em class='text-danger'>category</em> below</p>";
					}

				?>
				<select name="post_category" id="" class="form-control">
					<option value="<?php echo $post_category_id; ?>">SELECT CATEGORY</option>
					<?php 

					$query = "SELECT * FROM categories WHERE cat_id != 8";
					$select_categories = mysqli_query($connection, $query);
					while($row = mysqli_fetch_assoc($select_categories)) {
						$cat_id = $row['cat_id'];
						$cat_title = $row['cat_title'];

						echo "<option value='$cat_id'>{$cat_title}</option>";
					}

					?>
				</select>
			</div>
			<div class="form-group">
				<label for "title">Author</label>
				<select name="post_author" class="form-control">
					<option value="<?php echo $post_author ?>">Select Author</option>
					<?php 

						$query = "SELECT * FROM users where user_role != 'pending' ";

						$fetch_authors = mysqli_query($connection, $query);
						checkQuery($fetch_authors);

						while($row = mysqli_fetch_assoc($fetch_authors)) {
							$post_author = $row['user_firstname'] . " " . $row['user_lastname'];
							echo "<option value='{$post_author}'>$post_author</option>";
						}

					?>
				</select>
			</div>

			<div class="form-group">
				<label for "title">Status</label>
				<?php 

				if($post_status !== "published" ) {
					echo "<p>This post is a <em class='text-danger'>draft</em>. Do you want to Publish it? Select <em>publish</em> below.</p>";
				}

				?>
				<select name="post_status" class="form-control">
					<option value="<?php echo $post_status; ?>">SELECT STATUS</option>
					<option value="draft">Draft</option>
					<option value="published">Publish</option>
				</select>
			</div>

			<div class="form-group">
				<label for "title">Tags</label>
				<input value="<?php echo $post_tags; ?>" type="text" class="form-control blog-title" name="post_tags">
			</div>


		</div>
	</div>



	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
	</div>

</form>
