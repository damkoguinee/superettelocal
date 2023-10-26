<?php $adress = $DB->querys("SELECT * FROM adresse where lieuvente='{$lieuvente}' ");

  $total = 0;
  $total_tva = 0; ?>



  <table style="margin:auto; width: 100%;  text-align: center;color: black; background: white; line-height: 5mm;" >

    <tr>
      <th style="font-weight: bold; font-size: 35px; padding: 5px"><?php 

      if ($adress['nom_mag']=='SOGUICOM SARLU') {?>
        <img src="css/img/logo.jpg" width="300" height="80"><?php

      }else{?>
        <?php echo $adress['nom_mag'];
      }?></th>
    </tr>

    <tr>
      <td style="font-size: 30px;"><?=$adress['type_mag']; ?></td>
    </tr>

    <tr>
      <td style="font-size: 30px;"><?=$adress['adresse']; ?></td>
    </tr>
  </table>