<?php
  //User object
  class User {
    public $dbConnection;
    public $clientIdentifier;
    function User($dbConnection){
      $this->dbConnection = $dbConnection;
      $this->readIdentifier();
    }

    //Read client identifier, if identifier does not exist, create one
    function readIdentifier(){
      if(!empty($_COOKIE["i"])){
        $this->clientIdentifier = $_COOKIE["i"];
      } else {
        setcookie("i",hash('sha512',time() . rand(0,100)),time() + 60 * 60 * 60 * 100,"/");
      }
    }

    //Salt the password
    function saltPassword($password,$salt){
      return hash('sha512',$password . $salt);
    }

    //Create a new user
    function create($username,$password){
      $stmt = $this->dbConnection->mysqliObj->prepare("INSERT INTO users (username,password,salt) VALUES (?,?,?)");
      $salt = hash('sha512',time() . rand(0,100));
      $password = $this->saltPassword($password,$salt);
      $stmt->bind_param("sss",$username,$password,$salt); //For most part, this is secure enough
      if($stmt->execute()){
        return true;
      } else {
        return false;
      }
    }

    //Check if user is currently loggedin
    function loggedin(){
      $stmt = $this->dbConnection->mysqliObj->prepare("SELECT * FROM auth_tokens WHERE token_body=?");
      $stmt->bind_param("s",$_COOKIE["t"]);
      $stmt->execute();
      $stmt->store_result();
      if($stmt->num_rows == 0){
        return false;
      } else {
        $stmt->bind_result($resultId,$resultUserId,$resultTokenBody,$resultClientIdentifier,$resultExpireTime);
        $stmt->fetch();
        if($resultClientIdentifier == $this->clientIdentifier && $resultExpireTime > time()){
          return true;
        } else {
          return false;
        }
      }
    }

    //Authorize a user using username and password
    function authorize($username,$password){
      $stmt = $this->dbConnection->mysqliObj->prepare("SELECT * FROM users WHERE username=?");
      $stmt->bind_param("s",$username);
      $stmt->execute();
      $stmt->store_result();
      if($stmt->num_rows == 0){
        return false;
      } else {
        $stmt->bind_result($resultId,$resultUsername,$resultPassword,$resultSalt);
        $stmt->fetch();
        if($this->saltPassword($password,$resultSalt) == $resultPassword){
          $stmt = $this->dbConnection->mysqliObj->prepare("INSERT INTO auth_tokens (user_id,token_body,client_identifier,expire_time) VALUES (?,?,?,?)");
          $token = hash('sha512',(time() + rand(0,100)) . rand(0,100)); //Generate a random token_body
          $expire = time() + 60*60*24*7; //7 days until expire
          $stmt->bind_param("issi",$resultId,$token,$this->clientIdentifier,$expire);
          if($stmt->execute()){
            return $token;
          } else {
            return false;
          }
        } else {
          return false;
        }
      }
    }

  }
?>
