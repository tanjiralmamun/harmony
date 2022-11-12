var jq = jQuery.noConflict();

jq( document ).ready( function() {

    /* Initializing the flexslider plugin. */
    jq('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails",
        animationLoop: false,
        slideshow: false,
        directionNav: false,
        smoothHeight: true
    });

    jq('.flex-prev').empty();
    jq('.flex-next').empty();
    
    /* jQuery event listener that listens for a click on the reset variations button. When
    the button is clicked, it triggers a custom event on the product gallery. */
    jq( '.reset_variations' ).on( 'click', () => {
        var form            = jq('.variations_form.cart'),
            product        = form.closest( '.product' ),
            product_gallery = product.find( '#harmony-product-gallery' );
            
        product_gallery.trigger( 'woocommerce_gallery_reset_slide_position' );
    })

    /* jQuery event listener that listens for a custom event on the product gallery. When the
    custom event is triggered, it resets the flexslider to the first slide. */
    jq( '#harmony-product-gallery' ).on( 'woocommerce_gallery_reset_slide_position', () => {
        var target = jq( '.flexslider' );
        target.flexslider(0);
    } )

    /* Checking if the product has a featured video. If it does, it sets the height
    of the video to match the height of the first image in the gallery. */
    var hasFeaturedVideo = jq( '#harmony-product-gallery' ).find( '.featured-video' );

    if( hasFeaturedVideo.length > 0 ){

        setTimeout( () => {

            var previousThumbWidth  = jq('.flex-control-nav li:eq(1) img').width(),
                previousThumbHeight = jq('.flex-control-nav li:eq(1) img').height()

            jq('.flex-control-nav li:eq(0) img').css({
                'width'     : previousThumbWidth + 'px',
                'height'    : previousThumbHeight + 'px',
                'object-fit': 'cover'
            });

        }, 200 )

    }

    // Loads the IFrame Player API code asynchronously.
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player,
        getVideoId = jq( '.featured-video.youtube' ).data( 'video_id' );
    window.onYouTubeIframeAPIReady = function () {
        player = new YT.Player( 'youtube-video-content', {
            videoId: getVideoId,
            playerVars: {
                'playsinline': 1,
                'rel': 0,
            },
            events: {
                'onReady': onPlayerReady
            }
        });
    }

    // The API will call this function when the video player is ready.
    function onPlayerReady(event) {
        event.target.stopVideo();
    }

    /* Prepending an anchor tag with a class of `harmony-gallery_trigger` to the
    `#harmony-product-gallery` element. */
    jq( '#harmony-product-gallery' ).prepend( '<a href="#" class="harmony-gallery_trigger">🔍</a>' );
    var gallery = jq( '#harmony-product-gallery .flexslider' ),

        /* Function for getting the items that are in the gallery. It is then returning
        those items. */
        getItems = function(){

            var items = [];

            gallery.find( 'a' ).each( function() {
                var href    = jq( this ).attr('href'),
                    size    = jq( this ).data('size').split('x'),
                    width  = size[0],
                    height = size[1];    

                var item = {
                    src: href,
                    w: width,
                    h: height
                }

                items.push( item );

            } )
                            
            /* This is checking if the product has a featured video that is from YouTube. If it does,
            it is getting the video ID and adding it to the gallery. */
            var youtubeVideoWrapper = gallery.find( '.featured-video.youtube' );
            
            if( youtubeVideoWrapper.length > 0 ){
                var item = {
                    html: '<div class="harmony-youtube-video-wrapper"><iframe width="640" height="360" src="https://www.youtube.com/embed/'+ getVideoId +'?playsinline=1&amp;rel=0&amp;enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'
                }

                items.unshift(item);
            }

            /* This is checking if the product has a featured video that is uploaded to the WordPress
            media library. If it does, it is getting the video URL and adding it to the gallery. */
            var wpmediaVideoWrapper = gallery.find( '.featured-video.wpmedia' );

            if( wpmediaVideoWrapper.length > 0 ){
                var getVideoURL = wpmediaVideoWrapper.find( 'source' ).attr( 'src' ),
                    item = {
                        html: '<div class="harmony-wpmedia-video-wrapper"><video controls><source src='+ getVideoURL +'></video></div>'
                    }

                items.unshift(item);
            }

            return items;

        }

    /* jQuery event listener that is listening for a click on the gallery. When the gallery
    is clicked, it is preventing the default action. */
    gallery.on( 'click', 'a', function(e){
        e.preventDefault();
    } )

    /* Function for getting the items that are in the gallery. It is then returning those
    items. */
    var galleryItems = getItems();

    /* Initializing the PhotoSwipe lightbox. */
    var pswp = jq('.pswp')[0];
    jq( '#harmony-product-gallery' ).on( 'click', 'a.harmony-gallery_trigger', function( e ) {
        e.preventDefault();
        
        var $index = jq( this ).index();
        var options = {
            index: $index,
            bgOpacity: 1,
            showHideOpacity: true
        }
        
        // Initialize PhotoSwipe
        var lightBox = new PhotoSwipe( pswp, PhotoSwipeUI_Default, galleryItems, options );
        
        lightBox.init();

        
        /* This is a listener that is listening for the close event on the lightbox. When the lightbox
        is closed, it is resetting the iframe src attribute. */
        lightBox.listen( 'close', function() {
            var youtubePopupVideoWrapper = jq( '.harmony-youtube-video-wrapper' );
            if( youtubePopupVideoWrapper.length > 0 ){
                var youtubePopupiFrameSrc = youtubePopupVideoWrapper.find( 'iframe' ).attr( 'src' );
                youtubePopupVideoWrapper.find('iframe').attr('src', youtubePopupiFrameSrc);
            }

            var wpmediaPopupVideoWrapper = jq( '.harmony-wpmedia-video-wrapper' );
            if( wpmediaPopupVideoWrapper.length > 0 ){
                var wpmediaVideo = wpmediaPopupVideoWrapper.find( 'video' ).get(0);
                function pauseWPMediaVideo(){
                    wpmediaVideo.pause();
                }
                pauseWPMediaVideo();
            }
        });
        
        
        /* This is a listener that is listening for the beforeChange event on the lightbox. When the
        lightbox is closed, it is resetting the iframe src attribute. */
        lightBox.listen( 'beforeChange', function() {
            var youtubePopupVideoWrapper = jq( '.harmony-youtube-video-wrapper' );
            if( youtubePopupVideoWrapper.length > 0 ){
                var youtubePopupiFrameSrc = youtubePopupVideoWrapper.find( 'iframe' ).attr( 'src' );
                youtubePopupVideoWrapper.find('iframe').attr('src', youtubePopupiFrameSrc);
            }

            var wpmediaPopupVideoWrapper = jq( '.harmony-wpmedia-video-wrapper' );
            if( wpmediaPopupVideoWrapper.length > 0 ){
                var wpmediaVideo = wpmediaPopupVideoWrapper.find( 'video' ).get(0);
                function pauseWPMediaVideo(){
                    wpmediaVideo.pause();
                }
                pauseWPMediaVideo();
            }
        } );
    });

    /* jQuery function that is looping through each anchor tag in the gallery. It is then
    getting the href attribute of the anchor tag and setting it as the url for the zoom function. */
    jq( '#harmony-product-gallery a' ).each( function(){
        var hrefAttr = jq(this).attr('href');
        jq(this).zoom({
            url: hrefAttr
        })
    } )

    /** 
     * 
     * Dokan Vendor Dashboard - Work with Product Video Radio select
     * 
    */
    jq( 'input[name="harmony_featured_video_type"]' ).on( 'change', function(){
        var featuredVideoType = jq( this ).val();
        
        if( featuredVideoType == 'youtube_video' ){
            jq( '.harmony-dk-wpmedia-video' ).removeClass( 'harmony-dk-active' );
            jq( '.harmony-dk-youtube-video' ).addClass( 'harmony-dk-active' );
        } else if ( featuredVideoType == 'wpmedia_video' ) {
            jq( '.harmony-dk-youtube-video' ).removeClass( 'harmony-dk-active' );
            jq( '#harmony_youtube_video' ).removeAttr( 'checked' );
            jq( '.harmony-dk-wpmedia-video' ).addClass( 'harmony-dk-active' );
        }
    } )

    /** 
     * 
     * Work with Product Audio Radio select
     * 
    */
    
    jq( 'input[name="harmony_product_audio_type"]' ).on( 'change', function(){
        var productAudioType = jq( this ).val();
        
        if( productAudioType == 'sc_audio' ){
            jq( '.harmony-dk-wpmedia-audio' ).removeClass( 'harmony-dk-active' );
            jq( '.harmony-dk-sc-audio' ).addClass( 'harmony-dk-active' );
        } else if ( productAudioType == 'wpmedia_audio' ) {
            jq( '.harmony-dk-sc-audio' ).removeClass( 'harmony-dk-active' );
            jq( '#harmony_sc_audio' ).removeAttr( 'checked' );
            jq( '.harmony-dk-wpmedia-audio' ).addClass( 'harmony-dk-active' );
        }
    } )

    /*
    *
    * Video Upload/WP Media Upload Window Field for Custom Uploaded Video
    * 
    */
    jq( 'a.harmony-dk-upload-file-btn' ).on( 'click', function( e ){
        e.preventDefault();

        var harmonyDKUploadFrame,
            harmonyDKUploadButton   = jq( this ),
            videoDKPosterContainer  = harmonyDKUploadButton.prev( 'input#harmony-dk-wpmedia-poster' ),
            videoDKURLContainer     = harmonyDKUploadButton.prev( 'input#harmony-dk-wpmedia-video-file' ),
            audioDKURLContainer     = harmonyDKUploadButton.prev( 'input#harmony-dk-wpmedia-audio-file' );
        
        // If the media frame already exists, reopen it.
        if ( harmonyDKUploadFrame ) {
            harmonyDKUploadFrame.open();
            return;
        }

        harmonyDKUploadFrame = wp.media({
            title: videoDKPosterContainer.length > 0 ? 'Select or Upload a Photo File' : videoDKURLContainer.length > 0 ? 'Select or Upload a Video File': 'Select or Upload a Audio File',
            library: {
                type: videoDKPosterContainer.length > 0 ? 'image' : videoDKURLContainer.length > 0 ? 'video' : 'audio'
            },
            button: {
                text: videoDKPosterContainer.length > 0 ? 'Add Photo' : videoDKURLContainer.length > 0 ? 'Add Video' : 'Add Audio'
            },
            multiple: false
        })

        harmonyDKUploadFrame.on( 'select', function(){
            var dkAttachment = harmonyDKUploadFrame.state().get('selection').first().toJSON();
            if( videoDKPosterContainer.length > 0 ){
                videoDKPosterContainer.val( dkAttachment.url );
            } else if ( videoDKURLContainer.length > 0 ) {
                videoDKURLContainer.val( dkAttachment.url );
            } else {
                audioDKURLContainer.val( dkAttachment.url );
            }
        } )

        harmonyDKUploadFrame.open();

    } )


} );
