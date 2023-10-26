<div id="bilan" style="display: flex; flex-wrap: wrap;">
  <?php 

  /*

  <div>

  <table class="payement">
    <thead>
      <tr>
        <th colspan="9">Situation des Caisses</th>
      </tr>

      <tr>
        <th style="width: 15%;"></th>
        <th colspan="4">Ajourdhui</th>
        <th colspan="4">Cumul</th>
      </tr>

      <tr>
        <th></th>
        <th>GNF</th>
        <th>$</th>
        <th>€</th>
        <th>CFA</th>

        <th>GNF</th>
        <th>$</th>
        <th>€</th>
        <th>CFA</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <th>Caisse1 Théorique</th>

        <td style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour(1, 'gnf', date('Ymd'), date('Ymd') ),0,',',' ');?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour(1, 'eu', date('Ymd'), date('Ymd')),0,',',' ');?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour(1, 'us', date('Ymd'), date('Ymd')),0,',',' ');?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour(1, 'cfa', date('Ymd'), date('Ymd')),0,',',' ');?></td>

        <td style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil(1, 'gnf', $_SESSION['date1'], $_SESSION['date2'] ),0,',',' ');?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil(1, 'eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil(1, 'us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil(1, 'cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr>

      <tr>
        <form action="comptasemaine.php" method="POST">

          <th>Caisse1 Réel</th><?php 

          if (isset($_POST['gnfr'])) {

            $gnfr=$panier->espace($panier->h($_POST['gnfr']));
            $eur=$panier->espace($panier->h($_POST['eur']));
            $usr=$panier->espace($panier->h($_POST['usr']));
            $cfar=$panier->espace($panier->h($_POST['cfar']));

            $gnfcr=$panier->espace($panier->h($_POST['gnfcr']));
            $eucr=$panier->espace($panier->h($_POST['eucr']));
            $uscr=$panier->espace($panier->h($_POST['uscr']));
            $cfacr=$panier->espace($panier->h($_POST['cfacr']));

            $diffgnfr=$panier->caisseJour(1, 'gnf', date('Ymd'), date('Ymd') )-$gnfr;
            $diffeur=$panier->caisseJour(1, 'eu', date('Ymd'), date('Ymd') )-$eur;
            $diffusr=$panier->caisseJour(1, 'us', date('Ymd'), date('Ymd') )-$usr;
            $diffcfar=$panier->caisseJour(1, 'cfa', date('Ymd'), date('Ymd') )-$cfar;

            $diffgnfcr=$panier->caisseJour(1, 'gnf', date('Ymd'), date('Ymd') )-$gnfcr;
            $diffeucr=$panier->caisseJour(1, 'eu', date('Ymd'), date('Ymd') )-$eucr;
            $diffuscr=$panier->caisseJour(1, 'us', date('Ymd'), date('Ymd') )-$uscr;
            $diffcfacr=$panier->caisseJour(1, 'cfa', date('Ymd'), date('Ymd') )-$cfacr;?>

            <td style="font-size:18px;text-align:right; padding-right: 5px;"><input type="text" name="gnfr" value="<?=$panier->formatNombre($gnfr);?>" onchange="this.form.submit()" ></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="eur" value="<?=$panier->formatNombre($eur);?>" onchange="this.form.submit()"></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="usr" value="<?=$panier->formatNombre($usr);?>" onchange="this.form.submit()"></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="cfar" value="<?=$panier->formatNombre($cfar);?>" onchange="this.form.submit()"></td>

            <td style="font-size:18px;text-align:right; padding-right: 5px;"><input type="text" name="gnfcr" value="<?=$panier->formatNombre($gnfcr);?>" onchange="this.form.submit()"></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="eucr" value="<?=$panier->formatNombre($eucr);?>" onchange="this.form.submit()"></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="uscr" value="<?=$panier->formatNombre($uscr);?>" onchange="this.form.submit()"></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="cfacr" value="<?=$panier->formatNombre($cfacr);?>" onchange="this.form.submit()"></td><?php

          }else{

            $diffgnfr=0;
            $diffeur=0;
            $diffusr=0;
            $diffcfar=0;

            $diffgnfcr=0;
            $diffeucr=0;
            $diffuscr=0;
            $diffcfacr=0;?>

            <td style="font-size:18px;text-align:right; padding-right: 5px;"><input type="text" name="gnfr" onchange="this.form.submit()" ></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="eur" onchange="this.form.submit()"></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="usr" onchange="this.form.submit()"></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="cfar" onchange="this.form.submit()"></td>

            <td style="font-size:18px;text-align:right; padding-right: 5px;"><input type="text" name="gnfcr" onchange="this.form.submit()"></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="eucr" onchange="this.form.submit()"></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="uscr" onchange="this.form.submit()"></td>

            <td style="font-size:18px; text-align:right; padding-right: 5px;"><input type="text" name="cfacr" onchange="this.form.submit()"></td><?php

          }?>
        </form>
      </tr>

      <tr>
        <th>Différence</th>

        <td style="font-size:18px;text-align:right; padding-right: 5px;"><?=$panier->formatNombre($diffgnfr);?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=$panier->formatNombre($diffeur);?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=$panier->formatNombre($diffusr);?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=$panier->formatNombre($diffcfar);?></td>

        <td style="font-size:18px;text-align:right; padding-right: 5px;"><?=$panier->formatNombre($diffgnfcr);?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=$panier->formatNombre($diffeucr);?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=$panier->formatNombre($diffuscr);?></td>

        <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=$panier->formatNombre($diffcfacr);?></td>
      </tr>
    </tbody>
  </table>
</div>
*/?>

