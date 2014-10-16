<?php
/**
 * @package Facebook Open Graph Meta Tags for WordPress
 * @version 1.1.2
 */
/*
Plugin Name: Facebook Open Graph Meta Tags for WordPress
Plugin URI: http://blog.wonderm00n.com/2011/10/14/wordpress-plugin-simple-facebook-open-graph-tags/
Description: This plugin (formerly known as "Wonderm00n's Simple Facebook Open Graph Meta Tags") inserts Facebook Open Graph Tags into your WordPress Blog/Website for more effective and efficient Facebook sharing results. It also allows you to add the Meta Description tag and Schema.org Name, Description and Image tags for more effective and efficient Google+ sharing results. You can also choose to insert the "enclosure" and "media:content" tags to the RSS feeds, so that apps like RSS Graffiti and twitterfeed post the image to Facebook correctly.
Version: 1.1.2
Author: Webdados
Author URI: http://www.webdados.pt
Text Domain: wd-fb-og
Domain Path: /lang
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$wonderm00n_open_graph_plugin_version='1.1.2';
$wonderm00n_open_graph_plugin_settings=array(
		'fb_app_id_show',
		'fb_app_id',
		'fb_admin_id_show',
		'fb_admin_id',
		'fb_locale_show',
		'fb_locale',
		'fb_sitename_show',
		'fb_title_show',
		'fb_title_show_schema',
		'fb_url_show',
		'fb_url_canonical',
		'fb_url_add_trailing',
		'fb_type_show',
		'fb_type_homepage',
		'fb_desc_show',
		'fb_desc_show_meta',
		'fb_desc_show_schema',
		'fb_desc_chars',
		'fb_desc_homepage',
		'fb_desc_homepage_customtext',
		'fb_image_show',
		'fb_image_show_schema',
		'fb_image',
		'fb_image_rss',
		'fb_image_use_specific',
		'fb_image_use_featured',
		'fb_image_use_content',
		'fb_image_use_media',
		'fb_image_use_default',
		'fb_show_wpseoyoast',
		'fb_show_subheading',
		'fb_show_businessdirectoryplugin'
);

//We have to remove canonical NOW because the plugin runs too late - We're also loading the settings which is cool
$webdados_fb_open_graph_settings=wonderm00n_open_graph_load_settings();
if (intval($webdados_fb_open_graph_settings['fb_url_show'])==1) {
	if (intval($webdados_fb_open_graph_settings['fb_url_canonical'])==1) {
		remove_action('wp_head', 'rel_canonical');
	}
}

//Languages
function wonderm00n_open_graph_init() {
	load_plugin_textdomain('wd-fb-og', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}
add_action('plugins_loaded', 'wonderm00n_open_graph_init');

function wonderm00n_open_graph() {
	global $wonderm00n_open_graph_plugin_settings, $wonderm00n_open_graph_plugin_version, $webdados_fb_open_graph_settings;

	//Upgrade
	wonderm00n_open_graph_upgrade();
	
	//Get options - OLD (until 0.5.4)
	/*foreach($wonderm00n_open_graph_plugin_settings as $key) {
		$$key=get_option('wonderm00n_open_graph_'.$key);
	}*/
	//Get options - NEW (after 0.5.4)
	extract($webdados_fb_open_graph_settings);
	
	//Also set Title Tag?
	$fb_set_title_tag=0;

	$fb_type='article';
	if (is_singular()) {
		//It's a Post or a Page or an attachment page - It can also be the homepage if it's set as a page
		global $post;
		$fb_title=esc_attr(strip_tags(stripslashes($post->post_title)));
		//SubHeading
		if ($fb_show_subheading==1) {
			@include_once(ABSPATH . 'wp-admin/includes/plugin.php');
			if (is_plugin_active('subheading/index.php')) {
				if (function_exists('get_the_subheading')) {
					$fb_title.=' - '.get_the_subheading();
				}
			}
		}
		$fb_url=get_permalink();
		if (is_front_page()) {
			/* Fix homepage type when it's a static page */
			$fb_url=get_option('home').(intval($fb_url_add_trailing)==1 ? '/' : '');
			$fb_type=trim($fb_type_homepage=='' ? 'website' : $fb_type_homepage);
		}
		if (trim($post->post_excerpt)!='') {
			//If there's an excerpt that's what we'll use
			$fb_desc=trim($post->post_excerpt);
		} else {
			//If not we grab it from the content
			$fb_desc=trim($post->post_content);
		}
		$fb_desc=(intval($fb_desc_chars)>0 ? substr(esc_attr(strip_tags(strip_shortcodes(stripslashes($fb_desc)))),0,$fb_desc_chars) : esc_attr(strip_tags(strip_shortcodes(stripslashes($fb_desc)))));
		if (intval($fb_image_show)==1) {
			$fb_image=wonderm00n_open_graph_post_image($fb_image_use_specific, $fb_image_use_featured, $fb_image_use_content, $fb_image_use_media, $fb_image_use_default, $fb_image);
		}
		//Business Directory Plugin
		if ($fb_show_businessdirectoryplugin==1) {
			@include_once(ABSPATH . 'wp-admin/includes/plugin.php');
			if (is_plugin_active('business-directory-plugin/wpbusdirman.php')) {
				global $wpbdp;
				//$bdpaction = _wpbdp_current_action();
				$bdpaction=$wpbdp->controller->get_current_action();
				switch($bdpaction) {
					case 'showlisting':
						//Listing
						$listing_id = get_query_var('listing') ? wpbdp_get_post_by_slug(get_query_var('listing'))->ID : wpbdp_getv($_GET, 'id', get_query_var('id'));
						$bdppost=get_post($listing_id);
						$fb_title=esc_attr(strip_tags(stripslashes($bdppost->post_title))).' - '.$fb_title;
						$fb_set_title_tag=1;
						$fb_url=get_permalink($listing_id);
						if (trim($bdppost->post_excerpt)!='') {
							//If there's an excerpt that's what we'll use
							$fb_desc=trim($bdppost->post_excerpt);
						} else {
							//If not we grab it from the content
							$fb_desc=trim($bdppost->post_content);
						}
						$fb_desc=(intval($fb_desc_chars)>0 ? substr(esc_attr(strip_tags(strip_shortcodes(stripslashes($fb_desc)))),0,$fb_desc_chars) : esc_attr(strip_tags(strip_shortcodes(stripslashes($fb_desc)))));
						if (intval($fb_image_show)==1) {
							$thumbdone=false;
							if (intval($fb_image_use_featured)==1) {
								//Featured
								if ($id_attachment=get_post_thumbnail_id($bdppost->ID)) {
									//There's a featured/thumbnail image for this listing
									$fb_image=wp_get_attachment_url($id_attachment, false);
									$thumbdone=true;
								}
							}
							if (!$thumbdone) {
								//Main image loaded
								if ($thumbnail_id = wpbdp_listings_api()->get_thumbnail_id($bdppost->ID)) {
									$fb_image=wp_get_attachment_url($thumbnail_id, false);
								}
							}
						}
						break;
					case 'browsecategory':
							//Categories
							$term = get_term_by('slug', get_query_var('category'), wpbdp_categories_taxonomy());
							$fb_title=esc_attr(strip_tags(stripslashes($term->name))).' - '.$fb_title;
							$fb_set_title_tag=1;
							$fb_url=get_term_link($term);
							if (trim($term->description)!='') {
								$fb_desc=trim($term->description);
							}
						break;
					case 'main':
						//Main page
						//No changes
						break;
					default:
						//No changes
						break;
				}
			}
		}
	} else {
		global $wp_query;
		//Other pages - Defaults
		$fb_title=esc_attr(strip_tags(stripslashes(get_bloginfo('name'))));
		//$fb_url=get_option('home').(intval($fb_url_add_trailing)==1 ? '/' : ''); //2013-11-4 changed from 'siteurl' to 'home'
		$fb_url=((!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];  //Not really canonical but will work for now

		switch(trim($fb_desc_homepage)) {
			case 'custom':
				$fb_desc=esc_attr(strip_tags(stripslashes($fb_desc_homepage_customtext)));
				break;
			default:
				$fb_desc=esc_attr(strip_tags(stripslashes(get_bloginfo('description'))));
				break;
		}
		
		if (is_category()) {
			$fb_title=esc_attr(strip_tags(stripslashes(single_cat_title('', false))));
			$term=$wp_query->get_queried_object();
			$fb_url=get_term_link($term, $term->taxonomy);
			$cat_desc=trim(esc_attr(strip_tags(stripslashes(category_description()))));
			if (trim($cat_desc)!='') $fb_desc=$cat_desc;
		} else {
			if (is_tag()) {
				$fb_title=esc_attr(strip_tags(stripslashes(single_tag_title('', false))));
				$term=$wp_query->get_queried_object();
				$fb_url=get_term_link($term, $term->taxonomy);
				$tag_desc=trim(esc_attr(strip_tags(stripslashes(tag_description()))));
				if (trim($tag_desc)!='') $fb_desc=$tag_desc;
			} else {
				if (is_tax()) {
					$fb_title=esc_attr(strip_tags(stripslashes(single_term_title('', false))));
					$term=$wp_query->get_queried_object();
					$fb_url=get_term_link($term, $term->taxonomy);
				} else {
					if (is_search()) {
						$fb_title=esc_attr(strip_tags(stripslashes(__('Search for').' "'.get_search_query().'"')));
						$fb_url=get_search_link();
					} else {
						if (is_author()) {
							$fb_title=esc_attr(strip_tags(stripslashes(get_the_author_meta('display_name', get_query_var('author')))));
							$fb_url=get_author_posts_url(get_query_var('author'), get_query_var('author_name'));
						} else {
							if (is_archive()) {
								if (is_day()) {
									$fb_title=esc_attr(strip_tags(stripslashes(get_query_var('day').' '.single_month_title(' ', false).' '.__('Archives'))));
									$fb_url=get_day_link(get_query_var('year'), get_query_var('monthnum'), get_query_var('day'));
								} else {
									if (is_month()) {
										$fb_title=esc_attr(strip_tags(stripslashes(single_month_title(' ', false).' '.__('Archives'))));
										$fb_url=get_month_link(get_query_var('year'), get_query_var('monthnum'));
									} else {
										if (is_year()) {
											$fb_title=esc_attr(strip_tags(stripslashes(get_query_var('year').' '.__('Archives'))));
											$fb_url=get_year_link(get_query_var('year'));
										}
									}
								}
							} else {
								if (is_front_page()) {
									$fb_url=get_option('home').(intval($fb_url_add_trailing)==1 ? '/' : '');
									$fb_type=trim($fb_type_homepage=='' ? 'website' : $fb_type_homepage);
								} else {
									//Others... Defaults already set up there
								}
							}
						}
					}
				}
			}
		}
	}
	//If no description let's just add the title
	if (trim($fb_desc)=='') $fb_desc=$fb_title;

	//YOAST?
	if ($fb_show_wpseoyoast==1) {
		if ( defined('WPSEO_VERSION') ) {
			$wpseo = new WPSEO_Frontend();
			//App ID - From our plugin
			//Admin ID - From our plugin
			//Locale - From our plugin
			//Sitename - From our plugin
			//Title - From WPSEO
			$fb_title=$wpseo->title(false);
			//Title - SubHeading plugin
			if ($fb_show_subheading==1) {
				@include_once(ABSPATH . 'wp-admin/includes/plugin.php');
				if (is_plugin_active('subheading/index.php')) {
					if (function_exists('get_the_subheading')) {
						$fb_title.=' - '.get_the_subheading();
					}
				}
			}
			//URL - From WPSEO
			$fb_url=$wpseo->canonical(false);
			//Description - From WPSEO or our pligun
			$fb_desc_temp=$wpseo->metadesc(false);
			$fb_desc=(trim($fb_desc_temp)!='' ? trim($fb_desc_temp) : $fb_desc);
			//Image - From our plugin
		}
	}
	
	$html='
<!-- START - Facebook Open Graph Meta Tags for WordPress '.$wonderm00n_open_graph_plugin_version.' -->
';
	if (intval($fb_app_id_show)==1 && trim($fb_app_id)!='') $html.='<meta property="fb:app_id" content="'.trim($fb_app_id).'" />
';
	if (intval($fb_admin_id_show)==1 && trim($fb_admin_id)!='') $html.='<meta property="fb:admins" content="'.trim($fb_admin_id).'" />
';
	if (intval($fb_locale_show)==1) $html.='<meta property="og:locale" content="'.trim(trim($fb_locale)!='' ? trim($fb_locale) : trim(get_locale())).'" />
';
	if (intval($fb_sitename_show)==1) $html.='<meta property="og:site_name" content="'.get_bloginfo('name').'" />
';
	if (intval($fb_title_show)==1) $html.='<meta property="og:title" content="'.trim($fb_title).'" />
';
	if (intval($fb_set_title_tag)==1) {
		//Does nothing so far. We try to create the <title> tag but it's too late now
	}
	if (intval($fb_title_show_schema)==1) $html.='<meta itemprop="name" content="'.trim($fb_title).'" />
';
	if (intval($fb_url_show)==1) {
		$html.='<meta property="og:url" content="'.trim(esc_attr($fb_url)).'" />
';
		if (intval($fb_url_canonical)==1) {
			//remove_action('wp_head', 'rel_canonical'); //This is already done
			$html.='<link rel="canonical" href="'.trim(esc_attr($fb_url)).'" />
';
		}
	}
	if (intval($fb_type_show)==1) $html.='<meta property="og:type" content="'.trim(esc_attr($fb_type)).'" />
';
	if (intval($fb_desc_show)==1) $html.='<meta property="og:description" content="'.trim($fb_desc).'" />
';
	if (intval($fb_desc_show_meta)==1) $html.='<meta name="description" content="'.trim($fb_desc).'" />
';
	if (intval($fb_desc_show_schema)==1) $html.='<meta itemprop="description" content="'.trim($fb_desc).'" />
';
	if(intval($fb_image_show)==1 && trim($fb_image)!='') $html.='<meta property="og:image" content="'.trim(esc_attr($fb_image)).'" />
';
	if(intval($fb_image_show_schema)==1 && trim($fb_image)!='') $html.='<meta itemprop="image" content="'.trim(esc_attr($fb_image)).'" />
';
	$html.='<!-- END - Facebook Open Graph Meta Tags for WordPress -->
';
	echo $html;
}
add_action('wp_head', 'wonderm00n_open_graph', 9999);

