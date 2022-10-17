<?php
namespace Harmony;

/**
 * Frontend Pages Handler
 */
class Frontend {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );


        add_action( 'dokan_new_product_after_product_tags', [ $this, 'harmony_vendor_add_product_video_url' ] );

        add_action( 'dokan_product_edit_after_product_tags', [ $this, 'harmony_vendor_edit_product_video_url' ], 10, 2 );

        add_action( 'dokan_new_product_added', [ $this, 'harmony_dk_product_video_url_save' ], 10, 2 );
        add_action( 'dokan_product_updated', [ $this, 'harmony_dk_product_video_url_save' ], 10, 2 );
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
     * It adds a new field to the add new product page in the vendor dashboard
     */
    public function harmony_vendor_add_product_video_url(){
        ?>
            <div class="dokan-form-group">
                <label for="harmony-video-url" class="dokan-form-label"><?php esc_html_e( 'Product Video URL', 'harmony' ); ?></label>
                <input class="dokan-form-control" name="harmony_youtube_video" id="harmony-video-url" type="text" placeholder="<?php esc_attr_e( 'Enter Video URL', 'harmony' ); ?>" value="<?php echo esc_attr( dokan_posted_input( 'harmony_youtube_video' ) ); ?>">
            </div>
        <?php
    }

    /**
     * It adds a new input field to the product edit page in the vendor dashboard
     * 
     * @param post The post object
     * @param post_id The post ID of the product.
     */
    public function harmony_vendor_edit_product_video_url( $post, $post_id ){
        ?>

        <div class="dokan-form-group">
        <label for="harmony_youtube_video" class="form-label"><?php esc_html_e( 'Product Video URL', 'harmony' ) ?></label>    

        <?php
            dokan_post_input_box( 
                $post_id,
                'harmony_youtube_video', 
                [
                    'placeholder'   => __( 'Enter Video URL', 'harmony' )
                ]
            );
        ?>

        </div>
        <?php
    }

    /**
     * Save the vendor featured video url field value
     * 
     * @param post_id The ID of the post being saved.
     * @param data The data that is being saved.
     */
    public function harmony_dk_product_video_url_save( $post_id, $data ){
        $dk_product_video_url = $data['harmony_youtube_video'];

        if( isset( $dk_product_video_url ) ){
            update_post_meta( $post_id, 'harmony_youtube_video', wp_kses_post( $dk_product_video_url ) );
        }
    }

}