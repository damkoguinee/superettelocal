<?php require 'header.php';
 require 'headercmd.php';?>

<script>
  function suivant(enCours, suivant, limite){
    if (enCours.value.length >= limite)
    document.term[suivant].focus();
  }
</script>

<div class="box_stockinv" style="margin-top: 30px; width: 100%;"><?php  

  if (isset($_POST['qtiter'])) {

    $nomtab1=$panier->nomStock($_POST['departs'])[1];

    $idstock1=$panier->nomStock($_POST['departs'])[2];

    $nomtab2=$panier->nomStock($_POST['departr'])[1];

    $idstock2=$panier->nomStock($_POST['departr'])[2];

    $id=$panier->h($_POST['id']);

    $qtite=$panier->h($_POST['qtiter']);

    $depart = $DB->querys("SELECT quantite as qtite FROM `".$nomtab1."` WHERE idprod=?", array($id));

    $qtited=$depart['qtite']-$qtite;

    $DB->insert("UPDATE `".$nomtab1."` SET quantite= ? WHERE idprod = ?", array($qtited, $id));

    $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'transp', 'sortie', -$qtite, $idstock1));


    $reception = $DB->querys("SELECT quantite as qtite FROM `".$nomtab2."` WHERE idprod=?", array($id));

    $qtiter=$reception['qtite']+$qtite;

    $DB->insert("UPDATE `".$nomtab2."` SET quantite= ? WHERE idprod = ?", array($qtiter, $id));

    $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'transp', 'entree', $qtite, $idstock2));

    $DB->insert('INSERT INTO transferprod (idprod, stockdep, quantitemouv, stockrecep, exect, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, $idstock1, $qtite, $idstock2, $_SESSION['idpseudo']));

  }

  if (isset($_POST['qtiteap'])) {

    $nomtab1=$panier->nomStock($_POST['departap'])[1];

    $idstock1=$panier->nomStock($_POST['departap'])[2];

    $id=$panier->h($_POST['idap']);

    $qtite=$panier->h($_POST['qtiteap']);

    $depart = $DB->querys("SELECT quantite as qtite FROM `".$nomtab1."` WHERE idprod=?", array($id));

    $qtited=$depart['qtite']+$qtite;

    $DB->insert("UPDATE `".$nomtab1."` SET quantite= ? WHERE idprod = ?", array($qtited, $id));

    $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'trans', 'entree', $qtite, $idstock1));

  }?>

  <table class="payement">

    <form method="GET" action="commandetrans.php" id="suite" name="term">

      <thead>

        <tr>
          <th colspan="3"><input  id="search-user" type="text" name="client" placeholder="rechercher dans une liste" />
            <div style="color:white; background-color: black; font-size: 11px;" id="result-search"></div></th>
          <th colspan="6" height="30">Transfert des Produits dans les magasins</th>
        </tr>      

        <tr>
          <th colspan="2">
            <input type = "search" name = "terme" placeholder="rechercher un produit" onKeyUp="suivant(this,'s', 10)" onchange="document.getElementById('suite').submit()"/>
          <input name = "s"  style="width: 0px; height: 0px;" /></th>
          <th colspan="3">Approvisionnement</th>
          <th colspan="4" style="background-color: red;">Transfert Produits</th>
        </tr>
       

        <tr>
          <th>N°</th>
          <th>Désignation</th>
          <th>Qtité</th>
          <th>Magasin Reception</th>
          <th></th>         
          <th>Magasin Retraît</th>
          <th>Qtite à Retirer</th>
          <th>Magasin Reception</th>
          <th></th>
        </tr>

      </thead>
    </form>

    <tbody>

      <?php
      $tot_achat=0;
      $tot_revient=0;
      $tot_vente=0;
      $qtiteR=0;
      $qtiteS=0;

      if (!isset($_GET['termeliste'])) {

        if (isset($_GET['terme'])) {

          if (isset($_GET["terme"])){

              $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
              $terme = $_GET['terme'];
              $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
              $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

              $_SESSION['terme']=$terme;
          }

          if (isset($terme)){

              $terme = strtolower($terme);
              $products = $DB->query("SELECT * FROM productslist WHERE designation LIKE ? OR Marque LIKE ? order by(designation)",array("%".$terme."%", "%".$terme."%"));
          }else{

           $message = "Vous devez entrer votre requete dans la barre de recherche";

          }

          if (empty($products)) {?>

            <div class="alertes">Produit indisponible<a href="ajout.php">Ajouter le produit</a></div><?php

          }

        }else{

          if (!empty($_SESSION['terme'])) {
            
            $products = $DB->query("SELECT * FROM productslist WHERE designation LIKE ? OR Marque LIKE ? order by(designation)",array("%".$_SESSION['terme']."%", "%".$_SESSION['terme']."%"));

          }else{

            $products = $DB->query("SELECT * FROM productslist order by(designation) LIMIT 50");
          }
        }
      }else{

         $products = $DB->query("SELECT * FROM productslist WHERE id= ? order by(designation)",array($_GET['termeliste']));
      }

      if (!empty($products)) {

        foreach ($products as $key=> $product){

          if ($product->type=='paquet') {
            $color='green';
          }elseif ($product->type=='detail') {
            $color='blue';
          }else{
            $color='';
          }?>

          <tr>
            <td><?=$key+1;?></td>  

            <td style="font-size: 15px; color:<?=$color;?>"><?= ucwords(strtolower($product->designation)); ?></td>

            <form action="commandetrans.php" method="POST">

              <td style="width:10%;"><input type="number" name="qtiteap" style="width: 90%;" /><input type="hidden" name="idap" value="<?=$product->id;?>"></td>

              <td>
                <select name="departap" required=""><?php 

                  foreach ($panier->listeStock() as $value) {?>

                    <option value="<?=$value->id;?>"><?=ucwords(strtolower($value->nomstock));?></option><?php
                  }?>
                </select>
              </td>

              <td><input type="submit" name="validap" value="Approvisionner" style="width: 95%; font-size: 16px; background-color: green;color: white; cursor: pointer;" onclick="return alerteT();" ></td>
            </form>

            <form action="commandetrans.php" method="POST">

              <td>
                <select name="departs" required="">
                  <option></option><?php 

                  foreach ($panier->listeStock() as $value) {

                    $reststock=$DB->querys("SELECT quantite as qtite FROM `".$value->nombdd."` WHERE idprod='{$product->id}'");

                      if (!empty($reststock['qtite'])) {?>

                        <option style="font-size:18px; color:orange;" value="<?=$value->id;?>"><?=$value->nomstock.' dispo '.$reststock['qtite'];?></option><?php
                      }
                  }?>
                </select>
              </td>

              <td><input type="number" name="qtiter" min="0" style="width: 95%;" /><input type="hidden" name="id" value="<?=$product->id;?>"></td>

              <td>
                <select name="departr" required="">
                  <option></option><?php 

                  foreach ($panier->listeStock() as $value) {?>

                    <option value="<?=$value->id;?>"><?=ucwords(strtolower($value->nomstock));?></option><?php
                  }?>
                </select>
              </td>

              <td><input type="submit" name="valids" value="deplacer" style="width: 95%; font-size: 16px; background-color: orange;color: white; cursor: pointer;" onclick="return alerteT();" ></td>

            </form>


          </tr><?php
        }
      }?>


    </tbody>

  </table>

  
</div> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?transfert',
                    data: 'user=' + encodeURIComponent(utilisateur),
                    success: function(data){
                        if(data != ""){
                          $('#result-search').append(data);
                        }else{
                          document.getElementById('result-search').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                        }
                    }
                })
            }
      
        });
    });
</script>


<script type="text/javascript">
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function alerteT(){
        return(confirm('Confirmer le transfert des produits'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script>  