<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Digital Citizen
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
        <div id="logo-salad">
            <a class="s-7iber" href="http://7iber.com">7iber</a>
            <a class="eff" href="http://EFF.org">EFF</a>
            <a class="access" href="http://accessnow.org">Access Now</a>
            <a class="gv" href="http://advocacy.globalvoicesonline.org">Global Voices Advocacy</a>
            <a class="smex" href="http://smex.org">Social Media Exchange</a>
        </div>
		<div class="site-info">
			<p>Some rights reserved <a href=""><span class="icon icon-cc">CC</span> <span class="icon icon-by">BY</span></a></p>

			<p>Follow us:
				<a href="https://www.facebook.com/muwatenraqamy" class="icon icon-facebook">Facebook</a>
				<a href="https://twitter.com/MuwatenRaqamy" class="icon icon-twitter">Twitter</a>
				<a href="https://github.com/EFForg/digitalcitizen" class="icon icon-github">Github</a>
			</p>

			<p>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'digitalcitizen' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'digitalcitizen' ), 'WordPress' ); ?></a>
			</p>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
