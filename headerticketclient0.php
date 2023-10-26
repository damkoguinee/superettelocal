<?php $adress = $DB->querys('SELECT * FROM adresse ');

  $total = 0;
  $total_tva = 0; ?>

<div class="ticket">

  <table style="width: 100%; margin:auto; text-align: center;color: black; background: white;" >

    <tr>
      <th style="font-weight: bold; font-size: 14px; padding: 5px"><?php echo $adress['nom_mag']; ?></th>
    </tr>

    <tr>

      <td style="font-size: 14px;">

        <?php echo $adress['type_mag']; ?><br />
        <?php echo($adress['adresse']); ?><br /> <br />

      </td>

    </tr>

    <tr>
      <td style="font-size:14px; text-align: right;"><?=ucwords($_SESSION['reclient']); ?></td>
    </tr>

  </table>