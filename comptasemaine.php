<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

  if ($products['level']>=3) {
    
    require 'delete.php';

    if (!isset($_POST['j1'])) {

      $_SESSION['date']=date("Ymd");  
      $dates = $_SESSION['date'];
      $dates = new DateTime( $dates );
      $dates = $dates->format('Ymd'); 
      $_SESSION['date']=$dates;
      $_SESSION['date1']=$dates;
      $_SESSION['date2']=$dates;
      $_SESSION['dates1']=$dates; 

      $_SESSION['lieuvented']=$_SESSION['lieuvente'];

    }else{

      $_SESSION['date01']=$_POST['j1'];
      $_SESSION['date1'] = new DateTime($_SESSION['date01']);
      $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
      
      $_SESSION['date02']=$_POST['j2'];
      $_SESSION['date2'] = new DateTime($_SESSION['date02']);
      $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

      $_SESSION['dates1']=(new DateTime($_SESSION['date01']))->format('d/m/Y');
      $_SESSION['dates2']=(new DateTime($_SESSION['date02']))->format('d/m/Y');

      $_SESSION['lieuvente']=$_POST['magasin'];
    }


    if (isset($_POST['j2'])) {

      $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

    }else{

      $datenormale=(new DateTime($dates))->format('d/m/Y');
    }?>

    <form style="margin-top: 20px;" id='naissance' method="POST" action="comptasemaine.php">

      <table style="margin-top: 10px;" class="payement">

        <thead>

          <tr>
            <th>Magasin</th>
            <th colspan="2">Début ----------- Fin</th>                   
            <th>Nbre V</th>
            <th style="font-size: 22px; padding-right: 5px; color: orange; font-weight: bold;">Chiffres d'affaires</th>
            <th>Charges</th>
            <th>Pertes Prod</th>
            <th>Var Dévise</th>
            <th><?php if ($products['statut']!='vendeur') {?>Bénéfice <?php }?></th>
          </tr>

        </thead>

        <tbody>

          <tr>
            <td>
              <select  name="magasin" onchange="this.form.submit()"><?php

                if (isset($_POST['magasin']) and $_POST['magasin']=='general') {?>

                  <option value="<?=$_POST['magasin'];?>">Général</option><?php
                  
                }elseif (isset($_POST['magasin'])) {?>

                  <option value="<?=$_POST['magasin'];?>"><?=$panier->nomStock($_POST['magasin'])[0];?></option><?php
                  
                }else{?>

                  <option value="<?=$_SESSION['lieuvente'];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php

                }

                if ($_SESSION['level']>6) {

                  foreach($panier->listeStock() as $product){?>

                    <option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

                  }?>

                  <option value="general">Général</option><?php
                }?>
              </select>
            </td><?php

            if (isset($_POST['j1'])) {?>

              <td style="border-right: 0px;"><input id="reccode" style="width: 130px; font-size: 14px;" type = "date" name = "j1" value="<?=$_SESSION['date01'];?>" onchange="this.form.submit()"></td><?php

            }else{?>

              <td style="border-right: 0px;"><input id="reccode" style="width: 130px; font-size: 14px;" type = "date" name = "j1" onchange="this.form.submit()"></td><?php

            }

            if (isset($_POST['j2'])) {?>

              <td style="border-left: 0px;"><input id="reccode" style="width: 130px; font-size: 14px;" type = "date" name = "j2" value="<?=$_SESSION['date02'];?>" onchange="this.form.submit()"></td><?php

            }else{?>

              <td style="border-left: 0px;"><input id="reccode" style="width: 130px; font-size: 14px;" type = "date" name = "j2" onchange="this.form.submit()"></td><?php

            }?> 

            <td style="text-align: center;"><?=$panier->nbreVente($_SESSION['date1'], $_SESSION['date2']); ?></td>

            <td style="font-size: 22px; text-align: center; padding-right: 5px; color: orange; font-weight: bold;"><?=number_format($panier->chiffrea($_SESSION['date1'], $_SESSION['date2']),0,',',' '); ?></td><?php

            if ($products['level']>=6) {?>

              <td style="text-align: center;"><?=number_format($panier->depenseTot($_SESSION['date1'], $_SESSION['date2']),0,',',' '); ?></td>

              <td style="text-align: center;"><?=number_format($panier->perteben($_SESSION['date1'], $_SESSION['date2']),0,',',' '); ?></td>

              <td style="text-align: center;"><?=number_format($panier->gaindevise($_SESSION['date1'], $_SESSION['date2']),0,',',' '); ?></td>

              <td style="text-align: center;"><?php if ($products['statut']!='vendeur') {?><?=number_format($panier->benefice($_SESSION['date1'], $_SESSION['date2']),0,',',' '); ?><?php } ?></td><?php 
            }else{?>

              <td></td>
              <td></td><?php 
            }?>
          </tr>

        </tbody>

      </table>
    </form><?php
    
    require 'headercompta.php';

    require 'bilansemaine.php';?>

    

    <div>


      <table class="payement">

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
        $cumulmontant=0;
        $cumulmontantgnf=0;

        $montantgnf=0;
        $montanteu=0;
        $montantus=0;
        $montantcfa=0;

        $motif='achat devise';

        if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

          $products= $DB->query("SELECT *FROM devisevente WHERE DATE_FORMAT(dateop, \"%Y%m%d\")>='{$_SESSION['date1']}' and DATE_FORMAT(dateop, \"%Y%m%d\")<='{$_SESSION['date2']}' and motif='{$motif}' order by(dateop) LIMIT 50");

        }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

          $products= $DB->query("SELECT *FROM devisevente WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\")>='{$_SESSION['date1']}' and DATE_FORMAT(dateop, \"%Y%m%d\")<='{$_SESSION['date2']}' and motif='{$motif}' order by(dateop) LIMIT 50");

        }else{

          $products= $DB->query("SELECT *FROM devisevente WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\")>='{$_SESSION['date1']}' and DATE_FORMAT(dateop, \"%Y%m%d\")<='{$_SESSION['date2']}' and motif='{$motif}' order by(dateop) LIMIT 50");

        }         
                
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

      </table>

  </div>

  <div style="margin-right: 30px"><?php 

    if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

      $products=$DB->query("SELECT nom_client as clientvip, client, montant, DATE_FORMAT(date_payement, \"%d/%m/%Y \")AS DateTemps FROM fraisup inner join client on client=client.id where DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

    }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

      $products=$DB->query("SELECT nom_client as clientvip, client, montant, DATE_FORMAT(date_payement, \"%d/%m/%Y \")AS DateTemps FROM fraisup inner join client on client=client.id where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(fraisup.id)DESC");

    }else{

      $products=$DB->query("SELECT nom_client as clientvip, client, montant, DATE_FORMAT(date_payement, \"%d/%m/%Y \")AS DateTemps FROM fraisup inner join client on client=client.id where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(fraisup.id)DESC");

    }

    if (!empty($products)) {?>

      <table class="payement">

        <thead>

          <tr>
            <th class="legende" colspan="4" height="30"><?="Liste des frais supplementaire " .$datenormale ?></th>
          </tr>

          <tr>
            <th>Nom</th>
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
            <td><?= ucwords($client); ?></td> 
            <td><?= ucwords('Frais Supplementaire achat'); ?></td>
            <td style="text-align: right; padding-right: 15px"><?= number_format($product->montant,0,',',' '); ?></td>
            <td><?= $product->DateTemps; ?></td>         
              
            </tr><?php 
          }?>


        </tbody>

        <tfoot>

          <tr>
            <th colspan="2">TOTAL</th>
            <th style="text-align: right;padding-right: 15px"><?= number_format($totaldepenses,0,',',' ') ; ?></th>
          </tr>

        </tfoot>

      </table><?php 
    }?>

  </div>

  <div style="display:flex;">

    <div style="margin-right: 30px"><?php
    $typef='transfert';


      if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

        $products=$DB->query("SELECT frais, DATE_FORMAT(datecmd, \"%d/%m/%Y \")AS DateTemps FROM facture where type='{$typef}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(facture.id)DESC");

      }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

        $products=$DB->query("SELECT frais, DATE_FORMAT(datecmd, \"%d/%m/%Y \")AS DateTemps FROM facture  where type='{$typef}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(facture.id)DESC");

      }else{

        $products=$DB->query("SELECT frais, DATE_FORMAT(datecmd, \"%d/%m/%Y \")AS DateTemps FROM facture inner join client on fournisseur=client.id where type='{$typef}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(facture.id)DESC");

      }

      if (!empty($products)) {?>

        <table class="payement">

          <thead>

            <tr>
              <th class="legende" colspan="3" height="30"><?="Liste des frais de transferts des Produits " .$datenormale ?></th>
            </tr>

            <tr>
              <th>Motif</th>
              <th>Montant</th>
              <th>Date</th>
            </tr>

          </thead>

          <tbody><?php 
            $totaldepenses=0;       

            foreach ($products as $product ){
              $totaldepenses+=$product->frais;?>                  
                                       
                <td><?= ucfirst('Frais des transferts marchandises'); ?></td>
                <td style="text-align: right; padding-right: 15px"><?= number_format($product->frais,0,',',' '); ?></td>
                <td><?= $product->DateTemps; ?></td>          
                
              </tr><?php 
            }?>


          </tbody>

          <tfoot>

            <tr>
              <th colspan="1">TOTAL</th>
              <th style="text-align: right;padding-right: 15px"><?= number_format($totaldepenses,0,',',' ') ; ?></th>
            </tr>

          </tfoot>

        </table><?php 
      }?>
    </div>

    <div><?php

      $typef='transfert';

      if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

        $products=$DB->query("SELECT nom_client as client, frais, DATE_FORMAT(datecmd, \"%d/%m/%Y \")AS DateTemps FROM facture inner join client on fournisseur=client.id where type!='{$typef}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(facture.id)DESC");

      }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

        $products=$DB->query("SELECT nom_client as client, frais, DATE_FORMAT(datecmd, \"%d/%m/%Y \")AS DateTemps FROM facture inner join client on fournisseur=client.id where type!='{$typef}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(facture.id)DESC");

      }else{

        $products=$DB->query("SELECT nom_client as client, frais, DATE_FORMAT(datecmd, \"%d/%m/%Y \")AS DateTemps FROM facture inner join client on fournisseur=client.id where type!='{$typef}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datecmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(facture.id)DESC");

      }

      if (!empty($products)) {?>

        <table class="payement">

          <thead>

            <tr>
              <th class="legende" colspan="4" height="30"><?="Liste des frais marchandises " .$datenormale ?></th>
            </tr>

            <tr>
              <th>Fournisseur</th>
              <th>Motif</th>
              <th>Montant</th>
              <th>Date</th>
            </tr>

          </thead>

          <tbody><?php 
            $totaldepenses=0;       

            foreach ($products as $product ){
              $totaldepenses+=$product->frais;?>
              <td><?= ucwords($product->client); ?></td>                   
                                       
                <td><?= ucfirst('Frais Marchandises'); ?></td>
                <td style="text-align: right; padding-right: 15px"><?= number_format($product->frais,0,',',' '); ?></td>
                <td><?= $product->DateTemps; ?></td>          
                
              </tr><?php 
            }?>


          </tbody>

          <tfoot>

            <tr>
              <th colspan="2">TOTAL</th>
              <th style="text-align: right;padding-right: 15px"><?= number_format($totaldepenses,0,',',' ') ; ?></th>
            </tr>

          </tfoot>

        </table><?php 
      }?>
    </div>

  </div>

  <div style="margin-right: 30px"><?php 
    if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

      $products=$DB->query("SELECT montant, coment, DATE_FORMAT(date_payement, \"%d/%m/%Y \")AS DateTemps FROM decdepense where DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(id)DESC");

    }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

      $products=$DB->query("SELECT montant, coment, DATE_FORMAT(date_payement, \"%d/%m/%Y \")AS DateTemps FROM decdepense where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(id)DESC");

    }else{

      $products=$DB->query("SELECT montant, coment, DATE_FORMAT(date_payement, \"%d/%m/%Y \")AS DateTemps FROM decdepense where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY(id)DESC");

    }

    if (!empty($products)) {?>

      <table class="payement">

        <thead>

          <tr>
            <th class="legende" colspan="3" height="30"><?="Liste des depenses " .$datenormale?></th>
          </tr>

          <tr>                      
            <th>Date</th>
            <th>Motif</th>
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
            <th colspan="2">TOTAL</th>
            <th style="text-align: right;padding-right: 15px"><?= number_format($totaldepenses,0,',',' ') ; ?></th>
          </tr>

        </tfoot>

      </table><?php 
    }?>
  
  </div>
