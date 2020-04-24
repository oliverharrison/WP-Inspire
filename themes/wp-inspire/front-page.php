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

		<header>
			<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
		</header>

		<div class="container">
			<?php
				$post_object = get_post( get_option('page_on_front') );
				echo wp_kses_post( '<div class="fp-content">' . $post_object->post_content . '</div>' );
			?>
		</div>

		<!-- TODO insert site description -->
		<?php get_template_part( 'template-parts/content', 'inspirations' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
