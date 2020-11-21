<?php
/**
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              allmarketingsolutions.co.uk
 * @since             1.0.0
 * @package           Easy_Carousel
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Carousel
 * Plugin URI:        #
 * Description:       Simple Owl Carousel.
 * Version:           1.0.0
 * Author:            AMS
 * Author URI:        allmarketingsolutions.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       easy-carousel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Rename this for your plugin and update it as you release new versions.
 */
define('EASY_CAROUSEL_VERSION', '1.0.0');


/**
 * The code that runs during plugin activation.
 */
function activate_easy_carousel()
{
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_easy_carousel()
{
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'activate_easy_carousel');
register_deactivation_hook(__FILE__, 'deactivate_easy_carousel');

/**
 * requiring assets
 */

require_once plugin_dir_path(__FILE__) . 'admin/easy-carousel-admin.php';

/**
 * adding seprate metabox for mobile image
 */
add_mobile_image_metabox();

/**
 * changing featured image metabox title
 */

function ec_change_featured_image_metabox_title()
{
    remove_meta_box('postimagediv', 'easy_carousel', 'side');
    add_meta_box('postimagediv', __('Desktop Feature Image', 'ec'), 'post_thumbnail_meta_box', 'easy_carousel', 'side');
}

add_action('do_meta_boxes', 'ec_change_featured_image_metabox_title');


require_once plugin_dir_path(__FILE__) . 'public/easy-carousel-public.php';


