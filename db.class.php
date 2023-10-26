<?php

class DB {
  private $host    = 'localhost';  // nom de l'host 
  private $name    = 'superettetaneneh';// connexion mag
  private $user    = 'root';       // utilisateur 
  private $pass    = '';       // mot de passe (il faudra peut-être mettre '' sous Windows)
  private $db;
  
  function __construct($host = null, $name = null, $name1 = null, $name2 = null, $name3 = null, $user = null, $pass = null){
    if($host != null){
      $this->host = $host;           
      $this->name = $name;         
      $this->user = $user;          
      $this->pass = $pass;
    }
    try{      
      
        $this->connexion = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->name,
          $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES UTF8', 
          PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        
        
    }catch (PDOException $e){
      echo 'Erreur : Impossible de se connecter  à la BDD !';
      die();
    }
  }

  public function querysI($sql, $data = array()){
    $req = $this->connexion->prepare($sql);
    $req->execute($data);
    return $req->fetch();
  }

  public function queryI($sql, $data = array()){
      $req = $this->connexion->prepare($sql);
      $req->execute($data);
      return $req->fetchAll(PDO::FETCH_OBJ);
  }

  public function deleteI($sql, $data = array()){
    $req = $this->connexion->prepare($sql);
    $req->execute($data);
  }

  public function insertI($sql, $data = array()){
    $req = $this->connexion->prepare($sql);
    $req->execute($data);
  }

  public function query($sql, $data = array()){
    $req = $this->connexion->prepare($sql);

    $req->execute($data);

    return $req->fetchAll(PDO::FETCH_OBJ);
  }

  public function querys($sql, $data = array()){

    $req = $this->connexion->prepare($sql);

    $req->execute($data);
    return $req->fetch();
  }
   
  public function delete($sql, $data = array()){
    $req = $this->connexion->prepare($sql);

    $req->execute($data);
  }

  public function insert($sql, $data = array()){
    $req = $this->connexion->prepare($sql);

    $req->execute($data);
  }
  
}?>
