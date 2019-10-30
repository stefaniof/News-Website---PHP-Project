<?php
    include 'session.php';
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Generic - Editorial by HTML5 UP</title>
		<script src="js/validation.js" type="text/javascript"></script>
		<script>
        function goBack()
        {
            window.history.back();
        }
		</script>
		<?php include 'header.php'; ?>

							<!-- Content -->
								<section>
									<header class="main">
										<h1>Error</h1>
										
									</header>
									
																
										
										<p>
										<?php 
											if (isset($_SESSION['message']) AND !empty($_SESSION['message']))
											{ 
												echo $_SESSION['message'];
											}
										?>
										</p>
										<button class="button button-block" onclick="goBack();"/>Back</button>
										
										
									
									
								</section>
								<?php include 'last_posts.php'; ?>
						</div>
					</div>

				<?php include 'footer.php'; ?>