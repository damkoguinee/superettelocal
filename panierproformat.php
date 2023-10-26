<div class="tableau">
	
	<?php $totalp=$panier->total();		

	if (isset($_POST['remise']) AND $_POST['remise']!=0) {

		$total=($panier->totalu()-$_POST['remise']);

		$_SESSION['remise']=$_POST['remise'];

	}elseif(isset($_POST['montant_paye'])){

		$total=($panier->totalu()-$_SESSION['remise']-$_POST['montant_paye']);

		$_SESSION['reste']=$total;

		$_SESSION['montant_paye']=$_POST['montant_paye'];

	}else{

		$total=$panier->totalu();

		$_SESSION['remise']=0;
		$_SESSION['montant_paye']=0;

	}

	if (isset($_SESSION['$quantite_rest']) AND $_SESSION['$quantite_rest']!=array()) {?>

		<div class="alertes"><?php echo $_SESSION['$quantite_rest']; ?></div><?php

	}else{

		if (isset($_SESSION['error']) AND $_SESSION['error']!= array()) {?>

			<div class="alertes"><?php echo $_SESSION['error']; ?></div><?php

		}else{


		}
	}

	if($_SESSION['panier']!=array()){?>

		<form id="client" action="proformat.php" method="POST">
			<table class="client">
				<tbody>
					<tr>

						<td class="nameclient"><select name="seleclient" onchange="document.getElementById('client').submit()" >
							<?php 
							if (empty($_SESSION["seleclient"])) {?>

								<option value=""></option>
								<option value="VIP">VIP</option>
								<option value="CLIENT">Client</option></select><?php

							}else{?>						

								<option value=""><?php echo $_SESSION["seleclient"];?></option>
								<option value="VIP">VIP</option>
								<option value="CLIENT">Client</option></select><?php

							}?>					
								
						</td><?php

						if (isset($_POST['montant_paye'])){

							if (isset($_SESSION['reste']) AND $_SESSION['reste']>0) {?>

								<th style="width: 30%; background-color: red; color: white; font-size: 30px;">RESTE</th>
								<th class="totalhaut"><?=" ". number_format(($total),2,',',' '); ?></th><?php

							}else{?>

								<th style="width: 30%; background-color: green; color: white; font-size: 30px;">RENDU</th>
								<th class="totalhaut" style="color: green;"><?=" ". number_format(($total),2,',',' '); ?></th><?php
							}

						}else{?>

							<th style="width: 30%; background-color: maroon; color: white; font-size: 30px;">TOTAL</th>
							<th class="totalhaut"><?=" ". number_format(($total),2,',',' '); ?></th><?php
						}?>

					</tr>

				</tbody>

			</table>

		</form><?php

	}?>	
		

	<form id='monform' method="POST" action="proformat.php"> <?php //Pour alerter dans index?>	

		<table class="tabpanier"><?php

			$ids = array_keys($_SESSION['panier']);

			if(empty($ids)){

				$products = array();

			}else{

				$products = $DB->query('SELECT * FROM products WHERE id IN ('.implode(',',$ids).')');?>

				<thead>

					<th class="img"></th>
					<th class="name">Désignation</th>
					<th class="price">P. Unit</th>
					<th class="quantity">Qtité</th>
					<th class="pricet" >P. Total</th>
					<th class="sup">Retirer</th>

				</thead><?php

			}

			foreach($products as $product): ?>

				<tbody>

					<td class="img"><a href="#"> <img src="img/<?= $product->id; ?>.jpg" height="25" width="25"></a></td>

					<td class="name" style="text-align: left;"><?= $product->designation; ?></td><?php

					if(isset($_POST['panieru']['quantity']) AND $_POST['panieru']['quantity']!=$product->prix_vente){?>

						<td class="pricec"><input type="number" min="0" onchange="document.getElementById('monform').submit()" name="panieru[quantity][<?= $product->id; ?>]" value="<?= $_SESSION['panieru'][$product->id]; ?>"></td><?php

					}elseif (isset($_POST['seleclient']) OR isset($_POST['remise']) OR isset($_POST['montant_paye'])) {

						if (array_sum($_SESSION['panieru'])<=$_SESSION['limite']) {?>

							<td class="pricec"><input type="number" min="0" onchange="document.getElementById('monform').submit()" name="panieru[quantity][<?= $product->id; ?>]" value="<?=$product->prix_vente; ?>"></td><?php
						}else{?>

						 	<td class="pricec"><input type="number" min="0" onchange="document.getElementById('monform').submit()" name="panieru[quantity][<?= $product->id; ?>]" value="<?= $_SESSION['panieru'][$product->id]; ?>"></td><?php

						} 
						
						
					}else{?>

						<td class="pricec"><input type="number" min="0" onchange="document.getElementById('monform').submit()" name="panieru[quantity][<?= $product->id; ?>]" value="<?=$product->prix_vente; ?>"></td><?php
					}?>

					<td class="quantity"><input  type="number" min="0" onchange="document.getElementById('monform').submit()" name="panier[quantity][<?= $product->id; ?>]" value="<?= $_SESSION['panier'][$product->id]; ?>"></td><?php

					if(isset($_POST['panieru']['quantity']) AND $_POST['panieru']['quantity']!=$product->prix_vente){?>

						<td class="pricet" style="text-align: right;"><?= number_format($_SESSION['panieru'][$product->id] *$_SESSION['panier'][$product->id],2,',',' '); ?></td><?php

					}elseif (isset($_POST['seleclient']) OR isset($_POST['remise']) OR isset($_POST['montant_paye'])){

						if (array_sum($_SESSION['panieru'])<=$_SESSION['limite']) {?>

							<td class="name"><?=number_format($product->prix_vente*$_SESSION['panier'][$product->id],2,',',' '); ?></td><?php

						}else{?>

						 	<td class="name"><?=number_format($_SESSION['panier'][$product->id]*$_SESSION['panieru'][$product->id],2,',',' '); ?></td><?php

						} 

					}else{?>

						<td class="pricet" style="text-align: right;"><?= number_format($product->prix_vente *$_SESSION['panier'][$product->id],2,',',' '); ?></td><?php

					}?>

					<td class="sup">
						<a href="proformat.php?delPanier=<?= $product->id; ?>" class="del"><img src="img/sup.jpg"></a>
					</td>

				</tbody>
			<?php endforeach; ?>

		</table>
	</form>

	<div class="espace"></div><?php

	if ($totalp!=0) {?>

		
		<table style="margin-top: 10px;" class="border_panier">

			<thead>
				<tr>
					<th style="width: 22%;">REMISE</th>
					<th style="width: 35%;">MONTANT REMIS</th><?php

					if (isset($_POST['montant_paye'])){

						if (isset($_SESSION['reste']) AND $_SESSION['reste']>0) {?>

							<th style="width: 35%; background-color: red; font-size: 18px;">RESTE À PAYER</th><?php

						}else{?>

							<th style="width: 35%; background-color: green; font-size: 18px;">RENDU CLIENT</th><?php
						}

					}else{?>

						<th style="width: 35%; background-color: maroon; font-size: 18px;">TOTAL CMD</th><?php
					}?>	

					<th style="width: 8%;">PAYEMENT</th>                    
				</tr>

			</thead>

			<tbody>
				<tr>
					<form id='remise' method="POST" action="proformat.php">
						<?php
						if ($_SESSION['remise']==0) {?>

							<td><input type="number" min="0" onchange="document.getElementById('remise').submit()" name="remise"></td> <?php

						}else{?>

							<td><input type="text" min="0" onchange="document.getElementById('remise').submit()" name="remise" value="<?= number_format($_SESSION['remise'],2,',',' '); ?>"></td><?php
						}?>

					</form>

					<form id='avance' method="POST" action="proformat.php">

						<?php
						if ($_SESSION['montant_paye']==0) {?>

							<td><input type="number" min="0" onchange="document.getElementById('avance').submit()" name="montant_paye"></td> <?php

						}else{?>

							<td><input type="text" min="0" onchange="document.getElementById('avance').submit()" name="montant_paye" value="<?= number_format($_SESSION['montant_paye'],2,',',' '); ?>"></td><?php
						}?>

					</form>

					<form action="addformat.php" method="POST" id="naissance" target="_blank" >		

						<td style="text-align: center; font-size: 25px;"><?= number_format(($total),2,',',' '); ?><input style="font-size: 0px; width: 0px; height: 0px;" type="text" name="reste" value="<?= number_format(($total),2,',',' '); ?>"></td>

						<td class="name"><select name="mode_payement" >
							<option value="especes">Especes</option>
							<option value="vire Bancaire">vire bancaire</option>
							<option value="cheque">Cheque</option></select>
						</td>

					</tr>

				</tbody>

			</table><?php

				

			if (isset($_POST['montant_paye']) AND empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {

			    if (!empty($_SESSION["seleclient"]) AND $_SESSION["seleclient"]=="VIP") {

			    	$products = $DB->query('SELECT * FROM client ');?>

			    	<table style="margin-top: 10px;" class="border_panier">

						<thead>

							<tr>
								<th>Frais sup</th>
								<th>Selectionnez un client</th>
							</tr>

						</thead>

				    	<tbody>

				    		<tr>
				    			<td><input type="text" name="fraisup"></td>

				    			<td><select type="text" name="client" required="">

				    				<option></option><?php
				    				foreach ($products as $value) {?>

				    					<option value="<?=$value->nom_client;?>"><?=$value->nom_client;?></option><?php

				    				}?></select>
				    			</td>
				    		</tr>
				    	</tbody>

				    </table><?php

				}else{?>

					<table style="margin-top: 10px;" class="border_panier">

						<thead>

							<tr>

								<th>Frais sup</th>
								<th>Saisir le nom du client</th>
							</tr>
						</thead>

						<tbody>
							<td><input type="text" name="fraisup"></td>
							<td><input type="text" name="client" value="" required=""></td>
						</tbody>
					</table><?php

				}?>

				<input id="button" type="submit" name="payer" value="Valider">
					<?php

		    }else{

		    	if ($panier->licence()=="expiree") {?>

   					<div class="alertes">Votre licence est expirée contactez DAMKO</div><?php
   				}

		    }?>
		</form><?php

	}else{
		// Aucune commande en-cours
	}?>
</div>


