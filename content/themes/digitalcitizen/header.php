<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Digital Citizen
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" role="banner">
		<?php digitalcitizen_language_switcher(); ?>

		<div id="masthead--branding">
			<h1 id="masthead--branding--title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 id="masthead--branding--description"><?php bloginfo( 'description' ); ?></h2>
		</div>

		<nav id="masthead--navigation" role="navigation">
			<input type="checkbox" id="masthead--navigation--toggle--checkbox" name="masthead--navigation--toggle--checkbox" />
			<label id="masthead--navigation--toggle" for="masthead--navigation--toggle--checkbox" class="menu-toggle icon-menu"><?php _e( 'menu', 'digitalcitizen' ); ?></label>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content">
