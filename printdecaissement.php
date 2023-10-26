<?php
require_once "lib/html2pdf.php";

ob_start(); ?>

<?php require '_header.php';?>

<page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">

  <?php 

  $Numv=$_GET['numdec'];

  $payement = $DB->querys('SELECT numdec, devisedec, montant, cprelever, payement, coment, lieuvente, DATE_FORMAT(date_payement, \'%d/%m/%Y \à %H:%i:%s\')AS DateV FROM decaissement WHERE decaissement.id= ?', array($Numv));

  $_SESSION['reclient']=$_GET['idc'];

  $idc=$_GET['idc'];

  $lieuvente=$payement['lieuvente'];

  require 'headerticketclient.php';?>

      <table style="margin:10px; font-size: 18px;color: black; background: white;" >

        <tr>
          <td><?="N° décaissement..................." .$payement['numdec'];?></td>
        </tr>

        <tr>
          
          <td><?= "Montant décaissé.................." .number_format($payement['montant'],0,',',' ').' '.$panier->deviseformat($payement['devisedec']);?></td>
        </tr> 

        <tr>
          
          <td><?= "Commentaire(s)...................." .ucfirst(strtolower($payement['coment']));?></td>
        </tr>      

        <tr>
          <td><?= "Type de paiement ................" .$payement['payement']; ?></td>
        </tr>

        <tr>
        <td><?="Compte de Retraît:..............." .ucwords(strtolower($panier->nomBanquefecth($payement["cprelever"]))); ?></td>
      </tr>

        <tr>
          <td><?="Date de paiement................." .$payement['DateV']; ?></td>
        </tr>

      </table><?php

      require 'piedticket.php';

      $pers1=$DB->querys('SELECT *from login where id=:type', array('type'=>$_SESSION['idpseudo']));?>

      <div style="margin-top:10px;"> 
      

        <div  style="margin-top: 0px; color: grey;">
          <label style="margin-left: 90px;"><?=strtoupper($pers1['statut']);?></label>

          <label style="margin-left: 300px;">Le Client</label>
        </div>

        <div class="pied" style="margin-top: 90px; color: grey;">
          <label style="margin-left: 80px;"><?=ucwords($pers1['nom']);?></label>

          <label style="margin-left: 300px;"><?=$panier->adClient($_SESSION['reclient'])[0]; ?></label>
        </div>
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