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
  
  <?php //require 'headerticketclient.php';

  $adress = $DB->querys("SELECT * FROM adresse where lieuvente='{$_SESSION['lieuvente']}' ");

    $Numv=$_GET['numdec'];

    $payement = $DB->querys('SELECT numcmd, client, montant, taux, devise, motif, typep, DATE_FORMAT(dateop, \'%d/%m/%Y \à %H:%i:%s\')AS DateV FROM devisevente WHERE id= ?', array($Numv));?>
  <div class="ticket">

    <table style="width: 100%; margin:auto; text-align: center;color: black; background: white;" >

      <tr>
        <th style="font-weight: bold; font-size: 14px; padding: 5px"><?php echo $adress['nom_mag']; ?></th>
      </tr>

      <tr>

        <td style="font-size: 14px;">

          <?php echo $adress['type_mag']; ?>
        </td>
      </tr>

      <tr>

        <td>
          <?php echo($adress['adresse']); ?>

        </td>

      </tr>
    </table>

    <table style="margin:0px; font-size: 18px;color: black; background: white; margin-top: 30px;" >

      <tr>
        <td style="font-style: italic;"><?= "N° Opération.........................." .$payement['numcmd'];?></td>
      </tr>

      <tr>
        <td style="font-style: italic;"><?="Date......................................." .$payement["DateV"]; ?></td>
      </tr>

      <tr>
        <td style="font-style: italic;"><?='Motif.......................................'.ucwords($payement['motif']); ?></td>
      </tr>

      <tr>
        <td style="font-style: italic;"><?="Montant en Devise................." .number_format($payement['montant'],2,',',' ').' '.$panier->deviseformat($payement['devise']);?></td>
      </tr>

      <tr>
        <td style="font-style: italic;"><?="Taux d'échange......................" .number_format($payement['taux'],2,',',' ');?></td>
      </tr> 

      <tr>
        <td style="font-style: italic;"><?="Montant en GNF....................." .number_format($payement['montant']*$payement['taux'],2,',',' ');?></td>
      </tr>     

      <tr>
        <td style="font-style: italic;"><?="Paiement par:........................." .$payement["typep"]; ?></td>
      </tr>

      <tr>
        <td style="font-style: italic;"><?="Client:....................................." .ucwords(strtolower($payement["client"])); ?></td>
      </tr>

      

      <tr>
    <td style="padding-top: 20px; font-size: 12px; font-style: italic;">************<?=$adress['nom_mag']. " vous souhaite une excellente journée**************"; ?></td>
  </tr>
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
?>