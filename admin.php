<?php 
    require 'includes/dbcon.php';
	session_start();

    if ($_SESSION['logged_in'] != 1)
    {
        $_SESSION['message'] = "<div class='info-alert'>You must log in before viewing this page!</div>";
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
		$user_type = $user['user_type'];
		
    }
	
	if ($user_type != 'admin')
	{
		$_SESSION['message'] = "<div class='info-alert'>You must have admin privilleges before viewing this page!</div>".$user_type;
        header("location: error.php");
	}
	
	
	
	
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Welcome <?= $first_name.' '.$last_name ?></title>
		<script src="js/validation.js" type="text/javascript"></script>
		<?php include 'header.php'; ?>

							<!-- Content -->
								<section>
									<header class="main">
										<h1>Admin Panel</h1>
									</header>
									
								<div class="row">
											<div class="8u 12u$(small)">
												<h3>Most viewed posts</h3>
												<table class="alt">
															<thead>
																<tr>
																	<th>Rank</th>
																	<th>Title</th>
																	<th>Author</th>
																	<th>Views</th>
																</tr>
															</thead>
															<tbody>
															<?php
																$rank = 0;
																$result= $mysqli->query("SELECT postviews.post_id as postid, postviews.views as views, posts.author_id, posts.title as title, users.first_name as fname, 	users.last_name as lname
																						FROM postviews
																						INNER JOIN posts ON postviews.post_id = posts.post_id
																						INNER JOIN users ON posts.author_id = users.user_id
																						ORDER BY views DESC LIMIT 5") or die($mysqli->error());
																if ($result->num_rows > 0)
																{
																	while ($row = $result->fetch_assoc()) 
																	{ 
															?>
																<tr>
																	<td>
																		<?php echo $rank+=1; ?>
																	</td>
																	<td>
																		<?php 
																			$post_id = $row['postid'];
																			$post_title = $row['title'];
																			$author_fname = $row['fname'];
																			$author_lname = $row['lname'];
																			echo '<a href="viewpost.php?id='.$post_id.'">'.$post_title.'</a>'; ?>
																	</td>
																	<td>
																		<?php echo $author_fname.' '.$author_lname; ?>
																	</td>
																	<td>
																		<?php echo $row['views']; ?>
																	</td>
																	
																	
																</tr>
															<?php 
																	} 
																}
															?>
															</tbody>
												</table>
											</div>
											<div class="4u$ 12u$(small)">
												<h3>Top commenters</h3>
												<table class="alt">
															<thead>
																<tr>
																	<th>Rank</th>
																	<th>First name</th>
																	<th>Last name</th>
																	<th>Comments</th>
																</tr>
															</thead>
															<tbody>
															<?php
																$rank = 0;
																$result= $mysqli->query("SELECT COUNT(comments.com_id) AS comnr, comments.com_authorid, users.first_name as fname, users.last_name as lname 
																						FROM comments 
																						INNER JOIN	users ON comments.com_authorid = users.user_id
																						GROUP BY com_authorid ORDER BY comnr DESC LIMIT 7;") or die($mysqli->error());
																if ($result->num_rows > 0)
																{
																	while ($row = $result->fetch_assoc()) 
																	{ 
															?>
																<tr>
																	<td>
																		<?php echo $rank+=1; ?>
																	</td>
																	<td>
																		<?php echo $row['fname']; ?>
																	</td>
																	<td>
																		<?php echo $row['lname']; ?>
																	</td>
																	<td>
																		<?php echo $row['comnr']; ?>
																	</td>
																	
																	
																</tr>
															<?php 
																	} 
																}
															?>
															</tbody>
												</table>
											</div>
								</div>
								<hr class="major" />
								<div class="table-wrapper">
									<h3>Manage users</h3>
														<table>
															<thead>
																<tr>
																	<th>User ID</th>
																	<th>First Name</th>
																	<th>Last Name</th>
																	<th>Email</th>
																	<th>Active</th>
																	<th>Promote</th>
																	<th>Delete</th>
																</tr>
															</thead>
															<tbody>
															<?php 
																$result= $mysqli->query("SELECT * FROM users WHERE email != 'ion246662@gmail.com'") or die($mysqli->error());
																if ($result->num_rows > 0)
																{
																	while ($row = $result->fetch_assoc()) 
																	{ 
															?>
																<tr>
																	<td>
																		<?php echo $row['user_id']; ?>
																	</td>
																	<td>
																		<?php echo $row['first_name']; ?>
																	</td>
																	<td>
																		<?php echo $row['last_name']; ?>
																	</td>
																	<td>
																		<?php echo $row['email']; ?>
																	</td>
																	<td>
																		<?php if ($row['active']=='0') { echo 'No'; } else { echo 'Yes'; } ?>
																	</td>
																	<td>
																		<?php if ($row['user_type']=='regular') { echo '<a href="promote.php?id='.$row['user_id'].'">Make admin</a>'; } else { echo 'Admin'; } ?>
																	</td>
																	<td>
																		<?php echo '<a href="delete.php?id='.$row['user_id'].'">Delete</a>'; ?>
																	</td>
																	
																</tr>
															<?php 
																	} 
																}
															?>
															</tbody>
														</table>
								</div>
								
			



            
            

       
									
									
								</section>
								<?php include 'last_posts.php'; ?>
						</div>
					</div>

				<?php include 'footer.php'; ?>