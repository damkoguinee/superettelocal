<?php require 'header.php';

if (!empty($_SESSION['pseudo'])) {

  if ($_SESSION['level']>=6) {
    

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
      $_SESSION['date2'] = new DateTime($_SESSION['date2']);
      $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

      $_SESSION['dates1']=$_SESSION['date1'];
      $_SESSION['dates2']=$_SESSION['date2']; 

        
    }

    if (isset($_POST['j2'])) {

      $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

    }else{

      $datenormale=(new DateTime($dates))->format('d/m/Y');
    }

    require 'headercompta.php';

    if (isset($_POST['clientliv'])) {
      $_SESSION['clientliv']=$_POST['clientliv'];
    }

    if (isset($_POST['numcmd'])) {
      $_SESSION['numcmd']=$_POST['numcmd'];
    }

    if (isset($_GET['searchclient']) ) {

        $_SESSION['searchclientch']=$_GET['searchclient'];
    }

    if (isset($_GET['delete'])) {

      $DB->delete("DELETE from decaissement where numdec='{$_GET['delete']}'");

      $DB->delete("DELETE from banque where numero='{$_GET['delete']}'");

      $DB->delete("DELETE from chequedepasse where numcheque='{$_GET['numcheque']}'");

      $DB->insert("UPDATE modep SET etatcheque = ? WHERE numerocheque = ?", array('nontraite', $_GET['numcheque']));?>

      <div class="alerteV">Chèque Annulé avec succès!!</div><?php 
    }

    if (isset($_GET['id']) or isset($_GET['searchclient'])) {

      if (isset($_GET['id'])) {
        $_SESSION['numchequech']=$_GET['numcheque'];
        $_SESSION['montantch']=$_GET['montant'];
        $_SESSION['caissecheque']=$_GET['caisse'];

        if ($panier->lieuVenteCaisse($_GET['caisse'])[1]=='Banque') {
          $_SESSION['lieuventecaisse']=$_SESSION['lieuvente'];
        }else{
          $_SESSION['lieuventecaisse']=$panier->lieuVenteCaisse($compte)[0];
        }
      }?>

      <form method="post"  action="cheque.php">

        <table class="payement" style="width: 100%;">

          <thead>
            <tr>
              <th class="legende" colspan="7" height="30">Décaissement du Chèque N°: <?=$_SESSION['numchequech'];?></th>  
            </tr>

            <tr>
              <th>Montant décaissé</th>
              <th>Compte à Prélever</th>
              <th>Destinataire</th>
              <th>commentaires</th>
              <th>Date dec</th>              
            </tr>

          </thead>
            
          <tbody>

            <td style="text-align:center; font-size: 22px;"><?=number_format($_SESSION['montantch'],0,',',' ');?>
              <input type="hidden"   name="montant" value="<?=$_SESSION['montantch'];?>">
              <input type="hidden"   name="numcheque" value="<?=$_SESSION['numchequech'];?>">
              <input type="hidden"   name="devise" value="gnf">
              <input type="hidden"   name="mode_payement" value="chèque">
              <input type="hidden"   name="datefact" value="<?=$_GET['datefact'];?>">
            </td>

            <td><select  name="compte" required="">
              <option value="<?=$_SESSION['caissecheque'];?>">Caisse</option>
                </select>               
            </td>

            <td>                           

              <select style="width:200px;" type="text" name="client" required=""><?php

                if (!empty($_SESSION['searchclientch'])) {?>

                    <option value="<?=$_SESSION['searchclientch'];?>"><?=$panier->nomClient($_SESSION['searchclientch']);?></option><?php
                }else{?>
                    <option></option><?php 
                }?>
                <option value="liquidite" style="font-size: 18px;">Chèque->espèces</option><?php

                foreach($panier->client() as $product){?>
                  <option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php
                }?>
              </select>

              <input style="width:200px;" id="search-user" type="text" placeholder="rechercher un client" />

                <div style="color:white; background-color: black; font-size: 16px; margin-left: 300px;" id="result-search"></div>
            </td>
            <td><input type="text" name="coment" maxlength="150" required=""></td>

            <td><input type="date" name="datedep"></td>                              

          </tbody>

        </table><?php

        if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

          <input id="button"  type="submit" name="valid" value="VALIDER" onclick="return alerteV();"><?php

        }else{?>

          <div class="alertes"> CAISSE CLOTUREE OU LA LICENCE EST EXPIREE </div><?php

        }?>
    
      </form><?php
    }


    if (isset($_POST['client']) and isset($_POST['coment'])){                         

      if ($_POST['montant']!="") {

        $numdec = $DB->querys('SELECT max(id) AS id FROM decaissement ');
        $numdec=$numdec['id']+1;
        $dateop=$panier->h($_POST['datedep']);

        $montant=$panier->h($_POST['montant']);
        $devise=$panier->h($_POST['devise']);
        $client=$panier->h($_POST['client']);
        $motif=$panier->h($_POST['coment']);
        $payement=$_POST['mode_payement'];
        $compte=$panier->h($_POST['compte']);
        $numcheque=$panier->h($_POST['numcheque']);

        $prodclient=$DB->querys("SELECT id, typeclient from client where id='{$_POST['client']}'");

        if (empty($dateop)) {

          $DB->insert('INSERT INTO decaissement (numdec, montant, devisedec, payement, numcheque, coment, client, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?,  now())',array('ret'.$numdec, $montant, $devise, $payement, $numcheque, $motif, $client, $compte, $_SESSION['lieuventecaisse']));

          if ($prodclient['typeclient']!='Banque') {

            if ($client!='liquidite') {

              $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($client, -$montant, 'Retrait', 'ret'.$numdec, $devise, $compte, $_SESSION['lieuventecaisse']));
            }
          }

                      
          $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, typep, lieuvente, numeropaie, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($compte, -$montant, "Retrait (".$motif.')', 'ret'.$numdec, $devise, 'cheque', $_SESSION['lieuventecaisse'], $numcheque));

          if ($client=='liquidite') {

            $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, typeent, devise, typep, lieuvente, numeropaie, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($compte, $montant, "liquidite (".$motif.')', 'ret'.$numdec, 'liquidite', 'gnf', 'espèces', $_SESSION['lieuventecaisse'], $numcheque));

          }

          if ($prodclient['typeclient']=='Banque') {

            $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, typep, lieuvente, numeropaie, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($client, $montant, "Retrait (".$motif.')', 'ret'.$numdec, $devise, 'cheque', $_SESSION['lieuvente'], $numcheque));

          }



        }else{

          $DB->insert('INSERT INTO decaissement (numdec, montant, devisedec, payement, numcheque, coment, client, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?,  ?)',array('ret'.$numdec, $montant, $devise, $payement, $numcheque, $motif, $client, $compte, $_SESSION['lieuventecaisse'], $dateop));

          if ($prodclient['typeclient']!='Banque') {

            if ($client!='liquidite') {

              $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($client, -$montant, 'Retrait', 'ret'.$numdec, $devise, $compte, $_SESSION['lieuventecaisse'], $dateop));
            }
          }

                      
          $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, typep, lieuvente, numeropaie, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($compte, -$montant, "Retrait (".$motif.')', 'ret'.$numdec, $devise, 'cheque', $_SESSION['lieuventecaisse'], $numcheque, $dateop));

          if ($client=='liquidite') {

            $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, typeent, devise, typep, lieuvente, numeropaie, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($compte, $montant, "liquidite (".$motif.')', 'ret'.$numdec, 'liquidite', 'gnf', 'espèces', $_SESSION['lieuventecaisse'], $numcheque, $dateop));

          }

          if ($prodclient['typeclient']=='Banque') {

            $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, typep, lieuvente, numeropaie, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($client, $montant, "Retrait (".$motif.')', 'ret'.$numdec, $devise, 'cheque', $_SESSION['lieuvente'], $numcheque, $dateop));

          }

        }

        $datefact=(new dateTime($_POST['datefact']))->format("Ymd");
        $datejour=date("Ymd");

        if ($datefact!=$datejour) {
          $DB->insert('INSERT INTO chequedepasse (numcheque, montant, dateencaissement, id_banque, lieuvente, dateop) VALUES(?, ?, ?, ?, ?, now())',array($numcheque, $montant, $_POST['datefact'], $compte, $_SESSION['lieuventecaisse']));
        }

        $DB->insert("UPDATE modep SET etatcheque = ? WHERE numerocheque = ?", array('traite', $numcheque));

      } else{?>

        <div class="alert">Saisissez tous les champs vides</div><?php

      }


    }else{

    } ?>

    <table class="payement" style="width: 100%;">

      <thead>        
        <tr>

          <form method="POST" action="cheque.php">

            <th style="border-right: 0px;" colspan="3"><?php

              if (isset($_POST['j1'])) {?>

                <input id="reccode" style="width: 120px; font-size: 14px;" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j2'];?>"><?php

              }else{?>

                <input id="reccode" style="width: 120px; font-size: 14px;" type = "date" name = "j1" onchange="this.form.submit()"><?php

              }?>
            </th>
          </form>

          <form method="POST" action="cheque.php">

            <th colspan="2">

              <select name="clientliv" onchange="this.form.submit()" style="width: 300px;"><?php

                if (isset($_POST['clientliv'])) {?>

                  <option value="<?=$_POST['clientliv'];?>"><?=ucwords($panier->nomClient($_POST['clientliv']));?></option><?php

                }else{?>
                  <option></option><?php
                }

                $type1='client';
                $type2='clientf';
                  
                foreach($panier->clientF($type1, $type2) as $product){?>

                  <option value="<?=$product->id;?>"><?=ucwords($product->nom_client);?></option><?php
                }?>
              </select>
            </th>
          </form>

          <form method="POST" action="cheque.php">

            <th colspan="3"><?php

              if (isset($_POST['numcmd'])) {?>

                <input style="width: 200px; font-size: 18px;" type = "text" name = "numcmd" value="<?=$_POST['numcmd'];?>" onchange="this.form.submit()"><?php

              }else{?>

                <input style="width: 250px; font-size: 18px;" type = "text" name = "numcmd" placeholder="rechercher par N° chèque" onchange="this.form.submit()"><?php

              }?>
            </th>
          </form>
        </tr>

        <tr>

          <th class="legende" colspan="9" height="30"><?="Liste des Chèques";?> </th>
        </tr>

        <tr>
          <th>N°</th>
          <th>Date d'entrée</th>
          <th>Nom sur le chèque</th>
          <th>N° Chèque</th>
          <th>Banque Chèque</th>
          <th>Montant</th>
          <th>Date de sortie</th>
          <th>Remis à</th>
          <th>Action</th>
        </tr>

      </thead>

      <tbody><?php 

        $etatliv='nonlivre';
        $cheque='cheque';
        $etat='non traite';
        $caisse=$_SESSION['caisse'];

        if ($_SESSION['level']>6) {
          
          if (isset($_POST['j1'])) {

            $products= $DB->query("SELECT numpaiep, numdec, modep.id as id, modep.montant as montant, modep.client as client, decaissement.client as clientrecep, decaissement.date_payement as datesortie, numerocheque, etatcheque, modep.banquecheque as banquecheque, datefact, caisse FROM modep left join decaissement on numerocheque=numcheque  WHERE modep='{$cheque}' and DATE_FORMAT(datefact, \"%Y-%m-%d \")='{$_POST['j1']}' order by(datefact)");

          }elseif (isset($_POST['clientliv'])) {

            $products= $DB->query("SELECT numpaiep, numdec, modep.id as id, modep.montant as montant, modep.client as client, decaissement.client as clientrecep, decaissement.date_payement as datesortie, numerocheque, etatcheque, modep.banquecheque as banquecheque, datefact, caisse FROM modep left join decaissement on numerocheque=numcheque WHERE  modep='{$cheque}' and modep.client='{$_POST['clientliv']}' order by(datefact)");

          }elseif (isset($_POST['numcmd'])) {

            $products= $DB->query("SELECT numpaiep, numdec, modep.id as id, modep.montant as montant, modep.client as client, decaissement.client as clientrecep, decaissement.date_payement as datesortie, numerocheque, etatcheque, modep.banquecheque as banquecheque, datefact, caisse FROM modep left join decaissement on numerocheque=numcheque WHERE modep='{$cheque}' and numerocheque='{$_POST['numcmd']}' order by(datefact)");

          }else{

            $products= $DB->query("SELECT numpaiep, numdec, modep.id as id, modep.montant as montant, modep.client as client, decaissement.client as clientrecep, decaissement.date_payement as datesortie, numerocheque, etatcheque, modep.banquecheque as banquecheque, datefact, caisse FROM modep left join decaissement on numerocheque=numcheque WHERE modep='{$cheque}' order by(etatcheque) LIMIT 10");
          }
        }else{

          if (isset($_POST['j1'])) {

            $products= $DB->query("SELECT numpaiep, numdec, modep.id as id, modep.montant as montant, modep.client as client, decaissement.client as clientrecep, decaissement.date_payement as datesortie, numerocheque, etatcheque, modep.banquecheque as banquecheque, datefact, caisse FROM modep left join decaissement on numerocheque=numcheque  WHERE caisse='{$caisse}' and modep='{$cheque}' and DATE_FORMAT(datefact, \"%Y-%m-%d \")='{$_POST['j1']}' order by(datefact)");

          }elseif (isset($_POST['clientliv'])) {

            $products= $DB->query("SELECT numpaiep, numdec, modep.id as id, modep.montant as montant, modep.client as client, decaissement.client as clientrecep, decaissement.date_payement as datesortie, numerocheque, etatcheque, modep.banquecheque as banquecheque, datefact, caisse FROM modep left join decaissement on numerocheque=numcheque WHERE caisse='{$caisse}' and modep='{$cheque}' and modep.client='{$_POST['clientliv']}' order by(datefact)");

          }elseif (isset($_POST['numcmd'])) {

            $products= $DB->query("SELECT numpaiep, numdec, modep.id as id, modep.montant as montant, modep.client as client, decaissement.client as clientrecep, decaissement.date_payement as datesortie, numerocheque, etatcheque, modep.banquecheque as banquecheque, datefact, caisse FROM modep left join decaissement on numerocheque=numcheque WHERE caisse='{$caisse}' and modep='{$cheque}' and numerocheque='{$_POST['numcmd']}' order by(datefact)");

          }else{

            $products= $DB->query("SELECT numpaiep, numdec, modep.id as id, modep.montant as montant, modep.client as client, decaissement.client as clientrecep, decaissement.date_payement as datesortie, numerocheque, etatcheque, modep.banquecheque as banquecheque, datefact, caisse FROM modep left join decaissement on numerocheque=numcheque WHERE caisse='{$caisse}' and  modep='{$cheque}' order by(etatcheque) LIMIT 10");
          }
        }

        $totqtite=0;
        $totqtitet=0;

        foreach ($products as $key=> $product ){

          if ($product->etatcheque=='traite') {
            $color='green';
            $totqtitet+=$product->montant;
            //$totqtite=0;
          }else{
            $color='';
            $totqtite+=$product->montant;
            //$totqtitet=0;
          }?>

          <tr>
            <td style="text-align: center; color: <?=$color;?>;"><?= $key+1; ?></td>

            <td style="text-align:center; color: <?=$color;?>;"><?=(new DateTime($product->datefact))->format('d/m/Y'); ?></td>

            <td style="color: <?=$color;?>;"><?=$panier->nomClient($product->client); ?></td>

            <td style="text-align: center; color: <?=$color;?>;"><?= $product->numerocheque; ?></td>

            <td style="text-align: left; color: <?=$color;?>;"><?=$product->banquecheque;?></td>                  

            <td style="text-align: right; padding-right: 10px; color: <?=$color;?>;"><?=number_format($product->montant,0,',',' ');?></td>

            <td style="text-align:center; color: <?=$color;?>;"><?php if ($product->etatcheque=='traite') {?><?=(new DateTime($product->datesortie))->format('d/m/Y'); ?><?php }?></td>

            <td style="color: <?=$color;?>;"><?=$panier->nomClient($product->clientrecep); ?></td>             

            <td><?php if ($product->etatcheque!='traite'){?><a href="cheque.php?id=<?=$product->id;?>&numcheque=<?=$product->numerocheque;?>&montant=<?=$product->montant;?>&datefact=<?=$product->datefact;?>&caisse=<?=$product->caisse;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: orange;color: white; cursor: pointer;"  type="submit" value="Décaisser" onclick="return alerteL();"></a><?php }else{
              ?><a href="cheque.php?delete=<?=$product->numdec;?>&idelete=<?=$product->id;?>&numcheque=<?=$product->numerocheque;?>&montant=<?=$product->montant;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Annuler" onclick="return alerteA();"></a><?php
            }?></td>
          </tr><?php 
        }?>

      </tbody>

      <tfoot>
        <tr>
          <th colspan="4">Totaux Chèques</th>
          <th style="text-align: right; padding-right: 10px;">Non Traités: <?= number_format($totqtite,0,',',' ');?></th>
          <th style="text-align: right; padding-right: 10px;">Traités: <?= number_format($totqtitet,0,',',' ');?></th>
        </tr>
      </tfoot>

    </table><?php 
  }
}?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <script>
      $(document).ready(function(){
          $('#search-user').keyup(function(){
              $('#result-search').html("");

              var utilisateur = $(this).val();

              if (utilisateur!='') {
                  $.ajax({
                      type: 'GET',
                      url: 'recherche_utilisateur.php?clientcheq',
                      data: 'user=' + encodeURIComponent(utilisateur),
                      success: function(data){
                          if(data != ""){
                            $('#result-search').append(data);
                          }else{
                            document.getElementById('result-search').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
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

  function alerteA(){
    return(confirm('Confirmez-vous cette opération'));
  }

  function alerteM(){
    return(confirm('Voulez-vous vraiment modifier cette vente?'));
  }

  function focus(){
    document.getElementById('reccode').focus();
  }
</script>