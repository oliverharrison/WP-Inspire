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

$inspiration_industries = get_terms(
	array(
		'taxonomy'   => 'industry',
		'hide_empty' => true,
	)
);

$inspiration_styles = get_terms(
	array(
		'taxonomy'   => 'style',
		'hide_empty' => true,
	)
);

$inspiration_colors = get_terms(
	array(
		'taxonomy'   => 'color',
		'hide_empty' => true,
	)
);

$query_vars = array(
	'region' => esc_html( get_query_var( 'region' ) ),
	'type'   => esc_html( get_query_var( 'type' ) ),
	'search' => esc_html( get_query_var( 'search' ) ),
);
?>

<div class="inspirations-bg">

	<div class="container">

		<?php if ( $inspirations->have_posts() ) : ?>

			<section class="inspirations-filters">

				<select class="inspiration-industy-filters">
					<option class="inspiration-industry" value=""><?php esc_html_e( 'Industries', 'wp_inspire' ); ?></option>
					<?php
					foreach ( $inspiration_industries as $key => $inspiration_industry ) :
						?>
						<option class="listings-region" value="<?php echo esc_attr( $inspiration_industry->slug ); ?>"<?php echo $inspiration_industry->slug === $query_vars['industry'] ? esc_attr( ' selected' ) : ''; ?>><?php echo esc_html( $inspiration_industry->name ); ?></option>
						<?php
					endforeach;
					?>
				</select>

				<select class="inspiration-style-filters">
					<option class="inspiration-style" value=""><?php esc_html_e( 'Styles', 'wp_inspire' ); ?></option>
					<?php
					foreach ( $inspiration_styles as $key => $inspiration_style ) :
						?>
						<option class="inspiration-style" value="<?php echo esc_attr( $inspiration_style->slug ); ?>"<?php echo $inspiration_style->slug === $query_vars['style'] ? esc_attr( ' selected' ) : ''; ?>><?php echo esc_html( $inspiration_style->name ); ?></option>
						<?php
					endforeach;
					?>
				</select>

				<select class="inspiration-color-filters">
					<option class="inspiration-color" value=""><?php esc_html_e( 'Colors', 'wp_inspire' ); ?></option>
					<?php
					foreach ( $inspiration_colors as $key => $inspiration_color ) :
						?>
						<option class="listings-region" value="<?php echo esc_attr( $inspiration_color->slug ); ?>"<?php echo $inspiration_color->slug === $query_vars['color'] ? esc_attr( ' selected' ) : ''; ?>><?php echo esc_html( $inspiration_color->name ); ?></option>
						<?php
					endforeach;
					?>
				</select>

			</section><!-- .inspiration-filters -->

			<section class="inspirations-block row">
				<?php while ( $inspirations->have_posts() ) : $inspirations->the_post(); ?>

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

</div><!-- .inspirations-bg -->
