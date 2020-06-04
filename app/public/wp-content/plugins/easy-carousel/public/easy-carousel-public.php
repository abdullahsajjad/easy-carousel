<?php
/**
 * The public-specific functionality of the plugin.
 *
 * @link       allmarketingsolutions.co.uk
 * @since      1.0.0
 *
 * @package    Easy_Carousel
 * @subpackage Easy_Carousel/public
 */

/**
 * The public-specific functionality of the plugin.
 *
 *
 * @package    Easy_Carousel
 * @subpackage Easy_Carousel/public
 * @author     AMS <btltimes39@gmail.com>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * public enqueue scripts
 */
function ec_public_scripts()
{

    wp_register_script(
        'ec-carousel-js',
        plugin_dir_url(__FILE__) . 'js/owl-carousel-min.js',
        array('jquery'),
        EASY_CAROUSEL_VERSION,
        true
    );

    wp_register_style(
        'ec-carousel-css',
        plugin_dir_url(__FILE__) . 'css/owl-carousel-min.css',
        array(),
        EASY_CAROUSEL_VERSION,
        False
    );

    wp_register_script(
        'ec-public-js',
        plugin_dir_url(__FILE__) . 'js/public-main.js',
        ['jquery'],
        EASY_CAROUSEL_VERSION,
        true
    );

    wp_register_style(
        'ec-stylesheet',
        plugin_dir_url(__FILE__) . 'css/ec-stylesheet.css',
        [],
        EASY_CAROUSEL_VERSION,
        false
    );

    wp_enqueue_script('ec-carousel-js');
    wp_enqueue_style('ec-carousel-css');
    wp_enqueue_script('ec-public-js');
    wp_enqueue_style('ec-stylesheet');
}

add_action('wp_enqueue_scripts', 'ec_public_scripts');


/**
 * Creating Shortcode to display slider
 * @return string
 */

function ec_create_shortcode()
{
    $mobile=false;
    if(!class_exists('Mobile_Detect'))
    {
        require_once plugin_dir_path(__FILE__).'includes/Mobile_Detect.php';
        $detect= new Mobile_Detect();
        if ( $detect->isMobile() ) {
            $mobile=true;
        }
    }

    $args = [
        'posts_per_page' => -1,
        'post_type' => 'easy_carousel'
    ];
    $query = new WP_Query($args);
    $html = '<div class="owl-carousel home-owl-slider desktop-v-10">';
    while ($query->have_posts()) {
        $query->the_post();
        $linkto = get_post_meta(get_the_ID(), 'linkto_slide', true) ? 1 : $linkto = 'javascript:void(0)';
        $html .= '
            <a class="item" href="' . $linkto . '">';
        if($mobile)
        {
            if (class_exists('MultiPostThumbnails')) :

                $mobile_image=MultiPostThumbnails::get_the_post_thumbnail(get_post_type(), 'mobile-feature-image');
                if($mobile_image)
                {
                    $html .= $mobile_image;
                }
                else{
                    $html .= get_the_post_thumbnail();
                }

            endif;
        }
        else{
            $html.=get_the_post_thumbnail();
        }
        if (get_the_content()) {
            $html .= '<div class="captions-drali-st"><h2>' . get_the_content() . '</h2>
			<span class="slider-button">Learn More</span></div>';
        }
        $html .= '</a>';
    }
    $html .= '</div>';
    return $html;
}

add_shortcode('easy_carousel', 'ec_create_shortcode');