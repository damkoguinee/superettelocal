<?php
require '_header.php';
$_SESSION['pseudo'] = $_POST['pseudo'];
$_etat = 'connecté';
	
$connexion = $DB->querys('SELECT * FROM login WHERE pseudo =:Pseudo', 
	array('Pseudo'=>$_POST['pseudo']));

$personnel = $DB->querys('SELECT * FROM personnel WHERE pseudo =:Pseudo', 
	array('Pseudo'=>$_POST['pseudo']));

$client = $DB->querys('SELECT * FROM client WHERE telephone =?', 
	array($connexion['telephone']));

$etab=$DB->querys('SELECT *from adresse');

$_SESSION['etab']=$etab['nom_mag'];

$password=password_verify($_POST['mdp'], $connexion['mdp']);

$_SESSION['type']=$connexion['type'];

$_SESSION['lieuvente']=$connexion['lieuvente'];
$_SESSION['lieuventevers']=$connexion['lieuvente'];
$_SESSION['idpseudo']=$connexion['id'];
$_SESSION['idcpseudo']=$client['id'];
$_SESSION['statut']=$connexion['statut'];
$_SESSION['level']=$connexion['level'];

$caisse = $DB->querys('SELECT * FROM nombanque WHERE lieuvente =? and type=?', 
	array($_SESSION['lieuvente'], 'caisse'));

$_SESSION['caisse']=$caisse['id'];


if (empty($connexion)){
	header('Location:form_connexion.php');
}else{

	if (!$password){
		header('Location:form_connexion.php');

	}else{

		if ($_SESSION['type']=='client' or $_SESSION['type']=='clientf') {

			header('Location: accueilclient.php?client');

		}else{

			header('Location: choix.php');

		}

		
	}
}?>