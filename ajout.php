<?php
require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];
  $products = $DB->querysI('SELECT statut, level FROM login WHERE pseudo= :PSEUDO',array('PSEUDO'=>$pseudo));
  

  if ($products['level']>=3) {

    if(isset($_GET["delete"])){

      $numero=$_GET["delete"];

      $DB->delete('DELETE FROM productslist WHERE id = ?', array($numero));
      $DB->delete('DELETE FROM stock1 WHERE idprod = ?', array($numero));
    }

    if (isset($_POST['id'])) {
      $qtiteint=$panier->h($_POST['qtiteint']);
      $qtiteintp=$panier->h($_POST['qtiteintp']);
      $pv=$panier->espace($_POST['pvente']);
      $id=$panier->h($_POST['id']);
      $desig=$panier->h($_POST['desig']);
      $codepm=$panier->h($_POST['codepm']);
      $codeb=$panier->h($_POST['codeb']);

      $DB->insert("UPDATE productslist SET Marque= ?, designation=?, qtiteint=?, qtiteintp=?, pventel=?, codeb=? WHERE id = ?", array($codepm, $desig, $qtiteint,  $qtiteintp, $pv, $codeb, $id));

      foreach ($panier->listeStock() as $value) {
        
        $DB->insert("UPDATE `".$value->nombdd."` SET qtiteintd=?, qtiteintp=?, prix_vente=?, codeb=? WHERE idprod = ?", array($qtiteint,  $qtiteintp, $pv, $codeb, $id));
      }
    }?>
    
    <div style="display: flex;">

      <div><?php require 'navstock.php';?></div>

      <div><?php

        if(isset($_GET["categ"])){?>

          <form id="naissance" method="POST" action="ajout.php" style="margin-top: 30px;" >
            <fieldset><legend>Ajouter une catégorie</legend>
              <ol>

                <li><label>Nom de la catégorie</label>
                    <input type="text" name="cate" required="">
                </li>
              </ol>
            </fieldset>

            <fieldset>

              <input type="reset" value="Annuler" name="valid" id="form" style="width:150px; cursor: pointer;"/>

              <input type="submit" value="Ajouter" name="categins" id="form" onclick="return alerteV();" style="margin-left: 20px; width:150px; cursor: pointer;" />

            </fieldset>
          </form><?php
        }

        if(isset($_POST["categins"])){

          $cate=$_POST['cate'];

          $products=$DB->query('SELECT nom FROM categorie WHERE nom= ?', array($cate));

          if (empty($products)) {

            $DB->insert('INSERT INTO categorie (nom) VALUES (?)', array($cate));

          }else{?>

            <div class="alerteV">Cette catégorie existe déjà</div><?php

          }
        }

        if(isset($_GET["ajoutprod"]) or isset($_POST["categins"])){

          $products=$DB->query('SELECT id, nom FROM categorie');?>

          <div class="ajout_prod">

            <form id="naissance" method="POST" action="ajout.php" enctype="multipart/form-data" style="margin-top: 30px; width: 100%;" >
              <fieldset><legend>Ajouter un Produit</legend>
                <ol>
                  <li><label>Catégorie produit</label>
                    <select type="text" name="genre" required="">
                      <option></option><?php
                    foreach ($products as $value) {?>

                      <option value="<?=$value->id;?>"><?=ucfirst($value->nom);?></option><?php 
                    }?>
                    </select>

                    <a href="ajout.php?categ">Ajouter une catégorie</a>
                  </li>

                  <li><label>Code Barre</label>
                      <input type="text" name="codeb">
                  </li>

                  <li><label>Code*</label>
                      <input type="text" name="marque" required="">
                  </li>

                  <li><label>Désignation*</label>
                    <input type="text" name="designation" required="">
                  </li>

                  <li><label>P.Achat</label>
                    <input type="text" name="pachat" value="0" min="0">
                  </li>

                  <li><label>P.Revient</label>
                    <input type="text" name="previent" value="0" min="0">
                  </li>

                  <li><label>P.Vente</label>
                      <input type="text" name="pvente" value="0" min="0" >
                  </li>

                  <li><label>Nature</label>
                    <select name="nature">
                      <option value="en_gros">En Gros</option>
                      <option value="paquet">Paquet</option>
                      <option value="detail">Détail</option>
                    </select>
                  </li>

                  <li><label>Qtité int Paquet</label>
                      <input type="text" name="qtiteintp" value="0">
                  </li>

                  <li><label>Quantité int Détail</label>
                      <input type="text" name="qtiteintd" value="0">
                  </li>


                  <li><label>Image</label>
                    <input type="file" name="photo" id="photo" />
                    <input type="hidden" value="b" name="env"/>
                  </li>

                </ol>

                <fieldset><input type="reset" value="Annuler" name="valid" id="form" style="width:150px;"/><input type="submit" value="Ajouter" name="validajout"  id="form" onclick="return alerteV();" style="margin-left: 20px; width:150px;" /></fieldset>
              </fieldset>
            </form>

          </div><?php
        }



        if (isset($_POST['validajout'])) {

          $designation=$panier->h($_POST['designation']);
          $marque=$panier->h($_POST['marque']);
          $pachat=$panier->h($_POST['pachat']);
          $previent=$panier->h($_POST['previent']);
          $pvente=$panier->h($_POST['pvente']);
          $categorie=$panier->h($_POST['genre']);
          $nature=$panier->h($_POST['nature']);
          $qtiteintp=$panier->h($_POST['qtiteintp']);
          $qtiteintd=$panier->h($_POST['qtiteintd']);
          $codeb=$_POST['codeb'];

          if (empty($_POST['marque']) and empty($_POST['designation'])) {?>

            <div class="alertes">Le nom et la designation doivent être completés</div><?php 
                
          }else{

            $products=$DB->query('SELECT designation FROM productslist WHERE designation= :NOM', array('NOM'=>$designation));

            if (!empty($products)) {?>

              <div class="alertes">Ce nom de produit existe déjà</div><?php
              
            }else{            
              

              $DB->insert('INSERT INTO productslist (codeb, Marque, designation, pventel, codecat, nbrevente, type, qtiteint, qtiteintp) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($codeb, $marque, $designation, $pvente, $categorie, 0, $nature, $qtiteintd, $qtiteintp));

              $prod=$DB->querys('SELECT max(id) as id FROM productslist');

              $_SESSION['id']=$prod['id'];
              

              if (!empty($qtiteintd)) {

                $DB->insert('INSERT INTO productslist (codeb, Marque, designation, pventel, codecat, nbrevente, type, qtiteint, qtiteintp) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array('', $marque, $designation.' detail', 0, $categorie, 0, 'detail', 0, 0));

                $prod=$DB->querys('SELECT max(id) as id FROM productslist');

                $_SESSION['idd']=$prod['id'];

              }

              if (!empty($qtiteintp)) {

                $DB->insert('INSERT INTO productslist (codeb, Marque, designation, pventel, codecat, nbrevente, type, qtiteint, qtiteintp) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array('', $marque, $designation.' paquet', 0, $categorie, 0, 'paquet', $qtiteintd, 0));

                $prod=$DB->querys('SELECT max(id) as id FROM productslist');

                $_SESSION['idp']=$prod['id'];

              }
              

              if(isset($_POST["env"])){
                $logo=$_FILES['photo']['name'];

                if($logo!=""){
                  require "uploadImage.php";
                  if($sortie==false){
                    $logo=$dest_dossier . $dest_fichier;
                  }else {
                    $logo="notdid";
                  }
                }
              }


              foreach ($panier->listeStock() as $value) {

                $bdd=$value->nombdd;                

                $DB->insert("INSERT INTO `".$bdd."` (idprod, codeb, prix_achat, prix_revient, prix_vente, nbrevente, type, qtiteintd, qtiteintp) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)", array($_SESSION['id'], $codeb, $pachat, $previent, $pvente, 0, $nature, $qtiteintd, $qtiteintp));

                if (!empty($qtiteintd)) {

                  $DB->insert("INSERT INTO `".$bdd."` (idprod, prix_achat, prix_revient, prix_vente, nbrevente, type, qtiteintd, qtiteintp) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", array($_SESSION['idd'], 0, 0, 0, 0, 'detail', 0, 0));
                }

                if (!empty($qtiteintp)) {

                  $DB->insert("INSERT INTO `".$bdd."` (idprod, prix_achat, prix_revient, prix_vente, nbrevente, type, qtiteintd, qtiteintp) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", array($_SESSION['idp'], 0, 0, 0, 0, 'paquet', $qtiteintd, 0));
                }

              }?>

              <div class="alerteV">Le produit a bien été ajouter</div><?php

            }

          }
        }

        if (isset($_GET['listep']) or isset($_POST['validajout']) or isset($_POST['qtiteintp']) or isset($_POST['design']) or isset($_GET['resultidprod'])) {

          if (isset($_POST['design'])) {
            $_SESSION['design']=$_POST['design'];

          }elseif(!empty($_SESSION['design'])){

            $_SESSION['design']=$_SESSION['design'];

          }else{
            $_SESSION['design']='';
          }

          if (isset($_POST['codep'])) {
            $_SESSION['codep']=$_POST['codep'];

          }elseif(!empty($_SESSION['codep'])){

            $_SESSION['codep']=$_SESSION['codep'];

          }else{
            $_SESSION['codep']='';
          }

          if (isset($_POST['codep']) or isset($_POST['id'])) {

            if (!empty($_POST['codep'])) {
              $prodm=$DB->query("SELECT *from productslist where Marque='{$_POST['codep']}' ");
            }else{

              if(!empty($_SESSION['design'])){

                $prodm=$DB->query("SELECT *from productslist where codecat='{$_SESSION['design']}' order by(pventel)");
              }else{

                $prodm=$DB->query('SELECT *from productslist order by(id) desc');

              }
            }

          }

          if (isset($_GET['resultidprod'])) {

            $prodm=$DB->query("SELECT *from productslist where id='{$_GET['resultidprod']}' ");
          }
          if (isset($_GET['delete'])) {

            $prodm=$DB->query("SELECT *from productslist where codecat='{$_SESSION['design']}' ");
          }?>
              
          <table class="payement">
            <thead>

              <form action="ajout.php" method="POST">

                <tr>
                  <th colspan="4">                   

                    <select style="width:30%; height: 30px; text-align;left;" type="text" name="design" onchange="this.form.submit()" ><?php 
                      if (!empty($_SESSION['design'])) {?>
                        <option value="<?=$_SESSION['design'];?>"><?=$panier->nomCategorie($_SESSION['design'])?></option><?php
                      }else{?>
                        <option>Recherchez par Catégorie</option><?php
                      }

                      foreach($panier->recherchestock() as $value){?>
                          <option value="<?=$value->id;?>"><?=$value->nom;?></option><?php
                      }?>
                      </select>

                      <input style="width:25%;" type="text" name="codep" onchange="this.form.submit()" placeholder="rechercher par code" />

                      <input style="width:35%;" id="search-user" type="text" name="client" placeholder="rechercher un produit" />

                      <div id="result-search"></div>
                  </th>

                  <th height="25" colspan="9" style="text-align: center"><?='Liste des Produits';?> <a href="ajout.php?ajoutprod" style="color: orange; margin-left: 30px;">Ajouter un Produit</a></th>
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Code</th>
                  <th>Désignation</th>
                  <th>Code Barre</th>
                  <th style="width:8%;">Qtite int D</th>
                  <th style="width:8%;">Qtite int P</th>
                  <th style="width:10%;">P. Vente</th>
                  <th></th>
                  <th></th>
                </tr>
              </form>

            </thead>

            <tbody><?php

              if (empty($prodm)) {
                # code...
              }else{
                foreach ($prodm as $key=> $formation) {
                  $verif=$DB->querys("SELECT id FROM stockmouv where idstock='{$formation->id}' ");?>

                  <tr>
                    <form action="ajout.php" method="POST">

                      <td style="text-align: center;"><?=$key+1;?></td>

                      <td style="text-align: left"><input style="text-align: left;" type="text" name="codepm" value="<?= ucwords(strtolower($formation->Marque)); ?>" ></td>

                      <td style="text-align: left; width: 35%;"><input style="text-align: left;" type="text" name="desig" value="<?= ucwords(strtolower($formation->designation)); ?>"> <input type="hidden" name="id" value="<?= $formation->id; ?>"></td>

                      <td style="text-align: left;"><input style="text-align: left;" type="text" name="codeb" value="<?= $formation->codeb; ?>"></td>

                      <td><input type="text" name="qtiteint" value="<?=$formation->qtiteint; ?>"  style="width:90%;"></td>

                      <td><input type="text" name="qtiteintp" value="<?=$formation->qtiteintp; ?>"  style="width:90%;"></td>

                      <td><input type="text" name="pvente" value="<?=number_format($formation->pventel,0,',',' '); ?>" onchange="this.form.submit()" style="width:90%;"></td>

                      <td><input type="submit" name="valid" value="Valider"></td>

                      <td><?php if (empty($verif['id'])) {?>
                        <a href="ajout.php?delete=<?=$formation->id;?>" onclick="return alerteS();"><input type="button" value="Supprimer" style="width: 95%; font-size: 16px; background-color: red; color: white; cursor: pointer"></a><?php }?>
                      </td>
                    </form>

                  </tr><?php
                }

              }?>          
            </tbody>

                
          </table><?php
        }?>
      </div>

      </div><?php

    }else{?>

      <div class="alertes">Vous n'avez pas toutes les autorisations réquises</div><?php
    }

  }else{

  }?>
</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?ajout',
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

<script>
function suivant(enCours, suivant, limite){
  if (enCours.value.length >= limite)
  document.term[suivant].focus();
}

function focus(){
document.getElementById('reccode').focus();
}

function alerteS(){
  return(confirm('Confirmer la suppression?'));
}

function alerteV(){
    return(confirm('Confirmer la validation'));
}

function alerteM(){
  return(confirm('Confirmer la modification'));
}
</script>
