<fieldset style="margin-top: 10px;"><legend>Selectionnez le motif</legend> 
    <div class="choixg"> 
        
        <div class="optiong">
            <a href="bulletin.php?client">
            <div class="descript_optiong">Compte Clients</div></a>
        </div>
        <?php 

        if ($_SESSION['level']>6) {?>

            <div class="optiong">
                <a href="bulletin.php?fournisseurs">
                <div class="descript_optiong">Compte Fournisseurs</div></a>
            </div>

            <div class="optiong">
                <a href="bulletin.php?frais">
                <div class="descript_optiong">Compte Frais</div></a>
            </div> <?php 
        }?>

        <div class="optiong">
            <a href="bulletin.php?autres">
            <div class="descript_optiong">Compte Autres</div></a>
        </div>

        <div class="optiong">
            <a href="bulletin.php?personnel">
            <div class="descript_optiong">Compte Personnels</div></a>
        </div>

              
    </div>

</fieldset>