jQuery(document).ready(function($) {

//********************************************************
// process the MailChimp signup
//********************************************************

    $('div#music-signup-form input#music-subscribe').click(function(event) {

        var email  = $('div#music-signup-form input#music-email').prop('value');

        var data = {
            action: 'music_signup',
            email: email,
            nonce:  rkvAJAX.nonce
        };

        jQuery.post(rkvAJAX.ajaxurl, data, function(response) {
            var obj;
            try {
                obj = jQuery.parseJSON(response);
            }
            catch(e) {  // bad JSON catch
                console.log('bad JSON');
                // add some error messaging ?
                }

            if(obj.success === true) { // it worked. AS IT SHOULD.
                $('div#music-signup-form input#music-email').val('');
                $('span#music-msg').delay(400).replaceWith('<div class="alert alert-success music-clear centered-text"><p>' + obj.message +'</p></div>');
                $('span#music-list').delay(400).replaceWith(obj.display);
            }
            
            else if(obj.success === false && obj.errcode == 'EMAIL_EXISTS') { // check for existing email
                $('div#music-signup-form input#music-email').val('');
                $('span#music-msg').delay(400).replaceWith('<div class="alert alert-error music-clear centered-text"><p>' + obj.message +'</p></div>');
                $('span#music-list').delay(400).replaceWith(obj.display);
            }
            else {  // something else went wrong
                $('span#music-msg').delay(400).replaceWith('<div class="alert alert-error music-clear centered-text"><p>' + obj.message +'</p></div>');
            }
        });

    });


//********************************************************
// what, you're still here? It's over. Go home.
//********************************************************


});