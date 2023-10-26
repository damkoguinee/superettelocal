<?php require 'header.php';
 require 'headercmd.php';?>

<script>
  function suivant(enCours, suivant, limite){
    if (enCours.value.length >= limite)
    document.term[suivant].focus();
  }
</script>

<div class="box_stockinv" style="margin-top: 30px; width: 100%;"><?php

  if (isset($_POST['qtiteap'])) {

    $nomtab1=$panier->nomStock($_POST['departap'])[1];

    $idstock1=$panier->nomStock($_POST['departap'])[2];

    $id=$panier->h($_POST['idap']);

    $qtite=$panier->h($_POST['qtiteap']);

    $numcmd=$panier->h($_POST['numcmd']);

    $pa=$panier->h($_POST['pa']);
    $pr=$panier->h($_POST['pr']);

    $etatliv='livre';

    $depart = $DB->querys("SELECT quantite as qtite, prix_revient as pr FROM `".$nomtab1."` WHERE idprod=?", array($id));

    $previenmoyen=(($pr*$qtite+$depart['pr']*$depart['qtite'])/($qtite+$depart['qtite']));

    $previenmoyen=number_format($previenmoyen,0,',','');

    $prodachat = $DB->querys("SELECT sum(quantiteliv) as qtite FROM achat WHERE id_produitfac=? and numcmd=?", array($id, $numcmd));

    $qtited=$depart['qtite']+$qtite;

    $DB->insert("UPDATE `".$nomtab1."` SET quantite= ?, prix_revient=? WHERE idprod = ?", array($qtited, $previenmoyen, $id));

    $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'trans', 'entree', $qtite, $idstock1));

    $qtitereste=$prodachat['qtite']-$qtite;

    $DB->insert("UPDATE achat SET quantiteliv=? WHERE id_produitfac = ? and numcmd=?", array($qtitereste, $id, $numcmd));

    $prodachat = $DB->querys("SELECT sum(quantiteliv) as qtiteliv, sum(quantite) as qtite FROM achat WHERE id_produitfac=? and numcmd=?", array($id, $numcmd));

    if (-$prodachat['qtiteliv']==$prodachat['qtite']) {
      $etatliv='livre';
    }else{
      $etatliv='nonlivre';
    }

    $DB->insert("UPDATE achat SET etat= ? WHERE id_produitfac = ? and numcmd=?", array($etatliv, $id, $numcmd));

    

  }?>

  <table class="payement">

    <form method="GET" action="repartitioncmd.php" id="suite" name="term">

      <thead>

        <tr>
          <th colspan="3"><input  id="search-user" type="text" name="client" placeholder="rechercher dans une liste" />
            <div style="color:white; background-color: black; font-size: 11px;" id="result-search"></div>
          </th>

          <th colspan="2">
            <input type = "search" name = "terme" placeholder="rechercher un produit" onKeyUp="suivant(this,'s', 10)" onchange="document.getElementById('suite').submit()"/>
            <input name = "s"  style="width: 0px; height: 0px;" />
          </th>
          <th colspan="6" height="30">Répartitions des Produits dans les stocks</th>
        </tr> 
       

        <tr>
          <th>N°</th>
          <th>N° Fact/BL</th>
          <th>Date fact</th>
          <th>Fournisseur</th>
          <th>Désignation</th>
          <th>P. Achat</th>
          <th>P.Revient</th>
          <th>Liv/qtite</th>
          <th>Qtité liv</th>
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

      $etat='nonlivre';

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
              $products = $DB->query("SELECT * FROM achat WHERE etat LIKE ? and (designation LIKE ? OR numfact LIKE ?) order by(numfact)",array($etat, "%".$terme."%", "%".$terme."%"));
          }else{

           $message = "Vous devez entrer votre requete dans la barre de recherche";

          }

          if (empty($products)) {?>

            <div class="alertes">Produit indisponible<a href="ajout.php">Ajouter le produit</a></div><?php

          }

        }else{

          if (!empty($_SESSION['terme'])) {
            
            $products = $DB->query("SELECT * FROM achat WHERE etat LIKE ? and (designation LIKE ? OR numfact LIKE ?) order by(numfact)",array($etat, "%".$_SESSION['terme']."%", "%".$_SESSION['terme']."%"));

          }else{

            $products = $DB->query("SELECT * FROM achat order by(numfact) LIMIT 50");
          }
        }
      }else{

         $products = $DB->query("SELECT * FROM achat WHERE id_produitfac= ? order by(designation)",array($_GET['termeliste']));
      }

      if (!empty($products)) {

        foreach ($products as $key=> $product){

          if ($product->etat!='livre') {

            $color='';?>

            <tr>
              <td style="text-align: center;"><?=$key+1;?></td>

              <td style="text-align: center;"><?=$product->numfact;?></td>

              <td style="text-align: center;"><?=(new dateTime($product->datefact))->format("d/m/Y");?></td>

              <td><?=$panier->nomClient($product->fournisseur);?></td>  

              <td style="font-size: 15px; color:<?=$color;?>"><?= ucwords(strtolower($product->designation)); ?></td>

              <td style="text-align:right;"><?=number_format($product->pachat,0,',',' ');?></td>

              <td style="text-align:right;"><?=number_format($product->previent,0,',',' ');?></td>

              <td style="text-align:center;"><?=(-$product->quantiteliv).'/'.($product->quantite);?></td>

              <form action="repartitioncmd.php" method="POST">

                <td style="width:10%;"><input type="number" name="qtiteap" min="0" max="<?=$product->quantite+$product->quantiteliv;?>" style="width: 90%;" /><input type="hidden" name="idap" value="<?=$product->id_produitfac;?>"><input type="hidden" name="numcmd" value="<?=$product->numcmd;?>"><input type="hidden" name="pr" value="<?=$product->previent;?>"><input type="hidden" name="pa" value="<?=$product->pachat;?>"></td>

                <td>
                  <select name="departap" required="">
                    <option></option><?php 

                    foreach ($panier->listeStock() as $value) {?>

                      <option value="<?=$value->id;?>"><?=ucwords(strtolower($value->nombdd));?></option><?php
                    }?>
                  </select>
                </td>

                <td><input type="submit" name="validap" value="Valider" style="width: 95%; font-size: 16px; background-color: green;color: white; cursor: pointer;" onclick="return alerteT();" ></td>
              </form>
            </tr><?php
          }
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
                    url: 'rechercheproduit.php?repartition',
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