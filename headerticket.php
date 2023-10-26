<?php $adress = $DB->querys("SELECT * FROM adresse where lieuvente='{$_SESSION['lieuvente']}'");

  $total = 0;
  $total_tva = 0; ?>

  <div class="ticket">

    <table style="margin:auto; text-align: center;color: black; background: white;" >

      <tr>
        <th style="font-weight: bold; font-size: 22px; padding: 5px"><?php 

        if ($adress['nom_mag']=='SOGUICOM SARLU') {?>
          <img src="css/img/logo.jpg" width="300" height="80"><?php

        }else{?>
          <img src="css/img/logo.jpg" width="150" height="50"><?php echo $adress['nom_mag'];
        }?></th>
      </tr>

      <tr><td style="font-size: 14px;"><?=ucwords(strtolower($adress['type_mag'])); ?></td></tr>

      <tr><td style="font-size: 14px;"><?=ucwords(strtolower($adress['adresse'])); ?><br/> <br/></td></tr>

    </table>