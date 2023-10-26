<?php require 'header.php';

require 'headercompta.php';

if (!isset($_POST['annee'])) {

  $_SESSION['date']=date("Y");
  
}else{

  $_SESSION['date']=$_POST['annee'];
  
}

if (isset($_POST['liquide'])) {

    $_SESSION['liquide']=$_POST['liquide'];

    $liquide=$_SESSION['liquide'];

}elseif(isset($_POST['chiffrea'])){

    $liquide=$_SESSION['liquide'];

  
}else{

    $liquide=0;

}

  $tot_achat=0;
  $tot_vente=0;
  $tot_revient=0;
  foreach ($panier->listeStock() as $valueS) {

    $prodstock = $DB->querys("SELECT sum(prix_revient*quantite) as pr, sum(prix_achat*quantite) as pa, sum(prix_vente*quantite) as pv FROM `".$valueS->nombdd."`");

    $tot_achat+=$prodstock['pa'];
    $tot_vente+=$prodstock['pv'];
    $tot_revient+=$prodstock['pr'];
  }?>

  <form id='naissance' method="POST" action="inventairegeneral.php"> 

    <ol>
      <li><label></label>

        <select id="reccode" style="width: 250px; font-size: 14px;"  type="number" name="annee" required="" onchange="this.form.submit();"><?php 

          if (isset($_POST['annee'])) {?>
            <option value=""><?="Année ".$_POST['annee'];?></option><?php

          }else{?>

            <option value="">Choisir une année...</option><?php

          }

          $annee=date("Y");

          for($i=2018;$i<=$annee ;$i++){?>

            <option value="<?=$i;?>"><?=$i;?></option><?php

          }?>
        </select>
        
      </li>
    </ol>
  </form>

  <form id='liquide' method="POST" action="inventairegeneral.php">

    <div class="tbord">      

      <div class="casem">

        <div class="descriptd">ARGENT LIQUIDE</br>

          <input class="descriptmf" type="float" name="liquide" onchange="document.getElementById('liquide').submit()" value="<?=number_format($liquide,0,',',' ');?>">
        </div>
      </div>

      <div class="descripts">+</div>
    
      <div class="casem">
        <div class="descriptd">MONTANT CAISSE
          <div class="descriptm"><?=number_format($panier->montantCompteInvent('caisse'),0,',',' ');?></div>
        </div>
      </div>

      <div class="descripts">+</div>
    
      <div class="casem">
        <div class="descriptd">MONTANT BANQUE
          <div class="descriptm"><?=number_format($panier->montantCompteBanqueInvent('banque'),0,',',' ');?></div>
        </div>
      </div>
    

      <div class="descripts">+</div>
    
      <div class="casem">
        <div class="descriptd">MONTANT STOCK
          <div class="descriptm"><?=number_format($tot_revient,0,',',' ');?></div>
        </div>
      </div>

        <div class="descripts">+</div>
        <div class="casem">
          <div class="descriptd">SOLDE CREDITS
            <div class="descriptm" style="background-color: red;"><?= number_format((-1)*$panier->soldecredit(),0,',',' '); ?></div>
          </div>
        </div>
        
      <div class="casem">
        <div class="descriptd">DEPENSES
          <div class="descriptm"><?=number_format($panier->totdepense($_SESSION['date']),0,',',' ') ; ?></div>
        </div>
      </div>

    </div>
    <div class="descripts">| |</div>

    <div class="casem" style="display: flex; margin: auto; margin-top: 20px;"><?php

      $chiffrea=$liquide+$panier->montantCompteInvent('caisse')+$panier->montantCompteBanqueInvent('banque')+$tot_revient+$panier->soldecredit();?>

      <div style="margin-left:25%;">

        <div class="descriptd">SOLDE COMPTE <?= date("Y");?>
          <div class="descriptm"><?=number_format($chiffrea,0,',',' ') ; ?></div>
        </div>

      </div>
    </div>
  </form>                

  <form id="chiffrea" action="inventairegeneral.php" method="POST"><?php

    if (isset($_POST['chiffrea'])) {

      $chiffreaa=$_POST['chiffrea'];
    
    }else{
      $chiffreaa=0;
    }?>              

    <div class="tbord">                

      <div class="casem">
        <div class="descriptd">SOLDE COMPTE <?= date("Y")-1;?></br>
          <input class="descriptmf" type="float" name="chiffrea" onchange="document.getElementById('chiffrea').submit()" value="<?=number_format($chiffreaa,0,',',' ');?>">
        </div>
      </div>

      <div class="casem" style="margin-left: 20px;"><?php            

        if (!isset($_POST['chiffrea'])) {

        }else{

          if (($chiffrea-$chiffreaa)<0) {?>
            
            <div class="descriptd">MANQUE NET <?= date("Y");?>
            <div class="descriptmbn"><?=number_format($chiffrea-$chiffreaa,0,',',' ');?></div><?php

          }else{?>

            <div class="descriptd">BENEFICE NET <?= date("Y");?>
            <div class="descriptmbp"><?=number_format($chiffrea-$chiffreaa,0,',',' ');?></div><?php
          }
        }?>

      </div>
    </div>
  </form>