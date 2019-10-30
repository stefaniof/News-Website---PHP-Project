<?php 
    include 'session.php'; 
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
			$page = 1;
			}
	$limit = 6;										
	$start_from = ($page-1) * $limit;
	$result = $mysqli->query('SELECT COUNT(*) FROM posts');
	$total_rows = mysqli_fetch_array($result)[0];
	$total_pages = ceil($total_rows / $limit);
	$res_data = $mysqli->query("SELECT * FROM posts ORDER BY time DESC LIMIT $start_from, $limit");	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Archive</title>
		<script src="js/validation.js" type="text/javascript"></script>
		<?php include 'header.php'; ?>

							<!-- Content -->
								<section>
									<header class="main">
										<h1>Archive</h1>
									</header>
									
									<?php
										while($post = $res_data->fetch_assoc()){
												//get author name
												$author_id = $post['author_id'];
												$author_name= $mysqli->query("SELECT first_name, last_name FROM users WHERE user_id='$author_id'");
												$aname = $author_name->fetch_assoc();
												$author_fname = $aname['first_name'];
												$author_lname = $aname['last_name'];
											
												echo '<div class="row">
											<div class="4u 12u$(small)">
												<p><span class="image fit"><a href="viewpost.php?id='.$post['post_id'].'" class="image"><img src="'.$post['image'].'" alt="'.$post['title'].'" width="416" height="256" /></a></span></p>
											</div>
											<div class="8u$ 12u$(small)">
												<h3 id="content"><a href="viewpost.php?id='.$post['post_id'].'">'.$post['title'].'</a></h3>
												<h6>Posted on '.date('jS M Y H:i:s', strtotime($post['time'])).' by '.$author_fname.' '.$author_lname.'</h6>
												<p>'.$post['description'].'[...]</p>';
												echo '<p><a href="viewpost.php?id='.$post['post_id'].'" class="button special">Read More</a></p> </div></div>';
												echo '<hr />';		
											

										}

									
									?>	
									
									

									<div align="center"> <ul class="pagination">
										<li><a href="?page=1" class="prev">First</a></li>
										<li class="<?php if($page <= 1){ echo 'disabled'; } ?>">
											<a href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>">Prev</a>
										</li>
										<li class="<?php if($page >= $total_pages){ echo 'disabled'; } ?>">
											<a href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">Next</a>
										</li>
										<li><a href="?page=<?php echo $total_pages; ?>">Last</a></li>
									</ul>
									</div>
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
									
								</section>
						</div>
					</div>

				<?php include 'footer.php'; ?>