</div>


<div class="bilan_dec">

  <div class="dec"><?php

    if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

      $products=$DB->query("SELECT decaissement.id as id, montant, devisedec, payement as type, client.id as idc, nom_client as client, coment, date_payement AS DateTemps FROM decaissement left join client on decaissement.client=client.id where DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

      $prodep=$DB->querys("SELECT id, montant, devisedep as devisedec, payement as type, client as client, coment, date_payement AS DateTemps FROM decdepense where DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");



    }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

      $products=$DB->query("SELECT decaissement.id as id, montant, devisedec, payement as type, client.id as idc, nom_client as client, coment, date_payement AS DateTemps FROM decaissement left join client on decaissement.client=client.id where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

      $prodep=$DB->querys("SELECT id, sum(montant) as montant, devisedep as devisedec, payement as type, client as client, coment, date_payement AS DateTemps FROM decdepense where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

    }else{

      $products =$DB->query("SELECT decaissement.id as id, montant, devisedec, payement as type, client.id as idc, nom_client as client, coment, date_payement AS DateTemps FROM decaissement left join client on decaissement.client=client.id  WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

      $prodep=$DB->querys("SELECT id, sum(montant) as montant, devisedep as devisedec, payement as type, client as client, coment, date_payement AS DateTemps FROM decdepense where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

    }

    

    if (!empty($products)) {?>
     
      <table  class="payement">

        <thead>

          <tr>
            <th class="legende" colspan="11" height="30"><?="Liste des Décaissements " .$datenormale ?></th>
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
            <td style="text-align:center;">--</td>

            <td style="text-align: right; padding-right: 10px;" ><?=number_format($prodep['montant'],0,',',' ');?></td>

            <td style="text-align: right; padding-right: 10px;" >--</td>

            <td style="text-align: right; padding-right: 10px;" >--</td>

            <td style="text-align: right; padding-right: 10px;" >--</td>

            <td style="text-align: right; padding-right: 10px;" >--</td>

            <td style="text-align: right; padding-right: 10px;" >--</td>

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
    }?>

  </div>

  <div class="cred"><?php

    if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

      $products=$DB->query("SELECT client.nom_client as nom_client, client.id as idc, montant, devisevers, type_versement, motif, date_versement FROM versement inner join client on versement.nom_client=client.id where DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

    }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

      $products=$DB->query("SELECT client.nom_client as nom_client, client.id as idc, montant, devisevers, type_versement, motif, date_versement FROM versement inner join client on versement.nom_client=client.id where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

    }else{

      $products =$DB->query("SELECT client.nom_client as nom_client, client.id as idc, montant, devisevers, type_versement, motif, date_versement FROM versement inner join client on versement.nom_client=client.id  WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

    }?>
     
    <table  class="payement">

      <thead>

        <tr>
          <th class="legende" colspan="11" height="30"><?="Liste des Encaissements " .$datenormale ?></th>
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

    /*?>

    <table style="margin-top: 30px;" class="payement">

      <thead>
        <tr>
          <th class="legende" colspan="10" height="30"><?="Détails des Produits Vendus " .$datenormale ?></th>
        </tr>

        <tr>
          <th>N°</th>
          <th>N° Cmd</th>
          <th>Désignation</th>
          <th>Date Cmd</th>
          <th>Qtité Cmd</th>
          <th>Qtite Liv</th>
          <th>P.Vente</th>
          <th>P.Revient</th>
          <th>Bénéfice</th>
          <th>Client</th>          
        </tr>
      </thead>

      <tbody><?php
        if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

          $products=$DB->query("SELECT id_produit as idprod, commande.num_cmd as numc, quantity, qtiteliv, commande.prix_vente as prix_vente,commande.prix_revient as prix_revient, etat, date_cmd, id_client as idc FROM commande inner join payement on payement.num_cmd=commande.num_cmd where DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

        }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

          $products=$DB->query("SELECT id_produit as idprod, commande.num_cmd as numc, quantity, qtiteliv, commande.prix_vente as prix_vente,commande.prix_revient as prix_revient, etat, date_cmd, id_client as idc FROM commande inner join payement on payement.num_cmd=commande.num_cmd where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

        }else{

          $products =$DB->query("SELECT id_produit as idprod, commande.num_cmd as numc, quantity, qtiteliv, commande.prix_vente as prix_vente,commande.prix_revient as prix_revient, etat, date_cmd, id_client as idc FROM commande inner join payement on payement.num_cmd=commande.num_cmd  WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

        } 

        $cumulmontantotc=0;
        $cumulrevient=0;
        $qtiteliv=0;
        $qtitecmd=0;
        foreach ($products as $keyc=> $product ){
          $qtitecmd+=$product->quantity;
          $qtiteliv+=$product->qtiteliv;

          $cumulmontantotc+=$product->prix_vente*$product->quantity;
          $cumulrevient+=$product->prix_revient*$product->quantity; ?>

          <tr>
            <td style="text-align:center"><?= $keyc+1; ?></td>
            <td style="text-align:center"><?= $product->numc; ?></td>
            <td><?=ucwords(strtolower($panier->nomProduit($product->idprod))); ?></td>
            <td style="text-align:center"><?= $panier->formatDate($product->date_cmd); ?></td>
            <td style="text-align:center"><?= $product->quantity; ?></td>
            <td style="text-align:center"><?= $product->qtiteliv; ?></td>
            <td style="text-align: right"  ><?= number_format($product->prix_vente*$product->quantity,0,',',' '); ?></td>
            <td style="text-align: right"  ><?php if ($_SESSION['statut']=='responsable' and $_SESSION['level']>6) {?><?= number_format($product->prix_revient*$product->quantity,0,',',' '); ?><?php }?></td>
            <td style="text-align: right"  ><?php if ($_SESSION['statut']=='responsable' and $_SESSION['level']>6) {?><?= number_format($product->prix_vente*$product->quantity-$product->prix_revient*$product->quantity,0,',',' '); ?><?php }?></td>
            <td><?= $panier->nomClient($product->idc); ?></td>
          </tr><?php 
        }?>

      </tbody>

      <tfoot>
          <tr>
            <th colspan="4">Totaux</th>
            <th style="text-align: center;"><?= $qtitecmd;?></th>
            <th style="text-align: center;"><?= $qtiteliv;?></th>
            <th style="text-align: right;"><?= number_format($cumulmontantotc,0,',',' ');?></th>
            <th style="text-align: right;"><?php if ($_SESSION['statut']=='responsable' and $_SESSION['level']>6) {?><?= number_format($cumulrevient,0,',',' ');?><?php }?></th>
            <th style="text-align: right;"><?php if ($_SESSION['statut']=='responsable' and $_SESSION['level']>6) {?><?= number_format($cumulmontantotc-$cumulrevient,0,',',' ');?><?php }?></th>
          </tr>
        </tfoot>

    </table>

    */;?>

    <table style="margin-top: 30px;" class="payement">
      <thead>
        <tr>
          <th class="legende" colspan="13" height="30"><?="Liste des Facturations Crédits " .$datenormale ?></th>
        </tr>

        <tr>
          <th>N°</th>
          <th>N° Cmd</th>
          <th>Date Cmd</th>
          <th>Etat</th>
          <th>Livraison</th>
          <th>Remise</th>
          <th>Total</th>
          <th>Montant</th>
          <th>Client</th>
          <th>Solde GNF</th>
        </tr>
      </thead>
      <tbody><?php

        $etat='credit';

        if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

          $products=$DB->query("SELECT *FROM payement where etat='{$etat}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

        }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

          $products=$DB->query("SELECT *FROM payement where etat='{$etat}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

        }else{

          $products =$DB->query("SELECT *FROM payement WHERE etat='{$etat}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

        }

        $cumulmontanremp=0;
        $cumulmontantotp=0;
        $cumulmontanrestp=0;

        foreach ($products as $key=> $product ){

          $cumulmontanremp+=$product->remise;
          $cumulmontantotp+=$product->Total-$product->remise;
          $cumulmontanrestp+=$product->montantpaye; ?>

          <tr>
            <td style="text-align:center;"><?=$key+1;?></td>

            <td><a style="color: red;" href="recherche.php?recreditc=<?=$product->num_cmd;?>"><?= $product->num_cmd; ?></a></td>

            <td style="text-align:center;"><?= $panier->formatDate($product->date_cmd); ?></td>

            <td style="text-align:center;"><?= $product->etat; ?></td>

            <td style="text-align:center;"><?= $product->etatliv; ?></td>

            <td style="text-align:right"><?= number_format($product->remise,0,',',' '); ?></td>

            <td style="text-align: right"><?= number_format(($product->Total-$product->remise),0,',',' '); ?></td>
            <td style="text-align:right"><?= number_format($product->montantpaye,0,',',' '); ?> </td>

            <td><?= $panier->nomClient($product->num_client); ?></td>

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
    </table>


    <table style="margin-top: 30px;" class="payement">

      <thead>
        <tr>
          <th class="legende" colspan="10" height="30"><?="Détails des Produits Vendus " .$datenormale ?><a style="margin-left: 10px;"href="csv.php?vente" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/excel.jpg"></a></th>
        </tr>

        <tr>
          <th>N°</th>
          <th>Désignation</th>
          <th>Qtité</th>
          <th>P.Achat</th>
          <th>P.Revient</th>
          <th>P.Vente</th>          
          <th>Bénéfice</th>
          <th>Date</th>
          <th>Etat</th>
          <th>Contact du Client</th>
        </tr>
      </thead>

      <tbody><?php 

        if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

          $products =$DB->query('SELECT commande.num_cmd as num_cmd, designation, quantity, commande.prix_vente as prix_vente,commande.prix_revient as prix_revient, commande.prix_achat as pa, etat, typeclient, nom_client as clientvip, DATE_FORMAT(date_cmd,  \'%d/%m/%Y\')AS DateTemps FROM productslist inner join commande on commande.id_produit=productslist.id inner join payement on payement.num_cmd=commande.num_cmd left join client on client.id=id_client WHERE  DATE_FORMAT(date_cmd, \'%Y%m%d\') >= :date1 and DATE_FORMAT(date_cmd, \'%Y%m%d\') <= :date2 order by(designation)', array('date1' => $_SESSION['date1'],'date2' => $_SESSION['date2']));

        }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

          $products =$DB->query("SELECT commande.num_cmd as num_cmd, designation, quantity, commande.prix_vente as prix_vente,commande.prix_revient as prix_revient, commande.prix_achat as pa, etat, typeclient, nom_client as clientvip, DATE_FORMAT(date_cmd,  \"%d/%m/%Y\")AS DateTemps FROM productslist inner join commande on commande.id_produit=productslist.id inner join payement on payement.num_cmd=commande.num_cmd left join client on client.id=id_client WHERE  lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >= '{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' order by(designation)");

        }else{
          $products =$DB->query("SELECT commande.num_cmd as num_cmd, designation, quantity, commande.prix_vente as prix_vente,commande.prix_revient as prix_revient, commande.prix_achat as pa, etat, typeclient, nom_client as clientvip, DATE_FORMAT(date_cmd,  \"%d/%m/%Y\")AS DateTemps FROM productslist inner join commande on commande.id_produit=productslist.id inner join payement on payement.num_cmd=commande.num_cmd left join client on client.id=id_client WHERE  lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >= '{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' order by(designation)");

        } 
        

        $cumulmontantotc=0;
        $cumulrevient=0;
        $cumulpa=0;
        foreach ($products as $product ){

            $client=$product->clientvip;
          

          $cumulmontantotc+=$product->prix_vente*$product->quantity;
          $cumulrevient+=$product->prix_revient*$product->quantity;
          $cumulpa+=$product->pa*$product->quantity; ?>

          <tr>
           <td><a style="color: red;" href="recherche.php?recreditc=<?=$product->num_cmd;?>"><?= $product->num_cmd; ?></a></td>
            <td><?= $product->designation; ?></td>
            <td style="text-align:center"><?= $product->quantity; ?></td>

            <td style="text-align: right"  ><?= number_format($product->pa*$product->quantity,0,',',' '); ?></td>

            <td style="text-align: right"  ><?= number_format($product->prix_revient*$product->quantity,0,',',' '); ?></td>

            <td style="text-align: right"  ><?= number_format($product->prix_vente*$product->quantity,0,',',' '); ?></td>
            
            <td style="text-align: right"  ><?= number_format($product->prix_vente*$product->quantity-$product->prix_revient*$product->quantity,0,',',' '); ?></td>
            <td><?= $product->DateTemps; ?></td>
            <td><?= $product->etat; ?></td>
            <td><?= $client; ?></td>
          </tr><?php 

        }?>

      </tbody>

      <tfoot>
          <tr>
            <th colspan="3"></th>
            <th style="text-align: right;"><?= number_format($cumulrevient,0,',',' ');?></th>

            <th style="text-align: right;"><?= number_format($cumulpa,0,',',' ');?></th>

            <th style="text-align: right;"><?= number_format($cumulmontantotc,0,',',' ');?></th>
            
            <th style="text-align: right;"><?= number_format($cumulmontantotc-$cumulrevient,0,',',' ');?></th>
          </tr>
        </tfoot>

    </table>
<?php

    $_SESSION['lieuvente']=$_SESSION['lieuvented'];
  }else{

      echo "VOUS N'AVEZ PAS TOUTES LES AUTORISATIOS REQUISES";
    }

  }else{


  }?>
  
</body>
</html>

<script type="text/javascript">
  function alerteS(){
    return(confirm('Valider la suppression'));
  }

  function alerteM(){
    return(confirm('Voulez-vous vraiment modifier cette vente?'));
  }

  function focus(){
    document.getElementById('reccode').focus();
  }
</script>

