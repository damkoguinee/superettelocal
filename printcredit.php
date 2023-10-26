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
  }
  
  .border th {
    border: 1px solid black;
    padding:5px;
    font-weight: bold;
    font-size: 12px;
    color: black;
    background: white;
    text-align: center; }
  .border td {
    padding-bottom: 5px;
    padding-top: 5px;
    border: 1px solid black;    
    font-size: 14px;
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

  <?php require 'headerticket.php';?></div>

  <table class="border">

    <thead>

      <tr>
        <th colspan="5"><?="liste Crédits Clients " .date('d/m/Y'); ?></th>
      </tr>

      <tr>
        <th>N°cmd</th>
        <th>Client</th>
        <th>Total</th>
        <th>Reste à payer</th>
        <th>Date</th>
      </tr>

    </thead>

    <tbody><?php

      $tot=0;
      $reste=0;

      $credit_client=0;
      $totachat=0;
      $Etat="credit";

      $products = $DB->query('SELECT client.id as idc, num_cmd, num_client, client, typeclient, nom_client as clientvip, Total, remise, reste, montantpaye, DATE_FORMAT(date_cmd, \'%d/%m/%Y \')AS DateTemps FROM payement left join client on client.id=num_client  WHERE etat= :ETAT order by(client)', array('ETAT'=>$Etat));

      foreach ($products as $product){

        if ($product->typeclient=='VIP') {
            $client=$product->clientvip;
        }else{
          $client=$product->client;
        }

        $totachat+=$product->Total-$product->remise;

        $credit_client+=($product->Total-$product->remise-$product->montantpaye); ?>

        <tr>

          <td style="text-align: center;"><?=$product->num_cmd;?></td>

          <td style="text-align: left;"><?=$client; ?></td>

          <td style="text-align: right;padding-right: 5px;"><?= number_format($product->Total,0,',',' ') ; ?></td> 

          <td style="color: red; text-align: right;"><?=number_format(($product->reste),0,',',' '); ?></td>

          <td style="text-align:center;"><?= $product->DateTemps; ?></td>

        </tr><?php
      }?>

    </tbody>            

    <tfoot>

      <tr>

        <th colspan="2">Totaux</th>

        <th style="text-align: right; padding-right: 5px;"><?= number_format($totachat,0,',',' ') ; ?></th>

        <th style="text-align: right; color: red;"><?= number_format($credit_client,0,',',' ') ; ?></th>
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
    $pdf->Output('STOCK EDITE'.date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
?>