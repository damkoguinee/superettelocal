<?php
require 'header.php';

if(isset($_POST['cbarre']) and $_POST['cbarre']!='') {
  //header("Location: ex128.php");
  if (strlen($_POST['cbarre'])==1) {

    $codebarre='000'.ucwords($_POST['cbarre']);

  }else{

    $codebarre=$_POST['cbarre'];
  }
  $DB->insert('UPDATE products SET codeb= ? WHERE id = ?', array($codebarre,$_POST['id']));

  require('cbarre/ex.php');
  unset($_SESSION['designation']);
  //header("Location: update.php");
}