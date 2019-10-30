<?php 
    

	require 'includes/dbcon.php';
	session_start();

    if ($_SESSION['logged_in'] != 1)
    {
        $_SESSION['message'] = "<div class='info-alert'>You must log in as admin before being able to post new articles!</div>";
        header("location: error.php");    
    }
    else
    {
        $email = $mysqli->escape_string($_SESSION['email']);
        $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
        $user = $result->fetch_assoc();

        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $email = $user['email'];
        $user_id = $user['user_id'];
		$user_type = $user['user_type'];
    
	
		if($user_type != 'admin')
		{
	        $_SESSION['message'] = "<div class='info-alert'>You must log in as admin before being able to post new articles!</div>";
			header("location: error.php");
		}
		
		//create new post
		elseif (isset($_POST['new_post']) && $_POST['title'] != "" && $_POST['description'] != "" && $_POST['content'] != "") 
		{
			$_SESSION['message'] = "";
			$title = $mysqli->escape_string($_POST['title']);
			$description = $mysqli->escape_string($_POST['description']);
			$content = $mysqli->escape_string($_POST['content']);
			//$image = $mysqli->escape_string($_POST['image']);

			
			//upload image

			
			$target_dir = "images/";
			$imglocation = "images/default.jpg";
			$target_file = $target_dir . basename($_FILES["upimage"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			if(isset($_POST["upimage"])) {
				$check = getimagesize($_FILES["upimage"]["tmp_name"]);
				if($check !== false) {
					$uploadOk = 1;
				} else {
					$_SESSION['message'] = "<div class='info-alert'>File is not an image.</div>";
					$uploadOk = 0;
				}
			
				// Check if file already exists
				if (file_exists($target_file)) {
					$_SESSION['message'] = "<div class='info-alert'>Sorry, file not uploaded because it already exists.</div>";
					$uploadOk = 0;
					$imglocation = $target_file;
				}
				// Check file size
				if ($_FILES["upimage"]["size"] > 500000) {
					$_SESSION['message'] = "<div class='info-alert'>Sorry, your file is too large.</div>";
					$uploadOk = 0;
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
					$_SESSION['message'] = "<div class='info-alert'>No file was uploaded. Only JPG, JPEG, PNG & GIF files are allowed.</div>";
					$uploadOk = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 1) {
					if (move_uploaded_file($_FILES["upimage"]["tmp_name"], $target_file)) {
						$imglocation = "images/".basename( $_FILES["upimage"]["name"])."";
					} else {
						$_SESSION['message'] = "<div class='info-alert'>Sorry, there was an error uploading your file.</div>";
					}
				}
			}
			else {
				$_SESSION['message'] = "<div class='info-alert'>No image was uploaded.</div>";
			}
			
			// insert data into database
			$sql = "INSERT INTO posts (title, description, content, image, author_id)" 
				."VALUES ('$title','$description','$content','$imglocation', '$user_id')";
				
				if($mysqli->query($sql))
				{
					$_SESSION['message'] = $_SESSION['message']." <div class='info-success'> New post created successfully</div>";
					header("location: success.php");
				}
				else
				{
					$_SESSION['message'] = "<div class='info-alert'>Something went wrong! Please try again.</div>";
					header("Location: error.php");
				}
		}
	
	
	
	
	}
	
	
	
	
	
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Publish new post</title>
		<script src="js/validation.js" type="text/javascript"></script>
		<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
		<script>
				tinymce.init({
					selector: "textarea",
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen",
						"insertdatetime media table contextmenu paste"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
		</script>
		<?php include 'header.php'; ?>

							<!-- Content -->
								<section>
									<header class="main">
										<h1>Create a new post</h1>
									</header>
									
																
									
									
									<!-- Create new post -->
									<div class="form">

										<div id="update profile">  
											<form id="newpost" name="newpost" method="post" autocomplete="off" enctype="multipart/form-data">
												<div class="field-wrap">
													<label>
														Title<span class="req">*</span>
													</label>
													<input type="text" autocomplete="off" name="title" id="title"/>
												</div>          
												<div class="field-wrap">
													<label>
														Description<span class="req">*</span>
													</label>
												<input type="text" autocomplete="off" name="description" id="description"/>
												</div>
												<div class="field-wrap">
													<input type="file" name="upimage" id="upimage">
													
												</div>
												<div class="field-wrap">
													<label>
														Text<span class="req">*</span>
													</label>
													<textarea name="content" id="content" rows="10"></textarea>
												</div>
												<button type="submit" class="button button-block" name="new_post" id="new_post"/>Publish new post</button>
											</form>
										</div>
									</div>
									
									
									
									
									
									
									
									
								
									
									
									
									
									
									
									
									
									
									
									
									
									
									
								</section>
								<?php include 'last_posts.php'; ?>
						</div>
					</div>

				<?php include 'footer.php'; ?>