<?php
/**
 * The main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Inspire
 */

if ( ! is_active_sidebar( 'widgets-footer' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'widgets-footer' ); ?>
</aside><!-- #secondary -->
