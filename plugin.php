<?php
/**
 * Plugin Name:  Shipping Zone Duplicator for WooCommerce
 * Plugin URI:   https://wordpress.org/plugins/shipping-zone-duplicator-for-woocommerce/
 * Description:  A simple plugin to add duplication functionality for shipping zones and rates.
 * Version:      1.0.2
 * Author:       Jeroen Sormani
 * Author URI:   https://jeroensormani.com
 * Text Domain:  shipping-zone-duplicator-for-woocommerce
 */

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/**
 * Display PHP 7 required notice.
 *
 * Display a notice when the required PHP version is not met.
 *
 * @since 1.0.0
 */
function szdwc_php_version_notices() {
	?><div class='updated'>
		<p><?php echo sprintf( __( 'Shipping Zone Duplicator for WooCommerce requires PHP 7 or higher and your current PHP version is %s. Please (contact your host to) update your PHP version.', 'shipping-zone-duplicator-for-woocommerce' ), PHP_VERSION ); ?></p>
	</div><?php
}

if ( version_compare( PHP_VERSION, '7', 'lt' ) ) {
	add_action( 'admin_notices', 'szdwc_php_version_notices' );
	return;
}


// Check if required plugins are active
require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	return;
}

require 'shipping-zone-duplicator-for-woocommerce.php';
