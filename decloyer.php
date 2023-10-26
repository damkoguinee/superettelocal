<?php require 'header.php';

if (isset($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];


    if ($products['level']>=3) {

        if (isset($_GET['deleteret'])) {

            $DB->delete("DELETE from decloyer where numdec='{$_GET['deleteret']}'");

            $DB->delete("DELETE from bulletin where numero='{$_GET['deleteret']}'");

            $DB->delete("DELETE from banque where numero='{$_GET['deleteret']}'");?>

            <div class="alerteV">Suppression reussi!!</div><?php 
        }

        require 'navdec.php'; ?>

        <div class="decaissement">

            <div class="box_decaiss">

                <form method="post"  action="decloyer.php" target="_blank"><?php

                    if (isset($_GET['loyer'])) {?>

                        <table class="payement" style="width: 100%;">

                            <thead>
                              <tr>
                                <th class="legende" colspan="5" height="30"><?='Décaissement '." du " .date("d/m/y". "  à  ".date("H:i")) ?></th>  
                              </tr>

                              <tr>
                                <th>Montant décaissé</th>
                                <th>Payement</th>
                                <th>Compte à Prélever</th>
                                <th>Proriétaire</th>
                                <th>commentaires</th>               
                              </tr>

                            </thead>
                            
                            <tbody>
                                <td><input type="number" min="0"  name="montant" required="" style="font-size: 30px;"></td>
                                <td><select name="mode_payement" required="" >
                                    <option value=""></option><?php 
                                    foreach ($panier->modep as $value) {?>
                                        <option value="<?=$value;?>"><?=$value;?></option><?php 
                                    }?></select>
                                </td>

                                <td><select  name="compte" required="">
                                    <option></option><?php
                                        $type='Banque';

                                        foreach($panier->nomBanque() as $product){?>

                                            <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                                        }?>
                                    </select>               
                                </td>

                                <td><select class="nomstock" type="text" name="client" required="">
                                    <option></option><?php

                                    $type='Proprietaire';

                                    foreach($panier->ClientT($type) as $product){?>

                                        <option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php
                                    }?></select>
                                </td>
                                <td><input type="text" name="coment" required=""></td>                              

                            </tbody>

                        </table><?php
                        
                    }

                    if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

                        <input id="button"  type="submit" name="valid" value="VALIDER" onclick="return alerteV();"><?php

                    }else{?>

                        <div class="alertes"> CAISSE CLOTUREE OU LA LICENCE EST EXPIREE </div><?php

                    }?>
                    
                </form>

            </div>

        </div><?php


        if (isset($_POST['montant'])){

            if ($_POST['montant']<0){?>

                <div class="alertes">FORMAT INCORRECT</div><?php

            }elseif ($_POST['montant']>$panier->montantCompte($_POST['compte'])) {?>

                <div class="alertes">Echec montant decaissé est > au montant disponible en caisse</div><?php

            }elseif ($_POST['montant']>$panier->montantCompte($_POST['compte'])) {?>

                <div class="alertes">Echec montant decaissé est > au montant disponible</div><?php

            }else{                         

                if ($_POST['montant']!="") {

                    $numdec = $DB->querys('SELECT max(id) AS id FROM decloyer ');
                    $numdec=$numdec['id']+1;

                        
                    $DB->insert('INSERT INTO decloyer (numdec, montant, payement, coment, client, cprelever, date_payement) VALUES(?, ?, ?, ?, ?, ?,  now())',array('retl'.$numdec, $_POST['montant'], $_POST['mode_payement'], $_POST['coment'], $_POST['client'], $_POST['compte']));

                    //$client=$DB->querys("SELECT id, type from client where id='{$_POST['client']}'");

                    

                    $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_POST['compte'], -$_POST['montant'], "Retrait(".$_POST['coment'].')', 'retl'.$numdec));
                    

                    $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, date_versement) VALUES(?, ?, ?, ?, now())', array($_POST['client'], -$_POST['montant'], "Retrait loyer", 'retl'.$numdec));

                    if (isset($_POST["valid"])) {
                  
                        $_SESSION['nameclient']=$_POST['client'];

                        $_SESSION['reclient']=$_POST['client'];

                        header("Location: printdecloyer.php");
                  
                    }

                } else{?>

                  <div class="alert">Saisissez tous les champs vides</div><?php

                }

            }

        }else{

        }?>

        <div class="listedec"> 

            <table class="payement" style="width: 80%;">

                <thead>

                    <tr>
                      <th class="legende" colspan="6" height="30"><?php echo "Paiement du loyer de " .date("Y"). "  à  ".date("H:i") ?></th>
                    </tr>

                    <tr>
                      <th>N°</th>
                      <th>Montant</th>
                      <th>Motif</th>
                      <th>Propriétaire</th>
                      <th>Date</th>
                      <th></th>
                    </tr>

                </thead>

                <tbody><?php 
                    $cumulmontant=0;

                    $products = $DB->query('SELECT numdec, montant, coment, nom_client as client, DATE_FORMAT(date_payement, \'%d/%m/%Y \à %H:%i:%s\')AS DateTemps FROM decloyer inner join client on client=client.id WHERE YEAR(date_payement) = :annee ORDER BY(numdec)DESC', array('annee' => date('Y')));

                    foreach ($products as $product ){

                        $cumulmontant+=$product->montant;?>

                        <tr>

                            <td style="text-align: center;"><?= $product->numdec; ?></td>
                            
                            <td style="text-align: right; padding-right: 20px;"><?= number_format($product->montant,0,',',' '); ?></td>

                            <td><?= Ucwords($product->coment); ?></td>

                            <td><?= $product->client; ?></td>          
                            <td><?= $product->DateTemps; ?></td>

                            <td><a href="decloyer.php?deleteret=<?=$product->numdec;?>"> <input style="width: 100%;height: 30px; font-size: 17px; background-color: red;color: white; cursor: pointer;"  type="submit" value="Supprimer" onclick="return alerteS();"></a></td>

                        </tr><?php

                    }?>

                </tbody>

                <tfoot>
                    <tr>
                        <th></th>
                        <th style="text-align: right; padding-right: 20px;"><?= number_format($cumulmontant,0,',',' ');?></th>
                    </tr>
                </tfoot>

            </table>

        </div><?php

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