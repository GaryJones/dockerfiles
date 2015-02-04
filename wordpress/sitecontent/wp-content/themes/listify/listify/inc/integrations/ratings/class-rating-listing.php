<?php

class Listify_Rating_Listing extends Listify_Rating {

	public function __construct( $args = array() ) {
		parent::__construct( $args );
	}

	public function save() {
		global $wpdb;

		$query = $wpdb->prepare( "
			SELECT SUM(wpcm.meta_value)
			FROM $wpdb->comments AS wpc
			JOIN $wpdb->commentmeta AS wpcm
				ON wpc.comment_id  = wpcm.comment_id
			WHERE wpcm.meta_key = 'rating'
				AND wpc.comment_post_ID = %s
				AND wpc.comment_approved = '1'
		", $this->object_id );

		$total = $wpdb->get_var( $query );
		$votes = $this->count();

		if ( ! $total || $votes == 0 ) {
			update_post_meta( $this->object_id, 'rating', 0 );

			return;
		}

		$avg    = $total / $votes;
		$rating = round( round( $avg * 2 ) / 2, 1 );

		update_post_meta( $this->object_id, 'rating', $rating );

		return $rating;
	}

	public function get() {
		$this->rating = get_post_meta( $this->object_id, 'rating', true );

		if ( ! $this->rating ) {
			return 0;
		}

		return $this->rating;
	}

	public function count() {
		$comments = wp_count_comments( $this->object_id );

		return $comments->approved;
	}

}