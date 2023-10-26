<?php
require 'header.php';

$quantite=0;
$qtiteint=0;
$nbre=0;

$products=$DB->query('SELECT id, quantite, designation, name from products');

$DB->delete('DELETE FROM achat');
$DB->delete('DELETE FROM banque');
$DB->delete('DELETE FROM bulletin');
$DB->delete('DELETE FROM client');
$DB->delete('DELETE FROM cloture');
$DB->delete('DELETE FROM commande');
$DB->delete('DELETE FROM decaissement');
$DB->delete('DELETE FROM decdepense');
$DB->delete('DELETE FROM decloyer');
$DB->delete('DELETE FROM decpersonnel');
$DB->delete('DELETE FROM facture');
$DB->delete('DELETE FROM fraisup');
$DB->delete('DELETE FROM historique');
$DB->delete('DELETE FROM histpaiefrais');
$DB->delete('DELETE FROM payement');
$DB->delete('DELETE FROM personnel');

$DB->insert('UPDATE products SET quantite = ?, nbrevente=?', array($quantite, $nbre));

$DB->insert('UPDATE logo SET nbrevente=?', array($nbre));

$DB->delete('DELETE FROM proformat');
$DB->delete('DELETE FROM topclient');
$DB->delete('DELETE FROM versement');
