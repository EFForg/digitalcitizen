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

// Loads this plugin only on the post editor page.
add_action( 'load-post.php', 'eff_newsletter_meta_boxes_setup' );
add_action( 'load-post-new.php', 'eff_newsletter_meta_boxes_setup' );

add_action('load-post.php','eff_newsletter_handler');
add_action('load-post-new.php','eff_newsletter_handler');

// Actually handles sending the newsletter
function eff_newsletter_handler(){
	if(isset($_POST['send_email']) && $_POST['send_email'] == 'go') {
		// We include classes here so we only load them if
		// we need to send the newsletter
		include 'Html2Text.php';
		include 'emogrify.php';

		// Get the posts
		$posts = eff_newsletter_maybe_get_translations($_POST['post_ID']);

		// Manually writing the UTF8 byte-order mark because PHP is banaynay
		$text = "\xEF\xBB\xBF";
		// Maybe we don't need this when it gets pushed to email

		$html = eff_newsletter_html_image($posts[0]);
		// Loop through the posts
		foreach($posts as $post) {
			 $text .= eff_newsletter_text($post);
			 $text .= "\n\n";
			 $html .= eff_newsletter_html_content($post);
		}
		$html = eff_newsletter_inline_css($html);

		ob_start();
		include 'templates/email_template.php';
		$html = ob_get_clean();

		$url = 'https://supporters.eff.org/sites/all/modules/civicrm/extern/rest.php';
		$params = array(
		  'action' => 'create',
		  'api_key' => EFF_CIVI_APIKEY,
		  'body_html' => $html,
		  'body_text' => $text,
		  'created_id' => 1766707,
		  'contact_id' => 1766707,
		  'debug' => 1,
		  'dedupe_email' => 1,
		  'entity' => 'Mailing',
		  'footer_id' => 38,
		  'from_email' => 'info@digcit.org',
		  'from_name' => 'Digital Citizen',
		  'groups[include][]' => EFF_CIVI_GROUP,
		  'json' => 1,
		  'key' => EFF_CIVI_SITEKEY,
		  'name' => "Digital Citizen: {$post->post_title}",
		  'scheduled_id' => 1766707,
		  'subject' => "Digital Citizen: {$post->post_title}",
		  'url_tracking' => 0,
		  'version' => 3,
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);
		curl_close($ch);
		//For testing purposes
		/*
		$time = time();
		$myfile = fopen(ABSPATH.'/email'.$time.'.html', 'w');
		fwrite($myfile, $html);
		fclose($myfile);
		*/

		eff_newsletter_set_newsletter_sent($posts);
	}
}

function eff_newsletter_set_newsletter_sent($posts) {
	foreach($posts as $post) {
		add_post_meta($post->ID, "_eff_newsletter_sent_date", time(), true);
	}
}

// Get the post and all translations
function eff_newsletter_maybe_get_translations($post_id) {
	//Find out if we need to return more than one language.
	//If we don't, just return the one.

	//Returns an array of 1 or more posts.
	global $polylang;

	if($polylang) {
		$returnarr = [];
		$post_ids = $polylang->model->get_translations('post', $post_id);
		//This should be set by a plugin option
		$lang_order = ['en','ar'];
		if($post_ids) {
			foreach($lang_order as $i=>$lang) {
				$post = get_post($post_ids[$lang]);
				$post_lang = $polylang->model->get_post_language($post_ids[$lang]);
				$post->dir = $post_lang->is_rtl ? 'rtl' : 'ltr';
				$returnarr[] = $post;
			}
			return $returnarr;
		} else {
			return array(get_post($post_id));
		}
	} else {
		return array(get_post($post_id));
	}
}

// Minimally formats the post content as HTML, then converts
// it to plain text
function eff_newsletter_text($post) {
	$text = wpautop($post->post_excerpt);
	$text .= wpautop($post->post_content);
	$converter = new \Html2Text\Html2Text($text, array('do_links'=>'table'));
	//return $text;
	return $converter->getText();
}

function eff_newsletter_html_image($post) {
	$html = '';
	$image_id = get_post_thumbnail_id( $post->ID );
	$image_data = get_post($image_id);
	if($image_data) {
		$html = "<div class='img-with-caption'>" . wp_get_attachment_image( $image_id, 'email' );
		$html .= "<span class='caption'>" . $image_data->post_excerpt . "</span></div>";
	}
	return $html;
}

// Formats the newsletter content as HTML, grabs the email template
// stylesheet, and inlines all styles so the email looks right
function eff_newsletter_html_content($post) {
	$html = '<div dir="'.$post->dir.'">';
	$html .= "<p class='lead callout'>" . $post->post_excerpt . "</p>";
	$html .= apply_filters('the_content', $post->post_content);
	$html .= '</div>';
	return $html;
}

function eff_newsletter_inline_css($html) {
	$css = file_get_contents(plugin_dir_path( __FILE__ ) . 'email.css');
	$emogrifier = new \Pelago\Emogrifier($html, $css);
	$content = $emogrifier->emogrify();
	return preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $content);
}

// Add the action which adds the metabox containing the "Send Newsletter" button
function eff_newsletter_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'eff_newsletter_add_post_meta_boxes' );
}

// Registers the meta box
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

// Actually handle the output of the metabox with the button in it
function eff_newsletter_send_button_metabox() {
	global $post;
	$newsletter_sent = get_post_meta($post->ID,"_eff_newsletter_sent_date",true);
?>
  <p>
  	<button <?php //if ($newsletter_sent) echo "disabled"; ?> class="button button-primary" name="send_email" type="submit" value="go">Send Newsletter</button>
  	<?php if ($newsletter_sent): ?>
  	<p class="howto">You sent this newsletter as an email on <?php echo date('F j, Y, g:i:s a', $newsletter_sent); ?></p>
  	<?php endif; ?>
  </p>
<?php
}
