<?php
/**
 * Digital Citizen functions and definitions
 *
 * @package Digital Citizen
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'digitalcitizen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function digitalcitizen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Digital Citizen, use a find and replace
	 * to change 'digitalcitizen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'digitalcitizen', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'digitalcitizen' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'digitalcitizen_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );

	//Enable posth thumbnails
	add_theme_support( 'post-thumbnails' );

	add_filter( 'mce_buttons_2', 'fb_mce_editor_buttons' );
	function fb_mce_editor_buttons( $buttons ) {

	array_unshift( $buttons, 'styleselect' );
	    return $buttons;
	}

	add_image_size( 'archive-thumb', 800, 200, true );
	add_image_size( 'mobile-fullscreen-portrait', 500, 900, true );
	add_image_size( 'mobile-fullscreen-landscape', 500, 900, true );
	add_image_size( 'widescreen-fullscreen', 1000, 562, true );
}
endif; // digitalcitizen_setup
add_action( 'after_setup_theme', 'digitalcitizen_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function digitalcitizen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'digitalcitizen' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'digitalcitizen_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function enqueue_less_styles($tag, $handle) {
    global $wp_styles;
    $match_pattern = '/\.less$/U';
    if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
        $handle = $wp_styles->registered[$handle]->handle;
        $media = $wp_styles->registered[$handle]->args;
        $href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
        $rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
        $title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';
 
        $tag = "<link rel='stylesheet/less' id='$handle' $title href='$href' type='text/less' media='$media' />";
    }
    return $tag;
}
add_filter( 'style_loader_tag', 'enqueue_less_styles', 5, 2);

function digitalcitizen_scripts() {
	wp_enqueue_style( 'digitalcitizen-style', get_stylesheet_uri() );

	wp_enqueue_style( 'digitalcitizen-style-less', get_template_directory_uri() . '/css/style.less' );

	wp_enqueue_script( 'prefixfree', get_template_directory_uri() . '/js/vendor/prefix-free.min.js', array(), '12345', true);

	wp_enqueue_script( 'digitalcitizen-scrollspy', get_template_directory_uri() . '/js/vendor/bootstrap-scrollspy.js', array('jquery'), '20120206', true );

	wp_enqueue_script( 'digitalcitizen-affix', get_template_directory_uri() . '/js/vendor/affix.js', array('jquery'), '20120206', true );
	
	wp_enqueue_script( 'digitalcitizen-effects', get_template_directory_uri() . '/js/effects.js', array('jquery','digitalcitizen-affix','digitalcitizen-scrollspy'), '20120206', true );

	wp_enqueue_script( 'digitalcitizen-vh-polyfill', get_template_directory_uri() . '/js/vendor/vh-polyfill.js', array('prefixfree'), '20120206', true );

	wp_enqueue_script( 'less', get_template_directory_uri() . '/js/vendor/less.js', array(), '20120206', false );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'digitalcitizen_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
