<?php
  //Dependencies
  include "../include/config.php";
  include "../include/database.php";
  include "../include/user.php";
  $dbConnection = new DatabaseConnection($database);
  $user = new User($dbConnection);

  //Login status is actually not needed here, because there is no way to access API without proper authentication
  //But for ease of use reasons, it is here
  if($user->loggedin()){
    if(empty($_GET["p"])){
      $page = "index";
    } else {
      $page = $_GET["p"];
    }
  } else {
    http_response_code(500);
    $page = "500";
  }


  $pagePath = "pages/$page.php";
?>
<!doctype html>
<html>
  <head>
    <script src="../static\lib\jquery-2.2.4.js"></script>
    <link href="../static\lib\font-awesome-4.6.3\css\font-awesome.min.css" type="text/css" rel="stylesheet" />
    <link href="../static\lib\bootstrap-3.3.6-dist\css\bootstrap.min.css" type="text/css" rel="stylesheet" />
    <script src="../static\lib\bootstrap-3.3.6-dist\js\bootstrap.min.js"></script>
    <meta charset="utf-8">
    <title>Admin - NBT</title>
  </head>

  <body>
    <?php
      include "parts/header.php";
      include $pagePath;
    ?>
  </body>
</html>
