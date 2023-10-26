<?php
require '_header.php';?>
  
<!DOCTYPE html>
<html>

<head>
    <title>logescom-ms</title>
    <meta charset="utf-8">    
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/commande.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/client.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/sousmenu.css" type="text/css" media="screen" charset="utf-8">
</head>

<script>
    function suivant(enCours, suivant, limite){
        if (enCours.value.length >= limite)
        document.term[suivant].focus();
    }
</script>

<body onload="return focus();"><?php

    if (isset($_SESSION['pseudo'])){?>    

        <div id="home">

            <div class="expo"><?php
                if (isset($_GET['vente']) or isset($_GET['logo'])) {
                    unset($_SESSION['scanner']); // Pour pouvoir à la vente normale
                }
                    
                if (isset($_GET['scanner']) or !empty($_SESSION['scanner'])) {?>
                    <div class="navsearch">
                        <div class="navs"><a href="choix.php">ACCUEIL</a></div>                        
                        <div class="search">
                            <form method="GET" action="addpanierproformat.php" id="suite">

                                <input id="reccode" type = "search" name = "scanneur" placeholder="scanner un produit" onchange="document.getElementById('suite').submit()">
                            </form>
                        </div>
                        <a href="proformat.php?vente"><input style="width: 150%;height: 30px; font-size: 20px; background-color: red;color: white;"  type="submit" value="Saisir"></a>
                    </div><?php

                    if (!empty($_SESSION['scanner'])) {

                        $products = $DB->query("SELECT * FROM products WHERE codeb LIKE ? ",array("%".$_SESSION['scanner']."%"));
                        foreach ( $products as $product ): ?>

                            <div class="box">

                                <ul style="margin-left: -35px; margin-top: -15px; margin-bottom: 20px;">                            
                                    <li class="logo"><a href="addpanierproformat.php?desig=<?= $product->designation; ?>">

                                        <div class="descript_logo">
                                            <div class="designation"><?= $product->designation; ?></div>
                                            <div class="picture"><img alt=" " src="img/<?= $product->id ; ?>.jpg"></div>
                                            <div class="reste">Stock: <?= $product->quantite; ?></div>
                                            <div class="pricebox"><?= number_format($product->prix_vente,2,',',' '); ?></div>
                                        </div> </a>

                                    </li>

                                </ul>


                            </div>

                        <?php endforeach ?><?php
                    }

                }else{?>
                    <div class="navsearch">

                        <div class="navs"><a href="choix.php">ACCUEIL</a></div>
                        <div class="search">
                            <form method="GET" action="proformat.php" id="suite" name="term">

                                <input id="reccode" type = "search" name = "terme" placeholder="rechercher un produit" onKeyUp="suivant(this,'s', 4)" onchange="document.getElementById('suite').submit()"/>

                                <input name = "s"  style="width: 0px; height: 0px;" />

                            </form>
                        </div>
                        <a href="proformat.php?scanner"><input name = "s" style="width: 150%;height: 30px; font-size: 20px; background-color: red;color: white;"  type="submit" value="Scanner"></a>
                    </div>

                    <?php
                    if (isset($_GET['terme'])) {

                        if (isset($_GET["terme"])){

                            $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
                            $terme = $_GET['terme'];
                            $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                            $terme = strip_tags($terme); //pour supprimer les balises html dans la requête
                        }

                        if (isset($terme)){

                            $terme = strtolower($terme);
                            $products = $DB->query("SELECT * FROM products WHERE designation LIKE ? OR Marque LIKE ?",array("%".$terme."%", "%".$terme."%"));
                        }else{

                         $message = "Vous devez entrer votre requete dans la barre de recherche";

                        }

                        foreach ( $products as $product ): ?>

                            <div class="box">

                                <ul style="margin-left: -35px; margin-top: -15px; margin-bottom: 20px;">                            
                                    <li class="logo"><a href="addpanierproformat.php?desig=<?= $product->designation; ?>">

                                        <div class="descript_logo">
                                            <div class="designation"><?= $product->designation; ?></div>
                                            <div class="picture"><img alt=" " src="img/<?= $product->id ; ?>.jpg"></div>
                                            <div class="reste">Stock: <?= $product->quantite; ?></div>
                                            <div class="pricebox"><?= number_format($product->prix_vente,2,',',' '); ?></div>
                                        </div> </a>

                                    </li>

                                </ul>

                            </div>

                        <?php endforeach ?><?php


                    }elseif (isset($_GET['logo'])) {

                        $products = $DB->query('SELECT * FROM products  WHERE  name=:NAME ORDER BY (nbrevente) DESC' , array('NAME' => $_GET['logo']));

                        foreach ( $products as $product ): ?>

                            <div class="box">

                                <ul style="margin-left: -35px; margin-top: -15px; margin-bottom: 20px;">                          
                                    <li class="logo"><a href="addpanierproformat.php?desig=<?= $product->designation; ?>">

                                        <div class="descript_logo">
                                            <div class="designation"><?= $product->designation; ?></div>
                                            <div class="picture"><img alt=" " src="img/<?= $product->id ; ?>.jpg"></div>
                                            <div class="reste">Stock: <?= $product->quantite; ?></div>
                                            <div class="pricebox"><?= number_format($product->prix_vente,2,',',' '); ?></div>
                                        </div> </a>

                                    </li>

                                </ul> 

                            </div>

                        <?php endforeach ?><?php
                        
                   
                    }else{

                        $products = $DB->query('SELECT * FROM logo ORDER BY (name)');
                        

                        foreach ( $products as $product ){?>

                            <div class="box">
                                <ul style="margin-left: -35px; margin-top: -15px; margin-bottom: 20px;">                            
                                    <li class="logo"><a href="proformat.php?logo=<?= $product->name; ?>">

                                        <div class="descript_logo">

                                            <div class="designation"><?= ucfirst($product->name); ?></div>

                                            <div class="picture"><img alt=" " src="img/logo/<?= $product->name; ?>.jpg"></div>

                                            <div class="reste">Nbre de vente: <?= $product->nbrevente; ?></div>

                                        </div> </a>

                                    </li>

                                </ul>

                            </div><?php
                        }

                    }
                }?>
            </div>

            <div id="commande">

                <?php require 'panierproformat.php'; ?>              
                
            </div>

        </div><?php  
        
    }else{

        header("Location: form_connexion.php");

    }?>
    
</body>
</html>

<script type="text/javascript">
  function alerteS(){
    return(confirm('Valider la suppression'));
  }

  function focus(){
    document.getElementById('reccode').focus();
  }
</script>