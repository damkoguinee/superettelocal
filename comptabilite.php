<?php

if (!isset($_POST['aujourdhui'])) {

  $_SESSION['date']=date("Y-m-d");      

}else{

  $_SESSION['date']=$_POST['aujourdhui'];

}

$DATEA = new DateTime( $_SESSION['date'] );
$datea = $DATEA->format('Y');
$datem = $DATEA->format('m');
$datej = $DATEA->format('d');    
$datenormale=$datej.'/'.$datem.'/'.$datea;

$_SESSION['datenormale']=$datenormale; ?>

<form id='aujourdhui' method="POST" action="inventaire.php">      

  <?php
  $tot_enc=0;
  $products =$DB->query('SELECT SUM(Total) AS tot, SUM(remise) AS rem, mode_payement FROM payement WHERE DAY(date_cmd)= :jour And MONTH(date_cmd) = :mois AND YEAR(date_cmd) = :annee', array(
    'jour' => $datej,
    'mois' => $datem,
    'annee' => $datea
  ));     

  foreach ($products as $product ):

    $tot_enc+=($product->tot-$product->rem);
    $_SESSION['tot_enc']=$tot_enc; ?>

  <?php endforeach ?><?php

  $tot_v = 0;    
  $tot_a = 0;
  $Benefice=0;
  $products =$DB->query('SELECT prix_vente, prix_achat, quantity, date_cmd FROM commande inner join payement on payement.num_cmd=commande.num_cmd WHERE DAY(date_cmd)= :jour And MONTH(date_cmd) = :mois AND YEAR(date_cmd) = :annee', array(
          'jour' => $datej,
          'mois' => $datem,
          'annee' => $datea,
        ));

  foreach ($products as $product):

    $prix_v=($product->prix_vente* $product->quantity);
    $prix_a=($product->prix_achat* $product->quantity);
    $tot_v+=$prix_v;
    $tot_a+=$prix_a;
    $Benefice=$tot_v- $tot_a;
    $_SESSION['benefice']=$Benefice; ?>

  <?php endforeach ?>

  <?php 
  $products =$DB->querys('SELECT Count(num_cmd)FROM payement WHERE DAY(date_cmd)= :jour And MONTH(date_cmd) = :mois AND YEAR(date_cmd) = :annee', array(
          'jour' => $datej,
          'mois' => $datem,
          'annee' => $datea,
        ));

  $nbre_cmd=$products['Count(num_cmd)'];
  $_SESSION['nbre_cmd']=$nbre_cmd;
  $heure=date("H:i");
  $date=date("d-m-y"); 

  $dateaa=substr($_SESSION['date'], 2, 2);
  $datenormaleaa=$dateaa.'-'.$datem.'-'.$datej;


  if ($datenormaleaa==date("y-m-d")) {?>            
      
    <table style="margin-top: 10px;" class="compta_tab">

      <thead>

        <tr>
          <th>Selectionnez le jour</th>                    
          <th class="commande">Nombre de Ventes</th>
          <th>Entrer le montant de la caisse</th>
          <th style="background-color: red">Différence</th>
        </tr>

      </thead>

      <tbody>

        <tr>

          <td><input type="date" onchange="document.getElementById('aujourdhui').submit()" name="aujourdhui" value="<?= $_SESSION['date']; ?>" ></td> 

          <td><?php echo $nbre_cmd ?></td>

          <?php
          if (isset($_POST["compta_gnf"]) AND isset($_SESSION['caisse'])) {

            $_SESSION['compta_gnf']=$_POST["compta_gnf"];
            $_SESSION['difference']=$_POST["compta_gnf"]-$_SESSION['caisse'];

            if($_POST["compta_gnf"]!=''){?>

              <td style="font-weight: bold; font-size: 14"><input type="text" onchange="document.getElementById('aujourdhui').submit()" name="compta_gnf" value="<?=number_format($_POST["compta_gnf"],0,',',' '); ?>"> </td>

              <td style="color: red"><?=number_format($_POST["compta_gnf"]-$_SESSION['caisse'],0,',',' '); ?></td><?php

            }else{?>

              <td style="font-weight: bold; font-size: 14"><input type="number" onchange="document.getElementById('aujourdhui').submit()" name="compta_gnf" value=""> </td>

              <td style="color: red"></td><?php

            }
          }else{?>

            <td style="font-weight: bold; font-size: 14"><input type="number" onchange="document.getElementById('aujourdhui').submit()" name="compta_gnf"> </td>


            <td style="color: red"></td><?php

          }?>

        </tr>

      </tbody>

    </table> <?php

  }else{

      $products =$DB->query('SELECT tot_saisie, difference FROM cloture WHERE DAY(date_cloture)= :jour And MONTH(date_cloture) = :mois AND YEAR(date_cloture) = :annee', array(
        'jour' => $datej,
        'mois' => $datem,
        'annee' => $datea,
      ));

      foreach ($products as $cloture ):?>

      <?php endforeach ?>

      <table style="margin-top: 10px; width: 30%;" class="compta_tab"><?php

      if (empty($cloture)) {//Pour afficher les journées non comptabilisées?>

        <thead>

          <tr>
            <th>SELCTIONNEZ LE JOUR</th>
          </tr>

        </thead>

        <tbody>

          <tr>

            <td><input type="date" onchange="document.getElementById('aujourdhui').submit()" name="aujourdhui" value="<?= $_SESSION['date']; ?>" ></td>
          </tr>

        </tbody><?php

      }else{?>

        <thead>
          <tr>
            <th>Selectionnez le jour</th>                    
            <th class="commande">Nombre de Ventes</th>
            <th>Entrer le montant de la caisse</th>
            <th style="background-color: red">Différence</th>
          </tr>
        </thead>

        <tbody>

          <tr>

            <td><input type="date" onchange="document.getElementById('aujourdhui').submit()" name="aujourdhui" value="<?= $_SESSION['date']; ?>" ></td>

            <td><?=$nbre_cmd ?></td>

            <td style="font-weight: bold; font-size: 14"><?=number_format($cloture->tot_saisie,0,',',' '); ?></td>

            <td style="color: red"><?=number_format($cloture->difference,0,',',' ');?></td>

          </tr>
        </tbody><?php

      }?>

    </table><?php

  }?>
