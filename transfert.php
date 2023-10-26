<?php

// Pour inserer dans la table livraison

	$magconect=$_SESSION['magconect'];

	if ($_SESSION['magconect']=='magstock' and ($_POST['clientvip']==46 or $_POST['clientvip']=='BoutiqueB10')) {


		$productt= $DB->query('SELECT id_produit as id, products.designation as designation, products.quantite as qtites, validpaie.quantite as qtite, pvente, name, Marque, prix_achat, prix_revient, prix_vente, nbrevente, type FROM validpaie inner join products on products.id=id_produit order by(validpaie.id)');

		if ($_POST['clientvip']==46) {

			$_SESSION['magconect']='magasin1';
		}

		if ($_POST['clientvip']=='BoutiqueB10') {

			$_SESSION['magconect']='magasin2';
			
		}

		$prodnuma = $DB->querys('SELECT max(id) AS max_id FROM achat ');
		$numcmdf=$date + $prodnuma['max_id'] + 1;

		foreach($productt as $product){

			$designation=$product->designation;
			$quantity= $product->qtite;	

			$prodtransfert = $DB->query('SELECT quantite FROM products WHERE id=:desig',array('desig'=>$product->id));
			

			foreach ($prodtransfert as $value) {
				
				$quantite=($value->quantite)+$quantity;

				$DB->insert('UPDATE products SET quantite = ? WHERE id = ?', array($quantite, $product->id));
			}


			$DB->insert('INSERT INTO achat (id_produitfac, numcmd, numfact, fournisseur, designation, quantite, pachat, previent, pvente, etat, datefact, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now())', array($product->id, 'cmd'.$numcmdf, 'factstock'.$numcmdf, 79, $designation, $quantity, $product->pvente, $product->pvente, $product->pvente, 'livre'));

			//require 'fraisupstock.php';

			
		}


		$DB->insert('INSERT INTO facture (numcmd, numfact, datefact, fournisseur, montantht, montantva, montantpaye, frais, payement, datecmd) VALUES(?, ?, now(), ?, ?, ?, ?, ?, ?, now())', array('cmd'.$numcmdf, 'factstock'.$numcmdf, 79, $total, 0, $montantpaye, 0, $_POST['mode_payement']));

		
	}
	$_SESSION['magconect']=$magconect; //pour retrouver le magasin initial