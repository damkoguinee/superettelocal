<div id="bilan">

  <div class="bloc_bilan">
          
    <table class="payement">

      <thead>

        <tr>
          <th class="legende" colspan="2" height="30" style="font-size: 18"><?="Bilan du " .$_SESSION['date'] ?></th> 
        </tr>

        <tr>
          <th>Désignation</th>
          <th>Montant</th>
        </tr>

      </thead>

      <tbody><?php 

      $mode_payement = array(

        "Espece" => "especes",
        "Cheque" => "cheque",
        "Virement bancaire" => "vire bancaire",
        "Vers bancaire" => "versement"        
      );

      $tot_enc=0;
      foreach ($mode_payement as $produc ):

        $products =$DB->query('SELECT SUM(Total) AS TOT, SUM(remise) AS REM, mode_payement FROM payement WHERE DATE_FORMAT(date_cmd, \'%m/%Y\') = :annee  AND mode_payement= :payement', array(
          'annee' => $_SESSION['date'],                      
          'payement'=>$produc
        ));     

        foreach ($products as $product ):

          if (empty($product->mode_payement)) {

          }else{

            $tot_enc+=($product->TOT-$product->REM); ?>

            <tr >                
              <td ><?=ucwords($product->mode_payement."s encaissés");?></td>              
              <td style="text-align: right" ><?=number_format(($product->TOT-$product->REM),2,',',' ');?></td>
            </tr><?php

          }?>

        <?php endforeach ?>

      <?php endforeach ?>

      

      <tr>
        <td>Chiffre d'affaire</td>
        <td style="text-align:right;"><?=number_format($tot_enc,2,',',' ');?></td>
      </tr>

      <?php
      $total_cours=0;
      $totalpaye=0;
      $remise=0;
      $credclient_gnf=0;            
      $products =$DB->query('SELECT SUM(Total) AS totc, SUM(montantpaye) AS montc, SUM(reste) as reste, mode_payement, SUM(remise) AS remc FROM payement WHERE DATE_FORMAT(date_cmd, \'%m/%Y\') = :annee  AND etat= :Etat ', array(
        'annee' => $_SESSION['date'],
        'Etat' =>'credit'
      ));      

      foreach ($products as $reste_payer ):

        $total_cours+=$reste_payer->totc;
        $totalpaye+=$reste_payer->montc;
        $remise+= $reste_payer->remc;
        $credclient_gnf+= $reste_payer->reste; ?>

        
        <tr>

          <td>Crédits Clients</td>
          <td style="text-align:right;"><?=number_format(($credclient_gnf),2,',',' ');?></td>
        </tr>

        <?php endforeach ?><?php

        $versementgnf=0;            

        $products =$DB->query('SELECT SUM(montant) AS sommeverse, date_versement FROM versement WHERE DATE_FORMAT(date_versement, \'%m/%Y\') = :annee', array('annee' => $_SESSION['date']));

        foreach( $products as $versement ):

          $versementgnf = $versement->sommeverse ;?>              

          <tr>
            <td>Total Versement</td>
            <td style="text-align:right;"><?=number_format(($versementgnf),2,',',' ');?></td>
          </tr>

        <?php endforeach ?>

        <tr>
          <td>Total Net Encaissé</td>
          <td style="text-align:right;"><?=number_format(($tot_enc-$credclient_gnf+$versementgnf),2,',',' ');?></td>
        </tr><?php

        $totremb_client=0;            
        $products =$DB->query('SELECT SUM(montant) AS montr FROM historique WHERE DATE_FORMAT(date_regul, \'%m/%Y\') = :annee  AND remboursement= :Remb ', array(
                'annee' => $_SESSION['date'],
                'Remb' =>'client'
        ));

        foreach ($products as $rembourse_client ):

          $totremb_client+=$rembourse_client->montr;?>

        <?php endforeach ?><?php

        if ($totremb_client==0) {

        }else{?>

          <tr>        
            <td>Remboursements Clients</td>
            <td style="text-align:right"><?=number_format(($totremb_client),2,',',' ');?></td>
          </tr><?php
        }?>

        <tr>
          <td style="text-align: center; background-color: yellow; color: red;" colspan="2">PARTIE DECAISSEMENT</td>
        </tr><?php            

        $montdec_gnf=0;
        $montant_eu=0;
        $montant_us=0;

        $mode_payement = array(

          "Espece" => "especes",
          "Vers bancaire" => "versement",
          "Cheque" => "cheque",
          "Virement bancaire" => "vire bancaire",
          "Vers bancaire" => "versement"        
        );

        foreach ($mode_payement as $produc ): 

          $products =$DB->query('SELECT SUM(montant) AS montg, payement FROM decaissement WHERE DATE_FORMAT(date_payement, \'%m/%Y\') = :annee AND payement= :payement', array(
                    'annee' => $_SESSION['date'],
                    'payement'=>$produc
                  ));    

          foreach ($products as $gnf ):

            $montdec_gnf+=$gnf->montg; ?>

            <tr>               
              <td ><?=ucwords($gnf->payement);?></td>              
              <td style="text-align: right"  ><?=number_format($gnf->montg,2,',',' ');?></td>

          <?php endforeach ?>                
        </tr> 

      <?php endforeach ?>

      

      <tr>
        <td>Total Décaissement</td>

        <td style="text-align:right;"><?=number_format($montdec_gnf,2,',',' ');?></td>

      </tr><?php


      $credit_gnf=0;                
      $products =$DB->query('SELECT prix_reel, montant FROM decaissement WHERE DATE_FORMAT(date_payement, \'%m/%Y\') = :annee  AND etat= :Etat',array(
          'annee' => $_SESSION['date'],
          'Etat' =>'credit'
        ));     

      foreach ($products as $product ):

        $credit_gnf+=(($product->prix_reel)-($product->montant)); ?>

      <?php endforeach ?>

      <tr> 
        <td>Crédits Magasin</td>
        <td style="text-align:right"><?=number_format(($credit_gnf),2,',',' ');?></td>
      </tr>

      <?php

      $totremb_mag=0;            
      $products =$DB->query('SELECT SUM(montant) AS month FROM historique WHERE DATE_FORMAT(date_regul, \'%m/%Y\') = :annee  AND remboursement= :Remb ', array(
        'annee' => $_SESSION['date'],
        'Remb' =>'magasin'
      ));

      foreach ($products as $rembourse_client ):

        $totremb_mag+=$rembourse_client->month;?>

      <?php endforeach ?><?php

      if ($totremb_mag==0) {

      }else{?>

        <tr>
          <td>Remboursements Magasin</td>
          <td style="text-align:right"><?=number_format(($totremb_mag),2,',',' ');?></td>
        </tr><?php

      }?>

      <tr>
        <td style="font-weight: bold; font-size: 14; background-color: green;color: white;"></td>
        <td style="font-weight: bold; font-size: 14;text-align:right; background-color: green; color: white;"></td>
      </tr>

    </tbody>
  </table>

</div>
</div>