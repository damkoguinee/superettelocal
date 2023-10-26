<?php
require 'header.php';

//Attention sauvegarder la base de données avant de commencer

//Ajouter une colonne nbrevente dans la table catégorie
//Importer la table productslist de Abda puis vider la table
//Ajouter un champs qui sappelle name dans productslist

//renommer la table bulletin en bulletin1
//importer la table bulletin de la nouvelle version puis la vider


$products=$DB->query("SELECT *FROM categorie");

foreach ($products as $value) {
        
	$DB->insert("UPDATE productslist SET codecat=? WHERE name = ?", array($value->id, $value->nom));
}

