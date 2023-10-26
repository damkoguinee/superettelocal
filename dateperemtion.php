<?php
require 'header.php';

if (isset($_GET['produit'])) {
  // code...
}else{

  if (isset($_POST['magasin'])) {

    $_SESSION['lieuventealerte']=$_POST['magasin'];
  }else{

    $_SESSION['lieuventealerte']=$_SESSION['lieuvente'];

  }
}

$nomtab=$panier->nomStock($_SESSION['lieuventealerte'])[1];

$idstock=$panier->nomStock($_SESSION['lieuventealerte'])[2];

require'indicateur.php';

if (isset($_GET['produit'])) {


  if (isset($_POST['qtiteperem'])) {

    $prodrayon = $DB->querys("SELECT quantite as qtite, prix_achat as pachat, prix_vente as pvente, prix_revient as previent FROM `".$nomtab."` WHERE idprod=:id", array('id' => $_POST['id']));
    $ndatep=$_POST['datep'];


    if (!empty($_POST['qtiteperem'])) {

      $maximum = $DB->querys('SELECT count(id) AS max_id FROM pertes ');

      $numpertes =$maximum['max_id'] + 1;

      $init='perim';

      $qtitesr=$prodrayon['qtite']-$_POST['qtiteperem'];
      

      $DB->insert("UPDATE `".$nomtab."` SET quantite= ?, dateperemtion=? WHERE idprod = ?", array($qtitesr, $ndatep, $_POST['id']));


      $DB->insert('INSERT INTO pertes (idpertes, idnomstockp, quantite, prix_achat, prix_vente, prix_revient, motifperte, datepertes) VALUES(?, ?, ?, ?, ?, ?, ?, now())',array($_POST['id'], $idstock, $_POST['qtiteperem'], $prodrayon['pachat'], $prodrayon['pvente'], $prodrayon['previent'], 'produit perimé'));

      $DB->insert('INSERT INTO stockmouv (idstock, idnomstock, numeromouv, libelle, quantitemouv, dateop) VALUES(?, ?, ?, ?, ?, now())', array($_POST['id'], $idstock, $init.$numpertes, 'pertes', -$_POST['qtiteperem']));

    }else{

      $DB->insert("UPDATE `".$nomtab."` SET dateperemtion=? WHERE idprod = ?", array($ndatep, $_POST['id']));
    }?>

    <div class="alerteV">Produit retirer avec succès</div><?php
  }?>

  <div style="display: flex; width: 90%; flex-wrap: wrap;"><?php

    $prodpos= $DB->query('SELECT nom, id FROM categorie order by(id) ');
    

    foreach ($prodpos as $position) {?>

      <div style="margin-left: 0px; margin-bottom: 0px; flex-wrap: wrap;"><?php

      if (isset($_GET['perime']) or isset($_POST['qtiteperem'])) {
        
        $prodperime= $DB->query("SELECT idprod as id, designation, codecat as position, quantite, dateperemtion AS datep FROM `".$nomtab."` inner join productslist on productslist.id=idprod where codecat=:pos and DATE_FORMAT(dateperemtion, \"%Y%m\") <= :annee and quantite>0", array('pos'=>$position->id, 'annee' => ($now)));

      }elseif(isset($_GET['critique'])){

       $prodperime= $DB->query("SELECT idprod as id, designation, codecat as position, quantite, dateperemtion AS datep FROM `".$nomtab."` inner join productslist on productslist.id=idprod where codecat=:pos and DATE_FORMAT(dateperemtion, \"%Y%m\") > :auj and DATE_FORMAT(dateperemtion, \"%Y%m\")<=:apres and quantite>0", array('pos'=>$position->id, 'auj' => ($now), 'apres' => ($nowl1)
        ));

      }elseif(isset($_GET['orange'])){

       $prodperime= $DB->query("SELECT idprod as id, designation, codecat as position, quantite, dateperemtion AS datep FROM `".$nomtab."` inner join productslist on productslist.id=idprod where codecat=:pos and DATE_FORMAT(dateperemtion, \"%Y%m\") > :auj and DATE_FORMAT(dateperemtion, \"%Y%m\")<=:apres and quantite>0", array('pos'=>$position->id, 'auj' => ($nowl1), 'apres'=>($nowl2)
        ));

      }elseif(isset($_GET['vert'])) {

       $prodperime= $DB->query("SELECT idprod as id, designation, codecat as position, quantite, dateperemtion AS datep FROM `".$nomtab."` inner join productslist on productslist.id=idprod where codecat=:pos and DATE_FORMAT(dateperemtion, \"%Y%m\") > :annee and quantite>0", array('pos'=>$position->id, 'annee' => ($nowl2)
        ));
      }

      if (!empty($prodperime)) {?>

        <table class="payement" style="width: 100%;">

          <thead>
            <tr><?php

                if (isset($_GET['perime'])) {?>

                  <th colspan="6"><?=strtoupper($position->nom);?></th><?php

                }else{?>

                  <th colspan="3"><?=strtoupper($position->nom);?></th><?php

                }?>
            </tr>

            <tr>
              <th>Designation</th>
              <th style="text-align: right; padding-right: 15px;">Qtité</th>
              <th>Date P</th><?php

              if (isset($_GET['perime'])) {?>
                <th>Qtite à retirer</th>
                <th colspan="2">Entrer nouvelle date</th><?php
              }?>
            </tr>
          </thead>

          <tbody><?php

            $total=0;

              foreach ($prodperime as $value) {

                $total+=$value->quantite;?>

                <tr>
                  <td style="color: <?=$_GET['produit'];?>"><?=ucwords(strtolower($value->designation));?></td>

                  <td style="color: <?=$_GET['produit'];?>; text-align: right; padding-right: 15px;"><?=$value->quantite;?></td>

                  <td style="color: <?=$_GET['produit'];?>; text-align: right; padding-right: 15px;"><?=(new dateTime($value->datep))->format('d/m/Y');?></td><?php

                  if (isset($_GET['perime']) or isset($_POST['qtiteperem'])) {?>

                    <form action="dateperemtion.php?produit=<?='maroon';?>&perime" method="POST">

                      <td style="width: 20%;"><input type="number" name="qtiteperem" max="<?=$value->quantite;?>" style="width: 95%;" /><input type="hidden" name="id" value="<?=$value->id;?>"></td>

                      <td style="width: 20%;"><input type="date" name="datep" value="<?=$value->datep;?>" style="width: 95%;" /><input type="hidden" name="id" value="<?=$value->id;?>"></td>

                      <td><input type="submit" name="valids" value="Valider" style="width: 95%; font-size: 12px; background-color: red;color: white; cursor: pointer;"></td>
                    </form><?php

                  }?>
                </tr><?php
              }?>
          </tbody>

          <tfoot>
            <tr>
              <th>Total</th>
              <th style="text-align: right; padding-right: 15px;"><?=$total;?></th><?php

                if (isset($_GET['perime']) or isset($_POST['qtiteperem'])) {?>

                  <th colspan="3"></th><?php

                }?>
            </tr>
          </tfoot>

        </table><?php
      }?>
      </div><?php
    }?>

    </div><?php
  
}



