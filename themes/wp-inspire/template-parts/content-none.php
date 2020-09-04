<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Inspire
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'wp_inspire' ); ?></h2>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_front_page() ) :
			?>

			<p><?php esc_html_e( 'Sorry, but no inspirations matched your filters. Please clear your filters or try a search below.', 'wp_inspire' ); ?></p>

			<a href="<?php echo home_url(); ?>" class="button clear-filters"><?php esc_html_e( 'Clear the filters', 'wp_inspire' ); ?></a>

			<?php
			get_search_form();

		elseif ( is_search() ) :
			?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'wp_inspire' ); ?></p>
			<?php
			get_search_form();

		else :
			?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wp_inspire' ); ?></p>
			<?php
			// get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
