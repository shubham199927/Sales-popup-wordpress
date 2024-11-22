<?php
/*
Plugin Name: Sales Popup
Plugin URI: https://www.linkedin.com/in/webdev-shubham/
Description: A plugin to show a popup for the Buy Any Three Perfumes At 999 offer.
Version: 2.0
Author: Shubham Sharma
Author URI: https://www.instagram.com/theycallmeshubham/
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: salespopup
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Enqueue styles and scripts
function salespopup_enqueue_scripts() {
    wp_enqueue_style('salespopup-style', plugin_dir_url(__FILE__) . 'public/css/style.css');
    wp_enqueue_script('salespopup-script', plugin_dir_url(__FILE__) . 'public/js/script.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'salespopup_enqueue_scripts');

// Display the popup HTML
function salespopup_html() {
    $title = get_option('salespopup_title', 'Welcome to Our Store! 🎉');
    $content = get_option('salespopup_content', 'Buy Any Three Perfumes At 999!');
    $button_text = get_option('salespopup_button_text', 'Shop Now');
    $button_link = get_option('salespopup_button_link', '/shop');
    ?>
    <div class="popup-overlay">
        <div class="popup-container">
            <span class="popup-close">&times;</span>
            <h2 class="popup-title"><?php echo esc_html($title); ?></h2>
            <div class="popup-content">
                <p><?php echo esc_html($content); ?></p>
            </div>
            <button class="cta-button" onclick="window.location.href='<?php echo esc_url($button_link); ?>'"><?php echo esc_html($button_text); ?></button>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'salespopup_html');

// Add settings menu
function salespopup_add_admin_menu() {
    add_menu_page('Sales Popup', 'Sales Popup', 'manage_options', 'salespopup', 'salespopup_options_page');
}
add_action('admin_menu', 'salespopup_add_admin_menu');

// Register settings
function salespopup_settings_init() {
    register_setting('salespopup', 'salespopup_title');
    register_setting('salespopup', 'salespopup_content');
    register_setting('salespopup', 'salespopup_button_text');
    register_setting('salespopup', 'salespopup_button_link');

    add_settings_section(
        'salespopup_section',
        __('Popup Settings', 'salespopup'),
        null,
        'salespopup'
    );

    add_settings_field(
        'salespopup_title',
        __('Popup Title', 'salespopup'),
        'salespopup_title_render',
        'salespopup',
        'salespopup_section'
    );

    add_settings_field(
        'salespopup_content',
        __('Popup Content', 'salespopup'),
        'salespopup_content_render',
        'salespopup',
        'salespopup_section'
    );

    add_settings_field(
        'salespopup_button_text',
        __('Button Text', 'salespopup'),
        'salespopup_button_text_render',
        'salespopup',
        'salespopup_section'
    );

    add_settings_field(
        'salespopup_button_link',
        __('Button Link', 'salespopup'),
        'salespopup_button_link_render',
        'salespopup',
        'salespopup_section'
    );
}
add_action('admin_init', 'salespopup_settings_init');

// Render title input
function salespopup_title_render() {
    ?>
    <input type="text" name="salespopup_title" value="<?php echo esc_attr(get_option('salespopup_title')); ?>" />
    <?php
}

// Render content input
function salespopup_content_render() {
    ?>
    <textarea name="salespopup_content"><?php echo esc_textarea(get_option('salespopup_content')); ?></textarea>
    <?php
}

// Render button text input
function salespopup_button_text_render() {
    ?>
    <input type="text" name="salespopup_button_text" value="<?php echo esc_attr(get_option('salespopup_button_text')); ?>" />
    <?php
}

// Render button link input
function salespopup_button_link_render() {
    ?>
    <input type="text" name="salespopup_button_link" value="<?php echo esc_attr(get_option('salespopup_button_link')); ?>" />
    <?php
}

// Create settings page
function salespopup_options_page() {
    ?>
    <form action="options.php" method="post">
        <h1><?php _e('Sales Popup Settings', 'salespopup'); ?></h1>
        <?php
        settings_fields('salespopup');
        do_settings_sections('salespopup');
        submit_button();
        ?>
    </form>
    <?php
}
?>
