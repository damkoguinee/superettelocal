<?php
require_once "lib/html2pdf.php";
ob_start(); ?>

<?php require '_header.php';?>

<style type="text/css">

body{
  margin: auto;
  width: 100%;
  height:68%;
  padding:0px;}
  .ticket{
    margin:auto;
    width: 100%;
  }
  table {
    width: 100%;
    color: #717375;
    font-family: helvetica;
    line-height: 5mm;
    border-collapse: collapse;
  }
  
  .border th {
    border: 1px solid black;
    padding: 0px;
    font-weight: bold;
    font-size: 13px;
    color: black;
    background: white;
    text-align: right;
    height: 12px; }
  .border td {
    border: 1px solid black;    
    font-size: 12px;
    color: black;
    background: white;
    text-align: center;
    height: 10px;
  }
  .footer{
    font-size: 14px;
    font-style: italic;
  }

</style>

<page backtop="5mm" backleft="15mm" backright="5mm" backbottom="15mm" footer="page;"><?php

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

  $adress = $DB->querys("SELECT * FROM adresse where lieuvente='{$lieuvente}' ");
  //require 'headerticketclient.php';?>

  <div>

    <table style="margin-top: 3px; margin-left:0px;" class="border">

      <thead>
        <tr>
          <th colspan="6" style="text-align:center; font-weight: bold; font-size: 18px; padding: 5px; border: 0px;">
            <?php echo $adress['nom_mag'];?></th>
        </tr>

        <tr>
          <td colspan="6" style="text-align:center; border: 0px;"><?=$adress['type_mag']; ?></td>
        </tr>

        <tr>
          <td colspan="6" style="text-align:center; border: 0px;"><?=$adress['adresse']; ?></td>
        </tr>
        <tr>
          <th colspan="6" style="text-align:right; font-size: 16px; border: 0px; "><?=$panier->adClient($_SESSION['reclient'])[0]; ?></th>
        </tr>

        <tr>
          <td colspan="6" style="text-align:right; font-size: 16px; border: 0px; "><?='Téléphone: '.$panier->adClient($_SESSION['reclient'])[1]; ?></td>
        </tr>

        <tr>
          <td colspan="6" style="text-align:right; font-size: 16px; border: 0px; "><?='Adresse: '.$panier->adClient($_SESSION['reclient'])[2]; ?></td>
        </tr>

         <tr>
          <td colspan="6" style="text-align:left; font-size: 16px; border: 0px; "><?= "Facture N°: " .$Num_cmd; ?></td>
        </tr>

        <tr>
          <td colspan="6" style="text-align:left; font-size: 16px; border: 0px; "><?="Date:  " .$payement['DateTemps']; ?></td>
        </tr><?php 
        if ($payement['etat']=='credit' and !empty($payement['datealerte'])) {?>

          <tr>
            <td colspan="6" style="text-align:left; font-size: 16px; border: 0px;"><?= "A régler avant le:  " .$payement['datealerte']; ?></td>
          </tr><?php 
        }?>

        <tr>
          <td colspan="6" style="text-align:left; font-size: 16px; border: 0px; border-bottom: 1px;"><?= "Vendeur:  " .$payement['vendeur']; ?></td>
        </tr>

        <tr>
          <th>N°</th>            
          <th style="width: 40%; text-align: left;text-align: center;">Désignation</th>
          <th style="width: 8%; padding-right: 5px; text-align: center;">Qtité</th>
          <th style="width: 8%; padding-right: 5px; text-align: center;">Livré</th>
          <th style="width: 17%; text-align: center;">Prix Unitaire</th>
          <th style="width: 23%; padding-right: 10px; text-align: center;">Prix Total</th>
        </tr>

      </thead>

      <tbody><?php

        $total=0;

         $products=$DB->query('SELECT quantity, commande.prix_vente as prix_vente, designation, qtiteliv, type, qtiteint, qtiteintp FROM commande inner join productslist on productslist.id=commande.id_produit WHERE num_cmd= ?', array($Num_cmd));

        $nbreligne=sizeof($products);
        $totqtite=0;
        $totqtiteliv=0;

        $totqtitep=0;
        $totqtitelivp=0;
        $totqtited=0;
        $totqtitelivd=0;
        foreach ($products as $key => $product){

          if ($product->type=='en_gros') {
            $totqtite+=$product->quantity;

            $qtiteint=$product->qtiteint;

            $totqtiteliv+=$product->qtiteliv;
          }elseif ($product->type=='detail') {
            $totqtited+=$product->quantity;

            $qtiteint='';

            $totqtitelivd+=$product->qtiteliv;
          }else{

            $totqtitep+=$product->quantity;
            $qtiteint='';

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
            <td><?=$key+1;?></td>

            <td style="width: 40%;text-align:left"><?=ucwords(strtolower($product->designation)).' ('.$qtiteint.')'; ?></td>

            <td style="width: 8%;"><?= $product->quantity; ?></td>

            <td style="width: 8%;"><?= $product->qtiteliv.'/'.$product->quantity; ?></td>

            <td style="width: 17%; text-align:right"><?=$pv; ?></td>

            <td style="width: 23%; text-align:right; padding-right: 10px;"><?= $pvtotal; ?></td><?php

            $price=($product->prix_vente*$product->quantity);

            $total += $price;?>

          </tr><?php
        }

        if (!empty($frais['motif'])) {

          $nbreligne=sizeof($products)+1;?>

          <tr>
            <td></td>              
            <td style="width: 40%;text-align:left"><?=ucwords($frais['motif']); ?></td>
            <td style="width: 8%;">-</td>
            <td style="width: 8%;">-</td>

            <td style="width: 17%; text-align:right"><?=number_format($frais['montant'],0,',',' '); ?></td>

            <td style="width: 23%; text-align:right; padding-right: 10px;"><?= number_format($frais['montant'],0,',',' '); ?></td>
          </tr><?php
        }

        $total=$total+$frais['montant'];

        $montantverse=$payement['montantpaye'];

        $Remise=$payement['remise'];

         $reste=$payement['reste'];

        $ttc = $total-$Remise;

        $tot_Rest = $total-$montantverse;

        if ($nbreligne==1) {

          $top=(200/($nbreligne));
        }else{

          $top=(245-($nbreligne*20));
        }
       ?>
      
      <tr>

        <td colspan="4" style="border:1px; border-bottom: 0px; padding-top: <?=$top.'px';?>;" class="space"></td>
        <td colspan="2" style="border:1px; padding-top:<?=$top.'px';?>;" class="space"></td>
      </tr>

      <tr>
        <td colspan="4" rowspan="4" style="padding: 2px; text-align: left; font-size:10px;">
        </td>
      </tr>

      <tr>
        <td style="text-align: right; border-left: 1px;" class="no-border">Montant Total </td>
        <td style="text-align:right; padding-right: 5px;"><?php echo number_format($total,0,',',' ') ?></td>
      </tr>

      <tr>
        <td style="text-align: right;" class="no-border">Montant Remise</td>               
        <td style="text-align:right; padding-right: 5px;"><?= number_format($Remise,0,',',' ') ?> (<?=($Remise/$total)*100;?>%)</td>        
      </tr>

      <tr>
        <td style="text-align: right; margin-bottom: 5px" class="no-border">Net à Payer </td>
        <td style="text-align:right; padding-right: 5px;"><?php echo number_format($ttc,0,',',' ') ?></td>
      </tr>

    </tbody>

    <tbody>

      <tr><?php

        if ($tot_Rest<=0) {?>
        
          <td colspan="4" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px; border-right: 0px;"><?="Montant Total Payé: ".number_format($montantverse,0,',',' ');?></td>

          <td colspan="2" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px;"><?="Rendu au Client: ".number_format(-$reste,0,',',' ');?> GNF</td><?php

        }else{?>

          <td colspan="4" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px; border-right: 0px;"><?="Montant Total Payé: ".number_format($montantverse,0,',',' ');?> GNF</td>

          <td colspan="2" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px;"><?="Reste à Payer: ".number_format($tot_Rest-$Remise,0,',',' ');?> GNF</td><?php

        }?>
      </tr>
      <tr>
        <td colspan="3" style="margin-top: 0px; color: grey; border: 0px;">European Market</td>
        <td colspan="3" style="margin-top: 0px; color: grey; border: 0px;"><?=$panier->adClient($_SESSION['reclient'])[0]; ?></td>
      </tr>
    </tbody>
  </table>
</div>
</page><?php 

//require 'piedprintticket.php';
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