<?php require 'header.php';

//require 'headerstock.php';?>
    
<div style="display: flex;">

  <div><?php require 'navstock.php';?></div><?php

    if (isset($_POST['designinp'])) {
      $_SESSION['designinp']=$_POST['designinp'];

    }elseif(!empty($_SESSION['designinp'])){

      $_SESSION['designinp']=$_SESSION['designinp'];

    }else{
      $_SESSION['designinp']='';
    }

    if (isset($_GET['fourn'])) {
      unset($_SESSION['designinp']);

    }?>

  <div style="width:80%;">

    <table class="payement">

      <form action="listeprodfournisseur.php" method="POST">

        <thead>

          <tr>

            <th colspan="3"><input style="width:250px; height: 30px;" type="text" name="designinp" onchange="this.form.submit()" placeholder="Rechercher une marque!!!" >
            </th>

            <th colspan="2" height="30"><?="Stock à la date " .date('d/m/Y'); ?></th>
          </tr>

          <tr>
            <th></th>
            <th>Désignation</th>
            <th>Catégorie</th>
            <th>Qtité</th>            
            <th>Nbre de vente</th>
          </tr>

        </thead>
      </form>

      <tbody>

        <?php
        $tot_achat=0;
        $tot_revient=0;
        $tot_vente=0;
        $quantite=0;

        if (!empty($_SESSION['designinp'])) {

          $productst = $DB->query("SELECT productslist.id as id, designation, nom FROM productslist inner join categorie on codecat=categorie.id where designation LIKE ? or Marque LIKE ? ORDER BY (designation)", array("%".$_SESSION['designinp']."%", "%".$_SESSION['designinp']."%"));
        }else{

          $productst = array();
        }

        foreach ($productst as $key=> $product){

          $qtites=0;

          foreach ($panier->listeStock() as $valueS) {

            $prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where productslist.id='{$product->id}' ");

            $qtites+=$prodstock['qtite'];

            
          }?>

          <tr>

            <th style="text-align: center;"><?=$key+1;?></th>

            <td style="text-align: left;"><?= ucwords(strtolower($product->designation)); ?></td>

            <td style="text-align: center;"><?= ucwords(strtolower($product->nom)); ?></td>

            <td style="text-align: center;"><?= $qtites; ?></td>

            <td style="text-align: center;"><?=number_format($panier->nbreventetotstat($product->id),0,',','');?></td>
          </tr><?php
        }?>

      </tbody>

    </table>
  </div>
</div> 

