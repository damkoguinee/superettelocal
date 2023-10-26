<?php require 'header.php';
 require 'navversement.php'; ?>

<script>
  function suivant(enCours, suivant, limite){
    if (enCours.value.length >= limite)
    document.term[suivant].focus();
  }
</script>

<?php

if (isset($_GET['deletevers'])) {

  $id=$_GET['deletevers'];

  $numero=$_GET['idprod'];
  $depart=$_GET['depart'];
  $nomtabdep=$panier->nomStock($depart)[1];
  $qtitesup=$_GET['qtite'];
  $dateop=$_GET['dateop'];
  $bl=$_SESSION['bl'];

  $qtiteiniti=$DB->querys("SELECT quantite, prix_revient as pr FROM `".$nomtabdep."` WHERE idprod=?", array($numero));

  $prodcmd=$DB->querys("SELECT quantite, previent as pr FROM achat WHERE id_produitfac=? and numfact=?", array($numero, $bl));

  $qtiteinit=$qtiteiniti['quantite'];
  $pri=$qtiteiniti['pr'];

  $qtiteaug=$qtiteiniti['quantite']-$qtitesup;

  $prmoyen=$panier->espace(number_format(((($qtiteinit*$pri)-($prodcmd['quantite']*$prodcmd['pr']))/(($qtiteinit-$prodcmd['quantite']))),0,',','')); 

  $DB->insert("UPDATE `".$nomtabdep."` SET quantite = ?, prix_revient=? WHERE idprod= ?", array($qtiteaug, $prmoyen, $numero));

  $DB->delete('DELETE FROM stockmouv WHERE id = ?', array($id));

  $DB->delete('DELETE FROM achat WHERE id_produitfac=? and numfact=?', array($numero, $bl));?>

    <div class="alerteV">L'approvisionnement a été bien annulé</div><?php
}


  if (isset($_POST['qtiteap'])) {

    $nomtab1=$panier->nomStock($_POST['departap'])[1];

    $idstock1=$panier->nomStock($_POST['departap'])[2];

    $lieuvente=$panier->nomStock($_POST['departap'])[3];

    $id=$panier->h($_POST['idap']);

    $designation=$panier->nomProduit($id);

    if (empty($_POST['pa'])) {
      $pra=0;
    }else{

      $pra=$panier->h($_POST['pa']);
    }

    $pv=$panier->h($_POST['pv']);

    $code=$panier->h($_POST['code']);

    $datep=$panier->h($_POST['datep']);

    if (empty($datep)) {
      $anneeo=date("Y")+5;
      $datep=date($anneeo."-m-d");
    }

    $desig=$panier->h($_POST['desig']);


    $bl=$_SESSION['bl'];


    $qtite=$panier->h($_POST['qtiteap']);

    $depart = $DB->querys("SELECT quantite as qtite, prix_revient as pr FROM `".$nomtab1."` WHERE idprod=?", array($id));

    $qtited=$depart['qtite']+$qtite;

    $qtitestock=$depart['qtite'];

    if ($qtitestock<0) {

      $qtitestock=0;
    }

    $previentstock=$depart['pr'];


    if (empty($previentstock)) {

        $qtitestock=0;
    }

    if ($qtite+$qtitestock==0) {
      $pr=$depart['pr'];
    }else{

      $pr=($qtite*$pra+$qtitestock*$depart['pr'])/($qtite+$qtitestock);
    }

    $DB->insert("UPDATE `".$nomtab1."` SET quantite= ?, prix_revient=?, prix_vente=?, codeb=?, dateperemtion=? WHERE idprod = ?", array($qtited, $pr, $pv, $code, $datep, $id));

    $DB->insert("UPDATE productslist SET designation= ? WHERE id = ?", array($desig, $id));

    $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, coment, dateop) VALUES(?, ?, ?, ?, ?, ?, now())', array($id, 'recepf', 'entree', $qtite, $idstock1, $bl));

    $DB->insert('INSERT INTO achat (id_produitfac, numcmd, numfact, fournisseur, designation, quantite, taux, pachat, previent, pvente, etat, idstockliv, datefact, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($id, $bl, $bl, $_SESSION['idclient'], $designation, $qtite, 1, $pra, $pr, 0, 'livre', $lieuvente, $_SESSION['datef'])); ?>

    <div class="alerteV">Produit approvisionné avec sucèe!!!</div> <?php

  }?>

