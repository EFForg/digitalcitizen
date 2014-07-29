<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Digital Citizen
 */

if ( ! function_exists( 'digitalcitizen_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function digitalcitizen_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'digitalcitizen' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'digitalcitizen' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'digitalcitizen' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'digitalcitizen_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function digitalcitizen_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'digitalcitizen' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'digitalcitizen' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link',     'digitalcitizen' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'digitalcitizen_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function digitalcitizen_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date('m/d/y') ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">%1$s</span>', 'digitalcitizen' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		)
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function digitalcitizen_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'digitalcitizen_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'digitalcitizen_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so digitalcitizen_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so digitalcitizen_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in digitalcitizen_categorized_blog.
 */
function digitalcitizen_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'digitalcitizen_categories' );
}
add_action( 'edit_category', 'digitalcitizen_category_transient_flusher' );
add_action( 'save_post',     'digitalcitizen_category_transient_flusher' );

function digitalcitizen_language_switcher() {
	if ( function_exists( 'pll_the_languages' ) ):
?>
	<div id="language_menu">
		<input type="checkbox" id="language_menu--checkbox" />
		<label id="language_menu--label" class="icon-earth" for="language_menu--checkbox" ><?php echo pll_current_language('name'); ?><?php echo pll_current_language('slug'); ?></label>
		<ul id="language_menu--list"><?php pll_the_languages();?></ul>
	</div>
<?php
	else:
		//TODO: If we're in the admin section throw an error telling the user that Polylang needs to be installed for this to work.
	endif;
}