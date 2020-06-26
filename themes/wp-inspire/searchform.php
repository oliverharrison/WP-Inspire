<?php
/**
 * The template for displaying the search form.
 *
 * @package Ventura County Coast
 */

// Make sure our search forms have unique IDs in the event more than 1 is on a page.
$random_identifier = wp_rand();
?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="search-field-<?php echo esc_attr( $random_identifier ); ?>">
		<span class="screen-reader-text"><?php esc_html_e( 'To search this site, enter a search term', 'wp_inspire' ); ?></span>
		<span class="input"><input class="search-field" id="search-field-<?php echo esc_attr( $random_identifier ); ?>" type="text" name="s" value="<?php echo get_search_query(); ?>" aria-required="false" autocomplete="off" placeholder="<?php echo esc_attr_e( 'Search', 'wp_inspire' ); ?>" /></span>
	</label>
	<button type="submit" id="search-submit" class="button button-search" aria-label="<?php esc_attr_e( 'Submit search', 'wp_inspire' ); ?>">Search</button>
</form>
