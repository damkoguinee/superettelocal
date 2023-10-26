<?php require 'header.php';

$prod = $DB->query('SELECT * FROM stock1');

foreach ($prod as $key => $value) {

	$id='0000-00-00';
	$id1='0001-11-30';
	$annee=date("Y")+5;
	$date=date($annee."-m-d");

	$DB->insert('UPDATE stock1 SET dateperemtion=? WHERE dateperemtion = ? or dateperemtion = ?', array($date, $id, $id1));
	
}