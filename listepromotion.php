<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

  if ($products['level']>=3) {

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

      $_SESSION['date01']=$_POST['j1'];
      $_SESSION['date1'] = new DateTime($_SESSION['date01']);
      $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
      
      $_SESSION['date02']=$_POST['j2'];
      $_SESSION['date2'] = new DateTime($_SESSION['date02']);
      $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

      $_SESSION['dates1']=(new DateTime($_SESSION['date01']))->format('d/m/Y');
      $_SESSION['dates2']=(new DateTime($_SESSION['date02']))->format('d/m/Y');  
    }

    if (isset($_POST['j2'])) {

      $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

    }else{

      $datenormale=(new DateTime($dates))->format('d/m/Y');
    }

    if (isset($_POST['clientliv'])) {
      $_SESSION['clientliv']=$_POST['clientliv'];
    }

    require 'headercompta.php';?>


    <table style="margin-top: 30px;" class="payement">
      <thead>
        <tr>
          <th class="legende" colspan="7" height="30"><?="Liste des Produits Offerts " .$datenormale ?></th>
        </tr>

        <tr>
          <form method="POST" action="listepromotion.php" id="suitec" name="termc">

            <th colspan="4" ><?php

              if (isset($_POST['j1'])) {?>

                <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php

              }else{?>

                <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()"><?php

              }

              if (isset($_POST['j2'])) {?>

                <input style="width:150px;" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php

              }else{?>

                <input style="width:150px;" type = "date" name = "j2" onchange="this.form.submit()"><?php

              }?>
            </th>
          </form>

          <form method="POST" action="listepromotion.php">

            <th colspan="3">

              <input style="width:65%;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div>
            </th>
          </form>

          
        </tr>

        <tr>
          <th>N°</th>
          <th>N° Cmd</th>
          <th>Date Cmd</th>
          <th>Désignation</th>
          <th>qtite</th>
          <th>Client</th>
          <th>Solde Client</th>
        </tr>
      </thead>
      <tbody><?php
        $zero=0;

        if (isset($_POST['j1'])) {

          if ($_SESSION['level']>6) {

            $products=$DB->query("SELECT *FROM payement inner join commande on commande.num_cmd=payement.num_cmd where prix_vente='{$zero}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

          }else{

            $products=$DB->query("SELECT *FROM payement inner join commande on commande.num_cmd=payement.num_cmd where prix_vente='{$zero}' and  lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}'");

          }

        }elseif (isset($_GET['clientsearch'])) {

          if ($_SESSION['level']>6) {

            $products=$DB->query("SELECT *FROM payement inner join commande on commande.num_cmd=payement.num_cmd where prix_vente='{$zero}' and num_client='{$_GET['clientsearch']}' ");

          }else{

            $products=$DB->query("SELECT *FROM payement inner join commande on commande.num_cmd=payement.num_cmd where prix_vente='{$zero}' and num_client='{$_GET['clientsearch']}' and lieuvente='{$_SESSION['lieuvente']}' ");
          }

        }else{

          if ($_SESSION['level']>6) {

            $products =$DB->query("SELECT *FROM payement inner join commande on commande.num_cmd=payement.num_cmd where prix_vente='{$zero}' and  DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");
          }else{

            $products =$DB->query("SELECT *FROM payement inner join commande on commande.num_cmd=payement.num_cmd where prix_vente='{$zero}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

          }

        }

        $cumulqtite=0;

        foreach ($products as $key=> $product ){

          $cumulqtite+=$product->quantity; ?>

          <tr>
            <td style="text-align:center;"><?=$key+1;?></td>

            <td><a style="color: red;" href="recherche.php?recreditc=<?=$product->num_cmd;?>"><?= $product->num_cmd; ?></a></td>

            <td style="text-align:left;"><?= $panier->formatDate($product->date_cmd); ?></td>

            <td style="text-align:center;"><?= $panier->nomProduit($product->id_produit); ?></td>

            <td style="text-align:center;"><?= $product->quantity; ?></td>

            <td><?= $panier->nomClient($product->num_client); ?></td>

             <td style="text-align: right; padding-right: 10px;"><?=number_format(-$panier->compteClient($product->num_client, 'gnf'),0,',',' '); ?></td> 
          </tr><?php 
        } ?>   
      </tbody>

      <tfoot>
        <tr>
          <th colspan="4"></th>
          <th style="text-align: right;"><?= number_format($cumulqtite,0,',',' ');?></th>
        </tr>
      </tfoot>
    </table><?php 

  }else{

    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

  }
}?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
  $(document).ready(function(){
      $('#search-user').keyup(function(){
          $('#result-search').html("");

          var utilisateur = $(this).val();

          if (utilisateur!='') {
              $.ajax({
                  type: 'GET',
                  url: 'recherche_utilisateur.php?produitoffert',
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

  function alerteM(){
    return(confirm('Voulez-vous vraiment modifier cette vente?'));
  }

  function focus(){
    document.getElementById('reccode').focus();
  }
</script>