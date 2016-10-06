<?php
/*
Plugin Name: Lyon News Syndication
Plugin URI:  https://github.com/mmcglynn/lyon-news-syndication
Description: Pulls configured content into a widget.
Version:     0.1
Author:      Michael McGlynn
Author URI:  http://reignitioninc.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: lyon-news-syndication
*/

// Exit is accessed directly
if (!defined('ABSPATH')) {
    exit;
}

require_once (plugin_dir_path(__FILE__) . 'shortcodes.php');

add_action( 'wp_head', 'ln_list_news' );

function ln_list_news() {
    echo "<script> //This is a list of news </script>\n";
}



class LS_News_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'ls_news_widget',
			'description' => 'My Widget is awesome',
		);
		parent::__construct( 'ls_news__widget', 'Lyon News', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'LS_News_Widget' );
});

add_action('admin_enqueue_scripts', 'ls_admin_enqueue_scripts');

function ls_admin_enqueue_scripts() {
    // Needs condtion - on widget screen and (if possible) widget is active.
    wp_enqueue_style('ls-admin-css', plugins_url(' css/ls-admin.css'), __FILE__);
    wp_enqueue_script('ls-admin-script', plugins_url('js/ls-admin.js'),__FILE__);
}



