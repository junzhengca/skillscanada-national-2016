//Event binding for document load
$(function(){

  //Event binding for back to top button
  $("#back-top").click(function(){
    $("html, body").animate({scrollTop:0},800);
  });

  //Event binding for search button on top
  $("#search-button").click(function(){
    toggleSearchBox();
  });

  //Event binding for full screen mask when search bar is shown
  $("#fullscreen-mask").click(function(){
    toggleSearchBox();
  });

  //Event binding for scroll down button
  $("#scroll-down-button").click(function(){
    $("document, body").animate({scrollTop:$(".page-header-container:first").height() + 325},800)
  });

  //Event binding for window scroll
  $(window).on('scroll',function(){
    parallax(); //Update parallax effect

    //Switch navbar style when scrolled over 300px
    if($(window).scrollTop() > 300){
      $("#main-nav-container").addClass("navbar-white");
      $("#logo-black").show();
      $("#logo-white").hide();
    } else {
      $("#main-nav-container").removeClass("navbar-white");
      $("#logo-black").hide();
      $("#logo-white").show();
    }

  });

  //Update parallax effect once
  parallax();
});


//Function for searchbox
var searchBoxStatus = false;
function toggleSearchBox(){
  if(!searchBoxStatus){
    $("#search-box").animate({'top':75},200);
    $("#fullscreen-mask").show();
  } else {
    $("#search-box").animate({'top':-100},200);
    $("#fullscreen-mask").hide();
  }
  searchBoxStatus = !searchBoxStatus;
}

//Parallax effect
function parallax(){
  $(".parallax-image").each(function(index){
    $(this).css({'top':($(window).scrollTop() - $(this).offset().top) / 3});
  });
}
