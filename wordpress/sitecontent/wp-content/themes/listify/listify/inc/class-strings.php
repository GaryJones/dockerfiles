<?php

class Listify_Strings {

	public $strings;

	public function __construct() {
		$this->labels = array(
			'singular' => listify_theme_mod( 'label-singular' ),
			'plural' => listify_theme_mod( 'label-plural' )
		);

		$this->strings = $this->get_strings();

		add_filter( 'gettext', array( $this, 'gettext' ), 0, 3 );
		add_filter( 'gettext_with_context', array( $this, 'gettext_with_context' ), 0, 4 );
		add_filter( 'ngettext', array( $this, 'ngettext' ), 0, 5 );
	}

	public function label($form, $slug = false) {
		$label = $this->labels[ $form ];

		if ( '' == $label && 'plural' == $form ) {
			$label = 'Listings';
		} elseif ( '' == $label && 'singular' == $form ) {
			$label = 'Listing';
		}

		if ( ! $slug ) {
			return $label;
		}

		return sanitize_title( $label );
	}

	public function gettext( $translated, $original, $domain ) {
		if ( isset ( $this->strings[$domain][$original] ) ) {
			return $this->strings[$domain][$original];
		} else {
			return $translated;
		}
	}

	public function gettext_with_context( $translated, $original, $context, $domain ) {
		if ( isset ( $this->strings[$domain][$original] ) ) {
			return $this->strings[$domain][$original];
		} else {
			return $translated;
		}
	}

	public function ngettext( $original, $single, $plural, $number, $domain ) {
		if ( isset ( $this->strings[$domain][$original] ) ) {
			return $this->strings[$domain][$original];
		} else {
			return $original;
		}
	}

