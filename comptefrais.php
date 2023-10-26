<div>
  <div><?php 
    $colspan=sizeof($panier->monnaie);?>
    <table class="payement" style="width: 90%;">

      <thead>

        <tr>

          <form method="GET"  action="bulletin.php?frais">
            <th colspan="3"><select style="width: 250px; height: 30px; font-size: 19px;" type="text" name="clientsearch" onchange="this.form.submit()"><?php
              if (isset($_GET['clientsearch'])) {
                if (isset($_GET['clientsearch'])) {
                  $_SESSION['reclient']=$_GET['clientsearch'];
                }?>

                <option><?=$panier->nomClient($_SESSION['reclient']);?></option><?php

              }else{?>
                <option>Selectionnez le client</option><?php
              }


              $type1='transporteur';
              $type2='douanier';
              
              foreach($panier->clientF($type1, $type2) as $product){?>

                <option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php
              }?></select>
            </th>
          
            <th colspan="<?=$colspan;?>" height="30">Compte Fournisseurs</th>
          </form>
        </tr>

        <tr>
          <th>N°</th>
          <th>Nom</th><?php 
          foreach ($panier->monnaie as $valuem) {?>
            <th>Solde Compte <?=strtoupper($valuem);?></th><?php 
          }?>
          <th></th>
        </tr>

      </thead>

      <tbody><?php 
        $cumulmontantgnf=0;
        $cumulmontanteu=0;
        $cumulmontantus=0;
        $cumulmontantcfa=0;

        if (isset($_GET['clientsearch'])) {

          $prodclient = $DB->query("SELECT *FROM client where id='{$_SESSION['reclient']}'");

        }else{

          $type1='transporteur';
          $type2='douanier';

          $prodclient = $DB->query("SELECT *FROM client where typeclient='{$type1}' or typeclient='{$type2}' ");          
        }


        foreach ($prodclient as $key => $value){?>

          <tr>

            <td style="text-align: center; font-size: 20px; "><?=$key+1; ?></td>

            <td style="font-size: 20px;"><?= $value->nom_client; ?></td> <?php

            foreach ($panier->monnaie as $valuem) {        

              $products= $DB->querys("SELECT sum(montant) as montant, devise, nom_client FROM bulletin where nom_client='{$value->id}' and devise='{$valuem}' ");

              if ($products['devise']=='gnf') {
                $cumulmontantgnf+=$products['montant'];
                $devise='gnf';
              }

              if ($products['devise']=='eu') {
                $cumulmontanteu+=$products['montant'];
                $devise='eu';
              }

              if ($products['devise']=='us') {
                $cumulmontantus+=$products['montant'];
                $devise='us';
              }

              if ($products['devise']=='cfa') {
                $cumulmontantcfa+=$products['montant'];
                $devise='cfa';
              }

              if ($products['montant']>0) {
                $color='red';
                $montant=$products['montant'];
              }else{

                $color='green';
                $montant=-$products['montant'];

              }?>

              <td style="text-align: right; padding-right: 5px; color: white; font-size: 20px; background-color: <?=$color;?>"><a style="color:white;" href="bilanfrais.php?bclient=<?=$products['nom_client'];?>&devise=<?=$devise;?>&frais"><?= number_format($montant,0,',',' '); ?></a></td><?php 
            }?>

            <td style=""></td>

          </tr><?php

        }?>

      </tbody>

      <tfoot>
          <tr>
            <th colspan="2">Solde</th>

            <th style="font-size: 20px; text-align: right; padding-right: 5px; background-color: <?=$panier->color($cumulmontantgnf);?>"><?= number_format($cumulmontantgnf,0,',',' ');?></th>

            <th style="font-size: 20px; text-align: right; padding-right: 5px; background-color: <?=$panier->color($cumulmontanteu);?>"><?= number_format($cumulmontanteu,0,',',' ');?></th>

            <th style="font-size: 20px; text-align: right; padding-right: 5px; background-color: <?=$panier->color($cumulmontantus);?>"><?= number_format($cumulmontantus,0,',',' ');?></th>

            <th style="font-size: 20px; text-align: right; padding-right: 5px; background-color: <?=$panier->color($cumulmontantcfa);?>"><?= number_format($cumulmontantcfa,0,',',' ');?></th>            
          </tr>
      </tfoot>

    </table>
  </div>
</div>

