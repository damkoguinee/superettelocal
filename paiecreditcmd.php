<?php

if (isset($_POST['paieunit']) or isset($_GET['paiepart'])){

  if (isset($_POST['paieunit']) and isset($_POST['montant']) ) {

    $product = $DB->querys('SELECT *FROM facture WHERE numcmd=:num_cmd', array('num_cmd' => $_POST['num_cmd']));

    if(empty($product)){?>

      <div class="alertes">Vérifiez le Numéro Saisi</div><?php

    }else{

      $reste=$product['montantht']+$product['montantva']-$product['montantpaye'];                
      $montant=($product['montantpaye']+$_POST['montant']);

      if ($reste!="0") {

        if ($_POST['montant']>$reste) {?>

          <div class="alertes">Le montant Saisi est > au crédit</div><?php

        }elseif ($_POST['montant']<0) {?>

          <div class="alertes">Format Incorrect</div><?php

        }else{

          $remb="magasin";
          $prodhist = $DB->query('SELECT num_cmd FROM histpaiefrais WHERE num_cmd=:Num', array('Num' => $product['numcmd']));

          if (!empty($prodhist)) {

          }else{

            $DB->insert('INSERT INTO histpaiefrais (num_cmd, montant, payement, nom_client, date_cmd, date_regul) VALUES(?, ?, ?, ?, ?, ?)',array($product['numcmd'], $product['montantpaye'], $product['payement'], $product['fournisseur'], $product['datecmd'], $product['datecmd']));
          }

          $date = date('Y-m-d H:i'); 

          $DB->insert('UPDATE facture SET montantpaye=?, payement=?, datepaye=? WHERE numcmd=?', array($montant, $_POST['mode_payement'], $date, $product['numcmd']));

          $DB->insert('INSERT INTO histpaiefrais(num_cmd, montant, payement, nom_client, date_cmd, date_regul) VALUES(?, ?, ?, ?, ?, now())', array($product['numcmd'], $_POST['montant'], $_POST['mode_payement'], $product['fournisseur'], $product['datecmd']));

          $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_POST['compte'], -$_POST['montant'], 'paiement '.$product['numcmd'], $product['numcmd']));

          $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($product['fournisseur'], -$_POST['montant'], "Paiement Fournisseur ", $product['numcmd']));          
        }

      }
    }

  }elseif (isset($_GET['paiepart'])){

    $prodchoix = $DB->query('SELECT *FROM paiecredcmd');

    foreach ($prodchoix as $value) {

      $montremb=$value->montant;

      $prodpaie = $DB->querys('SELECT *FROM facture where numcmd=:num', array('num'=>$value->numero));

      $montotp=$prodpaie['montantpaye']+$montremb;

      $reste=$prodpaie['montantht']+$prodpaie['montantva']-$prodpaie['montantpaye']-$montremb;

      
      $date = date('Y-m-d H:i');

      $prodhist = $DB->query('SELECT num_cmd FROM histpaiefrais WHERE num_cmd=:Num', array('Num' => $prodpaie['numcmd']));

      if (!empty($prodhist)) {

      }else{

        $DB->insert('INSERT INTO histpaiefrais (num_cmd, montant, payement, nom_client, date_cmd, date_regul) VALUES(?, ?, ?, ?, ?, ?)',array($prodpaie['numcmd'], $prodpaie['montantpaye'], $prodpaie['payement'], $prodpaie['fournisseur'], $prodpaie['datecmd'], $prodpaie['datecmd']));
      }

      

      $DB->insert('UPDATE facture SET montantpaye=?, datepaye=? WHERE numcmd = ?', array($montotp, $date, $value->numero));

      $DB->insert('INSERT INTO histpaiefrais (num_cmd, montant, payement, nom_client, date_cmd, date_regul) VALUES(?, ?, ?, ?, ?, ?)',array($value->numero, $montremb, $_GET['mode_payement'], $_SESSION['reclient'], $prodpaie['datecmd'], $date));

      $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_GET['compte'], -$montremb, 'paiement '.$value->numero, $value->numero));

      $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_SESSION['reclient'], -$montremb, "Paiement Fournisseur ", $value->numero));


      $DB->delete("DELETE FROM paiecredcmd");?>

      <div class="alerteV">Paiement enregistré avec succèe!!!</div><?php  
      
    }

  }elseif (isset($_POST['montantregt'])){

    $date = date('Y-m-d H:i');

    $prodpaie = $DB->query('SELECT * FROM facture where fournisseur=:client and (montantht+montantva-montantpaye)!=:etat', array('client'=>$_POST['numc'], 'etat'=>0));

    foreach ($prodpaie as $value) {

      $prodhist = $DB->query('SELECT num_cmd FROM histpaiefrais WHERE num_cmd=:Num', array('Num' => $value->numcmd));

      if (!empty($prodhist)) {

      }else{

        $DB->insert('INSERT INTO histpaiefrais (num_cmd, montant, payement, nom_client, date_cmd, date_regul) VALUES(?, ?, ?, ?, ?, ?)',array($value->numcmd, $value->montantpaye, $value->payement, $value->fournisseur, $value->datecmd, $value->datecmd));
      }

      $resteapayer=$value->montantht+$value->montantva-$value->montantpaye;

      $reste=$value->montantht+$value->montantva;


      $DB->insert('UPDATE facture SET montantpaye=?, datepaye=? WHERE numcmd = ?', array($reste, $date, $value->numcmd));

      $DB->insert('INSERT INTO histpaiefrais (num_cmd, montant, payement, nom_client, date_cmd, date_regul) VALUES(?, ?, ?, ?, ?, ?)',array($value->numcmd, $resteapayer, $_POST['mode_payement'], $_SESSION['reclient'], $value->datecmd, $date));

      $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_POST['compte'], -$resteapayer, 'paiement '.$value->numcmd, $value->numcmd));

      $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_SESSION['reclient'], -$resteapayer, "Paiement Fournisseur ", $value->numcmd));
    }?>

    <div class="alerteV">Paiement éffectué avec succèe!!!</div><?php

  }

}else{

}