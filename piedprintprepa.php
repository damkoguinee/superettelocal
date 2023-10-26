<?php

  $pers1=$DB->querys('SELECT *from login where id=:type', array('type'=>$_SESSION['idpseudo']));?>

  <div style="margin-top:20px;">

  <div  style="margin-top: 20px; color: grey;">
    <label style="margin-left: 20px; font-style: italic;">Préparateur</label>

    <label style="margin-left: 150px;"><?=ucwords($pers1['statut']);?></label>
  </div>
 

  <div class="pied" style="margin-top: 80px; color: grey;">
    <label style="margin-left: 10px;"></label>

    <label style="margin-left: 200px;"><?=ucwords($pers1['nom']);?></label>
  </div>
</div>

   
</page>