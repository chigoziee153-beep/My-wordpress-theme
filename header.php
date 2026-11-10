<?php /** Site header. @package NYDLACustom */ ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="nydla-page-loader" id="nydla-page-loader" aria-hidden="true">
	<div class="nydla-loader-brand">
		<span class="nydla-loader-mark">N</span>
		<span class="nydla-loader-name">NYDLA<span class="nydla-loader-dot">.</span></span>
	</div>
</div>
<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to content', 'nydla-custom' ); ?></a>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) : ?>
<header class="site-header" id="site-header">
	<div class="container header-inner">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="brand-text" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					<span class="brand-mark" aria-hidden="true">N</span><span>NYDLA<span class="brand-dot">.</span></span>
				</a>
			<?php endif; ?>
		</div>
		<button class="menu-toggle" type="button" aria-controls="primary-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'nydla-custom' ); ?>">
			<span></span><span></span><span></span>
		</button>
		<nav class="primary-navigation" id="primary-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'nydla-custom' ); ?>">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'primary-menu', 'fallback_cb' => 'nydla_custom_fallback_menu', 'depth' => 3 ) ); ?>
			<a class="button button-small button-dark nav-cta" href="<?php echo esc_url( nydla_custom_membership_url() ); ?>"><?php echo esc_html( get_theme_mod( 'nydla_header_button_text', 'Join the Community' ) ); ?> <span aria-hidden="true">↗</span></a>
		</nav>
	</div>
</header>
<?php endif; // End of optional Elementor Pro header location. ?>
