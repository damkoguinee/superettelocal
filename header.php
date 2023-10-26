<?php
require '_header.php'
?><!DOCTYPE html>
<html>
<head>
    <title>Logescom-ms</title>
    <meta charset="utf-8">    
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/commande.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/client.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/sousmenu.css" type="text/css" media="screen" charset="utf-8">
</head>

<body onload="return focus();"><?php
    $pseudo=$_SESSION['pseudo'];

    $products = $DB->querysI('SELECT level, statut FROM login WHERE pseudo=?',array($pseudo));?>

    <div id="header"><?php 

        if (!isset($_GET['conectC'])) {?>

            <div class="menu">

                <a href="choix.php" class="logo">ACCUEIL</a>

            </div>

            

            <div class="nav">
                <a href="versement.php?client" class="logo">Entrées</a><?php

                if ($_SESSION['level']>6) {?> 

                    <a href="dec.php?client" class="logo">Sorties</a>
                    <a href="top5.php" class="logo">Statistiques</a>

                    <a href="bulletin.php?compte" class="logo">Compte</a><?php

                    if ($_SESSION['level']>7) {?>                    

                        <a href="devise.php" class="logo">Devise</a>                   

                        <a href="promotion.php?promo" class="logo">Promotion</a><?php 
                    }
                }?>
                
                <a href="comptasemaine.php?journaliere=journa" class="logo">Comptabilite</a>
                           
                

            </div>

            <div class="dec"><a href="deconnexion.php" class="deconnexion"></a></div><?php 
        }else{?>

            <div class="menu">

                <a href="accueilclient.php" class="logo">ACCUEIL</a>

            </div><?php 
        }?>

        ?>
    </div>
    </div>