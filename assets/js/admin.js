var jq = jQuery.noConflict(),
    { __ } = wp.i18n;

jq( document ).ready( function(){

    /** 
     * 
     * Work with Product Video Radio select
     * 
    */
    
    jq( 'input[name="harmony_featured_video_type"]' ).on( 'change', function(){
        var featuredVideoType = jq( this ).val();
        
        if( featuredVideoType == 'youtube_video' ){
            jq( '.harmony-option-group-wrapper .harmony_wpmedia_video_field' ).removeClass( 'harmony_active' );
            jq( '.harmony-option-group-wrapper .harmony_youtube_video_field' ).addClass( 'harmony_active' );
        } else if ( featuredVideoType == 'wpmedia_video' ) {
            jq( '.harmony-option-group-wrapper .harmony_youtube_video_field' ).removeClass( 'harmony_active' );
            jq( '.harmony-option-group-wrapper #harmony_youtube_video' ).removeAttr( 'checked' );
            jq( '.harmony-option-group-wrapper .harmony_wpmedia_video_field' ).addClass( 'harmony_active' );
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
            jq( '.harmony-option-group-wrapper .harmony_wpmedia_audio_field' ).removeClass( 'harmony_active' );
            jq( '.harmony-option-group-wrapper .harmony_soundcloud_field' ).addClass( 'harmony_active' );
        } else if ( productAudioType == 'wpmedia_audio' ) {
            jq( '.harmony-option-group-wrapper .harmony_soundcloud_field' ).removeClass( 'harmony_active' );
            jq( '.harmony-option-group-wrapper #harmony_sc_audio' ).removeAttr( 'checked' );
            jq( '.harmony-option-group-wrapper .harmony_wpmedia_audio_field' ).addClass( 'harmony_active' );
        }
    } )

    /*
    *
    * Video Upload/WP Media Upload Window Field for Custom Uploaded Video
    * 
    */
    jq( 'a.harmony_upload_file_button' ).on( 'click', function( e ){
        e.preventDefault();

        var harmonyUploadFrame,
            harmonyUploadButton     = jq( this ),
            videoPosterContainer    = harmonyUploadButton.prev( 'input#harmony-wpmedia-poster' ),
            videoURLContainer       = harmonyUploadButton.prev( 'input#harmony-wpmedia-video' ),
            audioURLContainer       = harmonyUploadButton.prev( 'input#harmony_wpmedia_audio_file' );
        
        // If the media frame already exists, reopen it.
        if ( harmonyUploadFrame ) {
            harmonyUploadFrame.open();
            return;
        }

        harmonyUploadFrame = wp.media({
            title: videoPosterContainer.length > 0 ? __( 'Select or Upload a Photo File', 'harmony' ) : videoURLContainer.length > 0 ? __( 'Select or Upload a Video File', 'harmony' ): __( 'Select or Upload a Audio File', 'harmony'),
            library: {
                type: videoPosterContainer.length > 0 ? 'image' : videoURLContainer.length > 0 ? 'video' : 'audio'
            },
            button: {
                text: videoPosterContainer.length > 0 ? __( 'Add Photo', 'harmony' ) : videoURLContainer.length > 0 ? __( 'Add Video', 'harmony' ) : __( 'Add Audio', 'harmony' )
            },
            multiple: false
        })

        harmonyUploadFrame.on( 'select', function(){
            var attachment = harmonyUploadFrame.state().get('selection').first().toJSON();
            if( videoPosterContainer.length > 0 ){
                videoPosterContainer.val( attachment.url );
            } else if( videoURLContainer.length > 0 ) {
                videoURLContainer.val( attachment.url );
            } else {
                audioURLContainer.val( attachment.url );
            }
        } )

        harmonyUploadFrame.open();

    } )

    /* 
    * Harmony Settings
    *
    * For managing the Tab View and save the active tab in the local storage.
    * 
    */
    var harmonyActiveTab = localStorage.getItem( 'harmonyActiveTab' );
    if ( harmonyActiveTab !== null ) {
        var target   = jq( '.harmony-settings-tab' ).find( 'a[href="' + harmonyActiveTab + '"]' ),
            targetID = target.attr( 'href' ).split( '#', 2 );
            
        jq( '.harmony-settings' ).find( '.harmony_active' ).removeClass( 'harmony_active' );
        target.addClass( 'harmony_active' );
        jq( '.harmony-settings-tab-content' ).find( '#' + targetID[1] ).addClass( 'harmony_active' );
    }

    jq( '.harmony-settings-tab a' ).on( 'click', function( e ){
        e.preventDefault();
        var activeTab = jq( '.harmony-settings' ).find( '.harmony_active' );
            targetID  = jq( this ).attr( 'href' ).split( '#', 2 );

        activeTab.removeClass( 'harmony_active' );
        jq( this ).addClass( 'harmony_active' );

        jq( '.harmony-settings-tab-content' ).find( '#' + targetID[1] ).addClass( 'harmony_active' );
        
        localStorage.setItem( 'harmonyActiveTab', jq( this ).attr( 'href' ) );
    } )

} )