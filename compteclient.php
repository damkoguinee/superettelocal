<div>
  <div><?php 
    $colspan=sizeof($panier->monnaie);?>
    <table class="payement">

      <thead>

        <tr>

          <th colspan="3">
            <input style="width:55%;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
            <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div><?php 
            if (isset($_GET['clientsearch'])) {
              $_SESSION['reclient']=$_GET['clientsearch'];
            }


            if ($_SESSION['level']>6) {?>

              <form method="GET"  action="bulletin.php?client">
                <input type="hidden" name="client">

                <select style="width:200px;"  name="magasin" onchange="this.form.submit()"><?php

                  if (isset($_GET['magasin']) and $_GET['magasin']=='general') {?>

                    <option value="<?=$_GET['magasin'];?>">Général</option><?php
                    
                  }elseif (isset($_GET['magasin'])) {?>

                    <option value="<?=$_GET['magasin'];?>"><?=$panier->nomStock($_GET['magasin'])[0];?></option><?php
                    
                  }else{?>

                    <option value="<?=$_SESSION['lieuvente'];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php

                  }

                

                  foreach($panier->listeStock() as $product){?>

                    <option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

                  }?>

                  <option value="general">Général</option>
                </select>
              </form><?php
            }?> 
              
            </th>
          
            <th colspan="<?=$colspan;?>" height="30">Compte Clients et Client-Fournisseurs
              <a style="margin-left: 10px;"href="printcomptecategorie.php?compteclient" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>
            </th>
          </form>
        </tr>

        <tr>
          <th>N°</th>
          <th>Nom</th><?php 
          foreach ($panier->monnaie as $valuem) {?>
            <th>Solde Compte <?=strtoupper($valuem);?></th><?php 
          }?>
          <th></th>
        </tr>

      </thead>

      <tbody><?php 
        $cumulmontantgnf=0;
        $cumulmontanteu=0;
        $cumulmontantus=0;
        $cumulmontantcfa=0;

        if ($panier->adresse()=="ETS BBS (Beauty Boutique Sow)") {
          if (isset($_GET['clientsearch'])) {

            $prodclient = $DB->query("SELECT *FROM client where id='{$_SESSION['reclient']}'");

          }else{
            $prodclient=array();
          }
        }else{

          if (isset($_GET['clientsearch'])) {

            $prodclient = $DB->query("SELECT *FROM client where id='{$_SESSION['reclient']}'");

          }elseif (isset($_GET['magasin']) and $_GET['magasin']=='general') {

            $type1='client';
            $type2='clientf';

            $prodclient = $DB->query("SELECT *FROM client where (typeclient='{$type1}' or typeclient='{$type2}') ");

          }elseif (isset($_GET['magasin'])) {

            $type1='client';
            $type2='clientf';

            $prodclient = $DB->query("SELECT *FROM client where positionc='{$_GET['magasin']}' and (typeclient='{$type1}' or typeclient='{$type2}') ");

          }else{

            $type1='client';
            $type2='clientf';

            $prodclient = $DB->query("SELECT *FROM client where positionc='{$_SESSION['lieuvente']}' and (typeclient='{$type1}' or typeclient='{$type2}') ");
          }
        }


        foreach ($prodclient as $key => $value){?>

          <tr>

            <td style="text-align: center; font-size: 20px; "><?=$key+1; ?></td>

            <td style="font-size: 20px;"><?= ucwords(strtolower($value->nom_client)); ?></td> <?php

            foreach ($panier->monnaie as $valuem) {        

              $products= $DB->querys("SELECT sum(montant) as montant, devise, nom_client FROM bulletin where nom_client='{$value->id}' and devise='{$valuem}' ");

              if ($products['devise']=='gnf') {
                $cumulmontantgnf+=$products['montant'];
                $devise='gnf';
              }

              if ($products['devise']=='eu') {
                $cumulmontanteu+=$products['montant'];
                $devise='eu';
              }

              if ($products['devise']=='us') {
                $cumulmontantus+=$products['montant'];
                $devise='us';
              }

              if ($products['devise']=='cfa') {
                $cumulmontantcfa+=$products['montant'];
                $devise='cfa';
              }

              if ($products['devise']!='gnf' and $products['devise']!='eu' and $products['devise']!='us' and $products['devise']!='cfa') {
                $devise='gnf';
              }

              if ($products['montant']>0) {
                $color='red';
                $montant=$products['montant'];
              }else{

                $color='green';
                $montant=-$products['montant'];

              }?>

              <td style="text-align: right; padding-right: 5px; color: white; font-size: 20px; background-color: <?=$color;?>"><a style="color:white;" href="bilan.php?bclient=<?=$products['nom_client'];?>&devise=<?=$devise;?>"><?= number_format($montant,0,',',' '); ?></a></td><?php 
            }?>

            <td style=""><a href="bulletin.php?soldeclient=<?=$value->id;?>"><input style="width: 100%;height: 30px; font-size: 17px; background-color: orange;color: white; cursor: pointer;"  type="submit" value="Voir Facturation" onclick="return alerteS();"></a></td>

          </tr><?php

        }?>

      </tbody><?php 

      if ($cumulmontantgnf>0) {

        $cmontantgnf=$cumulmontantgnf;
      }else{
        $cmontantgnf=-$cumulmontantgnf;

      }

      if ($cumulmontanteu>0) {
        
        $cmontanteu=$cumulmontanteu;
      }else{
        $cmontanteu=-$cumulmontanteu;

      }

      if ($cumulmontantus>0) {
        
        $cmontantus=$cumulmontantus;
      }else{
        $cmontantus=-$cumulmontantus;

      }

      if ($cumulmontantcfa>0) {
        
        $cmontantcfa=$cumulmontantcfa;
      }else{
        $cmontantcfa=-$cumulmontantcfa;

      }?>

      <tfoot>
          <tr>
            <th colspan="2">Solde</th>

            <th style="font-size: 20px; text-align: right; padding-right: 5px; background-color: <?=$panier->color($cumulmontantgnf);?>"><?= number_format($cmontantgnf,0,',',' ');?></th>

            <th style="font-size: 20px; text-align: right; padding-right: 5px; background-color: <?=$panier->color($cumulmontanteu);?>"><?= number_format($cmontanteu,0,',',' ');?></th>

            <th style="font-size: 20px; text-align: right; padding-right: 5px; background-color: <?=$panier->color($cumulmontantus);?>"><?= number_format($cmontantus,0,',',' ');?></th>

            <th style="font-size: 20px; text-align: right; padding-right: 5px; background-color: <?=$panier->color($cumulmontantcfa);?>"><?= number_format($cmontantcfa,0,',',' ');?></th>            
          </tr>
      </tfoot>

    </table>
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
                    url: 'recherche_utilisateur.php?compteclient',
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

