<?php
function get_extension($nom) {
	$nom = explode(".", $nom);
	$nb = count($nom);
	return strtolower($nom[$nb-1]);
}
$sortie=false;
$extensions_ok = array('jpg','jpeg','png','jfif');
$typeimages_ok = array(2,3);
$taille_ko = 5;
$taille_max = $taille_ko*5;
$dest_dossier = 'img/'; //nom du dossier ou vous allez stocké vos images
$dest_fichier="";


if(!$getimagesize = getimagesize($_FILES['photo']['tmp_name'])) {
	$erreurs[] = "Le fichier n'est pas une image valide.";
}else {
	if (isset($_POST['photo']) or isset($_FILES['photo']['name'])) {// simplement pour ajouter une image
		
		$numphoto = $_SESSION['id'];

	}else{
		$products = $DB->query('SELECT max(id) AS maxid FROM productslist');

	    foreach ( $products as $maximum ):?>

	    <?php endforeach; ?><?php

		$numphoto = $maximum->maxid + 1;
	}

	if( (!in_array( get_extension($_FILES['photo']['name']), $extensions_ok ))or (!in_array($getimagesize[2], $typeimages_ok ))){
		$erreurs[] = 'Veuillez sélectionner un fichier de type Jpeg ou Png !';
	}else{// on vérifie le poids de l'image

		if( file_exists($_FILES['photo']['tmp_name']) and filesize($_FILES['photo']['tmp_name']) > $taille_max){

			$taille = getimagesize($_FILES['photo']['tmp_name']);
	        $largeur = $taille[0];
	        $hauteur = $taille[1];
	        $largeur_miniature = 150;
	        $hauteur_miniature = $hauteur / $largeur * 150;
	        $im = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
	        $im_miniature = imagecreatetruecolor($largeur_miniature
	        , $hauteur_miniature);
	        imagecopyresampled($im_miniature, $im, 0, 0, 0, 0, $largeur_miniature, $hauteur_miniature, $largeur, $hauteur);
	        imagejpeg($im_miniature, 'img/'.$numphoto.".".get_extension($_FILES['photo']['name']), 100); // chiffre correspond à la qualité de l'image


		}else{

			//$dest_fichier = basename($_FILES['photo']['name']."jpg");
			$dest_fichier = basename($_FILES['photo']['name']);
			$dest_fichier = strtr($dest_fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
			// un chtit regex pour remplacer tous ce qui n'est ni chiffre ni lettre par "_"
			$dest_fichier = preg_replace('/([^.a-z0-9]+)/i', '_', $dest_fichier);
			// pour ne pas écraser un fichier existant
			$dossier=$dest_dossier;
			while(file_exists($dossier . $dest_fichier)) {
				$dest_fichier = rand().$dest_fichier;

			}
			//********************************
			if(move_uploaded_file($_FILES['photo']['tmp_name'], $dossier . $numphoto.".".get_extension($_FILES['photo']['name']))) {
				$valid[] = "Image uploadé avec succés (<a href='".$dossier . $dest_fichier."'>Voir</a>)";
			}else {
				$erreurs[] = "Impossible d'uploader le fichier.<br />Veuillez vérifier que le dossier ".$dossier ;
			}
		}
	}
}

if(@$erreurs[0]!=""){?>
	print("<div class="erreurFormulaire">
	<div class="erreurEntete"> un probleme est survenu lors de l'upload de l'image</div><div class="erreurMessage"> ");<?php

	for($i=0;$i<5;$i++){
		if($erreurs[$i]=="")
		break;
		else echo "<li>".$erreurs[$i]."</li>"; $sortie=true;
	}
	print(" </div></div>");
}


?>
