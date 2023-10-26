<fieldset style="margin-top: 10px;"><legend>Selectionnez!!!!</legend> 
    <div class="choixg"> 
        <div class="optiong">
            <a href="versement.php?client=<?='decaissement client';?>&frais">
            <div class="descript_optiong">Versement</div></a>
        </div><?php 
        if ($_SESSION['level']>7) {?>

            <div class="optiong">
                <a href="chequeespeces.php?cheques">
                <div class="descript_optiong">Cheque/Espèces</div></a>
            </div>

            <div class="optiong">
                <a href="recette.php?recette">
                <div class="descript_optiong">Recette</div></a>
            </div> 

            <div class="optiong">
                <a href="editionfacture.php?recette">
                <div class="descript_optiong">Saisir Facture</div></a>
            </div><?php 
        }?>

        <div class="optiong">
            <a href="editionfacturefournisseur.php?recette">
            <div class="descript_optiong">Saisir Fact Fournisseur</div></a>
        </div>      
       
    </div>

</fieldset>