<?php
require_once "lib/html2pdf.php";

ob_start(); ?>

<?php require '_header.php';?>

<page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">

  <?php require 'headerticketclient.php';

    $array = $DB->querys("SELECT max(id) FROM decloyer "); 
    $Numv=$array['max(id)'];

    $payement = $DB->querys('SELECT numdec, montant, payement, coment, DATE_FORMAT(date_payement, \'%d/%m/%Y \à %H:%i:%s\')AS DateV FROM decloyer WHERE decloyer.id= ?', array($Numv));?>

      <table style="margin:10px; font-size: 18px;color: black; background: white;" >

        <tr>
          <td><?="N° dec: " .$payement['numdec'];?></td>
        </tr>

        <tr>
          
          <td><?= "Montant decaissé.................." .number_format($payement['montant'],0,',',' ').' GNF ('.$payement['coment'].')'; ?></td>
        </tr>      

        <tr>
          <td><?= "Paiement par ........................" .$payement['payement']; ?></td>
        </tr>

        <tr>
          <td><?="Date......................................." .$payement['DateV']; ?></td>
        </tr>

        <tr>
          <td><?= "Executé Par:.........................." .$_SESSION['pseudo']; ?></td>
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
    $pdf->pdf->SetKeywords('HTML2PDF, Synthese, PHP');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->writeHTML($content);
    $pdf->Output('ticket'.date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
?>