<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Inspire
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			wp_inspire_posted_on();
			wp_inspire_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="row">
		<?php wp_inspire_post_thumbnail(); ?>

		<div class="entry-summary col">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
