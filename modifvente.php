<?php
require 'header.php';
if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

  if ($products['level']>=3) {

    if (isset($_GET['num_cmd'])) {
    
      $_SESSION['num_cmd']=$_GET['num_cmd'];
    }

    if (isset($_GET['delid'])) {

      $prodcmd =$DB->querys('SELECT id, (prix_vente*quantity) as montant FROM commande WHERE id=:num', array('num'=>$_GET['delid']
        ));

      $prodpayement =$DB->querys('SELECT  montantpaye, Total, reste FROM payement WHERE num_cmd=:num', array('num'=>$_GET['num_cmd']
        ));

      $retranche=$prodpayement['Total']-$prodcmd['montant'];

      $DB->insert('UPDATE payement SET Total = ? WHERE num_cmd = ?', array($retranche, $_GET['num_cmd']));

      if ($prodpayement['reste']==0) {

        $DB->insert('UPDATE payement SET montantpaye = ? WHERE num_cmd = ?', array($retranche, $_GET['num_cmd']));
      }

      $prodbul =$DB->querys('SELECT  numero, montant FROM bulletin WHERE numero=:num', array('num'=>$_GET['num_cmd']
        ));

      $retranche=$prodbul['montant']-$prodcmd['montant'];

      $DB->insert('UPDATE bulletin SET montant = ? WHERE numero = ?', array($retranche, $_GET['num_cmd']));

      $DB->delete('DELETE FROM commande WHERE id= ?', array($_GET['delid']));

       $prodcmd =$DB->querys('SELECT id FROM commande WHERE num_cmd=:num', array('num'=>$_GET['num_cmd']
        ));

      var_dump($prodcmd);

      if (empty($prodcmd)) {
        echo "string";


        $DB->delete('DELETE FROM payement WHERE num_cmd= ?', array($_GET['num_cmd']));

      }

    }

    $prodclient = $DB->query('SELECT * FROM client where type=:type order by(nom_client)', array('type'=>'Client'));?>

    <table style="margin-top: 30px;" class="payement">

      <thead>
        <tr>
          <th class="legende" colspan="7" height="30">Modifier cette vente</th>
        </tr>

        <tr>

          <th>Désignation</th>
          <th>Qtité</th>
          <th>Payement</th>
          <th>Client</th>
          <th></th>
        </tr>
      </thead>

      <tbody><?php

        $products =$DB->query('SELECT id, num_cmd, designation, quantity, prix_vente, mode_payement, etat, client, DATE_FORMAT(date_cmd, \'%H:%i:%s\')AS DateTemps FROM commande inner join products on products.id=commande.id_produit inner join payement on payement.num_cmd=commande.num_cmd WHERE commande.num_cmd=:num', array('num'=>$_SESSION['num_cmd']
        ));

        foreach ($products as $product ){?>

          <form id="modif" method="POST" action="modifvente.php">

            <tr>
              <td><?= $product->designation; ?></td>

              <td style="text-align:center; width: 15%;"><input type="number" name="qtite" onchange="this.form.submit()" value="<?= $product->quantity; ?>" ><input type="hidden" name="id" value="<?= $product->id; ?>"></td>

              <td>
                <select name="mode_payement"  onchange="this.form.submit()">
                  <option value="<?= $product->mode_payement; ?>"><?= $product->mode_payement; ?></option>
                  <option value="especes">Espèces</option>
                  <option value="vire Bancaire">vire bancaire</option>
                  <option value="cheque">Cheque</option>
                </select>
              </td>

              <td>
                <select name="client" onchange="this.form.submit()">
                  <option value="<?= $product->client; ?>"><?= $product->client; ?></option><?php

                  foreach($prodclient as $prod){?> 

                    <option value="<?=$prod->nom_client;?>"><?=$prod->nom_client;?></option><?php
                  }?>

                </select>
              </td>

              <td><a href="modifvente.php?delid=<?=$product->id;?>&num_cmd=<?=$_SESSION['num_cmd'];?>"> Supprimer</a></td>
                  </td>
            </tr>
          </form><?php

        }?>

      </tbody><?php  
        $prodpay =$DB->querys('SELECT id, num_cmd, montantpaye, remise FROM payement WHERE num_cmd=:num', array('num'=>$_SESSION['num_cmd']
        ));?>


      <tfoot>
        <tr>
          <form action="modifvente" method="POST">
            <th>Montant Payé</th>
            <th><input type="text" name="montant" value="<?=$prodpay['montantpaye'];?>" onchange="this.form.submit()"></th>
          </form>
        </tr>

        <tr>
          <form action="modifvente" method="POST">
            <th>Remise</th>
            <th><input type="text" name="remise" value="<?=$prodpay['remise'];?>" onchange="this.form.submit()"></th>
          </form>

        </tr>
      </tfoot>

    </table><?php
  }
}