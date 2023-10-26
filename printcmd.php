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
    padding: 5px;
    font-weight: bold;
    font-size: 16px;
    color: black;
    background: white;
    text-align: right;
  }
  .border td {
    border: 1px solid black;
    padding: 3px;    
    font-size: 14px;
    color: black;
    background: white;
    text-align: center;
  }
  .footer{
    font-size: 18px;
    font-style: italic;
  }

</style>

<page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">

  <?php 

    if (empty($_SESSION['reclient'])) {

      $_SESSION['reclient']=$_GET['client'];
    }

    if (isset($_GET['print'])) {

      $Numcmd=$_GET['print'];

    }else{

      $reponse = $DB->querys("SELECT datecmd, max(numcmd) FROM achat");
      $Numcmd=$reponse['max(numcmd)'];
    } 

    $prodachat = $DB->query('SELECT numfact, nom_client as fournisseur, designation, quantite, taux, pachat, etat, DATE_FORMAT(datecmd, \'%d/%m/%Y \à %H:%i:%s\') AS datecmd FROM achat inner join client on client.id=fournisseur WHERE numcmd= :NUM', array('NUM'=>$Numcmd));

    $prodfact = $DB->querys('SELECT numfact, montantht, montantva, montantpaye, modep, taux, nom_client as fournisseur, lieuvente, DATE_FORMAT(datecmd, \'%d/%m/%Y \à %H:%i:%s\') AS datecmd FROM facture inner join client on client.id=fournisseur WHERE numcmd= :NUM', array('NUM'=>$Numcmd));

    $_SESSION['nameclient']=$_GET['client'];

    $idc=$_GET['client'];

    $lieuvente=$prodfact['lieuvente'];

    require 'headerticketclient.php';
    
    ?>

      <table style="margin:0px; font-size: 18px;color: black; background: white;" >

        <tr>
          <td><?php echo "N° facture: ".$prodfact['numfact'] ; ?></td>
        </tr>

        <tr>
          <td><?php echo "Date facture:  ".$prodfact['datecmd'] ; ?></td>
        </tr>

        <tr>
          <td><?php echo "Devise:  ".strtoupper($prodfact['modep']); ?></td>
        </tr>

        <tr>
          <td><?php echo "Taux:  ".number_format($prodfact['taux'],0,',',' '); ?></td>
        </tr>

      </table>


    <table class="border" style="margin-top: 20px;">

      <thead>

        <tr>
          <th style="width: 54%; text-align: center;">Désignation</th>
          <th style="width: 16%; text-align: center;">Qtite</th>
          <th style="width: 30%; text-align: center;">Montant</th>
        </tr>

      </thead>

      <tbody><?php 

        foreach ($prodachat as $product){?>

          <tr>              
            <td style="width: 54%; text-align:left"><?= ucwords($product->designation); ?></td>
            <td style="width: 16%; text-align: center;"><?= $product->quantite; ?></td>
              <td style="width: 30%; text-align: right; padding-right: 10px;"><?= number_format(($product->pachat/$product->taux),0,',',' '); ?></td>
          </tr><?php 
        }?> 

      </tbody>
    </table>

    <table style="margin-top: 1px; margin-left:0px;" class="border">

      <tbody>
        <tr>
          <th colspan="3" height="30"></th>
        </tr>

        <tr>
          <th style="width: 68%;border-bottom: 1px;">Total</th>

          <th style="width: 32%;text-align: right; padding-right: 10px; border-bottom: 1px;"><?= number_format((($prodfact['montantht']+$prodfact['montantva'])),0,',',' '); ?></th>
          
        </tr>

        <tr>
          <td colspan="2" style="width: 68%;border-top: 2px;"><?php

            $name=$_SESSION['nameclient'];?>Solde de vos Comptes:

            <label style="padding-right: 30px;">GNF: <?=number_format(($panier->soldeclientgen($name,'gnf')),0,',',' ');?></label><label style="background-color: white; color:white;">espa</label>

            <label style="margin-right: 10px;">€: <?=number_format(($panier->soldeclientgen($name,'eu')),0,',',' ');?></label><label style="background-color: white; color:white;">espa</label>

            <label style="margin-right: 10px;">$: <?=number_format(($panier->soldeclientgen($name,'us')),0,',',' ');?></label><label style="background-color: white; color:white;">espa</label>

            <label style="margin-right: 10px;">CFA: <?=number_format(($panier->soldeclientgen($name,'cfa')),0,',',' ');?></label>
          </td>
        </tr>

      </tbody>

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
    $pdf->Output('Commande du '.date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
?>