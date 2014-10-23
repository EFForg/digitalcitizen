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
?>

  <p>
    <label for="smashing-post-class"><?php _e( "Copy me!", 'digitalcitizen' ); ?></label>
    <br />
    <textarea readonly="readonly" class="widefat" name="smashing-post-class" id="smashing-post-class">
<?php 
	global $post;
	global $polylang; 
	$post_ids = $polylang->model->get_translations('post', $post->ID);
	
	$html = "<p class='lead callout'>" . $post->post_excerpt . "</p>";
	$html .= apply_filters('the_content', $post->post_content);

	foreach($post_ids as $id) {
		$the_post = get_post($id);
		$html .= "<p class='lead callout'>" . apply_filters('the_excerpt', $the_post->post_excerpt) . "</p>";
		$html .= apply_filters('the_content', $the_post->post_content);
	}
	 
	$css = file_get_contents(TEMPLATEPATH . '/css/email.css');
	$emogrifier = new \Pelago\Emogrifier($html, $css);
	$content = $emogrifier->emogrify();
	echo preg_replace('~<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>\s*~i', '', $content);
?>
    </textarea>
  </p>

<?php
}

?>