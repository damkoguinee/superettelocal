<?php
require 'header.php';

$prodcred= $DB->querys('SELECT sum(reste) as reste FROM payement where client=:client and etat=:etat ', array('client'=>$_POST['client'], 'etat'=>'credit'));

$prodnum= $DB->query('SELECT num_cmd, Total, montantpaye, reste, remise, client, typeclient FROM payement where client=:client and etat=:etat ', array('client'=>$_POST['client'], 'etat'=>'credit'));

$prodreste= $DB->query('SELECT reste FROM payement where client=:client and etat=:etat ', array('client'=>$_POST['client'], 'etat'=>'credit'));

$date = date('y-m-d H:i');

if ($_POST['montant']==$prodcred['reste']) {

  foreach ($prodnum as $value) {

    $montantpaye=$value->Total-$value->remise;

    $DB->insert('UPDATE payement SET montantpaye= ? , reste=? , mode_payement= ?, date_regul=?, etat= ? WHERE num_cmd = ?',array($montantpaye, 0, $_POST['mode_payement'], $date, 'totalite', $value->num_cmd));

    $DB->insert('INSERT INTO historique (num_cmd, montant, payement, nom_client, date_cmd, remboursement, date_regul) VALUES(?, ?, ?, ?, ?, ?, now())', array($value->num_cmd, $value->reste, $_POST['mode_payement'], $_POST['client'], $date, 'client'));

    if ($value->typeclient=="VIP") {

      $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_POST['client'], $value->reste, "regularisation des credits ", $value->num_cmd));
    }
  }

}elseif ($_POST['montant']>$prodcred['reste']) {

  $surplus=$_POST['montant']-$prodcred['reste'];

  foreach ($prodnum as $value) {

    $montantpaye=$value->Total-$value->remise;

    $DB->insert('UPDATE payement SET montantpaye= ? , reste=? , mode_payement= ?, date_regul=?, etat= ? WHERE num_cmd = ?',array($montantpaye, 0, $_POST['mode_payement'], $date, 'totalite', $value->num_cmd));

    $DB->insert('INSERT INTO historique (num_cmd, montant, payement, nom_client, date_cmd, remboursement, date_regul) VALUES(?, ?, ?, ?, ?, ?, now())', array($value->num_cmd, $value->reste, $_POST['mode_payement'], $_POST['client'], $date, 'client'));

    if ($value->typeclient=="VIP") {

      $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_POST['client'], $value->reste, "regularisation des credits ", $value->num_cmd));
    }
  }

  $DB->insert('INSERT INTO versement (numcmd, nom_client, montant, motif, type_versement, date_versement) VALUES(?, ?, ?, ?, ?, now())', array($_POST['numc'], $_POST['client'], $surplus,  'surplus sur remboursement credit', $_POST['mode_payement']));

  if (empty($_POST['numc'])) {

    $maximum = $DB->querys('SELECT max(id) AS max_id FROM versement ');

    $max=$maximum['max_id'];

  }else{

    $max=$_POST['numc'];
  }

  $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_POST['client'], $surplus, 'surplus sur remboursement credit', $max));

}else{

  $count=sizeof($prodnum);

  $i=0;
 
  foreach ($prodnum as $key => $value) {

    $montantpaye=$value->montantpaye+$_POST['montant'];
    $reste=$value->reste-$_POST['montant'];

    if ($key==0) {

      

      if ($_POST['montant']==$value->reste) {echo "egal";

        $DB->insert('UPDATE payement SET montantpaye= ? , reste=? , mode_payement= ?, date_regul=?, etat= ? WHERE num_cmd = ?',array($value->Total-$value->remise, 0, $_POST['mode_payement'], $date, 'totalite', $value->num_cmd));

        $surplus=0;

      }elseif ($_POST['montant']<$value->reste) {echo "moins";
        
        $DB->insert('UPDATE payement SET montantpaye= ? , reste=? , mode_payement= ?, date_regul=?, etat= ? WHERE num_cmd = ?',array($montantpaye, $reste, $_POST['mode_payement'], $date, 'credit', $value->num_cmd));

        $surplus=0;

      }else{ echo "plus";

        $surplus=$_POST['montant']-$value->reste;

        //$DB->insert('UPDATE payement SET montantpaye= ? , reste=? , mode_payement= ?, date_regul=?, etat= ? WHERE num_cmd = ?',array($value->Total-$value->remise, 0, $_POST['mode_payement'], $date, 'totalite', $value->num_cmd));

      }

      //echo $surplus;

    }else{

        if ($value->reste==$surplus) {

          //$DB->insert('UPDATE payement SET montantpaye= ? , reste=? , mode_payement= ?, date_regul=?, etat= ? WHERE num_cmd = ?',array($value->Total-$value->remise, 0, $_POST['mode_payement'], $date, 'totalite', $value->num_cmd));

          $surplus=0;

        }elseif ($value->reste<$surplus) {

          //$DB->insert('UPDATE payement SET montantpaye= ? , reste=? , mode_payement= ?, date_regul=?, etat= ? WHERE num_cmd = ?',array($value->Total-$value->remise, 0, $_POST['mode_payement'], $date, 'totalite', $value->num_cmd));

          $surplus=0;

        }else{

          //$DB->insert('UPDATE payement SET montantpaye= ? , reste=? , mode_payement= ?, date_regul=?, etat= ? WHERE num_cmd = ?',array($value->Total-$value->remise, 0, $_POST['mode_payement'], $date, 'totalite', $value->num_cmd));

          $surpluss=$value->reste-$surplus;
        }

      var_dump($value->reste-$surplus);


    }

    //print_r($prodnum[0]);



    //$montantpaye=$value->Total-$value->remise;

    //$DB->insert('UPDATE payement SET montantpaye= ? , reste=? , mode_payement= ?, date_regul=?, etat= ? WHERE num_cmd = ?',array($montantpaye, 0, $_POST['mode_payement'], $date, 'totalite', $value->num_cmd));
    
    //print_r($key);

    //print_r($value->reste);
  }
  
}

