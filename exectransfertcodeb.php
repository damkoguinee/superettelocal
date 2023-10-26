<?php require 'header.php';

$type='en_gros';

$prod = $DB->query("SELECT * FROM productslist where type='{$type}'");

$type1='paquet';

$DB->insert("UPDATE productslist SET codeb = ? WHERE type=?", array('', $type));

$DB->insert("UPDATE btnnongo SET codeb = ? WHERE type=?", array('', $type));

$DB->insert("UPDATE productslist SET codeb = ? WHERE type=?", array('', $type1));

$DB->insert("UPDATE btnnongo SET codeb = ? WHERE type=?", array('', $type1));
