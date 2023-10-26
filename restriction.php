<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

  $products = $DB->querysI('SELECT statut FROM login WHERE pseudo=? and type=?',array($pseudo, 'personnel'));

  if (isset($_GET['deletec'])) {

    $DB->delete('DELETE FROM client WHERE nom_client = ?', array($_GET['deletec']));
    $DB->delete('DELETE FROM bulletin WHERE nom_client = ?', array($_GET['deletec']));

    $DB->delete('DELETE FROM login WHERE nom= ? and type!=?', array($_GET['deletec'],'personnel'));
  }


  if (isset($_GET['restriction'])) {

    $id=$panier->h($_GET['restriction']);
    $etat='bloque';
    
    $DB->insert("UPDATE client SET restriction = ? WHERE id = ?",array($etat, $id));
  }

  if (isset($_GET['debloque'])) {

    $id=$panier->h($_GET['debloque']);
    $etat='ok';
    
    $DB->insert("UPDATE client SET restriction = ? WHERE id = ?",array($etat, $id));
  }


  if (!isset($_GET['ajoutc'])) {

    if (isset($_GET['client'])) {

      if (isset($_GET['clientsearch'])) {

        $products= $DB->query("SELECT *FROM client where id='{$_GET['clientsearch']}'");

      }else{

        $type1='client';
        $type2='clientf';

        $products= $DB->query("SELECT *FROM client where typeclient='{$type1}' or typeclient='{$type2}' order by(nom_client) ");          
      }?>

      <table class="payement" style="margin-bottom: 30px; width:90%;">

        <thead>

          <tr>
            <th class="legende" colspan="4" height="30">
              <input style="width:65%; height: 30px;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
              <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div>
            </th>

            <th class="legende" colspan="6" height="30"><?php 
              if (isset($_GET['clientsearch'])) {
                $_SESSION['reclient']=$_GET['clientsearch'];
              }?>

              <?= "Liste des Clients  " ?>
            </th>
          </tr>

          <tr>
            <th>N°</th>
            <th>Nom & Prénom</th>
            <th>Téléphone</th>
            <th>Adresse</th>
            <th>Solde Compte</th>
            <th>Action</th>
          </tr>

        </thead>

        <tbody><?php

          foreach ($products as $key=> $product ){?>

            <tr>

              <td style="text-align: center;"><?=$key+1;?></td>                        
              <td><?=ucwords(strtolower($product->nom_client));?></td>
              <td><?=$product->telephone; ?></td>
              <td><?=ucwords(strtolower($product->adresse)) ; ?></td>

              <td style="text-align: right; padding-right: 10px;"><?=number_format(-$panier->compteClient($product->id, 'gnf'),0,',',' '); ?></td>

              <td><?php 
                if ($product->restriction=='ok') {?>

                  <a href="restriction.php?restriction=<?=$product->id;?>&client"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor:pointer;"  type="submit" value="Bloquer" onclick="return alerteB();"></a><?php

                }else{?>

                  <a href="restriction.php?debloque=<?=$product->id;?>&client"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: green;color: white; cursor:pointer;"  type="submit" value="Débloquer" onclick="return alerteD();"></a><?php 
                }?>
              </td>

            </tr><?php 
          }?>

        </tbody>

      </table><?php
    }

  }else{

    echo "Vous n'avez pas toutes les autorisations réquises";

  }

}else{

}?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script><?php 

if (isset($_GET['client'])) {?>

  <script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?clientrest',
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
  </script><?php 
}?>

<script type="text/javascript">
    function alerteB(){
        return(confirm('Confirmer le bloquage de ce compte'));
    }

    function alerteD(){
        return(confirm('Confirmer le débloquage'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script>
