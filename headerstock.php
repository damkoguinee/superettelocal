<fieldset style="margin-top: 10px;">

  <div class="choixg"><?php

    if ($products['level']>=3) {?>

      <div class="optiong">
        <a href="stockmouv.php">
        <div class="descript_optiong">Mouv Produit <?=$panier->nomStock($_SESSION['idnomstock'])[0];?></div></a>
      </div>

      <div class="optiong">
        <a href="stockgeneral.php?nomstock=<?=$_SESSION['idnomstock'];?>">
        <div class="descript_optiong">Voir <?=ucwords($panier->nomStock($_SESSION['idnomstock'])[0]);?></div></a>
      </div>

      <div class="optiong">
        <a href="pertes.php?listep&?nomstock=<?=$_SESSION['idnomstock'];?>">
        <div class="descript_optiong">Pertes <?=$panier->nomStock($_SESSION['idnomstock'])[0];?></div></a>
      </div><?php
    }?>
  </div>
</fieldset>