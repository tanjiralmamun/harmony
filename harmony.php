<?php
/**
 * Plugin Name:             Harmony
 * Plugin URI:              https://wordpress.org/plugins/harmony
 * Description:             Product Featured Audio Video Content
 * Version:                 1.0
 * Requires at least:       5.2
 * Requires PHP:            7.2
 * WC requires at least:    6.0
 * WC tested up to:         6.8.2
 * Author:                  Tanjir Al Mamun
 * Author URI:              https://tanjirsdev.com
 * License:                 GPL v2 or later
 * License URI:             https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:             harmony
 * Domain Path:             /languages
 */

/**
 * Copyright (c) 2022 Tanjir Al Mamun (email: contact.tanjir@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * 
 * Harmony Class
 * 
 * @class Harmony - the class that holds the entire Harmony plugin
 * 
 */

final class Harmony {
    /**
     * 
     * Plugin version
     * 
     * @var string
     * 
     */

    public $version = '1.0';

    /**
     * 
     * Holds various class instances
     * 
     * @var array
     * 
     */

    private $container  = [];

    /**
     * 
     * Constructor for the Harmony class
     * 
     * Sets up all the appropriate hooks and actions
     * within the plugin
     * 
     */

    public function __construct(){
        $this->define_constants();
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        add_action( 'woocommerce_loaded', [ $this, 'init_plugin' ] );

        add_action( 'plugins_loaded', [ $this, 'woocommerce_not_loaded' ], 11 );
    }

    /**
     * 
     * Initialize the Harmony() class
     * 
     * Checks for an existing Harmony() instance
     * and if it doesn't find one, creates it.
     * 
     */

    public static function init(){
        static $instance = false;

        if( ! $instance ){
            $instance = new Harmony();
        }

        return $instance;
    }

    /**
     * 
     * Define contants
     * 
     * @return void
     * 
     */
    public function define_constants(){
        define( 'HARMONY_VERSION', $this->version );
        define( 'HARMONY_FILE', __FILE__ );
        define( 'HARMONY_PATH', dirname( HARMONY_FILE ) );
        define( 'HARMONY_INCLUDES', HARMONY_PATH . '/includes' );
        define( 'HARMONY_URL', plugins_url( '', HARMONY_FILE ) );
        define( 'HARMONY_ASSETS', HARMONY_URL . '/assets' );
    }

    /**
     * 
     * Load the plugin after all plugins are loaded
     * 
     * @return void
     * 
     */

    public function init_plugin(){
        $this->includes();
        $this->init_hooks();
    }

    /**
     * 
     * Placeholder for activation function
     * 
     * Nothing being called here yet.
     * 
     */

    public function activate(){
        $installed = get_option( 'harmony_installed' );

        if( ! $installed ){
            update_option( 'harmony_installed', time() );
        }

        update_option( 'harmony_version', HARMONY_VERSION );
    }

    /**
     * 
     * Include required files
     * 
     * @return void
     * 
     */

    public function includes(){
        require_once HARMONY_INCLUDES . '/Assets.php';

        if ( $this->is_request( 'admin' ) ) {
            require_once HARMONY_INCLUDES . '/Admin.php';
        }

        if ( $this->is_request( 'frontend' ) ) {
            require_once HARMONY_INCLUDES . '/Frontend.php';
        }

        require_once HARMONY_INCLUDES . '/functions.php';
    }

    /**
     * 
     * Initialize the hooks
     * 
     * @return void
     * 
     */

    public function init_hooks(){
        add_action( 'init', [ $this, 'init_classes' ] );

        add_action( 'init', [ $this, 'localization_setup' ] );

        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), [ $this, 'harmony_action_links'] );
    } 

    /**
     * 
     * Show action links on the plugin screen
     * 
     * @param mixed $links Plugin Action links
     * 
     * @return array
     * 
     */

    public function harmony_action_links( $links ){
        $action_links = [
            'settings'  => '<a href="' . admin_url( 'admin.php?page=harmony' ) . '" aria-label="' . esc_attr__( 'View Harmony settings', 'harmony' ) . '">' . esc_html__( 'Settings', 'harmony' ) . '</a>'
        ];

        return array_merge( $action_links, $links );
    }

    /**
     * 
     * Instantiate required classes
     * 
     * @return void
     * 
     */

    public function init_classes(){
        $this->container['assets']  = new Harmony\Assets();

        if ( $this->is_request( 'admin' ) ) {
            $this->container['admin']  = new Harmony\Admin();
        }

        if ( $this->is_request( 'frontend' ) ) {
            $this->container['frontend']  = new Harmony\Frontend();
        }
    }

    /**
     * 
     * Initialize plugin for localization
     * 
     * @uses load_plugin_textdomain()
     * 
     */

    public function localization_setup(){
        load_plugin_textdomain( 'harmony', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * 
     * What type of request is this?
     * 
     * @param string @type admin or frontend
     * 
     * @return bool
     * 
     */

    private function is_request( $type ){
        switch( $type ){
            case 'admin': 
                return is_admin();

            case 'frontend':
                return ( ! is_admin() );
        }
    }

    /**
     * 
     * Check whether woocommerce is installed and active
     * 
     * @since 1.0
     * 
     * @return bool
     * 
     */

    public function has_woocommerce(){
        return class_exists( 'WooCommerce' );
    }

    /**
     * 
     * Check whether dokan is installed and active
     * 
     * @since 1.0
     * 
     * @return bool
     * 
     */

    public function has_dokan(){
        return class_exists( 'WeDevs_Dokan' );
    }

    /**
     * 
     * Check whether woocommerce is installed
     * 
     * @since 1.0
     * 
     * @return bool
     * 
     */

    public function is_woocommerce_installed(){
        return in_array( 'woocommerce/woocommerce.php', array_keys( get_plugins() ), true );
    }

    /**
     * 
     * Handles scenerios when WooCommerce is not active
     * 
     * @since 1.0
     * 
     * @return void
     * 
     */

    public function woocommerce_not_loaded(){
        if ( did_action( 'woocommerce_loaded' ) || ! is_admin() ) {
            return;
        }

        require_once STOREKIT_INCLUDES . '/functions.php';
    }

} // Harmony

/**
 * 
 * Load Harmony Plugin when all plugins loaded
 * 
 * @since 1.0
 * 
 * @return Harmony
 * 
 */

function harmony(){
    return Harmony::init();
}

// Let's go
harmony();