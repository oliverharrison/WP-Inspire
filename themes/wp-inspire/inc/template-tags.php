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
		$inspiration_link  = get_field( 'link' );
		$inspiration_likes = get_field( 'likes' );
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
					<button class="like-this" data-id="<?php echo esc_attr( get_the_ID() ); ?>">
						<?php
							wp_inspire_display_heart(
								array(
									'icon' => 'heart-outline',
									'fill' => ($inspiration_likes / 255) * 100,
								)
							);
						?>
						<span class="inspiration-likes"><?php echo $inspiration_likes; ?></span>
					</button>
				</div>
			</div>

			<?php
			get_the_terms( $post_id, 'color' ) ? $taxonomies['Colors'] = get_the_terms( $post_id, 'color' ) : null;
			get_the_terms( $post_id, 'style' ) ? $taxonomies['Styles'] = get_the_terms( $post_id, 'style' ) : null;
			get_the_terms( $post_id, 'industry' ) ? $taxonomies['Industries'] = get_the_terms( $post_id, 'industry' ) : null;
			get_the_terms( $post_id, 'post_tag' ) ? $taxonomies['Tags'] = get_the_terms( $post_id, 'post_tag' ) : null;
			?>

			<?php if ( $taxonomies ) : ?>

				<div class="taxonomies-wrap">

					<?php foreach ( $taxonomies as $name => $taxonomy ) : ?>

						<?php if ( $taxonomy ) : ?>

						<div class="taxonomy-wrap taxonomy-<?php echo esc_attr( strtolower($name) ); ?>">
							<span class="taxonomy-title"><?php echo esc_attr( $name ); ?></span>
							<ul class="taxonomy-list list-<?php echo esc_attr( strtolower( $name ) ); ?>">
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

			<?php endif; ?>

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
 * Display heart SVG markup.
 *
 * @param array $args The parameters needed to display the SVG.
 * @author Oliver Harrison oliver@positivebias.com
 * @return string
 */
function wp_inspire_display_heart( $args = array() ) {

	if ( ! $args ) {
		return;
	}

	$defaults = array(
		'fill' => '',
	);

	$args = wp_parse_args( $args, $defaults );
	if ($args['fill']) {
		$args['fill'] = (int) $args['fill'];
	}
	?>
	<span class="icon">
		<span class="icon-fill" style="<?php echo 'opacity:' . $args['fill'] . '%;' ?>">
			<?php echo file_get_contents( get_theme_file_uri( '/assets/img/heart.svg' ) ); ?>
		</span>
		<?php echo file_get_contents( get_theme_file_uri( '/assets/img/' . esc_html( $args['icon'] ) . '.svg' ) ); ?>
	</span>
	<?php
}


/**
 * Create Alternate Logo Setting and Upload Control; add description for Primary Logo.
 *
 * @author Oliver Harrison oliver@positivebias.com
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
				'description' => esc_html__( 'Upload an alternate logo which will display in the footer.', 'wp_inspire' ),
				'label'       => esc_html__( 'Alternate Logo', 'wp_inspire' ),
				'section'     => 'title_tagline',
				'settings'    => 'wp_inspire_alternate_logo',
			)
		)
	);
}
add_action( 'customize_register', 'wp_inspire_customize_logos' );


/**
 * Custom Query Vars for the Inspiration filters.
 *
 * @param array $query_vars WP Public Query vars.
 * @author Oliver Harrison oliver@positivebias.com
 * @return array $query_vars Updated WP Public Query vars.
 * @since 2020-06-26
 */
function wp_inspire_updated_query_vars( $query_vars ) {
	$query_vars[] = 'filter_industry';
	$query_vars[] = 'filter_style';
	$query_vars[] = 'filter_color';
	return $query_vars;
}
add_filter( 'query_vars', 'wp_inspire_updated_query_vars' );


/**
 * Function to build the taxonomy filters for an inspirations wp_query.
 *
 * @return array $tax_query Array containing the taxonomy filters.
 * @author Oliver Harrison oliver@positivebias.com
 * @since 2020-06-26
 * @package WP Inspire
 */
function wp_inspire_inspiration_tax_query() {
	if ( ! get_query_var( 'industry' ) && ! get_query_var( 'style' ) && ! get_query_var( 'color' ) ) {
		return;
	}

	$tax_query = array( 'relation' => 'AND' );

	$query_vars = array(
		'industry' => esc_html( get_query_var( 'filter_industry' ) ),
		'style'    => esc_html( get_query_var( 'filter_style' ) ),
		'color'    => esc_html( get_query_var( 'filter_color' ) ),
	);

	foreach ( $query_vars as $tax_key => $query_var ) {
		if ( empty( $query_var ) ) {
			continue;
		}

		$tax_query[] = array(
			'taxonomy' => $tax_key,
			'field'    => 'slug',
			'terms'    => $query_var,
		);
	}

	return $tax_query;
}
