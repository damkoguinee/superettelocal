<?php
require 'header.php';?>

<style type="text/css">

.search{
  display: flex;
  flex-wrap: nowrap;
}
  .history{
    width: 50%;
    margin-top: 30px;
  }
 .ticket{
    margin-right: 10px;
    width: 95%;
  }

  table.border {
    width: 100%;
    color: #717375;
    font-family: helvetica;
    line-height: 10mm;
    border-collapse: collapse;
  }
  
  .border th {
    border: 1px solid black;
    padding: 0px;
    font-weight: bold;
    font-size: 14px;
    color: black;
    background: white;
    text-align: right;
    height: 30px; }
  .border td {
    line-height: 15mm;
    border: 1px solid black;    
    font-size: 14px;
    color: black;
    background: white;
    text-align: center;
    height: 18px;
  }
  .footer{
    font-size: 14px;
    font-style: italic;
  }
</style><?php 

require 'entetelivraisonachat.php';

if (isset($_GET['livraison'])) {

  $Num_cmd=$_GET['livraison'];
  $_SESSION['livraison']=$Num_cmd;
}else{

  $Num_cmd=$_SESSION['livraison'];

}

$_SESSION['rechercher']=$Num_cmd;

  $payement=$DB->querys('SELECT num_cmd, montantpaye, remise, reste, etat, num_client, DATE_FORMAT(date_cmd, \'%d/%m/%Y \à %H:%i:%s\')AS DateTemps, vendeur FROM payement WHERE num_cmd= ?', array($Num_cmd));

  //$frais=$DB->querys('SELECT numcmd, montant, motif  FROM fraisup WHERE numcmd= ?', array($Num_cmd));

  $_SESSION['reclient']=$payement['num_client'];
  $_SESSION['nameclient']=$payement['num_client'];

  if (isset($_POST['id'])) {

    $nomtab=$panier->nomStock($_POST['lstock'])[1];

    $idstock=$panier->nomStock($_POST['lstock'])[2];
    
    $qtiteliv=$panier->h($_POST['qtiteliv']);

    $id=$panier->h($_POST['id']);

    $idcmd=$panier->h($_POST['idc']);

    $numcmd=$panier->h($_POST['numcmd']);

    $type=$panier->h($_POST['type']);

    $marque=$panier->h($_POST['marque']);

    $recupliaison=$DB->querys("SELECT id  FROM productslist WHERE Marque=? and type=? ", array($marque, 'en_gros'));

    $liaison=$recupliaison['id'];

    $recupliaisonp=$DB->querys("SELECT id  FROM productslist WHERE Marque=? and type=? ", array($marque, 'paquet'));

    $liaisonp=$recupliaisonp['id'];

    $qtiteinit=$DB->querys("SELECT quantite  FROM `".$nomtab."` WHERE idprod=? ", array($id));

    $qtiterest=$qtiteinit['quantite']-$qtiteliv;

    $quantite=$qtiterest;

    $cmdverif=$DB->querys("SELECT qtiteliv, quantity  FROM commande WHERE id_produit=? and id=? and num_cmd=? ", array($id, $idcmd, $numcmd));

    if (($cmdverif['quantity']-$cmdverif['qtiteliv'])<$qtiteliv) {?>

      <div class="alertes">La quantité à livrer doit être <= <?=($cmdverif['quantity']-$cmdverif['qtiteliv']);?></div><?php
      

    }else{

      //****************Gestion de detail***************************

      if ($type=="en_gros") {      

        $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?",array($quantite, $id));

      }elseif($type=="paquet"){

        if ($quantite>0) {

          $quantite_det=$quantite;

          $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ? AND type=?", array($quantite_det, $id, "paquet"));

        }else{

          $products=$DB->querys("SELECT quantite, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaison)); //Recuperation du  produit en gros

          $quantite_gros=$products["quantite"]-1;

          $quantite_det=$products["qtiteintp"]+$quantite;

          if ($products["quantite"]>0) {

            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail

            $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

            $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintp"], $idstock));

          }else{

            $quantite_detail0=$quantite;
            $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
          }
        }

      }elseif($type=="detail"){

        if ($quantite>0) {

          $quantite_det=$quantite;

          $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ? AND type=?", array($quantite_det, $id, "detail"));

        }else{

          $products=$DB->querys("SELECT quantite, qtiteintd, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaison)); //Recuperation du  produit en gros

          $productsp=$DB->querys("SELECT quantite, qtiteintd, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaisonp)); //Recuperation du  produit en gros

          $quantite_gros=$products["quantite"]-1;

          $quantite_det=$products["qtiteintd"]+$quantite;

          $quantite_paq=$products["qtiteintp"]+$quantite;

          if ($productsp["quantite"]>0) {

            if ($products["quantite"]>0) {

              $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

              $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail

              $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

                $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintd"], $idstock));

            }else{

              $quantite_detail0=$quantite;
              $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
            }

          }else{// partie à affiner

            if ($products["quantite"]>0) {

              $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

              $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail

              $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

                $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintd"], $idstock));

            }else{

              $quantite_detail0=$quantite;
              $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
            }

          }
        }
      }

      //****************Fin Gestion detail**************************           

      $qtiteinitcmd=$DB->querys("SELECT qtiteliv  FROM commande WHERE id_produit=? and id=? and num_cmd=? ", array($id, $idcmd, $numcmd));

      $qtitecmd=$qtiteinitcmd['qtiteliv']+$qtiteliv;

      $DB->insert("UPDATE commande SET qtiteliv=? WHERE id_produit=?  and id=? and num_cmd=? ", array($qtitecmd, $id, $idcmd, $numcmd));

      $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'liv'.$numcmd, 'sortie', -$qtiteliv, $idstock));

      $qtiteinitcmd=$DB->querys("SELECT (quantity-qtiteliv) as reste  FROM commande WHERE id_produit=?  and id=? and num_cmd=? ", array($id, $idcmd, $numcmd));

      if ($qtiteinitcmd['reste']==0) {

        $DB->insert("UPDATE commande SET etatlivcmd=? WHERE id_produit=?  and id=? and num_cmd=? ", array('livre', $id, $idcmd, $numcmd));

      }else{

        $DB->insert("UPDATE commande SET etatlivcmd=? WHERE id_produit=?  and id=? and num_cmd=? ", array('encoursliv', $id, $idcmd, $numcmd));

      }

      $livreste=$DB->querys("SELECT etatlivcmd FROM commande WHERE num_cmd=:num and etatlivcmd!=:etat ", array('num'=>$numcmd, 'etat'=>'livre'));

      if (empty($livreste)) {

        $DB->insert("UPDATE payement SET etatliv=? WHERE num_cmd=? ", array('livre', $numcmd));
      }else{

        $DB->insert("UPDATE payement SET etatliv=? WHERE num_cmd=? ", array('encoursliv', $numcmd));

      }

      $DB->insert("INSERT INTO livraison (id_produitliv, idcmd, quantiteliv , numcmdliv, id_clientliv, livreur, idstockliv, dateliv) VALUES(?, ?, ?, ?, ?, ?, ?, now())", array($id, $idcmd, $qtiteliv, $numcmd, $_SESSION['reclient'], $_SESSION['idpseudo'], $idstock));
    }

  }?>

  <table style="margin:10px; font-size: 14px;color: black; background: white; width:80%;" >

    <tr>
      <td><strong><?php echo "Facture N°: " .$Num_cmd; ?></strong></td>
    </tr>

    <tr>
      <td><?php echo "Date:  " .$payement['DateTemps']; ?></td>
    </tr>

    <tr>
      <td><?php echo "Vendeur:  " .$panier->nomPersonnel($payement['vendeur']); ?></td>  
    </tr>

    <tr>
      <td style="font-size:14px; text-align: right;"><?=$panier->adClient($_SESSION['reclient'])[0]; ?></td>
    </tr>
    
    <tr>
      <td style="font-size:14px; text-align: right;"><?='Téléphone: '.$panier->adClient($_SESSION['reclient'])[1]; ?></td>
    </tr>

    <tr>
      <td style="font-size:14px; text-align: right;"><?='Adresse: '.$panier->adClient($_SESSION['reclient'])[2]; ?></td>
    </tr>

  </table>

  <div class="ticket">

    <table class="payement">

      <thead>

        <tr>
          <th style="text-align: center;">Désignation</th>
          <th style="text-align: center;">Qtité cmd</th>
          <th style="text-align: center;">Qtité Livré</th>
          <th style="text-align: center;">Reste à Livré</th>
          <th>Livraison</th>
          <th>Choix Stock</th>
          <th></th>
        </tr>

      </thead>

      <tbody><?php

        $total=0;
        $totqtiteliv=0;

         $products=$DB->query('SELECT commande.id as idc, productslist.id as id, quantity, qtiteliv, commande.prix_vente as prix_vente, designation, num_cmd, codecat, type, Marque FROM commande inner join productslist on productslist.id=commande.id_produit WHERE num_cmd= ? order by(type)', array($Num_cmd));
        $totqtite=0;
        foreach ($products as $product){

          $qtitecmd=$product->quantity;
          $totqtite+=$qtitecmd;

          $qtiteliv=$product->qtiteliv;

          $totqtiteliv+=$qtiteliv;

          $reste=$qtitecmd-$qtiteliv;

          if ($reste==0) {
            $etat='livraison terminée';
          }else{
            $etat='en-cours';
          } ?>

          <form method="Post" action="livraison.php">

            <tr>           

              <td style="text-align:left"><?=strtolower($product->designation); ?></td>

              <td style="text-align: center;"><?= $product->quantity; ?></td>

              <td style="text-align: center;"><?= $product->qtiteliv; ?></td>

              <td style="text-align: center;"><?= $reste; ?></td>

              <input type="hidden" name="id" value="<?=$product->id;?>">

              <input type="hidden" name="idc" value="<?=$product->idc;?>">

              <input type="hidden" name="numcmd" value="<?=$product->num_cmd;?>">

              <input type="hidden" name="type" value="<?=$product->type;?>">

              <input type="hidden" name="marque" value="<?=$product->Marque;?>">

              <td style="text-align:center; color: green; font-size:12px;"><?php if ($reste==0) {echo $etat;}else{?><input type="float" name="qtiteliv" max="<?=$reste;?>" placeholder="inserer la qtité"><?php }?></td>

              <td style="text-align:center; color: green; font-size:12px;"><?php if ($reste==0) {echo $etat;}else{?>
                <select name="lstock" required="" >

                  <option></option><?php

                  foreach ($panier->listeStock() as $values) {

                    $reststock=$DB->querys("SELECT quantite as qtite FROM `".$values->nombdd."` WHERE idprod='{$product->id}'");

                    $typegros='en_gros';

                    $searchengros=$DB->querys("SELECT Marque as marque FROM `".$values->nombdd."` inner join productslist on idprod=productslist.id  WHERE idprod='{$product->id}'");

                    $engros=$DB->querys("SELECT id FROM productslist  WHERE Marque='{$searchengros['marque']}' and type='{$typegros}'");

                    $restengros=$DB->querys("SELECT quantite as qtite FROM `".$values->nombdd."` WHERE idprod='{$engros['id']}'");

                    if ($product->type!='en_gros') {
                      if (!empty($restengros['qtite'])) {?>

                        <option style="font-size:20px; color:orange;" value="<?=$values->id;?>"><?=$values->nomstock.' dispo carton '.$restengros['qtite'];?></option><?php
                      }
                    }

                    if (!empty($reststock['qtite'])) {?>

                      <option style="font-size:20px; color:orange;" value="<?=$values->id;?>"><?=$values->nomstock.' dispo '.$reststock['qtite'];?></option><?php
                    }
                    
                  }?>              
                </select><?php }?>
              </td>

              <td style="text-align:center; color: green; font-size:12px;"><?php if ($reste==0) {echo $etat;}else{?><input type="submit" name="validl" value="Valider" onclick="return alerteL();" ><?php }?></td>

            </tr>
          </form><?php
        }?>     

    </tbody>

    <tfoot>
      <tr>
        <th>Totaux</th>
        <th><?=number_format($totqtite,0,',',' ');?></th>
        <th><?=number_format($totqtiteliv,0,',',' ');?></th>
        <th><?=number_format($totqtite-$totqtiteliv,0,',',' ');?></th>
      </tr>
    </tfoot>

  </table>

  
</div>

<script type="text/javascript">
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function alerteL(){
        return(confirm('Confirmer la livraison'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script>