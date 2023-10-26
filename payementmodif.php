<?php
require '_header.php';
$pseudo=$_SESSION['idpseudo'];
$prodvente = $DB->querys("SELECT *FROM validventemodif where pseudop='{$pseudo}' ");


if($prodvente['virement']!=0 and empty($_SESSION['banque'])){

	header("Location: modifventeprod.php");

	$alertesvirement='Selectionnez le compte pour le versement banque';

	$_SESSION['alertesvirement']=$alertesvirement;

}elseif($prodvente['cheque']!=0 and empty($prodvente['numcheque'])){
    header("Location: modifventeprod.php");

    $alertescheque='entrer le numéro du chèque';

    $_SESSION['alerteschequep']=$alertescheque;

}else{
	$numero_commande = $_POST['numcmd'];

	$_SESSION['numcmdmodif']=$numero_commande;

	$proddate = $DB->querys("SELECT *FROM payement where num_cmd='{$numero_commande}' ");

	if (empty($_POST['datev'])) {
		$datevente=$proddate['date_cmd'];
	}else{
		$datevente=$panier->h($_POST['datev']);
	}

	

	if (empty($_POST['fraisup'])) {
		$fraisup=0;
	}else{
		$fraisup=$panier->espace($_POST['fraisup']);
	}

	$pseudo=$_SESSION['idpseudo'];

	$numclient=$_SESSION['clientvip'];

	$datev=$panier->h($_POST['datev']);

	unset($_SESSION['$quantite_rest']); //pour vider en cas de commande > au stock    

	if (($panier->espace($_POST['reste'])+$fraisup)<=0) {

		$etat='totalite';
		$total=$panier->modifTotal();+$fraisup;

	}else{

		$etat='credit';
		$total=$panier->modifTotal();+$fraisup;
	}

	$prodqtite=$DB->query("SELECT *FROM livraison  WHERE numcmdliv='{$_SESSION['numcmdmodif']}'");

	foreach ($prodqtite as $prodcmd) {

	    $designation=$prodcmd->id_produitliv;
	    $qtite1=$prodcmd->quantiteliv;
	    $idinit=$prodcmd->id_produitliv;

	    $nomtab=$panier->nomStock($prodcmd->idstockliv)[1];
	    
	  
	    $prodstock=$DB->querys("SELECT idprod, quantite, nbrevente FROM `".$nomtab."` WHERE idprod= ?", array($designation));	    

      	$quantite=$prodstock['quantite']+$qtite1;
    
      	$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite, $designation));

        $vente= ($prodstock['nbrevente'])-$qtite1;

		$DB->insert("UPDATE `".$nomtab."` SET nbrevente= ? WHERE idprod = ?", array($vente, $designation));
	}

	$productsliv= $DB->query("SELECT id_produit as id, productslist.designation as designation, validpaiemodif.quantite as qtite, pvente, Marque, nbrevente, type FROM validpaiemodif inner join productslist on productslist.id=id_produit where pseudov='{$pseudo}' order by(validpaiemodif.id)");

	$cumbenef=0;

	$DB->delete('DELETE from commande WHERE num_cmd=?', array($numero_commande));

	$DB->delete('DELETE from livraison WHERE numcmdliv=?', array($numero_commande));

	$DB->delete('DELETE from stockmouv WHERE numeromouv=?', array('liv'.$numero_commande));



	foreach($productsliv as $product){

		$name= $product->Marque;
		$marque=$product->Marque;
		$designation=$product->designation;
		$id=$product->id;			
		$price_vente=$product->pvente;
		$quantity=$product->qtite;
		$numcmd=$numero_commande;

		$idstock=$panier->h($_POST['stockd']);

		if (!empty($_POST['stockd'])) {

			$nomtab=$panier->nomStock($_POST['stockd'])[1];
		}else{

			$nomtab=$panier->nomStock(1)[1];

		}

	    $idstock=$panier->nomStock($_POST['stockd'])[2];

	    $prodprixrevient=$DB->querys("SELECT prix_revient as previent  FROM `".$nomtab."` WHERE idprod='{$product->id}'");
	    
	    $price_revient=$prodprixrevient['previent'];
	    
	    $qtiteliv=$quantity;

	    $type=$product->type;

	    $recupliaison=$DB->querys("SELECT id  FROM productslist WHERE Marque=? and type=? ", array($marque, 'en_gros'));

	    $liaison=$recupliaison['id'];

	    $recupliaisonp=$DB->querys("SELECT id  FROM productslist WHERE Marque=? and type=? ", array($marque, 'paquet'));

	    $liaisonp=$recupliaisonp['id'];

	    if (!empty($_POST['stockd'])) {

		    $qtiteinit=$DB->querys("SELECT quantite  FROM `".$nomtab."` WHERE idprod=? ", array($id));

		    $qtiterest=$qtiteinit['quantite']-$qtiteliv;

		    $quantite=$qtiterest;
		}

		$DB->insert('INSERT INTO commande (id_produit, prix_vente, prix_revient, quantity, num_cmd, id_client) VALUES(?, ?, ?, ?, ?, ?)', array($id, $price_vente, $price_revient, $quantity, $numero_commande, $numclient));

		//**********************vente avec livraison directe***********************	

		if (!empty($_POST['stockd'])) {

			//****************Gestion de detail***************************

		    if ($type=="en_gros") {      

		      $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?",array($quantite, $id));

		    }elseif($type=="paquet"){

		      if ($quantite>0) {

		        $quantite_det=$quantite;

		        $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ? AND type=?", array($quantite_det, $id, "paquet"));

		      }else{

		        $products=$DB->querys("SELECT quantite, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaison)); //Recuperation du  produit en gros

		        $quantite_gros=$products["quantite"]-1;

		        $quantite_det=$products["qtiteintp"]+$quantite;

		        if ($products["quantite"]>0) {

		          $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

		          $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail

		          $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$numero_commande, 'sortie', -1, $idstock)); 

		          	$DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$numero_commande, 'entree', $products["qtiteintp"], $idstock));

		        }else{

		          $quantite_detail0=$quantite;
		          $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
		        }
		      }

		    }elseif($type=="detail"){

		      if ($quantite>0) {

		        $quantite_det=$quantite;

		        $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ? AND type=?", array($quantite_det, $id, "detail"));

		      }else{

		        $products=$DB->querys("SELECT quantite, qtiteintd, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaison)); //Recuperation du  produit en gros

		        $productsp=$DB->querys("SELECT quantite, qtiteintd, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaisonp)); //Recuperation du  produit en gros

		        $quantite_gros=$products["quantite"]-1;

		        $quantite_grosp=$productsp["quantite"]-1;

		        $quantite_det=$products["qtiteintd"]+$quantite;

		        $quantite_paq=$products["qtiteintp"]+$quantite;

		        if ($productsp["quantite"]>0) {

		          if ($products["quantite"]>0) {

		            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

		            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail

		            $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$numero_commande, 'sortie', -1, $idstock)); 

		          	$DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$numero_commande, 'entree', $products["qtiteintd"], $idstock));

		          }else{

		            $quantite_detail0=$quantite;
		            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
		          }

		        }else{// partie à affiner

		          if ($products["quantite"]>0) {

		            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

		            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail


		            $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$numero_commande, 'sortie', -1, $idstock)); 

		          	$DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$numero_commande, 'entree', $products["qtiteintd"], $idstock));

		          }else{

		            $quantite_detail0=$quantite;
		            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
		          }

		        }
		      }
		    }

		    //****************Fin Gestion detail************************** 

			$qtiteinitcmd=$DB->querys("SELECT qtiteliv  FROM commande WHERE id_produit=? and num_cmd=? ", array($id, $_SESSION['numcmdmodif']));

		    $qtitecmd=$qtiteinitcmd['qtiteliv']+$qtiteliv;

		    $DB->insert("UPDATE commande SET qtiteliv=?, etatlivcmd=? WHERE id_produit=? and num_cmd=? ", array($qtitecmd, 'livre', $id, $_SESSION['numcmdmodif']));

		    

		    $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, ?)', array($id, 'liv'.$_SESSION['numcmdmodif'], 'sortie', -$qtiteliv, $idstock, $datevente));		    

		    $DB->insert("UPDATE payement SET etatliv=? WHERE num_cmd=? ", array('livre', $_SESSION['numcmdmodif']));



		    $DB->insert("INSERT INTO livraison (id_produitliv, quantiteliv , numcmdliv, id_clientliv, livreur, idstockliv, dateliv) VALUES(?, ?, ?, ?, ?, ?, ?)", array($id, $qtiteliv, $numcmd, $numclient, $_SESSION['idpseudo'], $idstock, $datevente));


		}

		//**********************fin vente livraiosn*******************************				
	}



	//************************ GESTION TABLE PAYEMENT PAYEMENT TOTALITE***************

	$DB->delete('DELETE from payement WHERE num_cmd=?', array($numero_commande));
	$DB->delete('DELETE from decaissement WHERE numdec=?', array('reli'.$numero_commande));
	$DB->delete('DELETE from banque WHERE numero=?', array('vente'.$numero_commande));
	$DB->delete('DELETE from banque WHERE numero=?', array('fsup'.$numero_commande));
	$DB->delete('DELETE from fraisup WHERE numcmd=?', array($numero_commande));
	$DB->delete('DELETE from bulletin WHERE numero=?', array($numero_commande));
	$DB->delete('DELETE from modep WHERE numpaiep=?', array($numero_commande));

	$prodvente = $DB->querys("SELECT *FROM validventemodif where pseudop='{$pseudo}' ");
	if (($panier->espace($_POST['reste'])+$fraisup)<=0) {
		$surplus=$panier->espace($_POST['reste']);
		$reste=$_POST['reste']+$fraisup;
	}else{
		$surplus=0;
		$reste=$_POST['reste']+$fraisup;
	}
	$montantpaye=$panier->totalmodif()+$surplus;
	$reliquat=-$panier->espace($_POST['reste']);
	$montantreliquat=$panier->totalmodif();
	$virement=$prodvente['virement'];
	$cheque=$prodvente['cheque'];
	$montantgnf=$prodvente['montantpgnf'];
	$remise=$prodvente['remise'];
	if (empty($remise)) {
		$remise=0;
	}
	
	$gnf=$prodvente['montantpgnf']+$prodvente['virement']+$prodvente['cheque'];
	$eu=$prodvente['montantpeu'];
	$us=$prodvente['montantpus'];
	$cfa=$prodvente['montantpcfa'];
	$caisse=$panier->h($_POST['compte']);
	$numeropaie=$prodvente['numcheque'];
	$banqcheque=$prodvente['banqcheque'];
	$datealerte=$_POST['dateal'];
	$numeropaievir='';

	if (empty($datealerte)) {

		if (($panier->espace($_POST['reste'])+$fraisup)<0) {

			if (!empty($cheque) or !empty($eu) or !empty($us) or !empty($cfa)) {

				if (!empty($_SESSION['clientvipcash'])) {

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $_SESSION['lieuvente'], $datevente));
				}else{

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $_SESSION['lieuvente'], $datevente));

				}
				

				$DB->insert('INSERT INTO decaissement (numdec, montant, devisedec, payement, coment, client, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?,  ?)',array('reli'.$numero_commande, $reliquat, 'gnf', 'espèces', 'reliquat fact '.$numero_commande, $numclient, $caisse, $_SESSION['lieuvente'], $datevente));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', -$reliquat, 'reliquat n° '.$numero_commande, 'vente'.$numero_commande, 'gnf', $numeropaie, $banqcheque, $_SESSION['lieuvente'], $datevente));

			}else{
				if (!empty($_SESSION['clientvipcash'])) {

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $_SESSION['lieuvente'], $datevente));
				}else{

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $_SESSION['lieuvente'], $datevente));

				}

				
			}
		}else{

			if (!empty($_SESSION['clientvipcash'])) {

				$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $_SESSION['lieuvente'], $datevente));
			}else{

				$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $_SESSION['lieuvente'], $datevente));

			}

			

		}

	}else{

		if (($panier->espace($_POST['reste'])+$fraisup)<=0) {

		
			if (!empty($cheque) or !empty($eu) or !empty($us) or !empty($cfa)) {

				if (!empty($_SESSION['clientvipcash'])) {

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $_SESSION['lieuvente'], $datealerte, $datevente));
				}else{

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $_SESSION['lieuvente'], $datealerte, $datevente));

				}

				

				$DB->insert('INSERT INTO decaissement (numdec, montant, devisedec, payement, coment, client, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?,  ?)',array('reli'.$numero_commande, $reliquat, 'gnf', 'espèces', 'reliquatfact '.$numero_commande, $numclient, $caisse, $_SESSION['lieuvente'], $datevente));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', -$reliquat, 'reliquat n° '.$numero_commande, 'vente'.$numero_commande, 'gnf', $numeropaie, $banqcheque, $_SESSION['lieuvente'], $datevente));

			}else{

				if (!empty($_SESSION['clientvipcash'])) {

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $_SESSION['lieuvente'], $datealerte, $datevente));
				}else{

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $_SESSION['lieuvente'], $datealerte, $datevente));

				}

				
			}
		}else{

			if (!empty($_SESSION['clientvipcash'])) {

				$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $_SESSION['lieuvente'], $datealerte, $datevente));
			}else{

				$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $_SESSION['lieuvente'], $datealerte, $datevente));

			}

			

		}

	}

	$reste=$panier->espace($_POST['reste'])+$fraisup;


	if ($reste<=0) {

		if (empty($datev)) {

			//$DB->insert('INSERT INTO bulletin (nom_client, montant, devise, libelles, numero, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($numclient, 0, 'gnf', "reste à payer", $maximum['num_cmd'], $caisse, $_SESSION['lieuvente']));

		}else{

			//$DB->insert('INSERT INTO bulletin (nom_client, montant, devise, libelles, numero, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($numclient, 0, 'gnf', "reste à payer", $maximum['num_cmd'], $caisse, $_SESSION['lieuvente'], $datev));

		}
	}else{	

		$DB->insert('INSERT INTO bulletin (nom_client, montant, devise, libelles, numero, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($numclient, -$reste, 'gnf', "reste à payer", $numero_commande, $caisse, $_SESSION['lieuvente'], $datevente));


	}

	$cumbenef=0;
		
	$prodtop=$DB->querys('SELECT id_client, montant, benefice FROM topclient WHERE id_client=?', array($numclient));

	$newbenef=$prodtop['benefice']+$cumbenef;
	$newmontant=$prodtop['montant']+$total;

	if (empty($prodtop)) {

		$DB->insert('INSERT INTO topclient (id_client, montant, benefice) VALUES(?, ?, ?)', array($numclient, $total, $cumbenef));
	}else{

		$DB->insert('UPDATE topclient SET montant = ?, benefice=? WHERE id_client = ?', array($newmontant, $newbenef, $numclient));
	}

	if (($panier->espace($_POST['reste'])+$fraisup)<0) {// Pour separer le surplus d'especes et autres modes de vente

		if (!empty($cheque) or !empty($eu) or !empty($us) or !empty($cfa)) {

			$datev=$datevente;

			if (!empty($prodvente['virement'])) {

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_SESSION['banque'], 'vente', $virement, 'vente n°'.$numero_commande, 'vente'.$numero_commande, 'virement', $numeropaievir, $_SESSION['lieuvente'], $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantgnf), 'gnf', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

			}else{
				
				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantgnf), 'gnf', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));
			}

			if (!empty($prodvente['cheque'])) {

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', $cheque, 'vente n°'.$numero_commande, 'vente'.$numero_commande, 'cheque', $numeropaie, $banqcheque, $_SESSION['lieuvente'], $datev));
			}

				

			


			//*********************************fin banque****************************

			

			$datev=$datevente;

			if (!empty($prodvente['virement'])) {

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $virement, 'virement', 1, $datev, $caisse));
			}

			if (!empty($prodvente['cheque'])) {

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, numerocheque, banquecheque, datefact, caisse) VALUES(?, ?, ?,  ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $cheque, 'cheque', 1, $numeropaie, $banqcheque, $datev, $caisse));
			}

			if (!empty($prodvente['montantpgnf'])) {

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $montantgnf, 'gnf', 1, $datev, $caisse));
			}

			if (!empty($prodvente['montantpeu'])) {

				$taux=$panier->devise('euro');

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $eu, 'eu', $taux, $datev, $caisse));
			}

			if (!empty($prodvente['montantpus'])) {

				$taux=$panier->devise('us');

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $us, 'us', $taux, $datev, $caisse));
			}

			if (!empty($prodvente['montantpcfa'])) {

				$taux=$panier->devise('cfa');

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $cfa, 'cfa', $taux, $datev, $caisse));
			}

			

			//********************************fin modep*****************************

		}else{// Pour annuler le surplus en cas de paiement par especes

			$datev=$datevente;

				
			$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantpaye), 'gnf', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));



			//*********************************fin banque****************************


			if (!empty($prodvente['montantpgnf'])) {

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $montantpaye, 'gnf', 1, $datev, $caisse));
			}

			//********************************fin modep*****************************

		}

	}else{

		$datev=$datevente;

		if (!empty($prodvente['virement'])) {

			$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_SESSION['banque'], 'vente', $virement, 'vente n°'.$numero_commande, 'vente'.$numero_commande, 'virement', $numeropaievir, $_SESSION['lieuvente'], $datev));

			$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantgnf), 'gnf', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

			$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

			$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

			$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

		}else{
			
			$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantgnf), 'gnf', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

			$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

			$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));

			$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$numero_commande, 'vente'.$numero_commande, $_SESSION['lieuvente'], $datev));
		}

		if (!empty($prodvente['cheque'])) {

			$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', $cheque, 'vente n°'.$numero_commande, 'vente'.$numero_commande, 'cheque', $numeropaie, $banqcheque, $_SESSION['lieuvente'], $datev));
		}


		if (!empty($prodvente['virement'])) {

			$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $virement, 'virement', 1, $datev, $caisse));
		}

		if (!empty($prodvente['cheque'])) {

			$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, numerocheque, banquecheque, datefact, caisse) VALUES(?, ?, ?,  ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $cheque, 'cheque', 1, $numeropaie, $banqcheque, $datev, $caisse));
		}

		if (!empty($prodvente['montantpgnf'])) {

			$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $montantgnf, 'gnf', 1, $datev, $caisse));
		}

		if (!empty($prodvente['montantpeu'])) {

			$taux=$panier->devise('euro');

			$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $eu, 'eu', $taux, $datev, $caisse));
		}

		if (!empty($prodvente['montantpus'])) {

			$taux=$panier->devise('us');

			$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $us, 'us', $taux, $datev, $caisse));
		}

		if (!empty($prodvente['montantpcfa'])) {

			$taux=$panier->devise('cfa');

			$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($numero_commande, $numclient, $cfa, 'cfa', $taux, $datev, $caisse));
		}

		
	}

    require 'fraisupmodif.php';

    $DB->insert('INSERT INTO modifcommande(num_cmd, exec, dateop) VALUES(?, ?, now())', array($numero_commande, $pseudo));

    //require 'transfert.php'; //pour effectuer le transfert stock vers boutiques

    $_SESSION['panier'] = array();
    $_SESSION['panieru'] = array();
    $_SESSION['error']=array();
    $_SESSION['clientvip']=array();
    $_SESSION["montant_paye"]=array();
    $_SESSION['remise']=array();
    $_SESSION['product']=array();
    unset($_SESSION['banque']);
    unset($_SESSION['proformat']);
    unset($_SESSION['alertesvirement']);
    unset($_SESSION['alerteschequep']);

    $DB->delete("DELETE FROM validpaiemodif where pseudov='{$pseudo}' ");
	$DB->delete("DELETE FROM validventemodif where pseudop='{$pseudo}' ");



	header("Location: facturations.php");

    //header("Location: ticket_pdf.php");
}?>

</body>
</html>

			

	


		
