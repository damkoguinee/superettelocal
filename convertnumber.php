<?php
require '_header.php';

if (isset($_GET['user'])) {
	$user=(string) trim($_GET['user']);
	echo number_format($user,0,',',' ');
}

//echo "string";