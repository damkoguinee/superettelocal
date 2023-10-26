<?php
//Pour les frais supplemenetaire

$_SESSION['fraisup']=array();

if (!empty($_POST['fraisup'])) {

	$_SESSION['fraisup']=$_POST['fraisup'];

	$DB->insert('INSERT INTO decaissement (numcmd, montant, payement, motif, client, etat, date_payement) VALUES(?, ?, ?, ?, ?, ?, now())', array($numero_commande, $_POST['fraisup'],  $_POST['mode_payement'], 'frais marchandises stock->magasin ', 'stock', 'clos'));

	$DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($numclient, -$_POST['fraisup'], "frais supplementaire", $numero_commande));
}