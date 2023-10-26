<?php
require_once "lib/html2pdf.php";
ob_start(); ?>

<?php require '_header.php';?>

<style type="text/css">

body{
  margin: 0px;
  width: 100%;
  height:68%;
  padding:0px;
}
  .ticket{
    margin:auto;
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
    line-height: 10mm;
    border: 0px solid #CFD1D2;    
    font-size: 30px;
    color: black;
    background: white;
    text-align: center;}
  .footer{
    font-size: 30px;
    font-style: italic;
  }

</style>

<page backtop="5mm" backleft="5mm" backright="5mm" backbottom="5mm" footer="page;"><?php

    if (!empty($_SESSION['numcmdmodif'])) {
      $Num_cmd=$_SESSION['numcmdmodif'];
      unset($_SESSION['numcmdmodif']);
    }else{
      if (!isset($_GET['ticketclient'])) {
        $Num_cmd=$_SESSION['rechercher'];
      }
    }

    if (isset($_GET['ticketclient'])) {
      $Num_cmd=$_GET['ticketclient'];
    }

    $payement=$DB->querys('SELECT num_cmd, montantpaye, remise, reste, etat, num_client, nomclient, DATE_FORMAT(date_cmd, \'%d/%m/%Y \à %H:%i:%s\')AS DateTemps, vendeur, DATE_FORMAT(datealerte, \'%d/%m/%Y\') as datealerte, lieuvente FROM payement WHERE num_cmd= ?', array($Num_cmd));

    $frais=$DB->querys('SELECT numcmd, montant, motif  FROM fraisup WHERE numcmd= ?', array($Num_cmd));

    if ($payement['num_client']==0) {
      $_SESSION['nameclient']=$payement['nomclient'];
      $_SESSION['reclient']=$payement['nomclient'];
    }else{

      $_SESSION['nameclient']=$payement['num_client'];
      $_SESSION['reclient']=$payement['num_client'];

    }

    $idc=$payement['num_client'];
    $lieuvente=$payement['lieuvente'];
    require 'headerticketpetit.php';?>

    <div>

    <table style="margin:0px; margin-top: 60px; font-size: 30px;color: black; background: white;" >

      <tr>
        <td><strong><?php echo "Facture N°: " .$Num_cmd; ?></strong></td>
      </tr>

      <tr>
        <td><?php echo "Date:  " .$payement['DateTemps']; ?></td>
      </tr><?php 
      if ($payement['etat']=='credit' and !empty($payement['datealerte'])) {?>

        <tr>
          <td style="color: red;"><?= "A régler avant le:  " .$payement['datealerte']; ?></td>
        </tr><?php 
      }?>

      <tr>
        <td><?php echo "Vendeur:  " .$payement['vendeur']; ?></td>  
      </tr>

    </table>

    <table style="margin-top: 3px; margin-left:0px;" class="border">

      <tbody>

        <tr>            
          <th style="width: 44%; text-align: left;text-align: center;">Désignation</th>
          <th style="width: 10%; padding-right: 5px; text-align: center;">Qtité</th>
          <th style="width: 17%; text-align: center;">P.Unit</th>
          <th style="width: 29%; padding-right: 10px; text-align: right;">P. Total</th>
        </tr>

      </tbody>

      <tbody><?php

        $total=0;

         $products=$DB->query('SELECT quantity, commande.prix_vente as prix_vente, designation, qtiteliv, type FROM commande inner join productslist on productslist.id=commande.id_produit WHERE num_cmd= ?', array($Num_cmd));

        $nbreligne=sizeof($products);
        $totqtite=0;
        $totqtiteliv=0;

        $totqtitep=0;
        $totqtitelivp=0;
        $totqtited=0;
        $totqtitelivd=0;
        foreach ($products as $product){

          if ($product->type=='en_gros') {
            $totqtite+=$product->quantity;

            $totqtiteliv+=$product->qtiteliv;
          }elseif ($product->type=='detail') {
            $totqtited+=$product->quantity;

            $totqtitelivd+=$product->qtiteliv;
          }else{

            $totqtitep+=$product->quantity;

            $totqtitelivp+=$product->qtiteliv;
          }

          if (empty($product->prix_vente)) {
            $pv='Offert';
            $pvtotal='Offert';
          }else{
            $pv=number_format($product->prix_vente,0,',',' ');
            $pvtotal=number_format($product->prix_vente*$product->quantity,0,',',' ');
          }?>

          <tr>

            <td style="width: 44%;text-align:left"><?=ucwords(strtolower($product->designation)); ?></td>

            <td style="width: 10%;"><?= $product->quantity; ?></td>

            <td style="width: 17%; text-align:right"><?=$pv; ?></td>

            <td style="width: 29%; text-align:right; padding-right: 10px;"><?= $pvtotal; ?></td><?php

            $price=($product->prix_vente*$product->quantity);

            $total += $price;?>

          </tr><?php
        }

        $total=$total+$frais['montant'];

        $montantverse=$payement['montantpaye'];

        $Remise=$payement['remise'];

         $reste=$payement['reste'];

        $ttc = $total-$Remise;

        $tot_Rest = $total-$montantverse;

        if ($nbreligne==1) {

          $top=(160/($nbreligne));
        }else{

          $top=(205-($nbreligne*20));
        }
       ?>
      
      <tr>

        <td colspan="2" style="border:0px; border-bottom: 0px; padding-top: <?=$top.'px';?>;" class="space"></td>
        <td colspan="2" style="border:0px; padding-top:<?=$top.'px';?>;" class="space"></td>
      </tr>

      <tr>
        <td colspan="2" rowspan="4" style="padding: 2px; text-align: left; font-size:10px;"></td>
      </tr>

      <tr>
        <td style="text-align: right; border-left: 0px;" class="no-border">Total </td>
        <td style="text-align:right; padding-right: 0px;"><?php echo number_format($total,0,',',' ') ?></td>
      </tr><?php 

      if (!empty($Remise)) {?>
        <tr>
          <td style="text-align: right; border-left: 0px;" class="no-border">Remise </td>
          <td style="text-align:right; padding-right: 0px;"><?= number_format($Remise,0,',',' ') ?> (<?=($Remise/$total)*100;?>%)</td>
        </tr><?php
      }?>      
    </tbody>
  </table>

  <table class="border">

    <tbody><?php

        if ($tot_Rest<=0) {?>

          <tr>
        
            <td colspan="2" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:30px; border-right: 0px;"><?="Montant Total Payé: ".number_format($montantverse,0,',',' ');?></td>
          </tr>

          <tr>

            <td colspan="2" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:30px;"><?="Rendu au Client: ".number_format(-$reste,0,',',' ');?> GNF</td>
          </tr><?php

        }else{?>

          <tr>

            <td style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:30px;"><?="Montant Total Payé: ".number_format($montantverse,0,',',' ');?> GNF</td>
          </tr>

          <tr>
            <td style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:30px;"><?="Reste à Payer: ".number_format($tot_Rest-$Remise,0,',',' ');?> GNF</td>
          </tr><?php

        }?>

        <tr><td style="text-align: center; font-size: 25px; font-style: italic; padding-top: 30px;"><?=$adress['nom_mag'];?>, vous souhaite une excellente journée !!!!</td></tr>
        
    </tbody>


  </table>
</div>

</page><?php
  $content = ob_get_clean();
  try {
    $pdf = new HTML2PDF("p","A4","fr", true, "UTF-8" , 0);
    $pdf->pdf->SetAuthor('Amadou');
    $pdf->pdf->SetTitle("facture");
    $pdf->pdf->SetSubject('Création d\'un Portfolio');
    $pdf->pdf->SetKeywords('HTML2PDF, Synthese, PHP');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->writeHTML($content);
    $pdf->Output(date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
//header("Refresh: 10; URL=index.php");
?>