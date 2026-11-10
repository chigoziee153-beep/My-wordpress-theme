<?php
/**
 * NYDLA Custom theme functions.
 *
 * @package NYDLACustom
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function nydla_custom_setup() {
	load_theme_textdomain( 'nydla-custom', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 260, 'flex-width' => true, 'flex-height' => true ) );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-spacing' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );
	register_nav_menus( array( 'primary' => __( 'Primary Navigation', 'nydla-custom' ), 'footer' => __( 'Footer Navigation', 'nydla-custom' ) ) );
}
add_action( 'after_setup_theme', 'nydla_custom_setup' );

/**
 * Elementor compatibility: support the editor preview and published Elementor
 * content without altering how Gutenberg pages or theme Customizer pages work.
 * No Elementor dependency is required to use the NYDLA theme.
 */
function nydla_custom_is_elementor_preview( $post_id ) {
	if ( ! did_action( 'elementor/loaded' ) || ! isset( $_GET['elementor-preview'] ) || ! is_scalar( $_GET['elementor-preview'] ) ) {
		return false;
	}
	$preview_id = absint( wp_unslash( $_GET['elementor-preview'] ) );
	return $preview_id === (int) $post_id && current_user_can( 'edit_post', $preview_id );
}

function nydla_custom_is_elementor_content( $post_id ) {
	if ( ! did_action( 'elementor/loaded' ) || ! $post_id ) {
		return false;
	}
	return 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true )
		|| nydla_custom_is_elementor_preview( $post_id );
}

/** Elementor Pro Theme Builder locations are optional; theme fallbacks remain. */
function nydla_custom_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'nydla_custom_register_elementor_locations' );

function nydla_custom_assets() {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'nydla-custom-fonts', 'https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700;800&family=Oswald:wght@400;500;600;700&display=swap', array(), null );
	wp_enqueue_style( 'nydla-custom-style', get_template_directory_uri() . '/assets/css/main.css', array( 'nydla-custom-fonts' ), $version );
	if ( ! nydla_custom_is_elementor_preview( get_queried_object_id() ) ) {
		wp_enqueue_script( 'nydla-custom-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), $version, true );
		wp_enqueue_script( 'nydla-custom-effects', get_template_directory_uri() . '/assets/js/effects.js', array(), $version, true );
	}
	$primary = sanitize_hex_color( get_theme_mod( 'nydla_brand_blue', '#416af2' ) );
	$accent  = sanitize_hex_color( get_theme_mod( 'nydla_brand_violet', '#8c66ed' ) );
	$navy    = sanitize_hex_color( get_theme_mod( 'nydla_brand_navy', '#0b1430' ) );
	$radius = min( 48, max( 0, absint( get_theme_mod( 'nydla_hero_radius', 30 ) ) ) );
	$custom  = ':root{--blue:' . ( $primary ?: '#416af2' ) . ';--violet:' . ( $accent ?: '#8c66ed' ) . ';--navy:' . ( $navy ?: '#0b1430' ) . ';--hero-radius:' . $radius . 'px;}';
	wp_add_inline_style( 'nydla-custom-style', $custom );
	if ( ! nydla_custom_is_elementor_preview( get_queried_object_id() ) ) {
		wp_add_inline_script( 'nydla-custom-effects', 'window.NYDLAMotionSettings = ' . wp_json_encode( array(
		'loader'  => (bool) get_theme_mod( 'nydla_enable_loader', true ),
		'reveals' => (bool) get_theme_mod( 'nydla_enable_reveals', true ),
		'hero'    => (bool) get_theme_mod( 'nydla_enable_hero_motion', true ),
		'spotlight' => (bool) get_theme_mod( 'nydla_enable_hero_spotlight', true ),
		'cards' => (bool) get_theme_mod( 'nydla_enable_card_interactions', true ),
		'sticky' => (bool) get_theme_mod( 'nydla_enable_sticky_header', true ),
		'intensity' => nydla_custom_sanitize_motion_intensity( get_theme_mod( 'nydla_motion_intensity', 'subtle' ) ),
		) ) . ';', 'before' );
	}
}
add_action( 'wp_enqueue_scripts', 'nydla_custom_assets' );

/** Enable the optional preloader before the first paint; never hide a no-JS website. */
function nydla_custom_early_loading() {
	if ( is_admin() || nydla_custom_is_elementor_preview( get_queried_object_id() ) || ! get_theme_mod( 'nydla_enable_loader', true ) || 'off' === get_theme_mod( 'nydla_motion_intensity', 'subtle' ) ) {
		return;
	}
	echo '<script>if(!window.matchMedia("(prefers-reduced-motion: reduce)").matches){document.documentElement.classList.add("nydla-loading-enabled");window.setTimeout(function(){document.documentElement.classList.remove("nydla-loading-enabled")},6500)}</script>' . "\n";
}
add_action( 'wp_head', 'nydla_custom_early_loading', 1 );

