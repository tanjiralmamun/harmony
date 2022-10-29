<?php

/**
 * Handle when WooCommerce is not installed or activated
 *
 * @since 1.0
 * 
 */
function harmony_woocommerce_not_active_notice(){
    if ( current_user_can( 'activate_plugins' ) ) {

        $admin_notice_content = '';

        if ( ! harmony()->has_woocommerce() ){
            $install_url  = wp_nonce_url( add_query_arg( array( 'action' => 'install-plugin', 'plugin' => 'woocommerce' ), admin_url( 'update.php' ) ), 'install-plugin_woocommerce' );
            // translators: 1$-2$: opening and closing <strong> tags, 3$-4$: link tags, takes to woocommerce plugin on wp.org, 5$-6$: opening and closing link tags, leads to plugins.php in admin
            $admin_notice_content         = sprintf( esc_html__( '%1$sHarmony is inactive.%2$s The %3$sWooCommerce plugin%4$s must be active for Harmony to work. Please %5$s install WooCommerce &raquo;%6$s',  'harmony' ), '<strong>', '</strong>', '<a href="https://wordpress.org/plugins/woocommerce/">', '</a>', '<a href="' .  esc_url( $install_url ) . '">', '</a>' );

                if ( harmony()->is_woocommerce_installed() ) {
                    $install_url = wp_nonce_url( add_query_arg( array( 'action' => 'activate', 'plugin' => urlencode( 'woocommerce/woocommerce.php' ) ), admin_url( 'plugins.php' ) ), 'activate-plugin_woocommerce/woocommerce.php' );
                    // translators: 1$-2$: opening and closing <strong> tags, 3$-4$: link tags, takes to woocommerce plugin on wp.org, 5$-6$: opening and closing link tags, leads to plugins.php in admin
                    $admin_notice_content        = sprintf( esc_html__( '%1$sHarmony is inactive.%2$s The %3$sWooCommerce plugin%4$s must be active for Harmony to work. Please %5$s activate WooCommerce &raquo;%6$s',  'harmony' ), '<strong>', '</strong>', '<a href="https://wordpress.org/plugins/woocommerce/">', '</a>', '<a href="' .  esc_url( $install_url ) . '">', '</a>' );
                }
        }

        if ( $admin_notice_content ) {
            echo '<div class="error">';
            echo '<h3>'. esc_html__( 'WooCommerce Missing', 'wepos' ) . '</h3>';
            echo '<p>' . wp_kses_post( $admin_notice_content ) . '</p>';
            echo '</div>';
        }
    }
}
add_action( 'admin_notices', 'harmony_woocommerce_not_active_notice' );