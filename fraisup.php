<?php
//Pour les frais supplemenetaire



if (!empty($_POST['fraisup'])) {
	
	if (empty($datev)) {

		$DB->insert('INSERT INTO fraisup (numcmd, montant, motif, client, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, now())',array($init.$numero_commande, $fraisup, 'frais supplementaire', $numclient, $_SESSION['lieuvente']));

		$DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, now())', array($_POST['compte'], -$fraisup, 'fsup'.$init.$numero_commande, 'fsup'.$init.$numero_commande, $_SESSION['lieuvente']));


	}else{

		$DB->insert('INSERT INTO fraisup (numcmd, montant, motif, client, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?)',array($init.$numero_commande, $_POST['fraisup'], 'frais supplementaire', $numclient, $_SESSION['lieuvente'], $datev));

		$DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, now())', array($_POST['compte'], -$fraisup, 'fsup'.$init.$numero_commande, 'fsup'.$init.$numero_commande, $_SESSION['lieuvente'], $datev));

	}
}