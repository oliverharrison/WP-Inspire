<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Inspire
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp_inspire' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container header-wrap">
			<div class="row">
				<div class="site-branding col-md-3">
					<?php the_custom_logo(); ?>
				</div><!-- .site-branding -->
				<div class="col-md-9">

					<nav id="site-navigation" class="main-navigation">
						<?php
						wp_nav_menu( array(
							'theme_location' => 'main-menu',
							'menu_id'        => 'primary-menu',
							'container'      => '',
						) );
						?>
					</nav><!-- #site-navigation -->

				</div><!-- .col-md-9 -->
			</div><!-- .row -->
		</div><!-- .container -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