function nydla_custom_customize( $wp_customize ) {
	$sections = array(
		'nydla_homepage'   => array( 'title' => __( 'NYDLA — Hero & Links', 'nydla-custom' ), 'priority' => 30 ),
		'nydla_intro'      => array( 'title' => __( 'NYDLA — About Section', 'nydla-custom' ), 'priority' => 31 ),
		'nydla_features'   => array( 'title' => __( 'NYDLA — Feature Cards', 'nydla-custom' ), 'priority' => 32 ),
		'nydla_member'     => array( 'title' => __( 'NYDLA — Membership Section', 'nydla-custom' ), 'priority' => 33 ),
		'nydla_articles'   => array( 'title' => __( 'NYDLA — Latest Articles', 'nydla-custom' ), 'priority' => 34 ),
		'nydla_branding'   => array( 'title' => __( 'NYDLA — Colors & Footer', 'nydla-custom' ), 'priority' => 35 ),
		'nydla_motion'     => array( 'title' => __( 'NYDLA — Motion & Layout', 'nydla-custom' ), 'priority' => 36 ),
		'nydla_journey'    => array( 'title' => __( 'NYDLA — Brand Journey', 'nydla-custom' ), 'priority' => 37 ),
		'nydla_navigation' => array( 'title' => __( 'NYDLA — Navigation & Mega Menu', 'nydla-custom' ), 'priority' => 38 ),
	);
	foreach ( $sections as $id => $section ) {
		$wp_customize->add_section( $id, $section );
	}

	// Each field belongs to a clearly named section in Appearance > Customize.
	$fields = array(
		'nydla_hero_eyebrow' => array( 'section' => 'nydla_homepage', 'label' => 'Hero eyebrow', 'default' => 'From distance learning to digital living' ),
		'nydla_hero_title' => array( 'section' => 'nydla_homepage', 'label' => 'Hero headline', 'default' => 'Distance learning. Digital learning. Digital living.' ),
		'nydla_hero_description' => array( 'section' => 'nydla_homepage', 'label' => 'Hero description', 'default' => 'Explore the people and ideas connecting education, technology, and everyday life.', 'type' => 'textarea' ),
		'nydla_hero_button_text' => array( 'section' => 'nydla_homepage', 'label' => 'Hero primary button text', 'default' => 'Explore NYDLA' ),
		'nydla_header_button_text' => array( 'section' => 'nydla_homepage', 'label' => 'Header membership button text', 'default' => 'Join the Community' ),
		'nydla_membership_url' => array( 'section' => 'nydla_homepage', 'label' => 'Membership URL (blank uses the internal Membership / Join page)', 'default' => '', 'type' => 'url' ),
		'nydla_about_eyebrow' => array( 'section' => 'nydla_intro', 'label' => 'About section label', 'default' => 'The NYDLA community' ),
		'nydla_about_title' => array( 'section' => 'nydla_intro', 'label' => 'About section heading', 'default' => 'Connecting learning with life.' ),
		'nydla_about_text' => array( 'section' => 'nydla_intro', 'label' => 'About section description', 'default' => 'NYDLA brings together people, knowledge, and opportunities across distance learning, digital learning, and digital living.', 'type' => 'textarea' ),
		'nydla_features_eyebrow' => array( 'section' => 'nydla_features', 'label' => 'Feature section label', 'default' => 'Explore the possibilities' ),
		'nydla_features_title' => array( 'section' => 'nydla_features', 'label' => 'Feature section heading', 'default' => 'Built around what matters.' ),
		'nydla_features_description' => array( 'section' => 'nydla_features', 'label' => 'Feature section description', 'default' => 'Find fresh perspectives, meaningful connections, and opportunities to keep growing.', 'type' => 'textarea' ),
		'nydla_card_1_title' => array( 'section' => 'nydla_features', 'label' => 'Card 1 title', 'default' => 'Digital Learning' ),
		'nydla_card_1_text' => array( 'section' => 'nydla_features', 'label' => 'Card 1 text', 'default' => 'Ideas and conversations shaping learning in a connected world.', 'type' => 'textarea' ),
		'nydla_card_2_title' => array( 'section' => 'nydla_features', 'label' => 'Card 2 title', 'default' => 'Our Community' ),
		'nydla_card_2_text' => array( 'section' => 'nydla_features', 'label' => 'Card 2 text', 'default' => 'A place to meet people who believe in shared progress.', 'type' => 'textarea' ),
		'nydla_card_3_title' => array( 'section' => 'nydla_features', 'label' => 'Card 3 title', 'default' => 'Podcasts & Insights' ),
		'nydla_card_3_text' => array( 'section' => 'nydla_features', 'label' => 'Card 3 text', 'default' => 'Explore perspectives and stories from across the digital learning community.', 'type' => 'textarea' ),
		'nydla_card_4_title' => array( 'section' => 'nydla_features', 'label' => 'Card 4 title', 'default' => 'Events & Experiences' ),
		'nydla_card_4_text' => array( 'section' => 'nydla_features', 'label' => 'Card 4 text', 'default' => 'Discover opportunities for learning, conversations, and collaboration.', 'type' => 'textarea' ),
		'nydla_membership_eyebrow' => array( 'section' => 'nydla_member', 'label' => 'Membership section label', 'default' => 'Make the connection' ),
		'nydla_membership_title' => array( 'section' => 'nydla_member', 'label' => 'Membership heading', 'default' => 'The best ideas grow together.' ),
		'nydla_membership_text' => array( 'section' => 'nydla_member', 'label' => 'Membership description', 'default' => 'Become part of a community exploring the people and possibilities of digital learning.', 'type' => 'textarea' ),
		'nydla_membership_button_text' => array( 'section' => 'nydla_member', 'label' => 'Membership button text', 'default' => 'Explore membership' ),
		'nydla_articles_title' => array( 'section' => 'nydla_articles', 'label' => 'Latest articles heading', 'default' => 'Latest perspectives.' ),
		'nydla_articles_text' => array( 'section' => 'nydla_articles', 'label' => 'Latest articles description', 'default' => 'Fresh content from the NYDLA community.', 'type' => 'textarea' ),
		'nydla_brand_blue' => array( 'section' => 'nydla_branding', 'label' => 'Primary accent color', 'default' => '#416af2', 'type' => 'color' ),
		'nydla_brand_violet' => array( 'section' => 'nydla_branding', 'label' => 'Secondary accent color', 'default' => '#8c66ed', 'type' => 'color' ),
		'nydla_brand_navy' => array( 'section' => 'nydla_branding', 'label' => 'Dark base color', 'default' => '#0b1430', 'type' => 'color' ),
		'nydla_footer_text' => array( 'section' => 'nydla_branding', 'label' => 'Footer description', 'default' => 'Connecting people, knowledge, and technology across the world of digital learning.', 'type' => 'textarea' ),
		'nydla_enable_loader' => array( 'section' => 'nydla_motion', 'label' => 'Enable NYDLA page loading screen', 'default' => true, 'type' => 'checkbox' ),
		'nydla_enable_reveals' => array( 'section' => 'nydla_motion', 'label' => 'Enable fade-in section reveals', 'default' => true, 'type' => 'checkbox' ),
		'nydla_enable_hero_motion' => array( 'section' => 'nydla_motion', 'label' => 'Enable homepage artwork motion', 'default' => true, 'type' => 'checkbox' ),
		'nydla_hero_radius' => array( 'section' => 'nydla_motion', 'label' => 'Homepage hero corner radius (0–48 px)', 'default' => 30, 'type' => 'number' ),
		'nydla_enable_hero_spotlight' => array( 'section' => 'nydla_motion', 'label' => 'Mouse-following hero spotlight (desktop)', 'default' => true, 'type' => 'checkbox' ),
		'nydla_enable_card_interactions' => array( 'section' => 'nydla_motion', 'label' => 'Enable interactive card highlights', 'default' => true, 'type' => 'checkbox' ),
		'nydla_motion_intensity' => array( 'section' => 'nydla_motion', 'label' => 'Motion intensity', 'default' => 'subtle', 'type' => 'select', 'choices' => array( 'off' => 'Off', 'subtle' => 'Subtle (recommended)', 'standard' => 'Standard' ) ),
		'nydla_enable_mega_menu' => array( 'section' => 'nydla_navigation', 'label' => 'Enable multi-column mega dropdowns', 'default' => true, 'type' => 'checkbox' ),
		'nydla_enable_sticky_header' => array( 'section' => 'nydla_navigation', 'label' => 'Enable compact sticky header on scroll', 'default' => true, 'type' => 'checkbox' ),
		'nydla_enable_brand_journey' => array( 'section' => 'nydla_journey', 'label' => 'Show NYDLA brand journey on homepage', 'default' => true, 'type' => 'checkbox' ),
		'nydla_journey_eyebrow' => array( 'section' => 'nydla_journey', 'label' => 'Journey eyebrow', 'default' => 'Our evolving focus' ),
		'nydla_journey_title' => array( 'section' => 'nydla_journey', 'label' => 'Journey heading', 'default' => 'From learning at a distance to living digitally.' ),
		'nydla_journey_description' => array( 'section' => 'nydla_journey', 'label' => 'Journey description', 'default' => 'Three connected ideas that guide how we explore learning, technology, and community.', 'type' => 'textarea' ),
		'nydla_journey_1_title' => array( 'section' => 'nydla_journey', 'label' => 'Stage 1 title', 'default' => 'Distance Learning' ),
		'nydla_journey_1_text' => array( 'section' => 'nydla_journey', 'label' => 'Stage 1 description', 'default' => 'Learning beyond the boundaries of a physical classroom.', 'type' => 'textarea' ),
		'nydla_journey_2_title' => array( 'section' => 'nydla_journey', 'label' => 'Stage 2 title', 'default' => 'Digital Learning' ),
		'nydla_journey_2_text' => array( 'section' => 'nydla_journey', 'label' => 'Knowledge, tools, and connections in a digital world.', 'type' => 'textarea' ),
		'nydla_journey_3_title' => array( 'section' => 'nydla_journey', 'label' => 'Stage 3 title', 'default' => 'Digital Living' ),
		'nydla_journey_3_text' => array( 'section' => 'nydla_journey', 'label' => 'Exploring how technology shapes everyday life and possibility.', 'type' => 'textarea' ),
	);

	foreach ( $fields as $key => $field ) {
		$type = isset( $field['type'] ) ? $field['type'] : 'text';
		$sanitize = 'sanitize_text_field';
		if ( 'textarea' === $type ) {
			$sanitize = 'sanitize_textarea_field';
		} elseif ( 'url' === $type ) {
			$sanitize = 'esc_url_raw';
		} elseif ( 'color' === $type ) {
			$sanitize = 'sanitize_hex_color';
		} elseif ( 'checkbox' === $type ) {
			$sanitize = 'nydla_custom_sanitize_checkbox';
		} elseif ( 'select' === $type ) {
			$sanitize = 'nydla_custom_sanitize_motion_intensity';
		} elseif ( 'number' === $type ) {
			$sanitize = 'absint';
		}
		$wp_customize->add_setting( $key, array(
			'default'           => $field['default'],
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		) );
		$control_args = array(
			'label'   => $field['label'],
			'section' => $field['section'],
			'type'    => $type,
			'choices' => isset( $field['choices'] ) ? $field['choices'] : array(),
		);
		if ( 'color' === $type ) {
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, $control_args ) );
		} else {
			$wp_customize->add_control( $key, $control_args );
		}
	}
}
add_action( 'customize_register', 'nydla_custom_customize' );

