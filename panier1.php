<div class="tableau"><?php

	if (isset($_GET['delPanier'])) {

		$DB->delete('DELETE FROM validpaie WHERE id = ? and pseudov=?', array($_GET['delPanier'], $_SESSION['idpseudo']));

		$DB->delete('DELETE FROM validvente where pseudop=?', array($_SESSION['idpseudo']));

		unset($_SESSION['alertesvirement']);
		unset($_SESSION['banque']);
	}

	if (isset($_POST['devise'])) {

		$prodverifdevise = $DB->querys("SELECT montantdevise FROM devise where idvente='{$_SESSION['lieuvente']}' ");

		if (empty($prodverifdevise)) {

			$DB->insert("INSERT INTO devise (nomdevise, montantdevise, idvente) VALUES(?, ?, ?)", array($_POST['nom'], $_POST['devise'], $_SESSION['lieuvente']));
		}else{

			$DB->insert('UPDATE devise SET montantdevise=? where nomdevise=? and idvente=?', array($_POST['devise'], $_POST['nom'], $_SESSION['lieuvente']));

		}

	}

	if (isset($_GET['desig'])) {
		

		$prodvalidcverif = $DB->querys('SELECT quantite FROM validpaie where id_produit=? and pseudov=?', array($_GET['idc'], $_SESSION['idpseudo']));

		if (empty($prodvalidcverif)) {
					
			$DB->insert('INSERT INTO validpaie (id_produit, codebvc, quantite, pvente, pseudov, datecmd) VALUES(?, ?, ?, ?, ?, now())', array($_GET['idc'], 1, 1, $_GET['pv'], $_SESSION['idpseudo']));

		}else{

			$qtitesup=$prodvalidcverif['quantite']+1;

			$DB->insert('UPDATE validpaie SET quantite=? where id_produit=? and pseudov=?', array($qtitesup, $_GET['idc'], $_SESSION['idpseudo']));

		}
		

		//$DB->insert('INSERT INTO validpaie (id_produit, codebvc, quantite, pvente, pseudov, datecmd) VALUES(?, ?, ?, ?, ?, now())', array($_GET['idc'], 1, 1, $_GET['pv'], $_SESSION['idpseudo']));

	}

	
	if (isset($_GET['clientvip'])) {
		$_SESSION['clientvip']=$_GET['clientvip'];
		unset($_SESSION['clientvipcash']);
	}

	if (isset($_POST['clientvip'])) {
		$_SESSION['clientvip']=$_POST['clientvip'];
		unset($_SESSION['clientvipcash']);
	}

	if (isset($_POST['clientvipcash'])) {
		$_SESSION['clientvipcash']=$_POST['clientvipcash'];
		unset($_SESSION['clientvip']);
	}

	if ($panier->adresse()=='KOULA BUSINESS TRADING (K.B.T Sarl)') {

		if (!empty($_SESSION['clientvip'])) {
			$verifclient= $DB->querys("SELECT restriction FROM client where id='{$_SESSION['clientvip']}'");

			if ($verifclient['restriction']=='bloque') {
				$_SESSION['restriction']='bloqué';
				$com="Ce compte est bloqué, merci de contacter le responsable!!!";
			}else{

				$_SESSION['restriction']='ok';
				$com="";

			}
		}else{

			$_SESSION['restriction']='ok';
			$com="";

		}
	}else{

		$_SESSION['restriction']='ok';
		$com="";

	}

	if (isset($_POST['banque'])) {
		$_SESSION['banque']=$_POST['banque'];
		unset($_SESSION['alertesvirement']);
	}

	$nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];

	

	$totalcom=$panier->totalcom();
	if (isset($_GET['scanneur'])) {

		$_SESSION['scanner']=$_GET['scanneur'];

		$prodstock = $DB->querys("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id where `".$nomtab."`.codeb=:id", array('id'=>$_GET['scanneur']));

		$prodvalidcverif = $DB->querys('SELECT quantite FROM validpaie where id_produit=? and pseudov=?', array($prodstock['id'], $_SESSION['idpseudo']));

		if (empty($prodvalidcverif)) {

			$DB->insert('INSERT INTO validpaie (id_produit, codebvc, quantite, pvente, pseudov, datecmd) VALUES(?, ?, ?, ?, ?, now())', array($prodstock['id'], 1, 1, $prodstock['prix_vente'], $_SESSION['idpseudo']));
		}else{

			$qtitesup=$prodvalidcverif['quantite']+1;

			$DB->insert('UPDATE validpaie SET quantite=? where id_produit=? and pseudov=?', array($qtitesup, $prodstock['id'], $_SESSION['idpseudo']));

		}
	}

	if (isset($_POST['pvente']) or isset($_POST['quantity'])) {
		$pvente=$panier->espace($_POST['pvente']);
		
		$DB->insert('UPDATE validpaie SET quantite=?, pvente=? where id=? and pseudov=?', array($_POST['quantity'], $pvente, $_POST['idv'], $_SESSION['idpseudo']));
	}

	if (isset($_POST['remise']) or isset($_POST['remisep']) or isset($_POST['gnfpaye']) or isset($_POST['europaye']) or isset($_POST['uspaye']) or isset($_POST['cfapaye'])) {

		
		if (!empty($_POST['remisep'])) {echo "remisep";
			$remise=$panier->h($panier->espace(($panier->totalcom()*($_POST['remisep']/100))));
		}else{
			$remise=$panier->h($panier->espace($_POST['remise']));
		}
		//$remise=$panier->h($panier->espace($_POST['remise']));
		//$remisep=$panier->h($panier->espace($_POST['remisep']));
		$montantgnf=$panier->h($panier->espace($_POST['gnfpaye']));
		$montanteu=$panier->h($panier->espace($_POST['europaye']));
		$montantus=$panier->h($panier->espace($_POST['uspaye']));
		$montantcfa=$panier->h($panier->espace($_POST['cfapaye']));
		$montantvir=$panier->h($panier->espace($_POST['virement']));
		$montantcheq=$panier->h($panier->espace($_POST['cheque']));
		$numcheque=$panier->h($_POST['numcheque']);
		$banqcheque=$panier->h($_POST['banqcheque']);

		$prodverifv=$DB->querys('SELECT id from validvente where pseudop=?', array($_SESSION['idpseudo']));

		if (empty($prodverifv)) {

			$DB->insert('INSERT INTO validvente (remise, montantpgnf, montantpeu, montantpus, montantpcfa, virement, cheque, numcheque, banqcheque, pseudop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($remise, $montantgnf, $montanteu, $montantus, $montantcfa, $montantvir, $montantcheq, $numcheque, $banqcheque, $_SESSION['idpseudo']));
		}else{
		
			$DB->insert('UPDATE validvente SET remise=?, montantpgnf=?, montantpeu=?, montantpus=?, montantpcfa=?, virement=?, cheque=?, numcheque=?, banqcheque=? where pseudop=?', array($remise, $montantgnf, $montanteu, $montantus, $montantcfa, $montantvir, $montantcheq, $numcheque, $banqcheque, $_SESSION['idpseudo']));
		}

		if ($_POST['remisep']==0) {
			$DB->insert('UPDATE validvente SET remise=? where pseudop=?', array(0, $_SESSION['idpseudo']));
		}

		
	}


	$total=$panier->total();

	$totalpaye=$panier->totalpaye();

	

	$adress = $DB->querys('SELECT * FROM adresse ');

	$products=$DB->query("SELECT productslist.id as id, validpaie.id as idv, id_produit, validpaie.quantite as quantite, productslist.designation as designation, Marque, pvente, prix_vente as prix_vente, productslist.type as type, productslist.qtiteint as qtiteint, productslist.qtiteintp as qtiteintp FROM validpaie inner join productslist on productslist.id=validpaie.id_produit inner join `".$nomtab."` on idprod=productslist.id where pseudov='{$_SESSION['idpseudo']}' order by(validpaie.id) desc ");

	$prodvente = $DB->querys('SELECT remise, montantpgnf, montantpeu, montantpus, montantpcfa, virement, cheque, numcheque, banqcheque FROM validvente where pseudop=?', array($_SESSION['idpseudo']));

	if (!empty($products)) {?>

		<table class="payement" style="margin-top:-8px;">
			<thead>
				
					<tr>
						<th colspan="3">

							<table style="width:100%;">
								<thead>
									<tr><?php 
										if ($_SESSION['restriction']=='ok') {?>

											<th>Selectionnez le Client</th><?php
											
										}else{?>

											<th style="color:white; background-color:red;"><?=$com;?></th><?php

										}?>
										<th colspan="4">Solde Client</th>
									</tr>
									<tr>
										<th style="width:60%;">
											<div style="display:flex;">
												<div>
													<form method="POST" action="index.php"><?php 
														if (!empty($_SESSION['clientvipcash'])) {?>

															<input style="width:99%;" type="text" name="clientvipcash" value="<?=$_SESSION['clientvipcash'];?>" onchange="this.form.submit()"/><?php

														}else{?>
															<input style="width:99%;" type="text" name="clientvipcash" placeholder="Entrer client cash" onchange="this.form.submit()"/><?php 
														}?>
														
													</form>
												</div>

												<div>

													<form method="POST" action="index.php">

														<input style="width:40%;" id="search-user" type="text" name="client" placeholder="rechercher un client" />											
														<select style="height: 25px; width:50%;" type="text" name="clientvip" onchange="this.form.submit()"><?php 

															if (!empty($_SESSION['clientvip'])) {?>

																<option value="<?=$_SESSION['clientvip'];?>"><?=$panier->nomClient($_SESSION['clientvip']);?></option><?php 
															}else{?>

																<option></option><?php
															}

															$type1='client';
															$type2='clientf';
															
															foreach($panier->clientF($type1, $type2) as $product){?>

																<option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php
															}?>
														</select>

														<div id="result-search"></div>
													</form>
												</div>
											</div>
										</th><?php

										if (!empty($_SESSION['clientvip'])) { 

											foreach ($panier->monnaie as $valuem) {?>

												<th><?=strtoupper($valuem);?>: <?=number_format(-$panier->compteClient($_SESSION['clientvip'], $valuem),0,',',' ');?></th><?php
												
											}
										}?>
									</tr>
								</thead>
							</table>
						</th>
					</tr>
				

			</thead>

		</table>

		<table class="payement" style="margin-top:0px;">

			<thead>
				<th class="name">Désignation</th>
				<th>Dispo</th>
				<th class="price">P. Unit</th>
				<th>Qtité</th>
				<th class="pricet" >P. Total</th>
				<th></th>
				<th class="sup">Retirer</th>

			</thead><?php
			$totachat=0;

			$qtitetot=0;
			$qtitetotp=0;
			$qtitetotd=0;

			foreach($products as $product){
				$qtites=0;

				if ($product->type=='en_gros') {
	              $qtitetot+=$product->quantite;
	            }elseif ($product->type=='detail') {
	              $qtitetotd+=$product->quantite;
	            }else{

	             $qtitetotp+=$product->quantite;
	            }

				foreach ($panier->listeStock() as $valueS) {

					$prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where productslist.id='{$product->id}' ");

					$qtites+=$prodstock['qtite'];

					
				}

				$etatliv='nonlivre';

				$prodcmd=$DB->querys("SELECT sum(qtiteliv) as qtite FROM commande where id_produit='{$product->id}' and etatlivcmd='{$etatliv}' ");

				$restealivrer=$qtites-$prodcmd['qtite'];
				
				$totachat+=$product->pvente*$product->quantite;

				if ($product->quantite > $qtites) {
				 	$color='red';
				}elseif ($product->quantite==$qtites) {
					$color='grey';
				}else{
					$color='green';

				}?>

				<form id='monform' method="POST" action="index.php">

					<tbody><?php
						
						$designation=$product->designation;?>

						<td class="name" style="width: 50%; text-align: left; font-size: 18px; color:<?=$color;?>"><?= ucwords(strtolower($designation)); ?><input type="hidden" name="id" value="<?=$product->id;?>"><input type="hidden" name="idv" value="<?=$product->idv;?>"></td>

						<td style="text-align: center; font-weight:bold; font-size: 18px;"><?=$restealivrer;?></td><?php

						if ($product->pvente==0) {?>

							<td class="pricec"><input style="color:<?=$color;?>; font-size: 25px;" type="text" min="0" name="pvente" value="<?=number_format($product->pvente,0,',',' ');?>" onchange="this.form.submit()"></td><?php

						}else{?>

							<td class="pricec" style="font-size: 25px;"><input style="color:<?=$color;?>; font-size:25px;" type="text" min="0" name="pvente" value="<?=number_format($product->pvente,0,',',' ');?>" onchange="this.form.submit()" ></td><?php
						}?>



						<td class="quantity" style="font-size: 25px; width:13%;"><input style="color:<?=$color;?>; font-size:25px;" type="text" min="0" name="quantity" value="<?=$product->quantite;?>" onchange="this.form.submit()"></td>

						<td class="pricet" style="color:<?=$color;?>; font-size:25px;"><?=number_format($product->pvente*$product->quantite,0,',',' ');?></td>

						<td><input type="submit" name="modifvente" value="Valider" style="background-color: orange; color: white;"></td>

						<td class="sup">
							<a href="index.php?delPanier=<?= $product->idv;?>&montantsup=<?=$product->pvente*$product->quantite;?>" class="del"><img src="img/sup.jpg"></a>
						</td>

					</tbody>
				</form><?php
			}?>

		</table>

		<table class="payement" style="margin-top:0px;">
			<thead>
				<tr>
					<th style="font-size:12px; width:60%;">

						<div style="display: flex; height:20px;"><?php

							$proddevise=$DB->query("SELECT *From devise where idvente='{$_SESSION['lieuvente']}'");
							if (empty($proddevise)) {
								$initdevise=0;

								$proddevise=$DB->query("SELECT *From devise where idvente='{$initdevise}'");
							}

							foreach ($proddevise as $key => $valued) {?>

								<form method="POST" action="index.php" >

									<input type="hidden" name="nom" value="<?=$valued->nomdevise;?>"><input style="width:90%;" type="text" name="devise" value="<?=$valued->montantdevise;?>" onchange="this.form.submit()">
								</form><?php 
							}?>
						</div>
					</th><?php

					if (isset($_POST['gnfpaye']) or isset($_POST['europaye']) or isset($_POST['uspaye']) or isset($_POST['cfapaye'])){

						if ($total>0) {?>

							<th style="background-color: red; color: white; font-size: 35px;">Reste <label class="totalhaut"><?=" ". number_format(($total),0,',',' '); ?></label></th><?php

						}else{?>

							<th style="background-color: green; color: white; font-size: 35px;">Rendu <label class="totalhaut"><?=" ". number_format(($total),0,',',' '); ?></label></th><?php
						}

					}else{?>

						<th style="background-color: maroon; color: white; font-size: 35px;">TOTAL <label class="totalhaut"><?=" ". number_format(($total),0,',',' '); ?></label></th><?php
					}?>

				</tr>
			</thead>
		</table>
	

		<div class="espace"></div>

			<table style="margin-top: -10px;" class="payement">

				<thead>
					<tr>
						<th>Remise%</th>
						<th>Remise</th>
						<th colspan="2">GNF Payé</th>						
						<th style="width:20%;">US Payé</th>
						<th colspan="2">CFA Payé</th>                   
					</tr>

				</thead>

				<tbody>
					<form id='remise' method="POST" action="index.php">

						<tr>	
							<td><select name="remisep" onchange="this.form.submit()">
								<option value="<?=($prodvente['remise']/$panier->totalcom())*100;?>"><?=($prodvente['remise']/$panier->totalcom())*100;?></option>
								<option value="0">0</option><?php 
								$r=1;
								while ($r< 100) {?>
									<option value="<?=$r;?>"><?=$r;?>%</option><?php

									//$r=$r+4;

									$r++;
								}?>
							</select></td>

							<td><input style="font-size: 25px; font-weight: bold; width: 92%;" type="text" min="0" onchange="this.form.submit()" name="remise" value="<?=number_format($prodvente['remise'],0,',',' ');?>"></td>

							<td colspan="2"><?php 
								if (!empty($_SESSION['clientvipcash'])) {?>
									<input style="font-size: 25px; font-weight: bold; width: 92%;" type="text" min="0"  required=""  onchange="this.form.submit()" name="gnfpaye" value="<?=number_format($prodvente['montantpgnf'],0,',',' ');?>"><?php 
								}else{?>

									<input style="font-size: 25px; font-weight: bold; width: 92%;" type="text" min="0" onchange="this.form.submit()" name="gnfpaye" value="<?=number_format($prodvente['montantpgnf'],0,',',' ');?>"><?php 
								}?>
							</td>

							
							<input style="font-size: 25px; font-weight: bold; width: 92%;" type="hidden" min="0" onchange="this.form.submit()" name="europaye" value="<?=number_format($prodvente['montantpeu'],0,',',' ');?>">

							<td><input style="font-size: 25px; font-weight: bold; width: 92%;" type="text" min="0" onchange="this.form.submit()" name="uspaye" value="<?=number_format($prodvente['montantpus'],0,',',' ');?>"></td>

							<td colspan="2"><input style="font-size: 25px; font-weight: bold; width: 92%;" type="text" min="0" onchange="this.form.submit()" name="cfapaye" value="<?=number_format($prodvente['montantpcfa'],0,',',' ');?>"></td>

						</tr>
					</tbody>
					<thead>
						<tr><?php 
							if (!empty($_SESSION['alertesvirement'])) {?>
								<th colspan="2" style="color:red; width:10%;"><div style="color:red;"><?=$_SESSION['alertesvirement'];?></div></th><?php 
							}else{?>
								<th colspan="2">Versement Banque</th><?php 
							}?>

							<th colspan="3">Chèque</th>

							<th colspan="2">T. Payé</th>
						</tr>
					</thead>
					<tbody>

						<tr>

							<td><input style="font-size: 25px; font-weight: bold; width: 92%;" type="text" name="virement" value="<?=number_format($prodvente['virement'],0,',',' ');?>" onchange="this.form.submit()"></td>

							<td><?php 
								if ($prodvente['virement']!=0) {?>

									<select type="text" name="banque" required="" onchange="this.form.submit()"><?php

								}else{?>

									<select type="text" name="banque" onchange="this.form.submit()"><?php
								}
								 

								if (!empty($_SESSION['banque'])) {?>
									
									<option value="<?=$_SESSION['banque'];?>"><?=$panier->nomBanquefecth($_SESSION['banque']);?></option><?php
								}else{?>

									<option></option><?php
								}

								foreach($panier->nomBanqueVire() as $product){?>

		                            <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
		                        }?>
							</select></td>

							<td colspan="3">
								<input type="text" name="numcheque" value="<?=$prodvente['numcheque'];?>" placeholder="N° du Chèque" onchange="this.form.submit()" style="width: 35%; font-size:15px; font-weight: bold;"/><?php if (!empty($_SESSION['alerteschequep']) and empty($prodvente['numcheque'])) {?><div style="color:red;"><?=$_SESSION['alerteschequep'];?></div><?php }?>

								<select type="text" name="banqcheque" onchange="this.form.submit()" style="width: 25%;">
									<option value="ecobank">Ecobank</option>
					                <option value="bicigui">Bicigui</option>
					                <option value="bsic">Bsic</option>
					                <option value="uba">UBA</option>
					                <option value="banque islamique">Banque islamique</option>
					                <option value="skye bank">Skye Banq</option>
					                <option value="bci">BCI</option>
					                <option value="fbn">FBN</option>
					                <option value="societe generale">Société Générale</option>
					                <option value="orabank">Orabank</option>
								</select>

								<input type="text" name="cheque" value="<?=number_format($prodvente['cheque'],0,',',' ');?>" placeholder="montant du Chèque"  onchange="this.form.submit()" style="width: 30%; font-size:25px; font-weight: bold;">
							</td>

							<th colspan="2" style="background-color: green; font-size: 20px; width:5%;"><?= number_format(($totalpaye),0,',',' '); ?></th>	
						</tr>
					</tbody>

					</form>

					<thead>
						<tr>
							<th>Frais Sup</th>
							<th>Date Alerte</th>
							<th>Date Vente</th>
							<th>Compte de Dépôt</th>							
							<th>Vente Direct</th>
							<th colspan="2"></th>
						</tr>
					</thead>

					<tbody>

					<form id='payement' method="POST" action="payement.php"><?php

						if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

							<tr>
								<td style="width:20%;"><input style="font-size:25px; font-weight: bold;width: 92%;"  type="text" min="0" name="fraisup"></td>								

	                            <td style="width:20%;"><input style="height: 25px; width: 95%;" type="date" name="dateal"></td>

	                            <td style="width:20%;"><input style="height: 25px; width: 95%;" type="date" name="datev"></td>

	                            <td style="width:20%;">
									<select  name="compte" required="" ><?php
		                                $type='Banque';

		                                foreach($panier->nomBanqueCaisse() as $product){?>

		                                    <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
		                                }?>
		                            </select>
	                            </td>

	                            <td style="width:6%;"><select type="text" name="stockd">
	                            	<option value="<?=$panier->nomStock($_SESSION['lieuvente'])[2];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php 

		                            if ($_SESSION['level']>6) {

					                  foreach($panier->listeStock() as $product){?>

					                    <option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

					                  }?>

					                  <option value="general">Général</option><?php
					                }?></select>
					            </td><?php

	                            if (empty($_SESSION['clientvip']) and empty($_SESSION['clientvipcash'])) {
	                            }else{?>

	                            	<input type="hidden" name="reste" value="<?=$panier->total();?>">

		                            <td><input style="background-color:orange; cursor: pointer;" type="submit" name="proformat" value="Proformat"></td><?php

									if (!empty($_SESSION['clientvipcash'])) {

										if ($total<=0) {?>
											
											<td><input style="cursor: pointer;"  type="submit" name="payer" value="Valider"></td><?php
										}

									}else{?>

										<td><?php 
											if ($_SESSION['restriction']=='ok') {?>

												<input style="cursor: pointer;"  type="submit" name="payer" value="Valider"><?php 
											}?>
										</td><?php

									} 
								}?>
							</tr><?php

					    }else{

					    	if ($panier->licence()=="expiree") {?>

			   					<div class="alertes">Votre licence est expirée contactez DAMKO</div><?php
			   				}

					    }?>
					</form>
				</tbody>

				<tbody>
					<tr><?php 

						if($qtitetot!=0){?>
							<td>Carton(s): <?=$qtitetot;?></td><?php 
						}

						if($qtitetotp!=0){?>
							<td>Paquet(s): <?=$qtitetotp;?></td><?php 
						}

						if($qtitetotd!=0){?>
							<td>Détail(s): <?=$qtitetotd;?></td><?php 
						}?>
					</tr>
				</tbody>
			</table>
			</div><?php
	}else{
		
	}?>
</div>





