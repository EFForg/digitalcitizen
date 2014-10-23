<?php
add_action( 'load-post.php', 'digitalcitizen_meta_boxes_setup' );
add_action( 'load-post-new.php', 'digitalcitizen_meta_boxes_setup' );

function digitalcitizen_meta_boxes_setup() {
	add_action( 'add_meta_boxes', 'digitalcitizen_add_post_meta_boxes' );
}

function digitalcitizen_add_post_meta_boxes() {
	add_meta_box( 
		'newsletter-html', 
		'Newsletter HTML', 
		'digitalcitizen_newsletter_html_metabox', 
		'post', 
		$context = 'advanced', 
		$priority = 'default', 
		$callback_args = null 
	);
}

function digitalcitizen_newsletter_html_metabox() {
	include 'emogrify.php';
	include 'Converter.php';
	include 'ConverterExtra.php';
	include 'Parser.php';

	global $post;
	global $polylang;
	$converter = new Markdownify\Converter;
	$post_ids = $polylang->model->get_translations('post', $post->ID);
	
	$image_id = get_post_thumbnail_id( $post->ID );
	$image_data = get_post($image_id);

	$html = "<div class='img-with-caption'>" . wp_get_attachment_image( $image_id, 'email' );
	$html .= "<span class='caption'>" . $image_data->post_excerpt . "</span></div>";
	$html .= "<p class='lead callout'>" . $post->post_excerpt . "</p>";
	$html .= apply_filters('the_content', $post->post_content);

	$text = wpautop($post->post_excerpt);
	$text .= wpautop($post->post_content);

	$markdown_output = $converter->parseString($text);

	foreach($post_ids as $id) {
		$the_post = get_post($id);
		$html .= "<p class='lead callout'>" . $the_post->post_excerpt . "</p>";
		$html .= apply_filters('the_content', $the_post->post_content);

		$text = wpautop($the_post->post_excerpt);
		$text .= wpautop($the_post->post_content);

		$markdown_output .= $converter->parseString($text);
	}
	 
	$css = file_get_contents(TEMPLATEPATH . '/css/email.css');
	$emogrifier = new \Pelago\Emogrifier($html, $css);
	$content = $emogrifier->emogrify();
	$html_output = preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $content);
?>

  <p>
  	<label for="newsletter_html"><?php _e( "Copy and paste this into the HTML template", 'digitalcitizen' ); ?></label>
    <textarea id="newsletter_html" name="newsletter_html" readonly="readonly" class="widefat"><?php echo $html_output; ?></textarea>

    <label for="newsletter_text"><?php _e( "Copy and paste this into the 'text only' box", 'digitalcitizen' ); ?></label>
    <textarea id="newsletter_text" name="newsletter_text" readonly="readonly" class="widefat"><?php echo $markdown_output; ?></textarea>
  </p>

<?php
}

?>