<?php
  //Dependencies
  include "../include/config.php";
  include "../include/database.php";
  include "../include/user.php";
  include "../include/pages.php";
  include "../include/nav.php";
  $dbConnection = new DatabaseConnection($database);
  $user = new User($dbConnection);

  //$user->create("competitor4","skills2016"); //The username and password, just in case you cannot login

  //Initialize result array
  $result = array(
    "status" => "failed"
  );


  if(!empty($_POST["action"])){
    //Login and create a token
    if($_POST["action"] == "login"){ //Authorization not needed
      $token = $user->authorize($_POST["username"],$_POST["password"]);
      if($token){
        $result["status"] = "success";
        $result["token"] = $token;
        setcookie("t",$token,time() + 60 * 60 * 24 * 7,"/");
      }
    //Create a new page
    } else if ($_POST["action"] == "create_page"){ //Need authorization
      if($user->loggedin()){
        if(createPage($dbConnection,htmlentities($_POST["title"]),$_POST["description"],$_POST["keywords"],$_POST["content"])){
          $result["status"] = "success";
        }
      }
    //Get a list of pages
    } else if ($_POST["action"] == "get_all_pages"){ //Authorization not needed
      $result["status"] = "success"; //This will never fail
      $result["data"] = getAllPages($dbConnection);
    //Update a page
    } else if ($_POST["action"] == "update_page"){ //Need authorization
      if($user->loggedin()){
        if(updatePage($dbConnection,$_POST["old_title"],$_POST["title"],$_POST["description"],$_POST["keywords"],$_POST["content"])){
          $result["status"] = "success";
        }
      }
    //Delete a page
    } else if ($_POST["action"] == "delete_page"){ //Need authorization
      if($user->loggedin()){
        if(deletePage($dbConnection,$_POST["title"])){
          $result["status"] = "success";
        }
      }
    //Create a navigation element
    } else if ($_POST["action"] == "create_nav"){
      if($user->loggedin()){
        if(createNav($dbConnection,$_POST["text"],$_POST["link"],$_POST["order"])){
          $result["status"] = "success";
        }
      }
    //Get all navigation element
    } else if ($_POST["action"] == "get_all_navs"){ //Authorization not needed
      $result["status"] = "success"; //This will never fail
      $result["data"] = getAllNavs($dbConnection);
    //Update a navigation element
    } else if ($_POST["action"] == "update_nav"){ //Need authorization
      if($user->loggedin()){
        if(updatenav($dbConnection,$_POST["old_text"],$_POST["text"],$_POST["link"],$_POST["order"])){
          $result["status"] = "success";
        }
      }
    //Delete a navigation element
    } else if ($_POST["action"] == "delete_nav"){ //Need authorization
      if($user->loggedin()){
        if(deletenav($dbConnection,$_POST["text"])){
          $result["status"] = "success";
        }
      }
    }
  }

  //Output api response
  echo json_encode($result,true);
?>
