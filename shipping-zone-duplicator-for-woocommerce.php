<?php
namespace Shipping_Zone_Duplicator_for_WooCommerce;


/**
 * Main plugin class.
 */
class Shipping_Zone_Duplicator_For_WooCommerce {

	public $version = '1.0.1';

	public $file = __FILE__;

	private static $instance;


	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		if ( is_admin() ) {
			require_once plugin_dir_path( $this->file ) . 'includes/admin/admin-functions.php';
		}
	}


	/**
	 * Instance.
	 *
	 * An global instance of the class. Used to retrieve the instance
	 * to use on other files/plugins/themes.
	 *
	 * @since 1.0.0
	 *
	 * @return  object Instance of the class.
	 */
	public static  function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

/**
 * The main function responsible for returning the Shipping_Zone_Duplicator_For_WooCommerce object.
 *
 * Use this function like you would a global variable, except without needing to declare the global.
 *
 * Example: <?php Shipping_Zone_Duplicator_For_WooCommerce()->method_name(); ?>
 *
 * @since 1.0.0
 *
 * @return Shipping_Zone_Duplicator_For_WooCommerce Return the singleton Shipping_Zone_Duplicator_For_WooCommerce object.
 */
function Shipping_Zone_Duplicator_For_WooCommerce() {
	return Shipping_Zone_Duplicator_For_WooCommerce::instance();
}
add_action( 'admin_init', '\Shipping_Zone_Duplicator_for_WooCommerce\Shipping_Zone_Duplicator_For_WooCommerce', 5 );
