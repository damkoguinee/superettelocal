<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

  require 'headercompta.php';
  

  if ($products['level']>=3) {

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

    if (isset($_POST['devise'])) {
      $_SESSION['deviseselect']=$_POST['devise'];
    }elseif (isset($_POST['j1'])) {
      $_SESSION['deviseselect']=$_SESSION['deviseselect'];
    }else{
      $_SESSION['deviseselect']='gnf';
    };

    if (isset($_POST['banquerel'])) {
      $_SESSION['banquerel']=$_POST['banquerel'];
    };?>  

    <table class="payement" style="width:95%;"><?php 

      $cumulmontant=0;
        $dateselect=date('Y');
        $typecaisse='caisse';
        $zero=0;
        $devisegnf='gnf';
        $prodnombanque= $DB->querys("SELECT id FROM nombanque WHERE type='{$typecaisse}' ");

        $caisse=$prodnombanque['id'];

        if ($_SESSION['level']>6) {

          if (isset($_POST['banquerel'])) {

            $products= $DB->query("SELECT *FROM banque WHERE id_banque='{$_SESSION['banquerel']}' and montant!='{$zero}' and devise='{$_SESSION['deviseselect']}' order by(date_versement) desc");

          }elseif (isset($_POST['devise'])) {

            $products= $DB->query("SELECT *FROM banque WHERE id_banque='{$_SESSION['banquerel']}' and montant!='{$zero}' and devise='{$_SESSION['deviseselect']}' order by(date_versement) desc");

          }elseif (isset($_POST['j1'])) {

            $products= $DB->query("SELECT *FROM banque WHERE id_banque='{$_SESSION['banquerel']}' and montant!='{$zero}' and devise='{$_SESSION['deviseselect']}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>= '{$_SESSION['date1']}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<= '{$_SESSION['date2']}' order by(date_versement) desc");

          }else{

            $products= $DB->query("SELECT *FROM banque WHERE id_banque!='{$caisse}' and montant!='{$zero}' and devise='{$devisegnf}' and YEAR(date_versement) ='{$dateselect}' order by(date_versement) desc");
          }
        }else{

          if (isset($_POST['banquerel'])) {

            $products= $DB->query("SELECT *FROM banque WHERE lieuvente='{$_SESSION['lieuvente']}' and id_banque='{$_SESSION['banquerel']}' and montant!='{$zero}' and devise='{$_SESSION['deviseselect']}' order by(date_versement) desc");

          }elseif (isset($_POST['devise'])) {

            $products= $DB->query("SELECT *FROM banque WHERE lieuvente='{$_SESSION['lieuvente']}' and  id_banque='{$_SESSION['banquerel']}' and montant!='{$zero}' and devise='{$_SESSION['deviseselect']}' order by(date_versement) desc");

          }elseif (isset($_POST['j1'])) {

            $products= $DB->query("SELECT *FROM banque WHERE lieuvente='{$_SESSION['lieuvente']}' and id_banque='{$_SESSION['banquerel']}' and montant!='{$zero}' and devise='{$_SESSION['deviseselect']}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>= '{$_SESSION['date1']}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<= '{$_SESSION['date2']}' order by(date_versement) desc");

          }else{

            $products= $DB->query("SELECT *FROM banque WHERE lieuvente='{$_SESSION['lieuvente']}' and id_banque!='{$caisse}' and montant!='{$zero}' and devise='{$devisegnf}' and YEAR(date_versement) ='{$dateselect}' order by(date_versement) desc");
          }

        }

        $montantdebits=0;
        $montantcredits=0;

        foreach ($products as $keyd=> $product ){

          if ($product->montant<0) {
            $montantdebits+=$product->montant;
          }else{
            $montantcredits+=$product->montant;
          } 
        }?>

      <thead>
        <tr>
          <th height="30" colspan="5"><?="Relevé Bancaire en ".strtoupper($_SESSION['deviseselect']);?> Solde Compte: <?=number_format($montantcredits+$montantdebits,2,',',' ');?></th>
        </tr>

        <tr> 
          <form method="POST" action="relevebancaire.php">
            <th colspan="2">
              <li style="text-decoration: none; list-style: none;"><label>Banque</label>
              <select name="banquerel" required="" onchange="this.form.submit()" style="width:150px;"><?php
                if (!empty($_SESSION['banquerel'])) {?>

                  <option value="<?=$_SESSION['banquerel'];?>"><?=$panier->nomBanquefecth($_SESSION['banquerel']);?></option><?php
                }else{?>
                  <option></option><?php 
                } 
                foreach ($panier->nomBanque() as $valueb) {?>
                  <option value="<?=$valueb->id;?>"><?=strtoupper($valueb->nomb);?></option><?php 
                }?>
              </select>
            </li>
            </th>
          </form>

          <form method="POST" action="relevebancaire.php">
            <th colspan="1"><?php 
              if (!empty($_SESSION['banquerel'])) {?>
                <li style="text-decoration: none; list-style: none;"><label>Devise</label>
                  <select name="devise" required="" onchange="this.form.submit()" style="width:100px;"><?php
                    if (!empty($_SESSION['deviseselect'])) {?>

                      <option value="<?=$_SESSION['deviseselect'];?>"><?=$_SESSION['deviseselect'];?></option><?php
                    } 
                    foreach ($panier->monnaie as $valuem) {?>
                      <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                    }?>
                  </select>
                </li><?php 
              }?>
            </th>
          </form>

          <form method="POST" action="relevebancaire.php" id="suitec" name="termc">

            <th colspan="2" ><?php

              if (!empty($_SESSION['banquerel'])) {

                if (!empty($_SESSION['date1'])) {?>

                  <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php

                }else{?>

                  <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()"><?php

                }

                if (!empty($_SESSION['date2'])) {?>

                  <input style="width:150px;" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php

                }else{?>

                  <input style="width:150px;" type = "date" name = "j2" onchange="this.form.submit()"><?php

                }
              }?>
            </th>
          </form>                
        </tr>

        <tr>
          <th>N°</th>
          <th>Date</th>
          <th>Opérations</th>          
          <th>Débiter <?= strtoupper($_SESSION['deviseselect']);?></th>
          <th>Créditer <?= strtoupper($_SESSION['deviseselect']);?></th>
        </tr>

      </thead>

      <tbody><?php

      $montantdebit=0;
        $montantcredit=0;
       
        
        foreach ($products as $keyd=> $product ){?>

          <tr>
            <td style="text-align: center;"><?= $keyd+1; ?></td>
            <td><?=(new DateTime($product->date_versement))->format("d/m/Y H:i"); ?></td>
            <td><?= ucwords(strtolower($product->libelles)); ?></td><?php 

            if ($product->montant<0) {
              $montantdebit+=$product->montant;?>
              <td style="text-align:right;"><?=number_format(-1*$product->montant,0,',',' ');?></td>
              <td></td><?php
            }else{
              $montantcredit+=$product->montant;?>
              <td></td>
              <td style="text-align:right;"><?=number_format($product->montant,0,',',' ');?></td><?php
            }?>            
          </tr><?php 
        }?>

      </tbody>

      <tfoot>
        <tr>
          <th colspan="3">Totaux Versements</th>
          <th style="text-align: right; padding-right: 10px;"><?= number_format(-1*$montantdebit,0,',',' ');?></th>
          <th style="text-align: right; padding-right: 10px;"><?= number_format($montantcredit,0,',',' ');?></th>
          
        </tr>
      </tfoot>

    </table><?php

      

  }else{

    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

  }

}else{

  header("Location: deconnexion.php?payement");

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
