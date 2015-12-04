<?php
/**
 * @package Digital Citizen
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
		$image_id = get_post_thumbnail_id();
		$image_url = wp_get_attachment_image_src(
			$image_id,
			'archive-thumb', 
			true
		);
	?>
	<header class="entry-header" style="background-image:url('<?php echo $image_url[0]; ?>');">
			<div class="entry-meta">
				<?php the_title( '<span class="entry-title">', '</span>' ); ?>
				<?php digitalcitizen_posted_on(); ?>
			</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

</article><!-- #post-## -->
