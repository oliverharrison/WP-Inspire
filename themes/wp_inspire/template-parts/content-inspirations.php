<?php
/**
 * Template part for Inspirations
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Inspire
 */

$inspirations = new WP_Query(
	array(
		'post_type' => 'inspiration',
		'paged' => $paged
	)
);
?>

<div class="container">

<?php if ( $inspirations->have_posts() ) : ?>

	<section class="inspirations-block">

	<?php while ( $inspirations->have_posts() ) : $inspirations->the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'inspiration' ); ?>>
			<header class="entry-header">
				<?php the_title( '<h2 class="inspiration-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			<?php wp_inspire_post_thumbnail(); ?>

			<div class="entry-content">
				<?php
				the_content( sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'wp_inspire' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				) );
				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php wp_inspire_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</article><!-- #post-<?php the_ID(); ?> -->

	<?php endwhile; ?>

	<?php
	if (  $inspirations->max_num_pages > 1 ) :
		wp_inspire_numeric_posts_nav();
	endif;
	?>

	</section><!-- .inspirations-block -->

<?php
endif;
wp_reset_postdata();
?>

</div><!-- .container -->
