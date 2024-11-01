<?php
namespace Shipping_Zone_Duplicator_for_WooCommerce\Admin;

use WC_Shipping_Method;
use WC_Shipping_Zone;
use WC_Shipping_Zones;
use function Shipping_Zone_Duplicator_for_WooCommerce\Shipping_Zone_Duplicator_For_WooCommerce;


/**
 * Enqueue scripts.
 *
 * Enqueue script as javascript and style sheets.
 *
 * @since  1.0.0
 */
function admin_enqueue_scripts() {
	wp_register_script( 'shipping-zone-duplicator-for-woocommerce', plugins_url( 'assets/admin/js/main.js', Shipping_Zone_Duplicator_For_WooCommerce()->file ), array( 'jquery' ), Shipping_Zone_Duplicator_For_WooCommerce()->version );

	wp_localize_script( 'shipping-zone-duplicator-for-woocommerce', 'szdwc', array(
		'i18n' => array(
			'duplicate' => __( 'Duplicate', 'woocommerce' ),
		)
	) );

	if ( isset( $_GET['page'], $_GET['tab'] ) && $_GET['page'] == 'wc-settings' && $_GET['tab'] == 'shipping' ) {
		wp_enqueue_script( 'shipping-zone-duplicator-for-woocommerce' );
	}
}

add_action( 'admin_enqueue_scripts', 'Shipping_Zone_Duplicator_for_WooCommerce\Admin\admin_enqueue_scripts' );


/**
 * Duplicate zone action.
 *
 * Check if the duplicate zone action is being performed.
 *
 * @since 1.0.0
 */
function check_duplicate_zone_action() {

	// Check action
	if ( ! isset( $_GET['action'] ) || $_GET['action'] != 'duplicate-zone' ) {
		return;
	}

	// Check permissions
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}

	$zone_id = absint( $_GET['zone-id'] );

	// Get zone that is getting duplicated
	$dup = WC_Shipping_Zones::get_zone( absint( $zone_id ) );

	// Create new zone
	$zone = new WC_Shipping_Zone();
	$zone->set_zone_name( $dup->get_zone_name() . ' (' . __( 'duplicate', 'woocommerce' ) . ')' );

	// Set locations
	$locations = array_map( function( $i ) { return (array) $i; }, $dup->get_zone_locations() );
	$zone->set_locations( $locations );

	/** @var WC_Shipping_Method[] $methods */
	$methods = $dup->get_shipping_methods();

	// Loop through all methods and duplicate them.
	foreach ( $methods as $k => $m ) {
		$instance_id    = $zone->add_shipping_method( $m->id );
		$m->instance_id = $instance_id;

		update_option( $m->get_instance_option_key(), $m->instance_settings, 'yes' );
	}

	wp_safe_redirect( wp_get_referer() );
}
add_action( 'admin_init', '\Shipping_Zone_Duplicator_for_WooCommerce\Admin\check_duplicate_zone_action' );


/**
 * Duplicate method action.
 *
 * Check if the duplicate method action is being performed.
 *
 * @since 1.0.0
 */
function check_duplicate_method_action() {

	// Check action
	if ( ! isset( $_GET['action'], $_GET['instance-id'] ) || $_GET['action'] != 'duplicate-method' ) {
		return;
	}

	// Check permissions
	if ( ! current_user_can( 'manage_woocommerce' ) ) {
		return;
	}

	$method_id = absint( $_GET['instance-id'] );

	// Method to duplicate
	$dup = WC_Shipping_Zones::get_shipping_method( absint( $method_id ) );

	// Set title
	$dup->instance_settings['title'] = $dup->title .= ' (' . __( 'duplicate', 'woocommerce' ) . ')';

	// Get the zone
	$zone = WC_Shipping_Zones::get_zone_by( 'instance_id', $method_id );

	// Add the rate to the zone
	if ( $zone ) {
		$instance_id      = $zone->add_shipping_method( $dup->id );
		$dup->instance_id = $instance_id;

		update_option( $dup->get_instance_option_key(), $dup->instance_settings, 'yes' );
	}

	wp_safe_redirect( wp_get_referer() );
}
add_action( 'admin_init', '\Shipping_Zone_Duplicator_for_WooCommerce\Admin\check_duplicate_method_action' );
