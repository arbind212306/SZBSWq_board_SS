

$(document).ready(function () {
      
    //Disable mouse right click
    $("html").on("contextmenu",function(e){
        return false;
    });
    $("body").on("contextmenu",function(e){
        return false;
    });

     $('html').bind('cut copy paste', function (e) {
        e.preventDefault();
    }); 

     $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    }); 
});