<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

  if ($_SESSION['level']>=3) {
    
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

    <form style="margin-top: 20px;" id='naissance' method="POST" action="produitvendus.php">

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
            <th>Bénéfice</th>
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

              <td style="text-align: center;"><?=number_format($panier->benefice($_SESSION['date1'], $_SESSION['date2']),0,',',' '); ?></td><?php 
            }else{?>

              <td></td>
              <td></td><?php 
            }?>
          </tr>

        </tbody>

      </table>
    </form><?php
    
    require 'headercompta.php';?>

    <div style="display: flex; flex-wrap: wrap; width:100%;">

      <div style="margin-right:20px;">

        <table class="payement">

          <thead>

            <tr>
              <th class="legende" colspan="2" height="30"><?="Cartons Facturés " .$datenormale ?></th>
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
            $type='en_gros';

            if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

              $products =$DB->query("SELECT distinct(id_produit) as id FROM commande inner join payement on payement.num_cmd=commande.num_cmd inner join productslist on id_produit =productslist.id WHERE DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

            }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

              $products =$DB->query("SELECT distinct(id_produit) as id FROM commande inner join payement on payement.num_cmd=commande.num_cmd inner join productslist on id_produit =productslist.id WHERE lieuvente='{$_SESSION['lieuvente']}' and  DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

            }else{

              $products =$DB->query("SELECT distinct(id_produit) as id FROM commande inner join payement on payement.num_cmd=commande.num_cmd inner join productslist on id_produit =productslist.id WHERE lieuvente='{$_SESSION['lieuvente']}' and  DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

            }

            foreach ($products as $produc ){

              if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

                $product =$DB->querys("SELECT SUM(quantity) AS qtite, SUM(qtiteliv) as qtiteliv FROM commande inner join payement on payement.num_cmd=commande.num_cmd WHERE DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' AND commande.id_produit='{$produc->id}'");

              }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

                $product =$DB->querys("SELECT SUM(quantity) AS qtite, SUM(qtiteliv) as qtiteliv FROM commande inner join payement on payement.num_cmd=commande.num_cmd WHERE lieuvente='{$_SESSION['lieuvente']}' and  DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' AND commande.id_produit='{$produc->id}'");

              }else{

                $product =$DB->querys("SELECT SUM(quantity) AS qtite, SUM(qtiteliv) as qtiteliv FROM commande inner join payement on payement.num_cmd=commande.num_cmd WHERE lieuvente='{$_SESSION['lieuvente']}' and  DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' AND commande.id_produit='{$produc->id}'");

              }

                   

              $totalf+= $product['qtite'];
              $totall+= $product['qtiteliv'];

              if (!empty($product['qtite'])) {?>

                <tr>
                  <td style="text-align: left;"><?= ucwords(strtolower($panier->nomProduit($produc->id))); ?></td>
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
              <th class="legende" colspan="2" height="30"><?="Cartons Livrés " .$datenormale ?></th>
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

            foreach ($products as $produc ){

              if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

                $products =$DB->querys("SELECT sum(quantiteliv) as qtite FROM livraison WHERE DATE_FORMAT(dateliv, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(dateliv, \"%Y%m%d\") <= '{$_SESSION['date2']}' AND id_produitliv='{$produc->id}'");

              }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

                $products =$DB->querys("SELECT sum(quantiteliv) as qtite FROM livraison WHERE idstockliv='{$_SESSION['lieuvente']}' and  DATE_FORMAT(dateliv, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(dateliv, \"%Y%m%d\") <= '{$_SESSION['date2']}' AND id_produitliv='{$produc->id}'");

              }else{

                $products =$DB->querys("SELECT sum(quantiteliv) as qtite FROM livraison WHERE idstockliv='{$_SESSION['lieuvente']}' and  DATE_FORMAT(dateliv, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(dateliv, \"%Y%m%d\") <= '{$_SESSION['date2']}' AND id_produitliv='{$produc->id}'");

              }                  

              $totall+= $products['qtite'];

              if (!empty($products['qtite'])) {?>

                <tr>
                  <td style="text-align: left;"><?= ucwords(strtolower($panier->nomProduit($produc->id))); ?></td>
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
    </div>
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