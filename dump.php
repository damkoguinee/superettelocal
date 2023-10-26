<?php require '_header.php';

	//$panier->dumpMySQL("localhost", "root", "", "abda", 3);

//Entrez ici les informations de votre base de données et le nom du fichier de sauvegarde.
/*
$mysqlDatabaseName ='abda';
$mysqlUserName ='root';
$mysqlPassword ='';
$mysqlHostName ='dbxxx.hosting-data.io';
$mysqlExportPath ='export.sql';

//Veuillez ne pas modifier les points suivants
//Exportation de la base de données et résultat
$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;
exec($command,$output,$worked);
switch($worked){
case 0:
echo 'La base de données <b>' .$mysqlDatabaseName .'</b> a été stockée avec succès dans le chemin suivant '.getcwd().'/' .$mysqlExportPath .'</b>';
break;
case 1:
echo 'Une erreur s est produite lors de la exportation de <b>' .$mysqlDatabaseName .'</b> vers'.getcwd().'/' .$mysqlExportPath .'</b>';
break;
case 2:
echo 'Une erreur d exportation s est produite, veuillez vérifier les informations suivantes : <br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
break;
}
?>

*/

$serveur          = "localhost";
$utilisateur      = "root";
$motDePasse       = "";
$base             = "abda"; 
$dir_backup       = getenv('DOCUMENT_ROOT')."/DB_Backup";
MYSQLi_CONNECT($serveur, $utilisateur, $motDePasse) or die ( "<h1>Serveur MySQL non disponible</h1>");
//MYSQLi_SELECT_DB($base) or die ( "<h1>Base non disponible</h1>");
// Génération du fichier de sauvegarde dans le répertoire $dir_backup
  system(sprintf(
    'mysqldump --opt -h%s -u%s -p"%s" %s | gzip > %s/SauveBD_'.date("d_n_Y_H_i_s").'.sql.gz',
    $serveur,
    $utilisateur,
    $motDePasse,
    $base,
    $dir_backup
  ));
$NbJours = 7;
// Suppression des vieux fichiers de sauvegarde 
   $folder = new DirectoryIterator($dir_backup);
    foreach($folder as $file){ 
       if( ($file->isFile()) && (!$file->isDot()) ) {
          if (time() - $file->getMTime() > $NbJours*24*3600) unlink($file->getPathname());   
       }
    }
?>