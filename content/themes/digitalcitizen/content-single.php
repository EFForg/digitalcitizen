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

	<?php if($post->post_excerpt): ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
	<?php endif; ?>

	<aside class="entry-aside">
		<div class="entry-aside-inner">
			<?php get_sidebar(); ?>
		</div>
	</aside><!-- .entry-aside -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'digitalcitizen' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php get_template_part('socialbar'); ?>

	<footer class="entry-footer">
		<?php digitalcitizen_post_nav(); ?>
	</footer>

</article><!-- #post-## -->
