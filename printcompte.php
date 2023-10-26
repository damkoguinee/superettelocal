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
    padding:3px;
    padding-top: 10px;
    font-weight: bold;
    font-size: 13px;
    height: 15px;
    color: black;
    background: white;
    text-align: center; }
  .border td {
    line-height: 15mm;
    padding:8px;
    border: 1px solid black;    
    font-size: 12px;
    color: black;
    background: white;
    text-align: left;}
  .footer{
    font-size: 18px;
    font-style: italic;
  }

  .legende{
    font-size: 18px;
    text-align: center;
    padding-bottom: 5px;
    padding-top: 5px;
  }

</style>

<page backtop="10mm" backleft="5mm" backright="5mm" backbottom="10mm" footer="page;"><?php

  $_SESSION['reclient']=$_GET['compte'];

  $idc=$_GET['compte'];
  $lieuvente=$_SESSION['lieuvente'];
  require 'headerticketclient.php';

  $client=$_GET['compte'];
  $devise=$_GET['devise'];

  $prod =$DB->query("SELECT bulletin.nom_client as client, libelles, numero, montant, date_versement, devise FROM bulletin inner join client on client.id=bulletin.nom_client WHERE bulletin.nom_client='{$client}' and devise='{$devise}' ORDER BY (date_versement)");

  unset($_SESSION['reclient']);?>

  <table style="margin:auto; margin-top: 20px;" class="border">

    <thead>
      <tr>
        <th colspan="7" style="text-align:center;">Relevé de <?=$panier->nomClient($client);?> Tel: <?=$panier->nomClientad($client)[1].' ';?> Compte <?=strtoupper($devise);?></th>
      </tr>

      <tr>
        <th>N°</th>
        <th>Date</th>
        <th>Désignation</th>
        <th>Fact</th>
        <th>Enc</th>
        <th>Déc</th>
        <th>Solde</th>
      </tr>
    </thead>
    <tbody><?php 
      $soldea=0;
        $solded=0;
        $soldes=0;
        $soldet=0;
        $solde=0;
        $zero=0;
      foreach ($prod as $key => $value) {

        $produit =$DB->query("SELECT * FROM commande WHERE num_cmd='{$value->numero}'");

        $solde+=$value->montant;?>

        <tr>
        <td style="text-align: center;"><?=$key+1;?></td>

        <td style="text-align: center;"><?=(new dateTime($value->date_versement))->format('d/m/Y');?></td>

        <td style="font-size: 10px;"><?=ucwords(strtolower($value->libelles)).' facture '.$value->numero;?></td><?php 

        if ($value->libelles=='reste à payer') {

          $soldea+=$value->montant;?>

          
          
          <td style="text-align:right;"><?=number_format((-1)*$value->montant,0,',',' ');?></td>

          <td></td>
          <td></td>
          <td style="text-align:right;"><?=number_format(-$solde,0,',',' ');?></td><?php

        }elseif($value->libelles!='reste à payer' and $value->montant>=0){

          $solded+=$value->montant;?>
          <td></td>           
          <td style="text-align:right;"><?=number_format($value->montant,0,',',' ');?></td>
          <td></td>
          <td style="text-align:right;"><?=number_format(-$solde,0,',',' ');?></td><?php

        }else{

          $soldes+=$value->montant;;?>
          <td></td>
          <td></td>           
          <td style="text-align:right;"><?=number_format((-1)*$value->montant,0,',',' ');?></td>
          <td style="text-align:right;"><?=number_format(-$solde,0,',',' ');?></td><?php

        }?>
      </tr><?php 
    }?>
    </tbody>

    <tfoot>
      <tr>
        <th colspan="3">Totaux</th>
        <th style="text-align:right"><?=number_format(-$soldea,0,',',' ');?></th>
        <th style="text-align:right"><?=number_format($solded,0,',',' ');?></th>
        <th style="text-align:right"><?=number_format(-$soldes,0,',',' ');?></th>
        <th style="text-align:right"><?=number_format(-$solde,0,',',' ');?></th>
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
    $pdf->Output('COMPTE EDITE'.date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
?>