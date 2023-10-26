<?php
require 'header.php';

  if (isset($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];
    $products = $DB->querys('SELECT statut FROM personnel WHERE pseudo= :PSEUDO',array('PSEUDO'=>$pseudo));

    if ($products['statut']=="admin") {?>

      <fieldset style="margin-top: 10px;"><legend>Regularisaton des clients</legend>
        <div class="choixg">
          <div class="optiong">
            <a href="admin.php?licence">
            <div class="descript_optiong">Licence</div></a>
          </div> 

          <div class="optiong">
            <a href="admin.php?convertir" onclick="return alerteM();">
            <div class="descript_optiong">Modifier</div></a>
          </div>
          <div class="optiong">
            <a href="admin.php?photo">
            <div class="descript_optiong">Ajout Image</div></a>
          </div>
        </div>
      </fieldset>

      <div class="box_admin">        

        <div class="licence"><?php

          if (isset($_GET['licence'])) {?>

            <form method="post" action="admin.php">

                <table style="margin-top: 30px; width: 500px; margin-left: 0px;">

                    <thead>              
                      <tr>
                        <th>SELECTIONNEZ LA LICENCE</th>                
                        <th>DATE D'EXPIRATION</th>
                      </tr>
                    </thead>

                </table> <?php
                $products = $DB->query('SELECT * FROM licence ');

                echo '<select style="width:280px; height:50px; font-size:20px;" name="licence" required="">',"n";

                foreach($products as $product):

                    echo "\t",'<option></option>',"\n";

                    echo "\t",'<option value="', $product->num_licence ,'">', $product->num_licence ,'</option>',"\n";?>

                <?php endforeach ?>

                <td><input style="width: 200px; height: 40px; border-radius: 15px; font-size: 18px;" type="date" name="datel" value=""></td>

                <input class="buttomstock" type="submit" value="VALIDER" onclick="return alerteM();">

            </form><?php
          }

          if (!isset($_POST['licence'])) {

          }else{

            $datel = $_POST['datel'];
            $licence=$_POST['licence']; 
            $DB->insert('UPDATE licence SET date_fin = ? WHERE num_licence = ?', array($datel, $licence));

            echo "VOTRE LICENCE EST DESORMAIS VALABLE JUSQU'AU ".$datel;

          }

          if (isset($_GET['convertir'])) {

            $products = $DB->query('SELECT name FROM logo');

            foreach ( $products as $product ):

              $DB->insert('UPDATE logo SET name = ? WHERE name = ?', array(strtoupper($product->name[0]), $product->name));?>

            <?php endforeach ?><?php


            $products = $DB->query('SELECT designation, Marque FROM products');

            foreach ( $products as $product ):

              $DB->insert('UPDATE products SET name = ? , Marque = ? , designation = ? WHERE designation = ?', array(strtoupper($product->designation[0]), strtolower($product->Marque), strtolower($product->designation), strtolower($product->designation)));

              $DB->insert('UPDATE products SET name = ? , Marque = ? , designation = ? WHERE designation = ?', array(strtoupper($product->designation[0]), ucwords($product->Marque), ucwords($product->designation), $product->designation));?>

            <?php endforeach ?><?php

          }

          if (isset($_GET['photo']) or isset($_POST['aphoto']) or isset($_GET['terme']) or isset($_GET['id'])) {?>

            <form method="GET" action="admin.php">

                <input  type = "search" name = "terme" placeholder="rechercher forfait">

                <input  type = "submit" name = "s" value = "Rechercher">

            </form>

              <div>

                <div class="expo" style="width: 100%; margin: 20px;"><?php

                  if (isset($_GET['s'])) {

                      if (isset($_GET["s"]) AND $_GET["s"] == "Rechercher"){

                          $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
                          $terme = $_GET['terme'];
                          $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                          $terme = strip_tags($terme); //pour supprimer les balises html dans la requête
                      }

                      if (isset($terme)){

                          $terme = strtolower($terme);
                          $products = $DB->query("SELECT id, designation FROM products WHERE designation LIKE ? ",array("%".$terme."%"));
                      }else{

                       $message = "Vous devez entrer votre requete dans la barre de recherche";

                      }
                      foreach ( $products as $product ): ?>

                        <div class="box" style="margin-top: 2px;">
                          <nav_lateral>

                            <ul>                            
                              <li class="logo"><a href="admin.php?id=<?= $product->id; ?>">
                                <div class="descript_logo" style="width: 100px; height: 100px;">
                                    <div class="designation"><?= $product->designation; ?></div>
                                    <div class="picture"><img alt=" " src="img/<?= $product->id ; ?>.jpg"></div>
                                </div></a>
                              </li>
                            </ul>
                          </nav_lateral> 

                        </div>
                      <?php endforeach ?><?php
                    }?>
                  </div>
                </div>
                <form id='admin' method="POST" action="admin.php" enctype="multipart/form-data">
                  <table style="margin-top: 30px;" class="admin_ajout">
                    <thead>
                      <tr>
                        <th class="legende" colspan="2" height="30">Ajouter une image</th> 
                      </tr>                    
                      <tr>   
                        <th>Entrer le N° id</th>
                        <th>telecharger une image</th>
                      </tr>
                    </thead>

                    <tbody>
                       <td style="font-size: 20px;"><?php
                           if (!isset($_GET['id'])) {
                               
                           }else{

                            $_SESSION['id']=$_GET['id'];
                            echo $_GET['id'];?>
                            
                            <input style="width: 0px; height: 0px;" type="text" name="designation" value="<?=$_GET['id'];?>"><?php
                           }?>
                        </td> 
                        <td><input type="file" name="photo" id="photo" required="" /></td>
                        <input type="hidden" value="b" name="env"/>
                    </tbody>
                  </table>
                  <input class="buttomstock" type="submit" value="Ajouter" name="aphoto" onclick="return alerteM();">
                </form><?php

                if (!isset($_POST['designation'])) {
                        
                }else{

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
                    if($logo!="notdid"){
                        echo "upload reussi!!!";
                    }else{
                        echo"recommence!!!";
                    }
                  }
                }
              }?>

            </div>

          </div><?php

        }else{

          echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";
        }

      }else{

    }?>
  </body>

</html>

<script type="text/javascript">
    function alerteS(){
        return(confirm('Confirmer la suppression?'));
    }

    function alerteM(){
        return(confirm('Confirmer la modification'));
    }
</script>
