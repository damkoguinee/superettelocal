<?php
require 'header.php';

$prodm=$DB->query("SELECT *from productslist ");

foreach ($prodm as $key=> $formation) {
    $verif=$DB->querys("SELECT id FROM stockmouv where idstock='{$formation->id}' ");

    $verifstock=$DB->querys("SELECT quantite FROM stock1 where idprod='{$formation->id}' ");
    
    if (empty($verif['id'])) {

        if (empty($verifstock['quantite'])) {

            $DB->delete('DELETE FROM productslist WHERE id = ?', array($formation->id));
            $DB->delete('DELETE FROM stock1 WHERE idprod = ?', array($formation->id));
        }
    }
}