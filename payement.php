<?php
require '_header.php';
$pseudo=$_SESSION['idpseudo'];
$prodvente = $DB->querys("SELECT *FROM validvente where pseudop='{$pseudo}' ");

$lieuventecaisse=$panier->lieuVenteCaisse($_POST['compte'])[0];
$initial=$panier->adresseinit($lieuventecaisse)[0];

if (isset($_POST['proformat'])) {

	$_SESSION['proformat']='proformat';

	$products= $DB->query("SELECT id_produit as id, validpaie.quantite as qtite, pvente FROM validpaie where pseudov='{$_SESSION['idpseudo']}' order by(validpaie.id)");

	$date = date('y') . '00000';

	$maximum = $DB->querys('SELECT max(id) AS max_id FROM proformat');

	$numero_commande = $date + $maximum['max_id'] + 1;

	$init=$initial.'p';

	$_SESSION['num_cmdp']=$init.$numero_commande;

	foreach($products as $product){
		$id=$product->id;			
		$price_vente=$product->pvente;
		$qtite=$product->qtite;

		if (!empty($_SESSION['clientvipcash'])) {

			$DB->insert('INSERT INTO proformat (id_produit, num_pro, prix_vente, quantity, vendeur, id_client, nomclient, lieuvente, datepro) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($id, $init.$numero_commande, $price_vente, $qtite, $_SESSION['idpseudo'], 0, $_SESSION['clientvipcash'], $lieuventecaisse));
		}else{

			$DB->insert('INSERT INTO proformat (id_produit, num_pro, prix_vente, quantity, vendeur, id_client, lieuvente, datepro) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($id, $init.$numero_commande, $price_vente, $qtite, $_SESSION['idpseudo'], $_SESSION['clientvip'], $lieuventecaisse));

		}

		$_SESSION['panier'] = array();
        $_SESSION['panieru'] = array();
        $_SESSION['error']=array();
        $_SESSION["seleclient"]=array();
        $_SESSION["montant_paye"]=array();
        $_SESSION['remise']=array();
        $_SESSION['product']=array();
        //unset($_SESSION['clientvip']);
        //unset($_SESSION['clientvipcash']);

        //$DB->delete('DELETE FROM validpaie');
		//$DB->delete('DELETE FROM validvente');

		header("Location: index.php");
	}

	unset($_SESSION['clientvip']);
    unset($_SESSION['clientvipcash']);
				

}elseif($prodvente['virement']!=0 and empty($_SESSION['banque'])){

	header("Location: index.php");

	$alertesvirement='Selectionnez le compte pour le versement banque';

	$_SESSION['alertesvirement']=$alertesvirement;

}elseif($prodvente['cheque']!=0 and empty($prodvente['numcheque'])){
    header("Location: index.php");

    $alertescheque='entrer le numéro du chèque';

    $_SESSION['alerteschequep']=$alertescheque;

}else{

	$date = date('y') . '00000';

	$maximum = $DB->querys('SELECT max(id) AS max_id FROM numerocommande ');

	$numero_commande = $date + $maximum['max_id'] + 1;

	$init=$initial;

	$_SESSION['num_cmdp']=$init.$numero_commande;

	$DB->insert('INSERT INTO numerocommande (numero) VALUES(?)', array($init.$numero_commande));

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
		$total=$panier->totalcom()+$fraisup;

	}else{

		$etat='credit';
		$total=$panier->totalcom()+$fraisup;
	}

	$products= $DB->query("SELECT id_produit as id, productslist.designation as designation, validpaie.quantite as qtite, pvente, Marque, nbrevente, type FROM validpaie inner join productslist on productslist.id=id_produit where pseudov='{$pseudo}' order by(validpaie.id)");

	$cumbenef=0;

	foreach($products as $product){

		

		$name= $product->Marque;
		$marque=$product->Marque;
		$designation=$product->designation;
		$id=$product->id;			
		$price_vente=$product->pvente;
		
		$quantity=$product->qtite;
		$numcmd=$init.$numero_commande;

		$idstock=$panier->h($_POST['stockd']);

		if (!empty($_POST['stockd'])) {

			$nomtab=$panier->nomStock($_POST['stockd'])[1];
		}else{

			$nomtab=$panier->nomStock(1)[1];

		}

	    $idstock=$panier->nomStock($_POST['stockd'])[2];

	    $prodprixrevient=$DB->querys("SELECT prix_revient as previent  FROM `".$nomtab."` WHERE idprod='{$product->id}'");
	    
	    $price_revient=$prodprixrevient['previent'];
	    
	    if (!empty($_POST['datev'])) {
	    	$datep=$panier->h($_POST['datev']);
	    }else{
	    	$datep=date('Y-m-d');
	    }

	    $prodpromo= $DB->querys("SELECT * FROM promotion where idprod='{$id}' and dated<='{$datep}' and datef>='{$datep}' ");

	    if (!empty($prodpromo)) {

	    	$achatmin=$prodpromo['achatmin'];
		    $achatmax=$prodpromo['achatmax'];
		    $qtitepromo=$prodpromo['qtite'];

		    if ($achatmin<=$quantity and $achatmax>$quantity) {
		    	
		    	$qtiteplus=$quantity+$qtitepromo;

		    }else{
		    	$qtiteplus=$quantity;
		    }
		}else{
			$qtiteplus=$quantity;
			$achatmin=4000;
			$achatmax=4000;

		}
	    
	    $qtiteliv=$qtiteplus;

	    $type=$product->type;

	    $recupliaison=$DB->querys("SELECT id  FROM productslist WHERE Marque=? and type=? ", array($marque, 'en_gros'));

	    $liaison=$recupliaison['id'];

	    $recupliaisonp=$DB->querys("SELECT id  FROM productslist WHERE Marque=? and type=? ", array($marque, 'paquet'));

	    $liaisonp=$recupliaisonp['id'];

	    $qtiteinit=$DB->querys("SELECT quantite  FROM `".$nomtab."` WHERE idprod=? ", array($id));

	    $qtiterest=$qtiteinit['quantite']-$qtiteliv;

	    $quantite=$qtiterest;

		$DB->insert('INSERT INTO commande (id_produit, prix_vente, prix_revient, quantity, num_cmd, id_client) VALUES(?, ?, ?, ?, ?, ?)', array($id, $price_vente, $price_revient, $quantity, $init.$numero_commande, $numclient));

		// Promotion 

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

		           $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

		          $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintp"], $idstock));


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


		            	$DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

		          		$DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintd"], $idstock));

			        }else{

			            $quantite_detail0=$quantite;
			            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
			        }

		        }else{// partie à affiner

		          if ($products["quantite"]>0) {

		            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

		            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail

		            $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

		          	$DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintd"], $idstock));

		          }else{

		            $quantite_detail0=$quantite;
		            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
		          }

		        }
		      }
		    }

		    //****************Fin Gestion detail************************** 

			//$qtiteinitcmd=$DB->querys("SELECT qtiteliv  FROM commande WHERE id_produit=? and num_cmd=? ", array($id, $numcmd));

		    $qtitecmd=$qtiteliv;

		    $DB->insert("UPDATE commande SET qtiteliv=?, etatlivcmd=? WHERE id_produit=? and num_cmd=? ", array($qtitecmd, 'livre', $id, $init.$numero_commande));

		    $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'liv'.$init.$numero_commande, 'sortie', -$qtiteliv, $idstock));  

		    $DB->insert("INSERT INTO livraison (id_produitliv, quantiteliv , numcmdliv, id_clientliv, livreur, idstockliv, dateliv) VALUES(?, ?, ?, ?, ?, ?, now())", array($id, $qtiteliv, $init.$numero_commande, $numclient, $_SESSION['idpseudo'], $idstock));


		}

		//**********************fin vente livraiosn*******************************				
	}



	//************************ GESTION TABLE PAYEMENT PAYEMENT TOTALITE***************

	$prodvente = $DB->querys("SELECT *FROM validvente where pseudop='{$pseudo}' ");
	if (($panier->espace($_POST['reste'])+$fraisup)<=0) {
		$surplus=$panier->espace($_POST['reste']);
		$reste=$_POST['reste']+$fraisup;
	}else{
		$surplus=0;
		$reste=$_POST['reste']+$fraisup;
	}
	$montantpaye=$panier->totalpaye()+$surplus;
	$reliquat=-$panier->espace($_POST['reste']);
	$montantreliquat=$panier->totalpaye();
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

	if (empty($datev)) {

		if (empty($datealerte)) {

			if (($panier->espace($_POST['reste'])+$fraisup)<0) {

				if (!empty($cheque) or !empty($eu) or !empty($us) or !empty($cfa)) {

					if (!empty($_SESSION['clientvipcash'])) {

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse));
					}else{

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse));

					}

					$DB->insert('INSERT INTO decaissement (numdec, montant, devisedec, payement, coment, client, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?,  now())',array('reli'.$init.$numero_commande, $reliquat, 'gnf', 'espèces', 'reliquat fact '.$init.$numero_commande, $numclient, $caisse, $lieuventecaisse));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', -$reliquat, 'reliquat n° '.$init.$numero_commande, 'vente'.$init.$numero_commande, 'gnf', $numeropaie, $banqcheque, $lieuventecaisse));

				}else{

					if (!empty($_SESSION['clientvipcash'])) {

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse));
					}else{

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse));

					}

					
				}
			}else{

				if (!empty($_SESSION['clientvipcash'])) {

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse));
				}else{

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse));

				}				

			}

		}else{

			if (($panier->espace($_POST['reste'])+$fraisup)<=0) {

			
				if (!empty($cheque) or !empty($eu) or !empty($us) or !empty($cfa)) {

					if (!empty($_SESSION['clientvipcash'])) {

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datealerte));
					}else{

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse, $datealerte));

					}

					

					$DB->insert('INSERT INTO decaissement (numdec, montant, devisedec, payement, coment, client, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?,  now())',array('reli'.$init.$numero_commande, $reliquat, 'gnf', 'espèces', 'reliquatfact '.$init.$numero_commande, $numclient, $caisse, $lieuventecaisse));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', -$reliquat, 'reliquat n° '.$init.$numero_commande, 'vente'.$init.$numero_commande, 'gnf', $numeropaie, $banqcheque, $lieuventecaisse));

				}else{

					if (!empty($_SESSION['clientvipcash'])) {

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datealerte));
					}else{

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse, $datealerte));

					}

					
				}
			}else{

				if (!empty($_SESSION['clientvipcash'])) {

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datealerte));
				}else{

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse, $datealerte));

				}				

			}

		}
	}else{
		if (empty($datealerte)) {			

			if (($panier->espace($_POST['reste'])+$fraisup)<=0) {

				if (!empty($cheque) or !empty($eu) or !empty($us) or !empty($cfa)) {

					if (!empty($_SESSION['clientvipcash'])) {

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datev));
					}else{

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse, $datev));

					}

					$DB->insert('INSERT INTO decaissement (numdec, montant, devisedec, payement, coment, client, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?,  ?)',array('reli'.$init.$numero_commande, $reliquat, 'gnf', 'espèces', 'reliquat fact '.$init.$numero_commande, $numclient, $caisse, $lieuventecaisse, $datev));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', -$reliquat, 'reliquat n° '.$init.$numero_commande, 'vente'.$init.$numero_commande, 'gnf', $numeropaie, $banqcheque, $lieuventecaisse));

				}else{

					if (!empty($_SESSION['clientvipcash'])) {

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datev));
					}else{

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse, $datev));

					}

					
				}
			}else{

				if (!empty($_SESSION['clientvipcash'])) {

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datev));
				}else{

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse, $datev));

				}
				

			}

		}else{

			if (($panier->espace($_POST['reste'])+$fraisup)<=0) {

				if (!empty($cheque) or !empty($eu) or !empty($us) or !empty($cfa)) {

					if (!empty($_SESSION['clientvipcash'])) {

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datealerte, $datev));
					}else{

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse, $datealerte, $datev));

					}
					

					$DB->insert('INSERT INTO decaissement (numdec, montant, devisedec, payement, coment, client, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?,  ?)',array('reli'.$init.$numero_commande, $reliquat, 'gnf', 'espèces', 'reliquat'.$init.$numero_commande, $numclient, $caisse, $lieuventecaisse, $datev));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', -$reliquat, 'reliquat n° '.$init.$numero_commande, 'vente'.$init.$numero_commande, 'gnf', $numeropaie, $banqcheque, $lieuventecaisse));

				}else{

					if (!empty($_SESSION['clientvipcash'])) {

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datealerte, $datev));
					}else{

						$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse, $datealerte, $datev));

					}					
				}
			}else{

				if (!empty($_SESSION['clientvipcash'])) {

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, nomclient, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, 0, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datealerte, $datev));
				}else{

					$DB->insert('INSERT INTO payement (num_cmd, Total, fraisup, montantpaye, remise, reste, etat, vendeur, num_client, caisse, lieuvente, datealerte, date_cmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat, $pseudo, $numclient, $caisse, $lieuventecaisse, $datealerte, $datev));

				}

				

			}

			

		}
	}

	//$maximum = $DB->querys('SELECT max(num_cmd) AS num_cmd FROM payement ');

	$reste=$panier->espace($_POST['reste'])+$fraisup;

	if ($reste<=0) {

		if (empty($datev)) {

			$DB->insert('INSERT INTO bulletin (nom_client, montant, devise, libelles, numero, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($numclient, 0, 'gnf', "reste à payer", $init.$numero_commande, $caisse, $lieuventecaisse));

		}else{

			$DB->insert('INSERT INTO bulletin (nom_client, montant, devise, libelles, numero, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($numclient, 0, 'gnf', "reste à payer", $init.$numero_commande, $caisse, $lieuventecaisse, $datev));

		}
	}else{

		if (empty($datev)) {

			$DB->insert('INSERT INTO bulletin (nom_client, montant, devise, libelles, numero, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($numclient, -$reste, 'gnf', "reste à payer", $init.$numero_commande, $caisse, $lieuventecaisse));

		}else{

			$DB->insert('INSERT INTO bulletin (nom_client, montant, devise, libelles, numero, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($numclient, -$reste, 'gnf', "reste à payer", $init.$numero_commande, $caisse, $lieuventecaisse, $datev));

		}

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

			if (empty($datev)) {

				if (!empty($prodvente['virement'])) {

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, lieuvente,  date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($_SESSION['banque'], 'vente', $virement, 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, 'virement', $numeropaievir, $lieuventecaisse));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($montantgnf), 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));
				}else{

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($montantgnf), 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));
				}

				if (!empty($prodvente['cheque'])) {

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', $cheque, 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, 'cheque', $numeropaie, $banqcheque, $lieuventecaisse));
				}

			}else{

				if (!empty($prodvente['virement'])) {

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_SESSION['banque'], 'vente', $virement, 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, 'virement', $numeropaievir, $lieuventecaisse, $datev));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantgnf), 'gnf', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

				}else{
					
					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantgnf), 'gnf', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));
				}

				if (!empty($prodvente['cheque'])) {

					$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', $cheque, 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, 'cheque', $numeropaie, $banqcheque, $lieuventecaisse, $datev));
				}

				

			}


			//*********************************fin banque****************************

			if (empty($datev)) {

				if (!empty($prodvente['virement'])) {

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse) VALUES(?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $virement, 'virement', 1, $caisse ));
				}

				if (!empty($prodvente['cheque'])) {

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, numerocheque, banquecheque, caisse) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cheque, 'cheque', 1, $numeropaie, $banqcheque, $caisse));
				}

				if (!empty($prodvente['montantpgnf'])) {

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse) VALUES(?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $montantgnf, 'gnf', 1, $caisse ));
				}

				if (!empty($prodvente['montantpeu'])) {

					$taux=$panier->devise('euro');

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse) VALUES(?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $eu, 'eu', $taux, $caisse));
				}

				if (!empty($prodvente['montantpus'])) {

					$taux=$panier->devise('us');

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse) VALUES(?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $us, 'us', $taux, $caisse));
				}

				if (!empty($prodvente['montantpcfa'])) {

					$taux=$panier->devise('cfa');

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse) VALUES(?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cfa, 'cfa', $taux, $caisse));
				}
			}else{

				if (!empty($prodvente['virement'])) {

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $virement, 'virement', 1, $datev, $caisse));
				}

				if (!empty($prodvente['cheque'])) {

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, numerocheque, banquecheque, datefact, caisse) VALUES(?, ?, ?,  ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cheque, 'cheque', 1, $numeropaie, $banqcheque, $datev, $caisse));
				}

				if (!empty($prodvente['montantpgnf'])) {

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $montantgnf, 'gnf', 1, $datev, $caisse));
				}

				if (!empty($prodvente['montantpeu'])) {

					$taux=$panier->devise('euro');

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $eu, 'eu', $taux, $datev, $caisse));
				}

				if (!empty($prodvente['montantpus'])) {

					$taux=$panier->devise('us');

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $us, 'us', $taux, $datev, $caisse));
				}

				if (!empty($prodvente['montantpcfa'])) {

					$taux=$panier->devise('cfa');

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cfa, 'cfa', $taux, $datev, $caisse));
				}

			}

			//********************************fin modep*****************************

		}else{// Pour annuler le surplus en cas de paiement par especes

			if (empty($datev)) {				

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($montantpaye), 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

				
			}else{

				
				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantpaye), 'gnf', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

				

			}


			//*********************************fin banque****************************

			if (empty($datev)) {

				

				if (!empty($prodvente['montantpgnf'])) {

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse) VALUES(?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $montantpaye, 'gnf', 1, $caisse ));
				}

				
			}else{

				if (!empty($prodvente['montantpgnf'])) {

					$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $montantpaye, 'gnf', 1, $datev, $caisse));
				}

				

			}

			//********************************fin modep*****************************

		}

	}else{

		if (empty($datev)) {

			if (!empty($prodvente['virement'])) {

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, lieuvente,  date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($_SESSION['banque'], 'vente', $virement, 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, 'virement', $numeropaievir, $lieuventecaisse));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($montantgnf), 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));
			}else{

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($montantgnf), 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse));
			}

			if (!empty($prodvente['cheque'])) {

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compte'], 'vente', $cheque, 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, 'cheque', $numeropaie, $banqcheque, $lieuventecaisse));
			}

		}else{

			if (!empty($prodvente['virement'])) {

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_SESSION['banque'], 'vente', $virement, 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, 'virement', $numeropaievir, $lieuventecaisse, $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantgnf), 'gnf', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

			}else{
				
				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantgnf), 'gnf', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));
			}

			if (!empty($prodvente['cheque'])) {

				$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', $cheque, 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, 'cheque', $numeropaie, $banqcheque, $lieuventecaisse, $datev));
			}

			

		}

		if (empty($datev)) {

			if (!empty($prodvente['virement'])) {

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse) VALUES(?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $virement, 'virement', 1, $caisse ));
			}

			if (!empty($prodvente['cheque'])) {

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, numerocheque, banquecheque, caisse) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cheque, 'cheque', 1, $numeropaie, $banqcheque, $caisse));
			}

			if (!empty($prodvente['montantpgnf'])) {

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse) VALUES(?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $montantgnf, 'gnf', 1, $caisse ));
			}

			if (!empty($prodvente['montantpeu'])) {

				$taux=$panier->devise('euro');

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse) VALUES(?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $eu, 'eu', $taux, $caisse));
			}

			if (!empty($prodvente['montantpus'])) {

				$taux=$panier->devise('us');

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse) VALUES(?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $us, 'us', $taux, $caisse));
			}

			if (!empty($prodvente['montantpcfa'])) {

				$taux=$panier->devise('cfa');

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse) VALUES(?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cfa, 'cfa', $taux, $caisse));
			}
		}else{

			if (!empty($prodvente['virement'])) {

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $virement, 'virement', 1, $datev, $caisse));
			}

			if (!empty($prodvente['cheque'])) {

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, numerocheque, banquecheque, datefact, caisse) VALUES(?, ?, ?,  ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cheque, 'cheque', 1, $numeropaie, $banqcheque, $datev, $caisse));
			}

			if (!empty($prodvente['montantpgnf'])) {

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $montantgnf, 'gnf', 1, $datev, $caisse));
			}

			if (!empty($prodvente['montantpeu'])) {

				$taux=$panier->devise('euro');

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $eu, 'eu', $taux, $datev, $caisse));
			}

			if (!empty($prodvente['montantpus'])) {

				$taux=$panier->devise('us');

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $us, 'us', $taux, $datev, $caisse));
			}

			if (!empty($prodvente['montantpcfa'])) {

				$taux=$panier->devise('cfa');

				$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cfa, 'cfa', $taux, $datev, $caisse));
			}

		}
	}

	$numeroliv=$init.$numero_commande;

	$verifliv = $DB->querys("SELECT *FROM livraison where numcmdliv='{$numeroliv}' ");

	if (!empty($verifliv)) {
		$DB->insert("UPDATE payement SET etatliv=? WHERE num_cmd=? ", array('livre', $init.$numero_commande));
	}

	

    require 'fraisup.php';

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
    unset($_SESSION['clientvipcash']);
    unset($_SESSION['clientvip']);

    $DB->delete("DELETE FROM validpaie ");
	$DB->delete("DELETE FROM validvente ");

	//header("Location: index.php?payement");

	unset($_POST);
	unset($_GET);

    header("Location: recherche.php?payement");
}?>

</body>
</html>

			

	


		
