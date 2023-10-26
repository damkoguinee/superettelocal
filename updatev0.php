<?php
require 'header.php';

if (isset($_SESSION['pseudo'])){?> 

  <div class="choixg">
    <div class="optiong">
      <a href="update.php?supclot" onclick="return alerteM();">
      <div class="descript_optiong">Sup Cloture</div></a><?php
        if (isset($_GET['supclot'])) {
          $DB->delete('DELETE FROM cloture WHERE date_cloture= ?', array(date("Y-m-d")));
        }?>
    </div>

    <div class="optiong">
      <a href="update.php?magasin">
      <div class="descript_optiong">Adresse</div></a>
    </div> 

  </div>

  <div><?php

    if (isset($_GET['magasin'])) {?>

      <form id='admin' method="POST" action="update.php">

        <table style="width: 60%; margin: 20px;" class="border_decaissement">

          <thead>

            <tr>
              <th class="legende" colspan="3" height="30">Modifier l'adresse !!!</th> 
            </tr> 

            <tr>
              <th>NOM DU MAGASIN</th>                
              <th>TYPE DE MAGASIN</th>
              <th>ADRESSE</th>
            </tr>
          </thead>

          <tbody>
            <td><input type="text" name="name_mag" required=""></td>
            <td><input type="text" name="type_mag" required=""></td>
            <td><input type="text" name="adress_mag" required=""></td>
          </tbody>

        </table>

        <input id="button" type="submit" value="VALIDER" onclick="return alerteM();">

      </form> <?php
    }

    if (!isset($_POST['name_mag'])) {
        
    }else{

      $products = $DB->query('SELECT * FROM adresse ');

      if (!empty($products)) {

        $DB->insert('UPDATE adresse SET nom_mag = ?, type_mag = ? , adresse = ?', array(strtoupper($_POST['name_mag']), strtoupper($_POST['type_mag']), strtoupper($_POST['adress_mag'])));

        echo "magasin modifié avec succès";

      }else{

        $DB->insert('INSERT INTO adresse (nom_mag, type_mag, adresse) VALUES(?, ?, ?)', array(strtoupper($_POST['name_mag']), strtoupper($_POST['type_mag']), strtoupper($_POST['adress_mag'])));

        $products = $DB->query('SELECT * FROM adresse ');

        if (!$products) {

          echo "Votre ajout n'est pas pris en compte";

        }else{

            echo "magasin enregistré avec succès";
        }

      }

    }?>

  </div>

  <div id="home">

    <div class="exposs"><div class="alerte">Rechercher le produit à modifier!!<?php

      if (isset($_GET['venteu'])) {
          unset($_SESSION['scanneru']); // Pour pouvoir utiliser la vente normale
      }
  
      if (isset($_GET['scanneru']) or !empty($_SESSION['scanneru'])) {?>

        <div class="navsearch">  

          <div class="search">

            <form method="GET" action="addpanierstock.php" id="suite">

              <input id="reccode" type = "search" name = "scanneur" placeholder="scanner un produit" onchange="document.getElementById('suite').submit()">

            </form>

          </div>

          <div class="navss"><a href="update.php?venteu">Saisir</a></div>

        </div><?php

      }else{?>

        <div class="navsearch">

          <div class="search">

            <form method="GET" action="update.php" id="suite" name="term">

              <input id="reccode" type = "search" name = "terme" placeholder="rechercher un produit" onKeyUp="suivant(this,'s', 4)" onchange="document.getElementById('suite').submit()">
              <input name = "s" style="width: 0px; height: 0px;" />

            </form>
          </div>
          <div class="navss"><a href="update.php?scanneru">Scanner</a></div>

        </div><?php

      }?>

    </div><?php

    if (!empty($_SESSION['stock'])) {
          # N'affiche pas les produits
    }else{

      if (isset($_GET['terme'])) {

        if (isset($_GET["terme"])){

          $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
          $terme = $_GET['terme'];
          $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
          $terme = strip_tags($terme); //pour supprimer les balises html dans la requête
        }?>

        <form id='monform' method="POST" action="modif.php" enctype="multipart/form-data">

          <table class="tabpanier" style="width: 100%;">     

            <thead>

              <th></th>
              <th>Désignation</th>
              <th>P Achat</th>
              <th>P Unit</th>
              <th>Qtite</th>
              <th>Codebarre</th>
              <th>Peremption</th>
              <th>Ajouter une image</th>
              <th></th>
              <th></th>

            </thead><?php

            if (isset($terme)){

              $terme = strtolower($terme);

              $products =$DB->query("SELECT id, quantite, designation, prix_achat, prix_vente, DATE_FORMAT(dateperemtion, \"%d/%m/%Y \") AS Datep  FROM products WHERE designation LIKE ? OR Marque LIKE ?", array("%".$terme."%", "%".$terme."%"));

              foreach ( $products as $product ): ?>

                <tbody>

                  <td class="img"><img src="img/<?= $product->id; ?>.jpg" height="25" width="25"></td>

                  <td><input style="text-align: left;" type="text" name="marque" value="<?= $product->designation; ?>"></td>

                  <td><input type="text" name="pachat" min="0" value="<?= $product->prix_achat; ?>"></td>

                  <td><input type="text" name="prix" min="0" value="<?= $product->prix_vente; ?>"></td>

                  <td><input  type="number" name="quantite" min="0" value="<?= $product->quantite; ?>"></td>
                  <td><input  type="text" name="cbarre" min="0"></td>

                  <td style="text-align: right;"><input type="date" name="dateu"></td>

                  <td><input type="file" name="photo" id="photo"  /></td>

                  <td><input id="buttonn" type="submit" name="payer" value="Valider" onclick="return alerteM()"></td>

                  <td><a href="modif.php?delPanierstock=<?= $product->id; ?>" onclick="return alerteS()"><input id="buttonn" type="submit" name="delete" value="Supprimer"></a></td>

                </tbody>

              <?php endforeach ?><?php 

            }?>

          </table>

        </form><?php
      }

    }?>

  </div>    

  <?php// require 'panieru.php'; ?>  

  </div><?php

}else{

  header("Location: form_connexion.php");

}?>

</body>
</html>

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

function alerteM(){
  return(confirm('Confirmer la modification'));
}
</script>