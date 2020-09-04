<?php
/**
 * Template part for Inspirations
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Inspire
 */
?>

<?php $inspiration_link = get_field( 'link' ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'inspiration col-md-6 col-lg-4' ); ?>><!--  -->

	<div class="card">
		<div class="card-shadow"></div>
		<main class="post-body">

			<?php wp_inspire_post_thumbnail(); ?>
			<?php wp_inspire_entry_body(); ?>

		</main><!-- .entry-body -->

		<footer class="post-footer">
			<?php the_title( '<h2 class="inspiration-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<?php if ( $inspiration_link ) : ?>
				<a href="<?php echo esc_url( $inspiration_link['url'] ); ?>" class="link-out" target="_blank"><span class="icon icon-link"><?php echo esc_html( $inspiration_link['title'] ); ?></span></a>
			<?php endif; ?>
		</footer><!-- .entry-footer -->

	</div><!-- .card -->

</article><!-- #post-<?php the_ID(); ?> .inspiration.col-sm-4 -->
