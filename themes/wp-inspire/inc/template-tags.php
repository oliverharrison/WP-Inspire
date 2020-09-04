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
									'fill' => ($inspiration_likes / 255) * 100,
								)
							);
						?>
						<span class="inspiration-likes"><?php echo $inspiration_likes; ?></span>
					</button>
				</div>
			</div>

			<?php wp_inspire_display_taxonomies(); ?>

		</div><!-- .card-content -->
		<?php
	}
endif;

if ( ! function_exists( 'wp_inspire_display_taxonomies' ) ) :
	/**
	 * Displays a list of an Inspiration's taxonomies.
	 */
	function wp_inspire_display_taxonomies() {

		get_the_terms( get_the_ID(), 'color' ) ? $taxonomies['Colors'] = get_the_terms( get_the_ID(), 'color' ) : null;
		get_the_terms( get_the_ID(), 'style' ) ? $taxonomies['Styles'] = get_the_terms( get_the_ID(), 'style' ) : null;
		get_the_terms( get_the_ID(), 'industry' ) ? $taxonomies['Industries'] = get_the_terms( get_the_ID(), 'industry' ) : null;
		get_the_terms( get_the_ID(), 'post_tag' ) ? $taxonomies['Tags'] = get_the_terms( get_the_ID(), 'post_tag' ) : null;

		if ( $taxonomies ) :
		?>

			<?php if ( is_single() ) : ?>
				<div class="col-md-8">
			<?php endif; ?>

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

			<?php if ( is_single() ) : ?>
				</div>
			<?php endif; ?>

		<?php
		endif;
	}
endif;

if ( ! function_exists( 'wp_inspire_display_inspiration_logo' ) ) :
	/**
	 * Displays an Inspiration's logo.
	 */
	function wp_inspire_display_inspiration_logo() {
		$inspiration_logo = get_field( 'logo' );

		if ( $inspiration_logo ) :
			?>
			<div class="col-md-4">
				<?php echo wp_get_attachment_image( $inspiration_logo, 'medium' ); ?>
			</div>
			<?php
		endif;
	}
endif;

/**
 * Displays an inspiration's thumbnail.
 */