function wonderm00n_open_graph_add_opengraph_namespace( $output ) {
	if (stristr($output,'xmlns:og')) {
		//Already there
	} else {
		//Let's add it
		$output=$output . ' xmlns:og="http://ogp.me/ns#"';
	}
	if (stristr($output,'xmlns:fb')) {
		//Already there
	} else {
		//Let's add it
		$output=$output . ' xmlns:fb="http://ogp.me/ns/fb#"';
	}
	return $output;
}
//We want to be last to add the namespace because some other plugin may already added it ;-)
add_filter('language_attributes', 'wonderm00n_open_graph_add_opengraph_namespace',9999);

//Add images also to RSS feed. Most code from WP RSS Images by Alain Gonzalez
function wonderm00n_open_graph_images_on_feed($for_comments) {
	global $webdados_fb_open_graph_settings;
	if (intval($webdados_fb_open_graph_settings['fb_image_rss'])==1) {
		if (!$for_comments) {
			add_action('rss2_ns', 'wonderm00n_open_graph_images_on_feed_yahoo_media_tag');
			add_action('rss_item', 'wonderm00n_open_graph_images_on_feed_image');
			add_action('rss2_item', 'wonderm00n_open_graph_images_on_feed_image');
		}
	}
}
function wonderm00n_open_graph_images_on_feed_yahoo_media_tag() {
	echo 'xmlns:media="http://search.yahoo.com/mrss/"';
}
function wonderm00n_open_graph_images_on_feed_image() {
	global $webdados_fb_open_graph_settings;
	$fb_image = wonderm00n_open_graph_post_image($webdados_fb_open_graph_settings['fb_image_use_specific'], $webdados_fb_open_graph_settings['fb_image_use_featured'], $webdados_fb_open_graph_settings['fb_image_use_content'], $webdados_fb_open_graph_settings['fb_image_use_media'], $webdados_fb_open_graph_settings['fb_image_use_default'], $webdados_fb_open_graph_settings['fb_image']);
	if ($fb_image!='') {
		$uploads = wp_upload_dir();
		$url = parse_url($fb_image);
		$path = $uploads['basedir'] . preg_replace( '/.*uploads(.*)/', '${1}', $url['path'] );
		if (file_exists($path)) {
			$filesize=filesize($path);
			$url=$path;
		} else {		
			$header=get_headers($fb_image, 1);					   
			$filesize=$header['Content-Length'];	
			$url=$fb_image;				
		}
		list($width, $height, $type, $attr) = getimagesize($url);
		echo '<enclosure url="' . $fb_image . '" length="' . $filesize . '" type="'.image_type_to_mime_type($type).'" />';
		echo '<media:content url="'.$fb_image.'" width="'.$width.'" height="'.$height.'" medium="image" type="'.image_type_to_mime_type($type).'" />';
	}
}
add_action("do_feed_rss","wonderm00n_open_graph_images_on_feed",5,1);
add_action("do_feed_rss2","wonderm00n_open_graph_images_on_feed",5,1);

