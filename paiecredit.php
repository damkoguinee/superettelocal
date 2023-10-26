<?php

if (isset($_POST['paieunit']) or isset($_GET['paiepart'])){

  if (isset($_POST['paieunit']) and isset($_POST['montant']) ) {

    $product = $DB->query('SELECT num_cmd FROM payement WHERE num_cmd=:num_cmd', array('num_cmd' => $_POST['num_cmd']));

    if(empty($product)){?>

      <div class="alertes">Vérifiez le Numéro Saisi</div><?php

    }else{

      $products = $DB->query('SELECT * FROM payement  WHERE num_cmd = :NUM', array('NUM'=>$_POST['num_cmd']));

      foreach ($products as $product){

        $reste=$product->reste;

        $montantpaye=$product->montantpaye+$_POST['montant'];
      }

      if ($product->etat=="credit") {

        if ($_POST['montant']>$reste) {?>

          <div class="alertes">Le montant Saisi est > au crédit</div><?php

        }elseif ($_POST['montant']<0) {?>

          <div class="alertes">Format Incorrect</div><?php

        }else{

          $remb="client";
          $products = $DB->query('SELECT num_cmd FROM historique WHERE num_cmd=:num_cmd', array('num_cmd' => $_POST['num_cmd']));

          if (!empty($products)) {

          }else{

            $DB->insert('INSERT INTO historique (num_cmd,montant,payement,nom_client,date_cmd,remboursement) VALUES(?, ?, ?, ?, ?, ?)', array($product->num_cmd, $product->montantpaye, $product->mode_payement, $product->num_client, $product->date_cmd, $remb));
          }

          $date = date('Y-m-d H:i');
          $reste=$product->reste-$_POST['montant'];

          $DB->insert('UPDATE payement SET montantpaye= ? , reste=? , mode_payement= ?, date_regul=? WHERE num_cmd = ?',array($montantpaye, $reste, $_POST['mode_payement'], $date, $_POST['num_cmd']));

          $DB->insert('INSERT INTO historique (num_cmd,montant,payement,nom_client,date_cmd,remboursement,date_regul) VALUES(?,?,?,?,?,?,now())', array($product->num_cmd, $_POST['montant'], $_POST['mode_payement'], $product->num_client, $product->date_cmd, $remb));

          $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_POST['compte'], $_POST['montant'], 'paiement'.$product->num_cmd, $product->num_cmd));

          if ($product->typeclient=="VIP") {

            $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($product->num_client, $_POST['montant'], "Payement client ", $product->num_cmd));
          }

          $Etat='totalite';         

          $products = $DB->query('SELECT * FROM payement  WHERE num_cmd = :NUM', array('NUM'=>$_POST['num_cmd']));

          foreach ($products as $product){

            if (($product->Total-$product->remise)== $product->montantpaye) {

              $DB->insert('UPDATE payement SET etat= ? , date_regul=? WHERE num_cmd = ?', array($Etat, $date, $_POST['num_cmd']));

            }else{?>

              <div class="alertes" style="color: green;">REMBOURSEMENT EFFECTUE AVEC SUCCES</div><?php

            }
            $_SESSION['num_cmd']=$_POST['num_cmd'];
            $_SESSION['payement']=$_POST['mode_payement'];
            $_SESSION['name']=$product->client;
            $_SESSION['montant']=$_POST['montant'];
            $_SESSION['reste']=$product->reste;

            if ($_POST['typeclient']=='VIP') {
              $_SESSION['reclient']=$product->num_client;
              $_SESSION['nameclient']=$product->num_client;
            }else{
              $_SESSION['reclient']=$_SESSION['name'];
              $_SESSION['nameclient']=$_SESSION['name'];
            }
            $_SESSION['typeclient']=$_POST['typeclient'];

            header("Location: printpayement.php");
          }
        }

      }
    }

  }elseif (isset($_GET['paiepart'])){

    $prodchoix = $DB->query('SELECT *FROM paiecred');

    foreach ($prodchoix as $value) {

      $montremb=$value->montant;

      $prodpaie = $DB->querys('SELECT num_cmd, montantpaye, Total, etat, remise, reste, mode_payement, client, num_client, typeclient, date_cmd FROM payement where num_cmd=:num', array('num'=>$value->numero));

      $montotp=$prodpaie['montantpaye']+$montremb;
      $reste=$prodpaie['reste']-$montremb;

      if ($reste==0) {
        $etat='totalite';
      }else{
        $etat='credit';
      }

      $date = date('Y-m-d H:i');

      $products = $DB->query('SELECT num_cmd FROM historique WHERE num_cmd=:num_cmd', array('num_cmd' =>$value->numero));

      if (!empty($products)) {

      }else{

        $DB->insert('INSERT INTO historique (num_cmd, montant, payement, nom_client, date_cmd, remboursement) VALUES(?, ?, ?, ?, ?, ?)', array($prodpaie['num_cmd'], $prodpaie['montantpaye'], $prodpaie['mode_payement'], $prodpaie['num_client'], $prodpaie['date_cmd'], 'client'));
      }

      $DB->insert('UPDATE payement SET montantpaye=?, reste=?, etat= ? , date_regul=? WHERE num_cmd = ?', array($montotp, $reste, $etat, $date, $value->numero));

      $DB->insert('INSERT INTO historique (num_cmd, montant, payement, nom_client, date_cmd, remboursement, date_regul) VALUES(?, ?, ?, ?, ?, ?, now())', array($value->numero, $montremb, $_GET['mode_payement'], $_SESSION['reclient'], $date, 'client'));

      $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_GET['compte'], $montremb, 'paiement'.$prodpaie['num_cmd'], $prodpaie['num_cmd']));

      if ($prodpaie['typeclient']=="VIP") {

        $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_SESSION['reclient'], $montremb, "Payement client ", $value->numero));
      }

      $DB->delete("DELETE FROM paiecred");

      $_SESSION['montant']=$_GET['montotfact'];
      $_SESSION['paiement']=$_GET['mode_payement'];

      $_SESSION['nameclient']=$_SESSION['reclient'];

      //header("Location: printpayementout.php");?>

      <div class="alerteV">Paiement enregistré avec succèe!!!</div><?php  
      
    }

  }elseif (isset($_POST['montantregt'])){

    $date = date('Y-m-d H:i');

    $prodpaie = $DB->query('SELECT num_cmd, montantpaye, Total, etat, remise, reste, mode_payement, client, num_client, typeclient, date_cmd FROM payement where client=:client and etat=:etat', array('client'=>$_POST['numc'], 'etat'=>'credit'));

    foreach ($prodpaie as $value) {

      $products = $DB->query('SELECT num_cmd FROM historique WHERE num_cmd=:num_cmd', array('num_cmd' =>$value->num_cmd));

      if (!empty($products)) {

      }else{

        $DB->insert('INSERT INTO historique (num_cmd, montant, payement, nom_client, date_cmd, remboursement) VALUES(?, ?, ?, ?, ?, ?)', array($value->num_cmd, $value->montantpaye, $value->mode_payement, $value->num_client, $value->date_cmd, 'client'));
      }

      $resteapayer=$value->Total-$value->montantpaye;

      $DB->insert('UPDATE payement SET montantpaye=?, reste=?, etat= ? , date_regul=? WHERE num_cmd = ?', array($resteapayer, 0, 'totalite', $date, $value->num_cmd));

      $DB->insert('INSERT INTO historique (num_cmd, montant, payement, nom_client, date_cmd, remboursement, date_regul) VALUES(?, ?, ?, ?, ?, ?, now())', array($value->num_cmd, $resteapayer, $_POST['mode_payement'], $_SESSION['reclient'], $date, 'client'));

      $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_POST['compte'], $resteapayer, 'paiement'.$value->num_cmd, $value->num_cmd));

      if ($value->typeclient=="VIP") {

        $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_SESSION['reclient'], $resteapayer, "Payement client ", $value->num_cmd));
      }
    }

    $_SESSION['montant']=$_POST['montot'];
    $_SESSION['paiement']=$_POST['mode_payement'];

    $_SESSION['nameclient']=$_SESSION['reclient'];

    header("Location: printpayementout.php");?>

    <div class="alerteV">Paiement éffectué avec succèe!!!</div><?php

  }



}else{

}