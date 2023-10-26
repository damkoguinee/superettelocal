<?php require 'header.php';

if (!empty($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

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
        <th class="legende" colspan="10" height="30"><?="Historique des suppressions" ?></th>
      </tr>

      <tr>
        <th>N°</th>
        <th>N°Commande</th>
        <th>Désignation</th>
        <th>Qtité</th>
        <th>P.Revient</th>
        <th>P.Vente</th>          
        <th>Client</th>
        <th>Supprimé par</th>
        <th>Lieu de Vente</th>
        <th>Date</th>
      </tr>
    </thead>

    <tbody><?php 

      if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

        $products =$DB->query('SELECT * FROM ventedelete order by(num_cmd)');

      }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

        $products =$DB->query("SELECT *FROM ventedelete WHERE  idstock='{$_SESSION['lieuvente']}' order by(num_cmd)");

      }else{
        $products =$DB->query("SELECT *FROM ventedelete WHERE  idstock='{$_SESSION['lieuvente']}' order by(num_cmd)");

      } 
      foreach ($products as $key =>$product ){?>

        <tr>
          <td style="text-align:center"><?= $key+1; ?></td>
         <td style="text-align:center"><?= $product->num_cmd; ?></td>
          <td><?=$panier->nomProduit($product->id_produit); ?></td>
          <td style="text-align:center"><?= $product->quantity; ?></td>

          <td style="text-align: right"  ><?= number_format($product->prix_revient*$product->quantity,0,',',' '); ?></td>

          <td style="text-align: right"  ><?= number_format($product->prix_vente*$product->quantity,0,',',' '); ?></td>
          
          <td><?=$panier->nomClient($product->id_client); ?></td>

          <td><?=$panier->nomPersonnel($product->idpersonnel); ?></td>

          <td><?=$panier->nomStock($product->idstock)[0] ;?></td>

          <td><?=(new dateTime($product->datedelete))->format("d/m/Y h:m") ;?></td>
        </tr><?php 

      }?>

    </tbody>

  </table><?php 
}else{
  header("Location: form_connexion.php");
}