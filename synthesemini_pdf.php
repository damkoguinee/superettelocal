<?php
require_once "lib/html2pdf.php";?>

<?php require '_header.php';

$pseudo=$_SESSION['pseudo'];

$products = $DB->querysI('SELECT *FROM personnel WHERE pseudo= :PSEUDO',array('PSEUDO'=>$pseudo));
ob_start(); ?>

<style type="text/css">
  table {
    width: 100%;
    color: black;
    border-collapse: collapse;
    margin-bottom: 30px;
    margin-top: 20px;

  }
    
    .border th{
      text-align: center;
      font-size: 14px;
      height: 10px;
      padding-top: 7px;
      padding-left: 5px;
      padding-right:5px;
      border: 1px solid black; 
    }

    .border td{
      text-align: left;
      font-size: 11.5px;
      height: 8px;
      padding-top: 6px;
      padding-left: 1px;
      padding-right: 1px;
      border: 1px solid black;
    }

    .compta th{
      height: 20px;
      text-align: center;
      font-size: 14px;
      padding-left: 5px;
      padding-right:5px;
      border: 1px solid black;
    }

    .compta td{
      text-align: center;
      font-size: 12px;
      padding-left: 5px;
      padding-right: 5px;
      border: 1px solid black;
    }
</style><?php

