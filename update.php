<?php
require 'header.php';

$nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];

if (isset($_SESSION['pseudo'])){?> 
    <div class="choixg">
      <div class="optiong">
        <a href="update.php?supclot" onclick="return alerteM();">
        <div class="descript_optiong">Supprimer la fermeture</div></a><?php
          if (isset($_GET['supclot'])) {
            $DB->delete('DELETE FROM cloture WHERE date_cloture= ?', array(date("Y-m-d")));
          }?>
      </div>

      <div class="optiong">
        <a href="update.php?magasin">
        <div class="descript_optiong">Adresse</div></a>
      </div>

      <div class="optiong">
        <a href="ajout.php">
        <div class="descript_optiong">Nouveaux Produits</div></a>
      </div>

    </div>

    <div><?php
      if (isset($_GET['magasin'])) {?>

        <form id='admin' method="POST" action="update.php">

          <table style="margin-top: 30px; width: 70%;" class="payement">

            <thead>
              <tr>
                <th class="legende" colspan="3" height="30">Enregistrement du magasin</th> 
              </tr> 

              <tr>
                <th>Nom du magasin</th>                
                <th>Type de magasin</th>
                <th>Adresse</th>
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

          $DB->insert('UPDATE adresse SET nom_mag = ?, type_mag = ? , adresse = ?', array($_POST['name_mag'], $_POST['type_mag'], $_POST['adress_mag']));?>

          <div class="alerteV">Magasin modifié avec succèe!!!</div> <?php

        }else{

          $DB->insert('INSERT INTO adresse (nom_mag, type_mag, adresse) VALUES(?, ?, ?)', array($_POST['name_mag'], $_POST['type_mag'], $_POST['adress_mag']));

          $products = $DB->query('SELECT * FROM adresse ');

          if (!$products) {?>

            <div class="alertes">Magasin non modifié!!!</div> <?php

          }else{?>

            <div class="alerteV">Magasin enregistré avec succèe!!!</div> <?php
          }

        }

      }?>

    </div>

    <div id="home"><?php

      if (isset($_GET['delPanierstock'])) {

        if (empty($_SESSION['designation'])) {

        }else{

          $marque=$_SESSION['designation'];
          $id=$_SESSION['id'];
          $DB->delete("DELETE FROM `".$nomtab."` WHERE idprod = ?", array($id));
          
          $products=$DB->query("SELECT designation FROM`".$nomtab."` WHERE idprod= ?", array($id));

          if (!$products) {

            echo "Le produit ".$marque." a bien été supprimer";

          }else{

            echo "La suppression a echouée";

          }
          unset($_SESSION['designation']);
          header("Location: update.php");

        }
      }?>

      <div class="expos"><div class="alerte">Selectionnez un produit à modifier!!<?php
      if (isset($_GET['venteu'])) {
          unset($_SESSION['scanneru']); // Pour pouvoir à la vente normale
      }
  
      if (isset($_GET['scanneru']) or !empty($_SESSION['scanneru'])) {?>
          <div class="navsearch">                        
              <div class="search">
                  <form method="GET" action="addpanierstock.php" id="suite">

                      <input id="reccode" type = "search" name = "scanneur" placeholder="scanner un produit" onchange="document.getElementById('suite').submit()">
                  </form>
              </div>
              <a href="update.php?venteu"><input style="width: 150%;height: 30px; font-size: 20px; background-color: red;color: white;"  type="submit" value="Saisir"></a>

          </div><?php
      }else{?>
          <div class="navsearch">
              <div class="search">
                  <form method="GET" action="update.php" id="suite" name="term">

                     <input id="reccode" type = "search" name = "terme" placeholder="rechercher un produit" onKeyUp="suivant(this,'s', 15)" onchange="document.getElementById('suite').submit()">
                      <input name = "s" style="width: 0px; height: 0px;" />

                  </form>
              </div>
              <a href="update.php?scanneru"><input style="width: 150%;height: 30px; font-size: 20px; background-color: red;color: white;"  type="submit" value="Scanner"></a>

          </div><?php
      }?></div><?php

      if (!empty($_SESSION['stock'])) {
          # N'affiche pas les produits
      }else{

          if (isset($_GET['terme'])) {

              if (isset($_GET["terme"])){

                  $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
                  $terme = $_GET['terme'];
                  $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                  $terme = strip_tags($terme); //pour supprimer les balises html dans la requête
              }

              if (isset($terme)){

                $terme = strtolower($terme);
                $products = $DB->query("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id WHERE designation LIKE ? OR Marque LIKE ?",array("%".$terme."%", "%".$terme."%"));

                foreach ( $products as $product ){?>

                  <div class="boxs">
                    <nav_lateral>

                      <ul>                            
                          <li class="logo"><a href="addpanierstock.php?desig=<?= $product->designation; ?>"><?php

                                if ($product->type!='detail') {?>

                                    <div class="descript_logo"><?php

                                }else{?>
                                
                                    <div class="descript_logodet"><?php
                                }?>
                                  <div class="designation"><?= ucwords(strtolower($product->designation)); ?></div>
                                  <div class="picture"><img alt=" " src="img/<?= $product->id ; ?>.jpg"></div>
                                  <div class="reste">Stock: <?= $product->quantite; ?></div>
                                  <div class="pricebox"><?= number_format($product->prix_vente,2,',',' '); ?></div>
                              </div> </a>

                          </li>

                      </ul>

                    </nav_lateral>                                     

                  </div><?php 
                }
            }                  
             
          }else{

            if (!empty($_SESSION['productu'])) {
              if (strlen($_SESSION['productu'])>=20) {
                  $filtre = substr($_SESSION['productu'], 0, -20);                            
              }else{
                  $filtre = substr($_SESSION['productu'], 0, -5);
              }

              $products = $DB->query("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id WHERE designation LIKE ?",array("%".$filtre."%"));
            }else{

                $products = $DB->query("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id limit 50");
            }

              foreach ( $products as $product ): ?>

                  <div class="boxs">

                      <nav_lateral>

                          <ul>                            
                              <li class="logo"><a href="addpanierstock.php?desig=<?= $product->designation; ?>"><?php

                                if ($product->type!='detail') {?>

                                    <div class="descript_logo"><?php

                                }else{?>
                                
                                    <div class="descript_logodet"><?php
                                }?>
                                      <div class="designation"><?= ucwords(strtolower($product->designation)); ?></div>
                                      <div class="picture"><img alt=" " src="img/<?= $product->id ; ?>.jpg"></div>
                                      <div class="reste">Stock: <?= $product->quantite; ?></div>
                                      <div class="pricebox"><?= number_format($product->prix_vente,2,',',' '); ?> </div>
                                  </div> </a>

                              </li>

                          </ul>

                      </nav_lateral> 

                  </div>

              <?php endforeach ?><?php

          }
      }?>

  </div>
</div>    

  <?php require 'panieru.php'; ?>  

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