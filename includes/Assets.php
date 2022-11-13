<?php
namespace Harmony;

/**
 * 
 * Script and style classes
 * 
 */
class Assets {

    public function __construct(){
        if ( is_admin() ){
            add_action( 'admin_enqueue_scripts', [ $this, 'register' ], 5 );
        } else {
            add_action( 'wp_enqueue_scripts', [ $this, 'register' ], 5 );
        }
    }

    /**
     * 
     * Register plugin's scripts and styles
     * 
     * @return void
     * 
     */
    public function register(){
        $this->register_scripts( $this->get_scripts() );
        $this->register_styles( $this->get_styles() );
    }

    /**
     * 
     * Register scripts
     *
     * @param array $scripts
     *
     * @return void
     * 
     */
    private function register_scripts( $scripts ){
        foreach( $scripts as $handle => $script ){
            $deps       = isset( $script['deps'] ) ? $script['deps'] : false;
            $in_footer  = isset( $script['in_footer'] ) ? $script['in_footer'] : false;
            $version   = isset( $script['version'] ) ? $script['version'] : HARMONY_VERSION;

            wp_register_script( $handle, $script[ 'src' ], $deps, $version, $in_footer );
        }
    }

    /**
     * 
     * Register Styles
     * 
     * @param array $styles
     * 
     * @return void
     * 
     */

    public function register_styles( $styles ){
        foreach ( $styles as $handle => $style ){
            $deps   = isset( $style['deps'] ) ? $style['deps'] : false;

            wp_register_style( $handle, $style['src'], $deps, HARMONY_VERSION );
        }
    }


    public function get_scripts(){
        $scripts = [
            'harmony-admin' => [
                'src'       => HARMONY_ASSETS . '/js/admin.js',
                'deps'      => [ 'jquery', 'wp-i18n' ],
                'in_footer' => true
            ],
            'harmony-frontend' => [
                'src'       => HARMONY_ASSETS . '/js/frontend.js',
                'deps'      => [ 'jquery', 'flexslider', 'photoswipe', 'zoom', 'wp-i18n' ],
                'in_footer' => true
            ]
        ];

        return $scripts;
    }
    

    /**
     * 
     * Get registered styles
     *
     * @return array
     * 
     */

    public function get_styles(){
        $styles = [
            'harmony-admin' => [
                'src'   => HARMONY_ASSETS . '/css/admin.css'
            ],
            'harmony-flexslider' => [
                'src'   => HARMONY_ASSETS . '/css/flexslider.css'
            ],
            'harmony-frontend' => [
                'src'   => HARMONY_ASSETS . '/css/frontend.css'
            ]
        ];

        return $styles;
    }
}