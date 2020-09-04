<?php
/**
 * The main template file for the home page
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Inspire
 */

get_header();
?>

<div id="primary" class="content-area">

	<main id="main" class="site-main">

		<div class="container">
			<?php
				$post_object = get_post( get_option('page_on_front') );
				echo wp_kses_post( '<div class="fp-content">' . $post_object->post_content . '</div>' );
			?>
		</div><!-- .container -->
		<?php

		// Inspirations custom Query.
		// Add Type or Region Query Vars to the query.
		$inspirations_args = array(
			'post_type' => 'inspiration',
			'paged' => $paged
		);

		$tax_query = wp_inspire_inspiration_tax_query();

		if ( $tax_query ) {
			$inspirations_args['tax_query'] = $tax_query;
		}

		$inspirations = new WP_Query( $inspirations_args );
		?>

		<div class="inspirations-bg">

			<div class="container">

				<?php wp_inspire_display_inspirations_filters(); ?>

				<?php
				if ( $inspirations->have_posts() ) :
					?>
					<section class="inspirations-block row">

						<?php
						while ( $inspirations->have_posts() ) : $inspirations->the_post();

							get_template_part( 'template-parts/content', 'inspirations' );
						endwhile;
						?>

					</section><!-- .inspirations-block.row -->
					<?php

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;

				wp_reset_postdata();
				?>

			</div><!-- .container -->

		</div><!-- .inspirations-bg -->

	</main><!-- #main -->

</div><!-- #primary -->

<?php
get_footer();
