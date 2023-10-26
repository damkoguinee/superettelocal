<?php 

$client = $DB->querys('SELECT * FROM client WHERE id =?', 
    array($_SESSION['idcpseudo']));?>

<div style="font-size: 25px; margin-bottom: 30px;">
    <div><?=$panier->nomClient($client['id']);?></div>
    <div>Téléphone: <?=$client['telephone'];?></div>
    <div>E-mail: <?=$client['mail'];?></div>
    <div>Adresse: <?=$client['adresse'];?></div>
</div>

<fieldset style="font-size: 25px;"><legend>Solde de mes Comptes:</legend>

    <div style="font-size: 30px;">

        <label style="padding-right: 50px;"><a href="bilan.php?bclient=<?=$client['id'];?>&devise=gnf&conectC">GNF: <?=number_format($panier->compteClient($client['id'], 'gnf'),0,',',' '); ?></a></label>

        <label style="padding-right: 50px;"><a href="bilan.php?bclient=<?=$client['id'];?>&devise=eu&conectC"> € : <?=number_format($panier->compteClient($client['id'], 'eu'),0,',',' '); ?></a></label>

        <label style="padding-right: 50px;"><a href="bilan.php?bclient=<?=$client['id'];?>&devise=us&conectC"> $ : <?=number_format($panier->compteClient($client['id'], 'us'),0,',',' '); ?></a></label>

        <label style="padding-right: 50px;"><a href="bilan.php?bclient=<?=$client['id'];?>&devise=cfa&conectC">CFA: <?=number_format($panier->compteClient($client['id'], 'cfa'),0,',',' '); ?></a></label>
    </div>
</fieldset>

