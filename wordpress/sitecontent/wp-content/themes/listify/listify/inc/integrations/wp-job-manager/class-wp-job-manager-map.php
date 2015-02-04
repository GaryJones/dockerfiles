<?php

class Listify_WP_Job_Manager_Map extends listify_Integration {

	public function __construct() {
		$this->includes = array();
		$this->integration = 'wp-job-manager';

		parent::__construct();
	}

	public function display() {
		$display = listify_theme_mod( 'listing-archive-output');

		return in_array( $display, array( 'map', 'map-results' ) );
	}

	public function position() {
		return listify_theme_mod( 'listing-archive-map-position' );
	}

	public function setup_actions() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );

		if ( ! get_option( 'job_manager_regions_filter' ) ) {
			add_filter( 'get_job_listings_location_post_ids_sql', array( $this, 'apply_proximity_filter' ) );
			add_filter( 'job_manager_get_listings_custom_filter', '__return_true' );
			add_filter( 'job_manager_get_listings_custom_filter_text', array( $this, 'job_manager_get_listings_custom_filter_text' ) );

			add_action( 'job_manager_job_filters_search_jobs_end', array( $this, 'job_manager_job_filters_distance' ), 0 );
		}

		// add the view switcher
		add_action( 'listify_map_before', array( $this, 'view_switcher' ) );

		// output the map
		add_action( 'listify_output_map', array( $this, 'output_map' ) );
	}

	public function page_needs_map( $force = false ) {
		if ( $force ) {
			return $force;
		}

		$needs = false;

		if ( listify_is_job_manager_archive() ) {
			$needs = true;
		}

		if ( is_singular( 'job_listing' ) ) {
			$needs = true;
		}
		
		// always load when relisting/previewing just in case
		if ( ( isset( $_GET[ 'step' ] ) && 'preview' == $_GET[ 'step' ] ) || isset( $_POST[
		'job_manager_form' ] ) ) {
			$needs = true;
		}

		if ( is_page_template( 'page-templates/template-home.php' ) ) {
			$needs = true;
		}

		if ( apply_filters( 'listify_page_needs_map', false ) ) {
			$needs = true;
		}

		if ( ! $this->display() ) {
			$needs = false;
		}

		return $needs;
	}

	public function enqueue_scripts( $force = false ) {
		if ( ! $this->page_needs_map( $force ) ) {
			return;
		}

		wp_enqueue_script( 'google-maps', '//maps.googleapis.com/maps/api/js?v=3&libraries=geometry,places' );
		wp_enqueue_script( 'listify-job-manager-map', Listify_Integration::get_url() . 'js/wp-job-manager-map.min.js',
		array( 'jquery', 'jquery-ui-slider', 'google-maps', 'underscore' ), 20141204 );

		$settings = array(
			'facetwp' => listify_has_integration( 'facetwp' ),
			'canvas' => 'job_listings-map-canvas',
			'useClusters' => listify_theme_mod( 'map-behavior-clusters' ),
			'gridSize' => listify_theme_mod( 'map-behavior-grid-size' ),
			'autoFit' => listify_theme_mod( 'map-behavior-autofit' ),
			'mapOptions' => array(
				'zoom' => listify_theme_mod( 'map-behavior-zoom' ),
				'maxZoom' => listify_theme_mod( 'map-behavior-max-zoom' )
			),
			'searchRadius' => array(
				'min' => listify_theme_mod( 'map-behavior-search-min' ),
				'max' => listify_theme_mod( 'map-behavior-search-max' )
			)
		);

		if ( '' != ( $center = listify_theme_mod( 'map-behavior-center' ) ) ) {
			$settings[ 'mapOptions'][ 'center' ] = $center;
		}

		wp_localize_script( 'listify-job-manager-map', 'listifyMapSettings', apply_filters( 'listify_map_settings', $settings ) );
	}

	public function body_class( $classes ) {
		global $post;

		if (
			listify_is_job_manager_archive() &&
			'side' == $this->position() &&
			$this->display() &&
			! (
				is_page_template( 'page-templates/template-home.php' ) ||
				is_page_template( 'page-templates/template-full-width-blank.php' )
			) &&
			! ( has_shortcode( $post->post_content, 'jobs' ) )
		) {
			$classes[] = 'fixed-map';
		}

		return $classes;
	}

	public function output_map() {
		if ( ! $this->page_needs_map() ) {
			return;
		}

		locate_template( array( 'content-job_listing-map.php' ), true );
	}

	public function view_switcher() {
	?>
		<div class="archive-job_listing-toggle-wrapper container">
			<div class="archive-job_listing-toggle-inner views">
				<a href="#" class="archive-job_listing-toggle active" data-toggle=".content-area"><?php _e( 'Results', 'listify' ); ?></a><a href="#" class="archive-job_listing-toggle" data-toggle=".job_listings-map-wrapper"><?php _e( 'Map', 'listify' ); ?></a>
			</div>
		</div>
	<?php
	}

	public function job_manager_job_filters_distance() {
		$forced_location = isset( $_GET[ 'search_location' ] );
	?>
		<div class="search-radius-wrapper<?php echo $forced_location ? ' in-use' : ''; ?>">
			<div class="search-radius-label">
				<label for="use_search_radius">
					<input type="checkbox" name="use_search_radius" id="use_search_radius" />
					<?php _e( 'Radius: <span class="radi">50</span> mi', 'listify' ); ?>
				</label>
			</div>
			<div class="search-radius-slider">
				<div id="search-radius"></div>
			</div>

			<input type="hidden" id="search_radius" name="search_radius" value="50" />
		</div>

		<input type="hidden" id="search_lat" name="search_lat" value="0" />
  		<input type="hidden" id="search_lng" name="search_lng" value="0" />
	<?php
	}

	public function apply_proximity_filter($sql) {
		$params = array();

		if ( isset( $_POST[ 'form_data' ] ) ) {
			global $wpdb;

			parse_str( $_POST[ 'form_data' ], $params );

			$use_radius = isset( $params[ 'use_search_radius' ] ) && 'on' == $params[ 'use_search_radius' ];

			if ( $use_radius && ( isset( $params[ 'search_lat' ] ) && 0 != $params[ 'search_lat' ] ) ) {
				$lat = (float) $params[ 'search_lat' ];
				$lng = (float) $params[ 'search_lng' ];
				$radius = (int) $params[ 'search_radius' ];

				$sql = $wpdb->prepare( "
					SELECT DISTINCT p.ID,
					( 3959 * acos( cos( radians(%s) ) * cos( radians( lat.meta_value ) ) * cos( radians( lng.meta_value ) - radians(%s) ) + sin( radians(%s) ) * sin( radians( lat.meta_value ) ) ) )
					AS distance
					FROM {$wpdb->prefix}posts p
					LEFT JOIN {$wpdb->prefix}postmeta lat
						ON lat.post_id = p.ID
						AND lat.meta_key = 'geolocation_lat'
					LEFT JOIN {$wpdb->prefix}postmeta lng
						ON lng.post_id = p.ID
						AND lng.meta_key = 'geolocation_long'
					HAVING distance < %s
					ORDER BY distance",
					$lat,
					$lng,
					$lat,
					$radius
				);
			}

			return $sql;

		}

		return $sql;
	}

	public function job_manager_get_listings_custom_filter_text( $text ) {
		$params = array();

		parse_str( $_POST[ 'form_data' ], $params );

		$use_radius = isset( $params[ 'use_search_radius' ] ) && 'on' == $params[ 'use_search_radius' ];

		if ( ! $use_radius ) {
			return $text;
		}

		if ( ! isset( $params[ 'search_lat' ] ) || '' == $params[ 'search_lat' ] || 0 == $params[ 'search_lat' ] ) {
			return $text;
		}

		$text .= ' ' . sprintf( __( 'within a %d mile radius', 'listify' ), $params[ 'search_radius' ] );

		return $text;
	}

}
