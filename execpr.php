<?php require 'header.php';

$prod = $DB->query('SELECT * FROM stock1');

foreach ($prod as $key => $value) {

	$pa=$value->prix_achat;
	$pr=$value->prix_revient;

	$id=$value->idprod;

	$zero=0;

	$prodverif = $DB->querys("SELECT * FROM commande where id_produit='{$id}' and prix_revient='{$zero}' ");

	if ($prodverif['prix_revient']==0 or empty($prodverif['prix_revient']) or ($prodverif['prix_revient']>$prodverif['prix_vente'])) {

		$DB->insert('UPDATE commande SET prix_revient=? WHERE id_produit = ?', array($pr, $id));
	}
}