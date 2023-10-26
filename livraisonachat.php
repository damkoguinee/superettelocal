<?php require 'header.php';

if (!empty($_SESSION['pseudo'])) { 

  $pseudo=$_SESSION['pseudo'];

  require 'entetelivraisonachat.php';

  if (isset($_GET['delete'])) {

    $numidliv=$_GET['delete'];

    $id=$panier->h($_GET['idproduit']);

    $idc=$panier->h($_GET['idcmd']);

    $idclient=$panier->h($_GET['idclient']);

    $numcmd=$panier->h($_GET['numcmd']);

    $nomtab=$panier->nomStock($_GET['stock'])[1];

    $idstock=$panier->nomStock($_GET['stock'])[2];
    
    $qtiteliv=$panier->h($_GET['qtite']);    

    $qtiteinit=$DB->querys("SELECT quantite  FROM `".$nomtab."` WHERE idprod=? ", array($id));    

    $qtiterest=$qtiteinit['quantite']+$qtiteliv;    

    $DB->insert("UPDATE `".$nomtab."` SET quantite=? WHERE idprod=? ", array($qtiterest, $id));

    $qtiteinitcmd=$DB->querys("SELECT qtiteliv  FROM commande WHERE id_produit=? and id=? and num_cmd=? ", array($id, $idc, $numcmd));

    $qtitecmd=$qtiteinitcmd['qtiteliv']-$qtiteliv;

    $DB->insert("UPDATE commande SET qtiteliv=? WHERE id_produit=?  and id=? and num_cmd=? ", array($qtitecmd, $id, $idc, $numcmd));

    $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'annuliv'.$numcmd, 'entree', $qtiteliv, $idstock));

    $DB->insert("UPDATE payement SET etatliv=? WHERE num_cmd=? ", array('encoursliv', $numcmd));

    $DB->insert('INSERT INTO livraisondelete (id_produitliv, quantiteliv, numcmdliv, id_clientliv, idpersonnel, idstockliv, datedelete) VALUES(?, ?, ?, ?, ?, ?, now())', array($id, $qtiteliv, $numcmd, $idclient, $_SESSION['idpseudo'], $idstock));

    $DB->delete('DELETE FROM livraison WHERE id = ?', array($numidliv));?>

    <div class="alerteV">Commande annulée avec succèe!!!</div><?php
  }

  if (isset($_GET['nonlivre']) or isset($_POST['j1']) or isset($_POST['numcmd']) or isset($_POST['clientliv'])) {

    if (!isset($_POST['j1'])) {

      $_SESSION['date']=date("Ymd");  
      $dates = $_SESSION['date'];
      $dates = new DateTime( $dates );
      $dates = $dates->format('Ymd'); 
      $_SESSION['date']=$dates;
      $_SESSION['date1']=$dates;
      $_SESSION['date2']=$dates;
      $_SESSION['dates1']=$dates; 

    }else{

      $_SESSION['date1']=$_POST['j1'];
      $_SESSION['date1'] = new DateTime($_SESSION['date1']);
      $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
      $_SESSION['date2'] = new DateTime($_SESSION['date2']);
      $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

      $_SESSION['dates1']=$_SESSION['date1'];
      $_SESSION['dates2']=$_SESSION['date2']; 

        
    }

    if (isset($_POST['clientliv'])) {
      $_SESSION['clientliv']=$_POST['clientliv'];
    }

    if (isset($_POST['numcmd'])) {
      $_SESSION['numcmd']=$_POST['numcmd'];
    }
    

    if ($products['level']>=3) {?>


        <div class="listedec"> 

          <table class="payement" style="width: 80%;">

            <thead>

              
              <tr>

                <form method="POST" action="livraisonachat.php">

                  <th style="border-right: 0px;" colspan="3"><?php

                    if (isset($_POST['j1'])) {?>

                      <input id="reccode" style="width: 120px; font-size: 14px;" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php

                    }else{?>

                      <input id="reccode" style="width: 120px; font-size: 14px;" type = "date" name = "j1" onchange="this.form.submit()"><?php

                    }?>
                  </th>
                </form>

                <form method="POST" action="livraisonachat.php">

                  <th>

                    <input style="width:65%;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div>
                  </th>
                </form>

                <form method="POST" action="livraisonachat.php">

                  <th colspan="2"><?php

                    if (isset($_POST['numcmd'])) {?>

                      <input style="width: 200px; font-size: 18px;" type = "text" name = "numcmd" value="<?=$_POST['numcmd'];?>" onchange="this.form.submit()"><?php

                    }else{?>

                      <input style="width: 200px; font-size: 18px;" type = "text" name = "numcmd" placeholder="rechercher par N°" onchange="this.form.submit()"><?php

                    }?>
                  </th>
                </form>
              </tr>

              <tr>

                <th class="legende" colspan="6" height="30"><?="Liste des Achats non Livré";?> </th>
              </tr>

              <tr>
                <th>N°</th>
                <th>N° cmd</th>
                <th>Total Achat</th>
                <th>Nom du Client</th>
                <th>Date cmd</th>
                <th>Action</th>
              </tr>

            </thead>

            <tbody><?php 
              $cumulmontant=0;
              $etatliv='livre';
              if (isset($_POST['j1'])) {

                $products= $DB->query("SELECT *FROM payement inner join client on client.id=num_client  WHERE lieuvente='{$_SESSION['lieuvente']}' and etatliv!='{$etatliv}' and (DATE_FORMAT(date_cmd, \"%Y-%m-%d \")='{$_POST['j1']}') order by(nom_client) LIMIT 10");

              }elseif (isset($_GET['searchnlclient'])) {

                $products= $DB->query("SELECT *FROM payement inner join client on client.id=num_client  WHERE lieuvente='{$_SESSION['lieuvente']}' and etatliv!='{$etatliv}' and (num_client='{$_GET['searchnlclient']}') order by(nom_client) LIMIT 10");

              }elseif (isset($_POST['numcmd'])) {

                $products= $DB->query("SELECT *FROM payement inner join client on client.id=num_client  WHERE lieuvente='{$_SESSION['lieuvente']}' and etatliv!='{$etatliv}' and (num_cmd='{$_POST['numcmd']}') order by(nom_client) LIMIT 10");

              }else{

                $products= $DB->query("SELECT *FROM payement inner join client on client.id=num_client  WHERE etatliv!='{$etatliv}' and lieuvente='{$_SESSION['lieuvente']}' order by(nom_client) LIMIT 10");
              }

              foreach ($products as $key=> $product ){

                $cumulmontant+=($product->Total-$product->remise); ?>

                <tr>
                  <td style="text-align: center;"><?= $key+1; ?></td>

                  <td style="text-align: center;"><a style="color: red; text-align: center;" href="recherche.php?recreditc=<?=$product->num_cmd;?>"><?= $product->num_cmd; ?></a></td>

                  <td style="text-align: right; padding-right: 10px;"><?= number_format($product->Total,0,',',' '); ?></td>

                  <td><?= $product->nom_client; ?></td>                 

                  <td style="text-align:center;"><?=(new DateTime($product->date_cmd))->format('d/m/Y'); ?></td>

                  <td><a href="livraison.php?livraison=<?=$product->num_cmd;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: orange;color: white; cursor: pointer;"  type="submit" value="Livraison" onclick="return alerteL();"></a></td>
                </tr><?php 
              }?>

            </tbody>

            <tfoot>
                <tr>
                  <th colspan="2">Totaux</th>
                  <th style="text-align: right; padding-right: 10px;"><?= number_format($cumulmontant,0,',',' ');?></th>
                </tr>
            </tfoot>

          </table>

        </div><?php

      }else{

        echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

      }
    }else{


      if (!isset($_POST['j2'])) {

      $_SESSION['date']=date("Ymd");  
      $dates = $_SESSION['date'];
      $dates = new DateTime( $dates );
      $dates = $dates->format('Ymd'); 
      $_SESSION['date']=$dates;
      $_SESSION['date1']=$dates;
      $_SESSION['date2']=$dates;
      $_SESSION['dates1']=$dates; 

    }else{

      $_SESSION['date1']=$_POST['j2'];
      $_SESSION['date1'] = new DateTime($_SESSION['date1']);
      $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
      $_SESSION['date2'] = new DateTime($_SESSION['date2']);
      $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

      $_SESSION['dates1']=$_SESSION['date1'];
      $_SESSION['dates2']=$_SESSION['date2']; 

        
    }

    if (isset($_POST['clientlivr'])) {
      $_SESSION['clientliv']=$_POST['clientlivr'];
    }

    if (isset($_POST['numcmdliv'])) {
      $_SESSION['numcmd']=$_POST['numcmdliv'];
    }
    

    if ($products['level']>=3) {?>


        <div class="listedec"> 

          <table class="payement" style="width: 100%;">

            <thead>

              
              <tr>

                <form method="POST" action="livraisonachat.php">

                  <th style="border-right: 0px;" colspan="5"><?php

                    if (isset($_POST['j1'])) {?>

                      <input id="reccode" style="width: 120px; font-size: 14px;" type = "date" name = "j2" onchange="this.form.submit()" value="<?=$_POST['j2'];?>"><?php

                    }else{?>

                      <input id="reccode" style="width: 120px; font-size: 14px;" type = "date" name = "j2" onchange="this.form.submit()"><?php

                    }?>
                  </th>
                </form>

                <form method="POST" action="livraisonachat.php">

                  <th colspan="2">

                    <input style="width:65%;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                    <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div>
                  </th>
                </form>

                <form method="POST" action="livraisonachat.php">

                  <th colspan="2"><?php

                    if (isset($_POST['numcmd'])) {?>

                      <input style="width: 200px; font-size: 18px;" type = "text" name = "numcmdliv" value="<?=$_POST['numcmdliv'];?>" onchange="this.form.submit()"><?php

                    }else{?>

                      <input style="width: 200px; font-size: 18px;" type = "text" name = "numcmdliv" placeholder="rechercher par N°" onchange="this.form.submit()"><?php

                    }?>
                  </th>
                </form>
              </tr>

              <tr>

                <th class="legende" colspan="9" height="30"><?="Liste des Achats Livrés ";?> </th>
              </tr>

              <tr>
                <th>N°</th>
                <th>N° cmd</th>
                <th>Nom du produit</th>
                <th>Qtité Liv</th>
                <th>Stock</th>
                <th>Nom du Client</th>
                <th>Livreur</th>
                <th>Date Livraison</th>
                <th>Action</th>
              </tr>

            </thead>

            <tbody><?php 

              $etatliv='nonlivre';
              if (isset($_POST['j2'])) {

                $products= $DB->query("SELECT livraison.id as id, idcmd, quantiteliv, numcmdliv, id_produitliv, idstockliv, id_clientliv, livreur, dateliv, type FROM livraison inner join productslist on id_produitliv=productslist.id WHERE idstockliv='{$_SESSION['lieuvente']}' and (DATE_FORMAT(dateliv, \"%Y-%m-%d \")='{$_POST['j2']}') order by(id_clientliv)");

              }elseif (isset($_GET['searchversclient'])) {

                $products= $DB->query("SELECT livraison.id as id, idcmd, quantiteliv, numcmdliv, id_produitliv, idstockliv, id_clientliv, livreur, dateliv, type FROM livraison inner join productslist on id_produitliv=productslist.id WHERE idstockliv='{$_SESSION['lieuvente']}' and (id_clientliv='{$_GET['searchversclient']}') order by(id_clientliv)");

              }elseif (isset($_POST['numcmdliv'])) {

                $products= $DB->query("SELECT livraison.id as id, idcmd, quantiteliv, numcmdliv, id_produitliv, idstockliv, id_clientliv, livreur, dateliv, type FROM livraison inner join productslist on id_produitliv=productslist.id WHERE idstockliv='{$_SESSION['lieuvente']}' and (numcmdliv='{$_POST['numcmdliv']}') order by(id_clientliv)");

              }else{

                $products= $DB->query("SELECT livraison.id as id, idcmd, quantiteliv, numcmdliv, id_produitliv, idstockliv, id_clientliv, livreur, dateliv, type FROM livraison inner join productslist on id_produitliv=productslist.id where idstockliv='{$_SESSION['lieuvente']}' order by(id_clientliv) LIMIT 10");
              }

              $totqtite=0;

              foreach ($products as $key=> $product ){

                $totqtite+=$product->quantiteliv;?>

                <tr>
                  <td style="text-align: center;"><?= $key+1; ?></td>

                  <td style="text-align: center;"><a style="color: red; text-align: center;" href="recherche.php?recreditc=<?=$product->numcmdliv;?>"><?= $product->numcmdliv; ?></a></td>

                  <td style="text-align: left;"><?=$panier->nomProduit($product->id_produitliv);?></td>                  

                  <td style="text-align: center;"><?=$product->quantiteliv;?></td>

                  <td style="text-align: left;"><?=$panier->nomStock($product->idstockliv)[0];?></td>

                  <td><?=$panier->nomClient($product->id_clientliv); ?></td> 

                  <td><?=ucwords($panier->nomPersonnel($product->livreur)); ?></td>                 

                  <td style="text-align:center;"><?=(new DateTime($product->dateliv))->format('d/m/Y'); ?></td>

                  <td><a href="livraisonachat.php?delete=<?=$product->id;?>&idcmd=<?=$product->idcmd;?>&idproduit=<?=$product->id_produitliv;?>&numcmd=<?=$product->numcmdliv;?>&qtite=<?=$product->quantiteliv;?>&stock=<?=$product->idstockliv;?>&livreur=<?=$product->livreur;?>&idclient=<?=$product->id_clientliv;?>&type=<?=$product->type;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Annuler" onclick="return alerteL();"></a></td>
                </tr><?php 
              }?>

            </tbody>

            <tfoot>
                <tr>
                  <th colspan="3">Totaux</th>
                  <th style="text-align: center;"><?= number_format($totqtite,0,',',' ');?></th>
                </tr>
            </tfoot>

          </table>

        </div><?php

      }else{

        echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

      }
    }

  }else{

  }?>
    
</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script><?php 

if (isset($_GET['livre'])) {?>

  <script>
      $(document).ready(function(){
          $('#search-user').keyup(function(){
              $('#result-search').html("");

              var utilisateur = $(this).val();

              if (utilisateur!='') {
                  $.ajax({
                      type: 'GET',
                      url: 'recherche_utilisateur.php?clientliv',
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
}else{?>

  <script>
      $(document).ready(function(){
          $('#search-user').keyup(function(){
              $('#result-search').html("");

              var utilisateur = $(this).val();

              if (utilisateur!='') {
                  $.ajax({
                      type: 'GET',
                      url: 'recherche_utilisateur.php?clientnonliv',
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
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function alerteL(){
        return(confirm('Confirmer la livraison'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script>
