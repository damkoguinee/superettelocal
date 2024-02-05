<?php 

if (isset($_POST['num_cmd']) or isset($_GET['num_cmd'])) {


  if (isset($_POST['num_cmd'])) {
    
    $numero=$_POST['num_cmd'];
  }

  if (isset($_GET['num_cmd'])) {
    
    $numero=$_GET['num_cmd'];
  }

  //$prodtop=$DB->querys('SELECT id_client, montant, benefice FROM topclient WHERE id_client=?', array($_GET['client']));

  $prodliv=$DB->query("SELECT *FROM livraison inner join productslist on productslist.id=id_produitliv WHERE numcmdliv='{$numero}'");

    foreach ($prodliv as $prodcmd) {
      $idproduit=$prodcmd->id_produitliv;
      $designation=$prodcmd->designation;
      $qtitel=$prodcmd->quantiteliv;
      $nomtab=$panier->nomStock($prodcmd->idstockliv)[1];
      $idstock=$panier->nomStock($prodcmd->idstockliv)[2];
      $idclient=$prodcmd->id_clientliv;
      $typevente=$prodcmd->type;     
    
      $prodstock=$DB->querys("SELECT idprod, quantite FROM `".$nomtab."` WHERE idprod='{$idproduit}'");

      $quantite=$prodstock['quantite']+$qtitel;
      
      $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite, $idproduit));

      $DB->insert('INSERT INTO livraisondelete (id_produitliv, quantiteliv, numcmdliv, id_clientliv, idpersonnel, idstockliv, datedelete) VALUES(?, ?, ?, ?, ?, ?, now())', array($idproduit, $qtitel, $numero, $idclient, $_SESSION['idpseudo'], $idstock));
      
    }

    foreach ($prodliv as $prodcmd) {

      $designation=$prodcmd->id_produitliv;
      $qtitel=$prodcmd->quantiteliv;
      $nomtab=$panier->nomStock($prodcmd->idstockliv)[1];
      $idstock=$panier->nomStock($prodcmd->idstockliv)[2];
      $idclient=$prodcmd->id_clientliv;

      $numeroup='liv'.$numero;

      $prodmouv=$DB->querys('SELECT idstock, quantitemouv FROM stockmouv WHERE idstock= :DESIG and numeromouv=:numero' , array('DESIG'=>$designation, 'numero'=>$numeroup));                  

      $quantite=$prodmouv['quantitemouv']+$qtitel;
    
      $DB->insert("UPDATE stockmouv SET quantitemouv ='{$quantite}' WHERE idstock ='{$designation}' and numeromouv='{$numeroup}' and idnomstock='{$idstock}'" );
      
    }

    // Pour remettre de qtite dans les cartons si detail est tres grand

    foreach ($prodliv as $prodcmd) {

      $nom=$prodcmd->Marque;
      $designation=$prodcmd->id_produitliv;
      $qtitel=$prodcmd->quantiteliv;
      $nomtab=$panier->nomStock($prodcmd->idstockliv)[1];
      $idstock=$panier->nomStock($prodcmd->idstockliv)[2];
      $idclient=$prodcmd->id_clientliv;
      $typevente=$prodcmd->type;
      $type='detail';

      if ($typevente=='detail') {     

        $prodstock=$DB->querys("SELECT Marque, quantite, qtiteintd, productslist.qtiteintp as qtiteintp FROM `".$nomtab."` inner join productslist on idprod=productslist.id WHERE idprod='{$designation}'");

        $qtite=$prodstock['quantite'];
        $liaison=$prodstock['Marque'];

        $type='en_gros';

        $prodcart=$DB->querys("SELECT idprod, quantite, qtiteintd, productslist.qtiteintp as qtiteintp FROM `".$nomtab."`inner join productslist on idprod=productslist.id WHERE Marque='{$liaison}' and productslist.type='{$type}'");

        

        $qtiteint=$prodcart['qtiteintd'];

        $plus=$prodcart['quantite']+1;

        $idcarton=$prodcart['idprod'];          

        $reste=$qtite-$qtiteint;
          

        $moyens=$qtite-$qtiteint;


        if ($reste>0) {

          $DB->insert("UPDATE `".$nomtab."`  SET quantite ='{$plus}' WHERE idprod='{$idcarton}' ");

          $type='detail';

          $DB->insert("UPDATE `".$nomtab."` SET quantite ='{$moyens}' WHERE idprod='{$designation}' and type='{$type}'");
        }
      }
      
    }

    // Pour remettre de qtite dans les cartons si paquet est tres grand

    foreach ($prodliv as $prodcmd) {

      $nom=$prodcmd->Marque;
      $designation=$prodcmd->id_produitliv;
      $qtitel=$prodcmd->quantiteliv;
      $nomtab=$panier->nomStock($prodcmd->idstockliv)[1];
      $idstock=$panier->nomStock($prodcmd->idstockliv)[2];
      $typevente=$prodcmd->type;
      $type='paquet';

      if ($typevente=='paquet') {

        $prodstock=$DB->querys("SELECT Marque, quantite, qtiteintd, productslist.qtiteintp as qtiteintp FROM `".$nomtab."`inner join productslist on idprod=productslist.id WHERE idprod='{$designation}' ");

        $qtite=$prodstock['quantite'];
        $liaison=$prodstock['Marque'];

        $type='en_gros';

        $prodcart=$DB->querys("SELECT idprod, quantite, qtiteintd, productslist.qtiteintp as qtiteintp FROM `".$nomtab."`inner join productslist on idprod=productslist.id WHERE Marque='{$liaison}' and productslist.type='{$type}'");

        $qtiteint=$prodcart['qtiteintp'];

        $plus=$prodcart['quantite']+1;
        $idcarton=$prodcart['idprod']; 
          

        $reste=$qtite-$qtiteint;
          

        $moyens=$qtite-$qtiteint;


        if ($reste>0) {

          $DB->insert("UPDATE `".$nomtab."` SET quantite ='{$plus}' WHERE idprod='{$idcarton}'");

          $type='paquet';

          $DB->insert("UPDATE `".$nomtab."` SET quantite ='{$moyens}' WHERE idprod='{$designation}' and type='{$type}'");
        }
      }
    }

    $prodcmd=$DB->query("SELECT *FROM commande WHERE num_cmd='{$numero}'");

    $prodpaie=$DB->querys("SELECT *FROM payement WHERE num_cmd='{$numero}'");
  
    $idstockdel=$prodpaie['lieuvente'];
    $totalsup=$prodpaie['Total'];
  
    $montantsup=$prodpaie['montantpaye'];
  
    $remise=$prodpaie['remise'];
  
    foreach ($prodcmd as $valuec) {
  
      $DB->insert('INSERT INTO ventedelete (id_produit, prix_vente, prix_revient, quantity, num_cmd, id_client, idpersonnel, idstock, datedelete) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($valuec->id_produit, $valuec->prix_vente, $valuec->prix_revient, $valuec->quantity, $valuec->num_cmd, $valuec->id_client, $_SESSION['idpseudo'], $idstockdel));
    }

  $DB->delete('DELETE FROM payement WHERE num_cmd = ?', array($numero));

  $DB->delete('DELETE FROM bulletin WHERE numero = ?', array($numero));

  $DB->delete('DELETE FROM commande WHERE num_cmd = ?', array($numero));
  //$DB->delete('DELETE FROM stockmouv WHERE num_cmd = ?', array($numero));

  $DB->delete('DELETE FROM historique WHERE num_cmd = ?', array($numero));

  $DB->delete('DELETE FROM versement WHERE numcmd = ?', array($numero));

  $DB->delete('DELETE FROM fraisup WHERE numcmd = ?', array($numero));

  $DB->delete('DELETE FROM banque WHERE numero = ?', array('vente'.$numero));

  $DB->delete('DELETE FROM banque WHERE numero = ?', array('fsup'.$numero));

  $DB->delete('DELETE FROM decaissement WHERE numdec = ?', array('reli'.$numero));

  $DB->delete('DELETE FROM livraison WHERE numcmdliv = ?', array($numero));

  $DB->delete('DELETE FROM modep WHERE numpaiep = ?', array($numero));

  $prodp=$DB->querys('SELECT num_cmd FROM payement WHERE num_cmd= ?', array($numero));   
  

  

  if (empty($prodp)) {?>

    <div class="alerteV">Commande supprimée avec sucèe!!</div><?php

  }else{?>

    <div class="alertes">Commande non supprimée!!</div><?php

  }

}else{}?>