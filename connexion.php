<?php
require '_header.php';
$_SESSION['pseudo'] = $_POST['pseudo'];
$_etat = 'connecté';

$resultat=$DB->querys('SELECT * FROM personnel WHERE pseudo = ? AND mdp=? ', array($_POST['pseudo'], $_POST['mdp'] ));

$_SESSION['lieuvente']=$resultat['lieuvente'];
$_SESSION['idpseudo']=$resultat['id'];
$_SESSION['statut']=$resultat['statut'];
$_SESSION['level']=$resultat['level'];


if (!$resultat){
	header('Location: form_connexion.php');
}else{
	
	header('Location: choix.php');
}
?>