//Post image
function wonderm00n_open_graph_post_image($fb_image_use_specific=1,$fb_image_use_featured=1, $fb_image_use_content=1, $fb_image_use_media=1, $fb_image_use_default=1, $default_image='') {
	global $post;
	$thumbdone=false;
	$fb_image='';
	//Specific post image
	if (intval($fb_image_use_specific)==1) {
		if ($fb_image=trim(get_post_meta($post->ID, '_webdados_fb_open_graph_specific_image', true))) {
			if (trim($fb_image)!='') {
				$thumbdone=true;
			}
		}
	}
	//Featured image
	if (!$thumbdone) {
		if (function_exists('get_post_thumbnail_id')) {
			if (intval($fb_image_use_featured)==1) {
				if ($id_attachment=get_post_thumbnail_id($post->ID)) {
					//There's a featured/thumbnail image for this post
					$fb_image=wp_get_attachment_url($id_attachment, false);
					$thumbdone=true;
				}
			}
		}
	}
	//From post/page content
	if (!$thumbdone) {
		if (intval($fb_image_use_content)==1) {
			$imgreg = '/<img .*src=["\']([^ ^"^\']*)["\']/';
			preg_match_all($imgreg, trim($post->post_content), $matches);
			if (isset($matches[1][0])) {
				//There's an image on the content
				$image=$matches[1][0];
				$pos = strpos($image, site_url());
				if ($pos === false) {
					if (stristr($image, 'http://') || stristr($image, 'https://')) {
						//Complete URL - offsite
						$fb_image=$image;
					} else {
						$fb_image=site_url().$image;
					}
				} else {
					//Complete URL - onsite
					$fb_image=$image;
				}
				$thumbdone=true;
			}
		}
	}
	//From media gallery
	if (!$thumbdone) {
		if (intval($fb_image_use_media)==1) {
			$images = get_posts(array('post_type' => 'attachment','numberposts' => 1,'post_status' => null,'order' => 'ASC','orderby' => 'menu_order','post_mime_type' => 'image','post_parent' => $post->ID));
			if ($images) {
				$fb_image=wp_get_attachment_url($images[0]->ID, false);
				$thumbdone=true;
			}
		}
	}
	//From default
	if (!$thumbdone) {
		if (intval($fb_image_use_default)==1) {
			//Well... We sure did try. We'll just keep the default one!
			$fb_image=$default_image;
		} else {
			//User chose not to use default on pages/posts
			$fb_image='';
		}
	}
	return $fb_image;
}

