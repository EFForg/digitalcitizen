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
			'large', 
			true
		);
	?>
	<header class="entry-header" style="background-image:url('<?php echo $image_url[0]; ?>');">
			<div class="entry-meta">
				<?php the_title( '<span class="entry-title">', '</span>' ); ?>
				<?php digitalcitizen_posted_on(); ?>
			</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'digitalcitizen' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'digitalcitizen' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'digitalcitizen' ) );
				if ( $categories_list && digitalcitizen_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'digitalcitizen' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'digitalcitizen' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( 'Tagged %1$s', 'digitalcitizen' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'digitalcitizen' ), __( '1 Comment', 'digitalcitizen' ), __( '% Comments', 'digitalcitizen' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'digitalcitizen' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
