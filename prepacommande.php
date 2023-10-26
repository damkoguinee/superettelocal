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
    height: 20px;
    border: 1px solid black;
    padding: 3px;
    font-weight: bold;
    font-size: 14px;
    color: black;
    background: white;
    text-align: right;
  }
  .border td {
    height: 20px;
    padding: 3px;
    border: 1px solid black;    
    font-size: 16px;
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


  
    $Num_cmd=$_SESSION['rechercher'];

    $array=$DB->querys("SELECT date_cmd, num_cmd, montantpaye,remise, reste, telephone FROM payement inner join client on client.id=num_client WHERE num_cmd= ?", array($Num_cmd));

    $payement = $DB->querys('SELECT num_cmd, montantpaye, remise, reste, etat, nom_client as client, typeclient, num_client, DATE_FORMAT(date_cmd, \'%d/%m/%Y \à %H:%i:%s\')AS DateTemps, vendeur FROM payement inner join client on client.id=num_client WHERE num_cmd= ?', array($Num_cmd));

    if ($payement['typeclient']=='VIP') {
        $_SESSION['reclient']=$payement['num_client'];
        $_SESSION['nameclient']=$payement['num_client'];
        require 'headerticketclient.php';
      }else{
        $_SESSION['reclient']=$payement['client'];
        $_SESSION['nameclient']=$payement['client'];
        require 'headerticketclient0.php';
      }?></div>

    <table style="margin:0px; font-size: 18px;color: black; background: white;" >

        <tr>
          <td><?php echo "N°: " .$Num_cmd; ?></td>
        </tr> 

        <tr>
          <td><?php echo "Date de vente:  " .$payement['DateTemps']; ?></td>
        </tr>

        <tr>
          <td><?php echo "Vendeur:  " .$panier->nomPersonnel($payement['vendeur']); ?></td>  
        </tr>

      </table>

      <table style="margin-top: 30px; margin-left:0px;" class="border">

        <thead>

          <tr>
            <th style="text-align: center;">Reste</th>
            <th style="text-align: center;">Désignation</th><?php 

            foreach ($panier->listeStock() as $valueS) {?>
              <th style="text-align: center; font-size: 15px; width: 65px;"><?=ucwords($valueS->nomstock);?></th><?php 
            }?>
          </tr>

        </thead>

        <tbody><?php

          $total=0;
          $products = $DB->query('SELECT * FROM commande inner join productslist on productslist.id=id_produit WHERE num_cmd= ?', array($Num_cmd));
          
          foreach ($products as $product){?>

            <tr>

              <td><?= $product->quantity-$product->qtiteliv; ?></td>

              <td style="text-align:left, margin-left:5px; font-size: 12px;"><?= ucwords(strtolower($product->designation)); ?></td><?php 

              foreach ($panier->listeStock() as $valueS) {?>
                <td></td><?php 
              }?>



            </tr><?php
          }?>
          
        
      </tbody>

    </table>
    <div style="text-align:center;" >Prépa éditée le <?=date("d/m/Y à H:i");?></div><?php
require 'piedprintprepa.php';?>

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