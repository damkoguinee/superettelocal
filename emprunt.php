<?php
require 'header.php';
  if (isset($_SESSION['pseudo'])) {
    $pseudo=$_SESSION['pseudo'];
    

    if ($products['level']>=3) {

      require 'paiecredit.php';?>

      <div class="box_emprunt">

        <div class="reglement" style="width: 98%;"><?php

        if (isset($_GET['choix']) or isset($_GET['montcom'])) {

          if (isset($_GET['choix'])){

            $prodchoix = $DB->querys('SELECT id FROM paiecred WHERE numero = :mat', array('mat'=> $_GET['choix']));

            if (empty($prodchoix)) {

              $DB->insert('INSERT INTO paiecred(numero, montant) VALUES(?, ?)',array($_GET['choix'], $_GET['montchoix']));

            }else{

              $DB->delete('DELETE FROM paiecred where numero=?', array($_GET['choix']));              
            }
          }
          if(isset($_GET['montcom'])){

            $DB->insert('UPDATE paiecred SET montant=? where numero=?' ,array($_GET['montcom'], $_GET['numero']));
          }?>

          <table class="payement" style="width: 35%;">

            <th colspan="2">N°Commande</th>
            <th>Montant à Payer</th><?php 

            $apayer=0;                           

            $prodcred = $DB->query('SELECT * FROM paiecred  order by(id)');

            if (!empty($prodcred)) {?>
          
              <tbody><?php  

                foreach ($prodcred as $product){?>

                  <form method="GET"  action="emprunt.php"><?php

                    $apayer+=($product->montant); ?>

                    <tr>
                      <td style="text-align: center;" colspan="2"><?= $product->numero; ?><input type="hidden" name="numero" value="<?= $product->numero; ?>"><input type="hidden" name="typeclient" value="<?=$_GET['typeclient']; ?>"></td>

                      <td style="text-align: right;padding-right: 5px;"><input style="font-size: 30px;" type="text" name="montcom" max="<?=$product->montant;?>" value="<?= number_format($product->montant,0,',',' ');?>" onchange="this.form.submit()"></td>

                    </tr>
                  </form><?php
                }?>

              </tbody>
              <tfoot>

                <form method="GET"  action="emprunt.php" target="_blank">

                  <tr>
                    <th colspan="2">Montant Total</th>
                    <th style="text-align:center; font-size: 30px; padding-right:5px;"><?=number_format($apayer,0,',',' ');?><input type="hidden" name="montotfact" value="<?=$apayer; ?>"><input type="hidden" name="typeclient" value="<?=$_GET['typeclient']; ?>"></th>
                  </tr>

                  <tr>
                    <th><select name="mode_payement" required="" >
                      <?php 
                      foreach ($panier->modep as $value) {?>
                          <option value="<?=$value;?>"><?=$value;?></option><?php 
                      }?></select>
                    </th>

                    <th><select  name="compte" required="">
                      <option></option><?php
                          $type='Banque';

                          foreach($panier->nomBanque() as $product){?>

                              <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                          }?>
                      </select>               
                    </th>

                    <th><a href="emprunt.php?paiepart"><input style="color: white; background-color: orange; text-align: center; font-size: 18px; cursor:pointer;" type="submit" name="paiepart" value="Valider" onclick="return alerteV();"></a></th>
                  </tr>
                </form>
              </tfoot><?php 
            }?>
          </table><?php  

        }else{?>

          <form method="POST"  action="emprunt.php" target="_blank">

            <table class="payement" style="width: 80%;">

              <thead>
                <tr>
                  <th class="legende" colspan="4" height="30" style="border: 0px; background-color: #00FCCF; font-size: 20px; font-weight: bold; color: black"><?php echo "Gestion crédits clients" ?></th>    
                </tr>

                <tr>
                  <th>Entrer N°</th>
                  <th>Montant Remboursé</th>              
                  <th>Payement</th>
                  <th>Compte depôt</th> 
                </tr>
              </thead>

              <tbody>

                <tr><?php
                  if (isset($_GET['toutreg'])) {?>

                    <td style="text-align:center; font-size: 22px;"><?=$_GET['regtout']; ?><input type="hidden" name="num_cmd" value="<?=$_GET['regtout']; ?>"><input type="hidden" name="numc" value="<?=$_GET['toutreg']; ?>"><input type="hidden" name="montot" value="<?=$_GET['montot']; ?>"><input type="hidden" name="typeclient" value="<?=$_GET['typeclient']; ?>"></td><?php

                  }elseif (isset($_GET['reglement'])){?>

                    <td style="text-align:center; font-size: 22px;"><?=$_GET['reglement']; ?><input type="hidden" name="num_cmd" value="<?=$_GET['reglement']; ?>"><input type="hidden" name="typeclient" value="<?=$_GET['typeclient']; ?>"></td><?php

                  }else{?>

                    <td><input type="text" name="num_cmd" min="0" required="" style="width: 95%;"></td><?php
                  }

                  if (isset($_GET['toutreg'])) {?>

                    <td style="text-align:center; font-size: 30px;"><?=number_format($_GET['montot'],0,',',' ');?><input type="hidden"   name="montantregt" value="<?=$_GET['montot'];?>" style="width: 95%; font-size: 30px;"></td><?php

                  }else{?>

                    <td><input type="number"   name="montant" min="0" required="" style="width: 95%; font-size: 30px;"></td><?php

                  }?> 

                  

                  <td><select name="mode_payement" required="" style="width: 100%;">
                      <option value=""></option><?php 
                      foreach ($panier->modep as $value) {?>
                          <option value="<?=$value;?>"><?=$value;?></option><?php 
                      }?></select>
                  </td>

                  <td><select  name="compte" required="">
                      <option></option><?php
                          $type='Banque';

                          foreach($panier->nomBanque() as $product){?>

                              <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                          }?>
                      </select>               
                  </td>
                </tr>

              </tbody>

            </table><?php

            if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

              <input  id="button" type="submit" name="paieunit" value="VALIDER" onclick="return alerteV();"><?php

            }else{?>

              <div class="alertes"> CAISSE CLOS </div><?php

            }?>

          </form><?php
        }?>

          <table class="payement" style="width: 98%;">

            <thead>
              

              <tr>
                <form method="GET"  action="emprunt.php">
                  <th colspan="3"><select style="width: 250px; height: 30px; font-size: 19px;" type="text" name="client" onchange="this.form.submit()"><?php
                    if (isset($_GET['client']) or !empty($_SESSION['reclient'])) {
                      if (isset($_GET['client'])) {

                        $_SESSION['reclient']=$_GET['client'];
                      }?>

                      <option><?=$panier->nomClient($_SESSION['reclient']);?></option><?php
                    }else{?>
                      <option>Selectionnez le client</option><?php
                    }

                    foreach($panier->client() as $product){?>

                        <option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php
                    }?></select>
                  </th>
                </form>
                <th class="legende" colspan="5" height="30"><?php echo "Liste Crédits Clients" ?><a href="printcredit.php?credit" target="_blank" ><img  style=" margin-left: 20px; height: 20px; width: 20px;" src="css/img/pdf.jpg"></a></th>
              </tr>
              <tr>
                <th colspan="2">Choix</th>
                <th>Contact du Client</th>                
                <th>Total</th> 
                <th>Reste à Payer</th>
                <th>Date</th>
              </tr>

            </thead>

            <tbody><?php

              $credit_client=0;
              $totachat=0;
              $Etat="credit";

              if (isset($_GET['depart'])) {                          

                $products = $DB->query('SELECT client.id as idc, num_cmd, num_client, client, typeclient, nom_client as clientvip, Total, remise, reste, montantpaye, DATE_FORMAT(date_cmd, \'%d/%m/%Y \')AS DateTemps FROM payement left join client on client.id=num_client  WHERE etat= :ETAT order by(client)', array('ETAT'=>$Etat));

                unset($_SESSION['reclient']);

              }elseif (isset($_GET['client']) or !empty($_SESSION['reclient'])) {                              

                $products = $DB->query('SELECT client.id as idc, num_cmd, num_client, client, typeclient, nom_client as clientvip, Total, remise, reste, montantpaye, DATE_FORMAT(date_cmd, \'%d/%m/%Y \')AS DateTemps FROM payement left join client on client.id=num_client  WHERE etat= :ETAT and num_client=:client order by(client)', array('ETAT'=>$Etat, 'client'=>$_SESSION['reclient']));
              }else{

                $products = $DB->query('SELECT client.id as idc, num_cmd, num_client, client, typeclient, nom_client as clientvip, Total, remise, reste, montantpaye, DATE_FORMAT(date_cmd, \'%d/%m/%Y \')AS DateTemps FROM payement left join client on client.id=num_client  WHERE etat= :ETAT order by(client)', array('ETAT'=>$Etat));

                unset($_SESSION['reclient']);

              }

              foreach ($products as $product){?>

                <form method="GET"  action="emprunt.php"><?php
                  if ($product->typeclient=='VIP') {
                    $client=$product->clientvip;
                  }else{
                    $client=$product->client;
                  }

                  

                  $totachat+=$product->Total-$product->remise;

                  $credit_client+=($product->Total-$product->remise-$product->montantpaye); ?>

                  <tr>
                    <td><?php 

                      if (isset($_GET['client']) or !empty($_SESSION['reclient'])) {?>

                        <div style="display: flex;">

                          <div style="margin-left: 20px;">
                            <a href="emprunt.php?choix=<?=$product->num_cmd;?>&montchoix=<?=$product->reste;?>&typeclient=<?=$product->typeclient;?>"><input type="checked" name="choix" onchange="this.form.submit()" style="margin-top: 10px; height: 15px; width: 15px;"></a>
                          </div>

                          <div style="margin-left:5px;">
                            <table>

                              <tbody><?php 

                                $prodchek = $DB->query('SELECT * FROM paiecred  where numero=:num', array('num'=>$product->num_cmd));

                                if (empty($prodchek)) {
                                  // code...
                                }else{

                                  foreach ($prodchek as $value) {?>

                                    <tr><td style="border:0px;"><img  style="margin-top: 10px; height: 20px; width: 20px;" src="css/img/checkbox.jpg"></td></tr><?php
                                  }
                                }?>
                              </tbody>
                            </table>

                          </div><?php
                        }?>
                      </div>
                    </td>

                    <td style="text-align: center;"><a style="text-decoration: none;" href="emprunt.php?reglement=<?= $product->num_cmd;?>&typeclient=<?=$product->typeclient;?>">Régler</a></td>

                    <td style="text-align: left;"><?=$client; ?></td>

                    <td style="text-align: right;padding-right: 5px;"><?= number_format($product->Total,0,',',' ') ; ?></td> 

                    <td style="color: red; text-align: right; font-size: 22px;"><a style="color: red;" href="recherche.php?recreditc=<?=$product->num_cmd;?>&reclient=<?=$product->idc;?>"><?=number_format(($product->reste),0,',',' '); ?></a></td>

                    <td style="text-align:center;"><?= $product->DateTemps; ?></td>

                  </tr>
                </form><?php
              }?>

            </tbody>            

            <thead>

              <tr><?php 
                if (isset($_GET['client']) or !empty($_SESSION['reclient'])) {?>

                  <th colspan="2"><a href="emprunt.php?toutreg=<?=$_SESSION['reclient']; ?>&regtout=<?='tout régler';?>&montot=<?=$credit_client;?>&typeclient=<?='VIP';?>"><input style="color: white; background-color: orange; text-align: center; font-size: 18px; cursor:pointer;" type="submit" value="Tout Régler"></a></th>

                  <th>Totaux</th>

                  <th style="text-align: right; padding-right: 5px;"><?= number_format($totachat,0,',',' ') ; ?></th>

                  <th style="text-align: right; color: red; font-size:22px;"><?= number_format($credit_client,0,',',' ') ; ?></th>

                  <th></th> <?php 

                }else{?>  

                  <th colspan="3">Totaux</th>

                  <th style="text-align: right; padding-right: 5px;"><?= number_format($totachat,0,',',' ') ; ?></th>

                  <th style="text-align: right; color: red; font-size:22px;"><?= number_format($credit_client,0,',',' ') ; ?></th>

                  <th></th><?php
                }?>            
              </tr>
              
            </thead>

            </table>

            </br></br></br></br></br></br></br></br>

          </div>

          

      </div> <?php 

    }else{

      echo "Vous n'avez pas les autorisations requises";
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
