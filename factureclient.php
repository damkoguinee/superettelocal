<?php require 'header.php';

if (!isset($_POST['j1'])) {

  $_SESSION['date']=date("Ymd");  
  $dates = $_SESSION['date'];
  $dates = new DateTime( $dates );
  $dates = $dates->format('Ymd'); 
  $_SESSION['date']=$dates;
  $_SESSION['date1']=$dates;
  $_SESSION['date2']=$dates;
  $_SESSION['dates1']=$dates; 

}else{

  $_SESSION['date01']=$_POST['j1'];
  $_SESSION['date1'] = new DateTime($_SESSION['date01']);
  $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
  
  $_SESSION['date02']=$_POST['j2'];
  $_SESSION['date2'] = new DateTime($_SESSION['date02']);
  $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

  $_SESSION['dates1']=(new DateTime($_SESSION['date01']))->format('d/m/Y');
  $_SESSION['dates2']=(new DateTime($_SESSION['date02']))->format('d/m/Y');
}

if (isset($_POST['j2'])) {

  $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

}else{

  $datenormale=(new DateTime($dates))->format('d/m/Y');
}

if (!isset($_GET['produitfac'])) {?>

  <table style="margin-top: 30px;" class="payement">
    <thead>
      <tr>
        <th class="legende" colspan="5" height="30"><?="Liste de mes facturations ".$datenormale;?></th>
      </tr>

      <tr>
        <th>N°</th>
        <th>N° Facture</th>
        <th>Date Facture</th>
        <th>Montant</th>
        <th></th>
      </tr>
    </thead>

    <tbody><?php

      $products=$DB->query("SELECT *FROM payement where num_client='{$_SESSION['idcpseudo']}' order by(date_cmd) desc ");

      $cumulmontanremp=0;
      $cumulmontantotp=0;
      $cumulmontanrestp=0;

      foreach ($products as $key=> $product ){

        $cumulmontanremp+=$product->remise;
        $cumulmontantotp+=$product->Total-$product->remise;
        $cumulmontanrestp+=$product->montantpaye; ?>

        <tr>
          <td style="text-align:center;"><?=$key+1;?></td>

          <td style="text-align:center;"><?= $product->num_cmd; ?></td>

          <td style="text-align:center;"><?= $panier->formatDate($product->date_cmd); ?></td>

          <td style="text-align: right; padding-right: 10px;"><?= number_format(($product->Total-$product->remise),0,',',' '); ?></td>

          <td><a target="_blank" style="color: red;" href="printticket.php?ticketclient=<?=$product->num_cmd;?>&conectC" ><input style="width: 100%;height: 30px; font-size: 17px; background-color: orange;color: white; cursor:pointer;"  type="submit" value="Voir la facture"></a></td>
        </tr><?php 
      } ?>

    </tbody>

    <tfoot>
      <tr>
        <th colspan="3"></th>
        <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontantotp,0,',',' ');?></th>
      </tr>
    </tfoot>
  </table><?php
}

if (isset($_GET['produitfac'])) {?>

  <div id="bilaninv" style="display: flex; flex-wrap: wrap;">

    <div class="bloc_prodinv">

      <table class="payement">

        <thead>

          <tr>
            <th class="legende" colspan="2" height="30"><?="Produits Facturés " .$datenormale ?></th>
          </tr>

          <tr>
            <th>Désignation</th>
            <th>Qtité Facturée</th>
          </tr>

        </thead>

        <tbody>
          <?php 
          $totalf=0;
          $totall=0;
          $products =$DB->query('SELECT id, designation FROM productslist');

          foreach ($products as $produc ){

              $product =$DB->querys("SELECT SUM(quantity) AS qtite, SUM(qtiteliv) as qtiteliv FROM commande inner join payement on payement.num_cmd=commande.num_cmd WHERE num_client='{$_SESSION['idcpseudo']}' AND commande.id_produit='{$produc->id}'");
                 

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
            <th colspan="1" height="40">TOTAL</th>
            <th style="text-align: center;"><?= $totalf; ?></th>          
          </tr>

        </tbody>

      </table>
    </div>
    <div>


      <table class="payement">

        <thead>

          <tr>
            <th class="legende" colspan="2" height="30"><?="Produits Livrés " .$datenormale ?></th>
          </tr>

          <tr>
            <th>Désignation</th>
            <th>Qtité Livrée</th>
          </tr>

        </thead>

        <tbody>
          <?php 
          $totalf=0;
          $totall=0;

          $products =$DB->query('SELECT id, designation FROM productslist');
          foreach ($products as $produc ){

              $products =$DB->querys("SELECT sum(quantiteliv) as qtite FROM livraison WHERE id_clientliv='{$_SESSION['idcpseudo']}' and id_produitliv='{$produc->id}'");

            $totall+= $products['qtite'];

            if (!empty($products['qtite'])) {?>

              <tr>
                <td style="text-align: left;"><?= ucwords(strtolower($produc->designation)); ?></td>
                <td style="text-align:center;"><?= $products['qtite']; ?></td>
              </tr><?php
            }
            
          }?>

          <tr>          
            <th colspan="1" height="40">Totaux</th>
            <th style="text-align: center;"><?= $totall; ?></th>          
          </tr>

        </tbody>

      </table>
    </div>
  </div><?php
}



