<?php
  //Used to manage static contents such as css and js files
  class StaticContentLoader{
    public $contents;
    function StaticContentLoader($contents){
      $this->contents = $contents;
    }

    //Output html code for static contents
    public function out(){
      foreach($this->contents["css"] as $css){
        echo "<link href='$css' type='text/css' rel='stylesheet' />";
      }
      foreach($this->contents["js"] as $js){
        echo "<script src='$js' type='text/javascript'></script>";
      }
    }
  }
?>
