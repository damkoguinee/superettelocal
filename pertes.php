<?php
require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];
  $products = $DB->querysI('SELECT statut, level FROM login WHERE pseudo= :PSEUDO',array('PSEUDO'=>$pseudo));

  if (isset($_GET['listep']) or isset($_GET['ajoutpertes'])) {
    unset($_SESSION['resultidprodlp']);
    unset($_SESSION['resultidprod']);
  }

  if (isset($_GET['resultidprod'])) {
    $_SESSION['resultidprod']=$_GET['resultidprod'];
  }

  if (isset($_GET['resultidprodlp'])) {
    $_SESSION['resultidprodlp']=$_GET['resultidprodlp'];
  }
  

  if ($products['level']>=3) {

    require 'headerstock.php';

    if(isset($_GET["categ"])){?>

      <form id="naissance" method="POST" action="pertes.php?ajoutpertes" style="margin-top: 30px;" >
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

          $products=$DB->query('SELECT nom FROM categorieperte WHERE nom= ?', array($cate));

          if (empty($products)) {

            $DB->insert('INSERT INTO categorieperte (nom) VALUES (?)', array($cate));

          }else{?>

            <div class="alertes">Cette catégorie existe déjà</div><?php

          }
        }?>
    
    <div style="display: flex;">

      <div><?php require 'navstock.php';?></div><?php

        if (isset($_GET['nomstock'])) {

          $_SESSION['nomtab']=$panier->nomStock($_SESSION['idnomstock'])[1];
        }?>

        <div><?php 
          if (isset($_GET['ajoutpertes']) or isset($_GET['resultidprod'])) {

            $prodep=$DB->query('SELECT id, nom FROM categorieperte');?>
            <div>

              <form id="naissance" method="POST" action="pertes.php" style="margin-top: 30px;" >
                <fieldset><legend>Ajouter une Perte</legend>
                  <ol>
                    <li><label>Désignation</label>                           

                      <select type="text" name="nom"><?php 

                        if (!empty($_SESSION['resultidprod'])) {?>

                            <option value="<?=$_SESSION['resultidprod'];?>"><?=$panier->nomProduit($_SESSION['resultidprod']);?></option><?php
                        }else{?>
                            <option></option><?php 
                        }

                        foreach ($panier->listeProduit() as $value) {?>

                          <option value="<?=$value->id;?>"><?=ucfirst($value->designation);?></option><?php 
                        }?>
                      </select>

                      <input style="width:400px;" id="search-user" type="text" placeholder="rechercher un collaborateur" />

                        <div style="color:white; background-color: black; font-size: 16px; margin-left: 300px;" id="result-search"></div>

                    </li>

                    <li><label>P.Achat</label>
                        <input type="text" name="prix_achat" value="0" min="0">
                    </li>

                    <li><label>P.Vente</label>
                        <input type="text" name="prix_vente" value="0" min="0" >
                    </li>

                    <li><label>P.Revient</label>
                        <input type="text" name="prix_revient" value="0" min="0" >
                    </li>

                    <li><label>Quantité</label>
                      <input type="number" name="quantity" value="0" required="">- pour augmenter
                    </li>

                    <li><label>Motif Perte</label>
                      <select name="motif" required="">
                          <option></option><?php
                          foreach ($prodep as $value) {?>

                            <option value="<?=$value->id;?>"><?=ucfirst($value->nom);?></option><?php 
                          }?>
                      </select>

                      <a href="pertes.php?categ&ajoutpertes">Ajouter une catégorie de Perte</a>
                  </li>

                  </ol>

                  <fieldset><input type="reset" value="Annuler" name="valid" id="form" style="width:150px;"/><input type="submit" value="Ajouter" name="validp"  id="form" onclick="return alerteV();" style="margin-left: 20px; width:150px;" /></fieldset>
                </fieldset>
                </form>

            </div><?php
          }

          if (isset($_POST['validp'])) {

            if (empty($_POST['quantity']) and empty($_POST['nom'])) {
                  
            }else{

              $maximum = $DB->querys("SELECT count(id) AS max_id FROM pertes where idnomstockp='{$_SESSION['idnomstock']}' ");

              $numpertes =$maximum['max_id'] + 1;

              $init='per';
              
              
              $nom=$_POST['nom'];

              $DB->insert('INSERT INTO pertes (idpertes, idnomstockp, prix_achat, prix_vente, prix_revient, quantite, motifperte, datepertes) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['nom'], $_SESSION['idnomstock'], $_POST['prix_achat'], $_POST['prix_vente'], $_POST['prix_revient'], $_POST['quantity'], $_POST['motif']));

              $DB->insert('INSERT INTO stockmouv (idstock, idnomstock, numeromouv, libelle, quantitemouv, dateop) VALUES(?, ?, ?, ?, ?, now())', array($_POST['nom'], $_SESSION['idnomstock'], $init.$numpertes, 'pertes', -$_POST['quantity']));

              $prodstock = $DB->querys("SELECT quantite FROM `".$_SESSION['nomtab']."` where idprod='{$_POST['nom']}' ");

              $moins=$prodstock['quantite']-$_POST['quantity'];

              $DB->insert("UPDATE `".$_SESSION['nomtab']."` SET quantite= ? WHERE idprod = ?", array($moins, $_POST['nom']));?>

                <div class="alerteV">Le produit à bien été retirer dans votre stock</div><?php

            }
          }?>
        </div><?php 

        if (isset($_GET['listep']) or isset($_POST['validp']) or !empty($_SESSION['resultidprodlp'])) {?>

          <div>

            <table class="payement">

              <thead>

                <tr>
                  <th class="legende" colspan="4" height="30">Liste des Pertes <a href="pertes.php?ajoutpertes&nomstock=<?=$_SESSION['idnomstock'];?>" style="color: orange; margin-left: 30px;">Ajouter une Perte</a></th>

                  <th colspan="2">

                    <input style="width:95%;" id="search-userlp" type="text" name="clientsearchlp" placeholder="rechercher un produit" />
                    <div style="color:white; background-color: grey; font-size: 16px;" id="result-searchlp"></div>
                    </th>
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Motif</th>
                  <th>Nom du Produit</th>
                  <th>Qtite Perdue</th>
                  <th>P-Revient</th>
                  <th>Date de Saisie</th>
                </tr>

              </thead>

              <tbody><?php 
                $cumulmontant=0;
                $cumulqtite=0;
                $date=date('Y');
                

                if (!empty($_SESSION['resultidprodlp'])) {                 

                  if ($_SESSION['nomstock']=='stock general') {

                    $products= $DB->query("SELECT designation, motifperte as motif, pertes.prix_revient as prix_revient, pertes.quantite as quantite, datepertes FROM pertes inner join productslist on productslist.id=idpertes  WHERE YEAR(datepertes)='{$date}' and idpertes='{$_SESSION['resultidprodlp']}' order by(idpertes)");
                  }else{

                    $products= $DB->query("SELECT designation, motifperte as motif, pertes.prix_revient as prix_revient, pertes.quantite as quantite, datepertes FROM pertes inner join productslist on productslist.id=idpertes  WHERE YEAR(datepertes)='{$date}' and idnomstockp='{$_SESSION['idnomstock']}' and idpertes='{$_SESSION['resultidprodlp']}' order by(idpertes)");

                  }

                }else{

                  if ($_SESSION['nomstock']=='stock general') {

                    $products= $DB->query("SELECT designation, motifperte as motif, pertes.prix_revient as prix_revient, pertes.quantite as quantite, datepertes FROM pertes inner join productslist on productslist.id=idpertes  WHERE YEAR(datepertes)='{$date}' order by(idpertes)");
                  }else{

                    $products= $DB->query("SELECT designation, motifperte as motif, pertes.prix_revient as prix_revient, pertes.quantite as quantite, datepertes FROM pertes inner join productslist on productslist.id=idpertes  WHERE YEAR(datepertes)='{$date}' and idnomstockp='{$_SESSION['idnomstock']}' order by(idpertes)");

                  }
                }

                foreach ($products as $key=> $product ){

                  $totrevient=$product->prix_revient*$product->quantite;

                  $cumulmontant+=$totrevient;
                  $cumulqtite+=$product->quantite; ?>

                  <tr>
                    <td style="text-align: center;"><?= $key+1; ?></td>

                    <td><?=$panier->nomPertes($product->motif)[0];?></td>

                    <td><?= ucwords(strtolower($product->designation)); ?></td>

                    <td style="text-align: center;"><?= $product->quantite; ?></td> 

                    <td style="text-align: right; padding-right: 5px;"><?= number_format($totrevient,0,',',' '); ?></td>

                    <td><?= (new dateTime($product->datepertes))->format('d/m/Y'); ?></td>
                  </tr><?php 
                }?>

              </tbody>

              <tfoot>
                  <tr>
                    <th colspan="3">Totaux</th>
                    <th style="text-align: center; padding-right: 5px;"><?= $cumulqtite;?></th>
                    <th style="text-align: right; padding-right: 5px;"><?= number_format($cumulmontant,0,',',' ');?></th>
                  </tr>
              </tfoot>

            </table>
          </div><?php 
        }?>

      </div><?php

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
        $('#search-userlp').keyup(function(){
            $('#result-searchlp').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?listepertes',
                    data: 'user=' + encodeURIComponent(utilisateur),
                    success: function(data){
                        if(data != ""){
                          $('#result-searchlp').append(data);
                        }else{
                          document.getElementById('result-searchlp').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                        }
                    }
                })
            }
      
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?pertes',
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
