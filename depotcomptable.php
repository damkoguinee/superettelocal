<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];


    if ($products['level']>=3) {

        if (isset($_GET['deleteret'])) {

            $DB->delete("DELETE from decaissement where numdec='{$_GET['deleteret']}'");

            $DB->delete("DELETE from bulletin where numero='{$_GET['deleteret']}'");

            $DB->delete("DELETE from banque where numero='{$_GET['deleteret']}'");?>

            <div class="alerteV">Suppression reussi!!</div><?php 
        }

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

          $datenormale='du '.(new DateTime($dates))->format('d/m/Y');
        }

        if (isset($_POST['clientliv'])) {
          $_SESSION['clientliv']=$_POST['clientliv'];
        }

        require 'navdec.php'; ?>

        <table class="payement">

          <thead>

            <tr>
                <form method="POST" action="depotcomptable.php" id="suitec" name="termc">

                    <th colspan="3" ><?php

                      if (isset($_POST['j1'])) {?>

                        <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php

                      }else{?>

                        <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()"><?php

                      }

                      if (isset($_POST['j2'])) {?>

                        <input style="width:150px;" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php

                      }else{?>

                        <input style="width:150px;" type = "date" name = "j2" onchange="this.form.submit()"><?php

                      }?>
                    </th>
                </form>

                <form method="POST" action="depotcomptable.php">

                    <th colspan="1">

                        <select name="clientliv" onchange="this.form.submit()" style="width: 200px;"><?php

                        if (isset($_POST['clientliv'])) {?>

                          <option value="<?=$_POST['clientliv'];?>"><?=ucwords($panier->nomClient($_POST['clientliv']));?></option><?php

                        }else{?>
                          <option></option><?php
                        }

                        $type1='banque';
                        $type2='banque';

                        foreach($panier->clientF($type1, $type2) as $product){?>

                          <option value="<?=$product->id;?>"><?=ucwords($product->nom_client);?></option><?php
                        }?>
                        </select>
                    </th>
                </form>

                <th colspan="3" height="30" style="font-size:14px;"><?="Liste des dépôts comptable " .$datenormale ?> <a href="dec.php?ajout" style="color:orange; font-size: 25px;">Effectuer un Retraît</a></th>
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Montant</th>
                  <th >Motif</th>
                  <th>Client</th>
                  <th>Date</th>
                  <th>Justif</th>
                  <th></th>
                </tr>

            </thead>

            <tbody><?php 
                $cumulmontant=0;

                if (isset($_POST['j1'])) {

                    $type='banque';

                  $products= $DB->query('SELECT decaissement.id as id, client.id as idc, numdec, client.nom_client as client, payement as type, montant, coment, payement, DATE_FORMAT(date_payement, \'%d/%m/%Y\')AS DateTemps FROM decaissement inner join client on client.id=decaissement.client  WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')>=? and DATE_FORMAT(date_payement, \'%Y%m%d\')<=? and typeclient=? order by(date_payement) desc ', array($_SESSION['date1'], $_SESSION['date2'], $type));

                }elseif (isset($_POST['clientliv'])) {

                  $products= $DB->query('SELECT decaissement.id as id, client.id as idc, numdec, client.nom_client as client, payement as type, montant, coment, payement, DATE_FORMAT(date_payement, \'%d/%m/%Y\')AS DateTemps FROM decaissement inner join client on client.id=decaissement.client  WHERE decaissement.client = :client order by(date_payement) desc ', array('client' => $_POST['clientliv']));

                }else{

                  $type='banque';

                    $products= $DB->query('SELECT decaissement.id as id, client.id as idc, numdec, client.nom_client as client, payement as type, montant, coment, payement, DATE_FORMAT(date_payement, \'%d/%m/%Y\')AS DateTemps FROM decaissement inner join client on client.id=decaissement.client  WHERE typeclient=? order by(date_payement) desc ', array($type));
                }

                foreach ($products as $product ){

                    $cumulmontant+=$product->montant;?>

                    <tr>

                        <td style="text-align: center;"><?= $product->numdec; ?></td>
                        
                        <td style="text-align: right; padding-right: 20px;"><?= number_format($product->montant,0,',',' '); ?></td>

                        <td style="font-size:14px;"><?= Ucwords($product->coment); ?></td>

                        <td style="font-size:14px;"><?= $product->client; ?></td>          
                        <td><?= $product->DateTemps; ?></td>

                        <td style="text-align: center">

                            <a href="printdecaissement.php?numdec=<?=$product->id;?>&idc=<?=$product->idc;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>
                          </td>

                        <td><a href="dec.php?deleteret=<?=$product->numdec;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a></td>

                    </tr><?php

                }?>

            </tbody>

            <tfoot>
                <tr>
                    <th></th>
                    <th style="text-align: right; padding-right: 20px;"><?= number_format($cumulmontant,0,',',' ');?></th>
                </tr>
            </tfoot>

        </table><?php

    }else{

        echo "VOUS N'AVEZ PAS TOUTES LES AUTORISATIOS REQUISES";
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