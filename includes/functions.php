<?php

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
 */
function harmony_product_gallery_template( $located, $template_name, $args, $template_path, $default_path ) {
    if ( 'single-product/product-image.php' == $template_name ) {
        $located = plugin_dir_path( __FILE__ ) . '/product-gallery.php';
    }
    return $located;
}
add_filter( 'wc_get_template', 'harmony_product_gallery_template', 10, 5 );

function harmony_audio_player(){
    require_once plugin_dir_path( __FILE__ ) . '/product-audio.php';
}
add_action( 'woocommerce_before_add_to_cart_form', 'harmony_audio_player' );