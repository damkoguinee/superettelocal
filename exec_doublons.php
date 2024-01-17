<?php
require 'header.php'; 

$prodm = $DB->query("SELECT *
FROM productslist
WHERE designation IN (
    SELECT designation
    FROM productslist
    GROUP BY designation
    HAVING COUNT(*) > 1
)");

if(isset($_GET["delete"])){

    $numero=$_GET["delete"];

    $DB->delete('DELETE FROM productslist WHERE id = ?', array($numero));
    $DB->delete('DELETE FROM stock1 WHERE idprod = ?', array($numero));
}?>

   
              
<table class="payement">
    <thead>
        <form action="ajout.php" method="POST">

        <tr>
            <th height="25" colspan="5" style="text-align: center">liste des produits dont la designation est identique </th>
        </tr>

        <tr>
            <th>N°</th>
            <th>Code</th>
            <th>Désignation</th>
            <th>Code Barre</th>
            <th style="width:10%;">P. Vente</th>
        </tr>
        </form>

    </thead>

    <tbody><?php

        if (empty($prodm)) {
        # code...
        }else{
        foreach ($prodm as $key=> $formation) {
            $verif=$DB->querys("SELECT id FROM stockmouv where idstock='{$formation->id}' ");?>

            <tr>
            <form action="ajout.php" method="POST">

                <td style="text-align: center;"><?=$key+1;?></td>
                <td style="text-align: left"><?= ucwords(strtolower($formation->Marque)); ?></td>

                <td style="text-align: left; width: 35%;"><?= ucwords(strtolower($formation->designation)); ?></td>

                <td style="text-align: left;"><?= $formation->codeb; ?></td>            

                <td><?=number_format($formation->pventel,0,',',' '); ?></td>
            </form>

            </tr><?php
        }

        }?>          
    </tbody>

    
</table>
</body>

</html>
