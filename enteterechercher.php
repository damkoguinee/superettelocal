<fieldset style="margin-top: 10px;"><legend>Voulez-vous</legend>
  <div class="choixg">
    <?php 

    if (!empty($_SESSION['proformat'])) {?>

      <div class="optiong">
        <a href="printproformat.php?ticket&proformat=<?=$_SESSION['num_cmdp'];?>" target="_blank"><div class="descript_optiong">Imprimer le Proformat</div></a><?php //unset($_SESSION['num_cmdp']);?>
      </div><?php

      unset($_SESSION['proformat']); 
    }else{

      if (isset($_GET['recreditc'])) {

        $_SESSION['num_cmdp']=$_GET['recreditc'];
      }?>

      <div class="optiong">
        <a href="ticket_pdf.php?ticket" target="_blank"><div class="descript_optiong">Facture Petit Format</div></a>
      </div>

      <div class="optiong">
        <a href="printticket.php?ticket" target="_blank"><div class="descript_optiong">Imprimer la Facture</div></a>
      </div>

       <div class="optiong">
        <a href="prepacommande.php?bon" target="_blank"><div class="descript_optiong">Prépa-Commandes</div></a>
      </div>

      <div class="optiong">
        <a href="boncommande.php?bon" target="_blank"><div class="descript_optiong">Bon de Livraison</div></a>
      </div> <?php 
    }?>

     <div class="optiong">
          <a href="index.php?indexr"><div class="descript_optiong">Allez dans vente</div></a>
      </div> 

      <div class="optiong">
        <a href="choix.php?ajouterc"><div class="descript_optiong">Accueil</div></a>
      </div>
  </div>
</fieldset>