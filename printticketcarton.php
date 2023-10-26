<?php
require_once "lib/html2pdf.php";
ob_start(); ?>

<?php require '_header.php';?>

<style type="text/css">

body{
  margin: 0px;
  width: 100%;
  height:68%;
  padding:0px;}
  .ticket{
    margin:0px;
    width: 100%;
  }
  table {
    width: 100%;
    color: #717375;
    font-family: helvetica;
    line-height: 10mm;
    border-collapse: collapse;
  }
  
  .border th {
    border: 1px solid black;
    padding: 0px;
    font-weight: bold;
    font-size: 14px;
    color: black;
    background: white;
    text-align: right;
    height: 30px; }
  .border td {
    line-height: 15mm;
    border: 1px solid black;    
    font-size: 14px;
    color: black;
    background: white;
    text-align: center;
    height: 18px;
  }
  .footer{
    font-size: 14px;
    font-style: italic;
  }

</style>

<page backtop="5mm" backleft="5mm" backright="5mm" backbottom="5mm" footer="page;"><?php

    if (!empty($_SESSION['numcmdmodif'])) {
      $Num_cmd=$_SESSION['numcmdmodif'];
      unset($_SESSION['numcmdmodif']);
    }else{
      if (!isset($_GET['ticketclient'])) {
        $Num_cmd=$_SESSION['rechercher'];
      }
    }

    if (isset($_GET['ticketclient'])) {
      $Num_cmd=$_GET['ticketclient'];
    }

    $payement=$DB->querys('SELECT num_cmd, montantpaye, remise, reste, etat, num_client, DATE_FORMAT(date_cmd, \'%d/%m/%Y \à %H:%i:%s\')AS DateTemps, vendeur, DATE_FORMAT(datealerte, \'%d/%m/%Y\') as datealerte FROM payement WHERE num_cmd= ?', array($Num_cmd));

    $frais=$DB->querys('SELECT numcmd, montant, motif  FROM fraisup WHERE numcmd= ?', array($Num_cmd));

    $_SESSION['reclient']=$payement['num_client'];
    $_SESSION['nameclient']=$payement['num_client'];
    require 'headerticketclient.php';?>

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

      <table style="margin-top: 30px; margin-left:0px;" class="border">

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
            }?>

            <tr>

              <td style="width: 44%;text-align:left"><?=ucwords(strtolower($product->designation)); ?></td>

              <td style="width: 8%;"><?= $product->quantity; ?></td>

              <td style="width: 8%;"><?= $product->qtiteliv.'/'.$product->quantity; ?></td>

              <td style="width: 17%; text-align:right"><?=number_format($product->prix_vente,0,',',' '); ?></td>

              <td style="width: 23%; text-align:right; padding-right: 10px;"><?= number_format($product->prix_vente*$product->quantity,0,',',' '); ?></td><?php

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

          $ttc = $total-$Remise;

          $tot_Rest = $total-$montantverse;

          $top=(135/($nbreligne));
         ?>
        
        <tr>

          <td colspan="3" style="border:1px; border-bottom: 0px; padding-top: <?=$top.'px';?>;" class="space"></td>
          <td colspan="2" style="border:1px; padding-top:<?=$top.'px';?>;" class="space"></td>
        </tr>

        <tr>
          <td colspan="3" rowspan="4" style="padding: 2px; text-align: left; font-size:10px;"><?php 

            if($totqtite!=0){

              echo "Carton(s) Acheté(s):".$totqtite." Carton(s) Livré(s): ".$totqtiteliv;
            }?><br/><?php

            if($totqtitep!=0){

              echo "Paquet(s) Acheté(s):".$totqtitep." Paquet(s) Livré(s): ".$totqtitelivp;
            }?><br/><?php

            if($totqtitep!=0){

              echo "Détail(s) Acheté(s):".$totqtited." Détail(s) Livré(s): ".$totqtitelivd;
            }?>
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

      <tfoot>

        <tr><?php

          if ($tot_Rest<=0) {?>
          
            <td colspan="5" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px;"><?="Montant Total Payé: ".number_format($montantverse,0,',',' ');?></td><?php

          }else{?>

            <td colspan="3" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px; border-right: 0px;"><?="Montant Total Payé: ".number_format($montantverse,0,',',' ');?> GNF</td>

            <td colspan="2" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px;"><?="Reste à Payer: ".number_format($tot_Rest,0,',',' ');?> GNF</td><?php

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
      </tfoot>
    </table>

    <table class="border" style="margin-top:5px;">
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
</div><?php

require 'piedprintticket.php';
  $content = ob_get_clean();
  try {
    $pdf = new HTML2PDF("p","A4","fr", true, "UTF-8" , 0);
    $pdf->pdf->SetAuthor('Amadou');
    $pdf->pdf->SetTitle("facture");
    $pdf->pdf->SetSubject('Création d\'un Portfolio');
    $pdf->pdf->SetKeywords('HTML2PDF, Synthese, PHP');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->writeHTML($content);
    $pdf->Output(date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
//header("Refresh: 10; URL=index.php");
?>