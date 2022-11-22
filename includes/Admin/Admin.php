<?php
namespace Harmony;

/**
 * Admin Pages Handler
 */
class Admin {

    public function __construct() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        add_action( 'admin_menu', [ $this, 'harmony_settings_menu' ] );

        //activating harmony settings
        add_action( 'admin_init', [ $this, 'harmony_options' ] );
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'harmony-admin' );
        wp_enqueue_script( 'harmony-admin' );

        wp_set_script_translations( 'harmony-admin', 'harmony', plugin_dir_path( __FILE__ ) . 'languages' );
    }

    public function harmony_settings_menu(){
        add_submenu_page( 'woocommerce', __( 'Harmony Settings', 'harmony' ), __( 'Harmony', 'harmony' ), 'manage_options', 'harmony', [ $this, 'harmony_settings' ] );
    }

    public function harmony_settings(){
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php echo get_admin_page_title() ?></h1>
            <?php settings_errors(); ?>
            <div class="harmony-settings">
                <h2 class="harmony-settings-tab">
                    <a href="#harmony-woocommerce" class="harmony-settings-tablinks harmony_active">
                        <?php esc_html_e( 'WooCommerce Settings', 'harmony' ); ?>
                    </a>
                    <?php if( harmony()->has_dokan() ): ?>
                        <a href="#harmony-dokan" class="harmony-settings-tablinks">
                            <?php esc_html_e( 'Dokan Settings', 'harmony' ) ?>
                        </a>
                    <?php endif; ?>
                </h2>

                <div class="harmony-settings-tab-content">
                    <div class="form-wrapper harmony_active" id="harmony-woocommerce">
                        <form method="post" action="options.php">
                            <?php
                                settings_fields( 'harmony-woocommerce' );
                                do_settings_sections( 'harmony-woocommerce' );                        
                                submit_button();
                            ?>
                        </form>
                    </div>
                <?php if( harmony()->has_dokan() ): ?>
                    <div class="form-wrapper" id="harmony-dokan">
                        <form method="post" action="options.php">
                            <?php
                                settings_fields( 'harmony-dokan' );
                                do_settings_sections( 'harmony-dokan' );                        
                                submit_button();
                            ?>
                        </form>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    }   

    public function harmony_options(){
        //Settings Sections
        add_settings_section( 'harmony-woocommerce', __( 'WooCommerce Settings', 'harmony' ), '', 'harmony-woocommerce' );

        if( harmony()->has_dokan() ){
            add_settings_section( 'harmony-dokan', __( 'Dokan Settings', 'harmony' ), '', 'harmony-dokan' );
        }

        //WC Settings Fields
        add_settings_field( 'disable_wc_video', __( 'Disable Video', 'harmony' ), [ $this, 'disable_wc_video_checkbox' ], 'harmony-woocommerce', 'harmony-woocommerce' );
        add_settings_field( 'disable_wc_audio', __( 'Disable Audio', 'harmony' ), [ $this, 'disable_wc_audio_checkbox' ], 'harmony-woocommerce', 'harmony-woocommerce' );

        //Dokan Settings Fields
        if( harmony()->has_dokan() ){
            add_settings_field( 'disable_dk_video_field', __( 'Disable Video Field', 'harmony' ), [ $this, 'disable_dk_video_field_checkbox' ], 'harmony-dokan', 'harmony-dokan' );
            add_settings_field( 'disable_dk_audio_field', __( 'Disable Audio Field', 'harmony' ), [ $this, 'disable_dk_audio_field_checkbox' ], 'harmony-dokan', 'harmony-dokan' );
        }

        //WC Register Settings
        register_setting( 'harmony-woocommerce', 'disable_wc_video' );
        register_setting( 'harmony-woocommerce', 'disable_wc_audio' );

        //Dokan Register Settings
        if( harmony()->has_dokan() ){
            register_setting( 'harmony-dokan', 'disable_dk_video_field' );
            register_setting( 'harmony-dokan', 'disable_dk_audio_field' );
        }
    }

    public function disable_wc_video_checkbox(){
        $disable_wc_video = get_option( 'disable_wc_video' );
        ?>
        <label for="disable-wc-video">
            <input type="checkbox" name="disable_wc_video" id="disable-wc-video" <?php checked( $disable_wc_video, 'on' ) ?>>
            <?php esc_html_e( 'Disable Harmony Video Content', 'harmony' ); ?>
        </label>
        <?php
    }
    
    public function disable_wc_audio_checkbox(){
        $disable_wc_audio = get_option( 'disable_wc_audio' );
        ?>
        <label for="disable-wc-audio">
            <input type="checkbox" name="disable_wc_audio" id="disable-wc-audio" <?php checked( $disable_wc_audio, 'on' ) ?>>
            <?php esc_html_e( 'Disable Harmony Audio Content', 'harmony' ); ?>
        </label>
        <?php
    }
    
    public function disable_dk_video_field_checkbox(){
        $disable_dk_video_field = get_option( 'disable_dk_video_field' );
        ?>
        <label for="disable-dk-video-field">
            <input type="checkbox" name="disable_dk_video_field" id="disable-dk-video-field" <?php checked( $disable_dk_video_field, 'on' ) ?>>
            <?php esc_html_e( 'Disable Video Content Field for Vendors', 'harmony' ); ?>
        </label>
        <?php
    }

    public function disable_dk_audio_field_checkbox(){
        $disable_dk_audio_field = get_option( 'disable_dk_audio_field' );
        ?>
        <label for="disable-dk-audio-field">
            <input type="checkbox" name="disable_dk_audio_field" id="disable-dk-audio-field" <?php checked( $disable_dk_audio_field, 'on' ) ?>>
            <?php esc_html_e( 'Disable Audio Content Field for Vendors', 'harmony' ); ?>
        </label>
        <?php
    }

}