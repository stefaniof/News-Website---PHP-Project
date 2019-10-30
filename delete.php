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
        $user_type = $user['user_type'];
		
    }
	
	if ($user_type != 'admin')
	{
		$_SESSION['message'] = "<div class='info-alert'>You must have admin privilleges before viewing this page!</div>";
        header("location: error.php");
	}
	else
	{
		$id = $_GET['id'];
        
        $result = $mysqli->query("SELECT * FROM users WHERE user_id='$id'");
        $user = $result->fetch_assoc();

        $first_name = $user['first_name'];
        $last_name = $user['last_name'];

        if (isset($_POST['yes']))
        {
            if ($result->num_rows == 0)
            { 
                $_SESSION['message'] = "<div class='info-alert'>User has already been deleted!</div>";
                header("location: error.php");
            }
            else
            {
                $sql = "DELETE FROM users WHERE user_id='$id'";

                if ($mysqli->query($sql))
                {
                    $_SESSION['message'] = "<div class='info-success'>User deleted successfully</div>";
                    header("Location: success.php");
                }
                else
                {
                    $_SESSION['message'] = "<div class='info-success'>User not deleted!</div>";
                    header("Location: error.php");
                }
            }
        }
        else if (isset($_POST['no']))
        {
            header("location: admin.php");
        }
		
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
									
								
								        <form method="post">
											<h2>Are you sure you want to delete <a><?php echo $first_name." ".$last_name."?"; ?></a></h2>
											<a href="delete.php?id=<?php echo $_GET['id']; ?>"><button class="button button-block" id="yes" name="yes">Yes</button></a>
											<a href="admin.php"><button class="button button-block" id="no" name="no">No</button></a>
										</form>
									
									
									
									
									
									
									
									
									
								</section>
								<?php include 'last_posts.php'; ?>
						</div>
					</div>

				<?php include 'footer.php'; ?>