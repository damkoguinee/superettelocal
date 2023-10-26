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
    border-collapse: collapse;
    margin: auto;
  }
  
  .border th {
    border: 1px solid black;
    padding:5px;
    font-weight: bold;
    font-size: 11px;
    color: black;
    background: white;
    text-align: center; }
  .border td {
    padding-bottom: 5px;
    padding-top: 5px;
    border: 1px solid black;    
    font-size: 11px;
    color: black;
    background: white;
    text-align: left;
    padding-right: 10px;}
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

<page backtop="10mm" backleft="5mm" backright="5mm" backbottom="10mm" footer="page;">

  <?php 

  require 'headerticket.php';

  $datenormale=date("d/m/Y à H:i"); ?></div>

  <table  class="border">

          <thead>

            <tr>
              <th colspan="9" ><?="Liste des Depenses à la date du " .$datenormale ?></th>
            </tr>

            <tr>
              <th>N°</th>
              <th>Date</th>
              <th>Motif</th>              
              <th>GNF</th>
              <th>$</th>
              <th>€</th>
              <th>CFA</th>
              <th>V. Banque</th>
              <th>Chèque</th>
            </tr>

          </thead>

          <tbody><?php
            $montantgnf=0;
            $montanteu=0;
            $montantus=0;
            $montantcfa=0;
            $virement=0;
            $cheque=0;
            $keyd=0;

            $categorie= $DB->query("SELECT *FROM categoriedep order by(nom) ");

            foreach ($categorie as $key => $valuedep) {

              $products=$DB->query("SELECT decdepense.id as id, montant, devisedep as devisedec, payement as type, coment, date_payement AS DateTemps FROM decdepense where categorie='{$valuedep->id}' ");

              if (!empty($products)) {?>

                <tr><td colspan="9" style="text-align: center;font-weight: bold; "><?=strtoupper($valuedep->nom);?></td></tr><?php
              }

              $montantgnff=0;
              $montanteuu=0;
              $montantuss=0;
              $montantcfaa=0;
              $virementt=0;
              $chequee=0;

              foreach ($products as $keyv=> $product ){
                $keyd+=($keyv+1);?>

                <tr>
                  <td style="text-align: center;"><?= $keyv+1; ?></td>
                  <td style="text-align:center;"><?=(new dateTime($product->DateTemps))->format("d/m/Y"); ?></td>
                  <td><?= ucwords(strtolower($product->coment)); ?></td>
                  <?php

                  if ($product->devisedec=='gnf' and $product->type=='espèces') {

                    $montantgnf+=$product->montant;
                    $montantgnff+=$product->montant;?>

                    <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td><?php

                  }elseif ($product->devisedec=='us') {
                    $montantus+=$product->montant;
                    $montantuss+=$product->montant;?>

                    <td></td>
                    <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td><?php
                  }elseif ($product->devisedec=='eu') {
                    $montanteu+=$product->montant;
                    $montanteuu+=$product->montant;?>

                    <td></td>
                    <td></td>
                    <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                    <td></td>
                    <td></td>
                    <td></td><?php
                  }elseif ($product->devisedec=='cfa') {
                    $montantcfa+=$product->montant;
                    $montantcfaa+=$product->montant;?>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                    <td></td>
                    <td></td><?php

                  }elseif ($product->type=='virement') {
                    $virement+=$product->montant;
                    $virementt+=$product->montant;?>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                    <td></td><?php
                  }elseif ($product->type=='chèque') {
                    $cheque+=$product->montant;
                    $chequee+=$product->montant;?>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td><?php
                  }?>
                  
                </tr><?php 
              }

              if (!empty($products)) {?>

                <tr>
                  <td colspan="3" style="text-align: center;font-weight: bold; ">Totaux <?=ucwords($valuedep->nom);?></td>
                  <td style="text-align: right; font-weight: bold;"><?= number_format($montantgnff,0,',',' ');?></td>
                  <td style="text-align: right; font-weight: bold;"><?= number_format($montantuss,0,',',' ');?></td>
                  <td style="text-align: right; font-weight: bold;"><?= number_format($montanteuu,0,',',' ');?></td>
                  <td style="text-align: right; font-weight: bold;"><?= number_format($montantcfaa,0,',',' ');?></td>
                  <td style="text-align: right; font-weight: bold;"><?= number_format($virementt,0,',',' ');?></td>
                  <td style="text-align: right; font-weight: bold;"><?= number_format($chequee,0,',',' ');?></td>
                </tr><?php
              }
            }?>

          </tbody>

          <tfoot>
            <tr>
              <th colspan="3">Totaux Depenses</th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($montantgnf,0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($montantus,2,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($montanteu,2,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($montantcfa,0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($virement,0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($cheque,0,',',' ');?></th>
            </tr>
          </tfoot>

        </table>

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