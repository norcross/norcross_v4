jQuery(document).ready(function($) {

//********************************************************
// star rating calculation
//********************************************************

    $('div.plugin_details').each(function() {

        var path    = $('div.plugin_details').find('input#theme-root').val();
        var score   = $('div.plugin_details').find('input#rating-value').val();

        $('#plugin-rating').raty({
            half        : true,
            precision   : true,
            readOnly    : true,
            space       : false,
            score       : score,
            path        : path + '/lib/img',
            starOn      : 'star-on.png',
            starOff     : 'star-off.png',
            starHalf    : 'star-half.png',
            round       : {
                down: 0.25,
                full: 0.6,
                up: 0.9
            }
        });
    });

//********************************************************
// what, you're still here? It's over. Go home.
//********************************************************


});