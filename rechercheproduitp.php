<?php
require '_header.php';

if (isset($_GET['user'])) {
	$user=(string) trim($_GET['user']);
	$req=$DB->query('SELECT *FROM productslist where designation LIKE ? LIMIT 20',array("%".$user."%"));

	if (isset($_GET['ajout'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="ajout.php?resultidprod=<?=$value->id;?>"><div><?=$value->designation;?></div></a><?php
		}
	}elseif (isset($_GET['stockgeneral'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="stockgeneral.php?recherchgen=<?=$value->id;?>"><div><?=$value->designation;?></div></a><?php
		}
	}elseif (isset($_GET['statproduit'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="statproduit.php?recherchgen=<?=$value->id;?>"><div><?=$value->designation;?></div></a><?php
		}
	}elseif (isset($_GET['stockmouv'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="stockmouv.php?desig=<?=$value->id;?>"><div><?=$value->designation;?></div></a><?php
		}
	}elseif (isset($_GET['transfert'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="commandetrans.php?termeliste=<?=$value->id;?>"><div><?=$value->designation;?></div></a><?php
		}
	}elseif (isset($_GET['retourp'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="retourproduit.php?termeliste=<?=$value->id;?>"><div><?=$value->designation;?></div></a><?php
		}
	}elseif (isset($_GET['retourc'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="retourproduitclient.php?termeliste=<?=$value->id;?>"><div><?=$value->designation;?></div></a><?php
		}
	}elseif (isset($_GET['repartition'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="repartitioncmd.php?termeliste=<?=$value->id;?>"><div><?=$value->designation;?></div></a><?php
		}
	}elseif (isset($_GET['pertes'])) {

		foreach ($req as $key