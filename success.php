<?php
    include 'session.php';
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Generic - Editorial by HTML5 UP</title>
		<script src="js/validation.js" type="text/javascript"></script>
		<?php include 'header.php'; ?>

							<!-- Content -->
								<section>
									<header class="main">
										<h1><?= 'Success'; ?></h1>
										
									</header>
									
																
										
										<?php 
											if (isset($_SESSION['message']) AND !empty($_SESSION['message']))
											{
												echo $_SESSION['message'];
											}
										?>
										
									
									
								</section>
								<?php include 'last_posts.php'; ?>
						</div>
					</div>

				<?php include 'footer.php'; ?>