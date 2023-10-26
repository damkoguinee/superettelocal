<fieldset style="margin-bottom: 30px; margin-top: 20px;"><legend style="font-size: 20px; font-weight: bold; margin-bottom: 20px; ">Alerte sur les dates de Péremption dans le Magasin 

  <form action="dateperemtion.php" method="POST">

    <select  name="magasin" onchange="this.form.submit()"><?php

      if (isset($_POST['magasin']) and $_POST['magasin']=='general') {?>

        <option value="<?=$_POST['magasin'];?>">Général</option><?php
        
      }elseif (isset($_POST['magasin'])) {?>

        <option value="<?=$_POST['magasin'];?>"><?=$panier->nomStock($_POST['magasin'])[0];?></option><?php
        
      }else{?>

        <option value="<?=$_SESSION['lieuventealerte'];?>"><?=$panier->nomStock($_SESSION['lieuventealerte'])[0];?></option><?php

      }

      if ($_SESSION['level']>6) {

        foreach($panier->listeStock() as $product){?>

          <option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

        }
      }?>
    </select>

  </form></legend><?php

  $now0 = date('Y-m-d');
  $now1 = new DateTime( $now0);
  $now = $now1->format('Ym');

  $nowm=$now1->format('Y');//pour recuperer juste le mois 

  if ($nowm==11) {
    $nowl1=(date('Y')+1).'01';
  }elseif ($nowm==12) {
    $nowl1=(date('Y')+1).'02';
  }else{
    $nowl1=($now+2);
  }


  if ($nowm==7) {
    $nowl2=(date('Y')+1).'01';
  }elseif ($nowm==8) {
    $nowl2=(date('Y')+1).'02';
  }elseif ($nowm==9) {
    $nowl2=(date('Y')+1).'03';
  }elseif ($nowm==10) {
    $nowl2=(date('Y')+1).'04';
  }elseif ($nowm==11) {
    $nowl2=(date('Y')+1).'05';
  }elseif ($nowm==12) {
    $nowl2=(date('Y')+1).'06';
  }else{
    $nowl2=($now+6);
  }
  $prodperime= $DB->querys("SELECT count(id)as nbre FROM `".$nomtab."` where DATE_FORMAT(dateperemtion, \"%Y%m\") <= :annee and quantite>0", array('annee' => ($now)
    ));

  $prodcritique= $DB->querys("SELECT count(id)as nbre FROM `".$nomtab."` where DATE_FORMAT(dateperemtion, \"%Y%m\") > :auj and DATE_FORMAT(dateperemtion, \"%Y%m\")<=:apres and quantite>0", array('auj' => ($now), 'apres' => ($nowl1)
    ));

  $prodorange= $DB->querys("SELECT count(id)as nbre FROM `".$nomtab."` where DATE_FORMAT(dateperemtion, \"%Y%m\") > :auj and DATE_FORMAT(dateperemtion, \"%Y%m\")<=:apres and quantite>0", array('auj' => ($nowl1), 'apres'=>($nowl2)
    ));

  $prodvert= $DB->querys("SELECT count(id)as nbre FROM `".$nomtab."` where DATE_FORMAT(dateperemtion, \"%Y%m\") >= :annee and quantite>0", array('annee' => ($nowl2)
    ));


    ?>

    <a href="dateperemtion.php?produit=<?='maroon';?>&perime"><input name = "s" style="width: 23%;height: 40px; font-size: 20px; background-color: maroon;color: white; cursor: pointer;"  type="submit" value="<?=$prodperime['nbre'].' Perimé(s)';?>"></a>

    <a href="dateperemtion.php?produit=<?='red';?>&critique"><input name = "s" style="width: 23%;height: 40px; font-size: 20px; background-color: red;color: white; cursor: pointer;"  type="submit" value="<?=$prodcritique['nbre'].' (-2 mois)';?>"></a>

    <a href="dateperemtion.php?produit=<?='orange';?>&orange"><input name = "s" style="width: 23%;height: 40px; font-size: 20px; background-color: orange;color: white; cursor: pointer; "  type="submit" value="<?=$prodorange['nbre'].' (-6 mois)';?>"></a>

    <a href="dateperemtion.php?produit=<?='green';?>&vert"><input name = "s" style="width: 23%;height: 40px; font-size: 20px; background-color: green;color: white; cursor: pointer; margin-bottom: 20px; "  type="submit" value="<?=$prodvert['nbre'].' (+6 mois)';?>"></a>

    <a href="dateperemtion.php?perte"><input name = "s" style="width: 23%;height: 40px; font-size: 25px; background-color: green;color: white; cursor: pointer; margin-bottom: 20px; "  type="submit" value="Pertes"></a>

    <a href="pertes.php?ajoutpertes&nomstock=1"><input name = "s" style="width: 23%;height: 40px; font-size: 25px; background-color: red;color: white; cursor: pointer; margin-bottom: 20px; "  type="submit" value="Retrait Produit"></a>
</fieldset>