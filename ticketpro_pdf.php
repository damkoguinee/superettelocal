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
    font-size: 30px;
    color: black;
    background: white;
    text-align: right; }
  .border td {
    line-height: 15mm;
    border: 0px solid #CFD1D2;    
    font-size: 26px;
    color: black;
    background: white;
    text-align: center;}
  .footer{
    font-size: 30px;
    font-style: italic;
  }

</style>

<page backtop="0mm" backleft="0mm" backright="0mm" backbottom="10mm" footer="page;">

  <?php require 'headerticket.php';

    $array=$DB->querys("SELECT  max(num_cmd), client, vendeur, date_cmd as DateTemps FROM proformat ");



    $Num_cmd=$array['max(num_cmd)'];

    $products=$DB->query('SELECT num_cmd, designation, prix_vente, quantity FROM proformat WHERE num_cmd= ?', array($Num_cmd));?>    

      <table style="margin:0px; font-size: 30px;color: black; background: white;" >

        <tr>
          <td><strong><?php echo "Proformat N°: " .$Num_cmd; ?></strong></td>
        </tr> 

        <tr>
          <td><?php echo "Date:  " .$array['DateTemps']; ?></td>
        </tr>

         <tr>
          <td><?php echo "Nom du Client:  " .$array['client']; ?></td>
        </tr>

      </table>

      <table style="margin-top: 30px; margin-left:0px;" class="border">

        <tbody>

          <tr>
            <th style="width: 6%;">Qt</th>
            <th style="width: 42%; text-align: left;">Désignation</th>
            <th style="width: 24%;">Prix Unit</th>
            <th style="width: 28%; padding-right: 10px;">Prix tot</th>
          </tr>

        </tbody>
      </table>

      <table style="margin-top: 1px; margin-left:0px;" class="border">

        <tbody><?php

          $total=0;

          foreach ($products as $product){?>

            <tr>

              <td style="width: 6%;border:0px"><?= $product->quantity; ?></td>

                <td style="width: 42%;border:0px;text-align:left"><?=strtolower($product->designation); ?></td>

                <td style="width: 24%;border:0px; text-align:right"><?=number_format($product->prix_vente,0,',',' '); ?></td>

                <td style="width: 28%;border:0px; text-align:right; padding-right: 10px;"><?= number_format($product->prix_vente*$product->quantity,0,',',' '); ?></td><?php

              $price=($product->prix_vente*$product->quantity);

              $total += $price;?>

            </tr><?php
          }?>
        
        <tr>

          <td colspan="4" style="border:0px; padding-top: 50px;" class="space"></td>
        </tr>

        <tr>
          <td colspan="2" rowspan="4" style="padding: 1px; text-align: left; font-size:25px;"></td>
        </tr>

        <tr>
          <td style="text-align: right;" class="no-border">Total </td>
          <td style="text-align:right; padding-right: 5px;"><?php echo number_format($total,0,',',' ') ?></td>
        </tr>
        

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
    $pdf->Output('ticket'.date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
//header("Refresh: 10; URL=index.php");
?>