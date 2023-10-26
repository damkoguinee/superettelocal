<?php require '_header.php';
    
    
	$panier->dumpMySQL("localhost", "root", "", "europe", 3);

	header("Location: choix.php");
?>