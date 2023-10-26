<?php
require 'header.php';

if (isset($_SESSION['pseudo'])) {

  if ($_SESSION['level']>=6) {

    if (isset($_GET['delete'])) {

      $numidliv=$_GET['delete'];

      $numero=$_GET['numero'];

      $id=$panier->h($_GET['idproduit']);

      $idclient=$panier->h($_GET['idclient']);

      $nomtab=$panier->nomStock($_GET['stock'])[1];

      $idstock=$panier->nomStock($_GET['stock'])[2];
      
      $qtiteret=$panier->h($_GET['qtite']);    

      $qtiteinit=$DB->querys("SELECT quantite  FROM `".$nomtab."` WHERE idprod=? ", array($id));    

      $qtiterest=$qtiteinit['quantite']+$qtiteret;    

      $DB->insert("UPDATE `".$nomtab."` SET quantite=? WHERE idprod=? ", array($qtiterest, $id));

      $DB->delete('DELETE FROM stockmouv WHERE numeromouv = ?', array($numero));
      $DB->delete('DELETE FROM bulletin WHERE numero = ?', array($numero));
      $DB->delete('DELETE FROM retourlist WHERE numero = ?', array($numero));?>

      <div class="alerteV">Retour annulé avec succèe!!!</div><?php
    }

    require 'headercmd.php';?>

    <table class="payement">

      <thead>

        <tr>
          <th class="legende" colspan="9" height="30">Liste des Retours Produits <a href="retourproduit.php" style="color: orange; margin-left: 30px; font-size: 25px;">Effectuez un Retour</a></th>
        </tr>

        <tr>
          <th>N°</th>
          <th>Date</th>
          <th>Nom du Produit</th>
          <th>Stock</th>          
          <th>Prix Achat</th>
          <th>Qtite</th>
          <th>Total</th>
          <th>Fournisseur</th>
          <th></th>         
        </tr>

      </thead>

      <tbody><?php 
        $cumulmontant=0;
        $cumulqtite=0;
        $date=date('Y');

        $products= $DB->query("SELECT * FROM retourlist");

        

        foreach ($products as $key=> $product ){

          $totrevient=$product->pa*$product->quantiteret;

          $cumulmontant+=$totrevient;
          $cumulqtite+=$product->quantiteret; ?>

          <tr>
            <td style="text-align: center;"><?= $key+1; ?></td>

            <td><?= (new dateTime($product->dateop))->format('d/m/Y'); ?></td>

            <td><?= ucwords(strtolower($panier->nomProduit($product->idprod))); ?></td>

            <td><?= ucwords(strtolower($panier->nomStock($product->stockret)[0])); ?></td>

            <td style="text-align: right;"><?= $product->pa; ?></td>

            <td style="text-align: center;"><?= $product->quantiteret; ?></td>             

            <td style="text-align: right; padding-right: 5px;"><?= number_format($totrevient,0,',',' '); ?></td>

            <td><?= ucwords(strtolower($panier->nomClient($product->client))); ?></td>

            <td><a href="retourlist.php?delete=<?=$product->id;?>&idproduit=<?=$product->idprod;?>&qtite=<?=$product->quantiteret;?>&stock=<?=$product->stockret;?>&tot=<?=$totrevient;?>&numero=<?=$product->numero;?>&idclient=<?=$product->client;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Annuler" onclick="return alerteL();"></a></td>

            
          </tr><?php 
        }?>

      </tbody>

      <tfoot>
          <tr>
            <th colspan="5">Totaux</th>
            <th style="text-align: center; padding-right: 5px;"><?= $cumulqtite;?></th>
            <th style="text-align: right; padding-right: 5px;"><?= number_format($cumulmontant,0,',',' ');?></th>
          </tr>
      </tfoot>

    </table><?php 
  }

}else{

    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";
}?>
</body>

</html>

<script>
function suivant(enCours, suivant, limite){
  if (enCours.value.length >= limite)
  document.term[suivant].focus();
}

function focus(){
document.getElementById('reccode').focus();
}

function alerteS(){
  return(confirm('Confirmer la suppression?'));
}

function alerteL(){
        return(confirm('Confirmer la livraison'));
    }

function alerteV(){
    return(confirm('Confirmer la validation'));
}

function alerteM(){
  return(confirm('Confirmer la modification'));
}
</script>
