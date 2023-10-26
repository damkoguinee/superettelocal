<?php // content="text/plain; charset=utf-8"
session_start();
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_bar.php');
require 'db.class.php';
$DB = new DB();

$periode=$_GET['periode'];

$products = $DB->query("SELECT num_cmd, date_cmd FROM payement order by(DATE_FORMAT(date_cmd, \"%$periode\"))");

//var_dump($_GET['periode']);
$days=[];
foreach ($products as $event) {
	$date=(new dateTime($event->date_cmd))->format($periode);

	if (!isset($days[$date])) {
		$days[$date]=[1];
	}else{
		$days[$date][]+=1;
	}
}


$donnee=[];

foreach($days as $key=>$value){

	if ($_GET['descript']=='Jours') {
		
		if ($key==1) {
			$key='Lundi';
		}elseif ($key==2) {
			$key='Mardi';
		}elseif ($key==3) {
			$key='Mercredi';
		}elseif ($key==4) {
			$key='Jeudi';
		}elseif ($key==5) {
			$key='Vendredi';
		}elseif ($key==6) {
			$key='Samedi';
		}elseif ($key==7) {
			$key='Dimanche';
		}else{
			$key=$key;
		}
	}

	$tableauAnnees[]=$key;
	$tableauNombreVentes[]=sizeof($value);
		
}

/*
printf('<pre>%s</pre>', print_r($tableauAnnees,1));
printf('<pre>%s</pre>', print_r($tableauNombreVentes,1));
*/
// Construction du conteneur
// Spécification largeur et hauteur
$graph = new Graph(1000,500);

// Réprésentation linéaire
$graph->SetScale("textlin");

// Ajouter une ombre au conteneur
$graph->SetShadow();

// Fixer les marges
$graph->img->SetMargin(40,30,25,40);

// Création du graphique histogramme
$bplot = new BarPlot($tableauNombreVentes);

// Spécification des couleurs des barres
$bplot->SetFillColor(array('red', 'green', 'blue'));
// Une ombre pour chaque barre
$bplot->SetShadow();

// Afficher les valeurs pour chaque barre
$bplot->value->Show();
// Fixer l'aspect de la police
$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,9);
// Modifier le rendu de chaque valeur
$bplot->value->SetFormat('%d ventes');

// Ajouter les barres au conteneur
$graph->Add($bplot);

// Le titre
$graph->title->Set("Graphique: Repartition des ventes par ".ucwords($_GET['descript']));
$graph->title->SetFont(FF_FONT1,FS_BOLD);

// Titre pour l'axe horizontal(axe x) et vertical (axe y)
$graph->xaxis->title->Set(ucwords($_GET['descript']));
$graph->yaxis->title->Set("Nombre de ventes");

$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Légende pour l'axe horizontal
$graph->xaxis->SetTickLabels($tableauAnnees);

// Afficher le graphique
$graph->Stroke();

?>