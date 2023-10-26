<?php
require '_header.php'
?><!DOCTYPE html>
<html lang="fr">

<head>
    <title>logescom-ms</title>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta content="Page par défaut" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/formulaire.css" type="text/css" media="screen" charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
    
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="deconnexion.php"><img src="css/img/deconn.jpg" width="30" alt="damko"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="choix.php">Accueil</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="versement.php?client">Entrées</a>
            </li><?php

              if ($_SESSION['statut']=='responsable' or $_SESSION['statut']=='admin') {?>

                <li class="nav-item">
                  <a class="nav-link" href="dec.php?client">Sorties</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="devise.php">Devise</a>
                </li>           
                
                <li class="nav-item">
                  <a class="nav-link" href="top5.php">Statistiques</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="promotion.php">Promotion</a>
                </li><?php 
              }?>

            <li class="nav-item">
              <a class="nav-link" href="comptasemaine.php">Comptabilite</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="bulletin.php?compte">Compte</a>
            </li>


          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid mt-3">
      <div class="row">
        <div class="col-sm-12 col-md-2 pb-3 bg-danger bg-opacity-50"> <?php 
          if ($_SESSION['level']>0) {?>
            <div class="row mt-3">
              <div class="col" ><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="client.php?liste">Liste des clients</a></div>
            </div>

            <div class="row mt-3">

              <div class="col" ><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="client.php?fournisseur">Liste des fournisseurs</a></div>
            </div><?php 
          }?>   

          <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="client.php?autres">Autres</a></div></div>

          <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="clientgestionlist.php">Gestion des clients</a></div></div>

          <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="clientgestionrendezvous.php">Planning du Jour</a></div></div>
        </div>

        <div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php

          if (isset($_GET['clientsearch'])) {

            $products= $DB->query("SELECT *FROM client where positionc='{$_SESSION['lieuvente']}' and id='{$_GET['clientsearch']}'");

          }else{

            $type1='client';
            $type2='clientf';

            if ($_SESSION['level']>6) {

              $products= $DB->query("SELECT *FROM client where (typeclient='{$type1}' or typeclient='{$type2}') order by(nom_client)");

            }else{

              $products= $DB->query("SELECT *FROM client where positionc='{$_SESSION['lieuvente']}' and (typeclient='{$type1}' or typeclient='{$type2}') order by(nom_client)");

            }

                    
          }?>

          <table class="table table-hover table-bordered table-striped table-responsive">
            <thead>
              <tr>
                <th colspan="4" scope="col" class="text-center bg-info"><label>Liste des clients à fideliser</label></th>

                <th colspan="3" scope="col" class="text-center bg-info">
                  <input class="form-control me-2" id="search-user" type="search" placeholder="Search client" aria-label="Search" >
                  <div style="color:white; background-color: grey; font-size: 16px;" id="result-search"></div>
                </th>
              </tr>

              <tr>
                <th colspan="7" scope="col" class="text-center"><label class="bg-warning">15 jours <= vente < 30 jours </label> - <label class="bg-danger">vente > à 30 jours et compte débiteur</label> - <label class="bg-danger bg-opacity-50">vente > à 30 jours</label></th>
              </tr>
              <tr>
                <th scope="col" class="text-center">N°</th>
                <th scope="col" class="text-center">Prénom & Nom</th>
                <th scope="col" class="text-center">Téléphone</th>
                <th scope="col" class="text-center">Adresse</th>
                <th scope="col" class="text-center">Solde</th>
                <th class="text-center">Dernière Relance</th>
                <th scope="col" class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody><?php 
              foreach ($products as $key => $value) {

                $prodmouv= $DB->querys("SELECT max(date_cmd) as datemouv FROM payement where num_client='{$value->id}' ");

                $prodrelance= $DB->querys("SELECT max(dateop) as daterelance, rappel FROM clientrelance where idclient='{$value->id}' ");

                if (empty($prodrelance['daterelance'])) {
                  $relance='';
                }else{
                  /*

                  if ($_SESSION['init']=='osa') {
                    

                    if ($prodrelance['rappel']==0) {

                      foreach ($panier->email as $valuem) {

                        $destinataire=$valuem;
                        $message='bonjour,
                        une relance est planifiée avec '.ucwords(strtolower($value->nom_client)).' aujourdhui';
                        ini_set( 'display_errors', 1);
                        error_reporting( E_ALL );
                        $from = "damkoguinee.com";
                        $to =$destinataire;
                        $subject = "Alerte relance";
                        $message = $message;
                        $headers = "From:" . $from;
                        mail($to,$subject,$message, $headers);
                      }
                    }
                  }
                  */

                  $relance=(new dateTime($prodrelance['daterelance']))->format("d/m/Y");
                }

                $anneed=(new dateTime($prodmouv['datemouv']))->format("Y");
                $moisd=(new dateTime($prodmouv['datemouv']))->format("m");
                $jourd=(new dateTime($prodmouv['datemouv']))->format("d");

                $datenow= date("Y-m-d");

                $datealertemin = date("Y-m-d", mktime(0, 0, 0, $moisd, $jourd+15,   $anneed));

                $datealerte = date("Y-m-d", mktime(0, 0, 0, $moisd, $jourd+30,   $anneed));

                if (empty($prodmouv['datemouv']) and empty($panier->compteClient($value->id, 'gnf'))) {
                  $color='danger';
                  $opacity=25;
                }else{

                  if ($datenow<=$datealertemin) {

                    $color='success';
                    $opacity=100;

                  }elseif ($datenow>=$datealerte and $panier->compteClient($value->id, 'gnf')<0) {

                    $color='danger';
                    $opacity=100;

                  }elseif ($datenow>=$datealerte) {

                    $color='danger';
                    $opacity=25;

                  }else{

                    $color='warning';
                    $opacity=100;

                  }
                }

                if ($color=='warning' or $color=='danger') {?>
                  <tr>
                    <th scope="row" class="text-center bg-<?=$color;?> bg-opacity-<?=$opacity;?> "><?=$key+1;?></th>
                    <td class="bg-<?=$color;?> bg-opacity-<?=$opacity;?>"><?=ucwords(strtolower($value->nom_client));?></td>
                    <td class="bg-<?=$color;?> bg-opacity-<?=$opacity;?>"><?=$value->telephone;?></td>
                    <td class="bg-<?=$color;?> bg-opacity-<?=$opacity;?>"><?=$value->adresse;?></td>
                    <td style="text-align: right" class="bg-<?=$color;?> bg-opacity-<?=$opacity;?>"><?=number_format(-$panier->compteClient($value->id, 'gnf'),0,',',' ');?></td>
                    <td class="bg-<?=$color;?> bg-opacity-<?=$opacity;?> text-center "><?=$relance;?></td>
                    <td><a class="btn btn-success m-auto" href="clientgestion.php?suiviclient=<?=$value->id;?>&nomclient=<?=$value->nom_client;?>">Consulter</a></td>
                  </tr><?php 
                }
            }?>
              
            </tbody>
          </table>

          
          
        </div>

      </div>
    </div>


    

</div>

    



  </body>
</html>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?clientgestionsearch',
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

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



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
