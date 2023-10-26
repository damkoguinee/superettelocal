<?php
require 'header.php';
if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

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

    $_SESSION['date1']=$_POST['j1'];
    $_SESSION['date1'] = new DateTime($_SESSION['date1']);
    $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
    
    $_SESSION['date2']=$_POST['j2'];
    $_SESSION['date2'] = new DateTime($_SESSION['date2']);
    $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

    $_SESSION['dates1']=$_SESSION['date1'];
    $_SESSION['dates2']=$_SESSION['date2'];   
  }

  if ($products['level']>=3) {

    require 'navbulletin.php';

    if (isset($_GET['client']) or isset($_GET['clientsearch'])) {
      
      require 'compteclient.php';

    }elseif (isset($_GET['fournisseurs']) or isset($_GET['fournisseursearch'])) {
      
      require 'comptefournisseur.php';

    }elseif (isset($_GET['frais']) or isset($_GET['fraissearch'])) {
      
      require 'comptefrais.php';

    }elseif (isset($_GET['autres']) or isset($_GET['autressearch'])) {
      
      require 'compteautres.php';

    }elseif (isset($_GET['personnel']) or isset($_GET['personnelsearch'])) {
      
      require 'comptepersonnel.php';

    }else{

      if (!isset($_GET['compte'])) {

        if (isset($_GET['soldeclient'])) {

          $_SESSION['nameclient']=$_GET['soldeclient'];
        }else{

          $_SESSION['nameclient']=$_SESSION['nameclient'];

        }?>

        <div style="width:90%;"><?php

          if (isset($_POST["client"]) or !empty($_SESSION['date1']) or $_SESSION['date2']) {?>

            <table class="payement">
              <thead>
                <tr>

                  <form method="POST" action="bulletin.php" id="suitec" name="termc">

                    <th style="border-right: 0px;" ><?php

                      if (isset($_POST['j1'])) {?>

                        <input id="reccode" style="width: 120px; font-size: 14px;" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php

                      }else{?>

                        <input id="reccode" style="width: 120px; font-size: 14px;" type = "date" name = "j1" onchange="this.form.submit()"><?php

                      }?><?php

                      if (isset($_POST['j2'])) {?>

                        <input id="reccode" style="width: 120px; font-size: 14px;" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php

                      }else{?>

                        <input id="reccode" style="width: 120px; font-size: 14px;" type = "date" name = "j2" onchange="this.form.submit()"><?php

                      }?>
                    </th>
                    <th colspan="5">Produits facturés de <?=$panier->nomClient($_SESSION['nameclient']);?> Tel: <?=$panier->nomClientad($_SESSION['nameclient'])[1];?></th>
                  </form>
                </tr>
              </thead><?php

              
              $totc=0;
              $qtitet=0;
              $prodp=$DB->query('SELECT num_cmd as num, num_client as client, Total, DATE_FORMAT(date_cmd, \'%d/%m/%Y\') as datec from payement where num_client=:client AND DATE_FORMAT(date_cmd, \'%Y%m%d\') >= :date1 and DATE_FORMAT(date_cmd, \'%Y%m%d\') <= :date2 order by(date_cmd)', array('date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2'], 'client' => $_SESSION['nameclient']));

              foreach ($prodp as $key => $valuep) {
                $totc+=$valuep->Total;?>

                <tbody>

                  <tr>
                    <td colspan="6">
                      <div style="display:flex;">

                        <div><?=$key+1;?></div>
                        <div style="margin: auto;"><a style="color: red;" href="recherche.php?recreditc=<?=$valuep->num;?>&reclient=<?=$valuep->client;?>"><?=$valuep->num; ?></a></div>

                        <table class="payement">

                          <thead>
                            <tr>
                              <th colspan="5">Produits vendus le <?=$valuep->datec;?></th>
                            </tr>

                            <tr>
                              <th>Qtité</th>
                              <th>Désignation</th>                          
                              <th>P. Vente</th>
                              <th>P.Total</th>
                            </tr>
                          </thead><?php


                          $prodv=$DB->query('SELECT commande.num_cmd as num, commande.prix_vente as prixv, commande.quantity as qtite, designation from commande inner join  productslist on productslist.id=commande.id_produit where commande.num_cmd=:num and commande.id_client=:client', array('num'=>$valuep->num, 'client' => $_SESSION['nameclient']));

                          $frais=$DB->querys('SELECT numcmd, montant, motif  FROM fraisup WHERE numcmd= ?', array($valuep->num));

                          $qtite=0;
                          foreach ($prodv as $keyv => $value) {

                            $qtitet+=$value->qtite;
                            $qtite+=$value->qtite;?>

                            <div>

                              <tbody>
                                <tr>
                                  <td style="text-align:center;"><?=$value->qtite;?></td>
                                  <td><?=ucwords($value->designation);?></td>
                                  <td style="text-align:right;"><?=number_format($value->prixv,0,',',' ');?></td>
                                  <td style="text-align:right;"><?=number_format($value->prixv*$value->qtite,0,',',' ');?></td>
                                </tr>
                              </tbody>
                              
                            </div><?php 
                          }

                          if (!empty($frais['motif'])) {?>

                            <tr>
                              <td style="text-align: center;">1</td>

                              <td style="width: 40%;text-align:left"><?=ucwords($frais['motif']); ?></td>                              

                              <td style="width: 22%; text-align:right"><?=number_format($frais['montant'],0,',',' '); ?></td>

                              <td style="width: 28%; text-align:right; padding-right: 10px;"><?= number_format($frais['montant'],0,',',' '); ?></td>
                            </tr><?php
                          }?>
                          <tfoot>
                              <tr>
                                <th><?=$qtite;?></th>
                                <th colspan="2">Totaux</th>
                                <th style="text-align: right;"><?=number_format($valuep->Total,0,',',' ');?></th>
                              </tr>
                            </tfoot>
                        </table>
                      </div>

                    </td>
                  </tr>
                </tbody><?php
              }?>

              <tfoot>
                <tr>
                  <th colspan="2" style="background-color:green;">Qtité</th>
                  <th style="text-align: center; background-color:green;"><?=$qtitet;?></th>
                  <th colspan="2" style="background-color:green;">Total commandes</th>
                  <th style="text-align: center; background-color:green;"><?=number_format($totc,0,',',' ');?></th>
                </tr>
              </tfoot>

          </table><?php
        }?>
      </div><?php
    }
  }

}else{

  echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

}

}else{

}?>
    
</body>

</html>


