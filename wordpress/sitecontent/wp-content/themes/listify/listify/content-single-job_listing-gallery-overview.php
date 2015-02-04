<?php
/**
 * The template for displaying a list of gallery items for a job listing.
 *
 * Must pass an array of attachment IDs and a limit to show [$gallery, $limit]
 *
 * @package Listify
 */

if ( empty( $gallery ) ) {
	$gallery = array(-1);
}

$attachments = new WP_Query( array(
	'post__in' => $gallery,
	'post_status' => 'inherit',
	'post_type' => 'attachment',
	'post_mime_type' => 'image',
	'fields' => 'ids',
	'posts_per_page' => $limit
) );
?>

<ul class="listify-gallery-images">
	<?php if ( ! $attachments->have_posts() ) : ?>
		<?php if ( ! is_admin() ) : ?>
		<li class="gallery-no-images"><a href="#add-photo" class="popup-trigger"><?php _e( 'No images found. Why not add your own?', 'listify' ); ?></a></li>
		<?php endif; ?>
	<?php else : ?>
		<?php foreach ( $attachments->posts as $id ) : ?>
			<?php $image = wp_get_attachment_image_src( $id, 'thumbnail' ); ?>
			<li class="gallery-preview-image" style="background-image:url(<?php echo esc_url( $image[0] ); ?>); ?>">
				<a href="<?php echo get_attachment_link( $id ); ?>"></a>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>

<style>
.gallery-preview-image {
	border-radius: 50%;
	width: 60px;
	height: 60px;
	margin: 0 6px 12px;
	display: inline-block;
	background-size: cover;
}

.gallery-preview-image a {
	display: block;
	width: 100%;
	height: 100%;
}

.gallery-preview-image:nth-child(4n) {
	margin-right: 0;
}
</style>
