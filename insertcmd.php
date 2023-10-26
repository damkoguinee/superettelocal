<?php 

$date ='0000';

$prodnum = $DB->querys('SELECT max(id) AS max_id FROM achat ');

$numero_commande=$date + $prodnum['max_id'] + 1; //automatique



$numfact=$_POST['numfact'];//manuel
$pseudo=$_SESSION['idpseudo'];
$fraistotaux=$_POST['fraistot'];
//$fraistotaux=$_POST['fraistp']+$_POST['fraisdp']+$_POST['fraisa'];



$prodverif= $DB->querys('SELECT id FROM facture where numfact=:num',array('num'=>$numfact));


if (isset($_POST['payer'])){                         

    if ($_POST['lieuliv']!='multiples') {

        $nomtab=$panier->nomStock($_POST['lieuliv'])[1];

        $prod= $DB->query("SELECT id_produit, validcomande.designation as designation, `".$nomtab."`.quantite as qtites, validcomande.quantite as qtite, pachat, pvente, previent, frais, prix_revient FROM validcomande inner join `".$nomtab."` on `".$nomtab."`.idprod=id_produit where pseudo='{$_SESSION['idpseudo']}' order by(validcomande.id)");

        $prixreel=$panier->espace($_POST['prix_reel']); 

        if (isset($prixreel) AND $prixreel!="") {

            $datef=$_POST['datefact'];                           
            $fournisseur=$_POST['client'];
            $nomtab=$panier->nomStock($_POST['lieuliv'])[1];
            $lieuvente=$_POST['lieuliv'];                        


            foreach($prod as $product){

                $designation=$product->designation;
                $qtitestock=$product->qtites;
                $quantite= $product->qtite;
                $price_achat=$panier->espace(number_format($product->pachat*$_SESSION['taux'],0,',',''));
                $price_vente=$product->pvente;
                $price_revient=$panier->espace(number_format(($product->pachat*$_SESSION['taux'])+$product->frais,0,',',''));
                $previentstock=$product->prix_revient;
                $id_produitfac=$product->id_produit;
                $etatc='livre';
                

                $DB->insert('INSERT INTO achat (id_produitfac, numcmd, numfact, fournisseur, designation, quantite, taux, pachat, previent, pvente, etat, idstockliv, datefact, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($id_produitfac, 'cmd'.$numero_commande, $numfact, $fournisseur, $designation, $quantite, $_SESSION['taux'], $price_achat, $price_revient, $price_vente, $etatc, $lieuvente, $datef));

                $DB->insert('INSERT INTO stockmouv (idstock, idnomstock, numeromouv, libelle, quantitemouv, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id_produitfac, $lieuvente, 'cmd'.$numero_commande, 'entree', $quantite));

                $qtitetot=($qtitestock)+$quantite;

                if ($qtitestock<0) {

                    $qtitestock=0;
                }


                if (empty($previentstock)) {

                    $qtitestock=0;
                }

                $previenmoyen=(($price_revient*$quantite+$previentstock*$qtitestock)/($quantite+$qtitestock));

                $DB->insert("UPDATE `".$nomtab."` SET quantite = ? , prix_achat= ?, prix_revient=?, prix_vente= ?  WHERE idprod = ?", array($qtitetot, $price_achat, $previenmoyen, $price_vente, $id_produitfac));
            }

            $prixreeldevise=($prixreel/$_SESSION['taux']);
            $prixreel=($prixreel);

            $montantpdevise=($_POST['montantc']/$_SESSION['taux']);

            $etatc='livre';

            if (!empty($prixreel)) {

                $DB->insert('INSERT INTO facture (numcmd, numfact, datefact, fournisseur, taux, montantht, montantva, montantpaye, frais, modep, lieuvente, etatcf, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array('cmd'.$numero_commande, $numfact, $datef, $fournisseur, $_SESSION['taux'], $prixreel, 0, $_POST['montantc'], $fraistotaux, $_SESSION['devise'], $lieuvente, $etatc));

                $differnce=($prixreel);

                $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['client'], $differnce, $_SESSION['motif'], 'cmd'.$numero_commande, $_SESSION['devise'], 1, $lieuvente));
            }            

            if (!empty($_POST['frais'])) {

                $fraistrans=$_POST['frais'];
                $fraistransp=$_POST['fraistp'];
                $differncet=$fraistrans-$fraistransp;
                $transporteur=$_POST['clientt'];

                $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($transporteur, $differncet, "frais de trans (".'cmd'.$numero_commande.')', 'cmd'.$numero_commande, 'gnf', 1, $lieuvente));
            }

            if (!empty($_POST['fraisd'])) {

                $fraisdouane=$_POST['fraisd'];
                $fraisdouanepaye=$_POST['fraisdp'];
                $differnced=$fraisdouane-$fraisdouanepaye;  
                $douanier=$_POST['clientd'];

                $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($douanier, $differnced, "frais de douane (".'cmd'.$numero_commande.')', 'cmd'.$numero_commande, 'gnf', 1, $lieuvente));
            }

            if (!empty($_POST['fraisa'])) {

                $fraisautres=$_POST['fraisa'];
                $idcaisse=$panier->idCaisse($_SESSION['lieuvente'])[0];

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($idcaisse, -$fraisautres, "paiement autres frais (".'cmd'.$numero_commande.')', 'cmd'.$numero_commande, 'gnf', $_SESSION['lieuvente']));
            }

                

            $DB->delete('DELETE FROM validcomande where pseudo=?', array($_SESSION['idpseudo'])); //pour supprimer les produits validés 

            unset($_SESSION['panierc']);
            unset($_SESSION['panierca']);
            unset($_SESSION['paniercp']);
            unset($_SESSION['etat']);

            unset($_SESSION['taux']);
            unset($_SESSION['devise']);?>

            <div class="alerteV">Commande validée et stock mis à jour avec succèe!!</div><?php
            

        }else{?>

          <div class="alertes">Saisissez tous les champs vides</div><?php 

        } 

    }else{

        $prod= $DB->query("SELECT * FROM validcomande where pseudo='{$_SESSION['idpseudo']}' order by(validcomande.id)");

        $prixreel=$panier->espace($_POST['prix_reel']); 

        if (isset($prixreel) AND $prixreel!="") {

            $datef=$_POST['datefact'];                           
            $fournisseur=$_POST['client'];
            $nomtab='stock1';
            $lieuvente=0;                        


            foreach($prod as $product){

                $designation=$product->designation;
                $quantite= $product->quantite;
                $price_achat=$product->pachat*$_SESSION['taux'];
                $price_vente=$product->pvente;
                $price_revient=($product->pachat*$_SESSION['taux'])+$product->frais;
                $id_produitfac=$product->id_produit;
                $etatc='nonlivre';
                

                $DB->insert('INSERT INTO achat (id_produitfac, numcmd, numfact, fournisseur, designation, quantite, taux, pachat, previent, pvente, etat, idstockliv, datefact, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($id_produitfac, 'cmd'.$numero_commande, $numfact, $fournisseur, $designation, $quantite, $_SESSION['taux'], $price_achat, $price_revient, $price_vente, $etatc, $lieuvente, $datef));

                
            }

            $prixreeldevise=($prixreel/$_SESSION['taux']);
            $prixreel=($prixreel);

            $montantpdevise=($_POST['montantc']/$_SESSION['taux']);

            $etatc='livre';

            if (!empty($prixreel)) {

                $DB->insert('INSERT INTO facture (numcmd, numfact, datefact, fournisseur, taux, montantht, montantva, montantpaye, frais, modep, lieuvente, etatcf, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array('cmd'.$numero_commande, $numfact, $datef, $fournisseur, $_SESSION['taux'], $prixreel, 0, $_POST['montantc'], $fraistotaux, $_SESSION['devise'], $lieuvente, $etatc));

                $differnce=$prixreel;

                $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($_POST['client'], $differnce, $_SESSION['motif'], 'cmd'.$numero_commande, $_SESSION['devise'], 1, $lieuvente));
            }

            

            

            if (!empty($_POST['frais'])) {

                $fraistrans=$_POST['frais'];
                $fraistransp=$_POST['fraistp'];
                $differncet=$fraistrans-$fraistransp;
                $transporteur=$_POST['clientt'];

                $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($transporteur, $differncet, "frais de trans (".'cmd'.$numero_commande.')', 'cmd'.$numero_commande, 'gnf', 1, $lieuvente));
            }

            if (!empty($_POST['fraisd'])) {
                $fraisdouane=$_POST['fraisd'];
                $fraisdouanepaye=$_POST['fraisdp'];
                $differnced=$fraisdouane-$fraisdouanepaye;  
                $douanier=$_POST['clientd'];

                $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($douanier, $differnced, "frais de douane (".'cmd'.$numero_commande.')', 'cmd'.$numero_commande, 'gnf', 1, $lieuvente));
            }

            if (!empty($_POST['fraisa'])) {

                $fraisautres=$_POST['fraisa'];

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array(3, -$fraisautres, "paiement autres frais (".'cmd'.$numero_commande.')', 'cmd'.$numero_commande, 'gnf', $_SESSION['lieuvente']));
            }

                

            $DB->delete('DELETE FROM validcomande where pseudo=?', array($_SESSION['idpseudo'])); //pour supprimer les produits validés 

            unset($_SESSION['panierc']);
            unset($_SESSION['panierca']);
            unset($_SESSION['paniercp']);
            unset($_SESSION['etat']);

            unset($_SESSION['taux']);
            unset($_SESSION['devise']);?>

            <div class="alerteV">Commande validée et stock mis à jour avec succèe!!</div><?php
            

        }else{?>

          <div class="alertes">Saisissez tous les champs vides</div><?php 

        } 

    }


}else{

}  