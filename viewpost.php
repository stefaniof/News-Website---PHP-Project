<?php 
    include 'session.php'; 

    if ($_SESSION['logged_in'] != 1)
    {
        $_SESSION['message'] = "<div class='info-alert'>You must log in before viewing full article!</div>";
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
        $active = $user['active'];
		
		$user_id = $user['user_id'];
		$postid = $_GET['id'];
		$result = $mysqli->query("SELECT * FROM posts WHERE post_id='$postid'");
		$post = $result->fetch_assoc();
		//if post does not exist redirect user.
		if($result->num_rows == 0){
			header('Location: ./');
			exit;
		}		
		$author_id = $post['author_id'];
		$title = $post['title'];
		$description = $post['description'];	
		$image = $post['image'];	
		$content = $post['content'];	
		$time = $post['time'];
		// get author name
		$result = $mysqli->query("SELECT first_name, last_name FROM users WHERE user_id='$author_id'");
		$post = $result->fetch_assoc();
		$author_fname = $post['first_name'];
		$author_lname = $post['last_name'];

		
		
		//leave new comment
		if (isset($_POST['newcomment']) && $_POST['com_content'] != "") 
		{
			$comment = $mysqli->escape_string($_POST['com_content']);				
			// insert data into database
			$sql = "INSERT INTO comments (com_authorid, com_content, post_id)" 
				."VALUES ('$user_id','$comment','$postid')";					
				if($mysqli->query($sql))
				{					
					header("Refresh:0");
				}
				else
				{
					$_SESSION['message'] = "<div class='info-alert'>Something went wrong! Please try again.</div>";						header("Location: error.php");
				}
		}
		


		//count views for each post
		$countview = $mysqli->query("SELECT * FROM postviews WHERE post_id='$postid'");
		//if post is not counted, add it to table
		if($countview->num_rows == 0){
			$sql = "INSERT INTO postviews (post_id, views) VALUES ('$postid','1')";
			$mysqli->query($sql);
		}
		else{
			$viewcount = $countview->fetch_assoc();
			$counter = $viewcount['views'] + 1;
			$sql = "UPDATE postviews SET views='$counter' WHERE post_id='$postid'";
			$mysqli->query($sql);
		}
		
    }
	
	

	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title><?= $title ?></title>
		<script src="js/validation.js" type="text/javascript"></script>
		<?php include 'header.php'; ?>

							<!-- Content -->
								<section>
									<header class="main">
										<?php echo '<h2>'.$title.'</h2>'; ?>
										<div align="right"><?php echo '<h4>Posted on '.date('jS M Y', strtotime($time)).' by '.$author_fname.' '.$author_lname.'</h4>'; ?></div>
									</header>
									
									<?php  
										if ($active == "0")
										{
											echo '<div class="info-alert">Account is unverified, please confirm your email by 
											clicking on the link sent to your email!</div>
											<a href="resend.php"><button class="button button-block" name="resend"/>Resend Link</button></a>';
											
										}
										else{
											//post content
											echo '<div>';
												echo	'<div class="box alt">
															<div class="row 50% uniform">
																<div class="3u"></div>
																<div class="6u"><span class="image fit"><img src="'.$image.'" alt="" /></span></div>
																<div class="3u"></div>
																
															</div>
														</div>';
												echo $content; 
												echo '<hr class="major" />';
											echo '</div>';
										
											//comments
											$result = $mysqli->query("SELECT * FROM comments WHERE post_id='$postid'");
											if ($result->num_rows == 0)
											{
												echo '<h3>There are no comments yet. Be the first to leave a comment! </h3>';
											}
											else
											{
												echo '<h3> Comments: </h3>';
												while($comment = $result->fetch_assoc()){
													$com_authorid = $comment['com_authorid'];
													$author_result = $mysqli->query("SELECT first_name, last_name FROM users WHERE user_id='$com_authorid'");
													$com_author = $author_result->fetch_assoc();
													
													echo '<div>';
														echo '<h4>'.$com_author['first_name'].' '.$com_author['last_name'].' commented on '.date('jS M Y H:i:s', strtotime($comment['com_date'])).':</h4>
																					<blockquote>'.$comment['com_content'].'</blockquote>';
													echo '</div>';

												}
											}

											
											echo '<hr class="major" />
											<div class="form">

												<div id="update profile">  
													<form id="newcomment" name="newcomment" method="post" autocomplete="off" enctype="multipart/form-data">
														
														<div class="field-wrap">
															<label>
																Text<span class="req">*</span>
															</label>
															<textarea name="com_content" id="com_content" rows="2"></textarea>
														</div>
														<button type="submit" class="button button-block" name="newcomment" id="newcomment"/>Leave a comment</button>
													</form>
												</div>
											</div>';	


										
										}
										
										
										
									?>
		
									
									
								</section>
								<?php include 'last_posts.php'; ?>
						</div>
					</div>

				<?php include 'footer.php'; ?>