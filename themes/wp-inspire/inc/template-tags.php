<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WP_Inspire
 */

if ( ! function_exists( 'wp_inspire_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function wp_inspire_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'wp_inspire' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'wp_inspire_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function wp_inspire_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'wp_inspire' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'wp_inspire_entry_body' ) ) :
	/**
	 * Prints HTML with meta information for the inspiration
	 */
	function wp_inspire_entry_body() {
		$inspiration_link = get_field( 'link' );
		?>
		<div class="card-content">
			<div class="card-meta">
				<div class="card-links">
					<div class="internal-link">
						<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
							<img class="icon icon-info" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/info.svg' ); ?>" alt="Info icon" />
							<?php esc_html_e( 'More Info', 'wp_inspire' ); ?>
						</a>
					</div>
					<div class="external-link">
						<a href="<?php echo esc_url( $inspiration_link['url'] ); ?>" class="link-out" target="_blank">
							<img class="icon icon-link" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/link.svg' ); ?>" alt="Link out icon" />
							<?php echo esc_html( $inspiration_link['title'] ); ?>
						</a>
					</div>
				</div>
				<div class="card-heart">
					<a href="#" class="like-this">
						<img class="icon icon-heart" src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/heart.svg' ); ?>" alt="Heart icon" />
						<span class="inspiration-likes">122</span>
					</a>
				</div>
			</div>

			<?php
			$tags       = get_the_terms( $post_id, 'post_tag' );
			$industries = get_the_terms( $post_id, 'industry' );
			$styles     = get_the_terms( $post_id, 'style' );
			$colors     = get_the_terms( $post_id, 'color' );
			$taxonomies = [ 'Colors' => $colors, 'Styles' => $styles, 'Industries' => $industries, 'Tags' => $tags ];
			?>

			<div class="taxonomies-wrap">

				<?php foreach ( $taxonomies as $name => $taxonomy ) : ?>
					<?php if ( $taxonomy ) : ?>
					<div class="taxonomy-<?php echo esc_attr( strtolower($name) ); ?>">
						<!-- <h3 class="taxonomy-title"><?php echo $name; ?></h3> -->
						<?php  ?>
						<?php $list_class = ' list-' . strtolower( $name ); ?>
						<ul class="taxonomy-list<?php echo esc_attr( $list_class ); ?>">
							<?php foreach ( $taxonomy as $taxonomy_item ) : ?>
								<?php
									$color_bg   = 'Colors' === $name ? ' bg-tax-' . $taxonomy_item->slug : '';
									$color_text	= 'Colors' === $name ? ' color-tax-' . $taxonomy_item->slug : '';
								?>
								<li class="taxonomy-item<?php echo esc_attr( $color_bg ); ?>"><a class="taxonomy-link<?php echo esc_attr( $color_text ); ?>" href="<?php echo get_term_link( $taxonomy_item ); ?>"><?php echo $taxonomy_item->name; ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>
				<?php endforeach; ?>

			</div><!-- .taxonomies-wrap -->

		</div><!-- .card-content -->
		<?php
	}
endif;

if ( ! function_exists( 'wp_inspire_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function wp_inspire_post_thumbnail( $class = null ) {
		$classname = 'inspire-thumb' ? 'inspire-thumb ' . $class : 'inspire-thumb';

		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'medium_large', array( 'class' => $classname ) ); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail( 'post-thumbnail', array(
					'alt' => the_title_attribute( array(
						'echo' => false,
					) ),
					'class' => $classname
				) );
				?>
			</a>

		<?php
		endif; // End is_singular().
	}
endif;



/**
 * Create Alternate Logo Setting and Upload Control; add description for Primary Logo.
 *
 * @author Oliver Harrison
 * @param object $wp_customize Instance of WP_Customize_Class.
 */
function wp_inspire_customize_logos( $wp_customize ) {
	// Add a setting for an alternate logo that displays in the sticky nav.
	$wp_customize->add_setting(
		'wp_inspire_alternate_logo',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url',
		)
	);

	// Add a control to upload the Alternate Logo.
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'wp_inspire_alternate_logo',
			array(
				'description' => esc_html__( 'Upload an alternate logo which will display in the footer. The dimensions should be 418x106 pixels if using a PNG image or 209x53 pixels if using an SVG image.', 'dell-foundation' ),
				'label'       => esc_html__( 'Alternate Logo', 'dell-foundation' ),
				'section'     => 'title_tagline',
				'settings'    => 'wp_inspire_alternate_logo',
			)
		)
	);
}
add_action( 'customize_register', 'wp_inspire_customize_logos' );
