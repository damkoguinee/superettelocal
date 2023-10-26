<?php
require 'header.php';?>

<style type="text/css">

.search{
  display: flex;
  flex-wrap: nowrap;
}
  .history{
    width: 50%;
    margin-top: 30px;
  }
 .ticket{
    margin-right: 50px;
    width: 50%;
    height:100%;
  }

  table {
    width: 100%;
    color: #717375;
    font-family: helvetica;
    line-height: 6mm;
    border-collapse: collapse;
  }
  
  .border th {
    border: 2px solid #CFD1D2;
    padding: 0px;
    font-weight: bold;
    font-size: 16px;
    color: black;
    background: white;
  }
  .border td {
    line-height: 6mm;
    border: 0px solid #CFD1D2;    
    font-size: 16px;
    color: black;
    background: white;
    text-align: center;}
</style><?php

if (isset($_GET['reclient'])) {
  $_SESSION['reclient']=$_GET['reclient'];
}

$products = $DB->query('SELECT * FROM adresse ');

foreach ( $products as $adress ):?>

<?php endforeach ?><?php 

require 'enteterechercher.php';

if (isset($_POST['rechercher']) or isset($_GET['recreditc']) or !empty($_SESSION['num_cmdp'])) {  

  if (isset($_POST['rechercher'])){

    $Num_cmd=$_POST['rechercher'];
  }

  if (isset($_GET['recreditc'])){

    $Num_cmd=$_GET['recreditc'];
  }

  if (!empty($_SESSION['num_cmdp'])) {
    $Num_cmd=$_SESSION['num_cmdp'];
    $_SESSION['rechercher']=$Num_cmd;
    unset($_SESSION['num_cmdp']);
  }?>

  <div class="search">

    <div class="ticket" style="display: flex; width:100%;"><?php


    $_SESSION['rechercher']=$Num_cmd;


    $payement=$DB->querys('SELECT num_cmd, montantpaye, remise, reste, etat, num_client, nomclient, DATE_FORMAT(date_cmd, \'%d/%m/%Y \à %H:%i:%s\')AS DateTemps, vendeur, DATE_FORMAT(datealerte, \'%d/%m/%Y\') as datealerte FROM payement WHERE num_cmd= ?', array($Num_cmd));

    $adress = $DB->querys('SELECT * FROM adresse ');

      $frais=$DB->querys('SELECT numcmd, montant, motif  FROM fraisup WHERE numcmd= ?', array($Num_cmd));

      if ($payement['num_client']==0) {
        $_SESSION['nameclient']=$payement['nomclient'];
        $_SESSION['reclient']=$payement['nomclient'];
      }else{

        $_SESSION['nameclient']=$payement['num_client'];
        $_SESSION['reclient']=$payement['num_client'];

      }

      $idc=$payement['num_client'];
      //require 'headerticketclient.php';?>

      <div>

      <table style="margin:0px; font-size: 14px;color: black; background: white;" >

        <tr>
          <td><strong><?php echo "Facture N°: " .$Num_cmd; ?></strong></td>
        </tr>

        <tr>
          <td><?php echo "Date:  " .$payement['DateTemps']; ?></td>
        </tr><?php 
        if ($payement['etat']=='credit' and !empty($payement['datealerte'])) {?>

          <tr>
            <td style="color: red;"><?= "A régler avant le:  " .$payement['datealerte']; ?></td>
          </tr><?php 
        }?>

        <tr>
          <td><?php echo "Vendeur:  " .$panier->nomPersonnel($payement['vendeur']); ?></td>  
        </tr>

      </table>

        <table style="margin-top: 3px; margin-left:0px;" class="border">

          <tbody>

            <tr>            
              <th style="width: 44%; text-align: left;text-align: center;">Désignation</th>
              <th style="width: 8%; padding-right: 5px; text-align: center;">Qtité</th>
              <th style="width: 8%; padding-right: 5px; text-align: center;">Livré</th>
              <th style="width: 17%; text-align: center;">Prix Unitaire</th>
              <th style="width: 23%; padding-right: 10px; text-align: center;">Prix Total</th>
            </tr>

          </tbody>

          <tbody><?php

            $total=0;

             $products=$DB->query('SELECT quantity, commande.prix_vente as prix_vente, designation, qtiteliv, type FROM commande inner join productslist on productslist.id=commande.id_produit WHERE num_cmd= ?', array($Num_cmd));

            $nbreligne=sizeof($products);
            $totqtite=0;
            $totqtiteliv=0;

            $totqtitep=0;
            $totqtitelivp=0;
            $totqtited=0;
            $totqtitelivd=0;
            foreach ($products as $product){

              if ($product->type=='en_gros') {
                $totqtite+=$product->quantity;

                $totqtiteliv+=$product->qtiteliv;
              }elseif ($product->type=='detail') {
                $totqtited+=$product->quantity;

                $totqtitelivd+=$product->qtiteliv;
              }else{

                $totqtitep+=$product->quantity;

                $totqtitelivp+=$product->qtiteliv;
              }

              if (empty($product->prix_vente)) {
                $pv='Offert';
                $pvtotal='Offert';
              }else{
                $pv=number_format($product->prix_vente,0,',',' ');
                $pvtotal=number_format($product->prix_vente*$product->quantity,0,',',' ');
              }?>

              <tr>

                <td style="width: 44%;text-align:left"><?=ucwords(strtolower($product->designation)); ?></td>

                <td style="width: 8%;"><?= $product->quantity; ?></td>

                <td style="width: 8%;"><?= $product->qtiteliv.'/'.$product->quantity; ?></td>

                <td style="width: 17%; text-align:right"><?=$pv; ?></td>

                <td style="width: 23%; text-align:right; padding-right: 10px;"><?= $pvtotal; ?></td><?php

                $price=($product->prix_vente*$product->quantity);

                $total += $price;?>

              </tr><?php
            }

            if (!empty($frais['motif'])) {

              $nbreligne=sizeof($products)+1;?>

              <tr>              
                <td style="width: 44%;text-align:left"><?=ucwords($frais['motif']); ?></td>
                <td style="width: 8%;">-</td>
                <td style="width: 8%;">-</td>

                <td style="width: 17%; text-align:right"><?=number_format($frais['montant'],0,',',' '); ?></td>

                <td style="width: 23%; text-align:right; padding-right: 10px;"><?= number_format($frais['montant'],0,',',' '); ?></td>
              </tr><?php
            }

            $total=$total+$frais['montant'];

            $montantverse=$payement['montantpaye'];

            $Remise=$payement['remise'];

             $reste=$payement['reste'];

            $ttc = $total-$Remise;

            $tot_Rest = $total-$montantverse;

            if ($nbreligne==1) {

              $top=(205/($nbreligne));
            }else{

              $top=(205-($nbreligne*10));
            }
           ?>
          
          <tr>

            <td colspan="3" style="border:1px; border-bottom: 0px; padding-top: <?=$top.'px';?>;" class="space"></td>
            <td colspan="2" style="border:1px; padding-top:<?=$top.'px';?>;" class="space"></td>
          </tr>

          <tr>
            <td colspan="3" rowspan="4" style="padding: 2px; text-align: left; font-size:10px;">
            </td>
          </tr>

          <tr>
            <td style="text-align: right; border-left: 1px;" class="no-border">Montant Total </td>
            <td style="text-align:right; padding-right: 5px;"><?php echo number_format($total,0,',',' ') ?></td>
          </tr>

          <tr>
            <td style="text-align: right;" class="no-border">Montant Remise</td>               
            <td style="text-align:right; padding-right: 5px;"><?php echo number_format($Remise,0,',',' ') ?></td>        
          </tr>

          <tr>
            <td style="text-align: right; margin-bottom: 5px" class="no-border">Net à Payer </td>
            <td style="text-align:right; padding-right: 5px;"><?php echo number_format($ttc,0,',',' ') ?></td>
          </tr>

        </tbody>

        <tbody>

          <tr><?php

            if ($tot_Rest<=0) {?>
            
              <td colspan="3" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px; border-right: 0px;"><?="Montant Total Payé: ".number_format($montantverse,0,',',' ');?></td>

              <td colspan="2" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px;"><?="Rendu au Client: ".number_format(-$reste,0,',',' ');?> GNF</td><?php

            }else{?>

              <td colspan="3" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px; border-right: 0px;"><?="Montant Total Payé: ".number_format($montantverse,0,',',' ');?> GNF</td>

              <td colspan="2" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px;"><?="Reste à Payer: ".number_format($tot_Rest-$Remise,0,',',' ');?> GNF</td><?php

            }?>
          </tr>

          <tr>
            <th colspan="5" style="border:0px; border-left: 1px; border-right: 1px;"></th>
          </tr>

          <tr>
            <td colspan="5" style="font-size: 16px; text-align: center;"><?php

              $name=$_SESSION['nameclient'];?>Solde de vos Comptes:

              <label style="padding-right: 30px;">GNF: <?=number_format(($panier->soldeclientgen($name,'gnf')),0,',',' ');?></label><label style="background-color: white; color:white;">espa</label>

              <label style="margin-right: 10px;">€: <?=number_format(($panier->soldeclientgen($name,'eu')),0,',',' ');?></label><label style="background-color: white; color:white;">espa</label>

              <label style="margin-right: 10px;">$: <?=number_format(($panier->soldeclientgen($name,'us')),0,',',' ');?></label><label style="background-color: white; color:white;">espa</label>

              <label style="margin-right: 10px;">CFA: <?=number_format(($panier->soldeclientgen($name,'cfa')),0,',',' ');?></label>
            </td>
          </tr>

          <tr>
            <td colspan="5" style="font-size:14px;"><?php

            if ($adress['nom_mag']=='ETS BBS (Beauty Boutique Sow)') {

              if($totqtite!=0){

                echo "Carton(s) Acheté(s):".$totqtite." --- Livré(s): ".$totqtiteliv;
              }?><?php

              if($totqtitep!=0){

                echo " Paquet(s) Acheté(s):".$totqtitep." --- Livré(s): ".$totqtitelivp;
              }?><?php

              if($totqtited!=0){

                echo " Détail(s) Acheté(s):".$totqtited." --- Livré(s): ".$totqtitelivd;
              }
            }?>
              
            </td>
          </tr>
        </tbody>
      </table>

      <table class="border" style="margin-top:0px;">
        <thead>

          <tr>
            <td colspan="3" style="text-align:center; padding-top:3px;">Vos modes de paiements</td>
          </tr>

          <tr>
            <td style="text-align:center;">Espèces</td>
            <td style="text-align:center;">Chèque</td>
            <td style="text-align:center;">Versment Bancaire</td>
          </tr>
        </thead>

        <tbody>

          <tr>
            <td style="text-align: center;">
              <?php
                  if (!empty($panier->modep($Num_cmd, 'gnf')[0])) {?>

                    GNF: <?=number_format($panier->modep($Num_cmd, 'gnf')[0],0,',',' ');?> <label style="background-color: white; color:white;">espa</label><?php 
                  }
                  if (!empty($panier->modep($Num_cmd, 'eu')[0])) {?>

                    €: <?=number_format($panier->modep($Num_cmd, 'eu')[0],0,',',' ').'*'.$panier->modep($Num_cmd, 'eu', 1)[1];?><label style="background-color: white; color:white;">espa</label><?php 
                  }

                  if (!empty($panier->modep($Num_cmd, 'us')[0])) {?>
                    $: <?=number_format($panier->modep($Num_cmd, 'us')[0],0,',',' ').'*'.$panier->modep($Num_cmd, 'us', 1)[1];?><label style="background-color: white; color:white;">espa</label><?php 
                  }

                  if (!empty($panier->modep($Num_cmd, 'cfa')[0])) {?>
                  CFA: <?=number_format($panier->modep($Num_cmd, 'cfa')[0],0,',',' ').'*'.$panier->modep($Num_cmd, 'cfa', 1)[1];?><label style="background-color: white; color:white;">espa</label><?php 
                  }?>
            </td>

            <td><?php 

              if (!empty($panier->modep($Num_cmd, 'cheque')[0])) {?>
                <?=number_format($panier->modep($Num_cmd, 'cheque')[0],0,',',' ');?><?php 
              }?>
            </td>

            <td><?php

              if (!empty($panier->modep($Num_cmd, 'virement')[0])) {?>
                <?=number_format($panier->modep($Num_cmd, 'virement')[0],0,',',' ');?><?php 
              }?>
            </td>
          </tr>
          
        </tbody>
      </table>
    </div>
  </div><?php
}?>

<script>
function suivant(enCours, suivant, limite){
  if (enCours.value.length >= limite)
  document.term[suivant].focus();
}

function focus(){
document.getElementById('reccode').focus();
}

function alerteS(){
  return(confirm('Confirmer la suppression?'));
}

function alerteM(){
  return(confirm('Confirmer la modification'));
}

function alerteF(){
  return(confirm('Confirmer la femeture de la caisse'));
}
</script>

