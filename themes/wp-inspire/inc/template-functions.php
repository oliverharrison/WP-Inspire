<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WP_Inspire
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wp_inspire_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'wp_inspire_body_classes' );

function wp_inspire_numeric_posts_nav() {

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="navigation"><ul class="paginator">' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="paginator-item">%s</li>' . "\n", get_previous_posts_link() );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $link_class = 1 == $paged ? 'paginator-itemLink is-active' : 'paginator-itemLink';

        printf( '<li class="paginator-item"><a href="%s">%s</a></li>' . "\n", esc_url( get_pagenum_link( 1 ) ), $link_class, '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li class="paginator-item">…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
		$link_class = $paged == $link ? 'paginator-itemLink is-active' : 'paginator-itemLink';
        printf( '<li class="paginator-item"><a href="%s" class="%s">%s</a></li>' . "\n", esc_url( get_pagenum_link( $link ) ), $link_class, $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li class="paginator-item">…</li>' . "\n";

		$link_class = $paged == $link ? 'paginator-itemLink is-active' : 'paginator-itemLink';
        printf( '<li class="paginator-item"><a href="%s" class="%s">%s</a></li>' . "\n", esc_url( get_pagenum_link( $max ) ), $link_class, $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li class="paginator-item">%s</li>' . "\n", get_next_posts_link() );

    echo '</ul></div>' . "\n";

}

/**
 * Update the likes for for a given inspiration.
 *
 * @author Scott Anderson <scott.anderson@webdevstudios.com>
 * @since  NEXT
 * @param array $data Options for the function.
 * @return int New Likes Count
 */
function wp_inspire_like_inspiration( $data ) : int {
	update_field( 'likes', abs( get_field( 'likes', $data['id'] ) ) + 1, $data['id'] );
	return abs( get_field( 'likes', $data['id'] ) );
}
