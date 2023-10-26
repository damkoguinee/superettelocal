<?php
require_once "lib/html2pdf.php";

ob_start(); ?>
<?php require '_header.php';?>
<style type="text/css">

body{
  margin: auto;
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
    border-collapse: collapse;
  }
  
  .border th {
    border: 1px solid black;
    font-weight: bold;
    font-size: 11px;
    color: black;
    background: white;
    text-align: center; }
  .border td {
    border: 1px solid black;  
    height: 10px;
    padding-top: 10px; 
    padding-bottom: 5px; 
    font-size: 11px;
    color: black;
    background: white;
    text-align: left;
  }
  .footer{
    font-size: 30px;
    font-style: italic;
  }

  .legende{
    font-size: 18px;
    text-align: center;
    padding-bottom: 5px;
    padding-top: 5px;
  }

</style>

<page backtop="10mm" backleft="3mm" backright="3mm" backbottom="10mm" footer="page;">

  <?php require 'headerticket.php';

  $nomtab=$panier->nomStock($_GET['stock'])[1];

  $idstock=$panier->nomStock($_GET['stock'])[0];

  

  $colspan=count($panier->listeStock());?>
  <table class="border" style="margin: auto;">

    <thead>

        <tr>
            <th height="20" colspan="<?=$colspan+5;?>"><?="Etat du Stock à la date du " .date('d/m/Y'); ?></th>
        </tr>

        <tr>
          <th></th>
          <th >Désignation</th><?php

          foreach ($panier->listeStock() as $value) {?>

            <th style="height: 10px; font-size: 9.5px;"><?=ucwords(strtolower($value->nomstock));?></th><?php
          }?>

          <th style="font-size: 9.5px;">Tot</th>
          <th style="font-size: 9.5px;">NO Liv</th>
          <th style="font-size: 9.5px;">dispo</th>

        </tr>

    </thead>

    <tbody><?php 

      foreach ($panier->listeProduit() as $key => $valuep) {?>

        <tr>
          <td><?=$key+1;?></td>
          <td style="font-size: 12px;"><?=ucwords(strtolower($valuep->designation));?></td><?php

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

</page>
<?php
  $content = ob_get_clean();
  try {
    $pdf = new HTML2PDF("p","A4","fr", true, "UTF-8" , 0);
    $pdf->pdf->SetAuthor('Amadou');
    $pdf->pdf->SetTitle(date("d/m/y"));
    $pdf->pdf->SetSubject('Création d\'un Portfolio');
    $pdf->pdf->SetKeywords('HTML2PDF, Synthese, PHP');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->writeHTML($content);
    $pdf->Output('stock imprime le '.date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
?>