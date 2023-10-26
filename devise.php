<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

  require 'navdevise.php';

  if (!isset($_POST['taux'])) {

    if (isset($_GET['vente'])) {
      $_SESSION['motifdev']='vente devise';
    }else{
      $_SESSION['motifdev']='achat devise';
    }
  }
  

  if ($products['level']>=3) {

    if (isset($_GET['deletevers'])) {

      $numero=$_GET['deletevers'];
      $DB->delete('DELETE FROM devisevente WHERE numcmd = ?', array($numero));

      $DB->delete('DELETE FROM bulletin WHERE numero = ?', array($numero));

      $DB->delete('DELETE FROM banque WHERE numero = ?', array($numero));?>

        <div class="alerteV">LE VERSEMENT A BIEN ETE SUPPRIME</div><?php
    }

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

    if (isset($_GET['ajoutdev']) or isset($_POST['taux'])) {?>

      <form id="naissance" method="POST" action="devise.php" style="margin-top: 0px; width:90%;" >

        <fieldset><legend style="color:orange;"><?=ucwords($_SESSION['motifdev']);?></legend>
          <ol><?php 

            if (isset($_POST['taux'])) {
              $montant=$panier->espace($_POST['montant']);
              $taux=$panier->espace($_POST['taux']);
              $converti=$montant*$taux;?>

              <li><label>Montant Devise</label><input style="font-size: 22px;" type="text" name="montant" value="<?=$panier->formatNombre($montant);?>" onchange="this.form.submit()" required=""><input type="hidden" name="motif" value="<?=$_SESSION['motifdev'];?>"></li>

              <li><label>Devise</label><select type="number" name="devise" onchange="this.form.submit()" value="<?=$panier->formatNombre($_POST['devise']);?>" required="">
                <option value="<?=$_POST['devise'];?>"><?=strtoupper($_POST['devise']);?></option><?php 
                foreach ($panier->monnaie as $valuem) {?>
                    <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                }?></select>
              </li>

              <li><label>Taux</label><input style="font-size: 22px;" type="number" name="taux" value="<?=$taux;?>" onchange="this.form.submit()" required=""></li>

              <li style="font-size:22px; color:green;"><label>Montant Converti : </label><?=$panier->formatNombre($converti);?></li><?php 

            }else{?>

              <li><label>Montant Devise</label><input style="font-size: 22px;" type="number" name="montant" min="0" required="" placeholder="entrer le montant en devise"><input type="hidden" name="motif" value="<?=$_SESSION['motifdev'];?>"></li>

              <li><label>Devise</label><select type="number" name="devise" required="">
                <option value=""></option><?php 
                foreach ($panier->monnaie as $valuem) {?>
                    <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                }?></select>
              </li>

              <li><label>Taux</label><input style="font-size: 22px;" type="number" name="taux" min="0" onchange="this.form.submit()" required=""></li><?php

            }?>

            <li><label>Type de Paiement</label><select name="mode_payement" required="" >
              <option value=""></option><?php 
              foreach ($panier->modep as $value) {?>
                  <option value="<?=$value;?>"><?=$value;?></option><?php 
              }?></select>
            </li>

            <li><label>Compte Utilisé</label><select  name="compte" required="">
              <option></option><?php
                $type='Banque';

                foreach($panier->nomBanque() as $product){?>

                  <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                }?>
              </select>
            </li>

            <li><label>Date Opération</label><input type="date" name="datedep"></li>

            <li><label>Nom du Client</label><input type="text" name="client" required=""></li>
          </fieldset>

          <fieldset style="margin-top:-30px;">

            <input type="submit" value="Valider" name="validevise" id="form" onclick="return alerteV();" style="margin-left: 20px; width:150px; cursor: pointer;" />

          </fieldset> 

        
        </form> <?php
      }

      if (isset($_POST["validevise"])) {

        if (empty($_POST["client"]) OR empty($_POST["montant"]) or empty($_POST['devise']) OR empty($_POST["motif"])) {?>

          <div class="alertes">Les Champs sont vides</div><?php

        }else{

          $montant=$panier->espace($panier->h($_POST['montant']));
          $devise=$panier->h($_POST['devise']);
          $client=$panier->h($_POST['client']);
          $motif=$panier->h($_POST['motif']);
          $payement=$_POST['mode_payement'];
          $compte=$panier->h($_POST['compte']);
          $taux=$panier->espace($panier->h($_POST['taux']));
          $convert=$montant*$taux;

          $maximum = $DB->querys('SELECT max(id) AS max_id FROM devisevente');

          $max=$maximum['max_id']+1;
          $dateop=$_POST['datedep'];

          if (empty($dateop)) {

            if ($motif=='achat devise') {

              if (($convert)>$panier->montantCompteBil($compte, 'gnf')) {?>

                <div class="alertes">Echec Montant à décaisser est insuffisant</div><?php

              }else{

                $DB->insert('INSERT INTO devisevente (numcmd, client, montant, devise, taux, motif, typep, compte, lieuvente, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array('devisea'.$max, $client, $montant, $devise, $taux, $motif, $payement, $compte, $_SESSION['lieuvente']));                      

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($compte, $montant, "devisea(".$motif.')', 'devisea'.$max, $devise, $_SESSION['lieuvente']));

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($compte, -$convert, "devisea(".$motif.')', 'devisea'.$max, 'gnf', $_SESSION['lieuvente']));
              }

            }else{

              if (($montant)>$panier->montantCompteBil($compte, $devise)) {?>

                <div class="alertes">Echec Montant à décaisser est insuffisant</div><?php

              }else{

                $DB->insert('INSERT INTO devisevente (numcmd, client, montant, devise, taux, motif, typep, compte, lieuvente, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array('devisev'.$max, $client, $montant, $devise, $taux, $motif, $payement, $compte, $_SESSION['lieuvente']));                      

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($compte, -$montant, "devisev(".$motif.')', 'devisev'.$max, $devise, $_SESSION['lieuvente']));

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($compte, $convert, "devisev(".$motif.')', 'devisev'.$max, 'gnf', $_SESSION['lieuvente']));
              }

            }

          }else{

            if ($motif=='achat devise') {

              if (($convert)>$panier->montantCompteBil($compte, 'gnf')) {?>

                <div class="alertes">Echec Montant à décaisser est insuffisant</div><?php

              }else{

                $DB->insert('INSERT INTO devisevente (numcmd, client, montant, devise, taux, motif, typep, compte, lieuvente, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array('devisea'.$max, $client, $montant, $devise, $taux, $motif, $payement, $compte, $_SESSION['lieuvente'], $dateop));                      

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?)', array($compte, $montant, "devisea(".$motif.')', 'devisea'.$max, $devise, $_SESSION['lieuvente'], $dateop));

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?)', array($compte, -$convert, "devisea(".$motif.')', 'devisea'.$max, 'gnf', $_SESSION['lieuvente'], $dateop));
              }

            }else{

              if (($montant)>$panier->montantCompteBil($compte, $devise)) {?>

                <div class="alertes">Echec Montant à décaisser est insuffisant</div><?php

              }else{

                $DB->insert('INSERT INTO devisevente (numcmd, client, montant, devise, taux, motif, typep, compte, lieuvente, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array('devisev'.$max, $client, $montant, $devise, $taux, $motif, $payement, $compte, $_SESSION['lieuvente'], $dateop));                      

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?)', array($compte, -$montant, "devisev(".$motif.')', 'devisev'.$max, $devise, $_SESSION['lieuvente'], $dateop));

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?)', array($compte, $convert, "devisev(".$motif.')', 'devisev'.$max, 'gnf', $_SESSION['lieuvente'], $dateop));
              }

            }
          }

          if (isset($_POST["valid"])) {
                  
            $_SESSION['reclient']=$client;
            $_SESSION['nameclient']=$client;

            //header("Location:printversement.php");
      
          }

        }

      }else{

        
      }

      if (!isset($_GET['ajoutdev'])) {

        if (!empty($_SESSION['motifdev']) and $_SESSION['motifdev']=='vente devise') {?> 

          <div style="display:flex;">
            <div>

              <table class="payement">

                <thead>

                  <tr>
                    <form method="POST" action="devise.php?vente" id="suitec" name="termc">

                      <th colspan="3" ><?php

                        if (isset($_POST['j1'])) {?>

                          <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php

                        }else{?>

                          <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()"><?php

                        }

                        if (isset($_POST['j2'])) {?>

                          <input style="width:150px;" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php

                        }else{?>

                          <input style="width:150px;" type = "date" name = "j2" onchange="this.form.submit()"><?php

                        }?>
                      </th>
                    </form>
                  <th class="legende" colspan="8" height="30"><?="Liste des Ventes Devise ".$datenormale;?> <a href="devise.php?ajoutdev&vente" style="color:orange;">Effectuer une Vente</a></th>
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Date Op</th>
                  <th>Client</th>              
                  <th>Montant €</th>
                  <th>Montant $</th>
                  <th>Montant CFA</th>
                  <th>Taux</th>     
                  <th>Montant GNF</th>
                  <th>T. P</th>              
                  <th>Justif</th>
                  <th></th>
                </tr>

              </thead>

              <tbody><?php 
                $cumulmontant=0;
                $cumulmontantgnf=0;

                $montantgnf=0;
                $montanteu=0;
                $montantus=0;
                $montantcfa=0;
                if (isset($_POST['j1'])) {

                  $products= $DB->query('SELECT *FROM devisevente WHERE lieuvente=? and DATE_FORMAT(dateop, \'%Y%m%d\')>=? and DATE_FORMAT(dateop, \'%Y%m%d\')<=? and motif=? order by(dateop) LIMIT 50', array($_SESSION['lieuvente'], $_SESSION['date1'], $_SESSION['date2'], 'vente devise'));

                }else{

                  $products= $DB->query('SELECT *FROM devisevente  WHERE lieuvente=? and YEAR(dateop) =? and motif=? order by(dateop) LIMIT 50', array($_SESSION['lieuvente'], date('Y'), 'vente devise'));
                }
                
                $soldegnf=0;
                $soldeeu=0;
                $soldeus=0;
                $soldecfa=0;
                foreach ($products as $key=> $product ){

                  $cumulmontant+=$product->montant;
                  $cumulmontantgnf+=$product->montant*$product->taux; ?>

                  <tr>
                    <td style="text-align: center;"><?= $key+1; ?></td>

                    <td style="text-align: center;"><?=(new DateTime($product->dateop))->format("d/m/Y à H:i");?></td>

                    <td><?= ucwords(strtolower($product->client)); ?></td><?php

                    if ($product->devise=='eu') {

                      $montanteu+=$product->montant;?>

                      <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,2,',',' '); ?></td>

                      <td></td>
                      <td></td><?php

                    }elseif ($product->devise=='us') {

                      $montantus+=$product->montant;?>

                      <td></td>

                      <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,2,',',' '); ?></td>

                      <td></td><?php

                    }elseif ($product->devise=='cfa') {

                      $montantcfa+=$product->montant;?>
                      
                      <td></td>

                      <td></td>

                      <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,2,',',' '); ?></td><?php

                    }?> 

                    <td style="text-align: right; padding-right: 10px;"><?=number_format($product->taux,2,',',' ');?></td>

                    <td style="text-align: right; padding-right: 10px;"><?=number_format($product->montant*$product->taux,2,',',' ');?></td>  

                    <td><?= $product->typep; ?></td>

                     <td style="text-align: center">

                        <a href="printdevise.php?numdec=<?=$product->id;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>
                      </td>

                    <td><a href="devise.php?deletevers=<?=$product->numcmd;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a></td>
                  </tr><?php 
                }?>

              </tbody>

              <tfoot>
                <tr>
                  <th colspan="3">Totaux</th>
                  <th style="text-align: right; padding-right: 10px;"><?= number_format($montanteu,2,',',' ');?></th>
                  <th style="text-align: right; padding-right: 10px;"><?= number_format($montantus,2,',',' ');?></th>
                  <th style="text-align: right; padding-right: 10px;"><?= number_format($montantcfa,2,',',' ');?></th>
                  <th></th>
                  <th style="text-align: right padding-right: 10px;;"><?= number_format($cumulmontantgnf,2,',',' ');?></th>
                </tr>
              </tfoot>

            </table>
          </div>
        </div><?php

        }else{?>

          <div style="display: flex;">
            <div>

              <table class="payement">

                <thead>

                  <tr>
                    <form method="POST" action="devise.php?achat" id="suitec" name="termc">

                      <th colspan="3" ><?php

                        if (isset($_POST['j1'])) {?>

                          <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php

                        }else{?>

                          <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()"><?php

                        }

                        if (isset($_POST['j2'])) {?>

                          <input style="width:150px;" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php

                        }else{?>

                          <input style="width:150px;" type = "date" name = "j2" onchange="this.form.submit()"><?php

                        }?>
                      </th>
                    </form>
                  <th class="legende" colspan="8" height="30"><?="Liste des Achat Devise ".$datenormale;?> <a href="devise.php?ajoutdev&achat" style="color:orange;">Effectuer un Achat</a></th>
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Date Op</th>
                  <th>Client</th>              
                  <th>Montant €</th>
                  <th>Montant $</th>
                  <th>Montant CFA</th>
                  <th>Taux</th>     
                  <th>Montant GNF</th>
                  <th>T. P</th>              
                  <th>Justif</th>
                  <th></th>
                </tr>

              </thead>

              <tbody><?php 
                $cumulmontant=0;
                $cumulmontantgnf=0;

                $montantgnf=0;
                $montanteu=0;
                $montantus=0;
                $montantcfa=0;
                if (isset($_POST['j1'])) {

                  $products= $DB->query('SELECT *FROM devisevente WHERE lieuvente=? and DATE_FORMAT(dateop, \'%Y%m%d\')>=? and DATE_FORMAT(dateop, \'%Y%m%d\')<=? and motif=? order by(dateop) LIMIT 50', array($_SESSION['lieuvente'], $_SESSION['date1'], $_SESSION['date2'], 'achat devise'));

                }else{

                  $products= $DB->query('SELECT *FROM devisevente  WHERE lieuvente=? and YEAR(dateop) =? and motif=? order by(dateop) LIMIT 50', array($_SESSION['lieuvente'], date('Y'), 'achat devise'));
                }
                
                $soldegnf=0;
                $soldeeu=0;
                $soldeus=0;
                $soldecfa=0;
                foreach ($products as $key=> $product ){

                  $cumulmontant+=$product->montant;
                  $cumulmontantgnf+=$product->montant*$product->taux; ?>

                  <tr>
                    <td style="text-align: center;"><?= $key+1; ?></td>

                    <td style="text-align: center;"><?=(new DateTime($product->dateop))->format("d/m/Y à H:i");?></td>

                    <td><?= ucwords(strtolower($product->client)); ?></td><?php

                    if ($product->devise=='eu') {

                      $montanteu+=$product->montant;?>

                      <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,2,',',' '); ?></td>

                      <td></td>
                      <td></td><?php

                    }elseif ($product->devise=='us') {

                      $montantus+=$product->montant;?>

                      <td></td>

                      <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,2,',',' '); ?></td>

                      <td></td><?php

                    }elseif ($product->devise=='cfa') {

                      $montantcfa+=$product->montant;?>
                      
                      <td></td>

                      <td></td>

                      <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,2,',',' '); ?></td><?php

                    }?> 

                    <td style="text-align: right; padding-right: 10px;"><?=number_format($product->taux,2,',',' ');?></td>

                    <td style="text-align: right; padding-right: 10px;"><?=number_format($product->montant*$product->taux,2,',',' ');?></td>  

                    <td><?= $product->typep; ?></td>

                     <td style="text-align: center">

                        <a href="printdevise.php?numdec=<?=$product->id;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>
                      </td>

                    <td><a href="devise.php?deletevers=<?=$product->numcmd;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a></td>
                  </tr><?php 
                }?>

              </tbody>

              <tfoot>
                <tr>
                  <th colspan="3">Totaux</th>
                  <th style="text-align: right; padding-right: 10px;"><?= number_format($montanteu,2,',',' ');?></th>
                  <th style="text-align: right; padding-right: 10px;"><?= number_format($montantus,2,',',' ');?></th>
                  <th style="text-align: right; padding-right: 10px;"><?= number_format($montantcfa,2,',',' ');?></th>
                  <th></th>
                  <th style="text-align: right padding-right: 10px;;"><?= number_format($cumulmontantgnf,2,',',' ');?></th>
                </tr>
              </tfoot>

            </table>
          </div>
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
