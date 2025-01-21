<?php

namespace WPDataAccess\Data_Apps {

	use WPDataAccess\Plugin_Table_Models\WPDA_App_Model;
	use WPDataAccess\WPDA;

	class WPDA_App_Container extends WPDA_Container {

		private $app_id = '';

		public function __construct( $args = array(), $shortcode_args = array() ) {

			parent::__construct( $args, $shortcode_args );

			if ( isset( $args['app_id'] ) ) {
				$this->app_id = $args['app_id'];
			}

			if (
				isset( $args['builders'] ) &&
				(
					false === $args['builders'] ||
					'false' === $args['builders']
				)
			) {
				$this->builders = false;
			}

		}

		public function show() {

			$app = WPDA_App_Model::get_by_id( $this->app_id );
			if ( false === $app ) {
				if ( ! $this->send_feedback() ) {
					return;
				}

				$this->show_feedback( __( 'Invalid app id', 'wp-data-access' ) );
				return;
			}

			if ( ! $this->user_can_access( $app ) ) {
				if ( ! $this->send_feedback() ) {
					return;
				}

				$this->show_feedback( __( 'Not authorized', 'wp-data-access' ) );
				return;
			}

			?>

			<div class="wpda-pp-container">
				<div
					class="pp-container-app"
					data-source="{ 'id': '<?php echo $this->app_id; ?>' }"

					<?php
					if ( null !== $this->filter_field_name && null !== $this->filter_field_value ) {
						?>
						data-filter_field_name="<?php echo $this->filter_field_name; ?>"
						data-filter_field_value="<?php echo $this->filter_field_value; ?>"
						<?php
					}

					if ( 0 < count( $this->shortcode_args ) ) {
						?>
						data-shortcode_field_name="<?php echo implode( ',', array_keys( $this->shortcode_args ) ); ?>"
						data-shortcode_field_value="<?php echo implode( ',', array_values( $this->shortcode_args ) ); ?>"
						<?php
					}
					?>
				></div>
			</div>

			<?php

			$this->add_client();

		}

		private function user_can_access( $app ) {

			if ( ! isset ( $app[0]['app_settings'] ) ) {
				return false;
			}

			// Check access
			$app_settings_db = $app[0]['app_settings'];
			$app_settings    = json_decode( (string) $app_settings_db, true );
			if (
				! isset(
					$app_settings['rest_api']['authorization'],
					$app_settings['rest_api']['authorized_roles'],
					$app_settings['rest_api']['authorized_users']
				) ||
				! is_array( $app_settings['rest_api']['authorized_roles'] ) ||
				! is_array( $app_settings['rest_api']['authorized_users'] )
			) {
				// App contain no rest api settings
				return false;
			}

			if (
				! WPDA::current_user_is_admin() &&
				'anonymous' !== $app_settings['rest_api']['authorization']
			) {
				// Check authorization
				// Check user role
				$user_roles = WPDA::get_current_user_roles();
				if (
					! is_array( $user_roles ) ||
					empty(
						array_intersect(
							$app_settings['rest_api']['authorized_roles'],
							$user_roles
						)
					)
				) {
					// Check user login
					$user_login = WPDA::get_current_user_login();
					if ( ! in_array( $user_login, $app_settings['rest_api']['authorized_users'] ) ) {
						return false;
					}
				}
			}

			// Anonymous access
			return true;

		}

	}

}