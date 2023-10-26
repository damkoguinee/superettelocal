<?php
require '_header.php';
header("Content-type: text/csv;");

if (isset($_GET['stock'])) {
	header("Content-disposition: attachment; filename=payement stock.csv");

    $stock=$_GET['stock'];

    $newReservations = $DB->query("SELECT designation, productslist.codeb as codeb, prix_achat, prix_revient, prix_vente, quantite, dateperemtion, `".$_SESSION['nomtab']."`.id as id, productslist.type as type, productslist.qtiteint as qtiteint, productslist.qtiteintp as paquet FROM `".$stock."` inner join productslist on idprod=productslist.id ORDER BY (designation) ");?>
	Ordre;"designation";"codebarre";"type";"qtiteint";"qtiteintp";"quantite";"Prix-Achat";"Prix-Revient";"Prix-Vente";"Tot Achat";"Tot Revient";"Tot-Vente";<?php
	$totachat=0;
	$totrevient=0;
	$totvente=0;
	$quantite=0;
	foreach($newReservations as $key => $row) {

		$totachat+=$row->prix_achat*$row->quantite;
        $totrevient+=$row->prix_revient*$row->quantite;
        $totvente+=$row->prix_vente*$row->quantite;
        $quantite+=$row->quantite;

        echo "\n".'"'.($key+1).'";"'.$row->designation.'";"'.$row->codeb.'";"'.$row->type.'";"'.$row->qtiteint.'";"'.$row->paquet.'";"'.$row->quantite.'";"'.$row->prix_achat.'";"'.$row->prix_revient.'";"'.$row->prix_vente.'";"'.$totachat.'";"'.$totrevient.'";"'.$totvente.'"';

	    
	}
}

if (isset($_GET['vente'])) {
	header("Content-disposition: attachment; filename=payement produitsvendus.csv");
	

	$newReservations=$DB->query('SELECT designation, commande.prix_achat as pa, commande.prix_revient as pr, commande.prix_vente as pv, commande.num_cmd as num_cmd, quantity as quantite, date_cmd from productslist inner join commande on productslist.id=id_produit inner join payement on payement.num_cmd=commande.num_cmd order by (designation)');?>
	Ordre;"designation";"quantite";"Prix-Achat";"Prix-Revient";"Prix-Vente";"Tot Achat";"Tot Revient";"Tot-Vente";"Benefice";"dateop";<?php
	$totachat=0;
	$totrevient=0;
	$totvente=0;
	$benefice=0;
	$quantite=0;
	foreach($newReservations as $key => $row) {

		$totachat=$row->pa*$row->quantite;
        $totrevient=$row->pr*$row->quantite;
        $totvente=$row->pv*$row->quantite;
        $benefice=$totvente-$totrevient;
        $quantite+=$row->quantite;

        echo "\n".'"'.($row->num_cmd).'";"'.$row->designation.'";"'.$row->quantite.'";"'.$row->pa.'";"'.$row->pr.'";"'.$row->pv.'";"'.$totachat.'";"'.$totrevient.'";"'.$totvente.'";"'.$benefice.'";"'.$row->date_cmd.'"';

	    
	}
}




if (isset($_GET['client'])) {
	header("Content-disposition: attachment; filename=compteclient.csv");

	$cumulmontant=0;

    $type1='Client';
    $type2='Clientf';

    $nomclient = $DB->query("SELECT *FROM client order by(nom_client)");?>
    Ordre;"Collaborateur";"Contact";"adresse";"init";"type";"lieu de vente";"Solde GNF";"Solde EU";"Solde US";"Solde CFA";<?php

    foreach ($nomclient as $key => $row){

    	$valuem='gnf';     

        $products= $DB->querys("SELECT sum(montant) as montant, devise, nom_client FROM bulletin where nom_client='{$row->id}' and devise='{$valuem}' ");

      	$cumulmontant+=$products['montant'];

	    $montant=$products['montant'];

        

        $valuem='eu'; 

        $products= $DB->querys("SELECT sum(montant) as montant, devise, nom_client FROM bulletin where nom_client='{$row->id}' and devise='{$valuem}' ");

      	$cumulmontant+=$products['montant'];
	    $montanteu=$products['montant'];

	    $valuem='us'; 

        $products= $DB->querys("SELECT sum(montant) as montant, devise, nom_client FROM bulletin where nom_client='{$row->id}' and devise='{$valuem}' ");

      	$cumulmontant+=$products['montant'];
        $montantus=$products['montant'];

        $valuem='cfa'; 

        $products= $DB->querys("SELECT sum(montant) as montant, devise, nom_client FROM bulletin where nom_client='{$row->id}' and devise='{$valuem}' ");

      	$cumulmontant+=$products['montant'];
        $montantcfa=$products['montant'];

	    echo "\n".'"'.($key+1).'";"'.$row->nom_client.'";"'.$row->telephone.'";"'.$row->adresse.'";"'.$_SESSION['init'].'";"'.$row->typeclient.'";"'.$row->positionc.'";"'.$montant.'";"'.$montanteu.'";"'.$montantus.'";"'.$montantcfa.'"';
	    
	}
}

if (isset($_GET['personnel'])) {
	header("Content-disposition: attachment; filename=compteclient.csv");

	$cumulmontant=0;

    $type1='Employer';
    $type2='Employer';

    $nomclient = $DB->query("SELECT *FROM client where type='{$type1}' or type='{$type2}' order by(nom_client)");?>
    Ordre;"Nom du Client";"Solde Compte";<?php

    foreach ($nomclient as $key => $row){

    	$products= $DB->querys("SELECT sum(montant) as montant FROM bulletin where nom_client='{$row->id}' ");

      	$cumulmontant+=$products['montant'];

	    if ($products['montant']>0) {
        	$montant=$products['montant'];
      	}else{
	        $montant=$products['montant'];
	    }

        echo "\n".'"'.($key+1).'";"'.$row->nom_client.'";"'.$montant.'"';

	    
	}
}

if (isset($_GET['autres'])) {
	header("Content-disposition: attachment; filename=compteclient.csv");

	$cumulmontant=0;

    $type1='autres';
    $type2='autres';

    $nomclient = $DB->query("SELECT *FROM client where type='{$type1}' or type='{$type2}' order by(nom_client)");?>
    Ordre;"Nom du Client";"Solde Compte";<?php

    foreach ($nomclient as $key => $row){

    	$products= $DB->querys("SELECT sum(montant) as montant FROM bulletin where nom_client='{$row->id}' ");

      	$cumulmontant+=$products['montant'];

	    if ($products['montant']>0) {
        	$montant=$products['montant'];
      	}else{
	        $montant=$products['montant'];
	    }

        echo "\n".'"'.($key+1).'";"'.$row->nom_client.'";"'.$montant.'"';

	    
	}
}


if (isset($_GET['fournisseurs'])) {
	header("Content-disposition: attachment; filename=compteclient.csv");

	$cumulmontant=0;

    $type1='Fournisseur';
    $type2='Fournisseur';

    $nomclient = $DB->query("SELECT *FROM client where type='{$type1}' or type='{$type2}' order by(nom_client)");?>
    Ordre;"Nom du Client";"Solde Compte";<?php

    foreach ($nomclient as $key => $row){

    	$products= $DB->querys("SELECT sum(montant) as montant FROM bulletin where nom_client='{$row->id}' ");

      	$cumulmontant+=$products['montant'];

	    if ($products['montant']>0) {
        	$montant=$products['montant'];
      	}else{
	        $montant=$products['montant'];
	    }

        echo "\n".'"'.($key+1).'";"'.$row->nom_client.'";"'.$montant.'"';

	    
	}
}