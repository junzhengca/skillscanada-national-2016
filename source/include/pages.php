<?php
  //Functions for pages

  //Create a new page in database
  function createPage($dbConnection,$title,$description,$keyword,$content){
    $stmt = $dbConnection->mysqliObj->prepare("INSERT INTO pages (name,content,meta_description,meta_keywords) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$title,$content,$description,$keyword);
    if($stmt->execute()){
      return true;
    } else {
      return false;
    }
  }

  //Get all pages in database
  function getAllPages($dbConnection){
    $stmt = $dbConnection->mysqliObj->prepare("SELECT * FROM pages");
    $stmt->execute();
    $stmt->bind_result($resultTitle,$resultContent,$resultDescription,$resultKeyword);
    $result = array();
    while($stmt->fetch()){
      array_push($result,array(
        "title"=>$resultTitle,
        "content"=>$resultContent,
        "description"=>$resultDescription,
        "keyword"=>$resultKeyword
      ));
    }
    return $result;
  }

  //Update a page in database
  function updatePage($dbConnection,$oldTitle,$newTitle,$newDescription,$newKeyword,$newContent){
    $stmt = $dbConnection->mysqliObj->prepare("UPDATE pages SET name=?, content=?, meta_description=?, meta_keywords=? WHERE name=?");
    $stmt->bind_param("sssss",$newTitle,$newContent,$newDescription,$newKeyword,$oldTitle);
    if($stmt->execute()){
      return true;
    } else {
      return false;
    }
  }

  //Delete a page from database
  function deletePage($dbConnection,$title){
    $stmt = $dbConnection->mysqliObj->prepare("DELETE FROM pages WHERE name=?");
    $stmt->bind_param("s",$title);
    if($stmt->execute()){
      return true;
    } else {
      return false;
    }
  }

  //Get one page from database
  function getPage($dbConnnection,$title){
    $stmt = $dbConnnection->mysqliObj->prepare("SELECT * FROM pages WHERE name=?");
    $stmt->bind_param("s",$title);
    if($stmt->execute()){
      $stmt->store_result();
      $stmt->bind_result($resultTitle,$resultContent,$resultDescription,$resultKeyword);
      if($stmt->num_rows == 0){
        return false;
      } else {
        $stmt->fetch();
        return array(
          "title"=>$resultTitle,
          "content"=>$resultContent,
          "description"=>$resultDescription,
          "keyword"=>$resultKeyword
        );
      }
    } else {
      return false;
    }
  }
?>
