<?php
/**
 * Modules Loader
 *
 * @package Beaver Builder Modules
 */

/**
 * Initial Setup
 *
 * @since x.x.x
 */
class Cartflows_BB_Modules_Loader {

	/**
	 * Member Variable
	 *
	 * @var object instance
	 */
	private static $instance;

	/**
	 *  Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor function that initializes required actions and hooks
	 */
	public function __construct() {

		add_action( 'wp', array( $this, 'init' ), 8 );

	}

	/**
	 * Function that initializes init function
	 *
	 * @since x.x.x
	 */
	public function init() {
		$this->include_modules_files();
	}

	/**
	 * Returns Script array.
	 *
	 * @return array()
	 * @since x.x.x
	 */
	public static function get_module_list() {

		$widget_list = array(
			'cartflows-bb-next-step',
			'cartflows-bb-order-details',
			'cartflows-bb-checkout-form',
			'cartflows-bb-optin-form',
		);

		return $widget_list;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since x.x.x
	 * @access public
	 */
	public function include_modules_files() {

		global $post;

		if ( ! isset( $post ) ) {
			return;
		}

		$post_type = $post->post_type;

		if ( 'cartflows_step' === $post_type && class_exists( 'FLBuilder' ) ) {

			/* Required files */
			require_once CARTFLOWS_DIR . 'modules/beaver-builder/classes/class-cartflows-bb-editor.php';

			include_once CARTFLOWS_DIR . 'modules/beaver-builder/classes/class-cartflows-bb-helper.php';

			$widget_list = $this->get_module_list();

			if ( ! empty( $widget_list ) ) {
				foreach ( $widget_list as $widget ) {

					include_once CARTFLOWS_DIR . 'modules/beaver-builder/' . $widget . '/' . $widget . '.php';
				}
			}
		}
	}
}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Cartflows_BB_Modules_Loader::get_instance();
