<?php
require '_header.php';

$nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];

$json = array('error' => true);
if(isset($_GET['desig'])){
	$_SESSION['productu']=$_GET['desig'];
	$product = $DB->query("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id WHERE designation=:id", array('id' => $_GET['desig']));
	if(empty($product)){
		$json['message'] = "Ce produit n'existe pas";
	}else{
		$panier->addstock($product[0]->id);
		$json['error']  = false;
		$json['total']  = number_format($panier->total(),2,',',' ');
		$json['count']  = $panier->count();
		$json['message'] = 'Le produit a bien été ajouté à votre panier';
	}
}elseif (isset($_GET['scanneur'])) {
	$_SESSION['productu']=$_GET['desig'];// Pour faire le trie dans index
	$_SESSION['scanneru']=$_GET['scanneur'];	// Pour rester sur le scanner
	$product= $DB->query("SELECT id FROM `".$nomtab."` WHERE codeb=:id", array('id' => $_GET['scanneur']));
	if(empty($product)){
		$json['message'] = "Ce produit n'existe pas";
	}else{
		$panier->addstock($product[0]->id);
		$json['error']  = false;
		$json['total']  = number_format($panier->total(),2,',',' ');
		$json['count']  = $panier->count();
		$json['message'] = 'Le produit a bien été ajouté à votre panier';
	}

}else{
	$json['message'] = "Vous n'avez pas sélectionné de produit à ajouter au panier";
}
echo json_encode($json);
if (isset($_GET['modifvente'])) {

	$_SESSION['modifvente']=$_GET['modifvente'];
	
}else{

	$_SESSION['modifvente']=array();

}

	header('Location: update.php');
?>