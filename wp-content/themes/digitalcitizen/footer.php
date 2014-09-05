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
            <a class="s-7iber-medium" href="http://7iber.com">7iber</a>
            <a class="eff-medium" href="http://EFF.org">EFF</a>
            <a class="access-medium" href="http://accessnow.org">Access Now</a>
            <a class="gv-medium" href="http://advocacy.globalvoicesonline.org">Global Voices Advocacy</a>
            <a class="smex-medium" href="http://smex.org">Social Media Exchange</a>
        </div>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'digitalcitizen' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'digitalcitizen' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'digitalcitizen' ), 'Digital Citizen', '<a href="http://matthewgerring.com" rel="designer">Matthew Gerring</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
