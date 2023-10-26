<?php
require '_header.php';

$json = array('error' => true);
if(isset($_GET['desig'])){
	$_SESSION['product']=$_GET['desig'];// Pour faire le trie dans index	
	$product = $DB->query('SELECT id FROM products WHERE designation=:id', array('id' => $_GET['desig']));
	if(empty($product)){
		$json['message'] = "Ce produit n'existe pas";
	}else{
		$panier->add($product[0]->id);
		$panier->addu($product[0]->id);
		$json['error']  = false;
		$json['total']  = number_format($panier->total(),2,',',' ');
		$json['count']  = $panier->count();
		$json['message'] = 'Le produit a bien été ajouté à votre panier';
	}
}elseif (isset($_GET['scanneur'])) {
	$_SESSION['product']=$_GET['desig'];// Pour faire le trie dans index
	$_SESSION['scanner']=$_GET['scanneur'];	// Pour rester sur le scanner
	$product = $DB->query('SELECT id FROM products WHERE codeb=:id', array('id' => $_GET['scanneur']));
	if(empty($product)){
		$json['message'] = "Ce produit n'existe pas";
	}else{
		$panier->add($product[0]->id);
		$panier->addu($product[0]->id);
		$json['error']  = false;
		$json['total']  = number_format($panier->total(),2,',',' ');
		$json['count']  = $panier->count();
		$json['message'] = 'Le produit a bien été ajouté à votre panier';
	}
}else{
	$json['message'] = "Vous n'avez pas sélectionné de produit à ajouter au panier";
}
echo json_encode($json);
header('Location: proformat.php');
?>