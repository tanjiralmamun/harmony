<div class="harmony-content dokan-edit-row">
    <div class="dokan-section-heading" data-togglehandler="harmony_content">
        <h2><i class="fas fa-icons" aria-hidden="true"></i> <?php esc_html_e( 'Harmony', 'harmony' ); ?></h2>
        <p><?php esc_html_e( 'Product Audio & Video Content', 'harmony' ); ?></p>
        <a href="#" class="dokan-section-toggle">
            <i class="fas fa-sort-down fa-flip-vertical" aria-hidden="true"></i>
        </a>
        <div class="dokan-clearfix"></div>
    </div>

    <div class="dokan-section-content">
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
    </div><!-- .dokan-side-right -->
</div><!-- .dokan-product-inventory -->
