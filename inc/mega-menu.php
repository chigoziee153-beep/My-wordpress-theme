<?php
/**
 * WordPress-managed mega navigation enhancements.
 * Authors can nest items up to 3 levels in Appearance > Menus. No locked links.
 * @package NYDLACustom
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Mark the Explore item as a mega panel (other top-level items can opt in with CSS class nydla-mega-menu). */
function nydla_custom_menu_classes( $classes, $item, $args, $depth ) {
	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) return $classes;
	if ( 0 === (int) $depth && 'explore' === sanitize_title( wp_strip_all_tags( $item->title ) ) && in_array( 'menu-item-has-children', $classes, true ) ) {
		$classes[] = 'nydla-mega-menu';
	}
	if ( $depth > 0 ) {
		$icon_names = array( 'events', 'podcasts-media', 'resources', 'membership-join', 'sponsors-partners', 'about', 'about-nydla', 'contact' );
		$slug = sanitize_title( wp_strip_all_tags( $item->title ) );
		if ( in_array( $slug, $icon_names, true ) ) $classes[] = 'nydla-nav-icon-' . $slug;
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'nydla_custom_menu_classes', 10, 4 );

/**
 * Separate submenu controls keep actual page links clickable and expanders
 * keyboard/touch accessible. Markup is added to WordPress menu items only.
 */
function nydla_custom_menu_submenu_button( $item_output, $item, $depth, $args ) {
	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) return $item_output;
	if ( $depth > 0 && ! empty( $item->description ) ) {
		$description = '<span class="nydla-menu-description">' . esc_html( $item->description ) . '</span>';
		$item_output = preg_replace( '~</a>~i', '</a>' . $description, $item_output, 1 );
	}
	if ( ! in_array( 'menu-item-has-children', (array) $item->classes, true ) ) return $item_output;
	$label = sprintf( /* translators: %s = menu link title */ __( 'Toggle %s submenu', 'nydla-custom' ), wp_strip_all_tags( $item->title ) );
	$button = '<button type="button" class="nydla-submenu-toggle" aria-expanded="false" aria-label="' . esc_attr( $label ) . '"><span aria-hidden="true">⌄</span></button>';
	return preg_replace( '~</a>~i', '</a>' . $button, $item_output, 1 );
}
add_filter( 'walker_nav_menu_start_el', 'nydla_custom_menu_submenu_button', 10, 4 );