<div style="display: flex; width: 100%;">

  <div style="margin-right: 10px;">

    <table class="payement">

      <form method="GET" action="editionreceptionf.php" id="suite" name="term">

        <thead><?php 

          if (isset($_GET['bl'])) {
            $_SESSION['bl']=$_GET['bl'];
            $_SESSION['idclient']=$_GET['idclient'];
            $_SESSION['datef']=$_GET['datef'];
          }?>

          <tr><th colspan="10">Approvisionnement de la facture BL N° <?=$_SESSION['bl'].' de '.$panier->nomClient($_SESSION['idclient']);?></th></tr>

          <tr>

            <th colspan="10">
              <input type = "search" name = "terme" placeholder="rechercher un produit" onchange="document.getElementById('suite').submit()"/>
            <input name = "s"  style="width: 0px; height: 0px;" /></th>
          </tr>
         

          <tr>
            <th>N°</th>
            <th>Désignation</th>
            <th>Dispo</th>
            <th>Qtité</th>
            <th>P Revient</th>
            <th>P Vente</th>
            <th>Date de Peremtion</th>
            <th>Code barre</th>
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
                $products = $DB->query("SELECT * FROM productslist WHERE codeb LIKE ? OR designation LIKE ? OR Marque LIKE ? order by(designation)",array($terme, "%".$terme."%", "%".$terme."%"));
            }else{

             $message = "Vous devez entrer votre requete dans la barre de recherche";

            }

            if (empty($products)) {?>

              <div class="alertes">Produit indisponible<a href="ajout.php">Ajouter le produit</a></div><?php

            }

          }else{

            if (!empty($_SESSION['terme'])) {
              
              $products = $DB->query("SELECT * FROM productslist WHERE codeb LIKE ? OR designation LIKE ? OR Marque LIKE ? order by(designation)",array($_SESSION['terme'], "%".$_SESSION['terme']."%", "%".$_SESSION['terme']."%"));

            }else{

              $products = $DB->query("SELECT * FROM productslist order by(designation) LIMIT 50");
            }
          }
        }else{

           $products = $DB->query("SELECT * FROM productslist WHERE id= ? order by(designation)",array($_GET['termeliste']));
        }

        if (!empty($products)) {

          foreach ($products as $key=> $product){

            $nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];

            $pv=$DB->querys("SELECT prix_vente as pv, prix_revient, codeb, dateperemtion, quantite  FROM `".$nomtab."` WHERE idprod=? ", array($product->id));
            $pventel=$pv['pv'];
            $pachat=$pv['prix_revient'];
            $datep=$pv['dateperemtion'];
            $code=$pv['codeb'];
            $quantite=$pv['quantite'];

            if ($product->type=='paquet') {
              $color='green';
            }elseif ($product->type=='detail') {
              $color='blue';
            }else{
              $color='';
            }?>

            <tr>
              <td><?=$key+1;?></td>
              <form action="editionreceptionf.php" method="POST">

                <td style="font-size: 15px; width: 20%; color:<?=$color;?>"><input type="text" name="desig" value="<?= ucwords(strtolower($product->designation)); ?>" required="" style="width: 90%;" /></td>

                <td style="text-align: center;"><?=$quantite;?></td>   <?php 
                if ($_SESSION['level']>6) {?>

                  <td style="width:12%;"><input type="number" name="qtiteap" required="" style="width: 90%;" /><input type="hidden" name="idap" value="<?=$product->id;?>"> <input type="hidden" name="bl" value="<?=$_SESSION['bl'];?>"></td><?php 
                }else{?>

                  <td style="width:12%;"><input type="number" min="0" name="qtiteap" required="" style="width: 90%;" /><input type="hidden" name="idap" value="<?=$product->id;?>"></td><?php

                }?>

                <td style="width:12%;"><input type="text" name="pa" min="0" value="<?=$pachat;?>" style="width: 90%;" /></td>

                <td style="width:12%;"><input type="text" name="pv" value="<?=$pventel;?>" min="0" style="width: 90%;" /></td>

                <td style="width:12%;"><input type="date" name="datep" value="<?=$datep;?>" min="0" style="width: 90%;" /></td>

                <td style="width:12%;"><input type="text" name="code" value="<?=$code;?>" min="0" style="width: 90%;" /></td>

                <td>
                  <select name="departap" required="">
                    <option value="<?=$panier->nomStock($_SESSION['lieuvente'])[2];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php 

                    if ($_SESSION['level']>=6) {

                      foreach($panier->listeStock() as $value){?>

                        <option value="<?=$value->id;?>"><?=ucwords(strtolower($value->nomstock));?></option><?php

                      }
                    }?>
                  </select>
                </td>

                <td><input type="submit" name="validap" value="Approvisionner" style="width: 95%; font-size: 16px; background-color: green;color: white; cursor: pointer;" onclick="return alerteT();" ></td>
              </form>

              


            </tr><?php
          }
        }?>


      </tbody>

    </table>
  </div>

  <div style="overflow: auto;">

    <table class="payement">

      <thead>

        <tr><th colspan="6">Produits approvionnés facture BL N° <?=$_SESSION['bl'].' de '.$panier->nomClient($_SESSION['idclient']);?></th>

        <tr>
          <th>N°</th>
          <th>Date</th>
          <th>Désignation</th>
          <th>Qtité</th>
          <th>Stock</th>
          <th></th>
        </tr>

      </thead>

      <tbody><?php
       
        $cumulmontant=0;
        $zero=0;

        $products= $DB->query("SELECT *FROM stockmouv WHERE coment='{$_SESSION['bl']}' order by(dateop)");


      $qtitetot=0;
      foreach ($products as $keyd=> $product ){

        $qtitetot+=$product->quantitemouv;?>

        <tr>
          <td style="text-align: center;"><?= $keyd+1; ?></td>
          <td style="text-align: center;"><?= $panier->formatDate($product->dateop); ?></td>
          <td><?=$panier->nomProduit($product->idstock); ?></td>
          <td style="text-align: center;"><?=$product->quantitemouv; ?></td>
          <td><?=$panier->nomStock($product->idnomstock)[0]; ?></td>

          <td><a href="editionreceptionf.php?deletevers=<?=$product->id;?>&idprod=<?=$product->idstock;?>&dateop=<?=$product->dateop;?>&qtite=<?=$product->quantitemouv;?>&depart=<?=$product->idnomstock;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Annuler" onclick="return alerteS();"></a></td>
        </tr><?php 
      }?>

          

      </tbody>

      <tfoot>
      <tr>
        <th colspan="3">Totaux</th>
        <th style="text-align: center;"><?=$qtitetot;?></th>
      </tr>
      </tfoot>

    </table>
    
  </div>

  
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
                    url: 'rechercheproduit.php?edition',
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
    document.getElementById('reccode').focus();
  }

    window.onload = function() { 
        for(var i = 0, l = document.getElementsByTagName('input').length; i < l; i++) { 
            if(document.getElementsByTagName('input').item(i).type == 'text') { 
                document.getElementsByTagName('input').item(i).setAttribute('autocomplete', 'off'); 
            }; 
        }; 
    };

</script>  