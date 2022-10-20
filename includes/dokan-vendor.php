<div class="harmony-content dokan-edit-row">
    <div class="dokan-section-heading" data-togglehandler="harmony_content">
        <h2><i class="fas fa-icons" aria-hidden="true"></i> <?php esc_html_e( 'Harmony', 'harmony' ); ?></h2>
        <p><?php esc_html_e( 'Product Audio & Video Content', 'harmony' ); ?></p>
        <a href="#" class="dokan-section-toggle">
            <i class="fas fa-sort-down fa-flip-vertical" aria-hidden="true"></i>
        </a>
        <div class="dokan-clearfix"></div>
    </div>

    <div class="dokan-section-content harmony-video-content">
        <h3 class="harmony-dk-sub-heading">Product Video</h3>

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
            <label for="harmony_youtube_video"><input type="radio" name="harmony_featured_video_type" value="youtube_video" id="harmony_youtube_video" <?php echo $youtube_video_radio; ?>> YouTube</label>
            <label for="harmony_wpmedia_video"><input type="radio" name="harmony_featured_video_type" value="wpmedia_video" id="harmony_wpmedia_video" <?php echo $wpmedia_video_radio; ?>> File Upload</label>
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
                $harmony_wpmedia_video =  get_post_meta( $post_id, 'harmony_wpmedia_video', true );
            ?>

            <input type="text" name="harmony_wpmedia_video" id="harmony-dk-wpmedia-video-file" class="dokan-form-control" value="<?php echo esc_url( $harmony_wpmedia_video ); ?>">
            
            <a href="#" class="dokan-btn dokan-btn-default dokan-btn-theme harmony-dk-upload-file-btn">Choose File</a>
        </div>
        <div class="dokan-clearfix"></div>
    </div>
    <!-- Harmony Video Content -->

    <div class="dokan-section-content harmony-audio-content">
        <h3 class="harmony-dk-sub-heading">Product Audio</h3>

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
            <label for="harmony_sc_audio"><input type="radio" name="harmony_product_audio_type" value="sc_audio" id="harmony_sc_audio" <?php echo $sc_audio_radio; ?>> SoundCloud</label>
            <label for="harmony_wpmedia_audio"><input type="radio" name="harmony_product_audio_type" value="wpmedia_audio" id="harmony_wpmedia_audio" <?php echo $wpmedia_audio_radio; ?>> File Upload</label>
        </div>

        <div class="dokan-form-group harmony-dk-sc-audio <?php echo esc_attr( $sc_audio_input ); ?>">
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

            <input type="text" name="harmony_wpmedia_audio" id="harmony-dk-wpmedia-audio-file" class="dokan-form-control" value="<?php echo esc_url( $harmony_wpmedia_audio ); ?>">
            
            <a href="#" class="dokan-btn dokan-btn-default dokan-btn-theme harmony-dk-upload-file-btn">Choose File</a>
        </div>

        <div class="dokan-clearfix"></div>
    </div>
    <!-- Harmony Audio Content -->
    
</div><!-- Harmony Content -->
