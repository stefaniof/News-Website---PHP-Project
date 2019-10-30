<!-- Sidebar -->
					<div id="sidebar">
						<div class="inner">

							<!-- Login / Register -->	
								<section>
									<?php if (isset($_SESSION['logged_in']) != 1)
											{
												
												include 'logregform.php'; 
											} 
									?>
								</section>
								
							<!-- Menu -->
								<nav id="menu">
									<header class="major">
										<?php if (isset($_SESSION['logged_in']) == 1)
											{
												
												$email = $mysqli->escape_string($_SESSION['email']);
												$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
												$user = $result->fetch_assoc();

												$first_name = $user['first_name'];
												$user_type = $user['user_type'];
												
												
												echo '<h2>Howdy, '.$first_name.'!</h2>';
											}
											else {
												echo '<h2>Menu</h2>';
											}
											
										?>
									</header>
									<ul>
										<li><a href="index.php">Homepage</a></li>
										<?php if (isset($_SESSION['logged_in']) == 1 && $user_type == 'admin')
											{
												echo '<li>
														<span class="opener">Admin</span>
														<ul>
															<li><a href="post.php">New Post</a></li>
															<li><a href="admin.php">Admin Panel</a></li>
															<li><a href="report.php" target="_blank">Website Report</a></li>
														</ul>
													  </li>';
											}
											if (isset($_SESSION['logged_in']) == 1)
											{
												echo '<li><a href="profile.php">My Profile</a></li>';
											}
										?>
										<li><a href="archive.php">Archive</a></li>
										<li><a href="contact.php">Contact</a></li>
										<?php if (isset($_SESSION['logged_in']) == 1)
											{
												echo '<li><a href="logout.php">Log Out</a></li>';
											}
										?>
									</ul>
								</nav>

								
								
								
								
								
							<?php	
							$res_com = $mysqli->query("SELECT COUNT(com_id) AS comnr, title, image, description, comments.post_id as postid FROM posts JOIN comments ON posts.post_id = comments.post_id GROUP BY postid ORDER BY comnr DESC LIMIT 2");	
							
							?>
							<!-- Section -->
								<section>
									<header class="major">
										<h2>Most discussed posts</h2>
									</header>
									<div class="mini-posts">
										
										<?php
										while($compost = $res_com->fetch_assoc())
										{
											echo '<article>
													<a href="viewpost.php?id='.$compost['postid'].'" class="image"><img src="'.$compost['image'].'" alt="'.$compost['title'].'" /></a>
													<p>'.$compost['description'].'[...]</p>
												</article>';
										}
										?>
									</div>
								</section>

							

							<!-- Footer -->
								<footer id="footer">
									<p class="copyright">&copy; TechEditorial. All rights reserved.</p>
								</footer>

						</div>
					</div>

			</div>

		<!-- Scripts -->
		    <script src="js/validation.js" type="text/javascript"></script>

			<script src="js/passmeter.js" type="text/javascript"></script>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
			<script src="js/index.js"></script>			

	</body>
</html>