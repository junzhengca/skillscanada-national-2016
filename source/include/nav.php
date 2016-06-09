<?php
  //Functions for navigation elements

  //Create a new navigation element in the database
  function createNav($dbConnection,$text,$link,$order){
    $stmt = $dbConnection->mysqliObj->prepare("INSERT INTO navigation (display_text,display_order,link) VALUES (?,?,?)");
    $stmt->bind_param("sis",$text,$order,$link);
    if($stmt->execute()){
      return true;
    } else {
      return false;
    }
  }

  //Get all navigation elements from database
  function getAllNavs($dbConnection){
    $stmt = $dbConnection->mysqliObj->prepare("SELECT * FROM navigation ORDER BY display_order");
    $stmt->execute();
    $stmt->bind_result($resultText,$resultOrder,$resultLink);
    $result = array();
    while($stmt->fetch()){
      array_push($result,array(
        "text"=>$resultText,
        "order"=>$resultOrder,
        "link"=>$resultLink
      ));
    }
    return $result;
  }

  //Update a navigation element
  function updateNav($dbConnection,$oldText,$newText,$newLink,$newOrder){
    $stmt = $dbConnection->mysqliObj->prepare("UPDATE navigation SET display_text=?, display_order=?, link=? WHERE display_text=?");
    $stmt->bind_param("siss",$newText,$newOrder,$newLink,$oldText);
    if($stmt->execute()){
      return true;
    } else {
      return false;
    }
  }

  //Delete a navigation element
  function deleteNav($dbConnection,$text){
    $stmt = $dbConnection->mysqliObj->prepare("DELETE FROM navigation WHERE display_text=?");
    $stmt->bind_param("s",$text);
    if($stmt->execute()){
      return true;
    } else {
      return false;
    }
  }
?>
