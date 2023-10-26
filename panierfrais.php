<div class="cmd"><?php

	if (isset($_GET['delpc'])) {

		$DB->delete('DELETE FROM validcomandefrais WHERE id_produit = ? and pseudo=?', array($_GET['delpc'], $_SESSION['idpseudo']));
	}

	if (isset($_GET['desig'])) {

		$prodvalidcverif = $DB->querys('SELECT quantite FROM validcomandefrais where id_produit=? and pseudo=?', array($_GET['idc'], $_SESSION['idpseudo']));

		if (empty($prodvalidcverif)) {
					
			$DB->insert('INSERT INTO validcomandefrais (id_produit, designation, quantite, pachat, pvente, previent, frais, etat, pseudo, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($_GET['idc'], $_GET['desig'], 1, $_GET['pa'], $_GET['pv'], 0, 0, 'paye', $_SESSION['idpseudo']));

		}else{

			$qtitesup=$prodvalidcverif['quantite']+1;

			$DB->insert('UPDATE validcomandefrais SET quantite=? where id_produit=? and pseudo=?', array($qtitesup, $_GET['idc'], $_SESSION['idpseudo']));

		}
	}

	if (isset($_GET['scanneurc'])) {

		$_SESSION['scannerc']=$_GET['scanneurc'];

		$prodstock = $DB->querys('SELECT *FROM productslist where codeb=:id', array('id'=>$_GET['scanneurc']));

		$prodvalidcverif = $DB->querys('SELECT quantite FROM validcomandefrais where id_produit=? and pseudo=?', array($prodstock['id'], $_SESSION['idpseudo']));

		if (empty($prodvalidcverif)) {
					
			$DB->insert('INSERT INTO validcomandefrais (id_produit, codebvc, designation, quantite, pachat, pvente, previent, frais, etat, pseudo, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($prodstock['id'], $_GET['scanneurc'], $prodstock['designation'], 1, $prodstock['prix_achat'], $prodstock['prix_vente'], 0, 0, 'paye', $_SESSION['idpseudo']));

		}else{

			$qtitesup=$prodvalidcverif['quantite']+1;

			$DB->insert('UPDATE validcomandefrais SET quantite=? where id_produit=? and pseudo=?', array($qtitesup, $prodstock['id'], $_SESSION['idpseudo']));

		}
	}

	if (isset($_POST['modifcom']) or isset($_GET['modifcom'])) {
		
		$DB->insert('UPDATE validcomandefrais SET quantite=?, pachat=?, frais=?, pvente=? where id_produit=? and pseudo=?', array($_POST['quantity'], $_POST['pachat'], $_POST['frais'], $_POST['pvente'], $_POST['id'], $_SESSION['idpseudo']));
	}

	$prodvalidc = $DB->query("SELECT idprod as id, id_produit, `".$nomtab."`.quantite as qtites, validcomandefrais.quantite as quantite, validcomandefrais.designation as designation, pvente, pachat, prix_achat, prix_vente, frais, date_format(dateperemtion, \"%d/%m/%Y \") as dateperemtion FROM validcomandefrais inner join `".$nomtab."` on idprod=validcomandefrais.id_produit where pseudo='{$_SESSION['idpseudo']}' order by(validcomandefrais.id)desc");

	if (!empty($prodvalidc)) {?>
	 	
	 	<table class="tabpanierc" style="margin-top: 30px;">

	 		<thead>

	 			<tr><th colspan="8">Stock de départ: <?=$_SESSION['nomtab'];?></th></tr>

		 		<tr>			
					<th class="namec" height="30">Désignation</th>
					<th class="quantityc">Qtite</th>				
					<th class="quantityc">P. Achat</th>
					<th class="quantityc">Frais</th>
					<th class="quantityc">P. Vente</th>
					<th class="quantityc">P. Total</th>	
					<th></th>			
					<th class="sup">Sup</th>
				</tr>

			</thead>

			<?php

			$ptotalht=0;
			$totfrais=0;

			foreach($prodvalidc as $key=> $product){

				$ptotal=$product->quantite*$product->pachat;
				$pfrais=$product->frais;

				$ptotalht+=$ptotal;
				$totfrais+=$product->frais*$product->quantite;?>

				<form id="modifcom" action="transfertprodfrais.php?modifcom" method="POST">

					<tbody>

						<td style="text-align: left;"><?= ucfirst(strtolower($product->designation)); ?><input  type="hidden" name="id" value="<?=$product->id;?>"></td>

						<td><input  type="number" min="0" name="quantity" max="<?=$product->qtites;?>" value="<?=$product->quantite;?>"></td><?php

						if ($product->pachat==0) {?>

							<td><input type="text" min="0" name="pachat" value="<?=$product->prix_achat;?>"></td><?php

						}else{?>

							<td><input type="text" min="0" name="pachat" value="<?=$product->pachat;?>"></td><?php
						}?>

						<td><input type="text" name="frais" required="" value="<?=$product->frais;?>"></td><?php

						if ($product->pvente==0) {?>

							<td><input type="text" min="0" name="pvente" value="<?=$product->prix_vente;?>"></td><?php

						}else{?>

							<td><input type="text" min="0" name="pvente" value="<?=$product->pvente;?>"></td><?php
						}?>

						<td><?=number_format($ptotal,0,',',' ');?></td>

						<td><input type="submit" name="modifcom" value="Valider" style="background-color: orange; color: white;"></td>					

						<td class="supc">
							<a onclick="return alerteV();" href="transfertprodfrais.php?delpc=<?= $product->id_produit; ?>" class="del"><img src="img/sup.jpg"></a>
						</td>

					</tbody>
				</form><?php
			}?>

			
		</table><?php 

		$ttcgnf=$ptotalht*1;?>


		<table class="tabpanierc" style="width: 50%; height: 30px; margin-top: 20px; margin-right: 120px;">

			<thead>

		      	<tr>
		      		<th height="35" style="background-color: black; font-size: 20px; text-align: right;">FRAIS TOTAUX</th>
		      		<th style="background-color: red; font-size: 20px;"><?=number_format($totfrais,0,',',' '); ?></th>

		       		<th height="35" style="background-color: black; font-size: 20px; text-align: right;">TTC</th> 

		       		<th style="background-color: red; font-size: 20px;"><?=number_format($ptotalht,0,',',' '); ?></th>

		       		<th height="35" style="background-color: black; font-size: 20px; text-align: right;">TTC GNF</th> 

		       		<th style="background-color: red; font-size: 20px;"><?=number_format($ttcgnf,0,',',' '); ?></th>
		      	</tr>

		    </thead>

		</table>

		<form id="naissance" method="POST" action="transfertprodfrais.php" style="margin-top: 0px; margin-top:10px;" >

			<fieldset><legend></legend>
	      <ol>
	      	<input type="hidden" min="0"  name="numfact">
	      	<li><label>Date de Transfert</label><input type="date"  name="datefact" required=""></li>
	      	<li><label>Montant de la Facture</label><input style="font-size:20px;" type="text" min="0"  name="prix_reel" value="<?=number_format($ptotalht,0,',',' '); ?>"></label><input style="font-size:25px;" type="hidden" min="0" value="0" name="montantc" required=""></li>

	      	<li>Lieu de Livraison</label>

	        	<select  type="text" name="lieuliv" required="">
	        	<option></option><?php 

	        	if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {?>

	            	<option value="<?=$panier->nomStock($_SESSION['lieuvente'])[2];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php 
	            }else{?>

		            <option value="multiples">Multiples</option><?php

					foreach($panier->listeStock() as $product){?>

		              <option value="<?=$product->id;?>"><?=$product->nomstock;?></option><?php

		            }
		        }?>
	          </select></label>
	        </li>
	      </ol>

	      <ol style="background-color:orange;">

	      	<li style="font-size: 18px;"><label>Frais Totaux: </label><?=number_format($totfrais,0,',',' ');?><input style="width: 150px; font-size: 22px; " type="hidden" name="fraistot" value="<?=$totfrais;?>" min="0"></li><?php 
	      	if (empty($totfrais)) {
	      		$required='';
	      	}else{
	      		$required='required=""';
	      	}?>

	      	<li><label>Frais de Transport</label><input style="width: 150px; font-size: 22px; " type="text" min="0"  name="frais" <?=$required;?> ><input style="width: 150px; font-size: 22px; " type="hidden" name="fraistp" value="0" min="0">

	        	Transporteur
	        	<select  type="text" name="clientt">
	            <option></option><?php
	            $type1='transporteur';
				$type2='transporteur';
				foreach($panier->clientF($type1, $type2) as $product){?>

	              <option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php

	            }?>
	          </select>infos: Le compte du transporteur sera credité du montant des frais
	        </li>

	        <li><label>Autres Frais</label><input style="width: 150px; font-size: 22px; " type="text" min="0"  name="fraisa" >infos: ces frais sont directement decaissés dans la caisse du magasin de reception
	        </li>
	      </ol>
	    </fieldset>
		<fieldset>
			<input style="cursor: pointer;" id="form" type="submit" name="payer" value="Valider" onclick="return alerteV();">
			
		</fieldset>	

	</form><?php 
}?>

</div>