	private function get_strings() {
		$strings = array(
			'wp-job-manager' => array(
				'Job' => $this->label( 'singular' ),
				'Jobs' => $this->label( 'plural' ),
				'Job Listings' => $this->label( 'plural' ),
				'jobs' => $this->label( 'plural', true ),
				'job' => $this->label( 'singular', true ),

				'Job category' => sprintf( __( '%s Category', 'listify' ), $this->label( 'singular' ) ),
				'Job categories' => sprintf( __( '%s Categories', 'listify' ), $this->label( 'singular' ) ),
				'Job Categories' => sprintf( __( '%s Categories', 'listify' ), $this->label( 'singular' ) ),
				'job-category' => sprintf( __( '%s-category', 'listify' ), $this->label( 'singular', true ) ),

				'Job type' => sprintf( __( '%s Type', 'listify' ), $this->label( 'singular' ) ),
				'Job types' => sprintf( __( '%s Types', 'listify' ), $this->label( 'singular' ) ),
				'Job Types' => sprintf( __( '%s Types', 'listify' ), $this->label( 'singular' ) ),
				'job-type' => sprintf( __( '%s-type', 'listify' ), $this->label( 'singular', true ) ),

				'Application email' => __( 'Contact Email', 'listify' ),
				'Application URL' => __( 'Contact URL', 'listify' ),
				'Application email/URL' => __( 'Contact email/URL', 'listify' ),

				'Position filled?' => __( 'Listing filled?', 'listify' ),

				'A video about your company' => __( 'A video about your listing', 'listify' ),

				'Job Submission' => sprintf( '%s Submission', $this->label( 'singular' ) ),
				'Submit Job Form Page' => sprintf( 'Submit %s Form Page', $this->label( 'singular' ) ),
				'Job Dashboard Page' => sprintf( '%s Dashboard Page', $this->label( 'singular' ) ),
				'Job Listings Page' => sprintf( '%s Page', $this->label( 'plural' ) ),

				'Position' => __( 'Title', 'listify' )
			),
			'wp-job-manager-tags' => array(
				'Job Tags' => sprintf( '%s Tags', $this->label( 'singular' ) ),
				'Job tags' => sprintf( '%s Tags', $this->label( 'singular' ) ),
				'job-tag' => sprintf( '%s-tag', $this->label( 'singular', true ) ),
				'Comma separate tags, such as required skills or technologies, for this job.' => '',
				'Choose some tags, such as required skills or technologies, for this job.' => __( 'Choose some tags, such as required skills available features, for this listing.', 'listify' ),
				'Filter by tag:' => '<span class="filter-label">' . __( 'Filter by tag: ', 'listify' ) . '</span>',

				'Maximum Job Tags' => sprintf( 'Maximum %s Tags', $this->label( 'singular' ) )
			),
			'wp-job-manager-locations' => array(
				'Job Regions' => sprintf( '%s Regions', $this->label( 'singular' ) ),
				'Job Region' => sprintf( '%s Region', $this->label( 'singular' ) ),
				'job-region' => sprintf( '%s-region', $this->label( 'singular', true ) ),

				'Display a list of job regions.' => sprintf( __( 'Display a list of %s regions.', 'listify' ), $this->label( 'singular', true ) ),
			),
			'wp-job-manager-wc-paid-listings' => array(
				'%s job posted out of %d' => __( '%s listing posted out of %d', 'listify' ),
				'%s jobs posted out of %d' => __( '%s listings posted out of %d', 'listify' ),
				'%s for %d job' => __( '%s for %d listing', 'listify' ),
				'%s for %s jobs' => __( '%s for %s listings', 'listify' ),
				'Job Package' => sprintf( __( '%s Package', 'listify' ), $this->label( 'singular' ) ),
				'Job Package Subscription' => sprintf( __( '%s Package Subscription', 'listify' ), $this->label(
				'singular' ) ),
				'Job Listing' => sprintf( __( '%s Listing', 'listify' ), $this->label( 'singular' ) ),
				'Job listing limit' => sprintf( __( '%s limit', 'listify' ), $this->label( 'singular' ) ),
				'Job listing duration' => sprintf( __( '%s duration', 'listify' ), $this->label( 'singular' ) ),
				'The number of days that the job listing will be active.' => sprintf( __( 'The number of days that the %s
				will be active', 'listify' ), $this->label( 'singular', true ) ),
				'Feature job listings?' => sprintf( __( 'Feature %s?', 'listify' ), $this->label( 'singular', true ) ),
				'Feature this job listing - it will be styled differently and sticky.' => sprintf( __( 'Feature this %s
				-- it will be styled differently and sticky.', 'listify' ), $this->label( 'singular', true ) ),
				'My job packages' => sprintf( __( 'My %s packages', 'listify' ), $this->label( 'singular', true ) ),
				'Jobs Remaining' => sprintf( __( '%s Remaining', 'listify' ), $this->label( 'plural' ) )
			),
			'wp-job-manager-simple-paid-listings' => array(
				'Job #%d Payment Update' => __( '#%d Payment Update', 'listify' )
			),
			'wp-job-manager-alrts' => array(
				'Job Alert Results Matching \"%s\"' => __( 'Alert Results Matching \"%s\"', 'listify' ),
				'No jobs were found matching your search. Login to your account to change your alert criteria' => __( 'No
				results were found matching your search. Login to your account to change your alert criteria', 'listify'
				),
				'This job alert will automatically stop sending after %s.' => __( 'This alert will automatically stop
				sending after %s.', 'listify' ),
				'No jobs found' => sprintf( __( 'No %s found', 'listify' ), $this->label( 'plural', true ) ),
				'Optionally add a keyword to match jobs against' => sprintf( __( 'Optionally add a keyword to match %s 
				against', 'listify' ), $this->label( 'plural', true ) ),
				'Job Type' => sprintf( __( '%s Type', 'listify' ), $this->label( 'singular' ) ),
				'Any job type' => sprintf( __( 'Any %s type', 'listify' ), $this->label( 'singular', true ) ),
				'Job Type:' => sprintf( __( '%s Type:', 'listify' ), $this->label( 'singular' ) ),
				'Your job alerts are shown in the table below. Your alerts will be sent to %s.' => __( 'Your alerts are
				shown in the table below. The alerts will be sent to %s.' )
			)
		);

		$this->strings = apply_filters( 'listify_strings', $strings );

		return $this->strings;
	}

}

$GLOBALS[ 'listify_strings' ] = new Listify_Strings();
