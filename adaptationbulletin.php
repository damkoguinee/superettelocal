<?php
require 'header.php';

//Attention sauvegarder la base de données avant de commencer

//Ajouter une colonne nbrevente dans la table catégorie
//Importer la table productslist de Abda puis vider la table
//Ajouter un champs qui sappelle name dans productslist

//renommer la table bulletin en bulletin1
//importer la table bulletin de la nouvelle version puis la vider

/*

$prodbul=$DB->query("SELECT *FROM bulletin1 ");

foreach ($prodbul as $prod) {
	

	$DB->insert('INSERT INTO bulletin (nom_client, libelles, numero, montant, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($prod->nom_client, $prod->libelles, $prod->numero, $prod->montant, 'gnf', '1', '1', $prod->date_versement));
}




$proddec=$DB->query("SELECT *FROM decaissement1 ");

foreach ($proddec as $prod) {
	

	$DB->insert('INSERT INTO decaissement (numdec, montant, devisedec, payement, numcheque, banquecheque, coment, client, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  ?)',array($prod->numdec, $prod->montant, 'gnf', $prod->payement, '', '', $prod->coment, $prod->client, 1, 1, $prod->date_payement));
}

*/

$proddecd=$DB->query("SELECT *FROM decdepense1 ");

foreach ($proddecd as $prod) {
	

	$DB->insert('INSERT INTO decdepense (numdec, categorie, montant, devisedep, payement, coment, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?,  ?)',array($prod->numdec,7, $prod->montant, 'gnf', $prod->payement, $prod->coment,1, 1, $prod->date_payement));
}
