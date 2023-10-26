<?php require 'header.php';

$prod = $DB->query('SELECT * FROM bulletin');

foreach ($prod as $key => $value) {

	$prodverif = $DB->querys("SELECT * FROM client where id='{$value->nom_client}'  ");
	/*

	$fraisup = $DB->querys("SELECT sum(prix_vente*quantity) as totalcmd, id_client FROM commande where num_cmd='{$value->num_cmd}'  ");

	$pv=$prodverif['totalcmd'];
	$tot=$value->Total;
	$difference=$tot-$pv;

	*/

	if (empty($prodverif['id'])) {?><br><?php

		echo $value->nom_client.' montant= '.$value->montant;?></br><?php

		$DB->delete('DELETE FROM bulletin WHERE nom_client = ?', array($value->nom_client));

		$DB->delete('DELETE FROM versement WHERE nom_client = ?', array($value->nom_client));

		$DB->delete('DELETE FROM decaissement WHERE client = ?', array($value->nom_client));
	}
}