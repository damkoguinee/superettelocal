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

      if (!isset($_GET['numfactd'])) {

      }else{

        $numero=$_GET['numfactd'];

       $DB->delete('DELETE FROM fourachat WHERE numcmd = ?', array($numero));
       $DB->delete('DELETE FROM fourfacture WHERE numcmd = ?', array($numero));?>

        <div class="alerteV"><?="Commande ".$numero." supprimée";
      }
    }

    /* ------------- GESTION DES PAYEMENTS FACTURES ---------*/

    

    /* ------------- AFFICHAGE DE LA LISTE DES FACTURES---------*/

    $prodverif = $DB->query("SELECT* FROM fourfacture ORDER BY(datecmd)");

    if (!empty($prodverif)) {?>

      <table class="payement" style="width: 80%; margin-top: 20px;">

        <thead>

          <tr>
              <form method="GET"  action="fourlistecommande.php">
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
              <th class="legende" colspan="7" height="30"><?php echo "Liste des Commandes" ?></th>
            </tr>


          <tr>
            <th>N°Cmd</th>
            <th>Date</th>
            <th>Fournisseur</th>
            <th>Total Fac</th>
            <th></th>
            <th></th>
            <th></th>
          </tr>

        </thead>

        <tbody><?php

          if (isset($_GET['client']) or !empty($_SESSION['reclient'])) {

            $reponse = $DB->query("SELECT fourfacture.id as id, client.id as idc, lieuvente, numfact, numcmd, montantht, montantva, montantpaye, frais, payement, nom_client as client, DATE_FORMAT(datecmd, \"%d/%m/%Y\")AS datecmd, DATE_FORMAT(datefact, \"%d/%m/%Y\")AS datefact, DATE_FORMAT(datepaye, \"%d/%m/%Y\")AS datepayement FROM fourfacture inner join client on client.id=fournisseur WHERE client.id='{$_SESSION['reclient']}' ORDER BY(datecmd) DESC");

          }else{
            $date=date("Y");

            $reponse = $DB->query("SELECT fourfacture.id as id, client.id as idc, lieuvente, numfact, numcmd, montantht, montantva, montantpaye, frais, payement, nom_client as client, DATE_FORMAT(datecmd, \"%d/%m/%Y\")AS datecmd, DATE_FORMAT(datefact, \"%d/%m/%Y\")AS datefact, DATE_FORMAT(datepaye, \"%d/%m/%Y\")AS datepayement FROM fourfacture inner join client on client.id=fournisseur WHERE YEAR(datecmd) = '{$date}' ORDER BY(datecmd) DESC");

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

            <form method="GET"  action="fourlistecommande.php">

              <tr>
                <td style="text-align:center;"><?= $product->numfact; ?></td>

                <td style="text-align:center;"><?= $product->datecmd; ?></td>

                <td><?= ucwords(strtolower($product->client)); ?></td>

                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montantht+$product->montantva,0,',',' '); ?></td>

                <td style="text-align: center;"><a target="_blank" href="fourprintcmd.php?print=<?=$product->numcmd;?>&client=<?=$product->idc;?>&lieuvente=<?=$product->lieuvente;?>" class="print" style="text-decoration: none;" ><img src="img/pdf.jpg"></a></td>

                <td><a style="font-size: 25px; background-color: orange;color: white; cursor:pointer;" href="fourcommandemodif.php?numcmdmodif=<?=$product->numcmd;?>" onclick="return alerteM();"> Modifier </a></td>

                <td><a href="fourlistecommande.php?numfactd=<?=$product->numcmd;?>&lieuvente=<?=$product->lieuvente;?>"style="width: 100%;height: 30px; font-size: 25px; background-color: red;color: white; cursor:pointer;"  type="submit" value="Supprimer" onclick="return alerteS();">Supprimer </a></td>

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
    }
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

    function alerteM(){
        return(confirm('Confirmer la modification'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script>