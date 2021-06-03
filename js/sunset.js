jQuery(document).ready(function ($) {
    revealPost();
    /* Ajax Functions */

    var last_scroll = 0;

    $(document).on('click', '.btn-ajax-load:not(.loading)', function () {
        var that = $(this);
        var page = that.data('page');
        var pageNew = page + 1;
        var ajaxUrl = that.data('url');
        var prev = that.data('prev');
        var archive = that.data('archive');

        if(typeof prev === 'undefined') {
            prev = 0;
        }

        if(typeof archive === 'undefined') {
            archive = 0;
        }

        that.addClass('loading').find('.text').slideUp(320);
        that.find('.fas').addClass('spin');

        $.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                page: page,
                prev: prev,
                archive: archive,
                action: 'sunset_load_more',
            },
            error: function (response) {
                console.log(response);
            },
            success: function (response) {

                if(response == 0) {
                    $('.sunset-posts-container').append('<h3>You reached the end of the line</h3><p>no more post</p>');
                    that.slideUp(320);
                } else {

                    setTimeout(function () {
                    
                        if(prev == 1) {
                            $('.sunset-posts-container').prepend(response);
                            pageNew = page - 1;
                        }else {
                            $('.sunset-posts-container').append(response);
                        }

                        if(pageNew == 1) {
                            that.slideUp(320);
                        } else {
                            that.data('page', pageNew);
                            that.removeClass('loading').find('.text').slideDown(320);
                            that.find('.fas').removeClass('spin');
                        }
    
    
                        revealPost();
    
                    }, 1000);

                }

                
            }
        });

    });

    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if( Math.abs(scroll - last_scroll) > $(window).height()*0.1) {
            last_scroll = scroll;

            $('.page-limit').each(function (index) {
                if( isVisible( $(this) ) ) {
                    history.replaceState(null, null, $(this).attr("data-page"));
                    return(false);
                }
            });
        }
    });

    // Helper Function
    function revealPost() {
        var posts = $('article:not(.reveal)');
        var i = 0;
        setInterval(function () {

            if( i >= posts.length ) return false;
            var el = posts[i];
            $(el).addClass(' reveal');

            i++;

        }, 200);
    }
    function isVisible(element) {
        var scroll_pos = $(window).scrollTop();
        var window_height = $(window).height();
        var el_top = $(element).offset().top;
        var el_height = $(element).height();
        var el_bottom = el_top + el_height;
        return ((el_bottom - el_height*0.25 > scroll_pos) && (el_top < (scroll_pos+0.5*window_height)));
    }

    
    /* 
    Contact from submission
    */

    $('#sunsetContactForm').on('submit', function(e){
        e.preventDefault();
        $('.has-error').removeClass('has-error');
        $('.js-show-feedback').removeClass('js-show-feedback');

        var form = $(this),
            name = form.find('#name').val(),
            email = form.find('#email').val(),
            message = form.find('#message').val(),
            ajaxurl = form.data('url');
            
                if( name == '' ){
                    $('.namee').parent('.form-group').addClass('has-error');
                    console.log('name is empty');
                    return;
                }
                if( email === '' ){
                    $('#email').parent('.form-group').addClass('has-error');
                    return;
                }
        
                if( message === '' ){
                    $('#message').parent('.form-group').addClass('has-error');
                    return;
                }
               
                form.find('input, button, textarea').attr('disabled', 'disabled');
                $('.js-form-submission').addClass( 'js-show-feedback' );
            
            $.ajax({
			
                url : ajaxurl,
                type : 'post',
                data : {
                    
                    name : name,
                    email : email,
                    message : message,
                    action: 'sunset_save_user_contact_form'
                    
                },
                error : function( response ){
                    $('.js-form-submission').removeClass('js-show-feedback');
                    $('.js-form-error').addClass('js-show-feedback');
                    form.find('input, button, textarea').removeAttr('disabled');
                },
                success : function( response ){
                    if( response == 0 ){
					
                        setTimeout(function(){
                            $('.js-form-submission').removeClass('js-show-feedback');
                            $('.js-form-error').addClass('js-show-feedback');
                            form.find('input, button, textarea').removeAttr('disabled');
                        },1500);
    
                    } else {
                        
                        setTimeout(function(){
                            $('.js-form-submission').removeClass('js-show-feedback');
                            $('.js-form-success').addClass('js-show-feedback');
                            form.find('input, button, textarea').removeAttr('disabled').val('');
                        },1500);
    
                    }
                }
                
            });
    });

});