function nydla_custom_sanitize_checkbox( $value ) {
	return (bool) $value;
}
function nydla_custom_sanitize_motion_intensity( $value ) {
	return in_array( $value, array( 'off', 'subtle', 'standard' ), true ) ? $value : 'subtle';
}
function nydla_custom_body_classes( $classes ) {
	if ( 'off' === get_theme_mod( 'nydla_motion_intensity', 'subtle' ) ) $classes[] = 'nydla-motion-off';
	if ( 'standard' === get_theme_mod( 'nydla_motion_intensity', 'subtle' ) ) $classes[] = 'nydla-motion-standard';
	if ( get_theme_mod( 'nydla_enable_sticky_header', true ) ) $classes[] = 'nydla-sticky-enabled';
	if ( get_theme_mod( 'nydla_enable_mega_menu', true ) ) $classes[] = 'nydla-mega-enabled';
	if ( ! get_theme_mod( 'nydla_enable_card_interactions', true ) ) $classes[] = 'nydla-cards-static';
	return $classes;
}
add_filter( 'body_class', 'nydla_custom_body_classes' );

require_once get_template_directory() . '/inc/home-blocks.php';
require_once get_template_directory() . '/inc/mega-menu.php';

/**
 * Useful, accessible fallback while a WordPress menu has not been assigned.
 */
function nydla_custom_fallback_menu() {
	echo '<ul class="primary-menu">';
	echo '<li><a href="' . esc_url( home_url( '/#about' ) ) . '">' . esc_html__( 'About', 'nydla-custom' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#explore' ) ) . '">' . esc_html__( 'Explore', 'nydla-custom' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/#insights' ) ) . '">' . esc_html__( 'Insights', 'nydla-custom' ) . '</a></li>';
	echo '</ul>';
}
