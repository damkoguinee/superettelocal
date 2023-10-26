<?php
require 'header.php';
if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

  if (isset($_GET['deleteret'])) {

    $DB->delete("DELETE from banque where numero='{$_GET['deleteret']}'");

    $DB->delete("DELETE from transferfond where numero='{$_GET['deleteret']}'");?>

    <div class="alerteV">Transfert des fonds annulés avec succèe!!</div><?php 
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

  if (isset($_POST['clientliv'])) {
    $_SESSION['clientliv']=$_POST['clientliv'];
  }

  if ($products['level']>=3) {

    if (isset($_POST['valid'])) {

      $montant=$_POST['montant'];
      $compteret=$_POST['compteret'];
      $comptedep=$_POST['comptedep'];
      $devise=$_POST['devise'];
      $coment=$_POST['coment'];
      $dateop=$_POST['dateop'];

      $lieuventeret=$panier->lieuVenteCaisse($compteret)[0];

      $lieuventedep=$panier->lieuVenteCaisse($comptedep)[0];

      $numdec = $DB->querys('SELECT max(id) AS id FROM banque ');
      $numdec=$numdec['id']+1;

      if (empty($dateop)) {

        if ($compteret!='autresret') {

          $DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['compteret'], 'transfert', -$montant, $devise, 'retrait(transfert des fonds)', $numdec, $lieuventeret));
        }

        if ($compteret!='autresdep') {

          $DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['comptedep'], 'transfert', $montant, $devise, 'depot(transfert des fonds)', $numdec, $lieuventedep));
        }

        $DB->insert('INSERT INTO transferfond (numero, caissedep, montant, caisseret, devise, exect, lieuvente, coment, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($numdec, $_POST['comptedep'], $montant, $_POST['compteret'], $devise, $_SESSION['idpseudo'],  $lieuventeret, $coment));

      }else{

        if ($compteret!='autresret') {

          $DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compteret'], 'transfert', -$montant, $devise, 'retrait(transfert des fonds)', $numdec, $lieuventeret, $dateop));
        }

        if ($compteret!='autresdep') {

          $DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['comptedep'], 'transfert', $montant, $devise, 'depot(transfert des fonds)', $numdec, $lieuventedep, $dateop));
        }

        $DB->insert('INSERT INTO transferfond (numero, caissedep, montant, caisseret, devise, exect, lieuvente, coment, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numdec, $_POST['comptedep'], $montant, $_POST['compteret'], $devise, $_SESSION['idpseudo'], $lieuventeret, $coment, $dateop));
      }

      unset($_GET);
      unset($_POST);
      
    }

    if (isset($_GET['ajout']) or isset($_GET['searchclient']) ) {?>

      <form id="naissance" method="POST" action="banque.php" style="width: 70%; margin-top:10px;" >

        <fieldset><legend>Enregistrer un transfert des fonds  <a style="margin-left: 30px; color:white; font-size:18px;" href="banque.php">Retour à la liste des transferts</a></legend>
          <ol>

            <div style="display: flex;">
              <div style="width: 50%;">

                <li><label>Montant*</label><input id="numberconvert" type="number"   name="montant" min="0" required="" style="font-size: 25px; width: 50%;"></li>
              </div>

              <li style="width:50%;"><label style="width:50%;"><div style="color:white; background-color: grey; font-size: 25px; color: orange; width:100%;" id="convertnumber"></div></li></label>
            </div>

            <li><label>Compte de Retraît*</label>
              <select  name="compteret" required="">
                <option></option><?php
                $type='Banque';

                foreach($panier->nomBanqueCaisseFiltre() as $product){?>

                  <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                }

                foreach($panier->nomBanqueVire() as $product){?>

                  <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                }?>
                <option value="autresret">Autres</option>
              </select>
            </li>

            <li><label>Compte de Dépôt*</label>
              <select  name="comptedep" required="">
                <option></option><?php
                $type='Banque';

                foreach($panier->nomBanqueCaisseFiltre() as $product){?>

                  <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                }

                foreach($panier->nomBanqueVire() as $product){?>

                  <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                }?>

                <option value="autresdep">Autres</option>
              </select>
            </li>

            <li><label>Devise*</label>
              <select name="devise" required="" >
                <option value=""></option><?php 
                foreach ($panier->monnaie as $valuem) {?>
                    <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                }?>
              </select>
            </li>

            <li><label>Commentaires*</label><input type="text" name="coment" required=""></li>

            <li><label>Date</label><input type="date" name="dateop"></li>
          </ol>
        </fieldset>

        <fieldset><?php

          if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

            <input id="button"  type="submit" name="valid" value="VALIDER" onclick="return alerteV();" style="margin-left: 20px; margin-top: -20px; width:150px; cursor: pointer; color: black;"><?php

          }else{?>

            <div class="alertes"> CAISSE CLOTUREE OU LA LICENCE EST EXPIREE </div><?php

          }?> 
        </fieldset>       
      </form> <?php
    }  

    if (!isset($_GET['ajout'])) {?> 

      <table class="payement" style="width: 100%;">

        <thead>
          <tr><th colspan="9" height="30"><?="Liste des Transferts des fonts " .$datenormale ?> <a href="banque.php?ajout" style="color:orange;">Effectuer un transfert des fonds</a></th></tr>
          <tr>
            <form method="POST" action="banque.php" id="suitec" name="termc">

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

            <form method="POST" action="banque.php">

              <th colspan="6">

                <select name="clientliv" onchange="this.form.submit()" style="width: 300px;"><?php

                  if (isset($_POST['clientliv'])) {?>

                    <option value="<?=$_POST['clientliv'];?>"><?=ucwords($panier->nomBanquefecth($_POST['clientliv']));?></option><?php

                  }else{?>
                    <option></option><?php
                  }

                  foreach($panier->nomBanqueCaisseFiltre() as $product){?>

                    <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                  }

                  foreach($panier->nomBanqueVire() as $product){?>

                    <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                  }?>
                </select>
              </th>
            </form>

            
          </tr>
          
          <tr>
            <th>N°</th>
            <th>Date</th>
            <th>Commenataires</th>
            <th>Désignation</th>
            <th>Montant GNF</th>
            <th>Montant $</th>
            <th>Montant €</th>
            <th>Montant CFA</th>
            <th></th>              
          </tr>

        </thead>

        <tbody><?php 
          $typeent='transfert';

          if (isset($_POST['j1'])) {            

            $products= $DB->query("SELECT * FROM transferfond WHERE  lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\")>= '{$_SESSION['date1']}' and DATE_FORMAT(dateop, \"%Y%m%d\")<= '{$_SESSION['date2']}' order by(dateop) LIMIT 50");

          }elseif (isset($_POST['clientliv'])) {
            $banque=$_POST['clientliv'];
            $products= $DB->query("SELECT *FROM transferfond WHERE lieuvente='{$_SESSION['lieuvente']}' and caissedep='{$banque}' order by(dateop) LIMIT 50");

          }else{
            $annee=date('Y');

            if ($_SESSION['level']>6) {
              $products= $DB->query("SELECT *FROM transferfond  WHERE  YEAR(dateop) = '{$annee}' order by(dateop) LIMIT 50");
            }else{
              $products= $DB->query("SELECT *FROM transferfond  WHERE lieuvente='{$_SESSION['lieuvente']}' and YEAR(dateop) = '{$annee}' order by(dateop) LIMIT 50");
            }
            
          }

        $montantgnf=0;
        $montanteu=0;
        $montantus=0;
        $montantcfa=0;
        $virement=0;
        $cheque=0;
        foreach ($products as $keyv=> $product ){

          if ($product->caissedep=='autresdep') {
            $caissedep='autres';
          }else{
            $caissedep=$panier->nomBanquefecth($product->caissedep);
          }

          if ($product->caisseret=='autresret') {
            $caisseret='autres';
          }else{
            $caisseret=$panier->nomBanquefecth($product->caisseret);
          } ?>

          <tr>
            <td style="text-align: center;"><?= $keyv+1; ?></td>
            <td style="text-align:center;"><?=$panier->formatDate($product->dateop); ?></td>
            <td><?=$product->coment;?></td>
            <td>Transfert des fonds <?=$caisseret;?> --> <?=$caissedep;?></td><?php

            if ($product->devise=='gnf') {

                $montantgnf+=$product->montant;?>

                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                <td></td>
                <td></td>
                <td></td><?php

              }elseif ($product->devise=='us') {
                $montantus+=$product->montant;?>

                <td></td>
                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                <td></td>
                <td></td><?php
              }elseif ($product->devise=='eu') {
                $montanteu+=$product->montant;?>

                <td></td>
                <td></td>
                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                <td></td><?php
              }elseif ($product->devise=='cfa') {
                $montantcfa+=$product->montant;?>

                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td><?php

              }?>

              <td><a href="banque.php?deleteret=<?=$product->numero;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Annuler" onclick="return alerteS();"></a></td>
              
            </tr><?php 
        }?>

        </tbody>

      </table> <?php
    }

  }else{

    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

  }

}else{

}?>
    
</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#numberconvert').keyup(function(){
            $('#convertnumber').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'convertnumber.php?convert',
                    data: 'user=' + encodeURIComponent(utilisateur),
                    success: function(data){
                        if(data != ""){
                          $('#convertnumber').append(data);
                        }else{
                          document.getElementById('convertnumber').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                        }
                    }
                })
            }
      
        });
    });
  </script> 

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
