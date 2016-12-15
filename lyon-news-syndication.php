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
			'description' => 'Configure and display syndicated content.',
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
	//public function form( $instance ) {
		// outputs the options form on admin
	//}


	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="category">Category</label>
			<!-- This really needs to be populated by Ajaz -->
			<!-- <select class="category_list"></select> -->
		<?php buildCategories() ?>
		</p>
		<p>
			<label for="display_type">Display Type</label>
			<select id="display_type">
				<option value="1">Title only</option>
				<option value="2">Excerpt</option>
				<option value="3">Excerpt w/ thumbnail</option>
				<option value="3">Full post</option>
			</select>
		</p>
		<p>
			<label for="total_results">Number of results</label>
			<select id="total_results">
				<option value="1">1</option>
				<option value="3">3</option>
				<option value="5">5</option>
				<option value="10">10</option>
			</select>
		</p>
		<p>
			<button>Preview Selection</button>
		</p>
		<p>
			<input type="submit" title="Submit" value="SUBMIT" />
		</p>
		<?php
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


function buildCategories() {

	// REST API request
	// 50 is the current max, and assuming the list is flat
	$response = wp_remote_get(API_DOMAIN . API_VERSION . 'categories/?per_page=50&hide_empty=1');

	echo $response;

	// Get HTTP response code
	$response_code = wp_remote_retrieve_response_code( $response );

	$categories_string = 'Category display failed with HTTP response code: ' . $response_code;

	if ( $response_code == 200 ) {

		// Why can't wp_remote_retrieve_body() be assigned to a variable?
		$categories = json_decode(wp_remote_retrieve_body($response), true);

		if (count($categories) > 0) {

			// Debug
			// echo $categories[0]['id'];
			// count($categories);

			$categories_string = '<select><option value="">-- Select One --</option>';

			foreach ($categories as $cat) {
				$categories_string .= '<option value="' . $cat['id'] . '">' . $cat['name'] . ' (' . $cat['count'] . ')' . '</option>';
			}

			$categories_string .= '</select>';

		}
	}

	echo $categories_string;
}