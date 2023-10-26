<?php require '_header.php'?>

<!DOCTYPE html>
<html>
<head>
    <title>Logescom-ms</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/commande.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/client.css" type="text/css" media="screen" charset="utf-8">   
</head>

<body>

	<style type="text/css">
.contenant {
  position: relative;
  text-align: center;
  color: red;
}

.texte_centrer {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: red;
  font-size: 20px;
  font-weight: bold;
}
</style>


<?php
	$products = $DB->queryI('SELECT num_licence, nom_societe, DATE_FORMAT(date_souscription, \'%d/%m/%Y\') AS datesouscript, DATE_FORMAT(date_fin, \'%d/%m/%Y\') AS datefin, date_fin FROM licence');

    foreach ( $products as $product ):?>

   	<?php endforeach; ?><?php
   	$now = date('Y-m-d');
   	$datefin = $product->date_fin;

   	$now = new DateTime( $now );
   	$now = $now->format('Ymd');
   	$datefin = new DateTime( $datefin );
   	$datefin = $datefin->format('Ymd');?>

   	<div class="headconnex"><?php

	   	if ($datefin-$now<6 AND $datefin-$now>0 ) {?>

	   		<div class="alertes">Votre Licence expire dans <?=$datefin-$now ;?> jour(s)</div><?php				

	   	}elseif ($panier->licence()=="expiree") {?>

	   		<div class="alertes">Votre Licence est expirée Contacter DAMKO</div><?php
	   		
	   	}else{?>

	   		<div class="descriptl" style="color: white;">Licence Valable jusqu'au: <?= $product->datefin; ?> à 23H59</div><?php

	   	}?>       	
		
		<div class="form_connexion">
			<div style="margin:auto;" class="contenant" >
				<img width="100%" height="50" src="css/img/bg-header.png">
				<div class="texte_centrer"><?=$panier->adresse();?></div>		        
	        </div>	

			<div class="conex_employer" >
				<form action="connexion1.php" method="post" name="connexion" id="naissance">
		                    
		            <fieldset><legend style="margin: auto;"><img width="80" height="80" alt=" " src="css/img/logodamko.jpg"></br></legend>
		            	<ol>Acceder à votre espace <?=$panier->adresse();?>
		            		<li><label>Nom d'utilisateur*</label> <input  type="text" name="pseudo" id="pseudo" required=""  /></li>
		            		<li><label>mot de passe*</label> <input  type="password" name="mdp" id="mdp" required=""  /></li>
		            	</ol>
			            <input type="submit" value="connexion" style="cursor: pointer;" />	                        
		            </fieldset>
		        </form>

		        <fieldset>

		        	<legend style="margin-bottom: 20px; font-size: 15px; font-weight: bold;margin-top: 15px;">À Propos de la licence et du logiciel </legend>
		        	<div class="descriptl">Logescom: logiciel de gestion commerciale</div>
		        	<div class="descriptl">Développé par la société DAMKO</div>
		            <div class="descriptl">Siège Social: Labé République de Guinée</div>
		            <div class="descriptl">Matricule N°: 11978 </div>
		            <div class="descriptl">NIF: 482907474</div>		            
		            <div class="descriptl">Tel:(00224) 628 16 19 28</div>
		            <div class="descriptl">Email:gestcomdev@gmail.com</div>
		            <div class="descriptl">Numéro licence: <?= $product->num_licence; ?> </div>
		            <div class="descriptl">Date de souscription: <?= $product->datesouscript; ?> </div>
		            <div class="descriptl" style="color: red;">Valable jusqu'au: <?= $product->datefin; ?> à 23H59</div>
		            <div class="copyright"><img src="img/copyright.jpg"> </div>		            
		            	
		        </fieldset>
	        </div>
		</div>
	</div>   	
</body>

</html>