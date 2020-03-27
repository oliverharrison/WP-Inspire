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

	<section class="inspirations-block row">
	<?php while ( $inspirations->have_posts() ) : $inspirations->the_post(); ?>

		<?php
			$insp_link = get_field( 'link' );
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'inspiration col-sm-4' ); ?>>

			<div class="card">
				<div class="card-shadow"></div>
				<main class="post-body">

					<?php wp_inspire_post_thumbnail(); ?>
					<?php wp_inspire_entry_body(); ?>

				</main><!-- .entry-body -->

				<footer class="post-footer">
					<?php the_title( '<h2 class="inspiration-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
					<?php if ( $insp_link ) : ?>
						<a href="<?php echo esc_url( $insp_link['url'] ); ?>" class="link-out" target="_blank"><span class="icon icon-link"><?php echo esc_html( preg_replace( '#^https?://#', '', rtrim( $insp_link['url'], '/' ) ) ); ?></span></a>
					<?php endif; ?>

				</footer><!-- .entry-footer -->

			</div><!-- .card -->

		</article><!-- #post-<?php the_ID(); ?> .inspiration.col-sm-4 -->

	<?php endwhile; ?>

	<?php
	if (  $inspirations->max_num_pages > 1 ) :
		wp_inspire_numeric_posts_nav();
	endif;
	?>
	</section><!-- .inspirations-block.row -->

<?php
endif;
wp_reset_postdata();
?>

</div><!-- .container -->
