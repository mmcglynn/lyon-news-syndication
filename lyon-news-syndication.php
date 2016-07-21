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

add_action( 'wp_head', 'ln_list_news' );

function ln_list_news() {
    echo "<script> //This is a list of news </script>\n";
}



class My_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'my_widget',
			'description' => 'My Widget is awesome',
		);
		parent::__construct( 'my_widget', 'My Widget', $widget_ops );
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
	register_widget( 'My_Widget' );
});

function ls_admin_enqueue_scripts() {
    // Needs condtion - on widget screen and (if possible) 
    // widget is active.
    $wp_enqueue_style('ls-admin-css',plugin_url('css/ls-admin.css'),__FILE__);
    $wp_enqueue_script('ls-admin-script',plugin_url('js/ls-admin.js'),__FILE__);
}

add_action('admin_enqueue_scripts', 'ls_admin_enqueue_scripts');

