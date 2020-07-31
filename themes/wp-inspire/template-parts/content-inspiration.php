<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WP_Inspire
 */

?>
<div class="container">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php
					wp_inspire_posted_on();
					wp_inspire_posted_by();
					?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
        </header><!-- .entry-header -->

        <div class="row">
            <?php wp_inspire_display_inspiration_logo(); ?>
            <?php wp_inspire_display_taxonomies(); ?>
        </div>

        <div class="row">
		    <?php wp_inspire_post_thumbnail(); ?>
        </div>

        <div class="row">
            <div class="entry-content col">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp_inspire' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div><!-- .entry-content -->
        </div>
	</article><!-- #post-<?php the_ID(); ?> -->

</div><!-- .container -->
