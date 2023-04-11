<?php

    $disable_wc_video = get_option( 'disable_wc_video' );
    $disable_wc_audio = get_option( 'disable_wc_audio' );
    $disable_dk_video_field = get_option( 'disable_dk_video_field' );
    $disable_dk_audio_field = get_option( 'disable_dk_audio_field' );
    
    if( $disable_wc_audio !== 'on' && $disable_dk_audio_field == 'on' || $disable_wc_video !== 'on' && $disable_dk_video_field == 'on' ){
        return;
    }

?>
<div class="harmony-content dokan-edit-row">
    <div class="dokan-section-heading" data-togglehandler="harmony_content">
        <h2><i class="fas fa-icons" aria-hidden="true"></i> <?php _e( 'Harmony', 'harmony' ); ?></h2>
        <p><?php _e( 'Product Audio & Video Content', 'harmony' ); ?></p>
        <a href="#" class="dokan-section-toggle">
            <i class="fas fa-sort-down fa-flip-vertical" aria-hidden="true"></i>
        </a>
        <div class="dokan-clearfix"></div>
    </div>

    <?php

        if( $disable_wc_video !== 'on' && $disable_dk_video_field !== 'on' ):

    ?>
    <div class="dokan-section-content harmony-video-content">
        <h3 class="harmony-dk-sub-heading"><?php _e( 'Product Video', 'harmony') ?> </h3>

        <?php
            $featured_video_type = get_post_meta( get_the_ID(), 'harmony_featured_video_type', true );

            if( $featured_video_type == 'youtube_video' || $featured_video_type == '' ){
                $youtube_video_radio = 'checked';
                $youtube_video_input = 'harmony-dk-active';
            } elseif ( $featured_video_type == 'wpmedia_video' ){
                $wpmedia_video_radio = 'checked';
                $wpmedia_video_input = 'harmony-dk-active';
            }
        ?>

        <div class="harmony_type_container">
            <label for="harmony_youtube_video"><input type="radio" name="harmony_featured_video_type" value="youtube_video" id="harmony_youtube_video" <?php isset( $youtube_video_radio ) ? esc_attr_e( $youtube_video_radio ) : ''; ?>> 
                <?php _e( 'YouTube', 'harmony' ); ?>
            </label>
            <label for="harmony_wpmedia_video"><input type="radio" name="harmony_featured_video_type" value="wpmedia_video" id="harmony_wpmedia_video" <?php isset( $wpmedia_video_radio ) ? esc_attr_e( $wpmedia_video_radio ) : ''; ?>> 
                <?php _e( 'File Upload', 'harmony' ); ?>
            </label>
        </div>

        <div class="dokan-form-group harmony-dk-youtube-video <?php echo esc_attr( $youtube_video_input ); ?>">
            <?php
                dokan_post_input_box( 
                    $post_id,
                    'harmony_youtube_video', 
                    [
                        'placeholder'   => __( 'Paste YouTube URL', 'harmony' )
                    ]
                );
            ?>
        </div>

        <div class="dokan-form-group harmony-dk-wpmedia-video <?php echo esc_attr( $wpmedia_video_input ); ?>">
            <?php
                $harmony_wpmedia_poster =  get_post_meta( $post_id, 'harmony_wpmedia_poster', true );
                $harmony_wpmedia_video  =  get_post_meta( $post_id, 'harmony_wpmedia_video', true );
            ?>

            <div class="harmony-dk-input-group">
                <input type="text" name="harmony_wpmedia_poster" id="harmony-dk-wpmedia-poster" class="dokan-form-control" value="<?php echo esc_attr( $harmony_wpmedia_poster ); ?>">
                
                <a href="#" class="dokan-btn dokan-btn-default dokan-btn-theme harmony-dk-upload-file-btn">
                    <?php _e( 'Choose File', 'harmony' ); ?>
                </a>
            </div>
            
            <div class="harmony-dk-input-group">
                <input type="text" name="harmony_wpmedia_video" id="harmony-dk-wpmedia-video-file" class="dokan-form-control" value="<?php echo esc_attr( $harmony_wpmedia_video ); ?>">
                
                <a href="#" class="dokan-btn dokan-btn-default dokan-btn-theme harmony-dk-upload-file-btn">
                    <?php _e( 'Choose File', 'harmony' ); ?>
                </a>
            </div>
        </div>
        <div class="dokan-clearfix"></div>
    </div>
    <?php 
        endif; 
        // end of Harmony Video Content

        if( $disable_wc_audio !== 'on' && $disable_dk_audio_field !== 'on' ):

    ?>

    <div class="dokan-section-content harmony-audio-content">
        <h3 class="harmony-dk-sub-heading"><?php _e( 'Product Audio', 'harmony') ?> </h3>

        <?php
    
            $product_audio_type = get_post_meta( get_the_ID(), 'harmony_product_audio_type', true );
    
            if( $product_audio_type == 'sc_audio' || $product_audio_type == '' ){
                $sc_audio_radio = 'checked';
                $sc_audio_input = 'harmony-dk-active';
            } elseif ( $product_audio_type == 'wpmedia_audio' ){
                $wpmedia_audio_radio = 'checked';
                $wpmedia_audio_input = 'harmony-dk-active';
            }
    
        ?>

        <div class="harmony_type_container">
            <label for="harmony_sc_audio"><input type="radio" name="harmony_product_audio_type" value="sc_audio" id="harmony_sc_audio" <?php isset( $sc_audio_radio ) ? esc_attr_e( $sc_audio_radio ) : ''; ?>> 
                <?php _e( 'SoundCloud', 'harmony' ); ?>
            </label>
            <label for="harmony_wpmedia_audio"><input type="radio" name="harmony_product_audio_type" value="wpmedia_audio" id="harmony_wpmedia_audio" <?php isset( $wpmedia_audio_radio ) ? esc_attr_e( $wpmedia_audio_radio ) : ''; ?>> 
                <?php _e( 'File Upload', 'harmony' ); ?>
            </label>
        </div>

        <div class="dokan-form-group harmony-dk-sc-audio <?php isset( $sc_audio_input ) ? esc_attr_e( $sc_audio_input ): ''; ?>">
            <?php
                dokan_post_input_box( 
                    $post_id,
                    'harmony_soundcloud', 
                    [
                        'placeholder'   => __( 'Paste SoundCloud URL', 'harmony' )
                    ]
                );
            ?>
        </div>

        <div class="dokan-form-group harmony-dk-wpmedia-audio <?php echo esc_attr( $wpmedia_audio_input ); ?>">
            <?php
                $harmony_wpmedia_audio =  get_post_meta( $post_id, 'harmony_wpmedia_audio', true );
            ?>

            <input type="text" name="harmony_wpmedia_audio" id="harmony-dk-wpmedia-audio-file" class="dokan-form-control" value="<?php echo esc_attr( $harmony_wpmedia_audio ); ?>">
            
            <a href="#" class="dokan-btn dokan-btn-default dokan-btn-theme harmony-dk-upload-file-btn">
                <?php _e( 'Choose File', 'harmony' ); ?>
            </a>
        </div>

        <div class="dokan-clearfix"></div>
    </div>
    <?php endif; ?>
    <!-- Harmony Audio Content -->
    
</div><!-- Harmony Content -->
