<?php
require 'header.php';

if (isset($_SESSION['pseudo'])) {
    
    if ($_SESSION['statut']!='vendeur') {

		if (isset($_GET['ajout_en'])) {?>

			<div class="col">
			
			    <form id="naissance" method="POST" action="personnel.php" style="width: 60%;">

			    	<fieldset><legend>Ajouter un Personnel</legend>
			    		<ol>
			    			<li>
								<label>Type personnel</label><select type="text" name="perso" required="">
									<option></option>
									<option value="responsable">Responsable</option>
									<option value="vendeur">Vendeur</option>
									<option value="livreur">Livreur</option>
								</select> 
						  	</li>

							<li>
								<label>Nom</label>
								<input type="text" name="nom" required="">
							</li>

							<li>
							    <label>Téléphone</label>
							    <input type="text" name="tel" >
							</li>


							<li>
							    <label>Email</label>
							    <input type="text" name="mail" maxlength="100">
							</li>

							<li>
							    <label>Pseudo</label>
							    <input type="text" name="pseudo" >
							</li>

							<li>
							    <label>Mot de Passe</label>
							    <input type="text" name="mdp" >
							</li>

							<li><label>Lieu de Vente</label><select type="text" name="lieuvente" required="">
								<option></option><?php 
								foreach ($panier->listeStock() as $value) {?>
									
									<option value="<?=$value->id;?>"><?=ucwords($value->nomstock);?></option><?php
								}?></select>
							</li>

							<li>
								<label>Niveau</label>
								<select type="number" name="niv" required="">
									<option value="1">Niveau 1</option>
									<option value="2">Niveau 2</option>
									<option value="3">Niveau 3</option>
									<option value="4">Niveau 4</option>
									<option value="5">Niveau 5</option>
									<option value="6">Niveau 6</option>
									<option value="7">Niveau 7</option>

								</select>  
							</li>

					  	</ol>

					</fieldset>

					<fieldset><input type="reset" value="Annuler" name="annuldec" style="cursor: pointer;" /><input type="submit" value="Valider" name="ajouteen" onclick="return alerteV();" style="margin-left: 30px; cursor: pointer;"/></fieldset>
				</form>
			</div><?php
		}

		if(isset($_POST['ajouteen'])){?>
				
			<div class="col"><?php

				if($_POST['nom']!=""  and $_POST['perso']!=""){
					
					$nom=addslashes(Htmlspecialchars($_POST['nom']));
					$phone=addslashes(Htmlspecialchars($_POST['tel']));
					$pseudo=addslashes(Nl2br(Htmlspecialchars($_POST['pseudo'])));
					$mdp=addslashes(Nl2br(Htmlspecialchars($_POST['mdp'])));
					$type=addslashes(Nl2br(Htmlspecialchars($_POST['perso'])));
					$niveau=addslashes(Nl2br(Htmlspecialchars($_POST['niv'])));
					$email=addslashes(Nl2br(Htmlspecialchars($_POST['mail'])));
					$lieuvente=addslashes(Nl2br(Htmlspecialchars($_POST['lieuvente'])));

					$mdp=password_hash($mdp, PASSWORD_DEFAULT);			

					$nb=$DB->querysI('SELECT id from login where nom=:nom', array(
						'nom'=>$nom
						));

						if(!empty($nb)){?>
							<div class="alertes">Ce Personnel est déjà enregistré</div><?php
						}else{

							$nb=$DB->querys('SELECT max(id) as id from login');


							$matricule=$nb['id']+1;

							$DB->insertI('INSERT INTO login(identifiant, nom, telephone, email, pseudo, mdp, level, statut, lieuvente, dateenreg) values(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($matricule, $nom, $phone, $email, $pseudo, $mdp, $niveau, $type, $lieuvente));

							?>	

							<div class="alerteV">Personnel ajouté avec succée!!!</div><?php
						}

					

				}else{?>	

					<div class="alertes">Remplissez les champs vides</div><?php
				}?>

				</div><?php
			}


		//Modifier un enseignant

		if (isset($_GET['modif_en'])) {?>

			<div class="col">
			
			    <form id="naissance" method="POST" action="personnel.php" style="width: 60%;">

			    	<fieldset><legend>Modifier un personnel</legend>
			    		<ol><?php

						$prodm=$DB->querysI('SELECT * from login where id=:mat', array('mat'=>$_GET['modif_en']));?>

			    		<li>
							<label>Type personnel</label><select type="text" name="perso" required="">
								<option value="<?=$prodm['statut'];?>"><?=$prodm['statut'];?></option>
								<option value="responsable">Responsable</option>
								<option value="vendeur">Vendeur</option>
								<option value="livreur">Livreur</option>
							</select>

							<input type="text" name="id" value="<?=$_GET['modif_en'];?>"> 
					  	</li>

						<li>
							<label>Nom</label>
							<input type="text" name="nom" value="<?=$prodm['nom'];?>">
						</li>

						<li>
						    <label>Téléphone</label>
						    <input type="text" name="tel" value="<?=$prodm['telephone'];?>" >
						</li>

						<li>
						    <label>Email</label>
						    <input type="text" name="mail" value="<?=$prodm['email'];?>" >
						</li>

						<li>
						    <label>Pseudo</label>
						    <input type="text" name="pseudo" value="<?=$prodm['pseudo'];?>" >
						</li>

						<li>
						    <label>Mot de Passe</label>
						    <input type="text" name="mdp" >
						</li>

						<li><label>Lieu de Vente</label><select type="text" name="lieuvente" required="">
							<option value="<?=$prodm['lieuvente'];?>"><?=$panier->nomStock($prodm['lieuvente'])[0];?></option><?php 
							foreach ($panier->listeStock() as $value) {?>
								
								<option value="<?=$value->id;?>"><?=ucwords($value->nomstock);?></option><?php
							}?></select>
						</li>

						<li>
							<label>Niveau</label>
							<select type="number" name="niv" required="">
								<option value="<?=$prodm['level'];?>"><?=$prodm['level'];?></option>
								<option value="1">Niveau 1</option>
								<option value="2">Niveau 2</option>
								<option value="3">Niveau 3</option>
								<option value="4">Niveau 4</option>
								<option value="5">Niveau 5</option>
								<option value="6">Niveau 6</option>
								<option value="7">Niveau 7</option>
							</select>  
						</li>

					  	</ol>

					</fieldset>

					<fieldset><input type="reset" value="Annuler" name="annuldec" style="cursor: pointer;" /><input type="submit" value="Modifier" name="modifen" onclick="return alerteV();" style="margin-left: 30px; cursor: pointer;"/></fieldset>
				</form>
			</div><?php
		}

		if(isset($_POST['modifen'])){
				
			$nom=addslashes(Htmlspecialchars($_POST['nom']));
			$phone=addslashes(Htmlspecialchars($_POST['tel']));
			$pseudo=addslashes(Nl2br(Htmlspecialchars($_POST['pseudo'])));
			$mdp=addslashes(Nl2br(Htmlspecialchars($_POST['mdp'])));
			$type=addslashes(Nl2br(Htmlspecialchars($_POST['perso'])));
			$niveau=addslashes(Nl2br(Htmlspecialchars($_POST['niv'])));
			$email=addslashes(Nl2br(Htmlspecialchars($_POST['mail'])));
			$lieuvente=addslashes(Nl2br(Htmlspecialchars($_POST['lieuvente'])));

			$mdp=password_hash($mdp, PASSWORD_DEFAULT);			

			$DB->insertI('UPDATE login SET nom = ?, telephone=?, email=?, pseudo=?, mdp=?, level=?, statut=?, lieuvente=?  WHERE id = ?', array($nom, $phone, $email, $pseudo, $mdp, $niveau, $type, $lieuvente, $_POST['id']));?>	

			<div class="alerteV"> Modification effectuée avec succée!!!</div><?php
			
		}

		// fin modification

	    if (isset($_GET['enseig']) or isset($_POST['ajouteen'])  or isset($_GET['del_en']) or isset($_GET['del_pers']) or isset($_POST['modifen']) or isset($_GET['matiereen']) or isset($_GET['personnel']) or isset($_GET['payempcherc'])) {

	    	if (isset($_GET['del_pers'])) {

	          $DB->deleteI('DELETE FROM login WHERE id = ?', array($_GET['del_pers']));?>

	          <div class="alerteV">Suppression reussie!!!</div><?php 
	        }


	        $statut='personnel';
	        $level=6;

	        if ($_SESSION['level']==$level) {
	        	$prodm=$DB->queryI("SELECT * from login where type='{$statut}' and lieuvente='{$_SESSION['lieuvente']}'");
	        }else{
				$prodm=$DB->queryI("SELECT * from login where type='{$statut}'");
			}?>

				<div class="col">
		    
			    	<table class="payement" style="width: 80%; margin-top: 40px;">

			    		<thead>
		    				<tr>
		                    	<th colspan="2" class="info" style="text-align: center">Liste du personnels</th>

								<th colspan="5"><a href="personnel.php?ajout_en" style="color: white;">Ajouter un personnel</a></th>
		                    	
		                  	</tr>

							<tr>
								<th>Nom & Prénom</th>
								<th>Fonction</th>
								<th>Phone</th>
								<th>E.mail</th>
								<th>Identifiant</th>

								<th colspan="2"></th>
							</tr>

						</thead>

						<tbody><?php

							if (empty($prodm)) {
								# code...
							}else{

								foreach ($prodm as $formation) {?>

									<tr>

										<td><?=ucwords($formation->nom);?></td>

										<td><?=ucfirst($formation->statut);?></td>

				                        <td><?=$formation->telephone;?></td>

				                        <td><?=$formation->email;?></td>

										<td><?=$formation->pseudo;?></td>
										

										<td colspan="2">
											<a href="personnel.php?modif_en=<?=$formation->id;?>"><input type="button" value="Modifier" style="width: 45%; font-size: 16px; background-color: orange; color: white; cursor: pointer"></a>

				                        	<a href="personnel.php?del_pers=<?=$formation->id;?>" onclick="return alerteS();"><input type="button" value="Supprimer" style="width: 50%; font-size: 16px; background-color: red; color: white; cursor: pointer"></a>
				                        </td><?php

									}?>

								</tr><?php
							}?>

						
						</tbody>

					</table>

				</div><?php
			}
		}
	
}?>

		

<script type="text/javascript">
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script>