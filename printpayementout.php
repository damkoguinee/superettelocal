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
    border: 2px solid #CFD1D2;
    padding: 0px;
    font-weight: bold;
    font-size: 18px;
    color: black;
    background: white;
    text-align: right; }
  .border td {
    line-height: 10mm;
    border: 0px solid #CFD1D2;    
    font-size: 18px;
    color: black;
    background: white;
    text-align: center;}
  .footer{
    font-size: 18px;
    font-style: italic;
  }

</style>

<page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">

  <?php require 'headerticketclient.php';?>

  <table style="margin:0px; font-size: 18px;color: black; background: white;" > 

    <tr>
      <td><?php echo "Paiement:  " .strtolower($_SESSION['paiement']); ?></td>
    </tr>

    <tr>
      <td><?php echo "Montant Payé:  " .number_format($_SESSION['montant'],0,',',' '); ?></td>
    </tr>

    <tr>
      <td><?php echo "Reste à Payer: 0 "; ?></td>
    </tr>

    <tr>
      <td><?php echo "Date:  " .date('d/m/Y  H:i:s'); ?></td>
    </tr>

  </table><?php

      require 'piedticket.php';?>
      
  </div>

</page>

<?php
  $content = ob_get_clean();
  try {
    $pdf = new HTML2PDF("p","A4","fr", true, "UTF-8" , 0);
    $pdf->pdf->SetAuthor('Amadou');
    $pdf->pdf->SetTitle(date("d/m/y"));
    $pdf->pdf->SetSubject('Création d\'un Portfolio');
    $pdf->pdf->SetKeywords('HTML2PDF, payement, PHP');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->writeHTML($content);
    $pdf->Output('ticket'.date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
//header("Refresh: 10; URL=index.php");
?>