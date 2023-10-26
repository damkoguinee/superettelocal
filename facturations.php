<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

  if (isset($_GET['deletemodif'])) {

    $DB->delete('DELETE FROM validpaiemodif WHERE pseudov=?', array($_SESSION['idpseudo']));

    $DB->delete('DELETE FROM validventemodif where pseudop=?', array($_SESSION['idpseudo']));

    $_SESSION['panier'] = array();
    $_SESSION['panieru'] = array();
    $_SESSION['error']=array();
    $_SESSION['clientvip']=array();
    $_SESSION["montant_paye"]=array();
    $_SESSION['remise']=array();
    $_SESSION['product']=array();
    unset($_SESSION['banque']);
    unset($_SESSION['proformat']);
    unset($_SESSION['alertesvirement']);
    unset($_SESSION['alerteschequep']);
    unset($_SESSION['clientvipcash']);
  }

  $pseudo=$_SESSION['pseudo'];

  if ($_SESSION['level']>=3) {

    if (!isset($_POST['magasin'])) {

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
    }

    if (isset($_POST['j2']) or isset($_POST['magasin'])) {

      $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

    }else{

      $datenormale=(new DateTime($_SESSION['date']))->format('d/m/Y');
    }

    if (isset($_POST['clientliv'])) {
      $_SESSION['clientliv']=$_POST['clientliv'];
    }

    require 'headercompta.php';?>


    <table style="margin-top: 30px;" class="payement">
      <thead>

        <tr><th colspan="12" height="30"><?="Liste des Facturations " .$datenormale ?></th></tr>

        <tr>
          <form method="POST" action="facturations.php" id="suitec" name="termc">

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

          <form method="POST" action="facturations.php">

            <th colspan="4">

              <input style="width:65%;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div>
            </th>
          </form>

          <form method="POST" action="facturations.php" id="suitec" name="termc">
            <th colspan="4"><?php 


              if (!empty($_SESSION['date1'])) {?>
            
                <select style="width: 200px;" name="magasin" onchange="this.form.submit()"><?php

                  if (isset($_POST['magasin']) and $_POST['magasin']=='general') {?>

                    <option value="<?=$_POST['magasin'];?>">Général</option><?php
                    
                  }elseif (isset($_POST['magasin'])) {?>

                    <option value="<?=$_POST['magasin'];?>"><?=$panier->nomStock($_POST['magasin'])[0];?></option><?php
                    
                  }else{?>

                    <option value="<?=$_SESSION['lieuvente'];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php

                  }

                  if ($_SESSION['level']>6) {

                    foreach($panier->listeStock() as $product){?>

                      <option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

                    }?>

                    <option value="general">Général</option><?php
                  }?>
                </select><?php 
              }?>
            </th>
          </form>

          
        </tr>

        <tr>
          <th>N°</th>
          <th>N° Cmd</th>
          <th>Date Cmd</th>
          <th>Etat</th>
          <th>Livraison</th>
          <th>Remise</th>
          <th>Total</th>
          <th>Montant</th>
          <th>Client</th>
          <th>Solde GNF</th>
          <th colspan="2"></th>
        </tr>
      </thead>
      <tbody><?php

        if (isset($_POST['j1'])) {

          if ($_SESSION['level']>6) {

            $products=$DB->query("SELECT *FROM payement where DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' order by(id) desc");

          }else{

            $products=$DB->query("SELECT *FROM payement where lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' order by(id) desc");

          }

        }elseif (isset($_GET['clientsearch'])) {

          if ($_SESSION['level']>6) {

            $products=$DB->query("SELECT *FROM payement where num_client='{$_GET['clientsearch']}' order by(id) desc ");

          }else{

            $products=$DB->query("SELECT *FROM payement where num_client='{$_GET['clientsearch']}' and lieuvente='{$_SESSION['lieuvente']}' order by(id) desc ");
          }

        }elseif (isset($_POST['magasin'])) {

            if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

              $products=$DB->query("SELECT *FROM payement where DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' order by(id) desc ");
            }else{
              $products=$DB->query("SELECT *FROM payement where lieuvente='{$_POST['magasin']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}'order by(id) desc ");
            }                 

          }else{

          if ($_SESSION['level']>6) {

            $products =$DB->query("SELECT *FROM payement WHERE  DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' order by(id) desc ");
          }else{

            $products =$DB->query("SELECT *FROM payement WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' order by(id) desc ");

          }

        }

        $cumulmontanremp=0;
        $cumulmontantotp=0;
        $cumulmontanrestp=0;

        foreach ($products as $key=> $product ){

          $cumulmontanremp+=$product->remise;
          $cumulmontantotp+=$product->Total-$product->remise;
          $cumulmontanrestp+=$product->montantpaye; ?>

          <tr>
            <td style="text-align:center;"><?=$key+1;?></td>

            <td><a style="color: red;" href="recherche.php?recreditc=<?=$product->num_cmd;?>"><?= $product->num_cmd; ?></a></td>

            <td style="text-align:center;"><?= $panier->formatDate($product->date_cmd); ?></td>

            <td style="text-align:center;"><?= $product->etat; ?></td>

            <td style="text-align:center;"><?= $product->etatliv; ?></td>

            <td style="text-align:right"><?= number_format($product->remise,0,',',' '); ?></td>

            <td style="text-align: right"><?= number_format(($product->Total-$product->remise),0,',',' '); ?></td>
            <td style="text-align:right"><?= number_format($product->montantpaye,0,',',' '); ?> </td>

            <td><?= $panier->nomClient($product->num_client); ?></td>

             <td style="text-align: right; padding-right: 10px;"><?=number_format(-$panier->compteClient($product->num_client, 'gnf'),0,',',' '); ?></td> 

            <td><?php if ($_SESSION['level']>=6){?><a href="modifventeprod.php?numcmdmodif=<?=$product->num_cmd;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: orange;color: white; cursor:pointer;"  type="submit" value="Modifier" onclick="return alerteM();"></a><?php };?></td>

            <td><?php if ($_SESSION['level']>=6){?><a href="comptasemaine.php?num_cmd=<?=$product->num_cmd;?>&total=<?=$product->Total-$product->remise;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a><?php };?></td>
          </tr><?php 
        } ?>   
      </tbody>

      <tfoot>
        <tr>
          <th colspan="5"></th>
          <th style="text-align: right;"><?= number_format($cumulmontanremp,0,',',' ');?></th>
          <th style="text-align: right;"><?= number_format($cumulmontantotp,0,',',' ');?></th>
          <th style="text-align: right;"><?= number_format($cumulmontanrestp,0,',',' ');?></th>
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
                  url: 'recherche_utilisateur.php?clientfact',
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