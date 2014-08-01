<?php
/**
 * @package Digital Citizen
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
		$image_id = get_post_thumbnail_id();
		$image_url_large = wp_get_attachment_image_src(
			$image_id,
			'widescreen-fullscreen', 
			true
		);
		$image_url_small_portrait = wp_get_attachment_image_src(
			$image_id,
			'mobile-fullscreen-portrait', 
			true
		);
		$image_url_small_landscape = wp_get_attachment_image_src(
			$image_id,
			'mobile-fullscreen-landscape', 
			true
		);
	?>
	<style>
		.entry-header {
			background-image:url('<?php echo $image_url_small_portrait[0]; ?>');
		}
		@media screen and (orientation:'landscape') and (max-width: 768px) {
			.entry-header {
				background-image:url('<?php echo $image_url_small_landscape[0]; ?>');
			}
		}
		@media screen and (min-width: 768px) {
			.entry-header {
				background-image:url('<?php echo $image_url_large[0]; ?>');
			}
		}
	</style>
	<header class="entry-header">
			<div class="entry-meta">
				<?php the_title( '<span class="entry-title">', '</span>' ); ?>
				<?php digitalcitizen_posted_on(); ?>
			</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'digitalcitizen' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'digitalcitizen' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'digitalcitizen' ) );

			if ( ! digitalcitizen_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'digitalcitizen' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'digitalcitizen' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'digitalcitizen' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'digitalcitizen' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'digitalcitizen' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
