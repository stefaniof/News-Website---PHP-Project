<!-- Section -->
								<section>
									
									
																	
									<header class="major">
										<h2>Latest posts</h2>
									</header>
									<div class="posts">
										

									
									
									
									<?php										
										$res_data = $mysqli->query("SELECT * FROM posts ORDER BY time DESC LIMIT 6");
										while($post = $res_data->fetch_assoc())
										{
											echo '<article>';
													echo '<a href="viewpost.php?id='.$post['post_id'].'" class="image"><img src="'.$post['image'].'" alt="'.$post['title'].'" width="416" height="256" /></a>';
													echo '<h3>'.$post['title'].'</h3>';
													echo '<p>'.$post['description'].'</p>';
													echo '<ul class="actions">
																<li><a href="viewpost.php?id='.$post['post_id'].'" class="button">More</a></li>
														  </ul>';
											echo '</article>';
										}
										
									?>
									</div>
									<hr />
									<div align="center"><a href="archive.php" class="button special">See full archive</a></div>
								</section>