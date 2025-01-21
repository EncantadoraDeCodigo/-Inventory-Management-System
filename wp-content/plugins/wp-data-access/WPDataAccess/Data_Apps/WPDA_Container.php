<?php

namespace WPDataAccess\Data_Apps;

use WPDataAccess\API\WPDA_API_Core;
use WPDataAccess\WPDA;
abstract class WPDA_Container {
    private $feedback = false;

    private $fullscreen = false;

    protected $builders = true;

    protected $filter_field_name = null;

    protected $filter_field_value = null;

    protected $shortcode_args = null;

    public function __construct( $args = array(), $shortcode_args = array() ) {
        if ( isset( $args['feedback'] ) ) {
            $this->feedback = true === $args['feedback'] || 'true' === $args['feedback'];
        }
        if ( isset( $shortcode_args['fullscreen'] ) ) {
            $this->fullscreen = true === $shortcode_args['fullscreen'] || 'true' === $shortcode_args['fullscreen'];
        }
        if ( isset( $args['filter_field_name'] ) ) {
            $this->filter_field_name = WPDA_API_Core::sanitize_db_identifier( $args['filter_field_name'] );
        }
        if ( isset( $args['filter_field_value'] ) ) {
            $this->filter_field_value = sanitize_text_field( $args['filter_field_value'] );
        }
        $this->shortcode_args = $shortcode_args;
        wp_enqueue_style( 'wpda_apps' );
        wp_enqueue_media();
    }

    protected function add_client() {
        $mainjs = 'main-' . WPDA::get_option( WPDA::OPTION_WPDA_CLIENT_VERSION ) . '.js';
        $script_path = plugin_dir_url( __DIR__ ) . "../assets/dist/";
        $script_url = "{$script_path}/{$mainjs}";
        $app_site = wpda_freemius()->get_site();
        unset($app_site->public_key);
        unset($app_site->secret_key);
        $app_licenses = wpda_freemius()->get_available_premium_licenses();
        if ( is_array( $app_licenses ) ) {
            for ($i = 0; $i < count( $app_licenses ); $i++) {
                unset($app_licenses[$i]->secret_key);
            }
        }
        ?>

			<script>
				window.PP_APP_CONFIG = {
					appDebug: <?php 
        echo ( 'on' === WPDA::get_option( WPDA::OPTION_PLUGIN_DEBUG ) ? 'true' : 'false' );
        ?>,
					appLocales: "<?php 
        echo esc_url( $script_path ) . 'locales/';
        ?>",
					appSite: <?php 
        echo json_encode( $app_site, true );
        ?>,
					appLicenses: <?php 
        echo json_encode( array(
            'license' => $app_licenses,
            'local'   => wpda_freemius()->can_use_premium_code__premium_only(),
        ), true );
        ?>,
					appTarget: "<?php 
        echo ( is_admin() ? 'backend' : 'frontend' );
        ?>",
					appIp: "<?php 
        echo esc_attr( $_SERVER['REMOTE_ADDR'] );
        ?>",
					appUser:  "<?php 
        echo esc_attr( WPDA::get_current_user_login() );
        ?>",
					appRoles: <?php 
        echo ( false === $this->builders ? json_encode( array() ) : json_encode( WPDA::get_current_user_roles() ) );
        ?>,
					appLogin: <?php 
        echo ( 'anonymous' !== WPDA::get_current_user_login() ? 'true' : 'false' );
        ?>,
					appVars: <?php 
        echo json_encode( $_POST, true );
        ?>,
					appFullscreen: <?php 
        echo ( $this->fullscreen ? 'true' : 'false' );
        ?>,
				}
			</script>
			<script type="module" src="<?php 
        echo esc_attr( $script_url );
        ?>"></script>

			<?php 
    }

    protected function send_feedback() {
        return $this->feedback;
    }

    protected function show_feedback( $feedback ) {
        ?>
			<div style="padding: 30px 0">
				<div style="font-weight: normal; margin-bottom: 5px">
					WP Data Access error in shortcode<?php 
        echo esc_attr( $this->get_shortcode_from_class() );
        ?>:
				</div>

				<div style="font-weight: bold; color: #d32f2f">
					<?php 
        echo esc_html( $feedback );
        ?>
				</div>
			</div>
			<?php 
    }

    private function get_shortcode_from_class() {
        if ( strpos( get_class( $this ), 'WPDA_App_Container' ) !== false ) {
            return ' wpda_app';
        } elseif ( strpos( get_class( $this ), 'WPDA_Apps_List' ) !== false ) {
            return ' wpda_apps';
        } elseif ( strpos( get_class( $this ), 'WPDA_Explorer_Container' ) !== false ) {
            return ' wpda_data_explorer';
        }
        return '';
    }

}
