<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

  if (isset($_GET['num_pro'])) {

    $DB->delete('DELETE FROM proformat WHERE num_pro=?', array($_GET['num_pro']));
  }

  $pseudo=$_SESSION['pseudo'];

  if ($_SESSION['level']>=3) {

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

        <tr><th class="legende" colspan="7" height="30"><?="Liste des Proformats " .$datenormale ?></th></tr>

        <tr>
          <form method="POST" action="proformatliste.php" id="suitec" name="termc">

            <th colspan="3" ><?php

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

          <form method="POST" action="proformatliste.php">

            <th colspan="4">

              <input style="width:65%;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div>
            </th>
          </form>          
        </tr>

        <tr>
          <th>N°</th>
          <th>N° Proformat</th>
          <th>Date</th>
          <th>Client</th>
          <th>Solde GNF</th>
          <th colspan="2"></th>
        </tr>
      </thead>
      <tbody><?php

        if (isset($_POST['j1'])) {

          if ($_SESSION['level']>6) {

            $products=$DB->query("SELECT DISTINCT(num_pro) as num_pro, num_pro as num, id_client, datepro FROM proformat WHERE DATE_FORMAT(datepro, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datepro, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

          }else{

            $products=$DB->query("SELECT DISTINCT(num_pro) as num, num_pro as num, id_client, datepro FROM proformat WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(datepro, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datepro, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

          }

        }elseif (isset($_GET['clientsearch'])) {

          if ($_SESSION['level']>6) {

            $products=$DB->query("SELECT DISTINCT(num_pro) as num, num_pro as num, id_client, datepro FROM proformat WHERE id_client='{$_GET['clientsearch']}' ");

          }else{

            $products=$DB->query("SELECT DISTINCT(num_pro) as num, num_pro as num, id_client, datepro FROM proformat WHERE id_client='{$_GET['clientsearch']}' and lieuvente='{$_SESSION['lieuvente']}' ");
          }

        }else{

          if ($_SESSION['level']>6) {

            $products=$DB->query("SELECT DISTINCT(num_pro) as num, num_pro as num, id_client, datepro FROM proformat WHERE DATE_FORMAT(datepro, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datepro, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");
          }else{

            $products=$DB->query("SELECT DISTINCT(num_pro) as num, num_pro as num, id_client, datepro FROM proformat WHERE lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(datepro, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(datepro, \"%Y%m%d\") <= '{$_SESSION['date2']}' ");

          }

        }

        $cumulmontanremp=0;
        $cumulmontantotp=0;
        $cumulmontanrestp=0;

        foreach ($products as $key=> $product ){?>

          <tr>
            <td style="text-align:center;"><?=$key+1;?></td>

            <td><a style="color: red;" href="recherche.php?recreditc=<?=$product->num_cmd;?>"><?= $product->num; ?></a></td>

            <td style="text-align:center;"><?= $panier->formatDate($product->datepro); ?></td>

            <td><?= $panier->nomClient($product->id_client); ?></td>

             <td style="text-align: right; padding-right: 10px;"><?=number_format(-$panier->compteClient($product->id_client, 'gnf'),0,',',' '); ?></td> 

             <td style="text-align: center"><a href="printproformat.php?ticket&proformat=<?=$product->num;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a></td>

            <td><?php if ($_SESSION['level']>6){?><a href="proformatliste.php?num_pro=<?=$product->num;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a><?php };?></td>
          </tr><?php 
        } ?>   
      </tbody>
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
                  url: 'recherche_utilisateur.php?clientproformat',
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