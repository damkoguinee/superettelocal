<?php require 'header.php';

$num=154;
$mdp=232;

$DB->insert("UPDATE banque SET id_banque='{$mdp}' where id_banque='{$num}'")
	;


$DB->delete('DELETE FROM bulletin WHERE nom_client = ?', array($mdp));