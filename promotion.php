<?php
require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];
  $products = $DB->querysI('SELECT statut, level FROM login WHERE pseudo= :PSEUDO',array('PSEUDO'=>$pseudo));
  

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

      $_SESSION['lieuvented']=$_SESSION['lieuvente'];

    }else{

      $_SESSION['date01']=$_POST['j1'];
      $_SESSION['date1'] = new DateTime($_SESSION['date01']);
      $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
      
      $_SESSION['date02']=$_POST['j2'];
      $_SESSION['date2'] = new DateTime($_SESSION['date02']);
      $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

      $_SESSION['dates1']=(new DateTime($_SESSION['date01']))->format('d/m/Y');
      $_SESSION['dates2']=(new DateTime($_SESSION['date02']))->format('d/m/Y');

      $_SESSION['lieuvente']=$_POST['magasin'];
    }


    if (isset($_POST['j2'])) {

      $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

    }else{

      $datenormale=(new DateTime($dates))->format('d/m/Y');
    }

    require 'headercompta.php';?><?php 

    if (isset($_GET['deletec'])) {

      $DB->delete("DELETE from promotion where id='{$_GET['deletec']}'");?>

      <div class="alerteV">Suppression reussi!!</div><?php 
    }

    if (isset($_GET['ajoutp'])) {?>

      <form id="naissance" method="POST" action="promotion.php" style="margin-top: 30px;" >
        <fieldset><legend>Ajouter une Promotion</legend>
          <ol>
            <li><label>Nom du Produit</label>
              <select type="text" name="nom" required="">
                <option></option><?php
              foreach ($panier->listeProduit() as $value) {?>

                <option value="<?=$value->id;?>"><?=ucfirst($value->designation);?></option><?php 
              }?>
              </select>
            </li>

            <li><label style="width:150px;"><input type="number" name="achatmin" min="0" style="width: 150px; font-size: 20px;"></label><label style="margin-left:15px; font-size: 30px;"><= </label> <label style="width:150px; margin-left: 10px;">Achat</label> <label style=" font-size: 30px;">< </label> <input type="number" name="achatmax" min="0" style="width: 150px; font-size: 20px; margin-left:-100px;">
            </li>

            <li><label>Qtité Offerte</label>
              <input type="float" name="quantity" value="0" required="">
            </li>

            <li><label>Date de début</label>
              <input type="date" name="dated" required="">
            </li>

            <li><label>Date de Fin</label>
              <input type="date" name="datef" required="">
            </li>

            <li><label>Magasin</label>
              <select name="magasin" required="">
                <option></option><?php 

                if ($_SESSION['level']>6) {

                  foreach($panier->listeStock() as $product){?>

                    <option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

                  }
                }else{?>

                  <option value="<?=$panier->nomStock($_SESSION['lieuvente'])[2];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php 

                }?>
              </select>
            </li>

          </ol>

          <fieldset><input type="reset" value="Annuler" name="valid" id="form" style="width:150px;"/><input type="submit" value="Ajouter" name="validp"  id="form" onclick="return alerteV();" style="margin-left: 20px; width:150px; cursor: pointer;" /></fieldset>
        </fieldset>
      </form><?php
    }

    if (isset($_POST['validp'])) {

      if (empty($_POST['quantity']) and empty($_POST['achatmin']) and empty($_POST['achatmax']) and empty($_POST['dated']) and empty($_POST['datef'])) {?>

        <div class="alertes">Tous les champs doivent être renseigné</div><?php
            
      }else{

        $id=$panier->h($_POST['nom']);
        $achatmin=$panier->h($_POST['achatmin']);
        $achatmax=$panier->h($_POST['achatmax']);
        $qtite=$panier->h($_POST['quantity']);
        $dated=$panier->h($_POST['dated']);
        $datef=$panier->h($_POST['datef']);
        $magasin=$panier->h($_POST['magasin']);

        $prodverif = $DB->querys("SELECT id FROM promotion where idprod='{$id}' and idnomstock='{$magasin}' and dated='{$dated}' and datef='{datef}'");

        if (empty($prodverif)) {

          $DB->insert('INSERT INTO promotion (idprod, achatmin, achatmax, qtite, dated, datef, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($id, $achatmin, $achatmax, $qtite, $dated, $datef, $magasin));

          unset($_POST);
          unset($_GET);?>

          <div class="alerteV">La Promotion est enregistrée!!!</div><?php
        }else{?>

          <div class="alertes">Cette Promotion est déjà planifiée!!!</div><?php

        }

      }
    }

    if (isset($_GET['promo']) or isset($_GET['listep']) or isset($_POST['validp']) or isset($_GET['deletec'])) {?>

      <div>

        <table class="payement">

          <thead>

            <tr>
              <th class="legende" colspan="7" height="30">Liste des Promotions <a href="promotion.php?ajoutp" style="color: orange; margin-left: 30px;">Ajouter une Promotion</a></th>
            </tr>

            <tr>
              <th></th>
              <th>Nom du Produit</th>
              <th>Intervalle Achat</th>
              <th>Qtité Offerte</th>
              <th>Période</th>
              <th>Magasin</th>
              <th></th>
            </tr>

          </thead>

          <tbody><?php 
            $date=date('Y');

            $products= $DB->query("SELECT * FROM promotion inner join productslist on productslist.id=idprod  WHERE idnomstock='{$_SESSION['lieuvente']}' and YEAR(dateop)='{$date}' order by(dateop)");                

            foreach ($products as $key=> $product ){ ?>

              <tr>

                <td style="text-align: center;"><?= $key+1; ?></td>

                <td><?=ucwords($product->designation);?></td>

                <td style="text-align: center;"><?= $product->achatmin.' <= Achats < '.$product->achatmax; ?></td>

                <td style="text-align: center;"><?= $product->qtite; ?></td>

                <td style="text-align: center;"> Entre le <?=(new dateTime($product->dated))->format('d/m/Y').' et le '.(new dateTime($product->datef))->format('d/m/Y'); ?></td> 

                <td><?= $panier->nomstock($product->idnomstock)[0]; ?></td>

                <td><a href="promotion.php?deletec=<?=$product->id;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor:pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a></td>
              </tr><?php 
            }?>

          </tbody>

        </table>
      </div><?php 
    }

  }else{

    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";
  }

}else{

  header("Location: deconnexion.php");

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

function alerteV(){
    return(confirm('Confirmer la validation'));
}

function alerteM(){
  return(confirm('Confirmer la modification'));
}
</script>
