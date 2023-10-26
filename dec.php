<?php require 'header.php';

if (!empty($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];


    if ($products['level']>=3) {

        if (isset($_GET['deleteret'])) {

          $DB->delete("DELETE from decaissement where numdec='{$_GET['deleteret']}'");

          $DB->delete("DELETE from bulletin where numero='{$_GET['deleteret']}'");

          $DB->delete("DELETE from banque where numero='{$_GET['deleteret']}'");?>

          <div class="alerteV">Suppression reussi!!</div><?php 
        }

        if (!isset($_POST['magasin'])) {

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
        }

        if (isset($_POST['j2'])) {

          $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

        }else{

          $datenormale=(new DateTime($_SESSION['date']))->format('d/m/Y');
        }

        if (isset($_POST['clientliv'])) {
          $_SESSION['clientliv']=$_POST['clientliv'];
        }

        require 'navdec.php';

        if (isset($_GET['ajout']) or isset($_GET['searchclient']) ) {

            if (isset($_GET['searchclient']) ) {

                $_SESSION['searchclient']=$_GET['searchclient'];
            }?>

       
            <form id="naissance" method="POST" action="dec.php" style="margin-top: 0px; width:90%; margin-top:10px;" >

                <fieldset><legend style="color:orange;">Effectuez un dépôt</legend>
                    <ol>

                      <li><label>Destinataire*</label>                           

                          <select type="text" name="client"><?php 

                            if (!empty($_SESSION['searchclient'])) {?>

                                <option value="<?=$_SESSION['searchclient'];?>"><?=$panier->nomClient($_SESSION['searchclient']);?></option><?php
                            }else{?>
                                <option></option><?php 
                            }

                            foreach($panier->client() as $product){?>
                              <option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php
                            }?>
                          </select>

                          <input style="width:400px;" id="search-user" type="text" placeholder="rechercher un collaborateur" />

                            <div style="color:white; background-color: black; font-size: 16px; margin-left: 300px;" id="result-search"></div>

                        </li>

                        <div style="display: flex;">
                          <div style="width: 50%;">

                            <li><label>Montant Décaissé*</label><input id="numberconvert" type="number"   name="montant" min="0" required="" style="font-size: 25px; width: 50%;"></li>
                          </div>

                          <li style="width:50%;"><label style="width:50%;"><div style="color:white; background-color: grey; font-size: 25px; color: orange; width:100%;" id="convertnumber"></div></li></label>
                        </div>

                        <li><label>Devise*</label>
                          <select name="devise" required="" ><?php 
                            foreach ($panier->monnaie as $valuem) {?>
                                <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                            }?>
                          </select>
                        </li> 

                        <li><label>Mode de Payement*</label>
                          <select name="mode_payement" required="" ><?php 
                            foreach ($panier->modep as $value) {?>
                              <option value="<?=$value;?>"><?=$value;?></option><?php 
                            }?>
                          </select>
                        </li>

                        <li><label>N°Chèque</label><input type="text" name="numcheque"><div style="color: red;"><?php if (isset($_POST['numcheque']) ) {?><?=$_SESSION['alertescheque'];?><?php };?></div></li>

                        <li><label>Banque Chèque</label>
                          <select type="text" name="banquecheque" style="width: 25%;">
                            <option></option>
                            <option value="ecobank">Ecobank</option>
                            <option value="bicigui">Bicigui</option>
                            <option value="bsic">Bsic</option>
                            <option value="uba">UBA</option>
                            <option value="banque islamique">Banque islamique</option>
                            <option value="skye bank">Skye Banq</option>
                            <option value="bci">BCI</option>
                            <option value="fbn">FBN</option>
                            <option value="societe generale">Société Générale</option>
                            <option value="orabank">Orabank</option>
                          </select>
                        </li>           

                        <li><label>Compte à Prélever*</label>
                          <select  name="compte" required=""><?php
                              $type='Banque';

                           foreach($panier->nomBanqueCaisseFiltre() as $product){?>

                              <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                            }

                            foreach($panier->nomBanqueVire() as $product){?>

                              <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                            }?>
                          </select>
                        </li>                        

                        <li><label>Commentaires*</label><input type="text" name="coment" required=""></li>

                        <li><label>Date de dépôt</label><input type="date" name="datedep"></li>
                    </ol>
                 </fieldset>

                <fieldset><?php
                    
                  if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

                    <input id="form"  type="submit" name="valid" value="VALIDER" onclick="return alerteV();" style="margin-left: 20px; margin-top: -20px; width:150px; cursor: pointer;"><?php

                  }else{?>

                    <div class="alertes"> Journée cloturée ou la licence est expirée </div><?php

                  }?>
                </fieldset> 
            </form><?php 
        }


        if (isset($_POST['valid'])){

            if (empty($_POST["client"]) OR empty($_POST["montant"]) or empty($_POST['devise'])) {?>

                <div class="alertes">Les Champs sont vides</div><?php

            }elseif ($_POST['montant']<0){?>

                <div class="alertes">FORMAT INCORRECT</div><?php

            }elseif ($_POST['montant']>$panier->montantCompteBil($_POST['compte'], $_POST['devise'])) {?>

                <div class="alertes">Echec montant decaissé est > au montant disponible en caisse</div><?php

            }else{                          

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
                    $banquecheque=$panier->h($_POST['banquecheque']);

                    if ($panier->lieuVenteCaisse($compte)[1]=='Banque') {
                      $lieuventeret=$_SESSION['lieuvente'];
                    }else{
                      $lieuventeret=$panier->lieuVenteCaisse($compte)[0];
                    }

                    $prodclient=$DB->querys("SELECT id, typeclient from client where id='{$_POST['client']}'");

                    if (empty($dateop)) {

                        $DB->insert('INSERT INTO decaissement (numdec, montant, devisedec, payement, numcheque, banquecheque, coment, client, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  now())',array('ret'.$numdec, $montant, $devise, $payement, $numcheque, $banquecheque, $motif, $client, $compte, $lieuventeret));

                        if ($prodclient['typeclient']!='Banque') {

                            $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($client, -$montant, 'Retrait ('.$motif.')', 'ret'.$numdec, $devise, $compte, $lieuventeret));
                        }

                        
                        $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($compte, -$montant, "Retrait (".$motif.')', 'ret'.$numdec, $devise, $lieuventeret, $numcheque, $banquecheque));

                        if ($prodclient['typeclient']=='Banque') {

                            $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($prodclient['id'], $montant, "Retrait (".$motif.')', 'ret'.$numdec, $devise, $lieuventeret, $numcheque, $banquecheque));

                        }

                        unset($_SESSION['searchclient']);



                    }else{

                        $DB->insert('INSERT INTO decaissement (numdec, montant, devisedec, payement, numcheque, banquecheque, coment, client, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  ?)',array('ret'.$numdec, $montant, $devise, $payement, $numcheque, $banquecheque, $motif, $client, $compte, $lieuventeret, $dateop));

                        if ($prodclient['typeclient']!='Banque') {

                            $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($client, -$montant, 'Retrait ('.$motif.')', 'ret'.$numdec, $devise, $compte, $lieuventeret, $dateop));
                        }
                        

                        $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($compte, -$montant, "Retrait (".$motif.')', 'ret'.$numdec, $devise, $lieuventeret, $numcheque, $banquecheque, $dateop));

                        if ($prodclient['typeclient']=='Banque') {

                            $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($prodclient['id'], $montant, "Retrait (".$motif.')', 'ret'.$numdec, $devise, $lieuventeret, $numcheque, $banquecheque, $dateop));

                        }

                        unset($_SESSION['searchclient']);

                    }

                } else{?>

                  <div class="alert">Saisissez tous les champs vides</div><?php

                }

            }

        }

        if (!isset($_GET['ajout'])) {?>

            <table class="payement">

              <thead>
                <tr><th class="legende" colspan="12" height="30"><?="Liste des Décaissements " .$datenormale ?> <a href="dec.php?ajout" style="color:orange; font-size: 25px;">Effectuer un décaissement</a></th></tr>

                <tr>
                  <form method="POST" action="dec.php" id="suitec" name="termc">

                    <th colspan="2" ><?php

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

                  <form method="POST" action="dec.php" id="suitec" name="termc">
                    <th colspan="7"><?php 


                      if (!empty($_SESSION['date1'])) {?>
                    
                        <select style="width: 200px;" name="magasin" onchange="this.form.submit()"><?php

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
                        </select><?php 
                      }?>
                    </th>
                  </form>

                  <form method="POST" action="dec.php">

                    <th colspan="3">

                      <input style="width:65%;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                      <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div>
                    </th>
                  </form>                  
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Client</th>
                  <th>Motif</th>
                  <th>Date</th>
                  <th>GNF</th>
                  <th>$</th>
                  <th>€</th>
                  <th>CFA</th>
                  <th>V. Banque</th>
                  <th>Chèque</th>
                  <th colspan="2">Actions</th>
                </tr>

              </thead>

              <tbody><?php 

                if (isset($_POST['j1'])) {

                  if ($_SESSION['level']>6) {
                    $products= $DB->query('SELECT decaissement.id as id, client.id as idc, numdec, client.nom_client as client, payement as type, montant, coment, payement, devisedec, DATE_FORMAT(date_payement, \'%d/%m/%Y\')AS DateTemps FROM decaissement left join client on client.id=decaissement.client  WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(decaissement.id) desc ', array('date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));
                  }else{
                    $products= $DB->query('SELECT decaissement.id as id, client.id as idc, numdec, client.nom_client as client, payement as type, montant, coment, payement, devisedec, DATE_FORMAT(date_payement, \'%d/%m/%Y\')AS DateTemps FROM decaissement left join client on client.id=decaissement.client  WHERE lieuvente=:lieu and DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(decaissement.id) desc', array('lieu'=>$_SESSION['lieuvente'], 'date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));
                  }                 

                }elseif (isset($_POST['magasin'])) {

                  if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

                    $products= $DB->query('SELECT decaissement.id as id, client.id as idc, numdec, client.nom_client as client, payement as type, montant, coment, payement, devisedec, DATE_FORMAT(date_payement, \'%d/%m/%Y\')AS DateTemps FROM decaissement left join client on client.id=decaissement.client  WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(decaissement.id) desc', array('date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));
                  }else{
                    $products= $DB->query('SELECT decaissement.id as id, client.id as idc, numdec, client.nom_client as client, payement as type, montant, coment, payement, devisedec, DATE_FORMAT(date_payement, \'%d/%m/%Y\')AS DateTemps FROM decaissement left join client on client.id=decaissement.client  WHERE lieuvente=:lieu and DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(decaissement.id) desc', array('lieu'=>$_POST['magasin'], 'date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));
                  }                 

                }elseif (isset($_GET['searchversclient'])) {

                  if ($_SESSION['level']>6) {
                    $products= $DB->query('SELECT decaissement.id as id, client.id as idc, numdec, client.nom_client as client, payement as type, montant, coment, payement, devisedec, DATE_FORMAT(date_payement, \'%d/%m/%Y\')AS DateTemps FROM decaissement inner join client on client.id=decaissement.client  WHERE decaissement.client = :client order by(decaissement.id) desc ', array('client' => $_GET['searchversclient']));
                  }else{
                    $products= $DB->query('SELECT decaissement.id as id, client.id as idc, numdec, client.nom_client as client, payement as type, montant, coment, payement, devisedec, DATE_FORMAT(date_payement, \'%d/%m/%Y\')AS DateTemps FROM decaissement inner join client on client.id=decaissement.client  WHERE lieuvente=:lieu and decaissement.client = :client order by(decaissement.id) desc', array('lieu'=>$_SESSION['lieuvente'], 'client' => $_GET['searchversclient']));
                  }

                  

                }else{

                  if ($_SESSION['level']>6) {
                    $products= $DB->query('SELECT decaissement.id as id, client.id as idc, numdec, client.nom_client as client, payement as type, montant, coment, payement, devisedec, DATE_FORMAT(date_payement, \'%d/%m/%Y\')AS DateTemps FROM decaissement left join client on client.id=decaissement.client  order by(decaissement.id) desc');
                  }else{
                    $products= $DB->query('SELECT decaissement.id as id, client.id as idc, numdec, client.nom_client as client, payement as type, montant, coment, payement, devisedec, DATE_FORMAT(date_payement, \'%d/%m/%Y\')AS DateTemps FROM decaissement left join client on client.id=decaissement.client  WHERE lieuvente=:lieu order by(decaissement.id) desc', array('lieu'=>$_SESSION['lieuvente']));
                  }

                  
                }

                $montantgnf=0;
                $montanteu=0;
                $montantus=0;
                $montantcfa=0;
                $virement=0;
                $cheque=0;
                foreach ($products as $keyv=> $product ){?>

                  <tr>
                    <td style="text-align: center;"><?= $keyv+1; ?></td>
                    <td><?= $product->client; ?></td>
                    <td><?= ucwords(strtolower($product->coment)); ?></td>
                    <td style="text-align:center;"><?= $product->DateTemps; ?></td><?php

                    if ($product->devisedec=='gnf' and $product->type=='espèces') {

                        $montantgnf+=$product->montant;?>

                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td><?php

                      }elseif ($product->devisedec=='us') {
                        $montantus+=$product->montant;?>

                        <td></td>
                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td><?php
                      }elseif ($product->devisedec=='eu') {
                        $montanteu+=$product->montant;?>

                        <td></td>
                        <td></td>
                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                        <td></td>
                        <td></td>
                        <td></td><?php
                      }elseif ($product->devisedec=='cfa') {
                        $montantcfa+=$product->montant;?>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                        <td></td>
                        <td></td><?php

                      }elseif ($product->type=='virement') {
                        $virement+=$product->montant;?>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                        <td></td><?php
                      }elseif ($product->type=='chèque') {
                        $cheque+=$product->montant;?>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td><?php
                      }?>

                      <td style="text-align: center"><a href="printdecaissement.php?numdec=<?=$product->id;?>&idc=<?=$product->idc;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a></td>

                      <td><?php if ($_SESSION['level']>6){?><a href="dec.php?deleteret=<?=$product->numdec;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a><?php };?></td>
                      
                    </tr><?php 
                }?>

                </tbody>

                <tfoot>
                  <tr>
                    <th colspan="4">Totaux Décaissements</th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($montantgnf,0,',',' ');?></th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($montantus,0,',',' ');?></th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($montanteu,0,',',' ');?></th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($montantcfa,0,',',' ');?></th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($virement,0,',',' ');?></th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($cheque,0,',',' ');?></th>
                  </tr>
                </tfoot>

            </table><?php
        }

    }else{

        echo "VOUS N'AVEZ PAS TOUTES LES AUTORISATIOS REQUISES";
    }

}else{


}?>   
</body>
</html>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script><?php 

if (isset($_GET['client'])) {?>

  <script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?clientdec',
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
  </script><?php 
}else{?>

  <script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?decclient',
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
  </script><?php 

}?> 

<script>
    $(document).ready(function(){
        $('#numberconvert').keyup(function(){
            $('#convertnumber').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'convertnumber.php?convertdec',
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