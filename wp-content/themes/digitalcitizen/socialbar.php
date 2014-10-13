<aside id="social-bar">
	<div id="share-links">
		<span class="share-text">Share this article:</span>
		<a href="" class="share twitter-share icon-twitter">Twitter</a>
		<a href="" class="share facebook-share icon-facebook">Facebook</a>
	</div>

	<?php 
	printf(
		__( '<a href="%1$s" class="icon-link permalink" rel="bookmark">Permalink</a>', 'digitalcitizen' ),
		get_permalink()
	);
	?>
	<?php edit_post_link( __( 'Edit', 'digitalcitizen' ) ); ?>

</aside>