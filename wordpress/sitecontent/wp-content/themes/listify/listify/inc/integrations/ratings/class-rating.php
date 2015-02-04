<?php

abstract class Listify_Rating {

	public $object_id;
	public $rating;

	abstract public function get();
	abstract public function save();

	public function __construct( $args ) {
		$defaults = array(
			'rating' => false,
			'object_id' => false
		);

		$args = wp_parse_args( $args, $defaults );

		$this->rating = $args[ 'rating' ];
		$this->object_id = $args[ 'object_id' ];

		if ( $this->rating ) {
			$this->save();
		} else {
			$this->get();
		}
	}

	public function output() {
		if ( ! $this->rating ) {
			$this->rating = 0;
		}

		return number_format( $this->rating, 1, '.', ',' );
	}

	public function stars() {
		$output = array();
		$rating = $this->get();

		$remaining = 5 - $rating;

		$whole  = round( $rating, 0 );
		$r_whole = round( $remaining, 0 );

		for ( $i = 1; $i <= $whole; $i++ ) {
			$output[] = '<span class="star-icon"><span class="ion-ios7-star"></span></span>';
		}

		if ( $r_whole != $remaining ) {
			$output[] = '<span class="star-icon"><span class="ion-ios7-star-half"></span></span>';
		}

		for ( $i = 1; $i <= $r_whole; $i++ ) {
			$output[] = '<span class="star-icon"><span class="ion-ios7-star-outline"></span></span>';
		}

		$output = implode( '', $output );

		return $output;
	}

}