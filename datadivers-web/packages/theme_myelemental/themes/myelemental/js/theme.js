$(function() {  
  $('#navmenu').superfish({
        delay: 300,
        speed: 'normal'
  });
  
  $("<select id='mobile-nav' class='form-control'/>").appendTo("nav");
  // Create default option "Go to..."
  $("<option />", {
      "selected": "selected",
      "value"   : "",
      "text"    : "Go to..."
  }).appendTo("#nav-menu select");
  // Populate dropdown with menu items
  $("nav a").each(function() {
  var el = $(this);
  $("<option />", {
     "value"   : el.attr("href"),
     "text"    : el.text()
    }).appendTo("nav select");
  });
  // To make dropdown actually work
    $("nav select").change(function() {
       window.location = $(this).find("option:selected").val();
    }); 

});

