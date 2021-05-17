/* globals Chart:false, feather:false */


$(document).ready(function(){
    $( ".left-toggle-large" ).click(function() {
        var obj = 'hide-menu-large';

        if($('body').hasClass(obj)) {
            $('body').removeClass(obj);
        } else {
            $('body').addClass(obj);
        }
    });
    
    $( ".left-toggle-small" ).click(function() {
        var obj = 'show-menu-small';

        if($('body').hasClass(obj)) {
            $('body').removeClass(obj);
        } else {
            $('body').addClass(obj);
        }
    });
    
    $( ".right-toggle" ).click(function() {
        var obj = 'show';

        if($('.right-nav').hasClass(obj)) {
            $('.right-nav').removeClass(obj);
        } else {
            $('.right-nav').addClass(obj);
        }
    });
});
