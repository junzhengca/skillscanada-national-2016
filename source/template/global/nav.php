<nav class="navbar navbar-default" id="main-nav-container" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#"><img id="logo-white" class="logo" src="static/images/nbt-logo-white.png" /><img id="logo-black" class="logo" src="static/images/nbt-logo-black.png" /></a>
  </div>
  <div class="collapse navbar-collapse" id="main-nav">
    <ul class="nav navbar-nav" id="main-nav-inner">
      <?php foreach($navData as $nav){ //Output navigation ?>
        <li><a href="<?php echo $nav["link"]; ?>"><?php echo $nav["text"]; ?></a></li>
      <?php } ?>
      <li><a id="search-button"><span class="fa fa-search"></span></a></li>
    </ul>
  </div>
</nav>
