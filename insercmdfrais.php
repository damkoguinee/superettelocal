<?php

if (isset($_POST['payer'])) {

  $date ='0000';

  $prodnum = $DB->querys('SELECT max(id) AS max_id FROM achat ');

  $numero_commande=$date + $prodnum['max_id'] + 1; //automatique

  $nomtab1=$_SESSION['nomtab'];

  $idstock1=$_SESSION['idstock1'];

  $nomtab2=$panier->nomStock($_POST['lieuliv'])[1];

  $idstock2=$_POST['lieuliv'];


  $prod= $DB->query("SELECT *FROM validcomandefrais where pseudo='{$_SESSION['idpseudo']}' order by(validcomandefrais.id)");


  foreach ($prod as $key => $value) {


    $id=$value->id_produit;

    $qtite=$value->quantite;

    $depart = $DB->querys("SELECT quantite as qtite FROM `".$nomtab1."` WHERE idprod=?", array($id));

    $qtited=$depart['qtite']-$qtite;

    $DB->insert("UPDATE `".$nomtab1."` SET quantite= ? WHERE idprod = ?", array($qtited, $id));

    $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'transp', 'sortie', -$qtite, $idstock1));


    $reception = $DB->querys("SELECT quantite as qtite, prix_revient as prs FROM `".$nomtab2."` WHERE idprod=?", array($id));

    $qtiter=$reception['qtite']+$qtite;

    $id_produitfac=$id;
    $numfact='transf'.$numero_commande;
    $fournisseur=$nomtab1;
    $designation=$value->designation;
    $quantite=$qtite;
    $qtitestock=$reception['qtite'];
    $taux=1;
    $price_achat=$value->pachat;
    $previentstock=$reception['prs'];
    $price_revient=$value->pachat+$value->frais;
    $price_vente=$value->pvente;
    $etatc='livre';
    $lieuvente=$idstock2;
    $datef=$_POST['datefact'];

    $prixreel=$panier->espace($_POST['prix_reel']);

    $fraistotaux=$_POST['fraistot'];

    $caisse=$panier->nomBanqueCaissePrincipal($idstock2, 'caisse');

    if ($reception['qtite']<0) {

      $qtitestock=0;
    }


    if (empty($previentstock)) {

      $qtitestock=0;
    }

    $previenmoyen=(($price_revient*$quantite+$previentstock*$qtitestock)/($quantite+$qtitestock));

    $DB->insert("UPDATE `".$nomtab2."` SET quantite = ? , prix_revient=?  WHERE idprod = ?", array($qtiter, $previenmoyen, $id));

    $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'transp', 'entree', $qtite, $idstock2));

    $DB->insert('INSERT INTO transferprod (idprod, stockdep, quantitemouv, stockrecep, exect, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, $idstock1, $qtite, $idstock2, $_SESSION['idpseudo']));

    

    $DB->insert('INSERT INTO achat (id_produitfac, numcmd, numfact, fournisseur, designation, quantite, taux, pachat, previent, pvente, etat, idstockliv, datefact, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($id_produitfac, 'transf'.$numero_commande, $numfact, $idstock1, $designation, $quantite, $taux, $price_achat, $price_revient, $price_vente, $etatc, $lieuvente, $datef));
  }

  if (!empty($prixreel)) {

    $DB->insert('INSERT INTO facture (numcmd, numfact, datefact, fournisseur, taux, montantht, montantva, montantpaye, frais, modep, lieuvente, type, etatcf, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array('transf'.$numero_commande, 'transf'.$numero_commande, $datef, $idstock1, 1, 0, 0, 0, $fraistotaux, 'gnf', $lieuvente, 'transfert', $etatc));
  } 

  if (!empty($_POST['frais'])) {

    $fraistrans=$_POST['frais'];
    $fraistransp=$_POST['fraistp'];
    $differncet=$fraistrans-$fraistransp;
    $transporteur=$_POST['clientt'];

   $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($transporteur, $differncet, "frais de trans (".'transf'.$numero_commande.')', 'transf'.$numero_commande, 'gnf', 1, $lieuvente));
  }

  if (!empty($_POST['fraisa'])) {

    $fraisautres=$_POST['fraisa'];

    $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($caisse, -$fraisautres, "paiement autres frais (".'transf'.$numero_commande.')', 'transf'.$numero_commande, 'gnf', $lieuvente));
  }

  $DB->delete('DELETE FROM validcomandefrais where pseudo=?', array($_SESSION['idpseudo'])); //pour supprimer les produits validés 
  unset($_SESSION['magasinfrais']);

  unset($_GET, $_POST);
}?>