<fieldset style="margin-top: 10px;"><legend>Compatabilité</legend>

      <div class="choixg" style="display: flex; flex-wrap: wrap;">

        <div class="optiong">
          <a href="comptasemaine.php?semaine=<?='semaine';?>">
          <div class="descript_optiong" style="height: 40px;">Ventes</div></a>
        </div>       

        <div class="optiong">
          <a href="facturations.php">
          <div class="descript_optiong" style="height: 40px;">Facturations</div></a>
        </div>

        <div class="optiong">
          <a href="produitvendus.php?produit">
          <div class="descript_optiong" style="height: 40px;">Produits Vendus</div></a>
        </div><?php

      if ($_SESSION['level']>6) {?>
        <div class="optiong">
          <a href="relevebancaire.php">
          <div class="descript_optiong" style="height: 40px;">Relevé Compte</div></a>
        </div> 
        
        <div class="optiong">
          <a href="inventairegeneral.php?invent">
          <div class="descript_optiong" style="height: 40px;">Solde</div></a>
        </div>

        <div class="optiong">
          <a href="deletevente.php?promo">
          <div class="descript_optiong" style="height: 40px;">Historique Sup</div></a>
        </div>

        

        <?php

      if ($_SESSION['level']>7) {?>
        <div class="optiong">
          <a href="proformatliste.php">
          <div class="descript_optiong" style="height: 40px;">Proformat</div></a>
        </div>

        <div class="optiong">
          <a href="cheque.php?cheque">
          <div class="descript_optiong" style="height: 40px;">Chèque</div></a>
        </div>        

        <div class="optiong">
          <a href="gaindevise.php">
          <div class="descript_optiong" style="height: 40px;">Variation Dévise</div></a>
        </div>

        <div class="optiong">
          <a href="listepromotion.php?promo">
          <div class="descript_optiong" style="height: 40px;">Produits Offerts</div></a>
        </div> 

        <?php
      }
      }?>

      <div class="optiong">
        <a href="retourproduitclient.php?transfert">
        <div class="descript_optiong" style="height: 35px;">Retour Client</div></a>
      </div>

      <div><a href="synthesemini_pdf.php?date1=<?=$_SESSION['date1'];?>&date2=<?=$_SESSION['date2'];?>&datenormale=<?=$datenormale;?>" target="_blank" onclick="return alerteV();"><img  style=" margin-left: 20px; height: 50px; width: 50px;" src="css/img/pdf.jpg"></a>
          </div>
          
      </div>
    </fieldset>       