<?php
    session_start();
    session_unset();
    session_destroy(); 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <?php include 'css/css.html'; ?>
	<script>
        function goBack()
        {
            window.history.back();
        }
	</script>
</head>
<body>
    <div class="form">
        <?php 
            setcookie('email', $_POST['email'], 1);
            setcookie('password', password_hash($_POST['password'], PASSWORD_BCRYPT), 1);
          	header('Location: ' . $_SERVER['HTTP_REFERER']);
        ?>
    </div>
</body>
</html>