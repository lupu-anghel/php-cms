<?php if(isset($_POST['create_post'])) {

	$post_title = $_POST['title'];
	$post_author = $_POST['author'];
	$post_category_id = $_POST['post_category_id'];
	$post_status = $_POST['post_status'];
	$post_image = $_FILES['image']['name'];
	$post_image_temp = $_FILES['image']['tmp_name'];
	$post_tags = $_POST['post_tags'];
	$post_content = $_POST['post_content'];
	$post_date = date('d-m-y');
	// $post_comment_count = 0;

	move_uploaded_file($post_image_temp, "../images/$post_image");

	$query= "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
	$query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";

	$create_post_query = mysqli_query($connection, $query);
	checkQuery($create_post_query);

	$the_post_id = mysqli_insert_id($connection);

	echo "<div class='alert alert-success alert-dismissible' role='alert'>
    			<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    			<strong><i class='fa fa-check-circle'></i> Your post has been created!</strong> <a href='../post.php?p_id={$the_post_id}'>View your Post here</a> or <a href='posts.php'>View All Posts</a>
    	      </div>";

} 

?>
<h3>Add new post</h3>
<hr>

<form action="" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-9">
			<div class="form-group">
				<label for "title" class='sr-only'>Post Title</label>
				<input type="text" class="form-control blog-title" name="title" placeholder="Insert your blog post title here...">
			</div>
			<div class="form-group">
				<label for "content" class='sr-only'>Post Content</label>
				<textarea class="form-control" name="post_content" id="" cols="30" rows="20"></textarea>
			</div>
		</div>
		<div class="col-md-3">

			<div class="form-group" style="margin-top: 50px;">
				<label for "title">Post Image</label>
				<input type="file" name="image">
			</div>

			<div class="form-group">
				<label for "post_category">Category</label>
				<select name="post_category_id" class="form-control">
					<option value="8">SELECT CATEGORY</option>
					<?php 

						$query = "SELECT * FROM categories WHERE cat_id != 8";
						$fetch_categories = mysqli_query($connection, $query);

						while($row = mysqli_fetch_assoc($fetch_categories)) {

							$cat_id = $row['cat_id'];
							$cat_title = $row['cat_title'];
							echo "<option value='$cat_id'>$cat_title</option>";
						}

					?>
				</select>
			</div>

			<div class="form-group">
				<label for "title">Author</label>
				<select name="author" class="form-control">
					<?php 

						if(isset($_SESSION)) {
							$default_author = $_SESSION['user_firstname'] . " " . $_SESSION['user_lastname'];
						}

					?>
					<option value="<?php echo $default_author ?>">Select Author</option>

					<?php 

						$query = "SELECT user_id, user_firstname, user_lastname FROM users where user_role != 'pending' ";

						$fetch_authors = mysqli_query($connection, $query);
						checkQuery($fetch_authors);

						while($row = mysqli_fetch_assoc($fetch_authors)) {
							$author_name = $row['user_firstname'] . " " . $row['user_lastname'];
							echo "<option value='{$author_name}'>$author_name</option>";
						}

					?>
				</select>
				<!-- <input type="text" class="form-control" name="author"> -->
			</div>

			<div class="form-group">
				<label for "title">Status</label>
				<select name="post_status" class="form-control">
					<option value="draft">SELECT STATUS</option>
					<option value="draft">Draft</option>
					<option value="published">Publish</option>
				</select>
			</div>

			<div class="form-group">
				<label for "title">Tags</label>
				<input type="text" class="form-control blog-title" name="post_tags" placeholder="Your posts tags" required>
			</div>

		</div>
	</div>


	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
	</div>

</form>