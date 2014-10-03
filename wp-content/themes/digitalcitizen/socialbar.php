<aside id="social-bar">
	<span class="share-text">Share this article:</span>
	<a href="" class="twitter-share icon-twitter">Twitter</a>
	<a href="" class="facebook-share icon-facebook">Facebook</a>
	<?php 
	printf(
		__( '<a href="%1$s" class="icon-link" rel="bookmark">Permalink</a>', 'digitalcitizen' ),
		get_permalink()
	);
	?>
	<?php edit_post_link( __( 'Edit', 'digitalcitizen' ), '<span class="edit-link">', '</span>' ); ?>

</aside>