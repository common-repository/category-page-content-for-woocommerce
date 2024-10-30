<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://shehab24.github.io/portfolio/
 * @since             1.0.0
 * @package           Category_Page_Content_For_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Category Page Content For Woocommerce
 * Plugin URI:        https://wordpress.org/plugins/category-page-content-for-woocommerce/
 * Description:       Using this plugin You can put content Woocommerce category page if that page does not have any content for SEO
 * Version:           1.0.0
 * Author:            Shehab Mahamud
 * Author URI:        https://shehab24.github.io/portfolio//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       category-page-content-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC'))
{
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('CPCFW_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-category-page-content-for-seo-activator.php
 */
function cpcfw_activate_category_page_content_for_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-woocommerce-category-page-content-for-seo-activator.php';
	CPCFWActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-category-page-content-for-seo-deactivator.php
 */
function cpcfw_deactivate_category_page_content_for_woocommerce()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-woocommerce-category-page-content-for-seo-deactivator.php';
	CPCFWDeactivator::deactivate();
}

register_activation_hook(__FILE__, 'cpcfw_activate_category_page_content_for_woocommerce');
register_deactivation_hook(__FILE__, 'cpcfw_deactivate_category_page_content_for_woocommerce');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

require plugin_dir_path(__FILE__) . 'includes/class-woocommerce-category-page-content-for-seo.php';



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */


add_action('admin_init', 'cpcfw_check_woocommerce_active');

if (!function_exists('cpcfw_check_woocommerce_active'))
{
	function cpcfw_check_woocommerce_active()
	{
		return class_exists('WooCommerce');
	}
}

add_action('plugins_loaded', 'cpcfw_check_woocommerce_status');

function cpcfw_check_woocommerce_status()
{
	if (cpcfw_check_woocommerce_active() == true)
	{
		cpcfw_run_woocommerce_category_page_content_for_seo();

	} else
	{
		echo '<div class="error"><p>Category Page Content For Woocommerce  requires WooCommerce to be installed and active. Please activate WooCommerce.</p></div>';
	}
}


function cpcfw_run_woocommerce_category_page_content_for_seo()
{

	$plugin = new CPCFWClass();
	$plugin->run();

}

