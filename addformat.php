<?php
require '_header.php';

$date = date('y') . '0000';

$maximum = $DB->querys('SELECT max(num_cmd) AS max_id FROM proformat ');

$numero_commande =$maximum['max_id'] + 1;

$pseudo=$_SESSION['pseudo'];

$ids = array_keys($_SESSION['panier']);

	if(empty($ids)){

		$products = array();

	}else{

		$products = $DB->query('SELECT * FROM products WHERE id IN ('.implode(',',$ids).')');
	}

	foreach($products as $product){

		$name= $product->name;
		$designation=$product->designation;
		if (array_sum($_SESSION['panieru'])<=$_SESSION['limite']) {
			$price=$product->prix_vente;
		}else{
			$price= $_SESSION['panieru'][$product->id];

		}
		$quantity= $_SESSION['panier'][$product->id];
		$etat="totalite";
				
		if (isset($_POST['payer'])) {

			$DB->insert('INSERT INTO proformat (name, designation, prix_vente, quantity, num_cmd, client, vendeur, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($name, $designation, $price, $quantity,$numero_commande, $_POST['client'], $pseudo));
		}
	}

	$_SESSION['panier'] = array();
    $_SESSION['panieru'] = array();
    $_SESSION['error']=array();
    $_SESSION["seleclient"]=array();
    $_SESSION["montant_paye"]=array();
    $_SESSION['remise']=array();
    $_SESSION['product']=array();

	header("Location: ticketpro_pdf.php");
