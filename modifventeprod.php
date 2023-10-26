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

    $nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];

    if (isset($_SESSION['pseudo'])){

        if (empty($_SESSION['numcmdmodif']) and !isset($_GET['numcmdmodif'])) {

            header("Location: facturations.php");

        }else{?>    

            <div id="home">

                <div class="expo"><?php
                    if (isset($_GET['vente']) or isset($_GET['logo'])) {
                        unset($_SESSION['scanner']); // Pour pouvoir à la vente normale
                    }
                        
                    if (isset($_GET['scanner']) or !empty($_SESSION['scanner'])) {?>
                        <div class="navsearch">
                            <div class="navs"><a href="facturations.php?deletemodif">Retour</a></div>                        
                            <div class="search">
                                <form method="GET" action="modifventeprod.php" id="suite">

                                    <input id="reccode" type = "search" name = "scanneur" placeholder="scanner un produit" onchange="document.getElementById('suite').submit()">
                                </form>
                            </div>
                            <a href="modifventeprod.php?vente"><input style="width: 150%;height: 30px; font-size: 20px; background-color: red;color: white;"  type="submit" value="Saisir"></a>
                        </div><?php

                        if (!empty($_SESSION['scanner'])) {

                            $products = $DB->query("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id WHERE `".$nomtab."`.codeb LIKE ? ",array("%".$_SESSION['scanner']."%"));
                        foreach ( $products as $product ): ?>

                            <div class="box">

                                <ul style="margin-left: -35px; margin-top: -15px; margin-bottom: 20px;">                            
                                    <li class="logo">
                                        
                                        <a href="modifventeprod.php?desig=<?= $product->designation;?>&idc=<?= $product->id;?>&pv=<?= $product->prix_vente;?>"><?php

                                        if ($product->type!='detail') {?>

                                            <div class="descript_logo"><?php

                                        }else{?>
                                        
                                            <div class="descript_logodet"><?php
                                        }?>
                                            <div class="designation"><?= ucwords(strtolower($product->designation)); ?></div>
                                            <div class="picture"><img alt=" " src="img/<?= $product->id ; ?>.jpg"></div>
                                            <div class="pricebox"><?= number_format($product->pventel,2,',',' '); ?></div>
                                        </div> </a>

                                    </li>

                                </ul>


                            </div>

                        <?php endforeach ?><?php
                        }

                    }else{?>
                        <div class="navsearch">

                            <div class="navs"><a href="facturations.php?deletemodif">Retour</a></div>
                            <div class="search">
                                <form method="GET" action="modifventeprod.php" id="suite" name="term">

                                    <input id="reccode" type = "search" name = "terme" placeholder="rechercher un produit" onKeyUp="suivant(this,'s', 15)" onchange="document.getElementById('suite').submit()"/>

                                    <input name = "s"  style="width: 0px; height: 0px;" />

                                </form>
                            </div>
                            <a href="modifventeprod.php?scanner"><input name = "s" style="width: 150%;height: 30px; font-size: 20px; background-color: red;color: white;"  type="submit" value="Scanner"></a>
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
                            $products = $DB->query("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id WHERE designation LIKE ? OR Marque LIKE ?",array("%".$terme."%", "%".$terme."%"));
                        }else{

                         $message = "Vous devez entrer votre requete dans la barre de recherche";

                        }

                        foreach ( $products as $product ){

                            $qtites=0;
                            foreach ($panier->listeStock() as $valueS) {

                                $prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where productslist.id='{$product->id}' ");

                                $qtites+=$prodstock['qtite'];

                                
                            }

                            $etatliv='nonlivre';

                            $prodcmd=$DB->querys("SELECT sum(qtiteliv) as qtite FROM commande where id_produit='{$product->id}' and etatlivcmd='{$etatliv}' ");

                            $restealivrer=$qtites-$prodcmd['qtite'];

                            $qtitetab=$product->quantite;?>

                            <div class="box">

                                <ul style="margin-left: -35px; margin-top: -15px; margin-bottom: 20px;">                            
                                    <li class="logo">
                                        
                                        <a href="modifventeprod.php?desig=<?= $product->designation;?>&idc=<?= $product->id;?>&pv=<?= $product->prix_vente;?>"><?php

                                        if ($product->type!='detail') {?>

                                            <div class="descript_logo"><?php

                                        }else{?>
                                        
                                            <div class="descript_logodet"><?php
                                        }?>
                                            <div class="designation"><?= ucwords(strtolower($product->designation)); ?></div>
                                            <div class="picture"><img alt=" " src="img/<?= $product->id ; ?>.jpg"></div>

                                            <div class="reste">Reste: <?= $qtitetab.' / '.$restealivrer; ?></div>
                                            <div class="pricebox"><?= number_format($product->prix_vente,0,',',' '); ?></div>
                                        </div> </a>

                                    </li>

                                </ul>

                            </div> <?php
                        }


                        }elseif (isset($_GET['logo'])) {

                            $products = $DB->query("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id  WHERE  codecat=:NAME ORDER BY (`".$nomtab."`.nbrevente) DESC" , array('NAME' => $_GET['logo']));

                        foreach ( $products as $product ){

                            $qtites=0;
                            foreach ($panier->listeStock() as $valueS) {

                                $prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where productslist.id='{$product->id}' ");

                                $qtites+=$prodstock['qtite'];

                                
                            }

                            $etatliv='nonlivre';

                            $prodcmd=$DB->querys("SELECT sum(qtiteliv) as qtite FROM commande where id_produit='{$product->id}' and etatlivcmd='{$etatliv}' ");

                            $restealivrer=$qtites-$prodcmd['qtite'];

                            $qtitetab=$product->quantite; ?>

                            <div class="box">

                                <ul style="margin-left: -35px; margin-top: -15px; margin-bottom: 20px;">                          
                                    <li class="logo">
                                        
                                        <a href="modifventeprod.php?desig=<?= $product->designation;?>&idc=<?= $product->id;?>&pv=<?= $product->prix_vente;?>"><?php

                                        if ($product->type!='detail') {?>

                                            <div class="descript_logo"><?php

                                        }else{?>
                                        
                                            <div class="descript_logodet"><?php
                                        }?>
                                                <div class="designation"><?= ucwords(strtolower($product->designation)); ?></div>
                                                <div class="picture"><img alt=" " src="img/<?= $product->id ; ?>.jpg"></div>
                                                <div class="reste">Reste: <?= $qtitetab.' / '.$restealivrer; ?></div>
                                                <div class="pricebox"><?= number_format($product->prix_vente,0,',',' '); ?></div>
                                            </div>
                                        </a>

                                    </li>

                                </ul> 

                            </div><?php
                        }
                            
                       
                        }else{

                            $products = $DB->query('SELECT * FROM categorie ORDER BY (nom)');
                        

                        foreach ( $products as $product ){?>

                            <div class="box">
                                <ul style="margin-left: -35px; margin-top: -15px; margin-bottom: 20px;">                            
                                    <li class="logo"><a href="modifventeprod.php?logo=<?= $product->id; ?>">
                                        
                                        <div class="descript_logo">

                                            <div class="designation"><?= ucfirst(strtolower($product->nom)); ?></div>

                                            <div class="picture"><img alt=" " src="img/logo/<?= $product->nom; ?>.jpg"></div>
                                        </div> </a>

                                    </li>

                                </ul>

                            </div><?php
                        }

                        }
                    }?>
                </div>

                <div id="commande">

                    <?php require 'modifventepanier.php'; ?>              
                    
                </div>

            </div><?php
        }  
        
    }else{

        header("Location: form_connexion.php");

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
                    url: 'recherche_utilisateur.php?modifvente',
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

  function alerteM(){
    return(confirm('Voulez-vous vraiment modifier cette vente?'));
  }

  function focus(){
    document.getElementById('reccode').focus();
  }
</script>

