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
    font-size: 11px;
    color: black;
    background: white;
    text-align: center; }
  .border td {
    padding-bottom: 5px;
    padding-top: 5px;
    border: 1px solid black;    
    font-size: 11px;
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

  <?php 

  $nomtab=$panier->nomStock($_GET['stock'])[1];

  $idstock=$panier->nomStock($_GET['stock'])[0];

  require 'headerticket.php';

  if ($_GET['stock']==0) {
    /*?>
    
    <table class="border">

      <thead>

        <tr>
          <th colspan="2">
            <?="Stock Général à la date du " .date('d/m/Y'); ?> 
          </th>
        </tr>

        <tr>
          <th>Désignation</th>
          <th>
            <table class="border" style="width:100%;">
              <tbody><?php 
                $colspan=sizeof($panier->listeStock())+2;?>
                <tr><th colspan="<?= $colspan;?>">Quantite</th></tr>

                <tr><?php 

                  foreach ($panier->listeStock() as $valueS) {?>
                    <th width="80" style="font-size: 11px;"><?=ucwords($valueS->nomstock);?></th><?php 
                  }?>

                  <th width="80" style="font-size: 11px;">Qtité dispo</th>

                  <th width="80" style="font-size: 11px;">Qtité non Livré</th>
                </tr>
              </tbody>
            </table>
          </th>
        </tr>

      </thead>

    <tbody>

      <?php
      $tot_achat=0;
      $tot_revient=0;
      $tot_vente=0;
      $quantite=0;

      $totqtiteliv=0;
      foreach ($panier->listeProduit() as $value) {?>

        <tr>

          <td style="text-align: left;"><?= ucwords(strtolower($value->designation)); ?></td>

          <td style="text-align: center;">
            <table style="width:100%" class="border">
              <tbody>
                <tr><?php 

                  $totqtite=0;

                  $totstock=0;

                  
                  foreach ($panier->listeStock() as $valueS) {

                    $products = $DB->querys("SELECT quantite FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where productslist.id='{$value->id}' ORDER BY (designation)");

                    $quantite+=$products['quantite'];

                    $totqtite+=$products['quantite'];

                    $prodcmd=$DB->querys("SELECT sum(quantity-qtiteliv) as qtitenl from commande where id_produit='{$value->id}'");

                    $nonlivre=$prodcmd['qtitenl'];

                    ?>

                    <td width="80" style="text-align: center; font-size: 16px;"><?=$products['quantite'];?></td><?php
                  }
                  $totqtiteliv+=$prodcmd['qtitenl'];?>
                  <td width="80" style="text-align: center; font-size: 16px;"><?=$totqtite;?></td>

                  <td width="80" style="text-align: center; font-size: 16px;"><?=$nonlivre;?></td>

                </tr>
              </tbody>
            </table>
          </td>
        </tr><?php
      }?>

    </tbody><?php

    if (!isset($_POST['recherchgen'])) {?>

      <tfoot>

        <tr>
          <th colspan="1">TOTAUX</th>
          <th style="text-align: center;">
            <table style="width:100%;">
              <tfoot>
                <tr><?php

                  $qtites=0; 

                  foreach ($panier->listeStock() as $valueS) {

                    $products = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."`");

                    $qtites=$products['qtite'];?>

                    <th width="80" style="text-align: center; font-size: 16px;"><?= number_format($qtites,0,',',' ') ; ?></th><?php
                  }?>
                  <th width="80" style="text-align: center; font-size: 16px;"><?= number_format($quantite,0,',',' ') ; ?></th>

                  <th width="80" style="text-align: center; font-size: 16px;"><?= number_format($totqtiteliv,0,',',' ') ; ?></th>
                </tr>
              </tfoot>
            </table>                
          </th>

        </tr>

      </tfoot><?php 
    }?>

  </table><?php
  */
  }else{

    if (!isset($_GET['datep'])) {?>

      <table class="border">

        <thead>

          <tr>
            <th colspan="9"><?="Produits disponible du ".$idstock." à la date du ".date('d/m/Y'); ?></th>
          </tr>

          <tr>
            <th></th>
            <th>Désignation</th>
            <th>Qtité</th>
            <th>P.Achat</th>
            <th>Tot Achat</th>
            <th>P.Revient</th>
            <th>Tot Revient</th>
            <th>P.Vente</th>
            <th>Tot Vente</th>
          </tr>

        </thead>

        <tbody><?php

          $tot_achat=0;
          $tot_revient=0;
          $tot_vente=0;
          $quantite=0; 

          if (isset($_GET['carton'])) {
            $type='en_gros';

            $products= $DB->query("SELECT designation, prix_achat, prix_revient, prix_vente, quantite,`".$_SESSION['nomtab']."`.id as id FROM `".$nomtab."` inner join productslist on idprod=productslist.id where quantite!=0 ORDER BY (designation)");
          }elseif (isset($_GET['paquet'])) {
            $type='paquet';

            $products= $DB->query("SELECT designation, prix_achat, prix_revient, prix_vente, quantite,`".$_SESSION['nomtab']."`.id as id FROM `".$nomtab."` inner join productslist on idprod=productslist.id where productslist.type='{$type}' and quantite!=0 ORDER BY (designation)");
          }else{
            $type='detail';

            $products= $DB->query("SELECT designation, prix_achat, prix_revient, prix_vente, quantite,`".$_SESSION['nomtab']."`.id as id FROM `".$nomtab."` inner join productslist on idprod=productslist.id where productslist.type='{$type}' and quantite!=0 ORDER BY (designation)");

          }

          foreach ($products as $key=> $product):

            $tot_achat+=$product->prix_achat*$product->quantite;
            $tot_revient+=$product->prix_revient*$product->quantite;
            $tot_vente+=$product->prix_vente*$product->quantite;
            $quantite+=$product->quantite;?>

            <tr> 
              <th style="text-align: center;"><?=$key+1;?></th>             
              <td style="padding-right: 1px;"><?= ucwords(strtolower($product->designation)); ?></td>
              <td style="text-align: center;"><?= $product->quantite; ?></td>
              <td style="text-align: right;"><?= number_format($product->prix_achat,0,',',' ') ; ?> </td>
              <td style="text-align: right;"><?= number_format($product->prix_achat*$product->quantite,0,',',' ') ; ?> </td>
              <td style="text-align: right;"><?= number_format($product->prix_revient,0,',',' ') ; ?> </td>
              <td style="text-align: right;"><?= number_format($product->prix_revient*$product->quantite,0,',',' ') ; ?> </td>
              <td style="text-align: right;"><?= number_format($product->prix_vente,0,',',' '); ?>  </td>
              <td style="text-align: right;"><?= number_format($product->prix_vente*$product->quantite,0,',',' ') ; ?> </td>
            </tr>
              
          <?php endforeach ?>

        </tbody>

        <tfoot>

          <tr>
            <th colspan="2">TOTAL</th>
            <th style="text-align: center; padding-right: 10px;"><?= number_format($quantite,0,',',' ') ; ?> </th>
            <th></th>

            <th style="text-align: right; padding-right: 10px;"><?= number_format($tot_achat,0,',',' ') ; ?> </th>
            <th></th>

            <th style="text-align: right; padding-right: 10px;"><?= number_format($tot_revient,0,',',' ') ; ?> </th>
            <th></th>

            <th style="text-align: right; padding-right: 10px;"><?= number_format($tot_vente,0,',',' ') ; ?> </th>

          </tr>

        </tfoot>

      </table><?php 
    }else{?>

      <table class="border" style="margin: auto;">

      <thead>

        <tr>
          <th colspan="6"><?="Produits disponible à la date du ".date('d/m/Y'); ?></th>
        </tr>

        <tr>
          <th></th>
          <th>Désignation</th>
          <th>P.Vente</th>
          <th>Nbre Pièces</th>
          <th>Nbre Paquet</th>
          <th>Date de Péremption</th>
        </tr>

      </thead>

      <tbody><?php

        $tot_achat=0;
        $tot_revient=0;
        $tot_vente=0;
        $quantite=0; 

        
          $type='en_gros';

          $products= $DB->query("SELECT designation, prix_achat, prix_revient, prix_vente, dateperemtion, productslist.qtiteintp as qtiteintp, qtiteintd, quantite,`".$_SESSION['nomtab']."`.id as id FROM `".$nomtab."` inner join productslist on idprod=productslist.id where productslist.type='{$type}' and quantite!=0 ORDER BY (designation)");
        

        foreach ($products as $key=> $product):
          if (empty($product->dateperemtion)) {
            $datep='';
          }else{

            $datep=(new dateTime($product->dateperemtion))->format("d/m/Y");
          } ?>

          <tr> 
            <th style="text-align: center;"><?=$key+1;?></th>             
            <td style="padding-right: 1px;"><?= ucwords(strtolower($product->designation)); ?></td>
            <td style="text-align: right;"><?= number_format($product->prix_vente,0,',',' '); ?>  </td>
            <td style="text-align: center;"><?=$product->qtiteintd; ?>  </td>
            <td style="text-align: center;"><?=$product->qtiteintp; ?>  </td>
            <td style="text-align: center;"><?=$datep; ?> </td>
          </tr>
            
        <?php endforeach ?>

      </tbody>

    </table><?php
  }
  }?>
  
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
    $pdf->Output('stock imprime le '.date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
?>