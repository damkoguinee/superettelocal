<?php 

$numfact=$_POST['numcmd'];
$numero_commande=$numfact;
$pseudo=$_SESSION['idpseudo'];

$DB->delete('DELETE FROM fourachat WHERE numcmd = ?', array($numfact));
$DB->delete('DELETE FROM fourfacture WHERE numcmd = ?', array($numfact));

$prodverif= $DB->querys('SELECT id FROM fourfacture where numfact=:num',array('num'=>$numfact));


if (isset($_POST['payer'])){

    $nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];

    $prod= $DB->query("SELECT id_produit, fourvalidcomande.designation as designation, `".$nomtab."`.quantite as qtites, fourvalidcomande.quantite as qtite, pachat, pvente, previent, frais, prix_revient FROM fourvalidcomande inner join `".$nomtab."` on `".$nomtab."`.idprod=id_produit where pseudo='{$_SESSION['idpseudo']}' order by(fourvalidcomande.id)");

    $prixreel=$panier->espace($_POST['prix_reel']); 

    if (isset($prixreel) AND $prixreel!="") {                           
        $fournisseur=$_POST['client'];
        $nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];
        $lieuvente=$_SESSION['lieuvente']; 
        $_SESSION['taux']=1;  
        $_SESSION['devise']='gnf'; 
        $fraistotaux=0;                    


        foreach($prod as $product){

            $designation=$product->designation;
            $qtitestock=$product->qtites;
            $quantite= $product->qtite;
            $price_achat=$panier->espace(number_format($product->pachat*$_SESSION['taux'],0,',',''));
            $price_vente=$product->pvente;
            $price_revient=$panier->espace(number_format(($product->pachat*$_SESSION['taux'])+$product->frais,0,',',''));
            $previentstock=$product->prix_revient;
            $id_produitfac=$product->id_produit;
            $etatc='cmd';
            

            $DB->insert('INSERT INTO fourachat (id_produitfac, numcmd, numfact, fournisseur, designation, quantite, taux, pachat, previent, pvente, etat, idstockliv, datefact, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now(), now())', array($id_produitfac, $numero_commande, $numfact, $fournisseur, $designation, $quantite, $_SESSION['taux'], $price_achat, $price_revient, $price_vente, $etatc, $lieuvente));
        }

        

        $etatc='cmd';

        $DB->insert('INSERT INTO fourfacture (numcmd, numfact, datefact, fournisseur, taux, montantht, montantva, montantpaye, frais, modep, lieuvente, etatcf, datecmd) VALUES(?, ?, now(), ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($numero_commande, $numfact, $fournisseur, $_SESSION['taux'], $prixreel, 0, $_POST['montantc'], $fraistotaux, $_SESSION['devise'], $lieuvente, $etatc));

        $DB->delete('DELETE FROM fourvalidcomande where pseudo=?', array($_SESSION['idpseudo'])); //pour supprimer les produits validés 

        unset($_SESSION['panierc']);
        unset($_SESSION['panierca']);
        unset($_SESSION['paniercp']);
        unset($_SESSION['etat']);

        unset($_SESSION['taux']);
        unset($_SESSION['devise']);?>

        <div class="alerteV">Commande enregistrée avec succèe!!</div><?php
        

    }else{?>

      <div class="alertes">Saisissez tous les champs vides</div><?php 

    } 


}else{

}  