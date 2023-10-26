<?php
require 'header.php';


$prodenseig=$DB->query('SELECT * from personnel');

foreach ($prodenseig as $value) {

	$mdp=password_hash($value->mdp, PASSWORD_DEFAULT);

	$DB->insert("UPDATE login SET mdp='{$mdp}' where identifiant='{$value->identifiant}'")
	;
}