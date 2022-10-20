<?php
namespace Harmony;

/**
 * Admin Pages Handler
 */
class Admin {

    public function __construct() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        /* Admin Screen - New Tab */
        add_filter( 'woocommerce_product_data_tabs', [ $this, 'harmony_edit_product_tab' ] );
        add_action( 'woocommerce_product_data_panels', [ $this, 'harmony_edit_product_tab_content' ] );

        /* Admin Screen - Product Video Fields */
        add_action( 'harmony_product_tab_content', [ $this, 'harmony_product_video_url_field' ], 10 );

        /* Admin Screen - Product Audio Fields */
        add_action( 'harmony_product_tab_content', [ $this, 'harmony_product_audio_url_field' ], 11 );

        /* Admin Screen - Save Fields' Values */
        add_action( 'woocommerce_process_product_meta', [ $this, 'save_harmony_field_values' ], 10, 2 );

    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'harmony-admin' );
        wp_enqueue_script( 'harmony-admin' );
    }

    /**
     * It adds a new tab to the product data section of the product edit page.
     * 
     * @since 1.0
     * 
     * @param tabs The array of tabs that are already registered.
     * 
     * @return The tabs array with the new tab added.
     */
    public function harmony_edit_product_tab( $tabs ){
        $tabs[ 'harmony' ]  = [
            'label'     => __( 'Harmony', 'harmony' ),
            'target'    => 'harmony_product_data',
            'priority'  => 11
        ];
    
        return $tabs;
    }
    
    /**
     * It adds a new tab content panel to the product edit page in the admin area
     * 
     * @since 1.0
     */
    public function harmony_edit_product_tab_content(){
        ?>
        <div id="harmony_product_data" class="panel woocommerce_options_panel">
            <?php do_action( 'harmony_product_tab_content' ); ?>
        </div>
        <?php
    }

    
    /**
     * Adding Admin Screen - Product Video Section via Harmony tab
     * 
     * It creates a custom meta box for the product post type that allows the user to upload an video
     * file or enter a YouTube URL
     * 
     * @since 1.0
     * 
     */
    function harmony_product_video_url_field(){
        ?>

        <h3 class="harmony_content_panel_title">Product Video</h3><hr>

        <?php

        $featured_video_type = get_post_meta( get_the_ID(), 'harmony_featured_video_type', true );

        if( $featured_video_type == 'youtube_video' || $featured_video_type == '' ){
            $youtube_video_radio = 'checked';
            $youtube_video_input = 'harmony_active';
        } elseif ( $featured_video_type == 'wpmedia_video' ){
            $wpmedia_video_radio = 'checked';
            $wpmedia_video_input = 'harmony_active';
        }

        ?>

        <div class="options_group harmony-option-group-wrapper harmony-product_featured_video">
            <div class="harmony_type_container">
                <label for="harmony_youtube_video"><input type="radio" name="harmony_featured_video_type" value="youtube_video" id="harmony_youtube_video" <?php echo $youtube_video_radio; ?>> YouTube</label>
                <label for="harmony_wpmedia_video"><input type="radio" name="harmony_featured_video_type" value="wpmedia_video" id="harmony_wpmedia_video" <?php echo $wpmedia_video_radio; ?>> File Upload</label>
            </div>

            <hr>

            <?php
                woocommerce_wp_text_input( [
                    'id'            => 'harmony_youtube_video',
                    'value'         => get_post_meta( get_the_ID(), 'harmony_youtube_video', true ),
                    'label'         => __( 'Product Video URL', 'harmony' ),
                    'description'   => __( 'YouTube Video URL', 'harmony' ),
                    'desc_tip'      => true,
                    'wrapper_class' => $youtube_video_input
                ] );
            ?>

            <p class="form-field harmony_wpmedia_video_field <?php echo $wpmedia_video_input; ?>">
                <label for="harmony_wpmedia_video_file">Product Video URL</label>

                <?php
                    $harmony_wpmedia_video =  get_post_meta( get_the_ID(), 'harmony_wpmedia_video', true );
                ?>

                <input type="text" name="harmony_wpmedia_video" id="harmony_wpmedia_video_file" value="<?php echo esc_url( $harmony_wpmedia_video ); ?>">
                
                <a href="#" class="harmony_upload_file_button">Choose File</a>
            </p>

        </div>

        <?php
    }

    /**
     * 
     * Adding Admin Screen - Product Audio Section via Harmony tab
     * 
     * It creates a custom meta box for the product post type that allows the user to upload an audio
     * file or enter a SoundCloud URL
     * 
     * @since 1.0
     * 
     */
    function harmony_product_audio_url_field(){
        ?>
    
        <h3 class="harmony_content_panel_title">Product Audio</h3><hr>
    
        <?php
    
            $product_audio_type = get_post_meta( get_the_ID(), 'harmony_product_audio_type', true );
    
            if( $product_audio_type == 'sc_audio' || $product_audio_type == '' ){
                $sc_audio_radio = 'checked';
                $sc_audio_input = 'harmony_active';
            } elseif ( $product_audio_type == 'wpmedia_audio' ){
                $wpmedia_audio_radio = 'checked';
                $wpmedia_audio_input = 'harmony_active';
            }
    
        ?>
    
        <div class="options_group harmony-option-group-wrapper harmony-product_sample_audio">
    
            <div class="harmony_type_container">
                <label for="harmony_sc_audio"><input type="radio" name="harmony_product_audio_type" value="sc_audio" id="harmony_sc_audio" <?php echo $sc_audio_radio; ?>> SoundCloud</label>
                <label for="harmony_wpmedia_audio"><input type="radio" name="harmony_product_audio_type" value="wpmedia_audio" id="harmony_wpmedia_audio" <?php echo $wpmedia_audio_radio; ?>> File Upload</label>
            </div>
    
            <hr>
    
            <?php
    
                woocommerce_wp_text_input( [
                    'id'            => 'harmony_soundcloud',
                    'value'         => get_post_meta( get_the_ID(), 'harmony_soundcloud', true ),
                    'label'         => __( 'Product Audio URL', 'harmony' ),
                    'description'   => __( 'Soundcloud URL', 'harmony' ),
                    'desc_tip'      => true,
                    'wrapper_class' => $sc_audio_input
                ] );
    
            ?>
    
            <p class="form-field harmony_wpmedia_audio_field <?php echo $wpmedia_audio_input; ?>">
                <label for="harmony_wpmedia_audio_file">Product Audio URL</label>
    
                <?php
                    $harmony_wpmedia_audio =  get_post_meta( get_the_ID(), 'harmony_wpmedia_audio', true );
                ?>
    
                <input type="text" name="harmony_wpmedia_audio" id="harmony_wpmedia_audio_file" value="<?php echo esc_url( $harmony_wpmedia_audio ); ?>">
                
                <a href="#" class="harmony_upload_file_button">Choose File</a>
            </p>
    
        </div>
    
        <?php
    }
    
    /**
     * Save Admin Screen Field Values
     * 
     * @since 1.0
     * 
     * @param id The post ID.
     * @param post The post object.
     */
    function save_harmony_field_values( $id, $post ){
        /* Save Video Content values */
        if( !empty($_POST['harmony_featured_video_type']) ){
            update_post_meta( $id, 'harmony_featured_video_type', $_POST['harmony_featured_video_type'] );
        }

        if( !empty($_POST['harmony_youtube_video']) ){
            update_post_meta( $id, 'harmony_youtube_video', $_POST['harmony_youtube_video'] );
        }

        if( !empty($_POST['harmony_wpmedia_video']) ){
            update_post_meta( $id, 'harmony_wpmedia_video', $_POST['harmony_wpmedia_video'] );
        }

        /* Save Audio Content values */
        if( !empty( $_POST['harmony_product_audio_type'] ) ){
            update_post_meta( $id, 'harmony_product_audio_type', $_POST['harmony_product_audio_type'] );
        }
    
        if( !empty( $_POST['harmony_soundcloud'] ) ){
            update_post_meta( $id, 'harmony_soundcloud', $_POST['harmony_soundcloud'] );
        }
        if( !empty( $_POST['harmony_soundcloud'] ) ){
            update_post_meta( $id, 'harmony_wpmedia_audio', $_POST['harmony_wpmedia_audio'] );
        }
    }

}