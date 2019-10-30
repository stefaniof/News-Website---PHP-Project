<?php

require 'dbcon.php';
date_default_timezone_set('Europe/Bucharest');
$daten = date('Y-m-d', time());
echo $daten.'<br />';

// get real ip, even if user uses proxy
if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $userIP = $_SERVER['REMOTE_ADDR'];
}
echo $userIP;
$query = "SELECT * FROM unique_visitors WHERE access_date='$daten'";
$result = mysqli_query($mysqli, $query);// or $mysqli->query($query);



if($result->num_rows==0){
	$insertQuery = "INSERT INTO unique_visitors (access_date, ip) VALUES ('$daten','$userIP')";
	mysqli_query($mysqli, $insertQuery); 

} else {
	$row = $result->fetch_assoc();
	if(!preg_match('/'.$userIP.'/',$row['ip'])){
		$newIP = "$row[ip] $userIP";
		$updateQuery = "UPDATE unique_visitors SET ip='$newIP', views = 'views' + 1 WHERE access_date = '$daten'";
		mysqli_query($mysqli,$updateQuery);
	}
}

?>


