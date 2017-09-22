<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Foursites Dashboard
 *
 * @wordpress-plugin
 * Plugin Name:       Foursites Dashboard
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Foursites Client Dash Plugin
 * Version:           1.0.0
 * Author:            Foursites
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Foursites Dashboard
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_foursites_dashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-foursites-dashboard-activator.php';
	Foursites_Dashboard_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_foursites_dashboard() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-foursites-dashboard-deactivator.php';
	Foursites_Dashboard_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_foursites_dashboard' );
register_deactivation_hook( __FILE__, 'deactivate_foursites_dashboard' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-foursites_dashboard.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_foursites_dashboard() {

	$plugin = new Foursites_Dashboard();
	$plugin->run();

}
run_foursites_dashboard();
