<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];


  if ($products['level']>=3) {

    require 'delete.php'; 

    require 'headercompta.php';

    if (isset($_GET['journaliere']) or isset($_POST['aujourdhui']) or isset($_GET['deletep']) or isset($_GET['actual']) or isset($_GET['num_cmd'])) {

      require 'comptabilite.php'
      ;
    }else{

      if (!isset($_POST['annee'])) {

        $_SESSION['date']=date("Y");
        
      }else{

        $_SESSION['date']=$_POST['annee'];
        
      }

      $datenormale=$_SESSION['date'];

      if (isset($_POST['liquide'])) {

        $_SESSION['liquide']=$_POST['liquide'];

        $liquide=$_SESSION['liquide'];

      }elseif(isset($_POST['chiffrea'])){

        $liquide=$_SESSION['liquide'];

      
      }else{

        $liquide=0;

      }

      $tot_achat=0;
      $tot_vente=0;
      $stock = $DB->query('SELECT * FROM products ');

      foreach ($stock as $product){

        $tot_achat+=$product->prix_achat*$product->quantite;
        $tot_vente+=$product->prix_vente*$product->quantite;

      }?>

      <form id='naissance' method="POST" action="inventaire.php"> 

        <ol>
          <li><label></label>

            <?='<select id="reccode" style="width: 250px; font-size: 14px;"  type="number" name="annee" required="" onchange="this.form.submit();">',"n";
              if (isset($_POST['annee'])) {?>
                <option value=""><?="Année ".$_POST['annee'];?></option><?php

              }else{

                echo "\t",'<option value="">Choisir une année...</option>',"\n";

              }

            $annee=date("Y");

            for($i=2018;$i<=$annee ;$i++){

              echo "\t",'<option value="', $i,'">', $i,'</option>',"\n";

            }?></select>
            
          </li>
        </ol>
      </form>

      <div id="bilaninv">

        <div class="bloc_prodinv">

          <table class="payement">

            <thead>

              <tr>
                <th class="legende" colspan="2" height="30"><?="Produits Vendus en " .$_SESSION['date'] ?></th>
              </tr>

              <tr>
                <th style="width: 10%;">Qtite</th>
                <th>Designation</th>
              </tr>

            </thead>

            <tbody>
              <?php 
              $quantite=0;
              $totpv=0;

              foreach ($stock as $produc ): 

                $products = $DB->query('SELECT SUM(quantity) AS quantite, SUM(prix_vente) AS pv, designation FROM commande inner join products on products.id=commande.id_produit inner join payement on payement.num_cmd=commande.num_cmd WHERE YEAR(date_cmd) = :annee AND designation= :desig', array(
                  'annee' => $_SESSION['date'],
                  'desig'=>$produc->designation));     

                foreach ($products as $product ):

                  $quantite+= $product->quantite;
                  $totpv+= $product->pv;

                  if (!empty($product->designation)) {?>

                    <tr>
                      <td style="text-align: center;"><?= $product->quantite; ?></td>
                      <td style="text-align: left;"><?= ucwords(strtolower($product->designation)); ?></td>
                    </tr><?php

                  }else{

                  }?>                      
                <?php endforeach ?>
              <?php endforeach ?>

              <tr> 
                <th style="text-align: right; padding-right:20px"><?= $quantite; ?></th>        
                <th colspan="1" height="40"></th>          
              </tr>

            </tbody>

          </table>

        </div>

        <div style="margin-right: 30px">

          <table class="payement">

            <thead>

              <tr>
                <th class="legende" colspan="3" height="30"><?="Liste des frais " .$_SESSION['date'] ?></th>
              </tr>

              <tr>                      
                <th>Date</th>
                <th>Motif</th>
                <th>Montant</th>
              </tr>

            </thead>

            <tbody><?php 
              $totaldepenses=0;
              $products=$DB->query('SELECT montant, nom_client as client, coment, motif, DATE_FORMAT(date_payement, \'%d/%m/%Y \')AS DateTemps FROM decaissement inner join client on client.id=client WHERE motif=:MOTIF AND YEAR(date_payement) = :annee  ORDER BY(decaissement.id)DESC', array(
                'MOTIF' => "frais marchandises",
                'annee' => $_SESSION['date']
              ));

              foreach ($products as $product ):?>                   
                  <td><?= $product->DateTemps; ?></td>                       
                  <td><?= ucfirst($product->motif); ?></td>
                  <td style="text-align: right; padding-right: 15px"><?= number_format($product->montant,0,',',' '); ?></td>          
                  
                </tr>

              <?php endforeach ?>


            </tbody>

            <thead>

              <tr>
                <th colspan="2">TOTAL</th>
                <th style="text-align: right;padding-right: 15px"><?= number_format($panier->totdepense(),0,',',' ') ; ?></th>
              </tr>

            </thead>

          </table>

        </div>

        <div style="margin-right: 30px">

          <table class="payement">

            <thead>

              <tr>
                <th class="legende" colspan="3" height="30"><?="Liste des depenses en " .$_SESSION['date'] ?></th>
              </tr>

              <tr>                      
                <th>Date</th>
                <th>Motif</th>
                <th>Montant</th>
              </tr>

            </thead>

            <tbody><?php 
              $totaldepenses=0;
              $products=$DB->query('SELECT montant, coment, DATE_FORMAT(date_payement, \'%d/%m/%Y \')AS DateTemps FROM decaissement WHERE motif=:MOTIF AND YEAR(date_payement) = :annee ORDER BY(id)DESC', array(
                'MOTIF' => "depenses",
                'annee' => $_SESSION['date']
              ));

              foreach ($products as $product ):?>                   
                  <td><?= $product->DateTemps; ?></td>                       
                  <td><?= ucfirst(strtolower($product->coment)); ?></td>
                  <td style="text-align: right; padding-right: 15px"><?= number_format($product->montant,2,',',' '); ?></td>          
                  
                </tr>

              <?php endforeach ?>


            </tbody>

            <thead>

              <tr>
                <th colspan="2">TOTAL</th>
                <th style="text-align: right;padding-right: 15px"><?= number_format($panier->totdepense(),2,',',' ') ; ?> </th>
              </tr>

            </thead>

          </table>
        </div>
      </div>

        <div class="bilan_dec">

        <div class="dec"><?php

          $products =$DB->query('SELECT decaissement.id as id, montant, motif, nom_client as client, DATE_FORMAT(date_payement, \'%H:%i:%s\')AS DateTemps FROM decaissement inner join client on client.id=client  WHERE DATE_FORMAT(date_payement, \'%Y\') = :annee and montant>:montant', array('annee' => $_SESSION['date'], 'montant'=>0));

          if (!empty($products)) {?>
           
            <table  class="payement" style="width: 60%;">

              <thead>

                <tr>
                  <th class="legende" colspan="5" height="30"><?="Liste des Décaissements en " .$datenormale ?></th>
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
                foreach ($products as $product ){
                  $cumulmontant+=$product->montant;?>

                  <tr>
                    <td style="text-align: center;"><?= $product->id; ?></td>
                    <td style="text-align: right; padding-right: 20px;"><?= number_format($product->montant,0,',',' '); ?></td>
                    <td><?= ucwords($product->motif); ?></td>
                    <td><?= $product->client; ?></td>
                    <td><?= $product->DateTemps; ?></td>
                  </tr><?php 
                }?>

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
          $products =$DB->query('SELECT decaissement.id as id, prix_reel, montant, motif, nom_client as client, DATE_FORMAT(date_payement, \'%H:%i:%s\')AS DateTemps FROM decaissement inner join client on client.id=client WHERE etat=:Etat AND DATE_FORMAT(date_payement, \'%Y\') = :annee and montant>:montant',array(
            'Etat' => $Etat,
            'annee' => $_SESSION['date'],
            'montant'=>0
          )); 

          if (!empty($products)) {?>

            <table class="payement" style="width: 60%;">

              <thead>

                <tr>
                  <th class="legende" colspan="4" height="30" ><?="Crédits Magasin en ".$datenormale ?></th>
                </tr>
                <tr>
                  <th>Nom</th> 
                  <th>Heure</th>           
                  <th>Montant</th>
                  <th>Reste</th>
                </tr>

              </thead>

              <tbody>                

                <?php foreach ($products as $product): ?><?php

                  $credit_mag+=(($product->prix_reel)-($product->montant)); 
                  $cumulmontant+=$product->montant; ?>

                  <tr>
                    <td><?= $product->client; ?></td> 

                    <td style="text-align: center"><?= $product->DateTemps; ?></td>

                    <td style="text-align: right"><?= number_format($product->montant,0,',',' ') ; ?></td>
                    
                    <td style="color: red;text-align:right;"><?= number_format((($product->prix_reel)-($product->montant)),0,',',' '); ?></td>
                  </tr>

                <?php endforeach ?>

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
        $products =$DB->query('SELECT num_cmd, nom_client as client, Total, remise, montantpaye, reste, DATE_FORMAT(date_cmd, \'%H:%i:%s\')AS DateTemps FROM payement inner join client on client.id=num_client WHERE etat=:Etat AND DATE_FORMAT(date_cmd, \'%Y\') = :annee',array(
            'Etat' => $Etat,
            'annee' => $_SESSION['date']
          )); 

        if (!empty($products)) {?>

          <table class="payement">

            <thead>

              <tr>
                <th class="legende" colspan="7" height="30"><?="Liste Crédits Clients du ".$datenormale ?></th>
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

            foreach ($products as $product): 

              $cumulmontantot+=$product->Total;
              $cumulmontantrem+=$product->remise;
              $cumulmontantpaye+=$product->montantpaye;
              $cumulmontantres+=$product->reste;
             ?>
              <tr>
              <td><?= $product->num_cmd; ?></td>
              <td><?= $product->client; ?></td>
              <td style="text-align: center"><?= $product->DateTemps; ?></td>

              <td style="text-align:right"><?= number_format($product->Total,0,',',' ') ; ?></td>
              <td style="text-align:right"><?= number_format($product->remise,0,',',' ') ; ?></td>
              <td style="text-align:right"><?= number_format($product->montantpaye,0,',',' '); ?></td>
              
              <td style="color: red;text-align:right"><?= number_format(($product->reste),0,',',' '); ?></td>
            </tr>

            <?php endforeach ?>

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
            $products =$DB->query('SELECT designation, quantity, prix_vente, mode_payement, etat, nom_client as client, DATE_FORMAT(date_cmd, \'%H:%i:%s\')AS DateTemps FROM commande inner join client on client.id=id_client inner join products on products.id=commande.id_produit inner join payement on payement.num_cmd=commande.num_cmd WHERE DATE_FORMAT(date_cmd, \'%Y\') = :annee', array('annee' => $_SESSION['date']));

            $cumulmontantotc=0;
            foreach ($products as $product ){

              $cumulmontantotc+=$product->prix_vente*$product->quantity;?>

              <tr>
                <td><?= $product->designation; ?></td>
                <td style="text-align:center"><?= $product->quantity; ?></td>
                <td style="text-align: right"  ><?= number_format($product->prix_vente*$product->quantity,0,',',' '); ?></td>
                <td><?= $product->mode_payement; ?></td>
                <td><?= $product->DateTemps; ?></td>
                <td><?= $product->etat; ?></td>
                <td><?= $product->client; ?></td>
              </tr><?php 
            } ?>

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
              <th class="legende" colspan="10" height="30"><?="Détail des Commandes du " .$datenormale ?></th>
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
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $products =$DB->query('SELECT num_cmd, remise, montantpaye, Total, mode_payement, etat, nom_client as client, DATE_FORMAT(date_cmd, \'%H:%i:%s\')AS DateTemps FROM payement inner join client on client.id=num_client WHERE DATE_FORMAT(date_cmd, \'%Y\') = :annee', array('annee' => $_SESSION['date']));

            $cumulmontanremp=0;
            $cumulmontantotp=0;
            $cumulmontanrestp=0;
            foreach ($products as $product ){

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
                <td><?= $product->client; ?></td>

                <td><a href="inventaire.php?num_cmd=<?=$product->num_cmd;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white;"  type="submit" value="Supprimer" onclick="return alerteS();"></a></td>
                </td>
              </tr><?php 
            } ?>   
          </tbody>

          <tfoot>
            <tr>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontanremp,0,',',' ');?></th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontantotp,0,',',' ');?></th>
              <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontanrestp,0,',',' ');?></th>
            </tr>
          </tfoot>
        </table> 

      </div><?php

    }
  }else{

      echo "VOUS N'AVEZ PAS TOUTES LES AUTORISATIOS REQUISES";
    }

  }else{


  }?>
  
</body>
</html>


<script>
function suivant(enCours, suivant, limite){
  if (enCours.value.length >= limite)
  document.term[suivant].focus();
}

function focus(){
document.getElementById('reccode').focus();
}

function alerteS(){
  return(confirm('Confirmer la suppression?'));
}

function alerteM(){
  return(confirm('Confirmer la modification'));
}

function alerteF(){
  return(confirm('Confirmer la femeture de la caisse'));
}
</script>

