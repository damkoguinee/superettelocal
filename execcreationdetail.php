<?php require 'header.php';

$prod = $DB->query('SELECT * FROM productslist ');

foreach ($prod as $key => $value) {

	if (!empty($value->qtiteint)) {
		$type='detail';

		$prodverifdet = $DB->querys("SELECT * FROM productslist where Marque='{$value->Marque}' and type='{$type}'");

		if (empty($prodverifdet)) {
			$DB->insert('INSERT INTO productslist (Marque, designation, pventel, codecat, type) VALUES (?, ?, ?, ?, ?)', array($value->Marque, $value->designation.' det', 0, $value->codecat, 'detail'));
		}

		
	}

	if (!empty($value->qtiteintp)) {

		$type='paquet';

		$prodverifpaq = $DB->querys("SELECT * FROM productslist where Marque='{$value->Marque}' and type='{$type}'");

		if (empty($prodverifpaq)) {
			$DB->insert('INSERT INTO productslist (Marque, designation, pventel, codecat, type) VALUES (?, ?, ?, ?, ?)', array($value->Marque, $value->designation.' paq', 0, $value->codecat, 'paquet'));
		}

		
	}
}