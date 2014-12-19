<?php
/*
Plugin Name: EFF Newsletter API
Plugin URI: http://eff.org
Description: Send out blog posts and any translations thereof as email newsletters.
Version: 0.1
Author: Matthew Gerring
Author URI: http://matthewgerring.com
License: GPLv2 or later
Text Domain: eff-newsletter
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

add_action( 'load-post.php', 'eff_newsletter_meta_boxes_setup' );
add_action( 'load-post-new.php', 'eff_newsletter_meta_boxes_setup' );

add_action('load-post.php','eff_newsletter_handler');
add_action('load-post-new.php','eff_newsletter_handler');

function eff_newsletter_action_handler() {
	add_action('wp','eff_newsletter_handler');
}

function eff_newsletter_handler(){
	if(isset($_POST['send_email']) && $_POST['send_email'] == 'go') {
		//include 'Converter.php';
		//include 'ConverterExtra.php';
		//include 'Parser.php';
		include 'Html2Text.php';
		include 'emogrify.php';
		$posts = eff_newsletter_maybe_get_translations($_POST['post_ID']);

		//Manually writing the UTF8 byte-order mark because PHP is banaynay
		$text = "\xEF\xBB\xBF";
		//Maybe we don't need this when it gets pushed to email

		$html = '';

		foreach($posts as $post) {
			 $text .= eff_newsletter_markdown($post);

			 $html .= eff_newsletter_html($post);
		}

		$timestamp = time();

		//Write Text
		$text_email = fopen(ABSPATH . "../email/". $timestamp .".txt", "w");
		fwrite($text_email, $text);
		fclose($text_email);

		//Do the HTML template
		$html_email = fopen(ABSPATH . "../email/". $timestamp .".html", "w");
		fwrite($html_email, $html);
		fclose($html_email);
	}
}

function eff_newsletter_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'eff_newsletter_add_post_meta_boxes' );
}

function eff_newsletter_add_post_meta_boxes() {
	add_meta_box( 
		'send-newsletter', 
		'Send Newsletter', 
		'eff_newsletter_send_button_metabox', 
		'post', 
		$context = 'side', 
		$priority = 'default', 
		$callback_args = null 
	);
}

function eff_newsletter_maybe_get_translations($post_id) {
	//Find out if we need to return more than one language.
	//If we don't, just return the one.

	//Returns an array of 1 or more posts.
	global $polylang;

	if($polylang) {
		$post_ids = $polylang->model->get_translations('post', $post_id);
		foreach($post_ids as $post_id) {
			$returnarr[] = get_post($post_id);
		}
		return $returnarr;
	} else {
		return array(get_post($post_id));
	}
}

function eff_newsletter_markdown($post) {
	$text = wpautop($post->post_excerpt);
	$text .= wpautop($post->post_content);
	$converter = new \Html2Text\Html2Text($text, array('do_links'=>'table'));
	//return $text;
	return $converter->getText();
}

function eff_newsletter_html($post) {
	$html = '';
	$image_id = get_post_thumbnail_id( $post->ID );
	$image_data = get_post($image_id);
	if($image_data) {
		$html = "<div class='img-with-caption'>" . wp_get_attachment_image( $image_id, 'email' );
		$html .= "<span class='caption'>" . $image_data->post_excerpt . "</span></div>";
	}
	$html .= "<p class='lead callout'>" . $post->post_excerpt . "</p>";
	$html .= apply_filters('the_content', $post->post_content);
	$css = file_get_contents(plugin_dir_path( __FILE__ ) . 'email.css');
	$emogrifier = new \Pelago\Emogrifier($html, $css);
	$content = $emogrifier->emogrify();
	return preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $content);
}

function eff_newsletter_send_button_metabox() {
?>
  <p>
  	<button class="button button-primary" name="send_email" type="submit" value="go">Send Newsletter</button>
  </p>
<?php
}

?>