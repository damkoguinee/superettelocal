<?php require '_header.php';?>

<!DOCTYPE html>
<html>
<head>
    <title>Logespharma</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
</head>
<body><?php

    if (isset($_SESSION['pseudo'])){

        $pseudo=$_SESSION['pseudo'];

        $personnel = $DB->querysI('SELECT statut, nom FROM personnel WHERE pseudo= :PSEUDO', array('PSEUDO'=>$pseudo));?>    

        <div id="header">
            <div><a href="deconnexion.php" class="deconnexion"></a></div>

            

            <div style="margin-left: 40%;">

                <form method="POST" action="recherche.php">
                    <input style="width: 70%; font-size: 18px;" id="reccode"  type = "search" name = "rechercher" placeholder="rechercher un ticket">
                    <input  type = "submit" name = "s" value = "Rechercher">

                </form>

            </div>

            <div class="descript_option" style="color: green;"><?="Compte de ".ucwords($personnel['nom']);?> </div> 

        </div>

        <div><?php require'indicateur.php';?></div><?php

        $adress=$DB->querys('SELECT * FROM adresse ');?>

        <div id="home">

            <div class="choix">                

                <div class="option"><a href="index.php">
                    <div class="picturec"><img src="css/img/achat.jpg"></div>
                    <div class="descript_option">VENTES</div></a>
                </div>

                <div class="option"><a href="ajoutstock.php">
                    <div class="picturec"><img src="css/img/stock.jpg"></div>
                    <div class="descript_option">Stock</div></a>
                </div>                

                <div class="option"><a href="ajout.php">
                    <div class="picturec"><img src="css/img/ajout.jpg"></div>
                    <div class="descript_option">Produits</div></a>
                </div>

                <div class="option"><a href="ajout.php">
                    <div class="picturec"><img src="css/img/ajout.jpg"></div>
                    <div class="descript_option">Approvisionnment</div></a>
                </div>

                <div class="option"><a href="client.php">
                    <div class="picturec"><img src="css/img/client.jpg"></div>
                    <div class="descript_option">Clients</div></a>
                </div>

                <div class="option"><a href="client.php">
                    <div class="picturec"><img src="css/img/founisseur.jpg"></div>
                    <div class="descript_option">Fournisseurs</div></a>
                </div>

                <div class="option"><a href="personnel.php?enseig">
                    <div class="picturec"><img src="css/img/personnel.jpg"></div>
                    <div class="descript_option">Personnels</div></a>
                </div><?php  

                if ($personnel['statut']=="admin") {?>

                    <div class="option"><a href="admin.php">
                        <div class="picturec"><img src="css/img/admin.jpg"></div>
                        <div class="descript_option">ADMIN</div></a>
                    </div>

                    <div class="option"><a href="admindump.php">
                        <div class="picturec"><img src="css/img/dump.jpg"></div>
                        <div class="descript_option">EXTRACT BDD</div></a>
                    </div><?php

                }?>

            </div>

        </div><?php

    }else{

        header("Location: form_connexion.php");

    }?>
    
</body>
</html>