var jq = jQuery.noConflict();

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
            harmonyUploadButton = jq( this ),
            videoURLContainer = harmonyUploadButton.prev( 'input#harmony_wpmedia_video_file' ),
            audioURLContainer = harmonyUploadButton.prev( 'input#harmony_wpmedia_audio_file' );
        
        // If the media frame already exists, reopen it.
        if ( harmonyUploadFrame ) {
            harmonyUploadFrame.open();
            return;
        }

        harmonyUploadFrame = wp.media({
            title: videoURLContainer.length > 0 ? 'Select or Upload a Video File': 'Select or Upload a Audio File',
            library: {
                type: videoURLContainer.length > 0 ? 'video' : 'audio'
            },
            button: {
                text: videoURLContainer.length > 0 ? 'Add Video' : 'Add Audio'
            },
            multiple: false
        })

        harmonyUploadFrame.on( 'select', function(){
            var attachment = harmonyUploadFrame.state().get('selection').first().toJSON();
            if( videoURLContainer.length > 0 ){
                videoURLContainer.val( attachment.url );
            } else {
                audioURLContainer.val( attachment.url );
            }
        } )

        harmonyUploadFrame.open();

    } )

} )