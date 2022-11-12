<?php
namespace Harmony;

/**
 * Frontend Pages Handler
 */
class Frontend {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        // Replace and Load product image gallery template
        add_filter( 'wc_get_template', [ $this, 'harmony_product_gallery_template'], 10, 5 );

        // Load audio player template
        add_action( 'woocommerce_before_add_to_cart_form', [ $this, 'harmony_audio_player'] );

        // Load harmony content on the vendor dashboard
        add_action( 'dokan_product_edit_after_main', [ $this, 'load_harmony_content_template' ], 4, 2 );

        //Save vendor dashboard harmony content field values
        add_action( 'dokan_new_product_added', [ $this, 'harmony_dk_product_video_url_save' ], 10, 2 );
        add_action( 'dokan_product_updated', [ $this, 'harmony_dk_product_video_url_save' ] );
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts(){
        wp_enqueue_style( 'harmony-flexslider' );
        wp_enqueue_style( 'harmony-frontend' );
        wp_enqueue_script( 'harmony-frontend' );
    }

    /**
     * If the template being loaded is the product image template, load the product gallery template
     * instead
     * 
     * @param located The path of the file that WooCommerce was going to use.
     * @param template_name The name of the template (ex: single-product/product-image.php)
     * @param args (array) Arguments passed to the template.
     * @param template_path The path to the template file.
     * @param default_path The default path to the template file.
     * 
     * @return The product gallery template.
     * 
     * @since 1.0
     * 
     */
    function harmony_product_gallery_template( $located, $template_name, $args, $template_path, $default_path ) {
        if ( 'single-product/product-image.php' == $template_name ) {
            $located = HARMONY_PATH . '/templates/product-gallery.php';
        }
        return $located;
    }

    /**
     * 
     * Load Audio Content template on the single product page
     * Before "add to cart" button
     * 
     * @return void
     * 
     * @since 1.0
     * 
     */
    function harmony_audio_player(){
        require_once HARMONY_PATH . '/templates/product-audio.php';
    }

    /**
     * It loads harmony content template file on the vendor dashboard's edit product page
     * 
     * @param post The post object
     * @param post_id The post ID of the post you want to load the template for.
     * 
     * @since 1.0
     * 
     */
    public function load_harmony_content_template( $post, $post_id ){
        require_once HARMONY_PATH . '/templates/dokan-vendor.php';
    }

    /**
     * Save the vendor dashboard featured content field value
     * 
     * @param post_id The ID of the post being saved.
     * @param data The data that is being saved.
     */
    public function harmony_dk_product_video_url_save( $post_id ){
        /* Save Video Content values */
        if( isset($_POST['harmony_featured_video_type']) ){
            update_post_meta( $post_id, 'harmony_featured_video_type', $_POST['harmony_featured_video_type'] );
        }

        if( isset($_POST['harmony_youtube_video']) ){
            update_post_meta( $post_id, 'harmony_youtube_video', $_POST['harmony_youtube_video'] );
        }

        if( isset($_POST['harmony_wpmedia_poster']) ){
            update_post_meta( $post_id, 'harmony_wpmedia_poster', $_POST['harmony_wpmedia_poster'] );
        }

        if( isset($_POST['harmony_wpmedia_video']) ){
            update_post_meta( $post_id, 'harmony_wpmedia_video', $_POST['harmony_wpmedia_video'] );
        }

        /* Save Audio Content values */
        if( isset( $_POST['harmony_product_audio_type'] ) ){
            update_post_meta( $post_id, 'harmony_product_audio_type', $_POST['harmony_product_audio_type'] );
        }
    
        if( isset( $_POST['harmony_soundcloud'] ) ){
            update_post_meta( $post_id, 'harmony_soundcloud', $_POST['harmony_soundcloud'] );
        }
        if( isset( $_POST['harmony_soundcloud'] ) ){
            update_post_meta( $post_id, 'harmony_wpmedia_audio', $_POST['harmony_wpmedia_audio'] );
        }
    }

}