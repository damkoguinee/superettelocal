<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];

    $products = $DB->querys('SELECT statut FROM personnel WHERE pseudo= :PSEUDO',array('PSEUDO'=>$pseudo));

    if ($products['statut']!="vendeur") {

        require 'headercmd.php';

        $nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];

        if (isset($_POST['taux'])) {

            $_SESSION['taux']=$_POST['taux'];
            $_SESSION['devise']=$_POST['devise'];
        }

        if (isset($_POST['payer'])) {
            $_SESSION['motif']="Commande Fournisseur";
            $type="FOURNISSEUR";
            require 'insertcmd.php';
        }

        if (isset($_GET['delcmd'])) {

          $DB->delete('DELETE FROM achat WHERE id = ?', array($_GET['delcmd']));
        }?>

        <table class="tabpanierc" style="margin-top: 2px;">

            <thead>
                <form action="commande.php" method="POST">
                    <tr>
                        <th colspan="6" style="background-color:orange;">Dévise Facture 
                            <select name="devise" required=""><?php                                

                                if (!empty($_SESSION['taux'])) {?>

                                    <option value="<?=$_SESSION['taux'];?>"><?=strtoupper($_SESSION['devise']);?></option><?php
                                }else{?>
                                    <option></option><?php 
                                }

                              foreach($panier->monnaie as $value){?>

                                <option value="<?=$value;?>"><?=$value;?></option><?php
                              }?>
                            </select><?php

                                if (!empty($_SESSION['taux'])) {?>

                                    Saisir le Taux d'échange <input style="width:200px;" type="text" name="taux" onchange="this.form.submit()" value="<?=$_SESSION['taux'];?>" required="" ><?php 
                                }else{?>

                                    Saisir le Taux d'échange <input style="width:200px;" type="text" name="taux" onchange="this.form.submit()" required="" ><?php 

                                }?>
                        </th>
                    </tr>
                </form>
            </thead>
        </table><?php 

        if (!empty($_SESSION['taux'])) {?>

            <div class="expoc"><fieldset><legend>RECHERCHEZ LES PRODUITS</legend><?php
            if (isset($_GET['ventec'])) {
                unset($_SESSION['scannerc']); // Pour pouvoir à la vente normale
            }
            
            if (isset($_GET['scannerc']) or !empty($_SESSION['scannerc'])) {?>
                <div class="navsearch">                        
                    <div class="search">
                        <form method="GET" action="commande.php" id="suite">

                            <input id="reccode" type = "search" name = "scanneurc" placeholder="scanner un produit" onchange="document.getElementById('suite').submit()">
                        </form>
                    </div>
                    <a href="commande.php?ventec"><input style="width: 150%;height: 30px; font-size: 20px; background-color: red;color: white;"  type="submit" value="Saisir"></a>
                </div><?php
            }else{?>
                <div class="navsearch">
                    <div class="search">
                        <form method="GET" action="commande.php" id="suite" name="term">

                            <input id="reccode" type = "search" name = "terme" placeholder="rechercher un produit" onKeyUp="suivant(this,'s', 9)" onchange="document.getElementById('suite').submit()">
                            <input name = "s" style="width: 0px; height: 0px;" >
                        </form>
                    </div>
                    <a href="commande.php?scannerc"><input style="width: 150%;height: 30px; font-size: 20px; background-color: red;color: white;"  type="submit" value="Scanner"></a>
                </div><?php
            }
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

                }?>

                <div class="expoline"><?php

                    foreach ( $products as $product ){?>

                        <div class="boxc">
                            <nav_lateral>
                                <ul>                            
                                    <li class="logo"><a href="commande.php?desig=<?= $product->designation; ?>&idc=<?=$product->id;?>&pa=<?=$product->prix_achat;?>&pv=<?=$product->prix_vente;?>"><?php

                                        if ($product->type!='detail') {?>

                                            <div class="descript_logo"><?php

                                        }else{?>
                                        
                                            <div class="descript_logodet"><?php
                                        }?>
                                            <div class="designation"><?= $product->designation; ?></div>
                                            <div class="picture"><img alt=" " src="img/<?= $product->id ; ?>.jpg"></div>
                                            <div class="reste">Stock: <?= $product->quantite; ?></div>
                                            <div class="pricebox"><?= number_format($product->prix_revient,0,',',' '); ?></div>
                                        </div></a>

                                    </li>

                                </ul>

                            </nav_lateral>
                        </div><?php
                    }?>

                </div><?php
           
            }elseif (isset($_GET['logo'])) {

                $products = $DB->query("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id  WHERE  codecat=:NAME ORDER BY (`".$nomtab."`.nbrevente) DESC" , array('NAME' => $_GET['logo']));?>

                <div class="expoline"><?php                        

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

                            <ul style="margin-left: -35px; margin-top: 0px; margin-bottom: 20px;">                          
                                <li class="logo">
                                    
                                    <a href="commande.php?desig=<?= $product->designation; ?>&idc=<?=$product->id;?>&pa=<?=$product->prix_achat;?>&pv=<?=$product->prix_vente;?>"><?php

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
                    }?>
                </div><?php                
               
            }else{

                $products = $DB->query('SELECT * FROM categorie ORDER BY (nom)');?>

                <div class="expoline"><?php                        

                    foreach ( $products as $product ){?>

                        <div class="box">
                            <ul style="margin-left: -35px; margin-top: 0px; margin-bottom: 20px;">                            
                                <li class="logo"><a href="commande.php?logo=<?= $product->id; ?>">
                                    
                                    <div class="descript_logo">

                                        <div class="designation"><?= ucfirst(strtolower($product->nom)); ?></div>

                                        <div class="picture"><img alt=" " src="img/logo/<?= $product->nom; ?>.jpg"></div>
                                    </div> </a>

                                </li>

                            </ul>

                        </div><?php
                    }?>
                </div><?php

            }
        }?>

    </div></fieldset>


        <div id="panierc"><?php

            require 'panierc.php';?>
            
        </div><?php

    }else{

        echo "VOUS N'AVEZ PAS TOUTES LES AUTORISATIOS REQUISES";
    }

}else{


}?>

<script>
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }
    
    function suivant(enCours, suivant, limite){
        if (enCours.value.length >= limite)
        document.term[suivant].focus();
    }

    function focus(){
    document.getElementById('reccode').focus();
  }
</script>



