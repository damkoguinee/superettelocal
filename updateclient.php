<?php
require '_header.php';
/*
$prodclient = $DB->query('SELECT id, nom_client FROM client');

foreach ($prodclient as $client) {

	$prodbul = $DB->query('SELECT  nom_client FROM bulletin');

	$DB->insert('UPDATE bulletin SET nom_client=? where nom_client=?', array($client->id, $client->nom_client));

	$DB->insert('UPDATE commande SET id_client=? where client=?', array($client->id, $client->nom_client));

	$DB->insert('UPDATE decaissement SET client=? where client=?', array($client->id, $client->nom_client));

	$DB->insert('UPDATE historique SET nom_client=? where nom_client=?', array($client->id, $client->nom_client));

	$DB->insert('UPDATE payement SET num_client=?, client=? where client=?', array($client->id, $client->id, $client->nom_client));

	$DB->insert('UPDATE versement SET nom_client=? where nom_client=?', array($client->id, $client->nom_client));

	$DB->insert('UPDATE achat SET fournisseur=? where fournisseur=?', array($client->id, $client->nom_client));	
}
*/

$prodclient = $DB->query('SELECT id FROM versement');

foreach ($prodclient as $client) {

	$DB->insert('UPDATE versement SET numcmd=? where id=?', array('dep'.$client->id, $client->id));
}


