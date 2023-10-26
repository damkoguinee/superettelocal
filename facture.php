<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];
  

  if (isset($_GET['facture'])) {
    unset($_SESSION['reclient']);
  }
  
  if ($products['statut']!="vendeur") {

    require 'headercmd.php';

    /*-------------POUR SUPPRIMER UNE FACTURE--------------------------*/

    if (isset($_GET['delete']) OR isset($_GET['numfactd'])) {

      $nomtab=$panier->nomStock($_GET['lieuvente'])[1];
      $idstock=$_GET['lieuvente'];

      if (!isset($_GET['numfactd'])) {

      }else{

        $numero=$_GET['numfactd'];

        $products = $DB->query('SELECT id_produitfac, designation, quantite, previent FROM achat WHERE numcmd= :NUM' , array('NUM'=>$numero));

        foreach ($products as $prodcmd) {

          $designation=$prodcmd->id_produitfac;

          $prodstock=$DB->querys("SELECT idprod, quantite, prix_revient as pr FROM `".$nomtab."` WHERE idprod= :DESIG", array('DESIG'=>$designation));                   

          $quantite=$prodstock['quantite']-$prodcmd->quantite;

          $prmoyen=$panier->espace(number_format(((($prodstock['quantite']*$prodstock['pr'])-($prodcmd->quantite*$prodcmd->previent))/(($prodstock['quantite']-$prodcmd->quantite))),0,',',''));   

          $DB->insert("UPDATE `".$nomtab."` SET quantite = ?, prix_revient=? WHERE idprod = ?" , array($quantite, $prmoyen, $designation));
          
        }

        foreach ($products as $prodcmd) {

          $designation=$prodcmd->id_produitfac;

          $prodmouv=$DB->query('SELECT idstock, quantitemouv FROM stockmouv WHERE idstock= :DESIG and numeromouv=:numero and idnomstock=:noms' , array('DESIG'=>$designation, 'numero'=>$numero, 'noms'=>$idstock));

          foreach ($prodmouv as $prodstock) {                    

            $quantite=$prodstock->quantitemouv-$prodcmd->quantite;
        
            $DB->insert('UPDATE stockmouv SET quantitemouv = ? WHERE idstock = ? and numeromouv=? and idnomstock=?' , array($quantite, $designation, $numero, $idstock));
          }
        }

       $DB->delete('DELETE FROM achat WHERE numcmd = ?', array($numero));
       $DB->delete('DELETE FROM bulletin WHERE numero = ?', array($numero));
       $DB->delete('DELETE FROM histpaiefrais WHERE num_cmd = ?', array($numero));
       $DB->delete('DELETE FROM facture WHERE numcmd = ?', array($numero));

       $DB->delete('DELETE FROM banque WHERE numero = ?', array($numero));?>

        <div class="alerteV"><?="Commande ".$numero." supprimée";
      }
    }

    /* ------------- GESTION DES PAYEMENTS FACTURES ---------*/

    require 'paiecreditcmd.php';

    if (isset($_GET['choix']) or isset($_GET['montcom'])) {

      if (isset($_GET['choix'])){

        $prodchoix = $DB->querys('SELECT id FROM paiecredcmd WHERE numero = :mat', array('mat'=> $_GET['choix']));

        if (empty($prodchoix)) {

          $DB->insert('INSERT INTO paiecredcmd(numero, montant) VALUES(?, ?)',array($_GET['choix'], $_GET['montchoix']));

        }else{

          $DB->delete('DELETE FROM paiecredcmd where numero=?', array($_GET['choix']));              
        }
      }
      if(isset($_GET['montcom'])){

        $DB->insert('UPDATE paiecredcmd SET montant=? where numero=?' ,array($_GET['montcom'], $_GET['numero']));
      }  

    }else{?>

      <?php
    }

    /* ------------- AFFICHAGE DE LA LISTE DES FACTURES---------*/?>

    <table class="payement" style="width: 98%; margin-top: 20px;">

      <thead>

        <tr>
            <form method="GET"  action="facture.php">
              <th colspan="2"><select style="width: 250px; height: 30px; font-size: 19px;" type="text" name="client" onchange="this.form.submit()"><?php
                if (isset($_GET['client']) or !empty($_SESSION['reclient'])) {
                  if (isset($_GET['client'])) {
                    $_SESSION['reclient']=$_GET['client'];
                  }?>

                  <option><?=$panier->nomClient($_SESSION['reclient']);?></option><?php

                }else{?>
                  <option>Selectionnez le client</option><?php
                }

                $type='Fournisseur';

                $type1='fournisseur';
                $type2='clientf';


                foreach($panier->clientF($type1, $type2) as $product){?>

                  <option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php
                }?></select>
              </th>
            </form>
            <th class="legende" colspan="7" height="30"><?php echo "Liste des factures" ?></th>
          </tr>


        <tr>
          <th>N°Fact</th>
          <th>Date Fact</th>
          <th>Fournisseur</th>
          <th>Total Fac</th>
          <th>Date cmd</th>
          <th>Mode P</th>
          <th>Date P</th>
          <th></th>
          <th></th>
        </tr>

      </thead>

      <tbody><?php

        if (isset($_GET['client']) or !empty($_SESSION['reclient'])) {

          $reponse = $DB->query("SELECT facture.id as id, client.id as idc, lieuvente, numfact, numcmd, montantht, montantva, montantpaye, frais, payement, nom_client as client, DATE_FORMAT(datecmd, \"%d/%m/%Y\")AS datecmd, DATE_FORMAT(datefact, \"%d/%m/%Y\")AS datefact, DATE_FORMAT(datepaye, \"%d/%m/%Y\")AS datepayement FROM facture inner join client on client.id=fournisseur WHERE client.id='{$_SESSION['reclient']}' ORDER BY(datecmd) DESC");

        }else{
          $date=date("Y");

          $reponse = $DB->query("SELECT facture.id as id, client.id as idc, lieuvente, numfact, numcmd, montantht, montantva, montantpaye, frais, payement, nom_client as client, DATE_FORMAT(datecmd, \"%d/%m/%Y\")AS datecmd, DATE_FORMAT(datefact, \"%d/%m/%Y\")AS datefact, DATE_FORMAT(datepaye, \"%d/%m/%Y\")AS datepayement FROM facture inner join client on client.id=fournisseur WHERE YEAR(datecmd) = '{$date}' ORDER BY(datecmd) DESC");

          unset($_SESSION['reclient']);


        }

        $totresteapeyer=0;
        $totpayer=0;
        $totfact=0;

        foreach ($reponse as $product ){

          $totfact+=$product->montantht+$product->montantva;

          $resteapeyer=$product->montantht+$product->montantva-$product->montantpaye;

          $totresteapeyer+=$resteapeyer;

          $totpayer+=$product->montantpaye;
            
          if ($resteapeyer!='0') {

            $etat='En-cours';

          }else{

            $etat='Clos';
            
          }?>

          <form method="GET"  action="facture.php">

            <tr>
              <td><?= $product->numfact; ?></td>

              <td><?= $product->datefact; ?></td>

              <td><?= ucwords(strtolower($product->client)); ?></td>

              <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montantht+$product->montantva,0,',',' '); ?></td>

              <td><?= $product->datecmd; ?></td>

              <td><?= $product->payement; ?></td>

              <td><?= $product->datepayement; ?></td>

              <td style="text-align: center;"><a target="_blank" href="printcmd.php?print=<?=$product->numcmd;?>&client=<?=$product->idc;?>&lieuvente=<?=$product->lieuvente;?>" class="print" style="text-decoration: none;" ><img src="img/pdf.jpg"></a></td>

              <td><a href="facture.php?numfactd=<?=$product->numcmd;?>&lieuvente=<?=$product->lieuvente;?>"style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor:pointer;"  type="submit" value="Supprimer" onclick="return alerteS();">Supprimer </a></td>

            </tr>
          </form><?php 
        }?>

      </tbody>

      <tfoot>
        <tr><?php 

          if (isset($_GET['client']) or !empty($_SESSION['reclient'])) {?>

            <th colspan="3">Totaux</th>

            <th style="text-align: right; padding-right: 10px;"><?=number_format($totfact,0,',',' ');?></th><?php 

          }else{?>

            <th colspan="3">Totaux</th>

            <th style="text-align: right; padding-right: 10px;"><?=number_format($totfact,0,',',' ');?></th><?php
          }?>
        </tr>
      </tfoot>

    </table><?php
  }else{

    echo "VOUS N'AVEZ PAS TOUTES LES AUTORISATIOS REQUISES";

  }

}else{


}?>

<script type="text/javascript">
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script>