<?php
require 'header.php';

/*

$quantite=0;
$qtiteint=0;
$nbre=0;

$products=$DB->query('SELECT id, quantite from magmadina');

$DB->delete('DELETE FROM stockmouv ');

foreach ($products as $key => $value) {

	$DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($value->id, 'report stock', 'entree', $value->quantite, 1));
}

*/

$quantite=0;
$qtiteint=0;
$stock=$_SESSION['lieuvente'];

$nomtab=$panier->nomStock($stock)[1];

$products=$DB->query("SELECT idprod as id, quantite from `".$nomtab."` ");

foreach ($products as $key => $value) {

	$prodmouv=$DB->querys("SELECT id, sum(quantitemouv) as qtitem from stockmouv where idstock='{$value->id}' and idnomstock='{$stock}'  ");

	$qtites=$value->quantite;
	$qtitem=$prodmouv['qtitem'];

	$difference=$qtites-$qtitem;

	if ($qtites!=$qtitem) {

		$DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($value->id, 'ajust', 'ajustement', $difference, $stock));
	}
}