//Admin
if ( is_admin() ) {
	
	add_action('admin_menu', 'wonderm00n_open_graph_add_options');
	
	register_activation_hook(__FILE__, 'wonderm00n_open_graph_activate');
	
	function wonderm00n_open_graph_add_options() {
		if(function_exists('add_options_page')){
			add_options_page('Facebook Open Graph Tags', 'Facebook Open Graph Tags', 'manage_options', basename(__FILE__), 'wonderm00n_open_graph_admin');
		}
	}
	
	function wonderm00n_open_graph_activate() {
		// Let's not!
	}
	
	function wonderm00n_open_graph_settings_link( $links, $file ) {
		if( $file == 'wonderm00ns-simple-facebook-open-graph-tags/wonderm00n-open-graph.php' && function_exists( "admin_url" ) ) {
			$settings_link = '<a href="' . admin_url( 'options-general.php?page=wonderm00n-open-graph.php' ) . '">' . __('Settings') . '</a>';
			array_push( $links, $settings_link ); // after other links
		}
		return $links;
	}
	add_filter('plugin_row_meta', 'wonderm00n_open_graph_settings_link', 9, 2 );
	
	
	function wonderm00n_open_graph_admin() {
		global $wonderm00n_open_graph_plugin_settings, $wonderm00n_open_graph_plugin_version;
		wonderm00n_open_graph_upgrade();
		include_once 'includes/settings-page.php';
	}
	
	function wonderm00n_open_graph_scripts() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('jquery');
	}
	function wonderm00n_open_graph_styles() {
		wp_enqueue_style('thickbox');
	}
	add_action('admin_print_scripts', 'wonderm00n_open_graph_scripts');
	add_action('admin_print_styles', 'wonderm00n_open_graph_styles');

	function wonderm00n_open_graph_add_posts_options() {
		global $webdados_fb_open_graph_settings;
		if (intval($webdados_fb_open_graph_settings['fb_image_use_specific'])==1) {
			global $post;
			add_meta_box(
				'webdados_fb_open_graph',
				'Facebook Open Graph Meta Tags for WordPress',
	            'wonderm00n_open_graph_add_posts_options_box',
	            	$post->post_type
	        );
		}
	}
	function wonderm00n_open_graph_add_posts_options_box() {
		global $post;
		// Add an nonce field so we can check for it later.
  		wp_nonce_field( 'webdados_fb_open_graph_custom_box', 'webdados_fb_open_graph_custom_box_nonce' );
  		// Current value
  		$value = get_post_meta($post->ID, '_webdados_fb_open_graph_specific_image', true);
  		echo '<label for="webdados_fb_open_graph_specific_image">';
       	_e('Use this image:', 'wd-fb-og');
  		echo '</label> ';
  		echo '<input type="text" id="webdados_fb_open_graph_specific_image" name="webdados_fb_open_graph_specific_image" value="' . esc_attr( $value ) . '" size="75" />
  			  <input id="webdados_fb_open_graph_specific_image_button" class="button" type="button" value="'.__('Upload/Choose Open Graph Image','wd-fb-og').'" />
  			  <input id="webdados_fb_open_graph_specific_image_button_clear" class="button" type="button" value="'.__('Clear field','wd-fb-og').'"/>';
  		echo '<br/>'.__('Recommended size: 1200x630px', 'wd-fb-og');
  		echo '<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery(\'#webdados_fb_open_graph_specific_image_button\').live(\'click\', function() {
						tb_show(\'Upload image\', \'media-upload.php?post_id='.$post->ID.'&type=image&context=webdados_fb_open_graph_specific_image_button&TB_iframe=true\');
					});
					jQuery(\'#webdados_fb_open_graph_specific_image_button_clear\').live(\'click\', function() {
						jQuery(\'#webdados_fb_open_graph_specific_image\').val(\'\');
					});
				});
			</script>';
	}
	add_action('add_meta_boxes', 'wonderm00n_open_graph_add_posts_options');
	function wonderm00n_open_graph_add_posts_options_box_save( $post_id ) {

	  /*
	   * We need to verify this came from the our screen and with proper authorization,
	   * because save_post can be triggered at other times.
	   */

	  // Check if our nonce is set.
	  if ( ! isset( $_POST['webdados_fb_open_graph_custom_box_nonce'] ) )
	    return $post_id;

	  $nonce = $_POST['webdados_fb_open_graph_custom_box_nonce'];

	  // Verify that the nonce is valid.
	  if ( ! wp_verify_nonce( $nonce, 'webdados_fb_open_graph_custom_box' ) )
	      return $post_id;

	  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
	  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
	      return $post_id;

	  // Check the user's permissions.
	  if ( 'page' == $_POST['post_type'] ) {

	    if ( ! current_user_can( 'edit_page', $post_id ) )
	        return $post_id;
	  
	  } else {

	    if ( ! current_user_can( 'edit_post', $post_id ) )
	        return $post_id;
	  }

	  /* OK, its safe for us to save the data now. */

	  // Sanitize user input.
	  $mydata = sanitize_text_field( $_POST['webdados_fb_open_graph_specific_image'] );

	  // Update the meta field in the database.
	  update_post_meta( $post_id, '_webdados_fb_open_graph_specific_image', $mydata );
	}
	add_action('save_post', 'wonderm00n_open_graph_add_posts_options_box_save' );

	// Media insert code
	function webdados_fb_open_graph_media_admin_head() {

		?>
		<script type="text/javascript">
			function wdfbogFieldsFileMediaTrigger(guid) {
				window.parent.jQuery('#webdados_fb_open_graph_specific_image').val(guid);
				window.parent.jQuery('#TB_closeWindowButton').trigger('click');
			}
		</script>
		<style type="text/css">
		    tr.submit, .ml-submit, #save, #media-items .A1B1 p:last-child  { display: none; }
		</style>
		<?php
	}
	function webdados_fb_open_graph_media_fields_to_edit_filter($form_fields, $post) {
		// Reset form
		$form_fields = array();
		$url = wp_get_attachment_url( $post->ID );
		$form_fields['wd-fb-og_fields_file'] = array(
			'label' => '',
			'input' => 'html',
			'html' => '<a href="#" title="' . $url
			. '" class="wd-fb-og-fields-file-insert-button'
			. ' button-primary" onclick="wdfbogFieldsFileMediaTrigger(\''
			. $url . '\')">'
			. __( 'Use as Image Open Graph Tag', 'wd-fb-og') . '</a><br /><br />',
		);
		return $form_fields;
	}
    if ( (isset( $_GET['context'] ) && $_GET['context'] == 'webdados_fb_open_graph_specific_image_button')
            || (isset( $_SERVER['HTTP_REFERER'] )
            && strpos( $_SERVER['HTTP_REFERER'],
                    'context=webdados_fb_open_graph_specific_image_button' ) !== false)
    ) {
        // Add button
        add_filter( 'attachment_fields_to_edit', 'webdados_fb_open_graph_media_fields_to_edit_filter', 9999, 2 );
        // Add JS
        add_action( 'admin_head', 'webdados_fb_open_graph_media_admin_head' );
    }
}


	
function wonderm00n_open_graph_default_values() {
	return array(
		'fb_locale_show' => 1,
		'fb_sitename_show' => 1,
		'fb_title_show' => 1,
		'fb_url_show' => 1,
		'fb_url_canonical' => 1,
		'fb_type_show' => 1,
		'fb_desc_show' => 1,
		'fb_desc_chars' => 300,
		'fb_image_show' => 1,
		'fb_image_use_specific' => 1,
		'fb_image_use_featured' => 1,
		'fb_image_use_content' => 1,
		'fb_image_use_media' => 1,
		'fb_image_use_default' => 1,
		'fb_keep_data_uninstall' => 1
	);
}
function wonderm00n_open_graph_load_settings() {
	$defaults=wonderm00n_open_graph_default_values();
	//Load the user settings (if they exist)
	if ($usersettings=get_option('webdados_fb_open_graph_settings')) {
		//Merge the settings "all together now" (yes, it's a Beatles reference)
		foreach($usersettings as $key => $value) {
			//if ($value=='') {
			if (strlen(trim($value))==0) {
				if (!empty($defaults[$key])) {
					$usersettings[$key]=$defaults[$key];
				}
			}
		}
	} else {
		$usersettings=$defaults;
	}
	return $usersettings;
}