if (isset($_GET['perte'])) {?>

  <div style="display: flex; width: 60%; flex-wrap: wrap;"><?php

    $prodperime= $DB->query("SELECT idprod, motifperte as motif,  pertes.prix_achat as pachat, pertes.prix_revient as previent, pertes.prix_vente as pvente, pertes.quantite as qtitep, DATE_FORMAT(datepertes, \"%d/%m/%Y\") as date_retrait FROM pertes inner join `".$nomtab."` on idprod=pertes.idpertes order by(datepertes) DESC ");?>
    
    <table class="payement" style="width: 100%;">

      <thead>
        <tr>
          <th colspan="6">Tableau des pertes</th>
        </tr>

        <tr>
          <th>Motif</th>
          <th>Designation</th>
          <th style="text-align: right; padding-right: 15px;">Qtité</th>
          <th style="text-align: right; padding-right: 15px;">P. Achat</th>
          <th style="text-align: right; padding-right: 15px;">P. Vente</th>
          <th>Date Retrait</th>
        </tr>
      </thead>

      <tbody><?php

        $totalp=0;
        $totala=0;
        $totalv=0;

        foreach ($prodperime as $value) {

          $totalp+=$value->qtitep;
          $totala+=$value->pachat*$value->qtitep;
          $totalv+=$value->pvente*$value->qtitep;?>

          <tr>
            <td><?=ucwords($value->motif);?></td>

            <td><?=ucwords(strtolower($panier->nomProduit($value->idprod)));?></td>

            <td style="text-align: right; padding-right: 15px;"><?=$value->qtitep;?></td>

            <td style="text-align: right; padding-right: 15px;"><?=number_format($value->pachat,2,',',' ');?></td>

            <td style="text-align: right; padding-right: 15px;"><?=number_format($value->pvente,2,',',' ');?></td>

            <td><?=$value->date_retrait;?></td>

          </tr><?php
        }?>
        
      </tbody>

      <tfoot>
        <tr>
          <th colspan="2">Total</th>
          <th style="text-align: right; padding-right: 15px;"><?=$totalp;?></th>

          <th style="text-align: right; padding-right: 15px;"><?=number_format($totala,2,',',' ');?></th>

          <th style="text-align: right; padding-right: 15px;"><?=number_format($totalv,2,',',' ');?></th>

          <th></th>

        </tr>
      </tfoot>

    </table>
  </div><?php
  
}


