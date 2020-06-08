<?php
/**
 * Register Inspiration Likes Endpoint
 *
 * @author Scott Anderson <scott.anderson@webdevstudios.com>
 * @since  NEXT
 */
add_action( 'rest_api_init', function() {
	register_rest_route(
        'inspire/v1',
        '/like/(?P<id>\d+)',
        array(
            'methods'  => 'POST',
            'callback' => 'wp_inspire_like_inspiration',
        )
    );
} );
