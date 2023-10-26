<div class="choixg">                

  <div class="optiong">
    <a href="commande.php?livraison">
    <div class="descript_optiong" style="height: 35px;">Commandes</div></a>
  </div><?php  

  if ($_SESSION['level']>7) {?>

    <div class="optiong">
      <a href="repartitioncmd.php?livraison">
      <div class="descript_optiong" style="height: 35px;">Répartitions</div></a>
    </div>

    <div class="optiong">
      <a href="commandetrans.php?transfert">
      <div class="descript_optiong" style="height: 35px;">Transfert Produits</div></a>
    </div>

    <div class="optiong">
      <a href="transfertprodfrais.php?transfertfrais">
      <div class="descript_optiong" style="height: 35px;">Transfert avec Frais</div></a>
    </div>

    <div class="optiong">
      <a href="transfertprod.php?listetrans">
      <div class="descript_optiong" style="height: 35px;">Liste des Transferts</div></a>
    </div>         

    <div class="optiong">
      <a href="listeapprovisionnement.php?listeapp">
      <div class="descript_optiong" style="height: 35px;">Liste des Approv</div></a>
    </div>

    <div class="optiong">
      <a href="retourproduit.php?transfert">
      <div class="descript_optiong" style="height: 35px;">Retour Produit</div></a>
    </div>

    <div class="optiong">
      <a href="fourcommande.php?livraison">
      <div class="descript_optiong" style="height: 35px;">Passez commande</div></a>
    </div>

    <div class="optiong">
    <a href="fourlistecommande.php?livraison">
    <div class="descript_optiong" style="height: 35px;">Liste des Commandes</div></a>
  </div> <?php 
  }?>

    <div class="optiong">
      <a href="facture.php?facture">
      <div class="descript_optiong" style="height: 35px;">Factures</div></a>
    </div> 
 
</div>