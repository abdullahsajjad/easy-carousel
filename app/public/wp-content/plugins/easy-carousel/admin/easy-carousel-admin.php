<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       allmarketingsolutions.co.uk
 * @since      1.0.0
 *
 * @package    Easy_Carousel
 * @subpackage Easy_Carousel/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 *
 * @package    Easy_Carousel
 * @subpackage Easy_Carousel/admin
 * @author     AMS <btltimes39@gmail.com>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * enqueuing admin scripts
 */
function ec_admin_scripts()
{

    wp_register_style(
        'ec-admin-style',
        plugin_dir_url(__FILE__) . 'css/ec-admin-style.css',
        [],
        EASY_CAROUSEL_VERSION,
        false
    );
    wp_enqueue_style('ec-admin-style');
}

add_action('admin_enqueue_scripts', 'ec_admin_scripts');

function ec_register_carousel_post_type()
{

    $labels = array(
        'name' => 'Easy Carousel',
        'singular_name' => 'Easy carousel',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New carousel',
        'edit_item' => 'Edit carousel',
        'new_item' => 'New carousel',
        'all_items' => 'All carousel',
        'view_item' => 'View carousel',
        'search_items' => 'Search carousel',
        'not_found' => 'No carousel found',
        'not_found_in_trash' => 'No carousel found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Easy Carousel'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'easy-carousel'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-align-center'
    );

    register_post_type('easy_carousel', $args);

}

add_action('init', 'ec_register_carousel_post_type');

//var_dump(rtrim(plugin_dir_path( __FILE__ ),'/' ). '\includes\multi-post-thumbnails.php');

require_once plugin_dir_path(__FILE__) . 'multi-post-thumbnails.php';

function add_mobile_image_metabox()
{
    if (class_exists('MultiPostThumbnails')) {
        new MultiPostThumbnails(array(
                'label' => 'Mobile Feature Image',
                'id' => 'mobile-feature-image',
                'post_type' => 'easy_carousel'
            )
        );
    }
}

/**
 * Adding Link metabox to CPT
 *
 */
function add_link_metabox()
{
    add_meta_box(
        'linkto',           // Unique ID
        'link to',  // Box title
        'linkto_callback',  // Content callback, must be of type callable
        'easy_carousel'                 // Post type
    );
}

add_action('add_meta_boxes', 'add_link_metabox');


/**
 * Save data in link metabox
 * @param $post_id
 */
function save_linkto_metabox_data($post_id)
{
    //checking user permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) return;
    } else {
        if (!current_user_can('edit_post', $post_id)) return;
    }
    $link = sanitize_text_field($_POST['linkto']);
    update_post_meta($post_id, 'linkto_slide', $link);
}

add_action('save_post', 'save_linkto_metabox_data');


/**
 * callback function for link meta box
 * @param $post
 */
function linkto_callback($post)
{
    $value = get_post_meta($post->ID, 'linkto_slide', true);
    ?>
    <div class="easy-carousel-link">
        <input style="width:100%;" type="text" class="slide-link" name="linkto" placeholder="Link Slide To"
               value="<?php echo $value; ?>">
    </div>
    <?php
}