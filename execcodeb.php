<?php require 'header.php';
$type='en_gros';

$DB->insert('UPDATE productslist SET type=?', array($type));

$prod = $DB->query('SELECT * FROM productslist ');


foreach ($prod as $key => $value) {

	$codeb=$value->codeb;
	$type=$value->type;
	$id=$value->id;
	
	//$DB->insert('UPDATE productslist SET codeb = ? WHERE id = ?', array($codeb, $id));

	$DB->insert('UPDATE stock1 SET codeb = ?, type=? WHERE idprod = ?', array($codeb, $type, $id));
}