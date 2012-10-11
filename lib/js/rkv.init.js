//********************************************************
// function for calculating heights
//********************************************************

function sidebarScroll() {
	var offset = jQuery('div.wide-sidebar').offset();
	var topPadding = 65;

	jQuery(window).scroll(function() {
		if (jQuery(window).scrollTop() > offset.top) {
			jQuery('div.wide-sidebar').stop().animate({
				marginTop: jQuery(window).scrollTop() - offset.top + topPadding
			}, 500);
		} else {
			jQuery('div.wide-sidebar').stop().animate({
				marginTop: 0
			});
		}
	});
}

//********************************************************
// function for calculating heights
//********************************************************

function equalHeight(group) {
    var tallest = 0;
    group.each(function() {
        var thisHeight = jQuery(this).height();
        if(thisHeight > tallest) {
            tallest = thisHeight;
        }
    });
    group.height(tallest);
}

//********************************************************
// now start the engine
//********************************************************

jQuery(document).ready( function($) {

//********************************************************
// expand search on blur
//********************************************************

	$('li.search-nav input.search-query').focus(function () {
		$(this).animate({ width: '280px' }, 300);
	}).blur(function() {
		$(this).animate({ width: '156px' }, 300);
	});

//********************************************************
// set equal height where appropriate
//********************************************************

	$('div.container').each(function() {

		var load_width  = $(window).width();
		
		if (load_width > 600) {
			equalHeight($('p.home-info'));
			equalHeight($('div.plugin-single h3'));
			equalHeight($('div.plugin-text'));
			equalHeight($('div.snippet-title-area'));
		}

		$(window).resize(function() {
			var new_width  = $(window).width();
			console.log(new_width);
			if (new_width > 600) {
				equalHeight($('p.home-info'));
				equalHeight($('div.plugin-single h3'));
				equalHeight($('div.plugin-text'));
				equalHeight($('div.snippet-block .post-title-area'));
			}

		});
	});

//********************************************************
// show or hide my up arrow
//********************************************************

	var basetop	= $('div.navbar-fixed-top');
	var fromtop	= basetop.offset();
	var adjstop = fromtop.top;

	if (adjstop > 0)
		$('p.footer-text').find('span.jump-top').show();
		
	if (adjstop === 0)
		$('p.footer-text').find('span.jump-top').hide();

	$(window).scroll(function() {
		var basetop	= $('div.navbar-fixed-top');
		var fromtop	= basetop.offset();
		var adjstop = fromtop.top;

		if (adjstop > 0)
			$('p.footer-text').find('span.jump-top').fadeIn('slow');
		
		if (adjstop === 0)
			$('p.footer-text').find('span.jump-top').fadeOut('slow');
	});

//********************************************************
// scroll my sidebar
//********************************************************
/*
	$('div.slide-sidebar').each(function() {

		var load_width  = $(window).width();
		
		if (load_width > 1000) {
			$('div.slide-sidebar').addClass('wide-sidebar');
			sidebarScroll($('div.wide-sidebar'));
		}

		$(window).resize(function() {
			var new_width  = $(window).width();
			console.log(new_width);
			if (new_width > 1000) {
				$('div.slide-sidebar').addClass('wide-sidebar');
				sidebarScroll($('wide-sidebar'));
			}
			if (new_width < 1000) {
				$('div.slide-sidebar').removeClass('wide-sidebar');
			}

		});
	});
*/
/*
	$('p.post-details').each(function() {
		$(this).find('span.detail-comment').hover(
			function () {
				$(this).find('.icon').removeClass('icon-comment');
				$(this).find('.icon').addClass('icon-comments');
			},
			function () {
				$(this).find('.icon').removeClass('icon-comments');
				$(this).find('.icon').addClass('icon-comment');
			}
		);
	});
*/
//********************************************************
// icon some shit
//********************************************************

	$('div#sidebar').each(function() {
		$(this).find('div.widget_recent_entries h4').prepend('<i class="icon icon-edit pull-right"></i> ');
		$(this).find('div.recent_jam h4').prepend('<i class="icon icon-music pull-right"></i> ');

		$(this).find('div.recent_jam').find('div.jam-medallion').addClass('thumbnail');
		
	});

//********************************************************
// fade in instagram and load colorbox
//********************************************************
    $('body.instagram').each(function() {
        $(this).find('div.navbar-fixed-top').addClass('navbar-inverse');
        $(this).find('div.navbar-fixed-bottom').addClass('navbar-inverse');
    });


	$('img.instagram-pic').each(function(index) {
		$(this).delay(400 * index).fadeIn(400);
	});

    $('div.instagram-photo').each(function() {
        $(this).find('a.instagram-link').colorbox({
            rel:'instagram-gallery',
			transition:'fade',
			maxWidth:'95%',
            maxHeight:'95%'
        });
    });

//********************************************************
// add class to 4th block in archives
//********************************************************

	$('div.plugin-single:nth-child(3n-2)').addClass('plugin-clear');
	$('div.speaking-block:nth-child(3n-2)').addClass('speaking-reset');
	$('.snippet-block:nth-child(3n-2)').addClass('snippet-reset');

//********************************************************
// show / hide plugin data
//********************************************************

    $('div.plugin-detail-block div.plugin-detail-data').not(':first').hide();
    // show or hide plugin data blocks
    $('div.plugin-detail-nav a.btn').click(function() {
        var name = $(this).attr('id');
		$('div.plugin-detail-block').find('div.plugin-detail-data[rel="' + name + '"]').fadeIn(500);
		$('div.plugin-detail-block').find('div.plugin-detail-data').not('[rel="' + name + '"]').hide();
    });

//********************************************************
// set up panels for screenshots
//********************************************************

//	$('div.screenshots-data ol li:nth-child(4n)').addClass('screen-clear');

	$('div.screenshots-data ol li img').each(function() {
		var image = $(this).attr('src');
		$(this).attr('rel', 'screenshot-image');
		$(this).wrap('<a href="' + image + '" class="screenshot-image" />');
	});

	$('div.screenshots-data ol li p').each(function() {
		var text = $(this).text();
		var link = $(this).prev('a');
		$(link).attr('title', text);
	});

	$('div.screenshots-data ol').addClass('row-fluid');
	$('div.screenshots-data ol li a').addClass('span5');
	$('div.screenshots-data ol li p').addClass('span5');

//********************************************************
// colorbox for screenshots
//********************************************************
	$('div.screenshots-data ol li').each(function() {
		$(this).find('a.screenshot-image').colorbox({
			rel:'screenshot-image',
			transition:'fade',
			maxWidth:'95%',
            maxHeight:'95%'
		});
	});

//********************************************************
// ajax pagination
//********************************************************

    $('.wp-prev-next a').live('click', function(e){
        e.preventDefault();
        var link = $(this).attr('href');
        $('#content-block').fadeOut(500).load(link + ' #content-inner', function(){
            $('#content-block').fadeIn(200);
        });
        /*
        $('html, body').animate({
            scrollTop: $('.blog-wrapper').offset().top - 200
        }, 500);
*/
    });

//********************************************************
// jump to top from footer
//********************************************************

    $('span.jump-top').click(function() {
         $('html, body').animate({scrollTop:0}, 800);
	});


//********************************************************
// general and comment styling
//********************************************************
	
	$('ol.commentlist a.comment-reply-link').each(function() {
		$(this).addClass('btn btn-primary btn-mini');
		return true;
	});
	
	$('#cancel-comment-reply-link').each(function() {
		$(this).addClass('btn btn-danger btn-mini');
		return true;
	});

	$('li.comment div.comment-text p code').each(function() {
		$(this).wrap('<pre class="markup">');
		$(this).find('br').remove();
		return true;
	});
	
	$('article.post').hover(function(){
		$('a.edit-post').show();
	},function(){
		$('a.edit-post').hide();
	});
/*
	// Input placeholder text fix for IE
	$('[placeholder]').focus(function() {
		var input = $(this);
			if (input.val() == input.attr('placeholder')) {
				input.val('');
				input.removeClass('placeholder');
			}
	}).blur(function() {
		var input = $(this);
			if (input.val() === '' || input.val() == input.attr('placeholder')) {
				input.addClass('placeholder');
				input.val(input.attr('placeholder'));
			}
	}).blur();
	// Prevent submission of empty form
	$('[placeholder]').parents('form').submit(function() {
		$(this).find('[placeholder]').each(function() {
			var input = $(this);
				if (input.val() == input.attr('placeholder')) {
					input.val('');
				}
		});
	});
*/

	$('#s').focus(function(){
		if( $(window).width() < 940 ){
			$(this).animate({ width: '200px' });
		}
	});
	
	$('#s').blur(function(){
		if( $(window).width() < 940 ){
			$(this).animate({ width: '100px' });
		}
	});
			
	$('.alert-message').alert();
	
	$('.dropdown-toggle').dropdown();

	
	$('div.blog-post #respond').each(function() {
		$(this).find('textarea#comment').autoGrow();
	});

//********************************************************
// you're still here? it's over. go home.
//********************************************************

});

