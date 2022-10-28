<?php
namespace Harmony;

/**
 * Frontend Pages Handler
 */
class Frontend {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        add_action( 'dokan_product_edit_after_main', [ $this, 'load_harmony_content_template' ], 4, 2 );

        add_action( 'dokan_new_product_after_product_tags', [ $this, 'harmony_vendor_add_product_video_url' ] );

        add_action( 'dokan_new_product_added', [ $this, 'harmony_dk_product_video_url_save' ], 10, 2 );
        add_action( 'dokan_product_updated', [ $this, 'harmony_dk_product_video_url_save' ] );
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts(){
        wp_enqueue_style( 'harmony-frontend' );
        wp_enqueue_script( 'harmony-frontend' );
    }

    /**
     * It loads a template file that contains a form that allows a vendor to add a new product
     * 
     * @param post The post object
     * @param post_id The post ID of the post you want to load the template for.
     */
    public function load_harmony_content_template( $post, $post_id ){
        require_once HARMONY_INCLUDES . '/dokan-vendor.php';
    }

    /**
     * It adds a new field to the add new product page in the vendor dashboard
     */
    public function harmony_vendor_add_product_video_url(){
        ?>
            <div class="dokan-form-group">
                <label for="harmony-video-url" class="dokan-form-label">
                    <?php __( 'Product Video URL', 'harmony' ); ?>
                </label>
                <input class="dokan-form-control" name="harmony_youtube_video" id="harmony-video-url" type="text" placeholder="<?php esc_attr_e( 'Enter Video URL', 'harmony' ); ?>" value="<?php echo esc_attr( dokan_posted_input( 'harmony_youtube_video' ) ); ?>">
            </div>
        <?php
    }

    /**
     * Save the vendor featured video url field value
     * 
     * @param post_id The ID of the post being saved.
     * @param data The data that is being saved.
     */
    public function harmony_dk_product_video_url_save( $post_id ){
        /* Save Video Content values */
        if( !empty($_POST['harmony_featured_video_type']) ){
            update_post_meta( $post_id, 'harmony_featured_video_type', $_POST['harmony_featured_video_type'] );
        }

        if( !empty($_POST['harmony_youtube_video']) ){
            update_post_meta( $post_id, 'harmony_youtube_video', $_POST['harmony_youtube_video'] );
        }

        if( !empty($_POST['harmony_wpmedia_video']) ){
            update_post_meta( $post_id, 'harmony_wpmedia_video', $_POST['harmony_wpmedia_video'] );
        }

        /* Save Audio Content values */
        if( !empty( $_POST['harmony_product_audio_type'] ) ){
            update_post_meta( $post_id, 'harmony_product_audio_type', $_POST['harmony_product_audio_type'] );
        }
    
        if( !empty( $_POST['harmony_soundcloud'] ) ){
            update_post_meta( $post_id, 'harmony_soundcloud', $_POST['harmony_soundcloud'] );
        }
        if( !empty( $_POST['harmony_soundcloud'] ) ){
            update_post_meta( $post_id, 'harmony_wpmedia_audio', $_POST['harmony_wpmedia_audio'] );
        }
    }

}