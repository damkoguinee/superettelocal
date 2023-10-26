<?php

  $pers1=$DB->querys('SELECT *from login where id=:type', array('type'=>$payement['vendeur']));?>

  <div style="margin-top:20px;"> 
  

    <div  style="margin-top: 0px; color: grey;">
      <label style="margin-left: 90px;">European Market</label>

      <label style="margin-left: 300px;"><?=$panier->adClient($_SESSION['reclient'])[0]; ?></label>
    </div>
  </div>
</page>