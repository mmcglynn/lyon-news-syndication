<?php
function ls_sample_shortcode() {
    return showPosts(23);
}

add_shortcode('ls_news','ls_sample_shortcode');

// Define constants
define(DOMAIN, 'http://technicalwhining.com/');
define(API_VERSION, '/wp-json/wp/v2/');

function showPosts($id = 0) {

	// Start timer
	$time_start = microtime(true);

	$image_path =
	$posts_string = '';

	try {

		//$json = file_get_contents($domain . $version . 'posts/?filter[category_name]=hardware&status=publish');

		$response = wp_remote_get(DOMAIN . API_VERSION . 'posts/?filter[cat]=' . $id . '&status=publish');

		// Why can't wp_remote_retrieve_body() be assigned to a variable?
		$posts = json_decode(wp_remote_retrieve_body($response), true);
	}
	catch (Exception $e)
	{
		echo 'Exception caught: ' . $e->getMessage() . "\n";
	}

	echo '<p>There are ' . count($posts) . ' posts that match.</p>';

	$posts_string .= '<section class="syndicated_content">';

	if (count($posts) > 0) {

		foreach ($posts as $post) {

			/* */
			if ($post['featured_media'] > 0){

				echo $post['featured_media'];
				//$image_path = getFeaturedImage($post['featured_media']);
				//$posts_string .= '<img src="' . $image_path . '" />';
			}


			$posts_string .= '<h3>' . $post['title']['rendered'] . '</h3>';
			$posts_string .= $post['excerpt']['rendered'];

		}
	}  else {
		$posts_string .= 'There is no data to display';
	}

	$posts_string .= '</section>';

	// End timer
	$time_end = microtime(true);

	//dividing with 60 will give the execution time in minutes other wise seconds
	$execution_time = (($time_end - $time_start)/60)/60;

	//execution time of the script
	$posts_string .= 'Total execution time : ' . round((microtime(true) - $time_start),4) . ' seconds.';

	echo $posts_string;
}

function getFeaturedImage($id = 0, $size = 'thumbnail') {

	$attachment	=
	$source 	=
	$height 	=
	$width 		= '';

	try {

		$response = wp_remote_get(DOMAIN . API_VERSION . 'media/?include=' . $id);

		// Why can't wp_remote_retrieve_body() be assigned to a variable?
		$image = json_decode(wp_remote_retrieve_body($response), true);

	}
	catch (Exception $e)
	{
		echo 'Exception caught: ' . $e->getMessage() . "\n";
	}

	// Get the node that matches the size
	$node = $image[0]['media_details']['sizes'][$size];

	$src 	= $node['source_url'];
	$height = $node['height'];
	$width 	= $node['width'];

	$attachment = '<img src="' . $src . '" width="' . $width . '" height="' . $height . '" />';

	return $attachment;
}