<?php
require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];
  $products = $DB->querys('SELECT statut, level FROM login WHERE pseudo= :PSEUDO',array('PSEUDO'=>$pseudo));

  if ($products['level']>=3) {

    if(isset($_GET["delete"])){

      $numero=$_GET["delete"];

      $DB->delete("DELETE FROM stock WHERE id = ?", array($numero));

      $DB->delete("DROP TABLE `".$_GET['stock']."`");
    }?>

    <div style="display: flex;" >

      <div><?php require 'navstock.php';?></div>

      <div>

        <div style="width: 100%;"><?php

          if(isset($_GET["ajout"])){?>

            <form id="naissance" method="POST" action="ajoutstock.php" style="width: 100%; margin-top: 30px;">

              <fieldset><legend>Ajouter un Stock</legend>
                <ol>

                  <li><label>Nom*</label><input type="text" name="nom" maxlength="150" required=""/></li>                  

                  <li><label>Responsable*</label>
                    <select type="text" name="resp" required="">
                      <option></option><?php 
                      foreach ($panier->personnel() as $value) {?>

                        <option value="<?=$value->id;?>"><?=ucwords($value->nom);?></option><?php 
                      }?>
                    </select>
                  </li>

                  <li><label>Emplacement*</label>
                    <select type="text" name="position" required="">
                      <option></option><?php 
                      foreach ($panier->position as $value) {?>

                        <option value="<?=$value;?>"><?=ucwords($value);?></option><?php 
                      }?>
                    </select>
                  </li>

                  <li><label>Surface</label><input type="text" name="surface"/> m²</li>

                  <li><label>Nbre de Pièces</label>
                    <select type="text" name="nbrep"><?php
                      $i=1;
                      while ( $i<= 5) {?>

                        <option value="<?=$i;?>"><?=$i;?></option><?php

                        $i=$i;

                        $i++;
                      }?>
                    </select>
                  </li>

                  <li><label>Adresse*</label><input type="text" name="adresse" required=""/></li>

                </ol>
              </fieldset>

              <fieldset><input type="reset" value="Annuler" name="annuldec" style="cursor: pointer;" /><input type="submit" value="Valider" name="valid" onclick="return alerteV();" style="margin-left: 30px; cursor: pointer;"/></fieldset>
            </form><?php
          }?>

        </div><?php 


        if (isset($_POST['valid'])) {
          
          if($_POST['nom']!="" and $_POST['resp']!="" and $_POST['position']!=""){

            $nom=$panier->h($_POST['nom']);
            $resp=$panier->h($_POST['resp']);
            $position=$panier->h($_POST['position']);
            $surface=$panier->h($_POST['surface']);
            $nbrep=$panier->h($_POST['nbrep']);
            $adresse=$panier->h($_POST['adresse']);

            $nb=$DB->querys('SELECT nomstock from stock where (nomstock=:nom)', array('nom'=>$nom));

            if(!empty($nb)){?>
              <div class="alertes">Ce nom existe déja</div><?php

            }else{
              $searchString = " ";
              $replaceString = "";
              $originalString = $nom; 
               
              $motsansespace= str_replace($searchString, $replaceString, $originalString); 
              $bdd=$motsansespace;

              $DB->insert('INSERT INTO stock(nomstock, nombdd, coderesp, position, surface, nbrepiece, adresse) values(?, ?, ?, ?, ?, ?, ?)', array($nom, $bdd, $resp, $position, $surface, $nbrep, $adresse));

              $DB->insert("CREATE TABLE IF NOT EXISTS `".$bdd."`(
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `codeb` varchar(100) DEFAULT NULL,
                  `idprod` int(10) NOT NULL,
                  `prix_achat` double DEFAULT '0',
                  `prix_revient` double DEFAULT '0',
                  `prix_vente` double DEFAULT '0',
                  `type` varchar(20) DEFAULT NULL,
                  `quantite` int(11) DEFAULT '0',
                  `qtiteintd` int(11) DEFAULT '0',
                  `qtiteintp` int(11) DEFAULT '0',
                  `nbrevente` float DEFAULT '0',
                  `dateperemtion` date DEFAULT NULL,
                  PRIMARY KEY (`id`)
                )");

              foreach ($panier->listeProduit() as $value) {              

                $DB->insert("INSERT INTO `".$bdd."` (codeb, idprod, prix_achat, prix_revient, prix_vente, type, qtiteintd, qtiteintp) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", array($value->codeb, $value->id, 0, 0, $value->pventel, $value->type, $value->qtiteint, $value->qtiteintp));

              }?>  

              <div class="alerteV">Stock ajouté avec succèe!!!</div><?php
            }

          }else{?>  

            <div class="alertes">Remplissez les champs vides</div><?php
          }
        }

        if (!isset($_GET['ajout'])) {

          if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {

            $prodm=$DB->query("SELECT stock.id as id, nomstock, nombdd, nom, position, surface, nbrepiece, adresse from stock inner join login on login.id=coderesp where stock.id='{$_SESSION['lieuvente']}'  order by(stock.id)");

          }else{

            $prodm=$DB->query('SELECT stock.id as id, nomstock, nombdd, nom, position, surface, nbrepiece, adresse from stock inner join login on login.id=coderesp  order by(stock.id)');
          }

          ?>
              
          <table class="payement">
            <thead>

              <tr>
                
                <th height="25" colspan="9" style="text-align: center"><?='Liste des Stocks';?><?php  

                if ($_SESSION['level']>6) {?><a style="color: green; margin-left: 30px; color:orange; font-size:20px;" href="stockmouv.php?stockgeneral=<?='stock general';?>">Voir Stock Général</a> <a href="ajoutstock.php?ajout" style="color: orange; margin-left: 30px; font-size:20px;">Ajouter un Stock</a><?php 
                }?></th>

              </tr>

              <tr>
                <th>N°</th>
                <th>Nom</th>
                <th>Responsable</th>
                <th>Position</th>
                <th>Surafce</th>
                <th>N.Pièces</th>
                <th>Adresse</th>
                <th></th>
                <th></th>
              </tr>

            </thead>

            <tbody><?php

              if (empty($prodm)) {
                # code...
              }else{
                $cumultranche=0;
                foreach ($prodm as $key=> $formation) {?>

                  <tr>
                    <td style="text-align: center;"><?=$key+1;?></td>

                    <td style="text-align: left"><?=ucwords($formation->nomstock);?></td>

                    <td style="text-align: left"><?=ucwords($formation->nom);?></td>

                    <td style="text-align: left"><?=ucwords($formation->position);?></td>

                    <td style="text-align: center;"><?=$formation->surface;?> m²</td>

                    <td style="text-align: center;"><?=$formation->nbrepiece;?></td>

                    <td style="text-align: left"><?=ucwords($formation->adresse);?></td>

                    <td>
                      <a href="stockmouv.php?stock=<?=$formation->nombdd;?>&idnomstock=<?=$formation->id;?>"><input type="button" value="Opération" style="font-size: 16px;cursor: pointer"></a>
                    </td>

                    <td colspan="1">
                    </td>

                  </tr><?php
                }

              }?>          
            </tbody>

                
          </table><?php
        }?>

      </div>
    </div><?php

  }else{?>

    <div class="alertes">VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES</div><?php
  }

}else{

}?>

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
</body>

</html>
