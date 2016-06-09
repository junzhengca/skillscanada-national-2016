<?php
  //Database connection object
  class DatabaseConnection {
    public $mysqliObj;
    function DatabaseConnection($config){
      $this->mysqliObj = new MySQLi($config["host"],$config["username"],$config["password"],$config["name"]);
      if($this->mysqliObj->error){
        echo "database connection failed";
        exit;
      }
    }
  }
?>
