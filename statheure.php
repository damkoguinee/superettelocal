<?php // content="text/plain; charset=utf-8"
session_start();
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_bar.php');
require 'db.class.php';
$DB = new DB();


// **********************
// Extraction des données
// **********************

// Les années

$sql_annees = $DB->query('SELECT YEAR(date_cmd)as ANNEE FROM payement GROUP BY ANNEE');

// Pour chaque année récupérer le chiffre d'affaires

foreach ($sql_annees as $row_annees) {

    $tableauVentesParAnnees[$row_annees->ANNEE] = array(0,0,0,0,0,0,0,0,0,0,0,0);

    $sql_ventes_par_mois = $DB->query('SELECT MONTH(date_cmd)as MOIS, COUNT( `id` ) AS NOMBRE_VENTE, SUM(Total/1000) AS PRODUIT_VENTE FROM payement where year(date_cmd)=:annee GROUP BY MOIS', array('annee'=>$row_annees->ANNEE));

    foreach ($sql_ventes_par_mois as $row_mois) {

        $tableauVentesParAnnees[$row_annees->ANNEE][$row_mois->MOIS-1] = $row_mois->PRODUIT_VENTE;
    }
}


// **********************
// Création du graphique 
// **********************

// Création du graphique conteneur
$graph = new Graph(1200,500,'auto');    

// Type d'échelle
$graph->SetScale("textlin");

// Fixer les marges
$graph->img->SetMargin(60,80,30,40);

// Positionner la légende 
$graph->legend->Pos(0.02,0.05);

// Couleur de l'ombre et du fond de la légende
$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('lightblue@0.3');

// Obtenir le mois (localisation fr possible ?)
$graph->xaxis->SetTickLabels($gDateLocale->GetShortMonth());

// Afficher une image de fond
//$graph->SetBackgroundImage('images/R0011940.jpg',BGIMG_COPY);

// AXE X
$graph->xaxis->title->Set('Annees');
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetColor('black');
$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetColor('black');

// AXE Y
$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetColor('black');

//$graph->ygrid->SetColor('black@0.5');

// TITRE: texte
$graph->title->Set("Chiffre d'affaires/année");

// TITRE: marge et apparence
$graph->title->SetMargin(6);
$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);

// Couleurs et transparence par histogramme
$aColors=array('red@0.4', 'blue@0.4', 'green@0.4', 'pink@0.4', 'teal@0.4', 'navy@0.4');

$i=0;

// Chaque  histogramme est un élément du tableau:
$aGroupBarPlot = array();

foreach ($tableauVentesParAnnees as $key => $value) {
    $bplot = new BarPlot($tableauVentesParAnnees[$key]);
    $bplot->SetFillColor($aColors[$i++]);
    $bplot->SetLegend($key);
    $bplot->SetShadow('black@0.4');
    $aGroupBarPlot[] = $bplot; 
}

// Création de l'objet qui regroupe nos histogrammes
$gbarplot = new GroupBarPlot($aGroupBarPlot);
$gbarplot->SetWidth(0.8);

// Ajouter au graphique
$graph->Add($gbarplot);

// Afficher
$graph->Stroke();
?>