</form>

<div id="bilan">

  <div class="bloc_bilan">
          
    <table class="payement">

      <thead>

        <tr>
          <th class="legende" colspan="2" height="30" style="font-size: 18"><?="Bilan du " .$datenormale ?></th> 
        </tr>

        <tr>
          <th>Désignation</th>
          <th>Montant</th>
        </tr>

      </thead>

      <tbody><?php 

      $mode_payement = array(

        "Espece" => "especes",
        "Cheque" => "cheque",
        "Virement bancaire" => "vire bancaire",
        "Vers bancaire" => "versement"        
      );

      $tot_enc=0;
      foreach ($mode_payement as $produc ){

        $product =$DB->querys('SELECT SUM(Total) AS TOT, SUM(remise) AS REM, mode_payement FROM payement WHERE DAY(date_cmd)= :jour And MONTH(date_cmd) = :mois AND YEAR(date_cmd) = :annee  AND mode_payement= :payement', array(
          'jour' => $datej,
          'mois' => $datem,
          'annee' => $datea,                      
          'payement'=>$produc
        ));     

        if (empty($product['mode_payement'])) {

        }else{

          $tot_enc+=($product['TOT']-$product['REM']); ?>

          <tr >                
            <td ><?=ucwords($product['mode_payement']."s encaissés");?></td>              
            <td style="text-align: right" ><?=number_format(($product['TOT']-$product['REM']),0,',',' ');?></td>
          </tr><?php

        }
      }?>

      <tr>
        <td>Chiffre d'affaires</td>
        <td style="text-align:right;"><?=number_format($tot_enc,0,',',' ');?></td>
      </tr>

      <?php
      $total_cours=0;
      $totalpaye=0;
      $remise=0;
      $credclient_gnf=0;            
      $reste_payer=$DB->querys('SELECT SUM(Total) AS totc, SUM(montantpaye) AS montc, SUM(reste) as reste, mode_payement, SUM(remise) AS remc FROM payement WHERE DAY(date_cmd)= :jour And MONTH(date_cmd) = :mois AND YEAR(date_cmd) = :annee  AND etat= :Etat ', array(
        'jour' => $datej,
        'mois' => $datem,
        'annee' => $datea,
        'Etat' =>'credit'
      ));

            

      $total_cours=$reste_payer['totc'];
      $totalpaye=$reste_payer['montc'];
      $remise= $reste_payer['remc'];
      $credclient_gnf= $reste_payer['reste']; ?>

        
      <tr>

        <td>Crédits Clients</td>
        <td style="text-align:right;"><?=number_format(($credclient_gnf),0,',',' ');?></td>
      </tr><?php

        $versementgnf=0;            

        $versement=$DB->querys('SELECT SUM(montant) AS sommeverse, date_versement FROM versement WHERE DAY(date_versement)= :jour And MONTH(date_versement) = :mois AND YEAR(date_versement) = :annee', array('jour' => $datej, 'mois' => $datem, 'annee' => $datea));

        $versementgnf = $versement['sommeverse'];?>              

        <tr>
          <td>Total Versement</td>
          <td style="text-align:right;"><?=number_format(($versementgnf),0,',',' ');?></td>
        </tr>

        <tr>
          <td>Total Net Encaissé</td>
          <td style="text-align:right;"><?=number_format(($tot_enc-$credclient_gnf+$versementgnf),0,',',' ');?></td>
        </tr><?php

                    
        $totremb_client=0;
        $rembourse_client=$DB->querys('SELECT SUM(montant) AS montr FROM historique WHERE DAY(date_regul)= :jour And MONTH(date_regul) = :mois AND YEAR(date_regul) = :annee  AND remboursement= :Remb ', array(
          'jour' => $datej,
          'mois' => $datem,
          'annee' => $datea,
          'Remb' =>'client'
        ));

        $totremb_client=$rembourse_client['montr'];

        if ($totremb_client==0) {

        }else{?>

          <tr>        
            <td>Remboursements Clients</td>
            <td style="text-align:right"><?=number_format(($totremb_client),0,',',' ');?></td>
          </tr><?php
        }?>

        <tr>
          <td style="text-align: center; background-color: yellow; color: red;" colspan="2">PARTIE DECAISSEMENT</td>
        </tr><?php            

        $montdec_gnf=0;
        $montant_eu=0;
        $montant_us=0;

        $mode_payement = array(

          "Espèces" => "especes",
          "Versement" => "versement",
          "Chèque" => "cheque",
          "Virement Bancaire" => "vire bancaire"        
        );

        foreach ($mode_payement as $key=> $produc ){

          $gnfdec =$DB->querys('SELECT SUM(montant) AS montg, payement FROM decaissement WHERE DAY(date_payement)= :jour And MONTH(date_payement) = :mois AND YEAR(date_payement) = :annee AND payement= :payement', array(
            'jour' => $datej,
            'mois' => $datem,
            'annee' => $datea,
            'payement'=>$produc
          ));

          $decfraisup=$DB->querys('SELECT SUM(montant) AS montant FROM fraisup WHERE DAY(date_payement)= :jour And MONTH(date_payement) = :mois AND YEAR(date_payement) = :annee  AND payement= :payement', array(
            'jour' => $datej,
            'mois' => $datem,
            'annee' => $datea,
            'payement'=>$produc
          ));

          $decfraismarch=$DB->querys('SELECT SUM(montantpaye+frais) AS montant FROM facture WHERE DAY(datecmd)= :jour And MONTH(datecmd) = :mois AND YEAR(datecmd) = :annee  AND payement= :payement', array(
            'jour' => $datej,
            'mois' => $datem,
            'annee' => $datea,
            'payement'=>$produc
          ));

          $montdec_gnf+=$gnfdec['montg']+$decfraisup['montant']+$decfraismarch['montant']; ?>

          <tr>               
            <td ><?=ucwords($key);?></td>              
            <td style="text-align: right"  ><?=number_format($gnfdec['montg']+$decfraisup['montant']+$decfraismarch['montant'],0,',',' ');?></td>
          </tr> <?php 
        }?>

      <tr>
        <td>Total Décaissement</td>

        <td style="text-align:right;"><?=number_format($montdec_gnf,0,',',' ');?></td>

      </tr><?php


      $credit_gnf=0;                
      $products =$DB->query('SELECT prix_reel, montant FROM decaissement WHERE DAY(date_payement)= :jour And MONTH(date_payement) = :mois AND YEAR(date_payement) = :annee  AND etat= :Etat',array(
          'jour' => $datej,
          'mois' => $datem,
          'annee' => $datea,
          'Etat' =>'credit'
        ));     

      foreach ($products as $product ){

        $credit_gnf+=(($product->prix_reel)-($product->montant)); 
      }

      $creditfact=0;                
      $creditfact=$DB->querys('SELECT (montantht+montantva-montantpaye) as montant FROM facture WHERE DAY(datecmd)= :jour And MONTH(datecmd) = :mois AND YEAR(datecmd) = :annee',array(
          'jour' => $datej,
          'mois' => $datem,
          'annee' => $datea
        ));

      $creditfact=$creditfact['montant'];?>

      <tr> 
        <td>Crédits Magasin</td>
        <td style="text-align:right"><?=number_format(($credit_gnf+$creditfact),0,',',' ');?></td>
      </tr><?php

      $totremb_mag=0;            
      $rembourse_client =$DB->querys('SELECT SUM(montant) AS month FROM historique WHERE DAY(date_regul)= :jour And MONTH(date_regul) = :mois AND YEAR(date_regul) = :annee  AND remboursement= :Remb ', array(
        'jour' => $datej,
        'mois' => $datem,
        'annee' => $datea,
        'Remb' =>'magasin'
      ));

        $totremb_mag=$rembourse_client['month'];

      if ($totremb_mag==0) {

      }else{?>

        <tr>
          <td>Remboursements Magasin</td>
          <td style="text-align:right"><?=number_format(($totremb_mag),0,',',' ');?></td>
        </tr><?php

      }

             //Calcul caisse journaliere
      $_SESSION['tot_encjour']=$tot_enc;
      $_SESSION['caissejourn_gnf']=$tot_enc-$credclient_gnf-$montdec_gnf;
      $caissejourn_gnf=$_SESSION['caissejourn_gnf'];

