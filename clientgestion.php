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
    
    
</head><?php

$bdd="clientrelance";

$DB->insert("CREATE TABLE IF NOT EXISTS `".$bdd."`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `idclient` int(10) NOT NULL,
    `idpers` int(10) NOT NULL,
    `message` varchar(500) NOT NULL, 
    `rappel` int(11) NOT NULL DEFAULT '0',   
    `daterelance` date DEFAULT NULL,
    `dateop` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ");?>

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

        <div class="col col-sm-12 col-md-10">

          <div class="container-fluid"><?php 
            $_SESSION['suiviclient']=$_GET['suiviclient'];
            $_SESSION['nomclientsuivi']=$_GET['nomclient'];?>

            <div class="row">              

              <div class="col col-sm-12 col-md-8" style=" height: 380px; overflow: auto;"><?php 
                require 'clientrelance.php';?>                
              </div>

              <div class="col col-sm-12 col-md-4" style="height: 380px; overflow: auto;"><?php 
                require 'top5venteclient.php';?>                
              </div>

            </div>

            <div class="row">
              <div class="col col-sm-12 col-md-6" style="overflow: auto;"><?="<img src='./statclient.php' />"; ?></div>
              <div class="col col-sm-12 col-md-6" style="overflow: auto;"><?="<img src='./statprodclient.php' />"; ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
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
                    url: 'recherche_utilisateur.php?clientsearch',
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
}

if (isset($_GET['fournisseur'])) {?>

  <script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?fournisseursearch',
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
}

if (isset($_GET['autres'])) {?>

  <script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?autressearch',
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
