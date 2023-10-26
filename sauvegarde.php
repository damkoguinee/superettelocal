<?php
$now = time();
$fichier = fopen('date.txt', 'a+');
$time1 = fgets($fichier);
$n = $now - intval($time1);
var_dump($now - intval($time1));
//if((intval($time1)-$now)>= 10) {
if ($n > 1800) {


    system("mysqldump -u root  change > C:/wamp/www/dump/sakila.sql", $retour);
    echo "<br/> Debut de la sauvgarde MySQL";
    $A = new ZipArchive();
    $A->open("./archive.zip");
    $A->addFile("./sakila.sql", date("Ymdhis") . ".sql");

    $A->close();
    if (ftruncate($fichier, 0) === true) {
        if (fwrite($fichier, $now)) {
            if (fclose($fichier)) {

            }
        }
    }
}


function deleteOldFile($nDuration = 15552000)
{
    $A = new ZipArchive();
    $A->open("archive.zip");


    // liste les fichiers présents dans le répertoire
    foreach (glob("archive.zip") as $file) {
        echo $file;
        //if ( filemtime($file) <=  (time() - $this->nFileDuration)  && file_exists($file))
        if (filemtime($file) <= (time() - $nDuration) && file_exists($file))
            unlink($file);// supprime les vieux fichiers
    }


}

deleteOldFile();

?>