<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

  $products = $DB->querysI('SELECT statut FROM login WHERE pseudo=? and type=?',array($pseudo, 'personnel'));

  if (isset($_GET['deletec'])) {

    $DB->delete('DELETE FROM client WHERE nom_client = ?', array($_GET['deletec']));
    $DB->delete('DELETE FROM bulletin WHERE nom_client = ?', array($_GET['deletec']));

    $DB->delete('DELETE FROM login WHERE nom= ? and type!=?', array($_GET['deletec'],'personnel'));
  }

  if ($_SESSION['level']>=3) {?>

    <fieldset style="margin-top: 10px;"> 
      <div class="choixg"> 
        
        <div class="optiong">
            <a href="client.php?client">
            <div class="descript_optiong">Liste des Clients</div></a>
        </div><?php 

        if ($_SESSION['level']>1) {?>

          <div class="optiong">
              <a href="client.php?fournisseur">
              <div class="descript_optiong">Liste des Fournisseurs</div></a>
          </div><?php 
        }?>

        <div class="optiong">
          <a href="client.php?autres">
          <div class="descript_optiong">Autres</div></a>
        </div> 

        <div class="optiong">
          <a href="clientgestionlist.php?">
          <div class="descript_optiong">Gestion des Clients</div></a>
        </div>      
      </div>

    </fieldset><?php

    if (isset($_GET['ajoutc'])) {?>

      <form id="naissance" method="POST" action="client.php" style="margin-top: 30px; width:80%;" >

        <fieldset><legend>Ajouter un Collaborateur</legend>
          <ol>

            <li><label>Type</label>
              <select type="text" name="type" required="">
                <option></option>
                <option value="client">Client</option>
                <option value="clientf">Client-Fournisseurs</option>
                <option value="fournisseur">Fournisseur</option>
                <option value="Employer">Personnel</option>                
                <option value="transporteur">Transporteur</option>
                <option value="Banque">Banque</option>
                <option value="douanier">Douanier</option>
                <option value="autres">Autres</option>
              </select>
            </li></li>

            <li><label>Nom & Prénom*</label><input type="text" name="client" required=""></li>

            <li><label>Téléphone*</label><input type="text" name="tel" required=""></li>

            <li><label>E.mail</label><input type="text" name="mail"></li>

            <li><label>Lieu de Facturation</label><select type="text" name="position" required="">
              <option></option><?php 
              foreach ($panier->listeStock() as $value) {?>
                
                <option value="<?=$value->id;?>"><?=ucwords($value->nomstock);?></option><?php
              }?></select>
            </li>

            <li><label>Adresse*</label><input type="text" name="ad" required=""></li>

            <li><label>Solde Compte</label><input type="text" name="scompte" value="0"> - : le client vous doit et + le contraire</li>

            <li><label>Devise*</label>
              <select name="devise" required="" ><?php 
                foreach ($panier->monnaie as $valuem) {?>
                    <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                }?>
              </select>
            </li>


          </ol>
        </fieldset>

        <fieldset>

          <input type="reset" value="Annuler" name="valid" id="form" style="width:150px; cursor: pointer;"/>

          <input type="submit" value="Ajouter" name="valid" id="form" onclick="return alerteV();" style="margin-left: 20px; width:150px; cursor: pointer;" />

        </fieldset> 

      </form><?php
    }

    if (isset($_POST['valid'])) {

      $products=$DB->querys('SELECT * FROM client WHERE nom_client= ? or telephone=?', array($_POST["client"], $_POST['tel']));

      if (empty($products)) {

        if ($_POST["client"]=='') {?>

          <div class="alertes"><?="Completez tous les champs"; ?></div><?php

        }else{
          $client=$_POST['client'];
          $tel=$panier->h($_POST['tel']);
          $ad=$panier->h($_POST['ad']);
          $position=$panier->h($_POST['position']);
          $type=$panier->h($_POST['type']);
          $scompte=$_POST['scompte'];
          $devise=$_POST['devise'];
          $mail=$_POST['mail'];
          $mdp='0000';
          $mdp=password_hash($mdp, PASSWORD_DEFAULT);

          $DB->insert('INSERT INTO client (nom_client, telephone, mail,  adresse, positionc, typeclient) VALUES(?, ?, ?, ?, ?, ?)', array($client, $tel, $mail, $ad, $position, $type));          
          

          $prodclient=$DB->querys("SELECT max(id) as id from client ");

          if ($type=='Banque') {
            $nombanque=$panier->nomClientad($prodclient['id'])[0];

            $typeb=strtolower($type);

            $DB->insert('INSERT INTO nombanque (id, nomb, numero, type, lieuvente) VALUES(?, ?, ?, ?, ?)', array($prodclient['id'], $nombanque, $prodclient['id'], $typeb, $_SESSION['lieuvente']));
          }

          //$datereport="2022-08-15";

          $datereport=date('Y-m-d');

          $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($prodclient['id'], $scompte, 'report solde', 'ret', $devise, 1, $_SESSION['lieuvente'], $datereport));

          $DB->insertI('INSERT INTO login(nom, telephone, email, pseudo, mdp, level, statut, type, lieuvente, dateenreg) values(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($client, $tel, $mail, $tel, $mdp, '1', $type, $type, $position));?>

          <div class="alerteV">Collaborateur ajouté avec succèe!!:</div><?php 

        }

      }else{?>

        <div class="alertes"><?php echo "Ce nom ou ce numéro de téléphone est déjà attribué"; ?></div><?php        

      }
    }

    if (isset($_GET['modifc'])) {

      $prodc=$DB->querys('SELECT * FROM client WHERE id= ?', array($_GET["modifc"]));?>

      <form id="naissance" method="POST" action="client.php" style="margin-top: 30px; width:80%;" >

        <fieldset><legend>Modifier un Collaborateur</legend>
          <ol>

            <li><label>Type</label>
              <select name="type" required="">
                <option value="<?=$prodc['typeclient'];?>"><?=$prodc['typeclient'];?></option>
                <option value="fournisseur">Fournisseur</option>
                <option value="client">Client</option>
                <option value="clientf">Client & Fournisseur</option>
                <option value="Employer">Personnel</option>             
                <option value="banque">Banque</option>             
                <option value="transporteur">Transporteur</option>
                <option value="douanier">Douanier</option>
                <option value="autres">Autres</option>
              </select>
            </li>

            <li><label>Nom & Prénom*</label><input type="text" name="client" value="<?=$prodc['nom_client'];?>"><input type="hidden" name="id" value="<?=$prodc['id'];?>"></li>

            <li><label>Téléphone*</label><input type="number"   name="tel" value="<?=$prodc['telephone'];?>"></li>

            <li><label>E.mail</label><input type="text"   name="mail" value="<?=$prodc['mail'];?>"></li>

            <li><label>Mot de Passe</label><input type="text"   name="mdp" value="0000" required="" placeholder="le mot de passe par defaut est 0000" ></li>

            <li><label>Lieu de Facturation</label><select type="text" name="position" required="">
              <option value="<?=$prodc['positionc'];?>"><?=$prodc['positionc'];?></option><?php 
              foreach ($panier->listeStock() as $value) {?>
                
                <option value="<?=$value->id;?>"><?=ucwords($value->nomstock);?></option><?php
              }?></select>
            </li>

            <li><label>Adresse*</label><input type="text"   name="ad" value="<?=$prodc['adresse'];?>"></li>

            <li><label>Solde Compte</label><input type="text" name="scompte" value="0"> - : pour augmenter et + pour dimunier</li>

            <li><label>Devise*</label>
              <select name="devise" required="" ><?php 
                foreach ($panier->monnaie as $valuem) {?>
                    <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                }?>
              </select>
            </li>


          </ol>
        </fieldset>

        <fieldset>

          <input type="reset" value="Annuler" name="valid" id="form" style="width:150px; cursor: pointer;"/>

          <input type="submit" value="Ajouter" name="validm" id="form" onclick="return alerteV();" style="margin-left: 20px; width:150px; cursor: pointer;" />

        </fieldset>
      </form><?php 
    }

    if (isset($_POST['validm'])) {

      $client=$panier->h($_POST['client']);
      $tel=$panier->h($_POST['tel']);
      $ad=$panier->h($_POST['ad']);
      $position=$panier->h($_POST['position']);
      $type=$panier->h($_POST['type']);
      $id=$panier->h($_POST['id']);
      $scompte=$_POST['scompte'];
      $devise=$_POST['devise'];
      $mail=strtolower($_POST['mail']);
      $mdp=$_POST['mdp'];
      $mdp=password_hash($mdp, PASSWORD_DEFAULT);

      $DB->insert('UPDATE client SET nom_client=?, telephone=?, mail=?, adresse=?, typeclient=?, positionc=? where id=?', array($client, $tel, $mail, $ad, $type, $position, $id));

      $DB->insertI('UPDATE login SET nom = ?, telephone=?, email=?, pseudo=?, mdp=?, level=?, statut=?, type=?, lieuvente=?  WHERE nom = ?', array($client, $tel, $mail, $tel, $mdp, '1', $type, $type, $position, $_POST['id']));

      if (!empty($scompte)) {

        //$datereport="2022-06-11";
        $datereport=date('Y-m-d');

        $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($id, $scompte, 'ajustement solde', 'ret', $devise, 1, $_SESSION['lieuvente'], $datereport));
      }?>

      <div class="alerteV">Collaborateur modifié avec succèe!!:</div><?php
      

    }

    

    if (!isset($_GET['ajoutc'])) {

      if (isset($_GET['client'])) {

        if (isset($_GET['clientsearch'])) {

          $products= $DB->query("SELECT *FROM client where id='{$_GET['clientsearch']}'");

        }else{

          $type1='client';
          $type2='clientf';

          $products= $DB->query("SELECT *FROM client where typeclient='{$type1}' or typeclient='{$type2}' order by(nom_client) LIMIT 50");          
        }?>

        <table class="payement" style="margin-bottom: 30px;">

          <thead>

            <tr>
              <th class="legende" colspan="2" height="30">
                <input style="width:65%; height: 30px;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div>
              </th>

              <th class="legende" colspan="6" height="30"><?php 
                if (isset($_GET['clientsearch'])) {
                  $_SESSION['reclient']=$_GET['clientsearch'];
                }?>

                <?= "Liste des Clients  " ?><a href="client.php?ajoutc" style="color: orange; margin-left: 30px; font-size:30px;">Ajouter un Collaborateur</a>
              </th>
            </tr>

            <tr>
              <th>N°</th>
              <th>Nom & Prénom</th>
              <th>Téléphone</th>
              <th>Email</th>
              <th>Zone de Vente</th>
              <th>Adresse</th>
              <th></th>
              <th></th>
            </tr>

          </thead>

          <tbody><?php

            foreach ($products as $key=> $product ){?>

              <tr>

                <td style="text-align: center;"><?=$key+1;?></td>                        
                <td><?=$product->nom_client;?></td>
                <td><?=$product->telephone; ?></td>
                <td><?=$product->mail; ?></td>
                <td><?=$panier->nomStock($product->positionc)[0] ; ?></td>
                <td><?=ucwords(strtolower($product->adresse)) ; ?></td> 

                <td><?php if ($_SESSION['level']>7) {?><a href="client.php?modifc=<?=$product->id;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: orange;color: white; cursor: pointer;"  type="submit" value="Modifier"></a><?php }?></td>

                <td><?php if ($_SESSION['level']>7) {?><a href="client.php?deletec=<?=$product->nom_client;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor:pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a><?php }?></td>

              </tr><?php 
            }?>

          </tbody>

        </table><?php
      }


      if (isset($_GET['fournisseur'])) {

        if (isset($_GET['clientsearch'])) {

          $products= $DB->query("SELECT *FROM client where id='{$_GET['clientsearch']}'");

        }else{

          $type1='fournisseur';
          $type2='fournisseur';

          $products= $DB->query("SELECT *FROM client where typeclient='{$type1}' or typeclient='{$type2}' order by(nom_client)");          
        }?>

        <table class="payement" style="margin-bottom: 30px;">

          <thead>

            <tr>
              <th class="legende" colspan="2" height="30">
                <input style="width:65%;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un fournisseur" />
                <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div>
              </th>

              <th class="legende" colspan="6" height="30"><?php 
                if (isset($_GET['clientsearch'])) {
                  $_SESSION['reclient']=$_GET['clientsearch'];
                }?>

                <?= "Liste des Fournisseurs  " ?><a href="client.php?ajoutc" style="color: orange; margin-left: 30px;">Ajouter un Collaborateur</a>
              </th>
            </tr>

            <tr>
              <th>N°</th>
              <th>Nom & Prénom</th>
              <th>Téléphone</th>
              <th>Email</th>
              <th>Zone de Vente</th>
              <th>Adresse</th>
              <th></th>
              <th></th>
            </tr>

          </thead>

          <tbody><?php

            foreach ($products as $key=> $product ){?>

              <tr>

                <td style="text-align: center;"><?=$key+1;?></td>                        
                <td><?=$product->nom_client;?></td>
                <td><?=$product->telephone; ?></td>
                <td><?=$product->mail; ?></td>
                <td><?=$panier->nomStock($product->positionc)[0] ; ?></td>
                <td><?=ucwords(strtolower($product->adresse)) ; ?></td> 

                <td><a href="client.php?modifc=<?=$product->id;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: orange;color: white; cursor: pointer;"  type="submit" value="Modifier"></a></td>

                <td><?php if ($_SESSION['level']>7) {?><a href="client.php?deletec=<?=$product->nom_client;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor:pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a><?php }?></td>

              </tr><?php 
            }?>

          </tbody>

        </table><?php
      }

      if (isset($_GET['autres'])) {

        if (isset($_GET['clientsearch'])) {

          $products= $DB->query("SELECT *FROM client where id='{$_GET['clientsearch']}'");

        }else{

          $type1='client';
          $type2='fournisseur';
          $type3='clientf';

          $products= $DB->query("SELECT *FROM client where typeclient!='{$type1}' and typeclient!='{$type2}' and typeclient!='{$type3}' order by(nom_client)");          
        }?>

        <table class="payement" style="margin-bottom: 30px;">

          <thead>

            <tr>
              <th class="legende" colspan="2" height="30">
                <input style="width:65%;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div>
              </th>

              <th class="legende" colspan="6" height="30"><?php 
                if (isset($_GET['clientsearch'])) {
                  $_SESSION['reclient']=$_GET['clientsearch'];
                }?>

                <?= "Autres Collaborateurs  " ?><a href="client.php?ajoutc" style="color: orange; margin-left: 30px; font-size: 30px;">Ajouter un Collaborateur</a>
              </th>
            </tr>

            <tr>
              <th>N°</th>
              <th>Nom & Prénom</th>
              <th>Téléphone</th>
              <th>Email</th>
              <th>Zone de Vente</th>
              <th>Adresse</th>
              <th></th>
              <th></th>
            </tr>

          </thead>

          <tbody><?php

            foreach ($products as $key=> $product ){?>

              <tr>

                <td style="text-align: center;"><?=$key+1;?></td>                        
                <td><?=$product->nom_client;?></td>
                <td><?=$product->telephone; ?></td>
                <td><?=$product->mail; ?></td>
                <td><?=$panier->nomStock($product->positionc)[0] ; ?></td>
                <td><?=ucwords(strtolower($product->adresse)) ; ?></td> 

                <td><?php if ($_SESSION['level']>6) {?><a href="client.php?modifc=<?=$product->id;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: orange;color: white; cursor: pointer;"  type="submit" value="Modifier"></a><?php }?></td>

                <td><?php if ($_SESSION['level']>7) {?><a href="client.php?deletec=<?=$product->nom_client;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor:pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a><?php }?></td>

              </tr><?php 
            }?>

          </tbody>

        </table><?php
      }
    }


    }else{

      echo "Vous n'avez pas toutes les autorisations réquises";

    }

  }else{

  }?>

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
                    url: 'recherche_utilisateur.php?clientsearch',
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
}

if (isset($_GET['fournisseur'])) {?>

  <script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?fournisseursearch',
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
}

if (isset($_GET['autres'])) {?>

  <script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?autressearch',
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
