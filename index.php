<?php 

include 'session.php'; 

$res_lastp = $mysqli->query("SELECT * FROM posts ORDER BY time DESC LIMIT 1");	
$lastpost = $res_lastp->fetch_assoc();

function truncate($string,$length=300,$append="&hellip;") {
  $string = trim($string);

  if(strlen($string) > $length) {
    $string = wordwrap($string, $length);
    $string = explode("\n", $string, 2);
    $string = $string[0] . $append;
  }

  return $string;
}

?>
<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Editorial by HTML5 UP</title>
		
		
    <script src="js/validation.js" type="text/javascript"></script>
    <script src="js/showpass.js" type="text/javascript"></script>
    <script src="js/passmeter.js" type="text/javascript"></script>
		<?php include 'header.php'; ?>

							<!-- Banner -->
								<section id="banner">
									<div class="content">
										<header>
											<h2><?php echo $lastpost['title']; ?></h2>
											<div align="right"><?php echo '<h6>Posted on '.date('jS M Y H:i:s', strtotime($lastpost['time'])).'</h6>' ?></div>
										</header>
										<p><?php echo truncate($lastpost['content']); ?></p>
										<ul class="actions">
											<li><?php echo '<a href="viewpost.php?id='.$lastpost['post_id'].'" class="button big">Read More</a>'; ?></li>
										</ul>
									</div>
									<span class="image object">
										<?php echo '<img src="'.$lastpost['image'].'" alt="" />';  ?>
									</span>
								</section>

							<!-- Section -->
								<section>
									<header class="major">
										<h2>Register to:</h2>
									</header>
									<div class="features">
										<article>
											<span class="icon fa-diamond"></span>
											<div class="content">
												<h3>Have unlimited access</h3>
												<p>As a user, you can view every article on the website, free of charge! It only takes a minute, but it gives you a lifetime of reading quality technology-related articles, written by top editors.</p>
											</div>
										</article>
										<article>
											<span class="icon fa-paper-plane"></span>
											<div class="content">
												<h3>Comment on posts</h3>
												<p>Engage with our community and make your opinion known. It's both entertaining and educative.</p>
											</div>
										</article>
										<article>
											<span class="icon fa-rocket"></span>
											<div class="content">
												<h3>Stay informed</h3>
												<p>We will deliver you the latest technology news and reviews. You will have your daily dose of knowledge, that we promise!</p>
											</div>
										</article>
										<article>
											<span class="icon fa-signal"></span>
											<div class="content">
												<h3>Get promoted</h3>
												<p>By writing quality comments to our posts and by contacting us using the contact form, you can be promoted to editor.</p>
											</div>
										</article>
									</div>
								</section>

							<?php include 'last_posts.php'; ?>

						</div>
					</div>

				<?php include 'footer.php'; ?>