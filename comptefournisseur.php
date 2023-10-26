<div>
  <div><?php 
    $colspan=sizeof($panier->monnaie);?>
    <table class="payement" style="width: 90%;">

      <thead>

        <tr>
            <th colspan="3">

              <input style="width:55%;" id="search-user" type="text" name="clientsearch" placeholder="rechercher un fournisseur" />
              <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div><?php

                if (isset($_GET['fournisseursearch'])) {
                  $_SESSION['reclient']=$_GET['fournisseursearch'];
                }?>               
            </th>
          
            <th colspan="<?=$colspan;?>" height="30">Compte Fournisseurs
              <a style="margin-left: 10px;"href="printcomptecategorie.php?comptefournisseur" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>
            </th>
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

          if (isset($_GET['fournisseursearch'])) {

            $prodclient = $DB->query("SELECT *FROM client where id='{$_SESSION['reclient']}'");

          }else{

            $type1='fournisseur';
            $type2='fournisseur';

            $prodclient = array();          
          }
        }else{

          if (isset($_GET['fournisseursearch'])) {

            $prodclient = $DB->query("SELECT *FROM client where id='{$_SESSION['reclient']}'");

          }else{

            $type1='fournisseur';
            $type2='fournisseur';

            $prodclient = $DB->query("SELECT *FROM client where typeclient='{$type1}' or typeclient='{$type2}'");          
          }

        }


        foreach ($prodclient as $key => $value){?>

          <tr>

            <td style="text-align: center; font-size: 20px; "><?=$key+1; ?></td>

            <td style="font-size: 20px;"><?= $value->nom_client; ?></td> <?php

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

              if ($products['montant']>0) {
                $color='red';
                $montant=$products['montant'];
              }else{

                $color='green';
                $montant=-$products['montant'];

              }?>

              <td style="text-align: right; padding-right: 5px; color: white; font-size: 20px; background-color: <?=$color;?>"><a style="color:white;" href="bilanf.php?bclient=<?=$products['nom_client'];?>&devise=<?=$devise;?>"><?= number_format($montant,0,',',' '); ?></a></td><?php 
            }?>

            <td style=""></td>

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

            <th style="font-size: 20px; text-align: right; padding-right: 5px; background-color: <?=$panier->color($cumulmontantus);?>"><?= number_format($cmontantcfa,0,',',' ');?></th>

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
                    url: 'recherche_utilisateur.php?comptefournisseur',
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

