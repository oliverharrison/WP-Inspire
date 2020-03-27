<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Inspire
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="site-branding">
				<?php
					// Grab alternate logo from options.
					$alternate_logo = get_theme_mod( 'wp_inspire_alternate_logo' );

					if ( $alternate_logo ) :
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php echo esc_url( $alternate_logo ); ?>" alt="<?php echo esc_html_e( 'WP Inspire white logo', 'wp_inspire' ); ?>" class="alternate-logo" />
				</a>
				<?php endif; ?>
			</div><!-- .site-branding -->
		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
