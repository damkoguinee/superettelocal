<?php require 'header.php';

$prod = $DB->query("SELECT *FROM productslist");

foreach ($prod as $key => $value) {

    $prods = $DB->querys("SELECT *FROM stock1 where idprod='{$value->id}' ");

    if (empty($prods['id'])) {

        echo $value->designation.' ne figure pas dans la table stock1';
    }
    
}


$prod = $DB->query("SELECT *FROM stock1 ");

foreach ($prod as $key => $value) {

    $prods = $DB->querys("SELECT *FROM productslist where id='{$value->idprod}' ");

    if (empty($prods['id'])) {

        echo $value->idprod.' ne figure pas dans la table productslist';
    }
    
}
