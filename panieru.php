<div class="tableau" style="margin-top: -70px;"><?php

	$ids = array_keys($_SESSION['stock']);

	if(empty($ids)){

		//require 'stock.php';

		$products = array();

	}else{

		$product = $DB->querys("SELECT idprod as id, designation, Marque, `".$nomtab."`.codeb as codeb, prix_achat, prix_vente, prix_revient, quantite, `".$nomtab."`.qtiteintp as qtiteintp, qtiteintd, dateperemtion FROM `".$nomtab."` inner join productslist on idprod=productslist.id WHERE idprod IN (".implode(',',$ids).")");

		$_SESSION['designation']=$product['designation'];

		$_SESSION['id']=$product['id'];

		if (empty($_SESSION['modifvente'])) {?>

			<form target="_blank" id='naissance' method="POST" action="insertcodeb.php" style="width: 70%;">

				<ol>

					<li><label>Entrer le code barre</label><?php
						if (empty($product['codeb'])) {?>

							<input  type="text" name="cbarre" min="0" value="<?= $product['id']; ?>"><?php

						}else{?>

							<input  type="text" name="cbarre" min="0" value="<?= $product['codeb']; ?>"><?php
						}?>

						<input type="hidden" name="id" value="<?= $product['id']; ?>">
						<input type="hidden" name="prix" value="<?= $product['prix_vente']; ?>">

						<a href="" style="text-decoration: none; "><input style="width: 150px; margin-left: 30px; cursor: pointer;" type="submit" name="payercb" value="Modifier" onclick="return alerteM()"></a>

						
					</li>
				</ol>
			</form><?php
		}?>

		<form id='naissance' method="POST" action="modif.php" enctype="multipart/form-data" style="width: 70%;">

			<fieldset><legend>Effectuer des modifications sur ?</legend>

				<ol><?php

					if (empty($_SESSION['modifvente'])) {?>
						<li>
							<a href="update.php?delPanierstock=<?= $product['id']; ?>" style="width: 100%;height: 30px; font-size: 18px; font-weight: bold; background-color: red;color: white; cursor: pointer;">Supprimer le produit</a>
						</li>

						<li><?= $product['designation']; ?>
							<input type="hidden" value="<?=$product['id'];?>" name="id">

							<input type="hidden" name="marque" value="<?= $product['designation']; ?>">

							<input type="hidden" name="nom" value="<?= $product['Marque']; ?>">
						</li>

							<?php
					}?>

					<li><label>Prix Unitaire</label><?php

						if (empty($_SESSION['modifvente'])) {?>

							<input type="number" name="prixv" value="<?=$product['prix_vente'];?>"><?php

						}else{?>

							<input type="number" name="prixv" min="0" onchange="document.getElementById('naissance').submit()">
							<input type="hidden" name="id" value="<?= $_SESSION['modifvente']; ?>"><?php
						}?>
					</li>

					<li><label>Prix d'Achat</label>

						<input type="number" name="prixa" value="<?=$product['prix_achat'];?>" >
					</li>

					<li><label>Prix de Revient</label>

						<input type="number" name="prixr" value="<?=$product['prix_revient'];?>" >
					</li><?php

					if (empty($_SESSION['modifvente'])) {?>

						<li><label>Quantité</label><?php

							if ($products['level']>3) {?>

								<input  type="number" name="quantite" value="<?=$product['quantite'];?>"><?php

							}else{?>

								<input  type="number" name="quantite" min="0" value="<?=$product['quantite'];?>"><?php

							}?>
						</li>

						<li><label>Quantite Paquet</label>

							<input type="number" name="qtiteintp" value="<?=$product['qtiteintp'];?>" >
						</li>

						<li><label>Quantite int</label>

							<input type="number" name="qtiteint" value="<?=$product['qtiteintd'];?>" >
						</li>

						<li><label>Date</label>

							<input type="date" name="datep" value="<?=$product['dateperemtion'];?>" >
						</li>

						<li><label>Image</label>

							<input type="file" name="photo" id="photo"  />
						</li><?php
					}?>

				</ol>
			</fieldset>

			<fieldset>
				<div style="display: flex;">
					<div>
						<a href="update.php?delPanierstock=<?= $product['id']; ?>" style="text-decoration: none; width: 200px; "><input style="width: 150px; cursor: pointer;" type="submit" name="payer" value="Retour"></a>
					</div><?php

					if (empty($_SESSION['modifvente'])) {?>

						<div>

							<a href="" style="text-decoration: none; "><input style="width: 150px; margin-left: 30px; cursor: pointer;" type="submit" name="payer" value="Modifier" onclick="return alerteM()"></a>
						</div><?php
					}?>
				</div>

			</fieldset>
			
		</form><?php
	}?>
	
</div>


