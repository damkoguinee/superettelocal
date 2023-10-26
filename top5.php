<?php require 'header.php';



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

require 'headercompta.php';?>

<div style="display:flex">
  <div><?php require 'navcompta.php';?></div>

  <div>

    <div style="display: flex; flex-wrap: wrap;">

      <div style="margin-right: 10px;">

        <table class="payement">

          <thead>

            <tr>

              

                <th colspan="3" >

                <form method="POST" action="top5.php" id="suitec" name="termc"><?php

                  if (isset($_POST['j1'])) {?>

                    <input style="width:150px;" type = "date" name = "j1" value="<?=$_POST['j1'];?>"><?php

                  }else{?>

                    <input style="width:150px;" type = "date" name = "j1" ><?php

                  }

                  if (isset($_POST['j2'])) {?>

                    <input style="width:150px;" type = "date" name = "j2" value="<?=$_POST['j2'];?>" ><?php

                  }else{?>

                    <input style="width:150px;" type = "date" name = "j2"><?php

                  }?>

                  <input type="submit" name="" style="width:100px;">
                </form><?php 

                /*

                <form method="POST" action="top5.php" id="suitec" name="termc"><?php 

                  if ($_SESSION['level']>6) {?>

                    <select style="width:200px;"  name="magasin" onchange="this.form.submit()"><?php

                      if (isset($_POST['magasin']) and $_POST['magasin']=='general') {?>

                        <option value="<?=$_POST['magasin'];?>">Général</option><?php
                        
                      }elseif (isset($_POST['magasin'])) {?>

                        <option value="<?=$_POST['magasin'];?>"><?=$panier->nomStock($_POST['magasin'])[0];?></option><?php
                        
                      }else{?>

                        <option value="<?=$_SESSION['lieuvente'];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php

                      }

                      

                      foreach($panier->listeStock() as $product){?>

                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

                      }?>

                      <option value="general">Général</option>
                    </select><?php
                  }?>
                
                </form>
                */;?>
                </th>
              </tr>

              <tr><th colspan="3"><?="Top 10 des Produits";?></th></tr>

              <tr>
                <th>N°</th>
                <th>Désignation</th>
                <th>Qtités</th>
              </tr>

          </thead>

          <tbody><?php 
              $cumul=0;
              $cumulben=0;

              $prod = $DB->query('SELECT *FROM productslist');

              foreach ($prod as $product ){

                $nbre=$panier->nbreprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2']);

                $benefice=$panier->beneficeprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2']);

                if (!empty($nbre)) {
                  
                  $DB->insert('INSERT INTO intertopproduit (idprod, quantite, benefice, pseudo) VALUES(?, ?, ?, ?)', array($product->id, $nbre, $benefice, $_SESSION['idpseudo']));
                }
              }

              $products = $DB->query("SELECT *FROM intertopproduit where pseudo='{$_SESSION['idpseudo']}' order by(quantite) desc");


              foreach ($products as $key=> $product ){

                if ($key<=9) {

                  $cumul+=$product->quantite;
                  $cumulben+=$product->benefice;?>

                  <tr>

                    <td style="text-align: center;"><?= $key+1; ?></td>

                    <td><?=ucwords(strtolower($panier->nomProduit($product->idprod))); ?></td>

                    <td style="text-align: center;"><?=number_format($product->quantite,0,',',' ');?></td>

                  </tr><?php
                }

              }?>

          </tbody>

          <tfoot>
              <tr>
                  <th colspan="2">Totaux</th>
                  <th style="text-align: center;"><?=number_format($cumul,0,',',' ');?></th>
              </tr>
          </tfoot>

        </table>
      </div>


      <div style="margin-right: 10px;">

        <table class="payement">

          <thead>

            <tr>

              <th colspan="4" ><?="Top 10 des Produits par bénéfice";?></th>
            </tr>

            <tr>
              <th>N°</th>
              <th>Désignation</th>
              <th>Qtités</th>
              <th>Bénéfice</th>
            </tr>

          </thead>

          <tbody><?php 
            $cumul=0;
            $cumulben=0;              

            $products = $DB->query("SELECT *FROM intertopproduit where pseudo='{$_SESSION['idpseudo']}' order by(benefice) desc");


            foreach ($products as $key=> $product ){              

              if ($key<=9) {
                $cumul+=$product->quantite;
                $cumulben+=$product->benefice;?>

                <tr>

                  <td style="text-align: center;"><?= $key+1; ?></td>

                  <td><?=ucwords(strtolower($panier->nomProduit($product->idprod))); ?></td>

                  <td style="text-align: center;"><?=number_format($product->quantite,0,',',' ');?></td>

                  <td style="text-align: right;"><?=number_format($product->benefice,0,',',' ');?></td>

                </tr><?php
              }

            }?>

          </tbody>

          <tfoot>
            <tr>
              <th colspan="2">Totaux</th>
              <th style="text-align: center;"><?=number_format($cumul,0,',',' ');?></th>
              <th style="text-align: right;"><?=number_format($cumulben,0,',',' ');?></th>
            </tr>
          </tfoot>

        </table><?php 
        $DB->delete("DELETE FROM intertopproduit where pseudo='{$_SESSION['idpseudo']}'");?>
      </div>

      <div style="margin-right: 30px;">

        <table class="payement">

          <thead>

              <tr>
                <th colspan="3" height="30"><?="Top 10 des Clients";?></th>
              </tr>

              <tr>
                <th>N°</th>
                <th>Nom du Client</th>
                <th>Montant</th>
              </tr>

          </thead>

          <tbody><?php 
            $cumul=0;
            $cumulben=0;

            $prod = $DB->query('SELECT *FROM client');

            foreach ($prod as $product ){

              $nbre=$panier->montantstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2']);

              $benefice=$panier->beneficestatpardate($product->id, $_SESSION['date1'], $_SESSION['date2']);

              if (!empty($nbre)) {
                
                $DB->insert('INSERT INTO topclient (id_client, montant, benefice, pseudo) VALUES(?, ?, ?, ?)', array($product->id, $nbre, $benefice, $_SESSION['idpseudo']));
              }
            }

            $products = $DB->query("SELECT *FROM topclient where pseudo='{$_SESSION['idpseudo']}' order by(montant) desc");

            foreach ($products as $key=> $product ){

              if ($key<=9) {

                $cumul+=$product->montant;
                $cumulben+=$product->benefice;?>

                <tr>

                  <td style="text-align: center;"><?= $key+1; ?></td>

                  <td><?=ucwords(strtolower($panier->nomClient($product->id_client))); ?></td>

                  <td style="text-align: right;"><?=number_format($product->montant,0,',',' ');?></td>

                </tr><?php
              }

            }?>

          </tbody>

          <tfoot>
              <tr>
                  <th colspan="2">Totaux</th>
                  <th style="text-align: right;"><?=number_format($cumul,0,',',' ');?></th>
              </tr>
          </tfoot>

        </table>
      </div>

      <div>

        <table class="payement">

          <thead>

              <tr>
                <th colspan="4" height="30"><?="Top 10 des Clients par bénéfice";?></th>
              </tr>

              <tr>
                <th>N°</th>
                <th>Nom du Client</th>
                <th>Montant</th>
                <th>Bénéfice</th>
              </tr>

          </thead>

          <tbody><?php 

            $cumul=0;
            $cumulben=0;

            $products = $DB->query("SELECT *FROM topclient where pseudo='{$_SESSION['idpseudo']}' order by(benefice) desc");

            foreach ($products as $key=> $product ){


              if ($key<=9) {
                $cumul+=$product->montant;
                $cumulben+=$product->benefice;?>

                <tr>

                  <td style="text-align: center;"><?= $key+1; ?></td>

                  <td><?=ucwords(strtolower($panier->nomClient($product->id_client))); ?></td>

                  <td style="text-align: right;"><?=number_format($product->montant,0,',',' ');?></td>

                  <td style="text-align: right;"><?=number_format($product->benefice,0,',',' ');?></td>

                </tr><?php
              }

            }?>

          </tbody>

          <tfoot>
              <tr>
                  <th colspan="2">Totaux</th>
                  <th style="text-align: right;"><?=number_format($cumul,0,',',' ');?></th>
                  <th style="text-align: right;"><?=number_format($cumulben,0,',',' ');?></th>
              </tr>
          </tfoot>

        </table><?php 

        $DB->delete('DELETE FROM topclient');?>
      </div>

    </div>
  </div>
</div>

