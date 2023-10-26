<?php require '_header.php';?>

<!DOCTYPE html>
<html>
<head>
    <title>Logescom-ms</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
</head>
<body><?php 

    if (isset($_SESSION['pseudo'])){

        $pseudo=$_SESSION['pseudo'];

        $personnel = $DB->querysI('SELECT id, statut, nom, level FROM login WHERE pseudo= :PSEUDO', array('PSEUDO'=>$pseudo));?>    

        <div id="header">
            <div><a href="deconnexion.php" class="deconnexion"></a></div>

            

            <div style="margin-left: 40%;">

                <form method="POST" action="recherche.php">
                    <input style="width: 70%; font-size: 18px;" id="reccode"  type = "search" name = "rechercher" placeholder="rechercher un ticket">
                    <input  type = "submit" name = "s" value = "Rechercher">

                </form>

            </div>

            <div class="descript_option" style="color: red;"><?="Compte d'utilisateur ".ucwords($personnel['id']);?> </div> 

        </div>

        <div><?php 

            if (isset($_POST['magasin'])) {

                $_SESSION['lieuventealerte']=$_POST['magasin'];
            }else{

                $_SESSION['lieuventealerte']=$_SESSION['lieuvente'];

            }

            $nomtab=$panier->nomStock($_SESSION['lieuventealerte'])[1];
            $nomtab1=$panier->nomStock($_SESSION['lieuventealerte'])[0];

            $idstock=$panier->nomStock($_SESSION['lieuventealerte'])[2];

            

            require'indicateur.php';?>
                
        </div><?php

        $adress=$DB->querys('SELECT * FROM adresse ');?>

        <div id="home">

            <div class="choix">

                <div class="option"><a href="index.php">
                    <div class="picturec"><img src="css/img/achat.jpg"></div>
                    <div class="descript_option">Ventes</div></a>
                </div>
                

                <div class="option"><a href="client.php">
                    <div class="picturec"><img src="css/img/client.jpg"></div>
                    <div class="descript_option">Clients</div></a>
                </div>

                <div class="option"><a href="editionfacturefournisseur.php">
                    <div class="picturec"><img src="css/img/approv.jpg"></div>
                    <div class="descript_option">Approvisionnment</div></a>
                </div> 

                <div class="option"><a href="ajout.php?ajoutprod">
                    <div class="picturec"><img src="css/img/stock.jpg"></div>
                    <div class="descript_option">Nouveau Prod</div></a>
                </div> <?php  

                if ($_SESSION['level']>=6) {?>

                    <div class="option"><a href="dec.php?client">
                        <div class="picturec"><img src="css/img/retrait.jpg"></div>
                        <div class="descript_option">Sorties</div></a>
                    </div>

                     <?php 

                    if ($_SESSION['level']>7) {?> 

                        <div class="option"><a href="livraisonachat.php">
                            <div class="picturec"><img src="css/img/livraison.jpg"></div>
                            <div class="descript_option">Livraison</div></a>
                        </div>

                        

                        <div class="option"><a href="commande.php">
                            <div class="picturec"><img src="css/img/approv.jpg"></div>
                            <div class="descript_option">Commande</div></a>
                        </div><?php 
                    }

                    if ($_SESSION['level']>6) {?>

                        <div class="option"><a href="personnel.php?enseig">
                            <div class="picturec"><img src="css/img/personnel.jpg"></div>
                            <div class="descript_option">Personnels</div></a>
                        </div>

                        <div class="option"><a href="banque.php">
                            <div class="picturec"><img src="css/img/transfert.jpg"></div>
                            <div class="descript_option">Transfert des fonds</div></a>
                        </div><?php 
                    }?>

                        

                    <div class="option"><a href="bulletin.php?compte">
                        <div class="picturec"><img src="css/img/compte.jpg"></div>
                        <div class="descript_option">Compte</div></a>
                    </div>

                

                    <div class="option"><a href="ajoutstock.php">
                        <div class="picturec"><img src="css/img/stock.jpg"></div>
                        <div class="descript_option">Gestion Stock</div></a>
                    </div><?php 
                }?> 

                 

                    <div class="option"><a href="comptasemaine.php">
                        <div class="picturec"><img src="css/img/compta.jpg"></div>
                        <div class="descript_option">Comptabilite</div></a>
                    </div>

                    <div class="option"><a href="versement.php?client">
                        <div class="picturec"><img src="css/img/versement.jpg"></div>
                        <div class="descript_option">Entrée</div></a>
                    </div>                

            </div>

        </div><?php

    }else{

        header("Location: form_connexion.php");

    }?>
    
</body>
</html>