<?php
/**
 * Home: Map Listings
 *
 * @since Listify 1.0.0
 */
class Listify_Widget_Map_Listings extends Listify_Widget {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->widget_description = __( 'Display a map and results of listings', 'listify' );
		$this->widget_id          = 'listify_widget_map_listings';
		$this->widget_name        = __( 'Listify - Home: Map', 'listify' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => 'Recent Listings',
				'label' => __( 'Title:', 'listify' )
			),
			'description' => array(
				'type'  => 'text',
				'std'   => 'Discover some of our best listings',
				'label' => __( 'Description:', 'listify' )
			),
			'results' => array(
				'type' => 'checkbox',
				'std'  => 1,
				'label' => __( 'Display results', 'listify' )
			),
			'limit' => array(
				'type'  => 'number',
				'std'   => 3,
				'min'   => 1,
				'max'   => 30,
				'step'  => 1,
				'label' => __( 'Number of listings per page:', 'listify' )
			),
		);
		parent::__construct();

		if ( is_active_widget( false, false, $this->widget_id, true ) && is_page_template( 'page-templates/template-home.php' ) ) {
			add_filter( 'listify_page_needs_map', '__return_true' );
		}
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		extract( $args );

		$title = apply_filters( 'widget_title', $instance[ 'title' ], $instance, $this->id_base );
		$description = isset( $instance[ 'description' ] ) ? esc_attr( $instance[ 'description' ] ) : false;
		$results = isset( $instance[ 'results' ] ) && 1 == $instance[ 'results' ] ? true : false;
		$limit = isset( $instance[ 'limit' ] ) ? absint( $instance[ 'limit' ] ) : 3;

		$after_title = '<h2 class="home-widget-description">' . $description . '</h2>' . $after_title;

		ob_start();

		echo $before_widget;

		if ( $title ) echo $before_title . $title . $after_title;

		$atts = 'show_pagination=true per_page=' . $limit;

		do_action( 'listify_output_map' );
		do_action( 'listify_output_results', $atts );

		if ( ! $results ) {
		?>
			<style>
			#<?php echo $this->id; ?> .archive-job_listing-filter-title, #<?php echo $this->id; ?> ul.job_listings, #<?php echo $this->id; ?> .job-manager-pagination { display: none; }
			</style>
		<?php
		}

		echo $after_widget;

		$content = ob_get_clean();

		echo apply_filters( $this->widget_id, $content );

		$this->cache_widget( $args, $content );
	}
}