//*****************Cumul encaissement***********************************
      $now = date('Y-m-d');
      $now = new DateTime( $now );
      $now = $now->format('Ymd');
      $totenc=0;
      $prodenc =$DB->querys('SELECT SUM(Total) AS totp, SUM(remise) AS remp, mode_payement FROM payement WHERE DATE_FORMAT(date_cmd, \'%Y%m%d\')<= :NOW ', array(
        'NOW' => $now
      ));

      $totenc=($prodenc['totp']-$prodenc['remp']);


       //***********************Cumul credit**************************

      $total_cours=0;
      $total_avance=0;
      $remise=0;           
      $reste_payer =$DB->querys('SELECT SUM(Total) AS totpc, SUM(remise) AS rempc, SUM(montantpaye) AS montpc, SUM(reste) AS respc, mode_payement FROM payement WHERE DATE_FORMAT(date_cmd, \'%Y%m%d\')<= :NOW AND etat= :Etat ', array(
        'NOW' => $now,
        'Etat'=>'credit'
      )); 

      $credclient_gnf = $reste_payer['respc']; 

        //Cumul decaissement en gnf
      $montdec_gnf=0;
      $gnf =$DB->querys('SELECT SUM(montant) AS montdg FROM decaissement WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')<= :NOW', array('NOW' => $now));

      $frais =$DB->querys('SELECT SUM(frais+montantpaye) AS montf FROM facture WHERE DATE_FORMAT(datecmd, \'%Y%m%d\')<= :NOW', array('NOW' => $now));

      $fraisup =$DB->querys('SELECT SUM(montant) AS montfsup FROM fraisup WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')<= :NOW', array('NOW' => $now));   

      $montdec_gnf=$gnf['montdg']+$frais['montf']+$fraisup['montfsup'];



      $cloture=$DB->querys('SELECT tot_caisse, tot_saisie FROM cloture WHERE DAY(date_cloture)= :jour And MONTH(date_cloture) = :mois AND YEAR(date_cloture) = :annee', array(
        'jour' => $datej,
        'mois' => $datem,
        'annee' => $datea,
      ));

      if (!empty($cloture)) {

        $caisse=$cloture['tot_saisie'];
        $_SESSION['caisse']=$caisse;

      }else{

        $caisse=($totenc-$credclient_gnf+$panier->versementgnf()-$montdec_gnf)+ ($panier->manque());
        $_SESSION['caisse']=$caisse;

      }?>

      <tr>
        <td style="font-weight: bold; font-size: 14; background-color: green;color: white;">Total Disponible en Caisse</td>
        <td style="font-weight: bold; font-size: 14;text-align:right; background-color: green; color: white;"><?=number_format($caisse,0,',',' ');?></td>
      </tr>

    </tbody>
  </table>



