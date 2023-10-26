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

<page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;"><?php

    if (isset($_GET['proformat'])) {
      $Num_cmd=$_GET['proformat'];
    }else{
      $Num_cmd='';
    }

    $payement=$DB->querys('SELECT *FROM proformat WHERE num_pro= ?', array($Num_cmd));

      

      if ($payement['id_client']==0) {
        $_SESSION['nameclient']=$payement['nomclient'];
        $_SESSION['reclient']=$payement['nomclient'];
      }else{

        $_SESSION['nameclient']=$payement['id_client'];
        $_SESSION['reclient']=$payement['id_client'];

      }

      $idc=$payement['id_client'];  

      $lieuvente=$payement['lieuvente'];    
      
      require 'headerticketclient.php'; ?>

      <table style="margin:0px; font-size: 14px;color: black; background: white;" >

        <tr>
          <td><strong><?php echo "Proformat N°: " .$Num_cmd; ?></strong></td>
        </tr>  

        <tr>
          <td><?php echo "Date:  " .(new DateTime($payement['datepro']))->format('d/m/Y'); ?></td>
        </tr>

        <tr>
          <td><?php echo "Vendeur:  " .$panier->nomPersonnel($payement['vendeur']); ?></td> 
        </tr>

      </table>

      <table style="margin-top: 30px; margin-left:0px;" class="border">

        <tbody>

          <tr>
            <th style="width: 10%; padding-right: 5px; text-align: center;">Qtité</th>
            <th style="width: 40%; text-align: left;text-align: center;">Désignation</th>
            <th style="width: 22%; text-align: center;">Prix Unitaire</th>
            <th style="width: 28%; padding-right: 10px; text-align: center;">Prix Total</th>
          </tr>

        </tbody>
      </table>

      <table style="margin-top: 1px; margin-left:0px;" class="border">

        <tbody><?php

          $total=0;

           $products=$DB->query('SELECT * FROM proformat inner join productslist on productslist.id=proformat.id_produit WHERE num_pro= ?', array($Num_cmd));

           $nbreligne=sizeof($products);
          $totqtite=0;
          foreach ($products as $product){

            $totqtite+=$product->quantity;?>

            <tr>

              <td style="width: 10%;"><?= $product->quantity; ?></td>

                <td style="width: 40%;text-align:left"><?=ucwords(strtolower($product->designation)); ?></td>

                <td style="width: 22%; text-align:right"><?=number_format($product->prix_vente,0,',',' '); ?></td>

                <td style="width: 28%; text-align:right; padding-right: 10px;"><?= number_format($product->prix_vente*$product->quantity,0,',',' '); ?></td><?php

              $price=($product->prix_vente*$product->quantity);

              $total += $price;?>

            </tr><?php
          }

          $total=$total;

          $montantverse=0;

          $Remise=0;

          $ttc = $total-$Remise;

          $tot_Rest=0;

          if ($nbreligne==1) {

            $top=(205/($nbreligne));
          }else{

            $top=(205-($nbreligne*10));
          }?>
        
        <tr>

          <td colspan="2" style="border:1px; border-bottom: 0px; padding-top: <?=$top.'px';?>;" class="space"></td>
          <td colspan="2" style="border:1px; padding-top:<?=$top.'px';?>;" class="space"></td>
        </tr>

        <tr>
          <td colspan="2" rowspan="4" style="padding: 2px; text-align: left; font-size:18px;"></td>
        </tr>

        <tr>
          <td style="text-align: right; margin-bottom: 5px" class="no-border">Total Net </td>
          <td style="text-align:right; padding-right: 5px;"><?php echo number_format($ttc,0,',',' ') ?></td>
        </tr>

      </tbody>

    </table>

    <table style="margin-top: 30px; margin-left:0px;" class="border">

    <thead>

      <tr>
        <th style="width: 0%; border-right: 0px; border-bottom: 0px;"></th>
        <th style="width: 0%; text-align: left; border-right: 0px; border-bottom: 0px;"></th>
        <th style="width: 10%; border-right: 0px; border-bottom: 0px;"></th>
        <th style="width: 90%; padding-right: 10px;border-bottom: 0px;"></th>
      </tr>

    </thead>

    <tbody><?php

      if ($tot_Rest<=0) {?>

        <tr style="margin-top: 10px; width: 100%">
          <td style="border-right: 0px;"></td>

          <td style="border-right: 0px;"></td>
          <td colspan="2" rowspan="4" style=" padding-right: 15px; text-align: right; font-size:16px;"><br/><?php 


              if ($panier->soldeclient()<0) {?>

                Solde Compte: <?=number_format(($panier->soldeclient()),0,',',' ');

              }else{?>

                Solde Compte: <?=number_format(-($panier->soldeclient()),0,',',' ');
              }?>
          </td>

        </tr><?php

      }else{?>

        <tr style="margin-top: 10px; width: 100%">

          <td style="border-right: 0px;"></td>
          <td style="border-right: 0px;"></td>
          <td colspan="2" rowspan="4" style="padding-right: 15px; text-align: right; font-size:16px;"><?php echo"Montant versé: ".number_format($montantverse,0,',',' ');?><br/><?php 

              if ($panier->soldeclient()<0) {?>

                Solde Compte: <?=number_format(($panier->soldeclient()),0,',',' ');

              }else{?>

                Solde Compte: <?=number_format(-($panier->soldeclient()),0,',',' ');
              }?>
          </td>

        </tr><?php

      }?>

    </tbody>
  </table>
<?php

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
    $pdf->Output('ticket'.date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
//header("Refresh: 10; URL=index.php");
?>