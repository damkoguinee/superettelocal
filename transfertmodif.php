<?php 

$magconect=$_SESSION['magconect'];

if ($_SESSION['magconect']=='magstock' and ($_POST['clientvip']=='BoutiqueB3' or $_POST['clientvip']=='BoutiqueB10')) {

	$prodqtite=$DB->query('SELECT id_produit, name, Marque, designation, quantity FROM commande inner join products on products.id=commande.id_produit WHERE num_cmd= :NUM', array('NUM'=>$_SESSION['numcmdmodif']));

	foreach ($prodqtite as $prodcmd) {

	    $nom=$prodcmd->name;
	    $designation=$prodcmd->designation;
	    $qtite1=$prodcmd->quantity;
	    $idinit=$prodcmd->id_produit;
	    
	  
	    $prod=$DB->query('SELECT designation, quantite FROM products WHERE designation= ?', array($designation));

	    foreach ($prod as $prodstock) {

	      $quantite=$prodstock->quantite-$prodcmd->quantity;
	    
	      $DB->insert('UPDATE products SET quantite = ? WHERE designation = ?', array($quantite, $designation));
	    }
	}

	$products= $DB->query('SELECT id_produit as id, products.designation as designation, products.quantite as qtites, validpaiemodif.quantite as qtite, pvente, name, Marque, prix_achat, prix_revient, prix_vente, nbrevente, type FROM validpaiemodif inner join products on products.id=id_produit order by(validpaiemodif.id)');

	foreach($products as $product){

		$designation=$product->designation;
		$quantity= $product->qtite;
				
		
		if ($_POST['clientvip']=='BoutiqueB3') {

			$_SESSION['magconect']='magasin1';
		}

		if ($_POST['clientvip']=='BoutiqueB10') {

			$_SESSION['magconect']='magasin2';
			
		}

		$prodtransfert = $DB->query('SELECT quantite FROM products WHERE id=:desig',array('desig'=>$id));
		

		foreach ($prodtransfert as $value) {
			
			$quantite=($value->quantite)+$quantity;
			$DB->insert('UPDATE products SET quantite = ? WHERE id = ?', array($quantite, $id));
		}

		$_SESSION['magconect']=$magconect; //pour retrouver le magasin initial
	}
}