if ($products['level']>3) {?>

  <page backtop="2mm" backleft="5mm" backright="5mm" backbottom="5mm" >

    <div><?php require 'headerticket.php';


      $_SESSION['date1']=$_GET['date1'];
      $_SESSION['date2']=$_GET['date2'];
      $datenormale=$_GET['datenormale'];?></div></div>

    <div class="bloc_bilan">
              
      <table class="border">

        <thead>

          <tr>
            <th colspan="5"><?="Bilan " .$datenormale ?></th> 
          </tr>

          <tr>
            <th>Désignation</th>
            <th>Montant GNF</th>
            <th>Montant €</th>
            <th>Montant $</th>
            <th>Montant CFA</th>
          </tr>

        </thead>

        <tbody>

          <tr >                
            <td >Facturation(s) par Espèces</td>              
            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('gnf', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
          </tr>

          <tr>
            <td>Facturation(s) par Chèques</td>
            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('cheque', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
          </tr>

          <tr>
            <td>Facturation(s) Bancaire</td>
            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('virement', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
          </tr>

          <tr>
            <td style="font-size: 18px; padding-right: 5px;">Total des Facturations</td>

            <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('gnf', $_SESSION['date1'], $_SESSION['date2'])[0],0,',',' ');?></td>

            <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('eu', $_SESSION['date1'], $_SESSION['date2'])[1],0,',',' ');?></td>

            <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('us', $_SESSION['date1'], $_SESSION['date2'])[1],0,',',' ');?></td>

            <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('cfa',  $_SESSION['date1'], $_SESSION['date2'])[1],0,',',' ');?></td>
          </tr>

        <tr>
          <td style="color: orange; font-weight: bold; font-size: 18px;">Chiffre d'affaires</td>

          <td colspan="4" style="text-align: center; font-size: 18px; padding-right: 5px; color: orange; font-weight: bold;" ><?=number_format($panier->chiffrea($_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr>
          <td style="font-size: 18px; padding-right: 5px; color: red; font-weight: bold;">Crédits Clients</td>

          <td colspan="4" style="text-align: center; font-size: 18px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->resteFacturation($_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr>
          <td colspan="5" style="text-align:center; font-size: 20px; color:green;">Partie Encaissement</td>
        </tr>

        <tr >                
          <td >Encaissement par Espèces</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('gnf', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('eu', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('us', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('cfa', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr >                
          <td >Encaissement par Chèque</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('gnf', 'chèque', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
        </tr>

        <tr >                
          <td >Encaissement Bancaire</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('gnf', 'virement', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
        </tr>

        <tr >                
          <td >Encaissement Achat Devise</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('cfa', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr >                
          <td >Encaissement Liquidités</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->liquidite('gnf', 'liquidite', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" >---</td>

          <td style="text-align: right; padding-right: 5px;" >---</td>

          <td style="text-align: right; padding-right: 5px;" >---</td>
        </tr>

        <tr>
          <td style="font-size: 18px; padding-right: 5px;">Totaux Encaissements</td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('gnf', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2'])+$panier->liquidite('gnf', 'liquidite', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('eu', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('us', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('cfa', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('cfa', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr>
            <td style="font-size: 18px; padding-right: 5px; color: green; font-weight: bold;">TOTAL DES ENTREES</td>

            <td style="text-align: right; font-size: 16px; padding-right: 5px;color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('gnf', $_SESSION['date1'], $_SESSION['date2'])[0]+$panier->totalEncaissement('gnf', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2'])+$panier->liquidite('gnf', 'liquidite', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; font-size: 16px; padding-right: 5px; color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('eu', $_SESSION['date1'], $_SESSION['date2'])[1]+$panier->totalEncaissement('eu', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; font-size: 16px; padding-right: 5px; color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('us', $_SESSION['date1'], $_SESSION['date2'])[1]+$panier->totalEncaissement('us', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; font-size: 16px; padding-right: 5px; color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('cfa',  $_SESSION['date1'], $_SESSION['date2'])[1]+$panier->totalEncaissement('cfa', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('cfa', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
          </tr>

        <tr>
          <td colspan="5" style="text-align:center; font-size: 20px; color:red;">Partie Décaissement</td>
        </tr>

        <tr >                
          <td >Décaissement par Espèces</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('gnf', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('eu', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('us', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('cfa', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr >                
          <td >Décaissement par Chèque</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('gnf', 'chèque', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
        </tr>

        <tr >                
          <td >Décaissement Bancaire</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('gnf', 'virement', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
        </tr>

        <tr >                
          <td >Décaissement Achat Devise</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementCovertDevise('achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('eu', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('us', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('cfa', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr>
          <td style="font-size: 18px; padding-right: 5px; color: red; font-weight: bold;">Totaux des Décaissements</td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('gnf', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementCovertDevise('achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('eu', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('eu', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('us', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('us', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('cfa', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('cfa', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr><?php

        $soldetgnf=0;
      $soldeteu=0;
      $soldetus=0;
      $soldetcfa=0;

      foreach ($panier->nomBanque() as $banque) {

        if($banque->type!='banque'){?>

          <tr><?php

            if ($products['level']>3) {?>
              
              <th style="font-size:18px;"><?=strtoupper($banque->nomb);?> espèces du Jour</th>

              <th style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'gnf', $_SESSION['date1'], $_SESSION['date2'] )-$panier->caisseJourCheque($banque->id, 'gnf', $_SESSION['date1'], $_SESSION['date2'] ),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>
              <?php 
            }?>
          </tr>

          <tr><?php

            $soldetgnf+=$panier->montantCompteBil($banque->id, 'gnf');
            $soldeteu+=$panier->montantCompteBil($banque->id, 'eu');
            $soldetus+=$panier->montantCompteBil($banque->id, 'us');
            $soldetcfa+=$panier->montantCompteBil($banque->id, 'cfa');

            if ($products['level']>3) {?>
              
              <th style="font-size:18px;"><?=strtoupper($banque->nomb);?> Cumul espèces</th>

              <th style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'gnf')-$panier->montantCompteBilCheque($banque->id, 'gnf'),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'eu'),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'us'),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'cfa'),0,',',' ');?></th>
              <?php 
            }?>
          </tr><?php
        }


        if($banque->type!='banque'){?>

          <tr><?php

            if ($products['level']>3) {?>
              
              <th style="font-size:18px;"><?=strtoupper($banque->nomb);?> chèque du Jour</th>

              <th style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJourCheque($banque->id, 'gnf', $_SESSION['date1'], $_SESSION['date2'] ),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>
              <?php 
            }?>
          </tr>

          <tr><?php

            if ($products['level']>3) {?>
              
              <th style="font-size:18px;"><?=strtoupper($banque->nomb);?> Cumul chèque</th>

              <th style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBilCheque($banque->id, 'gnf'),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>
              <?php 
            }?>
          </tr><?php
        }
      }

        if ($products['level']>3) {?>
          <tr>
            <th style="font-size:16px";>Totaux</th>
            <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($soldetgnf,0,',',' ');?></th>
            <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($soldeteu,0,',',' ');?></th>
            <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($soldetus,0,',',' ');?></th>
            <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($soldetcfa,0,',',' ');?></th>
          </tr><?php
        }?>

      </tbody>
    </table>
  </div>
  </page>

  <page backtop="5mm" backleft="5mm" backright="5mm" backbottom="10mm" >
    <div><?php

    $productsc =$DB->querys("SELECT SUM(quantity) AS qtite, SUM(qtiteliv) as qtiteliv FROM commande inner join payement on payement.num_cmd=commande.num_cmd WHERE DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

    if (!empty($productsc)) {?>

      <table class="border">

        <thead>

          <tr>
            <th colspan="2"><?="Produits Facturés " .$datenormale ?></th>
          </tr>

          <tr>
            <th style="padding-right: 220px; padding-left: 220px;">Désignation</th>
            <th style="width: 120px;">Qtité Facturée</th>
          </tr>

        </thead>

        <tbody>
          <?php 
          $totalf=0;
          $totall=0;
          $products =$DB->query('SELECT id, designation FROM productslist');

          foreach ($products as $produc ){

            $product =$DB->querys("SELECT SUM(quantity) AS qtite, SUM(qtiteliv) as qtiteliv FROM commande inner join payement on payement.num_cmd=commande.num_cmd WHERE DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' AND commande.id_produit='{$produc->id}'");

                           

            $totalf+= $product['qtite'];
            $totall+= $product['qtiteliv'];

            if (!empty($product['qtite'])) {?>

              <tr>
                <td style="text-align: left;"><?= $produc->designation; ?></td>
                <td style="text-align:center;"><?= $product['qtite']; ?></td>
              </tr><?php

            }else{

            }
            
          }?>

          <tr>          
            <th colspan="1">Totaux</th>
            <th style="text-align: center;"><?= $totalf; ?></th>          
          </tr>

        </tbody>

      </table><?php 
    }

    $productsl =$DB->querys("SELECT sum(quantiteliv) as qtite FROM livraison WHERE DATE_FORMAT(dateliv, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(dateliv, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

    if (!empty($productsl)) {?>

      <table class="border">

        <thead>

          <tr>
            <th colspan="2" ><?="Produits Livrés " .$datenormale ?></th>
          </tr>

          <tr>
            <th style="padding-right: 220px; padding-left: 220px;">Désignation</th>
            <th style="width:120px;">Qtité Livrée</th>
          </tr>

        </thead>

          <tbody>
            <?php 
            $totalf=0;
            $totall=0;

            $products =$DB->query('SELECT id, designation FROM productslist');
            foreach ($products as $produc ){

              $products =$DB->querys("SELECT sum(quantiteliv) as qtite FROM livraison WHERE DATE_FORMAT(dateliv, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(dateliv, \"%Y%m%d\") <= '{$_SESSION['date2']}' AND id_produitliv='{$produc->id}'");

                             

              $totall+= $products['qtite'];

              if (!empty($products['qtite'])) {?>

                <tr>
                  <td style="text-align: left;"><?= ucwords(strtolower($produc->designation)); ?></td>
                  <td style="text-align:center;"><?= $products['qtite']; ?></td>
                </tr><?php
              }
              
            }?>

            <tr>          
              <th colspan="1">Totaux</th>
              <th style="text-align: center;"><?= $totall; ?></th>          
            </tr>

          </tbody>

        </table><?php
      } 


      $cumulmontant=0;
      $cumulmontantgnf=0;

      $montantgnf=0;
      $montanteu=0;
      $montantus=0;
      $montantcfa=0;

      $motif='achat devise';

      $products= $DB->query("SELECT *FROM devisevente WHERE DATE_FORMAT(dateop, \"%Y%m%d\")>='{$_SESSION['date1']}' and DATE_FORMAT(dateop, \"%Y%m%d\")<='{$_SESSION['date2']}' and motif='{$motif}' order by(dateop) LIMIT 50");

      

      if (!empty($products)) {?>

        <table class="border">

          <thead>

            <tr>
              <th colspan="9" ><?="Liste des Achats Devise ".$datenormale;?></th>
            </tr>

            <tr>
              <th>N°</th>
              <th>Date Op</th>
              <th>Client</th>              
              <th>Montant €</th>
              <th>Montant $</th>
              <th>Montant CFA</th>
              <th>Taux</th>     
              <th>Montant GNF</th>
              <th>T. P</th>
            </tr>

          </thead>

          <tbody><?php
                    
            $soldegnf=0;
            $soldeeu=0;
            $soldeus=0;
            $soldecfa=0;
            foreach ($products as $key=> $product ){

              $cumulmontant+=$product->montant;
              $cumulmontantgnf+=$product->montant*$product->taux; ?>

              <tr>
                <td style="text-align: center;"><?= $key+1; ?></td>

                <td style="text-align: center;"><?=(new DateTime($product->dateop))->format("d/m/Y à H:i");?></td>

                <td><?= ucwords(strtolower($product->client)); ?></td><?php

                if ($product->devise=='eu') {

                  $montanteu+=$product->montant;?>

                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                  <td></td>
                  <td></td><?php

                }elseif ($product->devise=='us') {

                  $montantus+=$product->montant;?>

                  <td></td>

                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                  <td></td><?php

                }elseif ($product->devise=='cfa') {

                  $montantcfa+=$product->montant;?>
                  
                  <td></td>

                  <td></td>

                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td><?php

                }?> 

                <td style="text-align: right; padding-right: 10px;"><?=number_format($product->taux,0,',',' ');?></td>

                <td style="text-align: right; padding-right: 10px;"><?=number_format($product->montant*$product->taux,0,',',' ');?></td>  

                <td><?= $product->typep; ?></td>
              </tr><?php 
            }?>

            </tbody>

            <tfoot>
              <tr>
                <th colspan="3">Totaux</th>
                <th style="text-align: right; padding-right: 10px;"><?= number_format($montanteu,0,',',' ');?></th>
                <th style="text-align: right; padding-right: 10px;"><?= number_format($montantus,0,',',' ');?></th>
                <th style="text-align: right; padding-right: 10px;"><?= number_format($montantcfa,0,',',' ');?></th>
                <th></th>
                <th style="text-align: right padding-right: 10px;;"><?= number_format($cumulmontantgnf,0,',',' ');?></th>
              </tr>
            </tfoot>

          </table><?php
        }


      $products=$DB->query("SELECT nom_client as clientvip, client, montant, DATE_FORMAT(date_payement, \"%d/%m/%Y \")AS DateTemps FROM fraisup inner join client on client=client.id where DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

      

      if (!empty($products)) {?>

        <table class="border">

          <thead>

            <tr>
              <th colspan="4" ><?="Liste des frais supplementaire " .$datenormale ?></th>
            </tr>

            <tr>
              <th style="padding-right: 150px; padding-left: 150px;">Nom</th>
              <th>Motif</th>
              <th>Montant</th>
              <th>Date</th>
            </tr>

          </thead>

          <tbody><?php 
            $totaldepenses=0;

            foreach ($products as $product ){
              if (!empty($product->clientvip)) {
                $client=$product->clientvip;
              }else{
                $client=$product->client;
              }
              $totaldepenses+=$product->montant;?>
              <tr>
                <td><?= ucwords($client); ?></td> 
                <td><?= ucwords('Frais Supplementaire achat'); ?></td>
                <td style="text-align: right; padding-right: 15px"><?= number_format($product->montant,0,',',' '); ?></td>
                <td><?= $product->DateTemps; ?></td>         
                
              </tr><?php 
            }?>


          </tbody>

          <tfoot>

            <tr>
              <th colspan="2">Totaux</th>
              <th style="text-align: right;padding-right: 15px"><?= number_format($totaldepenses,0,',',' ') ; ?></th>
            </tr>

          </tfoot>

        </table><?php 
      }

      
      $products=$DB->query("SELECT nom_client as client, frais, DATE_FORMAT(datecmd, \"%d/%m/%Y \")AS DateTemps FROM facture inner join client on fournisseur=client.id where DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(facture.id)DESC");

     

      if (!empty($products)) {?>

        <table class="border">

          <thead>

            <tr>
              <th colspan="4" ><?="Liste des frais marchandises " .$datenormale ?></th>
            </tr>

            <tr>
              <th style="padding-right: 150px; padding-left: 150px;">Fournisseur</th>
              <th>Motif</th>
              <th>Montant</th>
              <th>Date</th>
            </tr>

          </thead>

          <tbody><?php 
            $totaldepenses=0;       

            foreach ($products as $product ){
              $totaldepenses+=$product->frais;?>

              <tr>
                <td><?= ucwords($product->client); ?></td>                   
                                       
                <td><?= ucfirst('Frais Marchandises'); ?></td>
                <td style="text-align: right; padding-right: 15px"><?= number_format($product->frais,0,',',' '); ?></td>
                <td><?= $product->DateTemps; ?></td>          
                
              </tr><?php 
            }?>


          </tbody>

          <tfoot>

            <tr>
              <th colspan="2">Totaux</th>
              <th style="text-align: right;padding-right: 15px"><?= number_format($totaldepenses,0,',',' ') ; ?></th>
            </tr>

          </tfoot>

        </table><?php 
      }

      $products=$DB->query("SELECT montant, coment, DATE_FORMAT(date_payement, \"%d/%m/%Y \")AS DateTemps FROM decdepense where DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(id)DESC");

      

      if (!empty($products)) {?>

        <table class="border">

          <thead>

            <tr>
              <th colspan="3"><?="Liste des Dépenses " .$datenormale?></th>
            </tr>

            <tr>                      
              <th>Date</th>
              <th style="width:300px;">Motif</th>
              <th>Montant</th>
            </tr>

          </thead>

          <tbody><?php 
            $totaldepenses=0;       

            foreach ($products as $product ){

              $totaldepenses+=$product->montant;?>
              <tr> 

                <td><?= $product->DateTemps; ?></td>                       
                <td><?= strtolower($product->coment); ?></td>
                <td style="text-align: right; padding-right: 15px"><?= number_format($product->montant,0,',',' '); ?></td>          
                
              </tr><?php 
            } ?>


          </tbody>

          <tfoot>

            <tr>
              <th colspan="2">Total</th>
              <th style="text-align: right;padding-right: 15px"><?= number_format($totaldepenses,0,',',' ') ; ?></th>
            </tr>

          </tfoot>

        </table><?php 
      }

      $products=$DB->query("SELECT decaissement.id as id, montant, devisedec, payement as type, client.id as idc, nom_client as client, coment, date_payement AS DateTemps FROM decaissement left join client on decaissement.client=client.id where DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

      $prodep=$DB->querys("SELECT id, montant, devisedep as devisedec, payement as type, client as client, coment, date_payement AS DateTemps FROM decdepense where DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");



            

      if (!empty($products)) {?>
       
        <table  class="border">

          <thead>

            <tr>
              <th colspan="11" ><?="Liste des Décaissements " .$datenormale ?></th>
            </tr>

            <tr>
              <th>N°</th>
              <th>Client</th>
              <th>Motif</th>
              <th>Date</th>
              <th>GNF</th>
              <th>$</th>
              <th>€</th>
              <th>CFA</th>
              <th>V. Banque</th>
              <th>Chèque</th>
              <th>Solde Client</th>
            </tr>

          </thead>

          <tbody><?php
            $montantgnf=0;
            $montanteu=0;
            $montantus=0;
            $montantcfa=0;
            $virement=0;
            $cheque=0;
            $keyd=0;
            foreach ($products as $keyv=> $product ){
              $keyd+=($keyv+1);?>

              <tr>
                <td style="text-align: center;"><?= $keyv+1; ?></td>
                <td><?= $product->client; ?></td>
                <td><?= ucwords(strtolower($product->coment)); ?></td>
                <td style="text-align:center;"><?= $product->DateTemps; ?></td><?php

                if ($product->devisedec=='gnf' and $product->type=='espèces') {

                  $montantgnf+=$product->montant;?>

                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td><?php

                }elseif ($product->devisedec=='us') {
                  $montantus+=$product->montant;?>

                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td><?php
                }elseif ($product->devisedec=='eu') {
                  $montanteu+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td>
                  <td></td>
                  <td></td><?php
                }elseif ($product->devisedec=='cfa') {
                  $montantcfa+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td>
                  <td></td><?php

                }elseif ($product->type=='virement') {
                  $virement+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td><?php
                }elseif ($product->type=='chèque') {
                  $cheque+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td><?php
                }?>

                <td style="text-align: right; padding-right: 10px;"><?=number_format(-$panier->compteClient($product->idc, 'gnf'),0,',',' '); ?></td> 
                
              </tr><?php 
            }?>

            <tr>
              <td style="text-align: center;"><?= $keyd+1; ?></td>
              <td colspan="3">Décaissement Devise</td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementCovertDevise('achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('us', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('eu', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('cfa', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ></td>

              <td style="text-align: right; padding-right: 10px;" ></td>

              <td style="text-align: right; padding-right: 10px;" ></td>             
            </tr><?php

            $keydep=0;?>

            <tr>
              <td style="text-align: center;"><?= $keyd+2; ?></td>
              <td colspan="2">Dépense</td>
              <td style="text-align:center;"><?= $prodep['DateTemps']; ?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('gnf', 'espèces', $_SESSION['date1'], $_SESSION['date2'])-$montantgnf,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('us', 'espèces', $_SESSION['date1'], $_SESSION['date2'])-$montantus,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('eu', 'espèces', $_SESSION['date1'], $_SESSION['date2'])-$montanteu,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('cfa', 'espèces', $_SESSION['date1'], $_SESSION['date2'])-$montantcfa,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('gnf', 'virement', $_SESSION['date1'], $_SESSION['date2'])-$virement,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('gnf', 'cheque', $_SESSION['date1'], $_SESSION['date2'])-$cheque,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ></td>            
            </tr>

          </tbody>

          <tfoot>
            <tr>
              <th colspan="4">Totaux Décaissements</th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('gnf', 'espèces', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementCovertDevise('achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('us', 'espèces', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('us', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('eu', 'espèces', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('eu', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('cfa', 'espèces', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('cfa', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('gnf', 'virement', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('gnf', 'cheque', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th></th>
            </tr>
          </tfoot>

        </table><?php
      }


    $products=$DB->query("SELECT client.nom_client as nom_client, client.id as idc, montant, devisevers, type_versement, motif, date_versement FROM versement inner join client on versement.nom_client=client.id where DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");?>

      
       
      <table  class="border">

        <thead>

          <tr>
            <th colspan="11"><?="Liste des Encaissements " .$datenormale ?></th>
          </tr>

          <tr>
            <th>N°</th>
            <th>Client</th>
            <th>Motif</th>
            <th>Date</th>
            <th>GNF</th>
            <th>$</th>
            <th>€</th>
            <th>CFA</th>
            <th>V. Banque</th>
            <th>Chèque</th>
            <th>Solde Client</th>
          </tr>

        </thead>

        <tbody><?php
          $montantgnf=0;
          $montanteu=0;
          $montantus=0;
          $montantcfa=0;
          $virement=0;
          $cheque=0;
          $keyenc=0;
          foreach ($products as $keye=> $product ){
            $keyenc=$keye+1;?>

            <tr>
              <td style="text-align: center;"><?= $keye+1; ?></td>
              <td><?= $product->nom_client; ?></td>
              <td><?= ucwords(strtolower($product->motif)); ?></td>
              <td style="text-align:center;"><?=(new DateTime($product->date_versement))->format("d/m/Y à H:i"); ?></td><?php

              if ($product->devisevers=='gnf' and $product->type_versement=='espèces') {

                $montantgnf+=$product->montant;?>

                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td><?php

              }elseif ($product->devisevers=='us') {
                $montantus+=$product->montant;?>

                <td></td>
                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td><?php
              }elseif ($product->devisevers=='eu') {
                $montanteu+=$product->montant;?>

                <td></td>
                <td></td>
                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                <td></td>
                <td></td>
                <td></td><?php
              }elseif ($product->devisevers=='cfa') {
                $montantcfa+=$product->montant;?>

                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                <td></td>
                <td></td><?php

              }elseif ($product->type_versement=='virement') {
                $virement+=$product->montant;?>

                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                <td></td><?php
              }elseif ($product->type_versement=='chèque') {
                $cheque+=$product->montant;?>

                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td><?php
              }?>

              <td style="text-align: right; padding-right: 10px;"><?=number_format(-$panier->compteClient($product->idc, 'gnf'),0,',',' '); ?></td> 
              
            </tr><?php 
          }?>

          <tr>
            <td style="text-align: center;"><?= $keyenc+1; ?></td>
            <td colspan="3">Encaissement Devise</td>

            <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('cfa', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; padding-right: 10px;" ></td>

            <td style="text-align: right; padding-right: 10px;" ></td>

            <td style="text-align: right; padding-right: 10px;" ></td>              
          </tr>

          <tr>
        <td style="text-align: center;"><?= $keyenc+1; ?></td>
        <td colspan="3">Encaissement liquidités</td>

        <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->liquidite('gnf', 'liquidite', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 10px;" >---</td>

        <td style="text-align: right; padding-right: 10px;" >---</td>

        <td style="text-align: right; padding-right: 10px;" >---</td>

        <td style="text-align: right; padding-right: 10px;" >---</td>

        <td style="text-align: right; padding-right: 10px;" >---</td>

        <td style="text-align: right; padding-right: 10px;" >---</td>              
      </tr>

        </tbody>

        <tfoot>
          <tr>
            <th colspan="4">Totaux Versements</th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2'])+$montantgnf+$panier->liquidite('gnf', 'liquidite', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2'])+$montantus,0,',',' ');?></th>

            <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2'])+$montanteu,0,',',' ');?></th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($montantcfa,0,',',' ');?></th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($virement,0,',',' ');?></th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($cheque,0,',',' ');?></th>
            <th></th>
          </tr>
        </tfoot>

      </table><?php


      $products=$DB->query("SELECT *FROM payement where DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

      if (!empty($products)) {?>

        <table class="border">
          <thead>
            <tr>
              <th colspan="10"><?="Liste des Facturations " .$datenormale ?></th>
            </tr>

            <tr>
              <th>N°</th>
              <th>N° Cmd</th>
              <th>Date Cmd</th>
              <th>Etat</th>
              <th>Liv</th>
              <th>Remise</th>
              <th>Total</th>
              <th>Montant</th>
              <th>Client</th>
              <th>Solde GNF</th>
            </tr>
          </thead>
          <tbody><?php

            $cumulmontanremp=0;
            $cumulmontantotp=0;
            $cumulmontanrestp=0;

            foreach ($products as $key=> $product ){

              $cumulmontanremp+=$product->remise;
              $cumulmontantotp+=$product->Total-$product->remise;
              $cumulmontanrestp+=$product->montantpaye; ?>

              <tr>
                <td style="text-align:center;"><?=$key+1;?></td>

                <td><?= $product->num_cmd; ?></td>

                <td style="text-align:center;"><?= $panier->formatDate($product->date_cmd); ?></td>

                <td style="text-align:center;"><?= $product->etat; ?></td>

                <td style="text-align:center;"><?= $product->etatliv; ?></td>

                <td style="text-align:right"><?= number_format($product->remise,0,',',' '); ?></td>

                <td style="text-align: right"><?= number_format(($product->Total-$product->remise),0,',',' '); ?></td>
                <td style="text-align:right"><?= number_format($product->montantpaye,0,',',' '); ?> </td>

                <td style="font-size:10.5px;"><?= $panier->nomClient($product->num_client); ?></td>

                <td style="text-align: right; padding-right: 10px;"><?=number_format(-$panier->compteClient($product->num_client, 'gnf'),0,',',' '); ?></td>
              </tr><?php 
            } ?>   
          </tbody>

          <tfoot>
            <tr>
              <th colspan="5"></th>
              <th style="text-align: right;"><?= number_format($cumulmontanremp,0,',',' ');?></th>
              <th style="text-align: right;"><?= number_format($cumulmontantotp,0,',',' ');?></th>
              <th style="text-align: right;"><?= number_format($cumulmontanrestp,0,',',' ');?></th>
            </tr>
          </tfoot>
        </table><?php 
      }?>
  </div>

  </page><?php
}

$_SESSION['lieuvented']=$_SESSION['lieuvente'];

foreach ($panier->listeStock() as $key => $value) {

  $_SESSION['lieuvente']=$value->id;?>

  <page backtop="5mm" backleft="5mm" backright="5mm" backbottom="10mm" >

    <div><?php require 'headerticket.php';     

      $_SESSION['date1']=$_GET['date1'];
      $_SESSION['date2']=$_GET['date2'];
      $datenormale=ucwords($value->nomstock).' '.$_GET['datenormale'];?></div>
    </div>

    <div class="bloc_bilan">
            
      <table class="border">

        <thead>

          <tr>
            <th colspan="5"><?="Bilan " .$datenormale ?></th> 
          </tr><?php 

          $prodnbre =$DB->querys("SELECT sum(montant) as tot FROM decdepense WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

          $prodnbrev =$DB->querys("SELECT sum(prix_vente*quantity) as pv, sum(prix_revient*quantity) as pr FROM commande inner join payement on commande.num_cmd=payement.num_cmd WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

          $prodnbrebenv =$DB->querys("SELECT sum(remise) as remise FROM payement WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

          $benefice=($prodnbrev['pv']-$prodnbrev['pr']-$prodnbrebenv['remise']-$prodnbre['tot']);?>


          <tr>
            <th colspan="2">Dépenses: <?=number_format($prodnbre['tot'],0,',',' '); ?></th>
            <th colspan="3">Bénéfice: <?=number_format($benefice,0,',',' '); ?></th> 
          </tr>

          <tr>
            <th>Désignation</th>
            <th>Montant GNF</th>
            <th>Montant €</th>
            <th>Montant $</th>
            <th>Montant CFA</th>
          </tr>

        </thead>

        <tbody>

          <tr >                
            <td >Facturation(s) par Espèces</td>              
            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('gnf', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
          </tr>

          <tr>
            <td>Facturation(s) par Chèques</td>
            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('cheque', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
          </tr>

          <tr>
            <td>Facturation(s) Bancaire</td>
            <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('virement', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
          </tr>

          <tr>
            <td style="font-size: 18px; padding-right: 5px;">Total des Facturations</td>

            <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('gnf', $_SESSION['date1'], $_SESSION['date2'])[0],0,',',' ');?></td>

            <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('eu', $_SESSION['date1'], $_SESSION['date2'])[1],0,',',' ');?></td>

            <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('us', $_SESSION['date1'], $_SESSION['date2'])[1],0,',',' ');?></td>

            <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('cfa',  $_SESSION['date1'], $_SESSION['date2'])[1],0,',',' ');?></td>
          </tr>

        <tr>
          <td style="color: orange; font-weight: bold; font-size: 18px;">Chiffre d'affaires</td>

          <td colspan="4" style="text-align: center; font-size: 18px; padding-right: 5px; color: orange; font-weight: bold;" ><?=number_format($panier->chiffrea($_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr>
          <td style="font-size: 18px; padding-right: 5px; color: red; font-weight: bold;">Crédits Clients</td>

          <td colspan="4" style="text-align: center; font-size: 18px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->resteFacturation($_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr>
          <td colspan="5" style="text-align:center; font-size: 20px; color:green;">Partie Encaissement</td>
        </tr>

        <tr >                
          <td >Encaissement par Espèces</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('gnf', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('eu', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('us', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('cfa', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr >                
          <td >Encaissement par Chèque</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('gnf', 'chèque', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
        </tr>

        <tr >                
          <td >Encaissement Bancaire</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('gnf', 'virement', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
        </tr>

        <tr >                
          <td >Encaissement Achat Devise</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('cfa', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr>
          <td style="font-size: 18px; padding-right: 5px;">Totaux Encaissements</td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('gnf', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('eu', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('us', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('cfa', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('cfa', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr>
            <td style="font-size: 18px; padding-right: 5px; color: green; font-weight: bold;">TOTAL DES ENTREES</td>

            <td style="text-align: right; font-size: 16px; padding-right: 5px;color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('gnf', $_SESSION['date1'], $_SESSION['date2'])[0]+$panier->totalEncaissement('gnf', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; font-size: 16px; padding-right: 5px; color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('eu', $_SESSION['date1'], $_SESSION['date2'])[1]+$panier->totalEncaissement('eu', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; font-size: 16px; padding-right: 5px; color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('us', $_SESSION['date1'], $_SESSION['date2'])[1]+$panier->totalEncaissement('us', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

            <td style="text-align: right; font-size: 16px; padding-right: 5px; color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('cfa',  $_SESSION['date1'], $_SESSION['date2'])[1]+$panier->totalEncaissement('cfa', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('cfa', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
          </tr>

        <tr>
          <td colspan="5" style="text-align:center; font-size: 20px; color:red;">Partie Décaissement</td>
        </tr>

        <tr >                
          <td >Décaissement par Espèces</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('gnf', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('eu', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('us', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('cfa', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr >                
          <td >Décaissement par Chèque</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('gnf', 'chèque', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
        </tr>

        <tr >                
          <td >Décaissement Bancaire</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('gnf', 'virement', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
            <td style="text-align: right" ></td>
        </tr>

        <tr >                
          <td >Décaissement Achat Devise</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementCovertDevise('achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('eu', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('us', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('cfa', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr>
          <td style="font-size: 18px; padding-right: 5px; color: red; font-weight: bold;">Totaux des Décaissements</td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('gnf', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementCovertDevise('achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('eu', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('eu', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('us', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('us', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 16px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('cfa', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('cfa', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr><?php

        $soldetgnf=0;
        $soldeteu=0;
        $soldetus=0;
        $soldetcfa=0;

        foreach ($panier->nomBanque() as $banque) {?>

          <tr>
              
              <th style="font-size:16px;"><?=strtoupper($banque->nomb);?> du Jour</th>

              <th style="font-size:14px;text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'gnf', $_SESSION['date1'], $_SESSION['date2'] ),0,',',' ');?></th>

              <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>
          </tr>

          <tr><?php

            $soldetgnf+=$panier->montantCompteBil($banque->id, 'gnf');
            $soldeteu+=$panier->montantCompteBil($banque->id, 'eu');
            $soldetus+=$panier->montantCompteBil($banque->id, 'us');
            $soldetcfa+=$panier->montantCompteBil($banque->id, 'cfa');?>
              
              <th style="font-size:16px;">Cumul <?=strtoupper($banque->nomb);?></th>

              <th style="font-size:14px;text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'gnf')-$panier->montantCompteBilCheque($banque->id, 'gnf'),0,',',' ');?></th>

              <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'eu'),0,',',' ');?></th>

              <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'us'),0,',',' ');?></th>

              <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'cfa'),0,',',' ');?></th>
          </tr><?php 

          if($banque->type!='banque'){?>

            <tr><?php

              if ($_SESSION['level']>3) {?>
                
                <th style="font-size:14px;"><?=strtoupper($banque->nomb);?> Cumul chèque</th>

                <th style="font-size:14px;text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBilCheque($banque->id, 'gnf'),0,',',' ');?></th>

                <th style="font-size:14px; text-align:right; padding-right: 5px;">--</th>

                <th style="font-size:14px; text-align:right; padding-right: 5px;">--</th>

                <th style="font-size:14px; text-align:right; padding-right: 5px;">--</th>
                <?php 
              }?>
            </tr><?php
          }
        }?>
          <tr>
            <th style="font-size:16px";>Totaux</th>
            <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($soldetgnf,0,',',' ');?></th>
            <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($soldeteu,0,',',' ');?></th>
            <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($soldetus,0,',',' ');?></th>
            <th style="font-size:14px; text-align:right; padding-right: 5px;"><?=number_format($soldetcfa,0,',',' ');?></th>
          </tr>

        </tbody>
      </table>
    </div>
  </page>


  <page backtop="5mm" backleft="5mm" backright="5mm" backbottom="10mm" >
    <div><?php

      $productsc =$DB->querys("SELECT SUM(quantity) AS qtite, SUM(qtiteliv) as qtiteliv FROM commande inner join payement on payement.num_cmd=commande.num_cmd WHERE DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

      if (!empty($productsc)) {?>
        <table class="border">

          <thead>

            <tr>
              <th colspan="2"><?="Produits Facturés " .$datenormale ?></th>
            </tr>

            <tr>
              <th style="padding-right: 220px; padding-left: 220px;">Désignation</th>
              <th style="width:120px;">Qtité Facturée</th>
            </tr>

          </thead>

          <tbody>
            <?php 
            $totalf=0;
            $totall=0;
            $products =$DB->query('SELECT id, designation FROM productslist');

            foreach ($products as $produc ){

              $product =$DB->querys("SELECT SUM(quantity) AS qtite, SUM(qtiteliv) as qtiteliv FROM commande inner join payement on payement.num_cmd=commande.num_cmd WHERE lieuvente='{$_SESSION['lieuvente']}' and  DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' AND commande.id_produit='{$produc->id}'");
                   

              $totalf+= $product['qtite'];
              $totall+= $product['qtiteliv'];

              if (!empty($product['qtite'])) {?>

                <tr>
                  <td style="text-align: left;"><?= $produc->designation; ?></td>
                  <td style="text-align:center;"><?= $product['qtite']; ?></td>
                </tr><?php

              }else{

              }
              
            }?>

            <tr>          
              <th colspan="1">Totaux</th>
              <th style="text-align: center;"><?= $totalf; ?></th>          
            </tr>

          </tbody>

        </table><?php 
      }

      $productsl =$DB->querys("SELECT sum(quantiteliv) as qtite FROM livraison WHERE idstockliv='{$_SESSION['lieuvente']}' and  DATE_FORMAT(dateliv, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(dateliv, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

      if (empty($productsl)) {?>

        <table class="border">

      <thead>

        <tr>
          <th colspan="2" ><?="Produits Livrés " .$datenormale ?></th>
        </tr>

        <tr>
          <th style="padding-right: 220px; padding-left: 220px;">Désignation</th>
          <th style="width:120px;">Qtité Livrée</th>
        </tr>

      </thead>

        <tbody>
          <?php 
          $totalf=0;
          $totall=0;

          $products =$DB->query('SELECT id, designation FROM productslist');
          foreach ($products as $produc ){

            $products =$DB->querys("SELECT sum(quantiteliv) as qtite FROM livraison WHERE idstockliv='{$_SESSION['lieuvente']}' and  DATE_FORMAT(dateliv, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(dateliv, \"%Y%m%d\") <= '{$_SESSION['date2']}' AND id_produitliv='{$produc->id}'");                

            $totall+= $products['qtite'];

            if (!empty($products['qtite'])) {?>

              <tr>
                <td style="text-align: left;"><?= ucwords(strtolower($produc->designation)); ?></td>
                <td style="text-align:center;"><?= $products['qtite']; ?></td>
              </tr><?php
            }
            
          }?>

          <tr>          
            <th colspan="1">Totaux</th>
            <th style="text-align: center;"><?= $totall; ?></th>          
          </tr>

        </tbody>

      </table><?php 
    }

    $cumulmontant=0;
    $cumulmontantgnf=0;

    $montantgnf=0;
    $montanteu=0;
    $montantus=0;
    $montantcfa=0;

    $motif='achat devise';

    $products= $DB->query("SELECT *FROM devisevente WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\")>='{$_SESSION['date1']}' and DATE_FORMAT(dateop, \"%Y%m%d\")<='{$_SESSION['date2']}' and motif='{$motif}' order by(dateop) LIMIT 50");

    if (!empty($products)) {?>

      <table class="border">

        <thead>

          <tr>
            <th colspan="9" ><?="Liste des Achats Devise ".$datenormale;?></th>
          </tr>

          <tr>
            <th>N°</th>
            <th>Date Op</th>
            <th>Client</th>              
            <th>Montant €</th>
            <th>Montant $</th>
            <th>Montant CFA</th>
            <th>Taux</th>     
            <th>Montant GNF</th>
            <th>T. P</th>
          </tr>

        </thead>

        <tbody><?php 
          
                  
          $soldegnf=0;
          $soldeeu=0;
          $soldeus=0;
          $soldecfa=0;
          foreach ($products as $key=> $product ){

            $cumulmontant+=$product->montant;
            $cumulmontantgnf+=$product->montant*$product->taux; ?>

            <tr>
              <td style="text-align: center;"><?= $key+1; ?></td>

              <td style="text-align: center;"><?=(new DateTime($product->dateop))->format("d/m/Y à H:i");?></td>

              <td><?= ucwords(strtolower($product->client)); ?></td><?php

              if ($product->devise=='eu') {

                $montanteu+=$product->montant;?>

                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                <td></td>
                <td></td><?php

              }elseif ($product->devise=='us') {

                $montantus+=$product->montant;?>

                <td></td>

                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                <td></td><?php

              }elseif ($product->devise=='cfa') {

                $montantcfa+=$product->montant;?>
                
                <td></td>

                <td></td>

                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td><?php

              }?> 

              <td style="text-align: right; padding-right: 10px;"><?=number_format($product->taux,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;"><?=number_format($product->montant*$product->taux,0,',',' ');?></td>  

              <td><?= $product->typep; ?></td>
            </tr><?php 
          }?>

          </tbody>

          <tfoot>
            <tr>
              <th colspan="3">Totaux</th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($montanteu,0,',',' ');?></th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($montantus,0,',',' ');?></th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($montantcfa,0,',',' ');?></th>
              <th></th>
              <th style="text-align: right padding-right: 10px;;"><?= number_format($cumulmontantgnf,0,',',' ');?></th>
            </tr>
          </tfoot>

        </table><?php
      }

      $products=$DB->query("SELECT nom_client as clientvip, client, montant, DATE_FORMAT(date_payement, \"%d/%m/%Y \")AS DateTemps FROM fraisup inner join client on client=client.id where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(fraisup.id)DESC");

      if (!empty($products)) {?>

        <table class="border">

          <thead>

            <tr>
              <th colspan="4" ><?="Liste des frais supplementaire " .$datenormale ?></th>
            </tr>

            <tr>
              <th style="padding-right: 150px; padding-left: 150px;">Nom</th>
              <th>Motif</th>
              <th>Montant</th>
              <th>Date</th>
            </tr>

          </thead>

          <tbody><?php 
            $totaldepenses=0;

            foreach ($products as $product ){
              if (!empty($product->clientvip)) {
                $client=$product->clientvip;
              }else{
                $client=$product->client;
              }
              $totaldepenses+=$product->montant;?>
              <tr>
                <td><?= ucwords($client); ?></td> 
                <td><?= ucwords('Frais Supplementaire achat'); ?></td>
                <td style="text-align: right; padding-right: 15px"><?= number_format($product->montant,0,',',' '); ?></td>
                <td><?= $product->DateTemps; ?></td>         
                  
              </tr><?php 
            }?>


          </tbody>

          <tfoot>

            <tr>
              <th colspan="2">Totaux</th>
              <th style="text-align: right;padding-right: 15px"><?= number_format($totaldepenses,0,',',' ') ; ?></th>
            </tr>

          </tfoot>

        </table><?php 
      }


      $products=$DB->query("SELECT nom_client as client, frais, DATE_FORMAT(datecmd, \"%d/%m/%Y \")AS DateTemps FROM facture inner join client on fournisseur=client.id where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(facture.id)DESC");

      if (!empty($products)) {?>

        <table class="border">

          <thead>

            <tr>
              <th colspan="4" ><?="Liste des frais marchandises " .$datenormale ?></th>
            </tr>

            <tr>
              <th style="padding-right: 150px; padding-left: 150px;">Fournisseur</th>
              <th>Motif</th>
              <th>Montant</th>
              <th>Date</th>
            </tr>

          </thead>

          <tbody><?php 
            $totaldepenses=0;       

            foreach ($products as $product ){
              $totaldepenses+=$product->frais;?>

              <tr>
                <td><?= ucwords($product->client); ?></td>                   
                                       
                <td><?= ucfirst('Frais Marchandises'); ?></td>
                <td style="text-align: right; padding-right: 15px"><?= number_format($product->frais,0,',',' '); ?></td>
                <td><?= $product->DateTemps; ?></td>
              </tr>          
                
              <?php 
            }?>


          </tbody>

          <tfoot>

            <tr>
              <th colspan="2">Totaux</th>
              <th style="text-align: right;padding-right: 15px"><?= number_format($totaldepenses,0,',',' ') ; ?></th>
            </tr>

          </tfoot>

        </table><?php 
      }


      $products=$DB->query("SELECT montant, coment, DATE_FORMAT(date_payement, \"%d/%m/%Y \")AS DateTemps FROM decdepense where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(id)DESC");


      if (!empty($products)) {?>

        <table class="border">

          <thead>

            <tr>
              <th colspan="3"><?="Liste des Dépenses " .$datenormale?></th>
            </tr>

            <tr>                      
              <th>Date</th>
              <th style="width:300px;">Motif</th>
              <th>Montant</th>
            </tr>

          </thead>

          <tbody><?php 
            $totaldepenses=0;       

            foreach ($products as $product ){

              $totaldepenses+=$product->montant;?>
              <tr> 

                <td><?= $product->DateTemps; ?></td>                       
                <td><?= strtolower($product->coment); ?></td>
                <td style="text-align: right; padding-right: 15px"><?= number_format($product->montant,0,',',' '); ?></td>          
                
              </tr><?php 
            } ?>


          </tbody>

          <tfoot>

            <tr>
              <th colspan="2">Total</th>
              <th style="text-align: right;padding-right: 15px"><?= number_format($totaldepenses,0,',',' ') ; ?></th>
            </tr>

          </tfoot>

        </table><?php 
      }

      $products =$DB->query("SELECT decaissement.id as id, montant, devisedec, payement as type, client.id as idc, nom_client as client, coment, date_payement AS DateTemps FROM decaissement inner join client on decaissement.client=client.id  WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

      $prodep=$DB->querys("SELECT id, sum(montant) as montant, devisedep as devisedec, payement as type, client as client, coment, date_payement AS DateTemps FROM decdepense where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");
    

      if (!empty($products)) {?>
       
        <table  class="border">

          <thead>

            <tr>
              <th colspan="11" ><?="Liste des Décaissements " .$datenormale ?></th>
            </tr>

            <tr>
              <th>N°</th>
              <th>Client</th>
              <th>Motif</th>
              <th>Date</th>
              <th>GNF</th>
              <th>$</th>
              <th>€</th>
              <th>CFA</th>
              <th>V. Banque</th>
              <th>Chèque</th>
              <th>Solde Client</th>
            </tr>

          </thead>

          <tbody><?php
            $montantgnf=0;
            $montanteu=0;
            $montantus=0;
            $montantcfa=0;
            $virement=0;
            $cheque=0;
            $keyd=0;
            foreach ($products as $keyv=> $product ){
              $keyd+=($keyv+1);?>

              <tr>
                <td style="text-align: center;"><?= $keyv+1; ?></td>
                <td><?= $product->client; ?></td>
                <td><?= ucwords(strtolower($product->coment)); ?></td>
                <td style="text-align:center;"><?= $product->DateTemps; ?></td><?php

                if ($product->devisedec=='gnf' and $product->type=='espèces') {

                  $montantgnf+=$product->montant;?>

                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td><?php

                }elseif ($product->devisedec=='us') {
                  $montantus+=$product->montant;?>

                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td><?php
                }elseif ($product->devisedec=='eu') {
                  $montanteu+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td>
                  <td></td>
                  <td></td><?php
                }elseif ($product->devisedec=='cfa') {
                  $montantcfa+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td>
                  <td></td><?php

                }elseif ($product->type=='virement') {
                  $virement+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td><?php
                }elseif ($product->type=='chèque') {
                  $cheque+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td><?php
                }?>

                <td style="text-align: right; padding-right: 10px;"><?=number_format(-$panier->compteClient($product->idc, 'gnf'),0,',',' '); ?></td> 
                
              </tr><?php 
            }?>

            <tr>
              <td style="text-align: center;"><?= $keyd+1; ?></td>
              <td colspan="3">Décaissement Devise</td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementCovertDevise('achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('us', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('eu', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('cfa', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ></td>

              <td style="text-align: right; padding-right: 10px;" ></td>

              <td style="text-align: right; padding-right: 10px;" ></td>             
            </tr><?php

            $keydep=0;?>

            <tr>
              <td style="text-align: center;"><?= $keyd+2; ?></td>
              <td colspan="2">Dépense</td>
              <td style="text-align:center;"><?= $prodep['DateTemps']; ?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('gnf', 'espèces', $_SESSION['date1'], $_SESSION['date2'])-$montantgnf,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('us', 'espèces', $_SESSION['date1'], $_SESSION['date2'])-$montantus,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('eu', 'espèces', $_SESSION['date1'], $_SESSION['date2'])-$montanteu,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('cfa', 'espèces', $_SESSION['date1'], $_SESSION['date2'])-$montantcfa,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('gnf', 'virement', $_SESSION['date1'], $_SESSION['date2'])-$virement,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->decaissementBil('gnf', 'cheque', $_SESSION['date1'], $_SESSION['date2'])-$cheque,0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ></td>            
            </tr>

          </tbody>

          <tfoot>
            <tr>
              <th colspan="4">Totaux Décaissements</th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('gnf', 'espèces', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementCovertDevise('achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('us', 'espèces', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('us', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('eu', 'espèces', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('eu', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('cfa', 'espèces', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('cfa', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('gnf', 'virement', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->decaissementBil('gnf', 'cheque', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th></th>
            </tr>
          </tfoot>

        </table><?php
      }



      $products =$DB->query("SELECT client.nom_client as nom_client, client.id as idc, montant, devisevers, type_versement, motif, date_versement FROM versement inner join client on versement.nom_client=client.id  WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

    

      if (!empty($products)) {?>
       
        <table  class="border">

          <thead>

            <tr>
              <th colspan="11"><?="Liste des Encaissements " .$datenormale ?></th>
            </tr>

            <tr>
              <th>N°</th>
              <th>Client</th>
              <th>Motif</th>
              <th>Date</th>
              <th>GNF</th>
              <th>$</th>
              <th>€</th>
              <th>CFA</th>
              <th>V. Banque</th>
              <th>Chèque</th>
              <th>Solde Client</th>
            </tr>

          </thead>

          <tbody><?php
            $montantgnf=0;
            $montanteu=0;
            $montantus=0;
            $montantcfa=0;
            $virement=0;
            $cheque=0;
            $keyenc=0;
            foreach ($products as $keye=> $product ){
              $keyenc=$keye+1;?>

              <tr>
                <td style="text-align: center;"><?= $keye+1; ?></td>
                <td><?= $product->nom_client; ?></td>
                <td><?= ucwords(strtolower($product->motif)); ?></td>
                <td style="text-align:center;"><?=(new DateTime($product->date_versement))->format("d/m/Y à H:i"); ?></td><?php

                if ($product->devisevers=='gnf' and $product->type_versement=='espèces') {

                  $montantgnf+=$product->montant;?>

                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td><?php

                }elseif ($product->devisevers=='us') {
                  $montantus+=$product->montant;?>

                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td><?php
                }elseif ($product->devisevers=='eu') {
                  $montanteu+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td>
                  <td></td>
                  <td></td><?php
                }elseif ($product->devisevers=='cfa') {
                  $montantcfa+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td>
                  <td></td><?php

                }elseif ($product->type_versement=='virement') {
                  $virement+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                  <td></td><?php
                }elseif ($product->type_versement=='chèque') {
                  $cheque+=$product->montant;?>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td><?php
                }?>

                <td style="text-align: right; padding-right: 10px;"><?=number_format(-$panier->compteClient($product->idc, 'gnf'),0,',',' '); ?></td> 
                
              </tr><?php 
            }?>

            <tr>
              <td style="text-align: center;"><?= $keyenc+1; ?></td>
              <td colspan="3">Encaissement Devise</td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ><?=number_format($panier->encaissementDevise('cfa', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="text-align: right; padding-right: 10px;" ></td>

              <td style="text-align: right; padding-right: 10px;" ></td>

              <td style="text-align: right; padding-right: 10px;" ></td>              
            </tr>

          </tbody>

          <tfoot>
            <tr>
              <th colspan="4">Totaux Versements</th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2'])+$montantgnf,0,',',' ');?></th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2'])+$montantus,0,',',' ');?></th>

              <th style="text-align: right; padding-right: 10px;"><?= number_format($panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2'])+$montanteu,0,',',' ');?></th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($montantcfa,0,',',' ');?></th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($virement,0,',',' ');?></th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($cheque,0,',',' ');?></th>
              <th></th>
            </tr>
          </tfoot>

        </table><?php
      }

    $products=$DB->query("SELECT *FROM payement where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

    if (!empty($products)) {?>

      <table class="border">
        <thead>
          <tr>
            <th colspan="11"><?="Liste des Facturations " .$datenormale ?></th>
          </tr>

          <tr>
            <th>N°</th>
            <th>N° Cmd</th>
            <th>Date Cmd</th>
            <th>Etat</th>
            <th>Liv</th>
            <th>Remise</th>
            <th>Total</th>
            <th>Montant</th>
            <th>Client</th>
            <th>Solde GNF</th>
          </tr>
        </thead>
        <tbody><?php

          

          $cumulmontanremp=0;
          $cumulmontantotp=0;
          $cumulmontanrestp=0;

          foreach ($products as $key=> $product ){

            $cumulmontanremp+=$product->remise;
            $cumulmontantotp+=$product->Total-$product->remise;
            $cumulmontanrestp+=$product->montantpaye; ?>

            <tr>
              <td style="text-align:center;"><?=$key+1;?></td>

              <td><?= $product->num_cmd; ?></td>

              <td style="text-align:center;"><?= $panier->formatDate($product->date_cmd); ?></td>

              <td style="text-align:center;"><?= $product->etat; ?></td>

              <td style="text-align:center;"><?= $product->etatliv; ?></td>

              <td style="text-align:right"><?= number_format($product->remise,0,',',' '); ?></td>

              <td style="text-align: right"><?= number_format(($product->Total-$product->remise),0,',',' '); ?></td>
              <td style="text-align:right"><?= number_format($product->montantpaye,0,',',' '); ?> </td>

              <td style="font-size:10.5px;"><?= $panier->nomClient($product->num_client); ?></td>

              <td style="text-align: right; padding-right: 10px;"><?=number_format(-$panier->compteClient($product->num_client, 'gnf'),0,',',' '); ?></td>
            </tr><?php 
          } ?>   
        </tbody>

        <tfoot>
          <tr>
            <th colspan="5"></th>
            <th style="text-align: right;"><?= number_format($cumulmontanremp,0,',',' ');?></th>
            <th style="text-align: right;"><?= number_format($cumulmontantotp,0,',',' ');?></th>
            <th style="text-align: right;"><?= number_format($cumulmontanrestp,0,',',' ');?></th>
          </tr>
        </tfoot>
      </table><?php 
    }?>
    </div>
  </page><?php
}

$_SESSION['lieuvente']=$_SESSION['lieuvented'];

$content = ob_get_clean();
try {
  $pdf = new HTML2PDF("p","A4","fr", true, "UTF-8" , 0);
  $pdf->pdf->SetAuthor('Amadou');
  $pdf->pdf->SetTitle(date("d/m/y"));
  $pdf->pdf->SetSubject('Création d\'un Portfolio');
  $pdf->pdf->SetKeywords('HTML2PDF, Synthese, PHP');
  $pdf->pdf->IncludeJS("print(true);");
  $pdf->writeHTML($content);
  ob_clean();
  $pdf->Output('Bilan du'.date("d/m/y").date("H:i:s").'.pdf');
  // $pdf->Output('Devis.pdf', 'D');    
} catch (HTML2PDF_exception $e) {
  die($e);
}
//header("Location: index.php");
?>