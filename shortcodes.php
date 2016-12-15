<?php
function ls_sample_shortcode() {
    return syndicated_content();
	//return showPosts(12);
}

add_shortcode('ls_news','ls_sample_shortcode');


// Testing Transients
function syndicated_content() {

	// Do we have this information in our transients already?
	$transient = get_transient( 'syndicated_content' );

	// Yep!  Just return it and we're done.
	if( ! empty( $transient ) ) {

		// The function will return here every time after the first time it is run, until the transient expires.
		return $transient;

		// Nope!  We gotta make a call.
	} else {

		// We got this url from the documentation for the remote API.
		//$url = 'https://api.example.com/v4/subscribers';

		// We are structuring these args based on the API docs as well.
		//$args = array(
		//	'headers' => array(
		//		'token' => 'example_token'
		//	),
		//);

		// Call the API.
		//$out = wp_remote_get( $url, $args );

		$out = showPosts(12);

		// Save the API response so we don't have to call again until tomorrow.
		set_transient( 'css_t_subscribers', $out, DAY_IN_SECONDS );

		// Return the list of subscribers.  The function will return here the first time it is run, and then once again, each time the transient expires.
		return $out;

	}

}



/**
 * Show the posts
 *
 * @param int $id The category ID
 */
function showPosts($id = 0) {

	// REST API request
	$response = wp_remote_get(API_DOMAIN . API_VERSION . 'posts/?filter[cat]=' . $id . '&status=publish');

	// Get HTTP response code
	$response_code = wp_remote_retrieve_response_code( $response );

	// Start timer
	$time_start = microtime(true);

	$image_path = '';

	$posts_string = '<p>Sorry the request failed with HTTP response code: ' . $response_code . '</p>';

	if( $response_code == 200 ) {

		$posts_string = '<section class="syndicated_content">';

		// Why can't wp_remote_retrieve_body() be assigned to a variable?
		$posts = json_decode(wp_remote_retrieve_body($response), true);

		if (count($posts) > 0) {

			$posts_string .= '<p>There are ' . count($posts) . ' posts that match this query.</p>';

			foreach ($posts as $post) {

				// Debug
				//echo $post['featured_media'];

				$posts_string .= '<h3>' . $post['title']['rendered'] . '</h3>';

				if ($post['featured_media'] > 0){
					$posts_string .= getFeaturedImage($post['featured_media']);
				}

				$posts_string .= $post['excerpt']['rendered'];

			}

		}

		$posts_string .= '</section>';
	}

	// End timer
	$time_end = microtime(true);

	//dividing with 60 will give the execution time in minutes other wise seconds
	$execution_time = (($time_end - $time_start)/60)/60;

	//execution time of the script
	$posts_string .= 'Total execution time : ' . round((microtime(true) - $time_start),4) . ' seconds.';

	echo $posts_string;
}

function getFeaturedImage($id = 0, $size = 'thumbnail') {

	// REST API request
	$response = wp_remote_get(API_DOMAIN . API_VERSION . 'media/?include=' . $id);

	$response_code = wp_remote_retrieve_response_code( $response );

	$attachment	= $source = $height = $width = '';

	if( $response_code == 200 ) {

		// Why can't wp_remote_retrieve_body() be assigned to a variable?
		$image = json_decode(wp_remote_retrieve_body($response), true);

		// Get the node that matches the size
		$node = $image[0]['media_details']['sizes'][$size];

		$src 	= $node['source_url'];
		$height = $node['height'];
		$width 	= $node['width'];

		$attachment = '<img src="' . $src . '" width="' . $width . '" height="' . $height . '" />';

	}

	return $attachment;
}