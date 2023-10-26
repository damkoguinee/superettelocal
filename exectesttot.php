<?php require 'header.php';

$prod = $DB->query('SELECT * FROM commande order by(id_produit)');

foreach ($prod as $key => $value) {

	$prodverif = $DB->querys("SELECT * FROM productslist where id='{$value->id_produit}'  ");
	/*

	$fraisup = $DB->querys("SELECT sum(prix_vente*quantity) as totalcmd, id_client FROM commande where num_cmd='{$value->num_cmd}'  ");

	$pv=$prodverif['totalcmd'];
	$tot=$value->Total;
	$difference=$tot-$pv;

	*/

	if (empty($prodverif['id'])) {?><br/>

		<div style="font-weight: bold;"><?=$value->id_produit.' client= '.$panier->nomClient($value->id_client).' numero= '.$value->num_cmd.' prix de vente '.number_format($value->prix_vente,0,',',' ').' manquant '.number_format($value->prix_vente*$value->quantity,0,',',' ');?></div><?php
	}
}