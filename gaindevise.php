<?php require 'header.php';

if (!empty($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];


    if ($products['level']>=3) {

        if (isset($_GET['deleteret'])) {

          $DB->delete("DELETE from gaindevise where id='{$_GET['deleteret']}'");?>

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

          $datenormale=(new DateTime($dates))->format('d/m/Y');
        }

        if (isset($_POST['clientliv'])) {
          $_SESSION['clientliv']=$_POST['clientliv'];
        }

        require 'headercompta.php';

        if (isset($_GET['ajout'])) {

          if (isset($_GET['searchclient']) ) {

              $_SESSION['searchclient']=$_GET['searchclient'];
          }?>

     
          <form id="naissance" method="POST" action="gaindevise.php" style="margin-top: 0px; width:90%; margin-top:10px;" >

              <fieldset><legend style="color:orange;">Enregistrer un Gain</legend>
                <ol>

                  <div style="display: flex;">
                    <div style="width: 50%;">

                      <li><label>Montant *</label><input id="numberconvert" type="number"   name="montant" min="0" required="" style="font-size: 25px; width: 50%;"></li>
                    </div>

                    <li style="width:50%;"><label style="width:50%;"><div style="color:white; background-color: grey; font-size: 25px; color: orange; width:100%;" id="convertnumber"></div></li></label>
                  </div>

                    <li><label>Type*</label>
                      <select name="type" required="" >
                        <option></option>                             
                        <option value="benefice">Bénéfice</option>
                        <option value="perte">Perte</option>
                      </select>
                    </li>                 

                    <li><label>Commentaires*</label><input type="text" name="coment" required=""></li>

                    <li><label>Magasin*</label>
                      <select  name="magasin" required="">
                        <option></option><?php
                        if ($_SESSION['level']>6) {

                          foreach($panier->listeStock() as $product){?>

                            <option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

                          }
                        }else{?>

                          <option value="<?=$_SESSION['lieuvente'];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php
                        }?>
                      </select>
                    </li>

                    <li><label>Date Opération</label><input type="date" name="datedep"></li>
                </ol>
             </fieldset>

            <fieldset><?php
                
              if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

                <input id="form"  type="submit" name="valid" value="VALIDER" onclick="return alerteV();" style="margin-left: 20px; margin-top: -20px; width:150px; cursor: pointer;"><?php

              }else{?>

                <div class="alertes"> Journée cloturée ou la licence est expirée </div><?php

              }?>
            </fieldset> 
        </form><?php 
    }


    if (isset($_POST['valid'])){

      if (empty($_POST["montant"]) OR empty($_POST["type"])) {?>

        <div class="alertes">Les Champs sont vides</div><?php

      }elseif ($_POST['montant']<0){?>

          <div class="alertes">FORMAT INCORRECT</div><?php

      }else{                          

        if (!empty($_POST['montant']) and !empty($_POST['type'])) {

          $dateop=$panier->h($_POST['datedep']);
          $montant=$panier->h($_POST['montant']);
          $type=$panier->h($_POST['type']);                    
          $motif=$_POST['coment'];
          $lieuvente=$_POST['magasin'];

          if ($type=='benefice') {

            if (empty($dateop)) {

              $DB->insert('INSERT INTO gaindevise (montant, coment, lieuvente, dateop) VALUES(?, ?, ?, now())',array($montant, $motif, $lieuvente));
                  
            }else{

              $DB->insert('INSERT INTO gaindevise (montant, coment, lieuvente, dateop) VALUES(?, ?, ?, ?)',array($montant, $motif, $lieuvente, $dateop));
            }
          }else{

            if (empty($dateop)) {

              $DB->insert('INSERT INTO gaindevise (montant, coment, lieuvente, dateop) VALUES(?, ?, ?, now())',array(-$montant, $motif, $lieuvente));
                  
            }else{

              $DB->insert('INSERT INTO gaindevise (montant, coment, lieuvente, dateop) VALUES(?, ?,  ?, ?)',array(-$montant, $motif, $lieuvente, $dateop));
            } 

          }

        } else{?>

          <div class="alert">Saisissez tous les champs vides</div><?php

        }

      }

    }

        if (!isset($_GET['ajout'])) {?>

          <table class="payement">

            <thead>

              <tr>
                <form method="POST" action="dec.php" id="suitec" name="termc">

                  <th colspan="2" ><?php

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

                  

                <th colspan="3" height="30"><?="Liste des Gains dévise " .$datenormale ?> <a href="gaindevise.php?ajout" style="color:orange;">Effectuer un enregistrement</a></th>
              </tr>

              <tr>
                <th>N°</th>
                <th>Date</th>
                <th>Montant</th>
                <th>Commentaire</th>
                <th>Actions</th>
              </tr>

              </thead>

              <tbody><?php 

                if (isset($_POST['j1'])) {

                  $products= $DB->query('SELECT *FROM gaindevise WHERE lieuvente=:lieu and DATE_FORMAT(dateop, \'%Y%m%d\')>= :date1 and DATE_FORMAT(dateop, \'%Y%m%d\')<= :date2 order by(dateop) desc', array('lieu'=>$_SESSION['lieuvente'], 'date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));

                }else{

                  $products= $DB->query('SELECT *FROM gaindevise WHERE lieuvente=:lieu and YEAR(dateop) = :annee order by(dateop) desc', array('lieu'=>$_SESSION['lieuvente'], 'annee' => date('Y')));
                }

                $montantgnf=0;
                foreach ($products as $keyv=> $product ){
                  $montantgnf+=$product->montant;?>

                  <tr>
                    <td style="text-align: center;"><?= $keyv+1; ?></td>
                    <td style="text-align:center;"><?=(new DateTime($product->dateop))->format('d/m/Y'); ?></td>
                    <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                    <td><?= ucwords(strtolower($product->coment)); ?></td>

                    <td><a href="gaindevise.php?deleteret=<?=$product->id;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a></td>
                      
                  </tr><?php 
                }?>

                </tbody>

                <tfoot>
                  <tr>
                    <th colspan="2">Totaux </th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($montantgnf,0,',',' ');?></th>
                  </tr>
                </tfoot>

            </table><?php
        }

    }else{

        echo "VOUS N'AVEZ PAS TOUTES LES AUTORISATIOS REQUISES";
    }

}else{


}?>   
</body>
</html>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script><?php 

if (isset($_GET['client'])) {?>

  <script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?clientdec',
                    data: 'user=' + encodeURIComponent(utilisateur),
                    success: function(data){
                        if(data != ""){
                          $('#result-search').append(data);
                        }else{
                          document.getElementById('result-search').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                        }
                    }
                })
            }
      
        });
    });
  </script><?php 
}else{?>

  <script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?decclient',
                    data: 'user=' + encodeURIComponent(utilisateur),
                    success: function(data){
                        if(data != ""){
                          $('#result-search').append(data);
                        }else{
                          document.getElementById('result-search').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                        }
                    }
                })
            }
      
        });
    });
  </script><?php 

}?> 

<script>
    $(document).ready(function(){
        $('#numberconvert').keyup(function(){
            $('#convertnumber').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'convertnumber.php?convertdec',
                    data: 'user=' + encodeURIComponent(utilisateur),
                    success: function(data){
                        if(data != ""){
                          $('#convertnumber').append(data);
                        }else{
                          document.getElementById('convertnumber').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                        }
                    }
                })
            }
      
        });
    });
  </script> 

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