</div>
</div>


<div id="bilaninv" style="display: flex; flex-wrap: wrap;">

  <div class="bloc_prodinv" style="width: 30%;">

    <table class="payement">

      <thead>

        <tr>
          <th class="legende" colspan="2" height="30"><?="Produits Vendus le " .$datenormale ?></th>
        </tr>

        <tr>
          <th style="width: 90%;">Désignation</th>
          <th>Qtité</th>
        </tr>

      </thead>

      <tbody>
        <?php 
        $total=0;
        $products =$DB->query('SELECT id, designation FROM products order by(quantite) desc');

        foreach ($products as $produc ){

          $products =$DB->query('SELECT SUM(quantity) AS qtite FROM commande inner join payement on payement.num_cmd=commande.num_cmd WHERE DAY(date_cmd)= :jour And MONTH(date_cmd) = :mois AND YEAR(date_cmd) = :annee AND commande.id_produit= :desig', array(
            'jour' => $datej,
            'mois' => $datem,
            'annee' => $datea,
            'desig'=>$produc->id
          ));     

          foreach ($products as $product ){

            $total+= $product->qtite;

            if (!empty($product->qtite)) {?>

              <tr>
                <td style="text-align: left;"><?= $produc->designation; ?></td>
                <td style="text-align: right;"><?= $product->qtite; ?></td>
              </tr><?php

            }else{

            }
          }
        }?>

        <tr>          
          <th colspan="1" height="40">TOTAL</th>
          <th style="text-align: right; padding-right:20px"><?= $total; ?></th>          
        </tr>

      </tbody>

    </table>

  </div>

  <div style="margin-right: 30px">

    <table class="payement">

      <thead>

        <tr>
          <th class="legende" colspan="4" height="30"><?="Liste des frais supplementaire du " .$datenormale ?></th>
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
        $products=$DB->query('SELECT nom_client as client, montant, DATE_FORMAT(date_payement, \'%d/%m/%Y \')AS DateTemps FROM fraisup inner join client on fraisup.client=client.id WHERE DAY(date_payement)= :jour And MONTH(date_payement) = :mois AND YEAR(date_payement) = :annee ORDER BY(fraisup.id)DESC', array(
          'jour' => $datej,
          'mois' => $datem,
          'annee' => $datea
        ));

        foreach ($products as $product ){
          $totaldepenses+=$product->montant;?>
          <td><?= ucwords($product->client); ?></td> 
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

    </table>

  </div>

  <div style="margin-right: 30px">

    <table class="payement">

      <thead>

        <tr>
          <th class="legende" colspan="4" height="30"><?="Liste des frais marchandises du " .$datenormale ?></th>
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
        $products=$DB->query('SELECT nom_client as client, frais, DATE_FORMAT(datecmd, \'%d/%m/%Y \')AS DateTemps FROM facture inner join client on fournisseur=client.id WHERE DAY(datecmd)= :jour And MONTH(datecmd) = :mois AND YEAR(datecmd) = :annee ORDER BY(facture.id)DESC', array(
          'jour' => $datej,
          'mois' => $datem,
          'annee' => $datea
        ));

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

    </table>

  </div>

        <div style="margin-right: 30px">

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
              $products=$DB->query('SELECT montant, nom_client as client, coment, DATE_FORMAT(date_payement, \'%d/%m/%Y \')AS DateTemps FROM decaissement inner join client on client.id=client WHERE motif=:MOTIF AND DAY(date_payement)= :jour And MONTH(date_payement) = :mois AND YEAR(date_payement) = :annee ORDER BY(decaissement.id)DESC', array(
                'MOTIF' => "depenses",
                'jour' => $datej,
                'mois' => $datem,
                'annee' => $datea
              ));

            foreach ($products as $product ):?>                   
                <td><?= $product->DateTemps; ?></td>                       
                <td><?= strtolower($product->coment); ?></td>
                <td style="text-align: right; padding-right: 15px"><?= number_format($product->montant,0,',',' '); ?></td>          
                
              </tr>

            <?php endforeach ?>


          </tbody>

          <tfoot>

            <tr>
              <th colspan="2">TOTAL</th>
              <th style="text-align: right;padding-right: 15px"><?= number_format($panier->totdepense(),0,',',' ') ; ?></th>
            </tr>

          </tfoot>

        </table>
        
      </div>
    </div>


<div class="bilan_dec">

  <div class="dec"><?php

    $products =$DB->query('SELECT decaissement.id as id, montant, motif, nom_client as client, DATE_FORMAT(date_payement, \'%H:%i:%s\')AS DateTemps FROM decaissement inner join client on client=client.id  WHERE DAY(date_payement)= :jour And MONTH(date_payement) = :mois AND YEAR(date_payement) = :annee', array(
      'jour' => $datej,
      'mois' => $datem,
      'annee' => $datea
    ));

    if (!empty($products)) {?>
     
      <table  class="payement" style="width: 60%;">

        <thead>

          <tr>
            <th class="legende" colspan="5" height="30"><?="Liste des Décaissements du " .$datenormale ?></th>
          </tr>

          <tr>
            <th>N°</th>
            <th>Montant</th>
            <th>Motif</th>
            <th>Nom</th>
            <th>Heure</th>
          </tr>

        </thead>

        <tbody><?php
          $cumulmontant=0;
          foreach ($products as $product ): 

            $cumulmontant+=$product->montant;?>

            <tr>
              <td style="text-align: center;"><?= $product->id; ?></td>
              <td style="text-align: right; padding-right: 20px;"><?= number_format($product->montant,0,',',' '); ?></td>
              <td><?= ucwords($product->motif); ?></td>
              <td><?= $product->client; ?></td>
              <td><?= $product->DateTemps; ?></td>
            </tr>

          <?php endforeach ?>

        </tbody>

        <tfoot>
          <tr>
            <th></th>
            <th style="text-align: right; padding-right: 20px;"><?= number_format($cumulmontant,0,',',' ');?></th>
          </tr>
        </tfoot>

      </table><?php
    }?>

  </div>

  <div class="cred"><?php

    $credit_mag=0;
    $cumulmontant=0;
    $Etat="credit";              
    $products =$DB->query('SELECT decaissement.id as id, prix_reel, montant, motif, nom_client as client, DATE_FORMAT(date_payement, \'%H:%i:%s\')AS DateTemps FROM decaissement inner join client on client=client.id  WHERE etat=:Etat AND DAY(date_payement)= :jour And MONTH(date_payement) = :mois AND YEAR(date_payement) = :annee', array(
      'Etat' => $Etat,
      'jour' => $datej,
      'mois' => $datem,
      'annee' => $datea
    )); 

    if (!empty($products)) {?>

      <table class="payement" style="width: 60%;">

        <thead>

          <tr>
            <th class="legende" colspan="4" height="30" ><?="Crédits Magasin du ".$datenormale ?></th>
          </tr>
          <tr>
            <th>Nom</th>
            <th>Heure</th>            
            <th>Montant</th>
            <th>Reste</th>
          </tr>

        </thead>

        <tbody>                

          <?php foreach ($products as $product){

            $credit_mag+=(($product->prix_reel)-($product->montant));

            $cumulmontant+=$product->montant; ?>

            <tr>
              <td><?= $product->client; ?></td>
              <td style="text-align: center"><?= $product->DateTemps; ?></td>             
              <td style="text-align: right"><?= number_format($product->montant,0,',',' ') ; ?></td>
              <td style="color: red;text-align:right;"><?= number_format((($product->prix_reel)-($product->montant)),0,',',' '); ?></td>
            </tr><?php 
          }?>

        </tbody>

      
        <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontant,0,',',' ');?></th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($credit_mag,0,',',' ');?></th>
          </tr>
        </tfoot>
      </table><?php
    }?>

  </div><?php

    $Etat="credit";
    $products =$DB->query('SELECT num_cmd, nom_client as clientvip, client, typeclient, Total, remise, montantpaye, reste, DATE_FORMAT(date_cmd, \'%H:%i:%s\')AS DateTemps FROM payement left join client on num_client=client.id WHERE etat=:Etat AND DAY(date_cmd)= :jour And MONTH(date_cmd) = :mois AND YEAR(date_cmd) = :annee', array(
      'Etat' => $Etat,
      'jour' => $datej,
      'mois' => $datem,
      'annee' => $datea
    ));

    if (!empty($products)) {?>

      <table class="payement">

        <thead>

          <tr>
            <th class="legende" colspan="7" height="30"><?="Crédits Clients du ".$datenormale ?></th>
          </tr>
          <tr>
            <th>N°</th>
            <th>Contact Client</th>
            <th>Heure</th>
            <th>Total</th>
            <th>Remise</th>            
            <th>Montant Payé</th>
            <th>Reste à Payer</th>
          </tr>

        </thead>

        <tbody><?php

          $cumulmontantot=0;
          $cumulmontantrem=0;
          $cumulmontantpaye=0;
          $cumulmontantres=0;
          foreach ($products as $product){
            if ($product->typeclient=='VIP') {
              $client=$product->clientvip;
            }else{
              $client=$product->client;
            }

            $cumulmontantot+=$product->Total;
            $cumulmontantrem+=$product->remise;
            $cumulmontantpaye+=$product->montantpaye;
            $cumulmontantres+=$product->reste;?>

            <tr>
              <td><?= $product->num_cmd; ?></td>
              <td><?= $client; ?></td>
              <td style="text-align: center"><?= $product->DateTemps; ?></td>

              <td style="text-align:right"><?= number_format($product->Total,0,',',' ') ; ?></td>
              <td style="text-align:right"><?= number_format($product->remise,0,',',' ') ; ?></td>
              <td style="text-align:right"><?= number_format($product->montantpaye,0,',',' '); ?></td>
              
              <td style="color: red;text-align:right"><?= number_format(($product->reste),0,',',' '); ?></td>
            </tr><?php 
          }?>

        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontantot,0,',',' ');?></th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontantrem,0,',',' ');?></th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontantpaye,0,',',' ');?></th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontantres,0,',',' ');?></th>
          </tr>
        </tfoot>

      </table><?php
    }?>

    <table style="margin-top: 30px;" class="payement">

      <thead>
        <tr>
          <th class="legende" colspan="7" height="30"><?="Détails des Produits Vendus le " .$datenormale ?></th>
        </tr>

        <tr>

          <th>Désignation</th>
          <th>Qtité</th>
          <th>Montant</th>
          <th>Payement</th>
          <th>Heure</th>
          <th>Etat</th>
          <th>Contact du Client</th>
        </tr>
      </thead>

      <tbody>

        <?php  
        $products =$DB->query('SELECT designation, quantity, commande.prix_vente as prix_vente, mode_payement, etat, typeclient, nom_client as clientvip, client, DATE_FORMAT(date_cmd, \'%H:%i:%s\')AS DateTemps FROM products inner join commande on commande.id_produit=products.id inner join payement on payement.num_cmd=commande.num_cmd left join client on client.id=id_client WHERE DAY(date_cmd)= :jour And MONTH(date_cmd) = :mois AND YEAR(date_cmd) = :annee', array(
          'jour' => $datej,
          'mois' => $datem,
          'annee' => $datea
        ));
        $cumulmontantotc=0;
        foreach ($products as $product ){

          if ($product->typeclient=='VIP') {
            $client=$product->clientvip;
          }else{
            $client=$product->client;
          }

          $cumulmontantotc+=$product->prix_vente*$product->quantity; ?>

          <tr>
            <td><?= $product->designation; ?></td>
            <td style="text-align:center"><?= $product->quantity; ?></td>
            <td style="text-align: right"  ><?= number_format($product->prix_vente*$product->quantity,0,',',' '); ?></td>
            <td><?= $product->mode_payement; ?></td>
            <td><?= $product->DateTemps; ?></td>
            <td><?= $product->etat; ?></td>
            <td><?= $client; ?></td>
          </tr><?php 
        }?>

      </tbody>

      <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontantotc,0,',',' ');?></th>
          </tr>
        </tfoot>

    </table>

    <table style="margin-top: 30px;" class="payement">
      <thead>
        <tr>
          <th class="legende" colspan="11" height="30"><?="Détail des Commandes du " .$datenormale ?></th>
        </tr>

        <tr>
          <th>N°</th>
          <th>Heure</th>
          <th>Etat</th>
          <th>Payement</th>
          <th>Remise</th>
          <th>Total</th>
          <th>Montant</th>
          <th>Contact du Client</th>
          <th colspan="2"></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $products =$DB->query('SELECT num_cmd, remise, montantpaye, Total, mode_payement, etat, typeclient, nom_client as clientvip, client, DATE_FORMAT(date_cmd, \'%H:%i:%s\')AS DateTemps FROM payement left join client on client.id=num_client WHERE DAY(date_cmd)= :jour And MONTH(date_cmd) = :mois AND YEAR(date_cmd) = :annee', array(
          'jour' => $datej,
          'mois' => $datem,
          'annee' => $datea
        ));
        $cumulmontanremp=0;
        $cumulmontantotp=0;
        $cumulmontanrestp=0;

        foreach ($products as $product ){
          if ($product->typeclient=='VIP') {
            $client=$product->clientvip;
          }else{
            $client=$product->client;
          }
          $cumulmontanremp+=$product->remise;
          $cumulmontantotp+=$product->Total-$product->remise;
          $cumulmontanrestp+=$product->montantpaye; ?>

          <tr>
            <td><?= $product->num_cmd; ?></td>
            <td><?= $product->DateTemps; ?></td>
            <td><?= $product->etat; ?></td>
            <td><?= $product->mode_payement; ?></td>
            <td style="text-align:right"><?= number_format($product->remise,0,',',' '); ?></td>
            <td style="text-align: right"><?= number_format(($product->Total-$product->remise),2,',',' '); ?></td>
            <td style="text-align:right"><?= number_format($product->montantpaye,2,',',' '); ?> </td>

            <td><?= $client; ?></td>

            <td><a href="modifvente.php?num_cmd=<?=$product->num_cmd;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: orange;color: white;"  type="submit" value="Modifier" onclick="return alerteM();"></a></td>

            <td><a href="inventaire.php?num_cmd=<?=$product->num_cmd;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white;"  type="submit" value="Supprimer" onclick="return alerteS();"></a></td>
          </tr><?php 
        } ?>   
      </tbody>

      <tfoot>
        <tr>
          <th colspan="4"></th>
          <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontanremp,0,',',' ');?></th>
          <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontantotp,0,',',' ');?></th>
          <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontanrestp,0,',',' ');?></th>
        </tr>
      </tfoot>
    </table>
  
 

