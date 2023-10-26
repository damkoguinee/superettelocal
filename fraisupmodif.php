<?php
//Pour les frais supplemenetaire



if (!empty($_POST['fraisup'])) {

	$datev=$datevente;

	$DB->insert('INSERT INTO fraisup (numcmd, montant, motif, client, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?)',array($numero_commande, $_POST['fraisup'], 'frais supplementaire', $numclient, $_SESSION['lieuvente'], $datev));

	$DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?)', array($_POST['compte'], -$fraisup, 'fsup'.$numero_commande, 'fsup'.$numero_commande, $_SESSION['lieuvente'], $datev));
	
}