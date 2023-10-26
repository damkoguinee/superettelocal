<?php
require '_header.php';?>
  
<!DOCTYPE html>
<html>


<head>
    <title>Logescom</title>
    <meta charset="utf-8">    
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/commande.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/client.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/sousmenu.css" type="text/css" media="screen" charset="utf-8">
</head>

    <body><?php

        if (isset($_GET['lienclient'])) {                      

            $client = $DB->querys('SELECT * FROM client WHERE id =?', 
                array($_GET['lienclient']));

             $connexion = $DB->querys('SELECT * FROM login WHERE telephone =?', 
                array($client['telephone']));

             $_SESSION['pseudo']=$connexion['pseudo']; 

            $etab=$DB->querys('SELECT *from adresse');

            $_SESSION['etab']=$etab['nom_mag'];

            $_SESSION['type']=$connexion['type'];

            $_SESSION['lieuvente']=$connexion['lieuvente'];
            $_SESSION['idpseudo']=$connexion['id'];
            $_SESSION['idcpseudo']=$client['id'];
            $_SESSION['statut']=$connexion['statut'];
            $_SESSION['level']=$connexion['level'];
        }

        if (isset($_SESSION['pseudo'])) {?>
            
            <div class="form_connexion" style="width: 100%;">
                <fieldset>

                    <legend style="margin: auto;">
                        <div style="font-family: cursive; font-size: 30px; text-align: center;"><?=ucwords($_SESSION['etab']);?></div>
                    </legend>                        

                    <fieldset style="border: 0px;">

                        <legend style="margin: auto;"><img width="40" height="40" src="css/img/symbole.png"></legend>

                        <div><?php require 'ficheclient.php'; ?></div>

                        <div class="choix">

                            <div class="option"><a href="factureclient.php?conectC">
                                <div class="picturec"><img src="css/img/compta.jpg"></div>
                                <div class="descript_option">Mes Factures</div></a>
                            </div>

                            <div class="option"><a href="factureclient.php?conectC&produitfac">
                                <div class="picturec"><img src="css/img/approv.jpg"></div>
                                <div class="descript_option">Produits Facturés</div></a>
                            </div>

                        </div>
                    </fieldset>
                </fieldset>
            </div><?php
        }else{
            header('Location:form_connexion.php');
        }?>     
    </body>
    
</html>