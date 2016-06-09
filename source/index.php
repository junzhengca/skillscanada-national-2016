<?php
  //Dependencies
  include "include/config.php";
  include "include/static_content_loader.php";
  include "include/database.php";
  include "include/pages.php";
  include "include/nav.php";

  $dbConnection = new DatabaseConnection($database); //Connect to database
  $staticContentLoader = new StaticContentLoader($staticContents); //Create a new static content instance

  //Detect current page
  if(empty($_GET["p"])){
    $page = "index";
  } else {
    $page = $_GET["p"];
  }
  $pageData = getPage($dbConnection,$page);
  if(!$pageData){ //Page not found
    http_response_code(404);
    $pageData = getPage($dbConnection,"404");
  }
  $navData = getAllNavs($dbConnection);
?>

<!doctype html>
<html>
  <head>
    <?php $staticContentLoader->out(); ?>
    <meta name="description" value="<?php echo $pageData["description"]; ?>">
    <meta name="keywords" value="<?php echo $pageData["keyword"]; ?>">
    <meta charset="utf-8">
    <title><?php echo $pageData["title"]; ?> - New Brunswick Tourism</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <?php
      //Load header template
      include "template/global/header.php";

      //Load main content
      include "template/global/content.php";

      //Load footer template
      include "template/global/footer.php";
    ?>
  </body>
</html>
