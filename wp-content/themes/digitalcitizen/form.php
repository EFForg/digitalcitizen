<?php
/**
 *
 * The template for displaying forms. Make this a page template, maybe have it depend on custom fields?
 *
 *
 * @package Digital Citizen
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php get_template_part( 'form', $form_name ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-footer">
						<?php edit_post_link( __( 'Edit', 'digitalcitizen' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-footer -->
				</article><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>