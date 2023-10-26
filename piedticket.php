

<table style="margin-top: 30px; font-size: 18px;color: black; background: white;">

  <tr>
    <td style="padding-bottom: 20px"><?="************************************Situation de vos comptes************************************"; ?></td>
  </tr>

  <tr>

    <td style="font-size: 16px; text-align: center;"><?php

      $name=$_SESSION['reclient'];?>

      <label style="padding-right: 30px;">Compte GNF: <?=number_format(($panier->soldeclientgen($name,'gnf')),0,',',' ');?></label><label style="background-color: white; color:white;">espa</label>

      <label style="margin-right: 10px;">Compte €: <?=number_format(($panier->soldeclientgen($name,'eu')),0,',',' ');?></label><label style="background-color: white; color:white;">espa</label>

      <label style="margin-right: 10px;">Compte $: <?=number_format(($panier->soldeclientgen($name,'us')),0,',',' ');?></label><label style="background-color: white; color:white;">espa</label>

      <label style="margin-right: 10px;">Compte CFA: <?=number_format(($panier->soldeclientgen($name,'cfa')),0,',',' ');?></label>
    </td>
  </tr>


  <tr>
    

    <?php
    if ($panier->soldeclientgen($name,'gnf')<0) {?>

      <td style="padding-right: 60px; padding-top: 30px;"><?="Madame/Monsieur, à la date du ".date("d/m/Y").", vous nous devez " .number_format(-($panier->soldeclientgen($name,'gnf')),0,',',' '); ?> GNF</td><?php

    }else{?>

      <td style="padding-right: 60px; padding-top: 30px;"><?="Madame/Monsieur, à la date du ".date("d/m/Y").", nous vous devons " .number_format($panier->soldeclientgen($name,'gnf'),0,',',' '); ?> GNF</td><?php
    }?>
  </tr>

  <tr>
    <td style="padding-top: 20px; font-size: 14px;">************<?=$adress['nom_mag']. " vous souhaite une excellente journée**************"; ?></td>
  </tr>

</table>