<div style="display:flex; flex-wrap:wrap;">

  <div style="margin-right: 30px;">
          
    <table class="payement" >

      <thead>

        <tr>
          <th colspan="5"><?="Bilan " .$datenormale ?></th> 
        </tr>

        <tr>
          <th>Désignation</th>
          <th>Montant GNF</th>
          <th>Montant €</th>
          <th>Montant $</th>
          <th>Montant CFA</th>
        </tr>

      </thead>

      <tbody>

        <tr >                
          <td >Facturation(s) par Espèces</td>              
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('gnf', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

        <tr>
          <td>Facturation(s) par Chèques</td>
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('cheque', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
          <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
        </tr>

        <tr>
          <td>Facturation(s) Bancaire</td>
          <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->modepVente('virement', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
          <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
        </tr>

        <tr>
          <td style="font-size: 20px; padding-right: 5px;">Totaux Facturations</td>

          <td style="text-align: right; font-size: 25px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('gnf', $_SESSION['date1'], $_SESSION['date2'])[0],0,',',' ');?></td>

          <td style="text-align: right; font-size: 25px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('eu', $_SESSION['date1'], $_SESSION['date2'])[1],0,',',' ');?></td>

          <td style="text-align: right; font-size: 25px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('us', $_SESSION['date1'], $_SESSION['date2'])[1],0,',',' ');?></td>

          <td style="text-align: right; font-size: 25px; padding-right: 5px;" ><?=number_format($panier->totalFacturation('cfa',  $_SESSION['date1'], $_SESSION['date2'])[1],0,',',' ');?></td>
        </tr>

      <tr>
        <td style="color: orange; font-weight: bold;">Chiffre d'affaires</td>

        <td colspan="4" style="text-align: center; font-size: 22px; padding-right: 5px; color: orange; font-weight: bold;" ><?=number_format($panier->chiffrea($_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr>

      <tr>
        <td style="font-size: 22px; padding-right: 5px; color: red; font-weight: bold;">Crédits Clients</td>

        <td colspan="4" style="text-align: center; font-size: 22px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->resteFacturation($_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr>

      <tr>
        <td colspan="5" style="text-align:center; font-size: 25px; color:green;">Partie Encaissement</td>
      </tr>

      <tr >                
        <td ><a style="text-decoration: none;" href="versement.php">Encaissement par Espèces</a></td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('gnf', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('eu', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('us', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('cfa', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr>

      <tr >                
        <td >Encaissement par Chèque</td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('gnf', 'chèque', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
      </tr>

      <tr >                
        <td >Encaissement Bancaire</td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissement('gnf', 'virement', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
      </tr>

      <tr >                
        <td><a style="text-decoration: none;" href="devise.php?achat">Encaissement Achat Devise</a></td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('cfa', 'achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr>

      <tr >                
        <td >Encaissement Liquidités</td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->liquidite('gnf', 'liquidite', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" >---</td>

        <td style="text-align: right; padding-right: 5px;" >---</td>

        <td style="text-align: right; padding-right: 5px;" >---</td>
      </tr>


      <tr >                
        <td><a style="text-decoration: none;" href="banque.php">Encaissement des fonds</a></td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->transfertfond('gnf', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->transfertfond('eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->transfertfond('us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->transfertfond('cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr>


      <tr >                
        <td ><a style="text-decoration: none;" href="recette.php"> Encaissement Recettes</a></td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encrecette('gnf', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encrecette('eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encrecette('us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encrecette('cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr>

      <tr>
        <td style="font-size: 20px; padding-right: 5px;">Totaux Encaissement</td>

        <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('gnf', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2'])+$panier->liquidite('gnf', 'liquidite', $_SESSION['date1'], $_SESSION['date2'])+$panier->transfertfond('gnf', $_SESSION['date1'], $_SESSION['date2'])+$panier->encrecette('gnf', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('eu', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2'])+$panier->transfertfond('eu', $_SESSION['date1'], $_SESSION['date2'])+$panier->encrecette('eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('us', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2'])+$panier->transfertfond('us', $_SESSION['date1'], $_SESSION['date2'])+$panier->encrecette('us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; font-size: 18px; padding-right: 5px;" ><?=number_format($panier->totalEncaissement('cfa', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('cfa', 'achat devise', $_SESSION['date1'], $_SESSION['date2'])+$panier->transfertfond('cfa', $_SESSION['date1'], $_SESSION['date2'])+$panier->encrecette('cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr>

      <tr>
          <td style="font-size: 20px; padding-right: 5px; color: green; font-weight: bold;">TOTAL ENTREE</td>

          <td style="text-align: right; font-size: 20px; padding-right: 5px;color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('gnf', $_SESSION['date1'], $_SESSION['date2'])[0]+$panier->totalEncaissement('gnf', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementCovertDevise('vente devise', $_SESSION['date1'], $_SESSION['date2'])+$panier->liquidite('gnf', 'liquidite', $_SESSION['date1'], $_SESSION['date2'])+$panier->transfertfond('gnf', $_SESSION['date1'], $_SESSION['date2'])+$panier->encrecette('gnf', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 20px; padding-right: 5px; color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('eu', $_SESSION['date1'], $_SESSION['date2'])[1]+$panier->totalEncaissement('eu', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('eu', 'achat devise', $_SESSION['date1'], $_SESSION['date2'])+$panier->transfertfond('eu', $_SESSION['date1'], $_SESSION['date2'])+$panier->encrecette('eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 20px; padding-right: 5px; color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('us', $_SESSION['date1'], $_SESSION['date2'])[1]+$panier->totalEncaissement('us', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('us', 'achat devise', $_SESSION['date1'], $_SESSION['date2'])+$panier->transfertfond('us', $_SESSION['date1'], $_SESSION['date2'])+$panier->encrecette('us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

          <td style="text-align: right; font-size: 20px; padding-right: 5px; color: green; font-weight: bold;" ><?=number_format($panier->totalFacturation('cfa',  $_SESSION['date1'], $_SESSION['date2'])[1]+$panier->totalEncaissement('cfa', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('cfa', 'achat devise', $_SESSION['date1'], $_SESSION['date2'])+$panier->transfertfond('cfa', $_SESSION['date1'], $_SESSION['date2'])+$panier->encrecette('cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
        </tr>

      <tr>
        <td colspan="5" style="text-align:center; font-size: 25px; color:red;">Partie Décaissement</td>
      </tr>

      <tr >                
        <td ><a style="text-decoration: none;" href="dec.php">Décaissement par Espèces</a></td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('gnf', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('eu', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('us', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('cfa', 'espèces', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr>

      <tr >                
        <td>Décaissement par Chèque</td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('gnf', 'chèque', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
      </tr>

      <tr >                
        <td >Décaissement Bancaire</td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->decaissementBil('gnf', 'virement', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
          <td style="text-align: right" ></td>
      </tr>

      <tr >                
        <td ><a style="text-decoration: none;" href="devise.php?achat">Décaissement Achat Devise</a></td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementCovertDevise('achat devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('eu', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('us', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->encaissementDevise('cfa', 'vente devise', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr>

      <tr >                
        <td ><a style="text-decoration: none;" href="banque.php">Décaissement des fonds</a></td>              
        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->transfertfondec('gnf', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->transfertfondec('eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->transfertfondec('us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; padding-right: 5px;" ><?=number_format($panier->transfertfondec('cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr>

      <tr>
        <td style="font-size: 20px; padding-right: 5px; color: red; font-weight: bold;">Totaux Décaissement</td>

        <td style="text-align: right; font-size: 20px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('gnf', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementCovertDevise('achat devise', $_SESSION['date1'], $_SESSION['date2'])-$panier->transfertfondec('gnf', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; font-size: 20px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('eu', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('eu', 'vente devise', $_SESSION['date1'], $_SESSION['date2'])-$panier->transfertfondec('eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; font-size: 20px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('us', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('us', 'vente devise', $_SESSION['date1'], $_SESSION['date2'])-$panier->transfertfondec('us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

        <td style="text-align: right; font-size: 20px; padding-right: 5px; color: red; font-weight: bold;" ><?=number_format($panier->totalDecaissementBil('cfa', $_SESSION['date1'], $_SESSION['date2'])+$panier->encaissementDevise('cfa', 'vente devise', $_SESSION['date1'], $_SESSION['date2'])-$panier->transfertfondec('cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
      </tr><?php

      $soldetgnf=0;
      $soldeteu=0;
      $soldetus=0;
      $soldetcfa=0;

      foreach ($panier->nomBanqueBilan() as $banque) {

        if($banque->type!='banque'){?>

          <tr><?php

            if ($_SESSION['level']>1) {?>
              
              <th style="font-size:18px;"><?=strtoupper($banque->nomb);?> espèces du Jour</th>

              <th style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'gnf', $_SESSION['date1'], $_SESSION['date2'] )-$panier->caisseJourCheque($banque->id, 'gnf', $_SESSION['date1'], $_SESSION['date2'] ),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></th>
              <?php 
            }?>
          </tr>

          <tr><?php

            $soldetgnf+=$panier->montantCompteBil($banque->id, 'gnf');
            $soldeteu+=$panier->montantCompteBil($banque->id, 'eu');
            $soldetus+=$panier->montantCompteBil($banque->id, 'us');
            $soldetcfa+=$panier->montantCompteBil($banque->id, 'cfa');

            if ($_SESSION['level']>1) {?>
              
              <th style="font-size:18px;"><?=strtoupper($banque->nomb);?> Cumul espèces</th>

              <th style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'gnf')-$panier->montantCompteBilCheque($banque->id, 'gnf'),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'eu'),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'us'),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'cfa'),0,',',' ');?></th>
              <?php 
            }?>
          </tr><?php
        }


        if($banque->type!='banque'){?>

          <tr><?php

            if ($_SESSION['level']>3) {?>
              
              <th style="font-size:18px;"><?=strtoupper($banque->nomb);?> chèque du Jour</th>

              <th style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJourCheque($banque->id, 'gnf', $_SESSION['date1'], $_SESSION['date2'] ),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>
              <?php 
            }?>
          </tr>

          <tr><?php

            if ($_SESSION['level']>3) {?>
              
              <th style="font-size:18px;"><?=strtoupper($banque->nomb);?> Cumul chèque</th>

              <th style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBilCheque($banque->id, 'gnf'),0,',',' ');?></th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>

              <th style="font-size:18px; text-align:right; padding-right: 5px;">--</th>
              <?php 
            }?>
          </tr><?php
        }
      }

      if ($_SESSION['level']>3) {?>
        <tr>
          <th style="font-size:18px";>Totaux</th>
          <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($soldetgnf,0,',',' ');?></th>
          <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($soldeteu,0,',',' ');?></th>
          <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($soldetus,0,',',' ');?></th>
          <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($soldetcfa,0,',',' ');?></th>
        </tr><?php
      }?>

    </tbody>
  </table>
</div>

<div>

  <table class="payement">

    <thead>
      <tr>
        <th colspan="5">Situation des Comptes Bancaires</th>
      </tr>

      <tr>
        <th>Nom du Banque</th>
        <th>Solde GNF</th>
        <th>Solde €</th>
        <th>Solde $</th>
        <th>Solde CFA</th>
      </tr>
    </thead>

    <tbody><?php
  
      $soldetgnf=0;
      $soldeteu=0;
      $soldetus=0;
      $soldetcfa=0;

      foreach ($panier->nomBanque() as $banque) {

        if($banque->type=='banque'){?>

          <tr><?php

            if ($products['level']>6) {?>
              
              <th style="font-size:18px;"><?=strtoupper($banque->nomb);?> du Jour</th>

              <td style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'gnf', $_SESSION['date1'], $_SESSION['date2'] ),0,',',' ');?></td>

              <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'eu', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'us', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>

              <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->caisseJour($banque->id, 'cfa', $_SESSION['date1'], $_SESSION['date2']),0,',',' ');?></td>
              <?php 
            }?>
          </tr>

          <tr><?php

            $soldetgnf+=$panier->montantCompteBil($banque->id, 'gnf');
            $soldeteu+=$panier->montantCompteBil($banque->id, 'eu');
            $soldetus+=$panier->montantCompteBil($banque->id, 'us');
            $soldetcfa+=$panier->montantCompteBil($banque->id, 'cfa');

            if ($products['level']>6) {?>
              
              <th style="font-size:18px;">Cumul <?=strtoupper($banque->nomb);?></th>

              <td style="font-size:18px;text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'gnf'),0,',',' ');?></td>

              <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'eu'),0,',',' ');?></td>

              <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'us'),0,',',' ');?></td>

              <td style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($panier->montantCompteBil($banque->id, 'cfa'),0,',',' ');?></td>
              <?php 
            }?>
          </tr><?php
        }
      }

      if ($products['level']>6) {?>
        <tr>
          <th style="font-size:18px";>Totaux</th>
          <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($soldetgnf,0,',',' ');?></th>
          <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($soldeteu,0,',',' ');?></th>
          <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($soldetus,0,',',' ');?></th>
          <th style="font-size:18px; text-align:right; padding-right: 5px;"><?=number_format($soldetcfa,0,',',' ');?></th>
        </tr><?php
      }?>

    </tbody>
  </table>
</div>


</div>