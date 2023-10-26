<?php 
  if (isset($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];

    $products = $DB->querys('SELECT statut FROM personnel WHERE pseudo= :PSEUDO',array('PSEUDO'=>$pseudo));

    if ($products['statut']!="vendeur") {?>

      <div class="box_modif">
        
          <div class="sup_prod">

            <form method="post" action="update.php" ?>

              <div class="sup_cmd">ENTRER LE NUMERO DE COMMANDE </div>

              <?php echo '<input class="sup_entrernom" type="number" name="num_cmd" required="">';

              if (empty($panier->totalsaisie())) {?>

                <input id="button" type="submit" value="SUPPRIMER" onclick="return alerteS();"><?php

              }else{?>

                <div class="alertes"> CAISSE CLOS </div><?php

              }?>

            </form><?php

            require 'delete.php';?>
          
            <form method="post" action="update.php">

              <div style="background: #0CCFFC;" class="sup_cmd">ENTRER LE N° DE DECAISSEMENT </div>

              <?php echo '<input class="sup_entrernom" type="number" name="num_dec" required="" >';

              if (empty($panier->totalsaisie())) {?>

                <input id="button" type="submit" value="SUPPRIMER" onclick="return alerteS();"><?php

              }else{?>

                <div class="alertes"> CAISSE CLOS </div><?php

              }?>

            </form>

            <?php

            if (!isset($_POST['num_dec'])) {

            }else{

              $numero=$_POST['num_dec'];
              $DB->delete('DELETE FROM decaissement WHERE id = ? AND motif!= ?', array($numero, 'achat fournisseur'));

              $DB->delete('DELETE FROM bulletin WHERE numero = ? AND libelles!= ?', array($numero, 'achat fournisseur'));

              $DB->delete('DELETE FROM banque WHERE numero = ?', array($numero));

              $products=$DB->querys('SELECT id FROM decaissement WHERE id= ?', array($numero));

              if (empty($products)) {

                echo "LE DECAISSEMENT ".$numero." A ETE SUPPRIMER";

              }else{

                echo "ECHEC REESSAYER DE NOUVEAU";

              }

            }?>


            <form method="post" action="update.php">

              <div style="background: black;" class="sup_cmd">ENTRER LE N° DE VERSEMENT </div>

              <?php echo '<input class="sup_entrernom" type="number" name="num_vers" required="">';

              if (empty($panier->totalsaisie())) {?>

                <input id="button" type="submit" value="SUPPRIMER" onclick="return alerteS();"><?php

              }else{?>

                <div class="alertes"> CAISSE CLOS </div><?php

              }?>

            </form>

            <?php

            if (!isset($_POST['num_vers'])) {

            }else{

              $numero=$_POST['num_vers'];
              $DB->delete('DELETE FROM versement WHERE id = ?', array($numero));

              $DB->delete('DELETE FROM bulletin WHERE numero = ?', array($numero));

              $DB->delete('DELETE FROM banque WHERE numero = ?', array($numero));

              $products=$DB->querys('SELECT id FROM versement WHERE id= ?', array($numero));

              if (empty($products)) {

                echo "LE VERSEMENT ".$numero." A BIEN ETE SUPPRIME";

              }else{

                echo "ECHEC VERIFIER LE NUMERO";

              }

            }?>

          </div>

        

      </div><?php

      
    }else{

      echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

    }

  }else{

  }?>
  
</body>
</html>

<script type="text/javascript">
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script>
