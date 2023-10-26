<?php require 'header.php';

require 'headercompta.php';

if (isset($_GET['recherchgen']) or isset($_POST['design']) or isset($_POST['magasin'])) {

}else{

   $_SESSION['designstat']=array();
   $_SESSION['recherchgenstat']=array();

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
}

if (isset($_GET['recherchgen'])) {
  $_SESSION['designstat']=array();
  $_SESSION['recherchgenstat']=$_GET['recherchgen'];

}

if (isset($_POST['design'])) {
   $_SESSION['recherchgenstat']=array();
  $_SESSION['designstat']=$_POST['design'];

}

if (isset($_POST['magasin'])) {
  $_SESSION['lieuventestat']=$_POST['magasin'];
}else{
  $_SESSION['lieuventestat']=$_SESSION['lieuvente'];
}?>

<div style="display:flex">
  <div><?php require 'navcompta.php';?></div>

  <div>

    <div style="display: flex; flex-wrap: wrap;">

      <div style="margin-right: 10px;">

        <table class="payement">

          <thead>

            <tr>

              <th colspan="2">

                <form method="POST" action="statproduit.php" id="suitec" name="termc"><?php

                  if (isset($_POST['j1']) or isset($_GET['recherchgen']) or isset($_POST['design']) or isset($_POST['magasin'])) {?>

                    <input style="width:150px;" type = "date" name = "j1" value="<?=$_SESSION['date01'];?>" onchange="this.form.submit()" ><?php

                  }else{?>

                    <input style="width:150px;" type = "date" name = "j1" onchange="this.form.submit()"><?php

                  }

                  if (isset($_POST['j2']) or isset($_GET['recherchgen']) or isset($_POST['design']) or isset($_POST['magasin'])) {?>

                    <input style="width:150px;" type = "date" name = "j2" value="<?=$_SESSION['date02'];?>" onchange="this.form.submit()"><?php

                  }else{?>

                    <input style="width:150px;" type = "date" name = "j2" onchange="this.form.submit()"><?php

                  }?>
                </form>

              </th>

              <th colspan="2"><?php 
                if (!empty($_SESSION['recherchgenstat'])) {?>

                  <input style="width:200px;" id="search-user" type="text" name="recherchgen" value="<?=$panier->nomProduit($_SESSION['recherchgenstat']);?>" /><?php 

                }else{?>

                  <input style="width:200px;" id="search-user" type="text" name="recherchgen" placeholder="rechercher un produit" /><?php 

                }?>

                <div style="color:white; background-color: black; font-size: 11px;" id="result-search"></div>
              </th>

              <th colspan="2">

                <form method="POST" action="statproduit.php" id="suitec" name="termc">

                  <select style="width:200px; height: 30px;" type="text" name="design" onchange="this.form.submit()" ><?php 
                    if (!empty($_SESSION['designstat'])) {?>
                      <option value="<?=$_SESSION['designstat'];?>"><?=$panier->nomCategorie($_SESSION['designstat'])?></option><?php
                    }else{?>
                      <option></option><?php
                    }

                    foreach($panier->recherchestock() as $value){?>
                        <option value="<?=$value->id;?>"><?=$value->nom;?></option><?php
                    }?>
                  </select>
                </form>
              </th>

              <th colspan="2">


                <form method="POST" action="statproduit.php" id="suitec" name="termc">


                  <select  name="magasin" onchange="this.form.submit()" style="width:150px;" ><?php

                    if (isset($_POST['magasin']) and $_POST['magasin']=='general') {?>

                      <option value="<?=$_POST['magasin'];?>">Général</option><?php
                      
                    }elseif (isset($_POST['magasin'])) {?>

                      <option value="<?=$_POST['magasin'];?>"><?=$panier->nomStock($_POST['magasin'])[0];?></option><?php
                      
                    }else{?>

                      <option value="<?=$_SESSION['lieuvente'];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php

                    }

                    if ($_SESSION['level']>6) {

                      foreach($panier->listeStock() as $product){?>

                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

                      }?>

                      <option value="general">Général</option><?php
                    }?>
                  </select>
                </form><?php 

                /*

                <form method="POST" action="top5.php" id="suitec" name="termc"><?php 

                  if ($_SESSION['level']>6) {?>

                    <select style="width:200px;"  name="magasin" onchange="this.form.submit()"><?php

                      if (isset($_POST['magasin']) and $_POST['magasin']=='general') {?>

                        <option value="<?=$_POST['magasin'];?>">Général</option><?php
                        
                      }elseif (isset($_POST['magasin'])) {?>

                        <option value="<?=$_POST['magasin'];?>"><?=$panier->nomStock($_POST['magasin'])[0];?></option><?php
                        
                      }else{?>

                        <option value="<?=$_SESSION['lieuvente'];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php

                      }

                      

                      foreach($panier->listeStock() as $product){?>

                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

                      }?>

                      <option value="general">Général</option>
                    </select><?php
                  }?>
                
                </form>
                */;?>
                </th>
              </tr>

              <tr><th colspan="7"><?="Statistique sur les Ventes/Achats des Produits";?></th></tr>

              <tr>
                <th>N°</th>
                <th>Désignation</th>
                <th>Achètés</th>
                <th>Vendus</th>
                <th>Montant Achat</th>
                <th>Montant Vendus</th>
                <th>Bénéfice</th>
              </tr>

          </thead>

          <tbody><?php 
              $cumul=0;
              $cumulben=0;

              $DB->delete("DELETE FROM statproduit where pseudo='{$_SESSION['idpseudo']}'");

              if (!empty($_SESSION['recherchgenstat'])) {

                $recherchgen=$panier->h($_SESSION['recherchgenstat']);

                $prod = $DB->query("SELECT *FROM productslist where id='{$recherchgen}' ");

              }elseif (!empty($_SESSION['designstat'])) {

                $recherchgen=$panier->h($_SESSION['designstat']);

                $prod = $DB->query("SELECT *FROM productslist where codecat='{$recherchgen}' ");

              }else{

                $prod = $DB->query('SELECT *FROM productslist');
              }

              foreach ($prod as $product ){

                if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

                  $qvprod=$panier->pvprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuvente'])[0];

                  $pvprod=$panier->pvprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuvente'])[1];

                  $prvprod=$panier->pvprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuvente'])[2];

                  $qaprod=$panier->paprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuvente'])[0];

                  $paprod=$panier->paprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuvente'])[1];

                  $praprod=$panier->paprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuvente'])[2];

                  //$benefice=$panier->beneficeprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuvente']);
                  
                }else{

                  $qvprod=$panier->pvprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuventestat'])[0];

                  $pvprod=$panier->pvprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuventestat'])[1];

                  $prvprod=$panier->pvprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuventestat'])[2];

                  $qaprod=$panier->paprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuventestat'])[0];

                  $paprod=$panier->paprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuventestat'])[1];

                  $praprod=$panier->paprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuventestat'])[2];

                  //$benefice=$panier->beneficeprodstatpardate($product->id, $_SESSION['date1'], $_SESSION['date2'], $_SESSION['lieuvente']);
                  
                }

                

                if (!empty($qvprod)) {
                  
                  $DB->insert('INSERT INTO statproduit (idprod, qtitevendus, qtiteachat, montantvendus, montantachat, prvente, prachat, pseudo) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($product->id, $qvprod, $qaprod, $pvprod, $paprod, $prvprod, $praprod, $_SESSION['idpseudo']));
                }
              }

              $products = $DB->query("SELECT *FROM statproduit where pseudo='{$_SESSION['idpseudo']}' ");


              foreach ($products as $key=> $product ){

                if ($key<=9) {

                  $cumul+=0;
                  $cumulben+=0;

                  $benefice=$product->montantvendus-$product->prvente;?>

                  <tr>

                    <td style="text-align: center;"><?= $key+1; ?></td>

                    <td><?=ucwords(strtolower($panier->nomProduit($product->idprod))); ?></td>

                    <td style="text-align: center;"><?=number_format($product->qtiteachat,0,',',' ');?></td>

                    <td style="text-align: center;"><?=number_format($product->qtitevendus,0,',',' ');?></td>

                    <td style="text-align: center;"><?=number_format($product->montantachat,0,',',' ');?></td>

                    <td style="text-align: center;"><?=number_format($product->montantvendus,0,',',' ');?></td>

                    <td style="text-align: center;"><?=number_format($benefice,0,',',' ');?></td>

                  </tr><?php
                }

              }?>

          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?statproduit',
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
</script>

