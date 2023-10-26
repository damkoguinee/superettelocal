<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];


    if ($_SESSION['level']>=3) {
        $prodep=$DB->query('SELECT id, nom FROM categoriedep');

        if (isset($_GET['deleteret'])) {

            $DB->delete("DELETE from decdepense where numdec='{$_GET['deleteret']}'");

            $DB->delete("DELETE from bulletin where numero='{$_GET['deleteret']}'");

            $DB->delete("DELETE from banque where numero='{$_GET['deleteret']}'");?>

            <div class="alerteV">Suppression reussi!!</div><?php 
        }

        if (isset($_POST['categorielist']) or isset($_POST['magasin'])) {

            $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

        }else{

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

              $datenormale=(new DateTime($_SESSION['date']))->format('d/m/Y');
            }
        }

        if (isset($_POST['categorielist'])) {
          $_SESSION['categoriedep']=$_POST['categorielist'];
        }

        if (isset($_POST['magasin'])) {
          $_SESSION['magasindep']=$_POST['magasin'];
        }



        require 'navdec.php'; 

        if(isset($_POST["categins"])){

          $cate=$_POST['cate'];

          $products=$DB->query('SELECT nom FROM categoriedep WHERE nom= ?', array($cate));

          if (empty($products)) {

            $DB->insert('INSERT INTO categoriedep (nom) VALUES (?)', array($cate));

          }else{?>

            <div class="alertes">Cette catégorie existe déjà</div><?php

          }
        }

        if(isset($_GET["categ"])){?>

          <form id="naissance" method="POST" action="decdepense.php" style="margin-top: 30px;" >
            <fieldset><legend>Ajouter une catégorie</legend>
              <ol>

                <li><label>Nom de la catégorie</label>
                    <input type="text" name="cate" required="">
                </li>
              </ol>
            </fieldset>

            <fieldset>

              <input type="reset" value="Annuler" name="valid" id="form" style="width:150px; cursor: pointer;"/>

              <input type="submit" value="Ajouter" name="categins" id="form" onclick="return alerteV();" style="margin-left: 20px; width:150px; cursor: pointer;" />

            </fieldset>
          </form><?php
        }

        

        if (isset($_GET['ajoutdep']) or isset($_POST['categins']) or isset($_GET["categ"])) {

            ?>

            <form id="naissance" method="POST" action="decdepense.php" enctype="multipart/form-data" style="margin-top: 0px; width:90%; margin-top:10px;" >

                <fieldset><legend style="color:orange;">Enregistrer une depense</legend>
                    <ol>
                        <li><label>Catégorie de dépense</label>
                            <select name="categorie" required="">
                                <option></option><?php
                                foreach ($prodep as $value) {?>

                                  <option value="<?=$value->id;?>"><?=ucfirst($value->nom);?></option><?php 
                                }?>
                            </select>

                            <a href="decdepense.php?categ">Ajouter une catégorie</a>
                        </li>

                        <div style="display: flex;">
                          <div style="width: 50%;">

                            <li><label>Montant Décaissé*</label><input id="numberconvert" type="number"   name="montant" min="0" required="" style="font-size: 25px; width: 50%;"></li>
                          </div>

                          <li style="width:50%;"><label style="width:50%;"><div style="color:white; background-color: grey; font-size: 25px; color: orange; width:100%;" id="convertnumber"></div></li></label>
                        </div>

                        <li><label>Devise*</label>
                          <select name="devise" required="" ><?php 
                            foreach ($panier->monnaie as $valuem) {?>
                                <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                            }?>
                          </select>
                        </li> 

                        <li><label>Mode de Payement*</label>
                          <select name="mode_payement" required="" ><?php 
                            foreach ($panier->modep as $value) {?>
                              <option value="<?=$value;?>"><?=$value;?></option><?php 
                            }?>
                          </select>
                        </li>

                        <li><label>Compte à Prélever</label>

                            <select  name="compte" required="">
                                <option></option><?php
                                $type='Banque';

                                foreach($panier->nomBanque() as $product){?>

                                    <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                                }?>
                            </select>
                        </li>

                        <li><label>Commentaires</label><input type="text" name="coment" required=""></li>

                        <li><label>Justificatifs</label>
                            <input type="file" name="just[]"multiple id="photo" />
                            <input type="hidden" value="b" name="env"/>
                        </li>

                        <li><label>Date Op</label><input type="date" name="datedep"></li>
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

        if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

            <input id="button"  type="submit" name="valid" value="VALIDER" onclick="return alerteV();"><?php

        }else{?>

            <div class="alertes"> CAISSE CLOTUREE OU LA LICENCE EST EXPIREE </div><?php

        }


        if (isset($_POST['valid'])){            

            if ($_POST['montant']<0){?>

                <div class="alertes">FORMAT INCORRECT</div><?php

            }elseif ($_POST['montant']>$panier->montantCompteBil($_POST['compte'], $_POST['devise'])) {?>

                <div class="alertes">Echec montant decaissé est > au montant disponible en caisse</div><?php

            }else{                         

                if (!empty($_POST['montant']) and !empty($_POST['categorie']) and !empty($_POST['compte'])) {

                    $numdec = $DB->querys('SELECT max(id) AS id FROM decdepense ');
                    $numdec=$numdec['id']+1;

                    $categorie=$_POST['categorie'];
                    $montant=$panier->h($_POST['montant']);
                    $devise=$panier->h($_POST['devise']);
                    $motif=$panier->h($_POST['coment']);
                    $payement=$_POST['mode_payement'];
                    $compte=$panier->h($_POST['compte']);
                    $dateop=$panier->h($_POST['datedep']);
                    $lieuventeret=$panier->lieuVenteCaisse($compte)[0];

                    if(isset($_POST["env"])){

                        require "uploadep.php";
                    }

                    if (empty($dateop)) {
                        
                        $DB->insert('INSERT INTO decdepense (numdec, categorie, montant, devisedep, payement, coment, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?,  now())',array('retd'.$numdec, $categorie, $montant, $devise, $payement, $motif, $compte, $lieuventeret));

                        $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, now())', array($compte, -$montant, "Retrait (".$motif.')', 'retd'.$numdec, $devise, $lieuventeret));
                    }else{

                        $DB->insert('INSERT INTO decdepense (numdec, categorie, montant, devisedep, payement, coment, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?,  ?)',array('retd'.$numdec, $categorie, $montant, $devise, $payement, $motif, $compte, $lieuventeret, $dateop));

                        $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?)', array($compte, -$montant, "Retrait (".$motif.')', 'retd'.$numdec, $devise, $lieuventeret, $dateop));

                    }
                    ?>

                    <div class="alerteV">Retrait enregistré avec succèe!!</div><?php

                } else{?>

                  <div class="alertes">Saisissez tous les champs vides</div><?php

                }

            }

        }else{

        }


        if (!isset($_GET['ajoutdep'])) {?>

            <table class="payement">

              <thead>
                <tr><th class="legende" colspan="12" height="30"><?="Liste des Dépenses " .$datenormale ?> <a href="decdepense.php?ajoutdep" style="color:orange; font-size: 25px;">Enregistrer une dépense</a><a href="printdepenses.php" target="_blank" ><img  style=" margin-left: 20px; height: 20px; width: 20px;" src="css/img/pdf.jpg"></a></th></tr>

                <tr>
                  <form method="POST" action="decdepense.php" id="suitec" name="termc">

                    <th colspan="4" ><?php

                      if (isset($_POST['j1']) or isset($_POST['categorie'])) {?>

                        <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_SESSION['date01'];?>"><?php

                      }else{?>

                        <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()"><?php

                      }

                      if (isset($_POST['j2']) or isset($_POST['categorie'])) {?>

                        <input style="width:150px;" type = "date" name = "j2" value="<?=$_SESSION['date02'];?>" onchange="this.form.submit()"><?php

                      }else{?>

                        <input style="width:150px;" type = "date" name = "j2" onchange="this.form.submit()"><?php

                      }?>
                    </th>
                  </form>

                  <form method="POST" action="decdepense.php" id="suitec" name="termc">
                    <th colspan="4"><?php 


                      if (isset($_POST['j1']) or isset($_POST['magasin']) or isset($_POST['categorie'])) {?>
                    
                        <select style="width: 200px;" name="magasin" onchange="this.form.submit()"><?php

                          if (!empty($_SESSION['magasindep']) and $_SESSION['magasindep']=='general') {?>

                            <option value="<?=$_SESSION['magasindep'];?>">Général</option><?php
                            
                          }elseif (!empty($_SESSION['magasindep'])) {?>

                            <option value="<?=$_SESSION['magasindep'];?>"><?=$panier->nomStock($_SESSION['magasindep'])[0];?></option><?php
                            
                          }else{?>

                            <option></option><?php

                          }

                          if ($_SESSION['level']>6) {

                            foreach($panier->listeStock() as $product){?>

                              <option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

                            }?>

                            <option value="general">Général</option><?php
                          }?>
                        </select><?php 
                      }?>
                    </th>
                  </form>

                  <form method="POST" action="decdepense.php">

                    <th colspan="4"><?php 

                        if (isset($_POST['magasin']) or isset($_POST['categorielist'])) {?>

                            <select name="categorielist" required="" onchange="this.form.submit()" style="width:300px;"><?php 
                                if (isset($_POST['categorielist'])) {?>

                                    <option value="<?=$_POST['categorielist'];?>"><?=ucfirst($panier->nomCategoriedep($_POST['categorie']));?></option><?php
                                    
                                }else{?>

                                    <option>Selectionnez une Catégorie</option><?php 
                                }
                                foreach ($prodep as $value) {?>

                                  <option value="<?=$value->id;?>"><?=ucfirst($value->nom);?></option><?php 
                                }?>
                            </select><?php 
                        }?>
                    </th>
                  </form>                  
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Just</th>
                  <th>Date</th>
                  <th>Catégorie</th>
                  <th>Motif</th>                  
                  <th>GNF</th>
                  <th>$</th>
                  <th>€</th>
                  <th>CFA</th>
                  <th>V. Banque</th>
                  <th>Chèque</th>
                  <th>Actions</th>
                </tr>

              </thead>

              <tbody><?php 

                if (isset($_POST['j1'])) {

                  

                    if ($_SESSION['level']>6) {
                        $products= $DB->query('SELECT *FROM decdepense WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(id) desc', array('date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));
                    }else{
                        $products= $DB->query('SELECT *FROM decdepense WHERE lieuvente=:lieu and DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(id) desc', array('lieu'=>$_SESSION['lieuvente'], 'date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));
                    }

                }elseif (isset($_POST['magasin'])) {

                  if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

                    $products= $DB->query('SELECT *FROM decdepense WHERE DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(id) desc', array('date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));
                  }else{
                    $products= $DB->query('SELECT *FROM decdepense WHERE lieuvente=:lieu and DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(id) desc', array('lieu'=>$_SESSION['magasindep'], 'date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));
                  }                 

                }elseif (isset($_POST['categorielist'])) {                  

                    if ($_SESSION['magasindep']=='general') {
                        $products= $DB->query('SELECT * FROM decdepense  WHERE categorie= :client and DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(id) desc', array('client' => $_SESSION['categoriedep'], 'date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));
                    }else{
                        $products= $DB->query('SELECT * FROM decdepense  WHERE lieuvente=:lieu and categorie= :client and DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(id) desc', array('lieu'=>$_SESSION['magasindep'], 'client' => $_SESSION['categoriedep'], 'date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));
                    }

                }else{

                    if ($_SESSION['level']>6) {
                        $products= $DB->query('SELECT *FROM decdepense  order by(id) desc');
                    }else{
                        $products= $DB->query('SELECT *FROM decdepense order by(id) desc');
                    }

                  
                }

                $montantgnf=0;
                $montanteu=0;
                $montantus=0;
                $montantcfa=0;
                $virement=0;
                $cheque=0;
                foreach ($products as $keyv=> $product ){?>

                    <tr>
                    <td style="text-align: center;"><?= $keyv+1; ?></td>

                    <td style="text-align: center"><?php
                        $num=$product->numdec;
                        $nom_dossier="justificatifdep/".$product->numdec."/";
                        if (file_exists($nom_dossier)) {

                            $dossier=opendir($nom_dossier);
                            while ($fichier=readdir($dossier)) {

                                if ($fichier!='.' && $fichier!='..') {?>

                                    <a href="justificatifdep/<?=$product->numdec;?>/<?=$fichier;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a><?php
                                }
                            }closedir($dossier);
                        }?>
                    </td>
                    <td style="text-align:center;"><?=(new DateTime($product->date_payement))->format("d/m/Y"); ?></td>
                    <td><?= ucwords(strtolower($panier->nomCategoriedep($product->categorie))); ?></td>
                    <td><?= ucwords(strtolower($product->coment)); ?></td><?php

                    if ($product->devisedep=='gnf' and $product->payement=='espèces') {

                        $montantgnf+=$product->montant;?>

                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td><?php

                      }elseif ($product->devisedep=='us') {
                        $montantus+=$product->montant;?>

                        <td></td>
                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td><?php
                      }elseif ($product->devisedep=='eu') {
                        $montanteu+=$product->montant;?>

                        <td></td>
                        <td></td>
                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                        <td></td>
                        <td></td>
                        <td></td><?php
                      }elseif ($product->devisedep=='cfa') {
                        $montantcfa+=$product->montant;?>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                        <td></td>
                        <td></td><?php

                      }elseif ($product->payement=='virement') {
                        $virement+=$product->montant;?>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>
                        <td></td><?php
                      }elseif ($product->payement=='chèque') {
                        $cheque+=$product->montant;?>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td><?php
                      }?>

                      

                      <td><?php if ($_SESSION['level']>6){?><a href="decdepense.php?deleteret=<?=$product->numdec;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a><?php };?></td>
                      
                    </tr><?php 
                }?>

                </tbody>

                <tfoot>
                  <tr>
                    <th colspan="3">Totaux Décaissements</th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($montantgnf,0,',',' ');?></th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($montantus,0,',',' ');?></th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($montanteu,0,',',' ');?></th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($montantcfa,0,',',' ');?></th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($virement,0,',',' ');?></th>
                    <th style="text-align: right; padding-right: 10px;"><?= number_format($cheque,0,',',' ');?></th>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



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

