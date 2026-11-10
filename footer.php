<?php /** Site footer. @package NYDLACustom */ ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) : ?>
<footer class="site-footer">
	<div class="container footer-grid">
		<div class="footer-about">
			<a class="brand-text footer-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">NYDLA<span class="brand-dot">.</span></a>
			<p><?php echo esc_html( get_theme_mod( 'nydla_footer_text', 'Connecting people, knowledge, and technology across the world of digital learning.' ) ); ?></p>
		</div>
		<div>
			<h2><?php esc_html_e( 'Explore', 'nydla-custom' ); ?></h2>
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'footer-links', 'depth' => 1 ) ); ?>
			<?php else : ?>
				<ul class="footer-links">
					<li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About NYDLA', 'nydla-custom' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#explore' ) ); ?>"><?php esc_html_e( 'Our Focus', 'nydla-custom' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#insights' ) ); ?>"><?php esc_html_e( 'Insights', 'nydla-custom' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</div>
		<div>
			<h2><?php esc_html_e( 'Get involved', 'nydla-custom' ); ?></h2>
			<a class="footer-join" href="<?php echo esc_url( nydla_custom_membership_url() ); ?>"><?php esc_html_e( 'Discover membership', 'nydla-custom' ); ?> ↗</a>
			<p class="footer-note"><?php esc_html_e( 'New opportunities start with connection.', 'nydla-custom' ); ?></p>
		</div>
	</div>
	<div class="container footer-bottom"><span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>.</span><span><?php esc_html_e( 'Built for what comes next.', 'nydla-custom' ); ?></span></div>
</footer>
<?php endif; // End of optional Elementor Pro footer location. ?>
<?php wp_footer(); ?>
</body>
</html>