function wonderm00n_open_graph_upgrade() {
	global $wonderm00n_open_graph_plugin_version;
	$upgrade=false;
	//Upgrade from 0.5.4 - Last version with individual settings
	if (!$v=get_option('webdados_fb_open_graph_version')) {
		//Convert settings
		$upgrade=true;
		global $wonderm00n_open_graph_plugin_settings;
		foreach($wonderm00n_open_graph_plugin_settings as $key) {
			$webdados_fb_open_graph_settings[$key]=get_option('wonderm00n_open_graph_'.$key);
		}
		// New fb_image_use_specific
		$webdados_fb_open_graph_settings['fb_image_use_specific']=1;
		update_option('webdados_fb_open_graph_settings', $webdados_fb_open_graph_settings);
		foreach($wonderm00n_open_graph_plugin_settings as $key) {
			delete_option('wonderm00n_open_graph_'.$key);
		}
	} else {
		if ($v<$wonderm00n_open_graph_plugin_version) {
			//Any version upgrade
			$upgrade=true;
		}
	}
	//Set version on database
	if ($upgrade) {
		update_option('webdados_fb_open_graph_version', $wonderm00n_open_graph_plugin_version);
	}
}


//Uninstall stuff
register_uninstall_hook(__FILE__, 'wonderm00n_open_graph_uninstall'); //NOT WORKING! WHY?
function wonderm00n_open_graph_uninstall() {
	//NOT WORKING! WHY?
	//global $wonderm00n_open_graph_plugin_settings;
	//Remove data
	/*foreach($wonderm00n_open_graph_plugin_settings as $key) {
		delete_option('wonderm00n_open_graph_'.$key);
	}
	delete_option('wonderm00n_open_graph_activated');*/
}

//To avoid notices when updating options on settings-page.php
//Hey @flynsarmy you are here, see?
function wonderm00n_open_graph_post($var, $default='') {
	return isset($_POST[$var]) ? $_POST[$var] : $default;
}

?>