function wp_inspire_post_thumbnail( $class = null ) {
	$classname = 'inspire-thumb' ? 'inspire-thumb ' . $class : 'inspire-thumb';

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
		?>

		<div class="post-thumbnail col">
			<?php
				$single_thumbnail = get_field( 'single_image' );
				if ( is_single() && $single_thumbnail ) :
					echo wp_get_attachment_image( $single_thumbnail, 'extra_large' );
				else :
					the_post_thumbnail( 'extra_large', array( 'class' => $classname ) );
				endif;
			?>
		</div><!-- .post-thumbnail -->

	<?php elseif ( is_search() ) : ?>

		<div class="post-thumbnail col col-lg-3 col-md-4">
			<?php
				$single_thumbnail = get_field( 'single_image', get_the_ID() ) ?: ( get_field( 'logo', get_the_ID() ) ?: get_post_thumbnail_id() );
				echo wp_get_attachment_image( $single_thumbnail, 'extra_large' );
				?>
		</div><!-- .post-thumbnail -->

	<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'extra_large', array(
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
			<img src="<?php echo get_theme_file_uri( '/assets/img/heart.svg' ); ?>" alt="" class="icon-heart" />
		</span>
		<img src="<?php echo get_theme_file_uri( '/assets/img/heart-outline.svg' ); ?>" alt="" class="icon-heart" />
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
 * Function to build the taxonomy filters for an inspirations wp_query.
 *
 * @return array $tax_query Array containing the taxonomy filters.
 * @author Oliver Harrison oliver@positivebias.com
 * @since 2020-06-26
 * @package WP Inspire
 */
function wp_inspire_inspiration_tax_query() {
	/**
	 * You MUST use $_GET and NOT register public query_vars for the following.
	 * More info here: https://core.trac.wordpress.org/ticket/25143
	 */
	if ( ! $_GET['filter_industry'] && ! $_GET['filter_style'] && ! $_GET['filter_color'] && ! $_GET['filter_plugins'] ) {
		return;
	}

	$tax_query = array( 'relation' => 'AND' );

	$custom_query_vars = array(
		'industry' => filter_input ( INPUT_GET, 'filter_industry', FILTER_SANITIZE_STRING ),
		'style'    => filter_input ( INPUT_GET, 'filter_style', FILTER_SANITIZE_STRING ),
		'color'    => filter_input ( INPUT_GET, 'filter_color', FILTER_SANITIZE_STRING ),
		'plugins'  => filter_input ( INPUT_GET, 'filter_plugins', FILTER_SANITIZE_STRING ),
	);

	foreach ( $custom_query_vars as $tax_key => $query_var ) {
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

/**
 * Redirect Inspirations to front-page.php
 */
function wp_inspire_inspiration_redirect( $template ) {
    if ( get_query_var( 'filter_industry' ) || get_query_var( 'filter_style' ) || get_query_var( 'filter_color' ) ) {
        // return locate_template( 'front-page.php' );
    }
    return $template;
}
add_filter( 'template_include', 'wp_inspire_inspiration_redirect' );

/**
 * Display the Insipirations filters
 */
function wp_inspire_display_inspirations_filters() {

	// Get the terms for the filters.
	$inspiration_industries = get_terms(
		array(
			'taxonomy'   => 'industry',
			'hide_empty' => false,
		)
	);
	$inspiration_styles = get_terms(
		array(
			'taxonomy'   => 'style',
			'hide_empty' => false,
		)
	);
	$inspiration_colors = get_terms(
		array(
			'taxonomy'   => 'color',
			'hide_empty' => false,
		)
	);
	$inspiration_plugins = get_terms(
		array(
			'taxonomy'   => 'plugins',
			'hide_empty' => false,
		)
	);

	$custom_query_vars = array(
		'industry' => filter_input ( INPUT_GET, 'filter_industry', FILTER_SANITIZE_STRING ),
		'style'    => filter_input ( INPUT_GET, 'filter_style', FILTER_SANITIZE_STRING ),
		'color'    => filter_input ( INPUT_GET, 'filter_color', FILTER_SANITIZE_STRING ),
		'plugins'  => filter_input ( INPUT_GET, 'filter_plugins', FILTER_SANITIZE_STRING ),
	);
	?>
	<section class="inspirations-filters">
		<div class="filters-block">
			<h3 class="inspirations-filters-title">Filter the inspirations: </h3>
			<span class="select">
				<select class="inspiration-industry-filters">
					<option class="inspiration-industry" value=""><?php esc_html_e( 'Industries', 'wp_inspire' ); ?></option>
					<?php
					foreach ( $inspiration_industries as $key => $inspiration_industry ) :
						?>
						<option class="inspiration-industry" value="<?php echo esc_attr( $inspiration_industry->slug ); ?>"<?php echo $inspiration_industry->slug === $custom_query_vars['industry'] ? esc_attr( ' selected' ) : ''; ?>><?php echo esc_html( $inspiration_industry->name ); ?></option>
						<?php
					endforeach;
					?>
				</select>
			</span>

			<span class="select">
				<select class="inspiration-style-filters">
					<option class="inspiration-style" value=""><?php esc_html_e( 'Styles', 'wp_inspire' ); ?></option>
					<?php
					foreach ( $inspiration_styles as $key => $inspiration_style ) :
						?>
						<option class="inspiration-style" value="<?php echo esc_attr( $inspiration_style->slug ); ?>"<?php echo $inspiration_style->slug === $custom_query_vars['style'] ? esc_attr( ' selected' ) : ''; ?>><?php echo esc_html( $inspiration_style->name ); ?></option>
						<?php
					endforeach;
					?>
				</select>
			</span>

			<span class="select">
				<select class="inspiration-color-filters">
					<option class="inspiration-color" value=""><?php esc_html_e( 'Colors', 'wp_inspire' ); ?></option>
					<?php
					foreach ( $inspiration_colors as $key => $inspiration_color ) :
						?>
						<option class="inspiration-color" value="<?php echo esc_attr( $inspiration_color->slug ); ?>"<?php echo $inspiration_color->slug === $custom_query_vars['color'] ? esc_attr( ' selected' ) : ''; ?>><?php echo esc_html( $inspiration_color->name ); ?></option>
						<?php
					endforeach;
					?>
				</select>
			</span>

			<span class="select">
				<select class="inspiration-plugins-filters">
					<option class="inspiration-plugins" value=""><?php esc_html_e( 'Plugins', 'wp_inspire' ); ?></option>
					<?php
					foreach ( $inspiration_plugins as $key => $inspiration_plugin ) :
						?>
						<option class="inspiration-plugin" value="<?php echo esc_attr( $inspiration_plugin->slug ); ?>"<?php echo $inspiration_plugin->slug === $custom_query_vars['plugins'] ? esc_attr( ' selected' ) : ''; ?>><?php echo esc_html( $inspiration_plugin->name ); ?></option>
						<?php
					endforeach;
					?>
				</select>
			</span>
		</div>
		<?php
		if ( $custom_query_vars['industry'] || $custom_query_vars['style'] || $custom_query_vars['color'] || $custom_query_vars['plugins'] ) :
			?>
			<div class="filters-active">
				<h3 class="inspirations-filters-title">Active filters: </h3>
				<?php
				foreach ( $custom_query_vars as $key => $query_var ) {
					if ( empty( $query_var ) ) {
						continue;
					}

					$name = get_term_by( 'slug', $query_var, $key )->name;
					echo wp_kses_post( '<span class="filter-delete">' . ucwords( $key ) . ': <a href="' . esc_url( remove_query_arg( 'filter_' . $key ) ) . '">' . $name . ' <sup>&times;</sup></a></span>' );
				}
				?>
				<span class="filters-clear"><a class="clear-filters" href="<?php echo get_home_url(); ?>"><?php esc_html_e( 'Clear filters', 'wp_inspire' ); ?></a></span>
			</div>
			<?php
		endif;
		?>
	</section><!-- .inspirations-filters -->
	<?php
}
