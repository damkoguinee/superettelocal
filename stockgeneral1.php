<?php require 'header.php';

if (isset($_GET['nomstock']) and $_GET['nomstock']!=0) {

    $_SESSION['nomtab']=$panier->nomStock($_SESSION['idnomstock'])[1];

}else{

    $_SESSION['idnomstock']=0;
    $_SESSION['nomstock']='stock general';

}
require 'headerstock.php';?>

<div style="display: flex;">

  <div><?php require 'navstock.php';?></div>

  <div style="width: 100%;"><?php 

  	$colspan=count($panier->listeStock());?>
  	<table class="payement">

    	<thead>

        	<tr>
          		<th colspan="<?=$colspan+4;?>"><?="Etat du Stock à la date du " .date('d/m/Y'); ?><a href="printstock1.php?stock=<?=$_GET['recherche'];?>" target="_blank" ><img  style=" margin-left: 20px; height: 20px; width: 20px;" src="css/img/pdf.jpg"></a> 

          		<input style="width:400px;" id="search-user" type="text" name="recherchgen" placeholder="rechercher un produit" />

                <div style="color:white; background-color: black; font-size: 11px;" id="result-search"></div></th>
        	</tr>

        	<tr>
        		<th width="200">Désignation</th><?php

        		foreach ($panier->listeStock() as $value) {?>

        			<th style="width: 45px; height: 100px; font-size: 11px;"><?=$value->nomstock;?></th><?php
        		}?>

        		<th style="font-size: 12px;">Tot</th>
        		<th style="font-size: 12px;">NO Liv</th>
        		<th style="font-size: 12px;">dispo</th>

        	</tr>

    	</thead>

    	<tbody><?php 

    		foreach ($panier->listeProduit() as $key => $valuep) {?>

    			<tr>
    				<td><?=ucwords(strtolower($valuep->designation));?></td><?php

    				$totqtite=0;

    				foreach ($panier->listeStock() as $valueS) {

    					$prodqtite = $DB->querys("SELECT quantite FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where productslist.id='{$valuep->id}'");

    					$totqtite+=$prodqtite['quantite'];

    					if (empty($prodqtite['quantite'])) {
    					 	$qtite='';
    					}else{
    						$qtite=number_format($prodqtite['quantite'],0,',',' ');
    					} ?>

    					<td style="text-align: center;"><?=$qtite;?></td><?php


    				}

    				$prodcmd=$DB->querys("SELECT sum(quantity-qtiteliv) as qtitenl from commande where id_produit='{$valuep->id}'");

                    $nonlivre=$prodcmd['qtitenl'];

                    $dispo=$totqtite-$nonlivre;

                    if (empty($totqtite)) {
					 	$totqtite='';
					}else{
						$totqtite=number_format($totqtite,0,',',' ');
					}


					if (empty($nonlivre)) {
					 	$nonlivre='';
					}else{
						$nonlivre=number_format($nonlivre,0,',',' ');
					}

					if (empty($dispo)) {
					 	$dispo='';
					}else{
						$dispo=number_format($dispo,0,',',' ');
					}?>

    				<td style="text-align: center;"><?=$totqtite;?></td>

    				<td style="text-align: center;"><?=$nonlivre;?></td>

    				<td style="text-align: center;"><?=$dispo;?></td>    				

    			</tr><?php
    		}?>

        </tbody>
    </table>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?stockgeneral',
                    data: 'user=' + encodeURIComponent(utilisateur),
                    success: function(data){
                        if(data != ""){
                          $('#result-search').append(data);
                        }else{
                          document.getElementById('result-search').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                        }
                    }
                })
            }
      
        });
    });
</script>