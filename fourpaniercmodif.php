<div class="cmd"><?php

	if (isset($_GET['delpc'])) {

		$DB->delete('DELETE FROM fourvalidcomande WHERE id_produit = ? and pseudo=?', array($_GET['delpc'], $_SESSION['idpseudo']));
	}

	if (isset($_GET['numcmdmodif'])) {

		$DB->delete('DELETE FROM fourvalidcomande ');
			

		$_SESSION['numcmdmodif']=$_GET['numcmdmodif'];

		$prodcmd= $DB->query('SELECT *FROM fourachat  where numcmd=:num', array('num'=>$_SESSION['numcmdmodif']));

		foreach ($prodcmd as $value) {

			$DB->insert('INSERT INTO fourvalidcomande (id_produit, designation, quantite, pachat, pvente, previent, frais, etat, pseudo, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($value->id_produitfac, $value->designation, $value->quantite, $value->pachat, 0, 0, 0, 'cmd', $_SESSION['idpseudo']));
		}

	}else{

		

	}

	if (isset($_GET['desig'])) {

		$prodvalidcverif = $DB->querys('SELECT quantite FROM fourvalidcomande where id_produit=? and pseudo=?', array($_GET['idc'], $_SESSION['idpseudo']));

		if (empty($prodvalidcverif)) {
					
			$DB->insert('INSERT INTO fourvalidcomande (id_produit, designation, quantite, pachat, pvente, previent, frais, etat, pseudo, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($_GET['idc'], $_GET['desig'], 1, $_GET['pa'], 0, 0, 0, 'paye', $_SESSION['idpseudo']));

		}else{

			$qtitesup=$prodvalidcverif['quantite']+1;

			$DB->insert('UPDATE fourvalidcomande SET quantite=? where id_produit=? and pseudo=?', array($qtitesup, $_GET['idc'], $_SESSION['idpseudo']));

		}
	}

	if (isset($_GET['scanneurc'])) {

		$_SESSION['scannerc']=$_GET['scanneurc'];

		$prodstock = $DB->querys('SELECT *FROM productslist where codeb=:id', array('id'=>$_GET['scanneurc']));

		$prodvalidcverif = $DB->querys('SELECT quantite FROM fourvalidcomande where id_produit=? and pseudo=?', array($prodstock['id'], $_SESSION['idpseudo']));

		if (empty($prodvalidcverif)) {
					
			$DB->insert('INSERT INTO fourvalidcomande (id_produit, codebvc, designation, quantite, pachat, pvente, previent, frais, etat, pseudo, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($prodstock['id'], $_GET['scanneurc'], $prodstock['designation'], 1, $prodstock['prix_achat'], $prodstock['prix_vente'], 0, 0, 'paye', $_SESSION['idpseudo']));

		}else{ 
			$qtitesup=$prodvalidcverif['quantite']+1;

			$DB->insert('UPDATE fourvalidcomande SET quantite=? where id_produit=? and pseudo=?', array($qtitesup, $prodstock['id'], $_SESSION['idpseudo']));

		}
	}

	if (isset($_POST['modifcom']) or isset($_GET['modifcom'])) {
		
		$DB->insert('UPDATE fourvalidcomande SET quantite=?, pachat=?, frais=?, pvente=? where id_produit=? and pseudo=?', array($_POST['quantity'], $_POST['pachat'], 0, 0, $_POST['id'], $_SESSION['idpseudo']));
	}

	$prodvalidc = $DB->query("SELECT idprod as id, id_produit, fourvalidcomande.quantite as quantite, fourvalidcomande.designation as designation, pvente, pachat, prix_achat, prix_vente, frais, date_format(dateperemtion, \"%d/%m/%Y \") as dateperemtion FROM fourvalidcomande inner join `".$nomtab."` on idprod=fourvalidcomande.id_produit where pseudo='{$_SESSION['idpseudo']}' order by(fourvalidcomande.id)desc");

	if (!empty($prodvalidc)) {?>
	 	
	 	<table class="tabpanierc" style="margin-top: 30px;">

	 		<thead>

		 		<tr>			
					<th class="namec" height="30">Désignation</th>
					<th class="quantityc">Qtite</th>				
					<th class="quantityc">P. Achat</th>
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

				$ptotalht+=$ptotal;?>

				<form id="modifcom" action="fourcommandemodif.php?modifcom" method="POST">

					<tbody>

						<td style="text-align: left;"><?= ucfirst(strtolower($product->designation)); ?><input  type="hidden" name="id" value="<?=$product->id;?>"></td>

						<td><input  type="text" min="0" name="quantity" value="<?=$product->quantite;?>" onchange="this.form.submit()" ></td><?php

						if ($product->pachat==0) {?>

							<td><input type="text" min="0" name="pachat" value="<?=$product->prix_achat;?>"></td><?php

						}else{?>

							<td><input type="text" min="0" name="pachat" value="<?=$product->pachat;?>"></td><?php
						}?>

						<td><?=number_format($ptotal,0,',',' ');?></td>

						<td><input type="submit" name="modifcom" value="Valider" style="background-color: orange; color: white;"></td>					

						<td class="supc">
							<a onclick="return alerteV();" href="fourcommandemodif.php?delpc=<?= $product->id_produit; ?>" class="del"><img src="img/sup.jpg"></a>
						</td>

					</tbody>
				</form><?php
			}?>

			
		</table><?php 

		$ttcgnf=$ptotalht;?>


		<table class="tabpanierc" style="width: 50%; height: 30px; margin-top: 20px; margin-right: 120px;">

			<thead>

		      	<tr>

		       		<th height="35" style="background-color: black; font-size: 20px; text-align: right;">TTC GNF</th> 

		       		<th style="background-color: red; font-size: 20px;"><?=number_format($ttcgnf,0,',',' '); ?></th>
		      	</tr>

		    </thead>

		</table>

		<form id="naissance" method="POST" action="fourcommandemodif.php" style="margin-top: 0px; margin-top:10px;" >

			<fieldset><legend></legend>
	      <ol>
	      	<li><label>Montant de la Facture</label><input style="font-size:20px;" type="text" min="0"  name="prix_reel" value="<?=number_format($ptotalht,0,',',' '); ?>"></label><input style="font-size:25px;" type="hidden" min="0" value="0" name="montantc" required=""></li>

	      	<li>Fournisseur</label>
	        	<select  type="text" name="client" required="">
	            <option></option><?php
	            $type1='Fournisseur';
				$type2='Clientf';
				foreach($panier->clientF($type1, $type2) as $product){?>

	              <option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php

	            }?>
	          </select>
	        </li>
	        <input type="hidden" name="numcmd" value="<?=$_SESSION['numcmdmodif'];?>">
	      </ol>	      
	    </fieldset>
		<fieldset>
			<input style="cursor: pointer;" id="form" type="submit" name="payer" value="Valider" onclick="return alerteV();">
			
		</fieldset>	

	</form><?php 
}?>

</div>







