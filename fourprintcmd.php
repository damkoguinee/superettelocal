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
    font-size: 14px;
    color: black;
    background: white;
    text-align: right;
  }
  .border td {
    border: 1px solid black;
    padding: 5px;    
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

<page backtop="5mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">

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

    $prodachat = $DB->query('SELECT * FROM fourachat inner join productslist on productslist.id=id_produitfac WHERE numcmd= :NUM', array('NUM'=>$Numcmd));

    $prodfact = $DB->querys('SELECT numfact, numcmd, montantht, montantva, montantpaye, modep, taux, nom_client as fournisseur, lieuvente, DATE_FORMAT(datecmd, \'%d/%m/%Y \à %H:%i:%s\') AS datecmd FROM fourfacture inner join client on client.id=fournisseur WHERE numcmd= :NUM', array('NUM'=>$Numcmd));

    $_SESSION['nameclient']=$_GET['client'];

    $idc=$_GET['client'];

    $lieuvente=$prodfact['lieuvente'];

    //require 'headerticketclient.php';

    $adress = $DB->querys("SELECT * FROM adresse where lieuvente='{$lieuvente}' ");
    ?>


    <table class="border" style="margin-top: 5px; margin: auto;">

      <thead>
        <tr>
          <th colspan="4" style="text-align:center; font-weight: bold; font-size: 18px; padding: 5px; border: 0px;">
            <?php echo $adress['nom_mag'];?></th>
        </tr>

        <tr>
          <td colspan="4" style="text-align:center; border: 0px;"><?=$adress['type_mag']; ?></td>
        </tr>

        <tr>
          <td colspan="4" style="text-align:center; border: 0px;"><?=$adress['adresse']; ?></td>
        </tr>
        <tr>
          <th colspan="4" style="text-align:right; font-size: 16px; border: 0px; "><?=$panier->adClient($_SESSION['reclient'])[0]; ?></th>
        </tr>

        <tr>
          <td colspan="4" style="text-align:right; font-size: 16px; border: 0px; "><?='Téléphone: '.$panier->adClient($_SESSION['reclient'])[1]; ?></td>
        </tr>

        <tr>
          <td colspan="4" style="text-align:right; font-size: 16px; border: 0px; "><?='Adresse: '.$panier->adClient($_SESSION['reclient'])[2]; ?></td>
        </tr>

        <tr>
          <td colspan="4" style="text-align:left; font-size: 16px; border: 0px; "><?= "Bon de Commande N°: ".$prodfact['numcmd'] ; ?></td>
        </tr>

        <tr>
          <td colspan="4" style="text-align:left; font-size: 16px; border: 0px; border-bottom: 1px;"><?= "Date :  ".$prodfact['datecmd'] ; ?></td>
        </tr>

        <tr>
          <th style="text-align: center;">Code</th>
          <th style="text-align: center;">Désignation</th>
          <th style="text-align: center;">Quantité</th>
          <th style="text-align: center;">Prix Unitaire</th>
        </tr>

      </thead>

      <tbody><?php 

        foreach ($prodachat as $product){?>

          <tr>
            <td style="text-align: left;"><?= $product->codeb; ?></td>            
            <td style="text-align:left"><?= ucwords($product->designation); ?></td>
            <td style="text-align: center;"><?= $product->quantite; ?></td>
            <td style="text-align: right; padding-right: 10px;"></td>
          </tr><?php 
        }?> 

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