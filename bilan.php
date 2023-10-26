<?php
require 'header.php';

if (!empty($_SESSION['pseudo'])) {

	if (!isset($_POST['j1'])) {

	    $_SESSION['date']=date("Ymd");  
	    $dates = $_SESSION['date'];
	    $dates = new DateTime( $dates );
	    $dates = $dates->format('Ymd'); 
	    $_SESSION['date']=$dates;
	    $_SESSION['date1']=$dates;
	    $_SESSION['date2']=$dates;
	    $_SESSION['dates1']=$dates; 

	}else{

	    $_SESSION['date1']=$_POST['j1'];
	    $_SESSION['date1'] = new DateTime($_SESSION['date1']);
	    $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
	    
	    $_SESSION['date2']=$_POST['j2'];
	    $_SESSION['date2'] = new DateTime($_SESSION['date2']);
	    $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

	    $_SESSION['dates1']=$_SESSION['date1'];
	    $_SESSION['dates2']=$_SESSION['date2'];   
	}

	if (!isset($_GET['conectC'])) {
		require 'navbulletin.php';
	}

	$client=$_GET['bclient'];
	$devise=$_GET['devise'];

	$soldea=0;
  	$solded=0;
  	$soldes=0;
  	$soldet=0;
  	$solde=0;
  	$zero=0;
  	if (isset($_POST['j1']) or isset($_POST['j2'])) {

    	$prod =$DB->query("SELECT client.nom_client as client, libelles, numero, montant, date_versement, devise FROM bulletin inner join client on client.id=bulletin.nom_client WHERE bulletin.nom_client='{$client}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <='{$_SESSION['date2']}' ORDER BY (date_versement)");

  	}else{

    	$prod =$DB->query("SELECT bulletin.nom_client as client, libelles, numero, montant, date_versement, devise FROM bulletin inner join client on client.id=bulletin.nom_client WHERE bulletin.nom_client='{$client}' and devise='{$devise}' ORDER BY (date_versement)");
  	}?>

	<table class="payement">
		<thead>
			<tr>
				<th colspan="6" style="font-size: 20px;">Relevé de <?=$panier->nomClient($client);?> Tel: <?=$panier->nomClientad($client)[1];?><a style="margin-left: 10px;"href="printcompte.php?compte=<?=$client;?>&tel=<?=$panier->nomClientad($client)[1];?>&devise=<?=$devise;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a></th>

				<th style="font-size: 20px; color: orange;">Compte <?=strtoupper($devise);?></th>
			</tr>

			<tr>
				<th>Ordre</th>
				<th>Date</th>
				<th>Désignation</th>
				<th>Facturation</th>
				<th>Encaissement</th>
				<th>Décaissement</th>
				<th>Solde</th>
			</tr>
		</thead>
		<tbody><?php 
			$solde=0;
			foreach ($prod as $key => $value) {

				$produit =$DB->query("SELECT * FROM commande WHERE num_cmd='{$value->numero}'");

				$solde+=$value->montant;?>

				<tr>
					<td style="text-align: center;"><?=$key+1;?></td>

					<td style="text-align: center;"><?=(new dateTime($value->date_versement))->format('d/m/Y');?></td><?php 

					if ($value->libelles=='reste à payer') {

						$soldea+=$value->montant;?>

						<td>
							<a style="color: red;" href="recherche.php?recreditc=<?=$value->numero;?>&reclient=<?=$value->client;?>"><?=ucwords(strtolower($value->libelles)).' facture '.$value->numero;?></a>
						</td>
						
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($value->montant);?>"><?=number_format((-1)*$value->montant,0,',',' ');?></td>

						<td></td>
						<td></td>
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solde);?>"><?=number_format(-$solde,0,',',' ');?></td><?php

					}elseif($value->libelles!='reste à payer' and $value->montant>=0){

						$solded+=$value->montant;?>

						<td><a style="color: red;" href="versement.php?recreditc=<?=$value->numero;?>&reclient=<?=$value->client;?>"><?=ucwords(strtolower($value->libelles)).' N°'.$value->numero;?></a></td>
						<td></td>						
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($value->montant);?>"><?=number_format($value->montant,0,',',' ');?></td>
						<td></td>
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solde);?>"><?=number_format(-$solde,0,',',' ');?></td><?php

					}else{

						$soldes+=$value->montant;;?>

						<td><a style="color: red;" href="dec.php?recreditc=<?=$value->numero;?>&reclient=<?=$value->client;?>"><?=ucwords(strtolower($value->libelles)).' N°'.$value->numero;?></a></td>
						<td></td>
						<td></td>	

						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($value->montant);?>"><?=number_format((-1)*$value->montant,0,',',' ');?></td>

						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solde);?>"><?=number_format(-$solde,0,',',' ');?></td><?php

					}?>
				</tr><?php 
			}?>
		</tbody>

		<tfoot>
			<tr>
				<th colspan="3">Totaux</th>
				<th style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($soldea);?>"><?=number_format(-$soldea,0,',',' ');?></th>

				<th style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solded);?>"><?=number_format($solded,0,',',' ');?></th>

				<th style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($soldes);?>"><?=number_format(-$soldes,0,',',' ');?></th>

				<th style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solde);?>"><?=number_format(-$solde,0,',',' ');?></th>
			</tr>
		</tfoot>

	</table><?php
	// code...
}