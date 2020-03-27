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

		<!-- TODO insert site description -->

		<?php get_template_part( 'template-parts/content', 'inspirations' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
