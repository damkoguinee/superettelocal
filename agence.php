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

        $personnel = $DB->querysI('SELECT statut, nom, level FROM personnel WHERE pseudo= :PSEUDO', array('PSEUDO'=>$pseudo));?>    

        <div id="header">

            <div><a href="deconnexion.php" class="deconnexion"></a></div>

            <div style="margin-left: 40%;">

                <form method="POST" action="recherche.php">
                    <input style="width: 70%; font-size: 18px;" id="reccode"  type = "search" name = "rechercher" placeholder="rechercher un ticket">
                    <input  type = "submit" name = "s" value = "Rechercher">

                </form>

            </div>

            <div class="descript_option" style=" background-color: white; color: green; height: 30px; margin: auto; text-align: center;"><?="Utilisateur Connecté: ".ucwords($personnel['nom']);?> </div> 

        </div>

        <div id="home"><?php
            if ($personnel['level']>=5) {?>
                <div style="margin-left: 20%;"></div>

                <div class="choixa">                
                    <div>
                        <a href="connexion.php?responsablea=<?='damkomateriauxstock';?>">
                        <div class="picturea"><img src="css/img/stock.jpg"></div></a>                    
                        <div class="descript_option">Stock</div></br>
                        <div class="descript_option">Madina</div>
                        <div class="descript_option">Centre Koumi</div>
                        <div class="descript_option">Tel: +224 623 63 78 69</div>
                        <div class="descript_option">Responsable: DIALLO Alpha Oumar</div>
                    </div>

                </div>

                <div class="choixa">
                    <div>
                        <a href="connexion.php?responsablea=<?='damkomateriaux1';?>">
                        <div class="picturea"><img src="css/img/agence.jpg"></div></a>                    
                        <div class="descript_option">Magasin Sonfonia</div></br>
                        <div class="descript_option">Sonfonia</div>
                        <div class="descript_option">SOS</div>
                        <div class="descript_option">Tel: +224 623 63 78 69</div>
                        <div class="descript_option">Responsable: DIALLO Karim</div>
                    </div>
                </div>

                <?php
                /*

                <div class="choixa">
                    <div>
                        <a href="connexion.php?responsablea=<?='magasin2';?>">
                        <div class="picturea"><img src="css/img/agence.jpg"></div></a>                    
                        <div class="descript_option">Boutique N°B10</div></br>
                        <div class="descript_option">Madina</div>
                        <div class="descript_option">Centre Madame Barry</div>
                        <div class="descript_option">Tel: 622 62 17 26</div>
                        <div class="descript_option">Responsable: SY Saliou</div>
                    </div>
                </div><?php
                */
            }?> 

        </div><?php
    }?>
    </body>
</html>             
                