<?php
require 'header.php';
$nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];

if(isset($_FILES['photo']['name']) and $_FILES['photo']['name']!='' ){ 

  $logo=$_FILES['photo']['name'];

  if($logo!=""){

    require "uploadImage.php";

    if($sortie==false){

      $logo=$dest_dossier . $dest_fichier;

    }else {

      $logo="notdid";
    }
  }
  if($logo!="notdid"){
      echo "upload reussi!!!";
  }else{
      echo"recommence!!!";
  }
  header("Location: update.php");

}else{

  $product = $DB->querys("SELECT * FROM `".$nomtab."`  WHERE idprod = ?", array($_POST['id']));  

    //$quantity=($product['quantite']+$_POST['quantite']);

  if(isset($_POST['prixr'])) {

    $DB->insert("UPDATE `".$nomtab."` SET prix_achat= ? WHERE idprod = ?", array($_POST['prixa'], $_POST['id']));

    $DB->insert("UPDATE `".$nomtab."` SET prix_achat= ?, prix_revient=?, prix_vente=?, quantite=?, qtiteintd=?, qtiteintp=?, dateperemtion=? WHERE id = ?", array($_POST['prixa'], $_POST['prixr'], $_POST['prixv'], $_POST['quantite'], $_POST['qtiteint'], $_POST['qtiteintp'], $_POST['datep'], $_POST['id']));

    header("Location: update.php");

    unset($_SESSION['stock']);

  }

}?>
</body>
</html> 